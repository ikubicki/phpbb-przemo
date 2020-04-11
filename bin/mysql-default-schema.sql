/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `przemo` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `przemo`;

CREATE TABLE IF NOT EXISTS `advertisement` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `html` text,
  `email` varchar(128) DEFAULT '',
  `clicks` int(9) NOT NULL DEFAULT '0',
  `position` tinyint(1) NOT NULL DEFAULT '0',
  `porder` mediumint(4) NOT NULL DEFAULT '0',
  `added` int(11) NOT NULL DEFAULT '0',
  `expire` int(11) NOT NULL DEFAULT '0',
  `last_update` int(11) NOT NULL DEFAULT '0',
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `advertisement` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertisement` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `adv_person` (
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `person_id` mediumint(9) NOT NULL DEFAULT '0',
  `person_ip` char(8) DEFAULT '',
  PRIMARY KEY (`user_id`,`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `adv_person` DISABLE KEYS */;
/*!40000 ALTER TABLE `adv_person` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `anti_robotic_reg` (
  `session_id` char(32) NOT NULL DEFAULT '',
  `reg_key` char(4) NOT NULL DEFAULT '',
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `anti_robotic_reg` DISABLE KEYS */;
/*!40000 ALTER TABLE `anti_robotic_reg` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `attachments` (
  `attach_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `privmsgs_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id_1` mediumint(8) NOT NULL DEFAULT '0',
  `user_id_2` mediumint(8) NOT NULL DEFAULT '0',
  KEY `attach_id_post_id` (`attach_id`,`post_id`),
  KEY `attach_id_privmsgs_id` (`attach_id`,`privmsgs_id`),
  KEY `user_id_1` (`user_id_1`),
  KEY `user_id_2` (`user_id_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `attachments_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `attachments_config` DISABLE KEYS */;
INSERT INTO `attachments_config` (`config_name`, `config_value`) VALUES
	('allow_ftp_upload', '0'),
	('allow_pm_attach', '1'),
	('attachment_quota', '52428800'),
	('attachment_topic_review', '1'),
	('default_pm_quota', '0'),
	('default_upload_quota', '0'),
	('disable_mod', '0'),
	('display_order', '0'),
	('download_path', ''),
	('ftp_pass', ''),
	('ftp_pasv_mode', '1'),
	('ftp_path', ''),
	('ftp_server', ''),
	('ftp_user', ''),
	('img_create_thumbnail', '1'),
	('img_display_inlined', '1'),
	('img_imagick', ''),
	('img_link_height', '0'),
	('img_link_width', '0'),
	('img_max_height', '0'),
	('img_max_width', '0'),
	('img_min_thumb_filesize', '12000'),
	('max_attachments', '10'),
	('max_attachments_pm', '1'),
	('max_filesize', '262144'),
	('max_filesize_pm', '262144'),
	('show_apcp', '0'),
	('topic_icon', 'images/icon_clip.gif'),
	('upload_dir', 'files'),
	('upload_img', 'images/icon_clip.gif'),
	('use_gd2', '0');
/*!40000 ALTER TABLE `attachments_config` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `attachments_desc` (
  `attach_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `physical_filename` varchar(255) NOT NULL DEFAULT '',
  `real_filename` varchar(255) NOT NULL DEFAULT '',
  `download_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `mimetype` varchar(100) DEFAULT NULL,
  `filesize` int(20) NOT NULL DEFAULT '0',
  `filetime` int(11) NOT NULL DEFAULT '0',
  `thumbnail` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attach_id`),
  KEY `filetime` (`filetime`),
  KEY `physical_filename` (`physical_filename`(10)),
  KEY `filesize` (`filesize`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `attachments_desc` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachments_desc` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `attach_quota` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `quota_type` smallint(2) NOT NULL DEFAULT '0',
  `quota_limit_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  KEY `quota_type` (`quota_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `attach_quota` DISABLE KEYS */;
