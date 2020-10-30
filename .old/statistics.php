<?php
/***************************************************************************
 *                      statistics.php
 *                      -------------------
 *   begin              : Sat, Aug 31, 2002
 *   copyright          : (C) 2002 Meik Sievertsen
 *   email              : acyd.burn@gmx.de
 *   modification       : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification  : ver. 1.12.3 2003/06/15 21:00
 *
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
define('ATTACH', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$stats_config = array();

$sql = 'SELECT *
FROM ' . STATS_CONFIG_TABLE;
	 
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query statistics config table', '', __LINE__, __FILE__, $sql);
}

while ($row = $db->sql_fetchrow($result))
{
	$stats_config[$row['config_name']] = trim($row['config_value']);
}

include($phpbb_root_path . 'includes/functions_stats.' . $phpEx);
include($phpbb_root_path . 'includes/functions_module.' . $phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_STATISTICS);
init_userprefs($userdata);
//
// End session management
//

if ( $board_config['login_require'] && !$userdata['session_logged_in'] || ( $board_config['crestrict'] && !$userdata['session_logged_in'] ) )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

$language = $board_config['default_lang'];

if (!file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $language . '/lang_statistics.' . $phpEx)))
{
	$language = 'english';
}

include($phpbb_root_path . 'language/lang_' . $language . '/lang_statistics.' . $phpEx);

$page_title = $lang['Statistics_title'];
include('includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'statistics.tpl')
);


$stat_module_rows = get_module_list_from_db();
$stat_module_data = get_module_data_from_db();
$return_limit = $stats_config['return_limit'];

@reset($stat_module_rows);

while (list($module_id, $module_name) = each($stat_module_rows))
{
	$module_name = trim($module_name);

	if (module_auth_check($stat_module_data[$module_id], $userdata))
	{
		print '<a name="' . $module_id . '"></a>';

		$modules_dir = trim($stat_module_data[$module_id]['name']);

		$module_info = generate_module_info($stat_module_data[$module_id]);
		$mod_lang = 'module_language_parse';
				
		$language = $board_config['default_lang'];

		if (!file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $language . '/lang_statistics.' . $phpEx)))
		{
			$language = 'english';
		}
		include($phpbb_root_path . 'language/lang_' . $language . '/lang_statistics.' . $phpEx);
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);

		$language = $board_config['default_lang'];

		if (!file_exists(@phpbb_realpath($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/lang_' . $language . '/lang.' . $phpEx)))
		{
			$language = 'english';
		}

		if (!file_exists($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name)) {
			break;
		}

		include($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/lang_' . $language . '/lang.' . $phpEx);
		$reload = FALSE;

		if ((trim($stat_module_data[$module_id]['module_db_cache']) != '') || (trim($stat_module_data[$module_id]['module_result_cache']) != ''))
		{
			if ( (($stat_module_data[$module_id]['module_cache_time'] + ($stat_module_data[$module_id]['update_time'] * 3600)) > CR_TIME) && $stat_module_data[$module_id]['module_cache_time'] != 0 )
			{
				if (trim($stat_module_data[$module_id]['module_db_cache']) != '')
				{
					$statistics->db_cache_used = TRUE;
					$stat_db->begin_cached_query(TRUE, trim($stat_module_data[$module_id]['module_db_cache']));
				}

				if (trim($stat_module_data[$module_id]['module_result_cache']) != '')
				{
					$statistics->result_cache_used = TRUE;
					$result_cache->begin_cached_results(TRUE, trim($stat_module_data[$module_id]['module_result_cache']));
				}

				include($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/module.'.$phpEx);

				if (trim($stat_module_data[$module_id]['module_db_cache']) != '')
				{
					$stat_db->end_cached_query($module_id);
				}
				if (trim($stat_module_data[$module_id]['module_result_cache']) != '')
				{
					$result_cache->end_cached_query($module_id);
				}
			}
			else
			{
				$reload = TRUE;
			}
		}
		else
		{
			$reload = TRUE;
		}

		if ($reload)
		{
			$statistics->result_cache_used = FALSE;
			$statistics->db_cache_used = FALSE;

			$stat_db->begin_cached_query();
			$result_cache->begin_cached_results();
			include($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/module.'.$phpEx);
			$stat_db->end_cached_query($module_id);
			$result_cache->end_cached_query($module_id);
		}
				
		$template->set_filenames(array(
			'module_tpl_' . $module_id => './../../' . $phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_info['dname'] . '/module.tpl')
		);
	
		$template->pparse('module_tpl_' . $module_id);

		print '<br />';
	}
}
	
$sql = "UPDATE " . STATS_CONFIG_TABLE . "
SET config_value = " . (intval($stats_config['page_views']) + 1) . "
WHERE (config_name = 'page_views')";

if (!$db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Unable to Update View Counter', '', __LINE__, __FILE__, $sql);
}

$template->assign_vars(array(
	'VIEWED_INFO' => sprintf($lang['Viewed_info'], $stats_config['page_views']))
);
	
$template->assign_block_vars('main_bottom',array());

$template->pparse('body');

include('includes/page_tail.'.$phpEx);

?>