<?php
/***************************************************************************
 *                               functions.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/10/08 16:14
 *
 *   $Id: functions.php,v 1.133.2.38 2005/12/19 18:01:36 acydburn Exp $
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
 *
 ***************************************************************************/

//
// $nav_separator : used in the navigation sentence : ie Forum Index -> MainCat -> Forum -> Topic
// --------------
//--------------------------------------------------------------------------------------------------
$nav_separator = ' &raquo;&nbsp;';

// $tree : designed to get all the hierarchy
//	indexes :
//		- id : full designation : ie Root, f3, c20
//		- idx : rank order
//	$tree['keys'][id]			=> idx,
//	$tree['auth'][id]			=> auth_value array : ie tree['auth'][id]['auth_view'],
//	$tree['sub'][id]			=> array of sub-level ids,
//	$tree['main'][idx]			=> parent id,
//	$tree['type'][idx]			=> type of the row, can be 'c' for categories or 'f' for forums,
//	$tree['id'][idx]			=> value of the row id : cat_id for cats, forum_id for forums,
//	$tree['data'][idx]			=> db table row,
$tree = array();

function check_array_level($arr, $array_level, $int = false, $x = 0, $loop = false)
{
    if(is_array($arr)) {
        if(!$loop) $x = 0;
        foreach($arr as $k => $v) {
            if(is_array($v)) {
                if($x >= $array_level) return false;
                $x++;
                if(($arr[$k] = check_array_level($v, $array_level, $int, $x, true)) === false) return false;
            } elseif($int) $arr[$k] = intval($arr[$k]);
        }
    }
    return $arr;
}

function get_vars($name, $empty = false, $methods = 'POST,GET', $int = false, $array_level = 0)
{
    global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS;

    $methods = explode(',', $methods);
    foreach($methods as $var) {
        switch($var) {
            case 'COOKIE':
                if(isset($HTTP_COOKIE_VARS[$name])) {
                    if(!$array_level) return (!$int) ? $HTTP_COOKIE_VARS[$name] : intval($HTTP_COOKIE_VARS[$name]);
                    return check_array_level($HTTP_COOKIE_VARS[$name], $array_level, $int, $empty);
                }
                break;
            case 'POST':
                if(isset($HTTP_POST_VARS[$name])) {
                    if(!$array_level) {
                        if(!is_array($HTTP_POST_VARS[$name])) return (!$int) ? $HTTP_POST_VARS[$name] : intval($HTTP_POST_VARS[$name]);
                        return (!$int) ? $empty : intval($empty);
                    }
                    return check_array_level($HTTP_POST_VARS[$name], $array_level, $int, $empty);
                }
                break;
            case 'GET':
                if(isset($HTTP_GET_VARS[$name])) {
                    if(!$array_level) return (!$int) ? $HTTP_GET_VARS[$name] : intval($HTTP_GET_VARS[$name]);
                    return check_array_level($HTTP_GET_VARS[$name], $array_level, $int, $empty);
                }
                break;
        }
    }
    return (!$int) ? $empty : ( (!is_array($empty)) ? intval($empty) : $empty );
}

function space_clean(&$s)
{
	return; // this destroys utf8 encoding
    $c = array(chr(0xC2), chr(0xA0), chr(0x90), chr(0x9D), chr(0x81), chr(0x8D), chr(0x8F), chr(0xAD), chr(0x83));
    $s = str_replace($c, '', $s);
}

function var_adds(&$arr, $allowed_array, $space_clean = 'false')
{
    if(empty($arr)) return $arr;
    if(!is_array($arr)) exit;

    global $mquotes;

    foreach($arr as $k => $v) {
        if(is_array($v)) {
            if($allowed_array) {
                foreach($v as $k2 => $v2) {
                    if(is_array($v2)) exit;
                    if($space_clean) space_clean($arr[$k][$k2]);
                    if(!$mquotes) $arr[$k][$k2] = addslashes($arr[$k][$k2]);
                }
            } else unset($arr[$k]);
        } else {
            if($space_clean) space_clean($arr[$k]);
            if(!$mquotes) $arr[$k] = addslashes($arr[$k]);
        }
    }
}

function xhtmlspecialchars($s)
{
    return htmlspecialchars($s, ENT_COMPAT | ENT_HTML401, "UTF-8");
}

function get_object_lang($cur, $field)
{
	global $board_config, $lang, $tree;
	$res	= '';
	$athis	= $tree['keys'][$cur] ?? null;
	$type	= $tree['type'][$athis] ?? null;
	if ( $cur == 'Root' )
	{
		switch($field)
		{
			case 'name':
				if ( isset($lang[$board_config['sitename']]) )
				{
					$res = sprintf($lang['Forum_Index'], $lang[$board_config['sitename']]);
				}
				else
				{
					$res = sprintf($lang['Forum_Index'], $board_config['sitename']);
				}
				break;
			case 'desc':
				if ( isset($lang[$board_config['site_desc']]) )
				{
					$res = $lang[$board_config['site_desc']];
				}
				else
				{
					$res = $board_config['site_desc'];
				}
				break;
		}
	}
	else
	{
		switch($field)
		{
			case 'name':
				$field = ($type == POST_CAT_URL) ? 'cat_title' : 'forum_name';
				break;
			case 'desc':
				$field = ($type == POST_CAT_URL) ? 'cat_desc' : 'forum_desc';
				break;
		}
		$res = ($tree['auth'][$cur]['auth_view'] || defined('IN_ADMIN')) ? $tree['data'][$athis][$field] : '';
		if ( isset($lang[$res]) )
		{
			$res = $lang[$res];
		}
	}
	return replace_encoded($res);
}

function build_tree(&$cats, &$forums, &$new_topic_data, &$tracking_topics, &$tracking_forums, &$tracking_all, &$parents, $level = -1, $main = 'Root')
{
	global $db, $phpEx, $lang, $phpbb_root_path, $userdata, $user_ip;
	global $tree, $board_config, $readhist_buffer;

	$tree_level = array();

	// get the forums of the level
	$items = $parents[POST_FORUM_URL][$main] ?? null;
	if ($items) {
		for($i=0; $i < count($items); $i++)
		{
			$idx = $items[$i];
			$tree_level['type'][] = POST_FORUM_URL;
			$tree_level['id'][]	= $forums[$idx]['forum_id'];
			$tree_level['sort'][] = $forums[$idx]['forum_order'];
			$tree_level['data'][] = $forums[$idx];
		}
	}
	// add the categories of this level
	$items = $parents[POST_CAT_URL][$main] ?? null;
	if ($items) {
		for($i=0; $i < count($items); $i++)
		{
			$idx = $items[$i];
			$tree_level['type'][] = POST_CAT_URL;
			$tree_level['id'][]	= $cats[$idx]['cat_id'];
			$tree_level['sort'][] = $cats[$idx]['cat_order'];
			$tree_level['data'][] = $cats[$idx];
		}
	}

	// sort both
	if ( !empty($tree_level['data']) )
	{
		array_multisort($tree_level['sort'], $tree_level['type'], $tree_level['id'], $tree_level['data']);
	}

	// add the tree_level to the tree
	$level++;
	$order = 0;
	$items = $tree_level['data'] ?? null;
	if ($items) {
		for($i=0; $i < count($items); $i++)
		{
			$athis = empty($tree['data']) ? 0 : count($tree['data']);
			$key = $tree_level['type'][$i] . $tree_level['id'][$i];
			$order = $order + 10;
			$tree['keys'][$key] = $athis;
			$tree['main'][]	= $main;
			$tree['type'][]	= $tree_level['type'][$i];
			$tree['id'][] = $tree_level['id'][$i];
			$tree['data'][]	= $items[$i];

			$tree['sub'][$main][] = $key;

			// add sub levels
			build_tree($cats, $forums, $new_topic_data, $tracking_topics, $tracking_forums, $tracking_all, $parents, $level, $tree_level['type'][$i] . $tree_level['id'][$i]);
		}
	}
	return;
}

function read_tree()
{
	global $db, $userdata, $board_config, $HTTP_COOKIE_VARS;
	global $tree, $unique_cookie_name, $lang, $phpEx;

	// get censored words
	$orig_word = array();
	$replacement_word = array();
	$replacement_word_html = array();
	obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

	$parents = array(); $cats_lists = 'dat'; $cats = array(); $max_posts = 13121;
	$cat_d = (24 * 3600);

	$cat_list = sql_cache('check', 'cat_list');
	if (!empty($cat_list))
	{

		for($i=0; $i < count($cat_list); $i++)
		{
			$row = $cat_list[$i];
			if ( $row['cat_main'] == $row['cat_id'] )
			{
				$row['cat_main'] = 0;
			}
			if ( empty($row['cat_main_type']) )
			{
				$row['cat_main_type'] = POST_CAT_URL;
				$row['cat_order'] = $row['cat_order'] + 9000000;
			}
			$row['main'] = ($row['cat_main'] == 0) ? 'Root' : $row['cat_main_type'] . $row['cat_main'];
			$idx = count($cats);
			$cats[$idx] = $row;
			$parents[POST_CAT_URL][ $row['main'] ][] = $idx;
		}
	}
	else
	{
		$cat_list = array();
		$sql = "SELECT * FROM " . CATEGORIES_TABLE . "
			ORDER BY cat_order, cat_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t access list of Categories', '', __LINE__, __FILE__, $sql);
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$cat_list[] = $row;
			if ( $row['cat_main'] == $row['cat_id'] )
			{
				$row['cat_main'] = 0;
			}
			if ( empty($row['cat_main_type']) )
			{
				$row['cat_main_type'] = POST_CAT_URL;
				$row['cat_order'] = $row['cat_order'] + 9000000;
			}
			$row['main'] = ($row['cat_main'] == 0) ? 'Root' : $row['cat_main_type'] . $row['cat_main'];
			$idx = count($cats);
			$cats[$idx] = $row;
			$min_time = 1133694000;
			$parents[POST_CAT_URL][ $row['main'] ][] = $idx;
		}
		sql_cache('write', 'cat_list', $cat_list);
	}

	// read forums
	$forums = array();
	$sql = "SELECT f.*, p.post_time, p.post_username, p.post_approve, u.username, u.user_id, u.user_level, u.user_jr, t.topic_last_post_id, t.topic_title, t.topic_poster, t.topic_accept
		FROM " . FORUMS_TABLE . " f
			LEFT JOIN " . POSTS_TABLE . " p ON (p.post_id = f.forum_last_post_id)
			LEFT JOIN " . USERS_TABLE . " u ON (u.user_id = p.poster_id)
			LEFT JOIN " . TOPICS_TABLE . " t ON (t.topic_last_post_id = p.post_id AND t.forum_id = f.forum_id)
		ORDER BY f.forum_order, f.forum_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t access list of Forums', '', __LINE__, __FILE__, $sql);
	}
	while ($row = $db->sql_fetchrow($result))
	{
		$main_type = (empty($row['main_type'])) ? POST_CAT_URL : $row['main_type'];
		$row['main'] = ($row['cat_id'] == 0) ? 'Root' : $main_type . $row['cat_id'];
		if ( count($orig_word) )
		{
			$row['topic_title'] = preg_replace($orig_word, $replacement_word, $row['topic_title']);
		}
		$idx = count($forums);
		$forums[$idx] = $row;
		$parents[POST_FORUM_URL][ $row['main'] ][] = $idx;
	}

	$new_topic_data = $tracking_topics = $tracking_forums = $tracking_all = array();

	// build the tree
	$tree = array();
	build_tree($cats, $forums, $new_topic_data, $tracking_topics, $tracking_forums, $tracking_all, $parents);

	return;
}

