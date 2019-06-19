<?php
/***************************************************************************
 *                              reportpost.php
 *                            -------------------
 *   begin                : Saturday, Sep 14, 2002
 *   copyright            : (C) 2002 Saerdnaer
 *   email                : saerdnaer@web.de
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
	die("Hacking attempt");
}
if ( defined('REPORT_POST_INCLUDED') )
{
	return;
}
define('REPORT_POST_INCLUDED', true);

class Report_post_class {
	var $error_code;

	function get_forum_auth_sql($userdata, $suffix = '')
	{
		global $board_config;
		if ( $userdata['user_level'] == ADMIN )
		{
			return '';
		}
		else if ( $userdata['user_level'] <= USER )
		{
			$this->error_code[] = 101;
			return false;
		}
		else if ( $board_config['report_only_admin'] && $userdata['user_level'] > USER )
		{
			$this->error_code[] = 102;
			return false;
		}
		$auth = auth(AUTH_MOD, AUTH_LIST_ALL, $userdata);
		$forums_auth = array('yes' => '', 'yes_count' => 0, 'no' => '', 'no_count' => 0);
		while ( list($forum) = each($auth) )
		{
			if ( $auth[$forum]['auth_mod'] )
			{
				$forums_auth['yes'] .= ( empty($forums_auth['yes']) ? '' : ',' ) . $forum;
				$forums_auth['yes_count']++;
			}
			else
			{
				$forums_auth['no'] .= ( empty($forums_auth['no']) ? '' : ',' ) . $forum;
				$forums_auth['no_count']++;
			}
		}
		if ( $forums_auth['yes_count'] == 0 )
		{
			$this->error_code[] = 103;
			return false;
		}
		else if ( $forums_auth['no_count'] == 0 )
		{
			return '';
		}
		else
		{
			$t = ( $forums_auth['yes_count'] <= $forums_auth['no_count'] ) ? 'yes' : 'no';
			if ( $forums_auth[$t . '_count'] > 1 )
			{
				$forums_sql = 'AND ' . $suffix .  'forum_id ' . ( ( $t == 'no' ) ? 'NOT ' : '' ) . 'IN (' . $forums_auth[$t] . ')';
			}
			else
			{
				$forums_sql = 'AND ' . $suffix .  'forum_id ' . ( ( $t == 'no' ) ? '<> ' : '= ' ) . $forums_auth[$t];
			}
			return $forums_sql;
		}
	}
	function get_mods_auth_sql($forum_id, $suffix = '')
	{
		global $board_config;
		$auth_sql = "AND " . $suffix . "user_level = " . ADMIN;
		if ( !$board_config['report_only_admin'] )
		{
			$mods_sql = $this->get_moderators($forum_id);
			if ( !empty($mods_sql) )
			{
				$auth_sql = "AND ( " . $suffix . "user_level = " . ADMIN . " OR ( " . $suffix . "user_level > " . USER . " AND " . $suffix . "user_id IN (" . $mods_sql . ") ) )";
			}
		}
		return $auth_sql;
	}

	function check_report_popup($userdata)
	{
		global $db;
		$auth_sql = $this->get_forum_auth_sql($userdata);
		if ( is_bool($auth_sql) )
		{
			$this->error_code[] = 201;
			$this->reset_refresh_report_popup($userdata['user_id']);
			return false;
		}
		$sql	 = "SELECT COUNT(*) AS num FROM " . POSTS_TABLE . " WHERE reporter_id <> 0 $auth_sql";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Error by getting reported posts.", "", __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		if ( $row['num'] > 0 )
		{
			$return = true;
		}
		else
		{
			$this->error_code[] = 202;
			$return = false;
		}
		$this->reset_refresh_report_popup($userdata['user_id']);
		return $return;
	}
	function reset_refresh_report_popup($user_id)
	{
		global $db;
		$sql = "UPDATE " . USERS_TABLE . "
			SET refresh_report_popup = 0
			WHERE user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't reset refresh_report_popup.", "", __LINE__, __FILE__, $sql);
		}
		return true;
	}
	function update_refresh_report_popup($forum_id)
	{
		global $db;
		$auth_sql = $this->get_mods_auth_sql($forum_id);
		$sql = "UPDATE " . USERS_TABLE . "
			SET refresh_report_popup = 2
			WHERE no_report_popup = 0
				AND refresh_report_popup = 0
				$auth_sql";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update refresh_report_popup.", "", __LINE__, __FILE__, $sql);
		}
		return true;
	}
	function open_refresh_report_popup($forum_id)
	{
		global $db;
		$auth_sql = $this->get_mods_auth_sql($forum_id);
		$sql = "UPDATE " . USERS_TABLE . "
			SET refresh_report_popup = 1
			WHERE no_report_popup = 0
				AND refresh_report_popup = 0
				$auth_sql";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update refresh_report_popup.", "", __LINE__, __FILE__, $sql);
		}
		return true;
	}
	function report_auth($user_id)
	{
		global $db, $board_config;
		static $backup;
		if ( $backup == NULL )
		{
			$backup = true;
			if ( !empty($board_config['report_no_guestes']) && $user_id == ANONYMOUS )
			{
				$this->error_code[] = 111;
				$backup = false;
			}
			if ( $backup && !empty($board_config['report_no_auth_users']) )
			{
				if ( strpos(' ,' . $board_config['report_no_auth_users'] . ',', ',' . $user_id . ',') )
				{
					$this->error_code[] = 112;
					$backup = false;
				}
			}
			if ( $backup && !empty($board_config['report_no_auth_groups']) )
			{
				$sql = "SELECT count(*) AS count FROM " . USER_GROUP_TABLE . " WHERE user_id = '" . $user_id . "' AND group_id IN(" . $board_config['report_no_auth_groups'] . ")";
				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not select no report auth groups infos", "", __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);
				if ( $row['count'] > 0 )
				{
					$this->error_code[] = 113;
					$backup = false;
				}
			}
		}
		return $backup;
	}
	function report_disabled($user_id)
	{
		global $db, $board_config;
		if ( !empty($board_config['report_disabled_users']) )
		{
			if ( strpos(' ,' . $board_config['report_disabled_users'] . ',', ',' . $user_id . ',') )
			{
				$this->error_code[] = 121;
				return true;
			}
		}
		if ( !empty($board_config['report_disabled_groups']) )
		{
			$sql = "SELECT count(*) AS count FROM " . USER_GROUP_TABLE . " WHERE user_id = '" . $user_id . "' AND group_id IN(" . $board_config['report_disabled_groups'] . ")";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not select report disabled groups infos", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			if ( $row['count'] > 0 )
			{
				$this->error_code[] = 122;
				return true;
			}
		}
		return false;
	}
	function report_disabled2($user_id)
	{
		global $db, $board_config;
		static $disabled_user_ids;
		if ( empty($disabled_user_ids) )
		{
			$disabled_user_ids = array();
			if ( !empty($board_config['report_disabled_users']) )
			{
				$disabled_user_ids = array_flip( explode(',', $board_config['report_disabled_users']) );
			}
			if ( !empty($board_config['report_disabled_groups']) )
			{
				$sql = "SELECT user_id FROM " . USER_GROUP_TABLE . " WHERE group_id IN(" . $board_config['report_disabled_groups'] . ")";
				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not select report disabled groups infos", "", __LINE__, __FILE__, $sql);
				}
				while ( $row = $db->sql_fetchrow($result) )
				{
					$disabled_user_ids[$row['user_id']] = true;
				}
			}
		}
		if ( isset($disabled_user_ids[$user_id]) )
		{
			$this->error_code[] = 131;
			return true;
		}
		return false;
	}
	function get_moderators($forum_id)
	{
		global $db;
		static $backup;
		if ( $backup == NULL )
		{
			$backup = array();
		}
		if ( empty($backup[$forum_id]) )
		{
			$sql = "SELECT ug.user_id
				FROM (" . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug)
				WHERE aa.forum_id = $forum_id
					AND aa.auth_mod = " . TRUE . "
					AND ug.group_id = aa.group_id
				GROUP BY ug.user_id
				ORDER BY ug.user_id";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not query forum moderators', '', __LINE__, __FILE__, $sql);
			}

			$moderators = '';
			while( $row = $db->sql_fetchrow($result) )
			{
				$moderators .= ( empty($moderators) ? '' : ',' ) . $row['user_id'];
			}
			$backup[$forum_id] = $moderators;
		}
		return $backup[$forum_id];
	}
	function send_mail($to_userdata, $data)
	{
		global $emailer, $board_config, $phpEx, $phpbb_root_path;

		$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
		$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
		$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
		$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
		$script_name = ($script_name == '') ? $script_name : '/' . $script_name;

		$server_url = $server_protocol . $server_name . $server_port . $script_name;

		if ( !isset($emailer) )
		{
			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);
		}
		if ( $to_userdata['user_lang'] != $board_config['default_lang'] && !empty($to_userdata['user_lang']) )
		{
			include($phpbb_root_path . 'language/lang_' . $to_userdata['user_lang'] . '/lang_main.' . $phpEx);
		}
		else
		{
			global $lang;
		}
		if ( $data['poster_id'] == ANONYMOUS )
		{
			$postername = ( empty($data['post_username']) ? $lang['Guest'] : trim($data['post_username']) . ' (' . $lang['Guest'] . ')' );
		}
		else
		{
			$postername = $data['postername'];
		}

		$emailer->from($board_config['email_from']);
		$emailer->replyto($board_config['email_return_path']);

		$emailer->use_template('report_notify', $to_userdata['user_lang']);
		$emailer->email_address($to_userdata['user_email']);
		$emailer->set_subject($lang['User_report_post']);

		$emailer->assign_vars(array(
			'USERNAME' => $to_userdata['username'],
			'REPORTER' => $data['reportername'],
			'POSTER' => $postername,
			'SITENAME' => $board_config['sitename'],
			'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',

			'U_POST' => $server_url . "/viewtopic.$phpEx?" . POST_POST_URL . "=" . $data['post_id'] . '#' . $data['post_id'],
			'U_REPORTS' => $server_url . "/report.$phpEx")
		);

		$emailer->send();
		$emailer->reset();
	}
	function do_notification($forum_id, $data)
	{
		global $db;
		$auth_sql = $this->get_mods_auth_sql($forum_id);
		$sql = "SELECT username, user_email, user_lang
			FROM " . USERS_TABLE . "
			WHERE no_report_mail = 0 $auth_sql";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't notify moderstors and amdins.", "", __LINE__, __FILE__, $sql);
		}
		while( $to_userdata = $db->sql_fetchrow($result) )
		{
			$this->send_mail($to_userdata, $data);
		}
		return true;
	}
	function check_access($redirect = '', $with_login_and_error = false)
	{
		global $userdata, $board_config, $phpbb_root_path, $phpEx;
		if( $with_login_and_error && !$userdata['session_logged_in'] )
		{
			$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: '; 
			redirect(append_sid("login.$phpEx?redirect=$redirect", true));
		}
		else  if ( $userdata['user_level'] == ADMIN )
		{
			return true;
		}
		else if ( !$board_config['report_only_admin'] && $userdata['user_level'] > USER )
		{
			return true;
		}
		else if ( $with_login_and_error )
		{
			$this->error_code[] = 141;
			message_die(GENERAL_ERROR, 'Report_no_access');
		}
		$this->error_code[] = 141;
		return false;
	}

	function error($var_dumps = '')
	{
		if ( !empty($this->error_code) )
		{
			echo '<br/><hr/><span class="genmed">Report Post Hack Error Codes:<br/>';
			echo implode(', ', $this->error_code);
			echo '</span>';
		}
		if ( !empty($var_dumps) )
		{
			global $GLOBALS, $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_ENV_VARS, $HTTP_SERVER_VARS;
			$all = false;
			if ( $var_dumps == 'all' )
			{
				$all = true;
			}
			if ( $all || (strpos($var_dumps, 'v') !== false) )
			{
				echo '<hr/><span class="genmed">Var Dump $GLOBALS:<br/>';
				var_dump($GLOBALS);
				echo '</span>';
			}
			if ( $all || (strpos($var_dumps, 'g') !== false) )
			{
				echo '<hr/><span class="genmed">Var Dump $HTTP_GET_VARS:<br/>';
				var_dump($HTTP_GET_VARS);
				echo '</span>';
			}
			if ( $all || (strpos($var_dumps, 'p') !== false) )
			{
				echo '<hr/><span class="genmed">Var Dump $HTTP_POST_VARS:<br/>';
				var_dump($HTTP_POST_VARS);
				echo '</span>';
			}
			if ( $all || (strpos($var_dumps, 'c') !== false) )
			{
				echo '<hr/><span class="genmed">Var Dump $HTTP_COOKIE_VARS:<br/>';
				var_dump($HTTP_COOKIE_VARS);
				echo '</span>';
			}
			if ( $all || (strpos($var_dumps, 'e') !== false) )
			{
				echo '<hr/><span class="genmed">Var Dump $HTTP_ENV_VARS:<br/>';
				var_dump($HTTP_ENV_VARS);
				echo '</span>';
			}
			if ( $all || (strpos($var_dumps, 's') !== false) )
			{
				echo '<hr/><span class="genmed">Var Dump $HTTP_SERVER_VARS:<br/>';
				var_dump($HTTP_SERVER_VARS);
				echo '</span>';
			}
		}
	}
}
$rp = new Report_post_class;

?>