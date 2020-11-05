<?php
/***************************************************************************
 *                functions_remove.php
 *                -------------------
 *   begin        : 10, 03, 2005
 *   copyright    : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   email        : przemo@przemo.org
 *   version      : ver. 1.12.3 2005/10/04 13:18
 *
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

// All mechanisms for delete post, topic or user are very poor in all mod's ...
// And in the originally phpBB for example when user was delete, his avatar stay in the directory.
// So I decide to write completly and right functions.
// It's not so easy look like ...

function delete_post($post_id)
{
	global $db;

	delete_post_replies($post_id);

	$sql = "SELECT t.topic_first_post_id, t.topic_last_post_id, p.forum_id, p.poster_id, p.topic_id, f.forum_last_post_id, u.user_posts
	FROM (" . TOPICS_TABLE . " t, " . POSTS_TABLE . " p, " . FORUMS_TABLE . " f, " . USERS_TABLE . " u)
		WHERE p.post_id = $post_id
			AND t.topic_id = p.topic_id
			AND t.forum_id = f.forum_id
			AND p.poster_id = u.user_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error get post info', '', __LINE__, __FILE__, $sql);
	}

	if ( $info_row = $db->sql_fetchrow($result) )
	{
		$topic_id = $info_row['topic_id'];
		$forum_id = $info_row['forum_id'];

		if ( $info_row['topic_first_post_id'] == $post_id && $info_row['topic_last_post_id'] == $post_id )
		{
			delete_topic($topic_id, $forum_id, true);
			return;
		}

		delete_this_post($post_id);

		if ( $info_row['poster_id'] != ANONYMOUS && no_post_count($forum_id) && $info_row['user_posts'] > 0 )
		{
			$sql = "UPDATE " . USERS_TABLE . "
				SET user_posts = user_posts -1
				WHERE user_id = " . $info_row['poster_id'];
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error updating user posts', '', __LINE__, __FILE__, $sql);
			}
		}

		if ( $info_row['topic_last_post_id'] == $post_id )
		{
			$sql = "SELECT MAX(post_id) AS last_post
				FROM " . POSTS_TABLE . "
				WHERE topic_id = $topic_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error obtain topic information', '', __LINE__, __FILE__, $sql);
			}
			if ( !($posts_row = $db->sql_fetchrow($result)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic last post', '', __LINE__, __FILE__, $sql);
			}

			$update_last_post_sql = "topic_last_post_id = " . (($posts_row['last_post']) ? $posts_row['last_post'] : 0) . ", ";
		}
		else if ( $info_row['topic_first_post_id'] == $post_id )
		{
			$sql = "SELECT MIN(post_id) AS first_post
				FROM " . POSTS_TABLE . "
				WHERE topic_id = $topic_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error obtain topic information', '', __LINE__, __FILE__, $sql);
			}
			if ( !($posts_row = $db->sql_fetchrow($result)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic last post', '', __LINE__, __FILE__, $sql);
			}

			$update_last_post_sql = "topic_first_post_id = " . (($posts_row['first_post']) ? $posts_row['first_post'] : 0) . ", ";
		}
		else
		{
			$update_last_post_sql = '';
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET $update_last_post_sql topic_replies = topic_replies - 1
				WHERE topic_id = $topic_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error update topics data', '', __LINE__, __FILE__, $sql);
		}

		if ( $info_row['forum_last_post_id'] == $post_id )
		{
			$sql = "SELECT MAX(post_id) AS last_post, COUNT(post_id) AS total 
				FROM " . POSTS_TABLE . "
				WHERE forum_id = " . $forum_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error get post ID', '', __LINE__, __FILE__, $sql);
			}
			if ( $post_row = $db->sql_fetchrow($result) )
			{
				$last_post = ($post_row['last_post']) ? $post_row['last_post'] : 0;
				$total_posts = ($post_row['total']) ? $post_row['total'] : 0;
			}
			else
			{
				$last_post = 0;
				$total_posts = 0;
			}
			$forum_update_sql = "forum_posts = $total_posts, forum_last_post_id = $last_post";
		}
		else
		{
			$forum_update_sql = 'forum_posts = forum_posts - 1';
		}

		$sql = "UPDATE " . FORUMS_TABLE . "
			SET $forum_update_sql
			WHERE forum_id = $forum_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error update forum', '', __LINE__, __FILE__, $sql);
		}

		sql_cache('clear', 'multisqlcache_forum');
		sql_cache('clear', 'forum_data');

		$sql = "DELETE FROM " . READ_HIST_TABLE . "
			WHERE post_id = $post_id";
		$db->sql_query($sql);
	}
	return;
}

function delete_this_post($post_id, $make_db_stat = true)
{
	global $db, $phpbb_root_path, $phpEx, $board_config, $table_prefix;

	$post_id = (is_array($post_id)) ? implode(', ', $post_id) : implode(', ', array($post_id));

	$sql = "DELETE FROM " . POSTS_TABLE . "
		WHERE post_id IN($post_id)";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . POSTS_TEXT_TABLE . "
		WHERE post_id IN($post_id)";
	$db->sql_query($sql);
	
	$sql = "DELETE FROM " . POSTS_HISTORY_TABLE . " WHERE th_post_id IN($post_id)";
	$db->sql_query($sql);

	if ( $board_config['search_enable'] )
	{
		require_once($phpbb_root_path . 'includes/functions_search.'.$phpEx);
		remove_search_post($post_id);
	}

	if ( !function_exists('delete_attachment') )
	{
		require_once($phpbb_root_path . 'attach_mod/attachment_mod.'.$phpEx);
	}
	delete_attachment(explode(', ', $post_id));
	if ( !is_array($post_id) && $make_db_stat )
	{
		db_stat_update('posttopic');
	}

	return;
}

function delete_poll_data($topic_id)
{
	global $db;

	$topic_id = (is_array($topic_id)) ? implode(', ', $topic_id) : implode(', ', array($topic_id));

	$sql = "SELECT vote_id 
		FROM " . VOTE_DESC_TABLE . " 
		WHERE topic_id IN ($topic_id)";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get vote id information', '', __LINE__, __FILE__, $sql);
	}

	$vote_id_sql = '';
	while ( $row = $db->sql_fetchrow($result) )
	{
		$vote_id_sql .= ( ( $vote_id_sql != '' ) ? ', ' : '' ) . $row['vote_id'];
	}
	$db->sql_freeresult($result);

	if ( $vote_id_sql )
	{
		$sql = "DELETE FROM " . VOTE_DESC_TABLE . "
			WHERE vote_id IN($vote_id_sql)";
		$db->sql_query($sql);

		$sql = "DELETE FROM " . VOTE_RESULTS_TABLE . "
			WHERE vote_id IN($vote_id_sql)";
		$db->sql_query($sql);

		$sql = "DELETE FROM " . VOTE_USERS_TABLE . "
			WHERE vote_id IN($vote_id_sql)";
		$db->sql_query($sql);
	}
	return;
}

function delete_topic($topics_id, $forum_id = '', $do_sync = true)
{ // Delete only from one forum
	global $db, $phpbb_root_path, $phpEx, $board_config;

	$topics_forum_id = (is_array($topics_id)) ? $topics_id[0] : $topics_id;
	$topics_id = (is_array($topics_id)) ? implode(', ', $topics_id) : implode(', ', array($topics_id));

	if ( !$forum_id )
	{
		$sql = "SELECT forum_id
		FROM " . TOPICS_TABLE . "
			WHERE topic_id = $topics_forum_id";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error get topic info', '', __LINE__, __FILE__, $sql);
		}

		if ( !($row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_ERROR, 'Could not get topic info', '', __LINE__, __FILE__, $sql);
		}

		$forum_id = $row['forum_id'];
	}

	if ( no_post_count($forum_id) )
	{
		$sql = "SELECT p.poster_id, COUNT(p.post_id) AS posts, u.user_posts
			FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u)
			WHERE p.topic_id IN ($topics_id)
				AND u.user_id <> " . ANONYMOUS . "
				AND p.poster_id = u.user_id
			GROUP BY p.poster_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
		}

		$count_sql = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if($row['user_posts'] > 0)
			{
				$max_posts = ($row['posts'] > $row['user_posts']) ? $row['user_posts'] : $row['posts'];
				$count_sql[] = "UPDATE " . USERS_TABLE . " 
					SET user_posts = user_posts - " . $max_posts . "
					WHERE user_id = " . $row['poster_id'];
			}
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

	$sql = "SELECT post_id 
		FROM " . POSTS_TABLE . " 
		WHERE topic_id IN ($topics_id)";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get post id information', '', __LINE__, __FILE__, $sql);
	}

	$post_id_sql = array();;
	while ( $row = $db->sql_fetchrow($result) )
	{
		$post_id_sql[] = $row['post_id'];
	}
	$db->sql_freeresult($result);

	$post_id_sql = implode(', ', $post_id_sql);

	// Got all required info so go ahead and start deleting everything
	$sql = "DELETE 
		FROM " . TOPICS_TABLE . " 
		WHERE topic_id IN ($topics_id) 
			OR topic_moved_id IN ($topics_id)";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not delete topics', '', __LINE__, __FILE__, $sql);
	}

	if ( $post_id_sql )
	{
		delete_this_post($post_id_sql, false);
	}

	delete_poll_data($topics_id);

	$sql = "DELETE
		FROM " . TOPICS_WATCH_TABLE . "
		WHERE topic_id IN ($topics_id)";
	$db->sql_query($sql);

	$sql = "DELETE
		FROM " . TOPIC_VIEW_TABLE . "
		WHERE topic_id IN ($topics_id)";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . READ_HIST_TABLE . "
		WHERE topic_id IN($topics_id)";
	$db->sql_query($sql);

	if ( $board_config['ignore_topics'] )
	{
		$sql = "DELETE FROM " . TOPICS_IGNORE_TABLE . "
			WHERE topic_id IN ($topics_id)";
		$db->sql_query($sql);
	}

	if ( !(function_exists('sync')) )
	{
		require_once($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
	}
	if ( $do_sync )
	{
		sync('forum', $forum_id);
	}
	db_stat_update('posttopic');
	$db->sql_freeresult($result);
	return;
}

function delete_user($user_id, $username = '')
{
	global $db, $board_config, $phpbb_root_path, $phpEx, $userdata;

	if ( $user_id == ANONYMOUS ) return;

	if ( !$username )
	{
		$sql = "SELECT username, user_email
			FROM " . USERS_TABLE . "
			WHERE user_id = $user_id";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query users table', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$username = $row['username'];
		$user_email = $row['user_email'];
	}

	$sql = "SELECT g.group_id
		FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
		WHERE ug.user_id = $user_id
			AND g.group_id = ug.group_id
			AND g.group_single_user = 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain group information for this user', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);

	$sql = "UPDATE " . POSTS_TABLE . "
		SET poster_id = " . DELETED . ", post_username = '" . str_replace("\\'", "''", addslashes($username)) . "', poster_delete = 1
		WHERE poster_id = $user_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update posts for this user', '', __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_action_user = " . DELETED . "
		WHERE topic_action_user = $user_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update posts for this user', '', __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_poster = " . DELETED . " 
		WHERE topic_poster = $user_id";
	$db->sql_query($sql);

	$sql = "UPDATE " . VOTE_USERS_TABLE . "
		SET vote_user_id = " . DELETED . "
		WHERE vote_user_id = $user_id";
	$db->sql_query($sql);

	$group_moderator = $mark_list = array();

	$sql = "SELECT group_id
		FROM " . GROUPS_TABLE . "
		WHERE group_moderator = $user_id";
	$result = $db->sql_query($sql);

	while ( $row_group = $db->sql_fetchrow($result) )
	{
		$group_moderator[] = $row_group['group_id'];
	}

	if ( count($group_moderator) )
	{
		$update_moderator_id = implode(', ', $group_moderator);
					
		$sql = "UPDATE " . GROUPS_TABLE . "
			SET group_moderator = " . $userdata['user_id'] . "
			WHERE group_moderator IN ($update_moderator_id)";
		$db->sql_query($sql);
	}

	$sql = "SELECT user_avatar, user_avatar_type, user_sig_image, user_photo, user_photo_type
		FROM " . USERS_TABLE . "
		WHERE user_id = $user_id";
	$db->sql_query($sql);

	$row_img = $db->sql_fetchrow($result);

	if ( $row_img['user_avatar_type'] == USER_AVATAR_UPLOAD && $row_img['user_avatar'] )
	{
		if ( @file_exists($phpbb_root_path . $board_config['avatar_path'] . '/' . $row_img['user_avatar']) )
		{
			@unlink($phpbb_root_path . $board_config['avatar_path'] . '/' . $row_img['user_avatar']);
		}
	}
	if ( $row_img['user_sig_image'] )
	{
		if ( @file_exists($phpbb_root_path . $board_config['sig_images_path'] . '/' . $row_img['user_sig_image']) )
		{
			@unlink($phpbb_root_path . $board_config['sig_images_path'] . '/' . $row_img['user_sig_image']);
		}
	}
	if ( $row_img['user_photo_type'] == USER_AVATAR_UPLOAD && $row_img['user_photo'] )
	{
		if ( @file_exists($phpbb_root_path . $board_config['photo_path'] . '/' . $row_img['user_photo']) )
		{
			@unlink($phpbb_root_path . $board_config['photo_path'] . '/' . $row_img['user_photo']);
		}
	}

	$sql = "DELETE FROM " . USERS_TABLE . "
		WHERE user_id = $user_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not delete user', '', __LINE__, __FILE__, $sql);
	}

	$sql = "DELETE FROM " . ADV_PERSON_TABLE . "
		WHERE user_id = $user_id";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . ADV_PERSON_TABLE . "
		WHERE person_id = $user_id";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . USER_GROUP_TABLE . "
		WHERE user_id = $user_id";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . GROUPS_TABLE . "
		WHERE group_id = " . $row['group_id'];
	$db->sql_query($sql);

	sql_cache('clear', 'groups_desc');
	sql_cache('clear', 'user_groups');
	sql_cache('clear', 'groups_data');
	sql_cache('clear', 'moderators_list');

	$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
		WHERE group_id = " . $row['group_id'];
	$db->sql_query($sql);

	$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
		WHERE user_id = $user_id";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . BANLIST_TABLE . "
		WHERE ban_userid = $user_id";
	$db->sql_query($sql);

	$sql = "SELECT privmsgs_id
		FROM " . PRIVMSGS_TABLE . "
		WHERE privmsgs_from_userid = $user_id
			OR privmsgs_to_userid = $user_id";
	$result = $db->sql_query($sql);

	// This little bit of code directly from the private messaging section.
	// Thanks Paul!
	while ( $row_privmsgs = $db->sql_fetchrow($result) )
	{
		$mark_list[] = $row_privmsgs['privmsgs_id'];
	}

	if ( count($mark_list) )
	{
		$delete_sql_id = implode(', ', $mark_list);

		// We shouldn't need to worry about updating conters here...
		// They are already gone!
		$delete_text_sql = "DELETE FROM " . PRIVMSGS_TEXT_TABLE . " WHERE privmsgs_text_id IN ($delete_sql_id)";
		$delete_sql = "DELETE FROM " . PRIVMSGS_TABLE . " WHERE privmsgs_id IN ($delete_sql_id)";

		// Shouldn't need the switch statement here, either, as we just want
		// to take out all of the private messages. This will not affect
		// the other messages we want to keep; the ids are unique.
		$db->sql_query($delete_sql);
		$db->sql_query($delete_text_sql);
	}

	$sql = "DELETE FROM " . WARNINGS_TABLE . "
		WHERE userid = $user_id";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . READ_HIST_TABLE . "
		WHERE user_id = $user_id";
	$db->sql_query($sql);

	if ( $board_config['ignore_topics'] )
	{
		$sql = "DELETE FROM " . TOPICS_IGNORE_TABLE . "
			WHERE user_id = $user_id";
		$db->sql_query($sql);
	}
	
    $sql = "DELETE FROM " . IGNORE_TABLE . " WHERE user_id = $user_id OR user_ignore = $user_id";
    $db->sql_query($sql);

    $sql = "DELETE FROM " . JR_ADMIN_TABLE . " WHERE user_id = $user_id";
    $db->sql_query($sql);

	$sql = "DELETE FROM " . SHOUTBOX_TABLE . "
		WHERE sb_user_id = $user_id";
	$db->sql_query($sql);

	sql_cache('clear', 'sb_count');

	$sql = "DELETE FROM " . TOPIC_VIEW_TABLE . "
		WHERE user_id = $user_id";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . SESSIONS_TABLE . "
		WHERE session_user_id = $user_id";
	$db->sql_query($sql);

	$sql = "DELETE FROM " . SESSIONS_KEYS_TABLE . "
		WHERE user_id = $user_id";
	$db->sql_query($sql);

	db_stat_update('newestuser');

	if ( $board_config['del_user_notify'] && $user_email )
	{
		global $lang;
		require_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
		$emailer = new emailer($board_config['smtp_delivery']);

		$emailer->from($board_config['email_from']);
		$emailer->replyto($board_config['email_return_path']);

		$emailer->use_template('deluser_notify', $board_config['default_lang']);
		$emailer->email_address($user_email);
		$emailer->set_subject(sprintf($lang['Account_delete'], $board_config['sitename']));

		$emailer->assign_vars(array(
			'USERNAME' => $username,
			'SITENAME' => $board_config['sitename'],
			'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '')
		);

		$emailer->send();
		$emailer->reset();
	}
	return;
}

if ( !function_exists('prune_attachments') )
{
	function prune_attachments($sql_post)
	{
		global $phpbb_root_path, $phpEx;
		require_once($phpbb_root_path . 'attach_mod/includes/functions_delete.'.$phpEx);	
		//
		// Yeah, prune it.
		//
		delete_attachment($sql_post);
	}
}

function prune($forum_id, $prune_date, $mode = '')
{
	global $db, $lang;

	$sql = "SELECT t.topic_id 
		FROM " . POSTS_TABLE . " p, " . TOPICS_TABLE . " t
		WHERE t.forum_id = $forum_id
			AND ( p.post_id = t.topic_last_post_id 
				OR t.topic_last_post_id = 0 )";
	if ( $prune_date )
	{
		$sql .= " AND p.post_time < $prune_date";
	}
	if ( $mode != 'everything' )
	{
		$sql .= " AND t.topic_vote = 0 AND t.topic_type <> " . POST_ANNOUNCE . " AND t.topic_type <> " . POST_STICKY . " AND t.topic_type <> " . POST_GLOBAL_ANNOUNCE;
	}

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain lists of topics to prune', '', __LINE__, __FILE__, $sql);
	}

	@set_time_limit('300');

	$deleted_topics = '';
	while( $row = $db->sql_fetchrow($result) )
	{
		$deleted_topics++;
		delete_topic($row['topic_id'], $forum_id, $do_sync = false);
	}
	$db->sql_freeresult($result);

	db_stat_update('posttopic');

	if( $deleted_topics != '' )
	{
		return $deleted_topics;
	}

	return 0;
}

//
// Function auto_prune(), this function will read the configuration data from
// the auto_prune table and call the prune function with the necessary info.
//
function auto_prune($forum_id = 0)
{
	global $db, $lang;

	$sql = "SELECT *
		FROM " . PRUNE_TABLE . "
		WHERE forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not read auto_prune table', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['prune_freq'] && $row['prune_days'] )
		{
			$prune_date = CR_TIME - ( $row['prune_days'] * 86400 );
			$next_prune = CR_TIME + ( $row['prune_freq'] * 86400 );

			prune($forum_id, $prune_date);
			sync('forum', $forum_id);

			$sql = "UPDATE " . FORUMS_TABLE . " 
				SET prune_next = $next_prune 
				WHERE forum_id = $forum_id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update forum table', '', __LINE__, __FILE__, $sql);
			}
			sql_cache('clear', 'multisqlcache_forum');
			sql_cache('clear', 'forum_data');
		}
	}

	db_stat_update('posttopic');

	return;
}

function delete_post_replies($post_id)
{
	global $db;

	if ( $post_id < 1 )
	{
		return;
	}
	$sql = "SELECT post_id
		FROM " . POSTS_TABLE . " 
		WHERE post_parent = $post_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get parent posts information', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		delete_post($row['post_id']);
	}

	return;
}

?>