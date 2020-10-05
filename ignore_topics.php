<?php
/***************************************************************************
 *                      ignore_topics.php
 *                      -------------------
 *   begin              : 25, 09, 2003
 *   copyright          : (C) 2003 Przemo www.przemo.org/phpBB2/
 *   email              : przemo@przemo.org
 *   date modification  : ver. 1.12.0 2005/10/10 2:28
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

// Start session management
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
// End session management

$page_title = $lang['ignore_topics'];
$user_id = $userdata['user_id'];

if ( $userdata['user_level'] == ADMIN && $HTTP_GET_VARS['u'] )
{
	// It is hidden function
	$user_id = intval($HTTP_GET_VARS['u']);
}

$user_topics_per_page = ($userdata['user_topics_per_page'] > $board_config['topics_per_page']) ? $board_config['topics_per_page'] : $userdata['user_topics_per_page'];

if ( !$board_config['ignore_topics'] || !$userdata['session_logged_in'] )
{
	redirect(append_sid("index.$phpEx", true));
}

$min_time = CR_TIME - 7776000;
$topics_to_delete = '';

$sql = "SELECT i.topic_id
	FROM " . TOPICS_IGNORE_TABLE . " i
	LEFT JOIN " . TOPICS_TABLE . " t ON (t.topic_id = i.topic_id AND t.topic_type = " . POST_NORMAL . ")
	LEFT JOIN " . POSTS_TABLE . " p ON
	(
		p.topic_id = i.topic_id
		AND p.post_id = t.topic_last_post_id
		AND p.post_time < $min_time
	)
	WHERE p.topic_id IS NOT NULL
		AND t.topic_id IS NOT NULL
	GROUP by i.topic_id";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not get ignore topic information', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	do
	{
		$topics_to_delete .= ($topics_to_delete) ? ', ' . $row['topic_id'] : $row['topic_id'];
	}
	while ( $row = $db->sql_fetchrow($result) );
}

if ( $topics_to_delete )
{
	$sql = "DELETE FROM " . TOPICS_IGNORE_TABLE . "
		WHERE topic_id IN($topics_to_delete)";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not delete old ignore topics', '', __LINE__, __FILE__, $sql);
	}
}

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'ignore_topics_body.tpl')
);

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
}

if ( isset($HTTP_GET_VARS['topic_id']) || isset($HTTP_POST_VARS['topic_id']) )
{
	$topic_id = ( isset($HTTP_GET_VARS['topic_id']) ) ? intval($HTTP_GET_VARS['topic_id']) : intval($HTTP_POST_VARS['topic_id']);

	if ( isset($HTTP_GET_VARS['topic_id']) && !check_sid($HTTP_GET_VARS['sid']) )
	{
		message_die(GENERAL_ERROR, 'Invalid_session');
	}
}
else
{
	$topic_id = '';
}

if ( !isset($mode) && $topic_id )
{
    $sql = "SELECT topic_id FROM " . TOPICS_TABLE ." WHERE topic_id = $topic_id";
    if ( !$result = $db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, 'Could not check topic id', '', __LINE__, __FILE__, $sql);
    }
    if($db->sql_numrows($result) < 1) message_die(GENERAL_MESSAGE, $lang['No_such_post']);

	$sql = "INSERT INTO " . TOPICS_IGNORE_TABLE . " (topic_id, user_id)
			VALUES ($topic_id, $user_id)";
    if ( !$db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, 'Could not insert into topics ignore table', '',__LINE__, __FILE__, $sql);
    }

	$sql = "DELETE FROM " . READ_HIST_TABLE . "
		WHERE user_id = $user_id
			AND topic_id = $topic_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error in marking all as read', '',__LINE__, __FILE__, $sql);
	}

	$message = sprintf($lang['ignore_topic_added'], '<a href="' . append_sid("ignore_topics.$phpEx?mode=view") . '">', '</a>', '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( isset($HTTP_POST_VARS['unignore_mark']) )
{
	$list_ignore = ( isset($HTTP_POST_VARS['list_ignore']) ) ? $HTTP_POST_VARS['list_ignore'] : array();

	for($i = 0; $i < count($list_ignore); $i++)
	{
		$sql = "DELETE FROM " . TOPICS_IGNORE_TABLE . "
			WHERE user_id = $user_id
				AND topic_id = " . intval($list_ignore[$i]) . "";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error deleting ignore topic', '', __LINE__, __FILE__, $sql);
		}
	}
	$message = sprintf($lang['ignore_topic_unignored'], '<a href="' . append_sid("ignore_topics.$phpEx?mode=view") . '">', '</a>', '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( $mode == 'unignore' && isset($topic_id) )
{
	$sql = "DELETE FROM " . TOPICS_IGNORE_TABLE . "
		WHERE user_id = $user_id
			AND topic_id = $topic_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error deleting ignore topic', '', __LINE__, __FILE__, $sql);
	}
}

if ( isset($HTTP_POST_VARS['ignore']) )
{
	$list_ignore = ( isset($HTTP_POST_VARS['list_ignore']) ) ? $HTTP_POST_VARS['list_ignore'] : array();

	$topic_ids = $insert_sql = '';
	if ( $list_ignore )
	{
		for($i = 0; $i < count($list_ignore); $i++)
		{
			$i_topic_id = intval($list_ignore[$i]);
			$insert_sql .= (($insert_sql) ? ', ' : '') . "($i_topic_id, $user_id)";
			$topic_ids .= ($topic_ids) ? ', ' . $i_topic_id : $i_topic_id;
		}
		if ( $insert_sql )
		{
			$sql = "INSERT INTO " . TOPICS_IGNORE_TABLE . " (topic_id, user_id)
				VALUES $insert_sql";
			$db->sql_query($sql);
		}

		if ( $topic_ids  )
		{
			$sql = "DELETE FROM " . READ_HIST_TABLE . "
				WHERE user_id = $user_id
					AND topic_id IN($topic_ids)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Error in marking all as read', '',__LINE__, __FILE__, $sql);
			}
		}
	}
	$message = sprintf($lang['ignore_topic_added'], '<a href="' . append_sid("ignore_topics.$phpEx?mode=view") . '">', '</a>', '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( $mode == 'view' )
{
	$view_topics = (isset($HTTP_GET_VARS['topic_ignore'])) ? 'AND topic_id = ' . intval($HTTP_GET_VARS['topic_ignore']) : '';

	if ( isset($HTTP_GET_VARS['start']) || isset($HTTP_POST_VARS['start']) )
	{
		$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : intval($HTTP_POST_VARS['start']);
	}
	else
	{
		$start = 0;
	}
	$sql = "SELECT COUNT(topic_id) AS total 
		FROM " . TOPICS_IGNORE_TABLE . "
		WHERE user_id = $user_id
			$view_topics";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not list topics', '', __LINE__, __FILE__, $sql_tot);
	}

	$pm_total = ( $row = $db->sql_fetchrow($result) ) ? $row['total'] : 0;
	if ( $pm_total < 1 )
	{
		$message = sprintf($lang['ignore_list_empty'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}

	$page_number = sprintf($lang['Page_of'], ( floor( $start / $user_topics_per_page ) + 1 ), ceil( $pm_total / $user_topics_per_page ));
	$go_to_page = $lang['Goto_page'];
	if ( ceil( $pm_total / $user_topics_per_page ) == 1 )
	{
		$page_number = '';
		$go_to_page = '';
	}

	generate_pagination("ignore_topics.$phpEx?mode=view", $pm_total, $user_topics_per_page, $start);

	$view_topics = (isset($HTTP_GET_VARS['topic_ignore'])) ? 'AND t.topic_id = ' . intval($HTTP_GET_VARS['topic_ignore']) : '';

	$sql = "SELECT i.topic_id, t.topic_title, t.forum_id, f.forum_id, f.forum_name
		FROM (" . TOPICS_IGNORE_TABLE . " i, " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f)
		WHERE i.user_id = $user_id
			AND i.topic_id = t.topic_id
			AND t.forum_id = f.forum_id
			$view_topics
		ORDER by t.topic_type DESC, t.topic_last_post_id DESC
		LIMIT $start, $user_topics_per_page";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get topic information', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$topic_title = $row['topic_title'];
			if (!$board_config['show_badwords'])
			{
				$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_title) : $topic_title;
			}
			else
			{
				$topic_title = $row['topic_title'];
				replace_bad_words($orig_word, $replacement_word, $topic_title);
			}

			$topic_id = $row['topic_id'];
			$forum_id = $row['forum_id'];

			$template->assign_block_vars('view', array(
				'TOPIC_ID' => $topic_id,
				'TOPIC_TITLE' => $topic_title,
				'U_VIEW_TOPIC' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id"),
				'FORUM_NAME' => $row['forum_name'],
				'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL ."=$forum_id"))
			);
			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
}

make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'L_LIST_IGNORE' => $lang['list_ignore'],
	'L_LIST_IGNORE_E' => $lang['list_ignore_e'],
	'U_INDEX' => append_sid('index.'.$phpEx),
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'FORM_ACTION' => append_sid("ignore_topics.$phpEx"),
	'VIEW_IGNORE' => append_sid("ignore_topics.$phpEx?mode=view"),
	'L_MARK_ALL' => $lang['Mark_all'],
	'L_MARK' => $lang['Mark'],
	'L_DELETE_MARK' => $lang['Delete_marked'],
	'L_DELETE' => $lang['Delete'],
	'L_TOPICS' => $lang['Topics'],
	'L_FORUM' => $lang['Forum'])
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>