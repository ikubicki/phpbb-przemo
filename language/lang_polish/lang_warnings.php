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

$lang['how_many_warnings'] = 'Ostrze¿eñ';
$lang['value'] = 'Warto¶æ';
$lang['add'] = 'Doda³';
$lang['warnings'] = 'Ostrze¿enia u¿ytkowników';
if ( $board_config['mod_warnings'] )
{
	if ( $board_config['mod_edit_warnings'] ) $lang['mod_edit_warnings'] = 'Tak'; else $lang['mod_edit_warnings'] = 'Nie';
	$lang['mod_warnings'] = 'Tak'; 
	$lang['mod_edit_warnings'] = '<br />- Moderatorzy mog± edytowaæ ostrze¿enia dodane przez innych: <b><u>' . $lang['mod_edit_warnings'] . '</u></b>';
	$lang['mod_value_warning'] = '<br />- Maksymalna warto¶æ ostrze¿enia dodanego przez moderatora to: <b><u>' . $board_config['mod_value_warning'] . '</u></b>';
}
else
{
	$lang['mod_warnings'] = 'Nie'; 
	$lang['mod_edit_warnings'] = '';
	$lang['mod_value_warning'] = '';
}
if ( $board_config['expire_warnings'] < 1 )
{
	$expire_war = 'nie wygasaj± z up³ywem czasu';
}
else
{
	$expire_war = 'wygasaj± po <b>' . $board_config['expire_warnings'] . '</b> dniach';
}
if ( $board_config['warnings_mods_public'] ) $lang['warnings_mods_public'] = 'Tak'; else $lang['warnings_mods_public'] = 'Nie';
$lang['warnings_e'] = 'W tym miejscu wy¶wietlani s± u¿ytkownicy, posiadaj±cy na swoim koncie ostrze¿enia dodane przez administratorów, lub moderatorów.<br /><hr /><span class="gensmall"><b>Ustawienia ostrze¿eñ:</b><br />- Zablokowanie mo¿liwo¶ci pisania postów po warto¶ci ostrze¿eñ: <b><u>' . $board_config['write_warnings'] . '</u></b><br />- Zablokowanie mo¿liwo¶ci wej¶cia na forum po warto¶ci ostrze¿eñ: <b><u>' . $board_config['ban_warnings'] . '</u></b><br />- Ostrze¿enia ' . $expire_war . '<br />- U¿ytkownicy mog± widzieæ od kogo dostali ostrze¿enie: <b><u>' . $lang['warnings_mods_public'] . '</u></b><br />- Moderatorzy mog± dodawaæ ostrze¿enia: <b><u>' . $lang['mod_warnings'] . '</u></b>' . $lang['mod_edit_warnings'] . '' . $lang['mod_value_warning'] . '</span>';
$lang['add_warning'] = 'Dodaj ostrze¿enie';
$lang['index_warning'] = 'Strona g³ówna ostrze¿eñ';
$lang['action'] = 'Czynno¶æ';
$lang['Click_view_edited_warning'] = 'Ostrze¿enie zmienione. Kliknij %sTutaj%s aby przej¶æ do widoku ostrze¿eñ tego u¿ytkownika';
$lang['Click_view_deleted_warning'] = 'Ostrze¿enie usuniête. Kliknij %sTutaj%s aby wróciæ do widoku ostrze¿eñ';
$lang['Click_to_back'] = 'Kliknij %sTutaj%s ¿eby wróciæ';
$lang['Click_view_added'] = 'Ostrze¿enie dodane. Kliknij %sTutaj%s aby przej¶æ do widoku ostrze¿eñ tego u¿ytkownika';
$lang['list_empty'] = 'Nie ma ¿adnych ostrze¿eñ<br /><br />';
$lang['wrong_value'] = 'Nieprawid³owa warto¶æ';
$lang['reason_empty'] = 'Musisz podaæ powód';
$lang['user_empty'] = 'Musisz wybraæ u¿ytkownika';
$lang['wrong_user'] = 'Podany u¿ytkownik jest nieprawid³owy, nie ma go na li¶cie u¿ytkowników';
$lang['add_warning_e'] = 'Dodawanie nowego ostrze¿enia';
$lang['list_users'] = 'Lista u¿ytkowników którzy dostali ostrze¿enia';
$lang['view_warning_detail'] = 'Widok szczegó³owy ostrze¿eñ dla u¿ytkownika';
$lang['view_warning_modid'] = 'Ostrze¿enia które wystawi³';
$lang['warning_archive'] = 'Archiwum';
$lang['write_denied'] = ' zakaz pisania';
$lang['banned'] = ' zbanowany';
$lang['no_warning'] = 'Nie mo¿esz daæ ostrze¿enia temu u¿ytkownikowi';

// Admin
$lang['Warnings_e'] = 'W tym miejscu mo¿esz w³±czyæ mo¿liwo¶æ dodawania u¿ytkownikom ostrze¿eñ, przez Administratorów lub Moderatorów. U¿ytkownikom mo¿na dawaæ ostrze¿enia o ró¿nej warto¶ci, w zale¿no¶ci od ustawionej warto¶ci, po osi±gniêciu jej u¿ytkownik mo¿e mieæ zablokowan± mo¿liwo¶æ pisania, lub zablokowane wej¶cie na forum. Obydwa progi mo¿na w³±czyæ na raz, mo¿na ustaliæ ich wielko¶æ, oraz czas trwania ostrze¿eñ';
$lang['l_warnings_enable'] = 'Ostrze¿enia w³±czone';
$lang['l_mod_warnings'] = 'Moderatorzy mog± dawaæ ostrze¿enia';
$lang['l_mod_edit_warnings'] = 'Moderatorzy mog± edytowaæ ostrze¿enia których nie wystawili';
$lang['l_mod_value_warning'] = 'Maksymalna warto¶æ ostrze¿enia dla moderatorów';
$lang['l_write_warnings'] = 'Blokada pisania';
$lang['l_write_warnings_e'] = 'Po jakiej warto¶ci ostrze¿eñ u¿ytkownik nie bêdzie móg³ pisac na forum';
$lang['l_ban_warnings'] = 'Blokada wej¶cia na forum';
$lang['l_ban_warnings_e'] = 'Po jakiej warto¶ci ostrze¿eñ u¿ytkownik nie bêdzie móg³ wej¶æ na forum';
$lang['l_expire_warnings'] = 'Czas trwania ostrze¿enia';
$lang['l_expire_warnings_e'] = 'Podaj czas po ilu dniach ostrze¿enie zniknie od momentu jego wystawienia. 0 - wy³±czone';
$lang['l_warnings_mods_public'] = 'Widoczny autor ostrze¿enia';
$lang['l_warnings_mods_public_e'] = 'U¿ytkownicy mog± widzieæ kto da³ ostrze¿enie';
$lang['detail'] = 'Szczegó³y';
$lang['hide_config'] = 'Ukryj ustawienia';
$lang['show_config'] = 'Poka¿ ustawienia';
$lang['viewtopic_warnings'] = 'Ostrze¿enia pod avatarem';
$lang['added_by'] = 'Otrzymane od';

?>