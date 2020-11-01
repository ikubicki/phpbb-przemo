<?php
/***************************************************************************
 *                      lang_prune_users.php [Polish]
                        -------------------
   begin                : Jul 19 2002
   copyright            : (C) 2002 John B. Abela
   email                : abela@phpbb.com
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

//
// Format is same as lang_main
//

// Check for user gender
$he = ($userdata['user_gender'] != 2) ? true : false;

$lang['Page_title'] = 'Usuń posty użytkownika';
$lang['Page_desc'] = 'Możesz użyć tego narzędzia do skasowania postów danego użytkownika ze wszystkich forów lub tylko z wybranego.<br /><b>Przed użyciem tego narzędzia powin' .  (($he) ? 'ieneś' : 'naś') . ' zrobić kopię bazy danych.</b>';
$lang['Forum'] = 'Forum';
$lang['Prune_result_n'] = '%d Postów usuniętych.';
$lang['Prune_result_s'] = 'Usunięto %d post.';
$lang['Prune_result_p'] = 'Usunięto %d postów.';

$lang['X_Days'] = '%d Dni';
$lang['X_Weeks'] = '%d Tygodni';
$lang['X_Months'] = '%d Miesięcy';
$lang['X_Years'] = '%d Lat';

$lang['Prune_no_users'] = 'Nie wybrano użytkowników';
$lang['Prune_users_number'] = 'Usuniętych użytkowników: <b>%d</b>';

$lang['Prune_user_list'] = 'Użytkownicy którzy zostaną usunięci';
$lang['Prune_on_click'] = 'Czy jesteś pew' .  (($he) ? 'ien' : 'na') . ', że chcesz usunąć %d użytkowników?';
$lang['Prune_Action'] = 'Schematy usuwania użytkowników';
$lang['Prune_users_explain'] = 'W tym miejscu masz możliwość masowo usunąć użytkowników, masz do wyboru użytkowników którzy nie napisali żadnych postów, użytkowników którzy nigdy się nie logowali, nie aktywowali konta, małoaktywnych i małopiszących<br /><b>UWAGA</b> nie można cofnąć tej operacji, powinieneś zrobić kopię bazy danych przed jej wykonaniem !<br />Jednorazowo jest kasowanych maksymalnie 200 użytkowników.';
$lang['Prune_commands'] = $lang['Prune_explain'] = array();
$lang['Prune_commands'][0] = 'Usuń użytkowników bez postów';
$lang['Prune_explain'][0] = '%sZ wyjątkiem użytkowników zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][1] = 'Nieaktywnych';
$lang['Prune_explain'][1] = '%sNigdy nie zalogowanych, z wyjątkiem użytkowników zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][2] = 'Nieaktywowanych';
$lang['Prune_explain'][2] = '%sKtórzy nie dokonali aktywacji konta, z wyjątkiem użytkowników zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][3] = 'Małoaktywnych';
$lang['Prune_explain'][3] = 'Którzy nie odwiedzili forum przez ostatnie <b>%s</b> dni, z wyjątkiem użytkowników zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][4] = 'Małopiszących';
$lang['Prune_explain'][4] = 'Którzy piszą mniej niż 1 post na <b>%s</b> dni, z wyjątkiem użytkowników zarejestrowanych przez ostatnie <b>%d</b> dni'; 
$lang['Prune_commands'][5] = 'Małoaktywnych, bez postów';
$lang['Prune_explain'][5] = 'Którzy nie napisali żadnego postu i nie logowali sie przez ostatnie <b>%s</b> dni, z wyjątkiem użytkowników zarejestrowanych przez ostatnie <b>%d</b> dni'; 

//
// That's all Folks!
// -------------------------------------------------

?>