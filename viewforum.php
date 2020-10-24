<?php

use PhpBB\Forum\Url;

/***************************************************************************
 *                               viewforum.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/10/16 21:16
 *
 *   $Id: viewforum.php,v 1.139.2.12 2004/03/13 15:08:23 acydburn Exp $
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

define('IN_PHPBB', true);
define('ATTACH', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

/*

use PhpBB\Data\Cache;
$forums = (new PhpBB\Model\ForumsCollection);
$cache = new PhpBB\Data\Cache($forums);
$forum = cache($cache->get(1));
$topics = $forum->getTopics();
foreach($topics as $topic) {
//	var_dump($topic->topic_title . ' by ' . $topic->getRef('topic_poster')->username);
}



//exit;
// */

//
// Start initial var setup
//
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = ( isset($HTTP_GET_VARS[POST_FORUM_URL]) ) ? intval($HTTP_GET_VARS[POST_FORUM_URL]) : intval($HTTP_POST_VARS[POST_FORUM_URL]);
}
else if ( isset($HTTP_GET_VARS['forum']))
{
	$forum_id = intval($HTTP_GET_VARS['forum']);
}
else
{
	$forum_id = '';
}

$start     = get_vars('start', 0, 'GET,POST', true);
$mark_read = get_vars('mark', '', 'POST,GET');

if ( isset($HTTP_GET_VARS['show_ignore']) || isset($HTTP_POST_VARS['show_ignore']) )
{
	$show_ignore = true;
	$show_ignore_link = '&amp;show_ignore=1';
}
//
// End initial var setup
//

define('IN_VIEWFORUM', true);

$selected_id = get_vars('selected_id', false, 'POST,GET');
if ($selected_id)
{
	$type = substr($selected_id, 0, 1);
	$id	= intval(substr($selected_id, 1));

	if ( $type == POST_FORUM_URL )
	{
		$forum_id = $id;
	}
	else if ( ($type == POST_CAT_URL ) || ($selected_id == 'Root'))
	{
		$parm = ($id != 0) ? "?" . POST_CAT_URL . "=$id" : '';
		redirect(append_sid("./index.$phpEx" . $parm));
	}
}

//
// Check if the user has actually sent a forum ID with his/her request
// If not give them a nice error page.
//
if ( !empty($forum_id) )
{
	$cache_name = 'multisqlcache_forum_' . $forum_id;
	$forum_row  = sql_cache('check', $cache_name);
	if (empty($forum_row))
	{
		$sql = "SELECT *
			FROM " . FORUMS_TABLE . "
			WHERE forum_id = $forum_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
		}
		if ( !($forum_row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, 'Forum_not_exist');
		}
		sql_cache('write', $cache_name, $forum_row);
	}
}
else
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//

$user_topics_per_page = ($userdata['user_topics_per_page'] > $board_config['topics_per_page']) ? $board_config['topics_per_page'] : $userdata['user_topics_per_page'];
$user_posts_per_page = ($userdata['user_posts_per_page'] > $board_config['posts_per_page']) ? $board_config['posts_per_page'] : $userdata['user_posts_per_page'];

include($phpbb_root_path . 'includes/read_history.'.$phpEx);
include($phpbb_root_path . 'includes/functions_add.'.$phpEx);

$generate_online = users_online('viewforum');
$online_userlist = $generate_online[0];
$topic_expire    = [];

$selected_id = POST_FORUM_URL . $forum_id;
$athis = isset($tree['keys'][$selected_id]) ? $tree['keys'][$selected_id] : -1;
if ( ($athis > -1) && !empty($tree['data'][$athis]['forum_link']))
{
	// add 1 to hit if count ativated
	if ($tree['data'][$athis]['forum_link_hit_count'])
	{
		$sql = "UPDATE " . FORUMS_TABLE . " 
			SET forum_link_hit = forum_link_hit + 1 
			WHERE forum_id = $forum_id";
		if (!$db->sql_query($sql)) message_die(GENERAL_ERROR, 'Could not increment forum hits information', '', __LINE__, __FILE__, $sql);
		sql_cache('clear', 'multisqlcache_forum');
		sql_cache('clear', 'forum_data');
	}

	// prepare url
	$url = $tree['data'][$athis]['forum_link'];
	if ( $tree['data'][$athis]['forum_link_internal'] )
	{
		$part = explode( '?', $url);
		$url .= ((count($part) > 1) ? '&' : '?') . 'sid=' . $userdata['session_id'];
		$url = append_sid($url);

		// redirect to url
		redirect($url);
	}

	// Redirect via an HTML form for PITA webservers
	if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
	{
		header('Refresh: 0; URL=' . $url);
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $url . '"><title>' . $lang['Redirect'] . '</title></head><body><div align="center">' . sprintf($lang['Rediect_to'], '<a href="' . $url . '">', '</a>') . '</div></body></html>';
	}

	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . $url);
	exit;
}

if ( $board_config['login_require'] && !$userdata['session_logged_in'] )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

//
// Start auth check
//
$is_auth = [];
$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];

