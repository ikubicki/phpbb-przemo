<?php

/***************************************************************************
 *                 quick_reply.php
 *                 -------------------
 *  begin          : 11, 09, 2003
 *  copyright      : (C) 2005 Przemo www.przemo.org/phpBB2/
 *  email          : przemo@przemo.org
 *  version        : ver. 1.12.4 2005/12/14 23:24
 *  note           : Quote selected get from QR by RustyDragon and Smartor
 *
 ***************************************************************************/

/***************************************************************************
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 ***************************************************************************/

// BEGIN OUTPUT
$phpbb_root_path = './';

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt1');
}

$template->set_filenames(array(
	'quick_reply_output' => 'quick_reply.tpl')
);

$lock = (isset($HTTP_POST_VARS['lock'])) ? true : false;
$unlock = (isset($HTTP_POST_VARS['unlock'])) ? true : false;

$template->assign_block_vars('quick_reply', array(
	'POST_ACTION' => append_sid("posting.$phpEx"),
	'TOPIC_ID' => $topic_id)
);

if ( $userdata['session_logged_in'] )
{
	$template->assign_block_vars('quick_reply.user_logged_in', array(
		'ATTACH_SIGNATURE' => ($userdata['user_attachsig']) ? ' checked="checked"' : '',
		'NOTIFY_ON_REPLY' => ($notify_user || $userdata['user_notify']) ? ' checked="checked"' : '')
	);
}
else
{
	$template->assign_block_vars('quick_reply.user_logged_out', array());
}

if ( $board_config['allow_smilies'] && $userdata['show_smiles'] && $board_config['max_smilies'] )
{
	generate_smilies('quickreply', 0);
	$template->assign_block_vars('quick_reply.smilies', array());
}

if ( $is_auth['auth_mod'] )
{
	if ( $forum_topic_data['topic_status'] == TOPIC_LOCKED )
	{
		$template->assign_block_vars('quick_reply.switch_unlock_topic', array());
		$template->assign_vars(array(
			'L_UNLOCK_TOPIC' => $lang['Unlock_topic'])
		);
	}
	else
	{
		$template->assign_block_vars('quick_reply.switch_lock_topic', array());
		$template->assign_vars(array(
			'L_LOCK_TOPIC' => $lang['Lock_topic'])
		);
	}
}
if ( $board_config['expire'] )
{
	$template->assign_block_vars('quick_reply.expire_box', array());
	$template->assign_vars(array(
		'L_EXPIRE_Q' => $lang['post_expire_q'],
		'EXPIRE_2_SELECTED' => ($board_config['expire_value']) ? ' selected="selected"' : '',
		'L_DAYS' => $lang['Days'])
	);
}

if ( $board_config['split_messages'] )
{
	$show_nosplit = false;
	if ( $userdata['user_level'] == ADMIN || $userdata['user_jr'] )
	{
		$show_nosplit = ($board_config['split_messages_admin']) ? true : false;
	}
	else if ( $is_auth['auth_mod'] )
	{
		$show_nosplit = ($board_config['split_messages_mod']) ? true : false;
	}
	$show_nosplit = ( $forum_topic_data['forum_no_split'] || !$show_nosplit ) ? false : true;

	if ( $show_nosplit == true )
	{
		$template->assign_block_vars('quick_reply.switch_no_split_post', array());
		
		$template->assign_vars(array(
			'L_NO_SPLIT_POST' => $lang['No_split_post'])
		);
	}
}

if (!( !$board_config['allow_bbcode'] || (!$userdata['session_logged_in'] && $board_config['allow_bbcode_quest']) ))
{
	if ( $board_config['button_b'] )
	{
		$template->assign_block_vars('quick_reply.button_b', array());
	}
	if ( $board_config['button_i'] )
	{
		$template->assign_block_vars('quick_reply.button_i', array());
	}
	if ( $board_config['button_u'] )
	{
		$template->assign_block_vars('quick_reply.button_u', array());
	}
	if ( $board_config['button_im'] )
	{
		$template->assign_block_vars('quick_reply.button_im', array());
	}
	if ( $board_config['button_c'] )
	{
		$template->assign_block_vars('quick_reply.button_c', array());
	}
	if ( $board_config['button_q'] )
	{
		$template->assign_block_vars('quick_reply.button_q', array());
	}
}

if ( $board_config['allow_bbcode'] == 1 )
{
	$template->assign_block_vars('quick_reply.quote_box', array());
}

$s_hidden_fields = '<input type="hidden" name="przemo_hash" value="' . przemo_create_hash() . '" />';
$template->assign_vars(array(
	'S_HIDDEN_FIELDS' => $s_hidden_fields,
	'U_MORE_SMILIES' => append_sid("posting.$phpEx?mode=smilies"),
	'L_USERNAME' => $lang['Username'],
	'L_PREVIEW' => $lang['Preview'],
	'L_OPTIONS' => $lang['Options'],
	'L_SUBMIT' => $lang['Submit'],
	'L_CANCEL' => $lang['Cancel'],
	'L_ATTACH_SIGNATURE' => $lang['Attach_signature'],
	'L_NOTIFY_ON_REPLY' => $lang['Notify'],
	'L_NOTIFY_ON_REPLY' => $lang['Notify'],
	'L_ATTACH_SIGNATURE' => $lang['Attach_signature'],
	'L_ALL_SMILIES' => $lang['Quick_Reply_smilies'],
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],
	'L_QUICK_REPLY' => $lang['Quick_Reply'],
	'L_QUOTE_SELECTED' => $lang['QuoteSelelected'],
	'L_PREVIEW' => $lang['Preview'],
	'L_SUBMIT' => $lang['Submit'])
);

$template->assign_var_from_handle('QUICKREPLY_OUTPUT', 'quick_reply_output');

?>