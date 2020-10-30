<?php
#########################################################
## Author: Niels Chr. Rød
## Nickname: Niels Chr. Denmark
## Email: ncr@db9.dk
## http://mods.db9.dk
##
## Ver 1.2.10
## Developed as a drop-in to phpBB2 ver 2.0.2
##
#########################################################

define('MODULE_ID', 20);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Users']['      '] = $filename; //Space for JuniorAdmins

	return;
}

$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_prune_users.' . $phpEx);

$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : ( ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode']:'');
$days = ( isset($HTTP_POST_VARS['days']) ) ? intval($HTTP_POST_VARS['days']) : (( isset($HTTP_GET_VARS['days']) ) ? intval($HTTP_GET_VARS['days']):'');
$days2 = ( isset($HTTP_POST_VARS['days2']) ) ? intval($HTTP_POST_VARS['days2']) : (( isset($HTTP_GET_VARS['days2']) ) ? intval($HTTP_GET_VARS['days2']):'');

$user_count = ($HTTP_GET_VARS['user_count'] > 0) ? $HTTP_GET_VARS['user_count'] : 0;

if ( !isset($HTTP_POST_VARS['confirm']) )
{
	confirm(sprintf($lang['Prune_on_click'], $user_count), append_sid("admin_delete_users.$phpEx?mode=$mode&amp;days=$days&amp;days2=$days2"));
	exit;
}
else if ( isset($HTTP_POST_VARS['cancel']) )
{
	redirect(append_sid("admin/admin_prune_users.$phpEx"));
	exit;
}
	
switch ($mode)
{
	case 'prune_0' : $mode = 'Zero posters';
	case 'zero_poster' :
		$sql = "FROM " . USERS_TABLE . "
			WHERE user_id <> " . ANONYMOUS . "
				AND user_level = 0
				AND user_jr = 0
				AND user_posts < 1
				AND user_regdate < '" . ( CR_TIME - (86400 * $days)) . "'";
				break;

	case 'prune_1' : $mode = 'Not logged in';
	case 'not_login': 
		$sql = "FROM " . USERS_TABLE . "
			WHERE user_id <> " . ANONYMOUS . "
				AND user_level = 0
				AND user_jr = 0
				AND user_lastvisit < 1
				AND user_regdate < '" . (CR_TIME - (86400 * $days)) . "'";
				break;

	case 'prune_2' : $mode = 'Not activated';
		$sql = "FROM " . USERS_TABLE . "
			WHERE user_id <> " . ANONYMOUS . "
				AND user_level = 0
				AND user_jr = 0
				AND user_lastvisit < 1
				AND user_active = 0
				AND user_actkey <> ''
				AND user_regdate < '" . (CR_TIME - (86400 * $days)) . "'";
				break;

	case 'prune_3' : $mode = 'Long time visit';
		$sql = "FROM " . USERS_TABLE . "
			WHERE user_id <> " . ANONYMOUS . "
				AND user_level = 0
				AND user_jr = 0
				AND user_lastvisit < '" . ( CR_TIME - 86400 * $days2) . "'
				AND user_regdate < '" . (CR_TIME - (86400 * $days)) . "'";
			break; 

	case 'prune_4' : $mode = 'Avarage posts';
		$sql = "FROM  " . USERS_TABLE . "
			WHERE user_id <> " . ANONYMOUS . "
				AND user_level = 0
				AND user_jr = 0
				AND (user_posts/((user_lastvisit - user_regdate)/" . ($days2 * 86400) . ")) < 1
				AND user_regdate < '" . (CR_TIME - (86400*$days)) . "'";
			break; 
	case 'prune_5' : $mode = 'Not active';
		$sql = "FROM  " . USERS_TABLE . "
			WHERE user_id <> " . ANONYMOUS . "
				AND user_level = 0
				AND user_jr = 0
				AND user_lastvisit > 1 AND user_posts < 1
				AND user_lastvisit < '" . (CR_TIME - (86400*$days2)) . "'
				AND user_regdate < '" . (CR_TIME - (86400*$days)) . "'";
			break; 

	default : message_die(GENERAL_ERROR, 'No mode specified', '', __LINE__, __FILE__);
}

$sql = 'SELECT user_id, username ' . $sql . ' ORDER BY username LIMIT 200';

if ( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Error obtaining userdata', '', __LINE__, __FILE__, $sql);
}

require($phpbb_root_path . 'includes/functions_remove.'.$phpEx);

$i = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$username = $row['username'];
	delete_user($row['user_id'], $username);

	$name_list .= (($name_list) ? ' , ':'</br>') .$username;
	$i++;
}

$messages .= ((DEBUG) ? '':'').(($i) ? sprintf($lang['Prune_users_number'],$i).$name_list : $lang['Prune_no_users']);
message_die(GENERAL_MESSAGE, $messages); 

?>