/*!40000 ALTER TABLE `attach_quota` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `auth_access` (
  `group_id` mediumint(8) NOT NULL DEFAULT '0',
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `auth_view` tinyint(1) NOT NULL DEFAULT '0',
  `auth_read` tinyint(1) NOT NULL DEFAULT '0',
  `auth_post` tinyint(1) NOT NULL DEFAULT '0',
  `auth_reply` tinyint(1) NOT NULL DEFAULT '0',
  `auth_edit` tinyint(1) NOT NULL DEFAULT '0',
  `auth_delete` tinyint(1) NOT NULL DEFAULT '0',
  `auth_sticky` tinyint(1) NOT NULL DEFAULT '0',
  `auth_announce` tinyint(1) NOT NULL DEFAULT '0',
  `auth_globalannounce` tinyint(1) NOT NULL DEFAULT '0',
  `auth_vote` tinyint(1) NOT NULL DEFAULT '0',
  `auth_pollcreate` tinyint(1) NOT NULL DEFAULT '0',
  `auth_attachments` tinyint(1) NOT NULL DEFAULT '0',
  `auth_mod` tinyint(1) NOT NULL DEFAULT '0',
  `auth_download` tinyint(1) NOT NULL DEFAULT '0',
  KEY `group_id` (`group_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `auth_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_access` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `banlist` (
  `ban_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ban_userid` mediumint(8) NOT NULL DEFAULT '0',
  `ban_ip` char(8) NOT NULL DEFAULT '',
  `ban_email` varchar(255) DEFAULT NULL,
  `ban_time` int(11) DEFAULT NULL,
  `ban_expire_time` int(11) DEFAULT NULL,
  `ban_by_userid` mediumint(8) DEFAULT NULL,
  `ban_priv_reason` text,
  `ban_pub_reason_mode` tinyint(1) DEFAULT NULL,
  `ban_pub_reason` text,
  `ban_host` varchar(255) DEFAULT '',
  PRIMARY KEY (`ban_id`),
  KEY `ban_ip_user_id` (`ban_ip`,`ban_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `banlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `banlist` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(254) DEFAULT NULL,
  `cat_order` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat_main_type` char(1) DEFAULT NULL,
  `cat_main` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat_desc` text NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `cat_order` (`cat_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_order`, `cat_main_type`, `cat_main`, `cat_desc`) VALUES
	(1, 'Główna kategoria forum', 10, 'c', 0, 'Główna kategoria forum'),
	(3, 'Kategoria SubForów', 40, 'f', 2, ''),
	(4, 'Kategoria Sondy', 80, 'c', 1, '');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` text NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` (`config_name`, `config_value`) VALUES
	('address_whois', 'http://whois.domaintools.com/'),
	('admin_html', '0'),
	('admin_notify_gg', ''),
	('admin_notify_message', '0'),
	('admin_notify_reply', '1'),
	('advert', ''),
	('advert_foot', ''),
	('advert_separator', ' &bull; '),
	('advert_separator_l', '<br /><hr />'),
	('advert_width', '150'),
	('adv_person_time', '30'),
	('allow_autologin', '1'),
	('allow_avatar', '0'),
	('allow_avatar_local', '1'),
	('allow_avatar_remote', '1'),
	('allow_avatar_upload', '1'),
	('allow_bbcode', '1'),
	('allow_bbcode_quest', '0'),
	('allow_custom_color', '0'),
	('allow_custom_rank', '0'),
	('allow_html', '0'),
	('allow_html_tags', 'b,i,u,pre'),
	('allow_mod_delete_actions', '0'),
	('allow_namechange', '0'),
	('allow_photo_remote', '0'),
	('allow_photo_upload', '0'),
	('allow_sig', '1'),
	('allow_sig_image', '1'),
	('allow_sig_image_img', '0'),
	('allow_smilies', '1'),
	('anonymous_simple', '0'),
	('autorepair_tables', '1'),
	('auto_date', '1'),
	('avatar_filesize', '12144'),
	('avatar_gallery_path', 'images/avatars/gallery'),
	('avatar_max_height', '80'),
	('avatar_max_width', '80'),
	('avatar_path', 'images/avatars'),
	('banners_list', '<center><a href="http://phpbb.com" target="_blank"><img src="images/link_phpbb.gif" alt="" border="0" /></a></center><br />[banner]<center><a href="http://forumimages.com" target="_blank"><img src="images/link_forumimages.gif" alt="" border="0" /></a></center><br />[banner]<center><embed src="images/clock.swf" quality=high type="application/x-shockwave-flash" width="80" height="80" /></center>'),
	('banner_bottom', ''),
	('banner_bottom_enable', '0'),
	('banner_top', ''),
	('banner_top_enable', '0'),
	('ban_warnings', '6'),
	('block_time', '40'),
	('board_disable', ''),
	('board_email', 'twojlogin@twojadres.pl'),
	('board_email_form', '1'),
	('board_email_sig', 'Administrator Forum'),
	('board_msg', ''),
	('board_msg_enable', '0'),
	('board_timezone', '1.00'),
	('button_b', '1'),
	('button_c', '1'),
	('button_ce', '1'),
	('button_f', '1'),
	('button_hi', '1'),
	('button_i', '1'),
	('button_im', '1'),
	('button_l', '1'),
	('button_q', '1'),
	('button_s', '1'),
	('button_u', '1'),
	('button_ur', '1'),
	('cagent', '1'),
	('cavatar', '1'),
	('cbbcode', '0'),
	('cbstyle', '1'),
	('ccount', '1'),
	('cemail', '1'),
	('cfriend', '1'),
	('cfrom', '1'),
	('cgg', '1'),
	('check_address', '0'),
	('chtml', '0'),
	('cicq', '0'),
	('cignore', '1'),
	('cinter', '1'),
	('cjob', '0'),
	('cjoin', '1'),
	('clang', '1'),
	('cleveld', '0'),
	('clevell', '0'),
	('clevelp', '0'),
	('cllogin', '1'),
	('cload', '0'),
	('clog', '0'),
	('cmsn', '0'),
	('color_box', '1'),
	('cookie_domain', ''),
	('cookie_name', 'phpbb2mysql'),
	('cookie_path', '/'),
	('cookie_secure', '0'),
	('coppa_fax', ''),
	('coppa_mail', ''),
	('cpost', '1'),
	('cposts', '1'),
	('cquick', '1'),
	('cregist', '1'),
	('cregist_b', '0'),
	('crestrict', '0'),
	('csearch', '1'),
	('csmiles', '0'),
	('cstat', '1'),
	('cstyles', '1'),
	('ctimezone', '1'),
	('ctop', '1'),
	('custom_color_mod', '0'),
	('custom_color_use', '0'),
	('custom_color_view', '0'),
	('custom_rank_mod', '0'),
	('cyahoo', '0'),
	('data', ''),
	('day_to_prune', '120'),
	('default_dateformat', 'Y-m-d, H:i'),
	('default_style', '1'),
	('del_notify_choice', '0'),
	('del_notify_enable', '1'),
	('del_notify_method', '1'),
	('del_user_notify', '1'),
	('desc_color', ''),
	('disable_type', ''),
	('display_viewonline', '2'),
	('display_viewonline_over', '0'),
	('download', '1'),
	('echange_banner', '0'),
	('edit_time', '0'),
	('email_from', ''),
	('email_return_path', ''),
	('expire', '1'),
	('expire_value', '0'),
	('expire_warnings', '0'),
	('flood_interval', '20'),
	('force_complex_password', '0'),
	('freak', '1'),
	('gender', '1'),
	('generate_time', '1'),
	('generate_time_admin', '0'),
	('glow_box', '1'),
	('graphic', '1'),
	('group_rank_hack_version', '0'),
	('gzip_compress', '0'),
	('haslo_gg', ''),
	('header_enable', '0'),
	('helped', '0'),
	('hide_edited_admin', '0'),
	('hide_viewed_admin', '0'),
	('hot_threshold', '30'),
	('ignore_topics', '1'),
	('ipview', '0'),
	('jr_admin_html', '0'),
	('lastpost', ''),
	('last_dtable_notify', ''),
	('last_prune', '0'),
	('last_resync', '0'),
	('last_topic_title', '1'),
	('last_topic_title_length', '24'),
	('last_topic_title_over', '0'),
	('last_visitors_time', '24'),
	('last_visitors_time_count', '0'),
	('login_require', '0'),
	('main_admin_id', ''),
	('max_inbox_privmsgs', '50'),
	('max_login_error', '10'),
	('max_poll_options', '30'),
	('max_savebox_privmsgs', '50'),
	('max_sentbox_privmsgs', '25'),
	('max_sig_chars', '255'),
	('max_sig_chars_admin', '6'),
	('max_sig_chars_mod', '3'),
	('max_sig_custom_rank', '20'),
	('max_sig_location', '20'),
	('max_smilies', '24'),
	('meta_description', ''),
	('meta_keywords', ''),
	('min_password_len', '3'),
	('mod_edit_warnings', '0'),
	('mod_html', '0'),
	('mod_nick_color', ''),
	('mod_spy', '0'),
	('mod_spy_admin', '0'),
	('mod_value_warning', '1'),
	('mod_warnings', '1'),
	('name_color', ''),
	('newest', '1'),
	('newestuser', ''),
	('notify_gg', '1'),
	('not_anonymous_posting', '0'),
	('not_anonymous_quickreply', '0'),
	('not_edit_admin', '1'),
	('numer_gg', ''),
	('onmouse', '1'),
	('open_in_windows', '1'),
	('overlib', '1'),
	('override_user_style', '0'),
	('password_not_login', '0'),
	('photo_filesize', '40000'),
	('photo_max_height', '200'),
	('photo_max_width', '200'),
	('photo_path', 'images/photos'),
	('ph_days', '14'),
	('ph_len', '8'),
	('ph_mod', '0'),
	('ph_mod_delete', '0'),
	('postcount', ''),
	('poster_posts', '1'),
	('posts_per_page', '15'),
	('post_footer', '1'),
	('post_icon', '1'),
	('post_overlib', '1'),
	('privmsg_disable', '0'),
	('protection_get', '1'),
	('prune_enable', '0'),
	('public_category', ''),
	('rand_seed', '0'),
	('rand_seed_last_update', '0'),
	('rebuild_search', ''),
	('record_online_date', '0'),
	('record_online_users', '0'),
	('refresh', '0'),
	('report_disable', '1'),
	('report_disabled_groups', ''),
	('report_disabled_users', ''),
	('report_no_auth_groups', ''),
	('report_no_auth_users', ''),
	('report_no_guestes', '1'),
	('report_only_admin', '0'),
	('report_popup_height', '250'),
	('report_popup_links_target', '2'),
	('report_popup_width', '700'),
	('require_activation', '0'),
	('require_aim', '0'),
	('require_gender', '0'),
	('require_location', '0'),
	('require_website', '0'),
	('restrict_smilies', '0'),
	('rh_max_posts', '1000'),
	('rh_without_days', '3'),
	('ri_data', ''),
	('ri_time', ''),
	('r_a_r_time', '1'),
	('script_path', '/phpBB2/'),
	('search_enable', '1'),
	('search_keywords_max', '5'),
	('sendmail_fix', '0'),
	('server_name', 'www.myserver.tld'),
	('server_port', '80'),
	('session_length', '900'),
	('show_action_edited_by_others', '1'),
	('show_action_edited_self', '1'),
	('show_action_edited_self_all', '0'),
	('show_action_expired', '1'),
	('show_action_locked', '1'),
	('show_action_moved', '1'),
	('show_action_unlocked', '1'),
	('show_badwords', '1'),
	('show_rules', '0'),
	('sig_images_path', 'images/signatures'),
	('sig_image_filesize', '30000'),
	('sig_image_max_height', '50'),
	('sig_image_max_width', '400'),
	('sitename', 'Nazwa twojego forum'),
	('site_desc', 'Krótki tekst opisujący twoje forum'),
	('size_box', '1'),
	('smilies_columns', '4'),
	('smilies_path', 'images/smiles'),
	('smilies_rows', '8'),
	('smilies_w_columns', '8'),
	('smtp_delivery', '0'),
	('smtp_host', ''),
	('smtp_password', ''),
	('smtp_username', ''),
	('split_cat', '1'),
	('split_cat_over', '0'),
	('split_messages', '0'),
	('split_messages_admin', '0'),
	('split_messages_mod', '0'),
	('sql', 'http://'),
	('staff_enable', '1'),
	('staff_forums', '1'),
	('sub_forum', '1'),
	('sub_forum_over', '0'),
	('sub_level_links', '2'),
	('sub_level_links_over', '0'),
	('table_border', '6'),
	('title_explain', '1'),
	('topiccount', ''),
	('topics_per_page', '25'),
	('topic_color', '1'),
	('topic_color_all', '0'),
	('topic_color_mod', '1'),
	('topic_preview', '0'),
	('topic_start_date', '1'),
	('topic_start_dateformat', 'd-m-y'),
	('usercount', '2'),
	('u_o_t_d', '1'),
	('validate', '0'),
	('version', '1.12.9'),
	('viewonline', '0'),
	('viewtopic_warnings', '0'),
	('view_ad_by', '1'),
	('visitors', '1'),
	('warnings_enable', '1'),
	('warnings_mods_public', '1'),
	('who_viewed', '0'),
	('who_viewed_admin', '0'),
	('width_color1', ''),
	('width_color2', ''),
	('width_forum', '0'),
	('width_table', '800'),
	('write_warnings', '3');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `disallow` (
  `disallow_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `disallow_username` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`disallow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `disallow` DISABLE KEYS */;