function set_tree_user_auth()
{
	global $board_config, $userdata, $lang;
	global $tree;

	// read the tree from the bottom
	for($i = count($tree['data']) - 1; $i >= 0; $i--)
	{
		$cur = $tree['type'][$i] . $tree['id'][$i];
		$main = $tree['main'][$i];
		$main_idx = ($main == 'Root') ? -1 : $tree['keys'][$main];

		$auth_view = false;
		if ( isset($tree['auth'][$cur]['auth_view']) )
		{
			$auth_view = $tree['auth'][$cur]['auth_view'];
		}
		else if ( isset($tree['auth'][$cur]['tree.auth_view']) )
		{
			$auth_view = $tree['auth'][$cur]['tree.auth_view'];
		}
		$tree['auth'][$cur]['auth_view'] = $auth_view;
		if ( !isset($tree['auth'][$cur]['tree.auth_view']) )
		{
			$tree['auth'][$cur]['tree.auth_view'] = $auth_view;
		}

		// grant the main level
		if ( $main != 'Root' )
		{
			$tree['auth'][$main]['tree.auth_view'] = (!empty($tree['auth'][$main]['tree.auth_view']) || !empty($tree['auth'][$cur]['tree.auth_view']));
		}

		$auth_read = false;
		if ( isset($tree['auth'][$cur]['auth_read']) )
		{
			// forum auth
			$auth_read = $tree['auth'][$cur]['auth_read'];
		}
		$tree['auth'][$cur]['auth_read'] = $auth_read;

		$locked = true;
		if ( isset($tree['data'][$i]['forum_status']) )
		{
			$locked = ($tree['data'][$i]['forum_status'] == FORUM_LOCKED);
		}
		else if ( isset($tree['data'][$i]['tree.locked']) )
		{
			$locked = $tree['data'][$i]['tree.locked'];
		}
		$tree['data'][$i]['locked'] = $locked;

		if ( !isset($tree['data'][$i]['tree.locked']) )
		{
			$tree['data'][$i]['tree.locked'] = $locked;
		}
		$tree['data'][$i]['tree.locked'] = ($tree['data'][$i]['tree.locked'] && $locked);

		if ( !isset($tree['data'][$i]['tree.forum_posts']) )
		{
			$tree['data'][$i]['tree.forum_posts'] = 0;
			$tree['data'][$i]['tree.forum_topics'] = 0;
		}
		if ( $auth_view )
		{
			$tree['data'][$i]['tree.forum_posts'] += $tree['data'][$i]['forum_posts'] ?? 0;
			$tree['data'][$i]['tree.forum_topics'] += $tree['data'][$i]['forum_topics'] ?? 0;
		}

		if ( $main != 'Root' )
		{
			if ( !isset($tree['data'][$main_idx]['tree.locked']) )
			{
				$tree['data'][$main_idx]['tree.locked'] = $tree['data'][$i]['tree.locked'];
			}
			$tree['data'][$main_idx]['tree.locked'] = ($tree['data'][$main_idx]['tree.locked'] && $tree['data'][$i]['tree.locked']);

			if ( !isset($tree['data'][$main_idx]['tree.forum_posts']) )
			{
				$tree['data'][$main_idx]['tree.forum_posts'] = 0;
				$tree['data'][$main_idx]['tree.forum_topics'] = 0;
			}
			if ( $auth_view )
			{
				$tree['data'][$main_idx]['tree.forum_posts'] += $tree['data'][$i]['tree.forum_posts'];
				$tree['data'][$main_idx]['tree.forum_topics'] += $tree['data'][$i]['tree.forum_topics'];
			}
		}

		if ( $auth_read )
		{
			// fill the sub
			if ( empty($tree['data'][$i]['tree.topic_last_post_id']) || ($tree['data'][$i]['post_time'] > $tree['data'][$i]['tree.post_time']) )
			{
				$tree['data'][$i]['tree.topic_last_post_id'] = $tree['data'][$i]['topic_last_post_id'];
				$tree['data'][$i]['tree.post_time']	= $tree['data'][$i]['post_time'];
				$tree['data'][$i]['tree.post_user_id'] = $tree['data'][$i]['user_id'];
				$tree['data'][$i]['tree.post_username'] = ($tree['data'][$i]['user_id'] != ANONYMOUS) ? $tree['data'][$i]['username'] : ( (!empty($tree['data'][$i]['post_username'])) ? $tree['data'][$i]['post_username'] : $lang['Guest'] );

				$tree['data'][$i]['tree.user_level'] = $tree['data'][$i]['user_level'];
				$tree['data'][$i]['tree.user_jr'] = $tree['data'][$i]['user_jr'];
				$tree['data'][$i]['tree.topic_title'] = $tree['data'][$i]['topic_title'];
				$tree['data'][$i]['tree.topic_accept'] = $tree['data'][$i]['topic_accept'];
				$tree['data'][$i]['tree.topic_poster'] = $tree['data'][$i]['topic_poster'];

			}
		}

		// grant the main level
		if ( $main != 'Root' )
		{
			if ( empty($tree['data'][$main_idx]['tree.topic_last_post_id']) || ($tree['data'][$i]['tree.post_time'] > $tree['data'][$main_idx]['tree.post_time']) )
			{
				$tree['data'][$main_idx]['tree.topic_last_post_id']	= $tree['data'][$i]['tree.topic_last_post_id'];
				$tree['data'][$main_idx]['tree.post_time'] = $tree['data'][$i]['tree.post_time'];
				$tree['data'][$main_idx]['tree.post_user_id'] = $tree['data'][$i]['tree.post_user_id'];
				$tree['data'][$main_idx]['tree.post_username'] = $tree['data'][$i]['tree.post_username'];
				$tree['data'][$main_idx]['tree.user_level'] = $tree['data'][$i]['tree.user_level'];
				$tree['data'][$main_idx]['tree.user_jr'] = $tree['data'][$i]['tree.user_jr'];
				$tree['data'][$main_idx]['tree.topic_title'] = $tree['data'][$i]['tree.topic_title'];
				$tree['data'][$main_idx]['tree.topic_accept'] = $tree['data'][$i]['tree.topic_accept'];
				$tree['data'][$main_idx]['tree.topic_poster'] = $tree['data'][$i]['tree.topic_poster'];

			}
		}
	}
}

function get_user_tree(&$userdata)
{
	global $tree;

	if ( empty($tree) )
	{
		read_tree();
	}

	// read the user auth if requiered
	if ( empty($tree['auth']) )
	{
		$tree['auth'] = array();
		$wauth = auth(AUTH_ALL, AUTH_LIST_ALL, $userdata);
		if ( !empty($wauth) )
		{
			reset($wauth);
			foreach($wauth as $key => $data)
			{
				$tree['auth'][POST_FORUM_URL . $key] = $data;
			}
		}

		// enhanced each level
		set_tree_user_auth();
	}
	return;
}

function get_auth_keys($cur = 'Root', $all = false, $level = -1, $max = -1, $auth_key = 'auth_view')
{
	global $board_config;
	global $tree, $userdata;

	$keys = array();
	$last_i = -1;

	// add the level

	if ( ($cur == 'Root') || $tree['auth'][$cur][$auth_key] || $all )
	{
		// push the level
		if ( ($max < 0) || ($level < $max) || (($level == $max) && ((substr($tree['main'][$tree['keys'][$cur]], 0, 1) == POST_CAT_URL) || ($tree['main'][$tree['keys'][$cur]] == 'Root') )) )
		{
			// if child of cat, align the level on the parent one
			$orig_level = $level;
			if ( !$all )
			{
				$board_config['sub_forum'] = (!$board_config['sub_forum_over']) ? $userdata['user_sub_forum'] : $board_config['sub_forum'];
				if ( ($level > 0) && ((substr($cur, 0, 1) == POST_FORUM_URL) || (intval($board_config['sub_forum']) > 0)) && (substr($tree['main'][$tree['keys'][$cur]], 0, 1) == POST_CAT_URL) )
				{
					$level = $level - 1;
				}
			}

			// store this level
			$last_i++;
			$keys['keys'][$cur]	= $last_i;
			$keys['id'][$last_i] = $cur;
			$keys['real_level'][$last_i] = $orig_level;
			$keys['level'][$last_i]	= $level;
			$keys['idx'][$last_i] = (isset($tree['keys'][$cur]) ? $tree['keys'][$cur] : -1);

			// get sub-levels
			$items = isset($tree['sub'][$cur]) ? $tree['sub'][$cur] : false;
			if ($items) {
				for($i=0; $i < count($items); $i++)
				{
					$tkeys = array();
					$tkeys = get_auth_keys($tree['sub'][$cur][$i], $all, $orig_level+1, $max, $auth_key);

					// add sub-levels
					$subitems = $tkeys['id'] ?? null;
					if ($subitems) {
						for($j=0; $j < count($subitems); $j++)
						{
							$last_i++;
							$keys['keys'][$tkeys['id'][$j]] = $last_i;
							$keys['id'][$last_i] = $tkeys['id'][$j];
							$keys['real_level'][$last_i] = $tkeys['real_level'][$j];
							$keys['level'][$last_i]	= $tkeys['level'][$j];
							$keys['idx'][$last_i] = $tkeys['idx'][$j];
						}
					}
				}
			}
		}
	}

	return $keys;
}

