<?php
/***************************************************************************
 *						admin_uninstall.php
 *						-------------------
 * begin				: Thursday, November 11, 2003
 * copyright			: (C) (C) 2003 Przemo http://www.przemo.org
 * email				: przemo@przemo.org
 * date modification	: ver. 1.9 2004/05/30 21:50
 *
 * $Id: admin_uninstall.php,v 1.8.9 2004/05/30 21:50
 ***************************************************************************/

/***************************************************************************
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *
 ***************************************************************************/
define('MODULE_ID', 0);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['SQL']['Uninstall18'] = $file;
	return;
}

// Load default header
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

if( strstr($board_config['main_admin_id'], ',') )
{
	$fids = explode(',', $board_config['main_admin_id']);
	while( list($foo, $id) = each($fids) )
	{
		$fid[] = intval( trim($id) );
	}
}
else
{
	$fid[] = intval( trim($board_config['main_admin_id']) );
}
reset($fid);
if ( in_array($userdata['user_id'], $fid) == false )
{
	$message = sprintf($lang['SQL_Admin_No_Access'], '<a href="' . append_sid("admin_no_access.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}


$template->set_filenames(array(
	'body' => 'admin/uninstall.tpl')
);

$mode = $HTTP_POST_VARS['mode'];
if ( $mode != 'uninstall' || $mode != 'check' )
{
	$template->assign_vars(array(
		'TITLE' => $lang['Uninstall18'],
		'EXPLANATION' => $lang['uninstall_explain'],
		'ACTION' => '<td class="row1" align="center"><br /><form action="' . append_sid("admin_uninstall.$phpEx") . '" method="post"><input type="hidden" name="mode" value="check"><input type="submit" name="submit" class="mainoption" value="' . $lang['Uninstall'] . '" /></form></td>')
	);
}

if ( $mode == 'check' )
{
	$template->assign_vars(array(
		'UNINSTALL' => $lang['Uninstall'],
		'TITLE' => $lang['Uninstall18'],
		'EXPLANATION' => $lang['uninstall_explain'],
		'ACTION' => '<td class="row1" align="center"><br /><span class="nav">' . $lang['confirm_uninstall'] . '</span><br /><br />' . $lang['Set_new_version'] . '<br /><form action="' . append_sid("admin_uninstall.$phpEx") . '" method="post"><input type="ver" name="ver" value="2.0.19" size="6" /><br /><br /><input type="hidden" name="mode" value="uninstall"><input type="submit" name="cancel" value="' . $lang['No'] . '" class="mainoption" />&nbsp;&nbsp;<input type="submit" name="confirm" class="liteoption" value="' . $lang['Yes'] . '" /></form></td>')
	);
}

if ( $mode == 'uninstall' )
{
	if (isset($HTTP_POST_VARS['confirm']))
	{
		$sql = array();
		$new_version = ($HTTP_POST_VARS['ver']) ? str_replace(array("\'", "2.0"), array("''", ".0"), $HTTP_POST_VARS['ver']) : '.0.18';
		$sql[] = "UPDATE " . $table_prefix . "config SET config_value = '" . $new_version . "' WHERE config_name = 'version'";

		$sql[] = 'CREATE TABLE ' . $table_prefix . 'confirm (confirm_id char(32) DEFAULT \'\' NOT NULL, session_id char(32) DEFAULT \'\' NOT NULL, code char(6) DEFAULT \'\' NOT NULL, PRIMARY KEY (session_id, confirm_id)) latin2_general_ci';

		$sql[] = "ALTER TABLE " . USERS_TABLE . "
					ADD COLUMN user_login_tries smallint(5) UNSIGNED DEFAULT '0' NOT NULL";
		$sql[] = "ALTER TABLE " . USERS_TABLE . "
					ADD COLUMN user_last_login_try int(11) DEFAULT '0' NOT NULL";

		$sql[] = "ALTER TABLE " . $table_prefix . "user_group DROP INDEX user_pending";
		$sql[] = "ALTER TABLE " . $table_prefix . "groups DROP INDEX group_type";
		$sql[] = "ALTER TABLE " . $table_prefix . "sessions DROP INDEX session_time";
		$sql[] = "ALTER TABLE " . $table_prefix . "topics DROP INDEX topic_poster";
		$sql[] = "ALTER TABLE " . $table_prefix . "topics DROP INDEX topic_last_post_id";
		$sql[] = "ALTER TABLE " . $table_prefix . "topics DROP INDEX topic_first_post_id";
		$sql[] = "ALTER TABLE " . $table_prefix . "topics DROP INDEX topic_vote";
		$sql[] = "ALTER TABLE " . $table_prefix . "users DROP INDEX user_level";
		$sql[] = "ALTER TABLE " . $table_prefix . "users DROP INDEX user_lastvisit";
		$sql[] = "ALTER TABLE " . $table_prefix . "users DROP INDEX user_active";
		$sql[] = "ALTER TABLE " . $table_prefix . "users ADD user_dateformat varchar(14) DEFAULT 'd M Y H:i' NOT NULL";

		$drop_tables = array('advertisement', 'adv_person', 'anti_robotic_reg', 'attachments', 'attachments_config', 'attachments_desc', 'attach_quota', 'extensions', 'extension_groups', 'forbidden_extensions', 'ignores', 'jr_admin_users', 'logs', 'mass_email', 'posts_text_history', 'quota_limits', 'read_history', 'shoutbox', 'shoutbox_config', 'stats_config', 'stats_modules', 'topics_ignore', 'topic_view', 'users_warnings');

		for($i = 0; $i < count($drop_tables); $i++)
		{
			$sql[] = 'DROP TABLE ' . $table_prefix . $drop_tables[$i];
		}

		$drop_fields = array(
			'auth_access' => array('auth_globalannounce', 'auth_download'),
			'banlist' => array('ban_time', 'ban_expire_time', 'ban_by_userid', 'ban_priv_reason', 'ban_pub_reason_mode', 'ban_pub_reason', 'ban_host'),
			'categories' => array('cat_main_type', 'cat_main', 'cat_desc'),
			'forums' => array('auth_globalannounce', 'auth_download', 'password', 'forum_sort', 'forum_color', 'forum_link', 'forum_link_internal', 'forum_link_hit_count', 'forum_link_hit', 'main_type', 'forum_moderate', 'no_count', 'forum_trash', 'forum_separate', 'forum_show_ga', 'forum_tree_grade', 'forum_tree_req', 'forum_no_split', 'forum_no_helped', 'topic_tags', 'locked_bottom'),
			'groups' => array('group_order', 'group_count', 'group_count_enable', 'group_mail_enable', 'group_no_unsub', 'group_color', 'group_prefix', 'group_style'),
			'posts' => array('post_attachment', 'user_agent', 'post_icon', 'post_expire', 'reporter_id', 'post_marked', 'post_approve', 'poster_delete', 'post_edit_by', 'post_parent', 'post_order'),
			'privmsgs' => array('privmsgs_attachment'),
			'ranks' => array('rank_group'),
			'smilies' => array('smile_order'),
			'themes' => array('tr_color_helped', 'fontcolor_admin', 'fontcolor_jradmin', 'fontcolor_mod', 'factive_color', 'faonmouse_color', 'faonmouse2_color'),
			'topics' => array('topic_attachment', 'topic_icon', 'topic_expire', 'topic_color', 'topic_title_e', 'topic_action', 'topic_action_user', 'topic_action_date', 'topic_tree_width'),
			'users' => array('user_allowsig', 'user_viewaim', 'user_sig_image', 'user_custom_rank', 'user_photo', 'user_photo_type', 'user_custom_color', 'user_badlogin', 'user_blocktime', 'user_block_by', 'disallow_forums', 'can_custom_ranks', 'can_custom_color', 'user_gender', 'can_topic_color', 'user_notify_gg', 'allowpm', 'no_report_popup', 'refresh_report_popup', 'no_report_mail', 'user_avatar_width', 'user_avatar_height', 'special_rank', 'user_allow_helped', 'user_ip', 'user_ip_login_check', 'user_spend_time', 'user_visit', 'user_session_start', 'read_tracking_last_update', 'user_jr'),
			'vote_desc' => array('vote_max', 'vote_voted', 'vote_hide', 'vote_tothide'),
			'vote_voters' => array('vote_cast')
		);

		foreach($drop_fields as $table => $field)
		{
			for($i = 0; $i < count($field); $i++)
			{
				$sql[] = 'ALTER TABLE ' . $table_prefix . $table . ' DROP ' . $field[$i];
			}
		}

		$config_fields = array('sendmail_fix', 'allow_autologin', 'allow_photo_remote', 'allow_photo_upload', 'photo_filesize', 'photo_max_height', 'photo_max_width', 'photo_path', 'allow_custom_rank', 'cload', 'cstat', 'cregist', 'cstyles', 'ccount', 'cpost', 'ctop', 'cfriend', 'cjoin', 'cfrom', 'cposts', 'clevell', 'cleveld', 'cignore', 'cquick', 'cgg', 'csearch', 'cicq', 'cllogin', 'clevelp', 'cyahoo', 'cmsn', 'cjob', 'cinter', 'cemail', 'cbbcode', 'chtml', 'csmiles', 'clang', 'ctimezone', 'cbstyle', 'refresh', 'meta_keywords', 'meta_description', 'cavatar', 'clog', 'cagent', 'login_require', 'crestrict', 'validate', 'button_b', 'button_i', 'button_u', 'button_q', 'button_c', 'button_l', 'button_im', 'button_ur', 'button_ce', 'button_f', 'button_s', 'button_hi', 'color_box', 'size_box', 'glow_box', 'freak', 'allow_bbcode_quest', 'sql', 'cregist_b', 'allow_custom_color', 'custom_color_view', 'custom_color_use', 'post_icon', 'auto_date', 'newest', 'download', 'ipview', 'show_badwords', 'address_whois', 'u_o_t_d', 'expire', 'expire_value', 'numer_gg', 'haslo_gg', 'block_time', 'max_login_error', 'min_password_len', 'force_complex_password', 'password_not_login', 'del_user_notify', 'require_aim', 'require_website', 'require_location', 'post_footer', 'graphic', 'max_sig_custom_rank', 'max_sig_location', 'custom_color_mod', 'custom_rank_mod', 'allow_sig_image', 'sig_images_path', 'sig_image_filesize', 'sig_image_max_width', 'sig_image_max_height', 'hide_viewed_admin', 'hide_edited_admin', 'who_viewed', 'who_viewed_admin', 'edit_time', 'gender', 'require_gender', 'main_admin_id', 'day_to_prune', 'banner_top', 'banner_top_enable', 'banner_bottom', 'banner_bottom_enable', 'header_enable', 'not_edit_admin', 'staff_forums', 'staff_enable', 'smilies_columns', 'smilies_rows', 'smilies_w_columns', 'generate_time', 'name_color', 'desc_color', 'mod_nick_color', 'warnings_enable', 'mod_warnings', 'mod_edit_warnings', 'mod_value_warning', 'write_warnings', 'ban_warnings', 'expire_warnings', 'warnings_mod_public', 'viewtopic_warnings', 'board_msg_enable', 'board_msg', 'width_forum', 'width_table', 'width_color1', 'width_color2', 'table_border', 'rbuild_search', 'generate_time_admin', 'r_a_r_time', 'visitors', 'email_return_path', 'email_from', 'poster_posts', 'sub_forum', 'sub_forum_over', 'split_cat', 'split_cat_over', 'last_topic_title', 'last_topic_title_over', 'last_topic_title_length', 'sub_level_links', 'sub_level_links_over', 'display_viewonline', 'display_viewonline_over', 'ignore_topics', 'topic_color', 'topic_color_all', 'topic_color_mod', 'allow_sig_image_img', 'last_dtable_notify', 'report_no_guestes', 'report_no_auth_users', 'report_no_auth_groups', 'report_disabled_users', 'report_disabled_groups', 'report_only_admin', 'report_popup_height', 'report_popup_width', 'report_popup_links_target', 'report_disable', 'allow_avatar', 'last_visitors_time', 'max_sig_chars_admin', 'max_sig_chars_mod', 'viewonline', 'restrict_smilies', 'topic_preview', 'not_anonymous_posting', 'not_anonymous_quickreply', 'max_smilies', 'search_enable', 'overlib', 'notify_gg', 'admin_notify_gg', 'admin_notify_reply', 'admin_notify_message', 'topic_start_date', 'topic_start_dateformat', 'autorepair_tables', 'check_address', 'echange_banner', 'banners_list', 'split_messages', 'split_messages_admin', 'split_messages_mod', 'admin_html', 'jr_admin_html', 'mod_html', 'helped', 'del_notify_method', 'del_notify_enable', 'del_notify_choice', 'open_in_windows', 'title_explain', 'show_action_unlocked', 'show_action_locked', 'show_action_moved', 'show_action_expired', 'show_action_edited_by_others', 'show_action_edited_self', 'show_action_edited_self_all', 'allow_mod_delete_actions', 'show_rules', 'mod_spy', 'mod_spy_admin', 'post_overlib', 'ph_days', 'ph_len', 'ph_mod', 'ph_mod_delete', 'newestuser', 'topiccount', 'postcount', 'usercount', 'lastpost', 'anonymous_simple', 'onmouse', 'data', 'last_resync', 'advert', 'advert_foot', 'view_ad_by', 'advert_width', 'advert_separator', 'advert_separator_l', 'adv_person_time', 'group_rank_hack_version', 'disable_type', 'xs_auto_compile', 'xs_auto_recompile', 'xs_use_cache', 'xs_php', 'xs_def_template', 'xs_check_switches', 'xs_warn_includes', 'xs_ftp_host', 'xs_ftp_login', 'xs_ftp_path', 'xs_downloads_count', 'xs_downloads_default', 'xs_shownav', 'xs_template_time', 'xs_version', 'rh_without_days', 'rh_max_posts', 'public_category');

		for($i = 0; $i < count($config_fields); $i++)
		{
			$sql[] = "DELETE FROM " . $table_prefix . "config WHERE config_name = '" . $config_fields[$i] . "'";
		}

		$n = 0;
		$message = '';
		while($sql[$n])
		{
			$message .= ($mods[$n-1] != $mods[$n]) ? $mods[$n] : '';
			if ( !$result = $db->sql_query($sql[$n]) )
			{
				$sql_error = $db->sql_error();
				$debug_text = '';
				if ( $sql_error['message'] != '' )
				{
					$debug_text .= 'SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
				}
				$message .= '<tr><td class="row1" align="left"><span class="gensmall"><b><span style="color: #FF0000">[' . $lang['query_not_executed'] . ']</span></b><font size="1"> line: '.($n+1).' , '.$sql[$n].'</span> <b>( ' . $debug_text . ' )</b></span></td></tr>';
			}
			else
			{
				$message .='<tr><td class="row1" align="left"><span class="gensmall"><b><span style="color: #0000fF">[' . $lang['query_executed'] . ']</span></b><font size="1"> line: '.($n+1).' , '.$sql[$n].'</font></span></td></tr>';
			}
			$n++;
		}
		$template->assign_block_vars('topicrow', array(
			'MESSAGES' => $message)
		);
		$template->assign_vars(array(
			'EXPLANATION' => $lang['uninstall_explain'],
			'ACTION' => '<td class="row3" align="center">' . $lang['uninstall_end'] . '</td>')
		);
	}
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>