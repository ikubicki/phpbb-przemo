<?php
/***************************************************************************
 *              admin_shoutbox.php
 *              -------------------
 *  begin       : Friday, Jul 12, 2003
 *  copyright   : (C) 2003 Przemo ( http://www.przemo.org/phpBB2/ )
 *  email       : przemo@przemo.org
 *  version     : 1.12.0
 *
 ***************************************************************************/
define('MODULE_ID', 4);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['ShoutBox'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

// Pull all config data
if(empty($shoutbox_config))
{
    $sql = "SELECT * FROM " . SHOUTBOX_CONFIG_TABLE;
    if(!$result = $db->sql_query($sql))
    {
        message_die(CRITICAL_ERROR, "Could not query shoutbox config information", "", __LINE__, __FILE__, $sql);
    }
    while( $row = $db->sql_fetchrow($result) )
    {
         $shoutbox_config[$row['config_name']] = $row['config_value'];
    }
        
}

$clear_cache = false;
foreach( $shoutbox_config as $config_name => $config_value )
{
    $new[$config_name] = get_vars($config_name, $config_value, 'POST', false, 1);

    if( isset($HTTP_POST_VARS['submit']) )
    {
        if ($config_name == 'sb_group_sel' && is_array($new[$config_name]) )
        {
            $new[$config_name] = implode(",", $new[$config_name]);
        }

        $new_value = str_replace("\'", "''", $new[$config_name]);
        if($new_value != $config_value)
        {
            $sql = "UPDATE " . SHOUTBOX_CONFIG_TABLE . " SET
			config_value = '" . $new_value . "'
			WHERE config_name = '$config_name'";
            if( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, "Failed to update shoutbox configuration for $config_name", "", __LINE__, __FILE__, $sql);
            }
            $clear_cache = true;
        }
    }
}

if ( $clear_cache )
{
    sql_cache('clear', 'shoutbox_config');
}

if( isset($HTTP_POST_VARS['submit']) )
{
    $message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_shoutbox.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
    message_die(GENERAL_MESSAGE, $message);
}

$shoutbox_on_yes = ( $new['shoutbox_on'] ) ? "checked=\"checked\"" : "";
$shoutbox_on_no = ( !$new['shoutbox_on'] ) ? "checked=\"checked\"" : "";

$date_on_yes = ( $new['date_on'] ) ? "checked=\"checked\"" : "";
$date_on_no = ( !$new['date_on'] ) ? "checked=\"checked\"" : "";

$make_links_yes = ( $new['make_links'] ) ? "checked=\"checked\"" : "";
$make_links_no = ( !$new['make_links'] ) ? "checked=\"checked\"" : "";

$links_names_yes = ( $new['links_names'] ) ? "checked=\"checked\"" : "";
$links_names_no = ( !$new['links_names'] ) ? "checked=\"checked\"" : "";

$allow_smilies_yes = ( $new['allow_smilies'] ) ? "checked=\"checked\"" : "";
$allow_smilies_no = ( !$new['allow_smilies'] ) ? "checked=\"checked\"" : "";

$allow_bbcode_yes = ( $new['allow_bbcode'] ) ? "checked=\"checked\"" : "";
$allow_bbcode_no = ( !$new['allow_bbcode'] ) ? "checked=\"checked\"" : "";

$allow_edit_yes = ( $new['allow_edit'] ) ? "checked=\"checked\"" : "";
$allow_edit_no = ( !$new['allow_edit'] ) ? "checked=\"checked\"" : "";

$allow_edit_m_yes = ( $new['allow_edit_m'] ) ? "checked=\"checked\"" : "";
$allow_edit_m_no = ( !$new['allow_edit_m'] ) ? "checked=\"checked\"" : "";

$allow_edit_all_yes = ( $new['allow_edit_all'] ) ? "checked=\"checked\"" : "";
$allow_edit_all_no = ( !$new['allow_edit_all'] ) ? "checked=\"checked\"" : "";

$allow_delete_yes = ( $new['allow_delete'] ) ? "checked=\"checked\"" : "";
$allow_delete_no = ( !$new['allow_delete'] ) ? "checked=\"checked\"" : "";

$allow_delete_m_yes = ( $new['allow_delete_m'] ) ? "checked=\"checked\"" : "";
$allow_delete_m_no = ( !$new['allow_delete_m'] ) ? "checked=\"checked\"" : "";

