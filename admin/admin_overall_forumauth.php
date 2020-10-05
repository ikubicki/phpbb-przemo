<?php
/***************************************************************************
 *                       admin_overall_forumauth.php
 *                       -------------------
 *  begin                : Friday, July 12, 2002
 *  copyright            : (C) 2002 Smartor
 *  email                : smartor_xp@hotmail.com
 *  modification         : (C) 2003 Przemo www.przemo.org/phpBB2/
 *  date modification    : ver. 1.12.0 2005/11/11 14:47
 *
 *  $Id: admin_overall_forumauth.php,v 1.0.1 2002/8/08, 19:41:51 hnt Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 ***************************************************************************/
define('MODULE_ID', 25);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Forums']['OverallPermissions'] = $filename;

	return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Start program - define vars
//
//                View      Read      Post      Reply     Edit      Delete    Sticky    Announce  Globannoun  Vote     Poll
$simple_auth_ary = array(
	0 => array(AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_ADMIN, AUTH_REG, AUTH_REG),
	1 => array(AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_ADMIN, AUTH_REG, AUTH_REG),
	2 => array(AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_ADMIN, AUTH_REG, AUTH_REG),
	3 => array(AUTH_ALL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ADMIN, AUTH_ACL, AUTH_ACL),
	4 => array(AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ADMIN, AUTH_ACL, AUTH_ACL),
	5 => array(AUTH_ALL, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_ADMIN, AUTH_MOD, AUTH_MOD),
	6 => array(AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_ADMIN, AUTH_MOD, AUTH_MOD),
);

$simple_auth_types = array($lang['Public'], $lang['Registered'], $lang['Registered'] . ' [' . $lang['Hidden'] . ']', $lang['Private'], $lang['Private'] . ' [' . $lang['Hidden'] . ']', $lang['Moderators'], $lang['Moderators'] . ' [' . $lang['Hidden'] . ']');

$forum_auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_delete', 'auth_sticky', 'auth_announce', 'auth_globalannounce', 'auth_vote', 'auth_pollcreate');

$field_names = array(
	'auth_view' => $lang['View'],
	'auth_read' => $lang['Read'],
	'auth_post' => $lang['Post'],
	'auth_reply' => $lang['Reply'],
	'auth_edit' => $lang['Edit'],
	'auth_delete' => $lang['Delete'],
	'auth_sticky' => $lang['Sticky'],
	'auth_announce' => $lang['Announce'],
	'auth_globalannounce' => $lang['Globalannounce'],
	'auth_vote' => $lang['Vote'],
	'auth_pollcreate' => $lang['Pollcreate']);

$forum_auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN');
$forum_auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN);
attach_setup_forum_auth($simple_auth_ary, $forum_auth_fields, $field_names);

if( isset($HTTP_GET_VARS['adv']) )
{
	$adv = intval($HTTP_GET_VARS['adv']);
}
else
{
	unset($adv);
}

//
// Start program proper
//
if( isset($HTTP_POST_VARS['submit']) )
{
	$sql = '';

	if(isset($HTTP_POST_VARS['simpleauth']))
	{
		$simple_ary = $simple_auth_ary[$HTTP_POST_VARS['simpleauth']];

		for($i = 0; $i < count($simple_ary); $i++)
		{
			$sql .= ( ( $sql != '' ) ? ', ' : '' ) . $forum_auth_fields[$i] . ' = ' . $simple_ary[$i];
		}
		$sql = "UPDATE " . FORUMS_TABLE . " SET $sql";
	}
	else
	{
		for($i = 0; $i < count($forum_auth_fields); $i++)
		{
			$value = intval($HTTP_POST_VARS[$forum_auth_fields[$i]]);
			$sql .= ( ( $sql != '' ) ? ', ' : '' ) .$forum_auth_fields[$i] . ' = ' . $value;
		}
		$sql = "UPDATE " . FORUMS_TABLE . " SET $sql";
	}
	if ( $sql != '' )
	{
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update auth table', '', __LINE__, __FILE__, $sql);
		}
		sql_cache('clear', 'multisqlcache_forum');
		sql_cache('clear', 'forum_data');
		sql_cache('clear', 'f_access');
		sql_cache('clear', 'moderators_list');
	}

	$forum_sql = '';
	$adv = 0;

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_overall_forumauth.$phpEx") . '">')
	);
	$message = $lang['Forum_auth_updated'] . '<br /><br />' . sprintf($lang['Click_return_forumauth'], '<a href="' . append_sid("admin_overall_forumauth.$phpEx") . '">', "</a>");
	message_die(GENERAL_MESSAGE, $message);

}