function get_tree_option($cur = '', $all = false, $admin_config = false, $admin_ids = '')
{
	global $tree, $lang, $admin_select_key;

	$keys = array();
	$keys = get_auth_keys('Root', $all);
	$res = '';
	if ( $admin_ids )
	{
		$admin_ids = explode(',', $admin_ids);
	}

	for($i=0; $i < count($keys['id']); $i++)
	{
		if(!$admin_select_key)
		{
			$val_if = ( !empty($tree['type'][ $keys['idx'][$i] ]) && ($tree['type'][ $keys['idx'][$i] ] != POST_FORUM_URL) || empty($tree['data'][ $keys['idx'][$i] ]['forum_link']) )  ? true:false;
		}
		else
		{
			$val_if = true;
		}
		
		// only get object that are not forum links type
		if ( $val_if )
		{
			if ( $admin_config )
			{
				if ( $tree['type'][ $keys['idx'][$i]] == POST_FORUM_URL )
				{
					$selected = (@in_array(str_replace(POST_FORUM_URL, '', $keys['id'][$i]), $admin_ids)) ? ' selected="selected"' : '';
					$res .= '<option value="' . $keys['id'][$i] . '"' . $selected . '>';
				}
			}
			else
			{
				$selected = ($cur == $keys['id'][$i]) ? ' selected="selected"' : '';
				$res .= '<option value="' . $keys['id'][$i] . '"' . $selected . '>';
			}
			// name
			$name = get_object_lang($keys['id'][$i], 'name');
			$name = strip_tags($name);

			// increment
			$inc = '';
			for($k=1; $k <= $keys['real_level'][$i]; $k++)
			{
				$inc .= '|&nbsp;&nbsp;&nbsp;';
			}
			if ( $keys['level'][$i] >= 0 )
			{
				$inc .= '|--';
			}
			$name = $inc . $name;

			$res .= $name . '</option>';
		}
	}
	return $res;
}

function make_cat_nav_tree($cur, $pgm = '', $nav_class = 'nav')
{
	global $phpbb_root_path, $phpEx, $db;
	global $global_orig_word, $global_replacement_word;
	global $nav_separator, $HTTP_GET_VARS;
	global $tree, $nav_data;

	// get topic or post level
	$type = substr($cur, 0, 1);
	$id = intval(substr($cur,1));
	$topic_title = '';
	$fcur = '';
	if ( $nav_data )
	{
		// CH suck so much... :/ I hope it's last improvement for CH
		$row['forum_id'] = $nav_data[0];
		$row['topic_title'] = $nav_data[1];
	}

	switch ($type)
	{
		case POST_TOPIC_URL:
			if ( !$nav_data )
			{
				$sql = "SELECT forum_id, topic_title 
					FROM " . TOPICS_TABLE . "
					WHERE topic_id = $id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query topics information', '', __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);
			}

			$fcur = POST_FORUM_URL . $row['forum_id'];
			$topic_title = (!isset($HTTP_GET_VARS['view'])) ? $row['topic_title'] : '';
			$orig_word = array();
			$replacement_word = array();
			$replacement_word_html = array();
			obtain_word_list($orig_word, $replacement_word, $replacement_word_html);
			if ( count($orig_word) )
			{
				$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
			}

			break;
		case POST_POST_URL:
			if ( !$nav_data )
			{
				$sql = "SELECT t.forum_id, t.topic_title 
					FROM (" . POSTS_TABLE . " p, " . TOPICS_TABLE . " t)
					WHERE t.topic_id = p.topic_id
						AND post_id = $id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query posts information', '', __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);
			}

			$fcur = POST_FORUM_URL . $row['forum_id'];
			$topic_title = $row['topic_title'];
			$orig_word = array();
			$replacement_word = array();
			$replacement_word_html = array();
			obtain_word_list($orig_word, $replacement_word, $replacement_word_html);
			if ( count($orig_word) )
			{
				$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
			}
			break;
	}

	// keep the compliancy with prec versions
	if ( !isset($tree['keys'][$cur]) )
	{
		$cur = isset($tree['keys'][POST_CAT_URL . $cur]) ? POST_CAT_URL . $cur : $cur;
	}

	// find the object
	$athis = isset($tree['keys'][$cur]) ? $tree['keys'][$cur] : -1;

	$res = '';
	while (($athis >= 0) || ($fcur != ''))
	{
		$type = (substr($fcur, 0, 1) != '') ? substr($cur, 0, 1) : $tree['type'][$athis];
		switch($type)
		{
			case POST_CAT_URL:
				$field_name		= get_object_lang($cur, 'name');
				$param_type		= POST_CAT_URL;
				$param_value	= $tree['id'][$athis];
				$pgm_name		= "index.$phpEx";
				break;
			case POST_FORUM_URL:
				$field_name		= get_object_lang($cur, 'name');
				$param_type		= POST_FORUM_URL;
				$param_value	= $tree['id'][$athis];
				$pgm_name		= "viewforum.$phpEx";
				break;
			case POST_TOPIC_URL:
				$field_name		= replace_encoded($topic_title);
				$param_type		= POST_TOPIC_URL;
				$param_value	= $id;
				$pgm_name		= "viewtopic.$phpEx";
				break;
			case POST_POST_URL:
				$field_name		= replace_encoded($topic_title);
				$param_type		= POST_POST_URL;
				$param_value	= $id . '#' . $id;
				$pgm_name		= "viewtopic.$phpEx";
				break;
			default :
				$field_name		= '';
				$param_type		= '';
				$param_value	= '';
				$pgm_name		= "index.$phpEx";
				break;
		}
		if ( $pgm != '' )
		{
			$pgm_name = $pgm.$phpEx;
		}

		if ( !empty($field_name) )
		{
			$res = '<a href="' . append_sid('./' . $pgm_name . (($field_name != '') ? "?$param_type=$param_value" : '')) . '" class="' . $nav_class . '">' . $field_name . '</a>' . (($res != '') ? $nav_separator . $res : '');
		}

		// find parent object
		if ( $fcur != '' )
		{
			$cur = $fcur;
			$pgm = '';
			$fcur = '';
			$topic_title = '';
		}
		else
		{
			$cur = $tree['main'][$athis];
		}
		$athis = isset($tree['keys'][$cur]) ? $tree['keys'][$cur] : -1;
	}

	return $res;
}

function selectbox($box_name, $ignore_forum = false, $select_forum = '')
{
	$s_id = ($select_forum != '') ? POST_FORUM_URL . $select_forum : '';
	$s_list = get_tree_option($select_forum);
	$res = '<select name="' . $box_name . '">' . $s_list . '</select>';
	return $res;
}

function get_db_stat($mode)
{
	global $board_config;
	return ($mode == 'newestuser') ? unserialize($board_config[$mode]) : $board_config[$mode];
}

function db_stat_update($mode)
{
	global $db, $board_config;

	switch( $mode )
	{
		case 'newestuser':
			$sql = "SELECT username, user_id
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS . "
				ORDER BY user_id DESC
				LIMIT 1";

			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get newest username', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$sql = "UPDATE " . CONFIG_TABLE . "
				SET config_value = '" . str_replace("'", "''", serialize($row)) . "'
				WHERE config_name = 'newestuser'";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Error in updating config table', '', __LINE__, __FILE__, $sql);
			}
			$sql = "SELECT COUNT(user_id) AS total
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting total users from users table', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			update_config('usercount', $row['total']);

		break;

		case 'posttopic':
			$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . FORUMS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get usercount', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			update_config('topiccount', $row['topic_total']);
			update_config('postcount', $row['post_total']);

		break;
	}
	return;
}

function get_userdata($user, $force_str = false, $field = '*')
{
	global $db;

	if (!is_numeric($user) || $force_str)
	{
		$user = phpbb_clean_username($user);
	}
	else
	{
		$user = intval($user);
	}

	$sql = "SELECT $field
		FROM " . USERS_TABLE . " 
		WHERE ";
	$sql .= ( ( is_integer($user) ) ? "user_id = $user" : "username = '" .  str_replace("\'", "''", $user) . "'" ) . " AND user_id <> " . ANONYMOUS;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
	}

	return ( $row = $db->sql_fetchrow($result) ) ? $row : false;
}

function phpbb_clean_username($username)
{
	$username = substr(xhtmlspecialchars(str_replace("\'", "'", trim($username))), 0, 25);
	$username = phpbb_rtrim($username, "\\");	
	$username = str_replace("'", "\'", $username);

	return $username;
}

function phpbb_rtrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return rtrim($str);
	}
	return rtrim($str, $charlist);
}

function make_jumpbox($action, $match_forum_id = 0)
{
	global $template, $userdata, $lang, $db, $nav_links, $phpEx, $SID;
	global $links;

	// build the jumpbox
	$boxstring = '<select name="selected_id" onchange="if(this.options[this.selectedIndex].value != -1){ this.form.submit(); }">';
	$boxstring .= '<option value="-1">' . $lang['Select_forum'] . '</option><option value="-1"></option>' . get_tree_option(POST_FORUM_URL . $match_forum_id);
	$boxstring .= '</select><input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

	$template->vars(array(
		'L_GO' => $lang['Go'],
		'L_JUMP_TO' => $lang['Jump_to'],
		'L_SELECT_FORUM' => $lang['Select_forum'],

		'S_JUMPBOX_SELECT' => $boxstring,
		'S_JUMPBOX_ACTION' => append_sid($action))
	);
	$template->var('JUMPBOX', $template->render('jumpbox.tpl'));

	return;
}

