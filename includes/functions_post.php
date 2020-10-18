<?php
/***************************************************************************
 *                            functions_post.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/10/10 2:24
 *
 *   $Id: functions_post.php,v 1.9.2.40 2005/12/22 11:34:02 acydburn Exp $
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');

$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');

function get_value($user_id)
{
	global $db;
	$sql = "SELECT SUM(value) as val
		FROM " . WARNINGS_TABLE . "
		WHERE userid = $user_id
			AND archive = '0'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldnt Query value info from warnings table', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	return $row['val'];
}


//
// This function will prepare a posted message for
// entry into the database.
//
function prepare_message($message, $html_on, $bbcode_on, $smile_on, $bbcode_uid = 0, $forum_id = '')
{
	global $board_config, $userdata, $html_entities_match, $html_entities_replace, $tree;

	//
	// Clean up the message
	//
	$message = trim($message);

	$show_post_html = ( ($userdata['user_jr'] && $board_config['jr_admin_html']) || ($userdata['user_level'] == ADMIN && $board_config['admin_html']) ) ? true : false;
	if ( $userdata['user_level'] == MOD && $board_config['mod_html'] )
	{
		$is_auth = array();
		$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];
		$show_post_html = ($is_auth['auth_mod']) ? true : false;
	}
	if ( !$html_on )
	{
		$show_post_html = false;
	}

	if ( $html_on && !$show_post_html )
	{
		$allowed_html_tags = explode(',', $board_config['allow_html_tags']);

		$end_html = 0;
		$start_html = 1;
		$tmp_message = '';
		$message = ' ' . $message . ' ';

		while ($start_html = strpos($message, '<', $start_html))
		{
			$tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $end_html + 1, ($start_html - $end_html - 1)));

			if ($end_html = strpos($message, '>', $start_html))
			{
				$length = $end_html - $start_html + 1;
				$hold_string = substr($message, $start_html, $length);

				if (($unclosed_open = strrpos(' ' . $hold_string, '<')) != 1)
				{
					$tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($hold_string, 0, $unclosed_open - 1));
					$hold_string = substr($hold_string, $unclosed_open - 1);
				}

				$tagallowed = false;
				for ($i = 0; $i < sizeof($allowed_html_tags); $i++)
				{
					$match_tag = trim($allowed_html_tags[$i]);
					if (preg_match('#^<\/?' . $match_tag . '[> ]#i', $hold_string))
					{
						$tagallowed = (preg_match('#^<\/?' . $match_tag . ' .*?(style[\t ]*?=|on[\w]+[\t ]*?=)#i', $hold_string)) ? false : true;
					}
				}

				$tmp_message .= ($length && !$tagallowed) ? preg_replace($html_entities_match, $html_entities_replace, $hold_string) : $hold_string;

				$start_html += $length;
			}
			else
			{
				$tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $start_html, strlen($message)));

				$start_html = strlen($message);
				$end_html = $start_html;
			}
		}

		if ( !$end_html || ($end_html != strlen($message) && $tmp_message != '') )
		{
			$tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $end_html + 1));
		}

		$message = ( $tmp_message != '' ) ? trim($tmp_message) : trim($message);
	}
	else
	{
		$message = ($show_post_html) ? $message : preg_replace($html_entities_match, $html_entities_replace, $message);
	}

	if ( $bbcode_on && $bbcode_uid != '' )
	{
		$message = bbencode_first_pass($message, $bbcode_uid);
	}

	$symbol_code = array('&amp;micro','&amp;Omega;','&amp;Pi;','&amp;phi;','&amp;Delta;','&amp;Theta;','&amp;Lambda;','&amp;Sigma;','&amp;Phi;','&amp;Psi;','&amp;alpha;','&amp;beta;','&amp;chi;','&amp;tau;','&amp;gamma;','&amp;delta;','&amp;epsilon;','&amp;zeta;','&amp;eta;','&amp;psi;','&amp;theta;','&amp;lambda;','&amp;xi;','&amp;rho;','&amp;sigma;','&amp;omega;','&amp;kappa;','&amp;Gamma;','&amp;clubs;','&amp;hearts;','&amp;euro;','&amp;sect;','&amp;copy;','&amp;reg;','&amp;bull;','&amp;trade;','&amp;deg;','&amp;laquo;','&amp;raquo;','&amp;le;','&amp;ge;','&amp;sup3;','&amp;sup2;','&amp;frac12;','&amp;frac14;','&amp;frac34;','&amp;plusmn;','&amp;divide;','&amp;times;','&amp;radic;','&amp;infin;','&amp;int;','&amp;asymp;','&amp;ne;','&amp;equiv;');
	$symbol_replace = array('&micro','&Omega;','&Pi;','&phi;','&Delta;','&Theta;','&Lambda;','&Sigma;','&Phi;','&Psi;','&alpha;','&beta;','&chi;','&tau;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&psi;','&theta;','&lambda;','&xi;','&rho;','&sigma;','&omega;','&kappa;','&Gamma;','&clubs;','&hearts;','&euro;','&sect;','&copy;','&reg;','&bull;','&trade;','&deg;','&laquo;','&raquo;','&le;','&ge;','&sup3;','&sup2;','&frac12;','&frac14;','&frac34;','&plusmn;','&divide;','&times;','&radic;','&infin;','&int;','&asymp;','&ne;','&equiv;');

	$message = str_replace($symbol_code, $symbol_replace, $message);

	return $message;
}


function unprepare_message($message)
{
	global $unhtml_specialchars_match, $unhtml_specialchars_replace;

	return preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $message);
}


//
// Prepare a message for posting
// 
function prepare_post(&$mode, &$post_data, &$bbcode_on, &$html_on, &$smilies_on, &$error_msg, &$username, &$bbcode_uid, &$subject, &$subject_e, &$message, &$poll_title, &$poll_options, &$poll_length, &$max_vote, &$hide_vote, &$tothide_vote, $forum_id = '')
{
	global $board_config, $userdata, $lang, $phpEx, $phpbb_root_path;

	// Check username
	if (!empty($username))
	{
		$username = phpbb_clean_username($username);

		if (!$userdata['session_logged_in'] || ($userdata['session_logged_in'] && $username != $userdata['username']))
		{
			include($phpbb_root_path . 'includes/functions_validate.'.$phpEx);

			$result = validate_username($username);
			if ($result['error'])
			{
				$error_msg .= (!empty($error_msg)) ? '<br />' . $result['error_msg'] : $result['error_msg'];
			}
		}
		else
		{
			$username = '';
		}
	}

	// Check subject
	if ( !empty($subject_e) )
	{
		$subject_e = xhtmlspecialchars(trim($subject_e));
	}
	if ( !empty($subject) )
	{
		$subject = xhtmlspecialchars(trim($subject));
	}
	else if ( $mode == 'newtopic' || ( $mode == 'editpost' && $post_data['first_post'] ) )
	{
		$error_msg .= ( !empty($error_msg) ) ? '<br />' . $lang['Empty_subject'] : $lang['Empty_subject'];
	}

	// Check message
	if (!empty($message))
	{
		$bbcode_uid = ($bbcode_on) ? make_bbcode_uid() : '';
		$message = prepare_message(trim($message), $html_on, $bbcode_on, $smilies_on, $bbcode_uid, $forum_id);
	}
	else if ($mode != 'delete' && $mode != 'poll_delete') 
	{
		$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['Empty_message'] : $lang['Empty_message'];
	}

	//
	// Handle poll stuff
	//
	if ($mode == 'newtopic' || ($mode == 'editpost' && $post_data['first_post']))
	{
		$$max_vote = (isset($max_vote)) ? max(0, intval($max_vote)) : 0;
		$$hide_vote = (isset($hide_vote)) ? max(0, intval($hide_vote)) : 0;
		$$tothide_vote = (isset($tothide_vote)) ? max(0, intval($tothide_vote)) : 0;

		if ( !empty($poll_title) )
		{
			$poll_title = xhtmlspecialchars(trim($poll_title));
		}

		if ( !empty($poll_options) )
		{
			$temp_option_text = array();
			while( list($option_id, $option_text) = @each($poll_options) )
			{
				$option_text = trim($option_text);
				if ( !empty($option_text) )
				{
					$temp_option_text[$option_id] = xhtmlspecialchars($option_text);
				}
			}
			$option_text = $temp_option_text;

			if ( count($poll_options) < 2 )
			{
				$error_msg .= ( !empty($error_msg) ) ? '<br />' . $lang['To_few_poll_options'] : $lang['To_few_poll_options'];
			}
			else if ( count($poll_options) > $board_config['max_poll_options'] ) 
			{
				$error_msg .= ( !empty($error_msg) ) ? '<br />' . $lang['To_many_poll_options'] : $lang['To_many_poll_options'];
			}
			else if ( $poll_title == '' )
			{
				$error_msg .= ( !empty($error_msg) ) ? '<br />' . $lang['Empty_poll_title'] : $lang['Empty_poll_title'];
			}
		}
	}

	return;
}

//
// Post a new topic/reply/poll or edit existing post/poll
//
function submit_post($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id, &$topic_type, &$bbcode_on, &$html_on, &$smilies_on, &$attach_sig, &$bbcode_uid, $post_username, $post_subject, $post_subject_e, $post_message, $poll_title, &$poll_options, &$poll_length, &$max_vote, &$hide_vote, &$tothide_vote, &$user_agent, &$msg_icon, &$msg_expire, &$topic_color, &$post_approve, &$is_mod, &$is_jr_admin, $topic_gallery = 0)
{
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $userdata, $user_ip;

	include($phpbb_root_path . 'includes/functions_search.'.$phpEx);

	if ( !$msg_icon )
	{
		$msg_icon = 0;
	}
	if ( !$msg_expire )
	{
		$expire_time = 0;
	}
	else if ( $mode == 'editpost' )
	{
		$expire_time = ($msg_expire * 86400) + (CR_TIME - $post_data['post_time']);
	}
	else
	{
		$expire_time = ($msg_expire * 86400);
	}

	$current_time = CR_TIME;
	$value = get_value($userdata['user_id']);

	if ( $value >= $board_config['write_warnings'] )
	{
		$message = sprintf($lang['disallow_posting'], '<a href="' . append_sid("warnings.$phpEx") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}

	if ( $mode == 'newtopic' || $mode == 'reply' )
	{
		//
		// Flood control
		//
		if ( $userdata['user_level'] != ADMIN && !$is_jr_admin && !$is_mod )
		{
			$where_sql = ( $userdata['user_id'] == ANONYMOUS ) ? "poster_ip = '$user_ip'" : 'poster_id = ' . $userdata['user_id'];
			$sql = "SELECT MAX(post_time) AS last_post_time
				FROM " . POSTS_TABLE . "
				WHERE $where_sql";
			if ( $result = $db->sql_query($sql) )
			{
				if ( $row = $db->sql_fetchrow($result) )
				{
					if ( (intval($row['last_post_time']) > 0 && ( $current_time - intval($row['last_post_time']) ) < intval($board_config['flood_interval'])) && $userdata['user_level'] == USER && !$userdata['user_jr'] )
					{
						message_die(GENERAL_MESSAGE, $lang['Flood_Error']);
					}
				}
			}
		}
	}
	if ( $mode == 'editpost' && $board_config['search_enable'])
	{
		remove_search_post($post_id);
	}

	if ( $mode == 'newtopic' || ($mode == 'editpost' && $post_data['first_post']) )
	{
		$topic_tree_width = ($post_data['topic_tree_width']) ? $post_data['topic_tree_width'] : 0;
		$topic_vote = ( !empty($poll_title) && count($poll_options) >= 2 ) ? 1 : 0;
		$topic_gallery = intval($topic_gallery);
		$sql = ($mode != 'editpost') ? 
			"INSERT INTO " . TOPICS_TABLE . " (topic_title, topic_gallery, topic_poster, topic_time, forum_id, topic_status, topic_type, topic_vote, topic_icon, topic_expire, topic_color, topic_title_e, topic_tree_width, topic_accept) VALUES ('$post_subject', $topic_gallery, " . $userdata['user_id'] . ", $current_time, $forum_id, " . TOPIC_UNLOCKED . ", $topic_type, $topic_vote, $msg_icon, $expire_time, '$topic_color', '$post_subject_e', $topic_tree_width, $post_approve)" : 
			"UPDATE " . TOPICS_TABLE . " SET topic_title = '$post_subject', topic_gallery = $topic_gallery, topic_type = $topic_type, topic_icon = $msg_icon, topic_expire = $expire_time, topic_color = '$topic_color', topic_title_e = '$post_subject_e', topic_tree_width = $topic_tree_width " . (($post_data['edit_vote'] || !empty($poll_title)) ? ", topic_vote = " . $topic_vote : "") . " WHERE topic_id = $topic_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}

		if ( $mode == 'newtopic' )
		{
			$topic_id = $db->sql_nextid();
		}
	}

	if ( $post_data['post_parent'] && $post_data['post_parent'] != $post_data['topic_first_post_id'] )
	{
		$parents_data = $parents_ids = $parents_deep_ids = $this_tree_parents = array();
		$max_order = $post_parent_order = $begin_new_parents = $order_last_parents = $increase_post_ids = 0;

		$sql = "SELECT COUNT(post_id) as no_orders
			FROM " . POSTS_TABLE . "
			WHERE post_order = 0
				AND topic_id = " . $topic_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting count orders', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		if ( $row['no_orders'] > 1 )
		{
			$sql = "SELECT post_id
				FROM " . POSTS_TABLE . "
				WHERE topic_id = $topic_id
				ORDER BY post_order, post_time";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting post list', '', __LINE__, __FILE__, $sql);
			}
			$i = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				$sql2 = "UPDATE " . POSTS_TABLE . "
					SET post_order = $i
					WHERE post_id = " . $row['post_id'];
				if ( !($result2 = $db->sql_query($sql2)) )
				{
					message_die(GENERAL_ERROR, 'Error in updating posts order', '', __LINE__, __FILE__, $sql2);
				}
				$i++;
			}
		}

		$sql = "SELECT post_id, post_parent, post_order
			FROM " . POSTS_TABLE . "
			WHERE topic_id = $topic_id
			ORDER BY post_order";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_MESSAGE, $lang['No_such_post']);
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['post_id'] == $post_data['post_parent'] )
			{
				$post_parent_order = $row['post_order'];
				$begin_new_parents = 1;
			}

			if ( !$row['post_parent'] && !$post_parent_order )
			{
				$begin_new_parents = $order_last_parents = 0;
				$this_tree_parents = array();
			}

			if ( $begin_new_parents )
			{
				if ( $row['post_parent'] )
				{
					$this_tree_parents[] = $row['post_parent'];
				}
				if ( $row['post_id'] == $post_data['post_parent'] || ($row['post_parent'] >= $post_data['post_parent'] && in_array($post_data['post_parent'], $this_tree_parents) ) )
				{
					$order_last_parents = $row['post_order'];
				}
				else
				{
					$max_order = ($order_last_parents) ? $order_last_parents : $row['post_order'];
				}
			}

			$max_order_all = $row['post_order'];
		}
		if ( !$max_order )
		{
			$max_order = $max_order_all;
		}
		$post_order = $max_order + 1;

		$sql = "UPDATE " . POSTS_TABLE . "
			SET post_order = post_order + 1
			WHERE topic_id = $topic_id
				AND post_order > $max_order";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error in updating posts order', '', __LINE__, __FILE__, $sql);
		}
	}
	else
	{
		$sql = "SELECT MAX(post_order) as max_order
			FROM " . POSTS_TABLE . "
			WHERE topic_id = $topic_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_MESSAGE, $lang['No_such_post']);
		}

		$row = $db->sql_fetchrow($result);
		$post_order = $row['max_order'] + 1;
		$post_data['post_parent'] = 0;
	}

	$edited_sql = ($mode == 'editpost' && (!$post_data['last_post'] || $board_config['show_action_edited_self_all']) && $post_data['poster_post']) ? ", post_edit_time = $current_time, post_edit_count = post_edit_count + 1 " : "";

	$sql = ($mode != 'editpost') ? "INSERT INTO " . POSTS_TABLE . " (topic_id, forum_id, poster_id, post_username, post_time, poster_ip, enable_bbcode, enable_html, enable_smilies, enable_sig, user_agent, post_icon, post_expire, post_approve, post_parent, post_order) VALUES ($topic_id, $forum_id, " . $userdata['user_id'] . ", '$post_username', $current_time, '$user_ip', $bbcode_on, $html_on, $smilies_on, $attach_sig, '$user_agent', $msg_icon, $expire_time, $post_approve, " . $post_data['post_parent'] . ", $post_order)" : "UPDATE " . POSTS_TABLE . " SET enable_bbcode = $bbcode_on, enable_html = $html_on, enable_smilies = $smilies_on, enable_sig = $attach_sig" . $edited_sql . ", post_icon = $msg_icon, post_expire = $expire_time WHERE post_id = $post_id";
	if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
	{
		message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
	}

	if ( $mode != 'editpost' )
	{
		$post_id = $db->sql_nextid();

		update_config('lastpost', CR_TIME);
	}

	$sql = ($mode != 'editpost') ? 
		"INSERT INTO " . POSTS_TEXT_TABLE . " (post_id, post_subject, bbcode_uid, post_text) VALUES ($post_id, '".$db->sql_escape($post_subject)."', '$bbcode_uid', '".$db->sql_escape($post_message)."')" : 
		"UPDATE " . POSTS_TEXT_TABLE . " SET post_text = '".$db->sql_escape($post_message)."', bbcode_uid = '$bbcode_uid', post_subject = '".$db->sql_escape($post_subject)."' WHERE post_id = $post_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
	}
	if ( $board_config['search_enable'] )
	{
		add_search_words(0, $post_id, stripslashes($post_message), stripslashes($post_subject . ' ' . $post_subject), stripslashes($post_subject . ' ' . $post_subject_e));
	}

	// Add poll
	$hide_vote = ($hide_vote) ? $hide_vote : 0;
	$tothide_vote = ($tothide_vote) ? $tothide_vote : 0;

	if ( ($mode == 'newtopic' || ($mode == 'editpost' && $post_data['edit_poll'])) && !empty($poll_title) && count($poll_options) >= 2 )
	{
		$sql = ( !$post_data['has_poll'] ) ? "INSERT INTO " . VOTE_DESC_TABLE . " (topic_id, vote_text, vote_start, vote_length, vote_max, vote_hide, vote_tothide) VALUES ($topic_id, '$poll_title', $current_time, " . ( $poll_length * 86400 ) . ", '$max_vote', '$hide_vote', '$tothide_vote')" : "UPDATE " . VOTE_DESC_TABLE . " SET vote_text = '$poll_title', vote_length = " . ( $poll_length * 86400 ) . ", vote_max = '$max_vote', vote_hide = '$hide_vote', vote_tothide = '$tothide_vote' WHERE topic_id = $topic_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}

		$delete_option_sql = '';
		$old_poll_result = array();
		if ( $mode == 'editpost' && $post_data['has_poll'] )
		{
			$sql = "SELECT vote_option_id, vote_result
				FROM " . VOTE_RESULTS_TABLE . "
				WHERE vote_id = $poll_id
				ORDER BY vote_option_id ASC";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain vote data results for this topic', '', __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$old_poll_result[$row['vote_option_id']] = $row['vote_result'];

				if ( !isset($poll_options[$row['vote_option_id']]) )
				{
					$delete_option_sql .= ( $delete_option_sql != '' ) ? ', ' . $row['vote_option_id'] : $row['vote_option_id'];
				}
			}
		}
		else
		{
			$poll_id = $db->sql_nextid();
		}

		@reset($poll_options);

		$poll_option_id = 1;
		while ( list($option_id, $option_text) = each($poll_options) )
		{
			if ( !empty($option_text) )
			{
				$option_text = str_replace("\'", "''", xhtmlspecialchars($option_text));
				$poll_result = ($mode == 'editpost' && isset($old_poll_result[$option_id])) ? $old_poll_result[$option_id] : 0;

				$sql = ($mode != 'editpost' || !isset($old_poll_result[$option_id])) ? "INSERT INTO " . VOTE_RESULTS_TABLE . " (vote_id, vote_option_id, vote_option_text, vote_result) VALUES ($poll_id, $poll_option_id, '$option_text', $poll_result)" : "UPDATE " . VOTE_RESULTS_TABLE . " SET vote_option_text = '$option_text', vote_result = $poll_result WHERE vote_option_id = $option_id AND vote_id = $poll_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
				}
				$poll_option_id++;
			}
		}

		if ( $delete_option_sql != '' )
		{
			$sql = "DELETE FROM " . VOTE_RESULTS_TABLE . " 
				WHERE vote_option_id IN ($delete_option_sql) 
					AND vote_id = $poll_id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Error deleting pruned poll options', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	$meta = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">';
	$message = $lang['Stored'] . '<br /><br />' . sprintf($lang['Click_view_message'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');

	return false;
}

function refresh_gallery($topic_id, array $post_ids = [])
{
	
}


//
// Update post stats and details
//
function update_post_stats(&$mode, &$post_data, &$forum_id, &$topic_id, &$post_id, &$user_id)
{
	global $db;

	$forum_update_sql = "forum_posts = forum_posts +1";
	$topic_update_sql = '';

	if ( $mode != 'poll_delete' )
	{
		$forum_update_sql .= ", forum_last_post_id = $post_id" . ( ( $mode == 'newtopic' ) ? ", forum_topics = forum_topics +1" : "" );
		$topic_update_sql = "topic_last_post_id = $post_id" . ( ( $mode == 'reply' ) ? ", topic_replies = topic_replies +1" : ", topic_first_post_id = $post_id" );
	}
	else 
	{
		$topic_update_sql .= 'topic_vote = 0';
	}

	$sql = "UPDATE " . FORUMS_TABLE . " SET 
		$forum_update_sql 
		WHERE forum_id = $forum_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
	}

	sql_cache('clear', 'multisqlcache_forum');
	sql_cache('clear', 'forum_data');

	if ( $topic_update_sql != '' )
	{
		$sql = "UPDATE " . TOPICS_TABLE . " SET 
			$topic_update_sql 
			WHERE topic_id = $topic_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}
	}

	if ( $user_id != ANONYMOUS && $mode != 'poll_delete' && no_post_count($forum_id) )
	{
		$sql = "UPDATE " . USERS_TABLE . "
			SET user_posts = user_posts +1 
			WHERE user_id = $user_id";
		if ( !$db->sql_query($sql, END_TRANSACTION) )
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}
	}

	db_stat_update('posttopic');

	return;
}

//
// Handle user notification on new post
//
function user_notification($mode, &$post_data, &$forum_id, &$topic_id, &$post_id, &$notify_user, &$notification_username)
{
	global $db, $board_config, $lang, $userdata, $phpbb_root_path, $phpEx;

	if ($mode != 'delete')
	{
		if ( $mode == 'reply' )
		{
			$sql = "SELECT ban_userid 
				FROM " . BANLIST_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain banlist', '', __LINE__, __FILE__, $sql);
			}

			$user_id_sql = '';
			while ( $row = $db->sql_fetchrow($result) )
			{
				if ( isset($row['ban_userid']) && !empty($row['ban_userid']) )
				{
					$user_id_sql .= ', ' . $row['ban_userid'];
				}
			}

			$sql = "SELECT u.user_id, u.username, u.user_email, u.user_lang, u.user_aim, u.user_notify_gg, t.topic_title
				FROM (" . TOPICS_WATCH_TABLE . " tw, " . USERS_TABLE . " u, " . TOPICS_TABLE . " t)
				WHERE tw.topic_id = $topic_id 
					AND t.topic_id = $topic_id 
					AND tw.user_id NOT IN (" . $userdata['user_id'] . ", " . ANONYMOUS . $user_id_sql . " ) 
					AND tw.notify_status = " . TOPIC_WATCH_UN_NOTIFIED . " 
					AND u.user_id = tw.user_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain list of topic watchers', '', __LINE__, __FILE__, $sql);
			}

			$update_watched_sql = '';
			$bcc_list_ary = $list_addressats = array();

			if ( $row = $db->sql_fetchrow($result) )
			{
				@set_time_limit(60);
				$forum_can_gg_send = ($board_config['notify_gg'] && is_numeric(intval(trim($board_config['numer_gg']))) && !empty($board_config['haslo_gg'])) ? true : false;

				do
				{
					$user_aim = intval(trim($row['user_aim']));
					$gg_send = ($row['user_aim'] && is_numeric($user_aim) && strlen($user_aim) > 2 && $row['user_notify_gg']) ? true : false;
					if ( $row['user_email'] != '' && (!$gg_send || !$forum_can_gg_send) )
					{
						$bcc_list_ary[$row['user_lang']][] = $row['user_email'];
					}
					if ( $gg_send && $forum_can_gg_send )
					{
						$list_addressats[] = $user_aim;
					}
					$update_watched_sql .= ($update_watched_sql != '') ? ', ' . $row['user_id'] : $row['user_id'];
					$topic_title = $row['topic_title'];
				}
				while ($row = $db->sql_fetchrow($result));

				$orig_word = array();
				$replacement_word = array();
				$replacement_word_html = array();
				obtain_word_list($orig_word, $replacement_word, $replacement_word_html);
				$topic_title = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($topic_title)) : unprepare_message($topic_title);

				$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
				$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
				$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
				$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
				$script_name = ($script_name == '') ? $script_name . '/viewtopic.'.$phpEx : '/' . $script_name . '/viewtopic.'.$phpEx;

				//
				// Let's do some checking to make sure that mass mail functions
				// are working in win32 versions of php.
				//
				if (preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
				{
					$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';

					// We are running on windows, force delivery to use our smtp functions
					// since php's are broken by default
					$board_config['smtp_delivery'] = 1;
					$board_config['smtp_host'] = @$ini_val('SMTP');
				}

				if (sizeof($bcc_list_ary))
				{
					include($phpbb_root_path . 'includes/emailer.'.$phpEx);
					$emailer = new emailer($board_config['smtp_delivery']);

					$emailer->from($board_config['email_from']);
					$emailer->replyto($board_config['email_return_path']);

					@reset($bcc_list_ary);
					while (list($user_lang, $bcc_list) = each($bcc_list_ary))
					{
						$emailer->use_template('topic_notify', $user_lang);
				
						for ($i = 0; $i < count($bcc_list); $i++)
						{
							$emailer->bcc($bcc_list[$i]);
						}

						// The Topic_reply_notification lang string below will be used
						// if for some reason the mail template subject cannot be read 
						// ... note it will not necessarily be in the posters own language!
						$emailer->set_subject($lang['Topic_reply_notification']);

						// This is a nasty kludge to remove the username var ... till (if?)
						// translators update their templates
						$emailer->msg = preg_replace('#[ ]?{USERNAME}#', '', $emailer->msg);

						$emailer->assign_vars(array(
							'NOTIFICATION_USERNAME' => $notification_username,
							'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
							'SITENAME' => $board_config['sitename'],
							'TOPIC_TITLE' => $topic_title, 

							'U_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id",
							'U_STOP_WATCHING_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_TOPIC_URL . "=$topic_id&unwatch=topic")
						);

						$emailer->send();
						$emailer->reset();
					}
				}
			}
			$db->sql_freeresult($result);

			if ( $update_watched_sql != '' )
			{
				$sql = "UPDATE " . TOPICS_WATCH_TABLE . "
					SET notify_status = " . TOPIC_WATCH_NOTIFIED . "
					WHERE topic_id = $topic_id
						AND user_id IN ($update_watched_sql)";
				$db->sql_query($sql);
			}
		}

		if ( $list_addressats )
		{
			$tresc = "\"" . $board_config['sitename'] . "\"\r\n" . sprintf($lang['gg_notify_topic'], $topic_title, $userdata['username']) . "\r\n" . sprintf($lang['l_notify_gg_topic'], $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id");
			require_once('includes/functions_gg_notice.'.$phpEx);
			@wiadomosc_gg($list_addressats, $tresc, intval(trim($board_config['numer_gg'])), trim($board_config['haslo_gg']));
		}

		$sql = "SELECT topic_id 
			FROM " . TOPICS_WATCH_TABLE . "
			WHERE topic_id = $topic_id
				AND user_id = " . $userdata['user_id'];
		$result = $db->sql_query($sql);

		$row = $db->sql_fetchrow($result);

		if ( !$notify_user && !empty($row['topic_id']) )
		{
			$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
				WHERE topic_id = $topic_id
					AND user_id = " . $userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete topic watch information', '', __LINE__, __FILE__, $sql);
			}
		}
		else if ( $notify_user && empty($row['topic_id']) )
		{
			$sql = "INSERT INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
				VALUES (" . $userdata['user_id'] . ", $topic_id, 0)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not insert topic watch information', '', __LINE__, __FILE__, $sql);
			}
		}
	}
}

function disallow_forums($userdata, $forum_id)
{
	global $lang, $phpEx;

	if ( strstr($userdata['disallow_forums'], ',') )
	{
		$fids = explode(',', $userdata['disallow_forums']);

		while( list($foo, $id) = each($fids) )
		{
			$fid[] = intval( trim($id) );
		}
	}
	else
	{
		$fid[] = intval( trim($userdata['disallow_forums']) );
	}
	reset($fid);
	if ( in_array($forum_id, $fid) != false )
	{
		$message = $lang['banned_forum'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');
		message_die(GENERAL_MESSAGE, $message);
	}
}

function more_icons($page_id)
{
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $user_ip, $session_length, $starttime;
	global $userdata;

	$userdata = session_pagestart($user_ip, $page_id);
	init_userprefs($userdata);

	$gen_simple_header = TRUE;
	$page_title = $lang['Review_topic'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'iconsbody' => 'posting_icons.tpl')
	);

	$rep = $images['rank_path'] . 'icon';
	$dir = opendir($rep);

	while($file = readdir($dir))
	{
		$icon_code = str_replace(array('icon', '.gif'), array('', ''), $file);
		if ( strpos($file, '.gif') && is_numeric($icon_code) )
		{
			$template->assign_block_vars('icons', array(
				'URL' => $rep . '/' . $file,
				'ICON_CODE' => intval($icon_code))
			);
		}
	}
	closedir($dir);

	$template->assign_vars(array(
		'L_ICONS' => $lang['icons'])
	);

	$template->pparse('iconsbody');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

?>