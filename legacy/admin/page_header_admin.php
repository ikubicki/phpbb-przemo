<?php
/***************************************************************************
 *                           page_header_admin.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/11/11 15:15
 *
 *   $Id: page_header_admin.php,v 1.12.2.6 2005/03/26 14:15:59 acydburn Exp $
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

define('HEADER_INC', true);
define('ADMIN_TPL', true);

if ( $board_config['clog'] )
{
	@$fp = fopen("admin_logs.$phpEx", 'a');

	if ( isset($_SERVER['REQUEST_URI']) )
	{
		$addr_info = str_replace(array($board_config['script_path'], $board_config['server_name']), '', $_SERVER['REQUEST_URI']);
		$addr_info = xhtmlspecialchars($addr_info);
	}
	else
	{
		$addr_info = 'Serwer nie ustala zmiennej: \$_SERVER[\'REQUEST_URI\']';
	}

    if ($board_config['clog'] == 2 && !empty($_POST)) 
    { 
        $post_data = '<br><pre>$_POST =&gt; ' . xhtmlspecialchars(stripslashes(print_r($_POST, true))) . '</pre>'; 
    }

	$net_ip = (!$client_ip) ? ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR') ) : $client_ip;

	@fwrite($fp, "\n\r- " . date('d/m H:i:s') . ' ' . $userdata['username'] . ' "' . $net_ip . ((isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? ' local: ' . $_SERVER['HTTP_X_FORWARDED_FOR'] : '') . '" "' . $addr_info . '"' . $post_data . '<br>');
	@fclose($fp);
}

$template->set_filenames(array(
	'header' => 'admin/page_header.tpl')
);

if(empty($lang['tz'])) {
	
	$userlang = isset($userdata['user_lang']) ? $userdata['user_lang'] : $board_config['default_lang'];
	require($phpbb_root_path . 'language/lang_' . $userlang . '/lang_profile.' . $phpEx);
}

$l_timezone = $lang['tz'][(string) round($board_config['board_timezone'], 1)];

//
// The following assigns all _common_ variables that may be used at any point
// in a template. Note that all URL's should be wrapped in append_sid, as
// should all S_x_ACTIONS for forms.
//
$template->assign_vars(array(
	'SITENAME' => $board_config['sitename'],
	'PAGE_TITLE' => $page_title,

	'L_ADMIN' => $lang['Admin'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'L_FAQ' => $lang['FAQ'],

	'UNIQUE_COOKIE_NAME' => $unique_cookie_name . $userdata['user_id'],
	'COOKIE_PATH' => $board_config['cookie_path'],
	'COOKIE_DOMAIN' => $board_config['server_name'],
	'COOKIE_SECURE' => $board_config['cookie_secure'],

	'U_INDEX' => append_sid('../index.'.$phpEx),
	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => append_sid('../login.'.$phpEx),
	'S_JUMPBOX_ACTION' => append_sid('../viewforum.'.$phpEx),
	'S_CURRENT_TIME' => sprintf($lang['Current_time'], create_date($board_config['default_dateformat'], CR_TIME, $board_config['board_timezone'], true)),
	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],

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
	'T_TR_COLOR_HELPED' => '#'.$theme['tr_color_helped'],
	'T_ACTIVE_COLOR' => '#'.$theme['factive_color'],
	'T_ONMOUSE_COLOR' => '#'.$theme['faonmouse_color'],
	'T_ONMOUSE2_COLOR' => '#'.$theme['faonmouse2_color'],
	'SPACER' => './../' . $images['spacer'])
);

$template->pparse('header');

?>