//
// Initialise user settings on page load
function init_userprefs($userdata, $get_user_tree=true)
{
	global $db, $board_config, $theme, $images;
	global $template, $lang, $phpEx, $phpbb_root_path;
	global $nav_links, $unique_cookie_name, $HTTP_POST_VARS, $HTTP_COOKIE_VARS;

	$board_config['real_default_lang'] = $board_config['default_lang'];

	if ( $userdata['user_id'] != ANONYMOUS )
	{
		if ( !empty($userdata['user_lang']) )
		{
			$board_config['default_lang'] = $userdata['user_lang'];
		}

		if ( isset($userdata['user_timezone']) )
		{
			$board_config['board_timezone'] = $userdata['user_timezone'];
		}
	}
	if ( !empty($userdata['user_dateformat']) )
	{
		$board_config['default_dateformat'] = $userdata['user_dateformat'];
	}

	if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx)) )
	{
		$board_config['default_lang'] = 'english';
	}

	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);

	if ( defined('IN_ADMIN') )
	{
		if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.'.$phpEx)) )
		{
			$board_config['default_lang'] = 'english';
		}

		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
	}
	$language = $board_config['default_lang'];

	if ( defined('ATTACHMENTS_ON') )
	{
		if (file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_main_attach.'.$phpEx))
		{
			include($phpbb_root_path . 'language/lang_' . $language . '/lang_main_attach.' . $phpEx);
		}

		if (defined('IN_ADMIN'))
		{
			if (file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_admin_attach.'.$phpEx))
			{
				include($phpbb_root_path . 'language/lang_' . $language . '/lang_admin_attach.' . $phpEx);
			}
		}
	}

	global $tree;
	if ( $get_user_tree && empty($tree['auth']) && !defined('SHOUTBOX') )
	{
		get_user_tree($userdata);
	}

	if ( $userdata['user_id'] == ANONYMOUS && $board_config['anonymous_simple'] )
	{
		$board_config['onmouse'] = $board_config['cload'] = $board_config['cstat'] = $board_config['clevell'] = $board_config['cleveld'] = $board_config['clevelp'] = $board_config['cagent'] = $board_config['u_o_t_d'] = $board_config['overlib'] = '';
	}

	if ( $userdata['user_id'] == ANONYMOUS )
	{
		$default_cookie_style = $unique_cookie_name . '_default_style';

		if ( isset($HTTP_POST_VARS['template']) )
		{
			setcookie($default_cookie_style, $HTTP_POST_VARS['template'] , (CR_TIME + 21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

		}
		else if (isset($HTTP_COOKIE_VARS[$default_cookie_style]) )
		{
			$board_config['real_default_style'] = $board_config['default_style'];
			$board_config['default_style'] = $HTTP_COOKIE_VARS[$default_cookie_style];
		}
	}

	//
	// Show 'Board is disabled' message if needed.
	//
	if ( $board_config['disable_type'] == 1 && $userdata['user_level'] != ADMIN && !defined('IN_LOGIN') )
	{
		if ( $board_config['board_disable'] == 'db_backup_progress' )
		{
			if ( $board_config['db_backup_time'] < (CR_TIME - 300) )
			{
				update_config('board_disable', '');
				update_config('disable_type', '');
			}
			else
			{
				message_die(GENERAL_MESSAGE, $lang['Board_disable'] . '<br /><br />' . $lang['Reason'] . ': Database backup in progress please wait few seconds.');
			}
		}
		else
		{
			$reason = $lang['Board_disable'];
			$reason .= ($board_config['board_disable']) ? '<br /><br />' . $lang['Reason'] . ': ' . str_replace("\n", "\n<br />\n", $board_config['board_disable']) : '';

			message_die(GENERAL_MESSAGE, $reason);
		}
	}

	if ( !$board_config['override_user_style'] )
	{
		if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_style'] > 0 )
		{
			if ( $theme = setup_style($userdata['user_style']) )
			{
				return;
			}
		}
	}

	$theme = setup_style($board_config['default_style']);

	//
	// Mozilla navigation bar
	// Default items that should be valid on all pages.
	// Defined here to correctly assign the Language Variables
	// and be able to change the variables within code.
	//
	$nav_links['top'] = array ( 
		'url' => append_sid($phpbb_root_path . 'index.' . $phpEx),
		'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
	);
	$nav_links['search'] = array ( 
		'url' => append_sid($phpbb_root_path . 'search.' . $phpEx),
		'title' => $lang['Search']
	);
	$nav_links['help'] = array ( 
		'url' => append_sid($phpbb_root_path . 'faq.' . $phpEx),
		'title' => $lang['FAQ']
	);
	$nav_links['author'] = array ( 
		'url' => append_sid($phpbb_root_path . 'memberlist.' . $phpEx),
		'title' => $lang['Memberlist']
	);

	return;
}

function setup_style($style)
{
	return false;
	global $db, $board_config, $template, $images, $phpbb_root_path;

	$sql = "SELECT *
		FROM " . THEMES_TABLE . "
		WHERE themes_id = $style";

	$cache_string = 'multisqlcache_themes_' . $style;

	$row = sql_cache('check', $cache_string);
	if (!empty($row))
	{
		$right_template = true;
	}
	else
	{
		$result = $db->sql_query($sql);
		if ( $row = $db->sql_fetchrow($result) )
		{
			$right_template = true;
			sql_cache('write', $cache_string, $row);
		}
	}

	if ( !$right_template )
	{
		$sql = "SELECT *
			FROM " . THEMES_TABLE . "
			LIMIT 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not query database for theme info<br />' . $sql);
		}
		$row = $db->sql_fetchrow($result);
		if ( !$row )
		{
			message_die(CRITICAL_ERROR, 'Could not get theme data for themes_id [' . $style . ']');
		}
	}

	$template_path = 'templates/';
	$template_name = $row['template_name'] ;

	//$template = new Template($phpbb_root_path . $template_path . $template_name);
	$template = \PhpBB\Core\Context::getService('templates');

	if ( $template )
	{
		$current_template_path = $template_path . $template_name;
		@include($phpbb_root_path . $template_path . $template_name . '/' . $template_name . '.cfg');

		if ( !defined('TEMPLATE_CONFIG') )
		{
			message_die(CRITICAL_ERROR, 'Could not open ' . $template_name . ' template config file', '', __LINE__, __FILE__);
		}

		$img_lang = ( file_exists(@phpbb_realpath($phpbb_root_path . $current_template_path . '/images/lang_' . $board_config['default_lang'])) ) ? $board_config['default_lang'] : 'english';

		while( list($key, $value) = @each($images) )
		{
			if ( !is_array($value) )
			{
				$images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
			}
		}
	}

	return $row;
}

function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}


//
// Create date/time from format and timezone
//
function create_date($format, $gmepoch, $tz, $no_today = false)
{
	global $board_config, $lang;
	static $translate;

	if ( empty($translate) && $board_config['default_lang'] != 'english' )
	{
		@reset($lang['datetime']);
		while ( list($match, $replace) = @each($lang['datetime']) )
		{
			$translate[$match] = $replace;
		}
	}

	$tz_add = ($board_config['auto_date']) ? (3600 * ($tz + (@date('I', $gmepoch) && @date('I', CR_TIME)))) : (3600 * $tz);

	$epoch_time = $gmepoch + $tz_add;
	$current_time = CR_TIME + $tz_add;

	$cyear = @gmdate('Y', $current_time);
	$cmonth = @gmdate('n', $current_time);
	$cday = @gmdate('j', $current_time);
	$chour = @gmdate('G', $current_time);
	$cmin = @gmdate('i', $current_time);

	$today_begin = @gmmktime(0, 0, 0, $cmonth, $cday, $cyear);
	$today_end = @gmmktime(23, 59, 59, $cmonth, $cday, $cyear);
	$yesterday_begin = $today_begin - 86400;

	if ( $epoch_time > $yesterday_begin && $epoch_time < $today_end && !$no_today )
	{
		if ( $epoch_time < $today_begin )
		{
			return $lang['Yesterday'] . ' ' . @gmdate('G:i', $epoch_time);
		}
		else
		{
			return $lang['Today'] . ' ' . @gmdate('G:i', $epoch_time);
		}
	}

	return ( !empty($translate) ) ? strtr(@gmdate($format, $epoch_time), $translate) : @gmdate($format, $epoch_time);
}

//
// Pagination routine, generates
// page number sequence
//
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE)
{
	global $template, $lang;

	$total_pages = ceil($num_items / $per_page);
	$on_page = floor($start_item / $per_page) + 1;

	if ( $total_pages <= 1 )
	{
		return '';
	}

	if ( $total_pages > 10 )
	{
		$pages_jumpbox = '';
		for($i = 0; $i < $total_pages; $i++)
		{
			$pages_jumpbox .= '<option value="' . ($per_page * $i) . '"' . ((($on_page-1) == $i) ? ' selected="selected"' : '') . '>' . ($i+1) . '</option>';
		}

		$template->block('pagina_pages', array('OPTIONS' => $pages_jumpbox));
	}

	$template->set_filenames(array(
		'pagination' => 'pagination.tpl')
	);

	if ( $total_pages > 10 )
	{
		$template->vars(array(
			'L_ALL_AVAILABLE' => $lang['All_available'],
			'BASE_URL' => append_sid($base_url))
		);
	}

	$base_url = (strpos($base_url, '?') !== false) ? $base_url . '&amp;' : $base_url . '?';

	$template->vars(array(
		'PAGE_NUMBER' => sprintf($lang['Page_of'], $on_page, $total_pages),
		'L_GOTO_PAGE' => $lang['Goto_page'] . ': ')
	);

	$template->block('pages.begin', array());

	if ( $add_prevnext_text )
	{
		$template->vars(array(
			'L_BACK' => $lang['Previous'],
			'L_NEXT' => $lang['Next'])
		);
		if ( $on_page > 1 )
		{
			$template->block('pages.begin', array(
				'URL' => append_sid($base_url . "start=" . ( ( $on_page - 2 ) * $per_page ) ))
			);
		}
	}

	$page_string = '';
	if ( $total_pages > 10 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;

		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			if ( $i == $on_page )
			{
				$template->block('pages.onpage', array(
					'NUMBER' => $i)
				);
			}
			else
			{
				$template->block('pages.page', array(
					'URL' => append_sid($base_url . "start=" . ( ( $i - 1 ) * $per_page ) ),
					'NUMBER' => $i)
				);
			}

			if ( $i < $init_page_max )
			{
				$template->block('pages.separator', array());
			}
		}

		if ( $total_pages > 3 )
		{
			if ( $on_page > 1 && $on_page < $total_pages )
			{
				if ( $on_page > 5 )
				{
					$template->block('pages.allpages', array());
				}
				else
				{
					$template->block('pages.separator', array());
				}

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				{
					if ($i == $on_page)
					{
						$template->block('pages.onpage', array(
							'NUMBER' => $i)
						);
					}
					else
					{
						$template->block('pages.page', array(
							'URL' => append_sid($base_url . "start=" . ( ( $i - 1 ) * $per_page ) ),
							'NUMBER' => $i)
						);
					}

					if ( $i < $init_page_max + 1 )
					{
						$template->block('pages.separator', array());
					}
				}

				if ( $on_page < $total_pages - 4 )
				{
					$template->block('pages.allpages', array());
				}
				else
				{
					$template->block('pages.separator', array());
				}
			}
			else
			{
				$template->block('pages.allpages', array());
			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			{
				if ( $i == $on_page )
				{
					$template->block('pages.onpage', array(
						'NUMBER' => $i)
					);
				}
				else
				{
					$template->block('pages.page', array(
						'URL' => append_sid($base_url . "start=" . ( ( $i - 1 ) * $per_page ) ),
						'NUMBER' => $i)
					);
				}

				if ( $i < $total_pages )
				{
					$template->block('pages.separator', array());
				}
			}
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			if ( $i == $on_page ) 
			{
				$template->block('pages.onpage', array(
					'NUMBER' => $i)
				);
			}
			else
			{
				$template->block('pages.page', array(
					'URL' => append_sid($base_url . "start=" . ( ( $i - 1 ) * $per_page ) ),
					'NUMBER' => $i)
				);
			}
			if ( $i < $total_pages )
			{
				$template->block('pages.separator', array());
			}
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page < $total_pages )
		{
			$template->block('pages.end', array(
				'URL' => append_sid($base_url . "start=" . ( $on_page * $per_page ) ))
			);
		}
	}

	$template->var('PAGINATION', $template->render('pagination.tpl'));

	return;
}


