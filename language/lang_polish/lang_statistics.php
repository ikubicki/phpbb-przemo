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
$lang['Uses'] = 'U¿yty';
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
$lang['Return_limit_desc'] = 'Ile pozycji bêdzie wy¶wietlane w rankingu danej kategorii.';
$lang['Clear_cache'] = 'Czyszczenie Cache';
$lang['Clear_cache_desc'] = 'Czy¶ci z cachu dane wszystkich modu³ów (od¶wie¿anie)';

//
// Status Messages
//
$lang['Messages'] = 'Komunikaty admina';
$lang['Updated'] = 'Uaktualnione';
$lang['Active'] = 'W³±czony';
$lang['Activate'] = 'W³±cz';
$lang['Activated'] = 'W³±czono';
$lang['Not_active'] = 'Nieaktywny';
$lang['Deactivated'] = 'Wy³±czony';
$lang['Install'] = 'Zainstaluj';
$lang['Uninstall'] = 'Odinstaluj';
$lang['Uninstalled'] = 'Odinstalowany';
$lang['Move_up'] = 'W górê';
$lang['Move_down'] = 'W dó³';
$lang['Update_time'] = 'Czas uaktualniania';
$lang['Auth_settings_updated'] = 'Authorization Settings - [These are always updated]';

//
// Modules Management
//
$lang['Back_to_management'] = 'Wróæ do menad¿era statystyk';
$lang['Statistics_modules_title'] = 'Menad¿er statystyk';

$lang['Module_name'] = 'Nazwa';
$lang['Directory_name'] = 'Nazwa katalogu';
$lang['Status'] = 'Status';
$lang['Update_time_minutes'] = 'Czas uaktualniania w godzinach';
$lang['Update_time_desc'] = 'Czas od¶wie¿ania danych modu³u.';
$lang['Auto_set_update_time'] = 'Od¶wie¿ wszystkie modu³y.';
$lang['Uninstall_module'] = 'Odinstaluj modu³';
$lang['Uninstall_module_desc'] = 'Oznacz modu³ jako "Wy³±czony", mo¿esz go ponownie zainstalowaæ. Je¶li natomiast chcesz go usun±æ na sta³e bêdziesz musia³' .  (($he) ? '' : 'a') . ' jeszcze skasowaæ jego katalog.';
$lang['Active_desc'] = '';

$lang['Not_allowed_to_install'] = 'Nie ma mo¿liwo¶ci zainstalowania tego modu³u. Byæ mo¿e ten modu³ wymaga innego systemu statystyk.';
$lang['Wrong_stats_mod_version'] = 'Nie ma mo¿liwo¶ci zainstalowaæ tego modu³u, poniewa¿ zosta³ on napisany dla innej wersji systemu statystyk. Zeby go zainstalowaæ, potrzebujesz wersji %s Statystyk.'; // replace %s with Version (2.1.3 for example)
$lang['Module_install_error'] = 'Wyst±pi³ b³±d podczas instalowania modu³u. Byæ mo¿e wyst±pi³ jaki¶ b³±d SQL, zobacz powy¿ej.';

$lang['Preview_debug_info'] = 'Modu³ wygenerowany w %f sekund: %d wygenerowanych zapytañ.'; // Replace %f with seconds and %d with queries
$lang['Update_time_recommend'] = 'Proponowany czas uaktualniania minut: <b>%d</b>.'; // Replace %d with Minutes

?>