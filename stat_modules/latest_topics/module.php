<?php

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$statistics_module = true;

/***************************************************************************
 *								module.php
 *                            -------------------
 *   begin                : Tuesday, Sep 03, 2002
 *   copyright            : (C) 2002 Meik Sievertsen
 *   email                : acyd.burn@gmx.de
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// Modules should be considered to already have access to the following variables which
// the parser will give out to it:

// $return_limit - Control Panel defined number of items to display
// $module_info['name'] - The module name specified in the info.txt file
// $module_info['email'] - The author email
// $module_info['author'] - The author name
// $module_info['version'] - The version
// $module_info['url'] - The author url
//
// To make the module more compatible, please do not use any functions here
// and put all your code inline to keep from redeclaring functions on accident.
//

//
// All your code
//
// Latest Topics
//

//
// Authorization SQL - forum-based
//

$auth_data_sql = $statistics->forum_auth($userdata);

if ($auth_data_sql == '')
{
	// No authed Forum
	return;
}

if ($auth_data_sql != '')
{
	$sql = 'SELECT topic_id, topic_title, topic_time 
	FROM ' . TOPICS_TABLE . ' 
	WHERE forum_id IN (' . $auth_data_sql . ') AND (topic_status <> 2) 
	ORDER BY topic_time DESC 
	LIMIT ' . $return_limit;

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t retrieve topic data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$topic_count = $db->sql_numrows($result);
	$topic_data = $db->sql_fetchrowset($result);
}
else
{
	$topic_count = 0;
	$topic_data = array();
}

for ($i = 0; $i < $topic_count; $i++)
{
	$class = ( !($i+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'];
	
	$posttime = create_date($board_config['default_dateformat'], $topic_data[$i]['topic_time'], $board_config['board_timezone']);

	$template->assign_block_vars('topics', array(
		'RANK' => $i+1,
		'CLASS' => $class,
		'POSTTIME' => $posttime,
		'TITLE' => $topic_data[$i]['topic_title'],
		'URL' => append_sid($phpbb_root_path . 'viewtopic.php?t=' . $topic_data[$i]['topic_id']))
	);
}

$template->assign_vars(array(
	'L_RANK' => $lang['Rank'],
	'L_TOPIC' => $lang['Topic'],
	'L_POSTTIME' => $lang['Post_time'],
	'MODULE_NAME' => $lang['Latest_Topics'])
);

?>