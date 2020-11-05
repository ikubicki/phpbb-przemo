<?php
/***************************************************************************
 *                      read_history.php
 *                      -------------------
 *   begin              : 26.10.2005
 *   copyright          : (C) Przemo www.przemo.org/phpBB2/
 *   email              : przemo@przemo.org
 *   version            : 1.12.5
 *
 ***************************************************************************/

/***************************************************************************
 *	 This program is free software; you can redistribute it and/or modify
 *	 it under the terms of the GNU General Public License as published by
 *	 the Free Software Foundation; either version 2 of the License, or
 *	 (at your option) any later version.
 ***************************************************************************/

function user_unread_posts()
{
	global $db, $board_config, $userdata, $tree;

	$userdata['unread_data'] = $no_auth_forums = $remove_from_forums = $pids = array();

	$no_auth_ids = '';
	foreach( $tree['keys'] as $key => $val )
	{
		if ( substr($key, 0, 1) == POST_FORUM_URL && (!$tree['auth'][$key]['auth_read'] || !$tree['auth'][$key]['auth_view']))
		{
			$cur_forum_id = str_replace(POST_FORUM_URL, '', $key);
			$no_auth_ids .= ($no_auth_ids) ? ', ' . $cur_forum_id : $cur_forum_id;
			$no_auth_forums[] = $cur_forum_id;
		}
	}
	
	$sql = "SELECT post_id, topic_id, forum_id
		FROM " . READ_HIST_TABLE . "
		WHERE user_id = " . $userdata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query last visit posts', '', __LINE__, __FILE__, $sql);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		if ( !in_array($row['forum_id'], $no_auth_forums) )
		{
            $pids[$row['post_id']] = true;
			$userdata['unread_data'][$row['forum_id']][$row['topic_id']][] = $row['post_id'];
		}
		else
		{
			if ( !in_array($row['forum_id'], $remove_from_forums) )
			{
				$remove_from_forums[] = $row['forum_id'];
			}
		}
	}
	if ( count($remove_from_forums) )
	{
		$sql = "DELETE FROM " . READ_HIST_TABLE . "
			WHERE user_id = " . $userdata['user_id'] . "
			AND forum_id IN(" . implode(', ', $remove_from_forums) . ")";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete from read history table', '', __LINE__, __FILE__, $sql);
		}
	}

	if ( $board_config['lastpost'] > $userdata['read_tracking_last_update'] )
	{
		$sql = "UPDATE " . USERS_TABLE . "
			SET read_tracking_last_update = " . CR_TIME . "
			WHERE user_id = " . $userdata['user_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
		}
		if ( !$userdata['read_tracking_last_update'] || $userdata['user_session_start'] < ( CR_TIME-(3*(30*86400)) ) )
		{
			return $userdata;
		}

		$user_rh = $new_rh = array();
		$ignore_topics_table = $ignore_topics_sql = '';
		if ( $board_config['ignore_topics'] && $userdata['session_logged_in'] )
		{
			$ignore_topics_table = "LEFT JOIN " . TOPICS_IGNORE_TABLE . " i ON (i.topic_id = p.topic_id AND i.user_id = " . $userdata['user_id'] . ")";
			$ignore_topics_sql = "AND i.topic_id IS NULL";
		}

		$select_sql = "p.post_id, p.topic_id, p.forum_id
			FROM (" . POSTS_TABLE . " p)
			$ignore_topics_table
			WHERE p.post_time > " . $userdata['read_tracking_last_update'] . "
				AND p.poster_id <> " . $userdata['user_id'] . "
				$ignore_topics_sql
				" . (($no_auth_ids) ? "AND p.forum_id NOT IN($no_auth_ids)" : "");

		$sql = "SELECT $select_sql";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query new topic information', '', __LINE__, __FILE__, $sql);
		}
		$userdata['read_tracking_last_update'] = CR_TIME;
		$insert = 0;

		while( $row = $db->sql_fetchrow($result) )
		{
            if( !isset($pids[$row['post_id']]) ) {
                $user_rh[$row['post_id']] = $row;
                $new_rh[$row['post_id']]  = "(" . $userdata['user_id'] . "," . $row['post_id'] . "," . $row['topic_id'] . "," . $row['forum_id'] . ")";
                $userdata['unread_data'][$row['forum_id']][$row['topic_id']][] = $row['post_id'];
                $insert++;
            }
		}
		if ( $insert )
		{
			if ( (unread_forums_posts('count') + $insert) > $board_config['rh_max_posts'] && $userdata['user_level'] == USER && !$userdata['user_jr'] )
			{
				$sql = "SELECT post_id FROM " . POSTS_TABLE . "
					WHERE post_time > " . (CR_TIME - ($board_config['rh_without_days'] * 24 * 3600));
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query posts information', '', __LINE__, __FILE__, $sql);
				}
                $base_last_posts = array();
                while($row = $db->sql_fetchrow($result)) $base_last_posts[] = $row['post_id'];

                $last_posts = implode(',', $base_last_posts);

				$no_last_posts = ($last_posts) ? "AND post_id NOT IN($last_posts)" : '';

				$sql = "SELECT COUNT(*) as total
					FROM " . READ_HIST_TABLE . "
					WHERE user_id = " . $userdata['user_id'] . "
					$no_last_posts";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not count posts from read history table', '', __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);

				if ( ($row['total'] + $insert) > 19 )
				{
					$sql = "DELETE FROM " . READ_HIST_TABLE . "
						WHERE user_id = " . $userdata['user_id'] . "
						$no_last_posts";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not delete from read history table', '', __LINE__, __FILE__, $sql);
					}
					$pruned_posts = $db->sql_affectedrows();

					if ( $last_posts )
					{
                        $new_value = array();
                        foreach($base_last_posts as $k => $v) {
                            if(!empty($user_rh[$v])) {
                                $new_value[] = "('" . $userdata['user_id'] . "', '" . $user_rh[$v]['post_id'] . "', '" . $user_rh[$v]['topic_id'] . "', '" . $user_rh[$v]['forum_id'] . "')";
                            }
                        }

                        if(!empty($new_value)) {
                            $sql = "INSERT IGNORE INTO " . READ_HIST_TABLE . " (user_id, post_id, topic_id, forum_id)
                                    VALUES " . implode(',', $new_value);
                            $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not insert into read history table', '', __LINE__, __FILE__, $sql);
                        }
					}
					global $lang;
					message_die(GENERAL_MESSAGE, sprintf($lang['Pruning_unread_posts'], $board_config['rh_max_posts'], $board_config['rh_without_days'], ($pruned_posts + $insert)));
				}
			}

            if(!empty($new_rh)) {
                $sql = "INSERT IGNORE INTO " . READ_HIST_TABLE . " (user_id, post_id, topic_id, forum_id)
                        VALUES " . implode(',', $new_rh);
                $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not insert into read history table', '', __LINE__, __FILE__, $sql);
            }

            if( (CR_TIME-86400) >= $board_config['last_prune'] )
            {
                $sec_to_prune = ($board_config['day_to_prune']) ? ($board_config['day_to_prune'] * 24 * 3600) : 3024000;
                $user_ids = array();

                $sql = "SELECT u.user_id FROM (" . USERS_TABLE . " u, " . READ_HIST_TABLE . " r)
					WHERE u.user_id = r.user_id
					AND u.user_lastvisit < " . (CR_TIME - $sec_to_prune) . "
					AND u.user_id <> " . ANONYMOUS . "
					AND u.user_level = " . USER . "
					AND u.user_id <> " . $userdata['user_id'] . "
					GROUP by r.user_id";
                if ( !($result = $db->sql_query($sql)) )
                {
                    message_die(GENERAL_ERROR, 'Could not query users table', '', __LINE__, __FILE__, $sql);
                }
                while( $row = $db->sql_fetchrow($result) ) $user_ids[] = $row['user_id'];

                if ( !empty($user_ids) )
                {
                    $sql = "DELETE FROM " . READ_HIST_TABLE . " WHERE user_id IN (" . implode(',',$user_ids) . ")";
                    $result = $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Could not delete from read history table', '', __LINE__, __FILE__, $sql);
                }

               	$sql = update_config('last_prune', CR_TIME);
            }
		}
	}

	$db->sql_freeresult($result);

	return $userdata;
}

function unread_forums_posts($mode, $forum_id = false)
{
	global $userdata;

	$return = ($mode == 'list') ? array() : 0;

	if ( !(is_array($userdata['unread_data'])) )
	{
		return $return;
	}

	if ( $forum_id )
	{
		if ( empty($userdata['unread_data'][$forum_id]) )
		{
			return $return;
		}
		foreach($userdata['unread_data'][$forum_id] as $topic => $posts)
		{
			if ( $mode == 'list' )
			{
				$return = array_merge($return, $posts);
			}
			else
			{
				$return = $return + count($posts);
			}
		}
	}
	else
	{
		foreach($userdata['unread_data'] as $forum_id => $topics)
		{
			foreach($topics as $topic => $posts)
			{
				if ( $mode == 'list' )
				{
					$return = array_merge($return, $posts);
				}
				else
				{
					$return = $return + count($posts);
				}
			}
		}
	}
	return $return;
}

?>