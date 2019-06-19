<?php
/***************************************************************************
 *                              topic_review.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.3 2005/10/09 12:18
 *
 *   $Id: topic_review.php,v 1.5.2.4 2005/05/06 20:50:12 acydburn Exp $
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
 *
 ***************************************************************************/

function topic_review($topic_id, $is_inline_review)
{
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $userdata, $user_ip;
	global $orig_word, $replacement_word, $replacement_word_html;
	global $starttime;
	global $tree;

	if ( !$is_inline_review )
	{
		if ( !isset($topic_id) || !$topic_id)
		{
			message_die(GENERAL_MESSAGE, 'No_such_post');
		}

		//
		// Get topic info ...
		//
		$sql = "SELECT t.topic_title, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments, f.auth_download, t.topic_attachment , f.forum_moderate
			FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f)
			WHERE t.topic_id = $topic_id
			AND f.forum_id = t.forum_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
		}

		if ( !($forum_row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, 'No_such_post');
		}
		$db->sql_freeresult($result);

		$forum_id = $forum_row['forum_id'];
		$topic_title = $forum_row['topic_title'];
		
		//
		// Start session management
		//
		$userdata = session_pagestart($user_ip, $forum_id);
		init_userprefs($userdata);
		//
		// End session management
		//

		$is_auth = array();
		$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_row);

		$forum_view_moderate = ($forum_row['forum_moderate'] && !$is_auth['auth_mod']) ? true : false;

		if ( !$is_auth['auth_read'] )
		{
			message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']));
		}
	}

	$ignored_users = array();
	if ( $board_config['cignore'] )
	{
		$sql = "SELECT user_ignore
			FROM " . IGNORE_TABLE . "
			WHERE user_id = " . $userdata['user_id'];
		if ( !$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not get data from ignore table', __LINE__, __FILE__, $sql);
		}
		while($row = $db->sql_fetchrow($result))
		{
			$ignored_users[] = $row['user_ignore'];
		}
	}

	//
	// Define censored word matches
	//
	if ( empty($orig_word) && empty($replacement_word) )
	{
		$orig_word = array();
		$replacement_word = array();
		$replacement_word_html = array();

		obtain_word_list($orig_word, $replacement_word, $replacement_word_html);
	}

	//
	// Dump out the page header and load viewtopic body template
	//
	if ( !$is_inline_review )
	{
		$gen_simple_header = TRUE;

		$page_title = $lang['Topic_review'] . ' - ' . $topic_title;
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->set_filenames(array(
			'reviewbody' => 'posting_topic_review.tpl')
		);
	}

	$user_posts_per_page = ($userdata['user_posts_per_page'] > 0) ? $userdata['user_posts_per_page'] : '15';

	//
	// Go ahead and pull all data for this topic
	//
	$sql = "SELECT u.username, u.user_id, u.user_level, u.user_allowhtml, p.*, pt.post_text, pt.post_subject, pt.bbcode_uid
		FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt)
		WHERE p.topic_id = $topic_id
			AND p.poster_id = u.user_id
			AND p.post_id = pt.post_id
		ORDER BY p.post_order DESC, p.post_time DESC
		LIMIT $user_posts_per_page";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain post/user information', '', __LINE__, __FILE__, $sql);
	}
	if ( defined('ATTACHMENTS_ON') )
	{
		init_display_review_attachments($is_auth);
	}

	//
	// Okay, let's do the loop, yeah come on baby let's do the loop
	// and it goes like this ...
	//
	$user_id = $userdata['user_id'];
    $_row = $posters_id = array();
	while ( $row_a = $db->sql_fetchrow($result) ){
        $_row[]       = $row_a;
        $posters_id[] = $row_a['poster_id'];
    }

    if( !empty($_row) )
    {
		$mini_post_img = $images['icon_minipost'];
		$mini_post_alt = $lang['Post'];
        
		$i = 0;
		foreach( $_row as $row )
		{
			$poster_id = $row['user_id'];
			$poster_level = $row['user_level'];
            if($row['post_start_time']>0) $row['post_time'] = $row['post_start_time'];

			$show_post = (!$row['post_approve'] && $forum_view_moderate ) ? false : true; 

			if ( !@in_array($poster_id, $ignored_users) || $poster_level == MOD || $poster_level == ADMIN )
			{
				$poster = $row['username'];

				$post_date = create_date($board_config['default_dateformat'], $row['post_time'], $board_config['board_timezone']);

				//
				// Handle anon users posting with usernames
				//
				if ( $poster_id == ANONYMOUS && $row['post_username'] != '' )
				{
					$poster = $row['post_username'];
					$poster_rank = $lang['Guest'];
				}
				elseif ( $poster_id == ANONYMOUS )
				{
					$poster = $lang['Guest'];
					$poster_rank = '';
				}

				$post_subject = ( $row['post_subject'] != '' ) ? $row['post_subject'] : '';
				$message = $row['post_text'];
				$bbcode_uid = $row['bbcode_uid'];

				//
				// If the board has HTML off but the post has HTML
				// on then we process it, else leave it alone
				//

				if ( $poster_level != ANONYMOUS && $poster_level != ADMIN && $row['user_level'] == MOD )
				{
					$poster_is_mod_here = true;
					$poster_is_mod = true;
				}
				else
				{
					$poster_is_mod_here = $poster_is_mod = false;
					$poster_is_jr_admin = ($row['user_jr']) ? true : false;
				}

				$show_post_html = ($board_config['allow_html'] && $row['user_allowhtml']) ? true : false;
				if ( (($poster_is_mod_here && $board_config['mod_html']) || ($board_config['admin_html'] && $poster_level == ADMIN) || ($board_config['jr_admin_html'] && $poster_is_jr_admin)) && $row['enable_html'] && $row['user_allowhtml'] )
				{
					$show_post_html = true;
				}

				if ( !$show_post_html )
				{
					$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
				}

				$strip_br = ($show_post_html && (strpos($message, '<td>') !== false || strpos($message, '<tr>') !== false || strpos($message, '<table>') !== false)) ? true : false;


				if ( $userdata['user_level'] == ADMIN || $userdata['user_jr'] || $is_auth['auth_mod'] )
				{
					$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "<br><u><b>Mod Info:</u><br>[</b>\\1<b>]</b><br>", $message);
				}
				elseif ( strpos($message, "[mod]") !== false )
				{
					$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "", $message);
				}

				if ( $bbcode_uid != '' )
				{
					$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid, $userdata['username']) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);

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
				}

				$message = make_clickable($message);

				if ( $board_config['allow_smilies'] && $row['enable_smilies'] && $userdata['show_smiles'] )
				{
					$message = smilies_pass($message);
				}

				if ( count($orig_word) )
				{
					$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);
					$message = preg_replace($orig_word, $replacement_word_html, $message);
				}

				if ( !$strip_br )
				{
					$message = str_replace("\n", "\n<br />\n", $message);
				}

				if ( !$show_post )
				{
					$poster = $post_subject = $poster = '';
					$message = '<i><b>' . $lang['Post_no_approved'] . '</b></i>';
				}
				
				$quote_selection = ($board_config['graphic']) ? '<img src="' . $images['icon_q_quote'] . '" title="' . $lang['QuoteSelelected'] . '" border="0" alt="" />' : $lang['QuoteSelelected'];
				$quote_selection = '<a href="javascript:void(null)" onclick="qc();" onmouseover="qo();">' . $quote_selection . '</a>';

				//
				// Again this will be handled by the templating
				// code at some point
				//

				$template->assign_block_vars('postrow', array(
					'ROW_COLOR' => '#' . ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'], 
					'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'], 
					'MINI_POST_IMG' => $mini_post_img, 
					'POSTER_NAME' => $poster, 
					'POST_DATE' => $post_date, 
					'POST_SUBJECT' => $post_subject, 
					'QUOTE_SEL' => $quote_selection,
					'MESSAGE' => $message,					
					'L_MINI_POST_ALT' => $mini_post_alt)
				);
				if ( defined('ATTACHMENTS_ON') )
				{
					display_review_attachments($row['post_id'], $row['post_attachment'], $is_auth);
				}
				$i++;
			}
		}
	}
	else
	{
		message_die(GENERAL_MESSAGE, 'No_such_post', '', __LINE__, __FILE__, $sql);
	}
	$db->sql_freeresult($result);

	$template->assign_vars(array(
		'L_AUTHOR' => $lang['Author'],
		'L_MESSAGE' => $lang['Message'],
		'L_POSTED' => $lang['Posted'],
		'L_POST_SUBJECT' => $lang['Post_subject'], 
		'L_TOPIC_REVIEW' => $lang['Topic_review'])
	);

	if ( !$is_inline_review )
	{
		$template->pparse('reviewbody');
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}

?>