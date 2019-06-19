<?php
/***************************************************************************
 *                              admin_ranks.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.0 2005/11/11 14:56
 *
 *   $Id: admin_ranks.php,v 1.13.2.4 2004/03/25 15:57:20 acydburn Exp $
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
define('MODULE_ID', 99);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Users']['Ranks'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = xhtmlspecialchars($mode);
}
else 
{
	//
	// These could be entered via a form button
	//
	if( isset($HTTP_POST_VARS['add']) )
	{
		$mode = "add";
	}
	else if( isset($HTTP_POST_VARS['save']) )
	{
		$mode = "save";
	}
	else
	{
		$mode = "";
	}
}

if( $mode != "" )
{
	if( $mode == "edit" || $mode == "add" )
	{
		//
		// They want to add a new rank, show the form.
		//
		$rank_id = ( isset($HTTP_GET_VARS['id']) ) ? intval($HTTP_GET_VARS['id']) : 0;

		$s_hidden_fields = "";

		if( $mode == "edit" )
		{
			if( empty($rank_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['Must_select_rank']);
			}

			$sql = "SELECT * FROM " . RANKS_TABLE . "
				WHERE rank_id = $rank_id";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't obtain rank data", "", __LINE__, __FILE__, $sql);
			}

			$rank_info = $db->sql_fetchrow($result);
			$s_hidden_fields .= '<input type="hidden" name="id" value="' . $rank_id . '" />';

		}
		else
		{
			$rank_info['rank_special'] = 0;
			$rank_info['rank_group'] = 0;
		}

		$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';

		$rank_is_special = ( $rank_info['rank_special'] ) ? "checked=\"checked\"" : "";
		$rank_is_not_special = ( !$rank_info['rank_special'] ) ? "checked=\"checked\"" : "";
		$rep = '../' . $images['rank_path'] . '';
		$dir = opendir($rep);

		$l = 0;
		while($file = readdir($dir))
		{
			if (strpos($file, '.gif') || strpos($file, '.png'))
			{
				$file1[$l] = $file;
				$l++;
			}
		}
		closedir($dir);
		$ranks_list .= '<option value="">-</option>';
		for($k = 0; $k <= $l; $k++)
		{
			if ($file1[$k] != '')
			{
				$selected = ($rank_info['rank_image'] == $file1[$k]) ? ' selected="selected"' : '';
				$ranks_list .= '<option value="' . $file1[$k] . '"' . $selected . '>' . $file1[$k] . '</option>';
			}
		}

		$sql = "SELECT group_id, group_name
			FROM " . GROUPS_TABLE . "
			WHERE group_single_user = 0
			ORDER BY group_name";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain group list', '', __LINE__, __FILE__, $sql);
		}

		$group_select = '';
		if ( $row = $db->sql_fetchrow($result) )
		{
			$group_select .= '<select name="group">';
			$group_select .= '<option value="0">' . $lang['No'] . '</option>';
			do
			{
				$selected = ( $rank_info['rank_group'] == $row['group_id'] ) ? ' selected="selected"' : '';
				$group_select .= '<option value="' . $row['group_id'] . '"' . $selected . '>' . $row['group_name'] . '</option>';
			}
			while ( $row = $db->sql_fetchrow($result) );
			$group_select .= '</select>';
		}
		if ( !empty($group_select) )
		{
			$template->assign_block_vars('switch_group_rank', array(
				'L_GROUP_RANK' => $lang['Group_rank'],
				'L_GROUP_RANK_EXPLAIN' => $lang['Group_rank_explain'],
				'GROUP_RANK_SELECT' => $group_select)
			);
		}

		$template->set_filenames(array(
			"body" => "admin/ranks_edit_body.tpl")
		);

		$template->assign_vars(array(
			"RANK" => xhtmlspecialchars($rank_info['rank_title']),
			"SPECIAL_RANK" => $rank_is_special,
			"NOT_SPECIAL_RANK" => $rank_is_not_special,
			"MINIMUM" => ( $rank_is_special ) ? "" : $rank_info['rank_min'],
			"IMAGE" => ( $rank_info['rank_image'] != "" ) ? $rank_info['rank_image'] : "",
			"IMAGE_DISPLAY" => ( $rank_info['rank_image'] != "" ) ? '<img src="../' . $images['rank_path'] . $rank_info['rank_image'] . '" />' : "",
			"RANK_LIST" => $ranks_list,
			"RANK_IMG" => '../' . $images['rank_path'] . '' . $rank_info['rank_image'] . '',
			"PATH_RANKS" => '../' . $images['rank_path'] . '',
			"RANK_ONLOAD" => $rank_info['rank_image'],
			"L_RANKS_TITLE" => $lang['Ranks_title'],
			"L_RANKS_TEXT" => $lang['Ranks_explain'],
			"L_RANK_TITLE" => $lang['Rank_title'],
			"L_RANK_TITLE_E" => $lang['Rank_title_e'],
			"L_RANK_SPECIAL" => $lang['Rank_special'],
			"L_RANK_MINIMUM" => $lang['Rank_minimum'],
			"L_RANK_IMAGE" => $lang['Rank_image'],
			"L_RANK_IMAGE_EXPLAIN" => $lang['Rank_image_explain'],
			"L_SUBMIT" => $lang['Submit'],
			"L_RESET" => $lang['Reset'],
			"L_YES" => $lang['Yes'],
			"L_NO" => $lang['No'],

			"S_RANK_ACTION" => append_sid("admin_ranks.$phpEx"),
			"S_HIDDEN_FIELDS" => $s_hidden_fields)
		);
	}
	else if( $mode == "save" )
	{
		//
		// Ok, they sent us our info, let's update it.
		//

		$rank_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : 0;
		$rank_title = ( isset($HTTP_POST_VARS['title']) ) ? trim($HTTP_POST_VARS['title']) : "";
		$special_rank = ( $HTTP_POST_VARS['special_rank'] == 1 ) ? TRUE : 0;
		$group = ( $HTTP_POST_VARS['group'] > 0 ) ? intval($HTTP_POST_VARS['group']) : 0;
		$min_posts = ( $HTTP_POST_VARS['min_posts'] != '' ) ? intval($HTTP_POST_VARS['min_posts']) : "-1";
		$rank_image = ( (isset($HTTP_POST_VARS['rank_image'])) ) ? trim($HTTP_POST_VARS['rank_image']) : "";

		if( $rank_title == "" )
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_rank']);
		}

		if( $special_rank == 1 )
		{
			$max_posts = -1;
			$min_posts = -1;
			$group = 0;
		}

		//
		// The rank image has to be a jpg, gif or png
		//
		if($rank_image != "")
		{
			if ( !preg_match("/(\.gif|\.png|\.jpg)$/is", $rank_image))
			{
				$rank_image = "";
			}
		}

		if( $rank_id )
		{
			if (!$special_rank)
			{
				$sql = "UPDATE " . USERS_TABLE . " 
					SET user_rank = 0 
					WHERE user_rank = $rank_id";

				if( !$result = $db->sql_query($sql) ) 
				{
					message_die(GENERAL_ERROR, $lang['No_update_ranks'], "", __LINE__, __FILE__, $sql);
				}
			}
			$sql = "UPDATE " . RANKS_TABLE . "
				SET rank_title = '" . str_replace("\'", "''", $rank_title) . "', rank_special = $special_rank, rank_min = $min_posts, rank_image = '" . str_replace("\'", "''", $rank_image) . "', rank_group = $group
				WHERE rank_id = $rank_id";

			sql_cache('clear', 'list_ranks');

			$message = $lang['Rank_updated'];
		}
		else
		{
			$sql = "INSERT INTO " . RANKS_TABLE . " (rank_title, rank_special, rank_min, rank_image, rank_group)
				VALUES ('" . str_replace("\'", "''", $rank_title) . "', $special_rank, $min_posts, '" . str_replace("\'", "''", $rank_image) . "', $group)";

			sql_cache('clear', 'list_ranks');

			$message = $lang['Rank_added'];
		}

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update/insert into ranks table", "", __LINE__, __FILE__, $sql);
		}

		$message .= "<br /><br />" . sprintf($lang['Click_return_rankadmin'], "<a href=\"" . append_sid("admin_ranks.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);

	}
	else if( $mode == "delete" )
	{
		//
		// Ok, they want to delete their rank
		//

		if( isset($HTTP_POST_VARS['id']) || isset($HTTP_GET_VARS['id']) )
		{
			$rank_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);
		}
		else
		{
			$rank_id = 0;
		}

		if( $rank_id )
		{
			$sql = "DELETE FROM " . RANKS_TABLE . "
				WHERE rank_id = $rank_id";

			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete rank data", "", __LINE__, __FILE__, $sql);
			}

			sql_cache('clear', 'list_ranks');

			$sql = "UPDATE " . USERS_TABLE . "
				SET user_rank = 0
				WHERE user_rank = $rank_id";

			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, $lang['No_update_ranks'], "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Rank_removed'] . "<br /><br />" . sprintf($lang['Click_return_rankadmin'], "<a href=\"" . append_sid("admin_ranks.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_rank']);
		}
	}
	else
	{
		//
		// They didn't feel like giving us any information. Oh, too bad, we'll just display the
		// list then...
		//
		$template->set_filenames(array(
			"body" => "admin/ranks_list_body.tpl")
		);

		$sql = "SELECT r.*, g.group_name
			FROM " . RANKS_TABLE . " r
				LEFT JOIN " . GROUPS_TABLE . " g ON (g.group_id = r.rank_group)
			ORDER BY r.rank_special DESC, rank_group ASC, r.rank_min ASC";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain ranks data", "", __LINE__, __FILE__, $sql);
		}

		$rank_rows = $db->sql_fetchrowset($result);
		$rank_count = count($rank_rows);

		$template->assign_vars(array(
			"L_RANKS_TITLE" => $lang['Ranks_title'],
			"L_RANKS_TEXT" => $lang['Ranks_explain'],
			"L_RANK" => $lang['Rank_title'],
			"L_RANK_MINIMUM" => $lang['Rank_minimum'],
			"L_SPECIAL_RANK" => $lang['Group_Rank_special'],
			"L_EDIT" => $lang['Edit'],
			"L_DELETE" => $lang['Delete'],
			"L_ADD_RANK" => $lang['Add_new_rank'],
			"L_ACTION" => $lang['Action'],

			"S_RANKS_ACTION" => append_sid("admin_ranks.$phpEx"))
		);

		for( $i = 0; $i < $rank_count; $i++)
		{
			$rank = $rank_rows[$i]['rank_title'];
			$special_rank = $rank_rows[$i]['rank_special'];
			$rank_id = $rank_rows[$i]['rank_id'];
			$rank_min = $rank_rows[$i]['rank_min'];

			if($special_rank)
			{
				$rank_min = $rank_max = "-";
			}

			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
			$rank_is_special = ( $special_rank ) ? $lang['Yes'] : ( $rank_rows[$i]['rank_group'] > 0 ? $rank_rows[$i]['group_name'] : $lang['No'] );

			$template->assign_block_vars("ranks", array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				"RANK" => $rank,
				"RANK_MIN" => $rank_min,

				"SPECIAL_RANK" => $rank_is_special,

				"U_RANK_EDIT" => append_sid("admin_ranks.$phpEx?mode=edit&amp;id=$rank_id"),
				"U_RANK_DELETE" => append_sid("admin_ranks.$phpEx?mode=delete&amp;id=$rank_id"))
			);
		}
	}
}
else
{
	//
	// Show the default page
	//
	$template->set_filenames(array(
		"body" => "admin/ranks_list_body.tpl")
	);

	$sql = "SELECT * FROM " . RANKS_TABLE . "
		ORDER BY rank_min ASC, rank_special ASC";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain ranks data", "", __LINE__, __FILE__, $sql);
	}
	$rank_count = $db->sql_numrows($result);

	$rank_rows = $db->sql_fetchrowset($result);

	$template->assign_vars(array(
		"L_RANKS_TITLE" => $lang['Ranks_title'],
		"L_RANKS_TEXT" => $lang['Ranks_explain'],
		"L_RANK" => $lang['Rank_title'],
		"L_RANK_MINIMUM" => $lang['Rank_minimum'],
		"L_SPECIAL_RANK" => $lang['Rank_special'],
		"L_EDIT" => $lang['Edit'],
		"L_DELETE" => $lang['Delete'],
		"L_ADD_RANK" => $lang['Add_new_rank'],
		"L_ACTION" => $lang['Action'],

		"S_RANKS_ACTION" => append_sid("admin_ranks.$phpEx"))
	);

	for($i = 0; $i < $rank_count; $i++)
	{
		$rank = $rank_rows[$i]['rank_title'];
		$special_rank = $rank_rows[$i]['rank_special'];
		$rank_id = $rank_rows[$i]['rank_id'];
		$rank_min = $rank_rows[$i]['rank_min'];

		if( $special_rank == 1 )
		{
			$rank_min = $rank_max = "-";
		}

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$rank_is_special = ( $special_rank ) ? $lang['Yes'] : ( $rank_rows[$i]['rank_group'] > 0 ? $rank_rows[$i]['group_name'] : $lang['No'] );

		$template->assign_block_vars("ranks", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"RANK" => xhtmlspecialchars($rank),
			"SPECIAL_RANK" => $rank_is_special,
			"RANK_MIN" => $rank_min,

			"U_RANK_EDIT" => append_sid("admin_ranks.$phpEx?mode=edit&amp;id=$rank_id"),
			"U_RANK_DELETE" => append_sid("admin_ranks.$phpEx?mode=delete&amp;id=$rank_id"))
		);
	}
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>