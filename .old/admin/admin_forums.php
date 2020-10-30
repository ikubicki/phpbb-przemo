<?php
/***************************************************************************
 *                             admin_forums.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/10/09 22:48
 *
 *   $Id: admin_forums.php,v 1.40.2.12 2005/05/07 22:18:10 acydburn Exp $
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
define('MODULE_ID', 23);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Forums']['Manage'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

$forum_auth_ary = array(
	"auth_view" => AUTH_ALL,
	"auth_read" => AUTH_ALL,
	"auth_post" => AUTH_REG,
	"auth_reply" => AUTH_ALL,
	"auth_edit" => AUTH_REG,
	"auth_delete" => AUTH_REG,
	"auth_sticky" => AUTH_MOD,
	"auth_announce" => AUTH_MOD,
	"auth_globalannounce" => AUTH_ADMIN,
	"auth_vote" => AUTH_REG,
	"auth_pollcreate" => AUTH_REG
);

if ( defined('ATTACHMENTS_ON') ) $forum_auth_ary['auth_attachments'] = AUTH_REG;
if ( defined('ATTACHMENTS_ON') ) $forum_auth_ary['auth_download'] = AUTH_ALL;

//
// Mode setting
//
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = xhtmlspecialchars($mode);
}
else
{
	$mode = "";
}

$post_moderate = ($HTTP_POST_VARS['moderate']) ? 1 : 0;
$post_no_count = ($HTTP_POST_VARS['no_count']) ? 1 : 0;
$forum_trash = ($HTTP_POST_VARS['forum_trash']) ? 1 : 0;
$locked_bottom = ($HTTP_POST_VARS['locked_bottom']) ? 1 : 0;

// check the presence of the attachment of the forum
$sql = "SELECT main_type FROM " . FORUMS_TABLE;
if ( $db->sql_query($sql) )
{
	define('SUB_FORUM_ATTACH', true);
}

// get the ids
$cat_id = 0;
if (isset($HTTP_POST_VARS[POST_CAT_URL]) || isset($HTTP_GET_VARS[POST_CAT_URL]))
{
	$cat_id = isset($HTTP_POST_VARS[POST_CAT_URL]) ? intval($HTTP_POST_VARS[POST_CAT_URL]) : intval($HTTP_GET_VARS[POST_CAT_URL]);
}

$forum_id = 0;
if (isset($HTTP_POST_VARS[POST_FORUM_URL]) || isset($HTTP_GET_VARS[POST_FORUM_URL]))
{
	$forum_id = isset($HTTP_POST_VARS[POST_FORUM_URL]) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : intval($HTTP_GET_VARS[POST_FORUM_URL]);
}

// check and fix parm
if ( !(function_exists('admin_check_cat')) )
{
	function admin_check_cat()
	{
		global $db;

		$res = false;
		// build the cat list
		$mains = array();

		// from cats
		$sql = "SELECT * FROM " . CATEGORIES_TABLE . " ORDER BY cat_id";
		if ( !$result = $db->sql_query($sql) ) message_die(GENERAL_ERROR, "Couldn't access list of Categories", "", __LINE__, __FILE__, $sql);
		while ( $row = $db->sql_fetchrow($result) ) 
		{
			// fix cat_main value
			if (empty($row['cat_main_type'])) 
			{
				$row['cat_main_type'] = POST_CAT_URL;
			}
			if ( $row['cat_main'] == $row['cat_id'] )
			{
				$row['cat_main_type'] = POST_CAT_URL;
				$row['cat_main'] = 0;
			}
			// fill hierarchy array
			$mains[ POST_CAT_URL . $row['cat_id'] ] = $row['cat_main_type'] . $row['cat_main'];
		}// end while ( $row = $db->sql_fetchrow($result) )

		// from forums
		$sql = "SELECT * FROM " . FORUMS_TABLE . " ORDER BY forum_id";
		if ( !$result = $db->sql_query($sql) ) message_die(GENERAL_ERROR, "Couldn't access list of Forums", "", __LINE__, __FILE__, $sql);
		while ( $row = $db->sql_fetchrow($result) ) 
		{
			// fill hierarchy array
			if (empty($row['main_type'])) $row['main_type'] = POST_CAT_URL;
			$mains[POST_FORUM_URL . $row['forum_id'] ] = $row['main_type'] . $row['cat_id'];
		}// end while ( $row = $db->sql_fetchrow($result) )

		// no forums nor cats
		if (empty($mains)) return false;

		// push each cat
		reset($mains);
		while (list($id, $main) = each($mains) )
		{
			$root		= false;
			$cur		= $id;

			$stack		= array();
			$stack[]	= $cur;
			while ( !$root )
			{
				// parent catagory doesn't exists
				if ( ($mains[$cur] != 'c0' ) && !isset($mains[ $mains[$cur] ]) )
				{
					$mains[$cur] = 'c0';
				}

				// the parent category is already in the stack (recursive attachement)
				if ( in_array($mains[$cur], $stack) )
				{
					$mains[$cur] = 'c0';
				}

				// push parent category id
				$stack[] = $mains[$cur];

				// climb up a level
				$root = ($mains[$cur] == 'c0');
				$cur = $mains[$cur];

			}// while ( !$root )

			// update database
			$type		= substr($id, 0, 1);
			$i			= intval(substr($id, 1));
			$main_type	= substr($mains[$id], 0, 1);
			$main_id	= intval(substr($mains[$id], 1));
			if ( $i != 0)
			{
				switch( $type )
				{
					case POST_CAT_URL:
						$sql = "UPDATE " . CATEGORIES_TABLE . " SET cat_main_type='$main_type', cat_main=$main_id WHERE cat_id=$i";
						if ( !$result = $db->sql_query($sql) ) message_die(GENERAL_ERROR, "Couldn't update list of Categories", "", __LINE__, __FILE__, $sql);
						break;
					case POST_FORUM_URL:
						$sql = "UPDATE " . FORUMS_TABLE . " SET cat_id=$main_id WHERE forum_id=$i";
						if (defined('SUB_FORUM_ATTACH'))
						{
							$sql = "UPDATE " . FORUMS_TABLE . " SET main_type='$main_type', cat_id=$main_id WHERE forum_id=$i";
						}
						if ( !$result = $db->sql_query($sql) ) message_die(GENERAL_ERROR, "Couldn't update list of Forums", "", __LINE__, __FILE__, $sql);

						sql_cache('clear', 'multisqlcache_forum');
						sql_cache('clear', 'forum_data');
						sql_cache('clear', 'cat_list');
						sql_cache('clear', 'moderators_list');

						break;
					default:
						$sql = '';
						break;
				}
			}
		}
		return ;
	}// end
}

if ( !(function_exists('move_tree')) )
{
	function move_tree($type, $id, $move)
	{
		global $db;
		global $tree;

		// search the object
		$athis = (isset($tree['keys'][ $type . $id ])) ? $tree['keys'][ $type . $id ] : -1;

		// get the root id
		$main = ($athis < 0) ? 'Root' : $tree['main'][$athis];

		// renum objects of the same level and regenerate all
		$cats = array();
		$forums = array();
		$order = 0;
		$parents = array();
		for ($i=0; $i < count($tree['data']); $i++) 
		{
			if ($tree['main'][$i] == $main)
			{
				$order = $order + 10;
				$worder = ($i == $athis) ? $order + $move : $order;
				$field_name = ($tree['type'][$i] == POST_CAT_URL) ? 'cat_order' : 'forum_order';
				$tree['data'][$i][$field_name] = $worder;
			}
			if ($tree['type'][$i] == POST_CAT_URL)
			{
				$idx = count($cats);
				$cats[$idx] = $tree['data'][$i];
				$parents[POST_CAT_URL][ $tree['main'][$i] ][] = $idx;
			}
			else
			{
				$idx = count($forums);
				$forums[$idx] = $tree['data'][$i];
				$parents[POST_FORUM_URL][ $tree['main'][$i] ][] = $idx;
			}
		}

		// build the tree
		$tree = array();
		$new_topic_data = array();
		$tracking_topics = array();
		$tracking_forums = array();
		$tracking_all = -1;
		build_tree($cats, $forums, $new_topic_data, $tracking_topics, $tracking_forums, $tracking_all, $parents);

		// re-order all
		$order = 0;
		for ($i=0; $i < count($tree['data']); $i++)
		{
			$order = $order + 10;
			if ($tree['type'][$i] == POST_CAT_URL)
			{
				$sql = "UPDATE " . CATEGORIES_TABLE . " SET cat_order=$order WHERE cat_id=" . $tree['id'][$i];
			}
			else
			{
				$sql = "UPDATE " . FORUMS_TABLE . " SET forum_order=$order WHERE forum_id=" . $tree['id'][$i];
			}
			if ( !$db->sql_query($sql) ) message_die(GENERAL_ERROR, 'Couldn\'t update cat/forum order', '', __LINE__, __FILE__, $sql);

        }
		sql_cache('clear', 'multisqlcache_forum');
		sql_cache('clear', 'forum_data');
		sql_cache('clear', 'cat_list');
		sql_cache('clear', 'moderators_list');
		sql_cache('clear', 'f_access');
	}
}

if ( !(function_exists('get_info')) )
{
	function get_info($mode, $id)
	{
		global $db;

		switch($mode)
		{
			case 'category':
				$table = CATEGORIES_TABLE;
				$idfield = 'cat_id';
				$namefield = 'cat_title';
				break;

			case 'forum':
				$table = FORUMS_TABLE;
				$idfield = 'forum_id';
				$namefield = 'forum_name';
				break;

			default:
				message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
				break;
		}
		$sql = "SELECT count(*) as total
			FROM $table";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't get Forum/Category information", "", __LINE__, __FILE__, $sql);
		}
		$count = $db->sql_fetchrow($result);
		$count = $count['total'];

		$sql = "SELECT *
			FROM $table
			WHERE $idfield = $id";

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't get Forum/Category information", "", __LINE__, __FILE__, $sql);
		}

		if( $db->sql_numrows($result) != 1 )
		{
			message_die(GENERAL_ERROR, "Forum/Category doesn't exist or multiple forums/categories with ID $id", "", __LINE__, __FILE__);
		}

		$return = $db->sql_fetchrow($result);
		$return['number'] = $count;
		return $return;
	}
}

if ( !(function_exists('get_list')) )
{
	function get_list($mode, $id, $select)
	{
		global $db;

		switch($mode)
		{
			case 'category':
				$table = CATEGORIES_TABLE;
				$idfield = 'cat_id';
				$namefield = 'cat_title';
				break;

			case 'forum':
				$table = FORUMS_TABLE;
				$idfield = 'forum_id';
				$namefield = 'forum_name';
				break;

			default:
				message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
				break;
		}

		$sql = "SELECT *
			FROM $table";
		if( $select == 0 )
		{
			$sql .= " WHERE $idfield <> $id";
		}

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't get list of Categories/Forums", "", __LINE__, __FILE__, $sql);
		}

		$cat_list = "";

		while( $row = $db->sql_fetchrow($result) )
		{
			$s = "";
			if ($row[$idfield] == $id)
			{
				$s = " selected=\"selected\"";
			}
			$catlist .= "<option value=\"$row[$idfield]\"$s>" . $row[$namefield] . "</option>\n";
		}

		return($catlist);
	}
}

if ( !(function_exists('check_trash')) )
{
	function check_trash()
	{
		global $db;
		$sql = "SELECT *
			FROM " . FORUMS_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
		}
		while( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['forum_trash'] )
			{
				return true;
			}
		}
		return false;
	}
}

if ( !(function_exists('renumber_order')) )
{
	function renumber_order($mode, $cat = 0)
	{
		global $db;

		switch($mode)
		{
			case 'category':
				$table = CATEGORIES_TABLE;
				$idfield = 'cat_id';
				$orderfield = 'cat_order';
				$cat = 0;
				break;

			case 'forum':
				$table = FORUMS_TABLE;
				$idfield = 'forum_id';
				$orderfield = 'forum_order';
				$catfield = 'cat_id';
				break;

			default:
				message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
				break;
		}

		$sql = "SELECT * FROM $table";
		if( $cat != 0)
		{
			$sql .= " WHERE $catfield = $cat";
		}
		$sql .= " ORDER BY $orderfield ASC";

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't get list of Categories", "", __LINE__, __FILE__, $sql);
		}

		$i = 10;
		$inc = 10;

		while( $row = $db->sql_fetchrow($result) )
		{
			$sql = "UPDATE $table
				SET $orderfield = $i
				WHERE $idfield = " . $row[$idfield];
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
			}
			$i += 10;
		}
		sql_cache('clear', 'multisqlcache_forum');
		sql_cache('clear', 'forum_data');
		sql_cache('clear', 'cat_list');
		sql_cache('clear', 'moderators_list');
	}
}
//
// End function block
// ------------------

//
// Begin program proper
//
if( isset($HTTP_POST_VARS['addforum']) || isset($HTTP_POST_VARS['addcategory']) )
{
	$mode = ( isset($HTTP_POST_VARS['addforum']) ) ? "addforum" : "addcat";

	if( $mode == "addforum" )
	{
		list($cat_id) = each($HTTP_POST_VARS['addforum']);
		$cat_id = intval($cat_id);
		// 
		// stripslashes needs to be run on this because slashes are added when the forum name is posted
		//
		$forumname = stripslashes($HTTP_POST_VARS['name'][$cat_id]);
	}
	
	if( $mode == "addcat" )
	{
		list($cat_id) = each($HTTP_POST_VARS['addcategory']);
		$cat_title = stripslashes($HTTP_POST_VARS['name'][$cat_id]);
		$cat_main = $cat_id;
		$cat_id = -1;
	}
}

if( !empty($HTTP_POST_VARS['password']) )
{
	if( !preg_match("#[A-Za-z0-9]{3,20}$#si", $HTTP_POST_VARS['password']) )
	{
		message_die(GENERAL_MESSAGE, $lang['Only_alpha_num_chars']);
	}
}



if( !empty($mode) )
{
	admin_check_cat();
	get_user_tree($userdata);
	switch($mode)
	{
		case 'addforum':
		case 'editforum':
			//
			// Show form to create/modify a forum
			//
			if ($mode == 'editforum')
			{
				// $newmode determines if we are going to INSERT or UPDATE after posting?

				$l_title = $lang['Edit_forum'];
				$newmode = 'modforum';
				$buttonvalue = $lang['Update'];

				$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

				$row = get_info('forum', $forum_id);

				$trash_exists = check_trash();

				if ( $row['forum_trash'] || !$trash_exists )
				{
					$trash_block = true;
					$template->assign_block_vars('forum_trash', array());
				}

				$cat_id = $row['cat_id'];
				$forumname = $row['forum_name'];
				$forumdesc = $row['forum_desc'];
				$forumstatus = $row['forum_status'];
				$main_type = $row['main_type'];
				if (!defined('SUB_FORUM_ATTACH'))
				{
					if (empty($main_type)) $main_type = POST_CAT_URL;
				}
				$forum_link				= $row['forum_link'];
				$forum_link_internal	= intval($row['forum_link_internal']);
				$forum_link_hit_count	= intval($row['forum_link_hit_count']);
				$forum_link_hit 		= intval($row['forum_link_hit']);
				$forumsort = $row['forum_sort'];
				$forum_password = $row['password'];
				$forum_color = $row['forum_color'];
				$forum_separate = $row['forum_separate'];
				$forum_show_ga = $row['forum_show_ga'];
				$forum_tree_req = $row['forum_tree_req'];
				$forum_tree_grade = $row['forum_tree_grade'];
				$forum_no_helped = $row['forum_no_helped'];
				$forum_no_split = $row['forum_no_split'];
				$topic_tags = $row['topic_tags'];
				$locked_bottom_ch = $row['locked_bottom'];

				//
				// start forum prune stuff.
				//
				if ( $row['prune_enable'] )
				{
					$prune_enabled = "checked=\"checked\"";
					$sql = "SELECT *
						FROM " . PRUNE_TABLE . "
						WHERE forum_id = $forum_id";
					if ( !$pr_result = $db->sql_query($sql) )
					{
						 message_die(GENERAL_ERROR, "Auto-Prune: Couldn't read auto_prune table.", __LINE__, __FILE__);
					}
					$pr_row = $db->sql_fetchrow($pr_result);
				}
				else
				{
					$prune_enabled = '';
				}
			}
			else
			{
				$l_title = $lang['Create_forum'];
				$newmode = 'createforum';
				$buttonvalue = $lang['Create_forum'];

				$forumdesc = '';
				$forumstatus = FORUM_UNLOCKED;
				$forum_password = '';
				$forum_color = '';
				$forum_id = 0;
				$main_type = POST_CAT_URL;
				$prune_enabled = 0;
				$forum_link	= '';
				$forum_link_internal = 0;
				$forum_link_hit_count = 0;
				$forum_link_hit = 0;
				$forumsort = 'SORT_FPDATE';
				$forum_separate = 2;
				$forum_show_ga = 1;
				$forum_tree_req = 0;
				$forum_tree_grade = 3;
				$forum_no_helped = 0;
				$forum_no_split = 0;
				$topic_tags = '';
				$locked_bottom_ch = 0;
			}

			$trash_exists = check_trash();
				
			if ( !$trash_exists && !$trash_block )
			{
				$template->assign_block_vars('forum_trash', array());
			}

			if ( $board_config['helped'] )
			{
				$template->assign_block_vars('helped', array());
			}
			else
			{
				$s_hidden_fields .= '<input type="hidden" name="forum_no_helped" value="0" />';
			}
			if ( $board_config['split_messages'] )
			{
				$template->assign_block_vars('split', array());
			}
			else
			{
				$s_hidden_fields .= '<input type="hidden" name="forum_no_split" value="0" />';
			}

			$catlist = get_tree_option( $main_type . $cat_id, true );

			$sort_list = array('SORT_FPDATE', 'SORT_TTIME', 'SORT_ALPHA', 'SORT_AUTHOR');
			$sort_list_lang = array($lang['Sort_fpdate'], $lang['Sort_ttime'], $lang['Sort_alpha'], $lang['Sort_author']);
			for($i = 0; $i < count($sort_list); $i++)
			{
				$sort_order .= '<option value="' . $sort_list[$i] . '"' . (($forumsort == $sort_list[$i]) ? ' selected="selected"' : '') . '>' . $sort_list_lang[$i] . '</option>';
			}

			$forumstatus == ( FORUM_LOCKED ) ? $forumlocked = "selected=\"selected\"" : $forumunlocked = "selected=\"selected\"";
			$statuslist = "<option value=\"" . FORUM_UNLOCKED . "\" $forumunlocked>" . $lang['Status_unlocked'] . "</option>\n";
			$statuslist .= "<option value=\"" . FORUM_LOCKED . "\" $forumlocked>" . $lang['Status_locked'] . "</option>\n";

			$template->set_filenames(array(
				"body" => "admin/forum_edit_body.tpl")
			);

			$s_hidden_fields .= '<input type="hidden" name="mode" value="' . $newmode .'" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			$template->assign_vars(array(
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_SUBMIT_VALUE' => $buttonvalue,
				'S_CAT_LIST' => $catlist,
				'S_STATUS_LIST' => $statuslist,
				'S_PRUNE_ENABLED' => $prune_enabled,
				'S_SORT_ORDER' => $sort_order,

				'L_FORUM_TITLE' => $l_title,
				'L_FORUM_EXPLAIN' => $lang['Forum_edit_delete_explain'],
				'L_FORUM_SETTINGS' => $lang['Forum_settings'],
				'L_FORUM_NAME' => $lang['Forum_name'],
				'L_CATEGORY' => $lang['Category'],
				'L_FORUM_DESCRIPTION' => $lang['Forum_desc'],
				'L_FORUM_STATUS' => $lang['Forum_status'],
				'L_PASSWORD' => $lang['Password'],
				'L_AUTO_PRUNE' => $lang['Forum_pruning'],
				'L_PRUNE_EXPLAIN' => $lang['Prune_explain'],
				'L_ENABLED' => $lang['Enabled'],
				'L_PRUNE_DAYS' => $lang['prune_days'],
				'L_PRUNE_FREQ' => $lang['prune_freq'],
				'L_DAYS' => $lang['Days'],
				'L_SORT' => $lang['Sort_by'],
				'L_LINK' => $lang['Forum_link'],
				'L_FORUM_LINK' => $lang['Forum_link_url'],
				'L_FORUM_LINK_EXPLAIN' => $lang['Forum_link_url_explain'],
				'L_FORUM_LINK_INTERNAL' => $lang['Forum_link_internal'],
				'L_FORUM_LINK_INTERNAL_EXPLAIN' => $lang['Forum_link_internal_explain'],
				'L_FORUM_LINK_HIT_COUNT' => $lang['Forum_link_hit_count'],
				'L_FORUM_LINK_HIT_COUNT_EXPLAIN' => $lang['Forum_link_hit_count_explain'],
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'L_COLOR' => $lang['Font_color'],
				'L_TREE_REQ' => $lang['Tree_req'],
				'L_TREE_GRADE' => $lang['Tree_req_grade'],
				'L_NO_HELPED' => $lang['Forum_no_helped'],
				'L_NO_SPLIT' => $lang['Forum_no_split'],
				'L_TOPIC_TAGS' => $lang['topic_tags'],
				'L_MODERATE' => $lang['Forum_moderate'],
				'L_MODERATE_E' => $lang['Forum_moderate_e'],
				'L_LOCKED_BOTTOM' => $lang['sort_methods'],
				'L_NO_COUNT' => $lang['No_count'],
				'L_FORUM_TRASH' => $lang['Forum_trash'],
				'L_FORUM_TRASH_E' => $lang['Forum_trash_e'],
				'L_SEPARATE_TOPICS' => $lang['Separate_topics'],
				'L_SEPARATE_TOTAL' => $lang['Separate_total'],
				'L_SEPARATE_MED' => $lang['Separate_med'],
				'L_SHOW_GLOBAL_ANN' => $lang['Show_global_announce'],

				'PRUNE_DAYS' => ( isset($pr_row['prune_days']) ) ? $pr_row['prune_days'] : 7,
				'PRUNE_FREQ' => ( isset($pr_row['prune_freq']) ) ? $pr_row['prune_freq'] : 1,
				'FORUM_LINK' => $forum_link,
				'FORUM_LINK_INTERNAL_YES' => ( $forum_link_internal) ? ' checked="checked"' : '',
				'FORUM_LINK_INTERNAL_NO' => (!$forum_link_internal) ? ' checked="checked"' : '',
				'FORUM_LINK_HIT_COUNT_YES' => ( $forum_link_hit_count) ? ' checked="checked"' : '',
				'FORUM_LINK_HIT_COUNT_NO' => (!$forum_link_hit_count) ? ' checked="checked"' : '',
				'FORUM_NAME' => xhtmlspecialchars($forumname),
				'MODERATE_CHECKED' => ($row['forum_moderate']) ? ' checked="checked"' : '',
				'LOCKED_CHECKED' => ($locked_bottom_ch) ? ' checked="checked"' : '',
				'NO_COUNT_CHECKED' => ($row['no_count']) ? ' checked="checked"' : '',
				'SEPARATE_0_CHECKED' => ($forum_separate == 0) ? ' checked="checked"' : '',
				'SEPARATE_1_CHECKED' => ($forum_separate == 1) ? ' checked="checked"' : '',
				'SEPARATE_2_CHECKED' => ($forum_separate == 2) ? ' checked="checked"' : '',
				'SHOW_GA_CHECKED' => ($forum_show_ga == 1) ? ' checked="checked"' : '',
				'TRASH_CHECKED' => ($row['forum_trash']) ? ' checked="checked"' : '',
				'COLOR_SELECT' => ($row['forum_color']) ? $row['forum_color'] : '',
				'TREE_CHECKED' => ($forum_tree_req) ? ' checked="checked"' : '',
				'TREE_GRADE' => $forum_tree_grade,
				'NO_HELPED' => ($forum_no_helped) ? ' checked="checked"' : '',
				'NO_SPLIT' => ($forum_no_split) ? ' checked="checked"' : '',
				'FORUM_PASSWORD' => $forum_password,
				'TOPIC_TAGS' => xhtmlspecialchars($topic_tags),
				'DESCRIPTION' => $forumdesc)
			);
			$template->pparse("body");
			break;

		case 'createforum':
			//
			// Create a forum in the DB
			//
			if( trim($HTTP_POST_VARS['forumname']) == "" )
			{
				message_die(GENERAL_ERROR, $lang['Forum_name_missing']);
			}

			$fid = $HTTP_POST_VARS[POST_CAT_URL];
			$type = substr($fid, 0, 1);
			$id = intval(substr($fid, 1));
			if ($fid == 'Root')
			{
				$id = 0;
				$type = POST_CAT_URL;
				if (!defined('SUB_FORUM_ATTACH'))
				{
					message_die(GENERAL_ERROR, $lang['Attach_root_wrong']);
				}
			}
			if ($type != POST_CAT_URL)
			{
				if (!defined('SUB_FORUM_ATTACH'))
				{
					message_die(GENERAL_ERROR, $lang['Attach_forum_wrong']);
				}
				if ($type == POST_FORUM_URL)
				{
					$athis = $tree['keys'][$type . $id];
					if (!empty($tree['data'][$athis]['forum_link']))
					{
						message_die(GENERAL_ERROR, $lang['Forum_attached_to_link_denied']);
					}
				}
			}
			$cat_id = $id;

			// get the last order
			$max_order = 0;
			$last = count($tree['data'])-1;
			if ($last >= 0) 
			{
				$max_order = ($tree['type'][$last] == POST_CAT_URL) ? $tree['data'][$last]['cat_order'] : $tree['data'][$last]['forum_order'];
			}
			$next_order = $max_order + 10;

			$sql = "SELECT MAX(forum_id) AS max_id
				FROM " . FORUMS_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't get order number from forums table", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$max_id = $row['max_id'];
			$next_id = $max_id + 1;

			//
			// Default permissions of public :: 
			//
			$field_sql = "";
			$value_sql = "";
			while( list($field, $value) = each($forum_auth_ary) )
			{
				$field_sql .= ", $field";
				$value_sql .= ", $value";
			}

			// There is no problem having duplicate forum names so we won't check for it.
			if (defined('SUB_FORUM_ATTACH'))
			{
				$field_sql .= ", main_type";
				$value_sql .= ", '$type'";
			}

			$forum_link	= isset($HTTP_POST_VARS['forum_link']) ? trim(stripslashes($HTTP_POST_VARS['forum_link'])) : '';
			$forum_link_internal = isset($HTTP_POST_VARS['forum_link_internal']) ? intval($HTTP_POST_VARS['forum_link_internal']) : 0;
			$forum_link_hit_count = isset($HTTP_POST_VARS['forum_link_hit_count']) ? intval($HTTP_POST_VARS['forum_link_hit_count']) : 0;
			$forum_status = (!$forum_link) ? intval($HTTP_POST_VARS['forumstatus']) : 1;

			$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id, forum_name, cat_id, forum_desc, forum_order, forum_status, forum_sort, password, forum_color, forum_moderate, no_count, forum_trash, forum_separate, forum_show_ga, prune_enable, forum_link, forum_link_internal, forum_link_hit_count, forum_tree_req, forum_tree_grade, forum_no_helped, forum_no_split, topic_tags, locked_bottom" . $field_sql . ")
				VALUES ('" . $next_id . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', $cat_id, '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', $next_order, " . $forum_status . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['forumsort']) . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['password']) . "', '" . str_replace("\'", "''", str_replace("#", "", $HTTP_POST_VARS['forum_color'])) . "', $post_moderate, $post_no_count, $forum_trash, " . intval($HTTP_POST_VARS['forum_separate']) . ", " . intval($HTTP_POST_VARS['forum_show_ga']) . ", " . intval($HTTP_POST_VARS['prune_enable']) . ", '$forum_link', $forum_link_internal, $forum_link_hit_count, " . intval($HTTP_POST_VARS['forum_tree_req']) . ", " . intval($HTTP_POST_VARS['forum_tree_grade']) . ", " . intval($HTTP_POST_VARS['forum_no_helped']) . ", " . intval($HTTP_POST_VARS['forum_no_split']) . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['topic_tags']) . "', $locked_bottom" . $value_sql . ")";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in forums table", "", __LINE__, __FILE__, $sql);
			}
			sql_cache('clear', 'multisqlcache_forum');
			sql_cache('clear', 'forum_data');
			sql_cache('clear', 'f_access');
			admin_check_cat();
			get_user_tree($userdata);
			move_tree('Root', 0, 0);
			sql_cache('clear', 'moderators_list');

			if( $HTTP_POST_VARS['prune_enable'] )
			{
				if( $HTTP_POST_VARS['prune_days'] == "" || $HTTP_POST_VARS['prune_freq'] == "")
				{
					message_die(GENERAL_MESSAGE, $lang['Set_prune_data']);
				}

				$sql = "INSERT INTO " . PRUNE_TABLE . " (forum_id, prune_days, prune_freq)
					VALUES('" . $next_id . "', " . intval($HTTP_POST_VARS['prune_days']) . ", " . intval($HTTP_POST_VARS['prune_freq']) . ")";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't insert row in prune table", "", __LINE__, __FILE__, $sql);
				}
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'modforum':
			if( trim($HTTP_POST_VARS['forumname']) == "" )
			{
				message_die(GENERAL_ERROR, $lang['Forum_name_missing']);
			}

			$fid = $HTTP_POST_VARS[POST_CAT_URL];
			$type = substr($fid, 0, 1);
			$id = intval(substr($fid, 1));
			if ($fid == 'Root')
			{
				$id = 0;
				$type = POST_CAT_URL;
				if (!defined('SUB_FORUM_ATTACH'))
				{
					message_die(GENERAL_ERROR, $lang['Attach_root_wrong']);
				}
			}
			if ($type != POST_CAT_URL)
			{
				if (!defined('SUB_FORUM_ATTACH'))
				{
					message_die(GENERAL_ERROR, $lang['Attach_forum_wrong']);
				}
				if ($type == POST_FORUM_URL)
				{
					$athis = $tree['keys'][$type . $id];
					if (!empty($tree['data'][$athis]['forum_link']))
					{
						message_die(GENERAL_ERROR, $lang['Forum_attached_to_link_denied']);
					}
				}
			}
			$cat_id = $id;
			// Modify a forum in the DB
			if( isset($HTTP_POST_VARS['prune_enable']))
			{
				if( $HTTP_POST_VARS['prune_enable'] != 1 )
				{
					$HTTP_POST_VARS['prune_enable'] = 0;
				}
			}
			$field_value_sql = '';
			$forum_link				= isset($HTTP_POST_VARS['forum_link']) ? trim(stripslashes($HTTP_POST_VARS['forum_link'])) : '';
			$forum_link_internal	= isset($HTTP_POST_VARS['forum_link_internal']) ? intval($HTTP_POST_VARS['forum_link_internal']) : 0;
			$forum_link_hit_count	= isset($HTTP_POST_VARS['forum_link_hit_count']) ? intval($HTTP_POST_VARS['forum_link_hit_count']) : 0;
			$forum_status = (!$forum_link) ? intval($HTTP_POST_VARS['forumstatus']) : 1;

			// check if link nothing is attached to the forum
			if (!empty($forum_link))
			{
				// forum_id
				$forum_id = intval($HTTP_POST_VARS[POST_FORUM_URL]);

				// search in tree if something is attached to
				if (isset($tree['sub'][POST_FORUM_URL . $forum_id]))
				{
					message_die(GENERAL_MESSAGE, $lang['Forum_link_with_attachment_deny']);
				}

				// is there some topics attached to ?
				$sql = "SELECT * FROM " . TOPICS_TABLE . " WHERE forum_id=$forum_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Couldn\'t access topics table', '', __LINE__, __FILE__, $sql);
				}
				if ($row = $db->sql_fetchrow($result))
				{
					message_die(GENERAL_MESSAGE, $lang['Forum_link_with_topics_deny']);
				}
			}

			$field_value_sql .= ", forum_link='$forum_link'";
			$field_value_sql .= ", forum_link_internal=$forum_link_internal";
			$field_value_sql .= ", forum_link_hit_count=$forum_link_hit_count";
			if (defined('SUB_FORUM_ATTACH'))
			{
				$field_value_sql .= ", main_type = '$type'";
			}

			$up_forum_id = intval($HTTP_POST_VARS[POST_FORUM_URL]);
			$old_count = (no_post_count($up_forum_id)) ? true : false;

			if ( ($old_count && $post_no_count) || (!$old_count && !$post_no_count) )
			{
				$sql = "SELECT post_id FROM " . POSTS_TABLE . "
					WHERE forum_id = $up_forum_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't get posts id", "", __LINE__, __FILE__, $sql);
				}

				$posts_to_count = '';
				while( $row_p = $db->sql_fetchrow($result) )
				{
					$posts_to_count .= ( ( $posts_to_count != '' ) ? ', ' : '' ) . $row_p['post_id'];
				}
				if ( $posts_to_count )
				{
					$sql = "SELECT poster_id, COUNT(post_id) AS posts 
						FROM " . POSTS_TABLE . " 
						WHERE post_id IN($posts_to_count) 
						GROUP BY poster_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
					}
					$count_sql = array();
					$do_what = (!$old_count && !$post_no_count) ? '+' : '-';
					while ( $row_pc = $db->sql_fetchrow($result) )
					{
						$count_sql[] = "UPDATE " . USERS_TABLE . " 
							SET user_posts = user_posts $do_what " . $row_pc['posts'] . "
							WHERE user_id = " . $row_pc['poster_id'];
					}
					$db->sql_freeresult($result);

					if ( sizeof($count_sql) )
					{
						for($i = 0; $i < sizeof($count_sql); $i++)
						{
							if ( !$db->sql_query($count_sql[$i]) )
							{
								message_die(GENERAL_ERROR, 'Could not update user post count information', '', __LINE__, __FILE__, $sql);
							}
						}
					}
				}
			}

			$sql = "SELECT cat_id
				FROM " . CATEGORIES_TABLE . "
				WHERE cat_id = $cat_id";
			if ( (!$result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't get forum data", "", __LINE__, __FILE__, $sql);
			}
			$crow = $db->sql_fetchrow($result);

			if ( $crow['cat_id'] ==! $cat_id && $cat_id == $up_forum_id )
			{
				message_die(GENERAL_MESSAGE, $lang['Wrong_category']);
			}

			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', cat_id = $cat_id, forum_desc = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', forum_status = " . $forum_status . ", forum_sort = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumsort']) . "', password = '" . str_replace("\'", "''", $HTTP_POST_VARS['password']) . "', forum_color = '" . str_replace("\'", "''", str_replace("#", "", $HTTP_POST_VARS['forum_color'])) . "', forum_moderate = $post_moderate, locked_bottom = $locked_bottom, no_count = $post_no_count, forum_trash = $forum_trash, forum_separate = " . intval($HTTP_POST_VARS['forum_separate']) . ", forum_show_ga = " . intval($HTTP_POST_VARS['forum_show_ga']) . ", forum_tree_req = " . intval($HTTP_POST_VARS['forum_tree_req']) . ", forum_tree_grade = " . intval($HTTP_POST_VARS['forum_tree_grade']) . ", forum_no_helped = " . intval($HTTP_POST_VARS['forum_no_helped']) . ", forum_no_split = " . intval($HTTP_POST_VARS['forum_no_split']) . ", topic_tags = '" . str_replace("\'", "''", $HTTP_POST_VARS['topic_tags']) . "', prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . $field_value_sql . "
				WHERE forum_id = $up_forum_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update forum information", "", __LINE__, __FILE__, $sql);
			}

			sql_cache('clear', 'multisqlcache_forum');
			sql_cache('clear', 'forum_data');
			sql_cache('clear', 'moderators_list');

			if( $HTTP_POST_VARS['prune_enable'] == 1 )
			{
				if( $HTTP_POST_VARS['prune_days'] == "" || $HTTP_POST_VARS['prune_freq'] == "" )
				{
					message_die(GENERAL_MESSAGE, $lang['Set_prune_data']);
				}

				$sql = "SELECT *
					FROM " . PRUNE_TABLE . "
					WHERE forum_id = " . intval($HTTP_POST_VARS[POST_FORUM_URL]);
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't get forum Prune Information","",__LINE__, __FILE__, $sql);
				}

				if( $db->sql_numrows($result) > 0 )
				{
					$sql = "UPDATE " . PRUNE_TABLE . "
						SET	prune_days = " . intval($HTTP_POST_VARS['prune_days']) . ", prune_freq = " . intval($HTTP_POST_VARS['prune_freq']) . "
						WHERE forum_id = " . intval($HTTP_POST_VARS[POST_FORUM_URL]);
				}
				else
				{
					$sql = "INSERT INTO " . PRUNE_TABLE . " (forum_id, prune_days, prune_freq)
						VALUES(" . intval($HTTP_POST_VARS[POST_FORUM_URL]) . ", " . intval($HTTP_POST_VARS['prune_days']) . ", " . intval($HTTP_POST_VARS['prune_freq']) . ")";
				}

				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't Update Forum Prune Information","",__LINE__, __FILE__, $sql);
				}
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'createcat':
			// Create a category in the DB
			if( trim($HTTP_POST_VARS['cat_title']) == '')
			{
				message_die(GENERAL_ERROR, $lang['Category_name_missing']);
			}
			$main = $HTTP_POST_VARS['cat_main'];
			if ($main == 'Root')
			{
				$cat_main_type = POST_CAT_URL;
				$cat_main = 0;
			}
			else
			{
				$cat_main_type = substr($main, 0, 1);
				$cat_main = intval(substr($main, 1));
			}
			if ($cat_main_type == POST_FORUM_URL)
			{
				$athis = $tree['keys'][$cat_main_type . $cat_main];
				if (!empty($tree['data'][$athis]['forum_link']))
				{
					message_die(GENERAL_ERROR, $lang['Forum_attached_to_link_denied']);
				}
			}

			// get the last order
			$max_order = 0;
			$last = count($tree['data'])-1;
			if ($last >= 0) 
			{
				$max_order = ($tree['type'][$last] == POST_CAT_URL) ? $tree['data'][$last]['cat_order'] : $tree['data'][$last]['forum_order'];
			}
			$next_order = $max_order + 10;

			//
			// There is no problem having duplicate forum names so we won't check for it.
			//
			$sql = "INSERT INTO " . CATEGORIES_TABLE . " (cat_title, cat_main_type, cat_main, cat_desc, cat_order)
				VALUES ('" . str_replace("\'", "''", $HTTP_POST_VARS['cat_title']) . "', '" . $cat_main_type . "', " . $cat_main . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['cat_desc']) . "', $next_order)";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in categories table", "", __LINE__, __FILE__, $sql);
			}
			sql_cache('clear', 'cat_list');
			admin_check_cat();
			get_user_tree($userdata);
			move_tree('Root', 0, 0);
			sql_cache('clear', 'moderators_list');

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'addcat':

		case 'editcat':
			//
			// Show form to edit a category
			//
			if ($mode == 'editcat')
			{
				$l_title = $lang['Edit_Category'];
			$newmode = 'modcat';
			$buttonvalue = $lang['Update'];

			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$row = get_info('category', $cat_id);
			$cat_title = $row['cat_title'];
				$cat_desc	= $row['cat_desc'];
				$cat_main	= $row['cat_main'];
				$cat_main_type = $row['cat_main_type'];
				if ($cat_main <= 0)
				{
					$cat_main = 0;
					$cat_main_type = POST_CAT_URL;
				}
			}
			else
			{
				$l_title = $lang['Create_category'];
				$newmode = 'createcat';
				$buttonvalue = $lang['Create_category'];

				$cat_desc = '';
				$cat_main_type = POST_CAT_URL;
				if ($cat_main <= 0)
				{
					$cat_main = 0;
				}
			}

			// get the list of cats/forums
			$catlist = get_tree_option($cat_main_type . $cat_main, true);

			$template->set_filenames(array(
				"body" => "admin/category_edit_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="' . POST_CAT_URL . '" value="' . $cat_id . '" />';

			$template->assign_vars(array(
				'CAT_TITLE' => $cat_title,
				'L_CAT_DESCRIPTION'	=> $lang['Category_desc'],
				'CAT_DESCRIPTION' => $cat_desc,
				'S_CAT_LIST' => $catlist,
				'L_CATEGORY_ATTACHMENT'	=> $lang['Category_attachment'],
				'L_EDIT_CATEGORY' => $l_title,
				'L_EDIT_CATEGORY_EXPLAIN' => $lang['Edit_Category_explain'], 
				'L_CATEGORY' => $lang['Category'], 

				'S_HIDDEN_FIELDS' => $s_hidden_fields, 
				'S_SUBMIT_VALUE' => $buttonvalue, 
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"))
			);

			$template->pparse("body");
			break;

		case 'modcat':
			// Modify a category in the DB
			if( trim($HTTP_POST_VARS['cat_title']) == '')
			{
				message_die(GENERAL_ERROR, $lang['Category_name_missing']);
			}
			$main = $HTTP_POST_VARS['cat_main'];
			if ($main == 'Root')
			{
				$cat_main_type = POST_CAT_URL;
				$cat_main = 0;
			}
			else
			{
				$cat_main_type = substr($main, 0, 1);
				$cat_main = intval(substr($main, 1));
			}
			if ($cat_main_type == POST_FORUM_URL)
			{
				$athis = $tree['keys'][$cat_main_type . $cat_main];
				if (!empty($tree['data'][$athis]['forum_link']))
				{
					message_die(GENERAL_ERROR, $lang['Forum_attached_to_link_denied']);
				}
			}

			// update db
			$sql = "UPDATE " . CATEGORIES_TABLE . "
				SET cat_title = '" . str_replace("\'", "''", $HTTP_POST_VARS['cat_title']) . "', cat_main_type='" . $cat_main_type . "', cat_main = " . $cat_main . ", cat_desc = '" . str_replace("\'", "''", $HTTP_POST_VARS['cat_desc']) . "'
				WHERE cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]);
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update forum information", "", __LINE__, __FILE__, $sql);
			}
			sql_cache('clear', 'cat_list');
			sql_cache('clear', 'moderators_list');
			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			admin_check_cat();
			
			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'deleteforum':
			// Show form to delete a forum
			$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

			$select_to = '<select name="to_id">';
			$select_to .= "<option value=\"-1\"$s>" . $lang['Delete_all_posts'] . "</option>\n";
			$select_to .= '<option value=""></option>';
			$select_to .= get_tree_option('', true); 
			$select_to .= '</select>';
			$buttonvalue = $lang['Move_and_Delete'];
			$newmode = 'movedelforum';
			$athis = $tree['keys'][POST_FORUM_URL . $forum_id];
			$name = $tree['data'][$athis]['forum_name'];
			$desc = $tree['data'][$athis]['forum_desc'];

			if ( !$name && $forum_id )
			{
				$sql = "SELECT forum_name, forum_desc
					FROM " . FORUMS_TABLE . "
					WHERE forum_id = $forum_id";
				if ( (!$result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Couldn't get forum data", "", __LINE__, __FILE__, $sql);
				}
				$trow = $db->sql_fetchrow($result);
				$name = $trow['forum_name'];
				$desc = $trow['forum_desc'];
			}

			$name_trad = get_object_lang(POST_FORUM_URL . $forum_id, 'name');
			$desc_trad = get_object_lang(POST_FORUM_URL . $forum_id, 'desc');
			if ($name != $name_trad) $name = '(' . $name . ') ' . $name_trad;
			if ($desc != $desc_trad) $desc = '(' . $desc . ') ' . $desc_trad;

			$template->set_filenames(array(
				"body" => "admin/forum_delete_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="from_id" value="' . $forum_id . '" />';

			$template->assign_vars(array(
				'NAME' => strip_tags($name),

				'L_FORUM_DELETE' => $lang['Forum_delete'],
				'L_FORUM_DELETE_EXPLAIN' => $lang['Forum_delete_explain'],
				'L_MOVE_CONTENTS' => $lang['Move_contents'],
				'L_FORUM_NAME' => $lang['Forum_name'],

				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_VALUE' => $buttonvalue)
			);

			$template->assign_vars(array(
				'DESC'			=> strip_tags($desc),
				'L_FORUM_DESC'	=> $lang['Forum_desc'],
				)
			);

			$template->pparse("body");
			break;

		case 'movedelforum':
			//
			// Move or delete a forum in the DB
			//
			$from_id = intval($HTTP_POST_VARS['from_id']);
			$to_fid = $HTTP_POST_VARS['to_id'];
			if (intval($to_fid) == -1)
			{
				$to_type = '';
				$to_id = -1;
			}
			else
			{
				$to_type	= substr($to_fid, 0, 1);
				$to_id = intval(substr($to_fid, 1));
				if (($to_type != POST_FORUM_URL) || ($to_fid == 'Root'))
				{
					message_die(GENERAL_MESSAGE, $lang['Only_forum_for_topics']);
				}
			}

			// check if sub-levels present
			if (!empty($tree['sub'][POST_FORUM_URL. $from_id]))
			{
				message_die(GENERAL_MESSAGE, $lang['Delete_forum_with_attachment_denied']);
			}
			$delete_old = intval($HTTP_POST_VARS['delete_old']);
			// Either delete or move all posts in a forum
			if ( $to_id == -1 )
			{
				include($phpbb_root_path . "includes/functions_remove.$phpEx");
				prune($from_id, 0, 'everything'); // Delete everything from forum
			}
			else
			{
				$sql = "SELECT *
					FROM " . FORUMS_TABLE . "
					WHERE forum_id IN ($from_id, $to_id)";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't verify existence of forums", "", __LINE__, __FILE__, $sql);
				}
				if($db->sql_numrows($result) != 2)
				{
					message_die(GENERAL_ERROR, "Ambiguous forum ID's", "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . TOPICS_TABLE . "
					SET forum_id = $to_id
					WHERE forum_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move topics to other forum", "", __LINE__, __FILE__, $sql);
				}

				$sql = "SELECT post_id FROM " . POSTS_TABLE . "
					WHERE forum_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't get posts id", "", __LINE__, __FILE__, $sql);
				}
				$recalculate_posts = array();
				while ( $row_posts = $db->sql_fetchrow($result) ) 
				{
					$recalculate_posts[] = $row_posts['post_id'];
				}
				recalculate_user_posts($from_id, $to_id, $recalculate_posts);

				$sql = "UPDATE " . POSTS_TABLE . "
					SET forum_id = $to_id
					WHERE forum_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move posts to other forum", "", __LINE__, __FILE__, $sql);
				}
				$sql = "UPDATE " . READ_HIST_TABLE . "
					SET forum_id = $to_id
					WHERE forum_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move topics to other forum", "", __LINE__, __FILE__, $sql);
				}
				sync('forum', $to_id);
			}

			// Alter Mod level if appropriate - 2.0.4
			$sql = "SELECT ug.user_id 
				FROM (" . AUTH_ACCESS_TABLE . " a, " . USER_GROUP_TABLE . " ug)
				WHERE a.forum_id <> $from_id 
					AND a.auth_mod = 1
					AND ug.group_id = a.group_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't obtain moderator list", "", __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$user_ids = '';
				do
				{
					$user_ids .= (($user_ids != '') ? ', ' : '' ) . $row['user_id'];
				}
				while ($row = $db->sql_fetchrow($result));

				$sql = "SELECT ug.user_id 
					FROM (" . AUTH_ACCESS_TABLE . " a, " . USER_GROUP_TABLE . " ug)
					WHERE a.forum_id = $from_id 
						AND a.auth_mod = 1 
						AND ug.group_id = a.group_id
						AND ug.user_id NOT IN ($user_ids)";
				if( !$result2 = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't obtain moderator list", "", __LINE__, __FILE__, $sql);
				}
					
				if ($row = $db->sql_fetchrow($result2))
				{
					$user_ids = '';
					do
					{
						$user_ids .= (($user_ids != '') ? ', ' : '' ) . $row['user_id'];
					}
					while ($row = $db->sql_fetchrow($result2));

					$sql = "UPDATE " . USERS_TABLE . " 
						SET user_level = " . USER . " 
						WHERE user_id IN ($user_ids) 
							AND user_level <> " . ADMIN;
					$db->sql_query($sql);
				}
				$db->sql_freeresult($result);

			}
			$db->sql_freeresult($result2);

			$sql = "DELETE FROM " . FORUMS_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum", "", __LINE__, __FILE__, $sql);
			}

			sql_cache('clear', 'multisqlcache_forum');
			sql_cache('clear', 'forum_data');
			sql_cache('clear', 'moderators_list');

			$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . PRUNE_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum prune information!", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'deletecat':
			//
			// Show form to delete a category
			//
			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$buttonvalue = $lang['Move_and_Delete'];
			$newmode = 'movedelcat';
			$athis = $tree['keys'][POST_CAT_URL . $cat_id];
			$name = $tree['data'][$athis]['cat_title'];
			$desc = $tree['data'][$athis]['cat_desc'];

			$name_trad = get_object_lang(POST_CAT_URL . $cat_id, 'name');
			$desc_trad = get_object_lang(POST_CAT_URL . $cat_id, 'desc');
			if ($name != $name_trad) $name = '(' . $name . ') ' . $name_trad;
			if ($desc != $desc_trad) $desc = '(' . $desc . ') ' . $desc_trad;

			// chek main category deletation
			if ($tree['main'][$athis] == 'Root')
			{
				// check if other main categories
				$found = false;
				for ($i=0; (($i < count($tree['data'])) && !$found); $i++)
				{
					$found = (($i != $athis) && ($tree['main'][$i] == 'Root'));
				}
				// no other main cats : check if forums presents
				if (!$found)
				{
					$found = false;
					for ($i=0; $i < count($tree['sub'][POST_CAT_URL . $from_id]); $i++)
					{
						$found = ($tree['type'][$tree['keys'][$tree['sub'][POST_CAT_URL . $cat_id][$i]]] == POST_FORUM_URL);
					}
					if ($found)
					{
						message_die(GENERAL_ERROR, $lang['Must_delete_forums']);
					}
				}
			}
			
			// get cat list
			$s_cat_list = get_tree_option('', true);
			$select_to = '<select name="to_id">' . $s_cat_list . '</select>';

			$template->set_filenames(array(
				"body" => "admin/forum_delete_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="from_id" value="' . $cat_id . '" />';

			$template->assign_vars(array(
				'NAME' => strip_tags($name),
				'L_FORUM_DELETE' => $lang['Category_delete'],
				'L_FORUM_DELETE_EXPLAIN' => $lang['Category_delete_explain'],
				'L_MOVE_CONTENTS' => $lang['Move_contents'], 
				'L_FORUM_NAME' => $lang['Category'],
				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"), 
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_VALUE' => $buttonvalue)
			);

			$template->assign_vars(array(
				'L_FORUM_DESC'	=> $lang['Category_desc'],
				'DESC'			=> strip_tags($desc),
				)
			);
			$template->pparse("body");
			break;

		case 'movedelcat':
			//
			// Move or delete a category in the DB
			//
			$from_id = intval($HTTP_POST_VARS['from_id']);
			$to_fid 	= $HTTP_POST_VARS['to_id'];
			$to_type	= substr($to_fid, 0, 1);
			$to_id		= intval(substr($to_fid, 1));

			if (!empty($to_id))
			{
				$sql = "SELECT *
					FROM " . CATEGORIES_TABLE . "
					WHERE cat_id IN ($from_id, $to_id)";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't verify existence of categories", "", __LINE__, __FILE__, $sql);
				}
				if($db->sql_numrows($result) != 2)
				{
					message_die(GENERAL_ERROR, "Ambiguous category ID's", "", __LINE__, __FILE__);
				}
				// check that there is no forum attached to the from cat (will issue to forum attached to forums)
				if (($to_type == POST_FORUM_URL) && !defined('SUB_FORUM_ATTACH'))
				{
					$found = false;
					for ($i=0; $i < count($tree['sub'][POST_CAT_URL . $from_id]); $i++)
					{
						$found = ($tree['type'][$tree['keys'][$tree['sub'][POST_CAT_URL . $from_id][$i]]] == POST_FORUM_URL);
					}
					if ($found)
					{
						message_die(GENERAL_ERROR, $lang['Must_delete_forums']);
					}
				}

				$sql_feed = '';
				$sql_where = '';
				if (defined('SUB_FORUM_ATTACH'))
				{
					$sql_feed = ", main_type='$to_type'";
					$sql_where = " AND main_type='" . POST_CAT_URL . "'";
				}
				$sql = "UPDATE " . FORUMS_TABLE . "
					SET cat_id = $to_id" . $sql_feed . "
					WHERE cat_id = $from_id" . $sql_where;
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move forums to other category", "", __LINE__, __FILE__, $sql);
				}
				sql_cache('clear', 'multisqlcache_forum');
				sql_cache('clear', 'forum_data');
				sql_cache('clear', 'moderators_list');
			}

			$sql = "DELETE FROM " . CATEGORIES_TABLE ."
				WHERE cat_id = $from_id";

			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete category", "", __LINE__, __FILE__, $sql);
			}

			sql_cache('clear', 'cat_list');
			sql_cache('clear', 'moderators_list');

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			admin_check_cat();
			
			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'forum_order':
			//
			// Change order of forums in the DB
			//
			$move = intval($HTTP_GET_VARS['move']);
			$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

			// update the level order
			move_tree(POST_FORUM_URL, $forum_id, $move);
			$show_index = TRUE;

			break;

		case 'cat_order':
			//
			// Change order of categories in the DB
			//
			$move = intval($HTTP_GET_VARS['move']);
			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			// update the level order
			move_tree(POST_CAT_URL, $cat_id, $move);

			// get ids
			$main	= $tree['main'][ $tree['keys'][POST_CAT_URL . $cat_id] ];
			$cat_id = $tree['id'][ $tree['keys'][$main] ];
			$show_index = TRUE;

			break;

		case 'forum_sync':
			sync('forum', intval($HTTP_GET_VARS[POST_FORUM_URL]));
			$show_index = TRUE;

			break;

		default:
			message_die(GENERAL_MESSAGE, $lang['No_mode']);
			break;
	}

	if ($show_index != TRUE)
	{
		include('./page_footer_admin.'.$phpEx);
		exit;
	}
}

//
// Start page proper
//
$template->set_filenames(array(
	"body" => "admin/forum_admin_body.tpl")
);

$template->assign_vars(array(
	'L_ACTION' => $lang['Action'],
	'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
	'L_FORUM_TITLE' => $lang['Forum_admin'],
	'L_FORUM_EXPLAIN' => $lang['Forum_admin_explain'],
	'L_CREATE_FORUM' => $lang['Create_forum'],
	'L_CREATE_CATEGORY' => $lang['Create_category'],
	'L_EDIT' => $lang['Edit'],
	'L_DELETE' => $lang['Delete'],
	'L_MOVE_UP' => $lang['Move_up'],
	'L_MOVE_DOWN' => $lang['Move_down'],
	'L_SHOW_ALL' => $lang['BM_Show'] . ' ' . $lang['All_forums'],
	'U_SHOW_ALL' => append_sid("admin_forums.$phpEx?listall=1"),
	'L_RESYNC' => $lang['Resync'])
);

if ( !(function_exists('display_admin_index')) )
{
	include($phpbb_root_path . 'includes/functions_hierarchy.'.$phpEx);
	function display_admin_index($cur='Root', $level=0, $max_level=-1)
	{
		global $template, $phpEx, $lang, $images;
		global $tree;

		// display the level
		$athis = isset($tree['keys'][$cur]) ? $tree['keys'][$cur] : -1;

		// root level
		if ($max_level==-1)
		{
			// get max inc level
			$keys = array();
			$max_level = get_max_depth($cur, true, -1, $keys);
			if ($cur != 'Root') $max_level++;
			$template->assign_vars(array(
				'INC_SPAN'		=> ($max_level+3),
				'INC_SPAN_ALL'	=> ($max_level+7),
				)
			);
		}

		// if forum index, omit one level
		if ($cur == 'Root') $level=-1;

		// sub-levels
		if ($athis >= -1)
		{
			// cat header row
			if ($tree['type'][$athis] == POST_CAT_URL)
			{
				// display a cat row
				$cat = $tree['data'][$athis];
				$cat_id = $tree['id'][$athis];

				// get the class colors
				$class_catLeft	 = "cat";
				$class_catMiddle = "cat";
				$class_catRight = "cat";

				$cat_title = $cat['cat_title'];
				$cat_title_trad = get_object_lang(POST_CAT_URL . $cat_id, 'name');
				if ($cat_title != $cat_title_trad) $cat_title = '(' . $cat_title . ') ' . $cat_title_trad;

				// send to template
				$template->assign_block_vars('catrow', array());
				$template->assign_block_vars('catrow.cathead', array(
					'CAT_ID'			=> $cat_id,
					'CAT_TITLE'			=> strip_tags($cat_title),

					'CLASS_CATLEFT' 	=> $class_catLeft,
					'CLASS_CATMIDDLE'	=> $class_catMiddle,
					'CLASS_CATRIGHT'	=> $class_catRight,
					'INC_SPAN'			=> $max_level - $level+3,
					'WIDTH' 			=> ($max_level == $level) ? 'width="50%"' : '',

					'U_CAT_EDIT'		=> append_sid("admin_forums.$phpEx?mode=editcat&amp;" . POST_CAT_URL . "=$cat_id"),
					'U_CAT_DELETE'		=> append_sid("admin_forums.$phpEx?mode=deletecat&amp;" . POST_CAT_URL . "=$cat_id"),
					'U_CAT_MOVE_UP' 	=> append_sid("admin_forums.$phpEx?mode=cat_order&amp;move=-15&amp;" . POST_CAT_URL . "=$cat_id"),
					'U_CAT_MOVE_DOWN'	=> append_sid("admin_forums.$phpEx?mode=cat_order&amp;move=15&amp;" . POST_CAT_URL . "=$cat_id"),
					'U_VIEWCAT'			=> append_sid("admin_forums.$phpEx?" . POST_CAT_URL . "=$cat_id"))
				);
				// add indentation to the display
				$rowspan = empty($cat['cat_desc']) ? 1 : 2;
				for ($k=1; $k <= $level; $k++) $template->assign_block_vars('catrow.cathead.inc', array('ROWSPAN' => $rowspan));

				if (!empty($cat['cat_desc']))
				{
					$cat_desc = $cat['cat_desc'];
					$cat_desc_trad = get_object_lang(POST_CAT_URL . $cat_id, 'desc');
					if ($cat_desc != $cat_desc_trad) $cat_desc = '(' . $cat_desc . ') ' . $cat_desc_trad;

					$template->assign_block_vars('catrow', array());
					$template->assign_block_vars('catrow.cattitle', array(
						'CAT_DESCRIPTION'	=> strip_tags($cat_desc),
						'INC_SPAN_ALL'		=> $max_level - $level+7,
						)
					);
				}
			}

			// forum header row
			if ($tree['type'][$athis] == POST_FORUM_URL)
			{
				$forum = $tree['data'][$athis];
				$forum_id = $tree['id'][$athis];
				$forum_link_img = '';
				if (!empty($tree['data'][$athis]['forum_link']))
				{
					$forum_link_img = '<img src="../' . $images['link'] . '" border="0" />';
				}
				else
				{
					$sub = (isset($tree['sub'][POST_FORUM_URL . $forum_id]));
					$forum_link_img = '<img src="../' . (($sub) ? $images['category'] : $images['forum']) . '" border="0" />';
					if ($tree['data'][$athis]['forum_status'] == FORUM_LOCKED)
					{
						$forum_link_img = '<img src="../' . (($sub) ? $images['category_locked'] : $images['forum_locked']) . '" border="0" />';
					}
				}

				$forum_name = $forum['forum_name'];
				$forum_name_trad = get_object_lang(POST_FORUM_URL . $forum_id, 'name');
				if ($forum_name != $forum_name_trad) $forum_name = '(' . $forum_name . ') ' . $forum_name_trad;

				$forum_desc = $forum['forum_desc'];
				$forum_desc_trad = get_object_lang(POST_FORUM_URL . $forum_id, 'desc');
				if ( $forum_desc != $forum_desc_trad )
				{
					$forum_desc = '(' . $forum_desc . ') ' . $forum_desc_trad;
				}

				$template->assign_block_vars('catrow', array());
				$template->assign_block_vars('catrow.forumrow', array(
					'LINK_IMG' => $forum_link_img,
					'FORUM_NAME' => strip_tags($forum_name),
					'FORUM_ID' => $forum_id,
					'FORUM_DESC' => strip_tags($forum_desc),
					'NUM_TOPICS' => $forum['forum_topics'],
					'NUM_POSTS'	=> $forum['forum_posts'],
					'FORUM_COLOR' => ($forum['forum_color'] != '') ? ' style="color: #' . $forum['forum_color'] . '"' : '',
					'INC_SPAN' => $max_level - $level+1,
					'WIDTH' => ($max_level == $level) ? 'width="50%"' : '',

					'U_VIEWFORUM' => append_sid("admin_forums.$phpEx?" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_EDIT' => append_sid("admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_DELETE' => append_sid("admin_forums.$phpEx?mode=deleteforum&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_MOVE_UP'	=> append_sid("admin_forums.$phpEx?mode=forum_order&amp;move=-15&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_MOVE_DOWN' => append_sid("admin_forums.$phpEx?mode=forum_order&amp;move=15&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_RESYNC' => append_sid("admin_forums.$phpEx?mode=forum_sync&amp;" . POST_FORUM_URL . "=$forum_id"))
				);
				// add indentation to the display
				for ($k=1; $k <= $level; $k++) $template->assign_block_vars('catrow.forumrow.inc', array());
			}

			// display the sub-level
			for ($i=0; $i < count($tree['sub'][$cur]); $i++)
			{
				display_admin_index($tree['sub'][$cur][$i], $level+1, $max_level);
			}

			// forum footer

			// cat footer
			if ($tree['type'][$athis] == POST_CAT_URL)
			{
				// add the footer
				$template->assign_block_vars('catrow', array());
				$template->assign_block_vars('catrow.catfoot', array(
					'S_ADD_FORUM_SUBMIT'	=> "addforum[$cat_id]",
					'S_ADD_CAT_SUBMIT'		=> "addcategory[$cat_id]",
					'S_ADD_NAME'			=> "name[$cat_id]",
					'INC_SPAN'				=> $max_level - $level+3,
					'INC_SPAN_ALL'			=> $max_level - $level+7,
					)
				);
				// add indentation to the display
				for ($k=1; $k <= $level; $k++) $template->assign_block_vars('catrow.catfoot.inc', array());
			}

			// board index footer
			if ($cur == 'Root')
			{
				$template->assign_block_vars('switch_board_footer', array());
				if (defined('SUB_FORUM_ATTACH'))
				{
					$template->assign_block_vars('switch_board_footer.sub_forum_attach', array());
				}
			}
		}
	}
}

// fix the cat_main value
admin_check_cat();

// read the cats/forums tree
get_user_tree($userdata);

// get the values of level selected
$main = 'Root';
if (!empty($cat_id))
{
	$main = POST_CAT_URL . $cat_id;
}
else if (!empty($forum_id))
{
	$main = $tree['main'][$forum_id];
	$main = $tree['main'][ $tree['keys'][POST_FORUM_URL . $forum_id] ];
}
if (!isset($tree['keys'][$main])) $main = 'Root';

// display the tree
display_admin_index($main);

$sql = "SELECT f.*
	FROM " . FORUMS_TABLE . " f
	LEFT JOIN " . CATEGORIES_TABLE . " c ON (f.cat_id = c.cat_id)
	WHERE c.cat_id IS NULL
	AND f.forum_id = f.cat_id";
if( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t verify existence of categories', '', __LINE__, __FILE__, $sql);
}
$i = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$i++;
	if ( $i == 1 )
	{
		$template->assign_block_vars('forums_shadow', array(
			'L_FORUMS_SHADOW' => $lang['Forums_shadow'],
			'L_NAME' => $lang['Forum_name'],
			'L_FORUM_ID' => 'Forum ID',
			'L_CAT_ID' => 'Cat ID',
			'L_TOPICS' => $lang['Topics'],
			'L_POSTS' => $lang['Posts'],
			'L_ACTION' => $lang['Action'],
			'L_EDIT' => $lang['Edit'],
			'L_DELETE' => $lang['Delete'])
		);
	}
	$template->assign_block_vars('forums_shadow.forums_shadow_list', array(
		'CLASS' => (!($i % 2)) ? '1' : '2',
		'FORUMS_NAME' => strip_tags($row['forum_name']),
		'FORUM_ID' => $row['forum_id'],
		'CAT_ID' => $row['cat_id'],
		'TOPICS' => $row['forum_topics'],
		'POSTS' => $row['forum_posts'],
		'U_DELETE' => append_sid("admin_forums.$phpEx?mode=deleteforum&amp;" . POST_FORUM_URL . "=" . $row['forum_id']),
		'U_EDIT' => append_sid("admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=" . $row['forum_id']),
		'U_FORUMS' => append_sid("../viewforum.$phpEx?" . POST_FORUM_URL . "=" . $row['forum_id']))
	);
}

if ( isset($HTTP_GET_VARS['listall']) )
{
	$template->assign_block_vars('all', array(
		'L_ALL_FORUMS' => $lang['All_forums'],
		'L_NAME' => $lang['Forum_name'],
		'L_FORUM_ID' => 'Forum ID',
		'L_CAT_ID' => 'Cat ID',
		'L_TOPICS' => $lang['Topics'],
		'L_POSTS' => $lang['Posts'],
		'L_ACTION' => $lang['Action'],
		'L_EDIT' => $lang['Edit'],
		'L_DELETE' => $lang['Delete'])
	);

	$sql = "SELECT * FROM " . CATEGORIES_TABLE . "
		ORDER by cat_title";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t query categories table', '', __LINE__, __FILE__, $sql);
	}
	$i = 0;
	while( $row = $db->sql_fetchrow($result) )
	{
		$i++;
		$template->assign_block_vars('all.list_all', array(
			'CLASS' => (!($i % 2)) ? '1' : '2',
			'FORUMS_NAME' => strip_tags($row['cat_title']),
			'FORUM_ID' => '-',
			'CAT_ID' => $row['cat_id'],
			'TOPICS' => '-',
			'POSTS' => '-',
			'U_DELETE' => append_sid("admin_forums.$phpEx?mode=deletecat&amp;" . POST_CAT_URL . "=" . $row['cat_id']),
			'U_EDIT' => append_sid("admin_forums.$phpEx?mode=editcat&amp;" . POST_CAT_URL . "=" . $row['cat_id']),
			'U_FORUMS' => append_sid("../index.$phpEx?" . POST_CAT_URL . "=" . $row['cat_id']))
		);
	}
	$sql = "SELECT * FROM " . FORUMS_TABLE . "
		ORDER by forum_name";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t query forums table', '', __LINE__, __FILE__, $sql);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$i++;
		$template->assign_block_vars('all.list_all', array(
			'CLASS' => (!($i % 2)) ? '1' : '2',
			'FORUMS_NAME' => strip_tags($row['forum_name']),
			'FORUM_ID' => $row['forum_id'],
			'CAT_ID' => $row['cat_id'],
			'TOPICS' => $row['forum_topics'],
			'POSTS' => $row['forum_posts'],
			'U_DELETE' => append_sid("admin_forums.$phpEx?mode=deleteforum&amp;" . POST_FORUM_URL . "=" . $row['forum_id']),
			'U_EDIT' => append_sid("admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=" . $row['forum_id']),
			'U_FORUMS' => append_sid("../viewforum.$phpEx?" . POST_FORUM_URL . "=" . $row['forum_id']))
		);
	}
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>