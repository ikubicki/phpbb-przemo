<?php
/***************************************************************************
 *              admin_board_setup.php
 *              -------------------
 *  begin       : Tuesday, Jul 17, 2006
 *  copyright   : (C) 2003 Przemo ( http://www.przemo.org/phpBB2/ )
 *  email       : przemo@przemo.org
 *  version     : 1.12.0
 *
 ***************************************************************************/

define('MODULE_ID', 1);

define('IN_PHPBB', 1);

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

include($phpbb_root_path . 'admin/board_setup_defaults.'.$phpEx);

define('SAVED_TABLE', $table_prefix . 'config_saved');

//	print_r($config_tables);
if ( isset($HTTP_POST_VARS['action']) )
{
	if ( isset($HTTP_POST_VARS['save']) )
	{
		$sql = "SELECT COUNT(*) as total
			FROM " . SAVED_TABLE;
		if (!$result = $db->sql_query($sql))
		{
			$sql = "CREATE TABLE " . SAVED_TABLE . " ( 
				config_date int(11) default '0' NOT NULL,
				config_value longtext,
				PRIMARY KEY (config_date)) DEFAULT CHARSET latin2 COLLATE latin2_general_ci;";
			if ( !($db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not create config_saved table', '', __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$row = $db->sql_fetchrow($result);
			if ( $row['total'] > 30 )
			{
				$sql = "DELETE
					FROM " . SAVED_TABLE;
				if ( !($db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not delete from config_saved table', '', __LINE__, __FILE__, $sql);
				}
			}
		}

		$config_tables_sql = $field_array = array();
		foreach( $config_tables as $table => $data )
		{
			if ( $table == 'config' )
			{
				$current_data = $board_config;
			}
			else if ( $table == 'attachments_config' )
			{
				$current_data = $attach_config;
			}
			else
			{
				$current_data = $$table;
			}

			$field_array[$table] = array();

			foreach( $data as $field => $val )
			{
				$field_array[$table][$field] = preg_replace('/[\\\]+\'/', "'", $current_data[$field]);
			}
		}
		$sql = "INSERT INTO " . SAVED_TABLE . " (config_date, config_value) 
			VALUES(" . CR_TIME . ", '" . str_replace("'", "''", serialize($field_array)) . "')";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not save current settings.", "",__LINE__, __FILE__, xhtmlspecialchars($sql));
		}
	}
	else if ( isset($HTTP_POST_VARS['default']) || isset($HTTP_POST_VARS['simple']) || isset($HTTP_POST_VARS['full']) )
	{
		if ( isset($HTTP_POST_VARS['default']) )
		{
			$val_num = 0;
		}
		else if ( isset($HTTP_POST_VARS['full']) )
		{
			$val_num = 1;
		}
		else if ( isset($HTTP_POST_VARS['simple']) )
		{
			$val_num = 2;
		}

		$sql = array();
		foreach( $config_tables as $table => $data )
		{
			foreach( $data as $field => $val )
			{
				if ( $val[$val_num] !== 'IGNORE' )
				{
					$sql = "UPDATE " . $table_prefix . $table . "
						SET config_value = '" . str_replace("'", "''", $val[$val_num]) . "'
						WHERE config_name = '$field'";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, "Could not update settings for table: <b>$table</b> and field: <b>$field</b><br />Value: " . xhtmlspecialchars($val[$val_num]), "",__LINE__, __FILE__, xhtmlspecialchars($sql));
					}
				}
			}
		}
	}
	else if ( isset($HTTP_POST_VARS['saved']) )
	{
		$sql = "SELECT MAX(config_date) as last_date
			FROM " . SAVED_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not get last saved configuration data",__LINE__, __FILE__, $sql);
		}
		if ( !($row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_ERROR, "Could not get last saved configuration data",__LINE__, __FILE__, $sql);
		}
		if ( $row['last_date'] > 10000 )
		{
			$sql = "SELECT config_value
				FROM " . SAVED_TABLE . "
				WHERE config_date = " . $row['last_date'];
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Could not get last saved configuration data",__LINE__, __FILE__, $sql);
			}
			if ( !($row = $db->sql_fetchrow($result)) )
			{
				message_die(GENERAL_ERROR, "Could not get last saved configuration data",__LINE__, __FILE__, $sql);
			}
			$last_value = unserialize($row['config_value']);

			foreach( $last_value as $table => $data )
			{
				foreach( $data as $field => $val )
				{
					$sql = "UPDATE " . $table_prefix . $table . "
						SET config_value = '" . str_replace("'", "''", $val) . "'
						WHERE config_name = '$field'";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, "Could not update settings for table: <b>$table</b> and field: <b>$field</b><br />Value: " . xhtmlspecialchars($val[$val_num]), "",__LINE__, __FILE__, $sql);
					}
				}
			}
		}
	}
	sql_cache('clear', 'board_config');
	sql_cache('clear', 'shoutbox_config');
	sql_cache('clear', 'attach_config');

	$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_board.$phpEx?mode=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	message_die(GENERAL_MESSAGE, $message);
}

$template->assign_vars(array(
	'S_CONFIG_ACTION' => append_sid("admin_board_setup.$phpEx"),

	'L_DEFAULT_CONFIG' => $lang['Default_config'],
	'L_SIMPLE_CONFIG' => $lang['Max_config'],
	'L_FULL_CONFIG' => $lang['Min_config'],
	'L_SAVE_CONFIG' => $lang['Save_config'],
	'L_CONFIGURATION_E' => $lang['Config_setup_e'],
	'L_CONFIGURATION_TITLE' => $lang['Config_setup'])
);

$sql = "SELECT MAX(config_date) as last_date
	FROM " . SAVED_TABLE;
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
if ( $row['last_date'] > 10000 )
{
	$template->assign_block_vars('saved', array(
		'L_SAVED_CONFIG' => sprintf($lang['Saved_config'], create_date($board_config['default_dateformat'], $row['last_date'], $board_config['board_timezone'])))
	);
}

$template->set_filenames(array(
	'body' => 'admin/board_setup_config.tpl')
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>