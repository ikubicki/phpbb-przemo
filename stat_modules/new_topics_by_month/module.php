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
// New topics by month
//

if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();

	$sql = 'SELECT YEAR(FROM_UNIXTIME(topic_time)) as aar, MONTH(FROM_UNIXTIME(topic_time)) as mnd, COUNT(*) AS ant 
	FROM ' . TOPICS_TABLE . ' 
	GROUP BY YEAR(FROM_UNIXTIME(topic_time)),MONTH(FROM_UNIXTIME(topic_time)) 
	ORDER BY topic_time';

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t retrieve users data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$topics_count = $db->sql_numrows($result);
	$topics_data = $db->sql_fetchrowset($result);

	for ($i = 0; $i < $topics_count; $i=$i+$k)
	{
		$class = ( !($i+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'];
			
		$year = $topics_data[$i]['aar'];
		$k = 0;
		for ($j = 0; $j < 12; $j++)
		{
			$m[$j+1] = 0;
		}
		for ($j = 0; $j < 12; $j++)
		{
			if ($year == $topics_data[$i+$j]['aar'])
			{
				$month = $topics_data[$i+$j]['mnd'];
				$m[$month] = $topics_data[$i+$j]['ant'];
				$k = $k + 1;
			}
		}
		$template->assign_block_vars('newtopics', array(
			'CLASS' => $class,
			'YEAR' => $year,
			'M01' => $m[1],
			'M02' => $m[2],
			'M03' => $m[3],
			'M04' => $m[4],
			'M05' => $m[5],
			'M06' => $m[6],
			'M07' => $m[7],
			'M08' => $m[8],
			'M09' => $m[9],
			'M10' => $m[10],
			'M11' => $m[11],
			'M12' => $m[12])
		);

		$result_cache->assign_template_block_vars('newtopics');

	}
}
else
{
	for ($i = 0; $i < $result_cache->block_num_vars('newtopics'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('newtopics', $result_cache->get_block_array('newtopics', $i));

	}

}
$template->assign_vars(array(
	'L_NEWTOPICSBYMONTH' => $lang['Topics_month'],
	'L_YEAR' => $lang['Year'],
	'L_MONTH' => $lang['Month'],
	'L_NUMBER' => $lang['Number'],
	'L_JAN' => $lang['Month_jan'],
	'L_FEB' => $lang['Month_feb'],
	'L_MAR' => $lang['Month_mar'],
	'L_APR' => $lang['Month_apr'],
	'L_MAY' => $lang['Month_may'],
	'L_JUN' => $lang['Month_jun'],
	'L_JUL' => $lang['Month_jul'],
	'L_AUG' => $lang['Month_aug'],
	'L_SEP' => $lang['Month_sep'],
	'L_OCT' => $lang['Month_oct'],
	'L_NOV' => $lang['Month_nov'],
	'L_DEC' => $lang['Month_dec'])
);

?>