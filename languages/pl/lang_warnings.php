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

$lang['how_many_warnings'] = 'Ostrzeżeń';
$lang['value'] = 'Wartość';
$lang['add'] = 'Dodał';
$lang['warnings'] = 'Ostrzeżenia użytkowników';
if ( $board_config['mod_warnings'] )
{
	if ( $board_config['mod_edit_warnings'] ) $lang['mod_edit_warnings'] = 'Tak'; else $lang['mod_edit_warnings'] = 'Nie';
	$lang['mod_warnings'] = 'Tak'; 
	$lang['mod_edit_warnings'] = '<br />- Moderatorzy mogą edytować ostrzeżenia dodane przez innych: <b><u>' . $lang['mod_edit_warnings'] . '</u></b>';
	$lang['mod_value_warning'] = '<br />- Maksymalna wartość ostrzeżenia dodanego przez moderatora to: <b><u>' . $board_config['mod_value_warning'] . '</u></b>';
}
else
{
	$lang['mod_warnings'] = 'Nie'; 
	$lang['mod_edit_warnings'] = '';
	$lang['mod_value_warning'] = '';
}
if ( $board_config['expire_warnings'] < 1 )
{
	$expire_war = 'nie wygasają z upływem czasu';
}
else
{
	$expire_war = 'wygasają po <b>' . $board_config['expire_warnings'] . '</b> dniach';
}
if ( $board_config['warnings_mods_public'] ) $lang['warnings_mods_public'] = 'Tak'; else $lang['warnings_mods_public'] = 'Nie';
$lang['warnings_e'] = 'W tym miejscu wyświetlani są użytkownicy, posiadający na swoim koncie ostrzeżenia dodane przez administratorów, lub moderatorów.<br /><hr /><span class="gensmall"><b>Ustawienia ostrzeżeń:</b><br />- Zablokowanie możliwości pisania postów po wartości ostrzeżeń: <b><u>' . $board_config['write_warnings'] . '</u></b><br />- Zablokowanie możliwości wejścia na forum po wartości ostrzeżeń: <b><u>' . $board_config['ban_warnings'] . '</u></b><br />- Ostrzeżenia ' . $expire_war . '<br />- Użytkownicy mogą widzieć od kogo dostali ostrzeżenie: <b><u>' . $lang['warnings_mods_public'] . '</u></b><br />- Moderatorzy mogą dodawać ostrzeżenia: <b><u>' . $lang['mod_warnings'] . '</u></b>' . $lang['mod_edit_warnings'] . '' . $lang['mod_value_warning'] . '</span>';
$lang['add_warning'] = 'Dodaj ostrzeżenie';
$lang['index_warning'] = 'Strona główna ostrzeżeń';
$lang['action'] = 'Czynność';
$lang['Click_view_edited_warning'] = 'Ostrzeżenie zmienione. Kliknij %sTutaj%s aby przejść do widoku ostrzeżeń tego użytkownika';
$lang['Click_view_deleted_warning'] = 'Ostrzeżenie usunięte. Kliknij %sTutaj%s aby wrócić do widoku ostrzeżeń';
$lang['Click_to_back'] = 'Kliknij %sTutaj%s żeby wrócić';
$lang['Click_view_added'] = 'Ostrzeżenie dodane. Kliknij %sTutaj%s aby przejść do widoku ostrzeżeń tego użytkownika';
$lang['list_empty'] = 'Nie ma żadnych ostrzeżeń<br /><br />';
$lang['wrong_value'] = 'Nieprawidłowa wartość';
$lang['reason_empty'] = 'Musisz podać powód';
$lang['user_empty'] = 'Musisz wybrać użytkownika';
$lang['wrong_user'] = 'Podany użytkownik jest nieprawidłowy, nie ma go na liście użytkowników';
$lang['add_warning_e'] = 'Dodawanie nowego ostrzeżenia';
$lang['list_users'] = 'Lista użytkowników którzy dostali ostrzeżenia';
$lang['view_warning_detail'] = 'Widok szczegółowy ostrzeżeń dla użytkownika';
$lang['view_warning_modid'] = 'Ostrzeżenia które wystawił';
$lang['warning_archive'] = 'Archiwum';
$lang['write_denied'] = ' zakaz pisania';
$lang['banned'] = ' zbanowany';
$lang['no_warning'] = 'Nie możesz dać ostrzeżenia temu użytkownikowi';

// Admin
$lang['Warnings_e'] = 'W tym miejscu możesz włączyć możliwość dodawania użytkownikom ostrzeżeń, przez Administratorów lub Moderatorów. Użytkownikom można dawać ostrzeżenia o różnej wartości, w zależności od ustawionej wartości, po osiągnięciu jej użytkownik może mieć zablokowaną możliwość pisania, lub zablokowane wejście na forum. Obydwa progi można włączyć na raz, można ustalić ich wielkość, oraz czas trwania ostrzeżeń';
$lang['l_warnings_enable'] = 'Ostrzeżenia włączone';
$lang['l_mod_warnings'] = 'Moderatorzy mogą dawać ostrzeżenia';
$lang['l_mod_edit_warnings'] = 'Moderatorzy mogą edytować ostrzeżenia których nie wystawili';
$lang['l_mod_value_warning'] = 'Maksymalna wartość ostrzeżenia dla moderatorów';
$lang['l_write_warnings'] = 'Blokada pisania';
$lang['l_write_warnings_e'] = 'Po jakiej wartości ostrzeżeń użytkownik nie będzie mógł pisac na forum';
$lang['l_ban_warnings'] = 'Blokada wejścia na forum';
$lang['l_ban_warnings_e'] = 'Po jakiej wartości ostrzeżeń użytkownik nie będzie mógł wejść na forum';
$lang['l_expire_warnings'] = 'Czas trwania ostrzeżenia';
$lang['l_expire_warnings_e'] = 'Podaj czas po ilu dniach ostrzeżenie zniknie od momentu jego wystawienia. 0 - wyłączone';
$lang['l_warnings_mods_public'] = 'Widoczny autor ostrzeżenia';
$lang['l_warnings_mods_public_e'] = 'Użytkownicy mogą widzieć kto dał ostrzeżenie';
$lang['detail'] = 'Szczegóły';
$lang['hide_config'] = 'Ukryj ustawienia';
$lang['show_config'] = 'Pokaż ustawienia';
$lang['viewtopic_warnings'] = 'Ostrzeżenia pod avatarem';
$lang['added_by'] = 'Otrzymane od';

?>