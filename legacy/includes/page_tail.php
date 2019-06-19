<?php
/***************************************************************************
 *                              page_tail.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2003 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.9 2003/05/14 15:50
 *
 *   $Id: page_tail.php,v 1.27.2.4 2005/09/14 18:14:30 acydburn Exp $
 *
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

global $do_gzip_compress;

//
// Show the overall footer.
//

$banner_bottom = ($board_config['banner_bottom_enable']) ? $board_config['banner_bottom'] : ''; $bo = ( $userdata['session_logged_in'] && ($userdata['user_level'] == ADMIN || $userdata['user_jr'])) ? '<a href="admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a>' : '';

$template->set_filenames(array(
	'overall_footer' => ( empty($gen_simple_header) ) ? 'overall_footer.tpl' : 'simple_footer.tpl')
);

if ( $board_config['generate_time'] && (!$board_config['generate_time_admin'] || ($board_config['generate_time_admin'] && $userdata['user_level'] == ADMIN) ))
{
	$time_end = microtime(true);
	
	if(empty($time_start)) {
		
		$time_start = $_SERVER['REQUEST_TIME'];
		
		if(isset($_SERVER['REQUEST_TIME_FLOAT'])) {
			
			$time_start = $_SERVER['REQUEST_TIME_FLOAT'];
		}
	}
	
	$generated_time = round(($time_end - $time_start), 3);

	$generated_time = $generated_time < 0 ? '0.000' : $generated_time;

	$generate_time = $lang['generate_time'] . ' ' . $generated_time . ' ' . (($generated_time <= 2) ? $lang['second'] : $lang['seconds']) . '. ' . $lang['generate_queries'] . ': ' . $db->num_queries;
}
else
{
	$generate_time = '';
}

$template->assign_vars(array(
	'LOADING_FOOTER' => ($board_config['cload'] && $userdata['cload']) ? "<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\nhideLoadingPage();\n//-->\n</script>" : '',
	'CLICK_HERE_TO_VIEW' => $bo,
	'BANNER_BOTTOM' => replace_vars($banner_bottom),
	'GENERATE_TIME' => $generate_time,
	'TRANSLATION_INFO' => (isset($lang['TRANSLATION_INFO'])) ? $lang['TRANSLATION_INFO'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : ''))
);

$template->pparse('overall_footer');
if ( $show_queries )
{
	echo '<font size="1">' . $queries . '</font>';
}
//
// Close our DB connection.
//
$db->sql_close();

exit;

?>