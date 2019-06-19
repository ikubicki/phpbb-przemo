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

//
// Modules should be considered to already have access to the following variables which
// the parser will give out to it:
//
// $return_limit - Control Panel defined number of items to display
// $module_info['name'] - The module name specified in the info.txt file
// $module_info['email'] - The author email
// $module_info['author'] - The author name
// $module_info['version'] - The version
// $module_info['url'] - The author url
// $module_info['dname'] - The directory which the Module resides in
//
// To make the module more compatible, please do not use any functions here
// and put all your code inline to keep from redeclaring functions on accident.
//
// Use $lang['module_name'] for the Modules Name
// (For example, declare it in lang.php: $mod_lang('module_name', 'Top Posting Users');
// In lang.php the format to describe Language Variables is $mod_lang... but
// within the module.php just use $lang['something'] as you would do in any other script 
// within phpBB2.
//

/*
// Private messaging definitions from constants.php for reference
define('PRIVMSGS_READ_MAIL', 0);
define('PRIVMSGS_NEW_MAIL', 1);
define('PRIVMSGS_SENT_MAIL', 2);
define('PRIVMSGS_SAVED_IN_MAIL', 3);
define('PRIVMSGS_SAVED_OUT_MAIL', 4);
define('PRIVMSGS_UNREAD_MAIL', 5);
*/

	//Find this month's number of private messages
$month = array();
$year = create_date('Y', CR_TIME, $board_config['board_timezone'], true);
$month [0] = mktime (0,0,0,1,1, $year);
$month [1] = $month [0] + 2678400;
$month [2] = mktime (0,0,0,3,1, $year);
$month [3] = $month [2] + 2678400;
$month [4] = $month [3] + 2592000;
$month [5] = $month [4] + 2678400;
$month [6] = $month [5] + 2592000;
$month [7] = $month [6] + 2678400;
$month [8] = $month [7] + 2678400;
$month [9] = $month [8] + 2592000;
$month [10] = $month [9] + 2678400;
$month [11] = $month [10] + 2592000;
$month [12] = $month [11] + 2592000;
$arr_num = (date('n')-1);
$arr_num_1 = (date('n')-2);
$time_thismonth = $month[$arr_num];
$time_lastmonth = $month[$arr_num_1];
$monthno = create_date('n', CR_TIME, $board_config['board_timezone'], true);
$lastmonthno = $monthno - 1;
$nextmonthno = $monthno + 1;
$thismonth=mktime (0,0,0, $monthno,1, $year);
If ($lastmonthno == 0 ) 
{
	$lastmonthno = 12;
	$year = $year - 1;
}
$lastmonth=mktime (0,0,0, $lastmonthno,1, $year);
If ($nextmonthno == 13)	
{
	$nextmonthno = 1;
	$year = $year + 1;
}
if ( $lastmonthno==12 )
{
	$year = $year + 1;
}
$nextmonth=mktime (0,0,0, $nextmonthno,1, $year);
$l_this_month = create_date('F', $thismonth, $board_config['board_timezone'], true);
$l_this_year = create_date('Y', $thismonth, $board_config['board_timezone'], true);
// $thismonthname = create_date('F', CR_TIME, $board_config['board_timezone']);
// create_date gives wrong last month so use PHP's own function
// $lastmonthname = date('F', $lastmonth);
$l_last_month = create_date('F', $lastmonth, $board_config['board_timezone'], true);
$l_last_year = create_date('Y', $lastmonth, $board_config['board_timezone'], true);

$minutes = date('is', CR_TIME);
$hour_now = CR_TIME - (60*($minutes[0].$minutes[1])) - ($minutes[2].$minutes[3]); 
$date = date('H');
$time_today = $hour_now - (3600 * $date); 
$time_yesterday = $time_today - 86400;
$time_lastweek = $time_today - 7*86400;
$time_lastmonth = $time_today - ($thismonth - $lastmonth);

if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();
	for ($mycount=0; $mycount<=5; $mycount++)
	{
		$where_my = "WHERE privmsgs_type = " . $mycount;
		$sql = "SELECT count(*) AS total
		FROM " . PRIVMSGS_TABLE . "
		$where_my";
	
		if(!$count_result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Error getting total private messages.", "", __LINE__, get_module_fd_name(__FILE__), $sql);
		}
		else
		{
			$total = $db->sql_fetchrow($count_result);
			$mytotal[$mycount] = $total['total'];
		}
    }


