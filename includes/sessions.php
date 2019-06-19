<?php
/***************************************************************************
 *                                sessions.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/09/25 14:11
 *
 *   $Id: sessions.php,v 1.58.2.16 2005/10/30 15:17:14 acydburn Exp $
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

function check_sid($sid, $option = false)
{
    if($sid == '' || is_array($sid)) return false;
    if(!preg_match('/^[A-Za-z0-9]*$/', $sid)) return false;

    if(!$option)
    {
        global $userdata;
        if($sid !== $userdata['session_id']) return false;
    }

    return true;
}

function check_access($userdata)
{
	global $db, $client_ip, $user_ip, $HTTP_COOKIE_VARS, $unique_cookie_name, $board_config, $phpEx, $phpbb_root_path, $lang;

	$cookiepath = $board_config['cookie_path'];
	$cookiedomain = $board_config['cookie_domain'];
	$cookiesecure = $board_config['cookie_secure'];

	//
	// Initial ban check against user id, IP and email address
	//
	preg_match('/(..)(..)(..)(..)/', $user_ip, $user_ip_parts);

	$sql = "SELECT *
		FROM " . BANLIST_TABLE . " 
		WHERE ban_ip IN ('" . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . $user_ip_parts[4] . "', '" . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . "ff', '" . $user_ip_parts[1] . $user_ip_parts[2] . "ffff', '" . $user_ip_parts[1] . "ffffff')
			OR ban_userid = " . $userdata['user_id'];
	if ( $userdata['user_id'] != ANONYMOUS )
	{
		$sql .= " OR ban_email LIKE '" . str_replace("'", "''", $userdata['user_email']) . "' 
			OR ban_email LIKE '" . substr(str_replace("'", "''", $userdata['user_email']), strpos(str_replace("'", "''", $userdata['user_email']), "@")) . "'";
	}
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, 'Could not obtain ban information', '', __LINE__, __FILE__, $sql);
	}

	if ( $ban_info = $db->sql_fetchrow($result) )
	{
		$is_banned = true;
		if ( $ban_info['ban_expire_time'] && $ban_info['ban_expire_time'] < CR_TIME )
		{
			$sql = "DELETE FROM " . BANLIST_TABLE . " 
				WHERE ban_expire_time > 1
					AND ban_expire_time < " . CR_TIME;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(CRITICAL_ERROR, 'Could not delete ban expired', '', __LINE__, __FILE__, $sql);
			}
			$is_banned = false;
		}
	}

	if ( !$is_banned )
	{
		$sql = "SELECT *
			FROM " . BANLIST_TABLE . " 
			WHERE ban_host != ''";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not obtain ban information', '', __LINE__, __FILE__, $sql);
		}

		while( $row = $db->sql_fetchrow($result) )
		{
			if ( fit_address(@gethostbyaddr($client_ip), $row['ban_host']) )
			{
				$is_banned = true;
				$ban_info = $row;
			}
		}
	}

	if ( $is_banned || $HTTP_COOKIE_VARS[$unique_cookie_name . '_bb'] > (CR_TIME - (3600 * 24)) )
	{
		if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_main.'.$phpEx)) )
		{
			$userdata['user_lang'] = 'english';
		}
		include($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_main.' . $phpEx);

		setcookie($unique_cookie_name . '_bb', CR_TIME, (CR_TIME + 31536000), $cookiepath, $cookiedomain, $cookiesecure);

		if ($ban_info['ban_pub_reason_mode'] == '1')
		{
			$reason = str_replace("\n", "\n<br />\n", $ban_info['ban_priv_reason']);
		}
		else if ($ban_info['ban_pub_reason_mode'] == '2')
		{
			$reason = str_replace("\n", "\n<br />\n", $ban_info['ban_pub_reason']);
		}
		else
		{
			$reason = 'You_been_banned';
		}

		message_die(CRITICAL_MESSAGE, $reason);
	}

	if ( $board_config['warnings_enable'] && ($userdata['user_id'] != ANONYMOUS || $HTTP_COOKIE_VARS[$unique_cookie_name . '_b']) )
	{
		$warning_cookie_banned = ((!$board_config['expire_warnings'] && $HTTP_COOKIE_VARS[$unique_cookie_name . '_b']) || $HTTP_COOKIE_VARS[$unique_cookie_name . '_b'] > (CR_TIME - (3600 * 72))) ? true : false;
		if ( $board_config['expire_warnings'] )
		{
			$time_to_prune = CR_TIME - ($board_config['expire_warnings'] * 86400);

			$sql = "UPDATE " . WARNINGS_TABLE . "
				SET archive = 1
				WHERE date < $time_to_prune";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Couldnt update warnings table', '', __LINE__, __FILE__, $sql);
			}
		}

		$sql = "SELECT SUM(value) as val
			FROM " . WARNINGS_TABLE . "
			WHERE userid = " . $userdata['user_id'] . "
				AND archive = '0'";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Couldnt Query value info from warnings table', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$val = $row['val'];

		if ( $val >= $board_config['ban_warnings'] && $userdata['user_level'] != ADMIN ) 
		{
			setcookie($unique_cookie_name . '_b', CR_TIME, (CR_TIME + 31536000), $cookiepath, $cookiedomain, $cookiesecure);

			$sql = "SELECT COUNT(id) AS total
				FROM ". WARNINGS_TABLE ."
				WHERE archive = '0'
					AND userid = " . $userdata['user_id'];
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$warnings = $row['total'];

			$sql = "SELECT * FROM " . WARNINGS_TABLE . "
				WHERE userid = " . $userdata['user_id'] . "
				ORDER BY date DESC LIMIT 1";
			if ( !($result = $db->sql_query($sql)) ) 
			{
				message_die(CRITICAL_ERROR, 'Error getting user last warning info', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$last_date = create_date($board_config['default_dateformat'], $row['date'], $board_config['board_timezone']);
			$last_reason = $row['reason'];

			if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_main.'.$phpEx)) )
			{
				$userdata['user_lang'] = 'english';
			}
			include($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_main.' . $phpEx);

			if ( $warning_cookie_banned )
			{
				message_die(CRITICAL_MESSAGE, 'You_been_banned');
			}

			$message = sprintf($lang['warnings_banned_info'], $warnings, $val, $board_config['ban_warnings'], $last_date, str_replace("\n", "\n<br />\n", $last_reason));
			message_die(CRITICAL_MESSAGE, $message);
		}

		$sql = "SELECT warning_viewed FROM " . WARNINGS_TABLE . "
			WHERE userid = " . $userdata['user_id'] . "
				AND warning_viewed = 0";
		if ( !($result = $db->sql_query($sql)) ) 
		{ 
			message_die(CRITICAL_ERROR, 'Error getting user last warning info', '', __LINE__, __FILE__, $sql);
		}
		if ( $row = $db->sql_fetchrow($result) )
		{
			if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_main.'.$phpEx)) )
			{
				$userdata['user_lang'] = 'english';
			}
			include($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_main.' . $phpEx);

			$sql = "UPDATE " . WARNINGS_TABLE . "
				SET warning_viewed = 1
				WHERE userid = " . $userdata['user_id'];
			if ( !($result = $db->sql_query($sql)) ) 
			{ 
				message_die(CRITICAL_ERROR, 'Error getting user last warning info', '', __LINE__, __FILE__, $sql);
			}

			$message = sprintf($lang['warnings_lastwar_info'], '<a href="' . append_sid("warnings.$phpEx?mode=detail&amp;userid=" . $userdata['user_id']) . '">', '</a>');
			message_die(CRITICAL_MESSAGE, $message);
		}
	}
}

function make_over_userdata($userdata)
{
	global $HTTP_COOKIE_VARS, $unique_cookie_name, $board_config;

	unset($userdata['user_regdate'], $userdata['user_actkey'], $userdata['user_newpasswd'], $userdata['user_block_by'], $userdata['user_ip'], $userdata['user_spend_time'], $userdata['user_visit']);

	$_cookie_config = md5('_cookie_config' . $userdata['user_id']);

    $_uconf      = get_vars($unique_cookie_name.$_cookie_config, false, 'COOKIE');
	$user_config = ($_uconf) ? unserialize(stripslashes($_uconf)) : '';
	$default_enable = array('user_allow_signature', 'user_allow_sig_image', 'user_showavatars', 'page_avatar', 'view_ignore_topics', 'overlib', 'topic_start_date', 'ctop', 'onmouse', 'custom_color_use', 'custom_rank', 'cload', 'u_o_t_d', 'cagent', 'level', 'cignore', 'cquick', 'show_smiles', 'shoutbox', 'post_icon');
	$default_board_config = array('user_hot_threshold', 'user_sub_forum', 'user_split_cat', 'user_last_topic_title', 'user_sub_level_links', 'user_display_viewonline');
	$user_config_vars = array_merge(array('user_dateformat', 'user_topics_per_page', 'user_posts_per_page', 'simple_head', 'advertising'), $default_enable, $default_board_config);
	for($i = 0; $i < count($user_config_vars); $i++)
	{
		if ( isset($user_config[$user_config_vars[$i]]) )
		{
			$userdata[$user_config_vars[$i]] = $user_config[$user_config_vars[$i]];
		}
		else if ( in_array($user_config_vars[$i], $default_board_config) )
		{
			$userdata[$user_config_vars[$i]] = $board_config[str_replace('user_', '', $user_config_vars[$i])];
		}
		else if ( in_array($user_config_vars[$i], $default_enable) )
		{
			$userdata[$user_config_vars[$i]] = true;
		}
	}
	unset($user_config, $user_config_vars, $default_board_config, $default_enable);

    $userdata['user_topics_per_page'] = (!isset($userdata['user_topics_per_page']) || intval($userdata['user_topics_per_page']) < 1 || intval($userdata['user_topics_per_page']) > $board_config['topics_per_page'])     ? $board_config['topics_per_page'] : intval($userdata['user_topics_per_page']);
    $userdata['user_posts_per_page']  = (!isset($userdata['user_posts_per_page'])  || intval($userdata['user_posts_per_page'])  < 1 || intval($userdata['user_posts_per_page'])  > $board_config['user_posts_per_page']) ? $board_config['posts_per_page']  : intval($userdata['user_posts_per_page']);
    $userdata['user_hot_threshold']   = (!isset($userdata['user_hot_threshold'])   || intval($userdata['user_hot_threshold'])   < 1 || intval($userdata['user_hot_threshold'])   > $board_config['hot_threshold'])       ? $board_config['hot_threshold']   : intval($userdata['user_hot_threshold']);
	$date_formats = array(
    'D d M, Y',
    'D d M, Y g:i a',
    'D d M, Y H:i',
    'D d M, y',
    'D d M, y g:i a',
    'D d M, y H:i',
    'D M d, Y',
    'D M d, Y g:i a',
    'D M d, Y H:i',
    'D M d, y',
    'D M d, y g:i a',
    'D M d, y H:i',
    'd M Y h:i a',
    'd M Y h:i',
    'd M y h:i',
    'j F Y',
    'j F Y, g:i a',
    'j F Y, H:i',
    'j F y',
    'j F y, g:i a',
    'j F y, H:i',
    'Y-m-d',
    'Y-m-d, g:i a',
    'Y-m-d, H:i',
    'd-m-Y',
    'd-m-Y, g:i ',
    'd-m-Y, H:i',
    'y-m-d',
    'y-m-d, g:i a',
    'y-m-d, H:i',
    'd-m-y',
    'd-m-y, g:i a',
    'd-m-y, H:i');
    $userdata['user_dateformat'] = (!empty($userdata['user_dateformat']) && in_array($userdata['user_dateformat'], $date_formats)) ? $userdata['user_dateformat'] : $board_config['default_dateformat'];
    $userdata['user_new_privmsg'] = $userdata['user_new_privmsg'] > 65000 ? 0 : $userdata['user_new_privmsg'];
    $userdata['user_unread_privmsg'] = $userdata['user_unread_privmsg'] > 65000 ? 0 : $userdata['user_unread_privmsg'];
	return $userdata;
}

function fit_address($address, $search)
{
	if ( $address == $search )
	{
		return true;
	}
	else if ( stristr($search,'?') || stristr($search,'*') )
	{
		$search = str_replace(array('.', '*', '?', '/'), array('\.', '(.*)', '(.?)', '\/'), $search);

		if ( preg_match('/'.$search.'/i', $address) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else return false;
}

//
// Adds/updates a new session to the database for the given userid.
// Returns the new session ID on success.
//
function session_begin($user_id, $user_ip, $page_id, $auto_create = 0, $enable_autologin = 0, $admin = 0)
{
	global $db, $board_config, $client_ip, $user_ip;
	global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID, $unique_cookie_name;

	$cookiename = $unique_cookie_name;
	$cookiepath = $board_config['cookie_path'];
	$cookiedomain = $board_config['cookie_domain'];
	$cookiesecure = $board_config['cookie_secure'];

	if ( isset($HTTP_COOKIE_VARS[$cookiename . '_sid']) || isset($HTTP_COOKIE_VARS[$cookiename . '_data']) )
	{
		$session_id = isset($HTTP_COOKIE_VARS[$cookiename . '_sid']) ? $HTTP_COOKIE_VARS[$cookiename . '_sid'] : '';
		$sessiondata = isset($HTTP_COOKIE_VARS[$cookiename . '_data']) ? unserialize(stripslashes($HTTP_COOKIE_VARS[$cookiename . '_data'])) : array();
		$sessionmethod = SESSION_METHOD_COOKIE;
		$sessiondata['userid'] = intval($sessiondata['userid']);
	}
	else
	{
		$sessiondata = array();
		$session_id = ( isset($HTTP_GET_VARS['sid']) ) ? $HTTP_GET_VARS['sid'] : '';
		$sessionmethod = SESSION_METHOD_GET;
	}

	//
	if ( !check_sid($session_id, true) ) 
	{
		$session_id = '';
	}

	$page_id = (int) $page_id;

	$last_visit = 0;
	$current_time = CR_TIME;

	//
	// Are auto-logins allowed?
	// If allow_autologin is not set or is true then they are
	// (same behaviour as old 2.0.x session code)
	//
	if (isset($board_config['allow_autologin']) && !$board_config['allow_autologin'])
	{
		$enable_autologin = $sessiondata['autologinid'] = false;
	}

	// 
	// First off attempt to join with the autologin value if we have one
	// If not, just use the user_id value
	//
	$userdata = array();

	if ($user_id != ANONYMOUS)
	{
		if (isset($sessiondata['autologinid']) && (string) $sessiondata['autologinid'] != '' && $user_id)
		{
			// Auto login key reset if last visit user IP is different
			// It use "max_autologin_time" value as security level
			$sql = "SELECT user_ip, user_level, user_jr, user_ip_login_check
				FROM " . USERS_TABLE . "
				WHERE user_id = " . (int) $user_id;
			if (!($result = $db->sql_query($sql)))
			{
				message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
			}
			$secure_data = $db->sql_fetchrow($result);

			$do_secure_ip_check = true;

			$do_secure_ip_check = ( ($board_config['allow_autologin'] == 2 || $board_config['allow_autologin'] == 1) && ($board_config['allow_autologin'] == 2 || ($secure_data['user_level'] != USER || $secure_data['user_jr'])) && $secure_data['user_ip_login_check'] ) ? true : false;

			if ( (!$secure_data['user_ip'] || $secure_data['user_ip'] != $user_ip) && $do_secure_ip_check )
			{ 
				$sessiondata['autologinid'] = $enable_autologin = '';
				$user_id = ANONYMOUS;
			}
			else
			{
				$sql = 'SELECT u.* 
					FROM (' . USERS_TABLE . ' u, ' . SESSIONS_KEYS_TABLE . ' k)
					WHERE u.user_id = ' . (int) $user_id . "
						AND u.user_active = 1
						AND k.user_id = u.user_id
						AND k.key_id = '" . md5($sessiondata['autologinid']) . "'";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
				}

				$userdata = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
			}
		
			$enable_autologin = $login = 1;
		}
		else if (!$auto_create)
		{
			$sessiondata['autologinid'] = '';
			$sessiondata['userid'] = $user_id;

			$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . (int) $user_id . '
					AND user_active = 1';
			if (!($result = $db->sql_query($sql)))
			{
				message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
			}

			$userdata = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$login = 1;
		}
	}

	//
	// At this point either $userdata should be populated or
	// one of the below is true
	// * Key didn't match one in the DB
	// * User does not exist
	// * User is inactive
	//
	if (!sizeof($userdata) || !is_array($userdata) || !$userdata)
	{
		$sessiondata['autologinid'] = '';
		$sessiondata['userid'] = $user_id = ANONYMOUS;
		$enable_autologin = $login = 0;

		$sql = 'SELECT *
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $user_id;
		if (!($result = $db->sql_query($sql)))
		{
			message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
		}

		$userdata = $db->sql_fetchrow($result);

		$db->sql_freeresult($result);
	}

	if ( !$auto_create ) // If login by form
	{
		check_access($userdata);
	}

	//
	// Create or update the session
	//
	$sql = "UPDATE " . SESSIONS_TABLE . "
		SET session_user_id = $user_id, session_time = $current_time, session_page = $page_id, session_logged_in = $login, session_admin = $admin
		WHERE session_id = '" . $session_id . "' 
			AND session_ip = '$user_ip'
			AND session_time > " . ($current_time - $board_config['session_length']);
	if ( !$db->sql_query($sql) || !$db->sql_affectedrows() )
	{
		// If new session is created
		check_access($userdata);

		list($sec, $usec) = explode(' ', microtime());
		mt_srand((float) $sec + ((float) $usec * 100000));
		$session_id = md5(uniqid(mt_rand(), true));

		$sql = "INSERT INTO " . SESSIONS_TABLE . "
			(session_id, session_user_id, session_start, session_time, session_ip, session_page, session_logged_in, session_admin)
			VALUES ('$session_id', $user_id, $current_time, $current_time, '$user_ip', $page_id, $login, $admin)";
		if ( !$db->sql_query($sql) )
		{
			$db->sql_query("DELETE QUICK FROM " . SESSIONS_TABLE . " $delete_order LIMIT 50");

			if (!$db->sql_query($sql))
			{
				message_die(CRITICAL_ERROR, 'Error creating new session', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if ( $user_id != ANONYMOUS )
	{
		$last_visit = ( $userdata['user_session_time'] > 0 ) ? $userdata['user_session_time'] : $current_time; 

		if (!$admin)
		{
			$sql = "UPDATE " . USERS_TABLE . "
				SET user_session_time = $current_time, user_session_page = $page_id, user_lastvisit = $last_visit
				" . (($current_time - $userdata['user_session_time'] > $board_config['session_length']) ? ", user_session_start = $current_time, user_visit = user_visit + 1, user_ip = '$user_ip'" : "") . "
				WHERE user_id = $user_id";
			if ( !$db->sql_query($sql) )
			{
				message_die(CRITICAL_ERROR, 'Error updating last visit time', '', __LINE__, __FILE__, $sql);
			}
		}

		$userdata['user_lastvisit'] = $last_visit;

		//
		// Regenerate the auto-login key
		//
		if ($enable_autologin)
		{
			list($sec, $usec) = explode(' ', microtime());
			mt_srand(hexdec(substr($session_id, 0, 8)) + (float) $sec + ((float) $usec * 1000000));
			$auto_login_key = uniqid(mt_rand(), true);

			$sql = "SELECT key_id FROM " . SESSIONS_KEYS_TABLE . " 
				WHERE user_id = " . intval($user_id) . "
				ORDER BY last_login DESC";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(CRITICAL_ERROR, 'Could not get from keys table', '', __LINE__, __FILE__, $sql);
			}
			$key_ids = '';
			$exists_keys = $updated = 0;
			while( $row = $db->sql_fetchrow($result) )
			{
				if ( $exists_keys > 0 )
				{
					$key_ids .= (($key_ids) ? ', ' : '') . "'" . $row['key_id'] . "'";
				}
				$exists_keys++;
			}
			if ( $exists_keys == 2 )
			{
				$sql = "UPDATE " . SESSIONS_KEYS_TABLE . "
					SET key_id = '" . md5($auto_login_key) . "', last_ip = '$user_ip', last_login = $current_time
					WHERE user_id = $user_id
						AND key_id = $key_ids";

				if ( !$db->sql_query($sql) )
				{
					message_die(CRITICAL_ERROR, 'Error updating session key', '', __LINE__, __FILE__, $sql);
				}
				$updated = true;
			}
			else if ( $key_ids )
			{
				$sql = "DELETE FROM " . SESSIONS_KEYS_TABLE . " 
					WHERE key_id IN($key_ids)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(CRITICAL_ERROR, 'Could not delete from keys table', '', __LINE__, __FILE__, $sql);
				}
			}
			if ( !$updated )
			{
				$sql = 'INSERT INTO ' . SESSIONS_KEYS_TABLE . "(key_id, user_id, last_ip, last_login)
					VALUES ('" . md5($auto_login_key) . "', $user_id, '$user_ip', $current_time)";

				if ( !$db->sql_query($sql) )
				{
					message_die(CRITICAL_ERROR, 'Error updating session key', '', __LINE__, __FILE__, $sql);
				}
			}
			$sessiondata['autologinid'] = $auto_login_key;
			unset($auto_login_key);
		}
		else
		{
			$sessiondata['autologinid'] = '';
		}

//		$sessiondata['autologinid'] = (!$admin) ? (( $enable_autologin && $sessionmethod == SESSION_METHOD_COOKIE ) ? $auto_login_key : '') : $sessiondata['autologinid'];
		$sessiondata['userid'] = $user_id;
	}

	$userdata['session_id'] = $session_id;
	$userdata['session_ip'] = $user_ip;
	$userdata['session_user_id'] = $user_id;
	$userdata['session_logged_in'] = $login;
	$userdata['session_page'] = $page_id;
	$userdata['session_start'] = $current_time;
	$userdata['session_time'] = $current_time;
	$userdata['session_admin'] = $admin;
	$userdata['session_key'] = $sessiondata['autologinid'];

	setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);
	setcookie($cookiename . '_sid', $session_id, 0, $cookiepath, $cookiedomain, $cookiesecure);

	$SID = 'sid=' . $session_id;

	if ( $user_id == ANONYMOUS )
	{
		$userdata['user_active'] = $userdata['user_session_time'] = $userdata['user_session_page'] = $userdata['user_lastvisit'] = $userdata['user_level'] = $userdata['user_posts'] = $userdata['user_new_privmsg'] = $userdata['user_unread_privmsg'] = $userdata['user_last_privmsg'] = $userdata['user_allow_pm'] = $userdata['user_notify'] = $userdata['user_rank'] = $userdata['user_avatar_type'] = $userdata['user_badlogin'] = 0;
	}

	return make_over_userdata($userdata);
}

//
// Checks for a given user session, tidies session table and updates user
// sessions at each page refresh
//
function session_pagestart($user_ip, $thispage_id)
{
	global $db, $lang, $board_config;
	global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID, $unique_cookie_name;

	$cookiename = $unique_cookie_name;
	$cookiepath = $board_config['cookie_path'];
	$cookiedomain = $board_config['cookie_domain'];
	$cookiesecure = $board_config['cookie_secure'];

	$current_time = CR_TIME;
	if ( isset($userdata) ) unset($userdata);

	if ( isset($HTTP_COOKIE_VARS[$cookiename . '_sid']) || isset($HTTP_COOKIE_VARS[$cookiename . '_data']) )
	{
		$sessiondata = isset( $HTTP_COOKIE_VARS[$cookiename . '_data'] ) ? unserialize(stripslashes($HTTP_COOKIE_VARS[$cookiename . '_data'])) : array();
		$session_id = isset( $HTTP_COOKIE_VARS[$cookiename . '_sid'] ) ? $HTTP_COOKIE_VARS[$cookiename . '_sid'] : '';
		$sessionmethod = SESSION_METHOD_COOKIE;
	}
	else
	{
		$sessiondata = array();
		$session_id = ( isset($HTTP_GET_VARS['sid']) ) ? $HTTP_GET_VARS['sid'] : '';
		$sessionmethod = SESSION_METHOD_GET;
	}

	// 
	if ( !check_sid($session_id, true) )
	{
		$session_id = '';
	}

	$thispage_id = (int) $thispage_id;

	//
	// Does a session exist?
	//
	if ( !empty($session_id) )
	{
		//
		// session_id exists so go ahead and attempt to grab all
		// data in preparation
		//
		$sql = "SELECT u.*, s.*
			FROM (" . SESSIONS_TABLE . " s, " . USERS_TABLE . " u)
			WHERE s.session_id = '$session_id'
				AND u.user_id = s.session_user_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
		}

		$userdata = $db->sql_fetchrow($result);

		//
		// Did the session exist in the DB?
		//
		if ( isset($userdata['user_id']) )
		{
			if ( ((!$board_config['expire_warnings'] && $HTTP_COOKIE_VARS[$unique_cookie_name . '_b']) || $HTTP_COOKIE_VARS[$unique_cookie_name . '_b'] > (CR_TIME - (3600 * 72)) || $HTTP_COOKIE_VARS[$unique_cookie_name . '_bb'] > (CR_TIME - (3600 * 24)) && $userdata['user_id'] == ANONYMOUS ) )
			{
				message_die(CRITICAL_MESSAGE, 'You_been_banned');
			}

			//
			// Do not check IP assuming equivalence, if IPv4 we'll check only first 24
			// bits ... I've been told (by vHiker) this should alleviate problems with 
			// load balanced et al proxies while retaining some reliance on IP security.
			//
			$ip_check_s = substr($userdata['session_ip'], 0, 6);
			$ip_check_u = substr($user_ip, 0, 6);

			if ($ip_check_s == $ip_check_u)
			{
				$SID = ($sessionmethod == SESSION_METHOD_GET || defined('IN_ADMIN')) ? 'sid=' . $session_id : '';

				//
				// Only update session DB a minute or so after last update
				//
				if ( $current_time - $userdata['session_time'] > 60 )
				{
					// A little trick to reset session_admin on session re-usage
					$update_admin = (!defined('IN_ADMIN') && $current_time - $userdata['session_time'] > ($board_config['session_length']+60)) ? ', session_admin = 0' : '';

					$sql = "UPDATE " . SESSIONS_TABLE . " 
						SET session_time = $current_time, session_page = $thispage_id$update_admin
						" . (($userdata['session_time'] < ($current_time - $board_config['session_length'])) ? ", session_start = " . $current_time : "") . "
						WHERE session_id = '" . $userdata['session_id'] . "'";
					if ( !$db->sql_query($sql) )
					{
						message_die(CRITICAL_ERROR, 'Error updating sessions table', '', __LINE__, __FILE__, $sql);
					}

					if ( $userdata['user_id'] != ANONYMOUS )
					{
						$sql = "UPDATE " . USERS_TABLE . " 
							SET user_session_time = $current_time, user_session_page = $thispage_id
							, " . (($userdata['session_time'] < ($current_time - $board_config['session_length'])) ? "user_session_start = $current_time, user_visit = user_visit + 1, user_lastvisit = " . $userdata['user_session_time'] . ", user_ip = '$user_ip'" : "user_spend_time = user_spend_time + " . ($current_time - $userdata['session_time'])) . "
							WHERE user_id = " . $userdata['user_id'];
						if ( !$db->sql_query($sql) )
						{
							message_die(CRITICAL_ERROR, 'Error updating sessions table', '', __LINE__, __FILE__, $sql);
						}
					}

					$sql = "DELETE FROM " . SESSIONS_TABLE . "
						WHERE session_time < " . (CR_TIME - (int) $board_config['session_length']) . " 
							AND session_id <> '" . $userdata['session_id'] . "'";
					if ( !$db->sql_query($sql) )
					{
						message_die(CRITICAL_ERROR, 'Error clearing sessions table', '', __LINE__, __FILE__, $sql);
					}

					setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);
					setcookie($cookiename . '_sid', $session_id, 0, $cookiepath, $cookiedomain, $cookiesecure);
				}

				if ( $userdata['user_id'] == ANONYMOUS )
				{
					$userdata['user_active'] = $userdata['user_session_time'] = $userdata['user_session_page'] = $userdata['user_lastvisit'] = $userdata['user_level'] = $userdata['user_posts'] = $userdata['user_new_privmsg'] = $userdata['user_unread_privmsg'] = $userdata['user_last_privmsg'] = $userdata['user_allow_pm'] = $userdata['user_notify'] = $userdata['user_rank'] = $userdata['user_avatar_type'] = $userdata['user_badlogin'] = 0;
				}

				return make_over_userdata($userdata);
			}
		}
	}

	//
	// If we reach here then no (valid) session exists. So we'll create a new one,
	// using the cookie user_id if available to pull basic user prefs.
	//
	$user_id = ( isset($sessiondata['userid']) ) ? intval($sessiondata['userid']) : ANONYMOUS;

	if ( ((!$board_config['expire_warnings'] && $HTTP_COOKIE_VARS[$unique_cookie_name . '_b']) || $HTTP_COOKIE_VARS[$unique_cookie_name . '_b'] > (CR_TIME - (3600 * 72)) || $HTTP_COOKIE_VARS[$unique_cookie_name . '_bb'] > (CR_TIME - (3600 * 24)) && $user_id == ANONYMOUS ) )
	{
		message_die(CRITICAL_MESSAGE, 'You_been_banned');
	}

	if ( !($userdata = session_begin($user_id, $user_ip, $thispage_id, TRUE)) )
	{
		message_die(CRITICAL_ERROR, 'Error creating user session', '', __LINE__, __FILE__, $sql);
	}

	if ( $userdata['user_id'] == ANONYMOUS )
	{
		$userdata['user_active'] = $userdata['user_session_time'] = $userdata['user_session_page'] = $userdata['user_lastvisit'] = $userdata['user_level'] = $userdata['user_posts'] = $userdata['user_new_privmsg'] = $userdata['user_unread_privmsg'] = $userdata['user_last_privmsg'] = $userdata['user_allow_pm'] = $userdata['user_notify'] = $userdata['user_rank'] = $userdata['user_avatar_type'] = $userdata['user_badlogin'] = 0;
	}

	return make_over_userdata($userdata);

}

/**
* Terminates the specified session
* It will delete the entry in the sessions table for this session,
* remove the corresponding auto-login key and reset the cookies
*/
function session_end($session_id, $user_id)
{
	global $db, $lang, $board_config, $userdata;
	global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID, $unique_cookie_name;

	$cookiename = $unique_cookie_name;
	$cookiepath = $board_config['cookie_path'];
	$cookiedomain = $board_config['cookie_domain'];
	$cookiesecure = $board_config['cookie_secure'];

	$current_time = CR_TIME;

	if ( !check_sid($session_id, true) )
	{
		return;
	}
	
	//
	// Delete existing session
	//
	$sql = 'DELETE FROM ' . SESSIONS_TABLE . " 
		WHERE session_id = '$session_id' 
			AND session_user_id = $user_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(CRITICAL_ERROR, 'Error removing user session', '', __LINE__, __FILE__, $sql);
	}

	//
	// Remove this auto-login entry (if applicable)
	//
	if ( isset($userdata['session_key']) && $userdata['session_key'] != '' )
	{
		$autologin_key = md5($userdata['session_key']);
		$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
			WHERE user_id = ' . (int) $user_id . "
				AND key_id = '$autologin_key'";
		if ( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Error removing auto-login key', '', __LINE__, __FILE__, $sql);
		}
	}

	//
	// We expect that message_die will be called after this function,
	// but just in case it isn't, reset $userdata to the details for a guest
	//
	$sql = 'SELECT *
		FROM ' . USERS_TABLE . '
		WHERE user_id = ' . ANONYMOUS;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, 'Error obtaining user details', '', __LINE__, __FILE__, $sql);
	}
	if ( !($userdata = $db->sql_fetchrow($result)) )
	{
		message_die(CRITICAL_ERROR, 'Error obtaining user details', '', __LINE__, __FILE__, $sql);
	}
	$db->sql_freeresult($result);

	setcookie($cookiename . '_data', '', $current_time - 31536000, $cookiepath, $cookiedomain, $cookiesecure);
	setcookie($cookiename . '_sid', '', $current_time - 31536000, $cookiepath, $cookiedomain, $cookiesecure);

	return true;
}