//
// Obtain list of naughty words and build preg style replacement arrays for use by the
// calling script, note that the vars are passed as references this just makes it easier
// to return both sets of arrays
//
function obtain_word_list(&$orig_word, &$replacement_word, &$replacement_word_html)
{
	global $db;
	global $global_orig_word, $global_replacement_word, $global_replacement_word_html;

	if ( isset($global_orig_word) )
	{
		$orig_word	= $global_orig_word;
		$replacement_word = $global_replacement_word;
		$replacement_word_html = $global_replacement_word_html;
	}
	else
	{
		// Define censored word matches

		$word_list = sql_cache('check', 'word_list');
		if (!empty($word_list))
		{
			foreach($word_list as $word => $replacement)
			{
				$orig_word[] = '#\b(' . str_replace('\*', '\w*?', preg_quote($word, '#')) . ')\b#i';
				$replacement_word[] = strip_tags($replacement);
				$replacement_word_html[] = $replacement;
			}
		}
		else if (!isset($word_list))
		{
			$sql = "SELECT word, replacement
				FROM " . WORDS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get censored words from database', '', __LINE__, __FILE__, $sql);
			}

			$word_list = array();

			if ( $row = $db->sql_fetchrow($result) )
			{
				do
				{
					$orig_word[] = '#\b(' . str_replace('\*', '\w*?', preg_quote($row['word'], '#')) . ')\b#i';
					$replacement_word[] = strip_tags($row['replacement']);
					$replacement_word_html[] = $row['replacement'];
					$word_list[$row['word']] = $row['replacement'];
				}
				while ( $row = $db->sql_fetchrow($result) );
			}
			sql_cache('write', 'word_list', $word_list);
		}

		$global_orig_word = $orig_word;
		$global_replacement_word = $replacement_word;
		$global_replacement_word_html = $replacement_word_html;
	}
	return true;
}


// Filter supplied string on supplied bad words, except for users with moderator
// privilege, who get to see the original bad words highlighted instead
function replace_bad_words(&$orig_word, &$replacement_word, &$string)
{
	global $is_auth;

	// don't bother if no bad words defined
	if ( !count($orig_word) )
	{
		return;
	}

	if ( $is_auth['auth_mod'] )
	{
		$string = preg_replace($orig_word, '<span class="badwordhighlight">' . "\\1" . '</span>', $string);
	}
	else
	{
		$string = preg_replace($orig_word, $replacement_word, $string);
	}
}


//
// This is general replacement for die(), allows templated
// output in users (or default) language, etc.
//
// $msg_code can be one of these constants:
//
// GENERAL_MESSAGE : Use for any simple text message, eg. results 
// of an operation, authorisation failures, etc.
//
// GENERAL ERROR : Use for any error which occurs _AFTER_ the 
// common.php include and session code, ie. most errors in 
// pages/functions
//
// CRITICAL_MESSAGE : Used when basic config data is available but 
// a session may not exist, eg. banned users
//
// CRITICAL_ERROR : Used when config data cannot be obtained, eg
// no database connection. Should _not_ be used in 99.5% of cases
//
function message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	global $db, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images, $statistics_module;
	global $userdata, $user_ip, $session_length, $starttime, $page_title, $tree;
	if ( !$board_config['report_disable'] )
	{
		global $rp;
	}

	static $msg_history;
	if( !isset($msg_history) )
	{
		$msg_history = array();
	}
	$msg_history[] = array(
		'msg_code'	=> $msg_code,
		'msg_text'	=> $msg_text,
		'msg_title'	=> $msg_title,
		'err_line'	=> $err_line,
		'err_file'	=> $err_file,
		'sql'		=> $sql
	);

	if ( defined('HAS_DIED') )
	{
		//
		// This message is printed at the end of the report.
		// Of course, you can change it to suit your own needs. ;-)
		//
		$custom_error_message = 'Please, contact the Administrator. Thank you.';
		if ( !empty($board_config) && !empty($board_config['board_email']) )
		{
			$custom_error_message = sprintf($custom_error_message, '<a href="mailto:' . $board_config['board_email'] . '">', '</a>');
		}
		else
		{
			$custom_error_message = sprintf($custom_error_message, '', '');
		}
		echo "<html>\n<body>\n<b>Critical Error!</b><br />\nmessage_die() was called multiple times.<br />&nbsp;<hr />";
		if ( DEBUG && $sql )
		{
			for( $i = 0; $i < count($msg_history); $i++ )
			{
				echo '<b>Error #' . ($i+1) . "</b>\n<br />\n";
				if( !empty($msg_history[$i]['msg_title']) )
				{
					echo '<b>' . $msg_history[$i]['msg_title'] . "</b>\n<br />\n";
				}
				echo $msg_history[$i]['msg_text'] . "\n<br /><br />\n";
				if( !empty($msg_history[$i]['err_line']) )
				{
					echo '<b>Line :</b> ' . $msg_history[$i]['err_line'] . '<br /><b>File :</b> ' . $msg_history[$i]['err_file'] . "</b>\n<br />\n";
				}
				if( !empty($msg_history[$i]['sql']) )
				{
					echo '<b>SQL :</b> ' . $msg_history[$i]['sql'] . "\n<br />\n";
				}

				$sql_error = $db->sql_error();

				if( !empty($sql_error['message']) )
				{
					echo '<b>SQL message:</b> ' . $sql_error['message'] . "\n<br />\n";
				}
				echo "&nbsp;<hr />\n";
			}
		}
		echo $custom_error_message . '<hr /><br clear="all">';
		// die("</body>\n</html>");
	}
	
	define('HAS_DIED', 1);

	$sql_store = $sql;
	
	//
	// Get SQL error if we are debugging. Do this as soon as possible to prevent 
	// subsequent queries from overwriting the status of sql_error()
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) && $sql )
	{
		$sql_error = $db->sql_error();

		$debug_text = '';

		if ( $sql_error['message'] != '' )
		{
			$debug_text .= '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		}

		if ( $sql_store != '' )
		{
			$debug_text .= "<br /><br />$sql_store";
		}

		if ( $err_line != '' && $err_file != '' )
		{
			$debug_text .= '<br /><br />Line : ' . $err_line . '<br />File : ' . ( (!$statistics_module) ? basename($err_file) : $err_file ) . '<span class="gensmall">' . $lang['support'] . '</span>';
		}
	}

	if ( empty($userdata) && ( $msg_code == GENERAL_MESSAGE || $msg_code == GENERAL_ERROR ) )
	{
		$userdata = session_pagestart($user_ip, PAGE_INDEX);
		init_userprefs($userdata);
	}

	//
	// If the header hasn't been output then do it
	//
	if ( !defined('HEADER_INC') && $msg_code != CRITICAL_ERROR )
	{
		if ( empty($lang) )
		{
			if ( !empty($board_config['default_lang']) )
			{
				include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx);
			}
			else
			{
				include($phpbb_root_path . 'language/lang_english/lang_main.'.$phpEx);
			}
		}

		if ( empty($template) )
		{
			//$template = new Template($phpbb_root_path . 'templates/' . $board_config['board_template']);
			$template = \PhpBB\Core\Context::getService('templates');
		}
		if ( empty($theme) )
		{
			$theme = setup_style($board_config['default_style']);
		}

		// Load the Page Header
		if ( !defined('IN_ADMIN') )
		{
			include($phpbb_root_path . 'includes/page_header.'.$phpEx);
		}
		else
		{
			include($phpbb_root_path . 'admin/page_header_admin.'.$phpEx);
		}
	}

	switch($msg_code)
	{
		case GENERAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Information'];
			}
			break;

		case CRITICAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Critical_Information'];
			}
			break;

		case GENERAL_ERROR:
			if ( $msg_text == '' )
			{
				$msg_text = $lang['An_error_occured'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = $lang['General_Error'];
			}
			break;

		case CRITICAL_ERROR:
			// Critical errors mean we cannot rely on _ANY_ DB information being
			// available so we're going to dump out a simple echo'd statement
			include($phpbb_root_path . 'language/lang_english/lang_main.'.$phpEx);

			if ( $msg_text == '' )
			{
				$msg_text = $lang['A_critical_error'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = 'phpBB by Przemo : <b>' . $lang['Critical_Error'] . '</b>';
			}
			break;
	}

	// Try to repair table if potential damage
	if ( !empty($sql_error) && ($sql_error['code'] == '1016' || $sql_error['code'] == '1034') && ($board_config['autorepair_tables'] != 0 || !isset($board_config['autorepair_tables'])) )
	{
		$sql3 = "SELECT config_value
			FROM " . CONFIG_TABLE . "
			WHERE config_name = 'last_dtable_notify'";
		$result3 = $db->sql_query($sql3);
		$row3 = $db->sql_fetchrow($result3);

		if ( $row3['config_value'] < (CR_TIME - 3600) )
		{
			$pos1 = strpos($sql_error['message'], ": '");
			$pos2 = strpos($sql_error['message'], "'.");
			$table_damage = substr($sql_error['message'], ($pos1 + 3), ($pos2 - ($pos1 + 3)));
			$table_damage = str_replace('.MYI', '', $table_damage);
			$table_damage = str_replace('.MYD', '', $table_damage);

			$sql = "REPAIR TABLE " . $table_damage;
			if ( !($result = $db->sql_query($sql)) )
			{
				$rt_result = $db->sql_error();
				$rep_result = sprintf($lang['rrtf'], $table_damage, $sql, $rt_result['message'], $table_damage);
			}
			else
			{
				$rep_result = sprintf($lang['rrts'], $table_damage, $sql, $table_damage);
			}

			@mail($board_config['board_email'], $lang['mstr'], $rep_result);

			update_config('last_dtable_notify', CR_TIME);
		}
		$msg_text = $lang['rrsum'] . '<br /><br /><span style="font size: 10px">' . $msg_text . '</span>';
	}

	// Add on DEBUG info if we've enabled debug mode and this is an error. This
	// prevents debug info being output for general messages should DEBUG be
	// set TRUE by accident (preventing confusion for the end user!)
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		if ( $debug_text != '' )
		{
			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b>' . $debug_text;
		}
	}

	if ( $msg_code != CRITICAL_ERROR )
	{
		if ( !empty($lang[$msg_text]) )
		{
			$msg_text = $lang[$msg_text];
		}

		if ( !defined('IN_ADMIN') )
		{
			$template->set_filenames(array(
				'message_body' => 'message_body.tpl')
			);
		}
		else
		{
			$template->set_filenames(array(
				'message_body' => 'admin/admin_message_body.tpl')
			);
		}

		$template->vars(array(
			'MESSAGE_TITLE' => $msg_title,
			'MESSAGE_TEXT' => $msg_text)
		);
		$template->pparse('message_body');

		if ( !defined('IN_ADMIN') )
		{
			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		else
		{
			include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
		}
	}
	else
	{
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";
	}
	exit;
}


