# ************************************************************
# Sequel Ace SQL dump
# Version 2082
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.21)
# Database: przemo_utf8
# Generation Time: 2020-11-06 21:45:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table phpbb_adv_person
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_adv_person`;

CREATE TABLE `phpbb_adv_person` (
  `user_id` mediumint NOT NULL DEFAULT '0',
  `person_id` mediumint NOT NULL DEFAULT '0',
  `person_ip` char(8) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`user_id`,`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_advertisement
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_advertisement`;

CREATE TABLE `phpbb_advertisement` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `html` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `clicks` int NOT NULL DEFAULT '0',
  `position` tinyint(1) NOT NULL DEFAULT '0',
  `porder` mediumint NOT NULL DEFAULT '0',
  `added` int NOT NULL DEFAULT '0',
  `expire` int NOT NULL DEFAULT '0',
  `last_update` int NOT NULL DEFAULT '0',
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_anti_robotic_reg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_anti_robotic_reg`;

CREATE TABLE `phpbb_anti_robotic_reg` (
  `session_id` char(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `reg_key` char(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_attach_quota
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_attach_quota`;

CREATE TABLE `phpbb_attach_quota` (
  `user_id` mediumint unsigned NOT NULL DEFAULT '0',
  `group_id` mediumint unsigned NOT NULL DEFAULT '0',
  `quota_type` smallint NOT NULL DEFAULT '0',
  `quota_limit_id` mediumint unsigned NOT NULL DEFAULT '0',
  KEY `quota_type` (`quota_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_attachments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_attachments`;

CREATE TABLE `phpbb_attachments` (
  `attach_id` mediumint unsigned NOT NULL DEFAULT '0',
  `post_id` mediumint unsigned NOT NULL DEFAULT '0',
  `privmsgs_id` mediumint unsigned NOT NULL DEFAULT '0',
  `user_id_1` mediumint NOT NULL DEFAULT '0',
  `user_id_2` mediumint NOT NULL DEFAULT '0',
  KEY `attach_id_post_id` (`attach_id`,`post_id`),
  KEY `attach_id_privmsgs_id` (`attach_id`,`privmsgs_id`),
  KEY `user_id_1` (`user_id_1`),
  KEY `user_id_2` (`user_id_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_attachments_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_attachments_config`;

CREATE TABLE `phpbb_attachments_config` (
  `config_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `config_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_attachments_config` WRITE;
/*!40000 ALTER TABLE `phpbb_attachments_config` DISABLE KEYS */;

INSERT INTO `phpbb_attachments_config` (`config_name`, `config_value`)
VALUES
	('allow_ftp_upload','0'),
	('allow_pm_attach','1'),
	('attachment_quota','52428800'),
	('attachment_topic_review','1'),
	('default_pm_quota','0'),
	('default_upload_quota','0'),
	('disable_mod','0'),
	('display_order','0'),
	('download_path',''),
	('ftp_pass',''),
	('ftp_pasv_mode','1'),
	('ftp_path',''),
	('ftp_server',''),
	('ftp_user',''),
	('img_create_thumbnail','1'),
	('img_display_inlined','1'),
	('img_imagick',''),
	('img_link_height','0'),
	('img_link_width','0'),
	('img_max_height','0'),
	('img_max_width','0'),
	('img_min_thumb_filesize','12000'),
	('max_attachments','10'),
	('max_attachments_pm','1'),
	('max_filesize','262144'),
	('max_filesize_pm','262144'),
	('show_apcp','0'),
	('topic_icon','images/icon_clip.gif'),
	('upload_dir','files'),
	('upload_img','images/icon_clip.gif'),
	('use_gd2','0');

/*!40000 ALTER TABLE `phpbb_attachments_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_attachments_desc
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_attachments_desc`;

CREATE TABLE `phpbb_attachments_desc` (
  `attach_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `physical_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `real_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `download_count` mediumint unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mimetype` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filesize` int NOT NULL DEFAULT '0',
  `filetime` int NOT NULL DEFAULT '0',
  `thumbnail` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attach_id`),
  KEY `filetime` (`filetime`),
  KEY `physical_filename` (`physical_filename`(10)),
  KEY `filesize` (`filesize`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_auth_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_auth_access`;

CREATE TABLE `phpbb_auth_access` (
  `group_id` mediumint NOT NULL DEFAULT '0',
  `forum_id` smallint unsigned NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_banlist
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_banlist`;

CREATE TABLE `phpbb_banlist` (
  `ban_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `ban_userid` mediumint NOT NULL DEFAULT '0',
  `ban_ip` char(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ban_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_time` int DEFAULT NULL,
  `ban_expire_time` int DEFAULT NULL,
  `ban_by_userid` mediumint DEFAULT NULL,
  `ban_priv_reason` text COLLATE utf8mb4_unicode_ci,
  `ban_pub_reason_mode` tinyint(1) DEFAULT NULL,
  `ban_pub_reason` text COLLATE utf8mb4_unicode_ci,
  `ban_host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`ban_id`),
  KEY `ban_ip_user_id` (`ban_ip`,`ban_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_categories`;

CREATE TABLE `phpbb_categories` (
  `cat_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_order` mediumint unsigned NOT NULL DEFAULT '0',
  `cat_main_type` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_main` mediumint unsigned NOT NULL DEFAULT '0',
  `cat_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `cat_order` (`cat_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_categories` WRITE;
/*!40000 ALTER TABLE `phpbb_categories` DISABLE KEYS */;

INSERT INTO `phpbb_categories` (`cat_id`, `cat_title`, `cat_order`, `cat_main_type`, `cat_main`, `cat_desc`)
VALUES
	(1,'Główna kategoria forum',10,'c',0,'Główna kategoria forum'),
	(3,'Kategoria SubForów',40,'f',2,''),
	(4,'Kategoria Sondy',70,'c',1,''),
	(5,'Kolejna główna kategoria',100,'c',0,'Opis kategorii'),
	(6,'Podkategoria',110,'c',5,'Opis musi być'),
	(7,'Kategoria',160,'c',0,'');

/*!40000 ALTER TABLE `phpbb_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_config`;

CREATE TABLE `phpbb_config` (
  `config_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `config_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_config` WRITE;
/*!40000 ALTER TABLE `phpbb_config` DISABLE KEYS */;

INSERT INTO `phpbb_config` (`config_name`, `config_value`)
VALUES
	('address_whois','http://whois.domaintools.com/'),
	('admin_html','0'),
	('admin_notify_message','0'),
	('admin_notify_reply','1'),
	('adv_person_time','30'),
	('advert',''),
	('advert_foot',''),
	('advert_separator',' &bull; '),
	('advert_separator_l','<br /><hr />'),
	('advert_width','150'),
	('allow_autologin','1'),
	('allow_avatar','0'),
	('allow_avatar_local','1'),
	('allow_avatar_remote','1'),
	('allow_avatar_upload','1'),
	('allow_bbcode','1'),
	('allow_bbcode_quest','0'),
	('allow_custom_color','0'),
	('allow_custom_rank','0'),
	('allow_html','0'),
	('allow_html_tags','b,i,u,pre'),
	('allow_mod_delete_actions','0'),
	('allow_namechange','0'),
	('allow_photo_remote','0'),
	('allow_photo_upload','0'),
	('allow_sig','1'),
	('allow_sig_image','1'),
	('allow_sig_image_img','0'),
	('allow_smilies','1'),
	('allow_topic_gallery','1'),
	('anonymous_simple','0'),
	('auto_date','1'),
	('autorepair_tables','1'),
	('avatar_filesize','12144'),
	('avatar_gallery_path','images/avatars/gallery'),
	('avatar_max_height','80'),
	('avatar_max_width','80'),
	('avatar_path','images/avatars'),
	('ban_warnings','6'),
	('banner_bottom',''),
	('banner_bottom_enable','0'),
	('banner_top',''),
	('banner_top_enable','0'),
	('banners_list','<center><a href=\"http://phpbb.com\" target=\"_blank\"><img src=\"images/link_phpbb.gif\" alt=\"\" border=\"0\" /></a></center><br />[banner]<center><a href=\"http://forumimages.com\" target=\"_blank\"><img src=\"images/link_forumimages.gif\" alt=\"\" border=\"0\" /></a></center><br />[banner]<center><embed src=\"images/clock.swf\" quality=high type=\"application/x-shockwave-flash\" width=\"80\" height=\"80\" /></center>'),
	('block_time','40'),
	('board_disable',''),
	('board_email','admin@example.com'),
	('board_email_form','1'),
	('board_email_sig','Administrator Forum'),
	('board_msg',''),
	('board_msg_enable','0'),
	('board_startdate','1601919110'),
	('board_timezone','1.00'),
	('cagent','1'),
	('cavatar','1'),
	('cbbcode','0'),
	('cbstyle','1'),
	('ccount','1'),
	('cemail','1'),
	('cfriend','1'),
	('cfrom','1'),
	('cgg','1'),
	('check_address','0'),
	('chtml','0'),
	('cignore','1'),
	('cinter','1'),
	('cjob','0'),
	('cjoin','1'),
	('clang','1'),
	('cleveld','0'),
	('clevell','0'),
	('clevelp','0'),
	('cllogin','1'),
	('cload','0'),
	('clog','0'),
	('color_box','1'),
	('cookie_domain','localhost'),
	('cookie_name','phpbb2mysql'),
	('cookie_path','/'),
	('cookie_secure','1'),
	('cpost','1'),
	('cposts','1'),
	('cquick','1'),
	('cregist','1'),
	('cregist_b','0'),
	('crestrict','0'),
	('csearch','1'),
	('csmiles','0'),
	('cstat','1'),
	('cstyles','1'),
	('ctimezone','1'),
	('ctop','1'),
	('custom_color_mod','0'),
	('custom_color_use','0'),
	('custom_color_view','0'),
	('custom_rank_mod','0'),
	('data',''),
	('day_to_prune','120'),
	('default_dateformat','Y-m-d, H:i'),
	('default_lang','polish'),
	('default_style','1'),
	('del_notify_choice','0'),
	('del_notify_enable','1'),
	('del_notify_method','1'),
	('del_user_notify','1'),
	('desc_color',''),
	('disable_type',''),
	('display_viewonline','2'),
	('display_viewonline_over','0'),
	('download','1'),
	('echange_banner','0'),
	('edit_time','0'),
	('email_from','admin@example.com'),
	('email_return_path','admin@example.com'),
	('expire','1'),
	('expire_value','0'),
	('expire_warnings','0'),
	('facebook_appid',''),
	('facebook_secret',''),
	('flood_interval','20'),
	('force_complex_password','0'),
	('gender','1'),
	('generate_time','1'),
	('generate_time_admin','0'),
	('google_client_id','624532478979-tiqcd2ncorq7ko7vslsjbu138vtl27du.apps.googleusercontent.com'),
	('graphic','1'),
	('group_rank_hack_version','0'),
	('gzip_compress','0'),
	('header_enable','0'),
	('helped','0'),
	('hide_edited_admin','0'),
	('hide_viewed_admin','0'),
	('hot_threshold','30'),
	('ignore_topics','1'),
	('ipview','0'),
	('jr_admin_html','0'),
	('last_dtable_notify',''),
	('last_prune','0'),
	('last_resync','1603049056'),
	('last_topic_title','1'),
	('last_topic_title_length','24'),
	('last_topic_title_over','0'),
	('last_visitors_time','24'),
	('last_visitors_time_count','0'),
	('lastpost','1603026512'),
	('login_require','0'),
	('main_admin_id',''),
	('max_inbox_privmsgs','50'),
	('max_login_error','10'),
	('max_poll_options','30'),
	('max_savebox_privmsgs','50'),
	('max_sentbox_privmsgs','25'),
	('max_sig_chars','255'),
	('max_sig_chars_admin','6'),
	('max_sig_chars_mod','3'),
	('max_sig_custom_rank','20'),
	('max_sig_location','20'),
	('max_smilies','24'),
	('meta_description',''),
	('meta_keywords',''),
	('min_password_len','3'),
	('mod_edit_warnings','0'),
	('mod_html','0'),
	('mod_nick_color',''),
	('mod_spy','0'),
	('mod_spy_admin','0'),
	('mod_value_warning','1'),
	('mod_warnings','1'),
	('name_color',''),
	('newest','1'),
	('newestuser','a:2:{s:8:\"username\";s:5:\"admin\";s:7:\"user_id\";s:1:\"2\";}'),
	('not_anonymous_posting','0'),
	('not_anonymous_quickreply','0'),
	('not_edit_admin','1'),
	('onmouse','1'),
	('open_in_windows','1'),
	('overlib','1'),
	('override_user_style','0'),
	('password_not_login','0'),
	('ph_days','14'),
	('ph_len','8'),
	('ph_mod','0'),
	('ph_mod_delete','0'),
	('photo_filesize','40000'),
	('photo_max_height','200'),
	('photo_max_width','200'),
	('photo_path','images/photos'),
	('post_footer','1'),
	('post_icon','1'),
	('post_overlib','1'),
	('postcount','29'),
	('poster_posts','1'),
	('posts_per_page','15'),
	('privmsg_disable','0'),
	('protection_get','1'),
	('prune_enable','0'),
	('public_category',''),
	('r_a_r_time','1'),
	('rand_seed','9888b8207c5f563ffa8b6536d6f562cf'),
	('rand_seed_last_update','1601919114'),
	('rebuild_search',''),
	('recaptcha_key',''),
	('recaptcha_secret',''),
	('record_online_date','1601919114'),
	('record_online_users','1'),
	('refresh','0'),
	('report_disable','1'),
	('report_disabled_groups',''),
	('report_disabled_users',''),
	('report_no_auth_groups',''),
	('report_no_auth_users',''),
	('report_no_guestes','1'),
	('report_only_admin','0'),
	('report_popup_height','250'),
	('report_popup_links_target','2'),
	('report_popup_width','700'),
	('require_activation','0'),
	('require_gender','0'),
	('require_location','0'),
	('require_website','0'),
	('restrict_smilies','0'),
	('rh_max_posts','1000'),
	('rh_without_days','3'),
	('ri_data','1.12.13'),
	('ri_time','1603014670'),
	('script_path','/'),
	('search_enable','1'),
	('search_keywords_max','5'),
	('sendmail_fix','0'),
	('server_name','localhost'),
	('server_port','80'),
	('server_proto','https'),
	('session_length','900'),
	('shouts','{\n  \"enabled\": true,\n  \"autopurge\": 30,\n  \"rbac\": {\n    \"admin\": \"1r\",\n    \"jr_admin\": \"v\",\n    \"mod\":\"v\",\n    \"user\":\"3\",\n    \"anonymous\":\"1\"\n  }\n}'),
	('show_action_edited_by_others','1'),
	('show_action_edited_self','1'),
	('show_action_edited_self_all','0'),
	('show_action_expired','1'),
	('show_action_locked','1'),
	('show_action_moved','1'),
	('show_action_unlocked','1'),
	('show_badwords','1'),
	('show_rules','0'),
	('sig_image_filesize','30000'),
	('sig_image_max_height','50'),
	('sig_image_max_width','400'),
	('sig_images_path','images/signatures'),
	('site_desc','Krótki tekst opisujący twoje forum'),
	('sitename','Nazwa twojego forum'),
	('size_box','1'),
	('smilies_columns','4'),
	('smilies_path','images/smiles'),
	('smilies_rows','8'),
	('smilies_w_columns','8'),
	('smtp_delivery','0'),
	('smtp_host',''),
	('smtp_password',''),
	('smtp_username',''),
	('split_cat','1'),
	('split_cat_over','0'),
	('split_messages','0'),
	('split_messages_admin','0'),
	('split_messages_mod','0'),
	('sql','http://'),
	('staff_enable','1'),
	('staff_forums','1'),
	('sub_forum','1'),
	('sub_forum_over','0'),
	('sub_level_links','2'),
	('sub_level_links_over','0'),
	('table_border','6'),
	('title_explain','1'),
	('topic_color','1'),
	('topic_color_all','0'),
	('topic_color_mod','1'),
	('topic_preview','0'),
	('topic_start_date','1'),
	('topic_start_dateformat','d-m-y'),
	('topiccount','8'),
	('topics_per_page','25'),
	('u_o_t_d','1'),
	('usercount','1'),
	('validate','0'),
	('version','1.12.13'),
	('view_ad_by','1'),
	('viewonline','0'),
	('viewtopic_warnings','0'),
	('visitors','183'),
	('warnings_enable','1'),
	('warnings_mods_public','1'),
	('who_viewed','0'),
	('who_viewed_admin','0'),
	('width_color1',''),
	('width_color2',''),
	('width_forum','0'),
	('width_table','800'),
	('write_warnings','3'),
	('xs_auto_compile','1'),
	('xs_auto_recompile','1'),
	('xs_check_switches','1'),
	('xs_def_template','subSilver'),
	('xs_downloads_count','0'),
	('xs_downloads_default','0'),
	('xs_ftp_host',''),
	('xs_ftp_login',''),
	('xs_ftp_path',''),
	('xs_php','php'),
	('xs_shownav','1'),
	('xs_template_time','1601919114'),
	('xs_use_cache','1'),
	('xs_version','7'),
	('xs_warn_includes','1');

/*!40000 ALTER TABLE `phpbb_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_disallow
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_disallow`;

CREATE TABLE `phpbb_disallow` (
  `disallow_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `disallow_username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`disallow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_extension_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_extension_groups`;

CREATE TABLE `phpbb_extension_groups` (
  `group_id` mediumint NOT NULL AUTO_INCREMENT,
  `group_name` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cat_id` tinyint NOT NULL DEFAULT '0',
  `allow_group` tinyint(1) NOT NULL DEFAULT '0',
  `download_mode` tinyint unsigned NOT NULL DEFAULT '1',
  `upload_icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `max_filesize` int NOT NULL DEFAULT '0',
  `forum_permissions` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_extension_groups` WRITE;
/*!40000 ALTER TABLE `phpbb_extension_groups` DISABLE KEYS */;

INSERT INTO `phpbb_extension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`)
VALUES
	(1,'Images',1,1,1,'',0,''),
	(2,'Archives',0,1,1,'',0,''),
	(3,'Plain Text',0,0,1,'',0,''),
	(4,'Documents',0,0,1,'',0,''),
	(5,'Real Media',0,0,2,'',0,''),
	(6,'Streams',2,0,1,'',0,''),
	(7,'Flash Files',3,0,1,'',0,'');

/*!40000 ALTER TABLE `phpbb_extension_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_extensions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_extensions`;

CREATE TABLE `phpbb_extensions` (
  `ext_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint unsigned NOT NULL DEFAULT '0',
  `extension` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`ext_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_extensions` WRITE;
/*!40000 ALTER TABLE `phpbb_extensions` DISABLE KEYS */;

INSERT INTO `phpbb_extensions` (`ext_id`, `group_id`, `extension`, `comment`)
VALUES
	(1,1,'gif',''),
	(2,1,'png',''),
	(3,1,'jpeg',''),
	(4,1,'jpg',''),
	(5,1,'tif',''),
	(6,1,'tga',''),
	(7,2,'gtar',''),
	(8,2,'gz',''),
	(9,2,'tar',''),
	(10,2,'zip',''),
	(11,2,'rar',''),
	(12,2,'ace',''),
	(13,3,'txt',''),
	(14,3,'c',''),
	(15,3,'h',''),
	(16,3,'cpp',''),
	(17,3,'hpp',''),
	(18,3,'diz',''),
	(19,4,'xls',''),
	(20,4,'doc',''),
	(21,4,'dot',''),
	(22,4,'pdf',''),
	(23,4,'ai',''),
	(24,4,'ps',''),
	(25,4,'ppt',''),
	(26,5,'rm',''),
	(27,6,'wma',''),
	(31,6,'avi',''),
	(32,6,'mpg',''),
	(33,6,'mpeg',''),
	(34,6,'mp3',''),
	(35,6,'wav','');

/*!40000 ALTER TABLE `phpbb_extensions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_forbidden_extensions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_forbidden_extensions`;

CREATE TABLE `phpbb_forbidden_extensions` (
  `ext_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `extension` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ext_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_forbidden_extensions` WRITE;
/*!40000 ALTER TABLE `phpbb_forbidden_extensions` DISABLE KEYS */;

INSERT INTO `phpbb_forbidden_extensions` (`ext_id`, `extension`)
VALUES
	(1,'php'),
	(2,'php3'),
	(3,'php4'),
	(4,'phtml'),
	(5,'pl'),
	(6,'asp'),
	(7,'cgi');

/*!40000 ALTER TABLE `phpbb_forbidden_extensions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_forum_prune
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_forum_prune`;

CREATE TABLE `phpbb_forum_prune` (
  `prune_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint unsigned NOT NULL DEFAULT '0',
  `prune_days` smallint unsigned NOT NULL DEFAULT '0',
  `prune_freq` smallint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`prune_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_forums
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_forums`;

CREATE TABLE `phpbb_forums` (
  `forum_id` smallint unsigned NOT NULL DEFAULT '0',
  `cat_id` mediumint unsigned NOT NULL DEFAULT '0',
  `forum_name` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `forum_desc` text COLLATE utf8mb4_unicode_ci,
  `forum_status` tinyint(1) NOT NULL DEFAULT '0',
  `forum_order` mediumint unsigned NOT NULL DEFAULT '1',
  `forum_posts` mediumint unsigned NOT NULL DEFAULT '0',
  `forum_topics` mediumint unsigned NOT NULL DEFAULT '0',
  `forum_last_post_id` mediumint unsigned NOT NULL DEFAULT '0',
  `prune_next` int DEFAULT NULL,
  `prune_enable` tinyint(1) NOT NULL DEFAULT '0',
  `auth_view` tinyint NOT NULL DEFAULT '0',
  `auth_read` tinyint NOT NULL DEFAULT '0',
  `auth_post` tinyint NOT NULL DEFAULT '0',
  `auth_reply` tinyint NOT NULL DEFAULT '0',
  `auth_edit` tinyint NOT NULL DEFAULT '0',
  `auth_delete` tinyint NOT NULL DEFAULT '0',
  `auth_sticky` tinyint NOT NULL DEFAULT '0',
  `auth_announce` tinyint NOT NULL DEFAULT '0',
  `auth_globalannounce` tinyint NOT NULL DEFAULT '3',
  `auth_vote` tinyint NOT NULL DEFAULT '0',
  `auth_pollcreate` tinyint NOT NULL DEFAULT '0',
  `auth_attachments` tinyint NOT NULL DEFAULT '0',
  `auth_download` tinyint NOT NULL DEFAULT '0',
  `password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `forum_sort` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forum_color` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `forum_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forum_link_internal` tinyint(1) NOT NULL DEFAULT '0',
  `forum_link_hit_count` tinyint(1) NOT NULL DEFAULT '0',
  `forum_link_hit` bigint unsigned NOT NULL DEFAULT '0',
  `main_type` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forum_moderate` tinyint(1) NOT NULL DEFAULT '0',
  `no_count` tinyint(1) NOT NULL DEFAULT '0',
  `forum_trash` smallint NOT NULL DEFAULT '0',
  `forum_separate` smallint NOT NULL DEFAULT '2',
  `forum_show_ga` smallint NOT NULL DEFAULT '1',
  `forum_tree_grade` tinyint(1) NOT NULL DEFAULT '3',
  `forum_tree_req` tinyint(1) NOT NULL DEFAULT '0',
  `forum_no_split` tinyint(1) NOT NULL DEFAULT '0',
  `forum_no_helped` tinyint(1) NOT NULL DEFAULT '0',
  `topic_tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `locked_bottom` tinyint(1) DEFAULT '0',
  `forum_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`forum_id`),
  KEY `forums_order` (`forum_order`),
  KEY `cat_id` (`cat_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`),
  KEY `no_count` (`no_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_forums` WRITE;
/*!40000 ALTER TABLE `phpbb_forums` DISABLE KEYS */;

INSERT INTO `phpbb_forums` (`forum_id`, `cat_id`, `forum_name`, `forum_desc`, `forum_status`, `forum_order`, `forum_posts`, `forum_topics`, `forum_last_post_id`, `prune_next`, `prune_enable`, `auth_view`, `auth_read`, `auth_post`, `auth_reply`, `auth_edit`, `auth_delete`, `auth_sticky`, `auth_announce`, `auth_globalannounce`, `auth_vote`, `auth_pollcreate`, `auth_attachments`, `auth_download`, `password`, `forum_sort`, `forum_color`, `forum_link`, `forum_link_internal`, `forum_link_hit_count`, `forum_link_hit`, `main_type`, `forum_moderate`, `no_count`, `forum_trash`, `forum_separate`, `forum_show_ga`, `forum_tree_grade`, `forum_tree_req`, `forum_no_split`, `forum_no_helped`, `topic_tags`, `locked_bottom`, `forum_template`)
VALUES
	(1,1,'Testowe forum','Testowe forum.',0,20,23,3,97,0,0,0,0,1,0,1,1,3,3,3,1,1,1,1,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(2,1,'Test SubForów','W tym forum, znajdują się dwa testowe fora, można w nim również pisać tematy',0,30,1,1,3,0,0,0,0,1,0,1,1,3,3,3,1,1,1,1,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(3,3,'Testowe podforum 1','Testowe podforum 1',0,50,0,0,0,0,0,0,0,1,0,1,1,3,3,3,1,1,1,1,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(4,3,'Testowe podforum 2','Testowe podforum 2',0,60,0,0,0,0,0,0,0,1,0,1,1,3,3,3,1,1,1,1,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(6,4,'Forum moderacji','W tym forum tylko moderatorzy mogą zakładac nowe tematy',0,80,2,2,9,0,0,0,0,1,0,1,1,3,3,3,1,1,1,1,'','SORT_FPDATE','FF0000','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(7,4,'Sondy moderacji','To jest forum do umieszczania sond, tutaj tylko moderatorzy mogą umieszczać sondy i pisać posty.',0,90,1,1,7,0,0,0,0,1,0,1,1,3,3,3,1,1,1,1,'','SORT_FPDATE','32CD32','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(8,6,'Forum 1','Opis forum',0,120,0,0,0,NULL,0,0,0,1,0,1,1,3,3,5,1,1,1,0,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(9,6,'Forum 2','',0,130,0,0,0,NULL,0,0,0,1,0,1,1,3,3,5,1,1,1,0,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(10,5,'Forum 3','A to ma opis',0,140,0,0,0,NULL,0,0,0,1,0,1,1,3,3,5,1,1,1,0,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(11,5,'Forum 4','',0,150,0,0,0,NULL,0,0,0,1,0,1,1,3,3,5,1,1,1,0,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,NULL),
	(12,7,'Forum','',0,180,1,1,65,NULL,0,0,0,1,0,1,1,3,3,5,1,1,1,0,'','SORT_FPDATE','','',0,0,0,'c',0,0,0,2,1,3,0,0,0,'',0,'articles_body.tpl');

/*!40000 ALTER TABLE `phpbb_forums` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_gallery_images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_gallery_images`;

CREATE TABLE `phpbb_gallery_images` (
  `image_id` int unsigned NOT NULL AUTO_INCREMENT,
  `post_id` mediumint unsigned NOT NULL,
  `topic_id` mediumint unsigned NOT NULL,
  `forum_id` smallint unsigned NOT NULL,
  `poster_id` mediumint unsigned NOT NULL,
  `image_time` int unsigned NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `image_vote` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_gallery_images` WRITE;
/*!40000 ALTER TABLE `phpbb_gallery_images` DISABLE KEYS */;

INSERT INTO `phpbb_gallery_images` (`image_id`, `post_id`, `topic_id`, `forum_id`, `poster_id`, `image_time`, `image_url`, `image_vote`)
VALUES
	(3,97,9,1,2,0,'https://upload.wikimedia.org/wikipedia/commons/9/99/InsSight_spacecraft_appendix_gallery_Image_55-full.jpg',0),
	(4,97,9,1,2,0,'https://image.shutterstock.com/image-photo/bright-spring-view-cameo-island-260nw-1048185397.jpg',0);

/*!40000 ALTER TABLE `phpbb_gallery_images` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_groups`;

CREATE TABLE `phpbb_groups` (
  `group_id` mediumint NOT NULL AUTO_INCREMENT,
  `group_type` tinyint NOT NULL DEFAULT '1',
  `group_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `group_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `group_moderator` mediumint NOT NULL DEFAULT '0',
  `group_single_user` tinyint(1) NOT NULL DEFAULT '1',
  `group_order` mediumint NOT NULL DEFAULT '0',
  `group_count` int unsigned DEFAULT '99999999',
  `group_count_enable` smallint unsigned DEFAULT '0',
  `group_mail_enable` smallint DEFAULT '0',
  `group_no_unsub` smallint DEFAULT '0',
  `group_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_prefix` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `group_single_user` (`group_single_user`),
  KEY `group_type` (`group_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_groups` WRITE;
/*!40000 ALTER TABLE `phpbb_groups` DISABLE KEYS */;

INSERT INTO `phpbb_groups` (`group_id`, `group_type`, `group_name`, `group_description`, `group_moderator`, `group_single_user`, `group_order`, `group_count`, `group_count_enable`, `group_mail_enable`, `group_no_unsub`, `group_color`, `group_prefix`, `group_style`)
VALUES
	(1,1,'Anonymous','Personal User',0,1,0,99999999,0,0,0,'','',''),
	(2,1,'Admin','Personal User',0,1,0,99999999,0,0,0,'','','');

/*!40000 ALTER TABLE `phpbb_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_ignores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_ignores`;

CREATE TABLE `phpbb_ignores` (
  `user_id` mediumint NOT NULL DEFAULT '0',
  `user_ignore` mediumint NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`user_ignore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_jr_admin_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_jr_admin_users`;

CREATE TABLE `phpbb_jr_admin_users` (
  `user_id` mediumint NOT NULL DEFAULT '0',
  `user_jr_admin` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_logs`;

CREATE TABLE `phpbb_logs` (
  `id_log` mediumint NOT NULL AUTO_INCREMENT,
  `mode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `topic_id` mediumint DEFAULT '0',
  `user_id` mediumint DEFAULT '0',
  `username` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_ip` char(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `time` int DEFAULT '0',
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_logs` WRITE;
/*!40000 ALTER TABLE `phpbb_logs` DISABLE KEYS */;

INSERT INTO `phpbb_logs` (`id_log`, `mode`, `topic_id`, `user_id`, `username`, `user_ip`, `time`)
VALUES
	(1,'admin',0,2,'admin','ac120001',1601982842),
	(2,'admin',0,2,'admin','ac120001',1601986766),
	(3,'admin',0,2,'admin','ac120001',1601988770),
	(4,'admin',0,2,'admin','ac120001',1601988868),
	(5,'delete',9,2,'admin','ac120001',1602018194),
	(6,'delete',9,2,'admin','ac120001',1602018198),
	(7,'delete',9,2,'admin','ac120001',1602018204),
	(8,'delete',9,2,'admin','ac120001',1602018208),
	(9,'delete',9,2,'admin','ac120001',1602018211),
	(10,'delete',9,2,'admin','ac120001',1602018216),
	(11,'delete',9,2,'admin','ac120001',1602018221),
	(12,'delete',9,2,'admin','ac120001',1602018225),
	(13,'delete',9,2,'admin','ac120001',1602018229),
	(14,'delete',9,2,'admin','ac120001',1602018234),
	(15,'delete',9,2,'admin','ac120001',1602018238),
	(16,'delete',9,2,'admin','ac120001',1602018242),
	(17,'admin',0,2,'admin','ac120001',1602177000),
	(18,'admin',0,2,'admin','ac120001',1602276344),
	(19,'admin',0,2,'admin','ac120001',1602276445),
	(20,'admin',0,2,'admin','ac120001',1602276461),
	(21,'admin',0,2,'admin','ac120001',1602276614),
	(22,'admin',0,2,'admin','ac120001',1602276620),
	(23,'admin',0,2,'admin','ac120001',1602281112),
	(24,'admin',0,2,'admin','ac120001',1602281121),
	(25,'admin',0,2,'admin','ac120001',1602338328),
	(26,'delete',9,2,'admin','ac120001',1602415846),
	(27,'admin',0,2,'admin','ac120001',1602417768),
	(28,'admin',0,2,'admin','ac120001',1602418179),
	(29,'admin',0,2,'admin','ac120001',1602418748),
	(30,'admin',0,2,'admin','ac120001',1602431818),
	(31,'delete',9,2,'admin','ac120001',1602613875),
	(32,'delete',9,2,'admin','ac120001',1602613948),
	(33,'delete',9,2,'admin','ac120001',1602685852),
	(34,'delete',9,2,'admin','ac120001',1602685858),
	(35,'admin',0,2,'admin','ac120001',1602702805),
	(36,'admin',0,2,'admin','ac120001',1602703033),
	(37,'admin',0,2,'admin','ac120001',1602748717),
	(38,'admin',0,2,'admin','ac120001',1602748736),
	(39,'admin',0,2,'admin','ac120001',1602748748),
	(40,'admin',0,2,'admin','ac120001',1602748760),
	(41,'admin',0,2,'admin','ac120001',1602748789),
	(42,'admin',0,2,'admin','ac120001',1602748810),
	(43,'admin',0,2,'admin','ac120001',1602749548),
	(44,'admin',0,2,'admin','ac120001',1602749726),
	(45,'admin',0,2,'admin','ac120001',1602749758),
	(46,'admin',0,2,'admin','ac120001',1602749983),
	(47,'admin',0,2,'admin','ac120001',1602750020),
	(48,'admin',0,2,'admin','ac120001',1602787924),
	(49,'admin',0,2,'admin','ac120001',1603014670),
	(50,'admin',0,2,'admin','ac120001',1603014725),
	(51,'delete',9,2,'admin','ac120001',1603026569),
	(52,'delete',9,2,'admin','ac120001',1603026574),
	(53,'delete',9,2,'admin','ac120001',1603026581),
	(54,'delete',9,2,'admin','ac120001',1603026586),
	(55,'admin',0,2,'admin','ac120001',1603090107),
	(56,'admin',0,2,'admin','ac120001',1603090117),
	(57,'admin',0,2,'admin','ac120001',1603127381);

/*!40000 ALTER TABLE `phpbb_logs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_mass_email
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_mass_email`;

CREATE TABLE `phpbb_mass_email` (
  `mass_email_user_id` mediumint NOT NULL DEFAULT '0',
  `mass_email_text` longtext COLLATE utf8mb4_unicode_ci,
  `mass_email_subject` text COLLATE utf8mb4_unicode_ci,
  `mass_email_bcc` longtext COLLATE utf8mb4_unicode_ci,
  `mass_email_html` tinyint(1) NOT NULL DEFAULT '0',
  `mass_email_to` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`mass_email_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_posts`;

CREATE TABLE `phpbb_posts` (
  `post_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` mediumint unsigned NOT NULL DEFAULT '0',
  `forum_id` smallint unsigned NOT NULL DEFAULT '0',
  `poster_id` mediumint NOT NULL DEFAULT '0',
  `post_time` int NOT NULL DEFAULT '0',
  `post_start_time` int NOT NULL DEFAULT '0',
  `poster_ip` char(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enable_bbcode` tinyint(1) NOT NULL DEFAULT '1',
  `enable_html` tinyint(1) NOT NULL DEFAULT '0',
  `enable_smilies` tinyint(1) NOT NULL DEFAULT '1',
  `enable_sig` tinyint(1) NOT NULL DEFAULT '1',
  `post_edit_time` int DEFAULT '0',
  `post_edit_count` smallint unsigned NOT NULL DEFAULT '0',
  `post_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_icon` tinyint unsigned NOT NULL DEFAULT '0',
  `post_expire` int NOT NULL DEFAULT '0',
  `reporter_id` mediumint NOT NULL DEFAULT '0',
  `post_marked` enum('n','y') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_approve` tinyint(1) NOT NULL DEFAULT '1',
  `poster_delete` tinyint(1) DEFAULT '0',
  `post_edit_by` mediumint NOT NULL DEFAULT '0',
  `post_parent` mediumint NOT NULL DEFAULT '0',
  `post_order` mediumint NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_id` (`poster_id`),
  KEY `post_time` (`post_time`),
  KEY `reporter_id` (`reporter_id`),
  KEY `post_parent` (`post_parent`),
  KEY `post_approve` (`post_approve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_posts` WRITE;
/*!40000 ALTER TABLE `phpbb_posts` DISABLE KEYS */;

INSERT INTO `phpbb_posts` (`post_id`, `topic_id`, `forum_id`, `poster_id`, `post_time`, `post_start_time`, `poster_ip`, `post_username`, `enable_bbcode`, `enable_html`, `enable_smilies`, `enable_sig`, `post_edit_time`, `post_edit_count`, `post_attachment`, `user_agent`, `post_icon`, `post_expire`, `reporter_id`, `post_marked`, `post_approve`, `poster_delete`, `post_edit_by`, `post_parent`, `post_order`)
VALUES
	(3,2,2,2,1064458873,0,'7f000001','',1,0,1,0,0,0,0,'a:3:{i:0;s:16:\"icon_unknown.png\";i:1;s:16:\"icon_unknown.png\";i:2;s:0:\"\";}',0,0,0,'n',1,0,0,0,0),
	(5,4,1,2,1065136668,0,'7f000001','',1,0,0,0,0,0,0,'a:3:{i:0;s:16:\"icon_unknown.png\";i:1;s:16:\"icon_unknown.png\";i:2;s:0:\"\";}',2,0,0,'n',1,0,0,0,0),
	(7,5,7,2,1065137203,0,'7f000001','',1,0,1,0,0,0,0,'a:3:{i:0;s:16:\"icon_unknown.png\";i:1;s:16:\"icon_unknown.png\";i:2;s:0:\"\";}',0,0,0,'n',1,0,0,0,0),
	(8,6,6,2,1065137320,0,'7f000001','',1,0,1,0,0,0,0,'a:3:{i:0;s:16:\"icon_unknown.png\";i:1;s:16:\"icon_unknown.png\";i:2;s:0:\"\";}',0,0,0,'n',1,0,0,0,0),
	(9,7,6,2,1065137383,0,'7f000001','',1,0,1,0,0,0,0,'a:3:{i:0;s:16:\"icon_unknown.png\";i:1;s:16:\"icon_unknown.png\";i:2;s:0:\"\";}',0,0,0,'n',1,0,0,0,0),
	(10,4,1,2,1601919207,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,'n',1,0,0,0,1),
	(11,8,1,2,1601919228,0,'ac120001','',1,0,1,0,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,'n',1,0,0,0,1),
	(12,8,1,2,1601919232,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,'n',1,0,0,0,2),
	(13,8,1,2,1601919237,0,'ac120001','',1,0,1,0,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,'n',1,0,0,0,3),
	(14,8,1,2,1601922750,0,'ac120001','',1,0,1,0,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,'n',1,0,0,0,4),
	(15,9,1,2,1601927258,0,'ac120001','',1,0,1,0,1603023244,5,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,'n',1,0,0,0,1),
	(44,9,1,2,1601982596,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,5),
	(55,9,1,2,1602415830,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,7),
	(56,9,1,2,1602481486,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,8),
	(59,9,1,2,1602613976,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,9),
	(62,9,1,2,1602614212,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,12),
	(63,9,1,2,1602657429,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,13),
	(64,9,1,2,1602664040,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,14),
	(65,10,12,2,1602702134,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,1),
	(90,9,1,2,1603025823,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,19),
	(94,9,1,2,1603026405,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,20),
	(97,9,1,2,1603026512,0,'ac120001','',1,0,1,1,0,0,0,'a:3:{i:0;s:14:\"icon_apple.png\";i:1;s:16:\"icon_firefox.png\";i:2;s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0\";}',0,0,0,NULL,1,0,0,0,21);

/*!40000 ALTER TABLE `phpbb_posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_posts_text
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_posts_text`;

CREATE TABLE `phpbb_posts_text` (
  `post_id` mediumint unsigned NOT NULL DEFAULT '0',
  `bbcode_uid` char(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_subject` char(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_text` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_posts_text` WRITE;
/*!40000 ALTER TABLE `phpbb_posts_text` DISABLE KEYS */;

INSERT INTO `phpbb_posts_text` (`post_id`, `bbcode_uid`, `post_subject`, `post_text`)
VALUES
	(3,'b63934e592','Testowy temat w SubForum','Testowy temat w SubForum'),
	(5,'bcf3b5262c','Witaj na forum phpBB modified by Przemo','Dziękuję, za wybranie [URL=http://www.przemo.org/phpBB2/]phpBB modified by Przemo[/URL] do obsługi Twojego Forum.\r\n\r\nZapoznaj się dokładnie z instrukcjami zamieszczonymi w pliku [b:bcf3b5262c]/docs/readme.html[/b:bcf3b5262c] w katalogu forum.'),
	(7,'2fe4a4ef6b','Sonda1','sonda1'),
	(8,'c93fefdf03','Test trzeciego newsa','[URL=http://www.przemo.org]test[/URL] [b:c93fefdf03]test[/b:c93fefdf03] [size=18:c93fefdf03][shadow=red:c93fefdf03]test[/shadow:c93fefdf03][/size:c93fefdf03]\r\n\r\nt\r\n\r\ne\r\n\r\ns\r\n\r\nt\r\n\r\n.\r\n.\r\n.\r\n.\r\n.\r\n.\r\n.\r\n\r\nn\r\n\r\ne'),
	(9,'e7c9e3e71f','test drugiego newsa','[URL=http://www.przemo.org]test[/URL] [b:e7c9e3e71f]test[/b:e7c9e3e71f] [size=18:e7c9e3e71f][shadow=red:e7c9e3e71f]test[/shadow:e7c9e3e71f][/size:e7c9e3e71f]\r\n\r\nt\r\n\r\ne\r\n\r\ns\r\n\r\nt\r\n\r\n\r\n\r\nn\r\n\r\ne\r\n\r\nw\r\n\r\ns\r\n\r\na'),
	(10,'17b469a208','','ąćęśółńźż'),
	(11,'245429aea9','ąćęśółńźż','ąćęśółńźż'),
	(12,'3488acc63f','','ąćęśółńźż'),
	(13,'6d8f59a475','','ąćęśółńźż'),
	(14,'ec692bc3f0','','test'),
	(15,'18e85b0391','Przykładowy temat','A tutaj trochę treści.\n\n[img]https://i.pinimg.com/originals/3b/8a/d2/3b8ad2c7b1be2caf24321c852103598a.jpg[/img]'),
	(38,'9202918450','','HELLO ąśćęłńóźżĄŻĆĘŚŁÓųŃ\r\n\r\n😊🥺😉😍😘😚😜😂😝😳😁😣😢'),
	(44,'0a3e80ad06','','😝😳😁😣😢'),
	(55,'227b750807','','[img:227b750807]https://i.pinimg.com/originals/3b/8a/d2/3b8ad2c7b1be2caf24321c852103598a.jpg[/img:227b750807]\r\n\r\ntest'),
	(56,'79be727b55','','[img:79be727b55]https://images7.alphacoders.com/617/617537.jpg[/img:79be727b55]\r\nCurabitur ut auctor ex. Morbi imperdiet pharetra turpis, ut ultrices tellus scelerisque in. Pellentesque vitae mollis lorem. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce est nulla, commodo ac ligula quis, fermentum ultricies odio. Curabitur efficitur massa eget velit viverra vestibulum. [b:79be727b55]Cras tincidunt neque at turpis elementum pulvinar. [/b:79be727b55]Vestibulum eget varius risus. Sed quis vestibulum metus. Sed ut massa sit amet nisl porttitor tempus. Proin sagittis ante nulla. Ut sed diam ut tortor finibus pharetra. Phasellus rhoncus dolor ut neque finibus lobortis. Donec elementum lacus non mattis eleifend. Nunc convallis aliquam ante, sit amet euismod ex mollis aliquam. Praesent tempor pretium sodales.'),
	(59,'18bac79a20','','[img:18bac79a20]http://www.codebuilders.pl/codebuilders.png[/img:18bac79a20]\r\n[url]http://www.codebuilders.pl/codebuilders.png[/url]\r\n[url=http://www.codebuilders.pl/codebuilders.png]&quot;test&quot;[/url]'),
	(62,'1c666ac1a9','','http://www.codebuilders.pl/codebuilders.png\n\n[youtube]https://www.youtube.com/watch?v=c9HWz_yckHc&ab_channel=RhettDrum[/youtube]'),
	(63,'ecb61d0931','','[img:ecb61d0931]http://www.codebuilders.pl/codebuilders.jpg&quot;%20onerror=&quot;alert(\'alert\')[/img:ecb61d0931]'),
	(64,'609ec4d640','','[img:609ec4d640]http://www.codebuilders.pl/codebuilders.jpg?dupa[/img:609ec4d640]'),
	(65,'2f561b2cec','Hello world','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In facilisis tellus vitae purus consectetur, a euismod mauris finibus. Mauris tristique eros sit amet rutrum faucibus. Phasellus ipsum urna, egestas nec commodo non, dapibus ac nisl. Donec non dignissim elit, vel efficitur ex. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam viverra cursus lectus nec lobortis. Proin non laoreet tellus, vel aliquet turpis. Aliquam erat volutpat. \nAliquam erat volutpat. Sed vel posuere arcu. Aliquam porttitor, felis ac dapibus pellentesque, eros libero sagittis mi, vitae pellentesque lectus ex in mi.Maecenas euismod pulvinar velit, vel iaculis dolor porta sed. Aliquam laoreet leo vel mi lacinia, et condimentum arcu luctus. Sed aliquet laoreet erat nec accumsan. Sed consequat consequat pretium. Mauris pellentesque ullamcorper metus, nec mollis dui. Sed quis turpis non tortor condimentum dictum. Morbi non sem eget mauris aliquet convallis. In sit amet convallis augue. In porta est sit amet velit vestibulum posuere. Sed consequat auctor tortor eu suscipit.Cras pretium elit at ligula faucibus eleifend. Pellentesque pretium malesuada mauris sed pharetra. Nullam hendrerit diam nisi, vel tempus neque mattis at. Aenean felis tortor, blandit ut nulla id, sodales semper nibh. \n\nMorbi at interdum nunc. Nulla in consequat ex. Phasellus pellentesque, ligula in sodales tempor, turpis leo aliquam elit, eu consequat lectus leo eget nisl. Sed varius consequat nulla, ac malesuada nunc venenatis non. Nam dignissim, ligula vitae facilisis tristique, turpis orci congue turpis, sit amet tincidunt sem lacus ut mi.Vivamus egestas mattis felis, id vehicula erat. Mauris eget eros eget mauris mollis vestibulum. Ut laoreet felis est. Aenean a massa nec arcu rhoncus blandit vitae et ligula. Fusce sed posuere odio. Maecenas pellentesque quam sit amet quam ultrices, a eleifend dui hendrerit. Phasellus vitae odio non leo bibendum finibus. Praesent posuere quam sem, eu sodales nibh bibendum ut. \n\nPhasellus ornare arcu lectus, vitae sollicitudin tellus lacinia a. Nulla nibh ligula, placerat nec magna nec, efficitur venenatis lorem. Duis auctor dui vel risus ultrices vulputate. Etiam elementum odio quam.Ut ac nisi non tellus mollis pretium quis vulputate neque. Curabitur et consectetur augue. Nam nec eros volutpat, volutpat nulla nec, ullamcorper magna. Praesent maximus, urna ut dignissim gravida, tellus mi varius sem, sit amet dignissim arcu dui ac massa. Cras sit amet libero in metus maximus lacinia. Ut varius felis leo, ac feugiat sapien congue sed. Quisque tempor lobortis nisi, eget tristique ante blandit id. Sed quis massa nec quam ultrices vulputate id a lacus. Morbi euismod sagittis arcu, sed accumsan nunc dignissim eget. Integer imperdiet tincidunt ipsum, sit amet sagittis nisl rhoncus sit amet. Vivamus et blandit nibh. Vestibulum vel ex felis. Nulla in lectus sit amet nulla placerat vulputate id nec mi.\n\n[img:2f561b2cec]https://i.insider.com/5eb031e1e3c3fb77d21c342e?width=1100&format=jpeg&auto=webp[/img:2f561b2cec]'),
	(90,'dff689ab15','','[img:dff689ab15]https://upload.wikimedia.org/wikipedia/commons/9/99/InsSight_spacecraft_appendix_gallery_Image_55-full.jpg[/img:dff689ab15] [img:dff689ab15]https://image.shutterstock.com/image-photo/bright-spring-view-cameo-island-260nw-1048185397.jpg[/img:dff689ab15]'),
	(94,'fb640374b8','','[img:fb640374b8]https://upload.wikimedia.org/wikipedia/commons/9/99/InsSight_spacecraft_appendix_gallery_Image_55-full.jpg[/img:fb640374b8] [img:fb640374b8]https://image.shutterstock.com/image-photo/bright-spring-view-cameo-island-260nw-1048185397.jpg[/img:fb640374b8]'),
	(97,'3be6d67c00','','[img:3be6d67c00]https://upload.wikimedia.org/wikipedia/commons/9/99/InsSight_spacecraft_appendix_gallery_Image_55-full.jpg[/img:3be6d67c00] [img:3be6d67c00]https://image.shutterstock.com/image-photo/bright-spring-view-cameo-island-260nw-1048185397.jpg[/img:3be6d67c00]');

/*!40000 ALTER TABLE `phpbb_posts_text` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_posts_text_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_posts_text_history`;

CREATE TABLE `phpbb_posts_text_history` (
  `th_id` mediumint NOT NULL AUTO_INCREMENT,
  `th_post_id` mediumint unsigned NOT NULL DEFAULT '0',
  `th_post_text` text COLLATE utf8mb4_unicode_ci,
  `th_user_id` mediumint NOT NULL DEFAULT '0',
  `th_time` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`th_id`),
  KEY `th_post_id` (`th_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_posts_text_history` WRITE;
/*!40000 ALTER TABLE `phpbb_posts_text_history` DISABLE KEYS */;

INSERT INTO `phpbb_posts_text_history` (`th_id`, `th_post_id`, `th_post_text`, `th_user_id`, `th_time`)
VALUES
	(4,56,'[img:cc9d3da2e0]https://images7.alphacoders.com/617/617537.jpg[/img:cc9d3da2e0]\r\nCurabitur ut auctor ex. Morbi imperdiet pharetra turpis, ut ultrices tellus scelerisque in. Pellentesque vitae mollis lorem. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce est nulla, commodo ac ligula quis, fermentum ultricies odio. Curabitur efficitur massa eget velit viverra vestibulum. Cras tincidunt neque at turpis elementum pulvinar. Vestibulum eget varius risus. Sed quis vestibulum metus. Sed ut massa sit amet nisl porttitor tempus. Proin sagittis ante nulla. Ut sed diam ut tortor finibus pharetra. Phasellus rhoncus dolor ut neque finibus lobortis. Donec elementum lacus non mattis eleifend. Nunc convallis aliquam ante, sit amet euismod ex mollis aliquam. Praesent tempor pretium sodales.',2,1602601256);

/*!40000 ALTER TABLE `phpbb_posts_text_history` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_posts_votes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_posts_votes`;

CREATE TABLE `phpbb_posts_votes` (
  `forum_id` smallint unsigned NOT NULL,
  `topic_id` mediumint unsigned NOT NULL,
  `post_id` mediumint unsigned NOT NULL,
  `user_id` mediumint NOT NULL,
  `vote` tinyint(1) NOT NULL,
  `timestamp` int NOT NULL,
  UNIQUE KEY `unique_vote_per_post` (`user_id`,`post_id`),
  KEY `topic_id` (`topic_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_posts_votes` WRITE;
/*!40000 ALTER TABLE `phpbb_posts_votes` DISABLE KEYS */;

INSERT INTO `phpbb_posts_votes` (`forum_id`, `topic_id`, `post_id`, `user_id`, `vote`, `timestamp`)
VALUES
	(1,9,15,-1,1,1603646502),
	(1,9,44,-1,1,1603646506),
	(1,8,11,2,1,1602684880),
	(1,9,15,2,1,1603651786),
	(1,9,44,2,1,1602684517),
	(1,9,55,2,1,1602682491),
	(1,9,56,2,1,1602685880),
	(1,9,64,2,1,1602682615),
	(1,9,94,2,1,1603996248),
	(1,9,55,3,1,1602682491);

/*!40000 ALTER TABLE `phpbb_posts_votes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_privmsgs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_privmsgs`;

CREATE TABLE `phpbb_privmsgs` (
  `privmsgs_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `privmsgs_type` tinyint NOT NULL DEFAULT '0',
  `privmsgs_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `privmsgs_from_userid` mediumint NOT NULL DEFAULT '0',
  `privmsgs_to_userid` mediumint NOT NULL DEFAULT '0',
  `privmsgs_date` int NOT NULL DEFAULT '0',
  `privmsgs_ip` char(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `privmsgs_enable_bbcode` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_enable_html` tinyint(1) NOT NULL DEFAULT '0',
  `privmsgs_enable_smilies` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_attach_sig` tinyint(1) NOT NULL DEFAULT '1',
  `privmsgs_attachment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`privmsgs_id`),
  KEY `privmsgs_from_userid` (`privmsgs_from_userid`),
  KEY `privmsgs_to_userid` (`privmsgs_to_userid`),
  KEY `privmsgs_type` (`privmsgs_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_privmsgs_text
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_privmsgs_text`;

CREATE TABLE `phpbb_privmsgs_text` (
  `privmsgs_text_id` mediumint unsigned NOT NULL DEFAULT '0',
  `privmsgs_bbcode_uid` char(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `privmsgs_text` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`privmsgs_text_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_quota_limits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_quota_limits`;

CREATE TABLE `phpbb_quota_limits` (
  `quota_limit_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `quota_desc` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `quota_limit` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`quota_limit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_quota_limits` WRITE;
/*!40000 ALTER TABLE `phpbb_quota_limits` DISABLE KEYS */;

INSERT INTO `phpbb_quota_limits` (`quota_limit_id`, `quota_desc`, `quota_limit`)
VALUES
	(1,'Low',262144),
	(2,'Medium',2097152),
	(3,'High',5242880);

/*!40000 ALTER TABLE `phpbb_quota_limits` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_ranks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_ranks`;

CREATE TABLE `phpbb_ranks` (
  `rank_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `rank_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rank_min` mediumint NOT NULL DEFAULT '0',
  `rank_special` tinyint(1) DEFAULT '0',
  `rank_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `rank_group` mediumint NOT NULL DEFAULT '0',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_ranks` WRITE;
/*!40000 ALTER TABLE `phpbb_ranks` DISABLE KEYS */;

INSERT INTO `phpbb_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_special`, `rank_image`, `rank_group`)
VALUES
	(1,'Administrator',-1,1,'',0);

/*!40000 ALTER TABLE `phpbb_ranks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_read_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_read_history`;

CREATE TABLE `phpbb_read_history` (
  `user_id` mediumint NOT NULL DEFAULT '0',
  `post_id` mediumint unsigned NOT NULL DEFAULT '0',
  `topic_id` mediumint unsigned NOT NULL DEFAULT '0',
  `forum_id` smallint unsigned NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  KEY `topic_id` (`topic_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_search_results
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_search_results`;

CREATE TABLE `phpbb_search_results` (
  `search_id` int unsigned NOT NULL AUTO_INCREMENT,
  `session_id` char(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `search_array` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `search_time` int NOT NULL,
  PRIMARY KEY (`search_id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_search_results` WRITE;
/*!40000 ALTER TABLE `phpbb_search_results` DISABLE KEYS */;

INSERT INTO `phpbb_search_results` (`search_id`, `session_id`, `search_array`, `search_time`)
VALUES
	(1796350898,'8c418ef0ca67c8e10555df6f7fc4a968','a:7:{s:14:\"search_results\";N;s:17:\"total_match_count\";N;s:12:\"split_search\";N;s:7:\"sort_by\";N;s:8:\"sort_dir\";N;s:12:\"show_results\";N;s:12:\"return_chars\";N;}',1602680679);

/*!40000 ALTER TABLE `phpbb_search_results` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_search_wordlist
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_search_wordlist`;

CREATE TABLE `phpbb_search_wordlist` (
  `word_text` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `word_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `word_common` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`word_text`),
  KEY `word_id` (`word_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_search_wordlist` WRITE;
/*!40000 ALTER TABLE `phpbb_search_wordlist` DISABLE KEYS */;

INSERT INTO `phpbb_search_wordlist` (`word_text`, `word_id`, `word_common`)
VALUES
	(X'61',297,0),
	(X'616363756D73616E',298,0),
	(X'616363756D73616E2E',299,0),
	(X'61646970697363696E67',300,0),
	(X'61656E65616E',301,0),
	(X'616C697175616D',170,0),
	(X'616C697175616D2E',171,0),
	(X'616C6971756574',302,0),
	(X'616D6574',172,0),
	(X'616D65742E',303,0),
	(X'616E7465',173,0),
	(X'61726375',304,0),
	(X'617263752E',305,0),
	(X'61742E',306,0),
	(X'617563746F72',174,0),
	(X'61756775652E',307,0),
	(X'626962656E64756D',308,0),
	(X'626C616E646974',309,0),
	(X'636F64656275696C646572732E706C',287,0),
	(X'636F64656275696C646572732E706E67',288,0),
	(X'636F6D6D6F646F',175,0),
	(X'636F6E64696D656E74756D',310,0),
	(X'636F6E677565',311,0),
	(X'636F6E7365637465747572',312,0),
	(X'636F6E736571756174',313,0),
	(X'636F6E76616C6C6973',176,0),
	(X'636F6E76616C6C69732E',314,0),
	(X'63726173',177,0),
	(X'637572616269747572',178,0),
	(X'637572737573',315,0),
	(X'64617069627573',316,0),
	(X'6469616D',179,0),
	(X'64696374756D2E',317,0),
	(X'6469676E697373696D',318,0),
	(X'646973',180,0),
	(X'646F6373',4,0),
	(X'646F6BC58261646E6965',5,0),
	(X'646F6C6F72',181,0),
	(X'646F6E6563',182,0),
	(X'647275676965676F',27,0),
	(X'647569',319,0),
	(X'6475692E',320,0),
	(X'64756973',321,0),
	(X'647A69C4996B756AC499',6,0),
	(X'656666696369747572',183,0),
	(X'65676573746173',322,0),
	(X'65676574',184,0),
	(X'656765742E',323,0),
	(X'656C656966656E64',324,0),
	(X'656C656966656E642E',185,0),
	(X'656C656D656E74756D',186,0),
	(X'656C6974',325,0),
	(X'656C69742E',326,0),
	(X'65726174',327,0),
	(X'657261742E',328,0),
	(X'65726F73',329,0),
	(X'657374',187,0),
	(X'6573742E',330,0),
	(X'657469616D',331,0),
	(X'657569736D6F64',188,0),
	(X'65782E',189,0),
	(X'666163696C69736973',332,0),
	(X'6661756369627573',333,0),
	(X'66617563696275732E',334,0),
	(X'66656C6973',335,0),
	(X'66656C69732E',336,0),
	(X'6665726D656E74756D',190,0),
	(X'66657567696174',337,0),
	(X'66696E69627573',191,0),
	(X'66696E696275732E',338,0),
	(X'666F72756D',7,0),
	(X'666F72756D2E',8,0),
	(X'6675736365',192,0),
	(X'67726176696461',339,0),
	(X'68656C6C6F',13,0),
	(X'68656E647265726974',340,0),
	(X'68656E6472657269742E',341,0),
	(X'696163756C6973',342,0),
	(X'69642E',343,0),
	(X'696D70657264696574',193,0),
	(X'696E',344,0),
	(X'696E2E',194,0),
	(X'696E737472756B636A616D69',9,0),
	(X'696E7465676572',345,0),
	(X'696E74657264756D',346,0),
	(X'697073756D',347,0),
	(X'6B6174616C6F6775',10,0),
	(X'6C6163696E6961',348,0),
	(X'6C6163696E69612E',349,0),
	(X'6C61637573',195,0),
	(X'6C616375732E',350,0),
	(X'6C616F72656574',351,0),
	(X'6C6563747573',352,0),
	(X'6C656F',353,0),
	(X'6C696265726F',354,0),
	(X'6C6967756C61',196,0),
	(X'6C6967756C612E',355,0),
	(X'6C6F626F72746973',356,0),
	(X'6C6F626F727469732E',197,0),
	(X'6C6F72656D',357,0),
	(X'6C6F72656D2E',198,0),
	(X'6C75637475732E',358,0),
	(X'6D616563656E6173',359,0),
	(X'6D61676E61',360,0),
	(X'6D61676E612E',361,0),
	(X'6D61676E6973',199,0),
	(X'6D616C657375616461',362,0),
	(X'6D61737361',200,0),
	(X'6D617373612E',363,0),
	(X'6D6174746973',201,0),
	(X'6D6175726973',364,0),
	(X'6D6178696D7573',365,0),
	(X'6D65747573',366,0),
	(X'6D657475732E',202,0),
	(X'6D692E',367,0),
	(X'6D692E6D616563656E6173',368,0),
	(X'6D692E766976616D7573',369,0),
	(X'6D6F646966696564',11,0),
	(X'6D6F6C6C6973',203,0),
	(X'6D6F6E746573',204,0),
	(X'6D6F726269',205,0),
	(X'6D75732E',206,0),
	(X'6E616D',370,0),
	(X'6E61736365747572',207,0),
	(X'6E61746F717565',208,0),
	(X'6E6563',371,0),
	(X'6E65717565',209,0),
	(X'6E657175652E',372,0),
	(X'6E65777361',24,0),
	(X'6E696268',373,0),
	(X'6E6962682E',374,0),
	(X'6E697369',375,0),
	(X'6E69736C',210,0),
	(X'6E69736C2E',376,0),
	(X'6E6F6E',211,0),
	(X'6E6F6E2E',377,0),
	(X'6E6F74',378,0),
	(X'6E756C6C61',212,0),
	(X'6E756C6C612E',213,0),
	(X'6E756C6C616D',379,0),
	(X'6E756E63',214,0),
	(X'6E756E632E',380,0),
	(X'6F6273C582756769',12,0),
	(X'6F64696F',381,0),
	(X'6F64696F2E',215,0),
	(X'6F706973',6,0),
	(X'6F726369',216,0),
	(X'6F726E617265',382,0),
	(X'70617274757269656E74',217,0),
	(X'70656C6C656E746573717565',218,0),
	(X'70656E617469627573',219,0),
	(X'7068617265747261',220,0),
	(X'70686172657472612E',221,0),
	(X'70686173656C6C7573',222,0),
	(X'7068706262',13,0),
	(X'706C616365726174',383,0),
	(X'706C696B75',14,0),
	(X'706F727461',384,0),
	(X'706F72747469746F72',223,0),
	(X'706F7375657265',385,0),
	(X'706F73756572652E',386,0),
	(X'7072616573656E74',224,0),
	(X'7072657469756D',225,0),
	(X'7072657469756D2E',387,0),
	(X'70726F696E',226,0),
	(X'70727A656D6F',15,0),
	(X'70727A796BC58261646F7779',7,0),
	(X'70756C76696E6172',388,0),
	(X'70756C76696E61722E',227,0),
	(X'7075727573',389,0),
	(X'7175616D',390,0),
	(X'7175616D2E7574',391,0),
	(X'71756973',228,0),
	(X'71756973717565',392,0),
	(X'71756F74',289,0),
	(X'726561646D652E68746D6C',16,0),
	(X'72686F6E637573',229,0),
	(X'7269646963756C7573',230,0),
	(X'7269737573',393,0),
	(X'72697375732E',231,0),
	(X'72757472756D',394,0),
	(X'7361676974746973',232,0),
	(X'73617069656E',395,0),
	(X'7363656C65726973717565',233,0),
	(X'736564',234,0),
	(X'7365642E',396,0),
	(X'73656D',397,0),
	(X'73656D706572',398,0),
	(X'736974',235,0),
	(X'7369C499',17,0),
	(X'736F64616C6573',399,0),
	(X'736F64616C65732E',236,0),
	(X'736F6C6C696369747564696E',400,0),
	(X'736F6E646131',23,0),
	(X'737562666F72756D',1,0),
	(X'73757363697069742E63726173',401,0),
	(X'74656C6C7573',237,0),
	(X'74656D6174',8,0),
	(X'74656D617475',9,0),
	(X'74656D706F72',238,0),
	(X'74656D707573',402,0),
	(X'74656D7075732E',239,0),
	(X'74657374',5,0),
	(X'746573746F7779',3,0),
	(X'74696E636964756E74',240,0),
	(X'746F72746F72',241,0),
	(X'747265C59B63692E',10,0),
	(X'747269737469717565',403,0),
	(X'74726F6368C499',11,0),
	(X'74727A65636965676F',26,0),
	(X'747572706973',242,0),
	(X'7475727069732E',404,0),
	(X'747574616A',12,0),
	(X'74776F6A65676F',18,0),
	(X'756C6C616D636F72706572',405,0),
	(X'756C747269636573',243,0),
	(X'756C74726963696573',244,0),
	(X'75726E61',406,0),
	(X'75742E',407,0),
	(X'766172697573',245,0),
	(X'7665686963756C61',408,0),
	(X'76656C',409,0),
	(X'76656C6974',246,0),
	(X'76656E656E61746973',410,0),
	(X'766573746962756C756D',247,0),
	(X'766573746962756C756D2E',248,0),
	(X'7669746165',249,0),
	(X'766976616D7573',411,0),
	(X'76697665727261',250,0),
	(X'766F6C7574706174',412,0),
	(X'766F6C75747061742E',413,0),
	(X'76756C707574617465',414,0),
	(X'76756C7075746174652E',415,0),
	(X'776974616A',19,0),
	(X'776F726C64',416,0),
	(X'77796272616E6965',20,0),
	(X'7A616D6965737A637A6F6E796D69',21,0),
	(X'7A61706F7A6E616A',22,0),
	(X'C485C487C499C59BC3B3C582C584C5BAC5BC',1,0),
	(X'F09F989DF09F98B3F09F9881F09F98A3F09F98A2',55,0);

/*!40000 ALTER TABLE `phpbb_search_wordlist` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_search_wordmatch
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_search_wordmatch`;

CREATE TABLE `phpbb_search_wordmatch` (
  `post_id` mediumint unsigned NOT NULL DEFAULT '0',
  `word_id` mediumint unsigned NOT NULL DEFAULT '0',
  `title_match` tinyint(1) NOT NULL DEFAULT '0',
  KEY `post_id` (`post_id`),
  KEY `word_id` (`word_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_search_wordmatch` WRITE;
/*!40000 ALTER TABLE `phpbb_search_wordmatch` DISABLE KEYS */;

INSERT INTO `phpbb_search_wordmatch` (`post_id`, `word_id`, `title_match`)
VALUES
	(3,1,0),
	(3,2,0),
	(3,3,0),
	(3,1,1),
	(3,2,1),
	(3,3,1),
	(5,4,0),
	(5,5,0),
	(5,6,0),
	(5,8,0),
	(5,9,0),
	(5,10,0),
	(5,11,0),
	(5,12,0),
	(5,13,0),
	(5,14,0),
	(5,15,0),
	(5,16,0),
	(5,17,0),
	(5,18,0),
	(5,20,0),
	(5,21,0),
	(5,22,0),
	(5,7,1),
	(5,11,1),
	(5,13,1),
	(5,15,1),
	(5,19,1),
	(7,23,0),
	(7,23,1),
	(8,25,0),
	(8,24,1),
	(8,25,1),
	(8,26,1),
	(9,25,0),
	(9,27,1),
	(9,24,1),
	(9,25,1),
	(10,30,0),
	(11,30,0),
	(11,30,1),
	(11,30,2),
	(12,30,0),
	(12,30,2),
	(13,30,0),
	(13,30,2),
	(14,25,0),
	(14,30,2),
	(38,43,0),
	(38,36,2),
	(38,38,2),
	(44,55,0),
	(44,36,2),
	(44,38,2),
	(10,1,0),
	(11,1,0),
	(11,1,1),
	(11,1,2),
	(12,1,0),
	(13,1,0),
	(14,5,0),
	(55,5,0),
	(56,170,0),
	(56,171,0),
	(56,172,0),
	(56,173,0),
	(56,174,0),
	(56,175,0),
	(56,176,0),
	(56,177,0),
	(56,178,0),
	(56,179,0),
	(56,180,0),
	(56,181,0),
	(56,182,0),
	(56,183,0),
	(56,184,0),
	(56,185,0),
	(56,186,0),
	(56,187,0),
	(56,188,0),
	(56,189,0),
	(56,190,0),
	(56,191,0),
	(56,192,0),
	(56,193,0),
	(56,194,0),
	(56,195,0),
	(56,196,0),
	(56,197,0),
	(56,198,0),
	(56,199,0),
	(56,200,0),
	(56,201,0),
	(56,202,0),
	(56,203,0),
	(56,204,0),
	(56,205,0),
	(56,206,0),
	(56,207,0),
	(56,208,0),
	(56,209,0),
	(56,210,0),
	(56,211,0),
	(56,212,0),
	(56,213,0),
	(56,214,0),
	(56,215,0),
	(56,216,0),
	(56,217,0),
	(56,218,0),
	(56,219,0),
	(56,220,0),
	(56,221,0),
	(56,222,0),
	(56,223,0),
	(56,224,0),
	(56,225,0),
	(56,226,0),
	(56,227,0),
	(56,228,0),
	(56,229,0),
	(56,230,0),
	(56,231,0),
	(56,232,0),
	(56,233,0),
	(56,234,0),
	(56,235,0),
	(56,236,0),
	(56,237,0),
	(56,238,0),
	(56,239,0),
	(56,240,0),
	(56,241,0),
	(56,242,0),
	(56,243,0),
	(56,244,0),
	(56,245,0),
	(56,246,0),
	(56,247,0),
	(56,248,0),
	(56,249,0),
	(56,250,0),
	(59,287,0),
	(59,288,0),
	(59,289,0),
	(59,5,0),
	(62,287,0),
	(62,288,0),
	(65,170,0),
	(65,172,0),
	(65,173,0),
	(65,174,0),
	(65,175,0),
	(65,176,0),
	(65,177,0),
	(65,178,0),
	(65,179,0),
	(65,180,0),
	(65,181,0),
	(65,182,0),
	(65,183,0),
	(65,184,0),
	(65,185,0),
	(65,186,0),
	(65,187,0),
	(65,188,0),
	(65,189,0),
	(65,192,0),
	(65,193,0),
	(65,195,0),
	(65,196,0),
	(65,197,0),
	(65,198,0),
	(65,199,0),
	(65,200,0),
	(65,201,0),
	(65,203,0),
	(65,204,0),
	(65,205,0),
	(65,206,0),
	(65,207,0),
	(65,208,0),
	(65,209,0),
	(65,210,0),
	(65,211,0),
	(65,212,0),
	(65,214,0),
	(65,215,0),
	(65,216,0),
	(65,217,0),
	(65,218,0),
	(65,219,0),
	(65,221,0),
	(65,222,0),
	(65,223,0),
	(65,224,0),
	(65,225,0),
	(65,226,0),
	(65,228,0),
	(65,229,0),
	(65,230,0),
	(65,232,0),
	(65,234,0),
	(65,235,0),
	(65,237,0),
	(65,238,0),
	(65,240,0),
	(65,241,0),
	(65,242,0),
	(65,243,0),
	(65,245,0),
	(65,246,0),
	(65,247,0),
	(65,248,0),
	(65,249,0),
	(65,250,0),
	(65,297,0),
	(65,298,0),
	(65,299,0),
	(65,300,0),
	(65,301,0),
	(65,302,0),
	(65,303,0),
	(65,304,0),
	(65,305,0),
	(65,306,0),
	(65,307,0),
	(65,308,0),
	(65,309,0),
	(65,310,0),
	(65,311,0),
	(65,312,0),
	(65,313,0),
	(65,314,0),
	(65,315,0),
	(65,316,0),
	(65,317,0),
	(65,318,0),
	(65,319,0),
	(65,320,0),
	(65,321,0),
	(65,322,0),
	(65,323,0),
	(65,324,0),
	(65,325,0),
	(65,326,0),
	(65,327,0),
	(65,328,0),
	(65,329,0),
	(65,330,0),
	(65,331,0),
	(65,332,0),
	(65,333,0),
	(65,334,0),
	(65,335,0),
	(65,336,0),
	(65,337,0),
	(65,338,0),
	(65,339,0),
	(65,340,0),
	(65,341,0),
	(65,342,0),
	(65,343,0),
	(65,344,0),
	(65,345,0),
	(65,346,0),
	(65,347,0),
	(65,348,0),
	(65,349,0),
	(65,350,0),
	(65,351,0),
	(65,352,0),
	(65,353,0),
	(65,354,0),
	(65,355,0),
	(65,356,0),
	(65,357,0),
	(65,358,0),
	(65,359,0),
	(65,360,0),
	(65,361,0),
	(65,362,0),
	(65,363,0),
	(65,364,0),
	(65,365,0),
	(65,366,0),
	(65,367,0),
	(65,368,0),
	(65,369,0),
	(65,370,0),
	(65,371,0),
	(65,372,0),
	(65,373,0),
	(65,374,0),
	(65,375,0),
	(65,376,0),
	(65,377,0),
	(65,379,0),
	(65,380,0),
	(65,381,0),
	(65,382,0),
	(65,383,0),
	(65,384,0),
	(65,385,0),
	(65,386,0),
	(65,387,0),
	(65,388,0),
	(65,389,0),
	(65,390,0),
	(65,391,0),
	(65,392,0),
	(65,393,0),
	(65,394,0),
	(65,395,0),
	(65,396,0),
	(65,397,0),
	(65,398,0),
	(65,399,0),
	(65,400,0),
	(65,401,0),
	(65,402,0),
	(65,403,0),
	(65,404,0),
	(65,405,0),
	(65,406,0),
	(65,407,0),
	(65,408,0),
	(65,409,0),
	(65,410,0),
	(65,411,0),
	(65,412,0),
	(65,413,0),
	(65,414,0),
	(65,415,0),
	(65,13,1),
	(65,416,1),
	(65,13,2),
	(65,378,2),
	(65,416,2),
	(15,10,0),
	(15,11,0),
	(15,12,0),
	(15,7,1),
	(15,8,1),
	(15,6,2),
	(15,7,2),
	(15,8,2),
	(15,9,2);

/*!40000 ALTER TABLE `phpbb_search_wordmatch` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_sessions`;

CREATE TABLE `phpbb_sessions` (
  `session_id` char(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `session_user_id` mediumint NOT NULL DEFAULT '0',
  `session_start` int NOT NULL DEFAULT '0',
  `session_time` int NOT NULL DEFAULT '0',
  `session_ip` char(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `session_page` int NOT NULL DEFAULT '0',
  `session_logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `session_admin` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  KEY `session_user_id` (`session_user_id`),
  KEY `session_id_ip_user_id` (`session_id`,`session_ip`,`session_user_id`),
  KEY `session_time` (`session_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_sessions` WRITE;
/*!40000 ALTER TABLE `phpbb_sessions` DISABLE KEYS */;

INSERT INTO `phpbb_sessions` (`session_id`, `session_user_id`, `session_start`, `session_time`, `session_ip`, `session_page`, `session_logged_in`, `session_admin`)
VALUES
	('60e1e1213da11566ff7d4caee0e277ea',2,1604251746,1604252323,'ac120001',0,1,0);

/*!40000 ALTER TABLE `phpbb_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_sessions_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_sessions_keys`;

CREATE TABLE `phpbb_sessions_keys` (
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `user_id` mediumint NOT NULL DEFAULT '0',
  `last_ip` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `last_login` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`key_id`,`user_id`),
  KEY `last_login` (`last_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_sessions_keys` WRITE;
/*!40000 ALTER TABLE `phpbb_sessions_keys` DISABLE KEYS */;

INSERT INTO `phpbb_sessions_keys` (`key_id`, `user_id`, `last_ip`, `last_login`)
VALUES
	('0cc809a8591b8f5fb6409d6f9fac0a26',2,'ac120001',1604018923),
	('7e6f5dcada843b4826079fe0fbe10bae',2,'ac120001',1604047882);

/*!40000 ALTER TABLE `phpbb_sessions_keys` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_shoutbox
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_shoutbox`;

CREATE TABLE `phpbb_shoutbox` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sb_user_id` int NOT NULL DEFAULT '0',
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sb_user_id` (`sb_user_id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_shoutbox` WRITE;
/*!40000 ALTER TABLE `phpbb_shoutbox` DISABLE KEYS */;

INSERT INTO `phpbb_shoutbox` (`id`, `sb_user_id`, `msg`, `timestamp`)
VALUES
	(21,2,'😝😳😁😣😢',1601991674),
	(26,2,'Hello world! 😀 ',1602261595),
	(27,2,'Hello world! 😀 ',1602262051),
	(33,2,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut molestie nisi sit amet eros bibendum dictum. Morbi luctus ex ornare eleifend auctor. Maecenas nec posuere dui, ut ornare magna. Nulla facilisi. Ut metus nunc, facilisis non aliquam sed, sagittis at enim. Nam aliquet sagittis est at bibendum. Nullam ornare interdum massa eget aliquam. Suspendisse potenti. Nunc id risus est. Nunc in massa at dui pulvinar placerat in sed erat. Nulla euismod id nulla eu consequat. Sed a nisl vitae nisi luctus placerat in sed ipsum. In hac habitasse platea dictumst. Pellentesque ultricies et nisi ut viverra.',1602262499),
	(34,2,'<b>test</b>  😒 ',1602262517),
	(35,2,'\' is an apostrophe',1602262537),
	(41,2,'<b>HTML</b> [b]BBCODE[/b] *markdown* :)  😀 ',1602268381),
	(46,2,'```code```',1602507742),
	(52,2,'<b>test</b> [b]test[/b]',1602511747),
	(57,2,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut molestie nisi sit amet eros bibendum dictum. Morbi luctus ex ornare eleifend auctor. Maecenas nec posuere dui, ut ornare magna. Nulla facilisi. Ut metus nunc, facilisis non aliquam sed, sagittis at enim. Nam aliquet sagittis est at bibendum. Nullam ornare interdum massa eget aliquam. Suspendisse potenti. Nunc id risus est. Nunc in massa at dui pulvinar placerat in sed erat. Nulla euismod id nulla eu consequat. Sed a nisl vitae nisi luctus placerat in sed ipsum. In hac habitasse platea dictumst. Pellentesque ultricies et nisi ut viverra.',1602535288),
	(58,2,'[url=\"https://www.codebuilders.pl\"]Codebuilders.pl[/url]',1602667559);

/*!40000 ALTER TABLE `phpbb_shoutbox` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_shoutbox_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_shoutbox_config`;

CREATE TABLE `phpbb_shoutbox_config` (
  `config_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `config_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_shoutbox_config` WRITE;
/*!40000 ALTER TABLE `phpbb_shoutbox_config` DISABLE KEYS */;

INSERT INTO `phpbb_shoutbox_config` (`config_name`, `config_value`)
VALUES
	('allow_bbcode','1'),
	('allow_delete','0'),
	('allow_delete_all','0'),
	('allow_delete_m','0'),
	('allow_edit','0'),
	('allow_edit_all','0'),
	('allow_edit_m','0'),
	('allow_guest','0'),
	('allow_guest_view','1'),
	('allow_smilies','1'),
	('allow_users','1'),
	('allow_users_view','1'),
	('banned_user_id',''),
	('banned_user_id_view',''),
	('count_msg','30'),
	('date_format','d.m.y, H:i:s'),
	('date_on','1'),
	('delete_days','30'),
	('links_names','1'),
	('make_links','1'),
	('sb_group_sel','all'),
	('shout_height','130'),
	('shout_refresh','5'),
	('shout_width','630'),
	('shoutbox_on','1'),
	('shoutbox_smilies','0'),
	('text_lenght','500'),
	('usercall','0'),
	('word_lenght','80');

/*!40000 ALTER TABLE `phpbb_shoutbox_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_smilies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_smilies`;

CREATE TABLE `phpbb_smilies` (
  `smilies_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `smile_url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `emoticon` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `smile_order` mediumint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`smilies_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_smilies` WRITE;
/*!40000 ALTER TABLE `phpbb_smilies` DISABLE KEYS */;

INSERT INTO `phpbb_smilies` (`smilies_id`, `code`, `smile_url`, `emoticon`, `smile_order`)
VALUES
	(1,':-)','icon_smile.gif','',1),
	(2,';-)','icon_wink.gif','',2),
	(3,':-&gt;','icon_smile2.gif','',3),
	(4,':-D','icon_biggrin.gif','',4),
	(5,':-P','icon_razz.gif','',5),
	(6,':-o','icon_surprised.gif','',6),
	(7,':mrgreen:','icon_mrgreen.gif','',7),
	(8,':lol:','icon_lol.gif','',8),
	(9,':-(','icon_sad.gif','',9),
	(10,':-|','icon_neutral.gif','',10),
	(11,':-/','icon_curve.gif','',11),
	(12,':-?','icon_confused.gif','',12),
	(13,':-x','icon_mad.gif','',13),
	(14,':shock:','icon_eek.gif','',14),
	(15,':cry:','icon_cry.gif','',15),
	(16,':oops:','icon_redface.gif','',16),
	(17,'8-)','icon_cool.gif','',17),
	(18,':evil:','icon_evil.gif','',18),
	(19,':roll:','icon_rolleyes.gif','',19),
	(20,':!:','icon_exclaim.gif','',20),
	(21,':?:','icon_question.gif','',21),
	(22,':idea:','icon_idea.gif','',22),
	(23,':arrow:','icon_arrow.gif','',23);

/*!40000 ALTER TABLE `phpbb_smilies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_stats_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_stats_config`;

CREATE TABLE `phpbb_stats_config` (
  `config_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `config_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_stats_config` WRITE;
/*!40000 ALTER TABLE `phpbb_stats_config` DISABLE KEYS */;

INSERT INTO `phpbb_stats_config` (`config_name`, `config_value`)
VALUES
	('install_date','time()'),
	('modules_dir','stat_modules'),
	('page_views','22'),
	('return_limit','10'),
	('version','2.1.3');

/*!40000 ALTER TABLE `phpbb_stats_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_stats_modules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_stats_modules`;

CREATE TABLE `phpbb_stats_modules` (
  `module_id` tinyint NOT NULL DEFAULT '0',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `installed` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` mediumint unsigned NOT NULL DEFAULT '0',
  `update_time` mediumint unsigned NOT NULL DEFAULT '0',
  `auth_value` tinyint NOT NULL DEFAULT '0',
  `module_info_cache` blob,
  `module_db_cache` blob,
  `module_result_cache` blob,
  `module_info_time` int unsigned NOT NULL DEFAULT '0',
  `module_cache_time` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_stats_modules` WRITE;
/*!40000 ALTER TABLE `phpbb_stats_modules` DISABLE KEYS */;

INSERT INTO `phpbb_stats_modules` (`module_id`, `name`, `active`, `installed`, `display_order`, `update_time`, `auth_value`, `module_info_cache`, `module_db_cache`, `module_result_cache`, `module_info_time`, `module_cache_time`)
VALUES
	(1,'new_posts_by_month',1,1,10,24,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223234223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A32383A224E756D626572206F66206E657720706F737473206279206D6F6E7468223B733A363A22617574686F72223B733A31323A22546F6D6D79204A656E73656E223B733A353A22656D61696C223B733A32363A22746F6D6D795F6A656E73656E363740686F746D61696C2E636F6D223B733A333A2275726C223B733A32373A22687474703A2F2F7777772E73632D7265736F75726365732E6E6574223B733A373A2276657273696F6E223B733A353A22312E302E30223B733A31303A2265787472615F696E666F223B733A33363A224E6F20657874726120696E666F726D6174696F6E206F6E2074686973206D6F64756C652E223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A313A7B733A393A226E6577706F7374732E223B613A323A7B693A303B613A31343A7B733A353A22434C415353223B733A343A22726F7731223B733A343A2259454152223B733A343A2232303033223B733A333A224D3031223B693A303B733A333A224D3032223B693A303B733A333A224D3033223B693A303B733A333A224D3034223B693A303B733A333A224D3035223B693A303B733A333A224D3036223B693A303B733A333A224D3037223B693A303B733A333A224D3038223B693A303B733A333A224D3039223B693A303B733A333A224D3130223B693A303B733A333A224D3131223B693A303B733A333A224D3132223B693A303B7D693A313B613A31343A7B733A353A22434C415353223B733A343A22726F7731223B733A343A2259454152223B733A343A2232303230223B733A333A224D3031223B693A303B733A333A224D3032223B693A303B733A333A224D3033223B693A303B733A333A224D3034223B693A303B733A333A224D3035223B693A303B733A333A224D3036223B693A303B733A333A224D3037223B693A303B733A333A224D3038223B693A303B733A333A224D3039223B693A303B733A333A224D3130223B693A303B733A333A224D3131223B693A303B733A333A224D3132223B693A303B7D7D7D7D',1601896325,1602954291),
	(2,'new_topics_by_month',1,1,20,24,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223234223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A32393A224E756D626572206F66206E657720746F70696373206279206D6F6E7468223B733A363A22617574686F72223B733A31323A22546F6D6D79204A656E73656E223B733A353A22656D61696C223B733A32363A22746F6D6D795F6A656E73656E363740686F746D61696C2E636F6D223B733A333A2275726C223B733A32373A22687474703A2F2F7777772E73632D7265736F75726365732E6E6574223B733A373A2276657273696F6E223B733A353A22312E302E30223B733A31303A2265787472615F696E666F223B733A33363A224E6F20657874726120696E666F726D6174696F6E206F6E2074686973206D6F64756C652E223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A313A7B733A31303A226E6577746F706963732E223B613A323A7B693A303B613A31343A7B733A353A22434C415353223B733A343A22726F7731223B733A343A2259454152223B733A343A2232303033223B733A333A224D3031223B693A303B733A333A224D3032223B693A303B733A333A224D3033223B693A303B733A333A224D3034223B693A303B733A333A224D3035223B693A303B733A333A224D3036223B693A303B733A333A224D3037223B693A303B733A333A224D3038223B693A303B733A333A224D3039223B693A303B733A333A224D3130223B693A303B733A333A224D3131223B693A303B733A333A224D3132223B693A303B7D693A313B613A31343A7B733A353A22434C415353223B733A343A22726F7731223B733A343A2259454152223B733A343A2232303230223B733A333A224D3031223B693A303B733A333A224D3032223B693A303B733A333A224D3033223B693A303B733A333A224D3034223B693A303B733A333A224D3035223B693A303B733A333A224D3036223B693A303B733A333A224D3037223B693A303B733A333A224D3038223B693A303B733A333A224D3039223B693A303B733A333A224D3130223B693A303B733A333A224D3131223B693A303B733A333A224D3132223B693A303B7D7D7D7D',1601896325,1602954291),
	(3,'new_users_by_month',1,1,30,24,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223234223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31383A224E6577207573657273206279206D6F6E7468223B733A363A22617574686F72223B733A31323A22546F6D6D79204A656E73656E223B733A353A22656D61696C223B733A32363A22746F6D6D795F6A656E73656E363740686F746D61696C2E636F6D223B733A333A2275726C223B733A32373A22687474703A2F2F7777772E73632D7265736F75726365732E6E6574223B733A373A2276657273696F6E223B733A353A22312E302E30223B733A31303A2265787472615F696E666F223B733A33363A224E6F20657874726120696E666F726D6174696F6E206F6E2074686973206D6F64756C652E223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A313A7B733A373A227369676E75702E223B613A313A7B693A303B613A31343A7B733A353A22434C415353223B733A343A22726F7731223B733A343A2259454152223B733A343A2232303230223B733A333A224D3031223B693A303B733A333A224D3032223B693A303B733A333A224D3033223B693A303B733A333A224D3034223B693A303B733A333A224D3035223B693A303B733A333A224D3036223B693A303B733A333A224D3037223B693A303B733A333A224D3038223B693A303B733A333A224D3039223B693A303B733A333A224D3130223B693A303B733A333A224D3131223B693A303B733A333A224D3132223B693A303B7D7D7D7D',1601896325,1602954291),
	(4,'most_active_topics',1,1,40,0,0,X'613A393A7B733A31393A2264656661756C745F7570646174655F74696D65223B693A303B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31383A224D6F73742041637469766520546F70696373223B733A363A22617574686F72223B733A31383A224E6976697365632C2041637964204275726E223B733A353A22656D61696C223B733A31363A22616379642E6275726E40676D782E6465223B733A333A2275726C223B733A32393A22687474703A2F2F7777772E6F70656E746F6F6C732E64652F626F617264223B733A373A2276657273696F6E223B733A353A22322E312E33223B733A31373A2273746174735F6D6F645F76657273696F6E223B733A353A22322E312E33223B733A31303A2265787472615F696E666F223B733A33373A224E6F20657874726120696E666F726D6174696F6E206F6E2074686973206D6F64756C652E0A223B7D',X'4F3A393A226361636865645F6462223A333A7B733A313A226E223B613A313A7B693A303B613A313A7B693A303B693A333B7D7D733A323A226673223B613A313A7B693A303B613A313A7B693A303B613A333A7B693A303B613A343A7B733A383A22746F7069635F6964223B733A313A2239223B733A31313A22746F7069635F7469746C65223B733A31383A2250727A796BC58261646F77792074656D6174223B733A31333A22746F7069635F7265706C696573223B733A313A2237223B733A31313A22746F7069635F7669657773223B733A343A2231303039223B7D693A313B613A343A7B733A383A22746F7069635F6964223B733A313A2238223B733A31313A22746F7069635F7469746C65223B733A31383A22C485C487C499C59BC3B3C582C584C5BAC5BC223B733A31333A22746F7069635F7265706C696573223B733A313A2233223B733A31313A22746F7069635F7669657773223B733A323A223133223B7D693A323B613A343A7B733A383A22746F7069635F6964223B733A313A2234223B733A31313A22746F7069635F7469746C65223B733A33393A22576974616A206E6120666F72756D207068704242206D6F6469666965642062792050727A656D6F223B733A31333A22746F7069635F7265706C696573223B733A313A2231223B733A31313A22746F7069635F7669657773223B733A323A223133223B7D7D7D7D733A313A2266223B613A303A7B7D7D','',1601896325,1602954291),
	(5,'most_viewed_topics',1,1,50,0,0,X'613A393A7B733A31393A2264656661756C745F7570646174655F74696D65223B693A303B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31383A224D6F73742056696577656420546F70696373223B733A363A22617574686F72223B733A393A2241637964204275726E223B733A353A22656D61696C223B733A31363A22616379642E6275726E40676D782E6465223B733A333A2275726C223B733A32393A22687474703A2F2F7777772E6F70656E746F6F6C732E64652F626F617264223B733A373A2276657273696F6E223B733A353A22322E312E33223B733A31373A2273746174735F6D6F645F76657273696F6E223B733A353A22322E312E33223B733A31303A2265787472615F696E666F223B733A33373A224E6F20657874726120696E666F726D6174696F6E206F6E2074686973206D6F64756C652E0A223B7D',X'4F3A393A226361636865645F6462223A333A7B733A313A226E223B613A313A7B693A303B613A313A7B693A303B693A363B7D7D733A323A226673223B613A313A7B693A303B613A313A7B693A303B613A363A7B693A303B613A343A7B733A383A22746F7069635F6964223B733A313A2239223B733A31313A22746F7069635F7469746C65223B733A31383A2250727A796BC58261646F77792074656D6174223B733A31313A22746F7069635F7669657773223B733A343A2231303039223B733A31333A22746F7069635F7265706C696573223B733A313A2237223B7D693A313B613A343A7B733A383A22746F7069635F6964223B733A313A2234223B733A31313A22746F7069635F7469746C65223B733A33393A22576974616A206E6120666F72756D207068704242206D6F6469666965642062792050727A656D6F223B733A31313A22746F7069635F7669657773223B733A323A223133223B733A31333A22746F7069635F7265706C696573223B733A313A2231223B7D693A323B613A343A7B733A383A22746F7069635F6964223B733A313A2238223B733A31313A22746F7069635F7469746C65223B733A31383A22C485C487C499C59BC3B3C582C584C5BAC5BC223B733A31313A22746F7069635F7669657773223B733A323A223133223B733A31333A22746F7069635F7265706C696573223B733A313A2233223B7D693A333B613A343A7B733A383A22746F7069635F6964223B733A323A223130223B733A31313A22746F7069635F7469746C65223B733A31313A2248656C6C6F20776F726C64223B733A31313A22746F7069635F7669657773223B733A323A223130223B733A31333A22746F7069635F7265706C696573223B733A313A2230223B7D693A343B613A343A7B733A383A22746F7069635F6964223B733A313A2232223B733A31313A22746F7069635F7469746C65223B733A32343A22546573746F77792074656D6174207720537562466F72756D223B733A31313A22746F7069635F7669657773223B733A313A2237223B733A31333A22746F7069635F7265706C696573223B733A313A2230223B7D693A353B613A343A7B733A383A22746F7069635F6964223B733A313A2237223B733A31313A22746F7069635F7469746C65223B733A31393A227465737420647275676965676F206E65777361223B733A31313A22746F7069635F7669657773223B733A313A2233223B733A31333A22746F7069635F7265706C696573223B733A313A2230223B7D7D7D7D733A313A2266223B613A303A7B7D7D','',1601896325,1602954291),
	(6,'latest_topics',1,1,60,0,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B693A303B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31333A224C617465737420546F70696373223B733A363A22617574686F72223B733A31323A22546F6D6D79204A656E73656E223B733A353A22656D61696C223B733A32363A22746F6D6D795F6A656E73656E363740686F746D61696C2E636F6D223B733A333A2275726C223B733A32373A22687474703A2F2F7777772E73632D7265736F75726365732E6E6574223B733A373A2276657273696F6E223B733A353A22312E302E32223B733A31303A2265787472615F696E666F223B733A33363A224E6F20657874726120696E666F726D6174696F6E206F6E2074686973206D6F64756C652E223B7D','','',1601896325,0),
	(7,'priv_msgs',1,1,70,48,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223438223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31363A2250726976617465204D65737361676573223B733A363A22617574686F72223B733A34303A2273746576656D202F205B6D696E6F7220696D70726F76656D656E74735D2068656C6C757661677579223B733A353A22656D61696C223B733A34313A227374657665407369787468666F726D2E696E666F202F2068656C6C75766167757940676D782E6E6574223B733A333A2275726C223B733A32373A22687474703A2F2F7369787468666F726D2E696E666F2F666F72756D223B733A373A2276657273696F6E223B733A333A22312E32223B733A31303A2265787472615F696E666F223B733A3434353A2254686973206D6F64756C652073686F77732064657461696C73206F6620746865206E756D626572206F662070726976617465206D657373616765732E200A436F6465206973206261736564206F6E204E69766973656327732041646D696E6973747261746F722050616E656C20506C75672D696E20746F20646973706C61792061206C697374206F662070726976617465206D657373616765732E0A4368616E67657320696E2056657273696F6E20312E310A202D2049742075736573206164646974696F6E616C206C616E6775616E6765207661726961626C657320286E6F742066726F6D2074686520646174652066756E74696F6E20616E796D6F72652920666F7220746865206D6F6E7468277320736F2074686973206D6F642063616E206E6F7720626520757365642077697468206F74686572206C616E6775616E676573207468616E20656E676C697368206D6F726520656173696C792E0A202D20536F6D65206D696E6F7220726564657369676E0A4368616E67657320696E2056657273696F6E20312E320A202D20436F7272656374206275677320666F7220446563656D62657220616E64204A616E756172792066696775726573200A223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A313A7B733A333A22706D2E223B613A313A7B693A303B613A31323A7B733A31303A22544F54414C5F4D455353223B4E3B733A393A224C4153545F4D455353223B693A303B733A393A22544849535F4D455353223B693A303B733A31303A22544F4441595F4D455353223B693A303B733A31343A224C4153545F5745454B5F4D455353223B693A303B733A31353A224C4153545F4D4F4E54485F4D455353223B693A303B733A363A22544F54414C30223B733A313A2230223B733A363A22544F54414C31223B733A313A2230223B733A363A22544F54414C32223B733A313A2230223B733A363A22544F54414C33223B733A313A2230223B733A363A22544F54414C34223B733A313A2230223B733A363A22544F54414C35223B733A313A2230223B7D7D7D7D',1601896325,1602858409),
	(8,'top_posters',1,1,80,24,0,X'613A393A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223234223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31313A22546F7020506F7374657273223B733A363A22617574686F72223B733A393A2241637964204275726E223B733A353A22656D61696C223B733A31363A22616379642E6275726E40676D782E6465223B733A333A2275726C223B733A32393A22687474703A2F2F7777772E6F70656E746F6F6C732E64652F626F617264223B733A373A2276657273696F6E223B733A353A22322E312E33223B733A31373A2273746174735F6D6F645F76657273696F6E223B733A353A22322E312E33223B733A31303A2265787472615F696E666F223B733A33373A224E6F20657874726120696E666F726D6174696F6E206F6E2074686973206D6F64756C652E0A223B7D',X'4F3A393A226361636865645F6462223A333A7B733A313A226E223B613A313A7B693A313B613A313A7B693A303B693A313B7D7D733A323A226673223B613A313A7B693A313B613A313A7B693A303B613A313A7B693A303B613A333A7B733A373A22757365725F6964223B733A313A2232223B733A383A22757365726E616D65223B733A353A2261646D696E223B733A31303A22757365725F706F737473223B733A323A223136223B7D7D7D7D733A313A2266223B613A313A7B693A303B613A313A7B693A303B613A313A7B733A31313A22746F74616C5F706F737473223B733A323A223136223B7D7D7D7D','',1601896325,1602954291),
	(9,'last_active_users',1,1,90,0,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B693A303B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31373A224C61737420616374697665207573657273223B733A363A22617574686F72223B733A31323A22546F6D6D79204A656E73656E223B733A353A22656D61696C223B733A32363A22746F6D6D795F6A656E73656E363740686F746D61696C2E636F6D223B733A333A2275726C223B733A32373A22687474703A2F2F7777772E73632D7265736F75726365732E6E6574223B733A373A2276657273696F6E223B733A353A22312E302E30223B733A31303A2265787472615F696E666F223B733A33363A224E6F20657874726120696E666F726D6174696F6E206F6E2074686973206D6F64756C652E223B7D','','',1601896325,0),
	(10,'users_from_where',1,1,100,48,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223438223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31393A2257686572652069732075736572732066726F6D223B733A363A22617574686F72223B733A31323A22546F6D6D79204A656E73656E223B733A353A22656D61696C223B733A32363A22746F6D6D795F6A656E73656E363740686F746D61696C2E636F6D223B733A333A2275726C223B733A32373A22687474703A2F2F7777772E73632D7265736F75726365732E6E6574223B733A373A2276657273696F6E223B733A353A22312E302E30223B733A31303A2265787472615F696E666F223B733A35313A2254686973206D6F64756C65207573657320746865206669656C6420757365725F66726F6D20666F72207468652071756572792E223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A303A7B7D7D',1601896325,1602858409),
	(12,'users_gender',1,1,120,48,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223438223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31323A2255736572732067656E646572223B733A363A22617574686F72223B733A31313A225275737479447261676F6E223B733A353A22656D61696C223B733A31393A22646576405275737479447261676F6E2E636F6D223B733A333A2275726C223B733A32363A22687474703A2F2F7777772E5275737479447261676F6E2E636F6D223B733A373A2276657273696F6E223B733A333A22312E33223B733A31303A2265787472615F696E666F223B733A3131333A2253686F7773206E756D626572206F66206D616C6520616E642066656D616C652075736572730A52657175697265732047656E646572204D4F44206279204E69656C73204368722C2044656E6D61726B0A4D61646520666F7220537461746973746963732076657273696F6E20322E312E32223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A313A7B733A373A2267656E6465722E223B613A313A7B693A303B613A363A7B733A343A2252414E4B223B693A313B733A353A22434C415353223B733A343A22726F7731223B733A363A2247454E444552223B733A31343A224E696520776961646F6D6F203A29223B733A353A225553455253223B733A313A2231223B733A31303A2250455243454E54414745223B643A3130303B733A333A22424152223B643A39303B7D7D7D7D',1601896325,1602858409),
	(13,'top_smilies',1,1,130,64,0,X'613A393A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223634223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A31313A22546F7020536D696C696573223B733A363A22617574686F72223B733A393A2241637964204275726E223B733A353A22656D61696C223B733A31363A22616379642E6275726E40676D782E6465223B733A333A2275726C223B733A32393A22687474703A2F2F7777772E6F70656E746F6F6C732E64652F626F617264223B733A373A2276657273696F6E223B733A353A22322E312E33223B733A31373A2273746174735F6D6F645F76657273696F6E223B733A353A22322E312E33223B733A31303A2265787472615F696E666F223B733A3132333A224974206973207265636F6D6D656E646564207468617420796F75207075742061207570646174652074696D65206C696D697420746F2074686973206D6F64756C65206F6E206C617267657220626F617264732E0A412064656661756C74205570646174652054696D65206F66203130303020776173207365742E0A223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A303A7B7D7D',1601896325,1602858409),
	(14,'top_words',1,1,140,64,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223634223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A393A22546F7020776F726473223B733A363A22617574686F72223B733A31313A225275737479447261676F6E223B733A353A22656D61696C223B733A31383A226D74405275737479447261676F6E2E636F6D223B733A333A2275726C223B733A32363A22687474703A2F2F7777772E5275737479447261676F6E2E636F6D223B733A373A2276657273696F6E223B733A333A22312E32223B733A31303A2265787472615F696E666F223B733A33353A2253686F7773206D6F7374207573656420776F726473206F6E20796F757220666F72756D223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A313A7B733A363A22776F7264732E223B613A31303A7B693A303B613A363A7B733A343A2252414E4B223B693A313B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A383A22737562666F72756D223B733A31303A2250455243454E54414745223B643A322E32353B733A333A22424152223B643A39303B733A353A22434F554E54223B733A313A2238223B7D693A313B613A363A7B733A343A2252414E4B223B693A323B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A31383A22C485C487C499C59BC3B3C582C584C5BAC5BC223B733A31303A2250455243454E54414745223B643A322E32353B733A333A22424152223B643A39303B733A353A22434F554E54223B733A313A2238223B7D693A323B613A363A7B733A343A2252414E4B223B693A333B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A31303A22646F6BC58261646E6965223B733A31303A2250455243454E54414745223B643A312E31323B733A333A22424152223B643A34353B733A353A22434F554E54223B733A313A2234223B7D693A333B613A363A7B733A343A2252414E4B223B693A343B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A343A2274657374223B733A31303A2250455243454E54414745223B643A312E31323B733A333A22424152223B643A34353B733A353A22434F554E54223B733A313A2234223B7D693A343B613A363A7B733A343A2252414E4B223B693A353B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A353A2268656C6C6F223B733A31303A2250455243454E54414745223B643A312E31323B733A333A22424152223B643A34353B733A353A22434F554E54223B733A313A2234223B7D693A353B613A363A7B733A343A2252414E4B223B693A363B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A353A227068706262223B733A31303A2250455243454E54414745223B643A312E31323B733A333A22424152223B643A34353B733A353A22434F554E54223B733A313A2234223B7D693A363B613A363A7B733A343A2252414E4B223B693A373B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A353A22666F72756D223B733A31303A2250455243454E54414745223B643A302E38343B733A333A22424152223B643A33343B733A353A22434F554E54223B733A313A2233223B7D693A373B613A363A7B733A343A2252414E4B223B693A383B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A31323A2270727A796BC58261646F7779223B733A31303A2250455243454E54414745223B643A302E38343B733A333A22424152223B643A33343B733A353A22434F554E54223B733A313A2233223B7D693A383B613A363A7B733A343A2252414E4B223B693A393B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A363A22666F72756D2E223B733A31303A2250455243454E54414745223B643A302E38343B733A333A22424152223B643A33343B733A353A22434F554E54223B733A313A2233223B7D693A393B613A363A7B733A343A2252414E4B223B693A31303B733A353A22434C415353223B733A343A22726F7731223B733A343A22574F5244223B733A353A2274656D6174223B733A31303A2250455243454E54414745223B643A302E38343B733A333A22424152223B643A33343B733A353A22434F554E54223B733A313A2233223B7D7D7D7D',1601896325,1602858409),
	(15,'user_agent',1,1,150,64,0,X'613A383A7B733A31393A2264656661756C745F7570646174655F74696D65223B733A323A223634223B733A31363A22636F6E646974696F6E5F726573756C74223B623A313B733A343A226E616D65223B733A32343A22557365642073797374656D20616E642062726F7773657273223B733A363A22617574686F72223B733A363A2250727A656D6F223B733A353A22656D61696C223B733A31373A2270727A656D6F4070727A656D6F2E6F7267223B733A333A2275726C223B733A32393A22687474703A2F2F7777772E70727A656D6F2E6F72672F7068704242322F223B733A373A2276657273696F6E223B733A353A22312E302E30223B733A31303A2265787472615F696E666F223B733A303A22223B7D','',X'4F3A31333A226361636865645F726573756C74223A313A7B733A383A227661725F64617461223B613A323A7B733A373A22735F6C6F6F702E223B613A313A7B693A303B613A343A7B733A353A22434C415353223B733A343A22726F7731223B733A363A2253595354454D223B733A38363A2274656D706C617465732F73756253696C7665722F696D616765732F757365725F6167656E742F69636F6E5F6170706C652E706E6722207469746C653D224170706C652E706E672220616C743D224170706C652E706E67223B733A353A2256414C5545223B693A313B733A333A22424152223B643A39303B7D7D733A373A22625F6C6F6F702E223B613A313A7B693A303B613A343A7B733A353A22434C415353223B733A343A22726F7732223B733A373A2242524F57534552223B733A39323A2274656D706C617465732F73756253696C7665722F696D616765732F757365725F6167656E742F69636F6E5F66697265666F782E706E6722207469746C653D2246697265666F782E706E672220616C743D2246697265666F782E706E67223B733A353A2256414C5545223B693A313B733A333A22424152223B643A39303B7D7D7D7D',1601896325,1602858409);

/*!40000 ALTER TABLE `phpbb_stats_modules` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_themes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_themes`;

CREATE TABLE `phpbb_themes` (
  `themes_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `style_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `head_stylesheet` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_background` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_bgcolor` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_text` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_link` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_vlink` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_alink` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_hlink` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_color1` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_color2` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_color3` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_color_helped` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_class1` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_class2` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_class3` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_color1` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_color2` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_color3` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_class1` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_class2` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_class3` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_color1` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_color2` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_color3` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_class1` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_class2` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_class3` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontface1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontface2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontface3` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontsize1` tinyint DEFAULT NULL,
  `fontsize2` tinyint DEFAULT NULL,
  `fontsize3` tinyint DEFAULT NULL,
  `fontcolor1` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontcolor2` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontcolor3` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontcolor_admin` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontcolor_jradmin` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontcolor_mod` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `factive_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faonmouse_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faonmouse2_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span_class1` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span_class2` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span_class3` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_size_poll` smallint unsigned DEFAULT NULL,
  `img_size_privmsg` smallint unsigned DEFAULT NULL,
  PRIMARY KEY (`themes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_themes` WRITE;
/*!40000 ALTER TABLE `phpbb_themes` DISABLE KEYS */;

INSERT INTO `phpbb_themes` (`themes_id`, `template_name`, `style_name`, `head_stylesheet`, `body_background`, `body_bgcolor`, `body_text`, `body_link`, `body_vlink`, `body_alink`, `body_hlink`, `tr_color1`, `tr_color2`, `tr_color3`, `tr_color_helped`, `tr_class1`, `tr_class2`, `tr_class3`, `th_color1`, `th_color2`, `th_color3`, `th_class1`, `th_class2`, `th_class3`, `td_color1`, `td_color2`, `td_color3`, `td_class1`, `td_class2`, `td_class3`, `fontface1`, `fontface2`, `fontface3`, `fontsize1`, `fontsize2`, `fontsize3`, `fontcolor1`, `fontcolor2`, `fontcolor3`, `fontcolor_admin`, `fontcolor_jradmin`, `fontcolor_mod`, `factive_color`, `faonmouse_color`, `faonmouse2_color`, `span_class1`, `span_class2`, `span_class3`, `img_size_poll`, `img_size_privmsg`)
VALUES
	(1,'subSilver','subSilver','subSilver.css','','E5E5E5','000000','006699','5493B4','','DD6900','EFEFEF','DEE3E7','D1D7DC','F0EDDE','','','','98AAB1','006699','FFFFFF','cellpic1.gif','cellpic3.gif','cellpic2.jpg','FAFAFA','FFFFFF','','row1','row2','','Verdana, Arial, Helvetica, sans-serif','Trebuchet MS','Courier, \'Courier New\', sans-serif',10,11,12,'444444','006600','FFA34F','FFA34F','993333','006600','F9F9F0','DEE3E7','EFEFEF','','','',0,0);

/*!40000 ALTER TABLE `phpbb_themes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_themes_name
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_themes_name`;

CREATE TABLE `phpbb_themes_name` (
  `themes_id` smallint unsigned NOT NULL DEFAULT '0',
  `tr_color1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_color2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_color3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_class1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_class2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tr_class3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_color1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_color2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_color3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_class1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_class2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `th_class3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_color1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_color2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_color3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_class1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_class2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `td_class3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontface1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontface2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontface3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontsize1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontsize2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontsize3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontcolor1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontcolor2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fontcolor3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span_class1_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span_class2_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span_class3_name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`themes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_themes_name` WRITE;
/*!40000 ALTER TABLE `phpbb_themes_name` DISABLE KEYS */;

INSERT INTO `phpbb_themes_name` (`themes_id`, `tr_color1_name`, `tr_color2_name`, `tr_color3_name`, `tr_class1_name`, `tr_class2_name`, `tr_class3_name`, `th_color1_name`, `th_color2_name`, `th_color3_name`, `th_class1_name`, `th_class2_name`, `th_class3_name`, `td_color1_name`, `td_color2_name`, `td_color3_name`, `td_class1_name`, `td_class2_name`, `td_class3_name`, `fontface1_name`, `fontface2_name`, `fontface3_name`, `fontsize1_name`, `fontsize2_name`, `fontsize3_name`, `fontcolor1_name`, `fontcolor2_name`, `fontcolor3_name`, `span_class1_name`, `span_class2_name`, `span_class3_name`)
VALUES
	(1,'The lightest row colour','The medium row color','The darkest row colour','','','','Border round the whole page','Outer table border','Inner table border','Silver gradient picture','Blue gradient picture','Fade-out gradient on index','Background for quote boxes','All white areas','','Background for topic posts','2nd background for topic posts','','Main fonts','Additional topic title font','Form fonts','Smallest font size','Medium font size','Normal font size (post body etc)','Quote & copyright text','Code text colour','Main table header text colour','','','');

/*!40000 ALTER TABLE `phpbb_themes_name` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_topic_view
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_topic_view`;

CREATE TABLE `phpbb_topic_view` (
  `topic_id` mediumint NOT NULL DEFAULT '0',
  `user_id` mediumint NOT NULL DEFAULT '0',
  `view_time` int NOT NULL DEFAULT '0',
  `view_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_topics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_topics`;

CREATE TABLE `phpbb_topics` (
  `topic_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint unsigned NOT NULL DEFAULT '0',
  `topic_title` char(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `topic_poster` mediumint NOT NULL DEFAULT '0',
  `topic_time` int NOT NULL DEFAULT '0',
  `topic_views` mediumint unsigned NOT NULL DEFAULT '0',
  `topic_replies` mediumint unsigned NOT NULL DEFAULT '0',
  `topic_status` tinyint(1) NOT NULL DEFAULT '0',
  `topic_vote` tinyint(1) NOT NULL DEFAULT '0',
  `topic_type` tinyint(1) NOT NULL DEFAULT '0',
  `topic_first_post_id` mediumint unsigned NOT NULL DEFAULT '0',
  `topic_last_post_id` mediumint unsigned NOT NULL DEFAULT '0',
  `topic_moved_id` mediumint unsigned NOT NULL DEFAULT '0',
  `topic_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `topic_icon` tinyint unsigned NOT NULL DEFAULT '0',
  `topic_expire` int NOT NULL DEFAULT '0',
  `topic_color` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `topic_title_e` char(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `topic_action` tinyint(1) DEFAULT '0',
  `topic_action_user` mediumint NOT NULL DEFAULT '0',
  `topic_action_date` int NOT NULL DEFAULT '0',
  `topic_tree_width` smallint NOT NULL DEFAULT '0',
  `topic_accept` tinyint(1) NOT NULL DEFAULT '1',
  `topic_votes_sum` int unsigned NOT NULL DEFAULT '0',
  `topic_gallery` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_moved_id` (`topic_moved_id`),
  KEY `topic_status` (`topic_status`),
  KEY `topic_type` (`topic_type`),
  KEY `topic_poster` (`topic_poster`),
  KEY `topic_last_post_id` (`topic_last_post_id`),
  KEY `topic_first_post_id` (`topic_first_post_id`),
  KEY `topic_vote` (`topic_vote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_topics` WRITE;
/*!40000 ALTER TABLE `phpbb_topics` DISABLE KEYS */;

INSERT INTO `phpbb_topics` (`topic_id`, `forum_id`, `topic_title`, `topic_poster`, `topic_time`, `topic_views`, `topic_replies`, `topic_status`, `topic_vote`, `topic_type`, `topic_first_post_id`, `topic_last_post_id`, `topic_moved_id`, `topic_attachment`, `topic_icon`, `topic_expire`, `topic_color`, `topic_title_e`, `topic_action`, `topic_action_user`, `topic_action_date`, `topic_tree_width`, `topic_accept`, `topic_votes_sum`, `topic_gallery`)
VALUES
	(2,2,'Testowy temat w SubForum',2,1064458873,13,0,0,0,0,3,3,0,0,0,0,'','',0,0,0,0,1,0,0),
	(4,1,'Witaj na forum phpBB modified by Przemo',2,1065136668,34,1,0,0,0,5,10,0,0,2,0,'green','',0,0,0,0,1,0,0),
	(5,7,'Sonda1',2,1065137203,1,0,0,1,0,7,7,0,0,0,0,'','',0,0,0,0,1,0,0),
	(6,6,'Test trzeciego newsa',2,1065137320,0,0,0,0,0,8,8,0,0,0,0,'','',0,0,0,0,1,0,0),
	(7,6,'test drugiego newsa',2,1065137383,3,0,0,0,0,9,9,0,0,0,0,'','',0,0,0,0,1,0,0),
	(8,1,'🎶 ąćęśółńźż',2,1601919228,16,3,0,0,0,11,14,0,0,0,0,'','ąćęśółńźż',0,0,0,0,1,1,0),
	(9,1,'Przykładowy temat',2,1601927258,1147,10,0,0,0,15,97,0,0,0,0,'','Opis tematu',0,0,0,0,1,9,1),
	(10,12,'Hello world',2,1602702134,10,0,0,0,0,65,65,0,0,0,0,'','Curabitur et consectetur augue. Nam nec eros volutpat, volutpat nulla nec, ullamcorper magna.',0,0,0,0,1,0,0);

/*!40000 ALTER TABLE `phpbb_topics` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_topics_ignore
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_topics_ignore`;

CREATE TABLE `phpbb_topics_ignore` (
  `topic_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_topics_watch
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_topics_watch`;

CREATE TABLE `phpbb_topics_watch` (
  `topic_id` mediumint unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint NOT NULL DEFAULT '0',
  `notify_status` tinyint(1) NOT NULL DEFAULT '0',
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  KEY `notify_status` (`notify_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_user_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_user_group`;

CREATE TABLE `phpbb_user_group` (
  `group_id` mediumint NOT NULL DEFAULT '0',
  `user_id` mediumint NOT NULL DEFAULT '0',
  `user_pending` tinyint(1) DEFAULT NULL,
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`),
  KEY `user_pending` (`user_pending`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_user_group` WRITE;
/*!40000 ALTER TABLE `phpbb_user_group` DISABLE KEYS */;

INSERT INTO `phpbb_user_group` (`group_id`, `user_id`, `user_pending`)
VALUES
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0),
	(1,-1,0),
	(2,2,0);

/*!40000 ALTER TABLE `phpbb_user_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_users`;

CREATE TABLE `phpbb_users` (
  `user_id` mediumint NOT NULL AUTO_INCREMENT,
  `user_active` tinyint(1) DEFAULT '1',
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_password` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_session_time` int NOT NULL DEFAULT '0',
  `user_session_page` smallint NOT NULL DEFAULT '0',
  `user_lastvisit` int NOT NULL DEFAULT '0',
  `user_regdate` int NOT NULL DEFAULT '0',
  `user_level` tinyint(1) DEFAULT '0',
  `user_posts` mediumint unsigned NOT NULL DEFAULT '0',
  `user_timezone` decimal(5,2) NOT NULL DEFAULT '0.00',
  `user_style` tinyint DEFAULT '1',
  `user_lang` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_new_privmsg` smallint unsigned NOT NULL DEFAULT '0',
  `user_unread_privmsg` smallint unsigned NOT NULL DEFAULT '0',
  `user_last_privmsg` int NOT NULL DEFAULT '0',
  `user_emailtime` int DEFAULT '0',
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
  `user_rank` int DEFAULT '0',
  `user_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_avatar_type` tinyint(1) NOT NULL DEFAULT '0',
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_icq` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_from` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_sig` text COLLATE utf8mb4_unicode_ci,
  `user_sig_bbcode_uid` char(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_sig_image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_aim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_yim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_msnm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_occ` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_interests` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_actkey` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_newpasswd` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_custom_rank` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_photo_type` tinyint(1) NOT NULL DEFAULT '0',
  `user_custom_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_badlogin` smallint NOT NULL DEFAULT '0',
  `user_blocktime` int NOT NULL DEFAULT '0',
  `user_block_by` char(8) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `disallow_forums` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `can_custom_ranks` tinyint(1) NOT NULL DEFAULT '1',
  `can_custom_color` tinyint(1) NOT NULL DEFAULT '1',
  `user_gender` tinyint(1) NOT NULL DEFAULT '0',
  `can_topic_color` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify_gg` tinyint(1) NOT NULL DEFAULT '0',
  `allowpm` tinyint(1) DEFAULT '1',
  `no_report_popup` tinyint(1) NOT NULL DEFAULT '0',
  `refresh_report_popup` tinyint(1) NOT NULL DEFAULT '0',
  `no_report_mail` tinyint(1) NOT NULL DEFAULT '0',
  `user_avatar_width` smallint DEFAULT NULL,
  `user_avatar_height` smallint DEFAULT NULL,
  `special_rank` mediumint unsigned DEFAULT NULL,
  `user_allow_helped` tinyint unsigned NOT NULL DEFAULT '1',
  `user_ip` char(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ip_login_check` tinyint(1) NOT NULL DEFAULT '1',
  `user_spend_time` int NOT NULL DEFAULT '0',
  `user_visit` int NOT NULL DEFAULT '0',
  `user_session_start` int NOT NULL DEFAULT '0',
  `read_tracking_last_update` int NOT NULL DEFAULT '0',
  `user_jr` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_session_time` (`user_session_time`),
  KEY `user_level` (`user_level`),
  KEY `user_lastvisit` (`user_lastvisit`),
  KEY `user_active` (`user_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_users` WRITE;
/*!40000 ALTER TABLE `phpbb_users` DISABLE KEYS */;

INSERT INTO `phpbb_users` (`user_id`, `user_active`, `username`, `user_password`, `user_session_time`, `user_session_page`, `user_lastvisit`, `user_regdate`, `user_level`, `user_posts`, `user_timezone`, `user_style`, `user_lang`, `user_new_privmsg`, `user_unread_privmsg`, `user_last_privmsg`, `user_emailtime`, `user_viewemail`, `user_viewaim`, `user_attachsig`, `user_allowhtml`, `user_allowbbcode`, `user_allowsmile`, `user_allowavatar`, `user_allowsig`, `user_allow_pm`, `user_allow_viewonline`, `user_notify`, `user_notify_pm`, `user_popup_pm`, `user_rank`, `user_avatar`, `user_avatar_type`, `user_email`, `user_icq`, `user_website`, `user_from`, `user_sig`, `user_sig_bbcode_uid`, `user_sig_image`, `user_aim`, `user_yim`, `user_msnm`, `user_occ`, `user_interests`, `user_actkey`, `user_newpasswd`, `user_custom_rank`, `user_photo`, `user_photo_type`, `user_custom_color`, `user_badlogin`, `user_blocktime`, `user_block_by`, `disallow_forums`, `can_custom_ranks`, `can_custom_color`, `user_gender`, `can_topic_color`, `user_notify_gg`, `allowpm`, `no_report_popup`, `refresh_report_popup`, `no_report_mail`, `user_avatar_width`, `user_avatar_height`, `special_rank`, `user_allow_helped`, `user_ip`, `user_ip_login_check`, `user_spend_time`, `user_visit`, `user_session_start`, `read_tracking_last_update`, `user_jr`)
VALUES
	(-1,0,'Anonymous','1c55f93fb42e21a4407e',0,0,0,1601919110,0,0,1.00,0,'polish',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,1,0,0,'',0,'','','','','','','','','','','','','','','','',0,'',0,0,'','',1,1,0,1,0,1,0,0,0,0,0,0,1,'',1,0,0,0,0,0),
	(2,1,'admin','$H$9vuvV3Zp5F4pG.FP4jIIoiziLiT3Ml0',1604252323,0,1604248803,1601919110,1,25,1.00,1,'polish',0,0,0,0,1,1,1,1,1,1,1,1,1,1,0,1,1,1,'',0,'admin@example.com','','','','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac felis at elit ultrices euismod.','62d522719f','','','','','','','','','','',0,'',0,0,'','',1,1,0,1,0,1,0,0,0,0,0,0,1,'ac120001',1,673186,118,1604251746,1603026512,0);

/*!40000 ALTER TABLE `phpbb_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_users_auth
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_users_auth`;

CREATE TABLE `phpbb_users_auth` (
  `user_id` mediumint unsigned NOT NULL,
  `type` set('legacy','classic','facebook','google') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'legacy',
  `index` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `salt` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `active` tinyint unsigned NOT NULL DEFAULT '1',
  UNIQUE KEY `type` (`type`,`index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_users_auth` WRITE;
/*!40000 ALTER TABLE `phpbb_users_auth` DISABLE KEYS */;

INSERT INTO `phpbb_users_auth` (`user_id`, `type`, `index`, `hash`, `salt`, `active`)
VALUES
	(2,'legacy','admin','$H$9vuvV3Zp5F4pG.FP4jIIoiziLiT3Ml0','',1),
	(2,'classic','admin','_zewtsqbKnEvkvaOJnL8IJKKg_e-McmFqD_RZ4qvO5LokrdY3Svbdut64fONQv12','47eb21030af1020d96f0d01964',1); -- qwerty

/*!40000 ALTER TABLE `phpbb_users_auth` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_users_warnings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_users_warnings`;

CREATE TABLE `phpbb_users_warnings` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint NOT NULL DEFAULT '0',
  `modid` mediumint NOT NULL DEFAULT '0',
  `date` int NOT NULL DEFAULT '0',
  `value` mediumint NOT NULL DEFAULT '0',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `warning_viewed` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `archive` (`archive`),
  KEY `warning_viewed` (`warning_viewed`),
  KEY `date` (`date`),
  KEY `userid` (`userid`),
  KEY `modid` (`modid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_vote_desc
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_vote_desc`;

CREATE TABLE `phpbb_vote_desc` (
  `vote_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` mediumint unsigned NOT NULL DEFAULT '0',
  `vote_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vote_start` int NOT NULL DEFAULT '0',
  `vote_length` int NOT NULL DEFAULT '0',
  `vote_max` int NOT NULL DEFAULT '1',
  `vote_voted` int NOT NULL DEFAULT '0',
  `vote_hide` tinyint(1) NOT NULL DEFAULT '0',
  `vote_tothide` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`vote_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_vote_desc` WRITE;
/*!40000 ALTER TABLE `phpbb_vote_desc` DISABLE KEYS */;

INSERT INTO `phpbb_vote_desc` (`vote_id`, `topic_id`, `vote_text`, `vote_start`, `vote_length`, `vote_max`, `vote_voted`, `vote_hide`, `vote_tothide`)
VALUES
	(1,5,'Czy podoba Ci się to Forum?',1065137203,0,1,0,0,0);

/*!40000 ALTER TABLE `phpbb_vote_desc` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_vote_results
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_vote_results`;

CREATE TABLE `phpbb_vote_results` (
  `vote_id` mediumint unsigned NOT NULL DEFAULT '0',
  `vote_option_id` tinyint unsigned NOT NULL DEFAULT '0',
  `vote_option_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `vote_result` int NOT NULL DEFAULT '0',
  KEY `vote_option_id` (`vote_option_id`),
  KEY `vote_id` (`vote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `phpbb_vote_results` WRITE;
/*!40000 ALTER TABLE `phpbb_vote_results` DISABLE KEYS */;

INSERT INTO `phpbb_vote_results` (`vote_id`, `vote_option_id`, `vote_option_text`, `vote_result`)
VALUES
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0),
	(1,1,'Tak',0),
	(1,2,'Nie',0);

/*!40000 ALTER TABLE `phpbb_vote_results` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_vote_voters
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_vote_voters`;

CREATE TABLE `phpbb_vote_voters` (
  `vote_id` mediumint unsigned NOT NULL DEFAULT '0',
  `vote_user_id` mediumint NOT NULL DEFAULT '0',
  `vote_user_ip` char(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `vote_cast` tinyint unsigned NOT NULL DEFAULT '0',
  KEY `vote_id` (`vote_id`),
  KEY `vote_user_id` (`vote_user_id`),
  KEY `vote_user_ip` (`vote_user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table phpbb_words
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_words`;

CREATE TABLE `phpbb_words` (
  `word_id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `word` char(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `replacement` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`word_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
