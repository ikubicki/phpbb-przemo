<?php
/***************************************************************************
 *                             admin_groups.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2003 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.0 2005/11/11 14:51
 *
 *   $Id: admin_groups.php,v 1.25.2.9 2004/03/25 15:57:20 acydburn Exp $
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
define('MODULE_ID', 28);
define('IN_PHPBB', 1);

if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Groups']['Manage'] = $filename;

	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ( isset($HTTP_POST_VARS[POST_GROUPS_URL]) || isset($HTTP_GET_VARS[POST_GROUPS_URL]) )
{
	$group_id = ( isset($HTTP_POST_VARS[POST_GROUPS_URL]) ) ? intval($HTTP_POST_VARS[POST_GROUPS_URL]) : intval($HTTP_GET_VARS[POST_GROUPS_URL]);
}
else
{
	$group_id = 0;
}

if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = xhtmlspecialchars($mode);
}
else
{
	$mode = '';
}

$group_add_posts = ($HTTP_POST_VARS['group_add_posts']) ? intval($HTTP_POST_VARS['group_add_posts']) : 0;

if ( defined('ATTACHMENTS_ON') ) attachment_quota_settings('group', $HTTP_POST_VARS['group_update'], $mode);
if ( isset($HTTP_POST_VARS['edit']) || isset($HTTP_POST_VARS['new']) )
{
	//
	// Ok they are editing a group or creating a new group
	//
	$template->set_filenames(array(
		'body' => 'admin/group_edit_body.tpl')
	);

	if ( isset($HTTP_POST_VARS['edit']) )
	{
		//
		// They're editing. Grab the vars.
		//
		$sql = "SELECT *
			FROM " . GROUPS_TABLE . "
			WHERE group_single_user <> " . TRUE . "
			AND group_id = $group_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
		}

		if ( !($group_info = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, $lang['Group_not_exist']);
		}

		$mode = 'editgroup';
		$template->assign_block_vars('group_edit', array());

	}
	else if ( isset($HTTP_POST_VARS['new']) )
	{
		$group_info = array (
			'group_name' => '',
			'group_description' => '',
			'group_moderator' => '',
			'group_count' => '99999999',
			'group_count_enable' => '0',
			'group_mail_enable' => '0',
			'group_no_unsub' => '0',
			'group_color' => '',
			'group_prefix' => '',
			'group_style' => '',
			'group_type' => GROUP_OPEN);
		$group_open = ' checked="checked"';

		$mode = 'newgroup';
	}

	//
	// Ok, now we know everything about them, let's show the page.
	//
	$sql = "SELECT user_id, username
		FROM " . USERS_TABLE . "
		WHERE user_id <> " . ANONYMOUS . "
		ORDER BY username";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user info for moderator list', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['user_id'] == $group_info['group_moderator'] )
		{
			$group_moderator = $row['username'];
		}
	}

	$group_open = ( $group_info['group_type'] == GROUP_OPEN ) ? ' checked="checked"' : '';
	$group_closed = ( $group_info['group_type'] == GROUP_CLOSED ) ? ' checked="checked"' : '';
	$group_hidden = ( $group_info['group_type'] == GROUP_HIDDEN ) ? ' checked="checked"' : '';
	$group_count_enable_checked = ( $group_info['group_count_enable'] ) ? ' checked="checked"' : '';
	$group_mail_enable_checked = ( $group_info['group_mail_enable'] ) ? ' checked="checked"' : '';
	$group_no_unsub_checked = ( $group_info['group_no_unsub'] ) ? ' checked="checked"' : '';

	$s_hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" />';

	$template->assign_vars(array(
		'GROUP_NAME' => xhtmlspecialchars($group_info['group_name']),
		'GROUP_DESCRIPTION' => xhtmlspecialchars($group_info['group_description']),
		'GROUP_MODERATOR' => $group_moderator,
		'GROUP_COUNT' => $group_info['group_count'],
		'GROUP_COLOR' => ($group_info['group_color']) ? $group_info['group_color'] . '" style="color: #' . $group_info['group_color'] : '',
		'GROUP_PREFIX' => $group_info['group_prefix'],
		'GROUP_STYLE' => $group_info['group_style'],
		'GROUP_COUNT_ENABLE_CHECKED' => $group_count_enable_checked,
		'GROUP_MAIL_ENABLE_CHECKED' => $group_mail_enable_checked,
		'GROUP_NO_UNSUB_CHECKED' => $group_no_unsub_checked,

		'L_GROUP_COUNT' => $lang['group_count'],
		'L_GROUP_COUNT_EXPLAIN' => $lang['group_count_explain'],
		'L_GROUP_COUNT_ENABLE' => $lang['Group_count_enable'],
		'L_GROUP_MAIL_ENABLE' => $lang['Group_mail_enable'],
		'L_GROUP_NO_UNSUB' => $lang['Group_no_unsub'],
		'L_GROUP_COUNT_UPDATE' => $lang['Group_count_update'],
		'L_GROUP_COUNT_DELETE' => $lang['Group_count_delete'],
		'L_GROUP_TITLE' => $lang['Group_administration'],
		'L_GROUP_EDIT_DELETE' => ( isset($HTTP_POST_VARS['new']) ) ? $lang['New_group'] : $lang['Edit_group'],
		'L_GROUP_NAME' => $lang['group_name'],
		'L_GROUP_DESCRIPTION' => $lang['group_description'],
		'L_GROUP_MODERATOR' => $lang['group_moderator'],
		'L_FIND_USERNAME'	 => $lang['Find_username'],
		'L_GROUP_STATUS' => $lang['group_status'],
		'L_GROUP_OPEN' => $lang['group_open'],
		'L_GROUP_CLOSED' => $lang['group_closed'],
		'L_GROUP_HIDDEN' => $lang['group_hidden'],
		'L_GROUP_DELETE' => $lang['group_delete'],
		'L_GROUP_DELETE_CHECK' => $lang['group_delete_check'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_DELETE_MODERATOR' => $lang['delete_group_moderator'],
		'L_DELETE_MODERATOR_EXPLAIN' => $lang['delete_moderator_explain'],
		'L_YES' => $lang['Yes'],
		'L_GROUP_COLOR' => $lang['Font_color'],
		'L_GROUP_PREFIX' => $lang['Group_prefix'],
		'L_GROUP_STYLE' => $lang['Group_style'],
		'L_GROUP_COLOR_E' => $lang['Groups_color_explain'],
		'L_EXAMPLES' => $lang['Styles'],

		'U_SEARCH_USER' => append_sid("../search.$phpEx?mode=searchuser"),

		'S_GROUP_OPEN_TYPE' => GROUP_OPEN,
		'S_GROUP_CLOSED_TYPE' => GROUP_CLOSED,
		'S_GROUP_HIDDEN_TYPE' => GROUP_HIDDEN,
		'S_GROUP_OPEN_CHECKED' => $group_open,
		'S_GROUP_CLOSED_CHECKED' => $group_closed,
		'S_GROUP_HIDDEN_CHECKED' => $group_hidden,
		'S_GROUP_ACTION' => append_sid("admin_groups.$phpEx"),
		'S_HIDDEN_FIELDS' => $s_hidden_fields)
	);

	$template->pparse('body');

}
else if ( isset($HTTP_POST_VARS['group_update']) )
{
	//
	// Ok, they are submitting a group, let's save the data based on if it's new or editing
	//
	if ( isset($HTTP_POST_VARS['group_delete']) )
	{
		//
		// Reset User Moderator Level
		//

		// Is Group moderating a forum ?
		$sql = "SELECT auth_mod FROM " . AUTH_ACCESS_TABLE . " 
			WHERE group_id = " . $group_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select auth_access', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		if (intval($row['auth_mod']) == 1)
		{
			// Yes, get the assigned users and update their Permission if they are no longer moderator of one of the forums
			$sql = "SELECT user_id FROM " . USER_GROUP_TABLE . "
				WHERE group_id = " . $group_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select user_group', '', __LINE__, __FILE__, $sql);
			}

			$rows = $db->sql_fetchrowset($result);
			for ($i = 0; $i < count($rows); $i++)
			{
				$sql = "SELECT g.group_id FROM (" . AUTH_ACCESS_TABLE . " a, " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug)
				WHERE a.auth_mod = 1
					AND g.group_id = a.group_id
					AND a.group_id = ug.group_id
					AND g.group_id = ug.group_id
					AND ug.user_id = " . intval($rows[$i]['user_id']) . "
					AND ug.group_id <> " . $group_id;
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain moderator permissions', '', __LINE__, __FILE__, $sql);
				}

				if ($db->sql_numrows($result) == 0)
				{
					$sql = "UPDATE " . USERS_TABLE . " SET user_level = " . USER . " 
					WHERE user_level = " . MOD . " AND user_id = " . intval($rows[$i]['user_id']);
					
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update moderator permissions', '', __LINE__, __FILE__, $sql);
					}
				}
			}
		}

		$sql = "DELETE FROM " . GROUPS_TABLE . "
			WHERE group_id = " . $group_id;
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update group', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . USER_GROUP_TABLE . "
			WHERE group_id = " . $group_id;
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update user_group', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
			WHERE group_id = " . $group_id;
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update auth_access', '', __LINE__, __FILE__, $sql);
		}

		sql_cache('clear', 'groups_desc');
		sql_cache('clear', 'user_groups');
		sql_cache('clear', 'groups_data');
		sql_cache('clear', 'moderators_list');

		$message = $lang['Deleted_group'] . '<br /><br />' . sprintf($lang['Click_return_groupsadmin'], '<a href="' . append_sid("admin_groups.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}
	else
	{
		$group_type = isset($HTTP_POST_VARS['group_type']) ? intval($HTTP_POST_VARS['group_type']) : GROUP_OPEN;
		$group_name = isset($HTTP_POST_VARS['group_name']) ? trim($HTTP_POST_VARS['group_name']) : '';
		$group_description = isset($HTTP_POST_VARS['group_description']) ? trim($HTTP_POST_VARS['group_description']) : '';
		$group_moderator = isset($HTTP_POST_VARS['username']) ? $HTTP_POST_VARS['username'] : '';
		$delete_old_moderator = isset($HTTP_POST_VARS['delete_old_moderator']) ? true : false;
		$group_count = isset($HTTP_POST_VARS['group_count']) ? intval($HTTP_POST_VARS['group_count']) : 0;
		$group_count_enable = isset($HTTP_POST_VARS['group_count_enable']) ? 1 : 0;
		$group_color = isset($HTTP_POST_VARS['group_color']) ? $HTTP_POST_VARS['group_color'] : '';
		$group_prefix = isset($HTTP_POST_VARS['group_prefix']) ? xhtmlspecialchars($HTTP_POST_VARS['group_prefix']) : '';
		$group_style = isset($HTTP_POST_VARS['group_style']) ? xhtmlspecialchars($HTTP_POST_VARS['group_style']) : '';
		$group_mail_enable = isset($HTTP_POST_VARS['group_mail_enable']) ? 1 : 0;
		$group_no_unsub = isset($HTTP_POST_VARS['group_no_unsub']) ? true : false;
		$group_count_update = isset($HTTP_POST_VARS['group_count_update']) ? true : false;
		$group_count_delete = isset($HTTP_POST_VARS['group_count_delete']) ? true : false;

		if ( $group_name == '' )
		{
			message_die(GENERAL_MESSAGE, $lang['No_group_name']);
		}
		else if ( $group_moderator == '' )
		{
			message_die(GENERAL_MESSAGE, $lang['No_group_moderator']);
		}

		$this_userdata = get_userdata($group_moderator, true);
		$group_moderator = $this_userdata['user_id'];

		if ( !$group_moderator )
		{
			message_die(GENERAL_MESSAGE, $lang['No_group_moderator']);
		}

		if( $mode == "editgroup" )
		{
			$sql = "SELECT *
				FROM " . GROUPS_TABLE . "
				WHERE group_single_user <> " . TRUE . "
				AND group_id = " . $group_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
			}

			if( !($group_info = $db->sql_fetchrow($result)) )
			{
				message_die(GENERAL_MESSAGE, $lang['Group_not_exist']);
			}

			if ( $group_info['group_moderator'] != $group_moderator )
			{
				if ( $delete_old_moderator )
				{
					$sql = "DELETE FROM " . USER_GROUP_TABLE . "
						WHERE user_id = " . $group_info['group_moderator'] . "
							AND group_id = " . $group_id;
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update group moderator', '', __LINE__, __FILE__, $sql);
					}
				}

				$sql = "SELECT user_id
					FROM " . USER_GROUP_TABLE . "
					WHERE user_id = $group_moderator
						AND group_id = $group_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Failed to obtain current group moderator info', '', __LINE__, __FILE__, $sql);
				}

				if ( !($row = $db->sql_fetchrow($result)) )
				{
					$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending)
						VALUES (" . $group_id . ", " . $group_moderator . ", 0)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update group moderator', '', __LINE__, __FILE__, $sql);
					}
				}
			}

			$sql = "UPDATE " . GROUPS_TABLE . "
				SET group_type = $group_type, group_name = '" . str_replace("\'", "''", $group_name) . "', group_description = '" . str_replace("\'", "''", $group_description) . "', group_moderator = $group_moderator, group_count='$group_count', group_count_enable='$group_count_enable', group_mail_enable='$group_mail_enable', group_no_unsub='$group_no_unsub' , group_color = '" . str_replace("\'", "''", $group_color) . "', group_prefix = '" . str_replace("\'", "''", $group_prefix) . "', group_style = '" . str_replace("\'", "''", $group_style) . "'
				WHERE group_id = $group_id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update group', '', __LINE__, __FILE__, $sql);
			}
			if ($group_count_delete)
			{
				//removing old users
				$sql = "DELETE FROM " . USER_GROUP_TABLE . "
					WHERE group_id = $group_id 
					AND user_id NOT IN ('$group_moderator','".ANONYMOUS."')";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not remove users, group count', '', __LINE__, __FILE__, $sql);
				}
				$group_count_remove=$db->sql_affectedrows();
			}
			if ( $group_count_update)
			{
				//finding new users
				$sql = "SELECT u.user_id FROM " . USERS_TABLE . " u
					LEFT JOIN " . USER_GROUP_TABLE ." ug ON (u.user_id = ug.user_id AND ug.group_id = '$group_id')
					WHERE u.user_posts >= '$group_add_posts'
					AND ug.group_id is NULL
					AND u.user_id NOT IN ('$group_moderator','".ANONYMOUS."')";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, $sql.'Could not select new users, group count', '', __LINE__, __FILE__, $sql);
				}
				//inserting new users
				$group_count_added=0;
				while ( ($new_members = $db->sql_fetchrow($result)) )
				{
					$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending) 
						VALUES ($group_id, " . $new_members['user_id'] . ", 0)";
					if ( !($result2 = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Error inserting user group, group count', '', __LINE__, __FILE__, $sql);
					}
					$group_count_added++;
				}
			}

			sql_cache('clear', 'groups_desc');
			sql_cache('clear', 'user_groups');
			sql_cache('clear', 'groups_data');
			sql_cache('clear', 'moderators_list');

			$message = $lang['Updated_group'] . '<br />'.sprintf($lang['group_count_update'],$group_count_remove,$group_count_added).'<br /><br />' . sprintf($lang['Click_return_groupsadmin'], '<a href="' . append_sid("admin_groups.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');;

			message_die(GENERAL_MESSAGE, $message);
		}
		else if( $mode == 'newgroup' )
		{
			$sql = "SELECT MAX(group_order) AS max_order
				FROM " . GROUPS_TABLE . "
				WHERE group_single_user = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert new group', '', __LINE__, __FILE__, $sql);
			}
			$group_order = $db->sql_fetchrow($result);
			$group_order = $group_order['max_order'] + 1;
			$sql = "INSERT INTO " . GROUPS_TABLE . " (group_type, group_name, group_description, group_moderator, group_count, group_count_enable, group_mail_enable, group_no_unsub, group_single_user, group_order, group_color, group_prefix, group_style)
				VALUES ($group_type, '" . str_replace("\'", "''", $group_name) . "', '" . str_replace("\'", "''", $group_description) . "', $group_moderator, '$group_count', '$group_count_enable', '$group_mail_enable', '$group_no_unsub', '0', $group_order, '" . str_replace("\'", "''", $group_color) . "', '" . str_replace("\'", "''", $group_prefix) . "', '" . str_replace("\'", "''", $group_style) . "')";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not insert new group', '', __LINE__, __FILE__, $sql);
			}
			$new_group_id = $db->sql_nextid();

			$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending)
				VALUES ($new_group_id, $group_moderator, 0)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not insert new user-group info', '', __LINE__, __FILE__, $sql);
			}
			if ($group_count_delete)
			{
				//removing old users
				$sql = "DELETE FROM " . USER_GROUP_TABLE . "
					WHERE group_id=$new_group_id 
					AND user_id NOT IN ('$group_moderator','".ANONYMOUS."')";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not remove users, group count', '', __LINE__, __FILE__, $sql);
				}
				$group_count_remove=$db->sql_affectedrows();
			}
			if ( $group_count_update)
			{
				//finding new users
				$sql = "SELECT u.user_id FROM " . USERS_TABLE . " u
					LEFT JOIN " . USER_GROUP_TABLE ." ug ON (u.user_id = ug.user_id AND ug.group_id = '$new_group_id')
					WHERE u.user_posts >= '$group_add_posts'
					AND ug.group_id is NULL
					AND u.user_id NOT IN ('$group_moderator','".ANONYMOUS."')";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, $sql.'Could not select new users, group count', '', __LINE__, __FILE__, $sql);
				}
				//inserting new users
				$group_count_added=0;
				while ( ($new_members = $db->sql_fetchrow($result)) )
				{
					$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending) 
						VALUES ($new_group_id, " . $new_members['user_id'] . ", 0)";
					if ( !($result2 = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Error inserting user group, group count', '', __LINE__, __FILE__, $sql);
					}
					$group_count_added++;
				}
			}

			sql_cache('clear', 'groups_desc');
			sql_cache('clear', 'user_groups');
			sql_cache('clear', 'groups_data');
			sql_cache('clear', 'moderators_list');

			$message = $lang['Added_new_group'] . '<br />'.sprintf($lang['group_count_update'],$group_count_remove,$group_count_added).'<br /><br />' . sprintf($lang['Click_return_groupsadmin'], '<a href="' . append_sid("admin_groups.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');;

			message_die(GENERAL_MESSAGE, $message);

		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['No_group_action']);
		}
	}
}
else
{
	$sql = "SELECT group_id, group_name
		FROM " . GROUPS_TABLE . "
		WHERE group_single_user <> " . TRUE . "
		ORDER BY group_name";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain group list', '', __LINE__, __FILE__, $sql);
	}

	$select_list = '';
	if ( $row = $db->sql_fetchrow($result) )
	{
		$select_list .= '<select name="' . POST_GROUPS_URL . '">';
		do
		{
			$select_list .= '<option value="' . $row['group_id'] . '">' . strip_tags($row['group_name']) . '</option>';
		}
		while ( $row = $db->sql_fetchrow($result) );
		$select_list .= '</select>';
	}

	$template->set_filenames(array(
		'body' => 'admin/group_select_body.tpl')
	);

	$template->assign_vars(array(
		'L_GROUP_TITLE' => $lang['Group_administration'],
		'L_GROUP_EXPLAIN' => $lang['Group_admin_explain'],
		'L_GROUP_SELECT' => $lang['Select_group'],
		'L_LOOK_UP' => $lang['Look_up_group'],
		'L_CREATE_NEW_GROUP' => $lang['New_group'],

		'S_GROUP_ACTION' => append_sid("admin_groups.$phpEx"),
		'S_GROUP_SELECT' => $select_list)
	);

	if ( $select_list != '' )
	{
		$template->assign_block_vars('select_box', array());
	}

	$template->pparse('body');
}

include('./page_footer_admin.'.$phpEx);

?>