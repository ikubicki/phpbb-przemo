<?php
/***************************************************************************
 *                  gg.php
 *                  -------------------
 *   begin          : 29, 12, 2005
 *   copyright      : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   email          : przemo@przemo.org
 *   version        : ver. 1.12.0 2005/12/29 23:27
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

unset($HTTP_GET_VARS['gg']);

require('includes/functions_gg.'.$phpEx);
if ($HTTP_GET_VARS['gg']) read_status($HTTP_GET_VARS['gg']);

$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);

if ( isset($HTTP_GET_VARS[POST_USERS_URL]) || isset($HTTP_POST_VARS[POST_USERS_URL]) )
{
	$user_id = (isset($HTTP_GET_VARS[POST_USERS_URL])) ? intval($HTTP_GET_VARS[POST_USERS_URL]) : intval($HTTP_POST_VARS[POST_USERS_URL]);
}
else
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

$profiledata = get_userdata($user_id);

if (!$profiledata)
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

if ( intval($profiledata['user_aim']) < 1 )
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

if( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=gg.$phpEx&mode=$mode&u=$u", true));
}

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];

	if ( $mode == 'gadu' )
	{
		$template->set_filenames(array(
			'body' => 'gg.tpl')
		);
		make_jumpbox('viewforum.'.$phpEx);

		$page_title = 'Bramka Gadu-gadu';
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$user_aim = intval(trim($profiledata['user_aim']));

		$template->assign_vars(array(
			'AIM_STATUS' => '<img src="http://status.gadu-gadu.pl/users/status.asp?id=' . $user_aim . '&amp;styl=1" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" width="16" height="16" border="0" />',
			'RECIPIENT_ID' => $profiledata['user_id'],
			'GG_NUMBER' => $profiledata['user_aim'],
			'L_GG' => sprintf($lang['GG'], $profiledata['username']),
			'L_STAT_GG' => $lang['STAT_GG'],
			'L_AIM' => $lang['AIM'],
			'L_SUBMIT' => $lang['Submit'], 
			'S_SUBMIT_ACTION' => append_sid("gg.$phpEx"))
		);

		if ( $profiledata['user_viewaim'] )
		{
			$template->assign_block_vars('status', array());
		}

		$template->pparse('body');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}

	if ( $HTTP_POST_VARS['mode'] == 'post' )
	{
		$numer_bramki = intval(trim($board_config['numer_gg']));
		$haslo_bramki = trim($board_config['haslo_gg']);

		$tresc = $HTTP_POST_VARS['tresc'];

		if ( empty($numer_bramki) || empty($haslo_bramki) )
		{
			message_die(GENERAL_ERROR, $lang['not_gg_account']);
		}
		if ( strlen($tresc) < 3 )
		{
			message_die(GENERAL_ERROR, $lang['not_gg_msg']);
		}

		if ( strlen($tresc ) > 1800 )
		{
			message_die(GENERAL_ERROR, $lang['gg_too_long']);
		}

		error_reporting(E_ALL ^ E_NOTICE);

		$tablica_komunikatow = array (
			0x0002 => $lang['GG_send'],
			0x0003 => $lang['GG_wait'],
			0x0004 => $lang['GG_full'],
			0 => $lang['GG_not_send']
		);

		$gg = new www2gg ($numer_bramki, $haslo_bramki);

		$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
		$server_name = trim($board_config['server_name']);
		$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
		$script_name = ($script_name == '') ? $script_name : '/' . $script_name;
		$forum_addr = $server_protocol . $server_name . $server_port . $script_name;

		$separator = "\r\n\r\n_________________\r\nWiadomoœæ wys³ana z forum: [" . $board_config['sitename'] . "]\r\n" . $forum_addr . "/\r\nOd u¿ytkownika: " . $userdata['username'] . (($userdata['user_viewaim']) ? " Numer GG: " . intval(trim($userdata['user_aim'])) : '') . "\r\nNie odpisuj tutaj !";
		$tresc = $tresc.$separator;

		if ($seq = $gg->wiadomosc(intval($profiledata['user_aim']), $tresc)) 
		{
			message_die(GENERAL_MESSAGE, $tablica_komunikatow[$gg->status_dostarczenia ($seq)]);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $gg->error);
		}
	}
}
else
{
	redirect(append_sid("index.$phpEx", true));
}

?>