/*!40000 ALTER TABLE `disallow` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `extensions` (
  `ext_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extension` varchar(100) NOT NULL DEFAULT '',
  `comment` varchar(100) DEFAULT '',
  PRIMARY KEY (`ext_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `extensions` DISABLE KEYS */;
INSERT INTO `extensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES
	(1, 1, 'gif', ''),
	(2, 1, 'png', ''),
	(3, 1, 'jpeg', ''),
	(4, 1, 'jpg', ''),
	(5, 1, 'tif', ''),
	(6, 1, 'tga', ''),
	(7, 2, 'gtar', ''),
	(8, 2, 'gz', ''),
	(9, 2, 'tar', ''),
	(10, 2, 'zip', ''),
	(11, 2, 'rar', ''),
	(12, 2, 'ace', ''),
	(13, 3, 'txt', ''),
	(14, 3, 'c', ''),
	(15, 3, 'h', ''),
	(16, 3, 'cpp', ''),
	(17, 3, 'hpp', ''),
	(18, 3, 'diz', ''),
	(19, 4, 'xls', ''),
	(20, 4, 'doc', ''),
	(21, 4, 'dot', ''),
	(22, 4, 'pdf', ''),
	(23, 4, 'ai', ''),
	(24, 4, 'ps', ''),
	(25, 4, 'ppt', ''),
	(26, 5, 'rm', ''),
	(27, 6, 'wma', ''),
	(31, 6, 'avi', ''),
	(32, 6, 'mpg', ''),
	(33, 6, 'mpeg', ''),
	(34, 6, 'mp3', ''),
	(35, 6, 'wav', '');
/*!40000 ALTER TABLE `extensions` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `extension_groups` (
  `group_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `group_name` char(20) NOT NULL DEFAULT '',
  `cat_id` tinyint(2) NOT NULL DEFAULT '0',
  `allow_group` tinyint(1) NOT NULL DEFAULT '0',
  `download_mode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `upload_icon` varchar(100) DEFAULT '',
  `max_filesize` int(20) NOT NULL DEFAULT '0',
  `forum_permissions` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `extension_groups` DISABLE KEYS */;
INSERT INTO `extension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES
	(1, 'Images', 1, 1, 1, '', 0, ''),
	(2, 'Archives', 0, 1, 1, '', 0, ''),
	(3, 'Plain Text', 0, 0, 1, '', 0, ''),
	(4, 'Documents', 0, 0, 1, '', 0, ''),
	(5, 'Real Media', 0, 0, 2, '', 0, ''),
	(6, 'Streams', 2, 0, 1, '', 0, ''),
	(7, 'Flash Files', 3, 0, 1, '', 0, '');
/*!40000 ALTER TABLE `extension_groups` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `forbidden_extensions` (
  `ext_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `extension` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ext_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `forbidden_extensions` DISABLE KEYS */;
INSERT INTO `forbidden_extensions` (`ext_id`, `extension`) VALUES
	(1, 'php'),
	(2, 'php3'),
	(3, 'php4'),
	(4, 'phtml'),
	(5, 'pl'),
	(6, 'asp'),
	(7, 'cgi');
/*!40000 ALTER TABLE `forbidden_extensions` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `forums` (
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cat_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_name` varchar(254) DEFAULT '',
  `forum_desc` text,
  `forum_status` tinyint(1) NOT NULL DEFAULT '0',
  `forum_order` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `forum_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_topics` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_last_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `prune_next` int(11) DEFAULT NULL,
  `prune_enable` tinyint(1) NOT NULL DEFAULT '0',
  `auth_view` tinyint(2) NOT NULL DEFAULT '0',
  `auth_read` tinyint(2) NOT NULL DEFAULT '0',
  `auth_post` tinyint(2) NOT NULL DEFAULT '0',
  `auth_reply` tinyint(2) NOT NULL DEFAULT '0',
  `auth_edit` tinyint(2) NOT NULL DEFAULT '0',
  `auth_delete` tinyint(2) NOT NULL DEFAULT '0',
  `auth_sticky` tinyint(2) NOT NULL DEFAULT '0',
  `auth_announce` tinyint(2) NOT NULL DEFAULT '0',
  `auth_globalannounce` tinyint(2) NOT NULL DEFAULT '3',
  `auth_vote` tinyint(2) NOT NULL DEFAULT '0',
  `auth_pollcreate` tinyint(2) NOT NULL DEFAULT '0',
  `auth_attachments` tinyint(2) NOT NULL DEFAULT '0',
  `auth_download` tinyint(2) NOT NULL DEFAULT '0',
  `password` varchar(20) NOT NULL DEFAULT '',
  `forum_sort` varchar(12) NOT NULL,
  `forum_color` varchar(6) NOT NULL DEFAULT '',
  `forum_link` varchar(255) DEFAULT NULL,
  `forum_link_internal` tinyint(1) NOT NULL DEFAULT '0',
  `forum_link_hit_count` tinyint(1) NOT NULL DEFAULT '0',
  `forum_link_hit` bigint(20) unsigned NOT NULL DEFAULT '0',
  `main_type` char(1) DEFAULT NULL,
  `forum_moderate` tinyint(1) NOT NULL DEFAULT '0',
  `no_count` tinyint(1) NOT NULL DEFAULT '0',
  `forum_trash` smallint(1) NOT NULL DEFAULT '0',
  `forum_separate` smallint(1) NOT NULL DEFAULT '2',
  `forum_show_ga` smallint(1) NOT NULL DEFAULT '1',
  `forum_tree_grade` tinyint(1) NOT NULL DEFAULT '3',
  `forum_tree_req` tinyint(1) NOT NULL DEFAULT '0',
  `forum_no_split` tinyint(1) NOT NULL DEFAULT '0',
  `forum_no_helped` tinyint(1) NOT NULL DEFAULT '0',
  `topic_tags` varchar(255) DEFAULT '',
  `locked_bottom` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`forum_id`),
  KEY `forums_order` (`forum_order`),
  KEY `cat_id` (`cat_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`),
  KEY `no_count` (`no_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `forums` DISABLE KEYS */;