//
// This function is for compatibility with PHP 4.x's realpath()
// function. In later versions of PHP, it needs to be called
// to do checks with some functions. Older versions of PHP don't
// seem to need this, so we'll just return the original value.
// dougk_ff7 <October 5, 2002>
function phpbb_realpath($path)
{
	global $phpbb_root_path, $phpEx;
	return (!@function_exists('realpath') || !@realpath($phpbb_root_path . 'includes/functions.'.$phpEx)) ? $path : @realpath($path);
}

function redirect($url)
{
	global $db, $board_config;

	if ( !empty($db) )
	{
		$db->sql_close();
	}

	if (strstr(urldecode($url), "\n") || strstr(urldecode($url), "\r"))
	{ 
		message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
	}

	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;
	$url = preg_replace('#^\/?(.*?)\/?$#', '/\1', trim($url));

	// Redirect via an HTML form for PITA webservers
	if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
	{
		header('Refresh: 0; URL=' . $server_protocol . $server_name . $server_port . $script_name . $url);
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $server_protocol . $server_name . $server_port . $script_name . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $server_protocol . $server_name . $server_port . $script_name . $url . '">HERE</a> to be redirected</div></body></html>';
		exit;
	}

	// Behave as per HTTP/1.1 spec for others
	$url = str_replace('&amp;', '&', $url);
	header('Location: ' . $server_protocol . $server_name . $server_port . $script_name . $url);
	exit;
}

// Password-protected forums
function password_check ($forum_id, $password, $redirect, $forum_password = '')
{
	global $db, $userdata, $lang, $board_config;
	global $HTTP_COOKIE_VARS, $unique_cookie_name;

	if ( !$forum_id )
	{
		message_die(GENERAL_MESSAGE, $lang['Forum_not_exist']);
	}

	if ( !$forum_password )
	{
		$sql = "SELECT password FROM " . FORUMS_TABLE . "
			WHERE forum_id = $forum_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not retrieve forum password', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		$forum_password = $row['password'];
	}
	if ( $password != $forum_password || !$password )
	{
		message_die(GENERAL_MESSAGE, $lang['Incorrect_forum_password']);
	}

	$cookie_name = $unique_cookie_name . '_fpass_' . $forum_id;
	setcookie($cookie_name, md5($password), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	redirect($redirect);

	return true;
}


function password_box ($forum_id, $s_form_action)
{
	global $db, $template, $theme, $board_config, $lang, $phpEx, $phpbb_root_path, $gen_simple_header;
	global $userdata;

	$page_title = $lang['Enter_forum_password'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);
	$template->set_filenames(array(
		'body' => 'password_body.tpl')
	);

	$template->vars(array(
		'L_ENTER_PASSWORD' => $lang['Enter_forum_password'],
		'L_SUBMIT' => $lang['Submit'],
		'L_CANCEL' => $lang['Cancel'],

		'S_FORM_ACTION' => $s_form_action)
	);

	$template->pparse('body');
	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

function get_poster_topic_posts($topic_id, $user_id)
{
	global $lang, $db;

	static $ptp_buff;

	if( !isset($ptp_buff) )
	{
		$ptp_buff = array();
	}
	if( is_array($topic_id) )
	{
		$topic_id_list = implode(',', $topic_id);
		if ( $topic_id_list )
		{
			$sql = "SELECT topic_id, COUNT(post_id) AS posts
				FROM " . POSTS_TABLE . "
				WHERE topic_id IN ($topic_id_list)
					AND poster_id = $user_id
				GROUP BY topic_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain poster topic posts information', '', __LINE__, __FILE__, $sql);
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				$ptp_buff[$user_id][$row['topic_id']] = $row['posts'];
			}
			foreach( $topic_id as $id )
			{
				if( !isset($ptp_buff[$user_id][$id]) )
				{
					$ptp_buff[$user_id][$id] = '';
				}
			}
		}
		return;
	}

	if( isset($ptp_buff[$user_id][$topic_id]) )
	{
		return $ptp_buff[$user_id][$topic_id];
	}

	$sql = "SELECT COUNT(post_id) AS posts
		FROM " . POSTS_TABLE . "
		WHERE topic_id = $topic_id 
			AND poster_id = $user_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain poster topic posts information', '', __LINE__, __FILE__, $sql);
	}

	$poster_posts = ( $row = $db->sql_fetchrow($result) ) ? $row['posts'] : '';

	return $poster_posts;
}

function no_post_count($forum_id, $mode = '')
{
	global $db;

	if ( $mode != 'list' )
	{
		$sql = "SELECT no_count FROM " . FORUMS_TABLE . "
			WHERE forum_id = $forum_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not retrieve forum data', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		if ( $row['no_count'] )
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		$sql = "SELECT forum_id 
			FROM " . FORUMS_TABLE . "
			WHERE no_count = 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query forums table', '', __LINE__, __FILE__, $sql);
		}

		$no_count_forums = '';
		while( $row = $db->sql_fetchrow($result) )
		{
			$no_count_forums .= ( ( $no_count_forums != '' ) ? ', ' : '' ) . $row['forum_id'];
		}
		return $no_count_forums;
	}
}

function custom_fields($check = '', $view = false, $forum_id = '')
{
	global $db;
	$id = [];
	$desc = [];
	$max_value = [];
	$min_value = [];
	$numerics = [];
	$jumpbox = [];
	$makelinks = [];
	$view_post = [];
	$prefix = [];
	$suffix = [];
	$editable = [];
	$view_by = [];
	$where = '';
	if ( $check )
	{
		if ( $check == 'viewable' )
		{
			if ( $view == 0 )
			{
				return true;
			}
			global $userdata;

			$user_id = $forum_id;

			// $view : 0 - All, 1 - Registered, 2 - MOD, 3 - ADMIN, 4 - MOD & USER, 5 - ADMIN && USER
			if ( $userdata['user_level'] == ADMIN
					|| ($userdata['user_id'] != ANONYMOUS && $view == 1)
					|| ($userdata['user_level'] == MOD && ($view == 2 || $view == 4) )
					|| ($user_id && $user_id == $userdata['user_id'] && $view > 3)
				)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		if ( $check == 'viewtopic' )
		{
			$where = "WHERE view_post <> 0 AND no_forum NOT LIKE '%[" . $forum_id . "]%'";
		}
		else if ( $check == 'profile' )
		{
			$where = 'WHERE view_profile <> 0';
		}
		else if ( $check == 'quick_regist' )
		{
			$where = 'WHERE requires = 1';
		}

		$sql = "SELECT COUNT(id) AS total
			FROM " . FIELDS_TABLE . "
			$where
			LIMIT 1";

		$cache_name = 'multisqlcache_fieldsc_' . md5($sql);
		$row = sql_cache('check', $cache_name);
		if (!isset($row))
		{
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			sql_cache('write', $cache_name, $row);
		}
		if ( $row && $row['total'] > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		if ( $view == 'quick_regist' )
		{
			$get_sql = 'id, desc_short, max_value, jumpbox';
			$get_viewprofile = 'WHERE requires = 1';
		}
		else
		{
			$get_sql = '*';
			$get_viewprofile = ($view == 'profile') ? "WHERE view_profile <> 0" : "WHERE view_post <> 0 AND no_forum NOT LIKE '%[" . $forum_id . "]%'" . (($view == 'viewtopic') ? " AND view_post <> 0" : "");
		}
		if ( !$view )
		{
			$get_viewprofile = 'WHERE view_profile <> 0 OR view_post <> 0 OR requires = 1';
		}

		$sql = "SELECT " . $get_sql . "
			FROM " . FIELDS_TABLE . "
			$get_viewprofile
			ORDER by id ASC";

		$cache_name = 'multisqlcache_fields_' . md5($sql);
		$row_f = sql_cache('check', $cache_name);
		if (!isset($row_f))
		{
			$result = $db->sql_query($sql);
			$row_f = $db->sql_fetchrowset($result);
			sql_cache('write', $cache_name, $row_f);
		}

		if (empty($row_f)) {
			$row_f = [];
		}
		for($i=0; $i < count($row_f); $i++)
		{
			$row = $row_f[$i];
			if ( $view != 'quick_regist' )
			{
				if ( !$view )
				{
					$requires[] = $row['requires'];
					$desc_long[] = $row['desc_long'];
					$set_form[] = $row['set_form'];
				}

				$id[] = $row['id'];
				$desc[] = $row['desc_short'];
				$max_value[] = $row['max_value'];
				$min_value[] = $row['min_value'];
				$numerics[] = $row['numerics'];
				$jumpbox[] = str_replace(", ", ",", $row['jumpbox']);
				$makelinks[] = $row['makelinks'];
				$view_post[] = $row['view_post'];
			}
			else
			{
				$id[] = $row['id'];
				$desc[] = $row['desc_short'];
				$max_value[] = $row['max_value'];
				$jumpbox[] = str_replace(", ", ",", $row['jumpbox']);
			}
			$prefix[] = $row['prefix'];
			$suffix[] = $row['suffix'];

			$editable[] = $row['editable'];
			$view_by[] = $row['view_by'];
		}
		
		if ( $view != 'quick_regist' )
		{
			if ( !$view )
			{
				return array($id, $desc, $max_value, $min_value, $numerics, $requires, $jumpbox, $desc_long, $set_form, $prefix, $suffix, $editable, $view_by);
			}
			else
			{
				return array($id, $desc, $max_value, $min_value, $numerics, $jumpbox, $makelinks, $view_post, $prefix, $suffix, $editable, $view_by);
			}
		}
		else
		{
			return array($id, $desc, $max_value, $jumpbox, $editable, $view_by);
		}
	}
}

// Function strip all BBcodes (borrowed from Mouse Hover Topic Preview MOD)

function confirm($confirm_lang, $address, $sid = '')
{
	global $lang;

	$form_sid = ($sid) ? '<input type="hidden" name="sid" value="' . $sid . '">' : '';
	message_die(GENERAL_MESSAGE, '<form action="' . $address . '" method="post"><table border="0"><tr><td class="row1" align="center"><span class="gen">' . $confirm_lang . '</span><br /><br /><input type="hidden" name="confirm" value="1"><input type="submit" name="confirm" class="mainoption" value="' . $lang['Yes'] . '" />&nbsp;&nbsp;<input type="submit" name="cancel" value="' . $lang['No'] . '" class="liteoption" />' . $form_sid . '</td></tr></table></form>');

	return;
}

function replace_encoded($text)
{
	global $lang;
	return ($lang['ENCODING'] == 'iso-8859-2') ? $text : str_replace(
		array('�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�'),
		array('e', 'o', 'a', 's', 'l', 'z', 'z', 'c', 'n', 'E', 'O', 'A', 'S', 'L', 'Z', 'Z', 'C', 'N'), $text
	);
}

function sql_cache($mode, $file, $data = '')
{
	global $sql_cache_enable, $sql_work, $phpbb_root_path, $phpEx;

	if ( !$sql_cache_enable || !$sql_work ) { return false; }

	$cache_dir = $phpbb_root_path . 'cache/';
	$filename  = $cache_dir . $file . ".$phpEx";

	if ( !(@is_writable($cache_dir)) ) {  return false; }

	if ( $mode == 'check' )
    	{
			
        	$cache = null;
        	
        	if(file_exists($filename)) {
        		
        		include $filename;
        	}
        	
        	return $cache;
    	}
    	else if ( $mode == 'write' )
    	{
        	$mode = (file_exists($filename)) ? 'r+' : 'w';
        	if (!$fp = @fopen($filename, $mode)) { return; }
        	if (!@flock($fp, LOCK_EX|LOCK_NB))   { return; }

        	$data = '<?php $cache = ' . var_export($data, true) . ';';
        	ftruncate($fp, 0);
        	fwrite($fp, $data);
        	flock($fp, LOCK_UN);
        	fclose($fp);

        	return true;
    	}
    	else if ( $mode == 'clear' )
    	{
        	if (strpos($file, 'multisqlcache_') !== false)
        	{
            		$dir = opendir($cache_dir);

            		while($filename = readdir($dir))
            		{
                		if ( strpos($filename, $file) !== false )
                		{
                    			@unlink ($cache_dir . $filename);
                		}
           		}
           	 	closedir($dir);
        	}
        	else if (file_exists($filename) && $fp = @fopen($filename, 'r+'))
        	{
            		flock($fp, LOCK_EX);
            		ftruncate($fp, 0);
            		flock($fp, LOCK_UN);
           		fclose($fp);
        	}

        	return;
    	}
}

function phpbb_ltrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return ltrim($str);
	}
	
	$php_version = explode('.', PHP_VERSION);

	// php version < 4.1.0
	if ((int) $php_version[0] < 4 || ((int) $php_version[0] == 4 && (int) $php_version[1] < 1))
	{
		while ($str[0] == $charlist)
		{
			$str = substr($str, 1);
		}
	}
	else
	{
		$str = ltrim($str, $charlist);
	}

	return $str;
}

