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
$he = true;

$lang['Page_title'] = 'Usu� posty u�ytkownika';
$lang['Page_desc'] = 'Mo�esz u�y� tego narz�dzia do skasowania post�w danego u�ytkownika ze wszystkich for�w lub tylko z wybranego.<br /><b>Przed u�yciem tego narz�dzia powin' .  (($he) ? 'iene�' : 'na�') . ' zrobi� kopi� bazy danych.</b>';
$lang['Forum'] = 'Forum';
$lang['Prune_result_n'] = '%d Post�w usuni�tych.';
$lang['Prune_result_s'] = 'Usuni�to %d post.';
$lang['Prune_result_p'] = 'Usuni�to %d post�w.';

$lang['X_Days'] = '%d Dni';
$lang['X_Weeks'] = '%d Tygodni';
$lang['X_Months'] = '%d Miesi�cy';
$lang['X_Years'] = '%d Lat';

$lang['Prune_no_users'] = 'Nie wybrano u�ytkownik�w';
$lang['Prune_users_number'] = 'Usuni�tych u�ytkownik�w: <b>%d</b>';

$lang['Prune_user_list'] = 'U�ytkownicy kt�rzy zostan� usuni�ci';
$lang['Prune_on_click'] = 'Czy jeste� pew' .  (($he) ? 'ien' : 'na') . ', �e chcesz usun�� %d u�ytkownik�w?';
$lang['Prune_Action'] = 'Schematy usuwania u�ytkownik�w';
$lang['Prune_users_explain'] = 'W tym miejscu masz mo�liwo�� masowo usun�� u�ytkownik�w, masz do wyboru u�ytkownik�w kt�rzy nie napisali �adnych post�w, u�ytkownik�w kt�rzy nigdy si� nie logowali, nie aktywowali konta, ma�oaktywnych i ma�opisz�cych<br /><b>UWAGA</b> nie mo�na cofn�� tej operacji, powiniene� zrobi� kopi� bazy danych przed jej wykonaniem !<br />Jednorazowo jest kasowanych maksymalnie 200 u�ytkownik�w.';
$lang['Prune_commands'] = $lang['Prune_explain'] = array();
$lang['Prune_commands'][0] = 'Usu� u�ytkownik�w bez post�w';
$lang['Prune_explain'][0] = '%sZ wyj�tkiem u�ytkownik�w zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][1] = 'Nieaktywnych';
$lang['Prune_explain'][1] = '%sNigdy nie zalogowanych, z wyj�tkiem u�ytkownik�w zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][2] = 'Nieaktywowanych';
$lang['Prune_explain'][2] = '%sKt�rzy nie dokonali aktywacji konta, z wyj�tkiem u�ytkownik�w zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][3] = 'Ma�oaktywnych';
$lang['Prune_explain'][3] = 'Kt�rzy nie odwiedzili forum przez ostatnie <b>%s</b> dni, z wyj�tkiem u�ytkownik�w zarejestrowanych przez ostatnie <b>%d</b> dni';
$lang['Prune_commands'][4] = 'Ma�opisz�cych';
$lang['Prune_explain'][4] = 'Kt�rzy pisz� mniej ni� 1 post na <b>%s</b> dni, z wyj�tkiem u�ytkownik�w zarejestrowanych przez ostatnie <b>%d</b> dni'; 
$lang['Prune_commands'][5] = 'Ma�oaktywnych, bez post�w';
$lang['Prune_explain'][5] = 'Kt�rzy nie napisali �adnego postu i nie logowali sie przez ostatnie <b>%s</b> dni, z wyj�tkiem u�ytkownik�w zarejestrowanych przez ostatnie <b>%d</b> dni'; 

//
// That's all Folks!
// -------------------------------------------------

?>