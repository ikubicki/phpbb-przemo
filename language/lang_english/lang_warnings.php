<?php
/***************************************************************************
 *				lang_warnings.php [English]
 *				-------------------------
 *	begin			: 13, 09, 2003
 *	copyright		: (C) 2003 Przemo
 *	email			: przemo@przemo.org
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

$lang['how_many_warnings'] = 'Warnings';
$lang['value'] = 'Value';
$lang['add'] = 'Add';
$lang['warnings'] = 'Users reprimand';
if ( $board_config['mod_warnings'] )
{
	if ( $board_config['mod_edit_warnings'] ) $lang['mod_edit_warnings'] = 'Yes'; else $lang['mod_edit_warnings'] = 'No';
	$lang['mod_warnings'] = 'Yes'; 
	$lang['mod_edit_warnings'] = '<br />- Moderators can edit not self warnings: <b><u>' . $lang['mod_edit_warnings'] . '</u></b>';
	$lang['mod_value_warning'] = '<br />- Max. value for warning adding by moderator: <b><u>' . $board_config['mod_value_warning'] . '</u></b>';
}
else
{
	$lang['mod_warnings'] = 'No'; 
	$lang['mod_edit_warnings'] = '';
	$lang['mod_value_warning'] = '';
}
if ( $board_config['expire_warnings'] < 1 )
{
	$expire_war = 'not expired';
}
else
{
	$expire_war = 'expire after <b>' . $board_config['expire_warnings'] . '</b> days';
}
if ( $board_config['warnings_mods_public'] ) $lang['warnings_mods_public'] = 'Yes'; else $lang['warnings_mods_public'] = 'No';
$lang['warnings_e'] = 'Here displays users who have reprimand added by moderators or administrators.<br /><hr /><span class="gensmall"><b>Warnings setup:</b><br />- Dissallow postings after value: <b><u>' . $board_config['write_warnings'] . '</u></b><br />- Banned after value: <b><u>' . $board_config['ban_warnings'] . '</u></b><br />- Warnings ' . $expire_war . '<br />- Users can see who add warning: <b><u>' . $lang['warnings_mods_public'] . '</u></b><br />- Moderators can add warnings: <b><u>' . $lang['mod_warnings'] . '</u></b>' . $lang['mod_edit_warnings'] . '' . $lang['mod_value_warning'] . '</span>';
$lang['add_warning'] = 'Add warning';
$lang['index_warning'] = 'Warnings - Main page';
$lang['action'] = 'Action';
$lang['Click_view_edited_warning'] = 'Warnings updated. Click %sHERE%s to return warnings';
$lang['Click_view_deleted_warning'] = 'Warning deleted. Click %sHERE%s to return warnings';
$lang['Click_to_back'] = 'Click %sHERE%s to return';
$lang['Click_view_added'] = 'Warning added. Click %sHERE%s to return';
$lang['list_empty'] = 'Warnings list empty<br /><br />';
$lang['wrong_value'] = 'Wrong value';
$lang['reason_empty'] = 'You must add reason';
$lang['user_empty'] = 'You must choose user';
$lang['wrong_user'] = 'Wrong user';
$lang['add_warning_e'] = 'Add your warning';
$lang['list_users'] = 'Lists users with warnings';
$lang['view_warning_detail'] = 'View detailed user warnings';
$lang['warning_archive'] = 'Archive';
$lang['warnings_banned_info'] = '<b>You are banned !</b><br /><br />You have: <b>%s</b> warnings with all value: <b>%s</b>. Banned warnings value is: <b>%s</b><br /><br />Your last warning: <b>%s</b><br />Reason: <i>%s</i>';
$lang['write_denied'] = ' disallow posting';
$lang['banned'] = ' banned';
$lang['no_warning'] = 'You can not give warnings for this user';

// Admin
$lang['Warnings_e'] = 'Here you can setup your warnings tool';
$lang['l_warnings_enable'] = 'Warnings enabled';
$lang['l_mod_warnings'] = 'Moderators can add warnings';
$lang['l_mod_edit_warnings'] = 'Moderators can editing not self warnings';
$lang['l_mod_value_warning'] = 'Max. value warnings for moderators';
$lang['l_write_warnings'] = 'Disallow posting';
$lang['l_write_warnings_e'] = 'After this value users will can not posting';
$lang['l_ban_warnings'] = 'Banned after';
$lang['l_ban_warnings_e'] = 'After this value user will be banned';
$lang['l_expire_warnings'] = 'Expire';
$lang['l_expire_warnings_e'] = 'Days to expire warnings. 0 - disabled';
$lang['l_warnings_mods_public'] = 'Visible author of warning';
$lang['l_warnings_mods_public_e'] = 'Users can see who add warning';
$lang['detail'] = 'Details';
$lang['hide_config'] = 'Hide settings';
$lang['show_config'] = 'Show settings';
$lang['viewtopic_warnings'] = 'Warnings below avatar';
$lang['added_by'] = 'Make out';

?>