$allow_delete_all_yes = ( $new['allow_delete_all'] ) ? "checked=\"checked\"" : "";
$allow_delete_all_no = ( !$new['allow_delete_all'] ) ? "checked=\"checked\"" : "";

$allow_guest_yes = ( $new['allow_guest'] ) ? "checked=\"checked\"" : "";
$allow_guest_no = ( !$new['allow_guest'] ) ? "checked=\"checked\"" : "";

$allow_guest_view_yes = ( $new['allow_guest_view'] ) ? "checked=\"checked\"" : "";
$allow_guest_view_no = ( !$new['allow_guest_view'] ) ? "checked=\"checked\"" : "";

$allow_users_yes = ( $new['allow_users'] ) ? "checked=\"checked\"" : "";
$allow_users_no = ( !$new['allow_users'] ) ? "checked=\"checked\"" : "";

$allow_users_view_yes = ( $new['allow_users_view'] ) ? "checked=\"checked\"" : "";
$allow_users_view_no = ( !$new['allow_users_view'] ) ? "checked=\"checked\"" : "";

$usercall_yes = ( $new['usercall'] ) ? "checked=\"checked\"" : "";
$usercall_no = ( !$new['usercall'] ) ? "checked=\"checked\"" : "";

$shoutbox_smilies_yes = ( $new['shoutbox_smilies'] ) ? "checked=\"checked\"" : "";
$shoutbox_smilies_no = ( !$new['shoutbox_smilies'] ) ? "checked=\"checked\"" : "";

$select_list  = '';
$select_list2 = '';


$sql = 'SELECT group_id, group_name
	FROM ' . GROUPS_TABLE . '
	WHERE group_single_user <> ' . TRUE . '
	ORDER BY group_name';
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain group list', '', __LINE__, __FILE__, $sql);
}
$fid = explode(',',$new['sb_group_sel']);
if ( in_array('all', $fid) )
{ 
	$select_list2 = '<option selected="selected" value="all">Wszyscy / ALL</option>'; 
}
else
{
	$select_list2 = '<option value="all">Wszyscy / ALL</option>'; 
}
while ($row = $db->sql_fetchrow($result))
{
	if ( in_array($row['group_id'], $fid) )
	{ 
		$select_list .= '<option selected="selected" value="' . $row['group_id'] . '">' . strip_tags($row['group_name']) . '</option>'; 
	} 
	else
	{
		$select_list .= '<option value="' . $row['group_id'] . '">' . strip_tags($row['group_name']) . '</option>';
	}
}

$template->set_filenames(array(
	"body" => "admin/shoutbox_config_body.tpl")
);