function get_groups_color()
{
	$colors = $users = $groups = $style = array();
	$user_groups = sql_cache('check', 'user_groups');
	$groups_data = sql_cache('check', 'groups_data');
	if (!empty($user_groups) && !empty($groups_data))
	{
		$users  = $user_groups[0];
		$groups = $user_groups[1];

		$colors = $groups_data[0];
		$prefix = $groups_data[1];
		$style  = $groups_data[2];
	}
	else if (!isset($user_groups) || !isset($groups_data))
	{
		global $db;
		$sql = "SELECT ug.user_id, g.group_color, g.group_prefix, g.group_style, g.group_id
			FROM (" . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g)
			WHERE g.group_single_user = 0
			AND ( g.group_color <> '' OR g.group_prefix <> '' OR g.group_style <> '' )
				AND g.group_id = ug.group_id
				AND ug.user_pending <> 1
			GROUP by ug.user_id, ug.group_id
			ORDER BY g.group_order ASC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Can not get groups color', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$users[] = $row['user_id'];
			$groups[] = $row['group_id'];

			$colors[$row['group_id']] = $row['group_color'];
			$prefix[$row['group_id']] = $row['group_prefix'];
			$style[$row['group_id']] = $row['group_style'];
		}
		sql_cache('write', 'user_groups', array($users, $groups));
		sql_cache('write', 'groups_data', array($colors, $prefix, $style));
		$db->sql_freeresult($result);
	}
	return array($users, $groups, $colors, $prefix, $style);
}

function color_username($level, $jr_admin, $user_id, $username, $us_bold = true, $style = '')
{
	global $theme, $groups_color;
	static $groups_color;
	if ( !(isset($groups_color) ))
	{
		$groups_color = get_groups_color();
	}
	$users_color_id = $groups_color[0];
	$users_groups_id = $groups_color[1];
	$users_color = $groups_color[2];
	$users_prefix = $groups_color[3];
	$users_style = $groups_color[4];

	$bold = ($us_bold) ? '<b>%s</b>' : '%s';
	$color = '';
	$style_color = $color_id = $group_id = '';
	if ( $level == ADMIN && $theme['fontcolor_admin'] )
	{
		$username = sprintf($bold, $username);
		$style_color = ' style="color:#' . $theme['fontcolor_admin'] . (($style) ? '; ' . $style : '') . '"';
		$color = $theme['fontcolor_admin'];
	}
	else if ( $jr_admin && $theme['fontcolor_jradmin'] )
	{
		$username = sprintf($bold, $username);
		$style_color = ' style="color:#' . $theme['fontcolor_jradmin'] . (($style) ? '; ' . $style : '') . '"';
		$color = $theme['fontcolor_jradmin'];
	}
	else if ( $level == MOD && $theme['fontcolor_mod'] )
	{
		$username = sprintf($bold, $username);
		$style_color = ' style="color:#' . $theme['fontcolor_mod'] . (($style) ? '; ' . $style : '') . '"';
		$color = $theme['fontcolor_mod'];
	}
	else if ( @in_array($user_id, $users_color_id) )
	{
		$color_id = array_search($user_id, $users_color_id);
		$color = '';
		$group_id = $users_groups_id[$color_id];
		if ( $users_prefix[$group_id] )
		{
			$username = $users_prefix[$group_id] . $username;
		}
		if ( $users_color[$group_id] )
		{
			$style_color = 'color:#' . $users_color[$group_id];
			$color = $users_color[$group_id];
		}
		if ( $users_style[$group_id] )
		{
			$style_color .= (($style_color) ? '; ' : '') . $users_style[$group_id];
		}
		if ( $style_color )
		{
			$style_color = ' style="' . $style_color . (($style) ? '; ' . $style : '') . '"';
		}
		else if ( $style )
		{
			$style_color = ' style="' . $style . '"';
		}
	}
	else
	{
		$style_color = ($style) ? ' style="' . $style . '"' : '';
		return array($username, $style_color);
	}
	return array($username, $style_color, $color ? "#$color" : '');
}

function groups_color_explain($block)
{
	global $db, $theme, $lang, $template, $phpEx, $board_config, $userdata;
	$groups_desc_s = array();
	$gc = 0;
	if ( $theme['fontcolor_admin'] )
	{
		$groups_desc_s[$gc]['group_prefix'] = '';
		$groups_desc_s[$gc]['group_name'] = $lang['Admin_online_color'];
		$groups_desc_s[$gc]['group_color'] = $theme['fontcolor_admin'];
		$groups_desc_s[$gc]['group_id'] = 'admin';
		$groups_desc_s[$gc]['group_style'] = 'font-weight: bold';
		$groups_desc_s[$gc]['group_url'] = true;
		$gc++;
	}
	if ( $theme['fontcolor_jradmin'] )
	{
		$groups_desc_s[$gc]['group_prefix'] = '';
		$groups_desc_s[$gc]['group_name'] = $lang['Junior'];
		$groups_desc_s[$gc]['group_color'] = $theme['fontcolor_jradmin'];
		$groups_desc_s[$gc]['group_id'] = 'junior';
		$groups_desc_s[$gc]['group_style'] = 'font-weight: bold';
		$groups_desc_s[$gc]['group_url'] = true;
		$gc++;
	}
	if ( $theme['fontcolor_mod'] )
	{
		$groups_desc_s[$gc]['group_prefix'] = '';
		$groups_desc_s[$gc]['group_name'] = $lang['Mod_online_color'];
		$groups_desc_s[$gc]['group_color'] = $theme['fontcolor_mod'];
		$groups_desc_s[$gc]['group_id'] = 'mod';
		$groups_desc_s[$gc]['group_style'] = 'font-weight: bold';
		$groups_desc_s[$gc]['group_url'] = true;
		$gc++;
	}
	$groups_desc = sql_cache('check', 'groups_desc');
	if (!isset($groups_desc))
	{
		$groups_desc = array();
		$sql = "SELECT group_color, group_prefix, group_name, group_id, group_style, group_moderator, group_type
			FROM " . GROUPS_TABLE . "
			WHERE ( group_color <> '' OR group_prefix <> '' OR group_style <> '' )
				AND group_single_user = 0
			GROUP by group_id
			ORDER BY group_order ASC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Can not get groups', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$groups_desc[] = $row;
		}
		$db->sql_freeresult($result);
		sql_cache('write', 'groups_desc', $groups_desc);
	}
	if ( is_array($groups_desc) )
	{
		$groups_desc = @array_merge($groups_desc_s, $groups_desc);
	}
	else
	{
		$groups_desc = $groups_desc_s;
	}

	$count_groups_desc = count($groups_desc);
	$i = 0;

	foreach($groups_desc as $key => $val)
	{
		if (!isset($val['group_type'])) {
			$val['group_type'] = null;
		}
		if( $val['group_type'] != GROUP_HIDDEN || ( $val['group_type'] == GROUP_HIDDEN && $userdata['session_logged_in'] && ( $val['group_moderator'] == $userdata['user_id']  || $userdata['user_level'] == ADMIN ) ) )
		{
			$template->block($block, [
				'GROUP_PREFIX' => $val['group_prefix'],
				'GROUP_NAME' => $val['group_name'],
				'GROUP_COLOR' => $val['group_color'],
				'GROUP_STYLE' => ($val['group_style']) ? '; ' . $val['group_style'] : '',
				'U_GROUP_URL' => ($board_config['staff_enable'] || !$val['group_url']) ? (append_sid((($val['group_url']) ? "staff" : "groupcp") . ".$phpEx?" . POST_GROUPS_URL . "=" . $val['group_id'])) : 'javascript:void();',
			]);
			if ( $i != ($count_groups_desc - 1) )
			{
				$template->block($block . '.se_separator', array());
			}
			$i++;
		}
	}
}

function replace_vars($text, $default = '')
{
	global $theme, $board_config, $userdata;

	$text = ($userdata['session_logged_in']) ? preg_replace("#begin_logged_out(.*?)end_logged_out#si", "", $text) : preg_replace("#begin_logged_in(.*?)end_logged_in#si", "", $text);
	$ret_default = ($default) ? $default : 'au_value';

	return str_replace(array('au_tpl', 'au_lng', 'au_username', 'au_id', 'au_sid', 'begin_logged_out', 'end_logged_out', 'begin_logged_in', 'end_logged_in', 'au_value'), array($theme['template_name'], $board_config['default_lang'], $userdata['username'], $userdata['user_id'], $userdata['session_id'], '', '', '', '', $ret_default), $text);
}

