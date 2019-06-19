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

// DB Cache used here

//
// Top Posting Users
//

$statistics->init_bars();

if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();

	$sql = "SELECT SUM(special_rank) as total_helped FROM " . USERS_TABLE . "
		WHERE user_id <> " . ANONYMOUS;

	if ( !($result = $stat_db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t retrieve users data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$row = $stat_db->sql_fetchrow($result);
	$total_helped = $row['total_helped'];

	$sql = "SELECT user_id, username, special_rank FROM " . USERS_TABLE . " 
		WHERE (user_id <> " . ANONYMOUS . " ) AND (special_rank > 0) 
			ORDER BY special_rank DESC 
			LIMIT " . $return_limit;

	if ( !($result = $stat_db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t retrieve users data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$user_count = $stat_db->sql_numrows($result);
	$user_data = $stat_db->sql_fetchrowset($result);

	$firstcount = $user_data[0]['special_rank'];

	for ($i = 0; $i < $user_count; $i++)
	{
		$class = ( !($i+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'];

		$statistics->do_math($firstcount, $user_data[$i]['special_rank'], $total_helped);

		$template->assign_block_vars('users_helped', array(
			'RANK' => $i+1,
			'CLASS' => $class,
			'USERNAME' => $user_data[$i]['username'],
			'PERCENTAGE' => $statistics->percentage,
			'BAR' => $statistics->bar_percent,
			'URL' => append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $user_data[$i]['user_id']),
			'POSTS' => $user_data[$i]['special_rank'])
		);
		$result_cache->assign_template_block_vars('users_helped');
	}
}
else
{
	for ($i = 0; $i < $result_cache->block_num_vars('users_helped'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('users_helped', $result_cache->get_block_array('users_helped', $i));

	}

}
$template->assign_vars(array(
	'L_RANK' => $lang['Rank'],
	'L_POSTS' => $lang['helped'],
	'L_PERCENTAGE' => $lang['Percent'],
	'L_USERNAME' => $lang['Username'],
	'L_GRAPH' => $lang['Graph'],
	'MODULE_NAME' => $lang['module_name'])
);

?>