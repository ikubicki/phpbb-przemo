<?php

define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
$subdirectory = '../';
$gen_simple_header = true;
include($phpbb_root_path . 'includes/functions_add.'.$phpEx); 

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

include($phpbb_root_path . 'scripts/lang_' . $board_config['default_lang'] . '/lang_update.' . $phpEx);

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

if ($userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_ERROR, $lang['no_admin']);
}

$convert_posts_once = 2000;

$time_start = time();
$last_loop = 0;
$max_execution_time = 30;

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL ^ E_NOTICE);

include($phpbb_root_path . 'config.'.$phpEx);

// to make sure we will not try to convert new utf8 schema after a switch.
if (substr($dbname, -5) == '_utf8') {
    $dbname = substr($dbname, 0, strlen($dbname) - 5);
}

$db1 = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false, 'utf8');
$db2 = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname . '_utf8', false, 'utf8');

$error1 = $db1->sql_error(1);
$error2 = $db2->sql_error(1);

if ($error1[0] > 0) {
    message_die(GENERAL_ERROR, "Unable to connect to source schema [$dbname]");
}

if ($error2[0] > 0) {
    message_die(GENERAL_ERROR, "Unable to connect to destination schema [{$dbname}_utf8]");
}

$db2->sql_query("ALTER DATABASE {$dbname}_utf8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;");
$error = $db2->sql_error();

if ($error[0] > 0) {
    message_die(GENERAL_ERROR, "Unable to alter destination schema [{$dbname}_utf8]");
}


$res_tables = $db1->sql_query("SHOW TABLES FROM $dbname");
$stats = [];
$errors = [];
$numeric_fields = [
    'prune_next',
    'post_edit_time',
    'img_size_poll',
    'img_size_privmsg',
    'user_style',
    'user_avatar_width',
    'user_avatar_height',
    'special_rank',
];
$defaults = [
    'post_marked' => 'n',
];
foreach($db1->sql_fetchrowset($res_tables) as $table) {
    $table = reset($table);
    $res_create = $db1->sql_query("SHOW CREATE TABLE $table");
    $create = $db1->sql_fetchrow($res_create);
    $create = array_values($create)[1];
    $create = preg_replace('#ENGINE=[a-zA-Z0-9_-]+#', '', $create);
    $create = preg_replace('#DEFAULT\s+CHARSET=[a-zA-Z0-9_-]+#', '', $create);
    $create = preg_replace('#CHARACTER\s+SET\s+[a-zA-Z0-9_-]+\s+COLLATE\s+[a-zA-Z0-9_-]+#', '', $create);
    $db1->sql_freeresult($res_create);
    $db2->sql_query($create);
    $limit = 100;
    $offset = 0;
    $records = 0;

    while(true) {
        $res_rows = $db1->sql_query("SELECT * FROM `$table` LIMIT $limit OFFSET $offset");
        $count_rows = $db1->sql_numrows($res_rows);
        if ($count_rows < 1) {
            break;
        }
        $records += $count_rows;
        do {
            $row = $db1->sql_fetchrow($res_rows);
            if (!$row) {
                break;
            }
            $fields = '`' . implode('`, `', array_keys($row)) . '`';
            $insert = "REPLACE INTO $table ($fields) VALUES ";
            $values = [];
            foreach ($row as $field => $value) {
                if ($value === null && isset($defaults[$field])) {
                    $value = $defaults[$field];
                }
                if (is_integer($value)) {
                    $values[] = intval($value);
                }
                elseif (is_float($value)) {
                    $values[] = floatval($value);
                }
                elseif (in_array($field, $numeric_fields)) {
                    $values[] = intval($value);
                }
                else {
                    $values[] = $db2->sql_escape($value);
                }
            }
            $values = "'" . implode("', '", $values) . "'";
            $insert .= "($values);";
            $db2->sql_query($insert);
            $error = $db2->sql_error();
            if ($error[0] > 0) {
                $errors[$table][md5($error[1])] = $error[1];
            }
            
            $records++;
        }
        while(true);
        $offset += $limit;
    }
    $stats[$table] = $records;
}

if (!count($stats)) {
    message_die(GENERAL_ERROR, "No tables converted");
}

foreach($errors as $table => $table_errors) {
    print '<h3>'.strtoupper($table).' ERRORS</h3>';
    print implode('<br />', $table_errors);
}
print '<br /><br />';
foreach($stats as $table => $records) {
    print '<b>'.$table.'</b>: ' . intval($records) . ' processed.<br />';
}