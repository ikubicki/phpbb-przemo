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
// Last active users
//

$sql = 'SELECT user_id, username, user_lastvisit 
FROM ' . USERS_TABLE . ' 
WHERE user_id <> ' . ANONYMOUS . '
AND user_allow_viewonline = 1
ORDER BY user_lastvisit DESC 
LIMIT ' . $return_limit;

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t retrieve user data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
}

$user_count = $db->sql_numrows($result);
$user_data = $db->sql_fetchrowset($result);

for ($i = 0; $i < $user_count; $i++)
{
	$class = ( !($i+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'];
	$visitdate = create_date($board_config['default_dateformat'], $user_data[$i]['user_lastvisit'], $board_config['board_timezone']);

	$template->assign_block_vars('lastactive', array(
		'RANK' => $i+1,
		'CLASS' => $class,
		'LASTVISIT' => $visitdate,
		'URL' => append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $user_data[$i]['user_id']),
		'USERNAME' => $user_data[$i]['username'])
	);
}

$template->assign_vars(array(
	'L_RANK' => $lang['Rank'],
	'L_LASTVIST' => $lang['Last_visited'],
	'L_LAST_ACTIVE' => $lang['Last_active'])
);

?>