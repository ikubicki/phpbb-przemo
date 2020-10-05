<?php
/***************************************************************************
 *                      ignore.php
 *                      -------------------
 *   begin              : June 15, 2002
 *   copyright          : (C) 2001 Romar Armas and The phpBB Group
 *   email              : gunnerx@gunnerx.net
 *   modification       : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification	: ver. 1.12.0 2005/10/10 2:27
 *
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

/*
 * Ignore Users Panel
 *
 * This Panel is used to list users being ignore and add/delete users.
 */

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_IGNORE);
init_userprefs($userdata);
//
// End session management
//

$html_entities_match = array('#&#', '#<#', '#>#');
$html_entities_replace = array('&amp;', '&lt;', '&gt;');

$submit_search = ( isset($HTTP_POST_VARS['usersubmit']) ) ? TRUE : 0;

$refresh = $submit_search;

if ( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=ignore.$phpEx", true));
}

if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}

if ( $mode == 'add' )
{
	if (isset($HTTP_POST_VARS['username']))
	{
		$ignore_username = trim(strip_tags(xhtmlspecialchars(str_replace("\'", "''", $HTTP_POST_VARS['username']))));
		$sql = "SELECT user_id
				FROM " . USERS_TABLE ."
				WHERE username = '$ignore_username'";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not get user id from users table', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$ignore_user_id = $row['user_id'];

	}
	else
	{
		$ignore_user_id = intval($HTTP_GET_VARS['ignore_id']);
		if ( !check_sid($HTTP_GET_VARS['sid']) )
		{
			message_die(GENERAL_ERROR, 'Invalid_session');
		}
	}
	
	$ignore_topic = ( isset($HTTP_POST_VARS['topic']) ) ? intval($HTTP_POST_VARS['topic']) : intval($HTTP_GET_VARS['topic']);
}

$user_id = $userdata['user_id'];

if ( $ignore_topic == '' ) 
{
	$meta = '<meta http-equiv="refresh" content="4;url=' . append_sid("ignore.$phpEx") . '">';
}
else
{
	$meta = '<meta http-equiv="refresh" content="4;url=' . append_sid("viewtopic.$phpEx?t=$ignore_topic") . '">';
}