if ( !$is_auth['auth_read'] || !$is_auth['auth_view'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = POST_FORUM_URL . "=$forum_id" . ( ( isset($start) ) ? "&start=$start" : '' );
		redirect(append_sid("login.$phpEx?redirect=viewforum.$phpEx&$redirect", true));
	}
	//
	// The user is not authed to read this forum ...
	//
	$message = ( !$is_auth['auth_view'] ) ? $lang['Forum_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}
//
// End of auth check
//

// Password check
if ($forum_row['password'] != '')
{
	if ( !$is_auth['auth_mod'] || $userdata['user_level'] != ADMIN )
	{
		$redirect = str_replace("&amp;", "&", preg_replace('#.*?([a-z]+?\.' . $phpEx . '.*?)$#i', '\1', xhtmlspecialchars($_SERVER['REQUEST_URI'])));
		$cookie_forum_pass = $unique_cookie_name . '_fpass_' . $forum_id;
		if( $HTTP_POST_VARS['cancel'] )
		{
			redirect(append_sid("index.$phpEx"));
		}
		else if( $HTTP_POST_VARS['submit'] )
		{
			password_check($forum_id, $HTTP_POST_VARS['password'], $redirect, $forum_row['password']);
		}

		if( ($forum_row['password'] != '') && ($HTTP_COOKIE_VARS[$cookie_forum_pass] != md5($forum_row['password'])) )
		{
			password_box($forum_id, $redirect);
		}
	}
}
// END: Password check

$forum_moderate = ($forum_row['forum_moderate']) ? true : false;
$forum_view_moderate = ($forum_moderate && !$is_auth['auth_mod']) ? true : false;

//
// Handle marking posts
//
if ( $mark_read == 'topics' )
{
	if ( $userdata['session_logged_in'] )
	{
		if ( !check_sid($HTTP_GET_VARS['sid']) )
		{
			message_die(GENERAL_ERROR, 'Invalid_session');
		}

		$sql = "DELETE FROM " . READ_HIST_TABLE . "
			WHERE user_id = " . $userdata['user_id'] . "
				AND forum_id = $forum_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error in marking all as read', '',__LINE__, __FILE__, $sql);
		}

		$template->vars(array(
			'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id$show_ignore_link") . '">')
		);
	}

	$message = $lang['Topics_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id$show_ignore_link") . '">', '</a> ');
	message_die(GENERAL_MESSAGE, $message);
}

// Do the forum Prune
if ( $is_auth['auth_mod'] )
{
	if ( $forum_row['prune_next'] < CR_TIME && $forum_row['prune_enable'] )
	{
		include($phpbb_root_path . 'includes/functions_remove.'.$phpEx);
		require_once($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
		auto_prune($forum_id);
	}
}
// End of forum prune

// Obtain list of moderators of each forum
$forum_moderators = moderarots_list($forum_id, 'groups');
$count_moderators = count($forum_moderators);
$l_moderators = ( $count_moderators == 1 ) ? $lang['Moderator'] : $lang['Moderators'];

if ( $count_moderators > 0 )
{
	$forum_moderators = implode(', ', $forum_moderators);
}
else
{
	$forum_moderators = $lang['None'];
}

$ignore_topics_table = $ignore_topics_sql = $sort_unread = '';
if ( $board_config['ignore_topics'] && $userdata['session_logged_in'] && empty($show_ignore) )
{
	$ignore_topics_table = "LEFT JOIN " . TOPICS_IGNORE_TABLE . " i ON (i.topic_id = t.topic_id AND i.user_id = " . $userdata['user_id'] . ")";
	$ignore_topics_sql = "AND i.topic_id IS NULL";
}

// Generate a 'Show topics in previous x days' select box. If the topicsdays var is sent
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
$previous_days = array(0, 15, 30, 60, 120, 360, 720, 1440, 2880, 4320, 5760, 7200, 8640, 10080, 20160, 43200, 129600, 259200, 524160);
$previous_days_text = array($lang['All_Posts'], $lang['15_min'], $lang['30_min'], $lang['1_Hour'], $lang['2_Hour'], $lang['6_Hour'], $lang['12_Hour'], $lang['1_Day'], $lang['2_Days'], $lang['3_Days'], $lang['4_Days'], $lang['5_Days'], $lang['6_Days'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if ( !empty($HTTP_POST_VARS['topicdays']) || !empty($HTTP_GET_VARS['topicdays']) )
{
	$topic_days = ( !empty($HTTP_POST_VARS['topicdays']) ) ? intval($HTTP_POST_VARS['topicdays']) : intval($HTTP_GET_VARS['topicdays']);
	$min_topic_time = CR_TIME - ($topic_days * 60);

	$sql = "SELECT COUNT(t.topic_id) AS forum_topics
		FROM (" . TOPICS_TABLE . " t, " . POSTS_TABLE . " p)
		$ignore_topics_table
		WHERE t.forum_id = $forum_id
			$ignore_topics_sql
			AND p.post_id = t.topic_last_post_id
			AND p.post_time >= $min_topic_time";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain limited topics count information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	$topics_count = ($row['forum_topics']) ? $row['forum_topics'] : 1;
	$limit_topics_time = "AND p.post_time >= $min_topic_time";

	if ( !empty($HTTP_POST_VARS['topicdays']) )
	{
		$start = 0;
	}
}
else
{
	$topics_count = ($forum_row['forum_topics']) ? $forum_row['forum_topics'] : 1;
	if ( $topics_count > 1 && $board_config['ignore_topics'] && $userdata['session_logged_in'] && empty($show_ignore) )
	{
		$sql = "SELECT COUNT(t.topic_id) AS forum_topics
			FROM (" . TOPICS_TABLE . " t, " . TOPICS_IGNORE_TABLE . " i)
			WHERE t.forum_id = $forum_id
				AND t.topic_id = i.topic_id
				AND i.user_id = " . $userdata['user_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain limited topics count information', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$topics_count -= $row['forum_topics'];
	}
	$limit_topics_time = '';
	$topic_days = 0;
}

$select_topic_days = '<select name="topicdays">';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($topic_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$select_topic_days .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}
$select_topic_days .= '</select>';

if( $userdata['user_id'] != ANONYMOUS )
{
	$userdata = user_unread_posts();
	if ( $forum_row['forum_sort'] != 'SORT_FPDATE' && count($userdata['unread_data'][$forum_id]) )
	{
		$unread_topics_list = implode(',', array_keys($userdata['unread_data'][$forum_id]));
		$sort_unread = ($unread_topics_list) ? "t.topic_id IN($unread_topics_list) DESC, " : '';
	}
}

switch( $forum_row['forum_sort'] )
{
	case 'SORT_FPDATE':
        $topic_order = 'p2.post_time DESC';
		break;
	case 'SORT_TTIME':
		$topic_order = $sort_unread . 't.topic_time DESC';
		break;
	case 'SORT_ALPHA':
		$topic_order = $sort_unread . 't.topic_title ASC, t.topic_time DESC';
		break;
	case 'SORT_AUTHOR':
		$topic_order = $sort_unread . 'u.user_id < 0, u.username ASC';
		break;
	default:
        $topic_order = 'p2.post_time DESC';
		break;
}

$sotr_methods = ($forum_row['locked_bottom']) ? "ORDER BY t.topic_type DESC, t.topic_status ASC, $topic_order" : "ORDER BY t.topic_type DESC, $topic_order";

if ( $board_config['post_overlib'] && $board_config['overlib'] && $userdata['overlib'] )
{
	$forum_post_text_select = ", pt.post_text, pt2.post_text as last_post_text";
	$forum_post_text_where = "AND pt.post_id = t.topic_first_post_id AND pt2.post_id = t.topic_last_post_id";
	$forum_posts_tables = ", " . POSTS_TEXT_TABLE . " pt, " . POSTS_TEXT_TABLE . " pt2";
}
else
{
	$forum_post_text_select = $forum_post_text_where = $forum_posts_tables = '';
}

$forum_view_moderate = ($forum_row['forum_moderate'] && !$is_auth['auth_mod']) ? true : false;

$sql_fields = "t.*, u.username, u.user_id, u.user_level, u.user_jr, u2.username as user2, u2.user_id as id2, u2.user_level as user_level2, u2.user_jr as user_jr2, p.post_username, p.post_approve, p2.post_approve as post_approve2, p2.post_username AS post_username2, p2.post_time " . $forum_post_text_select;

$sql_tables = TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p $forum_posts_tables, " . POSTS_TABLE . " p2, " . USERS_TABLE . " u2";

if ( $forum_row['forum_show_ga'] )
{
	$sql_announces = "(t.topic_type = " . POST_GLOBAL_ANNOUNCE . " OR (t.topic_type = " . POST_ANNOUNCE . " AND t.forum_id = $forum_id) )";
}
else
{
	$sql_announces = "t.forum_id = $forum_id AND (t.topic_type = " . POST_ANNOUNCE . " OR t.topic_type = " . POST_GLOBAL_ANNOUNCE . ")";
}

// All GLOBAL announcement data, this keeps GLOBAL announcements 
// on each viewforum page ... 
$sql = "SELECT " . $sql_fields . "
	FROM (" . $sql_tables . ")
	$ignore_topics_table
	WHERE $sql_announces
		$ignore_topics_sql
		AND t.topic_poster = u.user_id
		AND p.post_id = t.topic_first_post_id
		AND p2.post_id = t.topic_last_post_id
		AND u2.user_id = p2.poster_id
		$forum_post_text_where
	ORDER BY t.topic_type DESC, t.topic_title";

if( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t obtain topic information', '', __LINE__, __FILE__, $sql);
}

$topic_rowset = [];
$total_announcements = $total_topics = $total_external_announcements = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$topic_rowset[] = $row;
	$total_announcements++;
	if ( $row['topic_type'] == POST_GLOBAL_ANNOUNCE && $row['forum_id'] != $forum_id )
	{
		$total_external_announcements++;
	}
}

// Grab all the basic data (all topics except announcements)
// for this forum

$sql = "SELECT " . $sql_fields . "
	FROM (" . $sql_tables . ")
	$ignore_topics_table
	WHERE t.forum_id = $forum_id
		$ignore_topics_sql
		AND t.topic_poster = u.user_id
		AND p.post_id = t.topic_first_post_id
		AND p2.post_id = t.topic_last_post_id
		AND u2.user_id = p2.poster_id
		$forum_post_text_where
		AND t.topic_type <> " . POST_ANNOUNCE . "
		AND t.topic_type <> " . POST_GLOBAL_ANNOUNCE . "
		$limit_topics_time $sotr_methods
	LIMIT $start, $user_topics_per_page";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{
	$topic_rowset[] = $row;
	$total_topics++;
}

$db->sql_freeresult($result);

// Total topics ...
$total_topics += $total_announcements;

// Define censored word matches
$orig_word = [];
$replacement_word = [];
$replacement_word_html = [];
obtain_word_list($orig_word, $replacement_word, $replacement_word_html);
$count_orig_word = (count($orig_word));

if (empty($show_ignore_link)) {
	$show_ignore_link = '';
}
// Post URL generation for templating vars
$template->vars(array(
	'L_DISPLAY_TOPICS' => $lang['Display_topics'],

	'LOGGED_IN_USER_LIST' => $online_userlist,
	'U_POST_NEW_TOPIC' => append_sid("posting.$phpEx?mode=newtopic&amp;" . POST_FORUM_URL . "=$forum_id"),

	'S_SELECT_TOPIC_DAYS' => $select_topic_days,
	'S_POST_DAYS_ACTION' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=" . $forum_id . "&amp;start=$start$show_ignore_link"))
);

//
// User authorisation levels output
//

if ( $userdata['session_logged_in'] && $userdata['disallow_forums'] )
{
	$disallow_forums = explode(',', $userdata['disallow_forums']);
	if ( @in_array($forum_id, $disallow_forums) )
	{
		$is_auth['auth_post'] = $is_auth['auth_reply'] = $is_auth['auth_edit'] = $is_auth['auth_delete'] = false;
	}
}

$s_auth_can = (($is_auth['auth_post']) ? $lang['Rules_post_can'] : $lang['Rules_post_cannot']) . '<br />';
$s_auth_can .= (($is_auth['auth_reply']) ? $lang['Rules_reply_can'] : $lang['Rules_reply_cannot']) . '<br />';
$s_auth_can .= (($is_auth['auth_edit']) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot']) . '<br />';
$s_auth_can .= (($is_auth['auth_delete']) ? $lang['Rules_delete_can'] : $lang['Rules_delete_cannot']) . '<br />';
$s_auth_can .= (($is_auth['auth_vote']) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot']) . '<br />';

if ( defined('ATTACHMENTS_ON') ) attach_build_auth_levels($is_auth, $s_auth_can);

if ( $is_auth['auth_mod'] )
{
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;start=" . $start . "&amp;sid=" . $userdata['session_id'] . '">', '</a>');
}

// Mozilla navigation bar
$nav_links['up'] = array(
	'url' => append_sid('index.'.$phpEx),
	'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
);

// Dump out the page header and load viewforum template
$forum_row['forum_name'] = get_object_lang(POST_FORUM_URL . $forum_id, 'name');
$page_title = $lang['View_forum'] . ' - ' . $forum_row['forum_name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
include($phpbb_root_path . 'includes/functions_hierarchy.'.$phpEx);

if (!$forum_row['forum_template']) {
	$forum_row['forum_template'] = 'viewforum_body.tpl';
}
$template->set_filenames([
	'body' => $forum_row['forum_template']
]);

make_jumpbox('viewforum.'.$phpEx);

display_index(POST_FORUM_URL . $forum_id);

$span_i = "2";
$span_j = "6";
if ( $board_config['post_icon'] && $userdata['post_icon'] )
{
	$span_i++;
	$span_j++;
}

$u_index_check = append_sid('index.'.$phpEx);
$show_ignore_topics = '';
if ( $board_config['ignore_topics'] && $userdata['session_logged_in'] && $userdata['view_ignore_topics'] )
{
	if (empty($show_ignore)) {
		$show_ignore_topics = new Url("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&show_ignore=1" . ($start ? '&start=' . $start : ''), $lang['show_ignore_topics']);
	}
	$span_i++;
	$span_j++;

	$template->block('ignore_form', array(
		'L_MARK_ALL' => $lang['Mark_all'],
		'L_IGNORE_MARK' => $lang['ignore_mark'],
		'U_IGNORE_TOPICS' => append_sid("ignore_topics.$phpEx"))
	);

	if ( $board_config['overlib'] && $userdata['overlib'] )
	{
		$template->block('ignore_form.overlib', array(
			'L_IGNORE_EXPLAIN' => $lang['ignore_topic_submit_e'])
		);
	}
}

$template->vars(array(
	'FORUM_ID' => $forum_id,
	'FORUM_NAME' => $forum_row['forum_name'],
	'U_INDEX' => $u_index_check,
	'MODERATORS' => $forum_moderators,
	'POST_IMG' => ($forum_row['forum_status'] == FORUM_LOCKED) ? $images['post_locked'] : $images['post_new'],
	'FOLDER_IMG' => $images['folder'],
	'FOLDER_NEW_IMG' => $images['folder_new'],
	'FOLDER_HOT_IMG' => $images['folder_hot'],
	'FOLDER_HOT_NEW_IMG' => $images['folder_hot_new'],
	'FOLDER_LOCKED_IMG' => $images['folder_locked'],
	'FOLDER_LOCKED_NEW_IMG' => $images['folder_locked_new'],
	'FOLDER_STICKY_IMG' => $images['folder_sticky'],
	'FOLDER_STICKY_NEW_IMG' => $images['folder_sticky_new'],
	'FOLDER_ANNOUNCE_IMG' => $images['folder_announce'],
	'FOLDER_ANNOUNCE_NEW_IMG' => $images['folder_announce_new'],
	'FOLDER_GLOBAL_ANNOUNCE_IMG' => $images['folder_global_announce'],
	'FOLDER_GLOBAL_ANNOUNCE_NEW_IMG' => $images['folder_global_announce_new'],
	'U_SHOW_IGNORE' => $show_ignore_topics,
	'SPAN_I' => $span_i,
	'SPAN_J' => $span_j,

	'L_TOPICS' => $lang['Topics'],
	'L_REPLIES' => $lang['Replies'],
	'L_VIEWS' => $lang['Views'],
	'L_POSTS' => $lang['Posts'],
	'L_VOTES' => $lang['Votes'],
	'L_LASTPOST' => $lang['Last_Post'],
	'L_MODERATOR' => $l_moderators,
	'L_MARK_TOPICS_READ' => $lang['Mark_all_topics'],
	'L_POST_NEW_TOPIC' => ($forum_row['forum_status'] == FORUM_LOCKED) ? $lang['Forum_locked'] : $lang['Post_new_topic'],
	'L_NO_NEW_POSTS' => $lang['No_new_posts'],
	'L_NEW_POSTS' => $lang['New_posts'],
	'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'],
	'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'],
	'L_NO_NEW_POSTS_HOT' => $lang['No_new_posts_hot'],
	'L_NEW_POSTS_HOT' => $lang['New_posts_hot'],
	'L_ANNOUNCEMENT' => $lang['Post_Announcement'],
	'L_GLOBAL_ANNOUNCEMENT' => $lang['Post_global_announcement'],
	'L_STICKY' => $lang['Post_Sticky'],
	'L_POSTED' => $lang['Posted'],
	'L_JOINED' => $lang['Joined'],
	'L_AUTHOR' => $lang['Author'],
	'L_IMPORTANT_TOPICS' => $lang['Important_topics'],

	'S_AUTH_LIST' => $s_auth_can,
	'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL ."=$forum_id$show_ignore_link"),
	'U_MARK_READ' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;mark=topics$show_ignore_link&amp;sid=" . $userdata['session_id']))
);

// End header
if ( $board_config['csearch'] )
{
	$template->block('switch_search_for', []);
}
$template->vars(array(
	'SEARCH_ACTION' => 'search.'.$phpEx.'?mode=results',
	'L_SEARCH_FOR' => $lang['Search_for'],
	'L_SUBMIT_SEARCH' => $lang['Search'])
);

// Okay, lets dump out the page ...
if( $total_topics )
{
	// BEGIN fetch additional topic data
	$topic_id_list = [];
	for($i = 0; $i < $total_topics; $i++)
	{
		$topic_id_list[] = $topic_rowset[$i]['topic_id'];
	}
	$topic_id_list = implode(',', $topic_id_list);
	$helped_list = [];
	if ( $board_config['helped'] && ($forum_row['forum_no_helped'] == 0))
	{
		$sql = "SELECT topic_id
			FROM " . POSTS_TABLE . "
			WHERE topic_id IN ($topic_id_list)
				AND post_marked = 'y'
			GROUP BY topic_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain marked posts information', '', __LINE__, __FILE__, $sql);
		}
		while( $row = $db->sql_fetchrow($result) )
		{
			$helped_list[$row['topic_id']] = true;
		}
	}
	if ( $userdata['user_id'] != ANONYMOUS )
	{
		get_poster_topic_posts(explode(',', $topic_id_list), $userdata['user_id']);
	}
	// END fetch additional topic data

	$normal_topics_exists = $important_topics_exists = $enable_hide_important = false;

	for($i = 0; $i < $total_topics; $i++)
	{
		if ( $topic_rowset[$i]['topic_type'] == POST_NORMAL )
		{
			$enable_hide_important = true;
			break;
		}
	}

	for($i = 0; $i < $total_topics; $i++)
	{
		$overlib_last_post_text = $first_and_last_post = $if_poster_posts = $overlib_title = $overlib_post_text = $overlib_unread_posts = '';
		$topic_id = $topic_rowset[$i]['topic_id'];
		$topic_vote = $topic_rowset[$i]['topic_vote'];
		$topic_type = $topic_rowset[$i]['topic_type'];

		if ( $forum_row['forum_separate'] )
		{
			$topic_important = ($topic_type == POST_ANNOUNCE || $topic_type == POST_GLOBAL_ANNOUNCE || $topic_type == POST_STICKY) ? true : false;

			if ( $topic_important && !$important_topics_exists )
			{
				if ( $forum_row['forum_separate'] == 2 )
				{
					$template->vars(array('L_TOPICS' => $lang['Important_topics']));
					if ( $enable_hide_important )
					{
						$template->block('switch_show_hide', []);
					}
				}
				else
				{
					$template->block('important_topics', []);
				}
				$important_topics_exists = true;
			}
		}

		// Begin expires mod
		if ( $board_config['expire'] )
		{
			$topic_end = $topic_rowset[$i]['topic_time'] + $topic_rowset[$i]['topic_expire'];
			$topic_expire_date = ($topic_rowset[$i]['topic_expire'] == 0) ? '' : '<br />' . $lang['topic_expire'] . ' ' . @date ("m.d, H:i",$topic_end);
			if ( CR_TIME > $topic_end && $topic_rowset[$i]['topic_expire'] > 0)
			{
                $topic_expire[] = $topic_id;
			}
		}
		// End expires mod

		if (!$board_config['show_badwords'])
		{
			$topic_title = ($count_orig_word) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title'];
			$topic_title_e = ($count_orig_word) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title_e']) : $topic_rowset[$i]['topic_title_e'];
		}
		else
		{
			$topic_title = $topic_rowset[$i]['topic_title'];
			replace_bad_words($orig_word, $replacement_word, $topic_title);
			$topic_title_e = $topic_rowset[$i]['topic_title_e'];
			replace_bad_words($orig_word, $replacement_word, $topic_title_e);
		}

		$replies = $topic_rowset[$i]['topic_replies'];

		if( $topic_type == POST_ANNOUNCE && $forum_row['forum_separate'] != 2 )
		{
			$topic_type = $lang['Topic_Announcement'] . ' ';
		}
		else if( $topic_type == POST_GLOBAL_ANNOUNCE && $forum_row['forum_separate'] != 2 )
		{
			$topic_type = $lang['Topic_global_announcement'] . ' ';
		}
		else if( $topic_type == POST_STICKY && $forum_row['forum_separate'] != 2 )
		{
			$topic_type = $lang['Topic_Sticky'] . ' ';
		}
		else
		{
			$topic_type = '';
		}

		if( $topic_rowset[$i]['topic_vote'] )
		{
			$topic_type .= $lang['Topic_Poll'] . ' ';
		}
		
		if( $topic_rowset[$i]['topic_status'] == TOPIC_MOVED )
		{
			$topic_type = $lang['Topic_Moved'] . ' ';
			$topic_id = $topic_rowset[$i]['topic_moved_id'];

			$folder_image = $images['folder'];
			$folder_alt = $lang['Topics_Moved'];
			$newest_post_img = '';
		}
		else
		{
			if( $topic_rowset[$i]['topic_type'] == POST_GLOBAL_ANNOUNCE ) 
			{ 
				$folder = $images['folder_global_announce'];
				$folder_new = $images['folder_global_announce_new'];
			}
			else
			if( $topic_rowset[$i]['topic_type'] == POST_ANNOUNCE )
			{
				$folder = $images['folder_announce'];
				$folder_new = $images['folder_announce_new'];
			}
			else if( $topic_rowset[$i]['topic_type'] == POST_STICKY )
			{
				$folder = $images['folder_sticky'];
				$folder_new = $images['folder_sticky_new'];
			}
			else if( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED )
			{
				$folder = $images['folder_locked'];
				$folder_new = $images['folder_locked_new'];
			}
			else
			{
				if($replies >= $userdata['user_hot_threshold'])
				{
					$folder = $images['folder_hot'];
					$folder_new = $images['folder_hot_new'];
				}
				else
				{
					$folder = $images['folder'];
					$folder_new = $images['folder_new'];
				}
			}

			$newest_post_img = '';
			if( $userdata['session_logged_in'] )
			{
				if (empty($userdata['unread_data'][$topic_rowset[$i]['forum_id']])) {
					$userdata['unread_data'][$topic_rowset[$i]['forum_id']] = null;
				}
				if ( is_array($userdata['unread_data'][$topic_rowset[$i]['forum_id']]) && array_key_exists($topic_id, $userdata['unread_data'][$topic_rowset[$i]['forum_id']]) )
				{
					$folder_image = $folder_new;
					$folder_alt = $lang['New_posts'];

					if ( !$board_config['newest'] )
					{
						$newest_post_img = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
					}
				}
				else
				{
					$folder_image = $folder;
					$folder_alt = ($topic_rowset[$i]['topic_status'] == TOPIC_LOCKED) ? $lang['Topic_locked'] : $lang['No_new_posts'];

					$newest_post_img = '';
				}
			}
			else
			{
				$folder_image = $folder;
				$folder_alt = ($topic_rowset[$i]['topic_status'] == TOPIC_LOCKED) ? $lang['Topic_locked'] : $lang['No_new_posts'];

				$newest_post_img = '';
			}
		}

		if ( ( $replies + 1 ) > $user_posts_per_page )
		{
			$total_pages = ceil( ($replies + 1) / $user_posts_per_page );
			$goto_page = ' [ <img src="' . $images['icon_gotopost'] . '" alt="" title="' . $lang['Goto_page'] . '" />' . $lang['Goto_page'] . ': ';
			$times = 1;
			for($j = 0; $j < $replies + 1; $j += $user_posts_per_page)
			{
				$goto_page .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $topic_id . "&amp;start=$j") . '">' . $times . '</a>';
				if ( $times == 1 && $total_pages > 4 )
				{
					$goto_page .= ' ... ';
					$times = $total_pages - 3;
					$j += ($total_pages - 4) * $user_posts_per_page;
				}
				else if ( $times < $total_pages )
				{
					$goto_page .= ', ';
				}
				$times++;
			}
			$goto_page .= ' ] ';
		}
		else
		{
			$goto_page = '';
		}

		$get_unread_posts = '';
		if ( $userdata['session_logged_in'] && $board_config['newest'] && $topic_rowset[$i]['topic_status'] != TOPIC_MOVED )
		{
			if (empty($userdata['unread_data'][$topic_rowset[$i]['forum_id']][$topic_id])) {
				$userdata['unread_data'][$topic_rowset[$i]['forum_id']][$topic_id] = [];
			}
			$view_topic_url = (count($userdata['unread_data'][$topic_rowset[$i]['forum_id']][$topic_id])) ? append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"' : append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id");
		} 
		else
		{
			$view_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id");
		}

		$colored_username = color_username($topic_rowset[$i]['user_level'], $topic_rowset[$i]['user_jr'], $topic_rowset[$i]['user_id'], $topic_rowset[$i]['username']);
		/*
		$topic_rowset[$i]['username'] = $colored_username[0];
		$topic_author = ($topic_rowset[$i]['user_id'] != ANONYMOUS) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $topic_rowset[$i]['user_id']) . '"' . $colored_username[1] . ' class="genmed">' : '';
		$topic_author .= ($topic_rowset[$i]['user_id'] != ANONYMOUS) ? $topic_rowset[$i]['username'] : ( ( $topic_rowset[$i]['post_username'] != '' ) ? $topic_rowset[$i]['post_username'] : $lang['Guest'] );
		$topic_author .= ($topic_rowset[$i]['user_id'] != ANONYMOUS) ? '</a>' : '';
		*/
		$topic_author = $topic_rowset[$i]['username'] ?: $topic_rowset[$i]['post_username'] ?: $lang['Guest'];
		if ($topic_rowset[$i]['user_id'] != ANONYMOUS) {
			$topic_author = new Url("profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . '=' . $topic_rowset[$i]['user_id'], $topic_author, ['color' => $colored_username[2]]);
		}

		$topic_start_dateformat = ($board_config['topic_start_dateformat']) ? $board_config['topic_start_dateformat'] : $board_config['default_dateformat'];
		$topic_time = ($board_config['topic_start_date'] && $userdata['topic_start_date']) ? create_date($topic_start_dateformat, $topic_rowset[$i]['topic_time'], $board_config['board_timezone']) : '';

		$first_post_time = create_date($board_config['default_dateformat'], $topic_rowset[$i]['topic_time'], $board_config['board_timezone']);
		$last_post_time = create_date($board_config['default_dateformat'], $topic_rowset[$i]['post_time'], $board_config['board_timezone']);

		$colored_username = color_username($topic_rowset[$i]['user_level2'], $topic_rowset[$i]['user_jr2'], $topic_rowset[$i]['id2'], $topic_rowset[$i]['user2']);
		// $topic_rowset[$i]['user2'] = $colored_username[0];
		// $last_post_author = ($topic_rowset[$i]['id2'] == ANONYMOUS) ? (($topic_rowset[$i]['post_username2'] != '') ? $topic_rowset[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $topic_rowset[$i]['id2']) . '"' . $colored_username[1] . ' class="gensmall">' . $topic_rowset[$i]['user2'] . '</a>';

		$last_post_author = $topic_rowset[$i]['user2'] ?: $topic_rowset[$i]['post_username2'] ?: $lang['Guest'];
		if ($topic_rowset[$i]['id2'] != ANONYMOUS) {
			$last_post_author = new Url("profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . '=' . $topic_rowset[$i]['id2'], $last_post_author, ['color' => $colored_username[2]]);
		}
		
		// $last_post_url = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $topic_rowset[$i]['topic_last_post_id']) . '#' . $topic_rowset[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" alt="" title="' . $lang['Last_Post'] . '" border="0" /></a>';
		$last_post_url = new Url("viewtopic.$phpEx?" . POST_POST_URL . '=' . $topic_rowset[$i]['topic_last_post_id'] . '#' . $topic_rowset[$i]['topic_last_post_id'], '&nbsp;', ['class' => 'latest_reply']);

		$views = $topic_rowset[$i]['topic_views'];
		$participated = false;
		if ( $userdata['session_logged_in'] )
		{
			$poster_posts = get_poster_topic_posts($topic_id, $userdata['user_id']);
			if ( $poster_posts && $board_config['poster_posts'])
			{
				$participated = true;
			}
		}

		if ( $forum_moderate )
		{
			if ( !$topic_rowset[$i]['post_approve'] )
			{
				if ( ($topic_rowset[$i]['topic_poster'] == $userdata['user_id'] && $userdata['user_id'] != ANONYMOUS) || $is_auth['auth_mod'] )
				{
					$topic_title = $topic_title . $lang['Post_no_approved'];
					$topic_title_e = '';
				}
				else
				{
					$topic_title = $lang['Post_no_approved'];
					$topic_time = $topic_author = $topic_title_e = '';
				}
			}

			if ( !$topic_rowset[$i]['post_approve2'] )
			{
				if ( (($topic_rowset[$i]['id2'] == $userdata['user_id'] && $userdata['user_id'] != ANONYMOUS) || $is_auth['auth_mod']) && $topic_rowset[$i]['topic_first_post_id'] != $topic_rowset[$i]['topic_last_post_id'] )
				{
					$last_post_author =  $lang['Post_no_approved'] . $last_post_author;
				}
				else
				{
					$last_post_author = '';
				}
			}
		}

		$img = null;
		preg_match('#\[img(:[a-z0-9]+)?\](.*?)\[/img(:[a-z0-9]+)?\]#i', $topic_rowset[$i]['post_text'], $img);

		$topic_class = [];
		if ($participated) {
			$topic_class[] = 'participated';
		}

		$template->block('topicrow', array(
			'ICON' => ($topic_rowset[$i]['topic_icon'] != 0) ? '<img src="' . $images['rank_path'] . 'icon/icon' . $topic_rowset[$i]['topic_icon']. '.gif" alt="" border="0">' : ' ',
			'TOPIC_EXPIRE' => $topic_expire_date,
			'ROW_COLOR' => (!($i % 2)) ? $theme['td_color1'] : $theme['td_color2'],
			'ROW_CLASS' => (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'],
			'ROW' => (isset($helped_list[$topic_id])) ? 'row_helped' : 'row1',
			'FORUM_ID' => $forum_id,
			'TOPIC_ID' => $topic_id,
			'TOPIC_IMAGE' => $img[2] ?? '',
			'TOPIC_FOLDER_IMG' => $folder_image,
			'TOPIC_TIME' => $topic_time,
			'TOPIC_AUTHOR' => $topic_author,
			'TOPIC_VOTES' => intval($topic_rowset[$i]['topic_votes_sum']),
			'CLASS' => implode(' ', $topic_class),
			'GOTO_PAGE' => $goto_page,
			'REPLIES' => $replies,
			'NEWEST_POST_IMG' => $newest_post_img,
			'TOPIC_ATTACHMENT_IMG' => ( defined('ATTACHMENTS_ON') ) ? topic_attachment_image($topic_rowset[$i]['topic_attachment']) : '',
			'TOPIC_TITLE' => replace_encoded($topic_title),
			'TOPIC_TITLE_E' => ($topic_title_e && $board_config['title_explain']) ? replace_encoded($topic_title_e) : '',
			'TOPIC_COLOR' => ($board_config['topic_color'] && $topic_rowset[$i]['topic_color']) ? $topic_rowset[$i]['topic_color'] : '',
			'TOPIC_TYPE' => $topic_type,
			'VIEWS' => $views,
			
			'FIRST_POST_TIME' => $first_post_time, 
			'LAST_POST_TIME' => $last_post_time, 
			'LAST_POST_AUTHOR' => $last_post_author, 
			'U_LAST_POST' => $last_post_url,

			'L_TOPIC_FOLDER_ALT' => $folder_alt, 
			'U_VIEW_TOPIC' => $view_topic_url)
		);

		if ( !$topic_important && !$normal_topics_exists && $forum_row['forum_separate'] && $important_topics_exists )
		{
			if ( $forum_row['forum_separate'] == 2 )
			{
				$template->vars(array('L_NORMAL_TOPICS' => $lang['Topics']));
				$template->block('topicrow.normal_topics', []);
			}
			else
			{
				$template->block('topicrow.normal_topics_row', []);
			}
			$normal_topics_exists = true;
		}

		if ( $board_config['ignore_topics'] && $userdata['session_logged_in'] && $userdata['view_ignore_topics'] )
		{
			$template->block('topicrow.ignore_checkbox', []);
		}

		if ( $board_config['post_icon'] && $userdata['post_icon'] )
		{
			$template->block('topicrow.icons', []);
		}

		if ( $overlib_post_text )
		{
			$template->block('topicrow.title_overlib', array(
				'L_FIRST_POST' => $lang['First_post'],
				'L_LAST_POST' => $lang['Last_Post'],
				'UNREAD_POSTS' => $overlib_unread_posts,
				'O_TITLE' => $overlib_title,
				'O_TEXT1' => $overlib_post_text)
			);

			if ( $first_and_last_post )
			{
				$template->block('topicrow.title_overlib.last', array(
					'O_TEXT2' => $overlib_last_post_text)
				);
			}
		}
	}

    if(!empty($topic_expire))
    {
        require_once($phpbb_root_path . 'includes/functions_remove.' . $phpEx);
        delete_topic($topic_expire, $forum_id, true);
    }
	$topics_count -= ($total_announcements - $total_external_announcements);

	generate_pagination("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;topicdays=$topic_days$show_ignore_link", $topics_count, $user_topics_per_page, $start);
}
else
{
	if ( $forum_row['forum_status'] != FORUM_LOCKED && $board_config['ignore_topics'] && $userdata['session_logged_in'] && !$show_ignore && $start && $userdata['topic_id'] )
	{
		$lang['No_topics_post_one'] = $lang['No_topics_post_one_ignore'];
	}
	// No topics
	$no_topics_msg = ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['No_topics_post_one'];

	$template->vars(array(
		'L_NO_TOPICS' => $no_topics_msg)
	);

	$template->block('switch_no_topics', [] );

}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

$template->display($forum_row['forum_template']);