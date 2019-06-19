<?php
/***************************************************************************
 *					admin_custom_fields.php
 *					-------------------
 *	begin			: Monday, May 10, 2004
 *	copyright		: (C) 2004 Przemo http://www.przemo.org
 *	email			: przemo@przemo.org
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
define('MODULE_ID', 17);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Users']['Custom_fields'] = $file;
	return;
}

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_custom_fields.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

$template->set_filenames(array(
	'body' => 'admin/custom_fields.tpl')
);

$mode = $HTTP_GET_VARS['mode'];
$jumpbox = trim($HTTP_POST_VARS['jumpbox']);
$id_form = intval($HTTP_GET_VARS['id_form']);
$desc_short = trim($HTTP_POST_VARS['desc_short']);
$desc_long = trim($HTTP_POST_VARS['desc_long']);
$makelinks = intval($HTTP_POST_VARS['makelinks']);
$max_value = intval($HTTP_POST_VARS['max_value']);
$min_value = intval($HTTP_POST_VARS['min_value']);
$numerics = intval($HTTP_POST_VARS['numerics']);
$requires = intval($HTTP_POST_VARS['requires']);
$view_post = intval($HTTP_POST_VARS['view_post']);
$view_profile = intval($HTTP_POST_VARS['view_profile']);
$set_form = intval($HTTP_POST_VARS['set_form']);
$editable = intval($HTTP_POST_VARS['editable']);
$view_by = intval($HTTP_POST_VARS['view_by']);
$no_forum = ( !empty($HTTP_POST_VARS['no_forum']) ) ? $HTTP_POST_VARS['no_forum'] : '';
$prefix = trim($HTTP_POST_VARS['prefix']);
$suffix = trim($HTTP_POST_VARS['suffix']);
$no_table = false;
$no_fields = true;

$no_forum_sql = '';
if ( is_array($no_forum) )
{
	for($i = 0; $i < count($no_forum); $i++)
	{
		if ( $no_forum[$i] && @$no_forum[$i]{0} == POST_FORUM_URL )
		{
			$no_forum_sql .= (($no_forum_sql) ? ', ' : '') . '[' . substr($no_forum[$i], 1) . ']';
		}
	}
}

$sql = "SELECT *
	FROM " . FIELDS_TABLE . "
	ORDER by id ASC";
if ( !($result = $db->sql_query($sql)) )
{
	$no_table = true;
}
if ($row = $db->sql_fetchrow($result))
{
	$no_fields = false;
}

if ( ($no_table || $no_fields || $mode == 'add' || $mode == 'edit') && $mode != 'add_field' && $mode != 'edit_field')
{
	$cf_description = ($no_table || $no_fields) ? $lang['CF_no_fields'] : '';
	if ( $mode != 'edit')
	{
		$s_action = append_sid("admin_custom_fields.$phpEx?mode=add_field");
		$title = $lang['CF_add'];
		$makelinks = '0';
		$max_value = '45';
		$min_value = '1';
		$numerics = '0';
		$requires = '0';
		$view_post = '2';
		$view_profile = '1';
		$set_form = '0';
		$editable = '1';
		$view_by = '0';
		$no_forum = $prefix = $suffix = '';
	}
	else
	{
		$sql = "SELECT * FROM " . FIELDS_TABLE . "
			WHERE id = $id_form";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get Profile Field from fields table', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		$s_action = append_sid("admin_custom_fields.$phpEx?mode=edit_field&amp;id_form=$id_form");
		$title = $lang['Edit'];
		$desc_short = $row['desc_short'];
		$desc_long = $row['desc_long'];
		$makelinks = $row['makelinks'];
		$max_value = $row['max_value'];
		$min_value = $row['min_value'];
		$numerics = $row['numerics'];
		$requires = $row['requires'];
		$view_post = $row['view_post'];
		$view_profile = $row['view_profile'];
		$set_form = $row['set_form'];
		$editable = $row['editable'];
		$view_by = $row['view_by'];
		$no_forum = $row['no_forum'];
		$prefix = $row['prefix'];
		$suffix = $row['suffix'];

		$options = explode(',', str_replace(', ', ',', $row['jumpbox']));

		if ( count($options) > 1 )
		{
			if (stristr($options[count($options) -1 ],'.gif') || stristr($options[count($options) -1 ],'.jpg'))
			{
				$jumpbox_edit = '<br /><br />' . $lang['Preview'] . ': <script language="javascript" type="text/javascript">function update_rank(newimage){document.jumpbox_edit.src = \'../' . $images['images'] . '/custom_fields/\'+newimage;}</script><select name="jumpbox_edit" onchange="update_rank(this.options[selectedIndex].value);"><option value="no_image.gif">' . $lang['None'] . '</option>';
				for ($i = 0; $i+1 <= count($options); $i++) 
				{
					$field_name = str_replace(array('_', '.gif', '.jpg'), array(' ', '', ''), xhtmlspecialchars($options[$i]));
					$jumpbox_edit .= '<option value="' . xhtmlspecialchars($options[$i]) . '">' . $field_name . '</option>';
				}
				$jumpbox_edit .= '</select>&nbsp;<img name="jumpbox_edit" src="../' . $images['images'] . '/custom_fields/no_image.gif" border="0" alt="" align="top" />';
				$jumpbox_text = xhtmlspecialchars($row['jumpbox']);
			}
			else
			{
				$jumpbox_edit = '<br /><br />' . $lang['Preview'] . ': <select name="jumpbox_edit"><option value="">' . $lang['None'] . '</option>';
				for ($i = 0; $i+1 <= count($options); $i++) 
				{
					$jumpbox_edit .= '<option value="' . xhtmlspecialchars($options[$i]) . '">' . xhtmlspecialchars($options[$i]) . '</option>';
				}
				$jumpbox_edit .= '</select>';
				$jumpbox_text = xhtmlspecialchars($row['jumpbox']);
			}
		}
		else
		{
			$jumpbox_edit = '';
			$jumpbox_text = '';
		}
	}
	$template->assign_block_vars('add_field',array());

 	if ( $mode == 'edit' )
	{
		$template->assign_block_vars('add_field.delete',array(
			'L_DELETE' => $lang['CF_delete'])
		);
	}
}

if ( !$no_fields && !isset($mode) )
{
	$i = 0;
	$title = $lang['CF_title'];
	$template->assign_block_vars('field_list',array());
	do
	{
		$id = $row['id'];

		$template->assign_block_vars('field_list_loop',array(
			'CLASS' => (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'],
			'DESC_SHORT' =>  strip_tags($row['desc_short']),
			'S_ACTION_EDIT' => append_sid("admin_custom_fields.$phpEx?mode=edit&amp;id_form=$id"))
		);
		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );
}

if ( isset($HTTP_POST_VARS['delete']) )
{
	$s_hidden_fields = '<input type="hidden" name="execute_delete" value="' . $HTTP_POST_VARS['delete'] . '">';

	$template->set_filenames(array(
		'confirm' => 'confirm_body.tpl')
	);

	$template->assign_vars(array(
		'MESSAGE_TITLE' => $lang['Confirm'],
		'MESSAGE_TEXT' => $lang['CF_confirm_delete'],
		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],
		'S_CONFIRM_ACTION' => append_sid("admin_custom_fields.$phpEx?mode=delete"),
		'S_HIDDEN_FIELDS' => $s_hidden_fields)
	);

	$template->pparse('confirm');
	include('page_footer_admin.'.$phpEx); 
}

if ( $mode == 'delete' )
{
	if ( isset($HTTP_POST_VARS['cancel']) )
	{
		redirect(append_sid("admin/admin_custom_fields.$phpEx", true));
	}

	$sql = "DELETE FROM " . FIELDS_TABLE . "
		WHERE id = " . intval($HTTP_POST_VARS['execute_delete']);
	if ( !$result = $db->sql_query($sql, BEGIN_TRANSACTION) )
	{
		message_die(GENERAL_ERROR, 'Could not delete profile field', '', __LINE__, __FILE__, $sql);
	}

	$column_name = 'user_field_' . intval($HTTP_POST_VARS['execute_delete']);

	$sql = "ALTER TABLE " . USERS_TABLE . " 
		DROP $column_name";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Failed to drop from users table', '', __LINE__, __FILE__, $sql);
	}

	$column_allow_name = 'user_allow_field_' . intval($HTTP_POST_VARS['execute_delete']);
	$sql = "ALTER TABLE " . USERS_TABLE . " 
		DROP $column_allow_name";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Failed to drop from users table', '', __LINE__, __FILE__, $sql);
	}

	$sql = "SELECT *
		FROM " . FIELDS_TABLE;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Failed to check fields table', '', __LINE__, __FILE__, $sql);
	}

	if ( !($row = $db->sql_fetchrow($result)) )
	{
		$sql = "DROP TABLE " . FIELDS_TABLE;
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Failed to drop fields table', '', __LINE__, __FILE__, $sql);
		}
	}

	sql_cache('clear', 'multisqlcache_fieldsc');
	sql_cache('clear', 'multisqlcache_fields');

	$message = sprintf($lang['CF_delete_executed'], '<a href="' . append_sid("admin_custom_fields.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( $mode == 'add_field' )
{
	if ( $no_table )
	{
		$create = "CREATE TABLE " . FIELDS_TABLE . " (
			id tinyint(1) NOT NULL auto_increment,
			desc_short varchar(255) NOT NULL,
			desc_long varchar(255),
			makelinks tinyint(1) DEFAULT '0' NOT NULL,
			max_value int(8) DEFAULT '45' NOT NULL,
			min_value int(8) DEFAULT '1' NOT NULL,
			numerics tinyint(1) DEFAULT '0' NOT NULL,
			jumpbox text,
			requires tinyint(1) DEFAULT '0' NOT NULL,
			view_post tinyint(1) DEFAULT '2' NOT NULL,
			view_profile tinyint(1) DEFAULT '1' NOT NULL,
			set_form tinyint(1) DEFAULT '0' NOT NULL,
			no_forum varchar(255) DEFAULT '' NOT NULL,
			prefix varchar(255) DEFAULT '' NOT NULL,
			suffix varchar(255) DEFAULT '' NOT NULL,
			editable tinyint(1) DEFAULT '1' NOT NULL,
			view_by tinyint(1) DEFAULT '0' NOT NULL,
			PRIMARY KEY id (id)) DEFAULT CHARSET latin2 COLLATE latin2_general_ci";

		if ( !($create_result = $db->sql_query($create)) )
		{
			message_die(GENERAL_ERROR, 'Error creating profile fields table', '', __LINE__, __FILE__, $create);
		}
	}

	$jumpbox = check_form($jumpbox, $desc_short);

	if ( $desc_short == 'adv_person' )
	{
		$makelinks = $requires = $editable = 0;
	}

	$sql = "INSERT INTO " . FIELDS_TABLE . " (desc_short, desc_long, makelinks, max_value, min_value, numerics, jumpbox, requires, view_post, view_profile, set_form, no_forum, prefix, suffix, editable, view_by)
		VALUES ('" . str_replace("\'", "''", $desc_short) . "', '" . str_replace("\'", "''", $desc_long) . "', $makelinks, $max_value, $min_value, $numerics, '" . str_replace("\'", "''", $jumpbox) . "', $requires, $view_post, $view_profile, $set_form, '" . str_replace("\'", "''", $no_forum_sql) . "', '" . str_replace("\'", "''", $prefix) . "', '" . str_replace("\'", "''", $suffix) . "', $editable, $view_by)";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['CF_duplicate_desc_short'], xhtmlspecialchars($desc_short)));
	}

	sql_cache('clear', 'multisqlcache_fieldsc');
	sql_cache('clear', 'multisqlcache_fields');

	$sql = "SELECT MAX(id) as max_id
		FROM " . FIELDS_TABLE . "
		LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error checking fields table');
	}
	$row = $db->sql_fetchrow($result);
	$column_name = 'user_field_' . $row['max_id'];

	$field_type = ($numerics) ? "INT($max_value) DEFAULT '0' NOT NULL" : "VARCHAR($max_value) DEFAULT '' NULL";

	$sql = "ALTER TABLE " . USERS_TABLE . " 
		ADD $column_name $field_type
		AFTER user_from";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Failed to alter users table', '', __LINE__, __FILE__, $sql);
	}

	$column_allow_name = 'user_allow_field_' . $row['max_id'];
	$sql = "ALTER TABLE " . USERS_TABLE . " 
		ADD $column_allow_name tinyint(1) DEFAULT '1'
		AFTER $column_name";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Failed to alter users table', '', __LINE__, __FILE__, $sql);
	}

	$message = sprintf($lang['CF_added'], xhtmlspecialchars(str_replace("\'", "'", $desc_short)), '<a href="' . append_sid("admin_custom_fields.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);

}

if ( $mode == 'edit_field' && $id_form )
{
	$jumpbox = check_form($jumpbox, $desc_short);

	if ( $desc_short == 'adv_person' )
	{
		$makelinks = $requires = $editable = 0;
	}

	$sql = "UPDATE " . FIELDS_TABLE . "
		SET desc_short = '" . str_replace("\'", "''", $desc_short) . "', desc_long = '" . str_replace("\'", "''", $desc_long) . "', makelinks = $makelinks, max_value = $max_value, min_value = $min_value, numerics = $numerics, jumpbox = '" . str_replace("\'", "''", $jumpbox) . "', requires = $requires, view_post = $view_post, view_profile = $view_profile, set_form = $set_form, no_forum = '" . str_replace("\'", "''", $no_forum_sql) . "', prefix = '" . str_replace("\'", "''", $prefix) . "', suffix = '" . str_replace("\'", "''", $suffix) . "', editable = $editable, view_by = $view_by
		WHERE id = $id_form";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Failed to update profile field', '', __LINE__, __FILE__, $sql);
	}

	$column_name = 'user_field_' . $id_form;
	$field_type = ($numerics) ? "INT($max_value) DEFAULT '0' NOT NULL" : "VARCHAR($max_value) DEFAULT '' NULL";

	$sql = "ALTER TABLE " . USERS_TABLE . "
		CHANGE $column_name $column_name $field_type";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Failed to update users table structure', '', __LINE__, __FILE__, $sql);
	}

	sql_cache('clear', 'multisqlcache_fieldsc');
	sql_cache('clear', 'multisqlcache_fields');

	$message = '' . sprintf($lang['CF_edited'], xhtmlspecialchars(str_replace("\'", "'", $desc_short)), '<a href="' . append_sid("admin_custom_fields.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( is_array($no_forum) )
{
	$no_forum_new = '';
	for($i = 0; $i < count($no_forum); $i++)
	{
		$no_forum_new .= (($no_forum_new) ? ', ' : '') . str_replace(POST_FORUM_URL, '', $no_forum[$i]);
	}
	$no_forum = $no_forum_new;
}

$template->assign_vars(array(
	'L_ADD' => $lang['Add_new'],
	'L_ADD_FIELD' => ($mode == 'edit') ? $lang['Save_Settings'] : $lang['Add_new'],
	'L_TITLE' => $title,
	'L_DESC_SHORT' => $lang['CF_short_desc'],
	'L_DESC_LONG' => $lang['CF_long_desc'],
	'L_MAKELINKS' => $lang['CF_makelinks'],
	'L_MAX_VALUE' => $lang['CF_max_value'],
	'L_MIN_VALUE' => $lang['CF_min_value'],
	'L_NUMERICS' => $lang['CF_numerics'],
	'L_REQUIRE' => $lang['CF_require'],
	'L_VIEW_POST' => $lang['CF_view_post'],
	'L_POST' => $lang['CF_post'],
	'L_UPOST' => $lang['CF_upost'],
	'L_AVATAR' => $lang['CF_avatar'],
	'L_VIEW_PROFILE' => $lang['CF_view_profile'],
	'L_NO_FORUM' => $lang['CF_no_forum'],
	'L_SET_FORM' => $lang['CF_set_form'],
	'L_TEXT' => $lang['CF_text'],
	'L_TEXTAREA' => $lang['CF_textarea'],
	'L_JUMPBOX' => $lang['CF_jumpbox'],
	'L_JUMPBOX_E' => $lang['CF_jumpbox_e'],
	'L_EDIT' => $lang['Edit'] . ' / ' . $lang['Preview'],
	'L_NONE' => $lang['None'],
	'L_NO' => $lang['No'],
	'L_YES' => $lang['Yes'],
	'CF_TITLE' => $lang['CF_title'],
	'CF_DESCRIPTION' => $cf_description,
	'CF_EXPLAIN' => $lang['CF_title_explain'],
	'L_PREFIX_E' => $lang['Prefix_e'],
	'L_EDITABLE' => $lang['CF_editable'],
	'L_VIEW_BY' => $lang['CF_view_by'],
	'L_VIEW_ALL' => $lang['Forum_ALL'],
	'L_VIEW_REGISTERED' => $lang['Forum_REG'],
	'L_VIEW_MOD' => $lang['Forum_MOD'],
	'L_VIEW_ADMIN' => $lang['Forum_ADMIN'],
	'L_AND_USER' => $lang['CF_view_by_user'],

	'ID' => $id_form,
	'DESC_SHORT' => xhtmlspecialchars($desc_short),
	'DESC_LONG' => xhtmlspecialchars($desc_long),
	'MAKELINKS_YES' => ($makelinks) ? 'checked="checked"' : '',
	'MAKELINKS_NO' => (!$makelinks) ? 'checked="checked"' : '',
	'MAX_VALUE' => $max_value,
	'MIN_VALUE' => $min_value,
	'NUMERICS_YES' => ($numerics) ? 'checked="checked"' : '',
	'NUMERICS_NO' => (!$numerics) ? 'checked="checked"' : '',
	'REQUIRE_YES' => ($requires) ? 'checked="checked"' : '',
	'REQUIRE_NO' => (!$requires) ? 'checked="checked"' : '',
	'SELECTED_NO' => (!$view_post) ? 'selected="selected"' : '',
	'SELECTED_POST' => ($view_post == '1') ? 'selected="selected"' : '',
	'SELECTED_UPOST' => ($view_post == '3') ? 'selected="selected"' : '',
	'SELECTED_AVATAR' => ($view_post == '2') ? 'selected="selected"' : '',
	'PROFILE_YES' => ($view_profile) ? 'checked="checked"' : '',
	'PROFILE_NO' => (!$view_profile) ? 'checked="checked"' : '',
	'SELECTED_TEXT' => (!$set_form) ? 'selected="selected"' : '',
	'SELECTED_TEXTAREA' => ($set_form) ? 'selected="selected"' : '',

	'EDITABLE_YES' => ($editable) ? 'checked="checked"' : '',
	'EDITABLE_NO' => (!$editable) ? 'checked="checked"' : '',
	'VIEW_ALL' => ($view_by == '0') ? 'selected="selected"' : '',
	'VIEW_REGISTERED' => ($view_by == '1') ? 'selected="selected"' : '',
	'VIEW_MOD' => ($view_by == '2') ? 'selected="selected"' : '',
	'VIEW_ADMIN' => ($view_by == '3') ? 'selected="selected"' : '',
	'VIEW_USER_MOD' => ($view_by == '4') ? 'selected="selected"' : '',
	'VIEW_USER_ADMIN' => ($view_by == '5') ? 'selected="selected"' : '',

	'JUMPBOX' => $jumpbox_text,
	'JUMPBOX_EDIT' => $jumpbox_edit,
	'NO_FORUM' => get_tree_option('', false, true, str_replace(array('[', ']'), '', $no_forum)),
	'PREFIX' => xhtmlspecialchars($prefix),
	'SUFFIX' => xhtmlspecialchars($suffix),
	'S_ACTION' => $s_action,
	'S_ACTION_ADD' => append_sid("admin_custom_fields.$phpEx?mode=add"))
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>