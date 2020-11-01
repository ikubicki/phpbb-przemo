<?php
/***************************************************************************
*                           lang_statistics.php
*                            -------------------
*   begin                : Tue February 26 2002
*   copyright            : (C) 2002 Nivisec.com
*   email                : admin@nivisec.com
*
*   $Id: lang_statistics.php,v 1.4 2002/11/09 16:04:08 acydburn Exp $
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

// Check for user gender
$he = ($userdata['user_gender'] != 2) ? true : false;

// Original Statistics Mod (c) 2002 Nivisec - http://nivisec.com/mods

//
// If you want to credit the Author on the Statistics Page, uncomment the second line.
//
$lang['Version_info'] = '<br />System statystyk wersja %s'; //%s = number
//$lang['Version_info'] = '<br />Statistics Mod Version %s &copy; 2002 <a href="http://www.opentools.de/board">Acyd Burn</a>';

//
// These Language Variables are available for all installed Modules
//
$lang['Rank'] = 'Pozycja';
$lang['Percent'] = 'Procent';
$lang['Graph'] = 'Wykres';
$lang['Uses'] = 'Użyty';
$lang['How_many'] = 'Ile razy';

//
// Main Language
//

//
// Page Header/Footer
//
$lang['Install_info'] = 'Zainstalowane na %s'; //%s = date
$lang['Viewed_info'] = 'Strona statystyk wczytana %d razy'; //%d = number
$lang['Statistics_title'] = 'Statystyki forum';

//
// Statistics Config
//
$lang['Statistics_config_title'] = 'Konfiguracja statystyk';

$lang['Return_limit'] = 'Limit pozycji';
$lang['Return_limit_desc'] = 'Ile pozycji będzie wyświetlane w rankingu danej kategorii.';
$lang['Clear_cache'] = 'Czyszczenie Cache';
$lang['Clear_cache_desc'] = 'Czyści z cachu dane wszystkich modułów (odświeżanie)';

//
// Status Messages
//
$lang['Messages'] = 'Komunikaty admina';
$lang['Updated'] = 'Uaktualnione';
$lang['Active'] = 'Włączony';
$lang['Activate'] = 'Włącz';
$lang['Activated'] = 'Włączono';
$lang['Not_active'] = 'Nieaktywny';
$lang['Deactivated'] = 'Wyłączony';
$lang['Install'] = 'Zainstaluj';
$lang['Uninstall'] = 'Odinstaluj';
$lang['Uninstalled'] = 'Odinstalowany';
$lang['Move_up'] = 'W górę';
$lang['Move_down'] = 'W dół';
$lang['Update_time'] = 'Czas uaktualniania';
$lang['Auth_settings_updated'] = 'Authorization Settings - [These are always updated]';

//
// Modules Management
//
$lang['Back_to_management'] = 'Wróć do menadżera statystyk';
$lang['Statistics_modules_title'] = 'Menadżer statystyk';

$lang['Module_name'] = 'Nazwa';
$lang['Directory_name'] = 'Nazwa katalogu';
$lang['Status'] = 'Status';
$lang['Update_time_minutes'] = 'Czas uaktualniania w godzinach';
$lang['Update_time_desc'] = 'Czas odświeżania danych modułu.';
$lang['Auto_set_update_time'] = 'Odśwież wszystkie moduły.';
$lang['Uninstall_module'] = 'Odinstaluj moduł';
$lang['Uninstall_module_desc'] = 'Oznacz moduł jako "Wyłączony", możesz go ponownie zainstalować. Jeśli natomiast chcesz go usunąć na stałe będziesz musiał' .  (($he) ? '' : 'a') . ' jeszcze skasować jego katalog.';
$lang['Active_desc'] = '';

$lang['Not_allowed_to_install'] = 'Nie ma możliwości zainstalowania tego modułu. Być może ten moduł wymaga innego systemu statystyk.';
$lang['Wrong_stats_mod_version'] = 'Nie ma możliwości zainstalować tego modułu, ponieważ został on napisany dla innej wersji systemu statystyk. Zeby go zainstalować, potrzebujesz wersji %s Statystyk.'; // replace %s with Version (2.1.3 for example)
$lang['Module_install_error'] = 'Wystąpił błąd podczas instalowania modułu. Być może wystąpił jakiś błąd SQL, zobacz powyżej.';

$lang['Preview_debug_info'] = 'Moduł wygenerowany w %f sekund: %d wygenerowanych zapytań.'; // Replace %f with seconds and %d with queries
$lang['Update_time_recommend'] = 'Proponowany czas uaktualniania minut: <b>%d</b>.'; // Replace %d with Minutes

?>