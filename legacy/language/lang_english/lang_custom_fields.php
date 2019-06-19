<?php
/***************************************************************************
 *             lang_custom_fields.php
 *             -------------------
 *	  begin     : Monday, May 10, 2004
 *	  copyright : (C) 2004 Przemo http://www.przemo.org/phpBB2/
 *	  email     : przemo@przemo.org
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

$lang['CF_title'] = 'Additionall fields in the profile';
$lang['CF_title_explain'] = 'Here you can define unlimited profile fields. You can set parameters separately per field which you add.<br />Here are few invisible settings also, like hide field name in the viewtopic, multilanguage support for field name and field description, icon support.<br />If you want to know it visit: <a href="http://www.przemo.org/phpBB2/forum/viewtopic.php?t=3148" target="_blank">Instruction</a>';
$lang['CF_add'] = 'Add additionall field';
$lang['CF_no_fields'] = 'No field\'s exists. Use below form to add profile field';
$lang['CF_short_desc'] = 'Field name';
$lang['CF_long_desc'] = 'Long field description (it will be showing under field name)';
$lang['CF_makelinks'] = 'Make links automatically';
$lang['CF_max_value'] = 'Maximum chars lenght';
$lang['CF_min_value'] = 'Minimum chars lenght';
$lang['CF_numerics'] = 'Numerics values only';
$lang['CF_require'] = 'Require durning registration';
$lang['CF_view_post'] = 'View topic position';
$lang['CF_post'] = 'Above post';
$lang['CF_upost'] = 'Under post';
$lang['CF_avatar'] = 'Under avatar';
$lang['CF_view_profile'] = 'Show in the user\'s profile';
$lang['CF_set_form'] = 'Type of fill in field';
$lang['CF_text'] = 'text';
$lang['CF_textarea'] = 'text area';
$lang['CF_jumpbox'] = 'generate jumpbox';
$lang['CF_jumpbox_e'] = 'You can set only few position to choose by user\'s, fill in field automatically in echange to JumpBox with list of your estabilish positions.<br />Positions separate with comma, for example: <b>dog, cat</b>';
$lang['CF_added'] = 'Field: <b>%s</b> added to database.<br /><br />Click %sTutaj%s to return additionall fields settings.';
$lang['CF_edited'] = 'Field: <b>%s</b> changed sucesfully.<br /><br />Click %sTutaj%s to return additionall fields settings.';
$lang['CF_delete'] = 'Mark to delete this additionall field';
$lang['CF_confirm_delete'] = 'Are you sure to delete this additionall field ?<br />Remember, you can not return back this operation and all user\'s data will be loss !';
$lang['CF_delete_executed'] = 'Field removed from database<br /><br />Click %sTutaj%s to return additionall fields settings.';
$lang['CF_duplicate_desc_short'] = 'Field with name: <b>%s</b> already exist.';
$lang['CF_too_short'] = 'Item: <b>%s</b> is too short, minimal length: %s';
$lang['CF_too_long'] = 'Item: <b>%s</b> is too long, maximum of chars: %s';
$lang['CF_required'] = 'Item: <b>%s</b> is require.';
$lang['CF_no_numeric'] = 'Item: <b>%s</b> must be numeric';
$lang['CF_no_jumpbox'] = 'Item: <b>%s</b> must fit to one of the estabilish positions';
$lang['CF_can_allow'] = 'Allow to use: %s';
$lang['CF_no_forum'] = 'Don\'t display in forums';
$lang['Prefix_e'] = 'Prefix and Suffix custom field can be used for example to create Skype html link:<br />&lt;a href=&quot;callto://<b>field_value</b>&quot;&gt;<b>field_value</b>&lt;/a&gt;<br />In this case set prefix only: <b>&lt;a href=&quot;callto://</b> and suffix: <b>&lt;/a&gt;</b> rest of link will be created automatically. But if prefix will not contain:<br /><b>&lt;a href=&quot;</b> or suffix: <b>&lt;/a&gt;</b> will be added only at the begin and end of the field value.<br /><a href="images/dynamic.html" target="_blank">Replace support</a>';
$lang['CF_editable'] = 'Editable by user';
$lang['CF_view_by'] = 'Viewable by';
$lang['CF_view_by_user'] = 'and user';
?>