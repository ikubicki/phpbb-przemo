<?php
/*************************************************************************** 
*                            admin_prune_users.php 
*             php Admin Script for prune users mod 
*                       ------------------- 
*   begin                : April 30, 2002 
*   email                : ncr@db9.dk HTTP://mods.db9.dk 
*      ver. 1.0.2. 
* 
* 
*   History:
* 	 0.9.0. - initial BETA
*      0.9.1. - added prune inativated option
*	 0.9.2. - added support for the end user easely can customise the
*			 interface with more options    
*	 0.9.3. - changed $lang['prune'] to $lang['Prune__commands']
*	 0.9.4. - added prune "avarage posts prune
*	 0.9.5. - now support own language file, the complete mod, require litle change in existing files
*	 0.9.6. - change the javascript name, in the template file
*      1.0.0. - considered as final, included a limit about how meny users max can be deleted at once
*      1.0.1. - fixed a HTML tag, in the admin URL
*      1.0.2. - moved to users section in ACP
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
define('MODULE_ID', 20);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Users']['Prune_users'] = $filename;
	return;
}
//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = "../";
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_prune_users.' . $phpEx);

$sql = array();
$default = $default2 = $days2 = array();


// ********************************************************************************
// from here you can define you own delete creterias, if you makes more, then you shall also
// edit the files lang_main.php, and the file delete_users.php, so they hold the same amount
// of options

//
// Initial selection
//

// find zero posters
$sql[0] = ' AND user_posts < 1';
$default[0] = 60;
$default2[0] = '';

// find users who have newer logged in
$sql[1] = ' AND user_lastvisit < 1';
$default[1] = 60;
$default2[1] = '';

// find not activated users
$sql[2] = ' AND user_lastvisit < 1 AND user_active = 0';
$default[2] = 60;
$default2[2] = '';

// find users not visited since xx days
if ( $HTTP_GET_VARS['days2_3'] || $HTTP_POST_VARS['days2_3'] )
{
	$days2[3] = ($HTTP_GET_VARS['days2_3']) ? intval($HTTP_GET_VARS['days2_3']) : intval($HTTP_POST_VARS['days2_3']);
}
else
{
	$days2[3] = 60;
}
$default2[3] = 60;
$sql[3] = ' AND user_lastvisit < ' . ( CR_TIME - 86400 * $days2[3]);
$default[3] = 180;

// 
// Users with less than 1 posts per xx days avg. 
// 
if ( $HTTP_GET_VARS['days2_4'] || $HTTP_POST_VARS['days2_4'] )
{
	$days2[4] = ($HTTP_GET_VARS['days2_4']) ? intval($HTTP_GET_VARS['days2_4']) : intval($HTTP_POST_VARS['days2_4']);
}
else
{
	$days2[4] = 14;
}
$default2[4] = 14;
$sql[4] = " AND (user_posts/((user_lastvisit - user_regdate)/" . ($days2[4] * 86400) . ")) < 1"; 
$default[4] = 60;

// find not long time logged in and no posts
if ( $HTTP_GET_VARS['days2_5'] || $HTTP_POST_VARS['days2_5'] )
{
	$days2[5] = ($HTTP_GET_VARS['days2_5']) ? intval($HTTP_GET_VARS['days2_5']) : intval($HTTP_POST_VARS['days2_5']);
}
else
{
	$days2[5] = 60;
}
$sql[5] = ' AND user_lastvisit > 1 AND user_posts < 1 AND user_lastvisit < ' . ( CR_TIME - 86400 * $days2[5]);
$default[5] = 180;
$default2[5] = 60;

// ********************************************************************************
// ****************** Do not change any thing below *******************************

$options = '<option value="1">&nbsp;'.$lang['1_Day'].'</option>
	<option value="2">&nbsp;2 '.$lang['Days'].'</option>
	<option value="3">&nbsp;3 '.$lang['Days'].'</option>
	<option value="4">&nbsp;4 '.$lang['Days'].'</option>
	<option value="5">&nbsp;5 '.$lang['Days'].'</option>
	<option value="6">&nbsp;6 '.$lang['Days'].'</option>
	<option value="7">&nbsp;'.$lang['7_Days'].'</option>
	<option value="14">&nbsp;'.$lang['2_Weeks'].'</option>
	<option value="21">&nbsp;'.sprintf($lang['X_Weeks'],3).'</option>
	<option value="30">&nbsp;'.$lang['1_Month'].'</option>
	<option value="60">&nbsp;'.sprintf($lang['X_Months'],2).'</option>
	<option value="90">&nbsp;'.$lang['3_Months'].'</option>
	<option value="180">&nbsp;'.$lang['6_Months'].'</option>
	<option value="365">&nbsp;'.$lang['1_Year'].'</option>
  	</select><br />';
//
// Generate page
//

include('page_header_admin.'.$phpEx);
$template->set_filenames(array("body" => "admin/prune_users_body.tpl"));
$n=0;
while ( !empty($sql[$n]) )
{
	$vars='days_'.$n;
	$vars2='days2_'.$n;
	
	$default[$n] = ($default[$n]) ? $default[$n] : 10;

	$days[$n] = ( isset($HTTP_GET_VARS[$vars]) ) ? intval($HTTP_GET_VARS[$vars]) : (( isset($HTTP_POST_VARS[$vars]) ) ? intval($HTTP_POST_VARS[$vars]) : $default[$n]);
	$days2[$n] = ( isset($HTTP_GET_VARS[$vars2]) ) ? intval($HTTP_GET_VARS[$vars2]) : (( isset($HTTP_POST_VARS[$vars2]) ) ? intval($HTTP_POST_VARS[$vars2]) : $default2[$n]);

	// make a extra option if the parsed days value does not already exisit
	if (!strpos($options,"value=\"".$days[$n]))
	{
		$options = '<option value="'.$days[$n].'">&nbsp;'.sprintf($lang['X_Days'],$days[$n]).'</option>'.$options;
	}
	$select[$n] = '<select name="days_'.$n.'" size="1" onchange="SetDays();" class="gensmall">
		'.str_replace("value=\"".$days[$n]."\">&nbsp;", "value=\"".$days[$n]."\" selected=\"selected\">&nbsp;*" ,$options);

	if ( $default2[$n] )
	{
		if (!strpos($options,"value=\"".$days2[$n]))
		{
			$options = '<option value="'.$days2[$n].'">&nbsp;'.sprintf($lang['X_Days'],$days2[$n]).'</option>'.$options;
		}
		$select2[$n] = '<select name="days2_'.$n.'" size="1" onchange="SetDays();" class="gensmall">
			'.str_replace("value=\"".$days2[$n]."\">&nbsp;", "value=\"".$days2[$n]."\" selected=\"selected\">&nbsp;*" ,$options);
	}

	$body_sql = "FROM " . USERS_TABLE . "
		WHERE user_id <> " . ANONYMOUS . "
			AND user_level = 0
			AND user_jr = 0
			" . $sql[$n] . "
			AND user_regdate < " . (CR_TIME - (86400 * $days[$n]));

	$cur_sql = "SELECT user_id, username 
		$body_sql
		ORDER BY username LIMIT 200";

	if(!($result = $db->sql_query($cur_sql)))
	{
		message_die(GENERAL_ERROR, 'Error obtaining userdata '.$sql[$n], '', __LINE__, __FILE__, $cur_sql);
	}

	$user_list = $db->sql_fetchrowset($result);
	$user_count=count($user_list);
	$db->sql_freeresult($result);
	if ( $user_count > 199 )
	{
		if(!($result = $db->sql_query("SELECT COUNT(*) as total $body_sql")))
		{
			message_die(GENERAL_ERROR, 'Error obtaining userdata '.$sql[$n], '', __LINE__, __FILE__, $cur_sql . 'LIMIT 200');
		}
		$tusers = $db->sql_fetchrow($result);
		$total_users = $tusers['total'];
	}
	else $total_users = '';
	for($i = 0; $i < $user_count; $i++) 
	{
		$list[$n] .= ' <a href="' . append_sid($phpbb_root_path."profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $user_list[$i]['user_id']) . '">' . $user_list[$i]['username'] . '</a>'; 
	}

	$template->assign_block_vars('prune_list', array(
		"LIST" => ($list[$n]) ? $list[$n] : $lang['None'],
		"USER_COUNT" => $user_count,
		"L_PRUNE" => $lang['Prune_commands'][$n],
		"L_PRUNE_EXPLAIN" => sprintf($lang['Prune_explain'][$n], $days2[$n], $days[$n]) . '<br><span class="gensmall">',
		"S_PRUNE_USERS" => append_sid("admin_prune_users.$phpEx"),
		"TOTAL_USERS" => ($total_users) ? ' / (' . $total_users . ')' : '',
		"S_DAYS" => $select[$n],
		"S_DAYS2" => $select2[$n],
		"U_PRUNE" => '<a href="' . append_sid($phpbb_root_path . 'admin/admin_delete_users.php?mode=prune_' . $n . '&amp;days=' . $days[$n]) . (($days2[$n]) ? '&amp;days2=' . $days2[$n] : '') . '&amp;user_count=' . $user_count . '">' . $lang['Prune_commands'][$n] . '</a>')
	);
	$n++;
	$select2[$n] = '';
}

$template->assign_vars(array(
	"L_PRUNE_ACTION" => $lang['Prune_Action'],
	"L_PRUNE_LIST" =>	$lang['Prune_user_list'],
	"L_DAYS" => $lang['Days'],
	"L_PRUNE_USERS" => $lang['Prune_users'],
	"L_PRUNE_USERS_EXPLAIN" => $lang['Prune_users_explain'],
));

$template->pparse('body');
include('page_footer_admin.'.$phpEx);

?>