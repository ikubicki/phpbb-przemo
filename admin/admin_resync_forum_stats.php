<?php

/*******************************************************************

 Name					: Resync Forum Statistics [Admin module]
 Copyright			: 2003, Adam Alkins
 Website				: http://www.rasadam.com
 email				: phpbb at rasadam dot com
 modification			: (C) 2003 Przemo http://www.przemo.org
 date modification	: ver. 1.9 2005/03/22 01:12

 $Id: admin_resync_forum_stats.php,v 1.5 2003/07/16 17:22:11 rasadam Exp $: 

*******************************************************************/

/*******************************************************************

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the 
Free Software Foundation Inc., 59 Temple Place, Suite 330,
Boston, MA  02111-1307  USA

*******************************************************************/
define('MODULE_ID', 27);
define('IN_PHPBB', 1);
if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Forums']['Resync_Stats'] = $filename;
	return;
}

// Load default header
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// Incase we end up with a large forum
@set_time_limit(300);

if ( !isset($HTTP_POST_VARS['doresync']) )
{
	if ( !isset($HTTP_GET_VARS['mode']) || $HTTP_GET_VARS['mode'] == 'simple' )
	{
		// Set template file
		$template->set_filenames(array(
		    'body' => 'admin/admin_resync_forum_stats_smp.tpl')
		);
		
		// Set template variables
		$template->assign_vars(array(
			'L_PAGE_TITLE' => $lang['Resync_page_title'],
			'L_PAGE_DESC' => $lang['Resync_page_desc_simple'],
			'L_RESYNC_ASK' => $lang['Resync_all_ask'],
			'L_MODE_CHANGE' => $lang['Advanced_mode'],
			'L_DO_RESYNC' => $lang['Resync_do'],
			'L_RESET' => $lang['Reset'],
			
			'S_RESYNC_ACTION' => append_sid("admin_resync_forum_stats.$phpEx?mode=simple"),

			'U_MODE_CHANGE' => append_sid("admin_resync_forum_stats.$phpEx?mode=advanced"))
		);
	}
	else
	{	
		// Set template file
		$template->set_filenames(array(
		    'body' => 'admin/admin_resync_forum_stats_adv.tpl')
		);
		
		// Select all the forums
		$sql = "SELECT f.forum_id, f.forum_name, c.cat_title
				FROM (" . FORUMS_TABLE . " f, " . CATEGORIES_TABLE . " c)
					WHERE f.cat_id = c.cat_id
				ORDER BY c.cat_order ASC, f.forum_name ASC";
		
		$result = $db->sql_query($sql);
	
		if ( !$result )
		{
			message_die(GENERAL_ERROR, 'Could not obtain forums list', '', __LINE__, __FILE__, $sql);
		}
		
		// If there are no forums
		if ( $db->sql_numrows($result) == 0 )
		{
			// Lets display a message to suite
			message_die(GENERAL_MESSAGE, $lang['Resync_no_forums']);
		}
			
		$forum_rows = $db->sql_fetchrowset($result);
		
		for($i = 0; $i < count($forum_rows); $i++)
		{
			// determine the css class
			if ( ($i % 2) == 1 )
			{
				$row_class = '1';
			}
			else
			{
				$row_class = '2';
			}

			// assign block values
			$template->assign_block_vars('forums', array(
				'CATEGORY_NAME' => stripslashes($forum_rows[$i]['cat_title']),
				'FORUM_ID' => $forum_rows[$i]['forum_id'],
				'FORUM_NAME' => stripslashes($forum_rows[$i]['forum_name']),
				'ROW_CLASS' => $row_class)
			);
		}
		 		
		$template->assign_vars(array(
			'L_PAGE_TITLE' => $lang['Resync_page_title'],
			'L_RESYNC_OPTIONS' => $lang['Resync_options'],
			'L_FORUM_TOPICS' => $lang['Resync_forum_topics'],
			'L_FORUM_POSTS' => $lang['Resync_forum_posts'],
			'L_FORUM_LAST_POST' => $lang['Resync_forum_last_post'],
			'L_TOPIC_REPLIES' => $lang['Resync_topic_replies'],
			'L_TOPIC_LAST_POST' => $lang['Resync_topic_last_post'],
			'L_CATEGORY' => $lang['Category'],
			'L_FORUM' => $lang['Forum'],
			'L_RESYNCQ' => $lang['Resync_question'],
			'L_MODE_CHANGE' => $lang['Simple_mode'],
			'L_DO_RESYNC' => $lang['Resync_do'],
			'L_RESET' => $lang['Reset'],
		
			'S_RESYNC_ACTION' => append_sid("admin_resync_forum_stats.$phpEx?mode=advanced"),

			'U_MODE_CHANGE' => append_sid("admin_resync_forum_stats.$phpEx?mode=simple"))
		);
	}
}
else
{
	// Get list of all forums
	$sql = "SELECT forum_id
			FROM " . FORUMS_TABLE;
	
	$result = $db->sql_query($sql);

	if ( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forums list', '', __LINE__, __FILE__, $sql);
	}

	$forums_db = $db->sql_fetchrowset($result);
	
	// We will use this variable to store the ids of forums we will be resyncing
	$forums = '';
	
	// This var will be used to note what we are doing
	unset($todo);
	
	// If we are in advanced mode
	if ( $HTTP_GET_VARS['mode'] == 'advanced' )
	{
		// Lets check to see what we should do
		$todo['forum_topics'] = ( $HTTP_POST_VARS['forum_topics'] == 1 ) ? 1 : 0;
		$todo['forum_posts'] = ( $HTTP_POST_VARS['forum_posts'] == 1 ) ? 1 : 0;
		$todo['forum_last_post'] = ( $HTTP_POST_VARS['forum_last_post'] == 1 ) ? 1 : 0;
		$todo['topic_replies'] = ( $HTTP_POST_VARS['topic_replies'] == 1 ) ? 1 : 0;
		$todo['topic_last_post'] = ( $HTTP_POST_VARS['topic_last_post'] == 1 ) ? 1 : 0;
	}
	else
	{
		// Let's prevent any XSS exploit down the road
		$HTTP_POST_POST['mode'] = 'simple';
		
		// Since this is simple mode, we will do everything!
		$todo['forum_topics'] = 1;
		$todo['forum_posts'] = 1;
		$todo['forum_last_post'] = 1;
		$todo['topic_replies'] = 1;
		$todo['topic_last_post'] = 1;
	}

	// Loop through all forums
	for($i = 0; $i < count($forums_db); $i++)
	{
		// If we are in advanced mode and we are to resync this forum OR we are in simple mode
		if ( ( $HTTP_GET_VARS['mode'] == 'advanced' && $HTTP_POST_VARS['forum_'.$forums_db[$i]['forum_id']] == 1 ) || $HTTP_GET_VARS['mode'] == 'simple' )
		{
			// Update query for the forum table
			$sql_forum = '';
		
			// Ok, now can we resync forum topic counts?
			if ( $todo['forum_topics'] == 1)
			{
				// Lets count the topics
				$sql = "SELECT COUNT(*) AS numrows
						FROM " . TOPICS_TABLE . "
						WHERE forum_id = ".$forums_db[$i]['forum_id'];
				
				$result = $db->sql_query($sql);

				if ( !$result )
				{
					message_die(GENERAL_ERROR, 'Could not obtain forum topics count', '', __LINE__, __FILE__, $sql);
				}

				$data = $db->sql_fetchrow($result);
				
				// Start the query
				$sql_forum = "UPDATE " . FORUMS_TABLE . "
					SET forum_topics = " . $data['numrows'];
			}
			
			// Ok, now can we resync forum post counts?
			if ( $todo['forum_posts'] == 1 )
			{
				// Lets count the posts
				$sql = "SELECT COUNT(*) AS numrows
						FROM " . POSTS_TABLE . "
						WHERE forum_id = ".$forums_db[$i]['forum_id'];
				
				$result = $db->sql_query($sql);

				if ( !$result )
				{
					message_die(GENERAL_ERROR, 'Could not obtain forum posts count', '', __LINE__, __FILE__, $sql);
				}

				$data = $db->sql_fetchrow($result);
				
				// Was the query started above? If not, we need to start the query here or just add to the updating
				if ( $sql_forum == '' )
				{
					$sql_forum = "UPDATE " . FORUMS_TABLE . "
						SET forum_posts = " . $data['numrows'];
				}
				else
				{
					$sql_forum .= ', forum_posts = ' . $data['numrows'];
				}
			}

			// Ok, now can we update the last forum post?
			if ( $todo['forum_last_post'] == 1 )
			{
				// Lets select that post
				$sql = "SELECT post_id
						FROM " . POSTS_TABLE . "
						WHERE forum_id = " . $forums_db[$i]['forum_id'] . "
						ORDER BY post_time DESC
						LIMIT 1";
				
				$result = $db->sql_query($sql);

				if ( !$result )
				{
					message_die(GENERAL_ERROR, 'Could not obtain last forum post', '', __LINE__, __FILE__, $sql);
				}
				
				
				// What if there were no posts in the forum?
				if ( $db->sql_numrows($result) !=1 )
				{
					$data['post_id'] = 0;
				}
				else
				{
					$data = $db->sql_fetchrow($result);
				}
				
				// Was the query started above? If not, we need to start the query here or just add to the updating
				if ( $sql_forum == '')
				{
					$sql_forum = "UPDATE " . FORUMS_TABLE . "
						SET forum_last_post_id = " . $data['post_id'];
				}
				else
				{
					$sql_forum .= ', forum_last_post_id = ' . $data['post_id'];
				}
			}
			
			// Now that we are done with the forums table part, we will run the update query
			// Do we need to?
			if ( $sql_forum != '' )
			{
				// Fine, lets attach the where clause for this forum
				$sql_forum .= ' WHERE forum_id = ' . $forums_db[$i]['forum_id'];
				
				// Let's update the forum!
				if ( !$db->sql_query($sql_forum) )
				{
					message_die(GENERAL_ERROR, 'Could not update forum stats', '', __LINE__, __FILE__, $sql_forum);
				}
			}

			// Now onto the topics table
			
			// Let's eliminate work if we don't have to do anything with topics
			if ( $todo['topic_replies'] == 1 || $todo['topic_last_post'] == 1 )
			{
				// We have to start by getting the topics in the forum
				$sql = "SELECT topic_id
						FROM " . TOPICS_TABLE . "
						WHERE forum_id = " . $forums_db[$i]['forum_id'] . "
							AND topic_moved_id = 0";
				
				$result = $db->sql_query($sql);
	
				if ( !$result )
				{
					message_die(GENERAL_ERROR, 'Could not obtain topics list', '', __LINE__, __FILE__, $sql);
				}
	
				$topics = $db->sql_fetchrowset($result);
				
				// Right, let's loop through these topics
				for($j = 0; $j < count($topics); $j++)
				{
					// Lets clear the query for this topic
					$sql_topic = '';
					
					// Ok, can we resync topic replies?
					if ( $todo['topic_replies'] == 1 )
					{
						// Lets count the posts
						$sql = "SELECT COUNT(*) AS numrows
								FROM " . POSTS_TABLE . "
								WHERE topic_id = " . $topics[$j]['topic_id'];
						
						$result = $db->sql_query($sql);
		
						if ( !$result )
						{
							message_die(GENERAL_ERROR, 'Could not obtain topics replies count', '', __LINE__, __FILE__, $sql);
						}
		
						$data = $db->sql_fetchrow($result);
						
						// Start the query
						$sql_topic = "UPDATE " . TOPICS_TABLE . "
							SET topic_replies = " . ($data['numrows'] - 1);
					}
	
					// Ok, now can we update the last topic post?
					if ( $todo['topic_last_post'] == 1 )
					{
						// Lets select that post
						$sql = "SELECT MAX(post_id) AS last_post_id
								FROM " . POSTS_TABLE . "
								WHERE topic_id = " . $topics[$j]['topic_id'];
						
						$result = $db->sql_query($sql);
		
						if ( !$result )
						{
							message_die(GENERAL_ERROR, 'Could not obtain last topic post', '', __LINE__, __FILE__, $sql);
						}
		
						$data = $db->sql_fetchrow($result);
						
						// Was the query started above? If not, we need to start the query here or just add to the updating
						if ( $sql_topic == '' )
						{
							$sql_topic = "UPDATE " . TOPICS_TABLE . "
								SET topic_last_post_id = " . $data['last_post_id'];
						}
						else
						{
							$sql_topic .= ', topic_last_post_id = ' . $data['last_post_id'];
						}
					}

					if ( $todo['topic_last_post'] == 1 )
					{
						// Lets select that post
						$sql = "SELECT MIN(post_id) AS first_post
							FROM " . POSTS_TABLE . "
							WHERE topic_id = " . $topics[$j]['topic_id'];
						if ( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not get post ID', '', __LINE__, __FILE__, $sql);
						}
						if ( $row = $db->sql_fetchrow($result) )
						{
							$row['first_post'] = ($row['first_post'] > 0) ? $row['first_post'] : 0;
							$sql = "UPDATE " . TOPICS_TABLE . "
								SET topic_first_post_id = " . $row['first_post'] . "
								WHERE topic_id = " . $topics[$j]['topic_id'];
						
							if ( !$db->sql_query($sql) )
							{
								message_die(GENERAL_ERROR, 'Could not update topic', '', __LINE__, __FILE__, $sql);
							}
						}
					}

					// Now that we are done with this topic, we will run the update query
					// Do we need to?
					if ( $sql_topic != '' )
					{
						// Fine, lets attach the where clause for this topic
						$sql_topic .= ' WHERE topic_id = ' . $topics[$j]['topic_id'];
						
						// Let's update the forum!
						if ( !$db->sql_query($sql_topic) )
						{

							if ( $topics[$j]['topic_last_post_id'] == '' || $topics[$j]['topic_first_post_id'] == '' )
							{
								$sql = "DELETE FROM " . TOPICS_TABLE . "
									WHERE topic_id = " . $topics[$j]['topic_id'];
								$result = $db->sql_query($sql);
								if ( !$result )
								{
									message_die(GENERAL_ERROR, 'Could not delete bad topics info', '', __LINE__, __FILE__, $sql);
								}
								$sql = "DELETE FROM " . READ_HIST_TABLE . "
									WHERE topic_id = " . $topics[$j]['topic_id'];
								$result = $db->sql_query($sql);
								if ( !$result )
								{
									message_die(GENERAL_ERROR, 'Could not delete bad topics info', '', __LINE__, __FILE__, $sql);
								}
							}
							else
							{
								message_die(GENERAL_ERROR, 'Could not update forum stats', '', __LINE__, __FILE__, $sql_topic);
							}
						}
					}
				}// End if we-have-to-do-anything-with-topics loop		
			}// End topics loop		
		}// End whether we should do anything for this forum
	}// End forums loop

	sql_cache('clear', 'multisqlcache_forum');
	sql_cache('clear', 'forum_data');
	
	$sql = "SELECT topic_id
		FROM " . TOPICS_TABLE . "
			WHERE topic_moved_id = 0";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get topics data', '', __LINE__, __FILE__, $sql);
	}

	$topics_list =  array();

	while ( $row = $db->sql_fetchrow($result) )
	{
		$topics_list[] = $row['topic_id'];
	}
	if ( $topics_list )
	{
		$topics_list = implode(', ', $topics_list);
		$sql_p = "DELETE FROM " . POSTS_TABLE . "
			WHERE topic_id NOT IN($topics_list)";
		if ( !($result_p = $db->sql_query($sql_p)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete shadow posts', '', __LINE__, __FILE__, $sql_p);
		}

		$sql_p = "DELETE FROM " . VOTE_DESC_TABLE . "
			WHERE topic_id NOT IN($topics_list)";
		if ( !($result_p = $db->sql_query($sql_p)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete shadow polls', '', __LINE__, __FILE__, $sql_p);
		}
		$sql_p = "DELETE FROM " . TOPICS_TABLE . "
			WHERE topic_moved_id <> 0
				AND topic_moved_id NOT IN($topics_list)";
		if ( !($result_p = $db->sql_query($sql_p)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete shadow polls', '', __LINE__, __FILE__, $sql_p);
		}
		$sql_p = "DELETE FROM " . TOPICS_IGNORE_TABLE . "
			WHERE topic_id NOT IN($topics_list)";
		if ( !($result_p = $db->sql_query($sql_p)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete shadow polls', '', __LINE__, __FILE__, $sql_p);
		}
		$sql = "DELETE
			FROM " . TOPICS_WATCH_TABLE . "
			WHERE topic_id NOT IN($topics_list)";
		if ( !$db->sql_query($sql, END_TRANSACTION) )
		{
			message_die(GENERAL_ERROR, 'Could not delete watched post list', '', __LINE__, __FILE__, $sql);
		}
		$sql = "DELETE
			FROM " . TOPIC_VIEW_TABLE . "
			WHERE topic_id NOT IN($topics_list)";
		if ( !$db->sql_query($sql, END_TRANSACTION) )
		{
			message_die(GENERAL_ERROR, 'Could not delete viewed post list', '', __LINE__, __FILE__, $sql);
		}
	}

	$sql = "SELECT vote_id FROM " . VOTE_DESC_TABLE;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get polls data', '', __LINE__, __FILE__, $sql);
	}

	$polls_list =  array();

	while ( $row = $db->sql_fetchrow($result) )
	{
		$polls_list[] = $row['vote_id'];
	}
	if ( $polls_list )
	{
		$polls_list = implode(', ', $polls_list);
		$sql_p = "DELETE FROM " . VOTE_USERS_TABLE . "
			WHERE vote_id NOT IN($polls_list)";
		if ( !($result_p = $db->sql_query($sql_p)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete shadow topics', '', __LINE__, __FILE__, $sql_p);
		}
		$sql_p = "DELETE FROM " . TOPICS_IGNORE_TABLE . "
			WHERE topic_id NOT IN($topics_list)";
		if ( !($result_p = $db->sql_query($sql_p)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete shadow topics ignore data', '', __LINE__, __FILE__, $sql_p);
		}
	}

	// Lets setup this little redirect statement
	$redirect_message = sprintf($lang['Resync_redirect'], append_sid("admin_resync_forum_stats.".$phpEx."?mode=".$HTTP_GET_VARS['mode']), append_sid("index.".$phpEx."?pane=right"));
	
	// Lets display a finished message
	message_die(GENERAL_MESSAGE,$lang['Resync_completed'].$redirect_message);
	
}// End if button was pushed check

// Spit out the page.
$template->pparse('body');

include('page_footer_admin.'.$phpEx);

?>