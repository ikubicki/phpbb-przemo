<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

// Here you can include new installed mod if needed
//
// include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_mod1.' . $phpEx);
// include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_mod2.' . $phpEx);
// include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_mod3.' . $phpEx);

$modules_data = array(
	'General' => array(
		'Configuration' => array("admin_board.$phpEx?mode=config", 1),
		'Config_setup' => array("admin_board_setup.$phpEx", 1),
		'Warnings' => array("admin_board.$phpEx?mode=warnings", 3),
		'ShoutBox' => array("admin_shoutbox.$phpEx", 4),
		'Updates' => array("admin_update.$phpEx", 5),
		'Styles' => array("xs_frameset.$phpEx?action=menu", 6),
		'Mass_Email' => array("admin_mass_email.$phpEx", 7),
		'Smilies' => array("admin_smilies.$phpEx", 9),
		'Word_Censor' => array("admin_words.$phpEx", 10),
		'Advert_title' => array("admin_advert.$phpEx", 11),
	),
	'Users' => array(
		'Users' => array("admin_users_list.$phpEx", 12),
		'Ban_Management' => array("admin_user_bantron.$phpEx", 14),
		'Inactive_title' => array("admin_account.$phpEx", 15),
		'Seeker' => array("../seeker.$phpEx", 19),
		'adv_person' => array("admin_advert_person.$phpEx", 16),
		'Custom_fields' => array("admin_custom_fields.$phpEx", 17),
		'Disallow' => array("admin_disallow.$phpEx", 18),
		'Prune_users' => array("admin_prune_users.$phpEx", 20),
		'Prune_User_Posts' => array("admin_prune_user_posts.$phpEx", 21),
		'Resync_page_posts' => array("admin_post_count_resync.$phpEx", 22),
	),
	'Groups' => array(
		'Manage' => array("admin_groups.$phpEx", 28),
		'Permissions' => array("admin_ug_auth.$phpEx?mode=group", 29),
		'Group_rank_order' => array("admin_group_rank.$phpEx", 30),
		'Ranks' => array("admin_ranks.$phpEx", 99),
	),
	'Forums' => array(
		'Manage' => array("admin_forums.$phpEx", 23),
		'Permissions' => array("admin_forumauth.$phpEx", 24),
        'Permissions_List'   => array("admin_forumauth_list.$phpEx", 120),
		'OverallPermissions' => array("admin_overall_forumauth.$phpEx", 25),
		'Prune' => array("admin_forum_prune.$phpEx", 26),
		'Resync_Stats' => array("admin_resync_forum_stats.$phpEx", 27),
	),

	'Attachments' => array(
		'Configuration' => array("admin_attachments.$phpEx?mode=manage", 36),
		'Control_Panel' => array("admin_attach_cp.$phpEx", 37),
		'Special_categories' => array("admin_attachments.$phpEx?mode=cats", 56),
		'Quota_limits' => array("admin_attachments.$phpEx?mode=quota", 57),
		'Extension_control' => array("admin_extensions.$phpEx?mode=extensions", 38),
		'Extension_group_manage' => array("admin_extensions.$phpEx?mode=groups", 60),
		'Forbidden_extensions' => array("admin_extensions.$phpEx?mode=forbidden", 61),
		'Shadow_attachments' => array("admin_attachments.$phpEx?mode=shadow", 58),
		'Sync_attachments' => array("admin_attachments.$phpEx?mode=sync", 59),
	),
	'Edit' => array(
		'FAQ' => array("admin_faq_editor.$phpEx?file=faq", 45),
		'BBCode_guide' => array("admin_faq_editor.$phpEx?file=bbcode", 71),
	),
	'Logs' => array(
		'LogsActions' => array("admin_logging.$phpEx", 46),
		'logs' => array("admin_logs.$phpEx", 47),
	),
	'SQL' => array(
		'Permissions' => array("admin_no_access.$phpEx", 0),
		'Backup_DB' => array("admin_db_utilities.$phpEx?perform=backup", 48),
		'Restore_DB' => array("admin_db_utilities.$phpEx?perform=restore", 72),
		'Optimize_DB' => array("admin_db_utilities.$phpEx?perform=optimize", 73),
		'MySQL' => array("admin_mysql.$phpEx", 49),
		'Rebuild_search' => array("admin_rebuild_search.$phpEx", 50),
		'MySqlAdmin' => array("admin_sql.$phpEx", 51),
		'PHP Info' => array("admin_phpinfo.$phpEx", 52),
		//'Uninstall18' => array("admin_uninstall.$phpEx", 0),
	),
	'Report_post' => array(
		'Configuration' => array("admin_report.$phpEx?mode=config", 53),
		'Permissions' => array("admin_report.$phpEx?mode=auth", 53),
	),
	'Statistics' => array(
		'Statistics_management' => array("admin_statistics.$phpEx?mode=manage", 54),
		'Statistics_config' => array("admin_statistics.$phpEx?mode=config", 74),
	),
	'Poll Admin' => array(
		'Poll Results' => array("admin_voting.$phpEx", 55),
	),
);

if ( $userdata['user_id'] == $privid )
{
	$modules_data['Users']['Private_Messages'] = array("admin_priv_msgs.$phpEx", 0);
}
?>