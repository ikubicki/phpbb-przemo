<?php
/***************************************************************************
 *                        check_files.php
 *                        -------------------
 *   begin                : 11, 05, 2005
 *   copyright            : (C) Przemo www.przemo.org/phpBB2/
 *   email                : przemo@przemo.org
 *   version              : 1.12.5
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

$only_admin = 0; // Tylko admin ma dostep do check_files ?

define('IN_PHPBB', true);

error_reporting  (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables
header('Content-type: text/html; charset=utf-8');

$time_start2 = microtime(true);

$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');

if ( @filesize("config.$phpEx") > 50 )
{
	include($phpbb_root_path . 'common.'.$phpEx);
	$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
	init_userprefs($userdata);

	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_check_files.' . $phpEx);

	if ( $only_admin && $userdata['user_level'] != ADMIN )
	{
		die($lang['cf_only_admin']);
	}
}
else
{
	include($phpbb_root_path . 'language/lang_polish/lang_check_files.' . $phpEx);
}

$lang['checksum_correct'] = ($lang['checksum_correct']) ? $lang['checksum_correct'] : 'correct checksum';
$lang['checksum_current'] = ($lang['checksum_current']) ? $lang['checksum_current'] : 'current checksum';

$mode = $_GET['mode'];
$type = $_GET['type'];
$cf = 'check_files.' . $phpEx;

function md5_checksum($file)
{
	if ( @file_exists($file) )
	{
		$fd = @fopen($file, 'rb');
		$fileContents = @fread($fd, @filesize($file));
		@fclose($fd);
		return md5($fileContents);
	}
	else
	{
		return false;
	}
}

function strlen_used_chars($file)
{
	if ( @file_exists($file) )
	{
		$fd = @fopen($file, 'rb');
		$fileContents = @fread($fd, @filesize($file));
		@fclose($fd);
		return strlen(str_replace(array(" ","\t","\n","\r"), '', $fileContents));
	}
	else
	{
		return false;
	}
}

echo'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
	<title>phpBB modified by Przemo CheckFiles</title>
	<meta http-equiv="Content-Type" content="text/html; charset=' . (isset($lang['ENCODING']) ? $lang['ENCODING'] : 'utf-8') . '" />
	<style type="text/css">
	<!--
	body {
	background-color: #EFEFEF;
	scrollbar-face-color: #EFEFEF;
	scrollbar-highlight-color: #FFFFFF;
	scrollbar-shadow-color: #DEE3E7;
	scrollbar-3dlight-color: #D1D7DC;
	scrollbar-arrow-color: #006699;
	scrollbar-track-color: #EFEFEF;
	scrollbar-darkshadow-color: #98AAB1;
	}

	.bodyline { background-color: #FFFFFF; border: 1px #98AAB1 solid; }
	font,th,td,p { font-family: Verdana, Arial, Helvetica, sans-serif }
	p, td		{ font-size : 12; color : #000000; }

	hr	{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px;}
	h1,h2,h3,h4		{ font-family: Arial, Helvetica, sans-serif; font-size : 19px; font-weight : bold; text-decoration : none; line-height : 100%; color : #000000;}
 
	-->
	</style>
 </head>

 <body bgcolor="#E5E5E5">
		<table width="98%" style="height: 100%" cellspacing="0" cellpadding="7" border="0" align="center">
			 <tr>
				<td class="bodyline" valign="top">';


$dbversion = '1.12.13';

echo '<h3>CheckFiles - phpBB by Przemo ' . $lang['version'] . ' ' . $dbversion . '</h3>' . $version_check . (($mode) ? '<h5>' . $lang['sql_checkng'] . '</h5>' : '');
if ( @filesize("config.$phpEx") > 50 && $userdata['user_level'] == ADMIN )
{
	echo '<font size="1">' . $lang['admin_explain'] . '</font>';
}

echo '<hr>';

include($phpbb_root_path . 'check_data.'.$phpEx);

if ( defined('PHPBB_INSTALLED') )
{
	echo '<table border="0">';
	if ( $mode == 'sql' && $userdata['user_level'] == ADMIN )
	{
		echo '<tr><td>
		<a href="' . $cf . '?mode=sql&amp;type=users_posts">' . $lang['user_posts'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=posts_text">' . $lang['post_text'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=topic_replies">' . $lang['topic_posts'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=last_first_post_in_topic">' . $lang['topic_first_last_post'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=moved">' . $lang['moved_topics'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=sync_unread_pms">' . $lang['sync_unread_pms'] . '</a><br />
		<a href="' . $cf . '?mode=sql&amp;type=topics_without_posts">' . $lang['topic_without_posts'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=posts_without_topic">' . $lang['post_without_topics'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=forum_posts">' . $lang['forums_posts'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=forum_topics">' . $lang['forums_topics'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=forum_last_post_id">' . $lang['forums_last_post'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=polls">' . $lang['polls'] . '</a>
		&nbsp; <a href="' . $cf . '?mode=sql&amp;type=users">' . $lang['users'] . '</a>
		<br /><br /><a href="' . $cf . '?mode=sql&amp;type=all">' . $lang['all'] . '</a><br /><font size="1">' . $lang['sync_explain'] . '</font>
		<br /><br />' . (($type) ? '<a href="' . $cf . '?mode=sql">' . $lang['back'] . '</a>&nbsp;&nbsp;&nbsp;' : '') . '<a href="' . $cf . '">' . $lang['CF_back'] . '</a>
		<hr />
		</td></tr>';

		if ( !$type )
		{
			echo '</table></td></tr></table></body></html>';
			if ( !empty($db) )
			{
				$db->sql_close();
			}
			exit;
		}

		@set_time_limit('300');

		$sql_results = array();
		$sql_results_name = array('users_posts' => 0, 'posts_text' => 0, 'topic_replies' => 0, 'last_post_topic' => 0, 'first_post_topic' => 0, 'moved' => 0, 'forum_posts' => 0, 'forum_topics' => 0, 'forum_last_post_id' => 0, 'topics_without_posts' => 0, 'posts_without_topic' => 0, 'polls' => 0, 'polls_desc' => 0, 'polls_res' => 0, 'polls_vote' => 0);
		$print_result = '';

		$all = ($type == 'all') ? true : false;

		if ( $type == 'users_posts' || $all )
		{
			$users_ids = array();
			$no_count_forums = no_post_count('1', 'list');
			
			$sql = "SELECT user_id, user_posts
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
			}
			while ( $row = $db->sql_fetchrow($result) )
			{
				$list_users[$row['user_id']] = $row['user_posts'];
            }
            $db->sql_freeresult($result);

            if( !empty($list_users) )
            {
				$sql_posts = "SELECT poster_id, count(post_id) AS posts
					FROM " . POSTS_TABLE . "
						WHERE poster_id IN (".implode(',',array_keys($list_users)).")
						" . (($no_count_forums) ? " AND forum_id NOT IN($no_count_forums)" : '')
						." GROUP BY poster_id";
				if ( !($result_posts = $db->sql_query($sql_posts)) )
				{
					message_die(GENERAL_ERROR, 'Could not count user posts', '', __LINE__, __FILE__, $sql_posts);
				}
				while( $row_post = $db->sql_fetchrow($result_posts) )
                {
                    if ( $list_users[$row_post['poster_id']] != $row_post['posts'] )
                    {
                        $sql_results_name['users_posts']++;
                        $users_ids[] = $row_post['poster_id'];
                    }
                }
			}

			if ( $sql_results_name['users_posts'] > 0 )
			{
				$echo_ids = '';
				for($i = 0; $i < count($users_ids); $i++)
				{
					$echo_ids .= '<a href="profile.'.$phpEx.'?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $users_ids[$i] . '">' . $users_ids[$i] . '</a>, ';
				}
				$print_result .= '<tr><td>' . $lang['users_wrong_posts'] . ': <b>' . $sql_results_name['users_posts'] . '</b><br />User ID\'s: ' . $echo_ids . '</td></tr>';
			}

			for($i = 0; $i < count($divisor); $i++)
			{
				$list_users_sql = implode(', ', array_keys($list_users));

				$sql = "SELECT post_id FROM " . POSTS_TABLE . "
					WHERE poster_id NOT IN($list_users_sql)
						AND poster_id <> " . ANONYMOUS;
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
				}
				while ( $row = $db->sql_fetchrow($result) )
				{
					$wrong_poster_posts[] = $row['post_id'];
				}
				$db->sql_freeresult($result);

				$t_sql = "SELECT topic_id FROM " . TOPICS_TABLE . "
					WHERE topic_poster NOT IN($list_users_sql)
						AND topic_poster <> " . ANONYMOUS;
				if ( !($t_result = $db->sql_query($t_sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get topic_poster information', '', __LINE__, __FILE__, $t_sql);
				}
				while ( $t_row = $db->sql_fetchrow($t_result) )
				{
					$wrong_poster_posts[] = $row['post_id'];
				}
				$db->sql_freeresult($t_result);
			}
			if ( count($wrong_poster_posts) > 0 )
			{
				$echo_ids = '';
				$print_result .= '<tr><td>' . $lang['non_exists_posters'] . ': <b>' . count($wrong_poster_posts) . '</b></td></tr>';
			}

			if ( count($wrong_poster_posts) > 0 )
			{
				$echo_ids = '';
				$print_result .= '<tr><td>' . $lang['non_exists_topic_authors'] . ': <b>' . count($wrong_poster_posts) . '</b></td></tr>';
			}
		}

		if ( $type == 'posts_text' || $all )
		{
			if ( isset($_GET['repair']) )
			{
				$sql = "SELECT post_id
					FROM " . POSTS_TABLE;
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get post list data', '', __LINE__, __FILE__, $sql);
				}

				$list_pt = $list_p = array();

				while ( $row_pt = $db->sql_fetchrow($result) )
				{
					$list_pt[] = $row_pt['post_id'];
				}
				$db->sql_freeresult($result);

				$sql = "SELECT post_id
					FROM " . POSTS_TEXT_TABLE;
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get post text list data', '', __LINE__, __FILE__, $sql);
				}

				while ( $row_p = $db->sql_fetchrow($result) )
				{
					$list_p[] = $row_p['post_id'];
				}
				$db->sql_freeresult($result);
				$no_in_pt = array_diff($list_pt, $list_p);
				$no_in_p = array_diff($list_p, $list_pt);

				$no_in_p = implode(', ', $no_in_p);
				$no_in_pt = implode(', ', $no_in_pt);

				if ( $no_in_p )
				{
					$sql = "DELETE FROM " . POSTS_TEXT_TABLE . "
						WHERE post_id IN($no_in_p)";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not delete posts text', '', __LINE__, __FILE__, $sql);
					}
				}

				if ( $no_in_pt )
				{
					$sql = "DELETE FROM " . POSTS_TABLE . "
						WHERE post_id IN($no_in_pt)";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not delete posts', '', __LINE__, __FILE__, $sql);
					}
					$sql = "DELETE FROM " . READ_HIST_TABLE . "
						WHERE post_id IN($no_in_pt)";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not delete posts', '', __LINE__, __FILE__, $sql);
					}
				}

				die('<br /><br />' . $lang['posts_was_sync'] . '<br /><br />');
			}
			$sql = "SELECT p.post_id
				FROM " . POSTS_TABLE . " p
				LEFT JOIN " . POSTS_TEXT_TABLE . " pt ON (p.post_id = pt.post_id)
				WHERE pt.post_id IS NULL";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get different', '', __LINE__, __FILE__, $sql);
			}
			$p_diff = $pt_diff = '';
			while ( $rowp = $db->sql_fetchrow($result) )
			{
				$p_diff .= ($p_diff) ? ', ' . $rowp['post_id'] : $rowp['post_id'];
			}
			$db->sql_freeresult($result);
			if ( $p_diff )
			{
				$print_result .= '<tr><td><br /><br />' . $lang['empty_posts'] . ': <b>' . $p_diff . '</b></td></tr>';
			}

			$sql = "SELECT pt.post_id
				FROM " . POSTS_TEXT_TABLE . " pt
				LEFT JOIN " . POSTS_TABLE . " p ON (pt.post_id = p.post_id)
				WHERE p.post_id IS NULL";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not ged different', '', __LINE__, __FILE__, $sql);
			}
			while ( $rowpt = $db->sql_fetchrow($result) )
			{
				$pt_diff .= ($pt_diff) ? ', ' . $rowpt['post_id'] : $rowpt['post_id'];
			}
			$db->sql_freeresult($result);
			if ( $pt_diff )
			{
				$print_result .= '<tr><td>' . ((!$p_diff) ? '<br /><br />' : '') . $lang['empty_posts_text'] . ': <b>' . $pt_diff . '</b></td></tr>';
			}
			if ( $pt_diff || $p_diff )
			{
				$print_result .= '<tr><td><a href="' . $cf . '?mode=sql&amp;type=posts_text&amp;repair=1">' . $lang['delete_empty_posts'] . '</a></td></tr>';
			}
		}

		if ( $type == 'topic_replies' || $type == 'last_first_post_in_topic' || $type == 'posts_without_topic' || $type == 'topics_without_posts' || $type == 'polls' || $all )
		{
			$sql = "SELECT topic_id, topic_replies, topic_last_post_id, topic_first_post_id
				FROM " . TOPICS_TABLE . "
					WHERE topic_moved_id = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topics data', '', __LINE__, __FILE__, $sql);
			}

			$tids = $topics_ids = $topics_last = $topics_last = $posts_wtopics = $topics = $topics_wposts = $polls_ids = array();

			while ( $row = $db->sql_fetchrow($result) )
			{
                $tids[$row['topic_id']] = $row;
                $topics[] = $row['topic_id'];
            }

            $db->sql_freeresult($result);

            if( !empty($tids) && !empty($topics) )
            {
                if ( $type == 'topic_replies' || $all )
                {
                    $sql_posts = "SELECT topic_id, count(post_id) AS posts
					    FROM " . POSTS_TABLE . "
						WHERE topic_id IN (".implode(',',$topics).")
						GROUP BY topic_id";
                    if ( !($result_posts = $db->sql_query($sql_posts)) )
                    {
                        message_die(GENERAL_ERROR, 'Could not count topic posts', '', __LINE__, __FILE__, $sql_posts);
                    }

                    while( $row_post = $db->sql_fetchrow($result_posts) )
                    {
                        if ( $tids[$row_post['topic_id']]['topic_replies'] != ($row_post['posts'] - 1) )
                        {
                            $sql_results_name['topic_replies']++;
                            $topics_ids[] = $row_post['topic_id'];
                        }
                    }
                    $db->sql_freeresult($result);
                }
                if ( $type == 'topics_without_posts' || $all )
                {
                    $sql_wposts = "SELECT topic_id, post_id
						FROM " . POSTS_TABLE . "
						WHERE topic_id IN (".implode(',',$topics).")
						GROUP BY topic_id";
                    if ( !($result_wposts = $db->sql_query($sql_wposts)) )
                    {
                        message_die(GENERAL_ERROR, 'Error get posts list', '', __LINE__, __FILE__, $sql_wposts);
                    }
                    $rw = array();
                    while( $row_wposts = $db->sql_fetchrow($result_wposts) )
                    {
                        $rw[] = $row_wposts['topic_id'];
                    }
                    $db->sql_freeresult($result);

                    //difference
                    $diff = array_diff($topics, $rw);
                    foreach($diff as $k => $v)
                    {
                        $sql_results_name['topics_without_posts']++;
                        $topics_wposts[] = $v;
                    }
                }
                if ( $type == 'last_first_post_in_topic' || $all )
                {
                    $sql_posts_last = "SELECT topic_id, MAX(post_id) AS last_post, MIN(post_id) AS first_post
						FROM " . POSTS_TABLE . "
						WHERE topic_id IN (".implode(',',$topics).")
						GROUP BY topic_id";
                    if ( !($result_posts_last = $db->sql_query($sql_posts_last)) )
                    {
                        message_die(GENERAL_ERROR, 'Could not count topic posts', '', __LINE__, __FILE__, $sql_posts_last);
                    }
                    while ($row_post_last = $db->sql_fetchrow($result_posts_last) )
                    {
                        if ( $tids[$row_post_last['topic_id']]['topic_last_post_id'] != $row_post_last['last_post'] )
                        {
                            $sql_results_name['last_post_topic']++;
                            $topics_last[] = $row_post_last['topic_id'];
                        }
                        if ( $tids[$row_post_last['topic_id']]['topic_first_post_id'] != $row_post_last['first_post'] )
                        {
                            $sql_results_name['first_post_topic']++;
                            $topics_first[] = $row_post_last['topic_id'];
                        }
                    }
                    $db->sql_freeresult($result);
                }
            }

			$topics_array = (is_array($topics)) ? $topics : array($topics);

			if (( ($type == 'posts_without_topic' || $all) && $topics ) || ( ($type == 'polls' || $all) && $topics ) )
			{
				$topics_sql = implode(', ', $topics_array);

				if ( ($type == 'posts_without_topic' || $all) && $topics )
				{
					$sql_wtopics = "SELECT post_id
						FROM " . POSTS_TABLE . "
						WHERE topic_id NOT IN($topics_sql)";
					if ( !($result_wtopics = $db->sql_query($sql_wtopics)) )
					{
						message_die(GENERAL_ERROR, 'Error get topic posts', '', __LINE__, __FILE__, $sql_wtopics);
					}
					while ( $row_wpost = $db->sql_fetchrow($result_wtopics) )
					{
						$sql_results_name['posts_without_topic']++;
						$posts_wtopics[] = $row_wpost['post_id'];
					}
				}

				if ( ($type == 'polls' || $all) && $topics )
				{
					$sql_p = "SELECT topic_id, vote_id
						FROM " . VOTE_DESC_TABLE . "
						WHERE topic_id NOT IN($topics_sql)";
					if ( !($result_p = $db->sql_query($sql_p)) )
					{
						message_die(GENERAL_ERROR, 'Could not get polls list', '', __LINE__, __FILE__, $sql_p);
					}
					while ( $row_p = $db->sql_fetchrow($result_p) )
					{
						$sql_results_name['polls']++;
						$polls_ids[] = $row_p['vote_id'];
					}
					$db->sql_freeresult($result_p);
				}
				if ( $sql_results_name['posts_without_topic'] > 0 )
				{
					$posts_wtopics = (is_array($posts_wtopics)) ? implode(', ', $posts_wtopics) : $posts_wtopics;
					$print_result .= '<tr><td><br /><br />Post�w bez temat�w: <b>' . $sql_results_name['posts_without_topic'] . '</b> ID\'s: <b>' . $posts_wtopics . '</b>';
				}
			}
			if ( ($type == 'topics_without_posts' || $all) && $sql_results_name['topics_without_posts'] > 0 )
			{
				$topics_wposts = (is_array($topics_wposts)) ? implode(', ', $topics_wposts) : $topics_wposts;
				$print_result .= '<tr><td><br /><br />Temat�w bez post�w: <b>' . $sql_results_name['topics_without_posts'] . '</b><br />Topic ID\'s: ' . $topics_wposts . '</td></tr>';
			}
			if ( ($type == 'topic_replies' || $all) && $sql_results_name['topic_replies'] > 0 )
			{
				$echo_ids = '';
				for($i = 0; $i < count($topics_ids); $i++)
				{
					$echo_ids .= '<a href="viewtopic.'.$phpEx.'?' . POST_TOPIC_URL . '=' . $topics_ids[$i] . '">' . $topics_ids[$i] . '</a>, ';
				}
				$print_result .= '<tr><td><br /><br />' . $lang['topics_wrong_replies'] . ': <b>' . $sql_results_name['topic_replies'] . '</b><br />Topic ID\'s: ' . $echo_ids . '</td></tr>';
			}
			if ( $type == 'last_first_post_in_topic' || $all )
			{
				if ( $sql_results_name['last_post_topic'] > 0 )
				{
					$echo_ids = '';
					for($i = 0; $i < count($topics_last); $i++)
					{
						$echo_ids .= '<a href="viewtopic.'.$phpEx.'?' . POST_TOPIC_URL . '=' . $topics_last[$i] . '">' . $topics_last[$i] . '</a>, ';
					}
					$print_result .= '<tr><td><br /><br />' . $lang['topics_wrong_last_post'] . ': <b>' . $sql_results_name['last_post_topic'] . '</b><br />Topic ID\'s: ' . $echo_ids . '</td></tr>';
				}
				if ( $sql_results_name['first_post_topic'] > 0 )
				{
					$echo_ids = '';
					for($i = 0; $i < count($topics_first); $i++)
					{
						$echo_ids .= '<a href="viewtopic.'.$phpEx.'?' . POST_TOPIC_URL . '=' . $topics_first[$i] . '">' . $topics_first[$i] . '</a>, ';
					}
					$print_result .= '<tr><td><br /><br />' . $lang['topics_wrong_first_post'] . ': <b>' . $sql_results_name['first_post_topic'] . '</b><br />Topic ID\'s: ' . $echo_ids . '</td></tr>';
				}
			}
			if ( ($type == 'polls' || $all) && $topics )
			{
				$sql_p = "SELECT vote_id
					FROM " . VOTE_DESC_TABLE;
				if ( !($result_p = $db->sql_query($sql_p)) )
				{
					message_die(GENERAL_ERROR, 'Could not get polls list', '', __LINE__, __FILE__, $sql_p);
				}
				while ( $row_p = $db->sql_fetchrow($result_p) )
				{
					$sql_results_name['polls_desc'] = $row_p['vote_id'];
				}
				$db->sql_freeresult($result_p);
			}
		}
		if ( $type == 'moved' || $all )
		{
			$moved_ids = array();
			$sql = "SELECT topic_id, topic_moved_id
				FROM " . TOPICS_TABLE . "
					WHERE topic_moved_id <> 0";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error get topic moved list', '', __LINE__, __FILE__, $sql);
			}
			while ( $row = $db->sql_fetchrow($result) )
			{
				$sql_m = "SELECT topic_id
					FROM " . TOPICS_TABLE . "
						WHERE topic_id = " . $row['topic_moved_id'];
				if ( !($result_m = $db->sql_query($sql_m)) )
				{
					message_die(GENERAL_ERROR, 'Error get topic list', '', __LINE__, __FILE__, $sql_m);
				}
				if ( !($row_m = $db->sql_fetchrow($result_m)) )
				{
					$sql_results_name['moved']++;
					$moved_ids[] = $row['topic_moved_id'];
				}
			}
			$db->sql_freeresult($result_m);
			if ( $sql_results_name['moved'] > 0 )
			{
				$echo_ids = '';
				for($i = 0; $i < count($moved_ids); $i++)
				{
					$echo_ids .= '<a href="viewtopic.'.$phpEx.'?' . POST_TOPIC_URL . '=' . $moved_ids[$i] . '">' . $moved_ids[$i] . '</a>, ';
				}
				$print_result .= '<tr><td><br /><br />' . $lang['empty_moved_topics'] . ': <b>' . $sql_results_name['moved'] . '</b><br />Topic ID\'s: ' . $echo_ids . '</td></tr>';
			}
		}
		if ( $type == 'without_forum' || $all )
		{
			$wforum_ids = array();
			$forums = array();
			$sql = "SELECT forum_id, forum_link
				FROM " . FORUMS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error get forums list', '', __LINE__, __FILE__, $sql);
			}
			while ( $row = $db->sql_fetchrow($result) )
			{
				if ( empty($row['forum_link']) && strlen($row['forum_link']) < 5 )
				{
					$forums[] = $row['forum_id'];
				}
			}
			$db->sql_freeresult($result);
			$forums = (is_array($forums)) ? implode(',', $forums) : $forums;

			if ( $forums )
			{
				if ( isset($_GET['repair_w']) )
				{
					$sql_w = "DELETE FROM " . TOPICS_TABLE . "
							WHERE forum_id NOT IN($forums)";
					if ( !($result_w = $db->sql_query($sql_w)) )
					{
						message_die(GENERAL_ERROR, 'Error deleting topics', '', __LINE__, __FILE__, $sql_m);
					}
					$sql_w = "DELETE FROM " . READ_HIST_TABLE . "
							WHERE forum_id NOT IN($forums)";
					if ( !($result_w = $db->sql_query($sql_w)) )
					{
						message_die(GENERAL_ERROR, 'Error deleting topics', '', __LINE__, __FILE__, $sql_m);
					}
					die('<br /><br />' . $lang['topics_was_sync'] . '<br /><br />');
				}
				$sql_m = "SELECT topic_id, forum_id
					FROM " . TOPICS_TABLE . "
						WHERE forum_id NOT IN($forums)";
				if ( !($result_m = $db->sql_query($sql_m)) )
				{
					message_die(GENERAL_ERROR, 'Error get topic list', '', __LINE__, __FILE__, $sql_m);
				}
				while ( $row_m = $db->sql_fetchrow($result_m) )
				{
					$sql_results_name['without_forum']++;
					$wforum_ids[] = $row_m['topic_id'] . ' - ' . $row_m['forum_id'];
				}
				$db->sql_freeresult($result_m);
				if ( $sql_results_name['without_forum'] > 0 )
				{
					$echo_ids = '';
					for($i = 0; $i < count($wforum_ids); $i++)
					{
						$echo_ids .= ($echo_ids) ? ', [' . $wforum_ids[$i] . ']' : '[' . $wforum_ids[$i] . ']';
					}
					$print_result .= '<tr><td><br /><br />' . sprintf($lang['empty_topics'], $sql_results_name['without_forum'], $echo_ids, '<a href="' . $cf . '?mode=sql&amp;type=without_forum&amp;repair_w=1">', '</a>') . '</td></tr>';
				}
			}
		}
		if ( $type == 'forum_posts' || $type == 'forum_topics' || $type == 'forum_last_post_id' || $all )
		{
			$fids = $fposts_ids = $ftopics_ids = $flast_ids = array();
			$sql = "SELECT forum_id, forum_posts, forum_topics, forum_last_post_id
				FROM " . FORUMS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get forum data', '', __LINE__, __FILE__, $sql);
			}
			while ( $row = $db->sql_fetchrow($result) )
			{
				$fids[$row['forum_id']] = $row;
			}
			$db->sql_freeresult($result);
			
			if( !empty($fids) )
			{
				if ( $type == 'forum_posts' || $all )
				{
					$sql_posts = "SELECT forum_id, COUNT(post_id) AS posts
						FROM " . POSTS_TABLE . "
						WHERE forum_id IN(".implode(',', array_keys($fids)).")
						GROUP BY forum_id";
					if ( !($result_posts = $db->sql_query($sql_posts)) )
					{
						message_die(GENERAL_ERROR, 'Could not count forum posts', '', __LINE__, __FILE__, $sql_posts);
					}
					while( $row_post = $db->sql_fetchrow($result_posts) )
					{
						if ( $fids[$row_post['forum_id']]['forum_posts'] != $row_post['posts'] )
						{
							$sql_results_name['forum_posts']++;
							$fposts_ids[] = $row_post['forum_id'];
						}
					}
					$db->sql_freeresult($result_posts);
				}
				if ( $type == 'forum_topics' || $all )
				{
					$sql_topics = "SELECT forum_id, COUNT(topic_id) AS topics
						FROM " . TOPICS_TABLE . "
						WHERE forum_id IN(".implode(',', array_keys($fids)).")
						GROUP BY forum_id";
					if ( !($result_topics = $db->sql_query($sql_topics)) )
					{
						message_die(GENERAL_ERROR, 'Could not count forum posts', '', __LINE__, __FILE__, $sql_topics);	
					}
					while( $row_topics = $db->sql_fetchrow($result_topics) )
					{
						if ( $fids[$row_topics['forum_id']]['forum_topics'] != $row_topics['topics'] )
						{
							$sql_results_name['forum_topics']++;
							$ftopics_ids[] = $row_topics['forum_id'];
						}
					}
					$db->sql_freeresult($result_topics);
				}
                if ( $type == 'forum_last_post_id' || $all )
                {
                    $_fids = array_keys($fids);
                    foreach($_fids as $k=>$v)
                    {
                        $sql = "SELECT forum_id, post_id FROM ".POSTS_TABLE." WHERE forum_id=$v ORDER BY post_time DESC LIMIT 1";
                        $res = $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not get last forum post', '', __LINE__, __FILE__, $sql_last);
                        $row = $db->sql_fetchrow($res);

                        $_last = ($fids[$row['forum_id']]['forum_last_post_id']) ? $fids[$row['forum_id']]['forum_last_post_id'] : 0;
                        if ( $_last != $row['post_id'] )
                        {
                            $sql_results_name['forum_last_post_id']++;
                            $flast_ids[] = $row['forum_id'];
                        }
                    }
                }
			}

			if ( ($type == 'forum_posts' || $all) && $sql_results_name['forum_posts'] > 0 )
			{
				$echo_ids = '';
				for($i = 0; $i < count($fposts_ids); $i++)
				{
					$echo_ids .= '<a href="viewforum.'.$phpEx.'?' . POST_FORUM_URL . '=' . $fposts_ids[$i] . '">' . $fposts_ids[$i] . '</a>, ';
				}
				$print_result .= '<tr><td><br /><br />' . $lang['forums_wrong_posts'] . ': <b>' . $sql_results_name['forum_posts'] . '</b><br />Forum ID\'s: ' . $echo_ids . '</td></tr>';
			}
			if ( ($type == 'forum_topics' || $all) && $sql_results_name['forum_topics'] > 0 )
			{
				$echo_ids = '';
				for($i = 0; $i < count($ftopics_ids); $i++)
				{
					$echo_ids .= '<a href="viewforum.'.$phpEx.'?' . POST_FORUM_URL . '=' . $ftopics_ids[$i] . '">' . $ftopics_ids[$i] . '</a>, ';
				}
				$print_result .= '<tr><td><br /><br />' . $lang['forums_wrong_topics'] . ': <b>' . $sql_results_name['forum_topics'] . '</b><br />Forum ID\'s: ' . $echo_ids . '</td></tr>';
			}
			if ( ($type == 'forum_last_post_id' || $all) && $sql_results_name['forum_last_post_id'] > 0 )
			{
				$echo_ids = '';
				for($i = 0; $i < count($flast_ids); $i++)
				{
					$echo_ids .= '<a href="viewforum.'.$phpEx.'?' . POST_FORUM_URL . '=' . $flast_ids[$i] . '">' . $flast_ids[$i] . '</a>, ';
				}
				$print_result .= '<tr><td><br /><br />' . $lang['forums_wrong_last_post'] . ': <b>' . $sql_results_name['forum_last_post_id'] . '</b><br />Forum ID\'s: ' . $echo_ids . '</td></tr>';
			}
		}
		if ( ($type == 'polls' || $all) )
		{
			$list_polls = array();
			if ( $sql_results_name['polls'] )
			{
				$polls_ids = (is_array($polls_ids)) ? implode(', ', $polls_ids) : $polls_ids;
				$print_result .= '<tr><td><br /><br />' . $lang['polls_without_topics'] . ': <b>' . $sql_results_name['polls'] . '</b><br />Vote ID\'s: ' . $polls_ids . '</td></tr>';
			}

			$sql = "SELECT vote_id
				FROM " . VOTE_DESC_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get vote desc data', '', __LINE__, __FILE__, $sql);
			}
			while ( $row = $db->sql_fetchrow($result) )
			{
				$list_polls[] = $row['vote_id'];
			}
			$db->sql_freeresult($result);

			$list_polls = (is_array($list_polls)) ? implode(', ', $list_polls) : $list_polls;

			if ( $list_polls )
			{
				$sql_polls = "SELECT COUNT(r.vote_id) as vid, COUNT(v.vote_id) as vidv
					FROM (" . VOTE_DESC_TABLE . " r, " . VOTE_RESULTS_TABLE . " v)
					WHERE r.vote_id NOT IN($list_polls)
						OR v.vote_id NOT IN($list_polls)";
				if ( !($result_polls = $db->sql_query($sql_polls)) )
				{
					message_die(GENERAL_ERROR, 'Could not count vote desc from vote desc table', '', __LINE__, __FILE__, $sql_polls);	
				}
				$row_polls = $db->sql_fetchrow($result_polls);
				$vid = count($row_polls['vid']);
				$vidv = count($row_polls['vidv']);
				if ( $row_polls['vid'] )
				{
					$print_result .= '<tr><td><br /><br />' . $lang['votes_without_polls'] . ': <b>' . $vid . '</b></td></tr>';
				}
				if ( $row_polls['vidv'] )
				{
					$print_result .= '<tr><td><br /><br />' . $lang['voters_without_polls'] . ': <b>' . $vidv . '</b></td></tr>';
				}
			}
		}

       if ( ($type == 'users' || $all) )
        {
            $uids = array();

            $sql = "SELECT u.user_id, ug.group_id FROM " . USERS_TABLE . " u
			    LEFT JOIN " . USER_GROUP_TABLE . " AS ug ON u.user_id=ug.user_id
			    LEFT JOIN " . GROUPS_TABLE . " AS g ON ug.group_id=g.group_id AND g.group_single_user=1
			    WHERE ug.group_id IS NULL OR g.group_id IS NULL";
            $result = $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not get user id information', '', __LINE__, __FILE__, $sql);
            while($row = $db->sql_fetchrow($result)) $uids[$row['user_id']] = $row['group_id'];
            $db->sql_freeresult($result);

            if ( isset($_GET['repair_ug']) && !empty($uids) )
            {
                foreach($uids as $k => $v)
                {
                    if( $v != NULL ){
                        $sql_rep = "DELETE FROM " . USER_GROUP_TABLE . " WHERE user_id = " . $k;
                        $db->sql_query($sql_rep) or message_die(GENERAL_ERROR, 'Could not delete old user group data', '', __LINE__, __FILE__, $sql_rep);
                    }

                    $sql_rep = "INSERT INTO " . GROUPS_TABLE . " (group_name, group_description, group_single_user, group_moderator)
									VALUES ('', 'Personal User', 1, 0)";
                    $db->sql_query($sql_rep) or message_die(GENERAL_ERROR, 'Could not insert data into groups table', '', __LINE__, __FILE__, $sql_rep);

                    $group_id = $db->sql_nextid();

                    $sql_rep = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending)
									VALUES (" . $k . ", $group_id, 0)";
                    $db->sql_query($sql_rep) or message_die(GENERAL_ERROR, 'Could not insert data into user_group table', '', __LINE__, __FILE__, $sql_rep);
                }

                sql_cache('clear', 'groups_desc');
                sql_cache('clear', 'user_groups');
                sql_cache('clear', 'groups_data');

                unset($uids);

                $result = $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not get user id information', '', __LINE__, __FILE__, $sql);
                while($row = $db->sql_fetchrow($result)) $uids[$row['user_id']] = $row['group_id'];
                $db->sql_freeresult($result);
            }

            if ( !empty($uids) )
            {
                $gecho_ids = array();
                foreach($uids as $k=>$v)
                {
                    $gecho_ids[] = '<a href="profile.'.$phpEx.'?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $k . '">' . $k . '</a>';
                }
                $print_result .= '<tr><td><br /><br />' . sprintf($lang['users_without_groups'], count($uids), implode(',',$gecho_ids), '<a href="' . $cf . '?mode=sql&amp;type=users&amp;repair_ug=1">', '</a>') . '</td></tr>';
            }
        }

        if ( ($type == 'sync_unread_pms' || $all) )
        {
            $uid=array();
            $sql_pms = "SELECT COUNT(p.privmsgs_id)as total,p.privmsgs_to_userid,u.user_unread_privmsg 
						FROM " . PRIVMSGS_TABLE . " p, " . USERS_TABLE . " u 
						WHERE p.privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " 
                        AND p.privmsgs_to_userid=u.user_id GROUP BY p.privmsgs_to_userid";

            if(!$result_pms = $db->sql_query($sql_pms))
            {
                message_die(GENERAL_ERROR, 'Could not select info from privmsgs table', '', __LINE__, __FILE__, $sql_pms);
            }
            while($row_pms = $db->sql_fetchrow($result_pms))
            {
                if($row['user_unread_privmsg'] != $row['total'])
                {
                    $sql = "UPDATE ". USERS_TABLE. " SET user_unread_privmsg=".$row_pms['total']." WHERE user_id=".$row_pms['privmsgs_to_userid'];
                    $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not update user unread privmsg', '', __LINE__, __FILE__, $sql);
                }
                $uid[] = $row_pms['privmsgs_to_userid'];
            }

            if(!empty($uid))
            {
                $sql = "UPDATE ". USERS_TABLE. " SET user_unread_privmsg=0 WHERE user_id NOT IN(".implode(',',$uid).") AND user_unread_privmsg>0";
                $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not update user unread privmsg', '', __LINE__, __FILE__, $sql);
            }
        }

		echo ($print_result) ? '<tr><td><br /><font color="#FF0000"><b>' . $lang['SQL_unsync'] . '</b></font><br /><br /></td></tr>' . $print_result . '<tr><td><br />' . (($userdata['user_level'] == ADMIN) ? '<br /><b>' . $lang['SQL_unsync_e'] : '') . '</td></tr>' : '<tr><td><br /><font color="#009900"><b>' . (($all) ? $lang['SQL_sync'] : $lang['sync']) . '.</b></font></tr></td>';

		$time_end2 = microtime(true);
		$generated_time2 = round(($time_end2 - $time_start2), 2);

		echo '<tr><td><br /><hr /><font size="1">' . (($generated_time2 > 0) ? $lang['gentime'] . ': <b>' . $generated_time2 . '</b>s.<br />' : '') . $lang['SQL_queries'] . ': <b>' . $db->num_queries . '</b></font></td></tr>';

		echo '</table></td></tr></table></body></html>';
		$db->sql_close();
		exit;
	}

	if ( $userdata['user_level'] == ADMIN )
	{
		echo '<tr><td colspan="2"><a href="' . $cf.(($mode) ? '' : '?mode=sql') . '">' . (($mode) ? $lang['back'] : $lang['check_SQL']) . '</a></td></tr>';
	}
	echo '<tr><td colspan="2"><a href="index.php">Forum</a><br /><br /></td></tr>';
	if ( phpversion() < 4.1 )
	{
		$phpver = '<font color="#FF0000"><b>' . phpversion() . ' - ' . $lang['to_low_php'] . '</b></font>';
	}
	else
	{
		$phpver = phpversion() . ' - <font color="#009900"><b>OK</b></font>';
	}

	$sql = "SELECT VERSION() AS mysql_version";
	if ( $result = $db->sql_query($sql) )
	{
		$row = $db->sql_fetchrow($result);
		$version = $row['mysql_version'];
	}

	if ( $board_config['gzip_compress'] )
	{
		$l_gzip_compress = $lang['Yes'] . ' (' . $lang['forum_compress'] . ')';
	}
	else
	{
		$l_gzip_compress = '<font color="#FF0000"><b>' . $lang['No'] . '</b></font>';
	}
	$is_ob_gzhandler_started = false;
	if ( (@ini_get('zlib.output_compression') && (int)@ini_get('zlib.output_compression') != 0 && strtolower(@ini_get('zlib.output_compression')) != 'off') || @ini_get('output_handler') && strtolower(@ini_get('output_handler'))=='ob_gzhandler' )
	{
		$l_gzip_compress = $lang['Yes'] . ' (' . $lang['server_compress'] . ')';
	}

    //mod deflate in htaccess
    $mod_deflate_htaccess = $lang['No'];
    if( file_exists('.htaccess') )
    {
        $htacc = file_get_contents('.htaccess');
        if( strpos($htacc, '<IfModule mod_deflate.c>') != false ) $mod_deflate_htaccess = $lang['Yes'];
    }
	
	$apache_modules = (function_exists('apache_get_modules')) ? apache_get_modules() : false;
    if( $apache_modules && in_array('mod_deflate', $apache_modules) ) {
        $mod_deflate = '<span style="color:green;font-weight:bold;">'.$lang['Yes'].'</span>';
    }else{
        $mod_deflate = '<span style="color:red;font-weight:bold;">'.( (!$apache_modules) ? '?':$lang['No'] ).'</span>';
	}
	
	$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
	echo '<tr><td valign="top"><table border="0">';
	echo '<tr><td>' . $lang['domain_name'] . '</td><td>: ' . $board_config['server_name'] . '</font></td></tr>';
	echo '<tr><td>Check address</td><td>: ' . $board_config['check_address'] . '</td></tr>';
	echo '<tr><td>Cookie secure</td><td>: ' . $board_config['cookie_secure'] . '</td></tr>';
	echo '<tr><td>PHP version</td><td>: ' . $phpver . '</td></tr>';
	echo '<tr><td>' . $lang['gzip'] . '</td><td>: ' . $l_gzip_compress . '</td></tr>';
	echo '<tr><td>' . $lang['Wrong_sql_version'] . '</td><td>: ' . (($board_config['version'] != $dbversion) ? '<font color="#FF0000"><b>' . $board_config['version'] . '</b></font>' : $board_config['version'] . ' - <font color="#009900"><b>OK</b></font>') . '</td></tr>';
	echo '</table></td><td>&nbsp;&nbsp;&nbsp;</td><td valign="top"><table border="0">';
	echo '<tr><td>MySql version</td><td>: ' . $version . '</td></tr>';
	$cf_cache_work = 'Cache: <b>' . (($sql_work) ? $lang['Yes'] : (($sql_cache_enable) ? $lang['No'] : $lang['Disabled']));
	echo '<tr><td>MySql ping</td><td>: ' . (($sql_ping = $db->sql_ping()) ? $sql_ping . ' ms' : '-') . ', ' . $cf_cache_work . '</b></td></tr>';
	echo '<tr><td>Safe mode</td><td>: ' . ((@ini_get('safe_mode')) ? '<font color="#FF0000"><b>' . $lang['Yes'] . '</b></font>' : $lang['No'] . ' - <font color="#009900"><b>OK</b></font>') . ', Open basedir: <b>' . ((@$ini_val('open_basedir')) ? $lang['Yes'] : $lang['No']) . '</b></td></tr>';

	if (!( function_exists('imagecreatefromjpeg') ))
	{
		echo '<tr><td><font color="#FF0000"><b>imagecreatefromjpeg()</b></font></td><td>: <font color="#FF0000">' . $lang['function_ct_not_exists'] . '</b></td></tr>';
	}
	else
	{
		echo '<tr><td><b>imagecreatefromjpeg()</b></td><td>: ' . $lang['gd_loaded'] . ' - <font color="#009900"><b>OK</b></font></td></tr>';
	}
	if ( !( function_exists('imagecreate') ) && !( function_exists('imagecreate') ) )
	{
		echo '<tr><td><font color="#FF0000"><b>imagecreate()</b></font></td><td>: <font color="#FF0000">' . $lang['function_ct_not_exists'] . '</b></td></tr>';	
	}
	else
	{
		$gd_version = (function_exists('imagecreatetruecolor')) ? 2 : 1;
		echo '<tr><td><b>imagecreate()</b></td><td>: ' . sprintf($lang['function_gd'], $gd_version) . ' - <font color="#009900"><b>OK</b></font></td></tr>';
	}
	if (!@extension_loaded('zlib'))
	{
		echo '<tr><td><font color="#FF0000"><b>zlib</b></font></td><td>: <font color="#FF0000">' . $lang['function_zlip_not_exists'] . '</b></td></tr>';
	}
	else
	{
		echo '<tr><td><b>zlib</b></td><td>: ' . $lang['loaded'] . ' - <font color="#009900"><b>OK</b></font></b></td></tr>';	
	}
    echo '<tr><td><b>mod_deflate:</b></td><td>: '.$mod_deflate.' (htaccess gzip: '.$mod_deflate_htaccess.')</td></tr>';
	echo '</table>';
	echo '</tr></td></table><hr /><table><tr><td valign="top"><table border="0">';

	$files_check = array('tmp', 'files', 'files/tmp', 'files/thumbs', 'images/avatars', 'images/avatars/tmp', 'images/avatars/upload', 'images/avatars/upload/tmp', 'images/photos/tmp', 'images/signatures', 'images/signatures/tmp', 'cache');
	for($i = 0; $i < count($files_check); $i++)
	{
		if ( $i == 8 )
		{
			echo '</table></td><td>&nbsp;&nbsp;&nbsp;</td><td valign="top"><table border="0">';
		}
		if ( is_writable($phpbb_root_path . $files_check[$i]) )
		{
			echo '<tr><td nowrap="nowrap" valign="top">/<b>' . $files_check[$i] . '</b>/</td><td nowrap="nowrap">: ' . $lang['is_writable'] . ' - <font color="#009900"><b>OK</b></font></td></tr>';
		}
		else
		{
			echo '<tr><td valign="top"><font color="#FF0000">/<b>' . $files_check[$i] . '</b>/</font></td><td>: <font color="#FF0000"><b>' . $lang['not_writable'] . ' !</b></font> <font size="1">' . $lang['set_chmod'] . ' <b>chmod 777 ' . $files_check[$i] . '</b></font></td></tr>';
		}
	}
	echo '</table></td></tr></table>';

	$table_structure_error = $inserts_error = '';
	$sql = "SELECT VERSION() AS mysql_version";
	if( preg_match("/^(3\.23|4\.|5\.)/", $version) )
	{
		$db_name = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)|(5\.)/", $version) ) ? "`$dbname`" : $dbname;

		$sql = "SHOW TABLES
			FROM " . $db_name;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not show tables', '', __LINE__, __FILE__, $sql);
		}
		$tables = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$tables[] = preg_replace("/$table_prefix/", '', $row['Tables_in_' . $dbname], 1);
		}
		$db->sql_freeresult($result);

		$missing_tables = $missing_fields = '';

		foreach($tables_structure as $table => $val)
		{
			$missing_fields_table = '';
			if ( !(in_array($table, $tables)) )
			{
				$missing_tables .= (($missing_tables) ? ', ' : '') . $table_prefix . $table;
			}
			else
			{
				$sql = "SHOW COLUMNS
					FROM " . $table_prefix . $table;
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(CRITICAL_ERROR, 'Could not show columns from table: ' . $table_prefix . $table, '', __LINE__, __FILE__, $sql);
				}
				$table_fields = array();
				while ( $row = $db->sql_fetchrow($result) )
				{
					$table_fields[] = $row['Field'];
				}
				$db->sql_freeresult($result);
				foreach($val as $name)
				{
					if ( !(in_array($name, $table_fields)) )
					{
						$missing_fields_table .= (($missing_fields_table) ? ', ' : '') . $name;
					}
				}
				if ( $missing_fields_table )
				{
					$missing_fields .= (($missing_fields) ? '<br />' : '') . sprintf($lang['Missing_field'], '<b>' . $table_prefix . $table . '</b>') . ': <b>' . $missing_fields_table . '</b>';
				}
			}
		}
		if ( $missing_tables )
		{
			$table_structure_error .= '<font color="#FF0000">' . $lang['Missing_tables'] . ': <b>' . $missing_tables . '</b><br />';
		}
		if ( $missing_fields )
		{
			$table_structure_error .= '<font color="#FF0000">' . $missing_fields . '<br />';
		}
	}
	foreach($config_inserts as $table => $inserst)
	{
		$missing_inserts = '';
		$sql = "SELECT config_name
			FROM " . $table_prefix . $table;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not show inserts from table: ' . $table_prefix . $table, '', __LINE__, __FILE__, $sql);
		}
		$table_inserts = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$table_inserts[] = $row['config_name'];
		}
		$db->sql_freeresult($result);
		foreach($inserst as $name)
		{
			if ( !(in_array($name, $table_inserts)) )
			{
				$missing_inserts .= (($missing_inserts) ? ', ' : '') . $name;
			}
		}
		if ( $missing_inserts )
		{
			$inserts_error .= '<font color="#FF0000">' . sprintf($lang['Missing_inserts'], '<b>' . $table_prefix . $table . '</b>') . '</b>: <b>' . $missing_inserts . '</b><br />';
		}
	}
	$sql_structure_error = $table_structure_error . $inserts_error;

	if ( $sql_structure_error )
	{
		echo '<table width="100%"><tr><td><hr />' . $sql_structure_error . '</td></tr></table>';
	}
}

$dir = @opendir($phpbb_root_path . 'includes/mods_info/');
$mod_name = $add_size = array();
while (($filename = @readdir($dir)) !== false)
{
	if (@preg_match('/(\.php$)$/is', $filename))
	{
		$file = $phpbb_root_path . 'includes/mods_info/'.$filename;
		include($file);
	}
}
@closedir($dir);

if ( count($mod_name) > 0 )
{
	echo '<hr /><font color="#0033CC"><b>' . $lang['installed_mods'] . '</b>:</font><br />' . $contents;
	for($i=0; count($mod_name) > $i; $i++)
	{
		echo ($i+1) . ' - <b>' . xhtmlspecialchars(substr($mod_name[$i], 0, 80)) . '</b></br />';
	}
}

if ( isset($HTTP_GET_VARS['set_sum']) )
{
	for($i=0; count($file_list) > $i; $i++)
	{
		$md5_set_sum = md5_checksum($phpbb_root_path . $file_list[$i] . '');
		echo '$md5_sum[\'' . ((@preg_match('/(\.php$)$/is', $file_list[$i])) ? str_replace('.php', '.\'.$phpEx', $file_list[$i]) . ']' : $file_list[$i] . '\']') . ' = \'' . $md5_set_sum . '\';<br />';
	}
	exit;
}

if ( isset($HTTP_GET_VARS['set_size']) )
{
	for($i=0; count($file_list) > $i; $i++)
	{
		$sizes = strlen_used_chars($phpbb_root_path . $file_list[$i] . '');
		echo '$sizes[\'' . ((@preg_match('/(\.php$)$/is', $file_list[$i])) ? str_replace('.php', '.\'.$phpEx', $file_list[$i]) . ']' : $file_list[$i] . '\']') . ' = \'' . $sizes . '\';<br />';
	}
	exit;
}

echo '<hr /><table><tr><td><b>' . $lang['fcr'] . '</b></td></tr></table>';

$result = '';
for($i=0; count($file_list) > $i; $i++)
{
	if ( md5_checksum($file_list[$i]) != trim($md5_sum[$file_list[$i]]) )
	{
		$content = md5_checksum($file_list[$i]);
		$filesize = strlen_used_chars($phpbb_root_path . $file_list[$i]);
		$mod_file = (isset($add_size[$file_list[$i]])) ? true : false;
		if ( !$mod_file || ($filesize != $sizes[$file_list[$i]] + $add_size[$file_list[$i]]) )
		{
			$file_name = ($add_size[$file_list[$i]]) ? '<font color="#0033CC">' . $file_list[$i] . '</font>' : $file_list[$i];
			$result .= ($content) ? '
			<tr>
				<td><b><font style="font-family: Arial, Helvetica; font-size: 11px;">' . $file_name . '</font></b></td>
				<td nowrap="nowrap">: <b><font style="font-family: Arial; font-size: 11px;" color="#FF0000">' . $lang['wrong_content'] . ' !</font></b><font style="font-family: Arial; font-size: 11px;"> [ ' . $content . ' ] &gt; [ ' . trim($md5_sum[$file_list[$i]]) . ' ]</font> </td>
				<td align="right" nowrap="nowrap"><font style="font-family: Arial; font-size: 11px;"> ' . $filesize . ' - ' . $sizes[$file_list[$i]] . ' (' . ($filesize - $sizes[$file_list[$i]] - $add_size[$file_list[$i]]) . ')</font></td>
			</tr>
			' : '
			<tr>
				<td><font color="#FF0000" style="font-family: Arial, Helvetica; font-size: 11px;"><b>' . $file_list[$i] . '</b></font></td><td>: <b>' . $lang['file_missing'] . ' !</b></td>
			</tr>';
			$wrong_content = true;
		}
		else if ($mod_file)
		{
			$result .= ($content) ? '
			<tr>
				<td><b><font color="#0033CC" style="font-family: Arial, Helvetica; font-size: 11px;">' . $file_list[$i] . '</font></b></td>
				<td nowrap="nowrap">: <b><font color="#009900" style="font-family: Arial; font-size: 11px;">' . $lang['modified'] . ' </font></b><font style="font-family: Arial; font-size: 11px;"> [ ' . $content . ' ] &gt; [ ' . trim($md5_sum[$file_list[$i]]) . ' ]</font> </td>
				<td align="right" nowrap="nowrap"><font style="font-family: Arial; font-size: 11px;"> ' . $filesize . ' - ' . $sizes[$file_list[$i]] . ' (' . ($filesize - $sizes[$file_list[$i]] - $add_size[$file_list[$i]]) . ')</font></td>
			</tr>
			' : '
			<tr>
				<td><font color="#FF0000" style="font-family: Arial, Helvetica; font-size: 11px;"><b>' . $file_list[$i] . '</b></font></td><td>: <b>' . $lang['file_missing'] . ' !</b></td>
			</tr>';
		}
	}
}
$echo = ( $result ) ? '
<table border="0">
	<tr>
		 <td><font size="2">' . $lang['filename'] . '</font> </td>
		 <td nowrap="nowrap" align="center"><font size="1">[ ' . $lang['checksum_current'] . ' ] &gt; [ ' . $lang['checksum_correct'] . ' ] </td>
		 <td align="right" nowrap="nowrap"><font size="1"> ' . $lang['count_chr'] . '</font></td>
	</tr>
	' . $result . '
</table>
<table>
	<tr>
		 <td>&nbsp;</td>
	</tr>
	<tr>
		 <td>' . (($wrong_content) ? '<font color="#FF0000">' . $lang['result_e'] : '<font color="#009900"><b>' . sprintf($lang['all_files_ok'], count($file_list)) . ' !</b>') . '</font></td>
	</tr>
</table>
' : '
<table>
	<tr>
		 <td>&nbsp;</td>
	</tr>
	<tr>
		 <td><font color="#009900"><b>' . sprintf($lang['all_files_ok'], count($file_list)) . ' !</b></font></td>
	</tr>
	' . $result . '
</table>';
echo $echo . '</td></tr></table></body></html>';

@$db->sql_close();
exit;

?>