//
// Append $SID to a url. Borrowed from phplib and modified. This is an
// extra routine utilised by the session code above and acts as a wrapper
// around every single URL and form action. If you replace the session
// code you must include this routine, even if it's empty.
//
function append_sid($url, $non_html_amp = false, $subdir_off = false)
{
	global $SID, $subdirectory, $userdata;
	if($userdata['session_logged_in'])
	{
		if ( !empty($SID) && !preg_match('#sid=#', $url) )
		{
			$url .= ( ( strpos($url, '?') !== false ) ?  ( ( $non_html_amp ) ? '&' : '&amp;' ) : '?' ) . $SID;
		}

		if ( isset($subdirectory) && !$subdir_off )
		{
			$url = $subdirectory . $url;
		}
	}
	
	return $url;
}

function przemo_check_hash($value)
{
    global $userdata;

    if($value == '' || is_array($value) || !strpos($value,'-')) return false;
    $token = explode('-', $value);

    if(!isset($token[1])) return false;

    if( $token[1] === sha1(md5($userdata['user_password']).$token[0]) )
    {
        return true;
    }

    return false;
}

function przemo_create_hash()
{
    global $userdata;

    if($userdata['user_id'] == ANONYMOUS && !$userdata['user_password'])
    {
        global $board_config,$db;

        $key = md5($board_config['rand_seed'].microtime());
        $userdata['user_password'] = substr($key,2,20);

        $sql = "UPDATE ".USERS_TABLE." SET user_password='".$userdata['user_password']."' WHERE user_id=".ANONYMOUS." LIMIT 1";
        $db->sql_query($sql) or message_die(GENERAL_ERROR, 'Error in update users table', '', __LINE__, __FILE__, $sql);
    }

    return CR_TIME.'-'.sha1(md5($userdata['user_password']).CR_TIME);
}

?>