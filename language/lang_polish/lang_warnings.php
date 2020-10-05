<?php
/***************************************************************************
 *				lang_warnings.php [Polish]
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

$lang['how_many_warnings'] = 'Ostrze�e�';
$lang['value'] = 'Warto��';
$lang['add'] = 'Doda�';
$lang['warnings'] = 'Ostrze�enia u�ytkownik�w';
if ( $board_config['mod_warnings'] )
{
	if ( $board_config['mod_edit_warnings'] ) $lang['mod_edit_warnings'] = 'Tak'; else $lang['mod_edit_warnings'] = 'Nie';
	$lang['mod_warnings'] = 'Tak'; 
	$lang['mod_edit_warnings'] = '<br />- Moderatorzy mog� edytowa� ostrze�enia dodane przez innych: <b><u>' . $lang['mod_edit_warnings'] . '</u></b>';
	$lang['mod_value_warning'] = '<br />- Maksymalna warto�� ostrze�enia dodanego przez moderatora to: <b><u>' . $board_config['mod_value_warning'] . '</u></b>';
}
else
{
	$lang['mod_warnings'] = 'Nie'; 
	$lang['mod_edit_warnings'] = '';
	$lang['mod_value_warning'] = '';
}
if ( $board_config['expire_warnings'] < 1 )
{
	$expire_war = 'nie wygasaj� z up�ywem czasu';
}
else
{
	$expire_war = 'wygasaj� po <b>' . $board_config['expire_warnings'] . '</b> dniach';
}
if ( $board_config['warnings_mods_public'] ) $lang['warnings_mods_public'] = 'Tak'; else $lang['warnings_mods_public'] = 'Nie';
$lang['warnings_e'] = 'W tym miejscu wy�wietlani s� u�ytkownicy, posiadaj�cy na swoim koncie ostrze�enia dodane przez administrator�w, lub moderator�w.<br /><hr /><span class="gensmall"><b>Ustawienia ostrze�e�:</b><br />- Zablokowanie mo�liwo�ci pisania post�w po warto�ci ostrze�e�: <b><u>' . $board_config['write_warnings'] . '</u></b><br />- Zablokowanie mo�liwo�ci wej�cia na forum po warto�ci ostrze�e�: <b><u>' . $board_config['ban_warnings'] . '</u></b><br />- Ostrze�enia ' . $expire_war . '<br />- U�ytkownicy mog� widzie� od kogo dostali ostrze�enie: <b><u>' . $lang['warnings_mods_public'] . '</u></b><br />- Moderatorzy mog� dodawa� ostrze�enia: <b><u>' . $lang['mod_warnings'] . '</u></b>' . $lang['mod_edit_warnings'] . '' . $lang['mod_value_warning'] . '</span>';
$lang['add_warning'] = 'Dodaj ostrze�enie';
$lang['index_warning'] = 'Strona g��wna ostrze�e�';
$lang['action'] = 'Czynno��';
$lang['Click_view_edited_warning'] = 'Ostrze�enie zmienione. Kliknij %sTutaj%s aby przej�� do widoku ostrze�e� tego u�ytkownika';
$lang['Click_view_deleted_warning'] = 'Ostrze�enie usuni�te. Kliknij %sTutaj%s aby wr�ci� do widoku ostrze�e�';
$lang['Click_to_back'] = 'Kliknij %sTutaj%s �eby wr�ci�';
$lang['Click_view_added'] = 'Ostrze�enie dodane. Kliknij %sTutaj%s aby przej�� do widoku ostrze�e� tego u�ytkownika';
$lang['list_empty'] = 'Nie ma �adnych ostrze�e�<br /><br />';
$lang['wrong_value'] = 'Nieprawid�owa warto��';
$lang['reason_empty'] = 'Musisz poda� pow�d';
$lang['user_empty'] = 'Musisz wybra� u�ytkownika';
$lang['wrong_user'] = 'Podany u�ytkownik jest nieprawid�owy, nie ma go na li�cie u�ytkownik�w';
$lang['add_warning_e'] = 'Dodawanie nowego ostrze�enia';
$lang['list_users'] = 'Lista u�ytkownik�w kt�rzy dostali ostrze�enia';
$lang['view_warning_detail'] = 'Widok szczeg�owy ostrze�e� dla u�ytkownika';
$lang['view_warning_modid'] = 'Ostrze�enia kt�re wystawi�';
$lang['warning_archive'] = 'Archiwum';
$lang['write_denied'] = ' zakaz pisania';
$lang['banned'] = ' zbanowany';
$lang['no_warning'] = 'Nie mo�esz da� ostrze�enia temu u�ytkownikowi';

// Admin
$lang['Warnings_e'] = 'W tym miejscu mo�esz w��czy� mo�liwo�� dodawania u�ytkownikom ostrze�e�, przez Administrator�w lub Moderator�w. U�ytkownikom mo�na dawa� ostrze�enia o r�nej warto�ci, w zale�no�ci od ustawionej warto�ci, po osi�gni�ciu jej u�ytkownik mo�e mie� zablokowan� mo�liwo�� pisania, lub zablokowane wej�cie na forum. Obydwa progi mo�na w��czy� na raz, mo�na ustali� ich wielko��, oraz czas trwania ostrze�e�';
$lang['l_warnings_enable'] = 'Ostrze�enia w��czone';
$lang['l_mod_warnings'] = 'Moderatorzy mog� dawa� ostrze�enia';
$lang['l_mod_edit_warnings'] = 'Moderatorzy mog� edytowa� ostrze�enia kt�rych nie wystawili';
$lang['l_mod_value_warning'] = 'Maksymalna warto�� ostrze�enia dla moderator�w';
$lang['l_write_warnings'] = 'Blokada pisania';
$lang['l_write_warnings_e'] = 'Po jakiej warto�ci ostrze�e� u�ytkownik nie b�dzie m�g� pisac na forum';
$lang['l_ban_warnings'] = 'Blokada wej�cia na forum';
$lang['l_ban_warnings_e'] = 'Po jakiej warto�ci ostrze�e� u�ytkownik nie b�dzie m�g� wej�� na forum';
$lang['l_expire_warnings'] = 'Czas trwania ostrze�enia';
$lang['l_expire_warnings_e'] = 'Podaj czas po ilu dniach ostrze�enie zniknie od momentu jego wystawienia. 0 - wy��czone';
$lang['l_warnings_mods_public'] = 'Widoczny autor ostrze�enia';
$lang['l_warnings_mods_public_e'] = 'U�ytkownicy mog� widzie� kto da� ostrze�enie';
$lang['detail'] = 'Szczeg�y';
$lang['hide_config'] = 'Ukryj ustawienia';
$lang['show_config'] = 'Poka� ustawienia';
$lang['viewtopic_warnings'] = 'Ostrze�enia pod avatarem';
$lang['added_by'] = 'Otrzymane od';

?>