$template->assign_vars(array(
	'SHOUTBOX_ON_YES' => $shoutbox_on_yes,
	'SHOUTBOX_ON_NO' => $shoutbox_on_no,
	'DATE_ON_YES' => $date_on_yes,
	'DATE_ON_NO' => $date_on_no,
	'MAKE_LINKS_YES' => $make_links_yes,
	'MAKE_LINKS_NO' => $make_links_no,
	'LINKS_NAMES_YES' => $links_names_yes,
	'LINKS_NAMES_NO' => $links_names_no,
	'ALLOW_SMILIES_YES' => $allow_smilies_yes,
	'ALLOW_SMILIES_NO' => $allow_smilies_no,
	'ALLOW_BBCODE_YES' => $allow_bbcode_yes,
	'ALLOW_BBCODE_NO' => $allow_bbcode_no,
	'ALLOW_EDIT_YES' => $allow_edit_yes,
	'ALLOW_EDIT_NO' => $allow_edit_no,
	'ALLOW_EDIT_M_YES' => $allow_edit_m_yes,
	'ALLOW_EDIT_M_NO' => $allow_edit_m_no,
	'ALLOW_EDIT_ALL_YES' => $allow_edit_all_yes,
	'ALLOW_EDIT_ALL_NO' => $allow_edit_all_no,
	'ALLOW_DELETE_YES' => $allow_delete_yes,
	'ALLOW_DELETE_NO' => $allow_delete_no,
	'ALLOW_DELETE_M_YES' => $allow_delete_m_yes,
	'ALLOW_DELETE_M_NO' => $allow_delete_m_no,
	'ALLOW_DELETE_ALL_YES' => $allow_delete_all_yes,
	'ALLOW_DELETE_ALL_NO' => $allow_delete_all_no,
	'ALLOW_GUEST_YES' => $allow_guest_yes,
	'ALLOW_GUEST_NO' => $allow_guest_no,
	'ALLOW_GUEST_VIEW_YES' => $allow_guest_view_yes,
	'ALLOW_GUEST_VIEW_NO' => $allow_guest_view_no,
	'ALLOW_USERS_YES' => $allow_users_yes,
	'ALLOW_USERS_NO' => $allow_users_no,
	'ALLOW_USERS_VIEW_YES' => $allow_users_view_yes,
	'ALLOW_USERS_VIEW_NO' => $allow_users_view_no,
	'USERCALL_YES' => $usercall_yes,
	'USERCALL_NO' => $usercall_no,
	'SMILIES_YES' => $shoutbox_smilies_yes,
	'SMILIES_NO' => $shoutbox_smilies_no,
	'L_SMILIES' => $lang['sb_smilies'],
	'L_USERCALL' => $lang['l_usercall'],
	'COUNT_MSG' => $new['count_msg'],
	'TEXT_LENGHT' => $new['text_lenght'],
	'WORD_LENGHT' => $new['word_lenght'],
	'DATE_FORMAT' => $new['date_format'],
	'SHOUT_WIDTH' => $new['shout_width'],
	'SHOUT_HEIGHT' => $new['shout_height'],
	'BANNED_USER_ID' => $new['banned_user_id'],
	'BANNED_USER_ID_VIEW' => $new['banned_user_id_view'],
	'DELETE_DAYS' => $new['delete_days'],
	'SHOUT_REFRESH' => $new['shout_refresh'],
	'SB_SHOUT_REFRESH' => $lang['sb_shout_refresh'],
	'S_CONFIG_ACTION' => append_sid("admin_shoutbox.$phpEx"),
	'L_DELETE_DAYS' => $lang['delete_days'],
	'L_SHOUTBOX_ON' => $lang['shoutbox_on'],
	'L_DATE_ON' => $lang['date_on'],
	'L_ALLOW_SMILIES' => $lang['Allow_smilies'],
	'L_ALLOW_BBCODE' => $lang['Allow_BBCode'],
	'L_DATE_FORMAT' => $lang['Date_format'],
	'L_SHOUT_SIZE' => $lang['shout_size'],
	'L_MAKE_LINKS' => $lang['sb_make_links'],
	'L_LINKS_NAMES' => $lang['sb_links_names'],
	'L_ALLOW_EDIT' => $lang['sb_allow_edit'],
	'L_ALLOW_EDIT_M' => $lang['sb_allow_edit_m'],
	'L_ALLOW_EDIT_ALL' => $lang['sb_allow_edit_all'],
	'L_ALLOW_DELETE' => $lang['sb_allow_delete'],
	'L_ALLOW_DELETE_M' => $lang['sb_allow_delete_m'],
	'L_ALLOW_DELETE_ALL' => $lang['sb_allow_delete_all'],
	'L_ALLOW_GUEST' => $lang['sb_allow_guest'],
	'L_ALLOW_GUEST_VIEW' => $lang['sb_allow_guest_view'],
	'L_ALLOW_USERS' => $lang['sb_allow_users'],
	'L_ALLOW_USERS_VIEW' => $lang['sb_allow_users_view'],
	'L_COUNT_MSG' => $lang['sb_count_msg'],
	'L_TEXT_LENGHT' => $lang['sb_text_lenght'],
	'L_WORD_LENGHT' => $lang['sb_word_lenght'],
	'L_BANNED_USER_ID' => $lang['sb_banned_send'],
	'L_BANNED_USER_ID_E' => $lang['sb_banned_send_e'],
	'L_BANNED_USER_ID_VIEW' => $lang['sb_banned_view'],
	'L_BANNED_USER_ID_VIEW_E' => $lang['sb_banned_view_e'],
	'L_GROUP_SEL_O' => $lang['sb_shout_group'],
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_SETUP_SHOUTBOX' => $lang['setup_shoutbox'],

	'L_GROUP_SELECT' => $lang['Select_group'],
	'S_GROUP_SELECT' => $select_list2 . $select_list,
		
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'])
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>