INSERT INTO `forums` (`forum_id`, `cat_id`, `forum_name`, `forum_desc`, `forum_status`, `forum_order`, `forum_posts`, `forum_topics`, `forum_last_post_id`, `prune_next`, `prune_enable`, `auth_view`, `auth_read`, `auth_post`, `auth_reply`, `auth_edit`, `auth_delete`, `auth_sticky`, `auth_announce`, `auth_globalannounce`, `auth_vote`, `auth_pollcreate`, `auth_attachments`, `auth_download`, `password`, `forum_sort`, `forum_color`, `forum_link`, `forum_link_internal`, `forum_link_hit_count`, `forum_link_hit`, `main_type`, `forum_moderate`, `no_count`, `forum_trash`, `forum_separate`, `forum_show_ga`, `forum_tree_grade`, `forum_tree_req`, `forum_no_split`, `forum_no_helped`, `topic_tags`, `locked_bottom`) VALUES
	(1, 1, 'Testowe forum', 'Testowe forum.', 0, 20, 1, 1, 5, NULL, 0, 0, 0, 1, 0, 1, 1, 3, 3, 3, 1, 1, 1, 1, '', 'SORT_FPDATE', '', '', 0, 0, 0, 'c', 0, 0, 0, 2, 1, 3, 0, 0, 0, '', 0),
	(2, 1, 'Test SubForów', 'W tym forum, znajdują się dwa testowe fora, można w nim rówwnież pisać tematy', 0, 30, 1, 1, 3, NULL, 0, 0, 0, 1, 0, 1, 1, 3, 3, 3, 1, 1, 1, 1, '', 'SORT_FPDATE', '', '', 0, 0, 0, 'c', 0, 0, 0, 2, 1, 3, 0, 0, 0, '', 0),
	(3, 3, 'Testowe podforum 1', 'Testowe podforum 1', 0, 50, 0, 0, 0, NULL, 0, 0, 0, 1, 0, 1, 1, 3, 3, 3, 1, 1, 1, 1, '', 'SORT_FPDATE', '', '', 0, 0, 0, 'c', 0, 0, 0, 2, 1, 3, 0, 0, 0, '', 0),
	(4, 3, 'Testowe podforum 2', 'Testowe podforum 2', 0, 60, 0, 0, 0, NULL, 0, 0, 0, 1, 0, 1, 1, 3, 3, 3, 1, 1, 1, 1, '', 'SORT_FPDATE', '', '', 0, 0, 0, 'c', 0, 0, 0, 2, 1, 3, 0, 0, 0, '', 0),
	(6, 4, 'Forum moderacji', 'W tym forum tylko moderatorzy mogą zakładać nowe tematy', 0, 90, 2, 2, 9, NULL, 0, 0, 0, 1, 0, 1, 1, 3, 3, 3, 1, 1, 1, 1, '', 'SORT_FPDATE', 'FF0000', '', 0, 0, 0, 'c', 0, 0, 0, 2, 1, 3, 0, 0, 0, '', 0),
	(7, 4, 'Sondy moderacji', 'To jest forum do umieszczania sond, tutaj tylko moderatorzy mogą umieszczać sondy i pisać posty.', 0, 100, 1, 1, 7, NULL, 0, 0, 0, 1, 0, 1, 1, 3, 3, 3, 1, 1, 1, 1, '', 'SORT_FPDATE', '32CD32', '', 0, 0, 0, 'c', 0, 0, 0, 2, 1, 3, 0, 0, 0, '', 0);
/*!40000 ALTER TABLE `forums` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `forum_prune` (
  `prune_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `prune_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `prune_freq` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`prune_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `forum_prune` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_prune` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `group_type` tinyint(4) NOT NULL DEFAULT '1',
  `group_name` varchar(120) NOT NULL DEFAULT '',
  `group_description` varchar(255) NOT NULL DEFAULT '',
  `group_moderator` mediumint(8) NOT NULL DEFAULT '0',
  `group_single_user` tinyint(1) NOT NULL DEFAULT '1',
  `group_order` mediumint(8) NOT NULL DEFAULT '0',
  `group_count` int(4) unsigned DEFAULT '99999999',
  `group_count_enable` smallint(2) unsigned DEFAULT '0',
  `group_mail_enable` smallint(1) DEFAULT '0',
  `group_no_unsub` smallint(1) DEFAULT '0',
  `group_color` varchar(6) DEFAULT NULL,
  `group_prefix` varchar(8) DEFAULT NULL,
  `group_style` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `group_single_user` (`group_single_user`),
  KEY `group_type` (`group_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`group_id`, `group_type`, `group_name`, `group_description`, `group_moderator`, `group_single_user`, `group_order`, `group_count`, `group_count_enable`, `group_mail_enable`, `group_no_unsub`, `group_color`, `group_prefix`, `group_style`) VALUES
	(1, 1, 'Anonymous', 'Personal User', 0, 1, 0, 99999999, 0, 0, 0, NULL, NULL, NULL),
	(2, 1, 'Admin', 'Personal User', 0, 1, 0, 99999999, 0, 0, 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `ignores` (
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_ignore` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`user_ignore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `ignores` DISABLE KEYS */;
/*!40000 ALTER TABLE `ignores` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `jr_admin_users` (
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `user_jr_admin` varchar(254) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `jr_admin_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `jr_admin_users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `logs` (
  `id_log` mediumint(10) NOT NULL AUTO_INCREMENT,
  `mode` varchar(50) DEFAULT '',
  `topic_id` mediumint(10) DEFAULT '0',
  `user_id` mediumint(8) DEFAULT '0',
  `username` varchar(25) DEFAULT '',
  `user_ip` char(8) NOT NULL DEFAULT '0',
  `time` int(11) DEFAULT '0',
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `mass_email` (
  `mass_email_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `mass_email_text` longtext,
  `mass_email_subject` text,
  `mass_email_bcc` longtext,
  `mass_email_html` tinyint(1) NOT NULL DEFAULT '0',
  `mass_email_to` varchar(128) DEFAULT '',
  PRIMARY KEY (`mass_email_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `mass_email` DISABLE KEYS */;
/*!40000 ALTER TABLE `mass_email` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `poster_id` mediumint(8) NOT NULL DEFAULT '0',
  `post_time` int(11) NOT NULL DEFAULT '0',
  `post_start_time` int(11) NOT NULL DEFAULT '0',
  `poster_ip` char(8) NOT NULL DEFAULT '',
  `post_username` varchar(25) NOT NULL DEFAULT '',
  `enable_bbcode` tinyint(1) NOT NULL DEFAULT '1',
  `enable_html` tinyint(1) NOT NULL DEFAULT '0',
  `enable_smilies` tinyint(1) NOT NULL DEFAULT '1',
  `enable_sig` tinyint(1) NOT NULL DEFAULT '1',
  `post_edit_time` int(11) DEFAULT '0',
  `post_edit_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `post_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `user_agent` varchar(255) NOT NULL DEFAULT '',
  `post_icon` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `post_expire` int(11) NOT NULL DEFAULT '0',
  `reporter_id` mediumint(8) NOT NULL DEFAULT '0',
  `post_marked` enum('n','y') DEFAULT NULL,
  `post_approve` tinyint(1) NOT NULL DEFAULT '1',
  `poster_delete` tinyint(1) DEFAULT '0',
  `post_edit_by` mediumint(8) NOT NULL DEFAULT '0',
  `post_parent` mediumint(8) NOT NULL DEFAULT '0',
  `post_order` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_id` (`poster_id`),
  KEY `post_time` (`post_time`),
  KEY `reporter_id` (`reporter_id`),
  KEY `post_parent` (`post_parent`),
  KEY `post_approve` (`post_approve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`post_id`, `topic_id`, `forum_id`, `poster_id`, `post_time`, `post_start_time`, `poster_ip`, `post_username`, `enable_bbcode`, `enable_html`, `enable_smilies`, `enable_sig`, `post_edit_time`, `post_edit_count`, `post_attachment`, `user_agent`, `post_icon`, `post_expire`, `reporter_id`, `post_marked`, `post_approve`, `poster_delete`, `post_edit_by`, `post_parent`, `post_order`) VALUES
	(3, 2, 2, 2, 1064458873, 0, '7f000001', '', 1, 0, 1, 0, NULL, 0, 0, '', 0, 0, 0, 'n', 1, 0, 0, 0, 0),
	(5, 4, 1, 2, 1065136668, 0, '7f000001', '', 1, 0, 0, 0, NULL, 0, 0, '', 2, 0, 0, 'n', 1, 0, 0, 0, 0),
	(7, 5, 7, 2, 1065137203, 0, '7f000001', '', 1, 0, 1, 0, NULL, 0, 0, '', 0, 0, 0, 'n', 1, 0, 0, 0, 0),
	(8, 6, 6, 2, 1065137320, 0, '7f000001', '', 1, 0, 1, 0, NULL, 0, 0, '', 0, 0, 0, 'n', 1, 0, 0, 0, 0),
	(9, 7, 6, 2, 1065137383, 0, '7f000001', '', 1, 0, 1, 0, NULL, 0, 0, '', 0, 0, 0, 'n', 1, 0, 0, 0, 0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `posts_text` (
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `bbcode_uid` char(10) NOT NULL DEFAULT '',
  `post_subject` char(60) NOT NULL DEFAULT '',
  `post_text` text,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `posts_text` DISABLE KEYS */;