//	Find largest private message id to show how many have been sent
	$where_my2 = "WHERE privmsgs_id >= 0";
	$sql = "SELECT max(privmsgs_id) AS total
	FROM " . PRIVMSGS_TABLE . "
	$where_my2";
	
	if ( !$count_result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Error getting total private messages written.", "", __LINE__, get_module_fd_name(__FILE__), $sql);
	}
	else
	{
		$total = $db->sql_fetchrow($count_result);
		$total_messages = $total['total'];
	}	
	
	$where_my2 = "WHERE privmsgs_date >= " . $lastmonth . "	AND privmsgs_date < " . $thismonth;

	$sql = "SELECT max(privmsgs_id) AS maxp, min(privmsgs_id) AS minp 
	FROM " . PRIVMSGS_TABLE . "
	$where_my2";

	if(!$count_result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Error getting last month's private messages written.", "", __LINE__, get_module_fd_name(__FILE__), $sql);
			}
			else
			{
				$total = $db->sql_fetchrow($count_result);
				
				If ($total['maxp'] == 0)
					{
					$lastmonth_messages = 0;
					}
					else
					{
					$lastmonth_messages = $total['maxp'] - $total['minp'] + 1;
					}
			}

	$where_my2 = "WHERE privmsgs_date >= " . $thismonth . "	AND privmsgs_date < " . $nextmonth;

	$sql = "SELECT max(privmsgs_id) AS maxp, min(privmsgs_id) AS minp 
	FROM " . PRIVMSGS_TABLE . "
	$where_my2";

	if(!$count_result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Error getting this month's private messages written.", "", __LINE__, get_module_fd_name(__FILE__), $sql);
			}
			else
			{
				$total = $db->sql_fetchrow($count_result);
				If ($total['maxp'] == 0)
					{
					$thismonth_messages = 0;
					}
					else
					{
					$thismonth_messages = $total['maxp'] - $total['minp'] + 1;
					}
			}
			
	//find number of PMs in last 24 hours
	$where_my2 = "WHERE privmsgs_date >= " . $time_yesterday;
	
	$sql = "SELECT max(privmsgs_id) AS maxp, min(privmsgs_id) AS minp 
	FROM " . PRIVMSGS_TABLE . "
	$where_my2";
	
	if(!$count_result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Error getting today's private messages written.", "", __LINE__, get_module_fd_name(__FILE__), $sql);
			}
			else
			{
				$total = $db->sql_fetchrow($count_result);
				If ($total['maxp'] == 0)
					{
					$todays_messages = 0;
					}
					else
					{
					$todays_messages = $total['maxp'] - $total['minp'] + 1;
					}
			}
	
	//find number of PMs in last 7 days
	$where_my2 = "WHERE privmsgs_date >= " . $time_lastweek;
	
	$sql = "SELECT max(privmsgs_id) AS maxp, min(privmsgs_id) AS minp 
	FROM " . PRIVMSGS_TABLE . "
	$where_my2";
	
	if(!$count_result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Error getting last 7 day's private messages written.", "", __LINE__, get_module_fd_name(__FILE__), $sql);
			}
			else
			{
				$total = $db->sql_fetchrow($count_result);
				If ($total['maxp'] == 0)
					{
					$lastweeks_messages = 0;
					}
					else
					{
					$lastweeks_messages = $total['maxp'] - $total['minp'] + 1;
					}
			}

	//find number of PMs in last month
	$where_my2 = "WHERE privmsgs_date >= " . $time_lastmonth;
	
	$sql = "SELECT max(privmsgs_id) AS maxp, min(privmsgs_id) AS minp 
	FROM " . PRIVMSGS_TABLE . "
	$where_my2";
	
	if(!$count_result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Error getting last month's private messages written.", "", __LINE__, get_module_fd_name(__FILE__), $sql);
	}
	else
	{
		$total = $db->sql_fetchrow($count_result);
		If ($total['maxp'] == 0)
		{
			$lastmonths_messages = 0;
		}
		else
		{
			$lastmonths_messages = $total['maxp'] - $total['minp'] + 1;
		}
	}
	$template->assign_block_vars('pm', array(
		'TOTAL_MESS' => $total_messages,
		'LAST_MESS' => $lastmonth_messages,
		'THIS_MESS' => $thismonth_messages,
		'TODAY_MESS' => $todays_messages,
		'LAST_WEEK_MESS' => $lastweeks_messages,
		'LAST_MONTH_MESS' => $lastmonths_messages,
		'TOTAL0' => $mytotal[0],
		'TOTAL1' => $mytotal[1],
		'TOTAL2' => $mytotal[2],
		'TOTAL3' => $mytotal[3],
		'TOTAL4' => $mytotal[4],
		'TOTAL5' => $mytotal[5])
	);
	$result_cache->assign_template_block_vars('pm');
}
else
{
	for ($i = 0; $i < $result_cache->block_num_vars('pm'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('pm', $result_cache->get_block_array('pm', $i));

	}

}

$template->assign_vars(array(
	'MODULE_NAME' => $lang['module_name'],
	'L_WRITTEN_PM' => $lang['Written_pm'],
	'L_NOTICE_PM' => $lang['Notice_pm'],
	'L_LAST_MONTH' => $lang['Last_month_pm'],
	'L_TODAY' => $lang['todays_pm'],
	'L_THIS_WEEK' => $lang['thisweeks_pm'],
	'L_THIS_MONTHS' => $lang['thismonths_pm'],
	'L_NUMBER' => $lang['numberof_pm'],
	'L_CURRENT' => $lang['current_pm'],
	'L_READ_PM' => $lang['Read_pm'],
	'L_NEW_PM' => $lang['New_pm'],
	'L_SENT_PM' => $lang['Sent_pm'],
	'L_INBOX_PM' => $lang['Inbox_pm'],
	'L_OUTBOX_PM' => $lang['Outbox_pm'],
	'L_UNREAD_PM' => $lang['Unread_pm'],
	'L_LAST_MONTH_NAME' => sprintf($lang['Month'], ($l_last_month . ' ' . $l_last_year) ),
	'L_THIS_MONTH' => $lang['This_month_pm'],
	'L_THIS_MONTH_NAME' => sprintf($lang['Month'], ($l_this_month . ' ' . $l_this_year) ))
);

?>