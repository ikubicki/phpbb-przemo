<?php
/***************************************************************************
 *                                posting.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/10/04 11:48
 *
 *   $Id: posting.php,v 1.159.2.27 2005/10/30 15:17:13 acydburn Exp $
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

$default_tree_width = 35;

define('IN_PHPBB', true);
define('ATTACH', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
include($phpbb_root_path . 'includes/functions_add.'.$phpEx);
include($phpbb_root_path . 'includes/functions_log.'.$phpEx);

//
// Check and set various parameters
//
$params = array('submit' => 'post', 'preview' => 'preview', 'delete' => 'delete', 'poll_delete' => 'poll_delete', 'poll_add' => 'add_poll_option', 'poll_edit' => 'edit_poll_option', 'mode' => 'mode');
while( list($var, $param) = @each($params) )
{
	if ( !empty($HTTP_POST_VARS[$param]) || !empty($HTTP_GET_VARS[$param]) )
	{
		$$var = ( !empty($HTTP_POST_VARS[$param]) ) ? xhtmlspecialchars($HTTP_POST_VARS[$param]) : xhtmlspecialchars($HTTP_GET_VARS[$param]);
	}
	else
	{
		$$var = '';
	}
}

$confirm = isset($HTTP_POST_VARS['confirm']) ? true : false;

$params = array('forum_id' => POST_FORUM_URL, 'topic_id' => POST_TOPIC_URL, 'post_id' => POST_POST_URL, 'back' => 'back');
while( list($var, $param) = @each($params) )
{
	if ( !empty($HTTP_POST_VARS[$param]) || !empty($HTTP_GET_VARS[$param]) )
	{
		$$var = ( !empty($HTTP_POST_VARS[$param]) ) ? intval($HTTP_POST_VARS[$param]) : intval($HTTP_GET_VARS[$param]);
	}
	else
	{
		$$var = '';
	}
}

$post_parent = (($mode == 'quote' || $mode == 'reply') && $post_id) ? $post_id : 0;
$post_parent = ($HTTP_POST_VARS['post_parent']) ? intval($HTTP_POST_VARS['post_parent']) : $post_parent;
$refresh = $preview || $poll_add || $poll_edit || $poll_delete;

$msg_icon_checked = get_vars('msg_icon', 0, 'POST', true);
$msg_icon = ($msg_icon_checked) ? $msg_icon_checked : get_vars('more_icon', 0, 'POST', true);
$msg_expire=$msg_expire_checked = get_vars('msg_expire', 0, 'POST', true);

$selected = ' selected="selected"';

//
// Set topic type
//
$topic_type = ( !empty($HTTP_POST_VARS['topictype']) ) ? intval($HTTP_POST_VARS['topictype']) : POST_NORMAL;
$topic_type = ( in_array($topic_type, array(POST_NORMAL, POST_STICKY, POST_ANNOUNCE, POST_GLOBAL_ANNOUNCE)) ) ? $topic_type : POST_NORMAL;
//
// If the mode is set to topic review then output
// that review ...
//
if ( $mode == 'topicreview' )
{
	require($phpbb_root_path . 'includes/topic_review.'.$phpEx);

	topic_review($topic_id, false);
	exit;
}
else if ( $mode == 'smilies' )
{
	generate_smilies('window', PAGE_POSTING);
	exit;
}
else if ( $mode == 'icons' )
{
	more_icons(PAGE_POSTING);
	exit;
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_POSTING);
init_userprefs($userdata);
//
// End session management
//

check_disable_function(PAGE_POSTING);

$is_jr_admin = ($userdata['user_jr']) ? true : false;

if ( $board_config['login_require'] && !$userdata['session_logged_in'] )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( !(defined('LANG_MODCP')) )
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_modcp.' . $phpEx);
}

//
// Was cancel pressed? If so then redirect to the appropriate
// page, no point in continuing with any further checks
//
if ( isset($HTTP_POST_VARS['cancel']) )
{
	if ( $post_id )
	{
		$redirect = "viewtopic.$phpEx?" . POST_POST_URL . "=$post_id";
		$post_append = "#$post_id";
	}
	else if ( $topic_id )
	{
		$redirect = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id";
		$post_append = '';
	}
	else if ( $forum_id )
	{
		$redirect = "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id";
		$post_append = '';
	}
	else
	{
		$redirect = "index.$phpEx";
		$post_append = '';
	}

	redirect(append_sid($redirect, true) . $post_append);
}

$user_agent = (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? xhtmlspecialchars(trim(addslashes($HTTP_SERVER_VARS['HTTP_USER_AGENT']))) : xhtmlspecialchars(trim(addslashes(getenv('HTTP_USER_AGENT'))));

if ( strlen($user_agent) > 100 )
{
	$user_agent = substr($user_agent, 0, 100) . '...';
}

$user_agent  = serialize(user_agent($user_agent));
$przemo_hash = get_vars('przemo_hash', '', 'POST');

// session id check
$sid = get_vars('sid', '', 'POST,GET');

//
// What auth type do we need to check?
//
$is_auth = array();
switch( $mode )
{
	case 'newtopic':
		if ( $topic_type == POST_GLOBAL_ANNOUNCE )
		{
			$is_auth_type = 'auth_globalannounce';
		}
		else
		if ( $topic_type == POST_ANNOUNCE )
		{
			$is_auth_type = 'auth_announce';
		}
		else if ( $topic_type == POST_STICKY )
		{
			$is_auth_type = 'auth_sticky';
		}
		else
		{
			$is_auth_type = 'auth_post';
		}
		break;
	case 'reply':
	case 'quote':
		$is_auth_type = 'auth_reply';
		break;
	case 'editpost':
		$is_auth_type = 'auth_edit';
		break;
	case 'delete':
	case 'poll_delete':
		if ( !check_sid($sid) )
		{
			message_die(GENERAL_ERROR, 'Invalid_session');
		}	
		$is_auth_type = 'auth_delete';
		break;
	case 'vote':
		$is_auth_type = 'auth_vote';
		break;
	case 'topicreview':
		$is_auth_type = 'auth_read';
		break;
	default:
		message_die(GENERAL_MESSAGE, $lang['No_post_mode']);
		break;
}

//
// Here we do various lookups to find topic_id, forum_id, post_id etc.
// Doing it here prevents spoofing (eg. faking forum_id, topic_id or post_id
//
$error_msg = '';
$post_data = array();
switch ( $mode )
{
	case 'newtopic':
		if ( empty($forum_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['Forum_not_exist']);
		}

		$sql = "SELECT * 
			FROM " . FORUMS_TABLE . " 
			WHERE forum_id = $forum_id";
		break;

	case 'reply':
	case 'vote':
		if ( empty( $topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['No_topic_id']);
		}

		$sql = "SELECT f.*, t.topic_status, t.topic_title, t.topic_title_e, t.topic_type, t.topic_first_post_id, t.topic_tree_width
			FROM (" . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t)
			WHERE t.topic_id = $topic_id
				AND f.forum_id = t.forum_id";
		break;

	case 'quote':
	case 'editpost':
	case 'delete':
	case 'poll_delete':
		if ( empty($post_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['No_post_id']);
		}
		if ( $userdata['user_level'] != ADMIN && $board_config['not_edit_admin'] && ($mode == 'editpost' || $mode == 'delete' || $mode == 'poll_delete') )
		{
			$sql = "SELECT u.user_level
				FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u)
				WHERE p.post_id = $post_id
					AND p.poster_id = u.user_id
					AND u.user_level = " . ADMIN;
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not retrieve post information', '', __LINE__, __FILE__, $sql);
			}
			if ( $row = $db->sql_fetchrow($result) )
			{
				message_die(GENERAL_MESSAGE, $lang['Not_auth_edit_delete_admin']);
			}
		}

		$select_sql = ( !$submit ) ? ", t.topic_title, t.topic_title_e, t.topic_color, p.enable_bbcode, p.enable_html, p.enable_smilies, p.enable_sig, p.post_username, p.post_time, p.post_approve, pt.post_subject, pt.post_text, pt.bbcode_uid, u.username, u.user_id, u.user_sig, u.user_sig_bbcode_uid, u.user_sig_image, p.user_agent, p.post_icon, p.post_expire" : '';
		$from_sql = ( !$submit ) ? ", " . POSTS_TEXT_TABLE . " pt, " . USERS_TABLE . " u" : '';
		$where_sql = ( !$submit ) ? "AND pt.post_id = p.post_id AND u.user_id = p.poster_id" : '';
		if ( !$board_config['report_disable'] )
		{
			$select_sql .= ( $mode == 'delete' ) ? ', p.reporter_id' : '';
		}

		$sql = "SELECT f.*, t.topic_id, t.topic_status, t.topic_type, t.topic_first_post_id, t.topic_last_post_id, t.topic_vote, topic_tree_width, p.post_id, post_time, p.poster_id" . $select_sql . " 
			FROM (" . POSTS_TABLE . " p, " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f" . $from_sql . ")
			WHERE p.post_id = $post_id 
				AND t.topic_id = p.topic_id 
				AND f.forum_id = p.forum_id
				$where_sql";
		break;

	default:
		message_die(GENERAL_MESSAGE, $lang['No_valid_mode']);
}

if ( $result = $db->sql_query($sql) )
{
	$post_info = $db->sql_fetchrow($result);
	if ( !$post_info )
	{
		message_die('GENERAL_MESSAGE', $lang['No_such_post']);
	}
	$db->sql_freeresult($result);

	$forum_id = $post_info['forum_id'];
	$forum_name = get_object_lang(POST_FORUM_URL . $forum_id, 'name');

	$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $post_info);
	if($post_info['forum_link']) message_die(GENERAL_MESSAGE, $lang['Forum_locked']);

	// Topic Lock/Unlock
	$lock = (isset($HTTP_POST_VARS['lock'])) ? TRUE : FALSE;
	$unlock = (isset($HTTP_POST_VARS['unlock'])) ? TRUE : FALSE;
	$comment = ((isset($HTTP_GET_VARS['comment']) || isset($HTTP_POST_VARS['comment'])) && $is_auth['auth_mod']) ? true : false;

	if ( ($submit || $confirm) && ($lock || $unlock) && ($is_auth['auth_mod']) && ($mode != 'newtopic') && (!$refresh) )
	{
		$t_id = ( !isset($post_info['topic_id']) ) ? $topic_id : $post_info['topic_id'];

		if ( $unlock ) 
		{
			$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_UNLOCKED . " 
			WHERE topic_id = $t_id
			AND topic_moved_id = 0";

			log_action('unlock', $t_id, $userdata['user_id'], $userdata['username']);
			set_action($t_id, UNLOCKED);
		}
		else if ( $lock )
		{
			$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_LOCKED . " 
			WHERE topic_id = $t_id
			AND topic_moved_id = 0";

			log_action('lock', $t_id, $userdata['user_id'], $userdata['username']);
			set_action($t_id, LOCKED);
		}

		if ( $lock || $unlock )
		{
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if ( ($post_info['forum_status'] == FORUM_LOCKED && !$is_auth['auth_mod']) || $post_info['forum_link_internal'] == 1 )
	{ 
	   message_die(GENERAL_MESSAGE, $lang['Forum_locked']); 
	} 
	else if ( $mode != 'newtopic' && $post_info['topic_status'] == TOPIC_LOCKED && !$is_auth['auth_mod']) 
	{ 
	   message_die(GENERAL_MESSAGE, $lang['Topic_locked']); 
	} 

	if ( $mode == 'editpost' && !$is_auth['auth_mod'] && $board_config['edit_time'] != '0' && !$submit)
	{
		$difference_sec = CR_TIME - $post_info['post_time'] ;
		$difference_min = (CR_TIME - $post_info['post_time']) / 60;
		if ( $difference_min > $board_config['edit_time'] )
		{
			$message = sprintf($lang['edit_time_past'],$board_config['edit_time']) . '<br /><br />' . sprintf($lang['Click_view_message'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}

	if ( $mode == 'editpost' || $mode == 'delete' || $mode == 'poll_delete' )
	{
		$topic_id = $post_info['topic_id'];

		$post_data['poster_post'] = ( $post_info['poster_id'] == $userdata['user_id'] ) ? true : false;
		$post_data['first_post'] = ( $post_info['topic_first_post_id'] == $post_id ) ? true : false;
		$post_data['last_post'] = ( $post_info['topic_last_post_id'] == $post_id ) ? true : false;
		$post_data['last_topic'] = ( $post_info['forum_last_post_id'] == $post_id ) ? true : false;
		$post_data['has_poll'] = ( $post_info['topic_vote'] ) ? true : false; 
		$post_data['topic_type'] = $post_info['topic_type'];
		$post_data['poster_id'] = $post_info['poster_id'];
		$post_data['post_time'] = $post_info['post_time'];

		if ( $post_data['first_post'] && $post_data['has_poll'] )
		{
			$sql = "SELECT * 
				FROM (" . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr)
				WHERE vd.topic_id = $topic_id 
					AND vr.vote_id = vd.vote_id 
				ORDER BY vr.vote_option_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain vote data for this topic', '', __LINE__, __FILE__, $sql);
			}

			$poll_options = array();
			$poll_results_sum = 0;
			if ( $row = $db->sql_fetchrow($result) )
			{
				$poll_title = $row['vote_text'];
				$poll_id = $row['vote_id'];
				$poll_length = floor($row['vote_length'] / 86400);
				$poll_length_h = ( $row['vote_length'] - ( $poll_length * 86400) ) / 3600;

				$max_vote = $row['vote_max'];
				$hide_vote = $row['vote_hide'];
				$tothide_vote = $row['vote_tothide'];

				do
				{
					$poll_options[$row['vote_option_id']] = $row['vote_option_text']; 
					$poll_results_sum += $row['vote_result'];
				}
				while ( $row = $db->sql_fetchrow($result) );
			}
			$db->sql_freeresult($result);

			$post_data['edit_poll'] = ( ( !$poll_results_sum || $is_auth['auth_mod'] ) && $post_data['first_post'] ) ? true : 0;
		}
		else 
		{
			$post_data['edit_poll'] = ($post_data['first_post'] && $is_auth['auth_pollcreate']) ? true : false;
		}
		
		//
		// Can this user edit/delete the post/poll?
		//
		if ( $post_info['poster_id'] != $userdata['user_id'] && !$is_auth['auth_mod'] )
		{
			$message = ( $delete || $mode == 'delete' ) ? $lang['Delete_own_posts'] : $lang['Edit_own_posts'];
			$message .= '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		}
		else if ( !$post_data['last_post'] && !$is_auth['auth_mod'] && ( $mode == 'delete' || $delete ) )
		{
			message_die(GENERAL_MESSAGE, $lang['Cannot_delete_replied']);
		}
		else if ( !$post_data['edit_poll'] && !$is_auth['auth_mod'] && ( $mode == 'poll_delete' || $poll_delete ) )
		{
			message_die(GENERAL_MESSAGE, $lang['Cannot_delete_poll']);
		}
	}
	else
	{
		if ( $mode == 'quote' )
		{
			$topic_id = $post_info['topic_id'];
		}
		if ( $mode == 'newtopic' )
		{
			$post_data['topic_type'] = POST_NORMAL;
		}

		$post_data['first_post'] = ( $mode == 'newtopic' ) ? true : 0;
		$post_data['last_post'] = false;
		$post_data['has_poll'] = false;
		$post_data['edit_poll'] = false;
	}
	if ( $mode == 'poll_delete' && !isset($poll_id) )
	{
		message_die(GENERAL_MESSAGE, $lang['No_such_post']);
	}
}
else
{
	message_die(GENERAL_MESSAGE, $lang['No_such_post']);
}

$topic_color = ($HTTP_POST_VARS['topic_color'] && $board_config['topic_color'] && $userdata['can_topic_color'] && ($board_config['topic_color_all'] || $userdata['user_level'] == ADMIN || ($is_auth['auth_mod'] && $board_config['topic_color_mod']))) ? xhtmlspecialchars($HTTP_POST_VARS['topic_color']) : '';

$submit_topic_tag = '';
if ( $HTTP_POST_VARS['topic_tag'] && strpos($post_info['topic_tags'], ',') )
{
	$topic_tags_ary = @explode(',', $post_info['topic_tags']);
	for($i = 0; $i < count($topic_tags_ary); $i++)
	{
		if ( $topic_tags_ary[$i] == $HTTP_POST_VARS['topic_tag'] )
		{
			$submit_topic_tag = '[' . $HTTP_POST_VARS['topic_tag'] . ']';
		}
	}
}

function separe_topic_tag($subject)
{
	global $board_config, $post_info;

	if ( strpos($post_info['topic_tags'], ',') && strpos($subject, '[') == 0 && strstr($subject,'[') && strpos($subject, ']') )
	{
		$tag_end = strpos($subject, ']') - 1;
		$topic_tag = substr($subject, 1, $tag_end);

		$topic_tags_ary = @explode(',', $post_info['topic_tags']);
		for($i = 0; $i < count($topic_tags_ary); $i++)
		{
			if ( $topic_tag == $topic_tags_ary[$i] )
			{
				return array($topic_tag, str_replace('[' . $topic_tag . '] ', '', $subject));
			}
		}
	}
	return false;
}

//
// The user is not authed, if they're not logged in then redirect
// them, else show them an error message
//
if ( !$is_auth[$is_auth_type] )
{
	if ( $userdata['session_logged_in'] )
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_' . $is_auth_type], $is_auth[$is_auth_type . "_type"]));
	}

	switch( $mode )
	{
		case 'newtopic':
			$redirect = "mode=newtopic&" . POST_FORUM_URL . "=" . $forum_id;
			break;
		case 'reply':
		case 'topicreview':
			$redirect = "mode=reply&" . POST_TOPIC_URL . "=" . $topic_id;
			break;
		case 'quote':
		case 'editpost':
			$redirect = "mode=quote&" . POST_POST_URL ."=" . $post_id;
			break;
	}

	redirect(append_sid("login.$phpEx?redirect=posting.$phpEx&" . $redirect, true));
}

if ( !$forum_id )
{
	$where_sql = ( $post_id ) ? "p.post_id = $post_id AND p.topic_id = t.topic_id" : "t.topic_id = $topic_id";
	$sql = "SELECT t.forum_id FROM (" . TOPICS_TABLE . " t, " . POSTS_TABLE . " p)
			WHERE $where_sql";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_MESSAGE, 'Could not retrieve forum id', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);
	$forum_id = $row['forum_id'];
}

if ( $forum_id && $userdata['user_level'] == MOD)
{
	$forum_moderators = moderarots_list($forum_id, 'mod');
	if ( @in_array($userdata['user_id'], $forum_moderators) )
	{
		$is_mod_forum = true;
	}
}
else
{
	$is_mod_forum = false;
}

if ( !$is_mod_forum && $userdata['user_level'] != ADMIN )
{
	$cache_name = 'multisqlcache_forum_' . $forum_id;
	$forum_row = sql_cache('check', $cache_name);
	if (!isset($forum_row))
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
			message_die(GENERAL_MESSAGE, 'Could not retrieve forum information', '', __LINE__, __FILE__, $sql);
		}
		sql_cache('write', $cache_name, $forum_row); 
	}

	$redirect = str_replace("&amp;", "&", preg_replace('#.*?([a-z]+?\.' . $phpEx . '.*?)$#i', '\1', xhtmlspecialchars($_SERVER['REQUEST_URI'])));
	$cookie_forum_pass = $unique_cookie_name . '_fpass_' . $forum_id;
	if ( $HTTP_POST_VARS['cancel'] )
	{
		redirect(append_sid("index.$phpEx"));
	}
	else if ( $HTTP_POST_VARS['submit'] && $HTTP_POST_VARS['password'] )
	{
		password_check($forum_id, $HTTP_POST_VARS['password'], $redirect);
	}

	if ( ($forum_row['password'] != '') && ($HTTP_COOKIE_VARS[$cookie_forum_pass] != md5($forum_row['password'])) )
	{
		password_box($forum_id, $redirect);
	}
}

//
// Set toggles for various options
//
if ( $board_config['allow_html'] || ( ($board_config['mod_html'] && $is_mod_forum) || ($board_config['admin_html'] && $userdata['user_level'] == ADMIN) || ($board_config['jr_admin_html'] && $is_jr_admin) ) )
{
	$html_on = ($submit || $refresh) ? (( !empty($HTTP_POST_VARS['disable_html'])) ? 0 : TRUE ) : (( $userdata['user_id'] == ANONYMOUS) ? $board_config['allow_html'] : $userdata['user_allowhtml']);
	$show_html = true;
}
else
{
	$html_on = 0;
	$show_html = false;
}

$user_can_use_bbcode = false;
if ( $userdata['session_logged_in'] && $board_config['allow_bbcode'] && $userdata['user_allowbbcode'] )
{
	$user_can_use_bbcode = true;
}
if ( $board_config['allow_bbcode'] && (!$userdata['session_logged_in'] && !$board_config['allow_bbcode_quest']) )
{
	$user_can_use_bbcode = true;
}

if ( !$user_can_use_bbcode )
{
	$bbcode_on = 0;
}
else
{
	$bbcode_on = (!empty($HTTP_POST_VARS['disable_bbcode'])) ? 0 : true;
}



if ( !$board_config['allow_smilies'] || ( $board_config['restrict_smilies'] && !$userdata['session_logged_in'] ) )
{
	$smilies_on = 0;
}
else
{
	$smilies_on = ($submit || $refresh) ? ((!empty($HTTP_POST_VARS['disable_smilies'])) ? 0 : TRUE) : (($userdata['user_id'] == ANONYMOUS) ? $board_config['allow_smilies'] : $userdata['user_allowsmile']);
}

if ( ($submit || $refresh) && $is_auth['auth_read'])
{
	$notify_user = ( !empty($HTTP_POST_VARS['notify']) ) ? TRUE : 0;
}
else
{
	$userdata['user_notify'] = ($post_info['poster_id'] != $userdata['user_id'] && $mode == 'editpost' ) ? 0 : $userdata['user_notify'];
	if ( $mode != 'newtopic' && $userdata['session_logged_in'] && $is_auth['auth_read'] )
	{
		$sql = "SELECT topic_id 
			FROM " . TOPICS_WATCH_TABLE . "
			WHERE topic_id = $topic_id 
				AND user_id = " . $userdata['user_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain topic watch information', '', __LINE__, __FILE__, $sql);
		}

		$notify_user = ( $db->sql_fetchrow($result) ) ? TRUE : (($mode == 'editpost') ? 0 : $userdata['user_notify']);
		$db->sql_freeresult($result);
	}
	else
	{
		$notify_user = ( $userdata['session_logged_in'] && $is_auth['auth_read'] ) ? $userdata['user_notify'] : 0;
	}
}

$attach_sig = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['attach_sig']) ) ? TRUE : 0 ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? 0 : $userdata['user_attachsig'] );

if ( defined('ATTACHMENTS_ON') && !$comment )
{
	execute_posting_attachment_handling();
}

// --------------------
//  What shall we do?
//
if ( ( $delete || $poll_delete || $mode == 'delete' ) && !$confirm )
{
	//
	// Confirm deletion
	//
	$s_hidden_fields = '<input type="hidden" name="' . POST_POST_URL . '" value="' . $post_id . '" />';
	$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
	$s_hidden_fields .= ( $delete || $mode == "delete" ) ? '<input type="hidden" name="mode" value="delete" />' : '<input type="hidden" name="mode" value="poll_delete" />';

	$l_confirm = ( $delete || $mode == 'delete' ) ? $lang['Confirm_delete'] : $lang['Confirm_delete_poll'];

	//
	// Output confirmation page
	//
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	if ( $mode == 'delete' && $post_info['poster_id'] != $userdata['user_id'] && $post_info['poster_id'] != ANONYMOUS && $board_config['del_notify_enable'])
	{
		$reason_jumpbox = '<select name="reasons">';
		for($i = 0; $i < count($lang['del_notify_reasons']); $i++)
		{
			$reason_jumpbox .= '<option value="' . $i . '"' . (($i == 0) ? $selected : '') . '>' . $lang['del_notify_reasons'][$i] . '</option>';
		}
		$reason_jumpbox .= '</select>';

		$s_hidden_fields .= '<input type="hidden" name="notify_user" value="' . $post_info['poster_id'] . '" />';
		$del_choice = ($board_config['del_notify_choice']) ? '<input type="checkbox" name="no_notify"> ' . $lang['del_notify_choice'] . '<br /><br />' : '';

		$sql = "SELECT username
			FROM " . USERS_TABLE . "
			WHERE user_id = " . $post_info['poster_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get username from users table', '', __LINE__, __FILE__, $sql);
		}
		$rowname = $db->sql_fetchrow($result);

		$template->set_filenames(array(
			'confirm_body' => 'confirm_body_notify.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE' => sprintf($lang['del_notify'], $rowname['username']),
			'REASON_JUMPBOX' => $reason_jumpbox,

			'L_DEL_NOTIFY_REASON' => $lang['del_notify_reason'],
			'L_DEL_NOTIFY_REASON_E' => $lang['del_notify_reason_e'],
			'L_DEL_NOTIFY_REASON2' => $lang['del_notify_reason2'],
			'L_DEL_NOTIFY_REASON2_E' => $lang['del_notify_reason2_e'],
			'L_DEL_NOTIFY' => $lang['del_notify'],
			'L_CONFIRM_DELETE' => $del_choice . $lang['Confirm_delete'],
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['Cancel'],

			'S_CONFIRM_ACTION' => append_sid("posting.$phpEx"),
			'S_HIDDEN_FIELDS' => $s_hidden_fields)
		);
	}
	else
	{
		if(!$back && !$post_data['first_post'])
		{
			$sql = "SELECT post_id FROM ".POSTS_TABLE." WHERE topic_id=$topic_id AND post_id < $post_id ORDER BY post_id DESC LIMIT 1";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$back = $row['post_id'];
		}
		$s_hidden_fields .= ($back) ? '<input type="hidden" name="back" value="'.$back.'" />' : '';	
		$template->set_filenames(array(
			'confirm_body' => 'confirm_body.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Information'],
			'MESSAGE_TEXT' => $l_confirm,

			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],

			'S_CONFIRM_ACTION' => append_sid("posting.$phpEx"),
			'S_HIDDEN_FIELDS' => $s_hidden_fields)
		);
	}

	$template->pparse('confirm_body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $mode == 'vote' )
{
	//
	// Vote in a poll
	//
	if ( !empty($HTTP_POST_VARS['vote_id']) )
	{
		$vote_option_id = intval($HTTP_POST_VARS['vote_id']);

		$sql = "SELECT vd.vote_id, vd.vote_max
			FROM (" . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr)
			WHERE vd.topic_id = $topic_id
				AND vr.vote_id = vd.vote_id
				AND vr.vote_option_id = $vote_option_id
			GROUP BY vd.vote_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain vote data for this topic', '', __LINE__, __FILE__, $sql);
		}

		if ( $vote_info = $db->sql_fetchrow($result) )
		{
			$max_vote = $vote_info['vote_max'];
		}

		$max_voting = count($HTTP_POST_VARS['vote_id']);

		if ( $max_voting > $max_vote )
		{
			$message_return .= '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a>');
			message_die(GENERAL_MESSAGE, sprintf($lang['too_many_voting'], $max_vote, $max_voting) . $message_return);
		}

		for($i = 0; $i < $max_voting; $i++)
		{
			$vbn[$i] = $HTTP_POST_VARS['vote_id'][$i];
		}

		$sql = "SELECT vd.vote_id
			FROM (" . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr)
			WHERE vd.topic_id = $topic_id
				AND vr.vote_id = vd.vote_id
				AND vr.vote_option_id = $vote_option_id
			GROUP BY vd.vote_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain vote data for this topic', '', __LINE__, __FILE__, $sql);
		}

		if ( $vote_info = $db->sql_fetchrow($result) )
		{
			$vote_id = $vote_info['vote_id'];

			$sql = "SELECT *
				FROM " . VOTE_USERS_TABLE . "
				WHERE vote_id = $vote_id
					AND vote_user_id = " . $userdata['user_id'];
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user vote data for this topic', '', __LINE__, __FILE__, $sql);
			}

			if ( !($row = $db->sql_fetchrow($result)) )
			{
				for($i = 0; $i < $max_voting; $i++)
				{
					$vote_option_id = intval($vbn[$i]);

					$sql = "UPDATE " . VOTE_RESULTS_TABLE . " 
						SET vote_result = vote_result + 1 
						WHERE vote_id = $vote_id 
						AND vote_option_id = $vote_option_id";
					if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
					{
						message_die(GENERAL_ERROR, 'Could not update poll result', '', __LINE__, __FILE__, $sql);
					}

					$sql = "INSERT INTO " . VOTE_USERS_TABLE . " (vote_id, vote_user_id, vote_user_ip, vote_cast)
						VALUES ($vote_id, " . $userdata['user_id'] . ", '$user_ip', '" . $vbn[$i] . "')";
					if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
					{
						message_die(GENERAL_ERROR, "Could not insert user_id for poll", "", __LINE__, __FILE__, $sql);
					}
				}
				$sql = "UPDATE " . VOTE_DESC_TABLE . " 
					SET vote_voted = vote_voted + 1 
					WHERE vote_id = $vote_id 
					AND topic_id = $topic_id";
				if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
				{
					message_die(GENERAL_ERROR, 'Could not update poll voted', '', __LINE__, __FILE__, $sql);
				}
				$message = $lang['Vote_cast'];
			}
			else
			{
				$message = $lang['Already_voted'];
			}
			$db->sql_freeresult($result2);
		}
		else
		{
			$message = $lang['No_vote_option'];
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">')
		);

		$message .= '<br /><br />' . sprintf($lang['Click_view_message'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
	else
	{
		redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));
	}
}
else if ( $submit || $confirm )
{
	//
	// Submit post/vote (newtopic, edit, reply, etc.)
	//

	if ( $mode == 'editpost' && $comment )
	{
		$sql = "SELECT pt.post_text, pt.bbcode_uid, p.enable_bbcode, p.enable_html, p.enable_smilies
			FROM (" . POSTS_TEXT_TABLE . " pt, " . POSTS_TABLE . " p)
			WHERE p.post_id = $post_id
			AND pt.post_id = $post_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain post information', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		$buid = $row['bbcode_uid'];
		$add_data = create_date($board_config['default_dateformat'], CR_TIME, $board_config['board_timezone'], true);
        if ( $user_can_use_bbcode && $bbcode_on && $row['enable_bbcode'] )
        {
            $separator = " \n\n[size=9:" . $buid . "][ [i:" . $buid . "]" . sprintf($lang['Comment_added'], "[b:" . $buid . "]" . phpbb_clean_username($userdata['username'])) . "[/b:" . $buid . "]: " . $add_data . "[/i:" . $buid . "] ][/size:" . $buid . "]\n";
        }
        else
        {
            $separator = " \n\n" . sprintf($lang['Comment_added'], phpbb_clean_username($userdata['username'])) . ": " . $add_data . "\n";
        }
		$message = prepare_message($HTTP_POST_VARS['message'], $row['enable_html'], $row['enable_bbcode'], $row['enable_smilies'], $buid, $forum_id);
		$last_message = prepare_message(str_replace(array("'", "\\"), array("''", "\\\\"), unprepare_message($row['post_text'])), $row['enable_html'], $row['enable_bbcode'], $row['enable_smilies'], $buid, $forum_id);
		$last_message = preg_replace("#\[quote:$buid=&quot;(.*?)&quot;\]#si", "[quote:$buid=\"\\1\"]", $last_message);
		$splited = $last_message . $separator . str_replace("\'", "''", $message);

		if ( strlen($splited) > 65500 )
		{
			message_die(GENERAL_MESSAGE, 'Your message is too long. It can not be more than 65500 chars.');
		}

		$sql = "UPDATE " . POSTS_TEXT_TABLE . "
			SET post_text = '$splited'
			WHERE post_id = $post_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update splited message', '', __LINE__, __FILE__, $sql);
		}

		if ( $board_config['search_enable'] )
		{
			include($phpbb_root_path . 'includes/functions_search.'.$phpEx);
			add_search_words(0, $post_id, stripslashes($message));
		}

		$meta = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">';
		$return_message = $lang['Stored'] . '<br /><br />' . sprintf($lang['Click_view_message'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');

		$template->assign_vars(array(
			'META' => $meta . $return_meta)
		);

		message_die(GENERAL_MESSAGE, $return_message);
	}

	if ( $mode == 'reply' && $board_config['split_messages'] && $userdata['user_id'] != ANONYMOUS && (!$post_info['topic_tree_width'] || !$post_parent) )
	{
		$do_split = false;
		if ( $userdata['user_level'] == ADMIN )
		{
			$do_split = (!$board_config['split_messages_admin']) ? false : true;
		}
		else
		{
			$do_split = ($is_mod_forum && !$board_config['split_messages_mod']) ? false : true;
		}

		$do_split = ( $post_info['forum_no_split'] || !$do_split  ) ? false : true;

		if ( isset($HTTP_POST_VARS['nosplit']) && ($userdata['user_level'] == ADMIN || $is_mod_forum) )
		{
			$do_split = false;
		}

        if ( $do_split )
        {
            $poster_id = $userdata['user_id'];

            $sql = "SELECT p.post_id, p.poster_id, p.post_time, p.post_start_time, p.forum_id, f.forum_last_post_id
                    FROM " . POSTS_TABLE . " p, " . FORUMS_TABLE . " f
					WHERE p.topic_id = $topic_id
					AND p.post_parent = 0
					AND p.forum_id=f.forum_id
					ORDER BY p.post_time DESC LIMIT 1";
	
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain post', '', __LINE__, __FILE__, $sql);
			}
			$post_id_last_row = $db->sql_fetchrow($result);
			$post_id = $post_id_last_row['post_id'];
			$poster_topic_id = $post_id_last_row['poster_id'];

			if ( $post_id_last_row['poster_id'] == $poster_id )
			{
				$sql = "SELECT pt.post_text, pt.bbcode_uid, p.enable_bbcode, p.enable_html, p.enable_smilies
					FROM (" . POSTS_TEXT_TABLE . " pt, " . POSTS_TABLE . " p)
					WHERE p.post_id = $post_id
					AND pt.post_id = $post_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain post information', '', __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);

				$buid = $row['bbcode_uid'];
				$add_data = create_date($board_config['default_dateformat'], CR_TIME, $board_config['board_timezone'], true);
				if ( $user_can_use_bbcode && $bbcode_on && $row['enable_bbcode'] )
				{
					$separator = " \n\n[size=9:" . $buid . "][ [i:" . $buid . "][b:" . $buid . "]" . $lang['added'] . "[/b:" . $buid . "]: " . $add_data . "[/i:" . $buid . "] ][/size:" . $buid . "]\n";
				}
				else
				{
					$separator = " \n\n" . $lang['added'] . ": " . $add_data . "\n";
				}
				$message = prepare_message($HTTP_POST_VARS['message'], $row['enable_html'], $row['enable_bbcode'], $row['enable_smilies'], $buid, $forum_id);
				$last_message = prepare_message(str_replace(array("'", "\\"), array("''", "\\\\"), unprepare_message($row['post_text'])), $row['enable_html'], $row['enable_bbcode'], $row['enable_smilies'], $buid, $forum_id);
				$last_message = preg_replace("#\[quote:$buid=&quot;(.*?)&quot;\]#si", "[quote:$buid=\"\\1\"]", $last_message);
				$splited = $last_message . $separator . str_replace("\'", "''", $message);

				if ( strlen($splited) > 65500 )
				{
					message_die(GENERAL_MESSAGE, 'Your message is too long. It can not be more than 65500 chars.');
				}

				if ( trim(str_replace("''", "\'", $last_message)) == trim(str_replace('\"', '"', $message)) )
				{
					message_die(GENERAL_ERROR, $lang['that_same_msg']);
				}

				if ( defined('ATTACHMENTS_ON') && !$comment )
				{
					$attachment_mod['posting']->insert_attachment($post_id);
				}

				$sql = "UPDATE " . POSTS_TEXT_TABLE . "
					SET post_text = '$splited'
					WHERE post_id = $post_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update splited message', '', __LINE__, __FILE__, $sql);
				}

                $sql_start = ($post_id_last_row['post_start_time'] == 0) ? ', post_start_time = ' . $post_id_last_row['post_time'] : '';

                $sql = "UPDATE " . POSTS_TABLE . " SET post_time = " . CR_TIME . $sql_start . " WHERE post_id = $post_id";
                $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not update message time', '', __LINE__, __FILE__, $sql);

				if($post_id_last_row['forum_last_post_id'] != $post_id) {				
					$sql = "UPDATE ".FORUMS_TABLE." SET forum_last_post_id=$post_id WHERE forum_id=".$post_id_last_row['forum_id'];
					$db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not update forum last post id ', '', __LINE__, __FILE__, $sql);
				}

                update_config('lastpost', CR_TIME);

				if ( $board_config['search_enable'] )
				{
					include($phpbb_root_path . 'includes/functions_search.'.$phpEx);
					add_search_words(0, $post_id, stripslashes($message));
				}

				$meta = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">';
				$return_message = $lang['Stored'] . '<br /><br />' . sprintf($lang['Click_view_message'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');

				$template->assign_vars(array(
					'META' => $meta . $return_meta)
				);

				message_die(GENERAL_MESSAGE, $return_message);
			}
		}
	}

	$return_message = '';
	$return_meta = '';

	disallow_forums($userdata, $forum_id);

	switch ( $mode )
	{
	case 'editpost':
        $username     = get_vars('username',  '', 'POST');
        $subject      = trim(get_vars('subject', '', 'POST'));
        $subject_e    = trim(get_vars('subject_e', '', 'POST'));
        $message      = get_vars('message',   '', 'POST');
        $bbcode_uid   = '';
        if( $is_auth['auth_pollcreate'] )
        {
            $poll_title    = get_vars('poll_title',       '', 'POST');
            $poll_options  = get_vars('poll_option_text', '', 'POST', false, 1);
            $poll_length   = get_vars('poll_length',      '', 'POST', true);
            $poll_length_h = get_vars('poll_length_h',    '', 'POST', true);

            $poll_length = $poll_length * 24;
            $poll_length = $poll_length_h + $poll_length;
            $poll_length = ($poll_length) ? max(0, ($poll_length / 24)) : 0;

            $max_vote     = (isset($HTTP_POST_VARS['max_vote'])) ? ( ( $HTTP_POST_VARS['max_vote'] == 0 ) ? 1 : $HTTP_POST_VARS['max_vote'] ) : '';
            $hide_vote    = (isset($HTTP_POST_VARS['hide_vote']) && $poll_length > 0 ) ? 1 : '';
            $tothide_vote = (isset($HTTP_POST_VARS['tothide_vote']) && isset($HTTP_POST_VARS['hide_vote']) && ($poll_length>0) ) ? 1 : '';
        }
        else
        {
            $poll_title=$max_vote=$hide_vote=$tothide_vote='';
            $poll_options=array();
            $poll_length=$poll_length_h=0;
        }

		if ( strlen($message) > 65500 )
		{
			message_die(GENERAL_MESSAGE, 'Your message is too long. It can not be more than 65500 chars.');
		}

		if ( !przemo_check_hash($przemo_hash) )
		{
			$error_msg = $lang['Invalid_session'];
		}
		prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on, $error_msg, $username, $bbcode_uid, $subject, $subject_e, $message, $poll_title, $poll_options, $poll_length, $max_vote, $hide_vote, $tothide_vote, $forum_id);

		if ( $error_msg == '' )
		{
			$topic_type = ($topic_type != $post_data['topic_type'] && !$is_auth['auth_sticky'] && !$is_auth['auth_announce'] && !$is_auth['auth_globalannounce']) ? $post_data['topic_type'] : $topic_type;

			if ( !$userdata['session_logged_in'] && $board_config['not_anonymous_posting'] && empty($HTTP_POST_VARS['username']) )
			{
				message_die(GENERAL_MESSAGE, $lang['No_to_user']);
			}

			$post_approve = ($post_info['forum_moderate'] && !$is_auth['auth_mod']) ? 0 : 1;

			if ( $submit_topic_tag )
			{
				$subject = $submit_topic_tag . ' ' . $subject;
			}
			$sql = "SELECT post_text, bbcode_uid
				FROM " . POSTS_TEXT_TABLE . "
				WHERE post_id = $post_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain post data information', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$old_post_text = $row['post_text'];
				$old_bbcode_uid = $row['bbcode_uid'];
			}
			else
			{
				message_die(GENERAL_ERROR, 'Could not obtain post data information', '', __LINE__, __FILE__, $sql);
			}

			if ( $post_info['forum_tree_grade'] )
			{
				if ( $is_auth['auth_mod'] && isset($HTTP_POST_VARS['tree_width']) )
				{
					$post_data['topic_tree_width'] = intval($HTTP_POST_VARS['tree_width']);
				}
				else if ( $post_info['forum_tree_req'] )
				{
					$post_data['topic_tree_width'] = $default_tree_width;
				}
				$post_data['topic_first_post_id'] = $post_info['topic_first_post_id'];
			}

			$str_replace_username = str_replace("\'", "''", $username);
			$str_replace_subject = str_replace("\'", "''", $subject);
			$str_replace_subject_e = str_replace("\'", "''", $subject_e);
			$str_replace_message = str_replace("\'", "''", $message);
			$str_replace_poll_title = str_replace("\'", "''", $poll_title);
			$str_replace_user_agent = str_replace("\'", "''", $user_agent);
			$str_replace_topic_color = str_replace("\'", "''", $topic_color);
			submit_post($mode, $post_data, $return_message, $return_meta, $forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on, $html_on, $smilies_on, $attach_sig, $bbcode_uid, $str_replace_username, $str_replace_subject, $str_replace_subject_e, $str_replace_message, $str_replace_poll_title, $poll_options, $poll_length, $max_vote, $hide_vote, $tothide_vote, $str_replace_user_agent, $msg_icon, $msg_expire, $str_replace_topic_color, $post_approve, $is_mod_forum, $is_jr_admin);

			$board_config['ph_days'] = intval($board_config['ph_days']);
			if ( ((strlen($old_post_text) - strlen($message)) > ($board_config['ph_len'] - 1) || (strlen($message) - strlen($old_post_text)) > ($board_config['ph_len'] - 1)) && $board_config['ph_days'] )
			{
				$old_post_text = str_replace(array("'", "\\", $old_bbcode_uid), array("''", "\\\\", "cc9d3da2e0"), $old_post_text);
				$sql = "INSERT INTO " . POSTS_HISTORY_TABLE . " (th_post_id, th_post_text, th_user_id, th_time)
					VALUES ($post_id, '$old_post_text', " . $userdata['user_id'] . ", " . CR_TIME . ")";
				if ( !($db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Error insert in post history table', '', __LINE__, __FILE__, $sql);
				}

				$min_time = CR_TIME - ($board_config['ph_days'] * 86400);

				$sql = "DELETE FROM " . POSTS_HISTORY_TABLE . "
					WHERE th_time < " . $min_time;

				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not delete old post history entries', '', __LINE__, __FILE__, $sql);
				}
			}

			if ( $userdata['user_level'] == ADMIN || $is_mod_forum )
			{
				// Log Actions Start
				log_action('edit', $post_id, $userdata['user_id'], $userdata['username'], $post_data['poster_id']);
				
				if ( !$post_data['poster_post'] )
				{
					set_action($post_id, EDITED);
				}
				else
				{
					$self_sql = ($post_data['last_post'] && !$board_config['show_action_edited_self_all']) ? ", post_edit_time = '0'" : '';
					$sql = "UPDATE " . POSTS_TABLE . "
						SET post_edit_by = '0' $self_sql
							WHERE post_id = $post_id";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Error in updating posts table', '', __LINE__, __FILE__, $sql);
					}
				}
			}
			else
			{
				$sql = "UPDATE " . POSTS_TABLE . " SET post_edit_time = '" . CR_TIME . "', post_edit_by = '".$userdata['user_id']."' WHERE post_id = ".$post_id;
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Error in updating posts table', '', __LINE__, __FILE__, $sql);
				}
			}

			$notify_n = 1;
			$mode_n = $mode;
			$post_data_n = $post_data;
			$forum_id_n = $forum_id;
			$topic_id_n = $topic_id;
			$post_id_n = $post_id;
			$notify_user_n = $notify_user;
		}
		break;

	case 'newtopic':
	case 'reply':
        $username     = get_vars('username',  '', 'POST');
        $subject      = trim(get_vars('subject', '', 'POST'));
        $subject_e    = trim(get_vars('subject_e', '', 'POST'));
        $message      = get_vars('message',   '', 'POST');
        $bbcode_uid   = '';
        if( $is_auth['auth_pollcreate'] )
        {
            $poll_title    = get_vars('poll_title',       '', 'POST');
            $poll_options  = get_vars('poll_option_text', '', 'POST', false, 1);
            $poll_length   = get_vars('poll_length',      '', 'POST', true);
            $poll_length_h = get_vars('poll_length_h',    '', 'POST', true);

            $poll_length = $poll_length * 24;
            $poll_length = $poll_length_h + $poll_length;
            $poll_length = ($poll_length) ? max(0, ($poll_length / 24)) : 0;

            $max_vote     = (isset($HTTP_POST_VARS['max_vote'])) ? ( ( $HTTP_POST_VARS['max_vote'] == 0 ) ? 1 : $HTTP_POST_VARS['max_vote'] ) : '';
            $hide_vote    = (isset($HTTP_POST_VARS['hide_vote']) && $poll_length > 0 ) ? 1 : '';
            $tothide_vote = (isset($HTTP_POST_VARS['tothide_vote']) && isset($HTTP_POST_VARS['hide_vote']) && ($poll_length>0) ) ? 1 : '';
        }
        else
        {
            $poll_title=$max_vote=$hide_vote=$tothide_vote='';
            $poll_options=array();
            $poll_length=$poll_length_h=0;
        }

		if ( strlen($message) > 65500 )
		{
			message_die(GENERAL_MESSAGE, 'Your message is too long. It can not be more than 65500 chars.');
		}

		if ( !przemo_check_hash($przemo_hash) )
		{
			$error_msg = $lang['Invalid_session'];
		}
		prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on, $error_msg, $username, $bbcode_uid, $subject, $subject_e, $message, $poll_title, $poll_options, $poll_length, $max_vote, $hide_vote, $tothide_vote, $forum_id);

		if ( $error_msg == '' )
		{
			$topic_type = ( $topic_type != $post_data['topic_type'] && !$is_auth['auth_sticky'] && !$is_auth['auth_announce'] && !$is_auth['auth_globalannounce'] ) ? $post_data['topic_type'] : $topic_type;

			if ( !$userdata['session_logged_in'] && $board_config['not_anonymous_posting'] && empty($HTTP_POST_VARS['username']) )
			{
				message_die(GENERAL_MESSAGE, $lang['No_to_user']);
			}

			$post_approve = ($post_info['forum_moderate'] && !$is_auth['auth_mod']) ? 0 : 1;

			if ( $submit_topic_tag && $mode == 'newtopic' )
			{
				$subject = $submit_topic_tag . ' ' . $subject;
			}
			
			$str_replace_username = str_replace("\'", "''", $username);
			$str_replace_subject = str_replace("\'", "''", $subject);
			$str_replace_subject_e = str_replace("\'", "''", $subject_e);
			$str_replace_message = str_replace("\'", "''", $message);
			$str_replace_poll_title = str_replace("\'", "''", $poll_title);
			$str_replace_user_agent = str_replace("\'", "''", $user_agent);
			$str_replace_topic_color = str_replace("\'", "''", $topic_color);

			if ( $post_info['forum_tree_grade'] )
			{
				$post_data['post_parent'] = ($post_info['topic_tree_width']) ? $post_parent : 0;
				if ( $is_auth['auth_mod'] && isset($HTTP_POST_VARS['tree_width']) )
				{
					$post_data['topic_tree_width'] = intval($HTTP_POST_VARS['tree_width']);
				}
				else if ( $post_info['forum_tree_req'] )
				{
					$post_data['topic_tree_width'] = $default_tree_width;
				}
				$post_data['topic_first_post_id'] = $post_info['topic_first_post_id'];
			}
			submit_post($mode, $post_data, $return_message, $return_meta, $forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on, $html_on, $smilies_on, $attach_sig, $bbcode_uid, $str_replace_username, $str_replace_subject, $str_replace_subject_e, $str_replace_message, $str_replace_poll_title, $poll_options, $poll_length, $max_vote, $hide_vote, $tothide_vote, $str_replace_user_agent, $msg_icon, $msg_expire, $str_replace_topic_color, $post_approve, $is_mod_forum, $is_jr_admin);

			$notify_n = 1;
			$mode_n = $mode;
			$post_data_n = $post_data;
			$forum_id_n = $forum_id;
			$topic_id_n = $topic_id;
			$post_id_n = $post_id;
			$notify_user_n = $notify_user;

			if ( $error_msg == '' && $lock && $mode == 'newtopic' && $is_auth['auth_mod'] )
			{
				$sql = "UPDATE " . TOPICS_TABLE . " 
				SET topic_status = " . TOPIC_LOCKED . " 
				WHERE topic_id = $topic_id
					AND topic_moved_id = 0";

				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
				}
			}
		}
		break;

	case 'delete':
		if ( !$board_config['report_disable'] )
		{
			$post_data['report'] = !empty($post_info['reporter_id']);
		}
		if ( !check_sid($sid) )
		{
			message_die(GENERAL_ERROR, 'Invalid_session');
		}
	case 'poll_delete':
		if ( $board_config['del_notify_enable'] && (isset($HTTP_POST_VARS['reason']) || isset($HTTP_POST_VARS['reasons'])) && (!($HTTP_POST_VARS['no_notify'] && $board_config['del_notify_choice'])) )
		{
			$reason = (!empty($HTTP_POST_VARS['reason'])) ? $HTTP_POST_VARS['reason'] : $HTTP_POST_VARS['reasons'];	
			notify_delete($post_id, $topic_id, $userdata['user_id'], intval($HTTP_POST_VARS['notify_user']), trim(stripslashes($reason)));
		}

		include($phpbb_root_path . 'includes/functions_remove.'.$phpEx);

		if ( $mode != 'poll_delete' )
		{
			delete_post($post_id);
		}

		if ( $mode == 'poll_delete' && $post_data['has_poll'] && $post_data['edit_poll'] )
		{
			delete_poll_data($topic_id);
		}

		if ( $mode == 'delete' && $post_data['first_post'] && $post_data['last_post'] )
		{
			$return_meta = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . '=' . $forum_id) . '">';
			$return_message = $lang['Deleted'];
		}
		else
		{
			$back = ($back) ? POST_POST_URL."=$back#$back": POST_TOPIC_URL . "=".$topic_id;
			$return_meta = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewtopic.$phpEx?".$back) . '">';
			$return_message = ( ( $mode == 'poll_delete' ) ? $lang['Poll_delete'] : $lang['Deleted'] ) . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?".$back) . '">', '</a>');
		}

		$message .= $return_message . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');
		
		if ( $userdata['user_level'] == ADMIN || $is_mod_forum )
		{
			// Log actions MOD Start
			log_action('delete', $topic_id, $userdata['user_id'], $userdata['username']);
		}

		break;
	}

    $user_id = ($mode == 'reply' || $mode == 'newtopic') ? $userdata['user_id'] : $post_data['poster_id'];
    if (empty($error_msg) && $mode != 'editpost' && $mode != 'delete')
    {
        update_post_stats($mode, $post_data, $forum_id, $topic_id, $post_id, $user_id);
    }

    if (empty($error_msg) && $mode != 'editpost' && $user_id != ANONYMOUS)
    {
        // check auto-group join 
        $sql = "SELECT g.group_id FROM " . GROUPS_TABLE . " g 
                JOIN " . USERS_TABLE . " u ON u.user_id = $user_id 
                LEFT JOIN " . USER_GROUP_TABLE . " ug ON (g.group_id = ug.group_id AND ug.user_id = u.user_id) 
                WHERE g.group_count_enable = 1 
                AND g.group_count <= u.user_posts 
                AND ug.user_id IS NULL";
        if ( !($result = $db->sql_query($sql)) )
        {
            message_die(GENERAL_ERROR, 'Error geting users post stat', '', __LINE__, __FILE__, $sql);
        }
        $clear_cache = false;
        while ($group_data = $db->sql_fetchrow($result))
        {
            $sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending) 
                    VALUES (" . $group_data['group_id'] . ", $user_id, 0)";
            if ( !($db->sql_query($sql)) )
            {
                message_die(GENERAL_ERROR, 'Error insert users, group count', '', __LINE__, __FILE__, $sql);
            }
            $clear_cache = true;
        }

        if ($clear_cache)
        {
            sql_cache('clear', 'user_groups');
            sql_cache('clear', 'groups_data');
            sql_cache('clear', 'moderators_list');
        }
    }

    if (empty($error_msg))
    {
        if (defined('ATTACHMENTS_ON') && !$comment)
        {
            $attachment_mod['posting']->insert_attachment($post_id);
        }

		if ( $notify_n )
		{
			$notification_username = ($userdata['user_level'] == ANONYMOUS) ? $lang['Guest'] : $userdata['username'];
			user_notification($mode_n, $post_data_n, $forum_id_n, $topic_id_n, $post_id_n, $notify_user_n, $notification_username);
		}

		$template->assign_vars(array(
			'META' => $return_meta)
		);

		message_die(GENERAL_MESSAGE, $return_message);
	}
}

if ( $refresh || isset($HTTP_POST_VARS['del_poll_option']) || $error_msg != '' )
{
	$username  = xhtmlspecialchars(trim(stripslashes(get_vars('username', '', 'POST'))));
	$subject   = xhtmlspecialchars(trim(stripslashes(get_vars('subject', '', 'POST'))));
	$message   = xhtmlspecialchars(trim(stripslashes(get_vars('message', '', 'POST'))));
	$subject_e = xhtmlspecialchars(trim(stripslashes(get_vars('subject_e', '', 'POST'))));
	
	$poll_title = xhtmlspecialchars(trim(stripslashes(get_vars('poll_title', '', 'POST'))));
	$poll_length = ( isset($HTTP_POST_VARS['poll_length']) ) ? max(0, intval($HTTP_POST_VARS['poll_length'])) : 0;
	$max_vote = ( isset($HTTP_POST_VARS['max_vote']) ) ? max(0, intval($HTTP_POST_VARS['max_vote'])) : 0;
	$hide_vote = ( isset($HTTP_POST_VARS['hide_vote']) ) ? max(0, intval($HTTP_POST_VARS['hide_vote'])) : 0;
	$tothide_vote = ( isset($HTTP_POST_VARS['tothide_vote']) ) ? max(0, intval($HTTP_POST_VARS['tothide_vote'])) : 0;

	$poll_options = array();
	if ( !empty($HTTP_POST_VARS['poll_option_text']) )
	{
		while( list($option_id, $option_text) = @each($HTTP_POST_VARS['poll_option_text']) )
		{
			if( isset($HTTP_POST_VARS['del_poll_option'][$option_id]) )
			{
				unset($poll_options[$option_id]);
			}
			else if ( !empty($option_text) ) 
			{
				$poll_options[$option_id] = xhtmlspecialchars(trim(stripslashes($option_text)));
			}
		}
	}

	if ( isset($poll_add) && !empty($HTTP_POST_VARS['add_poll_option_text']) )
	{
		$poll_options[] = xhtmlspecialchars(trim(stripslashes($HTTP_POST_VARS['add_poll_option_text'])));
	}

	if ( $mode == 'newtopic' || $mode == 'reply')
	{
		$user_sig = ($userdata['user_sig'] != '' && $board_config['allow_sig']) ? $userdata['user_sig'] : '';
		$user_sig_image = ($userdata['user_sig_image'] != '' && $board_config['allow_sig'] && $board_config['allow_sig_image']) ? $userdata['user_sig_image'] : '';
	}
	else if ( $mode == 'editpost' )
	{
		$user_sig = ($post_info['user_sig'] != '' && $board_config['allow_sig']) ? $post_info['user_sig'] : '';
		$userdata['user_sig_bbcode_uid'] = $post_info['user_sig_bbcode_uid'];
		$user_sig_image = ($post_info['user_sig_image'] != '' && $board_config['allow_sig'] && $board_config['allow_sig_image']) ? $post_info['user_sig_image'] : '';
	}

	$check0 = ($msg_expire == '0' || $HTTP_POST_VARS['msg_expire'] == '0') ? $selected : '';
	$check1 = ($msg_expire == '1' || $HTTP_POST_VARS['msg_expire'] == '1') ? $selected : '';
	$check2 = ($msg_expire == '2' || $HTTP_POST_VARS['msg_expire'] == '2') ? $selected : '';
	$check3 = ($msg_expire == '3' || $HTTP_POST_VARS['msg_expire'] == '3') ? $selected : '';
	$check4 = ($msg_expire == '4' || $HTTP_POST_VARS['msg_expire'] == '4') ? $selected : '';
	$check5 = ($msg_expire == '5' || $HTTP_POST_VARS['msg_expire'] == '5') ? $selected : '';
	$check6 = ($msg_expire == '6' || $HTTP_POST_VARS['msg_expire'] == '6') ? $selected : '';
	$check7 = ($msg_expire == '7' || $HTTP_POST_VARS['msg_expire'] == '7') ? $selected : '';
	$check14 = ($msg_expire == '14' || $HTTP_POST_VARS['msg_expire'] == '14') ? $selected : '';
	$check30 = ($msg_expire == '30' || $HTTP_POST_VARS['msg_expire'] == '30') ? $selected : '';
	$check90 = ($msg_expire == '90' || $HTTP_POST_VARS['msg_expire'] == '90') ? $selected : '';

	if ( $preview )
	{
		$orig_word = array();
		$replacement_word = array();
		$replacement_word_html = array();
		obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

		$bbcode_uid = ($bbcode_on) ? make_bbcode_uid() : '';
		$preview_message = stripslashes(prepare_message(addslashes(unprepare_message($message)), $html_on, $bbcode_on, $smilies_on, $bbcode_uid, $forum_id));
		$preview_subject = $subject;
		if ( $submit_topic_tag )
		{
			$preview_subject = $submit_topic_tag . ' ' . $subject;
			$topic_tag = str_replace(array('[', ']'), '', $submit_topic_tag);
		}
		$preview_subject_e = $subject_e;
		$preview_username = $username;

		$user_sig = ($userdata['user_allow_signature'] && $userdata['user_allowsig']) ? $user_sig : '';
		$user_sig_image = ($userdata['user_allow_sig_image'] && $userdata['user_allowsig']) ? $user_sig_image : '';

		//
		// Finalise processing as per viewtopic
		//

		$show_post_html = ($board_config['allow_html'] && $userdata['user_allowhtml']) ? true : false;
		if ( (($is_mod_forum && $board_config['mod_html']) || ($board_config['admin_html'] && $userdata['user_level'] == ADMIN) || ($board_config['jr_admin_html'] && $is_jr_admin)) && $userdata['user_allowhtml'] )
		{
			$show_post_html = true;
		}

		if ( !$show_post_html || !$html_on || $HTTP_POST_VARS['disable_html'] )
		{
			$preview_message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $preview_message);
		}

		if ( !$show_post_html && $user_sig != '' )
		{
			$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
		}

		$strip_br = ($show_post_html && (strpos($preview_message, '<td>') !== false || strpos($preview_message, '<tr>') !== false || strpos($preview_message, '<table>') !== false)) ? true : false;

		$preview_message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "<br /><u><b>Mod Info:</u><br />[</b>\\1<b>]</b><br />", $preview_message);

		if ( $attach_sig && $user_sig != '' && $userdata['user_sig_bbcode_uid'] )
		{
			$user_sig = bbencode_second_pass($user_sig, $userdata['user_sig_bbcode_uid'], $userdata['username']);
			$user_sig = bbencode_third_pass($user_sig, $userdata['user_sig_bbcode_uid'], true);
		}
		if ( $bbcode_on )
		{
			$preview_message = bbencode_second_pass($preview_message, $bbcode_uid, $userdata['username']);
			$preview_message = bbencode_third_pass($preview_message, $bbcode_uid, true);
		}

		if ( !empty($orig_word) )
		{
			$preview_username = (!empty($username)) ? preg_replace($orig_word, $replacement_word_html, $preview_username) : '';
			$preview_subject = (!empty($subject)) ? preg_replace($orig_word, $replacement_word_html, $preview_subject) : '';
			$preview_subject_e = (!empty($subject_e)) ? preg_replace($orig_word, $replacement_word_html, $preview_subject_e) : '';
			$preview_message = (!empty($preview_message)) ? preg_replace($orig_word, $replacement_word_html, $preview_message) : '';
		}

		if( $user_sig != '' )
		{
			$user_sig = make_clickable($user_sig);
		}
		$preview_message = make_clickable($preview_message);

		if( $smilies_on && $userdata['show_smiles'] )
		{
			if( $userdata['user_allowsmile'] && $user_sig != '' )
			{
				$user_sig = smilies_pass($user_sig);
			}

			$preview_message = smilies_pass($preview_message);
		}

		if( $attach_sig && $user_sig != '' )
		{
			$preview_message = $preview_message . '<br /><br />_________________<br />' . $user_sig;
		}
		if ( $attach_sig && $user_sig_image != '' )
		{
			$preview_message .= (($user_sig != '') ? '<br />' : '<br /><br />_________________<br />') . '<img src="' . $board_config['sig_images_path'] . '/' . $user_sig_image . '" border="0" />';
		}

		if ( !$strip_br )
		{
			$preview_message = str_replace("\n", "\n<br />\n", $preview_message);
		}

		$template->set_filenames(array(
			'preview' => 'posting_preview.tpl')
		);

		if ( defined('ATTACHMENTS_ON') && !$comment )
		{
			$attachment_mod['posting']->preview_attachments();
		}

		$template->assign_vars(array(
			'TOPIC_TITLE' => $preview_subject,
			'POST_SUBJECT' => $preview_subject . (($preview_subject_e) ? ' [' . $preview_subject_e . ']' : ''),
			'POSTER_NAME' => $preview_username,
			'POST_DATE' => create_date($board_config['default_dateformat'], CR_TIME, $board_config['board_timezone']),
			'MESSAGE' => $preview_message,
			'IMG_POST' => $images['icon_minipost'],

			'L_POST_SUBJECT' => $lang['Post_subject'],
			'L_PREVIEW' => $lang['Preview'],
			'L_POSTED' => $lang['Posted'], 
			'L_POST' => $lang['Post'])
		);

		$template->assign_var_from_handle('POST_PREVIEW_BOX', 'preview');
	}
	else if( $error_msg != '' )
	{
		$template->set_filenames(array(
			'reg_header' => 'error_body.tpl')
		);
		$template->assign_vars(array(
			'ERROR_MESSAGE' => $error_msg)
		);
		$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
	}
}
else
{
	//
	// User default entry point
	//
	if ( $mode == 'newtopic' )
	{
		$user_sig = ($userdata['user_sig'] != '') ? $userdata['user_sig'] : '';
		$user_sig_image = ($userdata['user_sig_image'] != '') ? $userdata['user_sig_image'] : '';

		$username = ($userdata['session_logged_in']) ? $userdata['username'] : '';
		$poll_title = '';
		$poll_length = '';
		$poll_length_h = '';
		$max_vote = '1';
		$hide_vote = '';
		$tothide_vote = '';
		$subject = '';
		$subject_e = '';
		$message = '';
	}
	else if ( $mode == 'reply' )
	{
		$user_sig = ($userdata['user_sig'] != '') ? $userdata['user_sig'] : '';
		$user_sig_image = ($userdata['user_sig_image'] != '') ? $userdata['user_sig_image'] : '';

		$username = ($userdata['session_logged_in']) ? $userdata['username'] : '';
		$subject = '';
		$subject_e = '';
		$message = '';

	}

	else if ( $mode == 'quote' || $mode == 'editpost' )
	{
		$subject = ( $post_data['first_post'] ) ? $post_info['topic_title'] : $post_info['post_subject'];

		if ( $tt_separate = separe_topic_tag($subject) )
		{
			$topic_tag = $tt_separate[0];
			$subject = $tt_separate[1];
		}

		$subject_e = ($post_data['first_post']) ? $post_info['topic_title_e'] : '';
		$message = (!$comment) ? $post_info['post_text'] : '';

		if ( $mode == 'editpost' )
		{
			$attach_sig = ($post_info['enable_sig'] && ($post_info['user_sig'] != '' || $post_info['user_sig_image'] != '')) ? TRUE : 0; 
			$user_sig = $post_info['user_sig'];
			$user_sig_image = $post_info['user_sig_image'];

			$html_on = ($post_info['enable_html']) ? true : false;
			$bbcode_on = ($post_info['enable_bbcode']) ? true : false;
			$smilies_on = ($post_info['enable_smilies']) ? true : false;

			switch ($post_info['post_icon'])
			{
				case 1 : $msg_icon_checked = 1; break;
				case 2 : $msg_icon_checked = 2; break;
				case 3 : $msg_icon_checked = 3; break;
				case 4 : $msg_icon_checked = 4; break;
				case 5 : $msg_icon_checked = 5; break;
				case 6 : $msg_icon_checked = 6; break;
				case 7 : $msg_icon_checked = 7; break;
				case 8 : $msg_icon_checked = 8; break;
				case 9 : $msg_icon_checked = 9; break;
				case 10 : $msg_icon_checked = 10; break;
				case 11 : $msg_icon_checked = 11; break;
				case 12 : $msg_icon_checked = 12; break;
				default : $msg_icon_checked = 0; break;
			}

			$check0 = $check1 = $check2 = $check3 = $check4 = $check5 = $check6 = $check7 = $check14 = $check30 = $check90 = '';
			if ( $post_info['post_expire'] )
			{
				$pe = $post_info['post_expire'] - (CR_TIME - $post_info['post_time']);
				if ($pe < 86400) $check1 = $selected;
				else if ($pe < 172800) $check2 = $selected;
				else if ($pe < 259200) $check3 = $selected;
				else if ($pe < 345600) $check4 = $selected;
				else if ($pe < 432000) $check5 = $selected;
				else if ($pe < 518400) $check6 = $selected;
				else if ($pe < 604800) $check7 = $selected;
				else if ($pe < 1209600) $check14 = $selected;
				else if ($pe < 2592000) $check30 = $selected;
				else if ($pe < 7776000) $check90 = $selected;
			}
			else
			{
				$check0 = $selected;
			}
		}
		else
		{
			$attach_sig = ($userdata['user_attachsig']) ? TRUE : 0;
			$user_sig = $userdata['user_sig'];
			$user_sig_image = $userdata['user_sig_image'];
		}

		if ( $post_info['bbcode_uid'] != '' )
		{
			$message = preg_replace('/\:(([a-z0-9]:)?)' . $post_info['bbcode_uid'] . '/s', '', $message);
		}

		$message = str_replace('<', '&lt;', $message);
		$message = str_replace('>', '&gt;', $message);
		$message = str_replace('<br />', "\n", $message);

		if ( $mode == 'quote' )
		{
			$orig_word = array();
			$replace_word = array();
			$replacement_word_html = array();
			obtain_word_list($orig_word, $replace_word, $replacement_word_html);

			$quote_username = (trim($post_info['post_username']) != '') ? $post_info['post_username'] : $post_info['username'];
			$message = '[quote="' . $quote_username . '"]' . $message . '[/quote]';
			$message = preg_replace("/(?<!;)(\[img\](.+?)\[\/img\])/s","[url=\\2]$lang[quote_image][/url]", $message);
			if ( !$post_info['post_approve'] )
			{
				$message = $subject = $post_info['post_approve'];
			}

			if ( !empty($orig_word) )
			{
				$subject = ( !empty($subject) ) ? preg_replace($orig_word, $replace_word, $subject) : '';
				$message = ( !empty($message) ) ? preg_replace($orig_word, $replace_word, $message) : '';
			}

			if ( $userdata['user_level'] != ADMIN && !$is_jr_admin && !$is_auth['auth_mod'] )
			{
				$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "", $message);
			}

			if ( !preg_match('/^Re:/', $subject) && strlen($subject) > 0 )
			{
				if ( $tt_separate = separe_topic_tag($subject) )
				{
					$subject = $tt_separate[1];
				}

				$subject = 'Re: ' . $subject;
			}
			if ( !$userdata['session_logged_in'] )
			{
				$message = hide_in_quote($message);
			}
			else
			{
				$sql = "SELECT poster_id, topic_id
					FROM " . POSTS_TABLE . "
					WHERE topic_id = $topic_id
						AND poster_id = " . $userdata['user_id'];
				$resultat = $db->sql_query($sql);

				if (!$db->sql_numrows($resultat))
				{
					$message = hide_in_quote($message);
				}
			}
			$mode = 'reply';
		}
		else
		{
			$username = ( $post_info['user_id'] == ANONYMOUS && !empty($post_info['post_username']) ) ? $post_info['post_username'] : '';
		}
	}
}

//
// Signature toggle selection
//
if ( $user_sig != '' || $user_sig_image != '' && !$comment )
{
	$template->assign_block_vars('switch_signature_checkbox', array());
}

if ( $board_config['post_icon'] && !$comment && $userdata['post_icon'] )
{
	$template->assign_block_vars('switch_msgicon_checkbox', array());
}

$rep = $images['rank_path'] . 'icon';
$dir = opendir($rep);
$i = 0;
$icons_value = 0;
while($file = readdir($dir))
{
	if (strpos($file, '.gif'))
	{
		$i++;
		$icons_value++;
	}
}
closedir($dir);

$class_more_icons = 'gensmall';
if ( $board_config['post_icon'] && $icons_value > 12 && !$comment && $userdata['post_icon'] )
{
	$template->assign_block_vars('switch_msgicon_checkbox.more_icons', array());
	$class_more_icons = 'copyright';
}

//
// HTML toggle selection
//
if ( $show_html )
{
	$html_status = $lang['HTML_is_ON'];
	$template->assign_block_vars('switch_html_checkbox', array());
}
else
{
	$html_status = $lang['HTML_is_OFF'];
}

//
// Smilies toggle selection
//
if ( $board_config['allow_smilies'] )
{
	$smilies_status = $lang['Smilies_are_ON'];
	if ( !$comment )
	{
		$template->assign_block_vars('switch_smilies_checkbox', array());
	}
}
else
{
	$smilies_status = $lang['Smilies_are_OFF'];
}

if ( !$userdata['session_logged_in'] || ( $mode == 'editpost' && $post_info['poster_id'] == ANONYMOUS ) )
{
	$template->assign_block_vars('switch_username_select', array());
}

//
// Notify checkbox - only show if user is logged in
//
if ( $userdata['session_logged_in'] && $is_auth['auth_read'] && !$comment )
{
	if ( $mode != 'editpost' || ( $mode == 'editpost' && $post_info['poster_id'] != ANONYMOUS ) )
	{
		$template->assign_block_vars('switch_notify_checkbox', array());
	}
}

//
// Delete selection
//
if ( $mode == 'editpost' && ( ( $is_auth['auth_delete'] && $post_data['last_post'] && ( !$post_data['has_poll'] || $post_data['edit_poll'] ) ) || $is_auth['auth_mod'] ) && !$comment )
{
	$template->assign_block_vars('switch_delete_checkbox', array());
}

// Lock/Unlock topic selection
if ( ( $mode == 'editpost' || $mode == 'reply' || $mode == 'quote' || $mode == 'newtopic' ) && $is_auth['auth_mod'] && !$comment )
{
	if ( $post_info['topic_status'] == TOPIC_LOCKED )
	{
		$template->assign_block_vars('switch_unlock_topic', array());

		$template->assign_vars(array(
			'L_UNLOCK_TOPIC' => $lang['Unlock_topic'],
			'S_UNLOCK_CHECKED' => ($unlock) ? 'checked="checked"' : '')
		);
	}
	else if ( $post_info['topic_status'] == TOPIC_UNLOCKED )
	{
		$template->assign_block_vars('switch_lock_topic', array());
		
		$template->assign_vars(array(
			'L_LOCK_TOPIC' => $lang['Lock_topic'],
			'S_LOCK_CHECKED' => ($lock) ? 'checked="checked"' : '')
		);
	}
}

if ( $board_config['split_messages'] && !$comment )
{
	$show_nosplit = false;
	if ( $userdata['user_level'] == ADMIN || $is_jr_admin )
	{
		$show_nosplit = ($board_config['split_messages_admin']) ? true : false;
	}
	else if ( $is_mod_forum )
	{
		$show_nosplit = ($board_config['split_messages_mod']) ? true : false;
	}
	$show_nosplit = ( $post_info['forum_no_split'] || !$show_nosplit ) ? false : true;

	if ( $show_nosplit )
	{
		$template->assign_block_vars('switch_no_split_post', array());
		
		$template->assign_vars(array(
			'L_NO_SPLIT_POST' => $lang['No_split_post'])
		);
	}
}

//
// Topic type selection
//
$topic_type_toggle = '';
if ( $mode == 'newtopic' || ( $mode == 'editpost' && $post_data['first_post'] ) )
{
	if ( !$comment )
	{
		$template->assign_block_vars('switch_type_toggle', array());
	}

	if( $is_auth['auth_sticky'] )
	{
		$topic_type_toggle .= '<input type="radio" name="topictype" value="' . POST_STICKY . '"';
		if ( (($post_data['topic_type'] == POST_STICKY || $topic_type == POST_STICKY) && !isset($HTTP_POST_VARS['topictype'])) || $HTTP_POST_VARS['topictype'] == POST_STICKY )
		{
			$topic_type_toggle .= ' checked="checked"';
		}
		$topic_type_toggle .= ' /> ' . $lang['Post_Sticky'] . '&nbsp;&nbsp;';
	}

	if( $is_auth['auth_announce'] )
	{
		$topic_type_toggle .= '<input type="radio" name="topictype" value="' . POST_ANNOUNCE . '"';
		if ( (($post_data['topic_type'] == POST_ANNOUNCE || $topic_type == POST_ANNOUNCE) && !isset($HTTP_POST_VARS['topictype'])) || $HTTP_POST_VARS['topictype'] == POST_ANNOUNCE )
		{
			$topic_type_toggle .= ' checked="checked"';
		}
		$topic_type_toggle .= ' /> ' . $lang['Post_Announcement'] . '&nbsp;&nbsp;';
	}
	if ( $is_auth['auth_globalannounce'] )
	{
		$topic_type_toggle .= '<input type="radio" name="topictype" value="' . POST_GLOBAL_ANNOUNCE . '"';
		if ( (($post_data['topic_type'] == POST_GLOBAL_ANNOUNCE || $topic_type == POST_GLOBAL_ANNOUNCE) && !isset($HTTP_POST_VARS['topictype'])) || $HTTP_POST_VARS['topictype'] == POST_GLOBAL_ANNOUNCE )
		{
			$topic_type_toggle .= ' checked="checked"';
		}
		$topic_type_toggle .= ' /> ' . $lang['Post_global_announcement'] . '&nbsp;&nbsp;';
	}

	if ( $topic_type_toggle != '' )
	{
		$topic_type_toggle = $lang['Post_topic_as'] . ': <input type="radio" name="topictype" value="' . POST_NORMAL .'"' . ( ( (($post_data['topic_type'] == POST_NORMAL || $topic_type == POST_NORMAL) && !isset($HTTP_POST_VARS['topictype'])) || $HTTP_POST_VARS['topictype'] == POST_NORMAL ) ? ' checked="checked"' : '' ) . ' /> ' . $lang['Post_Normal'] . '&nbsp;&nbsp;' . $topic_type_toggle;
	}
}

$hidden_form_fields = '<input type="hidden" name="mode" value="' . $mode . '" />';
$hidden_form_fields .= ($comment) ? '<input type="hidden" name="comment" value="1" />' : '';
$hidden_form_fields .= '<input type="hidden" name="post_parent" value="' . $post_parent . '" />';
$hidden_form_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$hidden_form_fields .= '<input type="hidden" name="przemo_hash" value="' . przemo_create_hash() . '" />';

switch( $mode )
{
	case 'newtopic':
		$page_title = $lang['Post_a_new_topic'];
		$hidden_form_fields .= '<input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';
		break;

	case 'reply':
		$page_title = $lang['Post_a_reply'];
		$hidden_form_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
		break;

	case 'editpost':
		$page_title = ($comment) ? $lang['Comment_post'] : $lang['Edit_Post'];
		$hidden_form_fields .= '<input type="hidden" name="' . POST_POST_URL . '" value="' . $post_id . '" />';
		break;
}

// Generate smilies listing for page output
generate_smilies('inline', PAGE_POSTING);

//
// Include page header
//
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'posting_body.tpl', 
	'pollbody' => 'posting_poll_body.tpl', 
	'reviewbody' => 'posting_topic_review.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'FORUM_NAME' => $forum_name,
	'L_POST_A' => $page_title,
	'L_POST_SUBJECT' => $lang['Post_subject'], 

	'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"))
);

//
// This enables the forum/topic title to be output for posting
// but not for privmsg (where it makes no sense)
//
$template->assign_block_vars('switch_not_privmsg', array());

$u_index_check = append_sid('index.'.$phpEx);

disallow_forums($userdata, $forum_id);

if ( $user_can_use_bbcode )
{
	$bbcode_status = $lang['BBCode_is_ON'];
}
else
{
	$bbcode_status = $lang['BBCode_is_OFF'];
}

if ( !$HTTP_POST_VARS['disable_html'] )
{
	$s_html_checked = (($html_on && $mode == 'editpost') || ($preview && !isset($HTTP_POST_VARS['disable_html'])) ) ? '' : 'checked="checked"';
}
else
{
	$s_html_checked = 'checked="checked"';
}

//
// Output the data to the template
//
$template->assign_vars(array(
	'L_SUBJECT' => $lang['Subject'],
	'L_SUBJECT_E' => $lang['Subject_e'],
	'L_SUBJECT_E_INFO' => $lang['Subject_e_info'],
	'L_MESSAGE_BODY' => $lang['Message_body'],
	'L_OPTIONS' => $lang['Options'],
	'L_PREVIEW' => $lang['Preview'],
	'L_SUBMIT' => $lang['Submit'],
	'L_CANCEL' => $lang['Cancel'],
	'L_CONFIRM_DELETE' => $lang['Confirm_delete'],
	'L_DISABLE_HTML' => $lang['Disable_HTML_post'],
	'L_DISABLE_BBCODE' => $lang['Disable_BBCode_post'],
	'L_DISABLE_SMILIES' => $lang['Disable_Smilies_post'],
	'L_ATTACH_SIGNATURE' => $lang['Attach_signature'],
	'L_NOTIFY_ON_REPLY' => $lang['Notify'],
	'L_DELETE_POST' => $lang['Delete_post'],
	'L_MSG_ICON_NO_ICON' => $lang['Msg_Icon_No_Icon'],
	'L_MORE_SMILIES' => $lang['More_emoticons'],
	'L_MORE_TOPICICONS' => $lang['more_topicicons'],

	'L_COLOR_DEFAULT' => $lang['color_default'],
	'L_COLOR_DARK_RED' => $lang['color_dark_red'],
	'L_COLOR_RED' => $lang['color_red'],
	'L_COLOR_ORANGE' => $lang['color_orange'],
	'L_COLOR_BROWN' => $lang['color_brown'],
	'L_COLOR_YELLOW' => $lang['color_yellow'],
	'L_COLOR_GREEN' => $lang['color_green'],
	'L_COLOR_OLIVE' => $lang['color_olive'],
	'L_COLOR_CYAN' => $lang['color_cyan'],
	'L_COLOR_BLUE' => $lang['color_blue'],
	'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
	'L_COLOR_INDIGO' => $lang['color_indigo'],
	'L_COLOR_VIOLET' => $lang['color_violet'],
	'L_COLOR_WHITE' => $lang['color_white'],
	'L_COLOR_BLACK' => $lang['color_black'],
	'L_FONT_COLOR' => $lang['Font_color'],

	'FONTCOLOR_1' => $theme['fontcolor1'],
	'U_INDEX' => $u_index_check,
	'USERNAME' => $username,
	'SUBJECT' => $subject,
	'SUBJECT_E' => $subject_e,
	'MESSAGE' => $message,
	'HTML_STATUS' => $html_status,
	'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
	'SMILIES_STATUS' => $smilies_status,
	'U_MORE_ICONS' => append_sid("posting.$phpEx?mode=icons"),
	'IMG_ADDR' => $lang['img_address'],
	'CSMILES_OFF1' => (!$board_config['allow_smilies'] || !$userdata['show_smiles']) ? '<!--' : '',
	'CSMILES_OFF2' => (!$board_config['allow_smilies'] || !$userdata['show_smiles']) ? '-->' : '',
	'U_VIEWTOPIC' => ($mode == 'reply') ? append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postorder=desc") : '',
	'U_REVIEW_TOPIC' => ($mode == 'reply') ? append_sid("posting.$phpEx?mode=topicreview&amp;" . POST_TOPIC_URL . "=$topic_id") : '',
	'ICON_PATH' => $images['rank_path'],
	'MESSAGEICON' => $lang['postmsgicon'],
	'MSG_ICON_CHECKED0' => ($msg_icon_checked == 0) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED1' => ($msg_icon_checked == 1) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED2' => ($msg_icon_checked == 2) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED3' => ($msg_icon_checked == 3) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED4' => ($msg_icon_checked == 4) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED5' => ($msg_icon_checked == 5) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED6' => ($msg_icon_checked == 6) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED7' => ($msg_icon_checked == 7) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED8' => ($msg_icon_checked == 8) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED9' => ($msg_icon_checked == 9) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED10' => ($msg_icon_checked == 10) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED11' => ($msg_icon_checked == 11) ? 'checked="checked"' : '',
	'MSG_ICON_CHECKED12' => ($msg_icon_checked == 12) ? 'checked="checked"' : '',
	'MORE_ICON_CHECK' => ($post_info['post_icon'] > 10) ? $post_info['post_icon'] : '',
	'CLASS_MORE_ICONS' => $class_more_icons,
	'S_HTML_CHECKED' => $s_html_checked,
	'S_BBCODE_CHECKED' => (!$bbcode_on) ? 'checked="checked"' : '',
	'S_SMILIES_CHECKED' => (!$smilies_on || $HTTP_POST_VARS['disable_smilies']) ? 'checked="checked"' : '',
	'S_SIGNATURE_CHECKED' => ( $attach_sig) ? 'checked="checked"' : '',
	'S_NOTIFY_CHECKED' => ($notify_user || $HTTP_POST_VARS['notify']) ? 'checked="checked"' : '',
	'S_SPLIT_CHECKED' => (isset($HTTP_POST_VARS['nosplit'])) ? 'checked="checked"' : '',
	'S_TYPE_TOGGLE' => $topic_type_toggle,
	'S_TOPIC_ID' => $topic_id,
	'S_POST_ACTION' => append_sid("posting.$phpEx"),
	'S_HIDDEN_FORM_FIELDS' => $hidden_form_fields)
);

if ( $user_can_use_bbcode )
{
	$template->assign_vars(array(
	'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
	'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
	'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
	'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
	'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
	'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
	'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
	'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
	'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
	'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
	'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
	'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
	'L_BBCODE_E_HELP' => $lang['bbcode_e_help'],
	'L_BBCODE_K_HELP' => $lang['bbcode_k_help'],
	'L_BBCODE_R_HELP' => $lang['bbcode_r_help'],
	'L_BBCODE_Y_HELP' => $lang['bbcode_y_help'],
	'L_BBCODE_S2_HELP' => $lang['bbcode_s2_help'],
	'L_BBCODE_G_HELP' => $lang['bbcode_g_help'],
	'L_BBCODE_H_HELP' => $lang['bbcode_h_help'],
	'L_BBCODE_CT_HELP' => $lang['bbcode_ct_help'],
	'L_STYLES_TIP' => $lang['Styles_tip'],
	'L_WRITE_LINK_TEXT' => $lang['write_link_text'],
	'L_WRITE_ADDRESS' => $lang['write_address'],

	'CLOSE_ALL' => '<input type="button" class="button" name="addbbcode-1" value="' . $lang['Close_Tags'] . '" style="width: 84px;  text-indent: -2px;" onClick="bbstyle(-1)" onMouseOver="helpline(\'a\')" />',
	'BUTTON_B' => ($board_config['button_b']) ? '<input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline(\'b\')" /> ' : '',
	'BUTTON_I' => ($board_config['button_i']) ? '<input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline(\'i\')" /> ' : '',
	'BUTTON_U' => ($board_config['button_u']) ? '<input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline(\'u\')" /> ' : '',
	'BUTTON_Q' => ($board_config['button_q']) ? '<input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline(\'q\')" /> ' : '',
	'BUTTON_C' => ($board_config['button_c']) ? '<input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px; text-indent: -2px;" onClick="bbstyle(8)" onMouseOver="helpline(\'c\')" /> ' : '',
	'BUTTON_L' => ($board_config['button_l']) ? '<input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline(\'l\')" /> ' : '',
	'BUTTON_IM' => ($board_config['button_im']) ? '<input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px" onclick="imgcode(this.form,\'img\',\'http://\')" onMouseOver="helpline(\'p\')" /> ' : '',
	'BUTTON_CE' => ($board_config['button_ce']) ? '<input type="button" class="button" accesskey="y" name="addbbcode26" value=" Center " style="width: 60px" onClick="bbstyle(26)" onMouseOver="helpline(\'y\')" /> ' : '',
	'BUTTON_F' => ($board_config['button_f']) ? '<input type="button" class="button" accesskey="e" name="addbbcode20" value="Fade" style="width: 40px; text-indent: -2px;" onClick="bbstyle(20)" onMouseOver="helpline(\'e\')" /> ' : '',
	'BUTTON_S' => ($board_config['button_s']) ? '<input type="button" class="button" accesskey="k" name="addbbcode22" value="Scroll" style="width: 40px; text-indent: -2px;" onClick="bbstyle(22)" onMouseOver="helpline(\'k\')" /> ' : '',
	'BUTTON_HI' => ($board_config['button_hi']) ? '<input type="button" class="button" accesskey="h" name="addbbcode28" value="Hide" style="width: 40px" onClick="bbstyle(28)" onMouseOver="helpline(\'h\')" />' : '',
	'STREAM_ADDR' => $lang['stream_address'])
	);

	if ( $board_config['button_ur'] )
	{
		$template->assign_block_vars('button_ur', array());
	}

	if ( $board_config['color_box'] )
	{
		$template->assign_block_vars('color_box', array());
	}

	if ( $board_config['glow_box'] )
	{
		$template->assign_block_vars('glow_box', array(
			'L_SHADOW_COLOR' => $lang['Shadow_color'],
			'L_GLOW_COLOR' => $lang['Glow_color'])
		);
	}

	if ( $board_config['size_box'] )
	{
		$template->assign_block_vars('size_box', array(
			'L_FONT_SIZE' => $lang['Font_size'],
			'L_FONT_TINY' => $lang['font_tiny'],
			'L_FONT_SMALL' => $lang['font_small'],
			'L_FONT_NORMAL' => $lang['font_normal'],
			'L_FONT_LARGE' => $lang['font_large'],
			'L_FONT_HUGE' => $lang['font_huge'])
		);
	}

	if ( $board_config['freak'] )
	{
		$template->assign_block_vars('freak', array(
			'L_FREAK_UNDO' => $lang['Freak_undo'])
		);
	}

	if ( !$comment )
	{
		$template->assign_block_vars('switch_bbcode_checkbox', array());
	}
}
else
{
	$template->assign_vars(array(
		'CBBCODE_OFF1' => '<!--',
		'CBBCODE_OFF2' => '-->',
		)
	);
}

if ( $mode != 'reply'&& $mode != 'quote' && $post_data['first_post'] && $board_config['title_explain'] && !$comment )
{
	$template->assign_block_vars('topic_explain', array());
}

if ( $board_config['topic_color'] && $userdata['can_topic_color'] && ( $mode == 'newtopic' || ( $mode == 'editpost' && $post_data['first_post'] ) ) && !$comment )
{
	if ( $board_config['topic_color_all'] || $userdata['user_level'] == ADMIN || ($is_auth['auth_mod'] && $board_config['topic_color_mod']) )
	{
		$template->assign_block_vars('topic_color', array(
			'L_TOPIC_COLOR' => $lang['topic_color'],

			'TCOL_EMPTY' => ($post_info['topic_color'] == '') ? $selected : '',
			'TCOL_DARKRED' => ($post_info['topic_color'] == 'darkred' || $HTTP_POST_VARS['topic_color'] == 'darkred') ? $selected : '',
			'TCOL_RED' => ($post_info['topic_color'] == 'red' || $HTTP_POST_VARS['topic_color'] == 'red') ? $selected : '',
			'TCOL_ORANGE' => ($post_info['topic_color'] == 'orange' || $HTTP_POST_VARS['topic_color'] == 'orange') ? $selected : '',
			'TCOL_BROWN' => ($post_info['topic_color'] == 'brown' || $HTTP_POST_VARS['topic_color'] == 'brown') ? $selected : '',
			'TCOL_YELLOW' => ($post_info['topic_color'] == 'yellow' || $HTTP_POST_VARS['topic_color'] == 'yellow') ? $selected : '',
			'TCOL_GREEN' => ($post_info['topic_color'] == 'green' || $HTTP_POST_VARS['topic_color'] == 'green') ? $selected : '',
			'TCOL_OLIVE' => ($post_info['topic_color'] == 'olive' || $HTTP_POST_VARS['topic_color'] == 'olive') ? $selected : '',
			'TCOL_CYAN' => ($post_info['topic_color'] == 'cyan' || $HTTP_POST_VARS['topic_color'] == 'cyan') ? $selected : '',
			'TCOL_BLUE' => ($post_info['topic_color'] == 'blue' || $HTTP_POST_VARS['topic_color'] == 'blue') ? $selected : '',
			'TCOL_DARKBLUE' => ($post_info['topic_color'] == 'darkblue' || $HTTP_POST_VARS['topic_color'] == 'darkblue') ? $selected : '',
			'TCOL_INDIGO' => ($post_info['topic_color'] == 'indigo' || $HTTP_POST_VARS['topic_color'] == 'indigo') ? $selected : '',
			'TCOL_VIOLET' => ($post_info['topic_color'] == 'violet' || $HTTP_POST_VARS['topic_color'] == 'violet') ? $selected : '',
			'TCOL_WHITE' => ($post_info['topic_color'] == 'white' || $HTTP_POST_VARS['topic_color'] == 'white') ? $selected : '',
			'TCOL_BLACK' => ($post_info['topic_color'] == 'black' || $HTTP_POST_VARS['topic_color'] == 'black') ? $selected : '')
		);
	}
}

if ( strpos($post_info['topic_tags'], ',') && $mode != 'quote' && $mode != 'reply' )
{
	$template->assign_block_vars('topic_tags', array());

	$topic_tags_ary = @explode(',', $post_info['topic_tags']);
	$topic_tags_options = '<option value="">--</option>';

	for($i = 0; $i < count($topic_tags_ary); $i++)
	{
		if ( $topic_tags_ary[$i] )
		{
			$tt_selected = ' selected="selected"';
			$topic_tags_options .= '<option value="' . $topic_tags_ary[$i] . '"' . (($topic_tag == $topic_tags_ary[$i] || $HTTP_POST_VARS['topic_tag'] == $topic_tags_ary[$i]) ? ' selected="selected"' : '') . '>[' . $topic_tags_ary[$i] . ']</option>';
		}
	}

	$template->assign_vars(array('TOPIC_TAGS_OPTIONS' => $topic_tags_options));
}

if ( (($mode == 'newtopic' || ($mode == 'editpost' && $post_info['topic_first_post_id'] == $post_id)) && $is_auth['auth_mod']) && $post_info['forum_tree_grade'] && !$comment )
{
	if ( $mode == 'newtopic' && $post_info['forum_tree_req'] )
	{
		$tree_width = $default_tree_width;
	}
	else
	{
		$tree_width = $post_info['topic_tree_width'];
	}
	$template->assign_block_vars('tree_width', array(
		'L_TREE_WIDTH' => $lang['Tree_width_topic'],
		'TREE_WIDTH' => ($tree_width) ? $tree_width : '')
	);
}

if ( $board_config['expire'] && !$comment )
{
	$template->assign_block_vars('expire_box', array(
		'L_EXPIRE_P' => $lang['l_expire_p'],
		'L_EXPIRE_PE' => $lang['l_expire_p_e'],
		'L_EXPIRE_UNLIMIT' => $lang['expire_unlimit'],
		'L_1_DAY' => $lang['1_Day'],
		'L_2_DAYS' => $lang['2_Days'],
		'L_3_DAYS' => $lang['3_Days'],
		'L_4_DAYS' => $lang['4_Days'],
		'L_5_DAYS' => $lang['5_Days'],
		'L_6_DAYS' => $lang['6_Days'],
		'L_7_DAYS' => $lang['7_Days'],
		'L_2_WEEKS' => $lang['2_Weeks'],
		'L_1_MONTH' => $lang['1_Month'],
		'L_3_MONTHS' => $lang['3_Months'],

		'CHECK_0' => $check0,
		'CHECK_1' => $check1,
		'CHECK_2' => $check2,
		'CHECK_3' => $check3,
		'CHECK_4' => $check4,
		'CHECK_5' => $check5,
		'CHECK_6' => $check6,
		'CHECK_7' => $check7,
		'CHECK_14' => $check14,
		'CHECK_30' => $check30,
		'CHECK_90' => $check90,
	));
}

$symbols = array('&micro','&Omega;','&Pi;','&phi;','&Delta;','&Theta;','&Lambda;','&Sigma;','&Phi;','&Psi;','&alpha;','&beta;','&chi;','&tau;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&psi;','&theta;','&lambda;','&xi;','&rho;','&sigma;','&omega;','&kappa;','&Gamma;','&clubs;','&hearts;','&oslash;','&sect;','&copy;','&reg;','&bull;','&trade;','&deg;','&laquo;','&raquo;','&le;','&ge;','&sup3;','&sup2;','&frac12;','&frac14;','&frac34;','&plusmn;','&divide;','&times;','&radic;','&infin;','&int;','&asymp;','&ne;','&equiv;','&asymp;','&larr;','&rarr;','&uarr;','&darr;','&harr;','&euro;','&pound;','&yen;','&cent;','&fnof;');

for($i = 0; $i < count($symbols); $i++)
{
	$tr_symbol_begin = $tr_symbol_end = '';
	if ( ($i / 11 == 1) || ($i / 11 == 2) || ($i / 11 == 3) || ($i / 11 == 4) || ($i / 11 == 5) || ($i / 11 == 6) || ($i / 11 == 7) )
	{
		$tr_symbol_begin = '<tr align="center" valign="middle">';
	}
	if ( ($i+1 / 11 == 1) || ($i+1 / 11 == 2) || ($i+1 / 11 == 3) || ($i+1 / 11 == 4) || ($i+1 / 11 == 5) || ($i+1 / 11 == 6) || ($i+1 / 11 == 7) )
	{
		$tr_symbol_end = '</tr>';
	}
	$template->assign_block_vars('symbols', array(
		'TR_SYMBOL_BEGIN' => $tr_symbol_begin,
		'TR_SYMBOL_END' => $tr_symbol_end,
		'SYMBOL' => $symbols[$i])
	);
}

//
// Poll entry switch/output
//
if( ( $mode == 'newtopic' || ( $mode == 'editpost' && $post_data['edit_poll']) ) && $is_auth['auth_pollcreate'] && !$comment )
{
	$template->assign_vars(array(
		'L_ADD_A_POLL' => $lang['Add_poll'],
		'L_ADD_POLL_EXPLAIN' => $lang['Add_poll_explain'],
		'L_POLL_QUESTION' => $lang['Poll_question'],
		'L_POLL_OPTION' => $lang['Poll_option'],
		'L_ADD_OPTION' => $lang['Add_option'],
		'L_UPDATE_OPTION' => $lang['Update'],
		'L_DELETE_OPTION' => $lang['Delete'],
		'L_POLL_LENGTH' => $lang['Poll_for'],
		'L_MAX_VOTE' => $lang['Max_vote'],
		'L_MAX_VOTE_EXPLAIN' => $lang['Max_vote_explain'],
		'L_MAX_VOTING_1_EXPLAIN' => $lang['Max_voting_1_explain'],
		'L_MAX_VOTING_2_EXPLAIN' => $lang['Max_voting_2_explain'],
		'L_MAX_VOTING_3_EXPLAIN' => $lang['Max_voting_3_explain'],
		'L_HIDE_VOTE' => $lang['Hide_vote'],
		'L_TOTHIDE_VOTE' => $lang['Tothide_vote'],
		'L_HIDE_VOTE_EXPLAIN' => $lang['Hide_vote_explain'],
		'L_HOURS' => $lang['Hours'],
		'L_DAYS' => $lang['Days'],
		'L_POLL_LENGTH_EXPLAIN' => $lang['Poll_for_explain'],
		'L_POLL_DELETE' => $lang['Delete_poll'],
		
		'POLL_TITLE' => $poll_title,
		'HIDE_VOTE' => ($hide_vote || $HTTP_POST_VARS['hide_vote']) ? 'checked="checked"' : '',
		'TOTHIDE_VOTE' => ($tothide_vote || $HTTP_POST_VARS['tothide_vote']) ? 'checked="checked"' : '',
		'POLL_LENGTH_H' => $poll_length_h,
		'MAX_VOTE' => $max_vote,
		'POLL_LENGTH' => $poll_length)
	);

	if( $mode == 'editpost' && $post_data['edit_poll'] && $post_data['has_poll'] && !$comment)
	{
		$template->assign_block_vars('switch_poll_delete_toggle', array());
	}

	if( !empty($poll_options) && !$comment )
	{
		while( list($option_id, $option_text) = each($poll_options) )
		{
			$template->assign_block_vars('poll_option_rows', array(
				'POLL_OPTION' => str_replace('"', '&quot;', $option_text),

				'S_POLL_OPTION_NUM' => $option_id)
			);
		}
	}

	$template->assign_var_from_handle('POLLBOX', 'pollbody');
}

//
// Topic review
//
if( $mode == 'reply' && $board_config['topic_preview'] && $is_auth['auth_read'])
{
	$template->assign_block_vars('switch_inline_mode', array());
	$template->assign_var_from_handle('TOPIC_REVIEW_BOX', 'reviewbody');
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>