$template->set_filenames(array(
	'body' => 'admin/auth_forum_body.tpl')
);

$forum_rows = array(
	'auth_view' => AUTH_ALL,
	'auth_read' => AUTH_ALL,
	'auth_post' => AUTH_ALL,
	'auth_reply' => AUTH_ALL,
	'auth_edit' => AUTH_REG,
	'auth_delete' => AUTH_REG,
	'auth_sticky' => AUTH_MOD,
	'auth_announce' => AUTH_MOD,
	'auth_globalannounce' => AUTH_ADMIN,
	'auth_vote' => AUTH_REG,
	'auth_pollcreate' => AUTH_REG,
	'auth_attachments' => AUTH_REG,
	'auth_download' => AUTH_ALL
);

@reset($simple_auth_ary);
while( list($key, $auth_levels) = each($simple_auth_ary))
{
	$matched = 1;
	for($k = 0; $k < count($auth_levels); $k++)
	{
		$matched_type = $key;

		if ( $forum_rows[$forum_auth_fields[$k]] != $auth_levels[$k] )
		{
			$matched = 0;
		}
	}

	if ( $matched )
	{
		break;
	}
}

if ( !isset($adv) && !$matched )
{
	$adv = 1;
}

$s_column_span == 0;

if ( empty($adv) )
{
	$simple_auth = '<select name="simpleauth">';

	for($j = 0; $j < count($simple_auth_types); $j++)
	{
		$selected = ( $matched_type == $j ) ? ' selected="selected"' : '';
		$simple_auth .= '<option value="' . $j . '"' . $selected . '>' . $simple_auth_types[$j] . '</option>';
	}

	$simple_auth .= '</select>';

	$template->assign_block_vars('forum_auth_titles', array(
		'CELL_TITLE' => $lang['Simple_mode'])
	);
	$template->assign_block_vars('forum_auth_data', array(
		'S_AUTH_LEVELS_SELECT' => $simple_auth)
	);

	$s_column_span++;
}
else
{
	for($j = 0; $j < count($forum_auth_fields); $j++)
	{
		$custom_auth[$j] = '&nbsp;<select name="' . $forum_auth_fields[$j] . '">';

		for($k = 0; $k < count($forum_auth_levels); $k++)
		{
			$selected = ( $forum_rows[$forum_auth_fields[$j]] == $forum_auth_const[$k] ) ? ' selected="selected"' : '';
			$custom_auth[$j] .= '<option value="' . $forum_auth_const[$k] . '"' . $selected . '>' . $lang['Forum_' . $forum_auth_levels[$k]] . '</option>';
		}
		$custom_auth[$j] .= '</select>&nbsp;';

		$cell_title = $field_names[$forum_auth_fields[$j]];

		$template->assign_block_vars('forum_auth_titles', array(
			'CELL_TITLE' => $cell_title)
		);
		$template->assign_block_vars('forum_auth_data', array(
			'S_AUTH_LEVELS_SELECT' => $custom_auth[$j])
		);

		$s_column_span++;
	}
}

$adv_mode = ( empty($adv) ) ? '1' : '0';
$switch_mode = append_sid("admin_overall_forumauth.$phpEx?" . POST_FORUM_URL . "=" . $forum_id . "&amp;adv=". $adv_mode);
$switch_mode_text = ( empty($adv) ) ? $lang['Advanced_mode'] : $lang['Simple_mode'];
$u_switch_mode = '<a href="' . $switch_mode . '">' . $switch_mode_text . '</a>';

$s_hidden_fields = '<input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '">';

$template->assign_vars(array(
	'L_FORUM' => $lang['OverallPermissions_all'],
	'L_AUTH_TITLE' => $lang['OverallPermissions'],
	'L_AUTH_EXPLAIN' => $lang['Forum_auth_explain'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],

	'U_SWITCH_MODE' => $u_switch_mode,

	'S_FORUMAUTH_ACTION' => append_sid("admin_overall_forumauth.$phpEx"),
	'S_COLUMN_SPAN' => $s_column_span,
	'S_HIDDEN_FIELDS' => $s_hidden_fields)
);

include('./page_header_admin.'.$phpEx);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>