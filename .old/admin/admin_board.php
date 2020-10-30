<?php
/***************************************************************************
 *                              admin_board.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/10/11 14:40
 *
 *   $Id: admin_board.php,v 1.51.2.11 2005/10/30 15:17:13 acydburn Exp $
 *
 *
 ***************************************************************************/

if ( @$_GET['mode'] == 'warnings' || @$_POST['mode'] == 'warnings' )
{
	define('MODULE_ID', 3);
}
else
{
	define('MODULE_ID', 1);
}

define('IN_PHPBB', 1);

if ( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Configuration'] = "$file?mode=config";
	$module['Users']['Warnings'] = "$file?mode=warnings";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_board.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_customize.' . $phpEx);

include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

$checked = 'checked="checked"';

$mode = get_vars('mode', '', 'GET,POST');

// Pull all config data
$new         = array();
$clear_cache = false;
$board_config = sql_cache('check', 'board_config');
if(empty($board_config)) {
    $sql = "SELECT * FROM " . CONFIG_TABLE;
    $result = $db->sql_query($sql) or message_die(CRITICAL_ERROR, "CONFIG TABLE ERROR", "", __LINE__, __FILE__, $sql);
    while($row = $db->sql_fetchrow($result)) $board_config[$row['config_name']] = $row['config_value'];
    $sql_work = sql_cache('write', 'board_config', $board_config);
}

$disallowed  = array('ban_warnings', 'write_warnings', 'warnings_mods_public', 'warnings_enable', 'mod_warnings', 'mod_edit_warnings', 'expire_warnings', 'mod_value_warning');
foreach($board_config as $config_name => $config_value)
{
    if( in_array($config_name, $disallowed) ) continue;

    $new[$config_name] = $config_value;

    if ( $config_name == 'cookie_name' )
    {
        $cookie_name = str_replace('.', '_', $new['cookie_name']);
    }

    if ( isset($HTTP_POST_VARS['submit']) )
    {
        $new[$config_name] = get_vars( $config_name, str_replace(array("'", "\\"), array("''", "\\\\"), $config_value), 'POST', false, 1);

        if ( $config_name == 'server_name' && preg_match('/(.*):\/\//', $new[$config_name],$par) )
        {
            message_die(GENERAL_MESSAGE, sprintf($lang['wrong_config_parametr'],$par[0]));
        }

        if ( $config_name == 'disable_type' )
        {
            if ( count($new[$config_name]) > 1 )
            {
                if ( $new[$config_name][0] == 2 && $new[$config_name][1] == 3 ){
                    $new[$config_name] = 4;
                }
                if ( $new[$config_name][0] == 1 ){
                    $new[$config_name] = 1;
                }
            }
            else if ( isset($HTTP_POST_VARS['board_disable']) )
            {
                $new[$config_name] = (isset($HTTP_POST_VARS['disable_type'])) ? $new[$config_name][0] : '';
            }
        }

        $sql_config_value = (isset($HTTP_POST_VARS[$config_name])) ? str_replace("\'", "''", $new[$config_name]) : $new[$config_name];

        if ( $config_name == 'sitename' || $config_name == 'board_disable' )
        {
            $sql_config_value = strip_tags($sql_config_value);
        }

        if($sql_config_value != $config_value)
        {
            $sql = "UPDATE " . CONFIG_TABLE . " SET
			config_value = '".$sql_config_value."'
			WHERE config_name = '$config_name'";

            if ( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, 'Failed to update general configuration for ' . $config_name, '', __LINE__, __FILE__, $sql);
            }
            $clear_cache = true;
        }
    }

    $new[$config_name] = xhtmlspecialchars($new[$config_name]);
}
if ( $clear_cache )
{
    sql_cache('clear', 'board_config');
}

if ( isset($HTTP_POST_VARS['submit']) )
{
    $message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_board.$phpEx?mode=$mode") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
    message_die(GENERAL_MESSAGE, $message);
}

