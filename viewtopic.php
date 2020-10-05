<?php
/***************************************************************************
 *                               viewtopic.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo http://www.przemo.org
 *   date modification    : ver. 1.12.5 2005/10/16 22:43
 *
 *   $Id: viewtopic.php,v 1.186.2.45 2005/10/05 17:42:04 grahamje Exp $
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

if ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) || !empty($HTTP_ENV_VARS['SERVER_NAME']) )
{
	$server_name = ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) ) ? $HTTP_SERVER_VARS['SERVER_NAME'] : $HTTP_ENV_VARS['SERVER_NAME'];
}
else if ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) || !empty($HTTP_ENV_VARS['HTTP_HOST']) )
{
	$server_name = ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) ) ? $HTTP_SERVER_VARS['HTTP_HOST'] : $HTTP_ENV_VARS['HTTP_HOST'];
}
else
{
	$server_name = '';
}

if ( isset($HTTP_GET_VARS['sleep']) && $_SERVER['REQUEST_URI'] && $server_name )
{
	$url = 'http://' . $server_name . $_SERVER['REQUEST_URI'];

	$url = substr($url, 0 ,strpos($url, 'sleep=') - strlen(6));

	if (strstr(urldecode($url), "\n") || strstr(urldecode($url), "\r"))
	{
		exit;
	}
	if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
	{
		header('Refresh: ' . intval($HTTP_GET_VARS['sleep']) . '; URL=' . $url);
	}
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="' . intval($HTTP_GET_VARS['sleep']) . '; url=' . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $url . '">HERE</a> to be redirected</div></body></html>';
	exit;
}

include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start initial var setup
//
$topic_id = $post_id = 0;
if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) )
{
	$topic_id = intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else if ( isset($HTTP_GET_VARS['topic']) )
{
	$topic_id = intval($HTTP_GET_VARS['topic']);
}

$start       = get_vars('start',       0, 'GET,POST', true);
$post_bypass = get_vars('bypass',      0, 'GET',      true);
$post_id     = get_vars(POST_POST_URL, 0, 'GET',      true);

if (!$topic_id && !$post_id)
{
	message_die(GENERAL_MESSAGE, 'No_such_post');
}

//
// Find topic id if user requested a newer
// or older topic
//
if ( isset($HTTP_GET_VARS['view']) && empty($HTTP_GET_VARS[POST_POST_URL]) )
{
	if ( $HTTP_GET_VARS['view'] == 'newest' )
	{
		if ( isset($HTTP_COOKIE_VARS[$unique_cookie_name . '_sid']) || isset($HTTP_GET_VARS['sid']) )
		{
			$session_id = isset($HTTP_COOKIE_VARS[$unique_cookie_name . '_sid']) ? $HTTP_COOKIE_VARS[$unique_cookie_name . '_sid'] : $HTTP_GET_VARS['sid'];

			if (!preg_match('/^[A-Za-z0-9]*$/', $session_id)) 
			{
				$session_id = '';
			}
			$SID = "sid=$session_id";

			if ( $session_id )
			{
				$sql = "SELECT rh.post_id
					FROM (" . READ_HIST_TABLE . " rh, " . SESSIONS_TABLE . " s, " . POSTS_TABLE . " p)
					WHERE s.session_id = '$session_id'
						AND s.session_user_id = rh.user_id
						AND p.topic_id = $topic_id
						AND rh.post_id = p.post_id
					ORDER BY p.post_order ASC, rh.post_id ASC
					LIMIT 1";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain newer/older topic information', '', __LINE__, __FILE__, $sql);
				}

				if ( !($row = $db->sql_fetchrow($result)) )
				{
					redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));
				}

				$post_id = $row['post_id'];

				$sql = "SELECT post_id FROM " . POSTS_TABLE . "
					WHERE post_id = $post_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get post_id from posts table', '', __LINE__, __FILE__, $sql);
				}

				if ( !$db->sql_affectedrows() )
				{
					$sql = "DELETE FROM " . READ_HIST_TABLE . "
						WHERE post_id = $post_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not delete post from read history table', '', __LINE__, __FILE__, $sql);
					}
					$post_id = '';
				}

				if ( !$post_id )
				{
					redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));
				}
				else
				{
					redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id", true) . "#$post_id");
				}
			}
		}
	}
	else if ( $HTTP_GET_VARS['view'] == 'next' || $HTTP_GET_VARS['view'] == 'previous' )
	{
		$sql_condition = ( $HTTP_GET_VARS['view'] == 'next' ) ? '>' : '<';
		$sql_ordering = ( $HTTP_GET_VARS['view'] == 'next' ) ? 'ASC' : 'DESC';

		$sql = "SELECT t.topic_id
			FROM (" . TOPICS_TABLE . " t, " . TOPICS_TABLE . " t2)
			WHERE
				t2.topic_id = $topic_id
				AND t.forum_id = t2.forum_id
				AND t.topic_moved_id = 0
				AND t.topic_last_post_id $sql_condition t2.topic_last_post_id
			ORDER BY t.topic_last_post_id $sql_ordering
			LIMIT 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain newer/older topic information", '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$topic_id = intval($row['topic_id']);
		}
		else
		{
			$message = ( $HTTP_GET_VARS['view'] == 'next' ) ? 'No_newer_topics' : 'No_older_topics';
			message_die(GENERAL_MESSAGE, $message);
		}
	}
}

//
// This rather complex gaggle of code handles querying for topics but
// also allows for direct linking to a post (and the calculation of which
// page the post is on and the correct display of viewtopic)
//
$join_sql_table = (!$post_id) ? '' : ", " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2 ";
$join_sql = (!$post_id) ? "t.topic_id = $topic_id" : "p.post_id = $post_id AND t.topic_id = p.topic_id AND p2.topic_id = p.topic_id AND p2.post_id <= $post_id";
$count_sql = (!$post_id) ? '' : ", p.post_order AS current_post_order, COUNT(p2.post_id) AS prev_posts";

$order_sql = (!$post_id) ? '' : "GROUP BY p.post_id, t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments, f.auth_download, t.topic_attachment ORDER BY p.post_order, p.post_id ASC";

$sql = "SELECT t.*, f.*, p3.post_approve AS topic_approve" . $count_sql . "
	FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p3" . $join_sql_table . ")
	WHERE $join_sql
		AND p3.post_id = topic_first_post_id
		AND f.forum_id = t.forum_id
	$order_sql";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}

if ( !($forum_topic_data = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'No_such_post');
}

$forum_id = intval($forum_topic_data['forum_id']);
$topic_id = intval($forum_topic_data['topic_id']);
$topic_first_post_id = $forum_topic_data['topic_first_post_id'];
//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//

$user_level = $userdata['user_level'];
$user_id = $userdata['user_id'];
$session_id = $userdata['session_id'];
$session_logged_in = $userdata['session_logged_in'];

$user_posts_per_page = ($userdata['user_posts_per_page'] > $board_config['posts_per_page']) ? $board_config['posts_per_page'] : $userdata['user_posts_per_page'];

if ( $board_config['login_require'] && !$session_logged_in )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

//
// Start auth check
//
$is_auth = array();
$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];

if( !$is_auth['auth_read'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = ($post_id) ? POST_POST_URL . "=$post_id" : POST_TOPIC_URL . "=$topic_id";
		$redirect .= ($start) ? "&start=$start" : '';
		redirect(append_sid("login.$phpEx?redirect=viewtopic.$phpEx&$redirect", true));
	}

	$message = ( !$is_auth['auth_view'] ) ? $lang['No_such_post'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}
//
// End auth check
//

$forum_view_moderate = ($forum_topic_data['forum_moderate'] && !$is_auth['auth_mod']) ? true : false;

if ( $is_auth['auth_mod'] )
{
    $accept_post = get_vars('accept_post', array(), 'POST', true, 1);
    $reject_post = get_vars('reject_post', array(), 'POST', true, 1);
    if (!empty($accept_post)){
        foreach( $accept_post as $k => $v ){
            if( !in_array($v, $reject_post) ){
                if($v === $topic_first_post_id){
                    $sql = "UPDATE " . TOPICS_TABLE . " SET topic_accept = 1 WHERE topic_id = " . $topic_id;
                    $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Error in approve topic', '', __LINE__, __FILE__, $sql);
                }

                $sql = "UPDATE " . POSTS_TABLE . " SET post_approve = 1 WHERE post_id = " . intval($v);
                $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Error in approve post', '', __LINE__, __FILE__, $sql);
            }
        }
    }
    if(!empty($reject_post)){
        require_once($phpbb_root_path . 'includes/functions_remove.' . $phpEx);
        foreach( $reject_post as $k => $v ){
            if (!in_array($v, $accept_post)) delete_post(intval($v));
        }
    }
}

if ( $HTTP_GET_VARS['action'] == 'delete' && (($is_auth['auth_mod'] && $board_config['allow_mod_delete_actions']) || $user_level == ADMIN) )
{
	$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_action = '', topic_action_user = '', topic_action_date = ''
			WHERE topic_id = $topic_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error in updating topics table', '', __LINE__, __FILE__, $sql);
	}
	redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));
}

if ( $HTTP_GET_VARS['post_edit_by'] == 'delete' && (($is_auth['auth_mod'] && $board_config['allow_mod_delete_actions']) || $user_level == ADMIN) )
{
	$sql = "UPDATE " . POSTS_TABLE . "
		SET post_edit_by = '0', post_edit_time = '0'
			WHERE post_id = $post_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error in updating posts table', '', __LINE__, __FILE__, $sql);
	}
	redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id", true) . '#' . $post_id);
}

// Password check
if ( $forum_topic_data['password'] != '' )
{
	if ( !$is_auth['auth_mod'] || $user_level != ADMIN )
	{
		$redirect = str_replace('&amp;', '&', preg_replace('#.*?([a-z]+?\.' . $phpEx . '.*?)$#i', '\1', xhtmlspecialchars($_SERVER['REQUEST_URI'])));
		$cookie_forum_pass = $unique_cookie_name . '_fpass_' . $forum_id;
		if ( $HTTP_POST_VARS['cancel'] )
		{
			redirect(append_sid("index.$phpEx"));
		}
		else if ( $HTTP_POST_VARS['submit'] )
		{
			password_check($forum_id, $HTTP_POST_VARS['password'], $redirect, $forum_topic_data['password']);
		}

		if ( ($forum_topic_data['password'] != '') && ($HTTP_COOKIE_VARS[$cookie_forum_pass] != md5($forum_topic_data['password'])) )
		{
			password_box($forum_id, $redirect);
		}
	}
}
// END Password check

$ignore_this_topic = false;
if ( $session_logged_in && $board_config['ignore_topics'] )
{
	$sql = "SELECT topic_id FROM " . TOPICS_IGNORE_TABLE . "
		WHERE user_id = " . $userdata['user_id'] . "
		AND topic_id = $topic_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain ignore topics', '', __LINE__, __FILE__, $sql);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$ignore_this_topic = true;
	}
}

if ( isset($HTTP_GET_VARS['mark_topic']) && $session_logged_in )
{
	if ( !check_sid($HTTP_GET_VARS['sid']) )
	{
		message_die(GENERAL_ERROR, 'Invalid_session');
	}

	if ( $HTTP_GET_VARS['mark_topic'] == 'read' )
	{
		$sql = "DELETE FROM " . READ_HIST_TABLE . "
			WHERE user_id = $user_id
			AND topic_id = $topic_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error deleting ignore topic', '', __LINE__, __FILE__, $sql);
		}
	}
	else if ( $HTTP_GET_VARS['mark_topic'] == 'unread' )
	{
		$unread_insert = '';

		$sql = "SELECT post_id
			FROM " . POSTS_TABLE . "
			WHERE topic_id = " . $topic_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query posts table', '', __LINE__, __FILE__, $sql);
		}

		while( $row = $db->sql_fetchrow($result) )
		{
			$unread_insert .= (($unread_insert) ? ', ' : '') . "($user_id, " . $row['post_id'] . ", $topic_id, $forum_id)";
		}
		if ( $unread_insert )
		{
			$sql2 = "INSERT IGNORE INTO " . READ_HIST_TABLE . " (user_id, post_id, topic_id, forum_id)
				VALUES $unread_insert";
			if ( !$db->sql_query($sql2) )
			{
				 message_die(GENERAL_ERROR, 'Could not insert into read history table', '',__LINE__, __FILE__, $sql2);
			}
		}
		if ( $ignore_this_topic )
		{
			$sql = "DELETE FROM " . TOPICS_IGNORE_TABLE . "
				WHERE user_id = $user_id
					AND topic_id = " . $topic_id;
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Error deleting ignore topic', '', __LINE__, __FILE__, $sql);
			}
		}
	}
}

if ( $board_config['who_viewed'] )
{
	if ( !($board_config['hide_viewed_admin'] && $user_level == ADMIN) )
	{
		$sql = "UPDATE " . TOPIC_VIEW_TABLE . "
			SET view_time = " . CR_TIME . ", view_count = view_count + 1
			WHERE topic_id = $topic_id
				AND user_id = $user_id";

		if ( !$db->sql_query($sql) || !$db->sql_affectedrows() )
		{
			$sql = "INSERT INTO " . TOPIC_VIEW_TABLE . " (topic_id, user_id, view_time, view_count)
				VALUES ($topic_id, $user_id, " . CR_TIME . ", 1)";
			$db->sql_query($sql);
		}
	}
}

$forum_name = get_object_lang(POST_FORUM_URL . $forum_topic_data['forum_id'], 'name');
$topic_title = $forum_topic_data['topic_title'];
$topic_time = $forum_topic_data['topic_time'];

if ( $post_id )
{
	if ( $forum_topic_data['topic_tree_width'] && $forum_topic_data['current_post_order'] )
	{
		$sql = "SELECT COUNT(post_id) AS prev_posts
			FROM " . POSTS_TABLE . "
			WHERE topic_id = $topic_id
				AND post_order <= " . $forum_topic_data['current_post_order'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
		}

		if ( !($prev_posts_data = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, 'No_such_post');
		}
		$forum_topic_data['prev_posts'] = $prev_posts_data['prev_posts'];
	}

	$start = floor(($forum_topic_data['prev_posts'] - 1) / $user_posts_per_page) * $user_posts_per_page;
}

//
// Is user watching this thread?
//
if( $userdata['session_logged_in'] )
{
	$can_watch_topic = TRUE;

	$sql = "SELECT notify_status
		FROM " . TOPICS_WATCH_TABLE . "
		WHERE topic_id = $topic_id
			AND user_id = " . $userdata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain topic watch information", '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$notify_user = true;
		if ( isset($HTTP_GET_VARS['unwatch']) )
		{
			if ( !check_sid($HTTP_GET_VARS['sid']) )
			{
				message_die(GENERAL_ERROR, 'Invalid_session');
			}

			if ( $HTTP_GET_VARS['unwatch'] == 'topic' )
			{
				$is_watching_topic = 0;

				$sql_priority = (SQL_LAYER == 'mysql') ? 'LOW_PRIORITY' : '';
				$sql = "DELETE $sql_priority FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $topic_id
					AND user_id = $user_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not delete topic watch information', '', __LINE__, __FILE__, $sql);
				}
			}
			
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">')
			);

			$message = $lang['No_longer_watching'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_topic = TRUE;

			if ( $row['notify_status'] )
			{
				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "UPDATE $sql_priority " . TOPICS_WATCH_TABLE . "
					SET notify_status = 0
					WHERE topic_id = $topic_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not update topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}
		}
	}
	else
	{
		if ( isset($HTTP_GET_VARS['watch']) )
		{
			if ( $HTTP_GET_VARS['watch'] == 'topic' )
			{
				if ( !check_sid($HTTP_GET_VARS['sid']) )
				{
					message_die(GENERAL_ERROR, 'Invalid_session');
				}

				$is_watching_topic = TRUE;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "INSERT $sql_priority INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
					VALUES (" . $userdata['user_id'] . ", $topic_id, 0)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not insert topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">')
			);

			$message = $lang['You_are_watching'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_topic = 0;
		}
	}
}
else
{
	if ( isset($HTTP_GET_VARS['unwatch']) )
	{
		if ( $HTTP_GET_VARS['unwatch'] == 'topic' )
		{
			redirect(append_sid("login.$phpEx?redirect=viewtopic.$phpEx&" . POST_TOPIC_URL . "=$topic_id&unwatch=topic", true));
		}
	}
	else
	{
		$can_watch_topic = 0;
		$is_watching_topic = 0;
	}
}

// Begin Helped
if ( isset($HTTP_GET_VARS['p_del']) && $is_auth['auth_mod'] && $board_config['helped'] && !$forum_topic_data['forum_no_helped'] )
{
	$p_del = intval($HTTP_GET_VARS['p_del']);
	if ( !$HTTP_GET_VARS['c_del'] )
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['helped_delete_confirm'], '<a href="' . append_sid("viewtopic.$phpEx?t=$topic_id&amp;p_del=$p_del&amp;c_del=1&amp;sid=$session_id") . '">', '</a>', '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$p_del#$p_del") . '">', '</a>'));
	}

	$sql = "SELECT poster_id FROM " . POSTS_TABLE . "
		WHERE post_id = $p_del
			AND post_marked = 'y'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query posts table', '', __LINE__, __FILE__, $sql3);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$sql = "UPDATE " . POSTS_TABLE . " SET post_marked = NULL
			WHERE post_id = " . $p_del; 
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query posts table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . USERS_TABLE . " SET special_rank = special_rank - 1
			WHERE user_id = " . $row['poster_id'];

		if ( $db->sql_query($sql) )
		{
			redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $p_del . '#' . $p_del, true));
		} 
	}
}

$rank = '';

if ( isset($HTTP_GET_VARS['p_add']) && $board_config['helped'] && !$forum_topic_data['forum_no_helped'] && $userdata['user_allow_helped'])
{
	$p_add = intval($HTTP_GET_VARS['p_add']);

	if ( !isset($HTTP_GET_VARS['c_add']) )
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['helped_confirm'], '<a href="' . append_sid("viewtopic.$phpEx?t=$topic_id&amp;p_add=$p_add&amp;c_add=1&amp;sid=$session_id") . '">', '</a>', '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$p_add#$p_add") . '">', '</a>'));
	}

	if ( !check_sid($HTTP_GET_VARS['sid']) )
	{
		message_die(GENERAL_ERROR, 'Invalid_session');
	}

	$sql = "SELECT post_marked, poster_id FROM " . POSTS_TABLE . "
		WHERE post_id = $p_add";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query posts table', '', __LINE__, __FILE__, $sql3);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['post_marked'] != 'y' && $row['poster_id'] != $userdata['user_id'])
		{
			$sql = "SELECT special_rank FROM " . USERS_TABLE . "
				WHERE user_id = " . $row['poster_id'];

			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query users table', '', __LINE__, __FILE__, $sql3);
			}
			if ( $row2 = $db->sql_fetchrow($result) )
			{
				$rank = ($row2['special_rank']) ? intval($row2['special_rank']) : 0;

				$sql3 = "SELECT topic_poster FROM " . TOPICS_TABLE . "
					WHERE topic_id = $topic_id
						AND topic_poster = " . $userdata['user_id'];

				if ( !($result3 = $db->sql_query($sql3)) )
				{
					message_die(GENERAL_ERROR, 'Could not query topics table', '', __LINE__, __FILE__, $sql3);
				}
				if ( !($row3 = $db->sql_fetchrow($result3)) )
				{
					message_die(GENERAL_ERROR, $lang['Not_Authorised']);
				}

				$sql4 = "SELECT topic_id FROM " . POSTS_TABLE . "
				WHERE post_id = $p_add";

				if ( !($result4 = $db->sql_query($sql4)) )
				{
					message_die(GENERAL_ERROR, 'Could not query posts table', '', __LINE__, __FILE__, $sql4);
				}
				$row4 = $db->sql_fetchrow($result4);

				if ( $row4['topic_id'] != $topic_id )
				{
					message_die(GENERAL_ERROR, $lang['Not_Authorised']);
				}

				$sql = "UPDATE " . POSTS_TABLE . " SET post_marked = 'y'
					WHERE post_id = " . $p_add; 
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query posts table', '', __LINE__, __FILE__, $sql);
				}

				$sql2 = "UPDATE " . USERS_TABLE . " SET special_rank = " . (++$rank) . "
					WHERE user_id = " . $row['poster_id'];

				if ( $db->sql_query($sql) && $db->sql_query($sql2) ) 
				{
					$template->assign_vars(array( 
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $p_add) . '#' . $p_add .'">')
					); 

					$message = sprintf($lang['helped_added'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $p_add) . '#' . $p_add . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message); 
				} 
			} 
		} 
	} 
} 
// End Helped

//
// Generate a 'Show posts in previous x days' select box. If the postdays var is POSTed
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
//
$previous_days = array(0, 15, 30, 60, 120, 360, 720, 1440, 2880, 4320, 5760, 7200, 8640, 10080, 20160, 43200, 129600, 259200, 524160);
$previous_days_text = array($lang['All_Posts'], $lang['15_min'], $lang['30_min'], $lang['1_Hour'], $lang['2_Hour'], $lang['6_Hour'], $lang['12_Hour'], $lang['1_Day'], $lang['2_Days'], $lang['3_Days'], $lang['4_Days'], $lang['5_Days'], $lang['6_Days'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if( !empty($HTTP_POST_VARS['postdays']) || !empty($HTTP_GET_VARS['postdays']) )
{
	$post_days = ( !empty($HTTP_POST_VARS['postdays']) ) ? intval($HTTP_POST_VARS['postdays']) : intval($HTTP_GET_VARS['postdays']);
	$min_post_time = CR_TIME - (intval($post_days) * 60);

	$sql = "SELECT COUNT(p.post_id) AS num_posts
		FROM (" . TOPICS_TABLE . " t, " . POSTS_TABLE . " p)
		WHERE t.topic_id = $topic_id
			AND p.topic_id = t.topic_id
			AND p.post_time >= $min_post_time";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain limited topics count information", '', __LINE__, __FILE__, $sql);
	}

	$total_replies = ( $row = $db->sql_fetchrow($result) ) ? intval($row['num_posts']) : 0;

	$limit_posts_time = "AND p.post_time >= $min_post_time ";

	if ( !empty($HTTP_POST_VARS['postdays']))
	{
		$start = 0;
	}
}
else
{
	$total_replies = intval($forum_topic_data['topic_replies']) + 1;

	$limit_posts_time = '';
	$post_days = 0;
}

$select_post_days = '<select name="postdays">';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($post_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$select_post_days .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}
$select_post_days .= '</select>';

//
// Decide how to order the post display
//
if ( !empty($HTTP_POST_VARS['postorder']) || !empty($HTTP_GET_VARS['postorder']) )
{
	$post_order = (!empty($HTTP_POST_VARS['postorder'])) ? xhtmlspecialchars($HTTP_POST_VARS['postorder']) : xhtmlspecialchars($HTTP_GET_VARS['postorder']);
	$post_time_order = ($post_order == "asc") ? "ASC" : "DESC";
	$order_by = 'p.post_time ' . $post_time_order;
}
else
{
	$post_order = 'asc';
	$post_time_order = 'ASC';
	$order_by = 'p.post_order, p.post_time ' . $post_time_order;
}

$select_post_order = '<select name="postorder">';
if ( $post_time_order == 'ASC' )
{
	$select_post_order .= '<option value="asc" selected="selected">' . $lang['Oldest_First'] . '</option><option value="desc">' . $lang['Newest_First'] . '</option>';
}
else
{
	$select_post_order .= '<option value="asc">' . $lang['Oldest_First'] . '</option><option value="desc" selected="selected">' . $lang['Newest_First'] . '</option>';
}
$select_post_order .= '</select>';

//
// Go ahead and pull all data for this topic
//
$sgv = '';
$sgv .= ($board_config['post_icon'] && $userdata['post_icon']) ? ', p.post_icon' : '';
$sgv .= ($board_config['cagent'] && $userdata['cagent']) ? ', p.user_agent' : '';
$sgv .= (defined('ATTACHMENTS_ON')) ? ', p.post_attachment' : '';
$sgv .= ($board_config['expire']) ? ', p.post_expire' : '';
$sgv .= (!$board_config['report_disable']) ? ', p.reporter_id' : '';
$sgv .= (!$forum_topic_data['forum_no_helped'] && $board_config['helped']) ? ', p.post_marked' : '';
$sgv .= ($board_config['allow_sig_image']) ? ', u.user_sig_image' : '';
$sgv .= ($board_config['cfrom']) ? ', u.user_from' : '';
$sgv .= ($board_config['clevell'] || $board_config['cleveld'] || $board_config['cjoin']) ? ', u.user_regdate' : '';
$sgv .= ($board_config['gender']) ? ', u.user_gender' : '';
$sgv .= ($board_config['cicq']) ? ', u.user_icq' : '';
$sgv .= ($board_config['cgg']) ? ', u.user_aim, u.user_viewaim' : '';
$sgv .= ($board_config['cmsn']) ? ', u.user_msnm' : '';
$sgv .= ($board_config['cyahoo']) ? ', u.user_yim' : '';
$sgv .= (!$forum_topic_data['forum_no_helped'] && $board_config['helped']) ? ', u.special_rank, u.user_allow_helped' : '';

$sgv .= ($board_config['custom_color_use'] || $board_config['custom_color_mod'] || $board_config['custom_color_view']) ? ', u.can_custom_color, u.user_custom_color' : '';
$sgv .= ($board_config['allow_avatar_remote']) ? ', u.user_avatar_width, u.user_avatar_height' : '';

$custom_fields = custom_fields('', 'viewtopic', $forum_id);
$fields_to_get = '';

if (empty($custom_fields[0])) {
	$custom_fields[0] = [];
}

for($i = 0; $i < count($custom_fields[0]); $i++)
{
	$split_field = 'u.user_field_' . $custom_fields[0][$i] . ', u.user_allow_field_' . $custom_fields[0][$i];
	if ( $custom_fields[7][$i] )
	{
		$fields_to_get .= ', ' . $split_field;
	}
}

$sgv .= $fields_to_get . ', ';

if ( intval($board_config['ph_days']) )
{
	$ph_field = ", ph.th_post_id";
	$ph_table = "LEFT JOIN " . POSTS_HISTORY_TABLE . " ph ON (ph.th_post_id = p.post_id)";
}
else
{
	$ph_field = $ph_table = '';
}

$sql = "SELECT p.post_id, p.post_time, p.post_start_time, p.enable_sig, p.enable_html, p.enable_smilies, p.post_edit_count, p.post_edit_time, p.post_username, p.post_approve, p.poster_delete, p.post_edit_by, p.post_parent" . $sgv . "u.user_id, u.username, u.user_level, u.user_jr, u.user_allowhtml, u.user_posts, u.user_allowsig, u.user_sig, u.user_sig_bbcode_uid, u.user_allowsmile, u.user_avatar_type, u.user_allowavatar, u.user_avatar, u.user_rank, u.user_viewemail, u.user_website, u.user_email, u.can_custom_ranks, u.user_custom_rank, u.user_session_time, u.user_allow_viewonline, pt.post_text, pt.bbcode_uid, pt.post_subject $ph_field
	FROM " . POSTS_TABLE . " p
	$ph_table
	LEFT JOIN " . POSTS_TEXT_TABLE . " pt ON (pt.post_id = p.post_id)
	LEFT JOIN " . USERS_TABLE . " u ON (u.user_id = p.poster_id)
	WHERE p.topic_id = $topic_id
		$limit_posts_time
	GROUP by p.post_id
	ORDER BY $order_by
	LIMIT $start, $user_posts_per_page";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain post/user information.', '', __LINE__, __FILE__, $sql);
}

$postrow = array();
$posters_id = array();
$posts_id = array();

$poster_id_sql = '';
if ( $row = $db->sql_fetchrow($result) )
{
	do
	{
		$postrow[] = $row;
		if( !in_array($row['user_id'], $posters_id) )
		{
			$posters_id[] = $row['user_id'];
		}
		$posts_id[] = $row['post_id'];
		$poster_id_sql .= ($row['user_rank']) ? '' : ( ',' . $row['user_id'] );
	}
	while ( $row = $db->sql_fetchrow($result) );
	$db->sql_freeresult($result);

	$total_posts = count($postrow);
}
else
{
	require_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
	sync('topic', $topic_id, true);
	message_die(GENERAL_MESSAGE, $lang['No_posts_topic']);
}
unset($posts_id);

if ( $session_logged_in )
{
	include($phpbb_root_path . 'includes/read_history.'.$phpEx);
	$userdata = user_unread_posts();
	$new_posts_to_delete = array();
}

// Get warnings for users
if ( $board_config['viewtopic_warnings'] && $board_config['warnings_enable'] )
{
	$sql = "SELECT userid, value
		FROM " . WARNINGS_TABLE . "
		WHERE userid IN (" . implode(',', $posters_id) . ")
			AND archive = '0'";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldnt Query value info from warnings table', '', __LINE__, __FILE__, $sql);
	}
	$warnings = array();

	foreach( $posters_id as $poster_id )
	{
		$warnings[$poster_id] = 0;
	}
	while($row = $db->sql_fetchrow($result))
	{
		$warnings[$row['userid']] += $row['value'];
	}
}

$resync = false;
if ( $forum_topic_data['topic_replies'] + 1 < $start + count($postrow) )
{
	$resync = true;
}
else if ( ($start + $user_posts_per_page > $forum_topic_data['topic_replies']) && !$forum_topic_data['topic_tree_width'] )
{
	$row_id = intval($forum_topic_data['topic_replies']) % intval($user_posts_per_page);
	if ( $postrow[$row_id]['post_id'] != $forum_topic_data['topic_last_post_id'] || $start + count($postrow) < $forum_topic_data['topic_replies'] )
	{
		$resync = true;
	}
}
else if ( count($postrow) < $user_posts_per_page && !$forum_topic_data['topic_tree_width'] )
{
	$resync = true;
}

if ( $resync && $board_config['last_resync'] < (CR_TIME - 1500) )
{
	update_config('last_resync', CR_TIME);
	require_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
	sync('topic', $topic_id, true);

	$result = $db->sql_query('SELECT COUNT(post_id) AS total FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $topic_id);
	$row = $db->sql_fetchrow($result);
	$total_replies = $row['total'];
}

$ranksrow = $list_ranks = array();
$rank_group_id_sql = '';

$list_ranks = sql_cache('check', 'list_ranks');
if (!isset($list_ranks))
{
	$list_ranks = array();
	$sql = "SELECT *
		FROM " . RANKS_TABLE . "
		ORDER BY rank_special, rank_min DESC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain ranks information.', '', __LINE__, __FILE__, $sql);
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		$list_ranks[] = $row;
	}
	$db->sql_freeresult($result);
	sql_cache('write', 'list_ranks', $list_ranks);
}

if (empty($list_ranks)) {
	$list_ranks = [];
}

for($i=0; $i < count($list_ranks); $i++)
{
	$row = $list_ranks[$i];
	if ( $row['rank_special'] )
	{
		$ranksrow[-1][$row['rank_id']] = $row;
	}
	else
	{
		$ranksrow[$row['rank_group']][] = $row;
		$rank_group_id_sql .= $row['rank_group'] > 0 ? ( ',' . $row['rank_group'] ) : '';
		$ranksrow[$row['rank_group']]['count']++;
	}
}

$poster_group = array();
if ( !empty($poster_id_sql) && !empty($rank_group_id_sql) )
{
	$rank_group_id_sql = substr($rank_group_id_sql, 1);
	$poster_id_sql = substr($poster_id_sql, 1);

	$sql = "SELECT ug.user_id, ug.group_id
		FROM (" . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g)
		WHERE ug.user_id IN ( $poster_id_sql )
			AND ug.group_id IN ( $rank_group_id_sql )
			AND g.group_id = ug.group_id
			AND g.group_single_user = 0
			AND ug.user_pending <> 1
			ORDER by g.group_order DESC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain poster group information.', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$poster_group[$row['user_id']] = $row['group_id'];
	}
	$db->sql_freeresult($result);
}

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
$replacement_word_html = array();
obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

//
// Censor topic title
//
if ( !$board_config['show_badwords'] )
{
	if ( count($orig_word) )
	{
		$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
	}
}
else
{
	replace_bad_words($orig_word, $replacement_word, $topic_title);
}

if ( $forum_topic_data['forum_moderate'] && !$forum_topic_data['topic_approve'] && ($forum_topic_data['topic_poster'] != $userdata['user_id'] || $userdata['user_id'] == ANONYMOUS) && !$is_auth['auth_mod'] )
{
	$topic_title = $forum_topic_data['topic_title'] = '';
}

//
// Was a highlight request part of the URI?
//
$highlight_match = $highlight = '';
$words = get_vars('highlight', '', 'GET');
if(!empty($words))
{
	// Split words and phrases
	$words = explode(' ', trim(xhtmlspecialchars($words)));

	for($i = 0; $i < sizeof($words); $i++)
	{
		if (trim($words[$i]) != '')
		{
			$highlight_match .= (($highlight_match != '') ? '|' : '') . str_replace('*', '\w*', preg_quote($words[$i], '#'));
		}
	}
	unset($words);

	$highlight = urlencode($HTTP_GET_VARS['highlight']);
	$highlight_match = phpbb_rtrim($highlight_match, "\\");
}

//
// Post, reply and other URL generation for
// templating vars
//
$new_topic_url = append_sid("posting.$phpEx?mode=newtopic&amp;" . POST_FORUM_URL . "=$forum_id");
$reply_topic_url = append_sid("posting.$phpEx?mode=reply&amp;" . POST_TOPIC_URL . "=$topic_id");
$view_forum_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id");
$view_prev_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=previous");
$view_next_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=next");

//
// Mozilla navigation bar
//
$nav_links['prev'] = array(
	'url' => $view_prev_topic_url,
	'title' => $lang['View_previous_topic']
);
$nav_links['next'] = array(
	'url' => $view_next_topic_url,
	'title' => $lang['View_next_topic']
);
$nav_links['up'] = array(
	'url' => $view_forum_url,
	'title' => $forum_name
);

if ( $HTTP_GET_VARS['cp'] && $HTTP_GET_VARS['ap'] )
{
	$reply_topic_back_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=0&amp;postorder=0&amp;start=" . (intval($HTTP_GET_VARS['cp']) * $user_posts_per_page));
	message_die('GENERAL_MESSAGE', sprintf($lang['Loser_protect'], intval($HTTP_GET_VARS['cp']), intval($HTTP_GET_VARS['ap']), '<a href="' . $reply_topic_back_url . '">', '</a>', '<a href="' . $reply_topic_url . '">', '</a>'));
}

$forum_topic_locked = ($forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED) ? true : false;

if ( $board_config['graphic'] )
{
	$reply_img = ($forum_topic_locked) ? $images['reply_locked'] : $images['reply_new'];
	$reply_alt = ($forum_topic_locked) ? $lang['Topic_locked'] : $lang['Reply_to_topic'];
	$post_img = ($forum_topic_data['forum_status'] == FORUM_LOCKED) ? $images['post_locked'] : $images['post_new'];
	$post_alt = ($forum_topic_data['forum_status'] == FORUM_LOCKED) ? $lang['Forum_locked'] : $lang['Post_new_topic'];
}
else
{
	$mini_reply = ($forum_topic_locked) ? $lang['mini_locked'] : $lang['mini_reply'];
	$mini_newtopic = ($forum_topic_data['forum_status'] == FORUM_LOCKED) ? $lang['mini_locked'] : $lang['mini_newtopic'];
	$reply_img = $images['spacer'] . '" border="0" />[ ' . $mini_reply . ' ]</a><a href=""><img src="' . $images['spacer'] . '" alt="';
	$post_img = $images['spacer'] . '" border="0" />[ ' . $mini_newtopic . ' ]</a><a href=""><img src="' . $images['spacer'] . '" alt="';
}

//
// Load templates
//
$template->set_filenames(array(
	'body' => 'viewtopic_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx, $forum_id);

//
// Output page header
//
$page_title = $lang['View_topic'] .' - ' . $topic_title;
$nav_data = array($forum_id, $forum_topic_data['topic_title']);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

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

$s_auth_can = (( $is_auth['auth_post']) ? $lang['Rules_post_can'] : $lang['Rules_post_cannot']) . '<br />';
$s_auth_can .= (( $is_auth['auth_reply']) ? $lang['Rules_reply_can'] : $lang['Rules_reply_cannot']) . '<br />';
$s_auth_can .= (( $is_auth['auth_edit']) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot']) . '<br />';
$s_auth_can .= (( $is_auth['auth_delete']) ? $lang['Rules_delete_can'] : $lang['Rules_delete_cannot']) . '<br />';
$s_auth_can .= (( $is_auth['auth_vote']) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot']) . '<br />';

if ( defined('ATTACHMENTS_ON') )
{
	attach_build_auth_levels($is_auth, $s_auth_can);
}

$topic_mod = '';

if ( $is_auth['auth_mod'] )
{
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $session_id . '">', '</a>');
	$topic_mod .= ($is_auth['auth_delete']) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $session_id . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;' : '';
	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=move&amp;sid=" . $session_id . '"><img src="' . $images['topic_mod_move'] . '" alt="' . $lang['Move_topic'] . '" title="' . $lang['Move_topic'] . '" border="0" /></a>&nbsp;';
	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=mergepost&amp;sid=" . $session_id . '"><img src="' . $images['topic_mod_merge'] . '" alt="' . $lang['Merge_post'] . '" title="' . $lang['Merge_post'] . '" border="0" /></a>&nbsp;';
	$topic_mod .= ($forum_topic_data['topic_status'] == TOPIC_UNLOCKED) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=lock&amp;sid=" . $session_id . '"><img src="' . $images['topic_mod_lock'] . '" alt="' . $lang['Lock_topic'] . '" title="' . $lang['Lock_topic'] . '" border="0" /></a>&nbsp;' : '<a href="' . append_sid("modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=unlock&amp;sid=" . $session_id . "") . '"><img src="' . $images['topic_mod_unlock'] . '" alt="' . $lang['Unlock_topic'] . '" title="' . $lang['Unlock_topic'] . '" border="0" /></a>&nbsp;';
	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=split&amp;sid=" . $session_id . '"><img src="' . $images['topic_mod_split'] . '" alt="' . $lang['Split_topic'] . '" title="' . $lang['Split_topic'] . '" border="0" /></a>&nbsp;';
	$normal_button = "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=normalise&amp;sid=" . $session_id . '"><img src="' . $images['folder'] . '" alt="' . $lang['Normal_topic'] . '" title="' . $lang['Normal_topic'] . '" border="0" /></a>&nbsp;';
	$sticky_button = ($is_auth['auth_sticky']) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=sticky&amp;sid=" . $session_id . '"><img src="' . $images['folder_sticky'] . '" alt="' . $lang['Sticky_topic'] . '" title="' . $lang['Sticky_topic'] . '" border="0" /></a>&nbsp;' : '';
	$announce_button = ($is_auth['auth_announce']) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=announce&amp;sid=" . $session_id . '"><img src="' . $images['folder_announce'] . '" alt="' . $lang['Announce_topic'] . '" title="' . $lang['Announce_topic'] . '" border="0" /></a>&nbsp;' : '';

	switch( $forum_topic_data['topic_type'] )
	{
		case POST_NORMAL: 
			$topic_mod .= $sticky_button . $announce_button;
			break;
		case POST_STICKY:
			$topic_mod .= $announce_button . $normal_button;
			break;
		case POST_ANNOUNCE:
			$topic_mod .= $sticky_button . $normal_button;
			break;
	}

	if ( $board_config['expire'] )
	{
		$topic_mod .= '<br /><span class="gensmall">' . $lang['topic_expire_mod'];
		$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=expire1&amp;sid=" . $session_id . '" class="mainmenu" title="' . $lang['expire_e'] . '">1</a>&nbsp;';
		$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=expire2&amp;sid=" . $session_id . '" class="mainmenu" title="' . $lang['expire_e'] . '">2</a>&nbsp;';
		$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=expire7&amp;sid=" . $session_id . '" class="mainmenu" title="' . $lang['expire_e'] . '">7</a>&nbsp;';
		$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=expire14&amp;sid=" . $session_id . '" class="mainmenu" title="' . $lang['expire_e'] . '">14</a> ' . $lang['Days'] . '</span>&nbsp;';
	}
}

//
// Topic watch information
//
$s_watching_topic = '';
if ( $can_watch_topic )
{
	if ( $is_watching_topic )
	{
		$s_watching_topic = '<br /><a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;unwatch=topic&amp;start=$start&amp;sid=" . $session_id . "") . '">' . $lang['Stop_watching_topic'] . '</a>';
	}
	else
	{
		$s_watching_topic = '<br /><a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;watch=topic&amp;start=$start&amp;sid=" . $session_id . "") . '">' . $lang['Start_watching_topic'] . '</a>';
	}
}

//
// If we've got a hightlight set pass it on to pagination,
// I get annoyed when I lose my highlight after the first page.
//
$base_url = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order" . (($highlight != '') ? "&amp;highlight=$highlight" : '');
generate_pagination($base_url, $total_replies, $user_posts_per_page, $start);

if ( $board_config['who_viewed'] && $session_logged_in )
{
	$topic_view_img = '<br /><a href="' . append_sid("topic_view_users.$phpEx?".POST_TOPIC_URL."=$topic_id") . '">' . $lang['Topic_view_users'] . '</a>';
	if ( $board_config['who_viewed_admin'] && !$is_auth['auth_mod'] && $user_level != ADMIN )
	{
		$topic_view_img = '';
	}
}

$u_index_check = append_sid("index.$phpEx");

$view_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $topic_id);

$ignore_status = '';

if ( $board_config['ignore_topics'] && $session_logged_in && $userdata['view_ignore_topics'] )
{
	$ignore_status = ($ignore_this_topic) ? '&nbsp;&nbsp;&nbsp;<span class="gensmall">[ <a href="' . append_sid("ignore_topics.$phpEx?mode=view&amp;topic_ignore=$topic_id") . '">' . $lang['current_topic_ignore'] . '</a> ]</span>' : '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . append_sid("ignore_topics.$phpEx?topic_id=$topic_id&amp;sid=" . $session_id . "") . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['ignore_topic'] . '" title="' . $lang['ignore_topic'] . '" border="0" align="top"/></a>';
}

if ( $board_config['cignore'] && $userdata['cignore'] && $userdata['session_logged_in'] )
{
	$ignored_users = array();
	$sql = "SELECT user_ignore
		FROM " . IGNORE_TABLE . "
		WHERE user_id = $user_id";
	if ( !$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not get data from ignore table', __LINE__, __FILE__, $sql);
	}
	while($row = $db->sql_fetchrow($result))
	{
		$ignored_users[] = $row['user_ignore'];
	}
}

$current_page = (floor($start / $user_posts_per_page) + 1);
$all_pages = ceil($total_replies / $user_posts_per_page);

$show_quickreply = (!$board_config['cquick'] || (!$session_logged_in && $board_config['not_anonymous_quickreply']) || !$userdata['cquick']) ? false : true;

if ( !$is_auth['auth_reply'] || ( !$is_auth['auth_mod'] && ($forum_topic_locked) ) )
{
	$show_quickreply = false;
}

if ( $show_quickreply && $all_pages != $current_page )
{
	$reply_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $topic_id . "&amp;cp=" . $current_page . "&amp;ap=" . $all_pages);
	$show_quickreply = ($board_config['group_rank_hack_version']) ? true : false; // Sorry for: group_rank_hack_version :)
}

$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
$script_name = ($script_name == '') ? $script_name : '/' . $script_name;

if ( $forum_topic_data['topic_action'] && $forum_topic_data['topic_action_user'] != ANONYMOUS)
{
	switch( $forum_topic_data['topic_action'] )
	{
		case UNLOCKED:
			$l_action = $lang['TA_Unocked'];
			$show_action = ($board_config['show_action_unlocked']) ? true : false;
		break;
		case LOCKED:
			$l_action = $lang['TA_Locked'];
			$show_action = ($board_config['show_action_locked']) ? true : false;
		break;
		case MOVED:
			$l_action = $lang['TA_Moved'];
			$show_action = ($board_config['show_action_moved']) ? true : false;
		break;
		case EXPIRED:
			$l_action = $lang['TA_Expired'];
			$show_action = ($board_config['show_action_expired'] && ($forum_topic_data['topic_expire'] > 0)) ? true : false;
		break;
	}

	if ( $show_action )
	{
		$by_userdata = get_userdata($forum_topic_data['topic_action_user'], false, 'username');

		$template->assign_block_vars('topic_action', array(
			'L_WHO' => $lang['TA_Who'],
			'USERNAME' => $by_userdata['username'],
			'PROFILE_URL' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $forum_topic_data['topic_action_user']),
			'DATE' => create_date($board_config['default_dateformat'], $forum_topic_data['topic_action_date'], $board_config['board_timezone']),
			'TOPIC_ACTION' => $l_action)
		);

		if ( ($is_auth['auth_mod'] && $board_config['allow_mod_delete_actions']) || $user_level == ADMIN )
		{
			$template->assign_block_vars('topic_action.topic_action_delete', array(
				'U_DELETE_ACTION' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;action=delete"),
				'DELETE_TITLE' => $lang['TA_Delete'])
			);
		}
	}
	else
	{
		$template->assign_block_vars('switch_no_topic_action', array());
	}
}
else
{
	$template->assign_block_vars('switch_no_topic_action', array());
}

//
// Send vars to template
//
$template->assign_vars(array(
	'FORUM_ID' => $forum_id,
	'FORUM_NAME' => $forum_name,
	'TOPIC_ID' => $topic_id,
	'TOPIC_TITLE' => replace_encoded($topic_title),
	'TOPIC_TITLE_B' => $b_topic_title,
	'TOPIC_COLOR' => ($board_config['topic_color'] && $forum_topic_data['topic_color']) ? ' style="color: ' . $forum_topic_data['topic_color'] . '"' : '',

	'POST_IMG' => $post_img,
	'REPLY_IMG' => $reply_img,
	'IGNORE_STATUS' => $ignore_status,
	'COMMENT_POST_IMG' => $images['icon_latest_reply'],
	'PAGE_NUMBER' => ($all_pages > 1) ? sprintf($lang['Page_of'], $current_page, $all_pages) : '',
	'TELLFRIEND_BOX' => ($board_config['cfriend'] && $session_logged_in) ? '<a href="' . append_sid("tellafriend.$phpEx?topic_id=$topic_id") . '">' . $lang['s_email_friend'] . '</a><br />' : '',
	'TOPIC_VIEW_IMG' => $topic_view_img,

	'L_COMMENT_IMG_TITLE' => $lang['Comment_post'],
	'L_PRINT' => $lang['Print_View'],
	'L_AUTHOR' => $lang['Author'],
	'L_MESSAGE' => $lang['Message'],
	'L_POSTED' => $lang['Posted'],
	'L_POST_SUBJECT' => $lang['Post_subject'],
	'L_VIEW_NEXT_TOPIC' => $lang['View_next_topic'],
	'L_VIEW_PREVIOUS_TOPIC' => $lang['View_previous_topic'],
	'L_POST_NEW_TOPIC' => $post_alt,
	'L_POST_REPLY_TOPIC' => $reply_alt,
	'L_DISPLAY_POSTS' => $lang['Display_posts'],
	'L_LOCK_TOPIC' => $lang['Lock_topic'],
	'L_UNLOCK_TOPIC' => $lang['Unlock_topic'],
	'L_MOVE_TOPIC' => $lang['Move_topic'],
	'L_SPLIT_TOPIC' => $lang['Split_topic'],
	'L_DELETE_TOPIC' => $lang['Delete_topic'],
	'L_GOTO_PAGE' => $lang['Goto_page'],
	'L_LEVEL' => $lang['l_level'],
	'L_TOPIC_BOOKMARK' => $lang['Topic_bookmark'],
	'L_REJECT' => $lang['Reject'],
	'L_ACCEPT' => $lang['Accept'],

	'S_TOPIC_LINK' => POST_TOPIC_URL,
	'S_SELECT_POST_DAYS' => $select_post_days,
	'S_SELECT_POST_ORDER' => $select_post_order,
	'S_POST_DAYS_ACTION' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $topic_id . "&amp;start=$start"),
	'S_AUTH_LIST' => $s_auth_can,
	'S_TOPIC_ADMIN' => $topic_mod,
	'S_WATCH_TOPIC' => $s_watching_topic,


	'U_VIEW_TOPIC' => $view_topic_url,
	'U_VIEW_FORUM' => $view_forum_url,
	'U_VIEW_OLDER_TOPIC' => $view_prev_topic_url,
	'U_VIEW_NEWER_TOPIC' => $view_next_topic_url,
	'U_POST_NEW_TOPIC' => $new_topic_url,
	'U_POST_REPLY_TOPIC' => $reply_topic_url,
	'U_INDEX' => $u_index_check,
	'U_PRINT' => append_sid("printview.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start"),
	'U_TOPIC_BOOKMARK' => $server_protocol . $server_name . $server_port . $script_name . "/viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id")
);

//
// Does this topic contain a poll?
//
if ( !empty($forum_topic_data['topic_vote']) && (!$forum_topic_data['forum_moderate'] || $forum_topic_data['topic_approve'] || $forum_topic_data['topic_poster'] == $userdata['user_id'] || $is_auth['auth_mod']) )
{
	$s_hidden_fields = '';

	$sql = "SELECT vd.vote_id, vd.vote_text, vd.vote_start, vd.vote_length, vd.vote_max, vd.vote_voted, vd.vote_hide, vd.vote_tothide, vr.vote_option_id, vr.vote_option_text, vr.vote_result
		FROM (" . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr)
		WHERE vd.topic_id = $topic_id
			AND vr.vote_id = vd.vote_id
		ORDER BY vr.vote_option_id ASC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain vote data for this topic', '', __LINE__, __FILE__, $sql);
	}

	if ( $vote_info = $db->sql_fetchrowset($result) )
	{
		$db->sql_freeresult($result);
		$vote_options = count($vote_info);

		$vote_id = $vote_info[0]['vote_id'];
		$vote_title = $vote_info[0]['vote_text'];
		$max_vote = $vote_info[0]['vote_max'];
		$voted_vote = $vote_info[0]['vote_voted'];
		$hide_vote = $vote_info[0]['vote_hide'];
		$tothide_vote = $vote_info[0]['vote_tothide'];

		$sql = "SELECT vote_id
			FROM " . VOTE_USERS_TABLE . "
			WHERE vote_id = $vote_id
				AND vote_user_id = " . intval($userdata['user_id']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain user vote data for this topic", '', __LINE__, __FILE__, $sql);
		}

		$user_voted = ( $row = $db->sql_fetchrow($result) ) ? TRUE : 0;
		$db->sql_freeresult($result);

		if ( isset($HTTP_GET_VARS['vote']) || isset($HTTP_POST_VARS['vote']) )
		{
			$view_result = ( ( ( isset($HTTP_GET_VARS['vote']) ) ? $HTTP_GET_VARS['vote'] : $HTTP_POST_VARS['vote'] ) == 'viewresult' ) ? TRUE : 0;
		}
		else
		{
			$view_result = 0;
		}

		$poll_expired = ( $vote_info[0]['vote_length'] ) ? ( ( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] < CR_TIME ) ? TRUE : 0 ) : 0;

		if ( $user_voted || $view_result || $poll_expired || !$is_auth['auth_vote'] || $forum_topic_data['topic_status'] == TOPIC_LOCKED )
		{
			$template->set_filenames(array(
				'pollbox' => 'viewtopic_poll_result.tpl')
			);

			$vote_results_sum = 0;

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_results_sum += $vote_info[$i]['vote_result'];
			}

			$vote_graphic = 0;
			$vote_graphic_max = count($images['voting_graphic']);

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_percent = ( $vote_results_sum > 0 ) ? $vote_info[$i]['vote_result'] / $vote_results_sum : 0;
				$vote_graphic_length = round($vote_percent * $board_config['vote_graphic_length']);

				$vote_graphic_img = $images['voting_graphic'][$vote_graphic];
				$vote_graphic = ($vote_graphic < $vote_graphic_max - 1) ? $vote_graphic + 1 : 0;

				if ( !$board_config['show_badwords'] )
				{
					if ( count($orig_word) )
					{
						$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
					}
				}
				else
				{
					$vote_option_text = $vote_info[$i]['vote_option_text'];
					replace_bad_words($orig_word, $replacement_word, $vote_option_text);
				}
				$hide_vote_bl = '';
				$hide_vote_zr = '0';
				$total_votes_1 = $lang['Total_votes'] ;
				$total_votes_2 = $vote_results_sum;

				if ( ( $poll_expired == 0 ) && ( $hide_vote == 1 ) && ( $vote_info[0]['vote_length'] <> 0 ) )
				{
					if ( $tothide_vote == 1 )
					{
						$total_votes_1 = '' ;
						$total_votes_2 = '' ;
					}
					$poll_expires_c = $lang['Results_after'];

					$template->assign_block_vars('poll_option', array(
						'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
						'POLL_OPTION_RESULT' => $hide_vote_bl,
						'POLL_OPTION_PERCENT' => $hide_vote_bl,
						'POLL_OPTION_IMG' => $vote_graphic_img,
						'POLL_OPTION_IMG_WIDTH' => $hide_vote_zr)
					);
				}
				else
				{
					$poll_expires_c = '';
					$template->assign_block_vars('poll_option', array(
						'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
						'POLL_OPTION_RESULT' => $vote_info[$i]['vote_result'],
						'POLL_OPTION_PERCENT' => sprintf("%.1d%%", ($vote_percent * 100)),

						'POLL_OPTION_IMG' => $vote_graphic_img,
						'POLL_OPTION_IMG_WIDTH' => $vote_graphic_length)
					);
				}
			}

			if ( ( $poll_expired == 0 ) && ( $vote_info[0]['vote_length'] <> 0 ) )
			{
				$poll_expire_1 = (($vote_info[0]['vote_start'] + $vote_info[0]['vote_length']) - CR_TIME );
				$poll_expire_2 = intval($poll_expire_1 / 86400);
				$poll_expire_a = $poll_expire_2 * 86400;
				$poll_expire_3 = intval(($poll_expire_1 - ($poll_expire_a)) / 3600);
				$poll_expire_b = $poll_expire_3 * 3600;
				$poll_expire_4 = intval((($poll_expire_1 - ($poll_expire_a) - ($poll_expire_b))) / 60);
				$poll_comma = ', ';
				$poll_space = ' ';
				$poll_expire_2 == '0' ? $poll_expire_6 = '' : (($poll_expire_3 == 0 && $poll_expire_4 == 0) ? $poll_expire_6 = $poll_expire_2 . $poll_space . $lang['Days'] : $poll_expire_6 = $poll_expire_2 . $poll_space . $lang['Days'] . $poll_comma) ;
				$poll_expire_3 == '0' ? $poll_expire_7 = '' : ($poll_expire_4 == 0 ? $poll_expire_7 = $poll_expire_3 . $poll_space . $lang['Hours'] : $poll_expire_7 = $poll_expire_3 . $poll_space . $lang['Hours'] . $poll_comma);
				$poll_expire_4 == '0' ? $poll_expire_8 = '' : $poll_expire_8 = $poll_expire_4 . $poll_space . $lang['Minutes'] ;
				$poll_expires_d = $lang['Poll_expires'];
			}
			else
			{
				$poll_expires_6 = '';
				$poll_expires_7 = '';
				$poll_expires_8 = '';
				$poll_expires_d = '';
			}
			$voted_vote_nb = $voted_vote;

			$template->assign_vars(array(
				'VOTED_SHOW' => $lang['Voted_show'],
				'L_TOTAL_VOTES' => $total_votes_1 . ': ',
				'L_RESULTS_AFTER' => $poll_expires_c,
				'L_POLL_EXPIRES' => $poll_expires_d,
				'POLL_EXPIRES' => ($poll_expire_6 . $poll_expire_7 . $poll_expire_8),
				'TOTAL_VOTES' => $total_votes_2)
			);
		}
		else
		{
			$template->set_filenames(array(
				'pollbox' => 'viewtopic_poll_ballot.tpl')
			);

			$vote_box = ($max_vote > 1) ? 'checkbox' : 'radio';

			for($i = 0; $i < $vote_options; $i++)
			{
				if ( !$board_config['show_badwords'] )
				{
					if ( count($orig_word) )
					{
						$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
					}
				}
				else
				{
					$vote_option_text = $vote_info[$i]['vote_option_text'];
					replace_bad_words($orig_word, $replacement_word, $vote_option_text);
				}

				$template->assign_block_vars('poll_option', array(
					'POLL_VOTE_BOX' => $vote_box,
					'POLL_OPTION_ID' => $vote_info[$i]['vote_option_id'],
					'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'])
				);
			}

			$template->assign_vars(array(
				'L_SUBMIT_VOTE' => $lang['Submit_vote'],
				'L_VIEW_RESULTS' => $lang['View_results'],

				'U_VIEW_RESULTS' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;vote=viewresult"))
			);

			$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $topic_id . '"><input type="hidden" name="mode" value="vote">';
		}
		if ( $max_vote > 1 )
		{
			$vote_br = '<br />';
			$max_vote_nb = $max_vote;
		}
		else
		{
			$vote_br = '';
			$lang['Max_voting_1_explain'] = '';
			$lang['Max_voting_2_explain'] = '';
			$lang['Max_voting_3_explain'] = '';
			$max_vote_nb = '';
		}
		if ( !$board_config['show_badwords'] )
		{
			if ( count($orig_word) )
			{
				$vote_title = preg_replace($orig_word, $replacement_word, $vote_title);
			}
		}
		else
		{
			replace_bad_words($orig_word, $replacement_word, $vote_title);
		}

		$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $session_id . '" />';

		$template->assign_vars(array(
			'POLL_QUESTION' => $vote_title,
			'POLL_VOTE_BR' => $vote_br,
			'MAX_VOTING_1_EXPLAIN' => $lang['Max_voting_1_explain'],
			'MAX_VOTING_2_EXPLAIN' => $lang['Max_voting_2_explain'],
			'MAX_VOTING_3_EXPLAIN' => $lang['Max_voting_3_explain'],
			'max_vote' => $max_vote_nb,
			'voted_vote' => $voted_vote_nb,

			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_POLL_ACTION' => append_sid("posting.$phpEx?mode=vote&amp;" . POST_TOPIC_URL . "=$topic_id"))
		);

		$template->assign_var_from_handle('POLL_DISPLAY', 'pollbox');
	}
}

if ( defined('ATTACHMENTS_ON') )
{
	init_display_post_attachments($forum_topic_data['topic_attachment']);
}

//
// Update the topic view counter
//
if ( mt_rand(1, 3) == 2 || $forum_topic_data['topic_views'] < 10 )
{
	$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_views = " . (($forum_topic_data['topic_views'] < 10) ? "topic_views + 1" : "topic_views + 3") . "
		WHERE topic_id = $topic_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update topic views.', '', __LINE__, __FILE__, $sql);
	}
}
//
// Okay, let's do the loop, yeah come on baby let's do the loop
// and it goes like this ...
//
$poster_ids = $check_for_mod_here = $userdata_reply_buffered = '';

$mods_ids = moderarots_list($forum_id, 'mod');

for($i = 0; $i < $total_posts; $i++)
{
	$poster_id = $postrow[$i]['user_id'];
	$poster_username = ($poster_id == ANONYMOUS) ? (($postrow[$i]['post_username']) ? $postrow[$i]['post_username'] : $lang['Guest']) : $postrow[$i]['username'];
	$poster = $poster_username;
	$postrow_post_id = $postrow[$i]['post_id'];
	$poster_level = $postrow[$i]['user_level'];
	$poster_posts = $postrow[$i]['user_posts'];
	$post_time = ($postrow[$i]['post_start_time'] == 0) ? $postrow[$i]['post_time'] : $postrow[$i]['post_start_time'];
	$show_post = (!$postrow[$i]['post_approve'] && $forum_view_moderate ) ? false : true; 
	if ( !$postrow[$i]['post_approve'] )
	{
		$show_reject_panel = true;
	}

	if ( !$forum_topic_data['topic_tree_width'] )
	{
		$postrow[$i]['post_parent'] = '';
	}

	if ( $postrow[$i]['post_parent'] )
	{
		if ( !isset($parents_data) )
		{
			$parents_data = array();
			$sql = "SELECT post_id, post_parent
				FROM " . POSTS_TABLE . "
				WHERE topic_id = $topic_id
					AND post_parent > 0
					ORDER by post_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query post data information', '', __LINE__, __FILE__, $sql);
			}

			while( $row = $db->sql_fetchrow($result) )
			{
				$parents_data[$row['post_id']] = (($parents_data[$row['post_parent']]) ? $parents_data[$row['post_parent']] : 0) + $forum_topic_data['topic_tree_width'];
			}
		}
	}

	$row_class = $post_reply_img = '';

	$forum_moderate = ($forum_topic_data['forum_moderate']) ? true : false;
	if( $topic_first_post_id == $postrow_post_id && ( ($forum_topic_data['topic_accept'] != $postrow[$i]['post_approve'] && $forum_moderate) || (!$forum_moderate && !$forum_topic_data['topic_accept']) ) )
	{
		$update_ta = (!$forum_moderate && !$forum_topic_data['topic_accept']) ? 1 : $postrow[$i]['post_approve'];
		$sql = "UPDATE " . TOPICS_TABLE . " SET topic_accept = " . $update_ta . " WHERE topic_id = " . $topic_id;
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error in update accept topic', '', __LINE__, __FILE__, $sql);
		}
	}

	if ( $poster_level != ANONYMOUS && $poster_level != ADMIN && $poster_level == MOD )
	{
		if ( in_array($poster_id, $mods_ids) )
		{
			$poster_is_mod_here = true;
			$poster_is_mod = true;
		}
		else
		{
			$poster_is_mod_here = false;
			$poster_is_mod = true;
		}
	}
	else
	{
		$poster_is_mod_here = $poster_is_mod = false;
		$poster_is_jr_admin = ($postrow[$i]['user_jr']) ? true : false;
	}

	// Begin post expires
	if ( $board_config['expire'] )
	{
		$post_end = $post_time + $postrow[$i]['post_expire'];
		$post_expire_date = ($postrow[$i]['post_expire'] == 0) ? '' : $lang['post_expire'] . ' ' . date('m.d, H:i', $post_end);

		if ( CR_TIME > $post_end && $postrow[$i]['post_expire'] > 0 )
		{
			require_once($phpbb_root_path . 'includes/functions_remove.' . $phpEx);
			delete_post($postrow_post_id);
		}
	}
	// End post expire

	if ( $board_config['cignore'] && $userdata['cignore'] )
	{
		if ( $user_id != ANONYMOUS )
		{
			$post_ignored = (in_array($poster_id, $ignored_users)) ? 1 : 0;
		}
		else
		{
			$post_ignored = 0;
		}
	}

	$ignore_this_post = (($post_ignored > 0) && ($poster_id != ANONYMOUS) && ($post_bypass != $postrow_post_id) && ($poster_level != ADMIN) && !$poster_is_mod ) ? true : false;

	if ( $ignore_this_post || (!$show_post && ($userdata['user_id'] != $poster_id || $poster_id == ANONYMOUS)) )
	{
		$post_date = create_date($board_config['default_dateformat'], $post_time, $board_config['board_timezone']);

		$message = (!$show_post) ? '<i><b>' . $lang['Post_no_approved'] . '</b></i>' : $lang['Post_user_ignored'] . ' ' . sprintf($lang['Click_view_ignore'], '<a href="' . append_sid("viewtopic.$phpEx?p=" . $postrow_post_id . "&amp;bypass=" . $postrow_post_id . "#" . $postrow_post_id) . '">', '</a>') . ' ' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');

		$poster = '';
		$poster_username = '';
		$aim_img = '';
		$aim_status_img = '';
		$delpost_img = '';
		$delpost = '';
		$email_img = '';
		$email = '';
		$gender_image = '';
		$icq_status_img = '';
		$icq_img = '';
		$icq = '';
		$icon = '';
		$ignore = '';
		$l_edited_by = '';
		$helped_me_show = '';
		$special_rank = '';
		$level_hp = '';
		$level_hp_percent = '';
		$level_mp_percent = '';
		$level_exp_percent = '';
		$level_level = '';
		$max_warn = '';
		$msn_img = '';
		$msn = '';
		$new_post = '';
		$pm_img = '';
		$pm = '';
		$post_expire_date = '';
		$poster = '';
		$poster_color_username = '';
		$poster_age = '';
		$poster_custom_rank = '';
		$poster_rank = '';
		$poster_joined = '';
		$poster_post = '';
		$poster_from = '';
		$poster_online = '';
		$poster_avatar = '';
		$poster_member = '';
		$poster_username = '';
		$post_subject = '';
		$profile_img = '';
		$post_reply_img = '';
		$profile = '';
		$quote_q_img = '';
		$quote_img = '';
		$quote = '';
		$quote_username = '';
		$edit_img = '';
		$rank_image = '';
		$report_img = '';
		$report = '';
		$title_style = '';
		$user_sig = '';
		$user_sig_image = '';
		$username_color = '';
		$warn_percent = '';
		$www_img = '';
		$www = '';
		$yim_img = '';
		$yim = '';
		$mini_post_img = $images['spacer'];
		
        if ( !empty($userdata['unread_data'][$forum_id][$topic_id]) && in_array($postrow_post_id, $userdata['unread_data'][$forum_id][$topic_id]) )
        {
			$new_posts_to_delete[] = $postrow_post_id;
        }
	}
	else
	{

		$post_date = create_date($board_config['default_dateformat'], $post_time, $board_config['board_timezone']);

		$poster_post = ($poster_id != ANONYMOUS && $board_config['cposts']) ? $lang['Posts'] . ': ' . $poster_posts : '';
		$poster_from = ($postrow[$i]['user_from'] && $board_config['cfrom'] && $poster_id != ANONYMOUS ) ? $lang['Location'] . ': ' . $postrow[$i]['user_from'] : '';
		$poster_online = (($postrow[$i]['user_allow_viewonline'] || $userdata['user_level'] == ADMIN) && $board_config['r_a_r_time'] && $poster_id != ANONYMOUS && $postrow[$i]['user_session_time'] > (CR_TIME - 300)) ? '<img src="' . $images['icon_online'] . '" border="0" alt="" title="Online"><br />' : '';
		$poster_joined = ($poster_id != ANONYMOUS && $board_config['cjoin']) ? (($postrow[$i]['user_gender'] == 2) ? $lang['Joined_she'] : $lang['Joined']) . ': ' . create_date($lang['DATE_FORMAT'], $postrow[$i]['user_regdate'], $board_config['board_timezone']) : '';

		$poster_avatar = '';
		if ( $postrow[$i]['user_avatar_type'] && $poster_id != ANONYMOUS && $postrow[$i]['user_allowavatar'] && $userdata['user_showavatars'] )
		{
			switch( $postrow[$i]['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$poster_avatar = ($board_config['allow_avatar_upload']) ? '<img src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_REMOTE:
				if ( $board_config['allow_avatar_remote'] )
				{
					if ( ($postrow[$i]['user_avatar_height'] && $postrow[$i]['user_avatar_height'] > 0) && ($postrow[$i]['user_avatar_width'] && $postrow[$i]['user_avatar_width'] > 0) )
					{
						$poster_avatar = '<img src="' . $postrow[$i]['user_avatar'] . '" height="' . $postrow[$i]['user_avatar_height'] . '" width="' . $postrow[$i]['user_avatar_width'] . '" alt="" border="0" />';
					}
					else // No width/height in the user's profile
					{
						$poster_avatar = '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />';
					}
				}
				else $poster_avatar = '';
					break;
				case USER_AVATAR_GALLERY:
					$poster_avatar = ($board_config['allow_avatar_local']) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
					break;
			}
			$poster_avatar = $poster_avatar . '<br />';
		}

		// Define the little post icon
		if ( $session_logged_in )
		{
			if (empty($userdata['unread_data'][$forum_id][$topic_id])) {
				$userdata['unread_data'][$forum_id][$topic_id] = [];
			}
			if ( count($userdata['unread_data'][$forum_id][$topic_id]) && in_array($postrow_post_id, $userdata['unread_data'][$forum_id][$topic_id]) )
			{
				$mini_post_img = $images['icon_minipost_new'];
				$new_post = 1;
				$new_posts_to_delete[] = $postrow_post_id;
			}
			else
			{
				$mini_post_img = $images['icon_minipost'];
				$new_post = 0;
			}
		}
		else
		{
			$mini_post_img = $images['icon_minipost'];
		}

		$mini_post_url = append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $postrow_post_id) . '#' . $postrow_post_id;

		// Generate ranks, set them to empty string initially.
		$poster_rank = '';
		$rank_image = '';
		if ( $poster_id == ANONYMOUS )
		{
			$anonymous_user = true;
		}
		else if ( $postrow[$i]['user_rank'] )
		{
			$poster_rank = $ranksrow[-1][$postrow[$i]['user_rank']]['rank_title'];
			$rank_file = $images['rank_path'] . $ranksrow[-1][$postrow[$i]['user_rank']]['rank_image'];
			$sizes = @getimagesize($rank_file);
			$rank_sizes = (intval($sizes[0]) > 0 && intval($sizes[1]) > 0) ? '" width="' . $sizes[0] . '" height="' . $sizes[1] : '';
			$rank_image = ($ranksrow[-1][$postrow[$i]['user_rank']]['rank_image']) ? '<img src="' . $rank_file . $width . '" alt="" title="' . str_replace('-#', '', $poster_rank) . '" border="0" /><br />' : '';
			$poster_rank = $poster_rank . '<br />';
			if ( strstr($poster_rank,'-#') )
			{
				$poster_rank = '';
			}
		}
		else if ( isset($poster_group[$poster_id]) )
		{
			$g = $poster_group[$poster_id];
			for($j = 0; $j < $ranksrow[$g]['count']; $j++)
			{
				if ( $poster_posts >= $ranksrow[$g][$j]['rank_min'] )
				{
					$poster_rank = $ranksrow[$g][$j]['rank_title'];
					$rank_file = $images['rank_path'] . $ranksrow[$g][$j]['rank_image'];
					$sizes = @getimagesize($rank_file);
					$rank_sizes = (intval($sizes[0]) > 0 && intval($sizes[1]) > 0) ? '" width="' . $sizes[0] . '" height="' . $sizes[1] : '';
					$rank_image = ($ranksrow[$g][$j]['rank_image']) ? '<img src="' . $rank_file . $width . '" alt="" title="' . str_replace('-#', '', $poster_rank) . '" border="0" /><br />' : '';
					$poster_rank = $poster_rank . '<br />';
					if ( strstr($poster_rank,'-#') )
					{
						$poster_rank = '';
					}
					break;
				}
			}
		}
		else
		{
			for($j = 0; $j < $ranksrow[0]['count']; $j++)
			{
				if ( $poster_posts >= $ranksrow[0][$j]['rank_min'] )
				{
					$poster_rank = $ranksrow[0][$j]['rank_title'];
					$rank_file = $images['rank_path'] . $ranksrow[0][$j]['rank_image'];
					$sizes = @getimagesize($rank_file);
					$rank_sizes = (intval($sizes[0]) > 0 && intval($sizes[1]) > 0) ? '" width="' . $sizes[0] . '" height="' . $sizes[1] : '';
					$rank_image = ($ranksrow[0][$j]['rank_image']) ? '<img src="' . $rank_file . $width . '" alt="" title="' . str_replace('-#', '', $poster_rank) . '" border="0" /><br />' : '';
					$poster_rank = $poster_rank . '<br />';
					if ( strstr($poster_rank,'-#') )
					{
						$poster_rank = '';
					}
					break;
				}
			}
		}

		$show_custom_rank = false;
		$custom_rank_mod = false;

		if ( $poster_posts >= $board_config['allow_custom_rank'] )
		{
			$show_custom_rank = true;
		}
		if ( $poster_is_mod || $poster_level == ADMIN || $poster_is_jr_admin )
		{
			$custom_rank_mod = true;
		}
		if ( $board_config['custom_rank_mod'] && $custom_rank_mod )
		{
			$show_custom_rank = true;
		}
		if ( $show_custom_rank && $postrow[$i]['can_custom_ranks'] && $postrow[$i]['user_custom_rank'] != '' && $poster_id != ANONYMOUS && $userdata['custom_rank'] )
		{
			$poster_custom_rank = $postrow[$i]['user_custom_rank'];
			$poster_custom_rank = $poster_custom_rank . '<br />';
		}
		else
		{
			$poster_custom_rank = '';
		}

		$temp_url = '';

		if ( $poster_id != ANONYMOUS )
		{
			if ( $poster_id == $user_id || !$board_config['cignore'] || !$userdata['cignore'] )
			{
				$ignore = '';
			}
			else if ( $session_logged_in )
			{
				$temp_url = append_sid("ignore.$phpEx?mode=add&amp;ignore_id=$poster_id&amp;topic=$topic_id&amp;sid=" . $session_id . "");
				$ignore = ($board_config['graphic']) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_ignore'] . '" alt="" title="' . $lang['Ignore_add'] . '" border="0" /></a> ' : '<a href="' . $temp_url . '" class="gen" title="' . $lang['Ignore_add'] . '">[<b>' . $lang['Ignore_mini'] . '</b>]</a> ';
			}

			$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
			if ( $board_config['post_footer'] )
			{		
				if ( $board_config['graphic'] )
				{
					$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="" title="' . $lang['Read_profile'] . '" border="0" /></a>';
					$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';
					$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
					$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
					if ( $board_config['gender'] )
					{
						switch ($postrow[$i]['user_gender'])
						{
							case 1 :
								$gender_image = $images['icon_minigender_male'];
							break;
							case 2 :
								$gender_image = $images['icon_minigender_female'];
							break;
							default :
								$gender_image = '';
						}
					}
					else
					{
						$gender_image = '';
					}
					$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
					$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';
					if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )
					{
						$email_uri = ($board_config['board_email_form']) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $postrow[$i]['user_email'];
						$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="" title="' . $lang['Send_email'] . '" border="0" /></a>';
						$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
					}
					else
					{
						$email_img = '';
						$email = '';
					}
					$www_img = ($postrow[$i]['user_website']) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww" rel="nofollow"><img src="' . $images['icon_www'] . '" alt="" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
					$www = ($postrow[$i]['user_website']) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww" rel="nofollow">' . $lang['Visit_website'] . '</a>' : '';
					if ( $board_config['cicq'] && !empty($postrow[$i]['user_icq']) )
					{
						$icq_status_img = '<a href="http://wwp.icq.com/' . $postrow[$i]['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $postrow[$i]['user_icq'] . '&img=5" width="18" height="18" border="0" alt="" /></a>';
						$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="" title="' . $lang['ICQ'] . '" border="0" /></a>';
						$icq = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '">' . $lang['ICQ'] . '</a>';
					}
			
					else
					{
						$icq_status_img = '';
						$icq_img = '';
						$icq = '';
					}
					if ( !empty($postrow[$i]['user_aim']) && $board_config['cgg'] )
					{
						$gg_url = append_sid("gg.$phpEx?mode=gadu&amp;" . POST_USERS_URL . "=$poster_id");
						if ( $postrow[$i]['user_viewaim'] )
						{
							$aim_status_img = '<a href="gg:' .$postrow[$i]['user_aim'] . '"><img src="http://status.gadu-gadu.pl/users/status.asp?id=' . $postrow[$i]['user_aim'] . '&amp;styl=1" alt="" title="' .$postrow[$i]['user_aim'] . '" border="0" width="16" height="16" /></a>';
							$aim_img = '<a href="' . $gg_url . '"><img src="' . $images['icon_aim'] . '" alt="" title="' . $lang['AIM'] . ': ' . $postrow[$i]['user_aim'] . '" border="0" /></a>';
						}
						else
						{
							$aim_status_img = '';
							$aim_img = '<a href="' . $gg_url . '"><img src="' . $images['icon_aim'] . '" alt="" border="0" /></a>';
						}
					}
					else
					{
						$aim_status_img = '';
						$aim_img = '';
					}
					$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
					$msn_img = ($postrow[$i]['user_msnm'] && $board_config['cmsn']) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="" title="' . $lang['MSNM'] . '" border="0" /></a> ' : '';
					$msn = ($postrow[$i]['user_msnm']) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
					$yim_img = ( $postrow[$i]['user_yim'] && $board_config['cyahoo']) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="" title="' . $lang['YIM'] . '" border="0" /></a> ' : '';
					$yim = ($postrow[$i]['user_yim']) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
				}
				else
				{
					$profile_img = '<a href="' . $temp_url . '" class="gen" title="' . $lang['Read_profile'] . '">[<b>' . $lang['Profile'] . '</b>]</a>';
					$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';
					$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
					$pm_img = '<a href="' . $temp_url . '" class="gen" title="' . $lang['Send_private_message'] . '">[<b>' . $lang['pm_mini'] . '</b>]</a>';
					$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

					if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )
					{
						$email_uri = ($board_config['board_email_form']) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $postrow[$i]['user_email'];
						$email_img = '<a href="' . $email_uri . '" class="gen" title="' . $lang['Send_email'] . '">[<b>' . $lang['Email'] . '</b>]</a>';
						$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
					}
					else
					{
						$email_img = '';
						$email = '';
					}
					$www_img = ($postrow[$i]['user_website']) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww" rel="nofollow" class="gen" title="' . $lang['Visit_website'] . '">[<b>WWW</b>]</a>' : '';
					$www = ($postrow[$i]['user_website']) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww" rel="nofollow">' . $lang['Visit_website'] . '</a>' : '';

					if ( $board_config['cicq'] && !empty($postrow[$i]['user_icq']) )
					{
						$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '" class="gen" title="' . $lang['ICQ'] . '">[<b>' . $lang['cicq'] . '</b>]</a>';
						$icq ='<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '" class="gen" title="' . $lang['ICQ'] . '">[<b>' . $lang['cicq'] . '</b>]</a>';
					}
					else
					{
						$icq_status_img = '';
						$icq_img = '';
						$icq = '';
					}
					if ( !empty($postrow[$i]['user_aim']) && $board_config['cgg'] )
					{
						$gg_url = append_sid("gg.$phpEx?mode=gadu&amp;" . POST_USERS_URL . "=$poster_id");
						if ( $postrow[$i]['user_viewaim'] )
						{
							$aim_img = '<a href="' . $gg_url . '" class="gen" title="' . $lang['AIM'] . ': ' . $postrow[$i]['user_aim'] . '">[<b>' . $lang['aim_mini'] . '</b>]</a>';
						}
						else
						{
							$aim_img = '<a href="' . $gg_url . '" class="gen">[<b>' . $lang['aim_mini'] . '</b>]</a>';
						}
					}
					else
					{
						$aim_status_img = '';
						$aim_img = '';
					}
					$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
					$msn_img = ($postrow[$i]['user_msnm'] && $board_config['cmsn']) ? '<a href="' . $temp_url . '" class="gen" " title="' . $lang['MSNM'] . '">[<b>MSNM</b>]</a> ' : '';
					$msn = ($postrow[$i]['user_msnm']) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
					$yim_img = ($postrow[$i]['user_yim'] && $board_config['cyahoo']) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg" class="gen" title="' . $lang['YIM'] . '>[<b>YIM</a></b>] ' : '';
					$yim = ($postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
				}
			}
			else
			{
				$profile_img = '';
				$profile = '';
				$pm_img = '';
				$pm = '';
				$email_img = '';
				$email = '';
				$www_img = '';
				$www = '';
				$icq_status_img = '';
				$icq_img = '';
				$icq = '';
				$aim_img = '';
				$msn_img = '';
				$msn = '';
				$yim_img = '';
				$yim = '';
			}

			$colored_username = color_username($postrow[$i]['user_level'], $postrow[$i]['user_jr'], $postrow[$i]['user_id'], $postrow[$i]['username'], false, 'font-size: 12');
			$poster_color_username = $colored_username[0];
			$username_color = $colored_username[1];

			if ( $postrow[$i]['user_custom_color'] && $postrow[$i]['can_custom_color'] && $userdata['custom_color_use'] )
			{
				if (( (($board_config['custom_color_use'] || $board_config['custom_color_view']) && $poster_posts >= $board_config['allow_custom_color'] ))
					|| ( ($poster_is_mod || $poster_level == ADMIN || $poster_is_jr_admin) && $board_config['custom_color_mod'] ))
				{
					$username_color = 'style="color:#' . $postrow[$i]['user_custom_color'] . '; font-size: 12"';
				}
			}
			$username_color = ($username_color) ? $username_color : 'style="font-size: 12"';
			$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
			$poster = ($show_quickreply) ? '<a href="javascript:em(\'[b]' . str_replace("'", "\'", $poster_username) . '[/b], \')" class="gensmall" ' . $username_color . '>' . $poster_color_username . '</a>' : '<a href="' . $temp_url . '" title="' . $lang['Read_profile'] . '" class="gensmall"' . $username_color . '>' . $poster_color_username . '</a>';
		}
		else
		{
			if ( $postrow[$i]['post_username'] != '' )
			{
				if ( $postrow[$i]['poster_delete'] )
				{
					$poster = $postrow[$i]['post_username'] . '</b><br /><font size="1">[<i>' . $lang['User_deleted'] . '</i>]</font><b>';
				}
				else
				{
					$poster = $postrow[$i]['post_username'];
					$poster_rank = $lang['Guest'];
				}
			}
			$profile_img = '';
			$profile = '';
			$ignore = '';
			$pm_img = '';
			$pm = '';
			$email_img = '';
			$email = '';
			$www_img = '';
			$www = '';
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
			$aim_img = '';
			$aim_status_img = '';
			$msn_img = '';
			$msn = '';
			$yim_img = '';
			$yim = '';
			$gender_image = '';
		}

		if ( ( $user_id == $poster_id && $is_auth['auth_edit'] && !$forum_topic_locked ) || $is_auth['auth_mod'] )
		{
			$temp_url = append_sid("posting.$phpEx?mode=editpost&amp;" . POST_POST_URL . "=" . $postrow_post_id);
			if ( $board_config['graphic'] )
			{
				$edit_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_edit'] . '" alt="" title="' . $lang['Edit_delete_post'] . '" border="0" /></a>';
			}
			else
			{
				$edit_img = '<a href="' . $temp_url . '" class="gen" title="' . $lang['Edit_delete_post'] . '">[<b>' . $lang['edit_mini'] . '</b>]</a>';
			}
			$edit = '<a href="' . $temp_url . '">' . $lang['Edit_delete_post'] . '</a>';
		}
		else
		{
			$edit_img = '';
			$edit = '';
		}

		if ( $is_auth['auth_mod'] )
		{
			$temp_url = "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $postrow_post_id . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $session_id;
			if ( $user_level == ADMIN | ($board_config['ipview']) )
			{
				if ( $board_config['graphic'] )
				{
					$ip_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_ip'] . '" alt="" title="' . $lang['View_IP'] . '" border="0" /></a>';
				}
				else
				{
					$ip_img = '<a href="' . $temp_url . '" class="gen" title="' . $lang['View_IP'] . '">[<b>IP</b>]</a>';
				}
			} 
			else
			{
				$ip_img = '';
			}
			$ip = '<a href="' . $temp_url . '">' . $lang['View_IP'] . '</a>';

			$back_url = ($postrow_post_id != $forum_topic_data['topic_first_post_id'] && $postrow[$i-1]['post_id']) ? '&amp;back='. $postrow[$i-1]['post_id'] : '';
			$back_url .= '&amp;sid='.$userdata['session_id'];
			$temp_url = append_sid("posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow_post_id.$back_url);
			if ( $board_config['graphic'] )
			{
				$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="" title="' . $lang['Delete_post'] . '" border="0" /></a>';
			}
			else
			{
				$delpost_img = '<a href="' . $temp_url . '" class="gen" title="' . $lang['Delete_post'] . '">[<b>X</b>]</a>';
			}
			$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
		}
		else
		{
			$ip_img = '';
			$ip = '';

			if ( $user_id == $poster_id && $is_auth['auth_delete'] && $forum_topic_data['topic_last_post_id'] == $postrow_post_id )
			{
			$back_url = ($postrow_post_id != $forum_topic_data['topic_first_post_id'] && $postrow[$i-1]['post_id']) ? '&amp;back='. $postrow[$i-1]['post_id'] : '';
			$back_url .= '&amp;sid='.$userdata['session_id'];
			$temp_url = append_sid("posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow_post_id.$back_url);
				if ( $board_config['graphic'] )
				{
					$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="" title="' . $lang['Delete_post'] . '" border="0" /></a>';
				}
				else
				{
					$delpost_img = '<a href="' . $temp_url . '" class="gen" title="' . $lang['Delete_post'] . '>[<b>X</b>]</a>';
				}
				$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
			}
			else
			{
				$delpost_img = '';
				$delpost = '';
			}
		}

		if ( $forum_topic_locked && !$is_auth['auth_mod'] )
		{
				$delpost_img = $delpost = '';
		}

		if ( !$board_config['report_disable'] )
		{
			if ( !isset($rp) )
			{
				require_once($phpbb_root_path . 'includes/reportpost.'.$phpEx);
			}
			if ( empty($postrow[$i]['reporter_id']) && ( !$session_logged_in || $poster_id != $user_id ) && !$rp->report_disabled2($poster_id) && $rp->report_auth($user_id) )
			{
				$temp_url = append_sid("report.$phpEx?mode=report&amp;" . POST_POST_URL . "=" . $postrow_post_id);
				$report_img = ($board_config['graphic']) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_report'] . '" alt="" title="' . $lang['Report_post'] . '" border="0" /></a>' : '<a href="' . $temp_url . '" title="' . $lang['Report_post'] . '" class="gen">[ <b>!!!</b> ]</a>';
				$report = '<a href="' . $temp_url . '">' . $lang['Report_post'] . '</a>';
			}
			else if ( !empty($postrow[$i]['reporter_id']) && ( ( $session_logged_in && $postrow[$i]['reporter_id'] == $user_id ) || ( $is_auth['auth_mod'] && $rp->check_access() ) ) )
			{
				$temp_url = append_sid("report.$phpEx?mode=del_report&amp;" . POST_POST_URL . "=" . $postrow_post_id);
				$report_img = ($board_config['graphic']) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_del_report'] . '" alt="" title="' . $lang['Report_del'] . '" border="0" /></a>' : '<a href="' . $temp_url . '" title="' . $lang['Report_del'] . '" class="gen">[ <b>!X!</b> ]</a>';
				$report = '<a href="' . $temp_url . '">' . $lang['Report_del'] . '</a>';
			}
			else
			{
				$report_img = '';
				$report = '';
			}
		}
		else
		{
			$report_img = '';
			$report = '';
		}

		$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : '';

		$message = $postrow[$i]['post_text'];

		$bbcode_uid = $postrow[$i]['bbcode_uid'];

		$user_sig = '';
		$user_sig_image = '';
		$user_sig_bbcode_uid = '';
		if ( $poster_id != ANONYMOUS && $postrow[$i]['user_allowsig'] )
		{
			$user_sig = ($postrow[$i]['enable_sig'] && $postrow[$i]['user_sig'] != '' && $board_config['allow_sig']) ? $postrow[$i]['user_sig'] : '';
			$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];
			$user_sig_image = ( $postrow[$i]['enable_sig'] && $postrow[$i]['user_sig_image'] != '' && $board_config['allow_sig'] && $board_config['allow_sig_image'] ) ? $postrow[$i]['user_sig_image'] : '';
			$user_sig = ($userdata['user_allow_signature']) ? $user_sig : '';
			$user_sig_image = ($userdata['user_allow_sig_image']) ? $user_sig_image : '';
		}

		$show_post_html = ($board_config['allow_html'] && $postrow[$i]['user_allowhtml']) ? true : false;
		if ( (($poster_is_mod_here && $board_config['mod_html']) || ($board_config['admin_html'] && $poster_level == ADMIN) || ($board_config['jr_admin_html'] && $poster_is_jr_admin)) && $postrow[$i]['user_allowhtml'] )
		{
			$show_post_html = true;
		}

		if ( !$show_post_html )
		{
			if ( $user_sig != '' )
			{
				$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
			}

			if ( $postrow[$i]['enable_html'] )
			{
				$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
			}
		}

		if ( $user_sig_image != '' )
		{
			$user_sig_image = (($user_sig != '') ? '<br />' : '<br />') . '<img src="' . $board_config['sig_images_path'] . '/' . $user_sig_image . '" border="0" alt="" />';
		}

		$strip_br = ($show_post_html && (strpos($message, '<td>') !== false || strpos($message, '<tr>') !== false || strpos($message, '<table>') !== false)) ? true : false;

		if ( $user_level == ADMIN || $userdata['user_jr'] || $is_auth['auth_mod'] )
		{
			$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "<br><u><b>Mod Info:</u><br>[</b>\\1<b>]</b><br>", $message);
		}
		elseif ( strpos($message, "[mod]") !== false )
		{
			$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "", $message);
		}

		if ( $user_sig != '' && $user_sig_bbcode_uid != '' )
		{
			$user_sig = ($board_config['allow_bbcode']) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid, $userdata['username']) : preg_replace("/\:$user_sig_bbcode_uid/si", '', $user_sig);
		}

		if ( $bbcode_uid != '' )
		{
			$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid, $userdata['username']) : preg_replace("/\:$bbcode_uid/si", '', $message);

			if ( strpos($message, "[hide:$bbcode_uid]") !== false )
			{
				if ( !$userdata_reply_buffered )
				{
					$valid = ( $session_logged_in && ($user_level == ADMIN || $userdata['user_jr'] || $is_auth['auth_mod'] || in_array($user_id, $posters_id)) ) ? true : false;
                    if ( $session_logged_in && !$valid )
					{
						$sql = "SELECT poster_id, topic_id
							FROM " . POSTS_TABLE . "
							WHERE topic_id = $topic_id
								AND poster_id = $user_id";

						$resultat = $db->sql_query($sql);
						$valid = $db->sql_numrows($resultat) ? true : false;
					}
					$userdata_reply_buffered = true;
				}
				$message = bbencode_third_pass($message, $bbcode_uid, $valid);
			}
		}

		// Parse smilies
		if ( $board_config['allow_smilies'] && $userdata['show_smiles'] )
		{
			if ( $postrow[$i]['user_allowsmile'] && $user_sig != '' )
			{
				$user_sig = smilies_pass($user_sig);
			}

			if ( $postrow[$i]['enable_smilies'] )
			{
				$message = smilies_pass($message);
			}
		}

		if ( $user_sig != '' )
		{
			$user_sig = make_clickable($user_sig);
		}
		$message = make_clickable($message);

		// Highlight active words (primarily for search)
		if ( $highlight_match )
		{
			// This was shamelessly 'borrowed' from volker at multiartstudio dot de
			// via php.net's annotated manual
			$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace('#\b(" . str_replace('\\', '\\\\', addslashes($highlight_match)) . ")\b#i', '<span style=\"color:#" . $theme['fontcolor3'] . "\"><b>\\\\1</b></span>', '\\0')", '>' . $message . '<'), 1, -1));
		}

		// Replace naughty words
		if ( !$board_config['show_badwords'] )
		{
			if ( count($orig_word) )
			{
				$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);

				if ( $user_sig != '' )
				{
					$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word_html, '\\0')", '>' . $user_sig . '<'), 1, -1));
				}

				$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word_html, '\\0')", '>' . $message . '<'), 1, -1));
			}
		}
		else
		{
			if ( $user_sig != '' )
			{
				replace_bad_words($orig_word, $replacement_word_html, $user_sig);
			}

			replace_bad_words($orig_word, $replacement_word, $post_subject);
			replace_bad_words($orig_word, $replacement_word_html, $message);
		}

		if ( !$strip_br )
		{
			$message = str_replace("\n", "\n<br />\n", $message);
		}
		if ( $user_sig != '' )
		{
			$user_sig = str_replace("\n", "\n<br />\n", $user_sig);
		}

		// Editing information
		$hide_edited_admin = ($poster_level == ADMIN && $board_config['hide_edited_admin'] && !$postrow[$i]['post_edit_by']) ? true : false;

		$show_edited_by = (!$board_config['show_action_edited_by_others'] && $postrow[$i]['post_edit_by']) ? false : true;
		if ( $postrow[$i]['post_edit_count'] && $postrow[$i]['post_edit_time'] && !$hide_edited_admin && $show_edited_by )
		{
			$l_edit_time_total = ($postrow[$i]['post_edit_count'] == 1) ? $lang['Edited_time_total'] : $lang['Edited_times_total'];

			if ( $postrow[$i]['post_edit_by'] )
			{
				$by_userdata_edit = get_userdata($postrow[$i]['post_edit_by'], false, 'username');
				$edited_by_user = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $postrow[$i]['post_edit_by']) . '">' . $by_userdata_edit['username'] . '</a>';

				$l_edited_by = sprintf($l_edit_time_total, $edited_by_user, create_date($board_config['default_dateformat'], $postrow[$i]['post_edit_time'], $board_config['board_timezone']), $postrow[$i]['post_edit_count']);
			}
			else if ( $board_config['show_action_edited_self'] )
			{
				$l_edited_by = sprintf($l_edit_time_total, $poster_username, create_date($board_config['default_dateformat'], $postrow[$i]['post_edit_time'], $board_config['board_timezone']), $postrow[$i]['post_edit_count']);
			}
			if ( (($is_auth['auth_mod'] && $board_config['allow_mod_delete_actions']) || $user_level == ADMIN) && $board_config['show_action_edited_self'] )
			{
				$l_edited_by .= ' <a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;post_edit_by=delete", true) . "#" . $postrow[$i]['post_id'] . '" title="' . $lang['TA_Delete'] . '">X</a>';
			}
			$show_edited_block = true;
		}
		else
		{
			$l_edited_by = $show_edited_block = '';
		}

		if ( $board_config['post_icon'] == 1 && $userdata['post_icon'] )
		{
			if ( $postrow[$i]['post_icon'] == 0 )
			{
				$icon = '';
			} 
			else
			{
				$icon = '<img src="' . $images['rank_path'] . 'icon/icon' . $postrow[$i]['post_icon'] . '.gif" alt="" border="0">&nbsp;';
			}
		}

		// Helped
		$helped_me_show = $special_rank = $icon_help = '';
		if ( $board_config['helped'] && !$forum_topic_data['forum_no_helped'] )
		{
			$rank = ($postrow[$i]['special_rank']) ? intval($postrow[$i]['special_rank']) : 0;

			$helped_how_much = ($rank < 2) ? $lang['help_1'] : $lang['help_more'];

			$special_rank = ($rank > 0 && $poster_id != ANONYMOUS && $postrow[$i]['user_allow_helped']) ? (($postrow[$i]['user_gender'] == 2) ? $lang['postrow_help_she'] : $lang['postrow_help']) . $rank . $helped_how_much . '<br />' : '';

			if ( $postrow[$i]['post_marked'] == 'y' )
			{
				$row_class = 'row_helped';
			}
			elseif ( $userdata['session_logged_in'] && $poster_id != ANONYMOUS && $poster_id != $userdata['user_id'] && $userdata['user_allow_helped'] && $userdata['user_id'] == $forum_topic_data['topic_poster'] )
			{
				$icon_help = ($postrow[$i]['user_gender'] == 2) ? $images['icon_help-a'] : $images['icon_help'];
				$helped_me_show = '<a href="' . append_sid("viewtopic.php?t=$topic_id&amp;p_add=$postrow_post_id") . '"><img src="' . $icon_help . '" border="0" title="' . $lang['He_helped'] . '" alt=""></a> ';
			}

			if ( $postrow[$i]['post_marked'] == 'y' && $is_auth['auth_mod'] )
			{
				$icon_help = ($postrow[$i]['user_gender'] == 2) ? $images['icon_help-a'] : $images['icon_help'];
				$helped_me_show = '<a href="' . append_sid("viewtopic.php?t=$topic_id&amp;p_del=$postrow_post_id") . '"><img src="' . $icon_help . '" border="0" title="' . $lang['He_helped_delete'] . '" alt=""></a> ';
			}
		}
		// Helped end
	}
	// Again this will be handled by the templating
	// code at some point

	if ( $board_config['allow_bbcode'] && $show_post && (!$forum_topic_locked || $is_auth['auth_mod']) )
	{
		$temp_url = append_sid("posting.$phpEx?mode=quote&amp;" . POST_POST_URL . "=" . $postrow_post_id);
		if ( $board_config['graphic'] )
		{
			$title_style = ($show_quickreply) ? 'title="' . $lang['QuoteSelelected'] . '"' : '';
			$quote_q_img = ($show_quickreply && !$forum_topic_data['topic_tree_width']) ? '<a href="javascript:void(null)" onclick="qc();" onmouseover="qo();"><img src="' . $images['icon_q_quote'] . '" ' . $title_style . ' border="0" alt="" /></a>&nbsp;' : $quote_q_img = '';
			$quote_img = ($user_id != $poster_id || $user_id == ANONYMOUS) ? $quote_q_img . '<a href="' . $temp_url . '"><img src="' . $images['icon_quote'] . '" alt="" title="' . $lang['Reply_with_quote'] . '" border="0" /></a>' : '';
			$quote_username = 'onmouseup="if(qu()) quoteAuthor = &quot;' . $poster_username . '&quot;"';
		}
		else
		{
			$quote_username = '';
			$quote_img = ($user_id != $poster_id || $user_id == ANONYMOUS) ? '<a href="' . $temp_url . '" class="gen" title="' . $lang['Reply_with_quote'] . '">[<b>' . $lang['quote_mini'] . '</b>]</a>' : '';
		}
		$quote = '<a href="' . $temp_url . '">' . $lang['Reply_with_quote'] . '</a>';
	}

	if ( ($forum_topic_data['topic_tree_width'] && ($user_id != $poster_id || $user_id == ANONYMOUS)) && !$forum_topic_locked )
	{
		$temp_url = append_sid("posting.$phpEx?mode=reply&amp;" . POST_TOPIC_URL . "=$topic_id&amp;" . POST_POST_URL . "=" . $postrow_post_id);

		$post_reply_img = '<a href="' . $temp_url . '" title="' . $lang['Post_reply_pm'] . '"><img src="' . $images['post_reply_new'] . '" border="0" /></a>';
	}

	$user_agent = ($board_config['cagent'] && $postrow[$i]['user_agent'] && !$ignore_this_post && $show_post && $userdata['cagent']) ? unserialize($postrow[$i]['user_agent']) : '';

	$template->assign_block_vars('postrow', array(
		'ICON' => $icon,
		'POST_EXPIRE' => $post_expire_date,
		'ROW_COLOR' => '#' . (!($i % 2)) ? $theme['td_color1'] : $theme['td_color2'],
		'ROW_CLASS' => (!$row_class) ? (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'] : $row_class,
		'POSTER_NAME' => (!$show_post && $userdata['user_id'] != $poster_id) ? '' : $poster,
		'POSTER_AGE' => ($poster_age) ? $poster_age . '<br />' : '',
		'POSTER_RANK' => $poster_rank,
		'CUSTOM_RANK' => $poster_custom_rank,
		'RANK_IMAGE' => $rank_image,
		'POSTER_JOINED' => ($poster_joined) ? $poster_joined . '<br />' : '',
		'POSTER_POSTS' => ($poster_post) ? $poster_post . '<br />' : '',
		'POSTER_FROM' => ($poster_from) ? $poster_from . '<br />' : '',
		'POSTER_ONLINE' => $poster_online,
		'POSTER_AVATAR' => $poster_avatar,
		'POST_DATE' => $post_date,
		'POST_SUBJECT' => $post_subject,
		'HELPED_ME' => $helped_me_show,
		'SPECIAL_RANK' => $special_rank,
		'VIEW_USER_AGENT' => (is_array($user_agent)) ? '&nbsp;&nbsp;<img src="' . $images['images'] . '/user_agent/' . $user_agent[0] . '" alt="" />&nbsp;<img src="' . $images['images'] . '/user_agent/' . $user_agent[1] . '" alt="" title="' . $user_agent[2] . '" />' : '',
		'MESSAGE' => (!$show_post && (($userdata['user_id'] == $poster_id && $poster_id != ANONYMOUS) || (!$postrow[$i]['post_approve'] && $is_auth['auth_mod']))) ? '<i><b>' . $lang['Post_no_approved'] . '</b></i><br /><br />' . $message : $message,
		'SIGNATURE' => $user_sig, 
		'SIG_IMAGE' => $user_sig_image,
		'EDITED_MESSAGE' => $l_edited_by, 
		'MINI_POST_IMG' => $mini_post_img,
		'PROFILE_IMG' => $profile_img, 
		'PROFILE' => $profile, 
		'IGNORE' => $ignore,
		'PM_IMG' => $pm_img,
		'PM' => $pm,
		'EMAIL_IMG' => $email_img,
		'EMAIL' => $email,
		'WWW_IMG' => $www_img,
		'WWW' => $www,
		'ICQ_STATUS_IMG' => ($board_config['cicq']) ? $icq_status_img : '',
		'ICQ_IMG' => ($board_config['cicq']) ? $icq_img : '',
		'ICQ' => ($board_config['cicq']) ? $icq : '',
		'AIM_IMG' => ($board_config['cgg']) ? $aim_img : '',
		'AIM_STATUS_IMG' => ($board_config['cgg']) ? $aim_status_img : '',
		'MSN_IMG' => $msn_img,
		'MSN' => $msn,
		'YIM_IMG' => $yim_img,
		'YIM' => $yim,
		'EDIT_IMG' => $edit_img,
		'EDIT' => $edit,
		'QUOTE_IMG' => $quote_img,
		'QUOTE' => $quote,
		'QUOTE_USERNAME' => $quote_username,
		'POST_REPLY_IMG' => $post_reply_img,
		'IP_IMG' => $ip_img,
		'IP' => $ip,
		'DELETE_IMG' => $delpost_img,
		'DELETE' => $delpost,
		'REPORT_IMG' => $report_img,
		'REPORT' => $report,
		'NEW_POST' => ($new_post) ? $lang['unread_post'] : '',
		'U_MINI_POST' => $mini_post_url,
		'U_POST_ID' => $postrow_post_id)
	);

	if ( $postrow[$i]['post_parent'] )
	{
		if ( $parents_data[$postrow[$i]['post_id']] == $forum_topic_data['topic_tree_width'] )
		{
			$tree_id = $postrow[$i]['post_id'];
		}

		if ( $parents_data[$postrow[$i]['post_id']] > ($forum_topic_data['topic_tree_width'] * $forum_topic_data['forum_tree_grade']) )
		{
			$val = ($forum_topic_data['topic_tree_width'] > 15) ? 2 : 10;
			$cross_grade = $parents_data[$postrow[$i]['post_id']] / $forum_topic_data['topic_tree_width'];

			$shift_decrease = (($cross_grade - $forum_topic_data['forum_tree_grade']) * ($forum_topic_data['topic_tree_width'] / 2)) + (($cross_grade - $forum_topic_data['forum_tree_grade']) * ($cross_grade / $val));

			$parents_data[$postrow[$i]['post_id']] = floor($parents_data[$postrow[$i]['post_id']] - $shift_decrease);
		}

		$template->assign_block_vars('postrow.post_tree', array(
			'TREE_ID' => $tree_id,
			'TREE_WIDTH' => $parents_data[$postrow[$i]['post_id']])
		);
	}

	if ( $forum_topic_data['forum_moderate'] && !$postrow[$i]['post_approve'] && $is_auth['auth_mod'] )
	{
		$template->assign_block_vars('postrow.post_moderate', array());
	}

	if ( $gender_image && $show_post )
	{
		$template->assign_block_vars('postrow.gender', array(
			'GENDER' => $gender_image)
		);
	}

	if ( $is_auth['auth_mod'] && $poster_id != $userdata['user_id'] )
	{
		$template->assign_block_vars('postrow.icon_comment', array(
			'U_COMMENT_POST' => append_sid("posting.$phpEx?mode=editpost&amp;" . POST_POST_URL . "=$postrow_post_id&amp;comment=1"))
		);
	}

	if ( $fields_to_get && $show_post )
	{
		for($j = 0; $j < count($custom_fields[0]); $j++)
		{
			if ( $custom_fields[11][$j] )
			{
				$show_this_field = custom_fields('viewable', $custom_fields[11][$j], $poster_id);
			}
			if ( $show_this_field || !$custom_fields[11][$j] )
			{
				$user_field = $postrow[$i]['user_field_' . $custom_fields[0][$j]];
				$user_allow_field = $postrow[$i]['user_allow_field_' . $custom_fields[0][$j]];
				$desc = (isset($lang[$custom_fields[1][$j]])) ? $lang[$custom_fields[1][$j]] : $custom_fields[1][$j];

				$desc_post = (isset($lang[$custom_fields[1][$j]])) ? $lang[$custom_fields[1][$j]] : $custom_fields[1][$j];
				$max_value = $custom_fields[2][$j];
				$min_value = $custom_fields[3][$j];
				$numerics = $custom_fields[4][$j];
				$jumpbox = $custom_fields[5][$j];
				$makelinks = $custom_fields[6][$j];
				$view_post = $custom_fields[7][$j];
				$prefix = replace_vars($custom_fields[8][$j], $user_field);
				$suffix = replace_vars($custom_fields[9][$j], $user_field);
				$desc2 = '';

				if ( $user_field && $user_allow_field)
				{
					$auth_field = false;
					if ( strlen($user_field) > $max_value )
					{
						$user_field = substr($user_field, 0, intval($max_value));
					}
					if ( strlen($user_field) < $min_value )
					{
						$user_field = '';
					}

					if ( $numerics )
					{
						if ( !is_numeric($user_field) )
						{
							$user_field = '';
						}
					}
					else if ( $makelinks )
					{
						$user_field = make_clickable($user_field);
					}
					if ( $jumpbox && $user_field )
					{
						$options = explode(',', $jumpbox);
						for($k = 0; $k+1 <= count($options); $k++)
						{
							$auth_field = ($options[$k] == $user_field) ? true : $auth_field;
						}
						if ( strpos($options[count($options) -1 ], '.gif') || strpos($options[count($options) -1 ], '.jpg') )
						{
							$field_name = str_replace(array('_', '.gif', '.jpg'), array(' ', '', ''), $user_field);
							$user_field = '<img src="' . $images['images'] . '/custom_fields/' . $user_field . '" border="0" alt="' . $field_name . '" title="' . $field_name . '" align="top" /><br />';
							$desc2 = $desc . ':<br />';
						}
					}
					if ( $prefix || $suffix )
					{
						if ( (strpos($prefix, '<a href="') !== false) && (strpos($suffix, '</a>') !== false) )
						{
							$user_field = $prefix . $user_field . '" title="' . str_replace('-#', '', $desc) . '">' . ((strpos($desc, '-#') !== false) ? '' : $user_field) . $suffix;
						}
						else
						{
							$user_field = $prefix . $user_field . $suffix;
						}
					}
					if ( ($auth_field || !$jumpbox) && $user_field )
					{
						$desc = (strpos($desc, '<br>') !== false) ? str_replace('<br>', '', $desc) . ':<br />' : $desc . ': ';
						$desc = ($desc2) ? $desc2 : $desc;
				
						if ( $view_post == '2' )
						{
							$template->assign_block_vars('postrow.custom_fields_avatar', array(
								'DESC' => (strpos($desc, '-#') !== false) ? '' : $desc,
								'FIELD' => $user_field)
							);
						}
						else if ( $view_post == '1' )
						{
							$template->assign_block_vars('postrow.custom_fields_post', array(
								'DESC' => (strpos($desc_post, '-#') !== false) ? '' : '<b>' . $desc_post . ':</b> ',
								'FIELD' => $user_field)
							);
						}
						else
						{
							$template->assign_block_vars('postrow.custom_fields_upost', array(
								'DESC' => (strpos($desc, '-#') !== false) ? '' : '<b>' . $desc_post . ':</b> ',
								'FIELD' => $user_field)
							);
						}
					}
				}
			}
		}
	}

	if ( $postrow[$i]['th_post_id'] || $show_edited_block )
	{
		$template->assign_block_vars('postrow.post_edited', array(
			'VIEW_POST_HISTORY' => ( $postrow[$i]['th_post_id'] && ($userdata['user_level'] == ADMIN || ($is_auth['auth_mod'] && $board_config['ph_mod'])) ) ? '<a href="' . append_sid("post_history.$phpEx?" . POST_POST_URL . "=" . $postrow[$i]['th_post_id']) . '" style="text-decoration: none;">' . $lang['Post_history'] . '</a>' : ''
		));
	}
	if ( $user_sig || $user_sig_image && $show_post )
	{
		$template->assign_block_vars('postrow.signature', array());
	}

	if ( $board_config['post_footer'] && !$postrow[$i]['post_parent'] )
	{
		$template->assign_block_vars('postrow.footer', array());
	}

	if ( $board_config['post_footer'] && $show_post && !$postrow[$i]['post_parent'] )
	{
		$template->assign_block_vars('postrow.top', array(
			'TOP_IMG' => ($i == 0) ? '<a href="#' . $postrow[($total_posts-1)]['post_id']	 . '"><img src="' . $images['topic_mod_merge'] . '" alt="" border="0" /></a>' : '<a href="#top"><img src="' . $images['topic_mod_move'] . '" alt="" border="0" /></a>')
		);
	}

	if ( defined('ATTACHMENTS_ON') && $show_post )
	{
		display_post_attachments($postrow_post_id, $postrow[$i]['post_attachment']);
	}

	if ( $board_config['viewtopic_warnings'] && $board_config['warnings_enable'] && $show_post )
	{
		$val = $warnings[$poster_id];

		if ( $val > 0 )
		{
			$max_warn = $board_config['ban_warnings'];
			$warn_percent = ($val > $max_warn) ? 100 : $val / $max_warn * 100;

			$template->assign_block_vars('postrow.warnings', array(
				'WARNINGS' => $lang['Warnings_viewtopic'],
				'HOW' => '<a href="' . append_sid("warnings.$phpEx?mode=detail&amp;userid=" . $poster_id . "") . '" class="mainmenu"><b>' . $val . '</b></a>',
				'WRITE' => $board_config['write_warnings'],
				'MAX' => $max_warn,
				'POSTER_W_WIDTH' => $warn_percent,
				'POSTER_W_EMPTY' => (100 - $warn_percent))
			);
		}
	}

	// Level Mod
	if ( ($board_config['clevell'] || $board_config['cleveld'] && $poster_id != ANONYMOUS && $board_config['graphic']) && $userdata['level'] && $show_post )
	{
		if ( $poster_posts < 1 )
		{
			$level_level = 0;
		}
		else
		{
			$level_level = floor(pow(log10( $poster_posts), 3)) + 1;
		}
		$level_avg_ppd = 5;
		$level_bonus_redux = 5;
		$level_user_ppd = ($poster_posts/max(1, round((CR_TIME - $postrow[$i]['user_regdate'])/86400 )));
		if ( $level_level < 1 )
		{
			$level_hp = '0/0';
			$level_hp_percent = 0;
		}
		else
		{
			$level_max_hp = floor((pow( $level_level, (1/4) ) ) * (pow( 10, pow( $level_level+2, (1/3) ) ) )/(1.5) );

			if ( $level_user_ppd >= $level_avg_ppd )
			{
				$level_hp_percent = floor((.5 + (($level_user_ppd - $level_avg_ppd)/($level_bonus_redux * 2))) * 100);
			}
			else
			{
				$level_hp_percent = floor($level_user_ppd/($level_avg_ppd/50));
			}
	
			if ( $level_hp_percent > 100 )
			{
				//Give the user a bonus to max HP for greater than 100% hp.
				$level_max_hp += floor(($level_hp_percent - 100) * pi());
				$level_hp_percent = 100;
			}
			else
			{
				$level_hp_percent = max(0, $level_hp_percent);
			}
	
			$level_cur_hp = floor($level_max_hp * ($level_hp_percent/100) );
	
			//Be sure a user has no more than max, and no less than zero hp.
			$level_cur_hp = max(0, $level_cur_hp);
			$level_cur_hp = min($level_max_hp, $level_cur_hp);
	
			$level_hp = $level_cur_hp . '/' . $level_max_hp;
		}
		$level_user_days = max(1, round(( CR_TIME - $postrow[$i]['user_regdate'] ) / 86400));
		$level_post_mp_cost = 2.5;
		$level_mp_regen_per_day = 4;
		if ( $level_level < 1 )
		{
			$level_mp = '0/0';
			$level_mp_percent = 0;
		}
		else
		{
			$level_max_mp = floor((pow( $level_level, (1/4) ) ) * (pow( 10, pow($level_level+2, (1/3)))) / (pi()) );
			$level_mp_cost = $poster_posts * $level_post_mp_cost;
			$level_mp_regen = max(1, $level_user_days * $level_mp_regen_per_day);
			$level_cur_mp = floor($level_max_mp - $level_mp_cost + $level_mp_regen);
			$level_cur_mp = max(0, $level_cur_mp);
			$level_cur_mp = min($level_max_mp, $level_cur_mp);
			$level_mp = $level_cur_mp . '/' . $level_max_mp;
			$level_mp_percent = floor($level_cur_mp/$level_max_mp * 100 );
		}
		if ( $level_level == 0 )
		{
			$level_exp = '0/0';
			$level_exp_percent = 100;
		}
		else
		{
			$level_posts_for_next = floor(pow(10, pow($level_level, (1/3))));
			@$level_posts_for_this = max(1, floor(pow( 10, pow(($level_level - 1), (1/3)))));
			$level_exp = ($poster_posts - $level_posts_for_this) . "/" . ($level_posts_for_next - $level_posts_for_this);
			$level_exp_percent = floor((($poster_posts - $level_posts_for_this) / max(1, ($level_posts_for_next - $level_posts_for_this))) * 100);
		}

		if ( $board_config['cleveld'] )
		{
			if ( $board_config['post_footer'] )
			{
				$template->assign_block_vars('postrow.levelmodd', array(
					"POSTER_HP" => $level_hp,
					"POSTER_HP_WIDTH" => $level_hp_percent,
					"POSTER_HP_EMPTY" => ( 100 - $level_hp_percent ),
					"POSTER_MP" => $level_mp,
					"POSTER_MP_WIDTH" => $level_mp_percent,
					"POSTER_MP_EMPTY" => ( 100 - $level_mp_percent ),
					"POSTER_EXP" => $level_exp,
					"POSTER_EXP_WIDTH" => $level_exp_percent,
					"POSTER_EXP_EMPTY" => ( 100 - $level_exp_percent ),
					"POSTER_LEVEL" => $level_level)
				);
			}
		}
		if ( $board_config['clevell'] )
		{
			$template->assign_block_vars('postrow.levelmodl', array(
				"POSTER_HP" => $level_hp,
				"POSTER_HP_WIDTH" => $level_hp_percent,
				"POSTER_HP_EMPTY" => ( 100 - $level_hp_percent ),
				"POSTER_MP" => $level_mp,
				"POSTER_MP_WIDTH" => $level_mp_percent,
				"POSTER_MP_EMPTY" => ( 100 - $level_mp_percent ),
				"POSTER_EXP" => $level_exp,
				"POSTER_EXP_WIDTH" => $level_exp_percent,
				"POSTER_EXP_EMPTY" => ( 100 - $level_exp_percent ),
				"POSTER_LEVEL" => $level_level)
			);
		}
	}
	// End Level Mod

	if ( !empty($postrow[$i]['user_aim']) && $board_config['cgg'] && $poster_id != ANONYMOUS && $board_config['cgg'] && $show_post )
	{
		$template->assign_block_vars('postrow.aim', array());
	}
	if ( !empty($postrow[$i]['user_icq']) && $board_config['cicq'] && $poster_id != ANONYMOUS && $board_config['cicq'] && $show_post  )
	{
		$template->assign_block_vars('postrow.icq', array());
	}
}

if ( $is_auth['auth_delete'] )
{
	$template->assign_block_vars('switch_auth_delete', array());
}

if ( $session_logged_in )
{
	if ( is_array($userdata['unread_data'][$forum_id][$topic_id]) && is_array($new_posts_to_delete) )
	{
		$unread_posts_diff = array_diff($userdata['unread_data'][$forum_id][$topic_id], $new_posts_to_delete);
		$unread_posts_exist = count($unread_posts_diff);
	}

	$template->assign_vars(array(
		'U_MARK_TOPIC_UNREAD' => '<br /><a href="' . append_sid("viewtopic.$phpEx?".POST_TOPIC_URL."=$topic_id"."&amp;mark_topic=unread&amp;sid=" . $session_id . "") . '">' . $lang['Mark_topic_unread'] . '</a>',
		'U_MARK_TOPIC_READ' => ($unread_posts_exist) ? '<br /><a href="' . append_sid("viewtopic.$phpEx?".POST_TOPIC_URL."=$topic_id"."&amp;mark_topic=read&amp;sid=" . $session_id . "") . '">' . $lang['Mark_topic_read'] . '</a>' : '')
	);

	if ( $forum_topic_data['topic_tree_width'] && $unread_posts_exist )
	{
		$template->assign_block_vars('next_unread_posts', array(
			'U_TOPIC_NEXT_UNREAD_POSTS' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest"),
			'L_TOPIC_NEXT_UNREAD_POSTS' => $lang['View_next_unread_posts'])
		);
	}
}

if ( $show_quickreply )
{
	include($phpbb_root_path . 'quick_reply.'.$phpEx);
}

if ( $show_reject_panel && $forum_topic_data['forum_moderate'] && $is_auth['auth_mod'] )
{
	$template->assign_block_vars('moderate', array(
		'L_ACCEPT-REJECT_POST' => $lang['Accept-reject'],
		'S_MODERATE_ACTION' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id"))
	);
}

if ( $session_logged_in && count($new_posts_to_delete) && !$HTTP_GET_VARS['mark_topic'] )
{
	$del_posts_ids = '';

	for($i = 0; $i < count($new_posts_to_delete); $i++)
	{
		$del_posts_ids .= ($del_posts_ids) ? ', ' . $new_posts_to_delete[$i] : $new_posts_to_delete[$i];
	}

	$sql = "DELETE FROM " . READ_HIST_TABLE . "
		WHERE user_id = $user_id
			AND post_id IN($del_posts_ids)";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not delete post from read history table', '', __LINE__, __FILE__, $sql);
	}
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>