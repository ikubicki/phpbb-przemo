<?php

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$statistics_module = true;

/***************************************************************************
 *                              module.php
 *                            -------------------
 *   begin                : Tuesday, Aug 20, 2002
 *   copyright            : RustyDragon 
 *   contact              : <dev@RustyDragon.com>, http://www.RustyDragon.com
 *   $Id: module.php,v 1.3 2002/09/29 14:15:15 RustyDragon Exp $
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

define('NO_GENDER', 0);
define('MALE', 1);
define('FEMALE', 2);

//Vote Images based on the theme path, (i.e. templates/CURRNT_THEME/ is already inserted below)
$vote_left = "images/vote_lcap.gif";
$vote_right = "images/vote_rcap.gif";
$vote_bar = "images/voting_bar.gif";

$statistics->init_bars();

if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();

	$rank = 0;
	//
	// Getting voting bar info from template
	//
	if( !$board_config['override_user_style'] )
	{
		if( $userdata['user_id'] != ANONYMOUS && isset($userdata['user_style']) )
		{
			$style = $userdata['user_style'];
			if( !$theme )
			$style =  $board_config['default_style'];
		}
		else
		$style =  $board_config['default_style'];
	}
	else
	$style =  $board_config['default_style'];

	$sql = 'SELECT *
	FROM ' . THEMES_TABLE . "
	WHERE themes_id = $style";

	if(!$result = $db->sql_query($sql))
	{
		message_die(CRITICAL_ERROR, "Couldn't query database for theme info.");
	}
	if( !$row = $db->sql_fetchrow($result) )
	{
		message_die(CRITICAL_ERROR, "Couldn't get theme data for themes_id=$style.");
	}

	$template_path = $phpbb_root_dir . 'templates/' ;
	$template_name = $row['template_name'] ;

	$current_template_path = $template_path . $template_name . '/';

	$template->assign_vars(array(
		'LEFT_GRAPH_IMAGE' => $current_template_path . $vote_left,
		'RIGHT_GRAPH_IMAGE' => $current_template_path . $vote_right,
		'GRAPH_IMAGE' => $current_template_path . $vote_bar)
	);

	//
	// Top posters SQL
	//
	$sql = 'SELECT COUNT(user_gender) as used_counter, user_gender 
	FROM ' . USERS_TABLE . '
	WHERE user_id != -1
	GROUP BY user_gender ORDER BY used_counter DESC';

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't retrieve users data", '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$user_count = $db->sql_numrows($result);
	$user_data = $db->sql_fetchrowset($result);
	$percentage = 0;
	$bar_percent = 0;
	$usercount = get_db_stat('usercount');

	$firstcount = $user_data[0]['used_counter'];
	$cst = ($firstcount > 0) ? 90 / $firstcount : 90;

	for ($i = 0; $i < $user_count; $i++)
	{
		if ( $user_data[$i]['used_counter'] != 0  )
		{
			$percentage = @round( min(100, ($user_data[$i]['used_counter'] / $usercount) * 100));
		}
		else
		{
			$percentage = 0;
		}

		$bar_percent = @round($user_data[$i]['used_counter'] * $cst);
		switch ($user_data[$i]['user_gender']){
			case NO_GENDER: $gender = $lang['No_gender_specify']; $gender_image =''; break;
			case MALE: $gender = '<img src="' . $current_template_path . 'images/icon_minigender_male.gif" border="0" alt="' . $lang['Male'] . '" />';
		break;
			case FEMALE: $gender = '<img src="' . $current_template_path . 'images/icon_minigender_female.gif" border="0" alt="' . $lang['Female'] . '" />';
		break;
		}

		$template->assign_block_vars('gender', array(
			'RANK' => $i+1,
			'CLASS' => ( !($i+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'],
			'GENDER' => $gender,
			'USERS' => $user_data[$i]['used_counter'],
			'PERCENTAGE' => $percentage,
			'BAR' => $bar_percent)
		);
		$result_cache->assign_template_block_vars('gender');
	}
}
else
{
	for ($i = 0; $i < $result_cache->block_num_vars('gender'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('gender', $result_cache->get_block_array('gender', $i));

	}

}
$template->assign_vars(array(
	'L_RANK' => $lang['Rank'],
	'L_USERS' => $lang['Memberlist'],
	'L_PERCENTAGE' => $lang['Percent'],
	'L_GENDER' => $lang['Gender'],
	'L_GRAPH' => $lang['Graph'],
	'MODULE_NAME' => $lang['module_name'])
);

?>