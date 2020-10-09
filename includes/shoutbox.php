<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

$template->assign_vars(array(
	'USER_ID' => $userdata['user_id'],
	'SESSION_ID' => $userdata['session_id'],
	'SHOUTBOX_WIDTH' => $shoutbox_config['shout_width'],
	'SHOUTBOX_HEIGHT' => $shoutbox_config['shout_height'],
	'MAXLENGHT' => $shoutbox_config['text_lenght'],
	'REFRESH_SB' => $shoutbox_config['shout_refresh'] * 1000,

	'L_SEND' => $lang['Submit'],
	'L_CANCEL' => $lang['Cancel'],
	'L_DELETE' => $lang['Delete'],
	'L_GG_MES' => $lang['Message'],
	'L_CONFIRM_DELETE' => $lang['Confirm_delete'],
	'L_ALERT' => $lang['l_alert_sb'],
	'L_REFRESH_SB' => $lang['l_refresh_sb'],
	'L_CANCEL_SB' => $lang['l_cancel_sb'],
	'L_EDIT_SB' => $lang['l_edit_sb'],
	'L_EMOTKI' => $lang['emotki'],
	'L_SHOUTBOX' => 'Shoutbox')
);

$template->set_filenames([
	'shoutbox_module' => __DIR__ . '/../modules/shouts/tpl/shoutbox_body.tpl',
	'shoutbox' => 'shoutbox_body.tpl',
]);

$template->assign_var_from_handle('MODULE_SHOUTBOX', 'shoutbox_module');
$template->assign_var_from_handle('SHOUTBOX_DISPLAY', 'shoutbox');