<?php

use PhpBB\Core\Context;
use PhpBB\Forum\Config;
use PhpBB\Model\UsersCollection;
use PhpBB\Modules\Shouts\model\ShoutsCollection;

$rootdir = __DIR__ . '/../..';
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$config = (new Config)->module('shouts');
$shouts = new PhpBB\Modules\Shouts\Shouts($encryption_key);

if (!$config->enabled) {
    $shouts->error('Module is disabled.');
}

if ($config->autopurge > 0) {
// @todo autopurge
}

/*
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
*/

$session = Context::getService('session');
$message = null; // pass through variable
$token = $_POST['token'];
$action = $_POST['action'];
if ($token) {
    list($tokenUserId, $tokenAction) = $shouts->setToken($token);
    $userId = $session->getUserId();
    if (!$shouts->validateToken($userId > 0 ? $userId : 0, $action)) {
        $shouts->error('Invalid authentication token');
    }
}
$shouts->setAction($action);

// -- PERMISSIONS CHECKING

$userdata = (array) $session->getUser();
$permissions = $session->getPermissions($config->rbac);
// var_dump($permissions);

$is_user = $session->isAuthenticated();
$is_admin = $session->isAdministrator();
$is_jr_admin = $session->isJunior();
$is_mod = $session->isModerator();
$can_sb_edit = $permissions->edit;
$can_sb_delete = $permissions->delete;
$is_allowed_group = false;

if ($is_user) {
    $shouts->setUserId($userdata['user_id']);
    if ($shoutbox_config['sb_group_sel'] ?? 'all' != 'all') {
        $sql = 'SELECT ug.group_id ' .
            'FROM (' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g) ' .
            'WHERE ug.user_id = ' . intval($userdata['user_id']) . ' ' .
            'AND g.group_id = ug.group_id ' .
            'AND g.group_single_user = 0 ' .
            'AND ug.user_pending <> 1';
        $result = $db->sql_query($sql);
        if ($result) {
            $groups = [];
            while ($row2 = $db->sql_fetchrow($result)) {
                $groups[] = $row2['group_id'];
            }
            $config_groups = explode(',', $shoutbox_config['sb_group_sel']);
            if (count($groups)) {
                foreach($groups as $group_id) {
                    if (in_array($group_id, $config_groups)) {
                        $is_allowed_group = true;
                        break;
                    }
                }
            }
        }
    }
    else {
        $is_allowed_group = true;
    }

    $acl = [
        'type' => 'user',
        'view' => $permissions->list,
        'add' => $permissions->create,
        'edit' => [
            'own' => $permissions->edit,
            'admin' => $permissions->mod,
        ],
        'delete' => [
            'own' => $permissions->delete,
            'admin' => $permissions->admin,
        ]
    ];
}
else {
    $shouts->setUserId(0);
    $acl = [
        'type' => 'guest',
        'view' => $permissions->list,
        'add' => $permissions->create,
        'edit' => [
            'own' => $permissions->edit,
            'admin' => $permissions->mod,
        ],
        'delete' => [
            'own' => $permissions->delete,
            'admin' => $permissions->admin,
        ]
    ];
}

if (!$acl['view']) {
    $shouts->error('You\'re not allowed to use shoutbox!');
}

function check_policy($action, $message)
{
    global $acl, $userdata;
    $scope = $message['author']['id'] == $userdata['user_id'] ? 'own' : 'admin';
    switch($action) {
        case 'add':
            return $acl['add'];
        case 'edit':
            return $acl['type'] == 'user' && $acl['edit'][$scope];
        case 'delete':
            return $acl['type'] == 'user' && $acl['delete'][$scope];
    }
    return false;
}

function save($action, $message, $text)
{
    switch($action) {
        case 'add': return save_add($text);
        case 'edit': return save_edit($message, $text);
        default: return false;
    }
}

function save_add($text)
{
    global $db, $acl, $userdata, $shouts;
    if (empty($acl['add'])) {
        return false;
    }
    $userId = intval($userdata['user_id']);
    $sql = 'INSERT INTO ' . SHOUTBOX_TABLE . ' ' . 
        '(sb_user_id, msg, timestamp) VALUES ' .
        '(' . $userId . ', \'' . $db->sql_escape($text) . '\', ' . time() . ')';
    $resultset = $db->sql_query($sql);
    if ($db->sql_affectedrows() > 0) {
        $lastInsertId = $db->sql_nextid();
        return message($lastInsertId);
    }
    return false;
}

function save_edit($message, $text)
{
    if (empty($message['acl']['edit'])) {
        return false;
    }
    global $db;
    $sql = 'UPDATE ' . SHOUTBOX_TABLE . ' ' . 
        'SET msg = \'' . $db->sql_escape($text) . '\'' . 
        'WHERE id = ' . intval($message['id']) . ' ';
    $statement = $db->sql_query($sql);
    if($db->sql_affectedrows() > 0) {
        return message($message['id']);
    }
    return false;
}

