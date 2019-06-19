<?php
/***************************************************************************
 *					admin_report.php
 *					-------------------
 *	copyright		: (C) 2002 by saerdnaer
 *	email			: saerdnaer@web.de
 *
 ***************************************************************************/

if ( @$_GET['mode'] == 'config' || @$_POST['mode'] == 'config' )
{
	define('MODULE_ID', 74);
}
else
{
	define('MODULE_ID', 53);
}

define('IN_PHPBB', true);

if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['Report_post']['Configuration'] = "$file?mode=config";
	$module['Report_post']['Permissions'] = "$file?mode=auth";
	return;
}
$phpbb_root_path = '../';

// Load default header
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
}
else
{
	$mode = '';
}

switch($mode)
{
	case 'config':
		$clear_cache = false;
		$sql = "SELECT * FROM " . CONFIG_TABLE . "
			WHERE config_name LIKE 'report_%'";
		if (!$result = $db->sql_query($sql))
		{
			 message_die(GENERAL_ERROR, 'Could not query config information', '', __LINE__, __FILE__, $sql);
		}
		while($row = $db->sql_fetchrow($result))
		{
			$config_name = $row['config_name'];
			$config_value = $row['config_value'];
			$default_config[$config_name] = $config_value;

			$new[$config_name] = (isset($HTTP_POST_VARS[$config_name])) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

			if ( isset($HTTP_POST_VARS['submit']) && $default_config[$config_name] != $new[$config_name] )
			{
				$sql = "UPDATE " . CONFIG_TABLE . " SET
					config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
					WHERE config_name = '$config_name'";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Failed to update configuration for $config_name', '', __LINE__, __FILE__, $sql);
				}
				$clear_cache = true;
			}
		}
		if ( $clear_cache )
		{
			sql_cache('clear', 'board_config');
		}
		if ( isset($HTTP_POST_VARS['submit']) )
		{
			$message = $lang['Report_config_updated'] . '<br /><br />' . sprintf($lang['Click_return_report_config'], '<a href="' . append_sid("admin_report.$phpEx?mode=config") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}

		// create popup links target selection box
		$popup_links_target_select = '<select name="report_popup_links_target">';

		for ( $i = 0; $i < 3; $i++ )
		{
			$selected = $new['report_popup_links_target'] == $i ? ' selected="selected"' : '';
			$popup_links_target_select .= '<option value="' . $i . '"' . $selected . '>' . $lang['Report_popup_links_target_' . $i] . '</option>';
		}
		$popup_links_target_select .= '</select>';

		$template->set_filenames(array(
			'body' => 'admin/report_config_body.tpl')
		);

		$template->assign_vars(array(
			'S_ACTION' => append_sid("admin_report.$phpEx"),
			'S_HIDDEN_FIELDS' => '<input type="hidden" name="mode" value="config" />',

			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'L_CONFIGURATION_TITLE' => $lang['Report_config'],
			'L_CONFIGURATION_EXPLAIN' => $lang['Report_config_explain'],
			'L_SETTINGS' => $lang['General_Config'],
			'L_POPUP_SIZE' => $lang['Report_popup_size'],
			'L_POPUP_SIZE_EXPLAIN' => $lang['Report_popup_size_explain'],
			'L_POPUP_LINKS_TARGET' => $lang['Report_popup_links_target'],
			'L_POPUP_LINKS_TARGET_EXPLAIN' => $lang['Report_popup_links_target_explain'],
			'L_ONLY_ADMIN' => $lang['Report_only_admin'],
			'L_ONLY_ADMIN_EXPLAIN' => $lang['Report_only_admin_explain'],
			'L_NO_GUESTS' => $lang['Report_no_guests'],
			'L_NO_GUESTS_EXPLAIN' => $lang['Report_no_guests_explain'],
			'L_RP_DISABLE' => $lang['Report_post_disable'],

			'L_SUBMIT' => $lang['Submit'],
			'L_RESET' => $lang['Reset'],

			'S_ONLY_ADMIN_YES' => $new['report_only_admin'] ? 'checked="checked"' : '',
			'S_ONLY_ADMIN_NO' => !$new['report_only_admin'] ? 'checked="checked"' : '',
			'S_NO_GUESTS_YES' => $new['report_no_guestes'] ? 'checked="checked"' : '',
			'S_NO_GUESTS_NO' => !$new['report_no_guestes'] ? 'checked="checked"' : '',

			'POPUP_HEIGHT' => $new['report_popup_height'],
			'POPUP_WIDTH' => $new['report_popup_width'],
			'POPUP_LINKS_TARGET_SELECT' => $popup_links_target_select,
			'RP_DISABLE_YES' => $new['report_disable'] ? 'checked="checked"' : '',
			'RP_DISABLE_NO' => !$new['report_disable'] ? 'checked="checked"' : '')
		);
		$template->pparse('body');
	break;
	case 'auth':
		if ( isset($HTTP_POST_VARS['submit']) && isset($HTTP_POST_VARS['type']) &&  isset($HTTP_POST_VARS['ug']) && isset($HTTP_POST_VARS['action']) )
		{
			if ( $HTTP_POST_VARS['type'] )
			{
				$auth = 'report_disabled_';
			}
			else
			{
				$auth = 'report_no_auth_';
			}
			if ( $HTTP_POST_VARS['ug'] )
			{
				$auth .= 'groups';
				$id = !empty($HTTP_POST_VARS['id']) ? $HTTP_POST_VARS['id'] : 0;
				if ( empty($id) )
				{
					message_die(GENERAL_ERROR, $lang['No_group_specified']);
				}
			}
			else
			{
				$auth .= 'users';
				$id = !empty($HTTP_POST_VARS['id']) ? $HTTP_POST_VARS['id'] : ( !empty($HTTP_POST_VARS['username']) ? $HTTP_POST_VARS['username'] : '' );
				if ( empty($id) )
				{
					message_die(GENERAL_ERROR, $lang['No_user_specified']);
				}
				if ( !empty($id) && !is_int($id) && !is_array($id) )
				{
					$sql = "SELECT user_id FROM " . USERS_TABLE . "
						WHERE user_id <> '-1'
							AND username = '$id'";
					if (!$result = $db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not get user_id', '', __LINE__, __FILE__, $sql);
					}
					if ( !($row = $db->sql_fetchrow($result)) )
					{
						message_die(GENERAL_ERROR, $lang['No_user_id_specified']);
					}
					$id = $row['user_id'];
				}
				if ( empty($id) || $id == ANONYMOUS )
				{
					message_die(GENERAL_ERROR, $lang['No_user_specified']);
				}
			}
			$auth_array = explode(',', $board_config[$auth]);
			if ( $HTTP_POST_VARS['action'] )
			{
				if ( in_array($id, $auth_array) )
				{
					 message_die(GENERAL_ERROR, $lang['Report_already_auth']);
				}
				$auth_array[ (empty($auth_array[0]) ? 0 : '') ] = $id;
				$new_auth = implode(',', $auth_array);
			}
			else
			{
				$new_auth = '';
				for ( $i = 0; $i < count($auth_array); $i++ )
				{
					if ( !in_array($auth_array[$i], $id) )
					{
						$new_auth .= ( empty($new_auth) ? '' : ',' ) . $auth_array[$i];
					}
				}
			}
			update_config($auth, $new_auth);
			message_die(GENERAL_MESSAGE, $lang['Auth_updated'] . '<br /><br />' . sprintf($lang['Click_return_report_auth'], '<a href="' . append_sid("admin_report.$phpEx?mode=auth&amp;type=" . $HTTP_POST_VARS['type'] . "&amp;ug=" . $HTTP_POST_VARS['ug'] ) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_report_auth_select'], '<a href="' . append_sid("admin_report.$phpEx?mode=auth") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>') );
		}
		else
		{
			if ( isset($HTTP_GET_VARS['ug']) && isset($HTTP_GET_VARS['type']) )
			{
				$ug = isset($HTTP_GET_VARS['ug']) ? intval($HTTP_GET_VARS['ug']) : 0;
				$type = isset($HTTP_GET_VARS['type']) ? intval($HTTP_GET_VARS['type']) : 0;
				if ( $type )
				{
					$auth = 'report_disabled_';
				}
				else
				{
					$auth = 'report_no_auth_';
				}
				if ( $ug )
				{
					$auth .= 'groups';
					$ug_select = '<select name="id[]" multiple="multiple" size="5">';
					if ( !empty($board_config[$auth]) )
					{
						$sql = "SELECT group_id, group_name FROM " . GROUPS_TABLE . "
							WHERE group_id IN ($board_config[$auth])
								ORDER BY group_name ASC";
						if (!$result = $db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not get ' . $auth, '', __LINE__, __FILE__, $sql);
						}
						while ( $row = $db->sql_fetchrow($result) )
						{
							$ug_select .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
						}
						$where_sql = "AND group_id NOT IN (" . $board_config[$auth] . ")";
					}
					else
					{
						$ug_select .= '<option value="-1">' . $lang['None'] . '</option>';
						$where_sql = '';
					}
					$ug_select .= '</select>';

					$group_select = '<select name="id">';
					$sql = "SELECT group_id, group_name FROM " . GROUPS_TABLE . "
						WHERE group_single_user <> 1
							$where_sql
							ORDER BY group_name ASC";
					if (!$result = $db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not get ' . $auth . ' list', '', __LINE__, __FILE__, $sql);
					}
					if ( $db->sql_numrows($result) > 0 )
					{
						while ( $row = $db->sql_fetchrow($result) )
						{
							$group_select .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
						}
					}
					else
					{
						$group_select .= '<option value="-1">' . $lang['No_groups_exist'] . '</option>';
					}
					$group_select .= '</select>';

				}
				else
				{
					$auth .= 'users';
					$ug_select = '<select name="id[]" multiple="multiple" size="5">';
					if ( !empty($board_config[$auth]) )
					{
						$sql = "SELECT user_id, username FROM " . USERS_TABLE . "
							WHERE user_id IN ($board_config[$auth])
								ORDER BY username ASC";
						if (!$result = $db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not get ' . $auth, '', __LINE__, __FILE__, $sql);
						}
						while ( $row = $db->sql_fetchrow($result) )
						{
							$ug_select .= '<option value="' . $row['user_id'] . '">' . $row['username'] . '</option>';
						}
					}
					else
					{
						$ug_select .= '<option value="-1">' . $lang['None'] . '</option>';
					}
					$ug_select .= '</select>';
					$group_select = '';
				}

				$template->set_filenames(array(
					'body' => 'admin/report_auth_body.tpl')
				);

				$template->assign_block_vars('switch_' . ( $ug ? 'group' : 'user' ), array());

				$s_hidden_fields  = '<input type="hidden" name="mode" value="auth"/>';
				$s_hidden_fields .= '<input type="hidden" name="type" value="' . $type . '"/>';
				$s_hidden_fields .= '<input type="hidden" name="ug" value="' . $ug . '"/>';
				$template->assign_vars(array(
					'L_TITLE' => $lang['Permissions'] . ' - ' . $lang[ 'Report_' . ( $type ? 'disable' : 'no_auth') ] . ' - ' . $lang[ $ug ? 'Groups' : 'Users' ],
					'L_EXPLAIN' => $lang[ 'Report_' . ( $type ? 'no_auth' : 'disable') . '_explain' ],
					'L_ACTION_0' => $lang['Remove'],
					'L_ACTION_1' => $lang['Add_new'],
					'L_UG' => $ug ? $lang['Look_up_Group'] : $lang['Look_up_User'],
					'L_UG_SELECT_EXPLAIN' => $lang['Report_auth_field_explain'],
					'L_BAN_GROUP' => $lang['Ban_group'],
					'L_BAN_GROUP_EXPLAIN' => $lang['Ban_group_explain'],
					'L_UNBAN_USER' => $lang['Unban_user'],
					'L_UNBAN_GROUP' => $lang['Unban_group'],
					'L_ADD' => $lang['Add_new'],
					'L_REMOVE' => $lang['Remove'],
					'L_FIND_USERNAME' => $lang['Find_username'],
					'L_BACK' => $lang['Back'],

					'UG_SELECT' => $ug_select,
					'GROUP_SELECT' => $group_select,
					'S_ACTION' => append_sid("admin_report.$phpEx"),
					'S_HIDDEN_FIELDS' => $s_hidden_fields,
					'U_SEARCH_USER' => append_sid("../search.$phpEx?mode=searchuser"),
					'U_BACK' => append_sid("admin_report.$phpEx?mode=auth"))
				);
				$template->pparse('body');
			}
			else
			{
				$template->set_filenames(array(
					'body' => 'admin/report_auth_select_body.tpl')
				);

				$template->assign_vars(array(
					'L_TITLE' => $lang['Permissions'],
					'L_EXPLAIN' => $lang['Report_permissions_explain'],
					'L_MANAGE_USERS' => $lang['Memberlist'],
					'L_MANAGE_GROUPS' => $lang['Usergroups'],
					'L_NO_AUTH' => $lang['Report_no_auth'],
					'L_DISABLE' => $lang['Report_disable'],

					'U_NO_AUTH_USER' => append_sid("admin_report.$phpEx?mode=auth&amp;type=0&amp;ug=0"),
					'U_NO_AUTH_GROUP' => append_sid("admin_report.$phpEx?mode=auth&amp;type=0&amp;ug=1"),
					'U_DISABLE_USER' => append_sid("admin_report.$phpEx?mode=auth&amp;type=1&amp;ug=0"),
					'U_DISABLE_GROUP' => append_sid("admin_report.$phpEx?mode=auth&amp;type=1&amp;ug=1"))
				);
				$template->pparse('body');
			}
		}
		break;
}

include('page_footer_admin.'.$phpEx);

?>