INSERT INTO `posts_text` (`post_id`, `bbcode_uid`, `post_subject`, `post_text`) VALUES
	(3, 'b63934e592', 'Testowy temat w SubForum', 'Testowy temat w SubForum'),
	(5, 'bcf3b5262c', 'Witaj na forum phpBB modified by Przemo', 'Dziękuję, za wybranie [URL=http://www.przemo.org/phpBB2/]phpBB modified by Przemo[/URL] do obsługi Twojego Forum.\r\n\r\nZapoznaj się dokładnie z instrukcjami zamieszczonymi w pliku [b:bcf3b5262c]/docs/readme.html[/b:bcf3b5262c] w katalogu forum.'),
	(7, '2fe4a4ef6b', 'Sonda1', 'sonda1'),
	(8, 'c93fefdf03', 'Test trzeciego newsa', '[URL=http://www.przemo.org]test[/URL] [b:c93fefdf03]test[/b:c93fefdf03] [size=18:c93fefdf03][shadow=red:c93fefdf03]test[/shadow:c93fefdf03][/size:c93fefdf03]\r\n\r\nt\r\n\r\ne\r\n\r\ns\r\n\r\nt\r\n\r\n.\r\n.\r\n.\r\n.\r\n.\r\n.\r\n.\r\n\r\nn\r\n\r\ne'),
	(9, 'e7c9e3e71f', 'test drugiego newsa', '[URL=http://www.przemo.org]test[/URL] [b:e7c9e3e71f]test[/b:e7c9e3e71f] [size=18:e7c9e3e71f][shadow=red:e7c9e3e71f]test[/shadow:e7c9e3e71f][/size:e7c9e3e71f]\r\n\r\nt\r\n\r\ne\r\n\r\ns\r\n\r\nt\r\n\r\n\r\n\r\nn\r\n\r\ne\r\n\r\nw\r\n\r\ns\r\n\r\na');
/*!40000 ALTER TABLE `posts_text` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `posts_text_history` (
  `th_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `th_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `th_post_text` text,
  `th_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `th_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`th_id`),
  KEY `th_post_id` (`th_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `posts_text_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_text_history` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `privmsgs` (
  `privmsgs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `privmsgs_type` tinyint(4) NOT NULL DEFAULT '0',
  `privmsgs_subject` varchar(255) NOT NULL DEFAULT '0',
  `privmsgs_from_userid` mediumint(8) NOT NULL DEFAULT '0',
  `privmsgs_to_userid` mediumint(8) NOT NULL DEFAULT '0',
  `privmsgs_date` int(11) NOT NULL DEFAULT '0',
  `privmsgs_ip` char(8) NOT NULL DEFAULT '',
  `privmsgs_enable_bbcode` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_enable_html` tinyint(1) NOT NULL DEFAULT '0',
  `privmsgs_enable_smilies` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_attach_sig` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_attachment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`privmsgs_id`),
  KEY `privmsgs_from_userid` (`privmsgs_from_userid`),
  KEY `privmsgs_to_userid` (`privmsgs_to_userid`),
  KEY `privmsgs_type` (`privmsgs_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `privmsgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `privmsgs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `privmsgs_text` (
  `privmsgs_text_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `privmsgs_bbcode_uid` char(10) NOT NULL DEFAULT '0',
  `privmsgs_text` text,
  PRIMARY KEY (`privmsgs_text_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `privmsgs_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `privmsgs_text` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `quota_limits` (
  `quota_limit_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `quota_desc` varchar(20) NOT NULL DEFAULT '',
  `quota_limit` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`quota_limit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `quota_limits` DISABLE KEYS */;
INSERT INTO `quota_limits` (`quota_limit_id`, `quota_desc`, `quota_limit`) VALUES
	(1, 'Low', 262144),
	(2, 'Medium', 2097152),
	(3, 'High', 5242880);
/*!40000 ALTER TABLE `quota_limits` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `ranks` (
  `rank_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `rank_title` varchar(50) NOT NULL DEFAULT '',
  `rank_min` mediumint(8) NOT NULL DEFAULT '0',
  `rank_special` tinyint(1) DEFAULT '0',
  `rank_image` varchar(255) DEFAULT '',
  `rank_group` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `ranks` DISABLE KEYS */;
INSERT INTO `ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_special`, `rank_image`, `rank_group`) VALUES
	(1, 'Administrator', -1, 1, NULL, 0);
/*!40000 ALTER TABLE `ranks` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `read_history` (
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  KEY `topic_id` (`topic_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `read_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `read_history` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `search_results` (
  `search_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` char(32) NOT NULL DEFAULT '',
  `search_array` longtext NOT NULL,
  `search_time` int(11) NOT NULL,
  PRIMARY KEY (`search_id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `search_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_results` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `search_wordlist` (
  `word_text` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `word_common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`word_text`),
  KEY `word_id` (`word_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `search_wordlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_wordlist` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `search_wordmatch` (
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `word_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title_match` tinyint(1) NOT NULL DEFAULT '0',
  KEY `post_id` (`post_id`),
  KEY `word_id` (`word_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `search_wordmatch` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_wordmatch` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` char(32) NOT NULL DEFAULT '',
  `session_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `session_start` int(11) NOT NULL DEFAULT '0',
  `session_time` int(11) NOT NULL DEFAULT '0',
  `session_ip` char(8) NOT NULL DEFAULT '0',
  `session_page` int(11) NOT NULL DEFAULT '0',
  `session_logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `session_admin` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  KEY `session_user_id` (`session_user_id`),
  KEY `session_id_ip_user_id` (`session_id`,`session_ip`,`session_user_id`),
  KEY `session_time` (`session_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `sessions_keys` (
  `key_id` varchar(32) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `last_ip` varchar(8) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`key_id`,`user_id`),
  KEY `last_login` (`last_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `sessions_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions_keys` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sb_user_id` int(11) NOT NULL DEFAULT '0',
  `msg` text NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sb_user_id` (`sb_user_id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `shoutbox` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoutbox` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `shoutbox_config` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `shoutbox_config` DISABLE KEYS */;
INSERT INTO `shoutbox_config` (`config_name`, `config_value`) VALUES
	('allow_bbcode', '1'),
	('allow_delete', '0'),
	('allow_delete_all', '0'),
	('allow_delete_m', '0'),
	('allow_edit', '0'),
	('allow_edit_all', '0'),
	('allow_edit_m', '0'),
	('allow_guest', '0'),
	('allow_guest_view', '1'),
	('allow_smilies', '1'),
	('allow_users', '1'),
	('allow_users_view', '1'),
	('banned_user_id', ''),
	('banned_user_id_view', ''),
	('count_msg', '30'),
	('date_format', 'd.m.y, H:i:s'),
	('date_on', '1'),
	('delete_days', '30'),
	('links_names', '1'),
	('make_links', '1'),
	('sb_group_sel', 'all'),
	('shoutbox_on', '1'),
	('shoutbox_smilies', '0'),
	('shout_height', '130'),
	('shout_refresh', '5'),
	('shout_width', '630'),
	('text_lenght', '500'),
	('usercall', '0'),
	('word_lenght', '80');
/*!40000 ALTER TABLE `shoutbox_config` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `smilies` (
  `smilies_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT '',
  `smile_url` varchar(100) DEFAULT '',
  `emoticon` varchar(75) DEFAULT '',
  `smile_order` mediumint(8) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`smilies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `smilies` DISABLE KEYS */;
