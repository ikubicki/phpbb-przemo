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
// Where are users from
//
// Updated by Acyd Burn on 2002-09-13
//

if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();


	$sql = "SELECT user_from, COUNT(*) as number
	FROM " . USERS_TABLE . "
	WHERE user_from <> ''
	GROUP BY user_from 
	ORDER BY number DESC 
	LIMIT " . $return_limit;

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t retrieve user data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$user_count = $db->sql_numrows($result);
	$user_data = $db->sql_fetchrowset($result);

	for ($i = 0; $i < $user_count; $i++)
	{
		$class = ( !($i+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'];

		$template->assign_block_vars('fromwhere', array(
			'RANK' => $i+1,
			'CLASS' => $class,
			'FROMWHERE' => $user_data[$i]['user_from'],
			'HOWMANY' => $user_data[$i]['number'])
		);
		$result_cache->assign_template_block_vars('fromwhere');
	}
}
else
{
	for ($i = 0; $i < $result_cache->block_num_vars('fromwhere'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('fromwhere', $result_cache->get_block_array('fromwhere', $i));

	}

}
$template->assign_vars(array(
	'L_RANK' => $lang['Rank'],
	'L_FROMWHERETITLE' => $lang['From_where_title'],
	'L_FROMWHERE' => $lang['From_where'],
	'L_HOWMANY' => $lang['How_many'])
);

?>