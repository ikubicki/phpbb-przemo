<?php

/***************************************************************************
 *                tellafriend.php
 *                -------------------
 *   begin        : 12, 03, 2004
 *   copyright    : (C) 2004 Przemo www.przemo.org/phpBB2/
 *   email        : przemo@przemo.org
 *   version      : 1.9
 *
 ***************************************************************************/

/***************************************************************************
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);

if (!$userdata['session_logged_in'])
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

$page_title = $lang['s_email_friend'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$topic_id = get_vars('topic_id', 0, 'GET,POST', true);
if(!$topic_id) message_die(GENERAL_MESSAGE, 'No topic_id set');

$sql = "SELECT topic_title, forum_id
	FROM " . TOPICS_TABLE . "
	WHERE topic_id = $topic_id";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not get topic info from topics table', '', __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);

$forum_id = $row['forum_id'];
$topic_title = $row['topic_title'];

$is_auth = array();
$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];
if ( !$is_auth['auth_read'] )
{
	$message = sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);
	message_die(GENERAL_MESSAGE, $message);
}

if ( isset($HTTP_POST_VARS['topic_id']) )
{
	$friendname = trim(get_vars('friendname', '', 'POST'));
	$friendemail = trim(get_vars('friendemail', '', 'POST'));
	$message = trim(get_vars('message', '', 'POST'));
	if ( empty($friendname) || empty($friendemail) )
	{
		message_die(GENERAL_MESSAGE, $lang['not_gg_addresat']);
	}
	if ( empty($message) )
	{
		message_die(GENERAL_MESSAGE, $lang['not_gg_msg']);
	}

	$sql = "SELECT user_emailtime
		FROM " . USERS_TABLE . " 
		WHERE user_id = " . $userdata['user_id'];
	if ( $result = $db->sql_query($sql) )
	{
		$row = $db->sql_fetchrow($result);
		if ( CR_TIME - $row['user_emailtime'] < 600 )
		{
			message_die(GENERAL_MESSAGE, $lang['Flood_email_limit']);
		}
		$sql = "UPDATE " . USERS_TABLE . " 
			SET user_emailtime = " . CR_TIME . " 
			WHERE user_id = " . $userdata['user_id'];
		if ( $result = $db->sql_query($sql) )
		{
			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);

			$emailer->from($userdata['user_email']);
			$emailer->replyto($board_config['email_return_path']);

			$emailer->use_template('tellafrien_send_email', $user_lang);
			$emailer->email_address($friendemail);
			$emailer->set_subject(sprintf($lang['s_email_friend_title'], $friendname, $sitename));

			$emailer->assign_vars(array(
				'FRIENDNAME' => $friendname,
				'SITENAME' => $board_config['sitename'], 
				'BOARD_EMAIL' => $board_config['board_email'], 
				'FROM_USERNAME' => $userdata['username'], 
				'TO_USERNAME' => $username, 
				'MESSAGE' => str_replace('\\"', '"', $message))
			);
			$emailer->send();
			$emailer->reset();

			$message = $lang['Email_sent'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			message_die(GENERAL_ERROR, 'Could not update last email time', '', __LINE__, __FILE__, $sql);
		}
	}
}

if ( isset($HTTP_GET_VARS['topic_id']) )
{
	$template->set_filenames(array(
		'body' => 'tellafriend_body.tpl')
	);

	$sitename = $board_config['sitename'];
 	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name. '/viewtopic.'.$phpEx : '/' . $script_name. '/viewtopic.'.$phpEx;
 
	$template->assign_vars(array(
		'L_TELLFRIEND_TITLE' => $lang['s_email_friend'],
		'SUBMIT_ACTION' => append_sid("tellafriend.$phpEx"),
		'L_TELLFRIEND_NAME' => $lang['s_email_friend_f_name'],
		'L_TELLFRIEND_EMAIL' => $lang['s_email_friend_f_email'],
		'L_TELLFRIEND_MESSAGE' => $lang['Message'],
		'L_TELLFRIEND_SEND' => $lang['Send_email'],
		'TELLFRIEND_MESSAGE' => sprintf($lang['s_email_friend_message'], '"' . $topic_title . '"', 'forum "' . $sitename . '"', $server_protocol . $server_name . $server_port . $script_name . '?' . POST_TOPIC_URL . '=' . $topic_id),
		'TOPIC_ID' => $topic_id)
	);
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>