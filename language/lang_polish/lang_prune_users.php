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

$lang['Page_title'] = 'Usuñ posty u¿ytkownika';
$lang['Page_desc'] = 'Mo¿esz u¿yæ tego narzêdzia do skasowania postów danego u¿ytkownika ze wszystkich forów lub tylko z wybranego.<br /><b>Przed u¿yciem tego narzêdzia powin' .  (($he) ? 'iene¶' : 'na¶') . ' zrobiæ kopiê bazy danych.</b>';
$lang['Forum'] = 'Forum';
$lang['Prune_result_n'] = '%d Postów usuniêtych.';
$lang['Prune_result_s'] = 'Usuniêto %d post.';
$lang['Prune_result_p'] = 'Usuniêto %d postów.';

$lang['X_Days'] = '%d Dni';
$lang['X_Weeks'] = '%d Tygodni';
$lang['X_Months'] = '%d Miesiêcy';
$lang['X_Years'] = '%d Lat';

$lang['Prune_no_users'] = 'Nie wybrano u¿ytkowników';
$lang['Prune_users_number'] = 'Usuniêtych u¿ytkowników: <b>%d</b>';

$lang['Prune_user_list'] = 'U¿ytkownicy którzy zostan± usuniêci';
$lang['Prune_on_click'] = 'Czy jeste¶ pew' .  (($he) ? 'ien' : 'na') . ', ¿e chcesz usun±æ %d u¿ytkowników?';
$lang['Prune_Action'] = 'Schematy usuwania u¿ytkowników';
$lang['Prune_users_explain'] = 'W tym miejscu masz mo¿liwo¶æ masowo usun±æ u¿ytkowników, masz do wyboru u¿ytkowników którzy nie napisali ¿adnych postów, u¿ytkowników którzy nigdy siê nie logowali, nie aktywowali konta, ma³oaktywnych i ma³opisz±cych<br /><b>UWAGA</b> nie mo¿na cofn±æ tej operacji, powiniene¶ zrobiæ kopiê bazy danych przed jej wykonaniem !<br />Jednorazowo jest kasowanych maksymalnie 200 u¿ytkowników.';
$lang['Prune_commands'] = $lang['Prune_explain'] = array();
$lang['Prune_commands'][0] = 'Usuñ u¿ytkowników bez postów';
$lang['Prune_explain'][0] = '%sZ wyj±tkiem u¿ytkowników zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][1] = 'Nieaktywnych';
$lang['Prune_explain'][1] = '%sNigdy nie zalogowanych, z wyj±tkiem u¿ytkowników zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][2] = 'Nieaktywowanych';
$lang['Prune_explain'][2] = '%sKtórzy nie dokonali aktywacji konta, z wyj±tkiem u¿ytkowników zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][3] = 'Ma³oaktywnych';
$lang['Prune_explain'][3] = 'Którzy nie odwiedzili forum przez ostatnie <b>%s</b> dni, z wyj±tkiem u¿ytkowników zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][4] = 'Ma³opisz±cych';
$lang['Prune_explain'][4] = 'Którzy pisz± mniej ni¿ 1 post na <b>%s</b> dni, z wyj±tkiem u¿ytkowników zarejestrowanych przez ostatnie <b>%d</b> dni'; 
$lang['Prune_commands'][5] = 'Ma³oaktywnych, bez postów';
$lang['Prune_explain'][5] = 'Którzy nie napisali ¿adnego postu i nie logowali sie przez ostatnie <b>%s</b> dni, z wyj±tkiem u¿ytkowników zarejestrowanych przez ostatnie <b>%d</b> dni'; 

//
// That's all Folks!
// -------------------------------------------------

?>