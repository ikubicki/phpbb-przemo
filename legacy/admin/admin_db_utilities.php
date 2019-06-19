<?php
/***************************************************************************
*                             admin_db_utilities.php
*                              -------------------
*     begin                : Thu May 31, 2001
*     copyright            : (C) 2001 The phpBB Group
*     email                : support@phpbb.com
*     modification         : (C) 2003 Przemo www.przemo.org/phpBB2/
*     date modification    : ver. 1.12.0 2005/11/11 14:43
*
*     $Id: admin_db_utilities.php,v 1.42.2.11 2005/02/21 18:36:49 acydburn Exp $
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( @$_GET['perform'] == 'restore' || @$_POST['perform'] == 'restore' )
{
	define('MODULE_ID', 72);
}
else if ( @$_GET['perform'] == 'optimize' || @$_POST['perform'] == 'optimize' )
{
	define('MODULE_ID', 73);
}
else
{
	define('MODULE_ID', 48);
}

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['SQL']['Backup_DB'] = $filename . "?perform=backup";
	$module['SQL']['Restore_DB'] = $filename . "?perform=restore";
	$module['SQL']['Optimize_DB'] = $filename . "?perform=optimize";

	return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if( strstr($board_config['main_admin_id'], ',') )
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


if( isset($HTTP_GET_VARS['perform']) || isset($HTTP_POST_VARS['perform']) )
{
	$perform = (isset($HTTP_POST_VARS['perform'])) ? $HTTP_POST_VARS['perform'] : $HTTP_GET_VARS['perform'];

	switch($perform)
	{
		case 'optimize':

			if(!isset($HTTP_POST_VARS['ottimizza']))
			{
				include('./page_header_admin.'.$phpEx);

				$sql = "SHOW TABLE STATUS";

				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, "Couldn't obtain databases list", "", __LINE__, __FILE__, $sql);
				}

				$opt = $db->sql_fetchrowset($result);

				for($i = 0; $i < count($opt); $i++)
				{
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
					$dbsize = $opt[$i]['Data_length'] + $opt[$i]['Index_length']; 

					if( $dbsize >= 1048576 )
					{
						//$dbsize = sprintf("%.2f Mb", ( $dbsize / 1048576 ));
						$dbsize = round(($dbsize / 1048576 ),1)." Mb";
					}
					else if( $dbsize >= 1024 )
					{
						//$dbsize = sprintf("%.2f Kb", ( $dbsize / 1024 ));
						$dbsize = round(($dbsize / 1024 ),1)." Kb";
					}
					else
					{
						//$dbsize = sprintf("%.2f Bytes", $dbsize);
						$dbsize = round($dbsize,1)." Bytes";
					}

					$opt[$i]['Data_free'] != 0 ? $data_free = "No OK" : $data_free = "OK";
					$opt[$i]['Data_free'] != 0 ? $check = "checked" : $check = ""; 

					$template->assign_block_vars("optimize", array(
						"ROW_CLASS" => $row_class,
						"S_SELECT_TABLE" => "<input type=\"checkbox\" name=\"selected_tbl[]\" value=\"" . $opt[$i]['Name'] . "\"" . $check . ">",
						"TABLE" => $opt[$i]['Name'],
						"RECORD" => $opt[$i]['Rows'],
						"TYPE" => $opt[$i]['Type'],
						"SIZE" => $dbsize,
						"STATUS" => $data_free,
						"TOT_TABLE" => $i
						)
					);

					$total_tab = $i +1;
					$total_rec = $total_rec + $opt[$i]['Rows']; 
					$total_size = $total_size + $opt[$i]['Data_length'] + $opt[$i]['Index_length']; 
					if ($data_free == "No OK") $total_stat = "No OK";
				}

				$total_size = round(($total_size / 1048576 ),1)." Mb";
				$total_stat == "No OK" ? $total_stat = "No OK" : $total_stat = "OK";

				$template->set_filenames(array(
						"body" => "admin/db_utils_optimize_body.tpl")
					);

					$s_hidden_fields = "<input type=\"hidden\" name=\"perform\" value=\"$perform\" />";
					if ( $i != 1 )
					{
					$select_scritp = "
					<script language=\"JavaScript\" type=\"text/javascript\">
					// I have copied and modified a script of phpMyAdmin.net
					<!--
					function setCheckboxes(the_form, do_check)
					{
					var elts = (typeof(document.forms[the_form].elements['selected_tbl[]']) != 'undefined') 
					? document.forms[the_form].elements['selected_tbl[]'] 
					: document.forms[the_form].elements = '';
	
					var elts_cnt  = (typeof(elts.length) != 'undefined') ? elts.length : 0;
	
					if (elts_cnt) {
						for (var i = 0; i < elts_cnt; i++) {
							if (do_check == \"invert\"){
							elts[i].checked == true ? elts[i].checked = false : elts[i].checked = true;
							} else {
							elts[i].checked = do_check;
							}
							} // end for
					    } else {
					        elts.checked        = do_check;
					    } // end if... else

					return true;
					}
					//-->
					</script>";
				}
				else
				{
					$select_scritp = "
					<script language=\"JavaScript\" type=\"text/javascript\">
					<!--
					function setCheckboxes(the_form, do_check)
					{
					}
					//-->
					</script>";
				}

				$template->assign_vars(array(
					"SELECT_SCRIPT" => $select_scritp,
					"L_DATABASE_OPTIMIZE" => $lang['Database_Utilities'] . " : " . $lang['Optimize'],
					"L_OPTIMIZE_EXPLAIN" => $lang['Optimize_explain'],
					"L_OPTIMIZE_TABLE" => $lang['Optimize_Table'],
					"L_OPTIMIZE_RECORD" => $lang['Optimize_Record'],
					"L_OPTIMIZE_TYPE" => $lang['Optimize_Type'],
					"L_OPTIMIZE_SIZE" => $lang['Optimize_Size'],
					"L_OPTIMIZE_STATUS" => $lang['Optimize_Status'],
					"TOT_TABLE" => $total_tab,
					"TOT_RECORD" => $total_rec,
					"TOT_SIZE" => $total_size,
					"TOT_STATUS" => $total_stat,
					"L_OPTIMIZE_CHECKALL" => $lang['Mark_all'],
					"L_OPTIMIZE_UNCHECKALL" => $lang['Unmark_all'],
					"L_OPTIMIZE_INVERTCHECKED" => $lang['Optimize_InvertChecked'],
					"L_START_OPTIMIZE" => $lang['Optimize'],
					"S_DBUTILS_ACTION" => append_sid("admin_db_utilities.$phpEx"),
					"S_HIDDEN_FIELDS" => $s_hidden_fields
					)
				);

				$template->pparse("body");

				break;
			}
			else
			{

				include('./page_header_admin.'.$phpEx);

				$sql = "OPTIMIZE TABLE ";

				// make query optimize
				if ($_POST["selected_tbl"] != ""){

				$i=1;
				foreach ($_POST["selected_tbl"] as $var => $value)
				{
					if($i<count($_POST["selected_tbl"]))
					{
						$sql .= "`$value`, ";
					}
					else
					{
						$sql .= "`$value`";
					}
					 $i++;
				} 

			}

			$sql .= " ;";

			if (!$result = $db->sql_query($sql))
			{
				$optimize_notablechecked = true;
			}

			$template->set_filenames(array(
				"body" => "admin/admin_message_body.tpl")
			);

			$optimize_notablechecked == true ? $message = $lang['Optimize_NoTableChecked'] : $message = $lang['Optimize_success'];

			$template->assign_vars(array(
				"MESSAGE_TITLE" => $lang['Database_Utilities'] . " : " . $lang['Optimize'],
				"MESSAGE_TEXT" => $message)
			);

			$template->pparse("body");
			break;

		}

		break;
		
		case 'backup':

			if( isset($HTTP_POST_VARS['update_config']) )
			{
				$HTTP_POST_VARS['db_backup_copies'] = (!(intval($HTTP_POST_VARS['db_backup_copies']))) ? 2 : intval($HTTP_POST_VARS['db_backup_copies']);

				$clear_cache = false;

				$sql = "SELECT *
					FROM " . CONFIG_TABLE ."
					WHERE config_name IN ('db_backup_enable', 'db_backup_copies', 'db_backup_search', 'db_backup_rh')";
				if (!$result = $db->sql_query($sql))
				{
					message_die(CRITICAL_ERROR, 'Could not query config information in admin_board', '', __LINE__, __FILE__, $sql);
				}
				else
				{
					while( $row = $db->sql_fetchrow($result) )
					{
						$config_name = $row['config_name'];
						$config_value = $row['config_value'];

						$default_config[$config_name] = $config_value;

						$new[$config_name] = (isset($HTTP_POST_VARS[$config_name])) ? $HTTP_POST_VARS[$config_name] : str_replace(array("'", "\\"), array("''", "\\\\"), $default_config[$config_name]);

						if ( $config_name == 'server_name' && preg_match('/(.*):\/\//', $new[$config_name],$par) )
						{
							message_die(GENERAL_MESSAGE, sprintf($lang['wrong_config_parametr'],$par[0]));
						}

						$sql_config_value = (isset($HTTP_POST_VARS[$config_name])) ? str_replace("\'", "''", $new[$config_name]) : $new[$config_name];

						$sql = "UPDATE " . CONFIG_TABLE . " SET
							config_value = '$sql_config_value'
							WHERE config_name = '$config_name'";

						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Failed to update general configuration for ' . $config_name, '', __LINE__, __FILE__, $sql);
						}
						$clear_cache = true;
					}

					if ( $clear_cache )
					{
						sql_cache('clear', 'board_config');
					}

					$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_db_utilities.$phpEx") . "&amp;perform=backup\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
					message_die(GENERAL_MESSAGE, $message);
					}

				$sql = "SELECT * FROM " . CONFIG_TABLE . "
					WHERE config_name = 'db_backup_enable'";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get data from config table', '', __LINE__, __FILE__, $sql);
				}
			}

			if ( !($row = $db->sql_fetchrow($result)) )
			{
				$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('db_backup_enable', '0')";
				$db->sql_query($sql);
				$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('db_backup_copies', '2')";
				$db->sql_query($sql);
				$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('db_backup_search', '0')";
				$db->sql_query($sql);
				$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('db_backup_rh', '0')";
				$db->sql_query($sql);
				$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('db_backup_time', '" . CR_TIME . "')";
				$db->sql_query($sql);
			}
			sql_cache('clear', 'board_config');


			include('./page_header_admin.'.$phpEx);

			$template->set_filenames(array(
				'body' => 'admin/db_utils_backup_body.tpl')
			);
			$s_hidden_fields = '<input type="hidden" name="perform" value="backup" /><input type="hidden" name="perform" value="' . $perform . '" />';

			if ( @touch($phpbb_root_path . '/db/db_backup/test') )
			{
				@unlink($phpbb_root_path . '/db/db_backup/test');
				$writable = '<font color="green"><b>/db/db_backup/ - writable - OK</b></font>';
			}
			else
			{
				$writable = '<font color="red"><b>/db/db_backup/ - Not writable !</b></font>';
			}

			$template->assign_vars(array(
				'L_DATABASE_BACKUP' => $lang['Database_Utilities'] . ' : ' . $lang['Backup'],
				'L_BACKUP_EXPLAIN' => $lang['Backup_explain'] . '<br />' . $writable,
				'L_NO' => $lang['No'],
				'L_YES' => $lang['Yes'],
				'L_ENABLE' => $lang['db_backup_enable'],
				'L_COPIES' => $lang['db_backup_copies'],
				'L_TABLES_SEARCH' => $lang['db_backup_tables_search'],
				'L_TABLES_RH' => $lang['db_backup_tables_rh'],
				'L_SUBMIT' => $lang['Submit'],
				'L_LINK' => $lang['db_backup_link'],
				'LAST_BACKUP' => $lang['db_backup_last'] . (($board_config['db_backup_time']) ? create_date($board_config['default_dateformat'], $board_config['db_backup_time'], $board_config['board_timezone']) : $lang['None']),

				'ENABLE_YES_CHECKED' => ($board_config['db_backup_enable']) ? 'checked="checked"' : '',
				'ENABLE_NO_CHECKED' => (!$board_config['db_backup_enable']) ? 'checked="checked"' : '',
				'COPIES' => ($board_config['db_backup_copies']) ? $board_config['db_backup_copies'] : 2,
				'SEARCH_YES_CHECKED' => ($board_config['db_backup_search']) ? 'checked="checked"' : '',
				'SEARCH_NO_CHECKED' => (!$board_config['db_backup_search']) ? 'checked="checked"' : '',
				'RH_YES_CHECKED' => ($board_config['db_backup_rh']) ? 'checked="checked"' : '',
				'RH_NO_CHECKED' => (!$board_config['db_backup_rh']) ? 'checked="checked"' : '',

				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_DBUTILS_ACTION' => append_sid("admin_db_utilities.$phpEx"), true)
			);
			$template->pparse('body');

			break;

		case 'backup_now':

			require($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
			db_backup(true);
			message_die(GENERAL_MESSAGE, $lang['db_backup_done']);

			break;


		case 'restore':

		print '<meta http-equiv="refresh" content="0;url=../dbloader/dbloader.'.$phpEx.'">';

		break;
	}
}

include('./page_footer_admin.'.$phpEx);

?>