<?php
/***************************************************************************
 *                      post_history.php
 *                      -------------------
 *   begin              : 21.10.2005
 *   copyright          : (C) Przemo www.przemo.org/phpBB2/
 *   email              : przemo@przemo.org
 *   version            : 1.12.0
 *
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';

include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

if ( isset($HTTP_GET_VARS[POST_POST_URL]))
{
	$post_id = intval($HTTP_GET_VARS[POST_POST_URL]);
}
else
{
	$post_id = 0;
}

if ( !isset($post_id) )
{
	message_die(GENERAL_MESSAGE, 'No_such_post');
}

$sql = "SELECT t.topic_id, t.topic_title, f.forum_id, p.poster_id, p.post_username, p.post_time, u.username
	FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p, " . USERS_TABLE . " u)
	WHERE p.post_id = $post_id
		AND p.topic_id = t.topic_id
		AND u.user_id = p.poster_id
		AND t.forum_id = f.forum_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain post/topic/forum information', '', __LINE__, __FILE__, $sql);
}

if ( !($forum_topic_data = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'No_such_post');
}

$forum_id = intval($forum_topic_data['forum_id']);
$topic_id = intval($forum_topic_data['topic_id']);
$topic_title = $forum_topic_data['topic_title'];

// Start session management
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
// End session management

require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_post_history.' . $phpEx);

$is_auth = array();
$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];

$is_auth_view = ($userdata['user_level'] == ADMIN || ($board_config['ph_mod'] && $is_auth['auth_mod'])) ? true : false;
if ( !$is_auth_view )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}

$is_auth_delete = ($userdata['user_level'] == ADMIN || ($board_config['ph_mod_delete']&& $is_auth['auth_mod'])) ? true : false;

if ( ($HTTP_POST_VARS['mode'] == 'delete' || $HTTP_GET_VARS['mode'] == 'delete') && $is_auth_delete )
{
	if ( !$HTTP_POST_VARS['confirm'] )
	{
		confirm($lang['Ph_confirm_delete'], append_sid("post_history.$phpEx?mode=delete&amp;" . POST_POST_URL . "=$post_id"));
	}
	else if ( !$HTTP_POST_VARS['cancel'] )
	{
		$sql = "DELETE FROM " . POSTS_HISTORY_TABLE . "
			WHERE th_post_id = $post_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete from post history table.', '', __LINE__, __FILE__, $sql);
		}
		else
		{
			message_die(GENERAL_MESSAGE, sprintf($lang['Ph_deleted'], '<a href="' . append_sid("viewtopic.php?t=$topic_id&amp;" . POST_POST_URL . "=$post_id") . '#' . $post_id . '">', '</a>'));
		}
	}
}

$template->set_filenames(array(
	'body' => 'post_history_body.tpl')
);

$template->assign_vars(array(
	'L_POST_TIME' => $lang['Sort_Time'],
	'L_POST_HISTORY_TITLE' => $lang['Post_history'],
	'L_EDITED_BY' => $lang['Edit_by'],
	'L_EDITED_TIME' => $lang['Edit_time'],
	'L_BACK_TO_POST' => $lang['Back_to_post'],
	'L_TOPIC' => $lang['Topic'],
	'L_AUTHOR' => $lang['Author'],

	'U_BACK_TO_POST' => append_sid("viewtopic.php?t=$topic_id&amp;" . POST_POST_URL . "=$post_id") . '#' . $post_id,
	'DELETE_IMG' => ($is_auth_delete) ? '<a href="' . append_sid("post_history.$phpEx?mode=delete&amp;" . POST_POST_URL . "=$post_id") . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_post_history'] . '" title="' . $lang['Delete_post_history'] . '" border="0" /></a>' : '',
	'POST_ID' => $post_id,
	'TOPIC_TITLE' => $forum_topic_data['topic_title'],
	'U_TOPIC_URL' => append_sid("viewtopic.php?t=$topic_id"),
	'POST_POSTER' => ($forum_topic_data['poster_id'] == ANONYMOUS) ? $lang['Guest'] : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $forum_topic_data['poster_id']) . '">' . $forum_topic_data['username'] . '</a>',
	'POST_TIME' => create_date($board_config['default_dateformat'], $forum_topic_data['post_time'], $board_config['board_timezone']),
));

$orig_word = $replacement_word_html = $replacement_word_html = array();
$prev_message = '';
obtain_word_list($orig_word, $replacement_word_html, $replacement_word_html);

$sql = "SELECT ph.th_id, ph.th_post_text, ph.th_user_id, ph.th_time, p.enable_html, p.enable_smilies, u.username
	FROM (" . POSTS_HISTORY_TABLE . " ph, " . POSTS_TABLE . " p, " . USERS_TABLE . " u)
	WHERE ph.th_post_id = $post_id
		AND ph.th_post_id = p.post_id
		AND ph.th_user_id = u.user_id
	ORDER by ph.th_time";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain post information.', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	$i = 0;
	do
	{
		$message = $row['th_post_text'];
		$bbcode_uid = 'cc9d3da2e0';	

		if ( $row['enable_html'] )
		{
			$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		}

		$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "<br><u><b>Mod Info:</u><br>[</b>\\1<b>]</b><br>", $message);

		if ( $bbcode_uid != '' )
		{
			$message = bbencode_second_pass($message, $bbcode_uid, $userdata['username']);
			$message = bbencode_third_pass($message, $bbcode_uid, 0);
		}
		$message = make_clickable($message);

		if ( !$board_config['show_badwords'] )
		{
			if ( count($orig_word) )
			{
				$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word_html, '\\0')", '>' . $message . '<'), 1, -1));
			}
		}
		else
		{
			replace_bad_words($orig_word, $replacement_word_html, $message);
		}

		if ( $board_config['allow_smilies'] && $userdata['show_smiles'] )
		{
			if ( $row['enable_smilies'] )
			{
				$message = smilies_pass($message);
			}
		}

		$message = str_replace(array("\n", "\r"), array("<br />", ''), $message);

		$template->assign_block_vars('postrow', array(
			'ROW_CLASS' => (!$row_class) ? (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'] : $row_class,
			'EDITED_BY_USERNAME' => $row['username'],
			'EDITED_BY_URL' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['th_user_id']),
			'EDITED_TIME' => create_date($board_config['default_dateformat'], $row['th_time'], $board_config['board_timezone']),
			'MESSAGE' => $message)
		);
		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );
	$db->sql_freeresult($result);
}
else
{
	message_die(GENERAL_MESSAGE, $lang['Ph_entry_empty']);
}

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>