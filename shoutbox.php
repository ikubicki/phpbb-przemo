<?php
/***************************************************************************
 *					shoutbox.php
 *					------------
 *	 begin				: Friday, May 02, 2004
 *   copyright			: (C) 2004 Przemo
 *   website			: http://www.przemo.org
 *   email				: przemo@przemo.org
 *   modification		: (C) 2010 lui754 <lui754@gmail.com>
 *	 date modification	: Saturday, Feb 20, 2010
 *   version			: 1.12.7
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

if ($shoutbox_config['shoutbox_smilies'])
{
	generate_smilies('inline', PAGE_SHOUTBOX);
	$template->assign_block_vars('smilies_emotki', array());
}

$template->assign_vars(array(
	'USER_ID' => $userdata['user_id'],
	'SESSION_ID' => $userdata['session_id'],
	'SHOUTBOX_WIDTH' => $shoutbox_config['shout_width'],
	'SHOUTBOX_HEIGHT' => $shoutbox_config['shout_height'],
	'MAXLENGHT' => $shoutbox_config['text_lenght'],
	'REFRESH_SB' => $shoutbox_config['shout_refresh'] * 1000,

	'L_SEND' => $lang['Submit'],
	'L_GG_MES' => $lang['Message'],
	'L_ALERT' => $lang['l_alert_sb'],
	'L_REFRESH_SB' => $lang['l_refresh_sb'],
	'L_CANCEL_SB' => $lang['l_cancel_sb'],
	'L_EDIT_SB' => $lang['l_edit_sb'],
	'L_EMOTKI' => $lang['emotki'],
	'L_SHOUTBOX' => 'Shoutbox')
);

$template->set_filenames(array(
	'shoutbox' => 'shoutbox_body.tpl')
);

$template->assign_var_from_handle('SHOUTBOX_DISPLAY', 'shoutbox');
?>