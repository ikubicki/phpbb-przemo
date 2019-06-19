<?php
/***************************************************************************
 *                          admin_rebuild_search.php
 *                            -------------------
 *   begin                : July 9th 2003
 *   copyright            : (C) 2003 Antony Bailey
 *   email                : antony_bailey@lycos.co.uk
 *   modification         : (C) 2003 Przemo http://www.przemo.org
 *   date modification    : ver. 1.9 2005/03/11 20:50
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
define('MODULE_ID', 50);
define ('IN_PHPBB', 1);

if(!empty ($setmodules))
{
	$filename = basename(__FILE__);
	$module['SQL']['Rebuild_search'] = $filename;
	return;
}

$no_page_header = true;
$phpbb_root_path = './../';

require ($phpbb_root_path . 'extension.inc');
require ('pagestart.' . $phpEx);
require ($phpbb_root_path . 'includes/functions_search.'.$phpEx); 

if ( strstr($board_config['main_admin_id'], ',') )
{
	$fids = explode(',', $board_config['main_admin_id']);
	while( list($foo, $id) = each($fids) )
	{
		$fid[] = intval( trim($id) );
	}
}
else
{
	$fid[] = intval( trim($board_config['main_admin_id']) );
}
reset($fid);
if ( in_array($userdata['user_id'], $fid) == false )
{
	$message = sprintf($lang['SQL_Admin_No_Access'], '<a href="' . append_sid("admin_no_access.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

$start_time = time ();
if ( isset($HTTP_GET_VARS['limit_time']) || isset($HTTP_POST_VARS['limit_time']) )
{
	$limit_time = (isset($HTTP_GET_VARS['limit_time'])) ? intval($HTTP_GET_VARS['limit_time']) : intval($HTTP_POST_VARS['limit_time']);
}
else $limit_time = 120;

$mode = $HTTP_GET_VARS['mode'];
$start = intval($HTTP_GET_VARS['start']);
$page_title = $lang['Page_title'];

if ( $mode == 'clear' )
{
	update_config('rebuild_search', '');
}

$sql = "SELECT * FROM " . CONFIG_TABLE . "
	WHERE config_name = 'rebuild_search'"; 
if ( !($result = $db->sql_query($sql)))
{
	message_die(CRITICAL_ERROR, 'Could not query config table for data previous rebuilding! If you dont want resume previous session just clear config table where config name = rebuild_search', '', __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$value = $row['config_value'];
	}
}

if ( $value != '' && !$HTTP_GET_VARS['total_num_rows'] )
{
	include('./page_header_admin.'.$phpEx);

	$rebuild_explain = $lang['Rebuild_search_explain'] . '<br /><br /><br /><br />' . sprintf($lang['resume_rebuild'], '<a href="' . append_sid("admin_rebuild_search.$phpEx?$value") . '">', '</a>', '<a href="' . append_sid ("admin_rebuild_search.$phpEx?mode=clear") . '">', '</a>');
	$template->assign_vars (array (
		'L_REBUILD_SEARCH' => $lang['Rebuild_search'],
		'L_REBUILD_SEARCH_EXPLAIN' => $rebuild_explain,
		'L_POST_LIMIT' => $lang['Post_limit'],
		'L_TIME_LIMIT' => $lang['Time_limit'],
		'L_REFRESH_RATE' => $lang['Refresh_rate'],
		'SESSION_ID' => $userdata['session_id'],
		
		'S_REBUILD_SEARCH_ACTION' => append_sid("admin_rebuild_search.$phpEx"))
	);
		
	$template->set_filenames (array (
	    'body' => 'admin/rebuild_search_body.tpl')
	);
}
else
{
	if (isset ($HTTP_GET_VARS['start']))
	{
		if ( !(function_exists('onTime')) )
		{
			function onTime()
			{
				global $start_time, $limit_time;
				static $max_execution_time;
				$current_time = time ();
			
				if (empty ($max_execution_time))
				{
					if (@ini_get ('safe_mode') == false)
					{
						@set_time_limit (0);
						$max_execution_time = $limit_time;
					}
					else
					{
						$max_execution_time = @ini_get('max_execution_time');
					}
				}
				return (($current_time - $start_time) < $max_execution_time) ? true : false;
			}
		}

		// Let's start over again and grow ourselves new MySQL tables.
		if ($start == 0)
		{
			$sql = array();
			$sql[] = "CREATE TABLE " . SEARCH_TABLE . "_new LIKE " . SEARCH_TABLE;
			$sql[] = "CREATE TABLE " . SEARCH_WORD_TABLE . "_new LIKE " . SEARCH_WORD_TABLE;
			$sql[] = "CREATE TABLE " . SEARCH_MATCH_TABLE . "_new LIKE " . SEARCH_MATCH_TABLE;
			$sql[] = "DROP TABLE " . SEARCH_TABLE;
			$sql[] = "DROP TABLE " . SEARCH_WORD_TABLE;
			$sql[] = "DROP TABLE " . SEARCH_MATCH_TABLE;
			$sql[] = "RENAME TABLE " . SEARCH_TABLE . "_new TO " . SEARCH_TABLE . ",
					  " . SEARCH_WORD_TABLE . "_new TO " . SEARCH_WORD_TABLE . ",
					  " . SEARCH_MATCH_TABLE . "_new TO " . SEARCH_MATCH_TABLE;
			foreach($sql as $q)
				$db->sql_query($q);

			// Text		
			$sql = "SELECT COUNT(post_id) as total FROM ". POSTS_TEXT_TABLE;
			$result = $db->sql_query($sql);
			$total_num_rows = $row['total'];
		}
		// Let's make the new tables.
		$total_num_rows = (isset($HTTP_GET_VARS['total_num_rows'])) ? intval($HTTP_GET_VARS['total_num_rows']) : $total_num_rows;
		
		$sql = "SELECT post_id, post_subject, post_text FROM " . POSTS_TEXT_TABLE . "
			LIMIT $start, " . intval($HTTP_GET_VARS['post_limit']);
		$result = $db->sql_query ($sql);
		
		$num_rows = 0;
		while (($row = $db->sql_fetchrow ($result)) && (onTime () == true))
		{
			if ( $row['post_subject'] )
			{
				$sql_e = "SELECT topic_title_e
					FROM " . TOPICS_TABLE . "
						WHERE topic_first_post_id = " . $row['post_id'];
				$result_e = $db->sql_query ($sql_e);
				$row_e = $db->sql_fetchrow($result_e);
			}
			$topic_explain = $row_e['topic_title_e'];

			add_search_words('single', $row['post_id'], stripslashes($row['post_text']), stripslashes($row['post_subject']), stripslashes($topic_explain));
			$num_rows++;
		}
	
		// Show the template work.
		$template->set_filenames(array(
			'body' => 'admin/admin_message_body.tpl')
		);

		if ( (($start + $num_rows) < $total_num_rows) && $num_rows > 0 )
		{
			$form_action = 'start=' . ($start + $num_rows) . '&amp;total_num_rows=' . $total_num_rows . '&amp;post_limit=' . intval($HTTP_GET_VARS['post_limit']) . '&amp;limit_time=' . $limit_time . '&amp;refresh_rate=' . intval($HTTP_GET_VARS['refresh_rate']);

			update_config('rebuild_search', $form_action);

			$next = $lang['Next'];
			$percent = @round((($start + $num_rows) / $total_num_rows) * 100);

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="'. $HTTP_GET_VARS['refresh_rate'] .';url='. append_sid("admin_rebuild_search.$phpEx?$form_action") .'">')
			);
		}
		else
		{
			update_config('rebuild_search', '');

			$next = $lang['Finished'];
			$percent = $lang['Finished'] . '<br />100';
			$lang['Percentage_complete'] = '';
			$form_action = 'finished=1';
		}
	
		include ('./page_header_admin.'.$phpEx);

		$template->assign_vars (array (
			'PERCENT' => $percent,
			'L_REBUILD_SEARCH' => $lang['Rebuild_search'],
			'L_REBUILD_SEARCH_EXPLAIN' => $lang['Rebuild_search_explain'],
			'L_NEXT' => $next,
			'L_PERCENTAGE_COMPLETE' => $lang['Percentage_complete'],
			'S_REBUILD_SEARCH_ACTION' => append_sid("admin_rebuild_search.$phpEx?$form_action"))
		);
	
		$template->set_filenames (array (
		    'body' => 'admin/rebuild_search_progress_body.tpl')
		);
	}
	else
	{
		include('./page_header_admin.'.$phpEx);

		// The variables, hey kids you wana edit these to add new stuff. :)
		$template->assign_vars (array (
			'L_REBUILD_SEARCH' => $lang['Rebuild_search'],
			'L_REBUILD_SEARCH_EXPLAIN' => $lang['Rebuild_search_explain'],
			'L_POST_LIMIT' => $lang['Post_limit'],
			'L_TIME_LIMIT' => $lang['Time_limit'],
			'L_REFRESH_RATE' => $lang['Refresh_rate'],
			'SESSION_ID' => $userdata['session_id'],
		
			'S_REBUILD_SEARCH_ACTION' => append_sid ("admin_rebuild_search.$phpEx"))
		);
		
		$template->set_filenames (array (
		    'body' => 'admin/rebuild_search_body.tpl')
		);
	}
}
// Generate the page
$template->pparse ('body');
include('./page_footer_admin.'.$phpEx);

?>