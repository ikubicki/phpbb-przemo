<?php
/***************************************************************************
 *						fetchposts.php
 *						-------------------
 * begin				: Tuesday, August 13, 2002
 * copyright			: (C) 2002 Smartor
 * email				: smartor_xp@hotmail.com
 * original work		: Volker Rattel <ca5ey@clanunity.net>
 * modification			: (C) 2003 Przemo http://www.przemo.org
 * date modification	: ver. 1.9 2003/06/15 21:00
 *
 * $Id: fetchposts.php,v 2.1.7 2003/01/30, 16:45:24 Smartor Exp $
 ***************************************************************************/

/***************************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/

/***************************************************************************
 * Some code in this file I borrowed from the phpBB Fetch Posts MOD by Ca5ey
 * and Mouse Hover Topic Preview MOD by Shannado
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Disable magic_quotes_runtime
if(get_magic_quotes_runtime()) { @ini_set('magic_quotes_runtime', 0); }

include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include_once($phpbb_root_path . 'includes/functions_add.'.$phpEx);

function phpbb_fetch_posts($forum_sql, $number_of_posts, $text_length)
{
	global $db, $board_config, $userdata;

	$sql = "SELECT t.topic_id, t.topic_time, t.topic_title, pt.post_text, u.username, u.user_id, t.topic_replies, pt.bbcode_uid, t.forum_id, t.topic_poster, t.topic_first_post_id, t.topic_status, pt.post_id, p.post_id, p.post_attachment, p.enable_smilies
		FROM (" . TOPICS_TABLE . " AS t, " . USERS_TABLE . " AS u, " . POSTS_TEXT_TABLE . " AS pt, " . POSTS_TABLE . " AS p)
		WHERE t.forum_id IN ($forum_sql)
			AND t.topic_time <= " . CR_TIME . "
			AND t.topic_poster = u.user_id
			AND t.topic_first_post_id = pt.post_id
			AND t.topic_first_post_id = p.post_id
			AND t.topic_status <> 2
			AND p.post_approve = 1
		ORDER BY t.topic_time DESC";
	if ( $number_of_posts != 0 )
	{
		$sql .= '
			LIMIT 0,' . $number_of_posts;
	}

	// query the database
	if ( !($result = $db->sql_query($sql)) )
	{
//		message_die(GENERAL_MESSAGE, 'Could not query setup information, check for exists and remove comma of the end of list forums ID');
	}

	// fetch all postings
	$posts = array();
	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$posts[$i]['bbcode_uid'] = $row['bbcode_uid'];
			$posts[$i]['enable_smilies'] = $row['enable_smilies'];
			$posts[$i]['post_text'] = $row['post_text'];
			$posts[$i]['topic_id'] = $row['topic_id'];
			$posts[$i]['topic_replies'] = $row['topic_replies'];
			$posts[$i]['topic_time'] = create_date($board_config['default_dateformat'], $row['topic_time'], $board_config['board_timezone']);
			$posts[$i]['topic_title'] = $row['topic_title'];
			$posts[$i]['user_id'] = $row['user_id'];
			$posts[$i]['username'] = $row['username'];
			if( defined('ATTACHMENTS_ON') )
			{
				$posts[$i]['post_attachment'] = $row['post_attachment'];
				$posts[$i]['post_id'] = $row['post_id'];
			}

			// do a little magic
			// note: part of this comes from mds' news script and some additional magics from Smartor
			stripslashes($posts[$i]['post_text']);
			if ( ($text_length == 0) or (strlen($posts[$i]['post_text']) <= $text_length) )
			{				
				$posts[$i]['post_text'] = bbencode_second_pass($posts[$i]['post_text'], $posts[$i]['bbcode_uid'], $userdata['username']);
				$posts[$i]['striped'] = 0;
			}
			else
			{
				// strip text for news
				$posts[$i]['post_text'] = bbencode_strip($posts[$i]['post_text'], $posts[$i]['bbcode_uid']);
				$posts[$i]['post_text'] = substr($posts[$i]['post_text'], 0, $text_length) . '...';
				$posts[$i]['striped'] = 1;
			}

			// Smilies
			if ( $posts[$i]['enable_smilies'] == 1 )
			{
				$posts[$i]['post_text'] = smilies_pass($posts[$i]['post_text']);
			}
			$posts[$i]['post_text'] = make_clickable($posts[$i]['post_text']);

			// define censored word matches
			$orig_word = array();
			$replacement_word = array();
			$replacement_word_html = array();
			obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

			// censor text and title
			if ( count($orig_word) )
			{
				$posts[$i]['topic_title'] = preg_replace($orig_word, $replacement_word, $posts[$i]['topic_title']);
				$posts[$i]['post_text'] = preg_replace($orig_word, $replacement_word, 	$posts[$i]['post_text']);
			}
			$posts[$i]['post_text'] = nl2br($posts[$i]['post_text']);

			$i++;
		}
		while ($row = $db->sql_fetchrow($result));
	}
	return $posts;
}

function phpbb_fetch_poll($forum_sql)
{
	global $db;

	$sql = "SELECT t.*, vd.*
		FROM (" . TOPICS_TABLE . " AS t, " . VOTE_DESC_TABLE . " AS vd)
		WHERE t.forum_id IN ($forum_sql)
			AND t.topic_status <> 1
			AND t.topic_status <> 2
			AND t.topic_vote = 1
			AND t.topic_id = vd.topic_id
		ORDER BY t.topic_time DESC
		LIMIT 0, 1";
	if ( !$query = $db->sql_query($sql) )
	{
//		message_die(GENERAL_MESSAGE, 'Could not query announcements information');
	}

	$result = $db->sql_fetchrow($query);

	if ( $result )
	{
		$sql = 'SELECT
				*
				FROM
				' . VOTE_RESULTS_TABLE . '
				WHERE
				vote_id = ' . $result['vote_id'] . '
				ORDER BY
				vote_option_id';

		if ( !$query = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not query vote result information', '', __LINE__, __FILE__, $sql);
		}

		while ($row = $db->sql_fetchrow($query))
		{
			$result['options'][] = $row;
		}
	}

	return $result;
}

?>