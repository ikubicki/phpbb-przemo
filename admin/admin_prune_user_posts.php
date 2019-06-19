<?php
/***************************************************************************
 *                        admin_prune_user_posts.php
 *                        -------------------
 *   begin                : Sunday, Jul 14, 2002
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification		  : (C) 2003 Przemo http://www.przemo.org
 *   date modification	  : ver. 1.9 2004/05/30 21:50
 *
 *   $Id:
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
define('MODULE_ID', 21);
define('IN_PHPBB', 1);

$phpbb_root_path = "../";
require($phpbb_root_path . 'extension.inc');
if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Users']['Prune_User_Posts'] = $filename;
	return;
}

require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_prune_users.'.$phpEx);
include($phpbb_root_path . 'includes/functions_remove.'.$phpEx);

$page_title = $lang['Page_title'];

//
// If button is pushed
//
if( isset($HTTP_POST_VARS['doprune']) )
{
	// Cut really bulshit original function

	$delete_count = 0;

	$sql = "SELECT user_id FROM " . USERS_TABLE . "
		WHERE username = '" . str_replace("\'", "''", $HTTP_POST_VARS['username']) . "'";

	if ( !($result = $db->sql_query($sql)) )
	{
	 	message_die(GENERAL_ERROR, 'Could not get user data', '', __LINE__, __FILE__, $sql);
	}
	$fetch_data = $db->sql_fetchrow($result);

	$user_id = $fetch_data['user_id'];

	if ( !$user_id )
	{
		message_die(GENERAL_MESSAGE, '<b>' . $user_id . '</b> ' . $lang['No_user_id_specified']);
	}
	else if ( $HTTP_POST_VARS['forum_id'] == 'all' )
	{
	 	$sql = "SELECT post_id
				FROM " . POSTS_TABLE . "
				WHERE poster_id = " . $user_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select posts from posts table' , '', __LINE__, __FILE__, $sql);
		}

		while( $post_data = $db->sql_fetchrow($result) )
		{
		 	delete_post($post_data['post_id']);
			$delete_count++;
		}
	}
	else
	{
	 	$sql = "SELECT post_id,topic_id
				FROM " . POSTS_TABLE . "
				WHERE poster_id = $user_id
					AND forum_id = " . intval($HTTP_POST_VARS['forum_id']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select posts from posts table', '', __LINE__, __FILE__, $sql);
		}

		while( $post_data = $db->sql_fetchrow($result) )
		{
		 	delete_post($post_data['post_id']);
			$delete_count++;
		}
	}

	if( $delete_count < 1 )
	{
		$l_delete_text = $lang['Prune_result_n'];
	}
	else if ( $delete_count == 1 )
	{
		$l_delete_text = $lang['Prune_result_s'];
	}
	else if ( $delete_count >= 2 )
	{
		$l_delete_text = $lang['Prune_result_p'];
	}

	$message = sprintf($l_delete_text, $delete_count);
	message_die(GENERAL_MESSAGE, $message);
}
else
{
	$template->assign_vars(array(
		'L_PRUNE_TITLE' => $lang['Page_title'],
		'L_PRUNE_DESC' => $lang['Page_desc'],
		'L_USER_NAME' => $lang['Username'],
		'L_FORUM_NAME' => $lang['Forum'],
		'L_BUTTON' => $lang['Remove'],
		'L_FIND_USERNAME' => $lang['Find_username'],
		'L_RESET' => $lang['Reset'],
		'L_ALL_FORUMS' => $lang['All_forums'],

		'U_SEARCH_USER' => append_sid("./../search.$phpEx?mode=searchuser"),

		'S_PRUNE_ACTION' => append_sid("admin_prune_user_posts.$phpEx"))
	);

	$sql = "SELECT forum_id, forum_name
		FROM " . FORUMS_TABLE . "
		ORDER BY forum_name";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not select users from users table', '', __LINE__, __FILE__, $sql);
	}

	$result_rows = $db->sql_fetchrowset($result);
	$result_count = $db->sql_numrows($result);

	for($i = 0; $i < $result_count; $i++)
	{
		$template->assign_block_vars("forums", array(
			"FORUM_ID" => $result_rows[$i]['forum_id'],
			"FORUM_NAME" => $result_rows[$i]['forum_name'])
		);
	}

	$template->set_filenames(array(
		"body" => "admin/admin_prune_users_body.tpl")
	);
}

$template->pparse("body");

include('page_footer_admin.'.$phpEx);

?>