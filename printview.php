<?php
/***************************************************************************
 *                 printview.php
 *                 -------------------
 *  begin          : 11, 12, 2005
 *  copyright      : (C) 2005 Przemo www.przemo.org/phpBB2/
 *  email          : przemo@przemo.org
 *  version        : ver. 1.12.0 2005/12/11 19:12
 *
 ***************************************************************************/

/***************************************************************************
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, 0);
init_userprefs($userdata);
// End session management

if ( $board_config['login_require'] && !$userdata['session_logged_in'] )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) )
{
	$topic_id = intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else if ( isset($HTTP_GET_VARS['topic']) )
{
	$topic_id = intval($HTTP_GET_VARS['topic']);
}
else
{
	$topic_id = 0;
}

if ( !$topic_id )
{
	message_die(GENERAL_MESSAGE, 'No_such_post');
}

$template->set_filenames(array(
	'body' => 'viewtopic_print.tpl')
);

$sql = "SELECT t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_poster, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.forum_moderate, f.password, p.post_approve as topic_approve
	FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p)
	WHERE t.topic_id = " . $topic_id . "
		AND f.forum_id = t.forum_id
		AND p.post_id = t.topic_first_post_id";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t obtain topic information', '', __LINE__, __FILE__, $sql);
}

if ( !($forum_row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'No_such_post');
}
$forum_id = $forum_row['forum_id'];
$forum_name = $forum_row['forum_name'];
$topic_title = $forum_row['topic_title'];
$topic_time = $forum_row['topic_time'];
$user_posts_per_page = ($userdata['user_posts_per_page'] > 0) ? $userdata['user_posts_per_page'] : '15';
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
if ( isset($HTTP_POST_VARS['start']) )
{
	$start = intval($HTTP_POST_VARS['start']);
}
$base_url = "printview.$phpEx?" . POST_TOPIC_URL . "=$topic_id";
generate_pagination($base_url, $forum_row['topic_replies'], $user_posts_per_page, $start);
$template->assign_block_vars('forum_row', array(
'TOPIC_ID' => '<a href="'. append_sid("viewtopic.$phpEx?". POST_TOPIC_URL .'='. $forum_row['topic_id']) .'" class="gensmall">' . $lang['Print_topic'] . '</a>'
));
if ( $forum_row['forum_moderate'] && !$forum_row['topic_approve'] )
{
	$topic_title = $forum_row['topic_title'] = '';
}

$is_auth = array();
$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];

$forum_view_moderate = ($forum_row['forum_moderate'] && !$is_auth['auth_mod']) ? true : false;

if ( !$is_auth['auth_read'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = 't=' . $topic_id;
		redirect(append_sid("login.$phpEx?redirect=printview.$phpEx&$redirect", true));
	}

	$message = sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}

if ( $forum_row['password'] != '' )
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
			password_check($forum_id, $HTTP_POST_VARS['password'], $redirect, $forum_row['password']);
		}

		if ( ($forum_row['password'] != '') && ($HTTP_COOKIE_VARS[$cookie_forum_pass] != md5($forum_row['password'])) )
		{
			password_box($forum_id, $redirect);
		}
	}
}
	
$sql = "SELECT u.username, u.user_id, u.user_level, u.user_jr, u.user_allowhtml, p.*, pt.post_text, pt.post_subject, pt.bbcode_uid
	FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt)
	WHERE p.topic_id = $topic_id
		AND pt.post_id = p.post_id
		AND u.user_id = p.poster_id
		ORDER BY p.post_order, p.post_time
	LIMIT $start, $user_posts_per_page";
if(!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Couldn\'t obtain post/user information.', '', __LINE__, __FILE__, $sql);
}

$postrow = $posters_id = array();
$total_posts = 0;
while($row = $db->sql_fetchrow($result))
{
    $total_posts++;
    $postrow[] = $row;
    $posters_id[] = $row['poster_id'];
}
$db->sql_freeresult($result);
if(!$total_posts) message_die(GENERAL_MESSAGE, $lang['No_posts_topic']);

$orig_word = array();
$replacement_word = array();
$replacement_word = array();
$replacement_word_html = array();
obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

if ( count($orig_word) )
{
	$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
}

$forum_moderators = moderarots_list($forum_id, 'mod');

for($i = 0; $i < $total_posts; $i++)
{
	$poster_id = $postrow[$i]['user_id'];
	$poster = $postrow[$i]['username'];
    if($postrow[$i]['post_start_time']>0) $postrow[$i]['post_time'] = $postrow[$i]['post_start_time'];

	$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);
	$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : '';

	$message = $postrow[$i]['post_text'];
	$bbcode_uid = $postrow[$i]['bbcode_uid'];
 
	if ( $postrow[$i]['user_level'] != ANONYMOUS && $postrow[$i]['user_level'] != ADMIN && $postrow[$i]['user_level'] == MOD )
	{
		$poster_is_mod_here = (@in_array($poster_id, $forum_moderators)) ? true : false;
	}
	else
	{
		$poster_is_mod_here = false;
		$poster_is_jr_admin = ($postrow[$i]['user_jr']) ? true : false;
	}

	$show_post_html = ($board_config['allow_html'] && $postrow[$i]['user_allowhtml']) ? true : false;
	if ( ($poster_is_mod_here && $board_config['mod_html']) || ($board_config['admin_html'] && $postrow[$i]['user_level'] == ADMIN) || ($board_config['jr_admin_html'] && $poster_is_jr_admin) )
	{
		$show_post_html = true;
	}

	if ( !$show_post_html )
	{
		if ( $postrow[$i]['enable_html'] )
		{
			$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		}
	}

	$strip_br = ($show_post_html && (strpos($message, '<td>') !== false || strpos($message, '<tr>') !== false || strpos($message, '<table>') !== false)) ? true : false;

	if ( $userdata['user_level'] == ADMIN || $userdata['user_jr'] || $is_auth['auth_mod'] ) 
	{
		$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "<br><u><b>Mod Info:</u><br>[</b>\\1<b>]</b><br>", $message);
	}
	elseif ( stristr($message,'[mod]') )
	{
		$message = trim(preg_replace('/(.*?)\[mod\].*?\[\/mod\](.*?)/si','\1\2',$message));
	}

	if( $bbcode_uid != '' )
	{
		$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid, $userdata['username']) : preg_replace("/\:[0-9a-z\:]+\]/si", "]", $message);
	}
	$message = make_clickable($message);
	
	if ( strpos($message, "[hide:$bbcode_uid]") !== false )
	{
		if ( !$userdata_reply_buffered )
		{
            $valid = ( $userdata['session_logged_in'] && ($userdata['user_level'] == ADMIN || $userdata['user_jr'] || $is_auth['auth_mod'] || in_array($userdata['user_id'], $posters_id)) ) ? true : false;
            if ( $userdata['session_logged_in'] && !$valid )
			{
				$sql = "SELECT poster_id, topic_id
						FROM " . POSTS_TABLE . "
						WHERE topic_id = $topic_id
							AND poster_id = ".$userdata['user_id'];

				$resultat = $db->sql_query($sql);
				$valid = $db->sql_numrows($resultat) ? true : false;
			}
			$userdata_reply_buffered = true;
		}
		$message = bbencode_third_pass($message, $bbcode_uid, $valid);
	}

	if ( count($orig_word) )
	{
		$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);
		$message = preg_replace($orig_word, $replacement_word_html, $message);
	}
	if ( $board_config['allow_smilies'] && $userdata['show_smiles'] )
	{
		if ( $postrow[$i]['enable_smilies'] )
		{
			$message = smilies_pass($message);
		}
	}

	$message = trim(preg_replace('/(.*?)\[hide\:.*?\].*?\[\/hide\:.*?\](.*?)/si','\1\2',$message));

	if ( !$strip_br )
	{
		$message = str_replace("\n", "\n<br />\n", $message);
	}

	if ( !$postrow[$i]['post_approve'] && $forum_view_moderate )
	{
		$poster_id = $poster = $bbcode_uid = $message = '';
		$post_subject = '<i>' . $lang['Post_no_approved'] . '</i>';
	}

 	$template->assign_block_vars('postrow', array(
		'POSTER_NAME' => ($poster_id == ANONYMOUS) ? (($poster) ? $poster : $lang['Guest']) : $poster,
		'POST_DATE' => $post_date,
		'POST_SUBJECT' => ($post_subject) ? '<b>' . $lang['Post_subject'] . '</b>: ' . $post_subject : '',
		'MESSAGE' => $message)
	);
}

$template->assign_vars(array(
	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],

	'PAGE_TITLE' => $lang['View_topic'] .' - ' . $topic_title,
	'FORUM_NAME' => $forum_name,
	'TOPIC_TITLE' => $topic_title,
	'SITENAME' => $board_config['sitename'],
	'SITE_DESCRIPTION' => $board_config['site_desc'])
);

$template->pparse('body');

$db->sql_close();

exit;
?>