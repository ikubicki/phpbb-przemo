<?php
/***************************************************************************
 *                                login.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/10/09 16:12
 *
 *   $Id: login.php,v 1.47.2.20 2005/10/30 15:17:13 acydburn Exp $
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

//
// Allow people to reach login page if
// board is shut down
//
define("IN_LOGIN", true);

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

if ( !function_exists('file_get_contents') )
{
	function file_get_contents($filename)
	{
		$file = @fopen($filename, 'rb');
		if ( $file )
		{
			if ( $fsize = @filesize($filename) )
			{
				$data = @fread($file, $fsize);
			}
			else
			{
				$data = '';
				while (!@feof($file))
				{
					$data .= @fread($file, 1024);
				}
			}
			@fclose($file);
		}
		return $data;
	}
}

$config_content = @file_get_contents($phpbb_root_path . 'config.'.$phpEx);

if ( strpos($config_content, 'dbuser') && (substr($config_content, 0, 5) != '<?php') )
{
	print('&bull; You have <u>damaged</u>: <b>config.'.$phpEx.'</b> file !<br />&bull; File must begin with: <b>&lt;?php</b> and finish with <b>?&gt;</b> with any other chars (spaces, tabs or new line) before &lt;?php and after ?&gt;<br />&bull; You must correct the file !<br />&bull; Remember <u>it is not mistake</u>, if your text editor can not see this space, tab or new line, use other editor with operating multi (CR/LF) format or create new file with clean content.<br />&bull; Forum will not work correctly with damaged config.php file.<hr /><br />');
}

if ( $board_config['check_address'] )
{
	if ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) || !empty($HTTP_ENV_VARS['SERVER_NAME']) )
	{
		$hostname = ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) ) ? $HTTP_SERVER_VARS['SERVER_NAME'] : $HTTP_ENV_VARS['SERVER_NAME'];
	}
	else if ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) || !empty($HTTP_ENV_VARS['HTTP_HOST']) )
	{
		$hostname = ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) ) ? $HTTP_SERVER_VARS['HTTP_HOST'] : $HTTP_ENV_VARS['HTTP_HOST'];
	}
	else
	{
		$hostname = '';
	}
}
if ( $board_config['check_address'] && $hostname != $board_config['server_name'] && $hostname && $board_config['server_name'] && $board_config['script_path'] && !$HTTP_GET_VARS['redir'] && !$HTTP_POST_VARS['username'] && !$HTTP_GET_VARS['logout'] )
{
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$the_script_name = ($script_name == '') ? $script_name : '/' . $script_name;
	$script_name = ($script_name == '') ? $script_name . '/login.'.$phpEx : '/' . $script_name . '/login.'.$phpEx;

	$check_path_setup = @fopen($server_protocol . $server_name . $server_port . $the_script_name . '/extension.inc', 'r');
	if ( $check_path_setup )
	{
		@fclose($check_path_setup);
		$check_path_ok = true;
	}

	if ( $check_path_ok )
	{
		if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
		{
			header('Refresh: 0; URL=' . $server_protocol . $server_name . $server_port . $script_name. '?redir=1');
			echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $server_protocol . $server_name . $server_port . $script_name. '?redir=1"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $server_protocol . $server_name . $server_port . $script_name. '?redir=1">HERE</a> to be redirected</div></body></html>';
			exit;
		}

		// Behave as per HTTP/1.1 spec for others
		header('Location: ' . $server_protocol . $server_name . $server_port . $script_name. '?redir=1');
		exit;
	}
}

//
// Set page ID for session management
//
$userdata = session_pagestart($user_ip, PAGE_LOGIN);
init_userprefs($userdata, false);
//
// End session management
//

// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

$redirect_admin = (isset($HTTP_GET_VARS['admin']) || isset($HTTP_POST_VARS['admin'])) ? '&amp;admin=1' : '';

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_profile.' . $phpEx); 

if ( $HTTP_POST_VARS['send_key'] )
{
	$sql = "SELECT username, user_email, user_emailtime, user_actkey, user_lang
		FROM " . USERS_TABLE . "
		WHERE user_id = " . intval($HTTP_POST_VARS['send_key']) . "
			AND user_active = 0
			AND user_actkey <> ''";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{

		if ( $row['user_emailtime'] > (CR_TIME - 3600) )
		{
			message_die(GENERAL_MESSAGE, $lang['Flood_email_limit']);
		}

		$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
		$script_name = ( $script_name != '' ) ? $script_name . '/profile.'.$phpEx : 'profile.'.$phpEx;
		$server_name = trim($board_config['server_name']);
		$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

		$server_url = $server_protocol . $server_name . $server_port . $script_name;

		include($phpbb_root_path . 'includes/emailer.'.$phpEx);
		$emailer = new emailer($board_config['smtp_delivery']);

		$emailer->from($board_config['email_from']);
		$emailer->replyto($board_config['email_return_path']);

		$emailer->use_template('user_welcome_inactive', $row['user_lang']);
		$emailer->email_address($row['user_email']);
		$emailer->set_subject(sprintf($lang['Welcome_subject'], $board_config['sitename']));

		$emailer->assign_vars(array(
			'SITENAME' => $board_config['sitename'],
			'WELCOME_MSG' => sprintf($lang['Welcome_subject'], $board_config['sitename']),
			'USERNAME' => $row['username'],
			'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),

			'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $HTTP_POST_VARS['send_key'] . '&act_key=' . $row['user_actkey'])
		);
		$emailer->send();
		$emailer->reset();

		$sql = "UPDATE " . USERS_TABLE . " SET user_emailtime = '" . CR_TIME . "'
			WHERE user_id = " . intval($HTTP_POST_VARS['send_key']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error updating correct login data', '', __LINE__, __FILE__, $sql);
		}

		message_die(GENERAL_MESSAGE, $lang['Act_key_send']);
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['Act_key_not_send']);
	}
}

if( isset($HTTP_POST_VARS['login']) || isset($HTTP_GET_VARS['login']) || isset($HTTP_POST_VARS['logout']) || isset($HTTP_GET_VARS['logout']) )
{
	if( ( isset($HTTP_POST_VARS['login']) || isset($HTTP_GET_VARS['login']) ) && (!$userdata['session_logged_in'] || isset($HTTP_POST_VARS['admin'])) )
	{
		$username = isset($HTTP_POST_VARS['username']) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';
		$password = isset($HTTP_POST_VARS['password']) ? $HTTP_POST_VARS['password'] : '';

		$sql = "SELECT user_id, username, user_password, user_email, user_active, user_actkey, user_lastvisit, user_level, user_badlogin, user_blocktime, user_email, user_lang, user_timezone
			FROM " . USERS_TABLE . "
			WHERE username = '" . str_replace("\'", "''", $username) . "'";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
		}

		if( $row = $db->sql_fetchrow($result) )
		{
			if( $row['user_level'] != ADMIN && $board_config['disable_type'] == 1 )
			{
				redirect(append_sid("index.$phpEx", true));
			}
			else
			{
				if ( phpbb_check_hash($password, $row['user_password']) )
				{
					$password_true = true;
				}
				else if( @md5($password) === $row['user_password'] && !is_array($password) )
				{
					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_password = "'. phpbb_hash($password) .'"
						WHERE user_id = ' . $row['user_id'];
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Error updating correct login data', '', __LINE__, __FILE__, $sql);
					}
					$password_true = true;
				}
				else
				{
					$password_true = false;
				}
				
				if( $password_true && $row['user_active'] && $row['user_blocktime'] < CR_TIME )
				{
					$sql = "UPDATE " . USERS_TABLE . " SET user_badlogin = '0'
						WHERE user_id = " . $row['user_id'];
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Error updating correct login data', '', __LINE__, __FILE__, $sql);
					}
					$row['user_badlogin'] = 0;
				}

				if ( ($row['user_badlogin'] < $board_config['max_login_error'] && $row['user_blocktime'] < CR_TIME) || !$board_config['max_login_error'] )
				{
					if ( $password_true && $row['user_active'] )
					{
						$autologin = ( isset($HTTP_POST_VARS['autologin']) ) ? TRUE : 0;

						$admin = (isset($HTTP_POST_VARS['admin'])) ? 1 : 0;
						$session_id = session_begin($row['user_id'], $user_ip, PAGE_INDEX, FALSE, $autologin, $admin);

						if ( $session_id )
						{
							$sql = "UPDATE " . USERS_TABLE . " SET user_badlogin = '0'
								WHERE user_id = " . $row['user_id'];
							if ( !($result = $db->sql_query($sql)) )
							{
								message_die(GENERAL_ERROR, 'Error updating correct login data', '', __LINE__, __FILE__, $sql);
							}

							$url = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', xhtmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.$phpEx";

							redirect(append_sid($url, true));
						}
						else
						{
							message_die(CRITICAL_ERROR, "Couldn't start session : login", "", __LINE__, __FILE__);
						}
					}
					else
					{
						$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', xhtmlspecialchars($HTTP_POST_VARS['redirect'])) : '';
						$redirect = str_replace('?', '&', $redirect);

						if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
						{
							message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
						}

						if ( $row['user_active'] )
						{
							//count bad login
							// block the user for X min
							if ( ($row['user_badlogin'] + 1) % $board_config['max_login_error'] )
							{
								$sql = "UPDATE " . USERS_TABLE . " SET user_badlogin = user_badlogin + 1
									WHERE username = '" . str_replace("\'", "''", $username) . "'";
								if ( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Error updating bad login data', '', __LINE__, __FILE__, $sql);
								}
							}
							else
							{
								$blocktime = ", user_block_by = '$user_ip', user_blocktime = '" . (CR_TIME + ($board_config['block_time'] * 60)) . "'";
								$sql = "UPDATE " . USERS_TABLE . "
									SET user_badlogin = user_badlogin + 1 $blocktime
									WHERE username = '" . str_replace("\'", "''", $username) . "'";
								if ( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Error updating bad login data' . $user_ip, '', __LINE__, __FILE__, $sql);
								}

								if ( $row['user_email'] && $row['user_blocktime'] < (CR_TIME - 3600) )
								{
									include($phpbb_root_path . 'includes/emailer.'.$phpEx);
									$emailer = new emailer($board_config['smtp_delivery']);

									$emailer->from($board_config['email_from']);
									$emailer->replyto($board_config['email_return_path']);

									$emailer->email_address($row['user_email']);
									$emailer->use_template('bad_login', (file_exists(@phpbb_realpath($phpbb_root_path . "language/lang_" . $row['user_lang'] . "/email/bad_login.tpl"))) ? $row['user_lang'] : '' );
									$emailer->set_subject($lang['Account_blocked']);

									$emailer->assign_vars(array(
										'USER' => $row['username'],
										'BLOCK_TIME' => $board_config['block_time'],
										'BAD_LOGINS' => ($row['user_badlogin'] + 1),
										'BLOCK_UNTIL' => create_date ('D d. M, Y H:i:s', (CR_TIME + ($board_config['block_time'] * 60)), $row['user_timezone'], true),
										'SITENAME' => $board_config['sitename'],
										'BOARD_EMAIL' => $board_config['board_email'])
									);
									$emailer->send();
									$emailer->reset();
								}
							}
						}
						if ( !$row['user_active'] )
						{
							if ( $row['user_actkey'] )
							{
								if ( $row['user_lastvisit'] )
								{
									$error_login_message = sprintf($lang['Error_login_not_active'], stripslashes($username));
								}
								else
								{
									$send_form = '<form action="' . append_sid("login.$phpEx") . '" method="post"><input type="submit" name="send" value="' . $lang['Send_act_key'] . '" class="liteoption" /><input type="hidden" name="send_key" value="' . $row['user_id'] . '" /></form>';
									$error_login_message = sprintf($lang['Error_login_not_active_register'], stripslashes($username), $row['user_email']) . '<br /><br />' . $send_form;
								}
							}
							else
							{
								$error_login_message = sprintf($lang['Error_login_blocked'], stripslashes($username));
							}
						}
						else
						{
							$error_login_message = sprintf($lang['Error_login'], stripslashes($username));
						}

						$message = $error_login_message . '<br /><br />' . sprintf($lang['Click_return_login'], '<a href="' . append_sid("login.$phpEx?redirect=$redirect$redirect_admin") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
						message_die(GENERAL_MESSAGE, $message);
					}
				}
				else
				{
					$message = $lang['Error_login_tomutch'] . '<br /><br />' . sprintf($lang['Click_return_login'], '<a href="' . append_sid("login.$phpEx?redirect=$redirect$redirect_admin") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
			}
		}
		else
		{
			$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', xhtmlspecialchars($HTTP_POST_VARS['redirect'])) : "";
			$redirect = str_replace("?", "&", $redirect);
			if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
			{
				message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
			}

			$message = sprintf($lang['Error_login_not_username'], stripslashes($username)) . '<br /><br />' . sprintf($lang['Click_return_login'], '<a href="' . append_sid("login.$phpEx?redirect=$redirect$redirect_admin") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	else if( ( isset($HTTP_GET_VARS['logout']) || isset($HTTP_POST_VARS['logout']) ) && $userdata['session_logged_in'] )
	{
		// session id check
		if ( !check_sid($sid) )
		{
			message_die(GENERAL_ERROR, 'Invalid_session');
		}

		if( $userdata['session_logged_in'] )
		{
			session_end($userdata['session_id'], $userdata['user_id']);
		}

		if (!empty($HTTP_POST_VARS['redirect']) || !empty($HTTP_GET_VARS['redirect']))
		{
			$url = (!empty($HTTP_POST_VARS['redirect'])) ? xhtmlspecialchars($HTTP_POST_VARS['redirect']) : xhtmlspecialchars($HTTP_GET_VARS['redirect']);
			$url = str_replace('&amp;', '&', $url);
			redirect(append_sid($url, true));
		}
		else
		{
			redirect(append_sid("index.$phpEx", true));
		}
	}
	else
	{
		$url = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', xhtmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.$phpEx";
		redirect(append_sid($url, true));
	}
}
else
{
	//
	// Do a full login page dohickey if
	// user not already logged in
	//
	if( !$userdata['session_logged_in'] || (isset($HTTP_GET_VARS['admin']) && $userdata['session_logged_in'] && ($userdata['user_level'] == ADMIN || $userdata['user_jr'] ) ))
	{
		$page_title = $lang['Login'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->set_filenames(array(
			'body' => 'login_body.tpl')
		);

		$forward_page = '';

		if( isset($HTTP_POST_VARS['redirect']) || isset($HTTP_GET_VARS['redirect']) )
		{
			$forward_to = $HTTP_SERVER_VARS['QUERY_STRING'];

			if( preg_match("/^redirect=([a-z0-9\.#\/\?&=\+\-_]+)/si", $forward_to, $forward_matches) )
			{
				$forward_to = ( !empty($forward_matches[3]) ) ? $forward_matches[3] : $forward_matches[1];
				$forward_match = explode('&', $forward_to);

				if(count($forward_match) > 1)
				{
					for($i = 1; $i < count($forward_match); $i++)
					{
						if( !strstr($forward_match[$i], 'sid=') )
						{
							if( $forward_page != '' )
							{
								$forward_page .= '&';
							}
							$forward_page .= $forward_match[$i];
						}
					}
					$forward_page = $forward_match[0] . '?' . $forward_page;
				}
				else
				{
					$forward_page = $forward_match[0];
				}
			}
		}

		$username = ( $userdata['user_id'] != ANONYMOUS ) ? $userdata['username'] : '';

		if ( isset($HTTP_GET_VARS['admin']) )
		{
			if ( stristr($forward_page, 'admin_users.'.$phpEx) )
			{
				$forward_page = "admin/admin_users.$phpEx?mode=edit&" . POST_USERS_URL . "=" . intval($HTTP_GET_VARS[POST_USERS_URL]);
			}
			else if ( stristr($forward_page, 'admin_ug_auth.'.$phpEx) )
			{
				$forward_page = "admin/admin_ug_auth.$phpEx?mode=user&" . POST_USERS_URL . "=" . intval($HTTP_GET_VARS[POST_USERS_URL]);
			}
			else if ( stristr($forward_page, 'admin_account.'.$phpEx) )
			{
				$forward_page = "admin/admin_account.$phpEx";
			}
			else
			{
				$forward_page = "admin/index.$phpEx";
			}
		}

		$s_hidden_fields = '<input type="hidden" name="redirect" value="' . $forward_page . '" />';
		$s_hidden_fields .= (isset($HTTP_GET_VARS['admin'])) ? '<input type="hidden" name="admin" value="1" />' : '';

		make_jumpbox('viewforum.'.$phpEx);
		$template->assign_vars(array(
			'USERNAME' => $username,

			'L_ENTER_PASSWORD' => (isset($HTTP_GET_VARS['admin'])) ? $lang['Admin_reauthenticate'] : $lang['Enter_password'],
			'L_SEND_PASSWORD' => $lang['Forgotten_password'],

			'U_SEND_PASSWORD' => append_sid("profile.$phpEx?mode=sendpassword"),

			'S_HIDDEN_FIELDS' => $s_hidden_fields)
		);

		$template->pparse('body');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
	else
	{
		redirect(append_sid("index.$phpEx", true));
	}

}

?>