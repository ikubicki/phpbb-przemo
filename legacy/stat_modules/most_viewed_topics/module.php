<?php

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$statistics_module = true;

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// Using Pre-Authorization and DB Cache

//
// Most Viewed Topics
//
$template->assign_vars(array(
	'L_RANK' => $lang['Rank'],
	'L_VIEWS' => $lang['Views'],
	'L_REPLIES' => $lang['Replies'],
	'L_TOPIC' => $lang['Topic'],
	'MODULE_NAME' => $lang['module_name'])
);

$auth_data_sql = $statistics->forum_auth($userdata);

if ($auth_data_sql == '')
{
	// No authed Forum
	return;
}

$sql = 'SELECT topic_id, topic_title, topic_views, topic_replies
FROM ' . TOPICS_TABLE .	' 
WHERE forum_id IN (' . $auth_data_sql . ') AND (topic_status <> 2) AND (topic_views > 0)
ORDER BY topic_views DESC 
LIMIT ' . $return_limit;

if ( !($result = $stat_db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t retrieve topic data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
}

$topic_count = $stat_db->sql_numrows($result);
$topic_data = $stat_db->sql_fetchrowset($result);

for ($i = 0; $i < $topic_count; $i++)
{
	$class = ( !($i+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'];

	$template->assign_block_vars('topicviews', array(
		'RANK' => $i+1,
		'CLASS' => $class,
		'TITLE' => $topic_data[$i]['topic_title'],
		'VIEWS' => $topic_data[$i]['topic_views'],
		'REPLIES' => $topic_data[$i]['topic_replies'],
		'URL' => append_sid($phpbb_root_path . 'viewtopic.php?t=' . $topic_data[$i]['topic_id']))
	);
}

?>