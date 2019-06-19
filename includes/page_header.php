<?php
/***************************************************************************
 *                              page_header.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/10/06 22:16
 *
 *   $Id: page_header.php,v 1.106.2.25 2005/10/30 15:17:14 acydburn Exp $
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
 
 if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

define('HEADER_INC', TRUE);

//
// Parse and show the overall header.
//
$template->set_filenames(array(
	'overall_header' => ( empty($gen_simple_header) ) ? 'overall_header.tpl' : 'simple_header.tpl')
);

//
// Generate logged in/logged out status
//
if ( $userdata['session_logged_in'] )
{
	$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
	$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
}
else
{
	$u_login_logout = 'login.'.$phpEx;
	$l_login_logout = $lang['Login'];
}

//
// Obtain number of new private messages
// if user is logged in
//
if ( ($userdata['session_logged_in']) && (empty($gen_simple_header)) )
{
	if ( $userdata['user_new_privmsg'] )
	{
		$l_message_new = ( $userdata['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
		$l_privmsgs_text = sprintf($l_message_new, $userdata['user_new_privmsg']);

		if ( $userdata['user_last_privmsg'] > $userdata['user_lastvisit'] )
		{
			$sql = "UPDATE " . USERS_TABLE . "
				SET user_last_privmsg = " . $userdata['user_lastvisit'] . "
				WHERE user_id = " . $userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{	
				message_die(GENERAL_ERROR, 'Could not update private message new/read time for user', '', __LINE__, __FILE__, $sql);
			}

			$s_privmsg_new = 1;
			$icon_pm = $images['pm_new_msg'];
		}
		else
		{
			$s_privmsg_new = 0;
			$icon_pm = $images['pm_new_msg'];
		}
	}
	else
	{
        if ( $userdata['user_unread_privmsg'] )
        {
            $l_message_unread = ( $userdata['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
            $l_privmsgs_text  = sprintf($l_message_unread, $userdata['user_unread_privmsg']);
        }
        else
        {
            $l_privmsgs_text  = $lang['No_new_pm'];
        }

        $s_privmsg_new = 0;
        $icon_pm       = $images['pm_no_new_msg'];

	}
}
else
{
	$icon_pm = $images['pm_no_new_msg'];
	$l_privmsgs_text = $lang['Login_check_pm'];
	$s_privmsg_new = 0;
}

$faq_img = $images['faq'];
$groups_img = $images['groups'];
$login_img = $images['login'];
$memberlist_img = $images['memberlist'];
$message_img = $images['message'];
$logout_img = $images['logout'];

//
// Generate HTML required for Mozilla Navigation bar
//
if (!isset($nav_links))
{
	$nav_links = array();
}

$nav_links_html = '';
$nav_link_proto = '<link rel="%s" href="%s" title="%s" />' . "\n";
while( list($nav_item, $nav_array) = @each($nav_links) )
{
	if ( !empty($nav_array['url']) )
	{
		$nav_links_html .= sprintf($nav_link_proto, $nav_item, $nav_array['url'], $nav_array['title']);
	}
	else
	{
		// We have a nested array, used for items like <link rel='chapter'> that can occur more than once.
		while( list(,$nested_array) = each($nav_array) )
		{
			$nav_links_html .= sprintf($nav_link_proto, $nav_item, $nested_array['url'], $nested_array['title']);
		}
	}
}

$board_msg = ( $board_config['board_msg_enable'] ) ? replace_vars($board_config['board_msg']) : '';

// The following assigns all _common_ variables that may be used at any point
// in a template.

$profile_img = $images['profile'];
$register_img = $images['register'];
$search_img = $images['search'];
$statistics_img = $images['statistics'];
$my_avatar_img = '';
$link_username = '';

if ( $board_config['banners_list'] && $board_config['echange_banner'] > 0 )
{
	$banners_list = explode('[banner]', $board_config['banners_list']);
	$rand = rand(0, (count($banners_list)-1));
	$eb = replace_vars($banners_list[$rand]);

	if ( $board_config['echange_banner'] == '6' )
	{
		$my_avatar_img = $eb;
	}
}

if ( $board_config['cavatar'] && $userdata['page_avatar'] && $board_config['echange_banner'] != '6' )
{
	$user_url = append_sid("profile.$phpEx?mode=viewprofile&amp;u" . "=" . $userdata['user_id']);
	$user_url2 = append_sid("profile.$phpEx?mode=editprofile&amp;sid=".$userdata['session_id']);
	if ( $userdata['user_avatar_type'] && $userdata['user_allowavatar'] )
	{
	    switch( $userdata['user_avatar_type'] )
	    {
			case USER_AVATAR_UPLOAD:
			$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<a href="' . $user_url2 . '"><img src="' . $board_config['avatar_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" /></a>' : '';
			break;
			case USER_AVATAR_REMOTE:
			if ( $board_config['allow_avatar_remote'] )
			{
				if ( ($userdata['user_avatar_height'] && $userdata['user_avatar_height'] > 0) && ($userdata['user_avatar_width'] && $userdata['user_avatar_width'] > 0) )
				{
					$poster_avatar = '<img src="' . $userdata['user_avatar'] . '" height="' . $userdata['user_avatar_height'] . '" width="' . $userdata['user_avatar_width'] . '" alt="" border="0" />';
				}
				else  // No width/height in the user's profile
				{
					$poster_avatar = '<img src="' . $userdata['user_avatar'] . '" alt="" border="0" />';
				}
			}
			else
			{
				$poster_avatar = '';
			}
			break;
			case USER_AVATAR_GALLERY:
				$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<a href="' . $user_url2 . '"><img src="' . $board_config['avatar_gallery_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
	    }
	}

	if ( $userdata['user_avatar_type'] && $userdata['user_allowavatar'] )
	{
		$link_username = ( '<br /><span class="gensmall"><a href="' . $user_url . '">' . $userdata['username'] . '</a></span>' );
		$my_avatar_img = $poster_avatar . $link_username;
	}
}

$sitename = ($board_config['name_color'] != '') ? '<span style="color: #' . $board_config['name_color'] . '">' . $board_config['sitename'] . '</span>' : $board_config['sitename'];

$site_description = ($board_config['desc_color'] != '') ? '<span style="color: #' . $board_config['desc_color'] . '">' . $board_config['site_desc'] . '</span>' : $board_config['site_desc'];

$nav_links_html .= append_sid("index.$phpEx?mode=eloading") . "\n\r";

if(empty($lang['tz'])) {
	
	$userlang = isset($userdata['user_lang']) ? $userdata['user_lang'] : $board_config['default_lang'];
	require($phpbb_root_path . 'language/lang_' . $userlang . '/lang_profile.' . $phpEx);
}

$l_timezone = $lang['tz'][(string) round($board_config['board_timezone'], 1)];

if ( !$board_config['server_name'] )
{
	$forum_warnings = '<b>Warning</b> ! server name is empty! Check in in the Admin Control Panel or set it in the PhpMyAdmin table: prefix_config - server_name row<br />';
}
if ( !$board_config['server_port'] )
{
	$forum_warnings = '<b>Warning</b> ! server port is empty! Check in in the Admin Control Panel or set it in the PhpMyAdmin table: prefix_config - server_port row<br />';
}
if ( !$board_config['cookie_name'] )
{
	$forum_warnings = '<b>Warning</b> ! cookie name is empty! Check in in the Admin Control Panel or set it in the PhpMyAdmin table: prefix_config - cookie_name row<br />';
}
if ( !$board_config['cookie_path'] )
{
	$forum_warnings = '<b>Warning</b> ! cookie path is empty! Check in in the Admin Control Panel or set it in the PhpMyAdmin table: prefix_config - cookie_path row<br />';
}

if ( $board_config['meta_keywords'] != '' && $board_config['meta_description'] != '' )
{
	$meta_desc = '<META NAME="Keywords" content="' . $board_config['meta_keywords'] .'">
  <META NAME="Description" content="' . $board_config['meta_description'] .'">';
}
else if ( $board_config['meta_keywords'] != '' )
{
	$meta_desc = '<META NAME="Keywords" content="' . $board_config['meta_keywords'] .'">';
}
else if ( $board_config['meta_description'] != '' )
{
	$meta_desc = '<META NAME="Description" content="' . $board_config['meta_description'] .'">';
}
else
{
	$meta_desc = '';
}

//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//
$template->assign_vars(array(
	'SITENAME' => replace_encoded($board_config['sitename']),
	'SITENAME_COLOR' => replace_encoded($sitename),
	'SITE_DESCRIPTION' => replace_encoded($site_description),
	'PAGE_TITLE' => $page_title,
    'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
	'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,
	'PRIVMSG_IMG' => $icon_pm,
	'BOARD_MSG' => replace_encoded($board_msg),
	'BOARD_MSG_IMG' => $images['board_msg_img'],
	'FAQ_IMG' => $faq_img,
	'GROUPS_IMG' => $groups_img,
	'LOGIN_IMG' => $login_img,
	'LOGOUT_IMG' => $logout_img,
	'MEMBERLIST_IMG' => $memberlist_img,
	'MESSAGE_IMG' => $message_img,
	'PROFILE_IMG' => $profile_img,
	'REGISTER_IMG' => $register_img,
	'SEARCH_IMG' => $search_img,
	'STATISTICS_IMG' => $statistics_img,
	'LANG' => $userdata['user_lang'],
	'META_DESC' => replace_encoded($meta_desc),
	'PAGE_LOAD_PLEASE_WAIT' => append_sid('<a href="index.'.$phpEx.'?mode=tloading">' . $lang['Page_loading_wait'] . '</a>'),
	'PAGE_LOADING_STOP' => $lang['Page_loading_stop'],
	'FORUM_WARNINGS' => $forum_warnings,
	'ROTATE_BANNER_1' => ($board_config['echange_banner'] == '1') ? $eb : '',
	'ROTATE_BANNER_2' => ($board_config['echange_banner'] == '2') ? $eb : '',
	'ROTATE_BANNER_3' => ($board_config['echange_banner'] == '3') ? $eb : '',
	'ROTATE_BANNER_4' => ($board_config['echange_banner'] == '4') ? $eb : '',
	'ROTATE_BANNER_5' => ($board_config['echange_banner'] == '5') ? $eb : '',
	'ONMOUSE_COLORS' => ($board_config['onmouse'] && $userdata['onmouse']) ? 'onMouseOver="onv(this);" onMouseOut="ont(this);" ' : '',
	'ONMOUSE2_COLORS' => ($board_config['onmouse']) ? 'onMouseOver="onv2(this);" onMouseOut="ont(this);" ' : '',
	'UNIQUE_COOKIE_NAME' => $unique_cookie_name . $userdata['user_id'],
	'COOKIE_PATH' => $board_config['cookie_path'],
	'COOKIE_DOMAIN' => $board_config['server_name'],
	'COOKIE_SECURE' => $board_config['cookie_secure'],

	'L_BOARD_MSG' => $lang['Post_Announcement'],
	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN_LOGOUT' => $l_login_logout,
	'L_LOGIN' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_INDEX' => sprintf($lang['Forum_Index'], replace_encoded($board_config['sitename'])),
	'L_INDEX_LABEL' => $lang['Forum_index'],
	'L_REGISTER' => $lang['Register'],
	'L_PROFILE' => $lang['Profile'],
	'L_SEARCH' => $lang['Search'],
	'L_PRIVATEMSGS' => $lang['Private_Messages'],
	'L_MEMBERLIST' => $lang['Memberlist'],
	'L_FAQ' => $lang['FAQ'],
	'L_USERGROUPS' => $lang['Usergroups'],
	'L_SEARCH_UNANSWERED' => $lang['Search_unanswered'],
	'L_SEARCH_SELF' => $lang['Search_your_posts'],
	'L_RSSUBMIT' => $lang['Submit'],
	'L_STATISTICS' => $lang['Statistics'],
	'L_NO_TEXT_SELECTED' => $lang['QuoteSelelectedEmpty'],
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],
	'L_PAGE_LOAD_PLEASE_WAIT' => $lang['Page_loading_wait'],
	'L_VHIDE' => $lang['Vhide'],

	'U_STAT' => append_sid("statistics.$phpEx"),
	'U_INDEX' => append_sid('index.'.$phpEx),
	'U_REGISTER' => append_sid('profile.'.$phpEx.'?mode=register'),
	'U_PROFILE' => append_sid('profile.'.$phpEx.'?mode=editprofile&amp;sid='.$userdata['session_id']),
	'U_PRIVATEMSGS' => append_sid('privmsg.'.$phpEx.'?folder=inbox'),
	'U_PRIVATEMSGS_POPUP' => append_sid('privmsg.'.$phpEx.'?mode=newpm'),
	'U_SEARCH' => append_sid('search.'.$phpEx),
	'U_MEMBERLIST' => append_sid('memberlist.'.$phpEx),
	'U_FAQ' => append_sid('faq.'.$phpEx),
	'U_LOGIN_LOGOUT' => append_sid($u_login_logout),
	'U_MEMBERSLIST' => append_sid('memberlist.'.$phpEx),
	'U_GROUP_CP' => append_sid('groupcp.'.$phpEx),

	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_TIMEZONE' => $l_timezone,
	'S_LOGIN_ACTION' => append_sid('login.'.$phpEx),

	'T_HEAD_STYLESHEET' => $theme['head_stylesheet'],
	'T_BODY_BACKGROUND' => $theme['body_background'],
	'T_BODY_BGCOLOR' => '#'.$theme['body_bgcolor'],
	'T_BODY_TEXT' => '#'.$theme['body_text'],
	'T_BODY_LINK' => '#'.$theme['body_link'],
	'T_BODY_VLINK' => '#'.$theme['body_vlink'],
	'T_BODY_ALINK' => '#'.$theme['body_alink'],
	'T_BODY_HLINK' => '#'.$theme['body_hlink'],
	'T_TR_COLOR1' => '#'.$theme['tr_color1'],
	'T_TR_COLOR2' => '#'.$theme['tr_color2'],
	'T_TR_COLOR3' => '#'.$theme['tr_color3'],
	'T_TR_CLASS1' => $theme['tr_class1'],
	'T_TR_CLASS2' => $theme['tr_class2'],
	'T_TR_CLASS3' => $theme['tr_class3'],
	'T_TH_COLOR1' => '#'.$theme['th_color1'],
	'T_TH_COLOR2' => '#'.$theme['th_color2'],
	'T_TH_COLOR3' => '#'.$theme['th_color3'],
	'T_ACTIVE_COLOR' => '#'.$theme['factive_color'],
	'T_ONMOUSE_COLOR' => '#'.$theme['faonmouse_color'],
	'T_ONMOUSE2_COLOR' => '#'.$theme['faonmouse2_color'],
	'T_TH_CLASS1' => $theme['th_class1'],
	'T_TH_CLASS2' => $theme['th_class2'],
	'T_TH_CLASS3' => $theme['th_class3'],
	'T_TD_COLOR1' => '#'.$theme['td_color1'],
	'T_TD_COLOR2' => '#'.$theme['td_color2'],
	'T_TD_COLOR3' => '#'.$theme['td_color3'],
	'T_TD_CLASS1' => $theme['td_class1'],
	'T_TD_CLASS2' => $theme['td_class2'],
	'T_TD_CLASS3' => $theme['td_class3'],
	'T_FONTFACE1' => $theme['fontface1'],
	'T_FONTFACE2' => $theme['fontface2'],
	'T_FONTFACE3' => $theme['fontface3'],
	'T_FONTSIZE1' => $theme['fontsize1'],
	'T_FONTSIZE2' => $theme['fontsize2'],
	'T_FONTSIZE3' => $theme['fontsize3'],
	'T_FONTCOLOR1' => '#'.$theme['fontcolor1'],
	'T_FONTCOLOR2' => '#'.$theme['fontcolor2'],
	'T_FONTCOLOR3' => '#'.$theme['fontcolor3'],
	'T_SPAN_CLASS1' => $theme['span_class1'],
	'T_SPAN_CLASS2' => $theme['span_class2'],
	'T_SPAN_CLASS3' => $theme['span_class3'],

	'NAV_LINKS' => $nav_links_html)
);

if ( $board_config['disable_type'] == 1 && $userdata['user_level'] == ADMIN )
{
	$template->assign_vars(array('SITENAME' => strip_tags($board_config['board_disable'])));
}

if ( $board_config['cload'] && $userdata['cload'] )
{
	$template->assign_block_vars('body_with_loading', array());
}
else
{
	$template->assign_block_vars('body_without_loading', array());
}

if ( $board_config['overlib'] && $userdata['overlib'] )
{
	$template->assign_block_vars('overlib', array());
}
if ( $board_config['width_forum'] )
{
	$template->assign_block_vars('forum_thin', array(
		'WIDTH_COLOR_1' => $board_config['width_color1'],
		'WIDTH_COLOR_2' => $board_config['width_color2'],
		'TABLE_BORDER' => $board_config['table_border'],
		'WIDTH_TABLE' => $board_config['width_table'],));
}

$advert_hide = ( (($board_config['view_ad_by'] == 1 && $userdata['session_logged_in']) || ($board_config['view_ad_by'] == 2 && ($userdata['user_level'] > 0 || $userdata['user_jr']))) && $userdata['advertising'] ) ? true : false;

if ( !$advert_hide )
{
	$advertising_body = $advertising_body_foot = '';

	$advertising = sql_cache('check', 'advertising');
	if (!isset($advertising))
	{
		$advertising = array();
		$sql = "SELECT id, html, email, position, expire, notify, type
			FROM " . ADV_TABLE . "
			WHERE position <> 0
			ORDER by porder";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get entries list', '', __LINE__, __FILE__, $sql); 
		}
		while( $row = $db->sql_fetchrow($result) )
		{
			$advertising[] = $row;
		}
		sql_cache('write', 'advertising', $advertising);
	}

	$count_advertising = count($advertising);

	if ( $count_advertising )
	{
		$email_list = $notify_list = array();

		for($i = 0; $i < $count_advertising; $i++)
		{
			if ( $advertising[$i]['position'] && ($advertising[$i]['expire'] > CR_TIME || !$advertising[$i]['expire']) )
			{
				$html = $advertising[$i]['html'];
				if ( $advertising[$i]['type'] == 1 )
				{
					$html = preg_replace("#<a(.*?)href=\"(.*?)\"([^>]*?)>(.*?)</a>#si", '<a href="ad.php?id=' . $advertising[$i]['id'] . '" \\1 \\3>\\4</a>', $html);
				}

				$adv_separator = ($advertising[$i]['position'] == 2) ? $board_config['advert_separator_l'] : $board_config['advert_separator'];
				if ( $advertising[$i]['position'] == 2 )
				{
					$advertising_body .= (($advertising_body) ? $adv_separator : '') . $html;
				}
				else
				{
					$advertising_body_foot .= (($advertising_body_foot) ? $adv_separator : '') . $html;
				}
			}
			if ( $advertising[$i]['email'] && !$advertising[$i]['notify'] && $advertising[$i]['expire'] && (($advertising[$i]['expire'] - CR_TIME) / 86400) <= 7 )
			{
				$email_list[] = $advertising[$i]['email'];
				$notify_list[] = $advertising[$i]['id'];
			}
		}

		if ( count($email_list) )
		{
			$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
			$server_name = trim($board_config['server_name']);
			$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
			$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

			$server_url = $server_protocol . $server_name . $server_port;

			include($phpbb_root_path . 'includes/emailer.'.$phpEx);

			$notified_ids = '';
			for($i = 0; $i < count($email_list); $i++)
			{
				$notified_ids .= ($notified_ids) ? ', ' . $notify_list[$i] : $notify_list[$i];
				$emailer = new emailer($board_config['smtp_delivery']);

				$emailer->from($board_config['email_from']);
				$emailer->replyto($board_config['email_from']);

				$emailer->use_template('advert', $board_config['real_default_lang']);
				$emailer->set_subject(sprintf($lang['email_title'], $board_config['sitename']));

				$emailer->assign_vars(array(
					'SITENAME' => $board_config['sitename'],
					'U_URL' => $server_url)
				);

				$emailer->email_address($email_list[$i]);
				$emailer->send();
				$emailer->reset();
			}

			if ( $notified_ids )
			{
				$sql = "UPDATE " . ADV_TABLE . "
					SET notify = 1
					WHERE id IN($notified_ids)";
				if ( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Could not update advertising table.", "", __LINE__, __FILE__, $sql);
				}
				sql_cache('clear', 'advertising');
			}
		}

		if ( $advertising_body_foot )
		{
			$board_config['banner_bottom_enable'] = true;
			$board_config['banner_bottom'] = (($board_config['banner_bottom']) ? '<br />' : '') . $board_config['banner_bottom'] . replace_vars($advertising_body_foot);
		}
		if ( $advertising_body )
		{
			$template->assign_block_vars('advert', array(
				'ADVERT_WIDTH' => $board_config['advert_width'],
				'ADVERT' => replace_vars($board_config['advert'] . $advertising_body . $board_config['advert_foot']))
			);
			if ( $board_config['width_forum'] )
			{
				$template->assign_block_vars('advert.advert_forum_thin', array());
			}
		}
	}
}

if ( $board_config['clog'] )
{
	@$fp = fopen("admin/admin_logs.$phpEx", 'a');

	if ( isset($_SERVER['REQUEST_URI']) )
	{
		$addr_info = str_replace(array($board_config['script_path'], $board_config['server_name']), '', $_SERVER['REQUEST_URI']);
		$addr_info = xhtmlspecialchars($addr_info);
	}
	else
	{
		if ( !$forum_id == '' )
		{
			$addr_info = ' Forum ID: ' . $forum_id;
		}
		if ( !$topic_id == '' )
		{
			$addr_info = ' Topic ID: ' . $topic_id;
		}
	}
	$addr_info = ($addr_info) ? $addr_info : 'index.php';
	$post_log_data = $cookie_log_data = '';

	if ( $board_config['clog'] == 2 )
	{
		if ( count($_POST) > 0 )
		{
			$no_log_key = array('submit', 'reset', 'subject', 'subject2', 'message', 'helpbox', 'tresc');
			while( list($key, $val) = @each($_POST) )
			{
				if ( $val != '' && !in_array($key, $no_log_key) && !preg_match('/addbbcode/i', $key)  )
				{
					if ( $key == 'password' || $key == 'new_password' || $key == 'password_confirm' )
					{
						$val = 'md5';
					}
					$post_log_data .= $key . '=' . xhtmlspecialchars(stripslashes($val)) . ' | ';
				}
			}
			$post_log_data = ($post_log_data) ? ' _POST[]: <i>' . $post_log_data . '</i>' : '';
		}
		if ( count($_COOKIE) > 0 )
		{
			while( list($key, $val) = @each($_COOKIE) )
			{
				$cookie_log_data .= xhtmlspecialchars(stripslashes($val)) . ' | ';
			}
			$cookie_log_data = ($cookie_log_data) ? ' _COOKIE[]: <i>' . $cookie_log_data . '</i>' : '';
		}
	}

	$net_ip = (!$client_ip) ? ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR') ) : $client_ip;

	@fwrite($fp, "\n\r- " . date('d/m H:i:s') . ' ' . $userdata['username'] . ' "' . $net_ip . ((isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? ' local: ' . $_SERVER['HTTP_X_FORWARDED_FOR'] : '') . '" "' . $addr_info . '"' . $post_log_data . $cookie_log_data . '<br>');
	@fclose($fp);
}

$logged_in_out_block = ($userdata['session_logged_in']) ? 'switch_user_logged_in' : 'switch_user_logged_out';

$template->assign_block_vars($logged_in_out_block, array());

// Setup header and userdata logged in/out
if ( !$userdata['session_logged_in'] )
{
	//
	// Allow autologin?
	//
	if (!isset($board_config['allow_autologin']) || $board_config['allow_autologin'] )
	{
		$template->assign_block_vars('switch_allow_autologin', array());
		$template->assign_block_vars($logged_in_out_block . '.switch_allow_autologin', array());
	}
}
else
{
	if ( !empty($userdata['user_popup_pm']) )
	{
		$template->assign_block_vars('switch_enable_pm_popup', array());
	}
}

if ( $board_config['cload'] && $userdata['cload'] )
{
	$template->assign_block_vars('loading_header', array());
}

if ( $board_config['cquick'] )
{
	$template->assign_block_vars('quick_quote', array());
}

if ( $board_config['header_enable'] )
{
	$header_block = '';
}
else if ( !$userdata['simple_head'] )
{
	$template->assign_block_vars('header', array());
	$template->assign_block_vars('header.' . $logged_in_out_block, array());
	$header_block = 'header.';
	
	if (!$board_config['report_disable'])
	{
		if ( ( $board_config['report_only_admin'] ? $userdata['user_level'] == ADMIN : $userdata['user_level'] > USER ) )
		{
			$template->assign_block_vars('header.switch_report_list', array(
				'U_REPORT_LIST' => append_sid('report.'.$phpEx),
				'L_REPORT_LIST' => $lang['Report_list']
			));

			if ( !isset($no_report_popup) && !$userdata['no_report_popup'] && $userdata['refresh_report_popup'] )
			{
				if ( $userdata['refresh_report_popup'] != 2 && !isset($rp) )
				{
					include($phpbb_root_path . 'includes/reportpost.'.$phpEx);
				}
				if ( $userdata['refresh_report_popup'] == 2 || $rp->check_report_popup($userdata) )
				{
					$template->assign_block_vars("switch_report_popup", array(
						'U_REPORT_POPUP' => append_sid('report.'.$phpEx.'?mode=popup'),
						'S_WIDTH' => $board_config['report_popup_width'],
						'S_HEIGHT' => $board_config['report_popup_height'])
					);
				}
			}
		}
	}

	if ( $my_avatar_img )
	{
		$template->assign_block_vars('header.switch_page_avatar', array());
		$template->assign_vars(array(
			'MY_AVATAR_IMG' => $my_avatar_img,
			'USERNAME' => $link_username)
		);
	}
}

if ( $userdata['simple_head'] )
{
	$template->assign_block_vars('simple_header', array());
	$template->assign_block_vars('simple_header.' . $logged_in_out_block, array());
	$header_block = 'simple_header.';
	$board_config['echange_banner'] = '';
}

if ($board_config['cstat']) $template->assign_block_vars($header_block . $logged_in_out_block . '.statistics', array());

if ( $board_config['board_msg_enable'] == '2' )
{
	$template->assign_block_vars('switch_enable_board_msg', array()); 
}

// get the nav sentence
$nav_key = '';
if (isset($HTTP_POST_VARS[POST_CAT_URL]) || isset($HTTP_GET_VARS[POST_CAT_URL]))
{
	$nav_key = POST_CAT_URL . ((isset($HTTP_POST_VARS[POST_CAT_URL])) ? intval($HTTP_POST_VARS[POST_CAT_URL]) : intval($HTTP_GET_VARS[POST_CAT_URL]));
}
if (isset($HTTP_POST_VARS[POST_FORUM_URL]) || isset($HTTP_GET_VARS[POST_FORUM_URL]))
{
	$nav_key = POST_FORUM_URL . ((isset($HTTP_POST_VARS[POST_FORUM_URL])) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : intval($HTTP_GET_VARS[POST_FORUM_URL]));
}
if (isset($HTTP_POST_VARS[POST_TOPIC_URL]) || isset($HTTP_GET_VARS[POST_TOPIC_URL]))
{
	$nav_key = POST_TOPIC_URL . ((isset($HTTP_POST_VARS[POST_TOPIC_URL])) ? intval($HTTP_POST_VARS[POST_TOPIC_URL]) : intval($HTTP_GET_VARS[POST_TOPIC_URL]));
}
if (isset($HTTP_POST_VARS[POST_POST_URL]) || isset($HTTP_GET_VARS[POST_POST_URL]))
{
	$nav_key = POST_POST_URL . ((isset($HTTP_POST_VARS[POST_POST_URL])) ? intval($HTTP_POST_VARS[POST_POST_URL]) : intval($HTTP_GET_VARS[POST_POST_URL]));
}
if ( empty($nav_key) && (isset($HTTP_POST_VARS['selected_id']) || isset($HTTP_GET_VARS['selected_id'])) )
{
	$nav_key = isset($HTTP_GET_VARS['selected_id']) ? $HTTP_GET_VARS['selected_id'] : $HTTP_POST_VARS['selected_id'];
}
if ( empty($nav_key) )
{
	$nav_key = 'Root';
}
$nav_cat_desc = make_cat_nav_tree($nav_key, $nav_pgm);

if ($nav_cat_desc != '')
{
	$nav_cat_desc = $nav_separator . $nav_cat_desc;
}

// send to template
$template->assign_vars(array(
	'STYLE_NAME' => $theme['template_name'],
	'SPACER' => $images['spacer'],
	'NAV_SEPARATOR' => $nav_separator,
	'NAV_CAT_DESC' => $nav_cat_desc,
	)
);

$banner_top = ($board_config['banner_top_enable']) ? $board_config['banner_top'] : '';
$template->assign_vars(array('BANNER_TOP' => replace_vars($banner_top)));

// Add no-cache control for cookies if they are set
//$c_no_cache = (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) || isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_data'])) ? 'no-cache="set-cookie", ' : '';

// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting
if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
{
	@header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	@header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
@header ('Expires: 0');
@header ('Pragma: no-cache');

$template->pparse('overall_header');

?>