switch( $mode )
{
	case 'delete':
		//
		// Delete User from ignore table
		//
		$sql = "DELETE 
			FROM " . IGNORE_TABLE . " 
			WHERE user_ignore = " . intval($HTTP_GET_VARS['ignore_id']) . "
				AND user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user from ignore table', '', __LINE__, __FILE__, $sql);
		}
		
		if ( $ignore_topic == '' )
		{
			$message = $lang['Ignore_deleted'] . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
		}
		else
		{
			$message = $lang['Ignore_deleted'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?t=$ignore_topic") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
		}

		$template->assign_vars(array(
				'META' => $meta)
		);
		message_die(GENERAL_MESSAGE, $message);

		break;

	case 'add':
		//
		// Delete User from ignore table
		//
		if ( $ignore_user_id != $user_id )
		{

			$sql = "SELECT user_id
				FROM " . IGNORE_TABLE ."
				WHERE user_ignore = '$ignore_user_id'
				AND user_id = '$user_id'";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not get user id from ignore table', '', __LINE__, __FILE__, $sql);
			}
			$numrows = $db->sql_numrows($result);

			if ( $numrows == 0 )
			{
                $sql = "SELECT user_id FROM " . USERS_TABLE ." WHERE user_id = '$ignore_user_id' AND user_id <> " . ANONYMOUS . "";
                if ( !$result = $db->sql_query($sql) )
                {
                    message_die(GENERAL_ERROR, 'Could not get ignored user id from users table', '', __LINE__, __FILE__, $sql);
                }
                if($db->sql_numrows($result) < 1)
                {
                    if( $ignore_topic == '' ){
                        $message = $lang['No_user_id_specified'] . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
                    }else{
                        $message = $lang['No_user_id_specified'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?t=$ignore_topic") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
                    }
                    message_die(GENERAL_MESSAGE, $message);
                }
				
				$sql = "INSERT INTO " . IGNORE_TABLE . " (user_id, user_ignore) 
					VALUES ('$user_id', '$ignore_user_id')";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not add user $ignore_user ($ignore_id) to ignore table', '', __LINE__, __FILE__, $sql);
				}

				if ( $ignore_topic == '' )
				{
					$message = $lang['Ignore_added'] . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
				}
				else
				{
					$message = $lang['Ignore_added'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?t=$ignore_topic") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
				}
			}
			else
			{
				if ( $ignore_topic == '' )
				{
					$message = $lang['Ignore_exists'] . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
				}
				else
				{
					$message = $lang['Ignore_exists'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?t=$ignore_topic") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
				}
			}
		}
		else
		{

			if ( $ignore_topic == '' )
			{
				$message = $lang['Ignore_user_warn'] . '<br /><br />' . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
			}
			else
			{
				$message = $lang['Ignore_user_warn'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?t=$ignore_topic") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_ignore'], '<a href="' . append_sid("ignore.$phpEx") . '">', '</a>');
			}
		}


		$template->assign_vars(array(
				'META' => $meta)
		);
		message_die(GENERAL_MESSAGE, $message);

	default:
		$page_title = $lang['Ignore_list'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->assign_vars(array(
			'L_IGNORE_LIST' => $lang['Ignore_list'],
			'L_IGNORE_ADD' => $lang['Ignore_add'],
			'L_IGNORE_DELETE' => $lang['Ignore_delete'],
			'L_IGNORED_USERS' => $lang['Ignore_users'],
			'L_SUBMIT' => $lang['Ignore_submit'],
			'L_USERNAME' => $lang['Username'],
			'L_FIND_USERNAME' => $lang['Find_username'],
			'USERNAME' => preg_replace($html_entities_match, $html_entities_replace, $username),
			'S_ACTION' => append_sid("ignore.$phpEx?mode=add"),
			'U_SEARCH_USER' => append_sid("search.$phpEx?mode=searchuser"))

		);

		$template->set_filenames(array(
			'body' => 'ignore_body.tpl')
		);

		//
		// Retrieve list of ignored ids
		//
		$sql = "SELECT i.user_ignore, u.username, u.user_id
			FROM (" . USERS_TABLE . " u, " . IGNORE_TABLE . " i)
			WHERE i.user_id = $user_id
				AND u.user_id = i.user_ignore";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error getting ignore listing', '', __LINE__, __FILE__, $sql);
		}
		$numrows = $db->sql_numrows($result);


		if ( $db->sql_numrows($result) > 0)
		{

			while ( $row = $db->sql_fetchrow($result) )
			{
				$id = $row['user_id'];
				$i_username = ( $id == ANONYMOUS ) ? $lang['Guest'] : $row['username'];

				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
				$temp_url = append_sid("ignore.$phpEx?mode=delete&amp;ignore_id=$id");
				$del_image = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Ignore_delete'] . '" border="0" /></a>';

				$template->assign_block_vars('userrow', array(
					'ROW_COLOR' => '#' . $row_color, 
					'ROW_CLASS' => $row_class, 
					'USERNAME' => $i_username,
					'U_PROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$id"),
					'DELETE_IMAGE' => $del_image)
				);
			}
		}
		else
		{

			$row_color = $theme['td_color1'];
			$row_class = $theme['td_class1'];
			$uprofile = "";
			$del_image = "";
			$template->assign_block_vars('userrow', array(
					'ROW_COLOR' => '#' . $row_color, 
					'ROW_CLASS' => $row_class, 
					'USERNAME' => $i_username,
					'U_PROFILE' => $uprofile,
					'DELETE_IMAGE' => $del_image)
				);
		}

		$template->pparse('body');

		break;
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>