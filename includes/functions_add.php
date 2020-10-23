<?php
/***************************************************************************
 *                   functions_add.php
 *                   -------------------
 *   begin           : 05, 09, 2005
 *   copyright       : (C) 2003 Przemo (http://www.przemo.org)
 *   email           : przemo@przemo.org
 *   version         : ver. 1.12.4 2005/09/05 12:06
 *
 ***************************************************************************/

/***************************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/

function set_action($topic_id, $action)
{
	global $db, $userdata;

	if ( $action == EDITED )
	{
		$sql = "UPDATE " . POSTS_TABLE . "
			SET post_edit_by = " . $userdata['user_id'] . ", post_edit_time = " . CR_TIME . ", post_edit_count = post_edit_count + 1
			WHERE post_id = $topic_id";
		if ( !($result = $db->sql_query($sql)) ) 
		{
			message_die(GENERAL_ERROR, 'Error in updating posts table', '', __LINE__, __FILE__, $sql);
		}
		return;
	}

	$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_action = $action, topic_action_user = " . $userdata['user_id'] . ", topic_action_date = " . CR_TIME . "
		WHERE topic_id IN ($topic_id)";
	if ( !($result = $db->sql_query($sql)) ) 
	{
		message_die(GENERAL_ERROR, 'Error in updating topics table', '', __LINE__, __FILE__, $sql);
	}

	return;
}

function notify_delete($post_id, $topic_id, $user_id, $notify_user, $reason, $in_modcp = false)
{
	global $db, $lang, $board_config, $phpbb_root_path, $phpEx, $html_entities_match, $html_entities_replace, $userdata;

	$get_post_id = ($in_modcp) ? 't.topic_first_post_id' : $post_id;

	$sql = "SELECT t.topic_first_post_id, t.topic_title, pt.post_text, pt.bbcode_uid, u.username, u.user_email, u.user_lang
		FROM (" . TOPICS_TABLE . " t, " . POSTS_TEXT_TABLE . " pt, " . USERS_TABLE . " u)
		WHERE pt.post_id = $get_post_id
			AND t.topic_id = $topic_id
			AND u.user_id = $notify_user";
	if ( !($result = $db->sql_query($sql)) )
	{
		return;
	}

	$row = $db->sql_fetchrow($result);

	if ( !$row['user_email'] )
	{
		return;
	}

	if ( $row['user_lang'] != $userdata['user_lang'] )
	{
		$userdata_lang = $lang;
		unset($lang);
		if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $row['user_lang'] . '/lang_main.'.$phpEx)) )
		{
			$row['user_lang'] = 'english';
		}
		include($phpbb_root_path . 'language/lang_' . $row['user_lang'] . '/lang_main.' . $phpEx);
		if ( !(defined('IN_MODCP')) )
		{
			if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $row['user_lang'] . '/lang_modcp.'.$phpEx)) )
			{
				$row['user_lang'] = 'english';
			}
			include($phpbb_root_path . 'language/lang_' . $row['user_lang'] . '/lang_modcp.' . $phpEx);
		}
		$user_lang = $lang;
		unset($lang);
		$lang = $userdata_lang;
		unset($userdata_lang);
	}
	else
	{
		if ( !(defined('IN_MODCP')) )
		{
			if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $row['user_lang'] . '/lang_modcp.'.$phpEx)) )
			{
				$row['user_lang'] = 'english';
			}
			include($phpbb_root_path . 'language/lang_' . $row['user_lang'] . '/lang_modcp.' . $phpEx);
		}
		$user_lang = $lang;
	}

	$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
	$unhtml_specialchars_replace = array('>', '<', '"', '&');

	$post_text = preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $row['post_text']);
	$post_text = preg_replace("#\[mod\](.*?)\[/mod\]#si", "", $post_text);

	$separator = "\n\r";
	$separator .= ($row['topic_title']) ? "\n\r" . preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $user_lang['Topic'] . ': "' . $row['topic_title']) . "\"\n\r" : '';
	$separator .= "\n\r" . (($board_config['del_notify_method']) ? bbencode_strip($post_text, $row['bbcode_uid']) : str_replace(':' . $row['bbcode_uid'], '', $post_text));

	$reason_out = (is_numeric($reason)) ? $user_lang['del_notify_reasons'][$reason] : $reason;
	$reason_out = ($reason == '0' || empty($reason_out) || is_numeric($reason_out)) ? '.' : ". \n\r" . $user_lang['Reason'] . ': ' . $reason_out;
	$l_post_topic = ($row['topic_first_post_id'] == $post_id || $in_modcp) ? $user_lang['Topic'] : $user_lang['Post'];

	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name . '/viewtopic.'.$phpEx : '/' . $script_name . '/viewtopic.'.$phpEx;

	$url_absolute = $server_protocol . $server_name . $server_port . $script_name;

	$u_topic = $url_absolute . '?' . POST_TOPIC_URL . '=' . $topic_id;

	$topic_link = ($row['topic_first_post_id'] == $post_id || $in_modcp) ? '' : sprintf($user_lang['topic_link'], $u_topic);

	if ( $board_config['del_notify_method'] )
	{
		$user_lang['your_post'] = "\n\r\n\r" . $user_lang['your_post'];
		$message = sprintf($user_lang['notify_message'], $l_post_topic, '"' . $board_config['sitename'] . '"', $reason_out . $topic_link . $user_lang['your_post'] . $separator);

		require_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
		$emailer = new emailer($board_config['smtp_delivery']);

		$emailer->from($board_config['email_from']);
		$emailer->replyto($board_config['email_return_path']);

		$emailer->use_template('notify_delete', $row['user_lang']);
		$emailer->email_address($row['user_email']);
		$emailer->set_subject(sprintf($user_lang['subject_notify_delete'], $l_post_topic));

		$emailer->assign_vars(array(
			'SITENAME' => $board_config['sitename'],
			'BOARD_EMAIL' => $board_config['board_email'],
			'TO_USERNAME' => $row['username'],
			'URL' => $server_protocol . $server_name . $server_port,
			'MESSAGE' => stripslashes($message))
		);

		$emailer->send();
		$emailer->reset();
	}
	else
	{
		send_forum_pm($notify_user, sprintf($user_lang['subject_notify_delete'], $l_post_topic), sprintf($user_lang['notify_message'], $l_post_topic, '"' . $board_config['sitename'] . '"', $reason_out . $topic_link . $user_lang['your_post'] . $separator));
	}
	return;
}

function send_forum_pm($user_to_id, $nd_subject, $nd_message)
{
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx, $html_entities_match, $html_entities_replace;

	$sql = "SELECT *
		FROM " . USERS_TABLE . " 
		WHERE user_id = " . $user_to_id . "
		AND user_id <> " . ANONYMOUS;
	if ( !($result = $db->sql_query($sql)) )
	{
		return;
	}
	$to_userdata = $db->sql_fetchrow($result);

	require_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
	require_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);

	$bbcode_uid = make_bbcode_uid();
	$nd_message = str_replace("'", "''", $nd_message);

	$nd_message = prepare_message(trim($nd_message), 0, 1, 1, $bbcode_uid);

	$msg_time = CR_TIME;

	// Do inbox limit stuff
	$sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time 
		FROM " . PRIVMSGS_TABLE . " 
		WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . " 
			OR privmsgs_type = " . PRIVMSGS_READ_MAIL . " 
			OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " ) 
			AND privmsgs_to_userid = " . $to_userdata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		return;
	}

	$sql_priority = ( SQL_LAYER == 'mysql' ) ? 'LOW_PRIORITY' : '';

	if ( $inbox_info = $db->sql_fetchrow($result) )
	{
		if ( $inbox_info['inbox_items'] >= $board_config['max_inbox_privmsgs'] )
		{
			$sql = "DELETE $sql_priority FROM " . PRIVMSGS_TABLE . " 
				WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . " 
					OR privmsgs_type = " . PRIVMSGS_READ_MAIL . " 
					OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " ) 
						AND privmsgs_date = " . $inbox_info['oldest_post_time'] . " 
						AND privmsgs_to_userid = " . $to_userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				return;
			}
		}
	}

	$sql_info = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_ip, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig)
		VALUES (" . PRIVMSGS_NEW_MAIL . ", '" . str_replace("\'", "''", $nd_subject) . "', " . ANONYMOUS . ", " . $to_userdata['user_id'] . ", $msg_time, '$user_ip', 0, 1, 1, 1)";

	if ( !($result = $db->sql_query($sql_info, BEGIN_TRANSACTION)) )
	{
		return;
	}

	$privmsg_sent_id = $db->sql_nextid();

	$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_bbcode_uid, privmsgs_text)
		VALUES ($privmsg_sent_id, '" . $bbcode_uid . "', '" . str_replace("\'", "''", $nd_message) . "')";

	if ( !$db->sql_query($sql, END_TRANSACTION) )
	{
		return;
	}

	$sql = "UPDATE " . USERS_TABLE . "
		SET user_new_privmsg = user_new_privmsg + 1, user_last_privmsg = '9999999999'
		WHERE user_id = " . $to_userdata['user_id']; 
	if ( !$status = $db->sql_query($sql) )
	{
		return;
	}

	return;
}

function user_agent($agent)
{
	$agent_tst = ' ' . strtolower($agent);
	$sa = $ba = '';

	if (strpos($agent_tst, 'windows') || strpos($agent_tst, 'win9') || strpos($agent_tst, 'win32') || strpos($agent_tst, 'nt 5.') || strpos($agent_tst, 'nt 6.') || strpos($agent_tst, 'nt 4') )
	{
		$sa = 'windows';
	}
	else
	{
		$sa = (strpos($agent_tst, 'linux')) ? 'linux' : $sa;
		$sa = (strpos($agent_tst, 'suse')) ? 'suse' : $sa;
		$sa = (strpos($agent_tst, 'debian')) ? 'debian' : $sa;
		$sa = (strpos($agent_tst, 'redhat')) ? 'redhat' : $sa;
		$sa = (strpos($agent_tst, 'ubuntu')) ? 'ubuntu' : $sa;
		$sa = (strpos($agent_tst, 'bsd')) ? 'freebsd' : $sa; // I know, sorry :)
		$sa = (strpos($agent_tst, 'android')) ? 'android' : $sa;
	}
	if ( $sa == '')
	{
		$sa = (strpos($agent_tst, 'mac')) ? 'apple' : $sa;
		$sa = (strpos($agent_tst, 'unix')) ? 'unix' : $sa;
		$sa = (strpos($agent_tst, 'macos')) ? 'apple' : $sa;
		$sa = (strpos($agent_tst, 'mac os')) ? 'apple' : $sa;
		$sa = (strpos($agent_tst, 'playstation')) ? 'playstation' : $sa;
		$sa = (strpos($agent_tst, 'symbian')) ? 'symbian' : $sa;
		$sa = ($sa == '' && strpos($agent_tst, 'win9') || strpos($agent_tst, 'win3') || strpos($agent_tst, 'windows') ) ? 'windows' : $sa;
	}

	$ba = (strpos($agent_tst, 'mozilla')) ? 'firefox' : $ba;
	$ba = (strpos($agent_tst, 'msie')) ? 'ie' : $ba;
	$ba = (strpos($agent_tst, 'msie 7.0')) ? 'ie' : $ba; // IE7
	$ba = (strpos($agent_tst, 'msie 8.0')) ? 'ie' : $ba; // IE8
	$ba = (strpos($agent_tst, 'iemobile')) ? 'ie' : $ba; // IE Mobile
	$ba = (strpos($agent_tst, 'edge')) ? 'ie' : $ba; // Edge
	$ba = (strpos($agent_tst, 'opera')) ? 'opera' : $ba;
	$ba = (strpos($agent_tst, 'opera mobi')) ? 'opera' : $ba; // Opera Mobi
	$ba = (strpos($agent_tst, 'firefox')) ? 'firefox' : $ba;
	$ba = (strpos($agent_tst, 'chrome')) ? 'chrome' : $ba; // Chrome Google
	$ba = (strpos($agent_tst, 'safari')) ? 'apple' : $ba; // Safari

	$ba = ($ba == '') ? 'unknown' : $ba;
	$sa = ($sa == '') ? 'unknown' : $sa;

	return array('icon_' . $sa . '.png', 'icon_' . $ba . '.png', $agent);
}

function bbencode_strip($text, $uid)
{
	// pad it with a space so we can distinguish between FALSE and matching the 1st char (index 0).
	// This is important; bbencode_quote(), bbencode_list(), and bbencode_code() all depend on it.
	$text = ' ' . $text;

	if ( !(strpos($text, "[") && strpos($text, "]")) )
	{
		$text = substr($text, 1);
		return $text;
	}

	$text = str_replace("[code:1:$uid]","", $text);
	$text = str_replace("[/code:1:$uid]", " ", $text);
	$text = str_replace("[code:$uid]", "", $text);
	$text = str_replace("[/code:$uid]", " ", $text);

	$text = str_replace("[quote:1:$uid]","", $text);
	$text = str_replace("[/quote:1:$uid]", " ", $text);
	$text = str_replace("[quote:$uid]", "", $text);
	$text = str_replace("[/quote:$uid]", " ", $text);

	$text = preg_replace("/\[quote:$uid=(?:\"?([^\"]*)\"?)\]/si", "", $text);
	$text = preg_replace("/\[quote:1:$uid=(?:\"?([^\"]*)\"?)\]/si", "", $text);
	
	$text = str_replace("[list:$uid]", "", $text);
	$text = str_replace("[*:$uid]", " ", $text);
	$text = str_replace("[/list:u:$uid]", " ", $text);
	$text = str_replace("[/list:o:$uid]", " ", $text);
	$text = preg_replace("/\[list=([a1]):$uid\]/si", "", $text);

	$text = preg_replace("/\[color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", "", $text);
	$text = str_replace("[/color:$uid]", " ", $text);

	$text = str_replace("[url]","", $text);
	$text = str_replace("[/url]", " ", $text);
	$text = str_replace("[/URL]", " ", $text);

	$text = preg_replace("/\[url=([a-z0-9\-\.,\?!%\*_\/:;~\\&$@\/=\+]+)\]/si", "", $text);
	$text = str_replace("[/url]", " ", $text);

	$text = str_replace("[img:$uid]","", $text);
	$text = str_replace("[/img:$uid]", " ", $text);

	$text = str_replace("[email:$uid]","", $text);
	$text = str_replace("[/email:$uid]", " ", $text);

	$text = preg_replace("/\[size=([\-\+]?[1-2]?[0-9]):$uid\]/si", "", $text);
	$text = str_replace("[/size:$uid]", " ", $text);
	
	$text = preg_replace("/\[align=(left|right|center|justify):$uid\]/si", "", $text);
	$text = str_replace("[/align:$uid]", " ", $text);

	$text = str_replace("[b:$uid]","", $text);
	$text = str_replace("[/b:$uid]", " ", $text);

	$text = str_replace("[u:$uid]", "", $text);
	$text = str_replace("[/u:$uid]", " ", $text);

	$text = str_replace("[i:$uid]", "", $text);
	$text = str_replace("[/i:$uid]", " ", $text);

	$text = str_replace("[fade:$uid]", "", $text);
	$text = str_replace("[/fade:$uid]", " ", $text);

	$text = str_replace("[scroll:$uid]", "", $text);
	$text = str_replace("[/scroll:$uid]", " ", $text);

	$text = str_replace("[center:$uid]", "", $text);
	$text = str_replace("[/center:$uid]", " ", $text);

	$text = preg_replace("/\[glow=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", "", $text);
	$text = str_replace("[/glow:$uid]", " ", $text);

	$text = preg_replace("/\[shadow=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", "", $text);
	$text = str_replace("[/shadow:$uid]", " ", $text);

	$text = str_replace("[g:$uid]", "", $text);
	$text = str_replace("[/g:$uid]", " ", $text);

	$text = str_replace("[you:$uid]", "you", $text);

	$text = preg_replace("#\[hide:$uid\](.*?)\[/hide:$uid\]#si"," ", $text);

	$text = preg_replace("#\[mod\](.*?)\[/mod\]#si"," ", $text);

	$text = substr($text, 1);

	return $text;
}

function users_online($mode)
{
	global $db, $lang, $board_config, $userdata, $forum_id, $phpEx;

	$logged_visible_online = $logged_hidden_online = $guests_online = 0;
	$online_userlist = '';

	if ( empty($forum_id) )
	{
		global $tree;
		$forum_data = sql_cache('check', 'forum_data');
		if (!isset($forum_data))
		{
			$forum_data = array();
			$sql = "SELECT *
				FROM " . FORUMS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				$forum_data[] = $row;
			}

			sql_cache('write', 'forum_data', $forum_data);
		}
		$forums_data = array();
		if ( is_array($forum_data) )
		{
			foreach($forum_data as $key => $val)
			{
				$forums_data[$val['forum_id']] = get_object_lang(POST_FORUM_URL . $val['forum_id'], 'name');
			}
		}
	}

	$user_forum_sql = ( !empty($forum_id) ) ? "AND s.session_page = " . intval($forum_id) : '';

	$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, 
		u.user_jr, u.user_session_time, u.user_session_start, s.session_logged_in,
		s.session_ip, s.session_start, s.session_page
		FROM (" . USERS_TABLE . " u, " . SESSIONS_TABLE . " s)
		WHERE u.user_id = s.session_user_id
			AND s.session_time >= ".( CR_TIME - 300 ) . "
		$user_forum_sql
		ORDER BY u.user_level = 1 DESC, u.user_jr DESC, u.user_level = 2 DESC, u.user_level = 0 DESC, u.username, s.session_start ASC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user/online information', '', __LINE__, __FILE__, $sql);
	}

	$prev_user_id = 0;
	$prev_session_ip = array();

	while( $row = $db->sql_fetchrow($result) )
	{
		// User is logged in and therefor not a guest
		if ( $row['session_logged_in'] )
		{
			// Skip multiple sessions for one user
			if ( $row['user_id'] != $prev_user_id )
			{
				if ( $board_config['overlib'] && $userdata['overlib'] && $mode != 'viewforum' )
				{
					if ( $row['session_page'] < 1 || !$tree['auth'][POST_FORUM_URL . $row['session_page']]['auth_view']	)
					{
						switch( $row['session_page'] )
						{
							case PAGE_INDEX:
								$location = $lang['Forum_index'];
								break;
							case PAGE_POSTING:
								$location = $lang['Posting_message'];
								break;
							case PAGE_LOGIN:
								$location = $lang['Logging_on'];
								break;
							case PAGE_SEARCH:
								$location = $lang['Searching_forums'];
								break;
							case PAGE_PROFILE:
								$location = $lang['Viewing_profile'];
								break;
							case PAGE_VIEWONLINE:
								$location = $lang['Viewing_online'];
								break;
							case PAGE_VIEWMEMBERS:
								$location = $lang['Viewing_member_list'];
								break;
							case PAGE_TOPIC_VIEW:
								$location = $lang['Viewing_topic'];
								break;
							case PAGE_PRIVMSGS:
								$location = $lang['Viewing_priv_msgs'];
								break;
							case PAGE_FAQ:
								$location = $lang['Viewing_FAQ'];
								break;
							case PAGE_STAFF:
								$location = $lang['Staff'];
								break;
							case PAGE_GROUPCP:
								$location = $lang['Usergroups'];
								break;
							case PAGE_STATISTICS:
								$location = $lang['Statistics'];
								break;
							case PAGE_SHOUTBOX:
								$location = 'ShoutBox';
								break;
							case PAGE_ADMIN_PANEL:
								$location = $lang['Admin_panel'];
								break;
							default:
								$location = $lang['Forum_index'];
						}
					}
					else
					{
						$location_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . '=' . $row['session_page']);
						$location = $forums_data[$row['session_page']];
					}

					$user_time_online = ($row['user_session_start']) ? $row['user_session_time'] - $row['user_session_start'] : CR_TIME - $row['session_start'];

					$time_online = (($user_time_online) < 3600) ? round( ($user_time_online) / 60, 0 ) : round( ($user_time_online) / 60 / 60, 1 );
					$lang_online = (($user_time_online) < 3600) ? $lang['online_minutes'] : $lang['online_hours'];
					$overlib_online = 'onMouseOver="return overlib(\'<left>' . sprintf($lang_online, $time_online) . '<br /><b>' . str_replace(array("'", '"'), array('&amp;#039;', '&amp;quot;'), $location) . '</b></left>\', CAPTION, \'<center>' . str_replace("'","&amp;#039;", $row['username']) . '</center>\')" onMouseOut="nd();"';
				}
				else
				{
					$overlib_online = '';
				}

				$colored_username = color_username($row['user_level'], $row['user_jr'], $row['user_id'], $row['username']);
				// $row['username'] = $colored_username[0];

				// $row['session_page']

				if ( $row['user_allow_viewonline'] )
				{
					$user_online_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '" class="gensmall" ' . $overlib_online . $colored_username[1] .'>' . $row['username'] . '</a>';
					$logged_visible_online++;
				}
				else
				{
					$user_online_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '" class="gensmall" ' . $overlib_online . $colored_username[1] .'><i>' . $row['username'] . '</i></a>';
					$logged_hidden_online++;
				}

				if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
				{
					$online_userlist .= ( $online_userlist != '' ) ? ', ' . $user_online_link : $user_online_link;
				}
			}
			$prev_user_id = $row['user_id'];
		}
		else
		{
			// Skip multiple sessions for one user
			if ( !(in_array($row['session_ip'], $prev_session_ip)) )
			{
				$guests_online++;
			}
		}

		$prev_session_ip[] = $row['session_ip'];
	}
	$db->sql_freeresult($result);

	if ( empty($online_userlist) )
	{
		$online_userlist = $lang['None'];
	}
	$online_userlist = ( ( isset($forum_id) ) ? $lang['Browsing_forum'] : $lang['Registered_users'] ) . ' ' . $online_userlist;

	$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

	if ( $total_online_users > $board_config['record_online_users'] && isset($board_config['record_online_users']) )
	{
		$board_config['record_online_users'] = $total_online_users;
		$board_config['record_online_date'] = CR_TIME;

		update_config('record_online_users', $total_online_users);
		update_config('record_online_date', $board_config['record_online_date']);
	}

	if ( $total_online_users == 0 )
	{
		$l_t_user_s = $lang['Online_users_zero_total'];
	}
	else if ( $total_online_users == 1 )
	{
		$l_t_user_s = $lang['Online_user_total'];
	}
	else
	{
		$l_t_user_s = $lang['Online_users_total'];
	}

	if ( $logged_visible_online == 0 )
	{
		$l_r_user_s = $lang['Reg_users_zero_total'];
	}
	else if ( $logged_visible_online == 1 )
	{
		$l_r_user_s = $lang['Reg_user_total'];
	}
	else
	{
		$l_r_user_s = $lang['Reg_users_total'];
	}

	if ( $logged_hidden_online == 0 )
	{
		$l_h_user_s = $lang['Hidden_users_zero_total'];
	}
	else if ( $logged_hidden_online == 1 )
	{
		$l_h_user_s = $lang['Hidden_user_total'];
	}
	else
	{
		$l_h_user_s = $lang['Hidden_users_total'];
	}

	if ( $guests_online == 0 )
	{
		$l_g_user_s = $lang['Guest_users_zero_total'];
	}
	else if ( $guests_online == 1 )
	{
		$l_g_user_s = $lang['Guest_user_total'];
	}
	else
	{
		$l_g_user_s = $lang['Guest_users_total'];
	}

	$l_online_users = sprintf($l_t_user_s, $total_online_users);
	$l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
	$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
	$l_online_users .= sprintf($l_g_user_s, $guests_online);
	// End online users

	return array($online_userlist, $l_online_users);
}

function mkrealdate($day,$month,$birth_year)
{
	// range check months
	if ( $month < 1 || $month > 12)
	{
		return 'error';
	}
	// range check days
	switch ($month)
	{
		case 1: if ( $day > 31) return 'error';
		break;
		case 2: if ( $day > 29)
			return 'error';
			$epoch = $epoch + 31;
			break;
		case 3: if ( $day > 31)
			return 'error';
			$epoch = $epoch + 59;
			break;
		case 4: if ( $day > 30)
			return 'error' ;
			$epoch = $epoch + 90;
			break;
		case 5: if ( $day > 31)
			return 'error';
			$epoch = $epoch + 120;
			break;
		case 6: if ( $day > 30)
			return 'error';
			$epoch = $epoch + 151;
			break;
		case 7: if ( $day > 31)
			return 'error';
			$epoch = $epoch + 181;
			break;
		case 8: if ( $day > 31)
			return 'error';
			$epoch = $epoch + 212;
			break;
		case 9: if ( $day > 30)
			return 'error';
			$epoch = $epoch + 243;
			break;
		case 10: if ( $day > 31)
			return 'error';
			$epoch = $epoch + 273;
			break;
		case 11: if ( $day > 30)
			return 'error';
			$epoch = $epoch + 304;
			break;
		case 12: if ( $day > 31)
			return 'error';
			$epoch = $epoch + 334;
			break;
	}
	$epoch = $epoch + $day;
	$epoch_Y = sqrt(($birth_year - 1970) * ($birth_year - 1970));
	$leapyear = round((($epoch_Y + 2) / 4)-.5);
	if (($epoch_Y + 2) % 4 == 0 )
	{
		// curent year is leapyear
		$leapyear--;
		if ( $birth_year > 1970 && $month >= 3)
		{
			$epoch = $epoch + 1;
		}
		if ( $birth_year < 1970 && $month < 3)
		{
			$epoch = $epoch - 1;
		}
	}
	else if ( $month == 2 && $day > 28 && date("L") == 0)
	{
		return 'error'; //only 28 days in feb.
	}
	else if ( $month == 2 && $day > 29 && date("L") == 1)
	{
		return 'error'; //only 29 days in feb., leapyear
	}
	//year
	$epoch = ($birth_year > 1970) ? $epoch + $epoch_Y * 365 - 1 + $leapyear : $epoch - $epoch_Y * 365 - 1 - $leapyear;

	return $epoch;
}

function prepare_overlib_text($first_text, $last_text)
{
	global $first_and_last_post, $count_orig_word, $orig_word, $replacement_word;

	$first_text = strip_tags(str_replace("<br />", "\n", $first_text));
	$last_text = strip_tags(str_replace("<br />", "\n", $last_text));

	$overlib_post_text = ($first_and_last_post) ? str_replace('splited_posts_text', '', $first_text) . 'splited_posts_text' . str_replace('splited_posts_text', '', $last_text) : $first_text;
	$overlib_post_text = ($count_orig_word) ? preg_replace($orig_word, $replacement_word, $overlib_post_text) : $overlib_post_text;
	$overlib_post_text = preg_replace("#\[url=(.*?)\](.*?)\[\/url\]#si", "\\1", $overlib_post_text);
	$overlib_post_text = preg_replace("#\[url(.*?)\](.*?)\[\/url\]#si", "\\2", $overlib_post_text);
	$overlib_post_text = preg_replace("#\[mod\](.*?)\[\/mod\]#si", "<br />", $overlib_post_text);
	$overlib_post_text = preg_replace("#\[hide:(.*?)\](.*?)\[\/hide:(.*?)\]#si", "", $overlib_post_text);
	$pattern_bbcode1 = "#\[([\w:=\"^\]]+):([\w=\"^\]]+)\](.*?)\[/([\w:^\]]+):([\w^\]]+)\]#si";
	$pattern_bbcode2 = "#\[([\w:=\"^\]]+):([\w=\"^\]]+)\]#si";
	while( preg_match($pattern_bbcode1, $overlib_post_text) )
	{
		$overlib_post_text = preg_replace($pattern_bbcode1, "\\3", $overlib_post_text);
	}
	while( preg_match($pattern_bbcode2, $overlib_post_text) )
	{
		$overlib_post_text = preg_replace($pattern_bbcode2, "", $overlib_post_text);
	}
	$overlib_post_text = str_replace(array("\r", "'"), array(" ", '&#039;'), $overlib_post_text);
	$overlib_post_text_ary = explode('splited_posts_text', $overlib_post_text);
	$overlib_post_text = str_replace("\n", "<br />", xhtmlspecialchars(substr($overlib_post_text_ary[0], 0, 260) . (((strlen($overlib_post_text_ary[0]) > 260) ? ' [...]' : ''))));
	$overlib_last_post_text = str_replace("\n", "<br />", xhtmlspecialchars(substr($overlib_post_text_ary[1], 0, 260) . (((strlen($overlib_post_text_ary[1]) > 260) ? ' [...]' : ''))));

	return array($overlib_post_text, $overlib_last_post_text);
}

function check_disable_function($page)
{
	global $board_config, $userdata, $lang;

	if ( !$board_config['disable_type'] || $userdata['user_level'] == ADMIN)
	{
		return;
	}
	else
	{
		$reason = ($board_config['board_disable']) ? '<br /><br />' . $lang['Reason'] . ': ' . str_replace("\n", "\n<br />\n", $board_config['board_disable']) : '';

		if ( ($board_config['disable_type'] == 2 || $board_config['disable_type'] == 4) && $page == PAGE_POSTING )
		{
			message_die(GENERAL_MESSAGE, $lang['Posting_disabled'] . $reason);
		}
		else if ( ($board_config['disable_type'] == 3 || $board_config['disable_type'] == 4) && $page == 'REGISTERING' )
		{
			message_die(GENERAL_MESSAGE, $lang['Registering_disabled'] . $reason);
		}
	}
}

?>