INSERT INTO `smilies` (`smilies_id`, `code`, `smile_url`, `emoticon`, `smile_order`) VALUES
	(1, ':-)', 'icon_smile.gif', '', 1),
	(2, ';-)', 'icon_wink.gif', '', 2),
	(3, ':-&gt;', 'icon_smile2.gif', '', 3),
	(4, ':-D', 'icon_biggrin.gif', '', 4),
	(5, ':-P', 'icon_razz.gif', '', 5),
	(6, ':-o', 'icon_surprised.gif', '', 6),
	(7, ':mrgreen:', 'icon_mrgreen.gif', '', 7),
	(8, ':lol:', 'icon_lol.gif', '', 8),
	(9, ':-(', 'icon_sad.gif', '', 9),
	(10, ':-|', 'icon_neutral.gif', '', 10),
	(11, ':-/', 'icon_curve.gif', '', 11),
	(12, ':-?', 'icon_confused.gif', '', 12),
	(13, ':-x', 'icon_mad.gif', '', 13),
	(14, ':shock:', 'icon_eek.gif', '', 14),
	(15, ':cry:', 'icon_cry.gif', '', 15),
	(16, ':oops:', 'icon_redface.gif', '', 16),
	(17, '8-)', 'icon_cool.gif', '', 17),
	(18, ':evil:', 'icon_evil.gif', '', 18),
	(19, ':roll:', 'icon_rolleyes.gif', '', 19),
	(20, ':!:', 'icon_exclaim.gif', '', 20),
	(21, ':?:', 'icon_question.gif', '', 21),
	(22, ':idea:', 'icon_idea.gif', '', 22),
	(23, ':arrow:', 'icon_arrow.gif', '', 23);
/*!40000 ALTER TABLE `smilies` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `stats_config` (
  `config_name` varchar(50) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `stats_config` DISABLE KEYS */;
INSERT INTO `stats_config` (`config_name`, `config_value`) VALUES
	('install_date', 'time()'),
	('modules_dir', 'stat_modules'),
	('page_views', '0'),
	('return_limit', '10'),
	('version', '2.1.3');
/*!40000 ALTER TABLE `stats_config` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `stats_modules` (
  `module_id` tinyint(8) NOT NULL DEFAULT '0',
  `name` varchar(150) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `installed` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `update_time` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_value` tinyint(2) NOT NULL DEFAULT '0',
  `module_info_cache` blob,
  `module_db_cache` blob,
  `module_result_cache` blob,
  `module_info_time` int(10) unsigned NOT NULL DEFAULT '0',
  `module_cache_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `stats_modules` DISABLE KEYS */;
