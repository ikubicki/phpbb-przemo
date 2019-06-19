<?php
/***************************************************************************
 *                   groupcp_mail.php
 *                   -------------------
 *   begin           : 04, 09, 2005
 *   copyright       : (C) 2003 Przemo (http://www.przemo.org)
 *   email           : przemo@przemo.org
 *   version         : ver. 1.12.0 2005/09/04 14:21
 *
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
// End session management

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_mass_email.' . $phpEx);

@set_time_limit(300);

function mass_email($bcc_list, $to, $use_html, $message, $subject, $start)
{
	global $phpbb_root_path, $phpEx, $board_config, $db, $lang, $user_ip, $userdata;

	if ( $start == 0 )
	{
		$sql = "DELETE FROM " . MASS_EMAIL . " WHERE mass_email_user_id = " . $userdata['user_id'];
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Unable to delete from mass email table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "INSERT  INTO " . MASS_EMAIL . " (mass_email_user_id, mass_email_text, mass_email_subject, mass_email_bcc, mass_email_html, mass_email_to)
			VALUES (" . $userdata['user_id'] . ", '" . str_replace("\'", "''", $message) . "', '" . str_replace("\'", "''", $subject) . "', '" . serialize($bcc_list) . "', $use_html, '" . str_replace("\'", "''", $to) . "')";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Unable to insert into mass email table', '', __LINE__, __FILE__, $sql);
		}
	}
	else
	{
		$sql = "SELECT *
			FROM " . MASS_EMAIL . "
			WHERE mass_email_user_id = " . $userdata['user_id'] . "
			LIMIT 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not query data from mass email table');
		}
		$row = $db->sql_fetchrow($result);

		$message = $row['mass_email_text'];
		$subject = $row['mass_email_subject'];
		$bcc_list = unserialize($row['mass_email_bcc']);
		$use_html = $row['mass_email_html'];
		$to = $row['mass_email_to'];
	}

	include($phpbb_root_path . 'includes/emailer.'.$phpEx);

	//
	// Let's do some checking to make sure that mass mail functions
	// are working in win32 versions of php.
	//
	if ( preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
	{
		$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

		// We are running on windows, force delivery to use our smtp functions
		// since php's are broken by default
		$board_config['smtp_delivery'] = 1;
		$board_config['smtp_host'] = @$ini_val('SMTP');
	}

	$emailer = new emailer($board_config['smtp_delivery']);

	$emailer->from($userdata['user_email']);
	$emailer->replyto($userdata['user_email']);

	if ( is_array($bcc_list[$start]) )
	{
		$users_ids = implode(', ', $bcc_list[$start]);

		$sql = "SELECT user_email FROM " . USERS_TABLE . "
		WHERE user_id IN($users_ids)";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select users email', '', __LINE__, __FILE__, $sql);
		}
		if ( $row = $db->sql_fetchrow($result) )
		{
			do
			{
				$emailer->bcc($row['user_email']);
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		$email_headers = 'X-AntiAbuse: Board servername - ' . $board_config['server_name'] . "\n";
		$email_headers .= 'X-AntiAbuse: User_id - ' . $userdata['user_id'] . "\n";
		$email_headers .= 'X-AntiAbuse: Username - ' . $userdata['username'] . "\n";
		$email_headers .= 'X-AntiAbuse: User IP - ' . decode_ip($user_ip) . "\n";

		$emailer->use_template('admin_send_email');
		$emailer->email_address($to);
		$emailer->set_subject(stripslashes($subject));
		$emailer->use_html($use_html);
		$emailer->extra_headers($email_headers);

		$email_message = ($use_html) ? str_replace(array('&plusmn;', '&para;', '¥', '·', '&brvbar;', '&not;'), array('±', '¶', '¼', '¡', '¦', '¬'), stripslashes($message)) : stripslashes($message);

		$emailer->assign_vars(array(
			'SITENAME' => $board_config['sitename'],
			'BOARD_EMAIL' => $board_config['board_email'], 
			'MESSAGE' => $email_message)
		);

		$emailer->send();
		$emailer->reset();

		$addr = append_sid("groupcp_mail.$phpEx?start=" . ($start + 1));
		$message = '<meta http-equiv="refresh" content="3;url=' . $addr . '">' . sprintf($lang['Mass_next_step'], ($start + 1), count($bcc_list)) . '<br /><br /><a href="' . $addr . '">' . $lang['Next'] . '</a>';

		message_die(GENERAL_MESSAGE, $message);
	}
	else
	{
		@unlink($phpbb_root_path . 'files/tmp/preview.html');

		$sql = "DELETE FROM " . MASS_EMAIL . " WHERE mass_email_user_id = " . $userdata['user_id'];
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Unable to delete from mass email table', '', __LINE__, __FILE__, $sql);
		}

		message_die(GENERAL_MESSAGE, $lang['Email_sent']);
	}
}

if ( $HTTP_GET_VARS['start'] )
{
	mass_email('', $userdata['user_email'], '', '', '', intval($HTTP_GET_VARS['start']));
}

$message = '';
$subject = '';

if ( isset($HTTP_GET_VARS[POST_GROUPS_URL]) || isset($HTTP_POST_VARS[POST_GROUPS_URL]) )
{
	$group_id = ( isset($HTTP_POST_VARS[POST_GROUPS_URL]) ) ? intval($HTTP_POST_VARS[POST_GROUPS_URL]) : intval($HTTP_GET_VARS[POST_GROUPS_URL]);
}
else
{
	$group_id = '';
}

if ($group_id)
{
	$sql = "SELECT group_moderator, group_mail_enable
		FROM " . GROUPS_TABLE . "
		WHERE group_id = $group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user and group information', '', __LINE__, __FILE__, $sql);
	}
}
else
{
	redirect(append_sid("index.$phpEx", true));
}
$row = $db->sql_fetchrow($result);

if ( ($row['group_mail_enable'] != 1 || $row['group_moderator'] != $userdata['user_id']) && $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, $lang['Mail_not_authorised']);
}

if ( isset($HTTP_POST_VARS['message']) || isset($HTTP_POST_VARS['subject']) )
{
	$subject = trim($HTTP_POST_VARS['subject']);
	$message = trim($HTTP_POST_VARS['message']);
	$use_html = ($HTTP_POST_VARS['html'] == 1) ? 1 : 0;
	if ( isset($HTTP_POST_VARS['language']) )
	{
		$email_language = $HTTP_POST_VARS['language'];
	}

	$error = FALSE;
	$error_msg = '';

	if ( empty($subject) )
	{
		$error = true;
		$error_msg .= ( !empty($error_msg) ) ? '<br />' . $lang['Empty_subject'] : $lang['Empty_subject'];
	}

	if ( empty($message) )
	{
		$error = true;
		$error_msg .= ( !empty($error_msg) ) ? '<br />' . $lang['Empty_message'] : $lang['Empty_message'];
	}

	$sql_language = ($email_language) ? "AND u.user_lang = '" . str_replace("\'", "''", $email_language) . "'": '';

	$sql = "SELECT u.user_id FROM (" . USERS_TABLE . " u, " . USER_GROUP_TABLE . " ug)
		WHERE ug.group_id = $group_id
			AND ug.user_pending <> " . TRUE . "
			AND u.user_id = ug.user_id $sql_language";
	if ( !isset($HTTP_POST_VARS['send']) )
	{
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select group members', '', __LINE__, __FILE__, $sql);
		}

		if ( !($row = $db->sql_fetchrow($result)) )
		{
			$err_message = $lang['No_user_id_specified'];

			$error = true;
			$error_msg .= ( !empty($error_msg) ) ? '<br />' . $err_message : $err_message;
		}
		$count_users = 0;
		do
		{
			$count_users++;
		}
		while ( $row = $db->sql_fetchrow($result) );

		$count_emails = (ceil($count_users / 85)) + 1;

		$template->assign_block_vars('preview', array());
		if ( $count_emails > 1 )
		{
			$template->assign_block_vars('preview.emails', array(
				'EMAILS' => sprintf($lang['Emails'], $count_users, $count_emails))
			);
		}
		if ( !$use_html )
		{
			$template->assign_block_vars('preview.message', array());
		}
		else
		{
			if ( @is_writable($phpbb_root_path . 'files/tmp/') )
			{
				@unlink($phpbb_root_path . 'files/tmp/preview.html');
				if ( $fp = @fopen($phpbb_root_path . 'files/tmp/preview.html', 'w') )
				{
					$write_message = str_replace(array('&plusmn;', '&para;', '¥', '·', '&brvbar;', '&not;'), array('±', '¶', '¼', '¡', '¦', '¬'), stripslashes($message));
					fwrite($fp, $write_message);
				}
				else
				{
					message_die(GENERAL_ERROR, sprintf($lang['Can_not_touch_preview'], 'files/tmp/preview.html'));
				}
			}
			else
			{
				message_die(GENERAL_ERROR, sprintf($lang['Cache_not_writable'], '/files/tmp/'));
			}
		}
		$template->assign_vars(array(
			'S_PREVIEW_FIELDS' => '<input type="hidden" name="message" value="' . xhtmlspecialchars(stripslashes($message)) . '" /><input type="hidden" name="subject" value="' . xhtmlspecialchars(stripslashes($subject)) . '" /><input type="hidden" name="html" value="' . $use_html . '" /><input type="hidden" name="language" value="' . $email_language . '" /><input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" />')
		);
	}
	else if ( !isset($HTTP_POST_VARS['improve']) )
	{
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select group members', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$bcc_list = array();
			$j = 0;
			$bcc_list[0] = array($row['user_id']);

			for ($i=1;;$i++)
			{
				if ( !( $row = $db->sql_fetchrow($result)) )
				{
					break;
				}
				$bcc_list[$j][] = $row['user_id'];

				if (($i % 85) == 0 )
				{
					$j++;
				}
			}
			$db->sql_freeresult($result);
		}
		else
		{
			$err_message = $lang['No_user_id_specified'];

			message_die(GENERAL_ERROR, $err_message);
		}

		if ( !$error )
		{
			mass_email($bcc_list, $userdata['user_email'], $use_html, $message, $subject, 0);
		}
	}
}
else
{
	$template->assign_block_vars('form', array());
}
if ( isset($HTTP_POST_VARS['improve']) )
{
	$template->assign_block_vars('form', array());
}

if ( $error )
{
	$template->set_filenames(array(
		'reg_header' => 'error_body.tpl')
	);
	$template->assign_vars(array(
		'ERROR_MESSAGE' => $error_msg)
	);
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}

//
// Initial selection
//

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

$template->set_filenames(array(
	'body' => 'groupcp_mail_body.tpl')
);

$selected_language = (isset($email_language)) ? $email_language : '';

$message = ($use_html) ? str_replace(array('&plusmn;', '&para;', '¥', '·', '&brvbar;', '&not;'), array('±', '¶', '¼', '¡', '¦', '¬'), $message) : $message;

$template->assign_vars(array(
	'MESSAGE' => xhtmlspecialchars(stripslashes($message)),
	'MESSAGE_PREVIEW' => str_replace("\n", "<br />", xhtmlspecialchars(stripslashes($message))),
	'SUBJECT' => xhtmlspecialchars(stripslashes($subject)),
	'LANGUAGE_SELECT' => language_select($selected_language, 'language', 'language', array('', $lang['All_users'])),
	'HTML_YES' => ($use_html) ? ' checked="checked"' : '',
	'HTML_NO' => (!$use_html) ? ' checked="checked"' : '',
	'PREVIEW_LANGUAGE' => ($selected_language) ? $selected_language : $lang['All_users'],
	'PREVIEW_HTML' => ($use_html) ? 'html <a href="files/tmp/preview.html" target="_blank">' . $lang['Preview'] . '</a>' : 'text',


	'L_IMPROVE' => $lang['Improve'],
	'L_USERS_LANGUAGE' => $lang['Users_language'],
	'L_USERS_LANGUAGE_E' => $lang['Users_language_e'],
	'L_PLAIN_HTML' => $lang['Email_plain_html'],
	'L_EMAIL_TITLE' => $lang['Email'],
	'L_EMAIL_EXPLAIN' => $lang['Mass_email_explain'],
	'L_COMPOSE' => ((isset($HTTP_POST_VARS['message']) || isset($HTTP_POST_VARS['subject'])) && !isset($HTTP_POST_VARS['improve'])) ? $lang['Preview'] : $lang['Compose'],
	'L_RECIPIENTS' => $lang['Recipients'],
	'L_EMAIL_SUBJECT' => $lang['Subject'],
	'L_EMAIL_MSG' => $lang['Message'],
	'L_EMAIL' => $lang['Preview'],
	'L_SEND' => $lang['Submit'],
	'L_NOTICE' => $notice,

	'S_GROUPCP_ACTION' => append_sid("groupcp_mail.$phpEx?" . POST_GROUPS_URL . "=$group_id"),
	'S_GROUP_SELECT' => $select_list)
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>