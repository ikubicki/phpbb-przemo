<?php

define('IN_PHPBB', true);
define('SHOUTBOX', true);
$phpbb_root_path = '../../';
$shoutbox_config = [];
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include(__DIR__ . '/Shouts.class.php');

$shouts = new phpBB\Modules\Shouts\Shouts($encryption_key);
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

$message = null; // pass through variable
$token = $_POST['token'];
$action = $_POST['action'];
if ($token) {
    list($tokenUserId, $tokenAction) = $shouts->setToken($token);
    $userId = $userdata['user_id'];
    if (!$shouts->validateToken($userId > 0 ? $userId : 0, $action)) {
        $shouts->error('Invalid authentication token');
    }
}
$shouts->setAction($action);

// -- PERMISSIONS CHECKING

$is_user = $userdata['user_id'] != ANONYMOUS;
$is_admin = $userdata['user_level'] == ADMIN;
$is_jr_admin = ($userdata['user_jr']) ? true : false;
$is_mod = ($userdata['user_level'] == MOD) ? true : false;
$can_sb_edit = ($is_jr_admin || $is_mod) && $shoutbox_config['allow_edit_m'];
$can_sb_delete = ($is_jr_admin || $is_mod) && $shoutbox_config['allow_delete_m'];
$is_allowed_group = false;

if ($is_user) {
    $shouts->setUserId($userdata['user_id']);
    if ($shoutbox_config['sb_group_sel'] != 'all') {
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
        'view' => $shoutbox_config['allow_users_view'],
        'post' => $shoutbox_config['allow_users'] || $is_allowed_group || $is_admin || $is_mod || $is_jr_admin,
        'edit' => [
            'own' => $shoutbox_config['allow_edit_all'],
            'admin' => $shoutbox_config['allow_edit'] && ($can_sb_edit || $is_admin),
        ],
        'delete' => [
            'own' => $shoutbox_config['allow_delete_all'],
            'admin' => $shoutbox_config['allow_delete'] && ($can_sb_delete || $is_admin),
        ]
    ];
}
else {
    $shouts->setUserId(0);
    $acl = [
        'type' => 'guest',
        'view' => $shoutbox_config['allow_guest_view'],
        'post' => $shoutbox_config['allow_guest'],
        'edit' => [
            'own' => false,
            'admin' => false,
        ],
        'delete' => [
            'own' => false,
            'admin' => false,
        ]
    ];
}

if (!$acl['view']) {
    $shouts->error('You\'re not allowed to use shoutbox!');
}

function save($id, $text)
{

}

switch($action) {
    case 'message':
        $message = $_POST['message'];
        break;
    case 'edit':
    case 'delete':
    case 'add':
        $id = intval($_POST['message']['id']);
        $text = htmlentities($_POST['message']['text']);
        $message = $_POST['message'];
        $shouts->setAction('refresh');
        // var_dump($id, $text);

}

// -- HANDLING NEW MESSAGES

$latestId = intval($_POST['latestId']);

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
    $date = date('Y-m-d', $row['timestamp']);
    $time = date('H:i:s', $row['timestamp']);
    $row_message = [
        'id' => $row['id'],
        'author' => [
            'id' => $row['sb_user_id'],
            'name' => $row['username'],
            'url' => '',
        ],
        'text' => $row['msg'],
        'time' => $date == date('Y-m-d') ? $time : "$date $time",
    ];
    $row_messages[] = $row_message;
}

krsort($row_messages);

foreach($row_messages as $row_message) {
    $shouts->addMessage($row_message);
}

// -- HANDLING ONLINE USERS

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

$data = [];
$data['latestId'] = $latestId;

if ($message) {
    $data['message'] = $message;
}

echo $shouts->send($data);