<?php
/***************************************************************************
 *                            usercp_activate.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/11/11 14:51
 *
 *   $Id: usercp_activate.php,v 1.6.2.9 2005/09/14 18:14:30 acydburn Exp $
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

$sql = "SELECT user_active, user_id, username, user_email, user_newpasswd, user_lang, user_actkey 
	FROM " . USERS_TABLE . "
	WHERE user_id = " . intval($HTTP_GET_VARS[POST_USERS_URL]);
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	if ( $row['user_active'] && trim($row['user_actkey']) == '' )
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("index.$phpEx") . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Already_activated']);
	}
	else if ( ((trim($row['user_actkey']) == trim($HTTP_GET_VARS['act_key'])) && (trim($row['user_actkey']) != '')) || $userdata['user_level'] == ADMIN )
	{
		if (intval($board_config['require_activation']) == USER_ACTIVATION_ADMIN && $row['user_newpasswd'] == '')
		{
			if (!$userdata['session_logged_in'])
			{
				redirect(append_sid('login.' . $phpEx . '?redirect=profile.' . $phpEx . '&mode=activate&' . POST_USERS_URL . '=' . $row['user_id'] . '&act_key=' . trim($HTTP_GET_VARS['act_key'])));
			}
			else if ($userdata['user_level'] != ADMIN)
			{
				$not_auth = true;
				if ( $userdata['user_jr'] )
				{
					$sql = "SELECT user_jr_admin FROM " . JR_ADMIN_TABLE . "
						WHERE user_id = " . $userdata['user_id'] . "
						LIMIT 1";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Failed to get data from Jr admins table', '', __LINE__, __FILE__, $sql);
					}
					if ( $row_c = $db->sql_fetchrow($result) )
					{
						$userdata['jr_data'] = explode(',', $row_c['user_jr_admin']);
						if ( @in_array(15, $userdata['jr_data']) )
						{
							$not_auth = false;
						}
					}

				}
				if ( $not_auth )
				{
					message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
				}
			}
		}
		$sql_update_pass = ( $row['user_newpasswd'] != '' ) ? ", user_password = '" . str_replace("\'", "''", $row['user_newpasswd']) . "', user_newpasswd = ''" : '';

		$sql = "UPDATE " . USERS_TABLE . "
			SET user_active = 1, user_actkey = ''" . $sql_update_pass . " 
			WHERE user_id = " . $row['user_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
		}

		if ( intval($board_config['require_activation']) == USER_ACTIVATION_ADMIN && $sql_update_pass == '' )
		{
			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);

			$emailer->from($board_config['email_from']);
			$emailer->replyto($board_config['email_return_path']);

			$emailer->use_template('admin_welcome_activated', $row['user_lang']);
			$emailer->email_address($row['user_email']);
			$emailer->set_subject($lang['Account_activated_subject']);

			$emailer->assign_vars(array(
				'SITENAME' => $board_config['sitename'],
				'USERNAME' => $row['username'],
				'PASSWORD' => $password_confirm,
				'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '')
			);
			$emailer->send();
			$emailer->reset();

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("admin/admin_account.$phpEx?sid=" . $userdata['session_id'] . "") . '">')
			);

			message_die(GENERAL_MESSAGE, $lang['Account_active_admin']);
		}
		else
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("index.$phpEx") . '">')
			);

			$message = ( $sql_update_pass == '' ) ? $lang['Account_active'] : $lang['Password_activated'];
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['Wrong_activation']);
	}
}
else
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

?>