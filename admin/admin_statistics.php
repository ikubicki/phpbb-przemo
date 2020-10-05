<?php
/***************************************************************************
*                           admin_statistics.php
*                            -------------------
*   begin                : Sat, Aug 31, 2002
*   copyright            : (C) 2002 Meik Sievertsen
*   email                : acyd.burn@gmx.de
*
*   $Id: admin_statistics.php,v 1.9 2002/11/09 17:13:26 acydburn Exp $
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
define('MODULE_ID', 54);
define('IN_PHPBB', true);

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
if (!empty($board_config))
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_statistics.' . $phpEx);
}

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Statistics']['Statistics_management'] = $filename . '?mode=manage';
	$module['Statistics']['Statistics_config'] = $filename . '?mode=config';
	return;
}

require('pagestart.' . $phpEx);

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
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_statistics.' . $phpEx);

//
// Try to re-assign Images for Admin Display
//
@reset($images);
while (list($key, $value) = each($images))
{
	if ((!is_array($images[$key])) && ($images[$key] != ''))
	{
		$images[$key] = './../' . $images[$key];
	}
}

//
// Now try to re-assign the smilies
//
$board_config['smilies_path'] = './../' . $board_config['smilies_path'];

//
// Init Vars
//
$params = array(
	'mode' => 'mode',
	'submit' => 'submit',
	'module_id' => POST_FORUM_URL
);

while( list($var, $param) = @each($params) )
{
	( !empty($HTTP_POST_VARS[$param]) || !empty($HTTP_GET_VARS[$param]) )? $$var = ( !empty($HTTP_POST_VARS[$param]) ) ? $HTTP_POST_VARS[$param] : $HTTP_GET_VARS[$param] : $$var = '';
}

$message = '';
$templated = true;

if ( !(function_exists('gen_auth_select')) )
{
	function gen_auth_select($default_auth_value)
	{
		global $lang;

		$auth_levels = array('ALL', 'REG', 'ADMIN');
		$auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ADMIN);

		$select_list = '<select name="auth_fields">';

		for($i = 0; $i < count($auth_levels); $i++)
		{
			$selected = ( $default_auth_value == $auth_const[$i] ) ? ' selected="selected"' : '';
			$select_list .= '<option value="' . $auth_const[$i] . '"' . $selected . '>' . $lang['Forum_' . $auth_levels[$i]] . '</option>';
		}
		$select_list .= '</select>';

		return ($select_list);
	}
}

if ($mode == 'order')
{
	//
	// Change order of modules in the DB
	//
	$move = intval($HTTP_GET_VARS['move']);

	$sql = "UPDATE " . MODULES_TABLE . "
	SET display_order = display_order + $move
	WHERE module_id = " . $module_id;

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't change Module order", "", __LINE__, __FILE__, $sql);
	}

	$sql = "SELECT module_id FROM " . MODULES_TABLE . "
	ORDER BY display_order ASC";

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Modules", "", __LINE__, __FILE__, $sql);
	}

	$i = 10;
	$inc = 10;

	while( $row = $db->sql_fetchrow($result) )
	{
		$sql = "UPDATE " . MODULES_TABLE . "
		SET display_order = " . $i . "
		WHERE module_id = " . $row['module_id'];

		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
		}
		$i += $inc;
	}

	$mode = 'manage';
}

if ($submit && $mode == 'config')
{
	if ( !empty($HTTP_POST_VARS['return_limit_set']) )
	{
		$update_value = ( !empty($HTTP_POST_VARS['return_limit_set']) ) ? intval($HTTP_POST_VARS['return_limit_set']) : 0;

		if (intval($stats_config['return_limit']) != intval($update_value))
		{
			$sql = "UPDATE " . STATS_CONFIG_TABLE . "
			SET config_value = '$update_value'
			WHERE (config_name = 'return_limit')";

			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Unable to update the Statistics Config Table', '', __LINE__, __FILE__, $sql);
			}

			$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Return_limit'];
		}
	}

	if ( !empty($HTTP_POST_VARS['clear_cache_set']) )
	{
		$sql = "UPDATE " . MODULES_TABLE . "
		SET module_info_time = 0,
		module_cache_time = 0";

		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Unable to update Modules Table', '', __LINE__, __FILE__, $sql);
		}

		$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Clear_cache'];
	}

	if ( !empty($HTTP_POST_VARS['modules_dir_set']) )
	{
		$update_value = ( !empty($HTTP_POST_VARS['modules_dir_set']) ) ? $HTTP_POST_VARS['modules_dir_set'] : '';

		if ($stats_config['modules_dir'] != $update_value)
		{
			$sql = "UPDATE " . STATS_CONFIG_TABLE . "
			SET config_value = '$update_value'
			WHERE (config_name = 'modules_dir')";

			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Unable to update Statistics Config Table', '', __LINE__, __FILE__, $sql);
			}

			$message .= '<br>' . $lang['Updated'];
		}
	}
}

if ($mode == 'config')
{
	$template->set_filenames(array(
		'body' => 'admin/stat_config_body.tpl')
	);

	$stats_config = array();

	$sql = 'SELECT *
	FROM ' . STATS_CONFIG_TABLE;

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query statistics config table', '', __LINE__, __FILE__, $sql);
	}

	while ($row = $db->sql_fetchrow($result))
	{
		$stats_config[$row['config_name']] = $row['config_value'];
	}

	$template->assign_vars(array(
		'L_RETURN_LIMIT' => $lang['Return_limit'],
		'L_RETURN_LIMIT_DESC' => $lang['Return_limit_desc'],
		'L_CLEAR_CACHE' => $lang['Clear_cache'],
		'L_CLEAR_CACHE_DESC' => $lang['Clear_cache_desc'],

		'L_MESSAGES' => $lang['Messages'],
		'L_RESET' => $lang['Reset'],
		'L_SUBMIT' => $lang['Submit'],

		'L_STATS_CONFIG' => $lang['Statistics_config_title'],
		'MESSAGE' => $message,

		'RETURN_LIMIT' => $stats_config['return_limit'],
		'MODULES_DIR' => $stats_config['modules_dir'],

		'S_ACTION' => append_sid("admin_statistics.$phpEx?mode=config"))
	);
}

if ($mode == 'install_activate')
{
	$mode = 'install';
	$var = 'activate';
}

if ($mode == 'activate')
{
	$sql = "UPDATE " . MODULES_TABLE . "
	SET active = 1
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to activate Module', '', __LINE__, __FILE__, $sql);
	}

	$sql = "SELECT * FROM " . MODULES_TABLE . "
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to get Module Informations', '', __LINE__, __FILE__, $sql);
	}

	$module_info = generate_module_info($db->sql_fetchrow($result));

	$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Activated'] . ' : ' . $module_info['name'];

	$mode = 'manage';
}

if ($mode == 'deactivate')
{
	$sql = "UPDATE " . MODULES_TABLE . "
	SET active = 0
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to deactivate Module', '', __LINE__, __FILE__, $sql);
	}

	$sql = "SELECT * FROM " . MODULES_TABLE . "
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to get Module Informations', '', __LINE__, __FILE__, $sql);
	}

	$module_info = generate_module_info($db->sql_fetchrow($result));

	$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Deactivated'] . ' : ' . $module_info['name'];

	$mode = 'manage';
}

if ($mode == 'uninstall')
{
	$sql = "UPDATE " . MODULES_TABLE . "
	SET installed = 0, active = 0
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to unsinstall Module', '', __LINE__, __FILE__, $sql);
	}

	$sql = "SELECT * FROM " . MODULES_TABLE . "
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to get Module Informations', '', __LINE__, __FILE__, $sql);
	}

	$module_info = generate_module_info($db->sql_fetchrow($result));

	$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Uninstalled'] . ' : ' . $module_info['name'];

	$mode = 'manage';
}

if ($mode == 'auto_set')
{
	$errored = false;
	$templated = false;

	print '<br />';

	$module_rows = get_module_list_from_db();
	$module_data = get_module_data_from_db();

	while (list($module_id, $module_name) = each($module_rows))
	{
		$module_name = trim($module_name);

		$module_info = generate_module_info($module_data[$module_id]);

		//
		// Start Time
		//
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;

		$db->num_queries = 0;

		$modules_dir = trim($module_info['dname']);
		$return_limit = $stats_config['return_limit'];

		$module_info = generate_module_info($module_data[$module_id]);
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
		include($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/lang_' . $language . '/lang.' . $phpEx);

		$statistics->result_cache_used = FALSE;
		$statistics->db_cache_used = FALSE;

		$stat_db->begin_cached_query();
		$result_cache->begin_cached_results();
		include($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/module.'.$phpEx);

		$template->set_filenames(array(
			'module_tpl_' . $module_id => './../' . $phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_info['dname'] . '/module.tpl')
		);

		$template->pparse('module_tpl_' . $module_id);

		//
		// End Time
		//
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$endtime = $mtime;
		$totaltime = ($endtime - $starttime);

		$num_queries = $db->num_queries;

		$update_time_recommend = 0;

		if ($totaltime > 0.2)
		{
			$update_time_recommend = round((($totaltime * $num_queries) * 1.5), 0);
		}

		$sql = "UPDATE " . MODULES_TABLE . "
		SET module_cache_time =	0
		WHERE module_id = " . $module_id;

		if (!($result = $db->sql_query($sql)))
		{
			$error = $db->sql_error();
			die('Unable to update Module -> <br />' . $error['message'] . ' -> <br />' . $sql);
		}


		if (!($result = $db->sql_query($sql)))
		{
			$error = $db->sql_error();
			die('Unable to update Module -> <br />' . $error['message'] . ' -> <br />' . $sql);
		}

		print '<span class="gen">Time consumed: ' . $totaltime . ' - Queries executed: ' . $num_queries . '</span><br />';
		print '<br />';

	}
	print '<br /><br /><br /><a href="' . append_sid("admin_statistics.$phpEx?mode=manage") . '">' . $lang['Back_to_management'] . '</a>';
}

//
// Manage Modules
//
if ($mode == 'manage')
{
	$template->set_filenames(array(
		'body' => 'admin/stat_manage_modules.tpl')
	);

	$sql = "SELECT MAX(display_order) as max, MIN(display_order) as min
	FROM " . MODULES_TABLE;

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Unable to get Display Order Informations', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);

	$curr_max = $row['max'];
	$curr_min = $row['min'];

	//
	// Update Module List
	//
	update_module_list();

	$sql = "SELECT *
	FROM " . MODULES_TABLE . "
	ORDER BY display_order ASC";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Unable to get Module Informations', '', __LINE__, __FILE__, $sql);
	}

	$rows = $db->sql_fetchrowset($result);
	$num_rows = $db->sql_numrows($result);

	for ($i = 0; $i < $num_rows; $i++)
	{
		$row_class = ( !($i%2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$module_info = generate_module_info($rows[$i]);
		$move_up = '';
		$move_down = '';
		$edit_install = '';
		$state = '';

		if ($rows[$i]['display_order'] != $curr_min)
		{
			$link = append_sid("admin_statistics.$phpEx?mode=order&amp;move=-15&amp;" . POST_FORUM_URL . "=" . $rows[$i]['module_id']);
			$move_up = '<a href="' . $link . '">' . $lang['Move_up'] . '</a>';
		}

		if ($rows[$i]['display_order'] != $curr_max)
		{
			$link = append_sid("admin_statistics.$phpEx?mode=order&amp;move=15&amp;" . POST_FORUM_URL . "=" . $rows[$i]['module_id']);
			$move_down = '<a href="' . $link . '">' . $lang['Move_down'] . '</a>';
		}

		if (intval($rows[$i]['installed']) == 1)
		{
			$edit_install = '<a href="' . append_sid("admin_statistics.$phpEx?mode=edit&amp;" . POST_FORUM_URL . "=" . $rows[$i]['module_id']) . '">' . $lang['Edit'] . '</a>';
			$edit_install .= '<br /><a href="' . append_sid("admin_statistics.$phpEx?mode=uninstall&amp;" . POST_FORUM_URL . "=" . $rows[$i]['module_id']) . '">' . $lang['Uninstall'] . '</a>';
		}
		else
		{
			$edit_install = '<a href="' . append_sid("admin_statistics.$phpEx?mode=install_activate&amp;" . POST_FORUM_URL . "=" . $rows[$i]['module_id']) . '">' . $lang['Install'] . ' & ' . $lang['Activate'] . '</a>';
			$edit_install .= '<br /><a href="' . append_sid("admin_statistics.$phpEx?mode=install&amp;" . POST_FORUM_URL . "=" . $rows[$i]['module_id']) . '">' . $lang['Install'] . '</a>';
		}

		if (intval($rows[$i]['active']) == 1)
		{
			$state_link = '<a href="' . append_sid("admin_statistics.$phpEx?mode=deactivate&amp;" . POST_FORUM_URL . "=" . $rows[$i]['module_id']) . '" alt="' . $lang['Deactivate'] . '">' . $lang['Active'] . '</a>';
		}
		else if ( (intval($rows[$i]['active']) == 0) && (intval($rows[$i]['installed']) == 1) )
		{
			$state_link = '<a href="' . append_sid("admin_statistics.$phpEx?mode=activate&amp;" . POST_FORUM_URL . "=" . $rows[$i]['module_id']) . '" alt="' . $lang['Activate'] . '">' . $lang['Not_active'] . '</a>';
		}
		else if (intval($rows[$i]['active']) == 0)
		{
			$state_link = $lang['Not_active'];
		}

		$template->assign_block_vars('modulerow', array(
			'ROW_CLASS' => $row_class,
			'NAME' => $module_info['name'],
			'DNAME' => $rows[$i]['name'],
			'U_STATE' => $state_link,
			'UPDATE_TIME' => $rows[$i]['update_time'],
			'U_MOVE_UP' => $move_up,
			'U_MOVE_DOWN' => $move_down,
			'U_EDIT' => $edit_install)
		);
	}

	$template->assign_vars(array(
		'L_STATS_MANAGE' => $lang['Statistics_modules_title'],
		'L_MESSAGES' => $lang['Messages'],
		'L_NAME' => $lang['Module_name'],
		'L_DNAME' => $lang['Directory_name'],
		'L_STATUS' => $lang['Status'],
		'L_UPDATE_TIME' => $lang['Update_time'],
		'L_AUTO_SET' => $lang['Auto_set_update_time'],
		'L_GO' => $lang['Go'],
		'U_AUTO_SET' => append_sid("admin_statistics.$phpEx?mode=auto_set"),

		'MESSAGE' => $message)
	);
}

if ($mode == 'install')
{
	$errored = false;
	$templated = false;

	$sql = "SELECT * FROM " . MODULES_TABLE . "
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to get Module Informations', '', __LINE__, __FILE__, $sql);
	}

	$module_info = generate_module_info($db->sql_fetchrow($result));

	$default_update_time = intval($module_info['default_update_time']);

	// Need to use inline print functions here to take care of dynamic things with the sql parse.
	// A place is made for them to show up fine without taking header time.
	print '<h3>' . $lang['Install'] . ' : ' . $module_info['name'] . '</h4>';
	print '<br />';

	print '<br />Module Name: ' . $module_info['name'];
	print '<br />Module Version: ' . $module_info['version'];
	print '<br />Module Author: ' . $module_info['author'];
	print '<br />Author Email: ' . $module_info['email'];
	print '<br />Author URL: ' . $module_info['url'];
	print '<br /><br /><br />' . $module_info['extra_info'];

	$do_install = TRUE;

	// Lets see if we are allowed to install this one. ;)
	if (!$module_info['condition_result'])
	{
		print '<br /><br />' . $lang['Not_allowed_to_install'] . '<br />';
		$do_install = FALSE;
	}
	else
	{
		$version = str_replace('.', '', $stats_config['version']);
		$version = intval($version);
		$module_version = str_replace('.', '', $module_info['stats_mod_version']);
		$module_version = intval($module_version);

		if ($version < $module_version)
		{
			print '<br /><br />' . sprintf($lang['Wrong_stats_mod_version'], $module_info['stats_mod_version']) . '<br />';
			$do_install = FALSE;
		}
	}

	if ($do_install)
	{
		include($phpbb_root_path.'includes/sql_parse.'.$phpEx);

		$available_dbms = array(
			"mysql" => array(
				"SCHEMA" => "install_mysql",
				"DELIM" => ";",
				"DELIM_BASIC" => ";",
				"COMMENTS" => "remove_remarks"
			),
			"mysql4" => array(
				"SCHEMA" => "install_mysql",
				"DELIM" => ";",
				"DELIM_BASIC" => ";",
				"COMMENTS" => "remove_remarks"
			),
			"mysqli" => array(
				"SCHEMA" => "install_mysql",
				"DELIM" => ";",
				"DELIM_BASIC" => ";",
				"COMMENTS" => "remove_remarks"
			)
		);

		$dbms_file = $phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_info['dname'] . '/' . $available_dbms[$dbms]['SCHEMA'] . '.sql';

		$remove_remarks = $available_dbms[$dbms]['COMMENTS'];;
		$delimiter = $available_dbms[$dbms]['DELIM'];
		$delimiter_basic = $available_dbms[$dbms]['DELIM_BASIC'];

		$sql = true;

		if ( !($fp = @fopen($dbms_file, 'r')) )
		{
	//		print "<br />No SQL File found... expected: " . $dbms_file . "<br />";
			print "<br /><br />No need to install any SQL specific things.<br />";
			$sql = false;
		}

		if ($sql)
		{
			fclose($fp);
			$sql_query = @fread(@fopen($dbms_file, 'r'), @filesize($dbms_file));
			$sql_query = preg_replace('/phpbb_/', $table_prefix, $sql_query);
	
			$sql_query = $remove_remarks($sql_query);
			$sql_query = split_sql_file($sql_query, $delimiter);

			$sql_count = count($sql_query);

			if ($sql_count == 0)
			{
				print "<br />SQL File empty... no need to install any SQL specific things.<br />";
			}

			for($i = 0; $i < $sql_count; $i++)
			{
				print "Running :: " . $sql_query[$i];
				flush();

				if ( !($result = $db->sql_query($sql_query[$i])) )
				{
					$errored = true;
					$error = $db->sql_error();
					print " -> <b>FAILED</b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
				}
				else
				{
					print " -> <b>COMPLETED</b><br /><br />\n\n";
				}
			}
		}

		if (!$errored)
		{
			$sql = "UPDATE " . MODULES_TABLE . "
			SET installed = 1, update_time = " . $default_update_time . "
			WHERE module_id = " . $module_id;

			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Unable to Install Module', '', __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			print '<br><span style="color: red">' . $lang['Module_install_error'] . '</span>';
		}

		if ( (isset($var)) && ($var != '') )
		{
			if ($var == 'activate')
			{
				$sql = "UPDATE " . MODULES_TABLE . "
				SET active = 1
				WHERE module_id = " . $module_id;

				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, 'Unable to Activate Module', '', __LINE__, __FILE__, $sql);
				}

				print '<br>' . $lang['Updated'] . ' : ' . $lang['Activated'] . ' : ' . $module_info['name'];
			}
		}
	}

	print '<br /><br /><br /><a href="' . append_sid("admin_statistics.$phpEx?mode=manage") . '">' . $lang['Back_to_management'] . '</a>';
}

if ($submit && $mode == 'edit')
{
	$auth_value = ( !empty($HTTP_POST_VARS['auth_fields']) ) ? intval($HTTP_POST_VARS['auth_fields']) : 0;

	$sql = "UPDATE " . MODULES_TABLE . "
	SET auth_value = " . $auth_value . "
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to Set Auth Value', '', __LINE__, __FILE__, $sql);
	}

	$sql = "SELECT * FROM " . MODULES_TABLE . "
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to get Module Informations', '', __LINE__, __FILE__, $sql);
	}

	$module_info = generate_module_info($db->sql_fetchrow($result));

	$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Auth_settings_updated'] . ' : ' . $module_info['name'];

	$update_value = ( isset($HTTP_POST_VARS['active']) ) ? intval($HTTP_POST_VARS['active']) : 0;

	if (intval($module_info['active']) != $update_value)
	{
		$sql = "UPDATE " . MODULES_TABLE . "
		SET active = " . intval($update_value) . "
		WHERE module_id = " . $module_id;

		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Unable to change Activation Setting', '', __LINE__, __FILE__, $sql);
		}

		$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Active'] . ' : ' . $module_info['name'];
	}

	$update_value = ( isset($HTTP_POST_VARS['updatetime']) ) ? intval($HTTP_POST_VARS['updatetime']) : 0;

	if (intval($module_info['update_time']) != intval($update_value))
	{
		$sql = "UPDATE " . MODULES_TABLE . "
		SET update_time = " . intval($update_value) . "
		WHERE module_id = " . $module_id;

		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Unable to update Update Time', '', __LINE__, __FILE__, $sql);
		}

		$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Update_time'] . ' : ' . $module_info['name'];
	}

	if ( isset($HTTP_POST_VARS['uninstall']) && (intval($HTTP_POST_VARS['uninstall']) == 0))
	{
		$sql = "UPDATE " . MODULES_TABLE . "
		SET installed = 0, active = 0
		WHERE module_id = " . $module_id;

		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Unable to Uninstall Module', '', __LINE__, __FILE__, $sql);
		}
		$message .= '<br>' . $lang['Updated'] . ' : ' . $lang['Uninstalled'] . ' : ' . $module_info['name'];
	}
}

if ($mode == 'edit')
{
	$template->set_filenames(array(
		'body' => 'admin/stat_edit_module.tpl')
	);

	//
	// Set up Preview Page
	//
	$sql = "SELECT * FROM " . MODULES_TABLE . "
	WHERE module_id = " . $module_id;

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Unable to get Module Informations', '', __LINE__, __FILE__, $sql);
	}

	$module_info = generate_module_info($db->sql_fetchrow($result));
	$module_name = trim($module_info['dname']);

	$auth_value = intval($module_info['auth_value']);

	$template->assign_vars(array(
		'ACTIVE_CHECKED_YES' => (intval($module_info['active']) == 1) ? 'checked="checked"' : '',
		'ACTIVE_CHECKED_NO' => (intval($module_info['active']) == 0) ? 'checked="checked"' : '',
		'UPDATE_TIME' => $module_info['update_time'],
		'MODULE_DNAME' => $module_info['dname'],
		'S_AUTH_SELECT' => gen_auth_select($auth_value),
		'MODULE_NAME' => $module_info['name'])
	);

	//
	// Compile the Module without using cache functions if it's active
	//
	$return_limit = $stats_config['return_limit'];

	//
	// Start Time
	//
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime;

	$db->num_queries = 0;

	$mod_lang = 'module_language_parse';

	$language = $board_config['default_lang'];

	if (!file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $language . '/lang_statistics.' . $phpEx)))
	{
		$language = 'english';
	}
	include($phpbb_root_path . 'language/lang_' . $language . '/lang_statistics.' . $phpEx);

	$language = $board_config['default_lang'];

	if (!file_exists(@phpbb_realpath($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/lang_' . $language . '/lang.' . $phpEx)))
	{
		$language = 'english';
	}
	include($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/lang_' . $language . '/lang.' . $phpEx);

	$statistics->result_cache_used = FALSE;
	$statistics->db_cache_used = FALSE;

	$stat_db->begin_cached_query();
	$result_cache->begin_cached_results();
	include($phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/module.'.$phpEx);

	$template->set_filenames(array(
		'preview' => './../' . $phpbb_root_path . $stats_config['modules_dir'] . '/' . $module_name . '/module.tpl')
	);

	//
	// End Time
	//
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$endtime = $mtime;
	$totaltime = ($endtime - $starttime);

	$num_queries = $db->num_queries;

	$update_time_recommend = 0;

	if ($totaltime > 0.2)
	{
		$update_time_recommend = round((($totaltime * $num_queries) * 1.5), 0);
	}

	$template->assign_vars(array(
		'MESSAGE' => $message,
		'L_ACTIVE' => $lang['Active'],
		'L_ACTIVE_DESC' => $lang['Active_desc'],
		'L_AUTH_SETTINGS' => $lang['Permissions'],
		'L_EDIT' => $lang['Edit'],
		'L_UPDATE_TIME' => $lang['Update_time_minutes'],
		'L_UPDATE_TIME_DESC' => $lang['Update_time_desc'],
		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],
		'L_UNINSTALL' => $lang['Uninstall_module'],
		'L_UNINSTALL_DESC' => $lang['Uninstall_module_desc'],
		'L_MESSAGES' => $lang['Messages'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_PREVIEW' => $lang['Preview'],
		'L_PREVIEW_DEBUG_INFO' => sprintf($lang['Preview_debug_info'], $totaltime, $num_queries),
		'L_UPDATE_TIME_RECOMMEND' => '',
		'L_BACK_TO_MANAGEMENT' => $lang['Back_to_management'],
		'U_MANAGEMENT' => append_sid("admin_statistics.$phpEx?mode=manage"),

		'S_ACTION' => append_sid("admin_statistics.$phpEx?mode=edit&amp;" . POST_FORUM_URL . "=$module_id"))
	);

	$template->assign_var_from_handle('PREVIEW_MODULE', 'preview');
}

$template->assign_vars(array(
	'VIEWED_INFO' => sprintf($lang['Viewed_info'], $stats_config['page_views']),
	'INSTALL_INFO' => '',
	'VERSION_INFO' => sprintf($lang['Version_info'], $stats_config['version']))
);

if ($templated)
{
	$template->pparse('body');

	include('./page_footer_admin.'.$phpEx);
}

?>