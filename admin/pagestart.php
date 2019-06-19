<?php
/***************************************************************************
 *                               pagestart.php
 *                            -------------------
 *   begin                : Thursday, Aug 2, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.0 2005/11/11 15:16
 *
 *   $Id: pagestart.php,v 1.1.2.9 2005/06/26 14:39:30 acydburn Exp $
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

if (!defined('IN_PHPBB'))
{
	die("Hacking attempt");
}

define('IN_ADMIN', true);
$auto_lang_enable = true;

include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'admin/admin_config.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ADMIN_PANEL);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'admin/modules_data.'.$phpEx);

$jr_admin = ($userdata['user_level'] != ADMIN && $userdata['user_jr']) ? true : false;

if ( $jr_admin )
{
	$sql = "SELECT user_jr_admin FROM " . JR_ADMIN_TABLE . "
		WHERE user_id = " . $userdata['user_id'] . "
		LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Failed to get data from Jr admins table', '', __LINE__, __FILE__, $sql);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$userdata['jr_data'] = explode(',', $row['user_jr_admin']);
		$access_this_place = false;

		$file = basename($HTTP_SERVER_VARS['REQUEST_URI']);

		if ( preg_match("/^index.$phpEx/", $file) )
		{
			$access_this_place = true;
		}
		else if ( defined('MODULE_ID') && MODULE_ID > 0 && is_array($userdata['jr_data']) && count($userdata['jr_data']) && in_array(MODULE_ID, $userdata['jr_data']) )
		{
			$access_this_place = true;
		}
		if ( !$access_this_place && MODULE_ID !== 'allow' )
		{
			message_die(GENERAL_MESSAGE, $lang['Acces_menu_denied']);
		}
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['Not_admin']);
	}
}
else if ( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_profile.' . $phpEx);
include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_modcp.' . $phpEx);

if( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=admin/index.$phpEx", true));
}

if (!$userdata['session_admin'] && $admin_panel_login)
{
	$admin_url = '';
	if ( $HTTP_SERVER_VARS['REQUEST_URI'] && !(preg_match("/index.$phpEx/", $HTTP_SERVER_VARS['REQUEST_URI'])) )
	{
		$admin_url = preg_replace("#(.*?)/admin_(.*?)(&|\?)sid=(.*)#si", "admin_\\2", $HTTP_SERVER_VARS['REQUEST_URI']);
	}
	redirect(append_sid("login.$phpEx?redirect=admin/" . (($admin_url) ? str_replace('?', '&', $admin_url) : "index.$phpEx") . "&admin=1", true));
}

if ( !check_sid($HTTP_GET_VARS['sid']) )
{
	message_die(GENERAL_MESSAGE, 'Invalid_session');
}

if ( empty($no_page_header) )
{
	// Not including the pageheader can be neccesarry if META tags are
	// needed in the calling script.
	include('./page_header_admin.'.$phpEx);
}

?>