//
// Fill smiley templates (or just the variables) with smileys
// Either in a window or inline
//
function generate_smilies($mode, $page_id)
{
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $user_ip, $session_length, $starttime;
	global $userdata;

	$inline_columns = $board_config['smilies_columns'];
	$inline_rows = $board_config['smilies_rows'];
	$window_columns = $board_config['smilies_w_columns'];

	if ($mode == 'window')
	{
		$userdata = session_pagestart($user_ip, $page_id);
		init_userprefs($userdata);

		$gen_simple_header = TRUE;

		$page_title = $lang['Emoticons'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->set_filenames(array(
			'smiliesbody' => 'posting_smilies.tpl')
		);
	}

	$smilies = sql_cache('check', 'smilies');
	if (!isset($smilies))
	{
		$sql = "SELECT * FROM " . SMILIES_TABLE . "
			ORDER by smile_order";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain smilies data', '', __LINE__, __FILE__, $sql);
		}
		$smilies = $db->sql_fetchrowset($result);
		sql_cache('write', 'smilies', $smilies);
	}

	if ( $smilies )
	{
		$num_smilies = 0;
		$rowset = array();
		for ($i = 0; $i < count($smilies); $i++)
		{
			if (empty($rowset[$smilies[$i]['smile_url']]))
			{
				$rowset[$smilies[$i]['smile_url']]['code'] = str_replace("'", "\\'", str_replace(array('"', '\\'), array('&quot;', '\\\\'), $smilies[$i]['code']));
				$rowset[$smilies[$i]['smile_url']]['emoticon'] = $smilies[$i]['emoticon'];
				$num_smilies++;

				if ( $mode == 'quickreply' && ($board_config['max_smilies']) && $num_smilies == $board_config['max_smilies'])
				{
					break;
				}
			}
		}

		if ($num_smilies)
		{
			$smilies_count = ($mode == 'inline' || $mode == 'quickreply') ? min(19, $num_smilies) : $num_smilies;
			$smilies_split_row = ($mode == 'inline' || $mode == 'quickreply') ? $inline_columns - 1 : $window_columns - 1;

			$s_colspan = 0;
			$row = 0;
			$col = 0;

			while (list($smile_url, $data) = @each($rowset))
			{
				if (!$col)
				{
					$template->block('smilies_row', array());
				}

				$sizes = @getimagesize($board_config['smilies_path'] . '/' . $smile_url);
				$width = (intval($sizes[0]) > 0 && intval($sizes[1]) > 0) ? '" width="' . $sizes[0] . '" height="' . $sizes[1] : '';

				$th_block = ($mode == 'quickreply') ? 'quick_reply' : 'smilies_row';

				$template->block($th_block . '.smilies_col', array(
					'SMILEY_CODE' => ' ' . $data['code'] . ' ',
					'SMILEY_IMG' => $board_config['smilies_path'] . '/' . $smile_url . $width,
					'SMILEY_DESC' => str_replace('\\\\', '\\', $data['code']))
				);

				$s_colspan = max($s_colspan, $col + 1);

				if ($col == $smilies_split_row)
				{
					if ($mode == 'inline' && $row == $inline_rows - 1)
					{
						break;
					}
					$col = 0;
					$row++;
				}
				else
				{
					$col++;
				}
			}

			if ($mode == 'inline' && $num_smilies > $inline_rows * $inline_columns)
			{
				$template->block('switch_smilies_extra', array());

				$template->vars(array(
					'L_MORE_SMILIES' => $lang['More_emoticons'], 
					'U_MORE_SMILIES' => append_sid("posting.$phpEx?mode=smilies"))
				);
			}

			$template->vars(array(
				'L_EMOTICONS' => $lang['Emoticons'], 
				'L_CLOSE_WINDOW' => $lang['Close_window'], 
				'S_SMILIES_COLSPAN' => $s_colspan)
			);
		}
	}

	if ($mode == 'window')
	{
		$template->pparse('smiliesbody');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}

function update_config($field, $value)
{
	global $db;

	$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = '" . str_replace("\'", "''", $value) . "'
		WHERE config_name = '$field'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update config table for field: ' . $field, '', __LINE__, __FILE__, $sql);
	}
	sql_cache('clear', 'board_config');
}

function moderarots_list($forum_id, $mode)
{
	global $db, $phpEx, $moderators_list;

	if ( !isset($moderators_list) )
	{
		$moderators_list = sql_cache('check', 'moderators_list');
		if (!isset($moderators_list))
		{		
			$moderators_list = $groups_check = $groups_check_se = array();
			$sql = "SELECT aa.forum_id, g.group_id, g.group_name, g.group_single_user, g.group_type, g.group_color, g.group_prefix, g.group_style, u.username, u.user_id
				FROM (" . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g)
				LEFT JOIN " . USERS_TABLE . " u ON (u.user_id = ug.user_id)
				WHERE aa.auth_mod = " . TRUE . "
					AND ug.group_id = aa.group_id
					AND g.group_id = aa.group_id
				ORDER by aa.forum_id, g.group_single_user, g.group_name";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				if ( $row['user_id'] && !(@in_array($row['user_id'], $moderators_list[$row['forum_id']]['mod_list'])) )
				{
					$moderators_list[$row['forum_id']]['mod_list'][] = $row['user_id'];
				}
				if ( $row['group_single_user'] == 0 && $row['group_type'] != GROUP_HIDDEN && !(@in_array($row['group_id'], $groups_check[$row['forum_id']]) ) )
				{
					$groups_check[$row['forum_id']][] = $row['group_id'];
					$moderators_list[$row['forum_id']]['group_list'][] = array($row['group_id'], $row['group_name'], 0, $row['group_color'], $row['group_prefix'], $row['group_style']);
				}
				else if ( $row['group_single_user'] == 1 && !(@in_array($row['user_id'], $groups_check_se[$row['forum_id']])) )
				{
					$groups_check_se[$row['forum_id']][] = $row['user_id'];
					$moderators_list[$row['forum_id']]['group_list'][] = array($row['user_id'], $row['username'], 1);
				}
			}
			sql_cache('write', 'moderators_list', $moderators_list);
		}
	}

	if ( $mode == 'groups' )
	{
		$return_groups = array();
		$items = $moderators_list[$forum_id]['group_list'] ?? null;
		if ($items) {
			for($i=0; $i < count($items); $i++)
			{
				$dat = $moderators_list[$forum_id]['group_list'][$i];
				if ( $dat[2] == 0 )
				{
					$return_groups[] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $dat[0]) . '" class="gensmall" style="' . (($dat[3]) ? 'color: #' . $dat[3] . ';' : '') . (($dat[5]) ? $dat[5] . ';' : '') . '">' . $dat[4] . $dat[1] . '</a>';
				}
				else
				{
					$return_groups[] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $dat[0]) . '" class="gensmall">' . $dat[1] . '</a>';
				}
			}
		}
		return $return_groups;
	}
	else if ( $mode == 'mod' )
	{
		if (empty($moderators_list[$forum_id]['mod_list'])) {
			$moderators_list[$forum_id]['mod_list'] = null;
		}
		return (is_array($moderators_list[$forum_id]['mod_list'])) ? $moderators_list[$forum_id]['mod_list'] : array();
	}
	return false;
}

function unique_id($extra = 'c')
{
	static $dss_seeded = false;
	global $board_config;

	$val = $board_config['rand_seed'] . microtime();
	$val = md5($val);
	$board_config['rand_seed'] = md5($board_config['rand_seed'] . $val . $extra);

	if ($dss_seeded !== true && ($board_config['rand_seed_last_update'] < time() - rand(1,10)))
	{
		update_config('rand_seed_last_update', time());
		update_config('rand_seed', $board_config['rand_seed']);
		$dss_seeded = true;
	}

	return substr($val, 4, 16);
}

function _hash_encode64($input, $count, &$itoa64)
{
	$output = '';
	$i = 0;

	do
	{
		$value = ord($input[$i++]);
		$output .= $itoa64[$value & 0x3f];

		if ($i < $count)
		{
			$value |= ord($input[$i]) << 8;
		}

		$output .= $itoa64[($value >> 6) & 0x3f];

		if ($i++ >= $count)
		{
			break;
		}

		if ($i < $count)
		{
			$value |= ord($input[$i]) << 16;
		}

		$output .= $itoa64[($value >> 12) & 0x3f];

		if ($i++ >= $count)
		{
			break;
		}

		$output .= $itoa64[($value >> 18) & 0x3f];
	}
	while ($i < $count);

	return $output;
}

function _hash_crypt_private($password, $setting, &$itoa64)
{
	$output = '*';

	// Check for correct hash
	if (substr($setting, 0, 3) != '$H$' && substr($setting, 0, 3) != '$P$')
	{
		return $output;
	}

	$count_log2 = strpos($itoa64, $setting[3]);

	if ($count_log2 < 7 || $count_log2 > 30)
	{
		return $output;
	}

	$count = 1 << $count_log2;
	$salt = substr($setting, 4, 8);

	if (strlen($salt) != 8)
	{
		return $output;
	}

	/**
	* We're kind of forced to use MD5 here since it's the only
	* cryptographic primitive available in all versions of PHP
	* currently in use.  To implement our own low-level crypto
	* in PHP would result in much worse performance and
	* consequently in lower iteration counts and hashes that are
	* quicker to crack (by non-PHP code).
	*/
	if (PHP_VERSION >= 5)
	{
		$hash = md5($salt . $password, true);
		do
		{
			$hash = md5($hash . $password, true);
		}
		while (--$count);
	}
	else
	{
		$hash = pack('H*', md5($salt . $password));
		do
		{
			$hash = pack('H*', md5($hash . $password));
		}
		while (--$count);
	}

	$output = substr($setting, 0, 12);
	$output .= _hash_encode64($hash, 16, $itoa64);

	return $output;
}

function _hash_gensalt_private($input, &$itoa64, $iteration_count_log2 = 6)
{
	if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
	{
		$iteration_count_log2 = 8;
	}

	$output = '$H$';
	$output .= $itoa64[min($iteration_count_log2 + ((PHP_VERSION >= 5) ? 5 : 3), 30)];
	$output .= _hash_encode64($input, 6, $itoa64);

	return $output;
}

function phpbb_hash($password)
{
	$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	$random_state = unique_id();
	$random = '';
	$count = 6;

	if (($fh = @fopen('/dev/urandom', 'rb')))
	{
		$random = fread($fh, $count);
		fclose($fh);
	}

	if (strlen($random) < $count)
	{
		$random = '';

		for ($i = 0; $i < $count; $i += 16)
		{
			$random_state = md5(unique_id() . $random_state);
			$random .= pack('H*', md5($random_state));
		}
		$random = substr($random, 0, $count);
	}

	$hash = _hash_crypt_private($password, _hash_gensalt_private($random, $itoa64), $itoa64);

	if (strlen($hash) == 34)
	{
		return $hash;
	}

	return md5($password);
}

function phpbb_check_hash($password, $hash)
{
	$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	if($password == '' || is_array($password)) { return false; }

	if (strlen($hash) == 34)
	{
		return (_hash_crypt_private($password, $hash, $itoa64) === $hash) ? true : false;
	}

	return false;
}

?>