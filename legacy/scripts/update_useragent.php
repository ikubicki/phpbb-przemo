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

$sql_where = "WHERE user_agent IS NOT NULL ORDER BY post_id DESC";

$sql = "SELECT COUNT(*) AS max_posts FROM " . POSTS_TABLE . "
	" . $sql_where;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
}

$max_posts = $db->sql_fetchrow($result);
$max_posts = $max_posts['max_posts'];
$i = $updated = 0;

while ($i <= $max_posts)
{
	$time1 = time();
	
	$sql = "SELECT post_id, user_agent FROM " . POSTS_TABLE . " 
		" . $sql_where . "
		LIMIT $i, $convert_posts_once";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( strpos($row['user_agent'], 'a:3:{') !== false )
		{
			$user_agent = @unserialize($row['user_agent']);
			$user_agent = ($user_agent[2]) ? $user_agent[2] : '';
		}
		else
		{
			$user_agent = $row['user_agent'];
		}
		
		$new_user_agent = user_agent($user_agent);
		if( strpos($row['user_agent'], $new_user_agent[0]) === false || strpos($row['user_agent'], $new_user_agent[1]) === false )
		{
			$sqlu = "UPDATE " . POSTS_TABLE . "
				SET user_agent='" . str_replace("'", "''", serialize($new_user_agent)) . "'
				WHERE post_id=" . $row['post_id'] . "
				LIMIT 1";
			if ( !($resultu = $db->sql_query($sqlu)) )
			{
				message_die(GENERAL_ERROR, 'Could not update forums information', '', __LINE__, __FILE__, $sqlu);
			}
			$updated++;
		}
	}
	$db->sql_freeresult($result);
	$i += $convert_posts_once;
	$last_loop = CR_TIME - $time1;

	// jesli zostalo mniej niz 5 sekund niz czas trwania petli
	if (CR_TIME - $time_start + $last_loop + 5 > $max_execution_time)
	{
		$url = append_sid("scripts/update_useragent.$phpEx");
		message_die(GENERAL_MESSAGE, sprintf($lang['UA_time_exc'], $updated, $max_posts, '<meta http-equiv="refresh" content="1;url=' . $url . '"><a href="' . $url . '">', '</a>'), $lang['UA_title']);
	}
}

if ($updated > 0)
{
	$sql = "UPDATE " . MODULES_TABLE . " SET module_info_time = 0, module_cache_time = 0";

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to update Modules Table', '', __LINE__, __FILE__, $sql);
	}
}

message_die(GENERAL_MESSAGE, sprintf($lang['UA_finished'], $updated), $lang['UA_title']);

?>