$template->assign_vars(array(
	'S_CONFIG_ACTION' => append_sid("admin_board.$phpEx"),
	'L_EMAIL_RESULT' => (function_exists('mail')) ? $lang['Yes'] : $lang['No'],
	'L_ENABLED' => $lang['Enabled'],
	'L_DISABLED' => $lang['Disabled'],
	'L_CONFIGURATION_TITLE' => $lang['General_Config'],
	'L_GENERAL_SETTINGS' => $lang['General_settings'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],
	'L_CONFIG' => $lang['conf_config'],
	'L_ADDONS' => $lang['conf_addons'],
	'L_MAIN_PAGE' => $lang['conf_main_page'],
	'L_ADDON_MAIN_PAGE' => $lang['l_addon_main_page'],
	'L_ADDON_MAIN' => $lang['l_addon_main'],
	'L_VIEWTOPIC' => $lang['conf_viewtopic'],
	'L_PROFILE' => $lang['conf_profile'],
	'L_ADDON_PROFILE' => $lang['l_addon_profile'],
	'L_POSTING' => $lang['conf_posting'],
	'L_ADDON_POSTING' => $lang['l_addon_posting'],
	'L_ADDON_VIEWTOPIC' => $lang['l_addon_viewtopic'],
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'])
);

if ( $mode == 'config' || $mode == '' )
{
	$template->set_filenames(array(
		'body' => 'admin/board_config_body.tpl')
	);

	$public_directories = '<option value="0">--</option>';
	array_unshift($lang['Public_categories'], '');
	for($i = 1; $i < count($lang['Public_categories']); $i++)
	{
		$public_directories .= '<option value="' . $i . '"' . (($new['public_category'] == $i) ? ' selected="selected"' : '') . '>' . $lang['Public_categories'][$i] . '</option>';
	}

	$template->assign_vars(array(
		'L_SERVER_NAME' => $lang['Server_name'],
		'L_SERVER_PORT' => $lang['Server_port'],
		'L_SERVER_PORT_EXPLAIN' => $lang['Server_port_explain'],
		'L_CHECK_ADDRESS' => $lang['check_address'],
		'L_CHECK_ADDRESS_E' => $lang['check_address_e'],
		'L_SCRIPT_PATH' => $lang['Script_path'],
		'L_SCRIPT_PATH_EXPLAIN' => $lang['Script_path_explain'],
		'L_SITE_NAME' => $lang['Site_name'],
		'L_COLOR' => $lang['Font_color'],
		'L_SITE_DESCRIPTION' => $lang['Site_desc'],
		'L_DISABLE_BOARD' => $lang['Deactivate'],
		'L_DISABLE_BOARD_EXPLAIN' => $lang['Board_disable_explain'],
		'L_NONE' => $lang['None'],
		'L_USER' => $lang['Username'],
		'L_ADMIN' => $lang['Acc_Admin'],
		'L_ACCT_ACTIVATION' => $lang['Acct_activation'],
		'L_FLOOD_INTERVAL' => $lang['Flood_Interval'],
		'L_FLOOD_INTERVAL_EXPLAIN' => $lang['Flood_Interval_explain'],
		'L_TOPICS_PER_PAGE' => $lang['Topics_per_page'],
		'L_POSTS_PER_PAGE' => $lang['Posts_per_page'],
		'L_HOT_THRESHOLD' => $lang['Hot_threshold'],
		'L_DEFAULT_STYLE' => $lang['Default_style'],
		'L_OVERRIDE_STYLE' => $lang['Override_style'],
		'L_OVERRIDE_STYLE_EXPLAIN' => $lang['Override_style_explain'],
		'L_DEFAULT_LANGUAGE' => $lang['Default_language'],
		'L_SEARCH_KEYWORDS_MAX' => $lang['search_keywords_max'],
		'L_DATE_FORMAT' => $lang['Date_format'],
		'L_SYSTEM_TIMEZONE' => $lang['System_timezone'],
		'L_AUTO_DATE' => $lang['auto_date'],
		'L_ENABLE_GZIP' => $lang['Enable_gzip'],
		'L_COOKIE_SETTINGS' => $lang['Cookie_settings'],
		'L_COOKIE_SETTINGS_EXPLAIN' => $lang['Cookie_settings_explain'],
		'L_COOKIE_NAME' => $lang['Cookie_name'],
		'L_COOKIE_PATH' => $lang['Cookie_path'],
		'L_COOKIE_SECURE' => $lang['Cookie_secure'],
		'L_COOKIE_SECURE_EXPLAIN' => $lang['Cookie_secure_explain'],
		'L_SESSION_LENGTH' => $lang['Session_length'],
		'L_SESSION_LENGTH_E' => $lang['Session_length_e'],
		'L_PRIVATE_MESSAGING' => $lang['Private_Messaging'],
		'L_DISABLE_PRIVATE_MESSAGING' => $lang['Disable_privmsg'],
		'L_INBOX_LIMIT' => $lang['Inbox_limits'],
		'L_SENTBOX_LIMIT' => $lang['Sentbox_limits'],
		'L_SAVEBOX_LIMIT' => $lang['Savebox_limits'],
		'L_COPPA_SETTINGS' => $lang['COPPA_settings'],
		'L_COPPA_FAX' => $lang['COPPA_fax'],
		'L_COPPA_MAIL' => $lang['COPPA_mail'],
		'L_COPPA_MAIL_EXPLAIN' => $lang['COPPA_mail_explain'],
		'L_EMAIL_SETTINGS' => $lang['Email_settings'],
		'L_BOARD_EMAIL_FORM' => $lang['Board_email_form'],
		'L_BOARD_EMAIL_FORM_EXPLAIN' => $lang['Board_email_form_explain'],
		'L_BOARD_EMAIL_CHECK' => $lang['f_mail'],
		'L_ADMIN_EMAIL' => $lang['Admin_email'],
		'L_EMAIL_RETURN_PATH' => $lang['email_return_path'],
		'L_EMAIL_FROM' => $lang['email_from'],
		'L_EMAIL_SIG' => $lang['Email_sig'],
		'L_EMAIL_SIG_EXPLAIN' => $lang['Email_sig_explain'],
		'L_USE_SMTP' => $lang['Use_SMTP'],
		'L_USE_SMTP_EXPLAIN' => $lang['Use_SMTP_explain'],
		'L_SMTP_SERVER' => $lang['SMTP_server'],
		'L_SMTP_USERNAME' => $lang['SMTP_username'],
		'L_SMTP_USERNAME_EXPLAIN' => $lang['SMTP_username_explain'],
		'L_SMTP_PASSWORD' => $lang['SMTP_password'],
		'L_SMTP_PASSWORD_EXPLAIN' => $lang['SMTP_password_explain'],
		'L_ALLOW_AUTOLOGIN' => $lang['Allow_autologin'],
		'L_ALLOW_AUTOLOGIN_EXPLAIN' => $lang['Allow_autologin_explain'],
		'L_AA_NO_LIMIT' => $lang['AA_no_limit'],
		'L_AA_WITH_IP' => $lang['AA_with_IP'],
		'L_AA_WITH_STAFF_IP' => $lang['AA_with_staff_IP'],
		'L_DISABLE_FORUM' => $lang['Forum'],
		'L_DISABLE_POSTING' => $lang['Posting'],
		'L_DISABLE_REGISTERING' => $lang['Registering'],
		'L_PUBLIC_DIRECTORY' => $lang['Public_category'],

		'PUBLIC_DIRECTORIES' => $public_directories,
		'SERVER_PORT' => $new['server_port'],
		'SCRIPT_PATH' => $new['script_path'],
		'SERVER_NAME' => $new['server_name'],
		'CHECK_ADDRESS_YES' => ($new['check_address']) ? $checked : '',
		'CHECK_ADDRESS_NO' => (!$new['check_address']) ? $checked : '',
		'SITENAME' => $new['sitename'],
		'SITE_DESCRIPTION' => $new['site_desc'],
		'DESC_COLOR' => $new['desc_color'],
		'NAME_COLOR' => $new['name_color'],
		'FLOOD_INTERVAL' => $new['flood_interval'],
		'TOPICS_PER_PAGE' => $new['topics_per_page'],
		'POSTS_PER_PAGE' => $new['posts_per_page'],
		'SEARCH_KEYWORDS_MAX' => $new['search_keywords_max'],
		'HOT_TOPIC' => $new['hot_threshold'],
		'ACTIVATION_NONE' => USER_ACTIVATION_NONE,
		'ACTIVATION_NONE_CHECKED' => ($new['require_activation'] == USER_ACTIVATION_NONE ) ? $checked : '',
		'ACTIVATION_USER' => USER_ACTIVATION_SELF,
		'ACTIVATION_USER_CHECKED' => ($new['require_activation'] == USER_ACTIVATION_SELF ) ? $checked : '',
		'ACTIVATION_ADMIN' => USER_ACTIVATION_ADMIN,
		'ACTIVATION_ADMIN_CHECKED' => ($new['require_activation'] == USER_ACTIVATION_ADMIN ) ? $checked : '',
		'STYLE_SELECT' => style_select($new['default_style'], 'default_style', '../templates'),
		'OVERRIDE_STYLE_YES' => ($new['override_user_style']) ? $checked : '',
		'OVERRIDE_STYLE_NO' => (!$new['override_user_style']) ? $checked : '',
		'LANG_SELECT' => language_select($new['default_lang'], 'default_lang', 'language'),
		'DEFAULT_DATEFORMAT' => admin_date_format_select($new['default_dateformat'], $board_config['board_timezone']),
		'TIMEZONE_SELECT' => tz_select($new['board_timezone'], 'board_timezone'),
		'AUTO_DATE_YES' => ($new['auto_date']) ? $checked : '',
		'AUTO_DATE_NO' => (!$new['auto_date']) ? $checked : '',
		'GZIP_YES' => ($new['gzip_compress']) ? $checked : '',
		'GZIP_NO' => (!$new['gzip_compress']) ? $checked : '',
		'BOARD_DISABLE' => $new['board_disable'],
		'COOKIE_NAME' => $new['cookie_name'],
		'COOKIE_PATH' => $new['cookie_path'],
		'SESSION_LENGTH' => $new['session_length'],
		'S_COOKIE_SECURE_ENABLED' => ($new['cookie_secure']) ? $checked : '',
		'S_COOKIE_SECURE_DISABLED' => (!$new['cookie_secure']) ? $checked : '',
		'S_PRIVMSG_ENABLED' => (!$new['privmsg_disable']) ? $checked : '',
		'S_PRIVMSG_DISABLED' => ($new['privmsg_disable']) ? $checked : '',
		'INBOX_LIMIT' => $new['max_inbox_privmsgs'],
		'SENTBOX_LIMIT' => $new['max_sentbox_privmsgs'],
		'SAVEBOX_LIMIT' => $new['max_savebox_privmsgs'],
		'COPPA_MAIL' => $new['coppa_mail'],
		'COPPA_FAX' => $new['coppa_fax'],
		'BOARD_EMAIL_FORM_ENABLE' => ($new['board_email_form']) ? $checked : '',
		'BOARD_EMAIL_FORM_DISABLE' => (!$new['board_email_form']) ? $checked : '',
		'BOARD_EMAIL' => $new['board_email'],
		'EMAIL_SIG' => $new['board_email_sig'],
		'EMAIL_RETURN_PATH' => $new['email_return_path'],
		'EMAIL_FROM' => $new['email_from'],
		'SMTP_YES' => ($new['smtp_delivery']) ? $checked : '',
		'SMTP_NO' => (!$new['smtp_delivery']) ? $checked : '',
		'SMTP_HOST' => $new['smtp_host'],
		'SMTP_USERNAME' => $new['smtp_username'],
		'SMTP_PASSWORD' => $new['smtp_password'],
		'AA_CHECK_0' => (!$new['allow_autologin']) ? ' selected="selected"' : '',
		'AA_CHECK_1' => ($new['allow_autologin'] == 1) ? ' selected="selected"' : '',
		'AA_CHECK_2' => ($new['allow_autologin'] == 2) ? ' selected="selected"' : '',
		'AA_CHECK_3' => ($new['allow_autologin'] == 3) ? ' selected="selected"' : '',

		'DISABLE_TYPE_1' => ($new['disable_type'] == 1) ? $checked : '',
		'DISABLE_TYPE_2' => ($new['disable_type'] == 2 || $new['disable_type'] == 4) ? $checked : '',
		'DISABLE_TYPE_3' => ($new['disable_type'] == 3 || $new['disable_type'] == 4) ? $checked : '',

		'S_HIDDEN_FIELDS' => '<input type="hidden" name="mode" value="config">')
	);
}
else if ( $mode == 'addons' )
{
	$template->set_filenames(array(
		'body' => 'admin/board_config_body_addons.tpl')
	);

	$template->assign_vars(array(
		'L_READ_TRACKING_DAYS' => $lang['read_tracking_days'],
		'L_READ_TRACKING_DAYS_E' => $lang['read_tracking_days_e'],
		'L_READ_TRACKING_MAX_POSTS' => $lang['read_tracking_max_posts'],
		'L_READ_TRACKING_MAX_POSTS_E' => $lang['read_tracking_max_posts_e'],
		'L_READ_TRACKING_W_DAYS' => $lang['read_tracking_without_days'],
		'L_READ_TRACKING_W_DAYS_E' => $lang['read_tracking_without_days_e'],
		'L_READ_TRACKING_C' => $lang['read_tracking_c'],
		'L_READ_TRACKING_C_E' => $lang['read_tracking_c_e'],
		'L_MAX_POLL_OPTIONS' => $lang['Max_poll_options'],
		'L_CRESTRICT' => $lang['crestrict'],
		'L_CRESTRICT_E' => $lang['crestrict_e'],
		'L_HELPED' => $lang['helped_a'],
		'L_HELPED_E' => $lang['helped_e'],
		'L_LOGIN_REQUIRE' => $lang['login_require'],
		'L_LOGIN_REQUIRE_E' => $lang['login_require_e'],
		'L_ALLOW_NAME_CHANGE' => $lang['Allow_name_change'],
		'L_ALLOW_CUSTOM_COLOR' => $lang['Allow_custom_color'],
		'L_ALLOW_CUSTOM_COLOR_EXPLAIN' => $lang['Allow_custom_color_explain'],
		'L_ALLOW_CUSTOM_COLOR_VIEW' => $lang['l_allow_custom_color_view'],
		'L_ALLOW_CUSTOM_COLOR_VIEW_E' => $lang['l_allow_custom_color_view_e'],
		'L_ALLOW_CUSTOM_COLOR_MOD' => $lang['Allow_custom_color_mod'],
		'L_ALLOW_CUSTOM_COLOR_MOD_E' => $lang['Allow_custom_color_mod_e'],
		'L_ALLOW_CUSTOM_RANK_MOD' => $lang['Allow_custom_rank_mod'],
		'L_ALLOW_CUSTOM_RANK_MOD_E' => $lang['Allow_custom_rank_mod_e'],
		'L_ALLOW_CUSTOM_RANK' => $lang['Allow_custom_rank'],
		'L_ALLOW_CUSTOM_RANK_EXPLAIN' => $lang['Allow_custom_rank_explain'],
		'L_MAX_SIG_CUSTOM_RANK' => $lang['max_sig_custom_rank'],
		'L_DEL_EMAIL_NOT' => $lang['del_email_not'],
		'L_DEL_EMAIL_NOT_E' => $lang['del_email_not_e'],
		'L_META_REFRESH' => $lang['l_meta_refresh'],
		'L_META_REFRESH_E' => $lang['l_meta_refresh_e'],
		'L_META_KEYWORDS' => $lang['Meta_keywords'],
		'L_META_KEYWORDS_EXPLAIN' => $lang['Meta_keywords_explain'],
		'L_META_DESCRIPTION' => $lang['Meta_description'],
		'L_META_DESCRIPTION_EXPLAIN' => $lang['Meta_description_explain'],
		'L_SQL' => $lang['l_sql'],
		'L_SQL_E' => $lang['l_sql_e'],
		'L_ADDRESS_WHOIS' => $lang['l_address_whois'],
		'L_ADDRESS_WHOIS_E' => $lang['l_address_whois_e'],
		'L_CLOG' => $lang['clog'],
		'L_LOG_POST' => $lang['clog_post'],
		'L_CLOG_E' => $lang['clog_e'],
		'L_CLOAD' => $lang['cload'],
		'L_LLOAD' => $lang['lload'],
		'L_NOT_EDIT_ADMIN' => $lang['not_edit_admin'],
		'L_NOT_EDIT_ADMIN_E' => $lang['not_edit_admin_e'],
		'L_SHOW_BADWORDS' => $lang['show_badwords'],
		'L_IPVIEW' => $lang['ipview'],
		'L_GENERATE_TIME' => $lang['l_generate_time'],
		'L_GENTIME_ADMIN' => $lang['gentime_admin'],
		'L_SHOW_RULES' => $lang['show_rules'],
		'L_SHOW_RULES_E' => $lang['show_rules_e'],
		'L_RED_AFT_REG' => $lang['red_aft_reg'],
		'L_RED_AFT_REG_E' => $lang['red_aft_reg_e'],
		'L_RED_AFT_ADDRESS' => $lang['red_aft_address'],
		'L_RED_AFT_ADDRESS_E' => $lang['red_aft_address_e'],
		'L_RAR_TIME' => $lang['rar_time'],
		'L_RAR_TIME_E' => $lang['rar_time_e'],
		'L_USER_PASSWORD_SETTINGS' => $lang['user_password_settings'],
		'L_MAX_LOGIN_ERROR' => $lang['Max_login_error'],
		'L_MAX_LOGIN_ERROR_EXPLAIN' => $lang['Max_login_error_explain'],
		'L_BLOCK_TIME' => $lang['Block_time'],
		'L_BLOCK_TIME_EXPLAIN' => $lang['Block_time_explain'],
		'L_PASSWORD_COMPLEX' => $lang['Password_complex'],
		'L_PASSWORD_COMPLEX_EXPLAIN' => $lang['Password_complex_explain'],
		'L_PASSWORD_NOT_LOGIN' => $lang['Password_not_login'],
		'L_PASSWORD_NOT_LOGIN_EXPLAIN' => $lang['Password_not_login_explain'],
		'L_PASSWORD_LEN' => $lang['Password_len'],
		'L_PASSWORD_LEN_EXPLAIN' => $lang['Password_len_explain'],
		'L_MAX_SIG_CHARS_ADMIN_E' => $lang['max_sig_chars_admin_e'],
		'L_MAX_SIG_CHARS_MOD_E' => $lang['max_sig_chars_mod_e'],
		'L_SEARCH_ENABLE' => $lang['search_enable'],
		'L_SEARCH_ENABLE_E' => $lang['search_enable_e'],
		'L_OVERLIB' => $lang['overlib'],
		'L_GG_NR' => $lang['GG_nr'],
		'L_GG_PASS' => $lang['GG_pass'],
		'L_NOTIFY_GG' => $lang['notify_gg'],
		'L_NOTIFY_GG_E' => $lang['notify_gg_e'],
		'L_ADMIN_NOTIFY_GG' => $lang['admin_notify_gg'],
		'L_ADMIN_NOTIFY_GG_E' => $lang['admin_notify_gg_e'],
		'L_ADMIN_NOTIFY_REPLY' => $lang['admin_notify_reply'],
		'L_ADMIN_NOTIFY_REPLY_E' => $lang['admin_notify_reply_e'],
		'L_ADMIN_NOTIFY_MESSAGE' => $lang['admin_notify_message'],
		'L_ADMIN_NOTIFY_MESSAGE_E' => $lang['admin_notify_message_e'],
		'L_PROTECTION_GET' => $lang['protection_get'],
		'L_PROTECTION_GET_E' => $lang['protection_get_e'],
		'L_AUTOREPAIR_TABLES' => $lang['autorepair_tables'],
		'L_AUTOREPAIR_TABLES_E' => $lang['autorepair_tables_e'],
		'L_DEL_NOT_METHOD' => $lang['l_del_not_method'],
		'L_DEL_NOT_ENABLE' => $lang['l_del_not_enable'],
		'L_DEL_NOT_CHOICE' => $lang['l_del_not_choice'],
		'L_OPEN_IN_WINDOWS' => $lang['l_open_in_windows'],
		'L_OPEN_IN_WINDOWS_E' => $lang['l_open_in_windows_e'],
		'L_ONMOUSE' => $lang['onmouse'],
		'L_ANONYMOUS_SIMPLE' => $lang['anonymous_simple'],
		'L_ANONYMOUS_SIMPLE_E' => $lang['anonymous_simple_e'],

		'READ_TRACKING_CLEAR' => '<a href="' . append_sid("admin_board.$phpEx?mode=clear") . '">' . $lang['Reset'] . '</a>',
		'DAY_TO_PRUNE' => $new['day_to_prune'],
		'MAX_POSTS' => $new['rh_max_posts'],
		'WITHOUT_DAYS' => $new['rh_without_days'],
		'MAX_POLL_OPTIONS' => $new['max_poll_options'],
		'CRESTRICT_YES' => ($new['crestrict']) ? $checked : '',
		'CRESTRICT_NO' => (!$new['crestrict']) ? $checked : '',
		'HELPED_YES' => ($new['helped']) ? $checked : '',
		'HELPED_NO' => (!$new['helped']) ? $checked : '',
		'LOGIN_REQUIRE_YES' => ($new['login_require']) ? $checked : '',
		'LOGIN_REQUIRE_NO' => (!$new['login_require']) ? $checked : '',
		'NAMECHANGE_YES' => ($new['allow_namechange']) ? $checked : '',
		'NAMECHANGE_NO' => (!$new['allow_namechange']) ? $checked : '',
		'CUSTOM_COLOR_USE_YES' => ($new['custom_color_use']) ? $checked : '',
		'CUSTOM_COLOR_USE_NO' => (!$new['custom_color_use']) ? $checked : '',
		'CUSTOM_COLOR' => $new['allow_custom_color'],
		'CUSTOM_COLOR_VIEW_YES' => ($new['custom_color_view']) ? $checked : '',
		'CUSTOM_COLOR_VIEW_NO' => (!$new['custom_color_view']) ? $checked : '',
		'CUSTOM_COLOR_MOD_YES' => ($new['custom_color_mod']) ? $checked : '',
		'CUSTOM_COLOR_MOD_NO' => (!$new['custom_color_mod']) ? $checked : '',
		'CUSTOM_RANK' => $new['allow_custom_rank'],
		'CUSTOM_RANK_MOD_YES' => ($new['custom_rank_mod']) ? $checked : '',
		'CUSTOM_RANK_MOD_NO' => (!$new['custom_rank_mod']) ? $checked : '',
		'MAX_SIG_CUSTOM_RANK' => $new['max_sig_custom_rank'],
		'DEL_EMAIL_NOT_YES' => ($new['del_user_notify']) ? $checked : '',
		'DEL_EMAIL_NOT_NO' => (!$new['del_user_notify']) ? $checked : '',
		'SREFRESH' => $new['refresh'],
		'META_KEYWORDS' => $new['meta_keywords'],
		'META_DESCRIPTION' => $new['meta_description'],
		'SQL' => $new['sql'],
		'ADDRESS_WHOIS' => $new['address_whois'],
		'CLOG_POST' => ($new['clog'] == 2) ? $checked : '',
		'CLOG_YES' => ($new['clog'] == 1) ? $checked : '',
		'CLOG_NO' => (!$new['clog']) ? $checked : '',
		'CLOAD_YES' => ($new['cload']) ? $checked : '',
		'CLOAD_NO' => (!$new['cload']) ? $checked : '',
		'NOT_EDIT_ADMIN_YES' => ($new['not_edit_admin']) ? $checked : '',
		'NOT_EDIT_ADMIN_NO' => (!$new['not_edit_admin']) ? $checked : '',
		'SHOW_BADWORDS_YES' => ($new['show_badwords']) ? $checked : '',
		'SHOW_BADWORDS_NO' => (!$new['show_badwords']) ? $checked : '',
		'IPVIEW_YES' => ($new['ipview']) ? $checked : '',
		'IPVIEW_NO' => (!$new['ipview']) ? $checked : '',
		'GENERATE_TIME_YES' => ($new['generate_time']) ? $checked : '',
		'GENERATE_TIME_NO' => (!$new['generate_time']) ? $checked : '',
		'GENTIMEADMIN_YES' => ($new['generate_time_admin']) ? $checked : '',
		'GENTIMEADMIN_NO' => (!$new['generate_time_admin']) ? $checked : '',
		'SHOW_RULES_YES' => ($new['show_rules']) ? $checked : '',
		'SHOW_RULES_NO' => (!$new['show_rules']) ? $checked : '',
		'MAX_LOGIN_ERROR' => $new['max_login_error'],
		'MIN_PASSWORD_LEN' => $new['min_password_len'],
		'S_PASSWORD_COMPLEX_ENABLED' => ($new['force_complex_password']) ? $checked : '',
		'S_PASSWORD_COMPLEX_DISABLED' => (!$new['force_complex_password']) ? $checked : '',
		'S_PASSWORD_NOT_LOGIN_ENABLED' => ($new['password_not_login']) ? $checked : '',
		'S_PASSWORD_NOT_LOGIN_DISABLED' => (!$new['password_not_login']) ? $checked : '',
		'BLOCK_TIME' => $new['block_time'],
		'SEARCH_ENABLE_YES' => ($new['search_enable']) ? $checked : '',
		'SEARCH_ENABLE_NO' => (!$new['search_enable']) ? $checked : '',
		'OVERLIB_YES' => ($new['overlib']) ? $checked : '',
		'OVERLIB_NO' => (!$new['overlib']) ? $checked : '',
		'GG_PASS' => $new['haslo_gg'],
		'GG_NR' => $new['numer_gg'],
		'NOTIFY_GG_YES' => ($new['notify_gg']) ? $checked : '',
		'NOTIFY_GG_NO' => (!$new['notify_gg']) ? $checked : '',
		'ADMIN_NOTIFY_REPLY_YES' => ($new['admin_notify_reply']) ? $checked : '',
		'ADMIN_NOTIFY_REPLY_NO' => (!$new['admin_notify_reply']) ? $checked : '',
		'ADMIN_NOTIFY_MESSAGE_YES' => ($new['admin_notify_message']) ? $checked : '',
		'ADMIN_NOTIFY_MESSAGE_NO' => (!$new['admin_notify_message']) ? $checked : '',
		'PROTECTION_GET_YES' => ($new['protection_get']) ? $checked : '',
		'PROTECTION_GET_NO' => (!$new['protection_get']) ? $checked : '',
		'AUTOREPAIR_TABLES_YES' => ($new['autorepair_tables']) ? $checked : '',
		'AUTOREPAIR_TABLES_NO' => (!$new['autorepair_tables']) ? $checked : '',
		'DEL_NOT_METHOD_YES' => ($new['del_notify_method']) ? $checked : '',
		'DEL_NOT_METHOD_NO' => (!$new['del_notify_method']) ? $checked : '',
		'DEL_NOT_ENABLE_YES' => ($new['del_notify_enable']) ? $checked : '',
		'DEL_NOT_ENABLE_NO' => (!$new['del_notify_enable']) ? $checked : '',
		'DEL_NOT_CHOICE_YES' => ($new['del_notify_choice']) ? $checked : '',
		'DEL_NOT_CHOICE_NO' => (!$new['del_notify_choice']) ? $checked : '',
		'OPEN_IN_WINDOWS_YES' => ($new['open_in_windows']) ? $checked : '',
		'OPEN_IN_WINDOWS_NO' => (!$new['open_in_windows']) ? $checked : '',
		'ADMIN_NOTIFY_GG' => $new['admin_notify_gg'],
		'MAX_SIG_CHARS_ADMIN' => $new['max_sig_chars_admin'],
		'MAX_SIG_CHARS_MOD' => $new['max_sig_chars_mod'],
		'ANONYMOUS_SIMPLE_YES' => ($new['anonymous_simple']) ? $checked : '',
		'ANONYMOUS_SIMPLE_NO' => (!$new['anonymous_simple']) ? $checked : '',
		'ONMOUSE_YES' => ($new['onmouse']) ? $checked : '',
		'ONMOUSE_NO' => (!$new['onmouse']) ? $checked : '',


		'S_HIDDEN_FIELDS' => '<input type="hidden" name="mode" value="addons">')
	);
}
else if ( $mode == 'main_page' )
{
	$template->set_filenames(array(
		'body' => 'admin/board_config_body_main_page.tpl')
	);

	$template->assign_vars(array(
		'L_BANNER_TOP' => $lang['banner_top'],
		'L_BANNER_TOP_E' => $lang['banner_top_e'],
		'L_BANNER_BOTTOM' => $lang['banner_bottom'],
		'L_BANNER_BOTTOM_E' => $lang['banner_bottom_e'],
		'L_HEADER' => $lang['header'],
		'L_HEADER_E' => $lang['header_e'],
		'L_ENABLE_BOARD_MSG' => $lang['Enable_board_msg'],
		'L_BOARD_MSG_NONE' => $lang['None'],
		'L_BOARD_MSG_INDEX' => $lang['board_msg_index'],
		'L_BOARD_MSG_ALL' => $lang['board_msg_all'],
		'L_BOARD_MSG' => $lang['board_msg'],
		'L_BOARD_MSG_EXPLAIN' => $lang['board_msg_explain'],
		'L_WIDTH_FORUM' => $lang['width_forum'],
		'L_WIDTH_FORUM_E' => $lang['width_forum_e'],
		'L_WIDTH_TABLE' => $lang['width_table'],
		'L_WIDTH_COLOR' => $lang['width_color'],
		'L_CAVATAR' => $lang['cavatar'],
		'L_CAVATAR_E' => $lang['cavatar_e'],
		'L_CDOWNLOAD' => $lang['cdownload'],
		'L_CDOWNLOAD_E' => $lang['cdownload_e'],
		'L_CSTAT' => $lang['cstat'],
		'L_LSTAT' => $lang['lstat'],
		'L_CREGIST' => $lang['cregist'],
		'L_LREGIST' => $lang['lregist'],
		'L_CLOGIN_B' => $lang['clogin_b'],
		'L_CSTYLES' => $lang['cstyles'],
		'L_LSTYLES' => $lang['lstyles'],
		'L_CCOUNT' => $lang['ccount'],
		'L_LCOUNT' => $lang['lcount'],
		'L_U_O_T_D' => $lang['u_o_t_d'],
		'L_STAFF_ENABLE' => $lang['Staff'],
		'L_STAFF_FORUMS' => $lang['staff_forums'],
		'L_CLOG' => $lang['clog'],
		'L_CTOP' => $lang['ctop'],
		'L_LTOP' => $lang['ltop'],
		'L_LAST_VISITORS_TIME_E' => $lang['last_visitors_time_e'],
		'L_LAST_VISITORS_TIME_COUNT' => $lang['last_visitors_time_count'],
		'L_ECHANGE_BANNER' => $lang['echange_banner'],
		'L_ECHANGE_BANNER_E' => $lang['echange_banner_e'],
		'L_ECHANGE_BANNER_HTML' => $lang['echange_banner_html'],
		'L_USE_SUB_FORUM' => $lang['user_sub_forum'],
		'L_INDEX_PACKING' => $lang['Index_packing_explain'],
		'L_SPLIT_CAT' => $lang['user_split_cat'],
		'L_USE_LAST_TOPIC_TITLE' => $lang['user_last_topic_title'],
		'L_LAST_TOPIC_TITLE_LEN' => $lang['Last_topic_title_length'],
		'L_MEDIUM' => $lang['Medium'],
		'L_NONES' => $lang['NoneS'],
		'L_FULL' => $lang['Full'],
		'L_IGNORE_USER_SETTINGS' => $lang['Override_user_choices'],
		'L_SUB_LEVEL_LINKS' => $lang['user_sub_level_links'],
		'L_SUB_LEVEL_LINKS_E' => $lang['Sub_level_links_explain'],
		'L_WITH_PICS' => $lang['With_pics'],
		'L_DISPLAY_VIEWONLINE' => $lang['user_display_viewonline'],
		'L_NEVER' => $lang['Never'],
		'L_ROOT_ONLY' => $lang['Root_index_only'],
		'L_ALWAYS' => $lang['Always_in_category'],

		'SUB_FORUMS_1_CHECKED' => ($new['sub_forum'] == 1) ? $checked : '',
		'SUB_FORUMS_2_CHECKED' => ($new['sub_forum'] == 2) ? $checked : '',
		'SUB_FORUMS_0_CHECKED' => ($new['sub_forum'] == 0) ? $checked : '',
		'SF_OVER_NO' => (!$new['sub_forum_over']) ? $checked : '',
		'SF_OVER_YES' => ($new['sub_forum_over']) ? $checked : '',
		'SPLIT_CAT_YES' => ($new['split_cat']) ? $checked : '',
		'SPLIT_CAT_NO' => (!$new['split_cat']) ? $checked : '',
		'SC_OVER_YES' => ($new['split_cat_over']) ? $checked : '',
		'SC_OVER_NO' => (!$new['split_cat_over']) ? $checked : '',
		'LTT_YES' => ($new['last_topic_title']) ? $checked : '',
		'LTT_NO' => (!$new['last_topic_title']) ? $checked : '',
		'LTT_OVER_YES' => ($new['last_topic_title_over']) ? $checked : '',
		'LTT_OVER_NO' => (!$new['last_topic_title_over']) ? $checked : '',
		'LTT_LEN' => $new['last_topic_title_length'],
		'SLL_FORUMS_0_CHECKED' => ($new['sub_level_links'] == 0) ? $checked : '',
		'SLL_FORUMS_1_CHECKED' => ($new['sub_level_links'] == 1) ? $checked : '',
		'SLL_FORUMS_2_CHECKED' => ($new['sub_level_links'] == 2) ? $checked : '',
		'SLL_OVER_YES' => ($new['sub_level_links_over']) ? $checked : '',
		'SLL_OVER_NO' => (!$new['sub_level_links_over']) ? $checked : '',
		'DISPLAY_VO_0_CHECKED' => ($new['display_viewonline'] == 0) ? $checked : '',
		'DISPLAY_VO_1_CHECKED' => ($new['display_viewonline'] == 1) ? $checked : '',
		'DISPLAY_VO_2_CHECKED' => ($new['display_viewonline'] == 2) ? $checked : '',
		'DVO_YES' => ($new['display_viewonline_over']) ? $checked : '',
		'DVO_NO' => (!$new['display_viewonline_over']) ? $checked : '',

		'BANNER_TOP_ENABLE_YES' => ($new['banner_top_enable']) ? $checked : '',
		'BANNER_TOP_ENABLE_NO' => (!$new['banner_top_enable']) ? $checked : '',
		'BANNER_TOP' => $new['banner_top'],
		'BANNER_BOTTOM_ENABLE_YES' => ($new['banner_bottom_enable']) ? $checked : '',
		'BANNER_BOTTOM_ENABLE_NO' => (!$new['banner_bottom_enable']) ? $checked : '',
		'BANNER_BOTTOM' => $new['banner_bottom'],
		'HEADER_ENABLE_YES' => ($new['header_enable']) ? $checked : '',
		'HEADER_ENABLE_NO' => (!$new['header_enable']) ? $checked : '',
		'BOARD_MSG_NONE' => ($new['board_msg_enable'] == '0' ) ? $checked : '',
		'BOARD_MSG_INDEX' => ($new['board_msg_enable'] == '1') ? $checked : '',
		'BOARD_MSG_ALL' => ($new['board_msg_enable'] == '2') ? $checked : '',
		'BOARD_MSG' => $new['board_msg'],
		'WIDTH_FORUM_YES' => ($new['width_forum']) ? $checked : '',
		'WIDTH_FORUM_NO' => (!$new['width_forum']) ? $checked : '',
		'WIDTH_TABLE' => $new['width_table'],
		'WIDTH_COLOR1' => $new['width_color1'],
		'WIDTH_COLOR2' => $new['width_color2'],
		'TABLE_BORDER' => $new['table_border'],
		'CAVATAR_YES' => ($new['cavatar']) ? $checked : '',
		'CAVATAR_NO' => (!$new['cavatar']) ? $checked : '',
		'CDOWNLOAD_YES' => ($new['download']) ? $checked : '',
		'CDOWNLOAD_NO' => (!$new['download']) ? $checked : '',
		'CSTAT_YES' => ($new['cstat']) ? $checked : '',
		'CSTAT_NO' => (!$new['cstat']) ? $checked : '',
		'CREGIST_YES' => ($new['cregist']) ? $checked : '',
		'CREGIST_NO' => (!$new['cregist']) ? $checked : '',
		'CREGIST_B_YES' => ($new['cregist_b']) ? $checked : '',
		'CREGIST_B_NO' => (!$new['cregist_b']) ? $checked : '',
		'CSTYLES_YES' => ($new['cstyles']) ? $checked : '',
		'CSTYLES_NO' => (!$new['cstyles']) ? $checked : '',
		'CCOUNT_YES' => ($new['ccount']) ? $checked : '',
		'CCOUNT_NO' => (!$new['ccount']) ? $checked : '',
		'U_O_T_D_YES' => ($new['u_o_t_d']) ? $checked : '',
		'U_O_T_D_NO' => (!$new['u_o_t_d']) ? $checked : '',
		'STAFF_ENABLE_NO' => (!$new['staff_enable']) ? $checked : '',
		'STAFF_ENABLE_YES' => ($new['staff_enable']) ? $checked : '',
		'STAFF_FORUMS_NO' => (!$new['staff_forums']) ? $checked : '',
		'STAFF_FORUMS_YES' => ($new['staff_forums']) ? $checked : '',
		'CTOP_YES' => ($new['ctop']) ? $checked : '',
		'CTOP_NO' => (!$new['ctop']) ? $checked : '',
		'ECHANGE_BANNER' => $new['echange_banner'],
		'ECHANGE_BANNER_HTML' => $new['banners_list'],
		'LAST_VISITORS_TIME' => $new['last_visitors_time'],
		'LAST_VISITORS_TIME_COUNT' => $new['last_visitors_time_count'],
		'S_HIDDEN_FIELDS' => '<input type="hidden" name="mode" value="main_page">')
	);
}
else if ( $mode == 'viewtopic' )
{
	$template->set_filenames(array(
		'body' => 'admin/board_config_body_viewtopic.tpl')
	);

	$template->assign_vars(array(
		'L_CAGENT' => $lang['cagent'],
		'L_CAGENT_E' => $lang['cagente'],
		'L_CFRIEND' => $lang['s_email_friend'],
		'L_LFRIEND' => $lang['lfriend'],
		'L_LAGE' => $lang['lage'],
		'L_CJOIN' => $lang['cjoin'],
		'L_LJOIN' => $lang['ljoin'],
		'L_CFROM' => $lang['cfrom'],
		'L_LFROM' => $lang['lfrom'],
		'L_CPOSTS' => $lang['cposts'],
		'L_LPOSTS' => $lang['lposts'],
		'L_CLEVELL' => $lang['clevell'],
		'L_LLEVELL' => $lang['llevell'],
		'L_CLEVELD' => $lang['cleveld'],
		'L_CIGNORE' => $lang['cignore'],
		'L_LIGNORE' => $lang['lignore'],
		'L_CQUICK' => $lang['Quick_Reply'],
		'L_LQUICK' => $lang['lquick'],
		'L_CGG' => $lang['cgg'],
		'L_LGG' => $lang['lgg'],
		'L_CLEVELD' => $lang['cleveld'],
		'L_LLEVELD' => $lang['lleveld'],
		'L_GRAPHIC' => $lang['graphic'],
		'L_GRAPHIC_E' => $lang['graphic_e'],
		'L_POST_FOOTER' => $lang['post_footer'],
		'L_POST_FOOTER_E' => $lang['post_footer_e'],
		'L_HV_ADMIN_E' => $lang['hv_admin_e'],
		'L_HV_ADMIN' => $lang['hv_admin'],
		'L_HE_ADMIN' => $lang['he_admin'],
		'L_HE_ADMIN_E' => $lang['he_admin_e'],
		'L_SA_UNLOCKED' => $lang['show_action_unlocked'],
		'L_SA_LOCKED' => $lang['show_action_locked'],
		'L_SA_MOVED' => $lang['show_action_moved'],
		'L_SA_EXPIRED' => $lang['show_action_expired'],
		'L_SA_EDITED_BY_OTHERS' => $lang['show_action_edited_by_others'],
		'L_SA_EDITED_SELF' => $lang['show_action_edited_self'],
		'L_SA_EDITED_SELF_ALL' => $lang['show_action_edited_self_all'],
		'L_SA_ALLOW_MOD_DELETE' => $lang['allow_mod_delete_actions'],
		'L_WV' => $lang['wv'],
		'L_WV_ADMIN' => $lang['wv_admin'],
		'L_WV_ADMIN_E' => $lang['wv_admin_e'],
		'L_NOT_ANONYMOUS_QUICKREPLY' => $lang['not_anonymous_quickreply'],
		'L_MAX_SMILIES' => $lang['max_smilies'],
		'L_TOPIC_START_DATE' => $lang['topic_start_date'],
		'L_TOPIC_START_DATEFORMAT' => $lang['topic_start_dateformat'],
		'L_TOPIC_START_DATEFORMAT_E' => $lang['topic_start_dateformat_e'],
		'L_ADDON_VIEWFORUM' => $lang['l_addon_viewforum'],
		'L_IGNORE_TOPICS' => $lang['ignore_topics'],
		'L_POSTER_POSTS' => $lang['l_poster_posts'],
		'L_POSTER_POSTS_E' => $lang['l_poster_posts_e'],
		'L_NEWEST' => $lang['newest'],
		'L_NEWEST_E' => $lang['newest_e'],
		'L_CSEARCH' => $lang['csearch'],
		'L_LSEARCH' => $lang['lsearch'],
		'L_QUICK_REPLY_PAGES' => $lang['quick_reply_pages'],
		'L_ONLINE_STATUS' => $lang['Show_online_status'],
		'L_EDIT_TIME' => $lang['edit_time'],
		'L_EDIT_TIME_EXPLAIN' => $lang['edit_time_explain'],
		'L_TOPIC_SPY_E' => $lang['Topic_spy_e'],
		'L_TOPIC_SPY_MOD' => $lang['Topic_spy_mod'],
		'L_TOPIC_SPY_MOD_ADMIN' => $lang['Topic_spy_mod_admin'],
		'L_POST_OVERLIB' => $lang['Post_overlib'],
		'L_PH_VALUE' => $lang['PH_values'],
		'L_PH_VALUE_E' => $lang['PH_values_e'],
		'L_PH_LEN' => $lang['PH_len'],
		'L_PH_LEN_E' => $lang['PH_len_e'],
		'L_PH_MOD' => $lang['PH_mod'],
		'L_PH_MOD_DELETE' => $lang['PH_mod_delete'],

		'CAGENT_YES' => ($new['cagent']) ? $checked : '',
		'CAGENT_NO' => (!$new['cagent']) ? $checked : '',
		'CFRIEND_YES' => ($new['cfriend']) ? $checked : '',
		'CFRIEND_NO' => (!$new['cfriend']) ? $checked : '',
		'CJOIN_YES' => ($new['cjoin']) ? $checked : '',
		'CJOIN_NO' => (!$new['cjoin']) ? $checked : '',
		'CFROM_YES' => ($new['cfrom']) ? $checked : '',
		'CFROM_NO' => (!$new['cfrom']) ? $checked : '',
		'CPOSTS_YES' => ($new['cposts']) ? $checked : '',
		'CPOSTS_NO' => (!$new['cposts']) ? $checked : '',
		'CLEVELL_YES' => ($new['clevell']) ? $checked : '',
		'CLEVELL_NO' => (!$new['clevell']) ? $checked : '',
		'CLEVELD_YES' => ($new['cleveld']) ? $checked : '',
		'CLEVELD_NO' => (!$new['cleveld']) ? $checked : '',
		'CIGNORE_YES' => ($new['cignore']) ? $checked : '',
		'CIGNORE_NO' => (!$new['cignore']) ? $checked : '',
		'CQUICK_YES' => ($new['cquick']) ? $checked : '',
		'CQUICK_NO' => (!$new['cquick']) ? $checked : '',
		'CGG_YES' => ($new['cgg']) ? $checked : '',
		'CGG_NO' => (!$new['cgg']) ? $checked : '',
		'GRAPHIC_YES' => ($new['graphic']) ? $checked : '',
		'GRAPHIC_NO' => (!$new['graphic']) ? $checked : '',
		'POST_FOOTER_YES' => ($new['post_footer']) ? $checked : '',
		'POST_FOOTER_NO' => (!$new['post_footer']) ? $checked : '',
		'HV_ADMIN_YES' => ($new['hide_viewed_admin']) ? $checked : '',
		'HV_ADMIN_NO' => (!$new['hide_viewed_admin']) ? $checked : '',
		'WV_YES' => ($new['who_viewed']) ? $checked : '',
		'WV_NO' => (!$new['who_viewed']) ? $checked : '',
		'WV_ADMIN_YES' => ($new['who_viewed_admin']) ? $checked : '',
		'WV_ADMIN_NO' => (!$new['who_viewed_admin']) ? $checked : '',
		'TOPIC_START_DATEFORMAT' => $new['topic_start_dateformat'],
		'MAX_SMILIES' => $new['max_smilies'],
		'NOT_ANONYMOUS_QUICKREPLY_YES' => ($new['not_anonymous_quickreply']) ? $checked : '',
		'NOT_ANONYMOUS_QUICKREPLY_NO' => (!$new['not_anonymous_quickreply']) ? $checked : '',
		'TOPIC_START_DATE_YES' => ($new['topic_start_date']) ? $checked : '',
		'TOPIC_START_DATE_NO' => (!$new['topic_start_date']) ? $checked : '',
		'IGNORE_TOPICS_YES' => ($new['ignore_topics']) ? $checked : '',
		'IGNORE_TOPICS_NO' => (!$new['ignore_topics']) ? $checked : '',
		'POSTER_POSTS_YES' => ($new['poster_posts']) ? $checked : '',
		'POSTER_POSTS_NO' => (!$new['poster_posts']) ? $checked : '',
		'ONLINE_STATUS_YES' => ($new['r_a_r_time']) ? $checked : '',
		'ONLINE_STATUS_NO' => (!$new['r_a_r_time']) ? $checked : '',
		'NEWEST_YES' => ($new['newest']) ? $checked : '',
		'NEWEST_NO' => (!$new['newest']) ? $checked : '',
		'CSEARCH_YES' => ($new['csearch']) ? $checked : '',
		'CSEARCH_NO' => (!$new['csearch']) ? $checked : '',
		'QUICK_REPLY_PAGES_YES' => ($new['group_rank_hack_version']) ? $checked : '',
		'QUICK_REPLY_PAGES_NO' => (!$new['group_rank_hack_version']) ? $checked : '',
		'HE_ADMIN_YES' => ($new['hide_edited_admin']) ? $checked : '',
		'HE_ADMIN_NO' => (!$new['hide_edited_admin']) ? $checked : '',
		'SA_UNLOCK_YES' => ($new['show_action_unlocked']) ? $checked : '',
		'SA_UNLOCK_NO' => (!$new['show_action_unlocked']) ? $checked : '',
		'SA_LOCK_YES' => ($new['show_action_locked']) ? $checked : '',
		'SA_LOCK_NO' => (!$new['show_action_locked']) ? $checked : '',
		'SA_MOVE_YES' => ($new['show_action_moved']) ? $checked : '',
		'SA_MOVE_NO' => (!$new['show_action_moved']) ? $checked : '',
		'SA_EXPIRE_YES' => ($new['show_action_expired']) ? $checked : '',
		'SA_EXPIRE_NO' => (!$new['show_action_expired']) ? $checked : '',
		'SA_EDITED_BY_OTHERS_YES' => ($new['show_action_edited_by_others']) ? $checked : '',
		'SA_EDITED_BY_OTHERS_NO' => (!$new['show_action_edited_by_others']) ? $checked : '',
		'SA_EDITED_SELF_YES' => ($new['show_action_edited_self']) ? $checked : '',
		'SA_EDITED_SELF_NO' => (!$new['show_action_edited_self']) ? $checked : '',
		'SA_EDITED_SELF_ALL_YES' => ($new['show_action_edited_self_all']) ? $checked : '',
		'SA_EDITED_SELF_ALL_NO' => (!$new['show_action_edited_self_all']) ? $checked : '',
		'SA_MOD_DELETE_YES' => ($new['allow_mod_delete_actions']) ? $checked : '',
		'SA_MOD_DELETE_NO' => (!$new['allow_mod_delete_actions']) ? $checked : '',
		'EDIT_TIME' => $new['edit_time'],
		'SPY_MOD_YES' => ($new['mod_spy']) ? $checked : '',
		'SPY_MOD_NO' => (!$new['mod_spy']) ? $checked : '',
		'SPY_ADMIN_YES' => ($new['mod_spy_admin']) ? $checked : '',
		'SPY_ADMIN_NO' => (!$new['mod_spy_admin']) ? $checked : '',
		'POST_OVERLIB_YES' => ($new['post_overlib']) ? $checked : '',
		'POST_OVERLIB_NO' => (!$new['post_overlib']) ? $checked : '',
		'PH_VALUE' => $new['ph_days'],
		'PH_LEN' => $new['ph_len'],
		'PH_MOD_YES' => ($new['ph_mod']) ? $checked : '',
		'PH_MOD_NO' => (!$new['ph_mod']) ? $checked : '',
		'PH_MOD_DELETE_YES' => ($new['ph_mod_delete']) ? $checked : '',
		'PH_MOD_DELETE_NO' => (!$new['ph_mod_delete']) ? $checked : '',

		'S_HIDDEN_FIELDS' => '<input type="hidden" name="mode" value="viewtopic">')
	);
}
else if ( $mode == 'profile' )
{
	$template->set_filenames(array(
		'body' => 'admin/board_config_body_profile.tpl')
	);

	$template->assign_vars(array(
		'L_VALIDATION' => $lang[Validation],
		'L_CVALIDATEE' => $lang['cvalidatee'],
		'L_REQUIRE_AIM' => $lang['l_require_aim'],
		'L_REQUIRE_AIM_E' => $lang['l_require_aim_e'],
		'L_REQUIRE_WEBSITE' => $lang['l_require_website'],
		'L_REQUIRE_WEBSITE_E' => $lang['l_require_website_e'],
		'L_REQUIRE_LOCATION' => $lang['l_require_location'],
		'L_REQUIRE_LOCATION_E' => $lang['l_require_location_e'],
		'L_MAX_SIG_LOCATION' => $lang['max_sig_location'],
		'L_GENDER' => $lang['l_gender'],
		'L_GENDER_E' => $lang['l_gender_e'],
		'L_REQUIRE_GENDER' => $lang['l_require_gender'],
		'L_CICQ' => $lang['cicq'],
		'L_LICQ' => $lang['licq'],
		'L_CLLOGIN' => $lang['Sort_Last_visit'],
		'L_LLLOGIN' => $lang['lllogin'],
		'L_CLEVELP' => $lang['clevelp'],
		'L_LLEVELP' => $lang['llevelp'],
		'L_CYAHOO' => $lang['cyahoo'],
		'L_LYAHOO' => $lang['lyahoo'],
		'L_CMSN' => $lang['cmsn'],
		'L_LMSN' => $lang['lmsn'],
		'L_CJOB' => $lang['Occupation'],
		'L_LJOB' => $lang['ljob'],
		'L_CINTER' => $lang['Interests'],
		'L_LINTER' => $lang['linter'],
		'L_CEMAIL' => $lang['Public_view_email'],
		'L_LEMAIL' => $lang['lemail'],
		'L_CBBCODE' => $lang['Always_bbcode'],
		'L_LBBCODE' => $lang['lbbcode'],
		'L_CHTML' => $lang['Always_html'],
		'L_LHTML' => $lang['lhtml'],
		'L_CSMILES' => $lang['Always_smile'],
		'L_LSMILES' => $lang['lsmiles'],
		'L_CLANG' => $lang['Board_lang'],
		'L_LLANG' => $lang['llang'],
		'L_CTIMEZONE' => $lang['Timezone'],
		'L_LTIMEZONE' => $lang['ltimezone'],
		'L_CDATEFOR' => $lang['Date_format'],
		'L_CBSTYLE' => $lang['Board_style'],
		'L_LBSTYLE' => $lang['lbstyle'],
		'L_AVATAR_SETTINGS' => $lang['Avatar_settings'],
		'L_ALLOW_LOCAL' => $lang['Allow_local'],
		'L_ALLOW_REMOTE' => $lang['Allow_remote'],
		'L_ALLOW_REMOTE_EXPLAIN' => $lang['Allow_remote_explain'],
		'L_ALLOW_UPLOAD' => $lang['Allow_upload'],
		'L_ALLOW_AVATAR' => $lang['Allow_avatar'],
		'L_ALLOW_AVATAR_EXPLAIN' => $lang['Allow_avatar_explain'],
		'L_MAX_FILESIZE' => $lang['Max_filesize'],
		'L_MAX_FILESIZE_EXPLAIN' => $lang['Max_filesize_explain'],
		'L_MAX_AVATAR_SIZE' => $lang['Max_avatar_size'],
		'L_MAX_AVATAR_SIZE_EXPLAIN' => $lang['Max_avatar_size_explain'],
		'L_AVATAR_STORAGE_PATH' => $lang['Avatar_storage_path'],
		'L_AVATAR_STORAGE_PATH_EXPLAIN' => $lang['Avatar_storage_path_explain'],
		'L_AVATAR_GALLERY_PATH' => $lang['Avatar_gallery_path'],
		'L_AVATAR_GALLERY_PATH_EXPLAIN' => $lang['Avatar_gallery_path_explain'],
		'L_PROFLE_PHOTO_SETTINGS' => $lang['Profile_photo_settings'],
		'L_ALLOW_PHOTO_REMOTE' => $lang['Allow_photo_remote'],
		'L_ALLOW_PHOTO_REMOTE_EXPLAIN' => $lang['Allow_photo_remote_explain'],
		'L_ALLOW_PHOTO_UPLOAD' => $lang['Allow_photo_upload'],
		'L_PHOTO_MAX_FILESIZE' => $lang['Photo_max_filesize'],
		'L_PHOTO_MAX_FILESIZE_EXPLAIN' => $lang['Photo_max_filesize_explain'],
		'L_MAX_PHOTO_SIZE' => $lang['Max_photo_size'],
		'L_PHOTO_STORAGE_PATH' => $lang['Photo_storage_path'],
		'L_PHOTO_STORAGE_PATH_EXPLAIN' => $lang['Photo_storage_path_explain'],
		'L_SIGNATURE_SETTINGS' => $lang['Signature_settings'],
		'L_ALLOW_SIG_IMAGE' => $lang['Allow_sig_image'],
		'L_ALLOW_SIG' => $lang['Allow_sig'],
		'L_MAX_SIG_LENGTH' => $lang['Max_sig_length'],
		'L_MAX_SIG_LENGTH_EXPLAIN' => $lang['Max_sig_length_explain'],
		'L_MAX_SIG_FILESIZE' => $lang['Max_sig_image_filesize'],
		'L_MAX_SIG_IMAGE_SIZE' => $lang['Max_sig_image_size'],
		'L_MAX_SIG_IMAGE_SIZE_EXPLAIN' => $lang['Max_sig_image_size_explain'],
		'L_SIG_IMAGES_STORAGE_PATH' => $lang['Sig_images_storage_path'],
		'L_SIG_IMAGES_STORAGE_PATH_EXPLAIN' => $lang['Sig_images_storage_path_explain'],
		'L_MAX_SIG_LENGTH' => $lang['Max_sig_length'],
		'L_MAX_SIG_LENGTH_EXPLAIN' => $lang['Max_sig_length_explain'],
		'L_ALLOW_IMG_BBCODE' => $lang['allow_img_bbcode'],
		'L_ALLOW_IMG_BBCODE_E' => $lang['allow_img_bbcode_e'],
		'L_VIEWONLINE' => $lang['viewonline_e'],

		'CVALIDATE_YES' => ($new['validate']) ? $checked : '',
		'CVALIDATE_NO' => (!$new['validate']) ? $checked : '',
		'REQUIRE_AIM_YES' => ($new['require_aim']) ? $checked : '',
		'REQUIRE_AIM_NO' => (!$new['require_aim']) ? $checked : '',
		'REQUIRE_WEBSITE_YES' => ($new['require_website']) ? $checked : '',
		'REQUIRE_WEBSITE_NO' => (!$new['require_website']) ? $checked : '',
		'REQUIRE_LOCATION_YES' => ($new['require_location']) ? $checked : '',
		'REQUIRE_LOCATION_NO' => (!$new['require_location']) ? $checked : '',
		'MAX_SIG_LOCATION' => $new['max_sig_location'],
		'GENDER_YES' => ($new['gender']) ? $checked : '',
		'GENDER_NO' => (!$new['gender']) ? $checked : '',
		'REQUIRE_GENDER_YES' => ($new['require_gender']) ? $checked : '',
		'REQUIRE_GENDER_NO' => (!$new['require_gender']) ? $checked : '',
		'CICQ_YES' => ($new['cicq']) ? $checked : '',
		'CICQ_NO' => (!$new['cicq']) ? $checked : '',
		'CLLOGIN_YES' => ($new['cllogin']) ? $checked : '',
		'CLLOGIN_NO' => (!$new['cllogin']) ? $checked : '',
		'CLEVELP_YES' => ($new['clevelp']) ? $checked : '',
		'CLEVELP_NO' => (!$new['clevelp']) ? $checked : '',
		'CYAHOO_YES' => ($new['cyahoo']) ? $checked : '',
		'CYAHOO_NO' => (!$new['cyahoo']) ? $checked : '',
		'CMSN_YES' => ($new['cmsn']) ? $checked : '',
		'CMSN_NO' => (!$new['cmsn']) ? $checked : '',
		'CJOB_YES' => ($new['cjob']) ? $checked : '',
		'CJOB_NO' => (!$new['cjob']) ? $checked : '',
		'CINTER_YES' => ($new['cinter']) ? $checked : '',
		'CINTER_NO' => (!$new['cinter']) ? $checked : '',
		'CEMAIL_YES' => ($new['cemail']) ? $checked : '',
		'CEMAIL_NO' => (!$new['cemail']) ? $checked : '',
		'CBBCODE_YES' => ($new['cbbcode']) ? $checked : '',
		'CBBCODE_NO' => (!$new['cbbcode']) ? $checked : '',
		'CHTML_YES' => ($new['chtml']) ? $checked : '',
		'CHTML_NO' => (!$new['chtml']) ? $checked : '',
		'CSMILES_YES' => ($new['csmiles']) ? $checked : '',
		'CSMILES_NO' => (!$new['csmiles']) ? $checked : '',
		'CLANG_YES' => ($new['clang']) ? $checked : '',
		'CLANG_NO' => (!$new['clang']) ? $checked : '',
		'CTIMEZONE_YES' => ($new['ctimezone']) ? $checked : '',
		'CTIMEZONE_NO' => (!$new['ctimezone']) ? $checked : '',
		'CBSTYLE_YES' => ($new['cbstyle']) ? $checked : '',
		'CBSTYLE_NO' => (!$new['cbstyle']) ? $checked : '',
		'AVATARS_LOCAL_YES' => ($new['allow_avatar_local']) ? $checked : '',
		'AVATARS_LOCAL_NO' => (!$new['allow_avatar_local']) ? $checked : '',
		'AVATARS_REMOTE_YES' => ($new['allow_avatar_remote']) ? $checked : '',
		'AVATARS_REMOTE_NO' => (!$new['allow_avatar_remote']) ? $checked : '',
		'AVATARS_UPLOAD_YES' => ($new['allow_avatar_upload']) ? $checked : '',
		'AVATARS_UPLOAD_NO' => (!$new['allow_avatar_upload']) ? $checked : '',
		'AVATAR_FILESIZE' => $new['avatar_filesize'],
		'ALLOW_AVATAR' => $new['allow_avatar'],
		'AVATAR_MAX_HEIGHT' => $new['avatar_max_height'],
		'AVATAR_MAX_WIDTH' => $new['avatar_max_width'],
		'AVATAR_PATH' => $new['avatar_path'],
		'AVATAR_GALLERY_PATH' => $new['avatar_gallery_path'],
		'PHOTO_REMOTE_YES' => ($new['allow_photo_remote']) ? $checked : '',
		'PHOTO_REMOTE_NO' => (!$new['allow_photo_remote']) ? $checked : '',
		'PHOTO_UPLOAD_YES' => ($new['allow_photo_upload']) ? $checked : '',
		'PHOTO_UPLOAD_NO' => (!$new['allow_photo_upload']) ? $checked : '',
		'PHOTO_FILESIZE' => $new['photo_filesize'],
		'PHOTO_MAX_WIDTH' => $new['photo_max_width'],
		'PHOTO_MAX_HEIGHT' => $new['photo_max_height'],
		'PHOTO_PATH' => $new['photo_path'],
		'SIG_YES' => ($new['allow_sig']) ? $checked : '',
		'SIG_NO' => (!$new['allow_sig']) ? $checked : '',
		'SIG_IMAGE_YES' => ($new['allow_sig_image']) ? $checked : '',
		'SIG_IMAGE_NO' => (!$new['allow_sig_image']) ? $checked : '',
		'SIG_SIZE' => $new['max_sig_chars'],
		'SIG_IMAGE_FILESIZE' => $new['sig_image_filesize'],
		'SIG_IMAGE_MAX_HEIGHT' => $new['sig_image_max_height'],
		'SIG_IMAGE_MAX_WIDTH' => $new['sig_image_max_width'],
		'SIG_IMAGES_PATH' => $new['sig_images_path'],
		'SIG_IMAGE_IMG_YES' => ($new['allow_sig_image_img']) ? $checked : '',
		'SIG_IMAGE_IMG_NO' => (!$new['allow_sig_image_img']) ? $checked : '',
		'VIEWONLINE' => $new['viewonline'],
		'S_HIDDEN_FIELDS' => '<input type="hidden" name="mode" value="profile">')
	);
}
else if ( $mode == 'posting' )
{
	$template->set_filenames(array(
		'body' => 'admin/board_config_body_posting.tpl')
	);

	$template->assign_vars(array(
		'L_ALLOW_SMILIES' => $lang['Allow_smilies'],
		'L_SMILIES_PATH' => $lang['Smilies_path'],
		'L_SMILIES_VALUE' => $lang['l_smilies_value'],
		'L_SMILIES_VALUE_E' => $lang['l_smilies_value_e'],
		'L_ALLOW_HTML' => $lang['Allow_HTML'],
		'L_ALLOWED_TAGS' => $lang['Allowed_tags'],
		'L_ALLOWED_TAGS_EXPLAIN' => $lang['Allowed_tags_explain'],
		'L_RESTRICTBBCODE' => $lang['l_restrictbbcode'],
		'L_RESTRICTBBCODE_E' => $lang['l_restrictbbcode_e'],
		'L_ALLOW_BBCODE' => $lang['Allow_BBCode'],
		'L_POSTICON' => $lang['posticon_a'],
		'L_BUTTON_B' => $lang['l_button_b'],
		'L_BUTTON_I' => $lang['l_button_i'],
		'L_BUTTON_U' => $lang['l_button_u'],
		'L_BUTTON_Q' => $lang['l_button_q'],
		'L_BUTTON_C' => $lang['l_button_c'],
		'L_BUTTON_L' => $lang['l_button_l'],
		'L_BUTTON_IM' => $lang['l_button_im'],
		'L_BUTTON_UR' => $lang['l_button_ur'],
		'L_BUTTON_CE' => $lang['l_button_ce'],
		'L_BUTTON_F' => $lang['l_button_f'],
		'L_BUTTON_S' => $lang['l_button_s'],
		'L_BUTTON_HI' => $lang['l_button_hi'],
		'L_COLOR_BOX' => $lang['l_color_box'],
		'L_SIZE_BOX' => $lang['l_size_box'],
		'L_GLOW_BOX' => $lang['l_glow_box'],
		'L_TOPIC_COLOR' => $lang['topic_color'],
		'L_TOPIC_COLOR_ALL' => $lang['topic_color_all'],
		'L_TOPIC_COLOR_MOD' => $lang['topic_color_mod'],
		'L_EXPIRE' => $lang['l_expire_p'],
		'L_EXPIRE_V' => $lang['l_expire_v'],
		'L_EXPIRE_V_E' => $lang['l_expire_v_e'],
		'L_FREAK' => $lang['l_freak'],
		'L_ADMIN_HTML_E' => $lang['admin_html_e'],
		'L_RESTRICT_SMILIES' => $lang['restrict_smilies'],
		'L_TOPIC_PREVIEW' => $lang['topic_preview'],
		'L_NOT_ANONYMOUS_POSTING_E' => $lang['not_anonymous_posting_e'],
		'L_SPLIT_MESSAGES' => $lang['split_messages'],
		'L_SPLIT_MESSAGES_E' => $lang['split_messages_e'],
		'L_SPLIT_MESSAGES_ADMIN' => $lang['split_messages_admin'],
		'L_SPLIT_MESSAGES_MOD' => $lang['split_messages_mod'],
		'L_ADMIN_HTML' => $lang['admin_html'],
		'L_JR_ADMIN_HTML' => $lang['jr_admin_html'],
		'L_MOD_HTML' => $lang['mod_html'],
		'L_TITLE_EXPLAIN' => $lang['Subject_e'],

		'SMILE_YES' => ($new['allow_smilies']) ? $checked : '',
		'SMILE_NO' => (!$new['allow_smilies']) ? $checked : '',
		'SMILIES_PATH' => $new['smilies_path'],
		'SMILIES_COLUMNS' => $new['smilies_columns'],
		'SMILIES_ROWS' => $new['smilies_rows'],
		'SMILIES_W_COLUMNS' => $new['smilies_w_columns'],
		'HTML_YES' => ($new['allow_html']) ? $checked : '',
		'HTML_NO' => (!$new['allow_html']) ? $checked : '',
		'HTML_TAGS' => $new['allow_html_tags'],
		'RESTRICTBBCODE_YES' => ($new['allow_bbcode_quest']) ? $checked : '',
		'RESTRICTBBCODE_NO' => (!$new['allow_bbcode_quest']) ? $checked : '',
		'BBCODE_YES' => ($new['allow_bbcode']) ? $checked : '',
		'BBCODE_NO' => (!$new['allow_bbcode']) ? $checked : '',
		'POSTICON_YES' => ($new['post_icon']) ? $checked : '',
		'POSTICON_NO' => (!$new['post_icon']) ? $checked : '',
		'BUTTON_B_YES' => ($new['button_b']) ? $checked : '',
		'BUTTON_B_NO' => (!$new['button_b']) ? $checked : '',
		'BUTTON_I_YES' => ($new['button_i']) ? $checked : '',
		'BUTTON_I_NO' => (!$new['button_i']) ? $checked : '',
		'BUTTON_U_YES' => ($new['button_u']) ? $checked : '',
		'BUTTON_U_NO' => (!$new['button_u']) ? $checked : '',
		'BUTTON_Q_YES' => ($new['button_q']) ? $checked : '',
		'BUTTON_Q_NO' => (!$new['button_q']) ? $checked : '',
		'BUTTON_C_YES' => ($new['button_c']) ? $checked : '',
		'BUTTON_C_NO' => (!$new['button_c']) ? $checked : '',
		'BUTTON_L_YES' => ($new['button_l']) ? $checked : '',
		'BUTTON_L_NO' => (!$new['button_l']) ? $checked : '',
		'BUTTON_IM_YES' => ($new['button_im']) ? $checked : '',
		'BUTTON_IM_NO' => (!$new['button_im']) ? $checked : '',
		'BUTTON_UR_YES' => ($new['button_ur']) ? $checked : '',
		'BUTTON_UR_NO' => (!$new['button_ur']) ? $checked : '',
		'BUTTON_CE_YES' => ($new['button_ce']) ? $checked : '',
		'BUTTON_CE_NO' => (!$new['button_ce']) ? $checked : '',
		'BUTTON_F_YES' => ($new['button_f']) ? $checked : '',
		'BUTTON_F_NO' => (!$new['button_f']) ? $checked : '',
		'BUTTON_S_YES' => ($new['button_s']) ? $checked : '',
		'BUTTON_S_NO' => (!$new['button_s']) ? $checked : '',
		'BUTTON_HI_YES' => ($new['button_hi']) ? $checked : '',
		'BUTTON_HI_NO' => (!$new['button_hi']) ? $checked : '',
		'COLOR_BOX_YES' => ($new['color_box']) ? $checked : '',
		'COLOR_BOX_NO' => (!$new['color_box']) ? $checked : '',
		'SIZE_BOX_YES' => ($new['size_box']) ? $checked : '',
		'SIZE_BOX_NO' => (!$new['size_box']) ? $checked : '',
		'GLOW_BOX_YES' => ($new['glow_box']) ? $checked : '',
		'GLOW_BOX_NO' => (!$new['glow_box']) ? $checked : '',
		'TOPIC_COLOR_YES' => ($new['topic_color']) ? $checked : '',
		'TOPIC_COLOR_NO' => (!$new['topic_color']) ? $checked : '',
		'TOPIC_COLOR_MOD_YES' => ($new['topic_color_mod']) ? $checked : '',
		'TOPIC_COLOR_MOD_NO' => (!$new['topic_color_mod']) ? $checked : '',
		'TOPIC_COLOR_ALL_YES' => ($new['topic_color_all']) ? $checked : '',
		'TOPIC_COLOR_ALL_NO' => (!$new['topic_color_all']) ? $checked : '',
		'EXPIRE_YES' => ($new['expire']) ? $checked : '',
		'EXPIRE_NO' => (!$new['expire']) ? $checked : '',
		'EXPIRE_V_YES' => ($new['expire_value']) ? $checked : '',
		'EXPIRE_V_NO' => (!$new['expire_value']) ? $checked : '',
		'FREAK_YES' => ($new['freak']) ? $checked : '',
		'FREAK_NO' => (!$new['freak']) ? $checked : '',
		'RESTRICT_SMILIES_YES' => ($new['restrict_smilies']) ? $checked : '',
		'RESTRICT_SMILIES_NO' => (!$new['restrict_smilies']) ? $checked : '',
		'TOPIC_PREVIEW_YES' => ($new['topic_preview']) ? $checked : '',
		'TOPIC_PREVIEW_NO' => (!$new['topic_preview']) ? $checked : '',
		'NOT_ANONYMOUS_POSTING_YES' => ($new['not_anonymous_posting']) ? $checked : '',
		'NOT_ANONYMOUS_POSTING_NO' => (!$new['not_anonymous_posting']) ? $checked : '',
		'SPLIT_MESSAGES_YES' => ($new['split_messages']) ? $checked : '',
		'SPLIT_MESSAGES_NO' => (!$new['split_messages']) ? $checked : '',
		'SPLIT_MESSAGES_ADMIN_YES' => ($new['split_messages_admin']) ? $checked : '',
		'SPLIT_MESSAGES_ADMIN_NO' => (!$new['split_messages_admin']) ? $checked : '',
		'SPLIT_MESSAGES_MOD_YES' => ($new['split_messages_mod']) ? $checked : '',
		'SPLIT_MESSAGES_MOD_NO' => (!$new['split_messages_mod']) ? $checked : '',
		'ADMIN_HTML_YES' => ($new['admin_html']) ? $checked : '',
		'ADMIN_HTML_NO' => (!$new['admin_html']) ? $checked : '',
		'JR_ADMIN_HTML_YES' => ($new['jr_admin_html']) ? $checked : '',
		'JR_ADMIN_HTML_NO' => (!$new['jr_admin_html']) ? $checked : '',
		'MOD_HTML_YES' => ($new['mod_html']) ? $checked : '',
		'MOD_HTML_NO' => (!$new['mod_html']) ? $checked : '',
		'TITLE_EXPLAIN_YES' => ($new['title_explain']) ? $checked : '',
		'TITLE_EXPLAIN_NO' => (!$new['title_explain']) ? $checked : '',
		'S_HIDDEN_FIELDS' => '<input type="hidden" name="mode" value="posting">')
	);
}
else if ( $mode == 'clear' )
{
	$sql = "DELETE FROM " . READ_HIST_TABLE . "";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error in clear read history', '', __LINE__, __FILE__, $sql);
	}
	else
	{
		$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_board.$phpEx?mode=addons") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}
}
else if ( $mode == 'warnings' )
{
    $clear_cache    = false;
    $arr = array
    (
        'ban_warnings'         => $board_config['ban_warnings'],
        'write_warnings'       => $board_config['write_warnings'],
        'warnings_mods_public' => $board_config['warnings_mods_public'],
        'warnings_enable'      => $board_config['warnings_enable'],
        'mod_warnings'         => $board_config['mod_warnings'],
        'mod_edit_warnings'    => $board_config['mod_edit_warnings'],
        'expire_warnings'      => $board_config['expire_warnings'],
        'mod_value_warning'    => $board_config['mod_value_warning'],
        'viewtopic_warnings'   => $board_config['viewtopic_warnings']
    );

    foreach( $arr as $config_name => $config_value )
    {
        $war[$config_name] = get_vars($config_name, $config_value, 'POST', true);

        if ( isset($HTTP_POST_VARS['submit_warnings']) )
        {
            if($war[$config_name] != $config_value)
            {
                $sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . $war[$config_name] . "'
				WHERE config_name = '$config_name'";
                if ( !$db->sql_query($sql) )
                {
                    message_die(GENERAL_ERROR, 'Failed to update general configuration for ' . $config_name, '', __LINE__, __FILE__, $sql);
                }
                $clear_cache = true;
            }
        }
    }

    if ( $clear_cache )
    {
        sql_cache('clear', 'board_config');
    }

    if ( isset($HTTP_POST_VARS['submit_warnings']) )
    {
        $message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_board.$phpEx?mode=warnings") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
        message_die(GENERAL_MESSAGE, $message);
    }

	require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_warnings.' . $phpEx);

	$template->set_filenames(array(
		'body' => 'admin/warnings_config_body.tpl')
	);

	$template->assign_block_vars('warnings', array(
		'L_WARNINGS' => $lang['Warnings'],
		'L_WARNINGS_E' => $lang['Warnings_e'],
		'L_WARNINGS_ENABLE' => $lang['l_warnings_enable'],
		'L_MOD_WARNINGS' => $lang['l_mod_warnings'],
		'L_MOD_EDIT_WARNINGS' => $lang['l_mod_edit_warnings'],
		'L_MOD_VALUE_WARNING' => $lang['l_mod_value_warning'],
		'L_WRITE_WARNINGS' => $lang['l_write_warnings'],
		'L_WRITE_WARNINGS_E' => $lang['l_write_warnings_e'],
		'L_BAN_WARNINGS' => $lang['l_ban_warnings'],
		'L_BAN_WARNINGS_E' => $lang['l_ban_warnings_e'],
		'L_EXPIRE_WARNINGS' => $lang['l_expire_warnings'],
		'L_EXPIRE_WARNINGS_E' => $lang['l_expire_warnings_e'],
		'L_WARNINGS_MODS_PUBLIC' => $lang['l_warnings_mods_public'],
		'L_WARNINGS_MODS_PUBLIC_E' => $lang['l_warnings_mods_public_e'],
		'L_VIEWTOPIC_WARNINGS' => $lang['viewtopic_warnings'],
		'L_ENABLED' => $lang['Enabled'],
		'L_DISABLED' => $lang['Disabled'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],

		'S_CONFIG_ACTION' => append_sid("admin_board.$phpEx"),
		'WARNING_ENABLE_YES' => ( $war['warnings_enable']) ? $checked : '',
		'WARNING_ENABLE_NO' => (!$war['warnings_enable']) ? $checked : '',
		'MOD_WARNINGS_YES' => ($war['mod_warnings']) ? $checked : '',
		'MOD_WARNINGS_NO' => (!$war['mod_warnings']) ? $checked : '',
		'MOD_EDIT_WARNINGS_YES' => ($war['mod_edit_warnings']) ? $checked : '',
		'MOD_EDIT_WARNINGS_NO' => (!$war['mod_edit_warnings']) ? $checked : '',
		'WARNINGS_MODS_PUBLIC_YES' => ($war['warnings_mods_public']) ? $checked : '',
		'WARNINGS_MODS_PUBLIC_NO' => (!$war['warnings_mods_public']) ? $checked : '',
		'MOD_VALUE_WARNING' => $war['mod_value_warning'],
		'WRITE_WARNINGS' => $war['write_warnings'],
		'BAN_WARNINGS' => $war['ban_warnings'],
		'EXPIRE_WARNINGS' => $war['expire_warnings'],
		'VIEWTOPIC_WARNINGS_YES' => ($new['viewtopic_warnings']) ? $checked : '',
		'VIEWTOPIC_WARNINGS_NO' => (!$new['viewtopic_warnings']) ? $checked : '')
	);
}

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>