function delete($message)
{
    if (empty($message['acl']['delete'])) {
        return false;
    }
    global $db;
    $sql = 'DELETE FROM ' . SHOUTBOX_TABLE . ' ' . 
        'WHERE id = ' . intval($message['id']) . ' ' .
        'LIMIT 1';
    $resultset = $db->sql_query($sql);
    return $db->sql_affectedrows() > 0;
}

function message($id)
{
    if ($id > 0) {
        global $db;
        $sql = 'SELECT s.timestamp, s.sb_user_id, s.id, s.msg, u.username, u.user_level, u.user_id, u.user_jr ' .
            'FROM ' . SHOUTBOX_TABLE . ' s, ' . USERS_TABLE . ' u ' .
            'WHERE u.user_id = s.sb_user_id ' . 
            'AND s.id = ' . intval($id) . ' ' .
            'LIMIT 1';
        $resultset = $db->sql_query($sql);
        if($resultset) {
            $row = $db->sql_fetchrow($resultset);
            $db->sql_freeresult($resultset);
            return build($row);
        }
        return false;
    }
}

function build($data)
{
    global $userdata;
    $date = date('Y-m-d', $data['timestamp']);
    $time = date('H:i:s', $data['timestamp']);
    $message = [
        'id' => $data['id'],
        'author' => [
            'id' => $data['sb_user_id'],
            'name' => $data['username'],
            'url' => '',
        ],
        'text' => $data['msg'],
        'time' => $date == date('Y-m-d') ? $time : "$date $time",
    ];
    $message['acl'] = [
        'edit' => check_policy('edit', $message),
        'delete' => check_policy('delete', $message),
    ];
    if ($data['sb_user_id'] == $userdata['user_id'] && time() - $data['timestamp'] < 60) {
        $message['acl']['edit'] = true;
        $message['acl']['delete'] = true;
    }
    return $message;
}

$message = (array) ($_POST['message'] ?? []);

switch($action) {
    case 'message':
        if (!empty($message['id'])) {
            $message = message($message['id']);
        }
        break;
    case 'edit':
    case 'add':
        $text = $message['text'];
        $text = $text;
        if ($text) {
            if (!empty($message['id'])) {
                $message = message($message['id']);
            }
            else {
                $message = false;
            }
            if (!$message || $message['text'] != $text) {
                $message = save($action, $message, $text);
            }
        }
        $shouts->setAction('refresh');
        if(empty($message)) {
            $shouts->error('Unable to save the message');
        }
        break;
    case 'delete':
        if ($message['id']) {
            $message = message($message['id']);
            $result = delete($message);
        }
        $shouts->setAction('refresh');
        if(empty($result)) {
            $shouts->error('Unable to delete the message');
        }
        break;
}

// -- HANDLING NEW MESSAGES

$latestId = intval($_POST['latestId']);

$messages = (new ShoutsCollection)
    ->leftjoin(new UsersCollection, 'user_id', 'sb_user_id', [], 'poster')
    ->find("phpbb_shoutbox.id > $latestId", ['id' => 'DESC'], 10);
/*
var_dump($m);
// $criteria = [], array $order = [], $limit = null, $offset = 0
$sql = 'SELECT s.timestamp, s.sb_user_id, s.id, s.msg, u.username, u.user_level, u.user_id, u.user_jr ' .
    'FROM ' . SHOUTBOX_TABLE . ' s, ' . USERS_TABLE . ' u ' .
    'WHERE u.user_id = s.sb_user_id ' . 
    "AND s.id > $latestId " .
    'ORDER BY s.id DESC ' . 
    'LIMIT ' . $shoutbox_config['count_msg'];
$resultset = $db->sql_query($sql);
if(!$resultset) {
    $shouts->error('Can\'t retrieve data');
}
$row_messages = [];
while ($row = $db->sql_fetchrow($resultset)) {
    $row_messages[] = build($row);
}

krsort($row_messages);
*/
foreach($messages as $record) {
    $shouts->addMessage($record->row($permissions));
}

// -- HANDLING ONLINE USERS
/*
$sql = 'SELECT u.user_id, u.user_session_time ' .
    'FROM ' . SHOUTBOX_TABLE . ' s, ' . USERS_TABLE . ' u ' .
    'WHERE u.user_id = s.sb_user_id ' . 
    'ORDER BY s.id DESC ' . 
    'LIMIT ' . $shoutbox_config['count_msg'];
$resultset = $db->sql_query($sql);
if($resultset) {
    while ($row = $db->sql_fetchrow($resultset)) {
        if (time() - $row['user_session_time'] < 300) {
            $shouts->addOnline(intval($row['user_id']));
        }
    }
}
*/
$data = [];
$data['latestId'] = $latestId;

if ($message) {
    $data['message'] = $message;
}

echo $shouts->send($data);