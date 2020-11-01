<?php
/***************************************************************************
 *                      lang_prune_users.php [English]
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

$lang['Page_title'] = 'Prune User Posts';
$lang['Page_desc'] = 'You can use those tool to delete posts of a specific user from all the forums any specific one.<br /><b>Before use this tool you should backup your database!</b>';
$lang['Forum'] = 'Forum';
$lang['Prune_result_n'] = '%d Posts Deleted.';
$lang['Prune_result_s'] = 'Successfully Pruned %d post.';
$lang['Prune_result_p'] = 'Successfully Pruned %d posts.';

$lang['X_Days'] = '%d Days';
$lang['X_Weeks'] = '%d Weeks';
$lang['X_Months'] = '%d Months';
$lang['X_Years'] = '%d Years';

$lang['Prune_no_users'] = 'No users deleted';
$lang['Prune_users_number'] = 'The following %d users were deleted:';

$lang['Prune_user_list'] = 'Users who will be deleted';
$lang['Prune_on_click'] = 'You are about to delete %d users. Are you sure?';
$lang['Prune_Action'] = 'Click link below to execute';
$lang['Prune_users_explain'] = 'From this page you can prune users. You can choose one of three links: delete old users who have never posted, delete old users who have never logged in, delete users who have never activated their account.<p/><b>Note:</b> There is no undo function.<br /><br />Removed users $notify notified via na e-mail about deleted<br />You can change it in menu Configuration > Additional > "Notify user via e-mail about delete accout"';
$lang['Prune_commands'] = array();
$lang['Prune_commands'][0] = 'Prune non-posting users';
$lang['Prune_explain'][0] = '%sWho have never posted, <b>excluding</b> new users from the past <b>%s</b> days';
$lang['Prune_commands'][1] = 'Prune inactive users';
$lang['Prune_explain'][1] = '%sWho have never logged in, <b>excluding</b> new users from the past <b>%s</b> days';
$lang['Prune_commands'][2] = 'Prune non-activate users';
$lang['Prune_explain'][2] = '%sWho have never been activated, <b>excluding</b> new users from the past <b>%s</b> days';
$lang['Prune_commands'][3] = 'Prune long-time-since users';
$lang['Prune_explain'][3] = 'Who have not visited for <b>%s</b> days, <b>excluding</b> new users from the past <b>%s</b> days';
$lang['Prune_commands'][4] = 'Prune not posting so often users';
$lang['Prune_explain'][4] = 'Who have less than an avarage of 1 post for every <b>%s</b> days while registered, <b>excluding</b> new users from the past <b>%s</b> days'; 
$lang['Prune_commands'][5] = 'Prune inactive users with no posts';
$lang['Prune_explain'][5] = 'Who have no posts, who have not visited for <b>%s</b> days, <b>excluding</b> new users from the past <b>%s</b> days'; 

//
// That's all Folks!
// -------------------------------------------------

?>