INSERT INTO `stats_modules` (`module_id`, `name`, `active`, `installed`, `display_order`, `update_time`, `auth_value`, `module_info_cache`, `module_db_cache`, `module_result_cache`, `module_info_time`, `module_cache_time`) VALUES
	(1, 'new_posts_by_month', 1, 1, 10, 24, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(2, 'new_topics_by_month', 1, 1, 20, 24, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(3, 'new_users_by_month', 1, 1, 30, 24, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(4, 'most_active_topics', 1, 1, 40, 0, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(5, 'most_viewed_topics', 1, 1, 50, 0, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(6, 'latest_topics', 1, 1, 60, 0, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(7, 'priv_msgs', 1, 1, 70, 48, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(8, 'top_posters', 1, 1, 80, 24, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(9, 'last_active_users', 1, 1, 90, 0, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(10, 'users_from_where', 1, 1, 100, 48, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(12, 'users_gender', 1, 1, 120, 48, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(13, 'top_smilies', 1, 1, 130, 64, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(14, 'top_words', 1, 1, 140, 64, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0),
	(15, 'user_agent', 1, 1, 150, 64, 0, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, _binary 0x5B424C4F425D, 0, 0);
/*!40000 ALTER TABLE `stats_modules` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `themes` (
  `themes_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(30) NOT NULL DEFAULT '',
  `style_name` varchar(30) NOT NULL DEFAULT '',
  `head_stylesheet` varchar(100) DEFAULT NULL,
  `body_background` varchar(100) DEFAULT NULL,
  `body_bgcolor` varchar(6) DEFAULT NULL,
  `body_text` varchar(6) DEFAULT NULL,
  `body_link` varchar(6) DEFAULT NULL,
  `body_vlink` varchar(6) DEFAULT NULL,
  `body_alink` varchar(6) DEFAULT NULL,
  `body_hlink` varchar(6) DEFAULT NULL,
  `tr_color1` varchar(6) DEFAULT NULL,
  `tr_color2` varchar(6) DEFAULT NULL,
  `tr_color3` varchar(6) DEFAULT NULL,
  `tr_color_helped` varchar(6) DEFAULT NULL,
  `tr_class1` varchar(25) DEFAULT NULL,
  `tr_class2` varchar(25) DEFAULT NULL,
  `tr_class3` varchar(25) DEFAULT NULL,
  `th_color1` varchar(6) DEFAULT NULL,
  `th_color2` varchar(6) DEFAULT NULL,
  `th_color3` varchar(6) DEFAULT NULL,
  `th_class1` varchar(25) DEFAULT NULL,
  `th_class2` varchar(25) DEFAULT NULL,
  `th_class3` varchar(25) DEFAULT NULL,
  `td_color1` varchar(6) DEFAULT NULL,
  `td_color2` varchar(6) DEFAULT NULL,
  `td_color3` varchar(6) DEFAULT NULL,
  `td_class1` varchar(25) DEFAULT NULL,
  `td_class2` varchar(25) DEFAULT NULL,
  `td_class3` varchar(25) DEFAULT NULL,
  `fontface1` varchar(50) DEFAULT NULL,
  `fontface2` varchar(50) DEFAULT NULL,
  `fontface3` varchar(50) DEFAULT NULL,
  `fontsize1` tinyint(4) DEFAULT NULL,
  `fontsize2` tinyint(4) DEFAULT NULL,
  `fontsize3` tinyint(4) DEFAULT NULL,
  `fontcolor1` varchar(6) DEFAULT NULL,
  `fontcolor2` varchar(6) DEFAULT NULL,
  `fontcolor3` varchar(6) DEFAULT NULL,
  `fontcolor_admin` varchar(6) DEFAULT NULL,
  `fontcolor_jradmin` varchar(6) DEFAULT NULL,
  `fontcolor_mod` varchar(6) DEFAULT NULL,
  `factive_color` varchar(6) DEFAULT NULL,
  `faonmouse_color` varchar(6) DEFAULT NULL,
  `faonmouse2_color` varchar(6) DEFAULT NULL,
  `span_class1` varchar(25) DEFAULT NULL,
  `span_class2` varchar(25) DEFAULT NULL,
  `span_class3` varchar(25) DEFAULT NULL,
  `img_size_poll` smallint(5) unsigned DEFAULT NULL,
  `img_size_privmsg` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`themes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `themes` DISABLE KEYS */;
INSERT INTO `themes` (`themes_id`, `template_name`, `style_name`, `head_stylesheet`, `body_background`, `body_bgcolor`, `body_text`, `body_link`, `body_vlink`, `body_alink`, `body_hlink`, `tr_color1`, `tr_color2`, `tr_color3`, `tr_color_helped`, `tr_class1`, `tr_class2`, `tr_class3`, `th_color1`, `th_color2`, `th_color3`, `th_class1`, `th_class2`, `th_class3`, `td_color1`, `td_color2`, `td_color3`, `td_class1`, `td_class2`, `td_class3`, `fontface1`, `fontface2`, `fontface3`, `fontsize1`, `fontsize2`, `fontsize3`, `fontcolor1`, `fontcolor2`, `fontcolor3`, `fontcolor_admin`, `fontcolor_jradmin`, `fontcolor_mod`, `factive_color`, `faonmouse_color`, `faonmouse2_color`, `span_class1`, `span_class2`, `span_class3`, `img_size_poll`, `img_size_privmsg`) VALUES
	(1, 'subSilver', 'subSilver', 'subSilver.css', '', 'E5E5E5', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', 'F0EDDE', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, \'Courier New\', sans-serif', 10, 11, 12, '444444', '006600', 'FFA34F', 'FFA34F', '993333', '006600', 'F9F9F0', 'DEE3E7', 'EFEFEF', '', '', '', NULL, NULL);
/*!40000 ALTER TABLE `themes` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `themes_name` (
  `themes_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tr_color1_name` char(50) DEFAULT NULL,
  `tr_color2_name` char(50) DEFAULT NULL,
  `tr_color3_name` char(50) DEFAULT NULL,
  `tr_class1_name` char(50) DEFAULT NULL,
  `tr_class2_name` char(50) DEFAULT NULL,
  `tr_class3_name` char(50) DEFAULT NULL,
  `th_color1_name` char(50) DEFAULT NULL,
  `th_color2_name` char(50) DEFAULT NULL,
  `th_color3_name` char(50) DEFAULT NULL,
  `th_class1_name` char(50) DEFAULT NULL,
  `th_class2_name` char(50) DEFAULT NULL,
  `th_class3_name` char(50) DEFAULT NULL,
  `td_color1_name` char(50) DEFAULT NULL,
  `td_color2_name` char(50) DEFAULT NULL,
  `td_color3_name` char(50) DEFAULT NULL,
  `td_class1_name` char(50) DEFAULT NULL,
  `td_class2_name` char(50) DEFAULT NULL,
  `td_class3_name` char(50) DEFAULT NULL,
  `fontface1_name` char(50) DEFAULT NULL,
  `fontface2_name` char(50) DEFAULT NULL,
  `fontface3_name` char(50) DEFAULT NULL,
  `fontsize1_name` char(50) DEFAULT NULL,
  `fontsize2_name` char(50) DEFAULT NULL,
  `fontsize3_name` char(50) DEFAULT NULL,
  `fontcolor1_name` char(50) DEFAULT NULL,
  `fontcolor2_name` char(50) DEFAULT NULL,
  `fontcolor3_name` char(50) DEFAULT NULL,
  `span_class1_name` char(50) DEFAULT NULL,
  `span_class2_name` char(50) DEFAULT NULL,
  `span_class3_name` char(50) DEFAULT NULL,
  PRIMARY KEY (`themes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `themes_name` DISABLE KEYS */;
INSERT INTO `themes_name` (`themes_id`, `tr_color1_name`, `tr_color2_name`, `tr_color3_name`, `tr_class1_name`, `tr_class2_name`, `tr_class3_name`, `th_color1_name`, `th_color2_name`, `th_color3_name`, `th_class1_name`, `th_class2_name`, `th_class3_name`, `td_color1_name`, `td_color2_name`, `td_color3_name`, `td_class1_name`, `td_class2_name`, `td_class3_name`, `fontface1_name`, `fontface2_name`, `fontface3_name`, `fontsize1_name`, `fontsize2_name`, `fontsize3_name`, `fontcolor1_name`, `fontcolor2_name`, `fontcolor3_name`, `span_class1_name`, `span_class2_name`, `span_class3_name`) VALUES
	(1, 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');
/*!40000 ALTER TABLE `themes_name` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `topics` (
  `topic_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `topic_title` char(60) NOT NULL DEFAULT '',
  `topic_poster` mediumint(8) NOT NULL DEFAULT '0',
  `topic_time` int(11) NOT NULL DEFAULT '0',
  `topic_views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_replies` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_status` tinyint(1) NOT NULL DEFAULT '0',
  `topic_vote` tinyint(1) NOT NULL DEFAULT '0',
  `topic_type` tinyint(1) NOT NULL DEFAULT '0',
  `topic_first_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_last_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_moved_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `topic_icon` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `topic_expire` int(11) NOT NULL DEFAULT '0',
  `topic_color` varchar(8) DEFAULT NULL,
  `topic_title_e` char(100) NOT NULL DEFAULT '',
  `topic_action` tinyint(1) DEFAULT '0',
  `topic_action_user` mediumint(8) NOT NULL DEFAULT '0',
  `topic_action_date` int(11) NOT NULL DEFAULT '0',
  `topic_tree_width` smallint(2) NOT NULL DEFAULT '0',
  `topic_accept` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_moved_id` (`topic_moved_id`),
  KEY `topic_status` (`topic_status`),
  KEY `topic_type` (`topic_type`),
  KEY `topic_poster` (`topic_poster`),
  KEY `topic_last_post_id` (`topic_last_post_id`),
  KEY `topic_first_post_id` (`topic_first_post_id`),
  KEY `topic_vote` (`topic_vote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` (`topic_id`, `forum_id`, `topic_title`, `topic_poster`, `topic_time`, `topic_views`, `topic_replies`, `topic_status`, `topic_vote`, `topic_type`, `topic_first_post_id`, `topic_last_post_id`, `topic_moved_id`, `topic_attachment`, `topic_icon`, `topic_expire`, `topic_color`, `topic_title_e`, `topic_action`, `topic_action_user`, `topic_action_date`, `topic_tree_width`, `topic_accept`) VALUES
	(2, 2, 'Testowy temat w SubForum', 2, 1064458873, 0, 0, 0, 0, 0, 3, 3, 0, 0, 0, 0, '', '', 0, 0, 0, 0, 1),
	(4, 1, 'Witaj na forum phpBB modified by Przemo', 2, 1065136668, 0, 0, 0, 0, 0, 5, 5, 0, 0, 2, 0, 'green', '', 0, 0, 0, 0, 1),
	(5, 7, 'Sonda1', 2, 1065137203, 0, 0, 0, 1, 0, 7, 7, 0, 0, 0, 0, '', '', 0, 0, 0, 0, 1),
	(6, 6, 'Test trzeciego newsa', 2, 1065137320, 0, 0, 0, 0, 0, 8, 8, 0, 0, 0, 0, '', '', 0, 0, 0, 0, 1),
	(7, 6, 'test drugiego newsa', 2, 1065137383, 0, 0, 0, 0, 0, 9, 9, 0, 0, 0, 0, '', '', 0, 0, 0, 0, 1);
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `topics_ignore` (
  `topic_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `topics_ignore` DISABLE KEYS */;
/*!40000 ALTER TABLE `topics_ignore` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `topics_watch` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `notify_status` tinyint(1) NOT NULL DEFAULT '0',
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  KEY `notify_status` (`notify_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `topics_watch` DISABLE KEYS */;
/*!40000 ALTER TABLE `topics_watch` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `topic_view` (
  `topic_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `view_time` int(11) NOT NULL DEFAULT '0',
  `view_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `topic_view` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic_view` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_active` tinyint(1) DEFAULT '1',
  `username` varchar(25) NOT NULL DEFAULT '',
  `user_password` varchar(40) NOT NULL DEFAULT '',
  `user_session_time` int(11) NOT NULL DEFAULT '0',
  `user_session_page` smallint(5) NOT NULL DEFAULT '0',
  `user_lastvisit` int(11) NOT NULL DEFAULT '0',
  `user_regdate` int(11) NOT NULL DEFAULT '0',
  `user_level` tinyint(1) DEFAULT '0',
  `user_posts` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `user_timezone` decimal(5,2) NOT NULL DEFAULT '0.00',
  `user_style` tinyint(2) DEFAULT '1',
  `user_lang` varchar(12) NOT NULL DEFAULT '',
  `user_new_privmsg` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_unread_privmsg` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_last_privmsg` int(11) NOT NULL DEFAULT '0',
  `user_emailtime` int(11) DEFAULT '0',
  `user_viewemail` tinyint(1) DEFAULT '1',
  `user_viewaim` tinyint(1) DEFAULT '1',
  `user_attachsig` tinyint(1) DEFAULT '1',
  `user_allowhtml` tinyint(1) DEFAULT '1',
  `user_allowbbcode` tinyint(1) DEFAULT '1',
  `user_allowsmile` tinyint(1) DEFAULT '1',
  `user_allowavatar` tinyint(1) NOT NULL DEFAULT '1',
  `user_allowsig` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_pm` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_viewonline` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify_pm` tinyint(1) NOT NULL DEFAULT '1',
  `user_popup_pm` tinyint(1) NOT NULL DEFAULT '0',
  `user_rank` int(11) DEFAULT '0',
  `user_avatar` varchar(100) DEFAULT '',
  `user_avatar_type` tinyint(1) NOT NULL DEFAULT '0',
  `user_email` varchar(255) DEFAULT '',
  `user_icq` varchar(15) DEFAULT '',
  `user_website` varchar(255) DEFAULT '',
  `user_from` varchar(64) DEFAULT '',
  `user_sig` text,
  `user_sig_bbcode_uid` char(10) DEFAULT '',
  `user_sig_image` varchar(100) NOT NULL DEFAULT '',
  `user_aim` varchar(255) DEFAULT '',
  `user_yim` varchar(255) DEFAULT '',
  `user_msnm` varchar(255) DEFAULT '',
  `user_occ` varchar(100) DEFAULT '',
  `user_interests` varchar(255) DEFAULT '',
  `user_actkey` varchar(32) DEFAULT '',
  `user_newpasswd` varchar(40) DEFAULT '',
  `user_custom_rank` varchar(100) DEFAULT '',
  `user_photo` varchar(100) DEFAULT '',
  `user_photo_type` tinyint(1) NOT NULL DEFAULT '0',
  `user_custom_color` varchar(6) DEFAULT '',
  `user_badlogin` smallint(2) NOT NULL DEFAULT '0',
  `user_blocktime` int(11) NOT NULL DEFAULT '0',
  `user_block_by` char(8) DEFAULT '',
  `disallow_forums` varchar(254) DEFAULT '',
  `can_custom_ranks` tinyint(1) NOT NULL DEFAULT '1',
  `can_custom_color` tinyint(1) NOT NULL DEFAULT '1',
  `user_gender` tinyint(1) NOT NULL DEFAULT '0',
  `can_topic_color` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify_gg` tinyint(1) NOT NULL DEFAULT '0',
  `allowpm` tinyint(1) DEFAULT '1',
  `no_report_popup` tinyint(1) NOT NULL DEFAULT '0',
  `refresh_report_popup` tinyint(1) NOT NULL DEFAULT '0',
  `no_report_mail` tinyint(1) NOT NULL DEFAULT '0',
  `user_avatar_width` smallint(3) DEFAULT NULL,
  `user_avatar_height` smallint(3) DEFAULT NULL,
  `special_rank` mediumint(8) unsigned DEFAULT NULL,
  `user_allow_helped` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_ip` char(8) DEFAULT NULL,
  `user_ip_login_check` tinyint(1) NOT NULL DEFAULT '1',
  `user_spend_time` int(8) NOT NULL DEFAULT '0',
  `user_visit` int(7) NOT NULL DEFAULT '0',
  `user_session_start` int(11) NOT NULL DEFAULT '0',
  `read_tracking_last_update` int(11) NOT NULL DEFAULT '0',
  `user_jr` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_session_time` (`user_session_time`),
  KEY `user_level` (`user_level`),
  KEY `user_lastvisit` (`user_lastvisit`),
  KEY `user_active` (`user_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_active`, `username`, `user_password`, `user_session_time`, `user_session_page`, `user_lastvisit`, `user_regdate`, `user_level`, `user_posts`, `user_timezone`, `user_style`, `user_lang`, `user_new_privmsg`, `user_unread_privmsg`, `user_last_privmsg`, `user_emailtime`, `user_viewemail`, `user_viewaim`, `user_attachsig`, `user_allowhtml`, `user_allowbbcode`, `user_allowsmile`, `user_allowavatar`, `user_allowsig`, `user_allow_pm`, `user_allow_viewonline`, `user_notify`, `user_notify_pm`, `user_popup_pm`, `user_rank`, `user_avatar`, `user_avatar_type`, `user_email`, `user_icq`, `user_website`, `user_from`, `user_sig`, `user_sig_bbcode_uid`, `user_sig_image`, `user_aim`, `user_yim`, `user_msnm`, `user_occ`, `user_interests`, `user_actkey`, `user_newpasswd`, `user_custom_rank`, `user_photo`, `user_photo_type`, `user_custom_color`, `user_badlogin`, `user_blocktime`, `user_block_by`, `disallow_forums`, `can_custom_ranks`, `can_custom_color`, `user_gender`, `can_topic_color`, `user_notify_gg`, `allowpm`, `no_report_popup`, `refresh_report_popup`, `no_report_mail`, `user_avatar_width`, `user_avatar_height`, `special_rank`, `user_allow_helped`, `user_ip`, `user_ip_login_check`, `user_spend_time`, `user_visit`, `user_session_start`, `read_tracking_last_update`, `user_jr`) VALUES
	(-1, 0, 'Anonymous', '', 0, 0, 0, 0, 0, 0, 1.00, NULL, 'polish', 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 0, 0, '', '', 1, 1, 0, 1, 0, 1, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 1, 0, 0, 0, 0, 0),
	(2, 1, 'Admin', '21232f297a57a5a743894a0e4a801fc3', 0, 0, 0, 0, 1, 5, 1.00, 1, '', 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, '', 0, 'admin@yourdomain.com', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 0, 0, '', '', 1, 1, 0, 1, 0, 1, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 1, 0, 0, 0, 0, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users_warnings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) NOT NULL DEFAULT '0',
  `modid` mediumint(8) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `value` mediumint(8) NOT NULL DEFAULT '0',
  `reason` text,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `warning_viewed` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `archive` (`archive`),
  KEY `warning_viewed` (`warning_viewed`),
  KEY `date` (`date`),
  KEY `userid` (`userid`),
  KEY `modid` (`modid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `users_warnings` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_warnings` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user_group` (
  `group_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_pending` tinyint(1) DEFAULT NULL,
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`),
  KEY `user_pending` (`user_pending`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` (`group_id`, `user_id`, `user_pending`) VALUES
	(1, -1, 0),
	(2, 2, 0);
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `vote_desc` (
  `vote_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_text` text NOT NULL,
  `vote_start` int(11) NOT NULL DEFAULT '0',
  `vote_length` int(11) NOT NULL DEFAULT '0',
  `vote_max` int(3) NOT NULL DEFAULT '1',
  `vote_voted` int(7) NOT NULL DEFAULT '0',
  `vote_hide` tinyint(1) NOT NULL DEFAULT '0',
  `vote_tothide` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`vote_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `vote_desc` DISABLE KEYS */;
INSERT INTO `vote_desc` (`vote_id`, `topic_id`, `vote_text`, `vote_start`, `vote_length`, `vote_max`, `vote_voted`, `vote_hide`, `vote_tothide`) VALUES
	(1, 5, 'Czy podoba Ci się to Forum?', 1065137203, 0, 1, 0, 0, 0);
/*!40000 ALTER TABLE `vote_desc` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `vote_results` (
  `vote_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_option_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `vote_option_text` varchar(255) NOT NULL DEFAULT '',
  `vote_result` int(11) NOT NULL DEFAULT '0',
  KEY `vote_option_id` (`vote_option_id`),
  KEY `vote_id` (`vote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `vote_results` DISABLE KEYS */;
INSERT INTO `vote_results` (`vote_id`, `vote_option_id`, `vote_option_text`, `vote_result`) VALUES
	(1, 1, 'Tak', 0),
	(1, 2, 'Nie', 0);
/*!40000 ALTER TABLE `vote_results` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `vote_voters` (
  `vote_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `vote_user_ip` char(8) NOT NULL DEFAULT '',
  `vote_cast` tinyint(4) unsigned NOT NULL DEFAULT '0',
  KEY `vote_id` (`vote_id`),
  KEY `vote_user_id` (`vote_user_id`),
  KEY `vote_user_ip` (`vote_user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `vote_voters` DISABLE KEYS */;
/*!40000 ALTER TABLE `vote_voters` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `words` (
  `word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `word` char(100) NOT NULL DEFAULT '',
  `replacement` text NOT NULL,
  PRIMARY KEY (`word_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `words` DISABLE KEYS */;
/*!40000 ALTER TABLE `words` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
