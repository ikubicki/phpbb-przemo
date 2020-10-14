#
# Basic DB data for phpBB2 modified v1.12.13 by Przemo
#

#
# Table structure for table 'phpbb_advertisement'
#
CREATE TABLE phpbb_advertisement (
  id mediumint(9) NOT NULL auto_increment,
  html text NULL,
  email varchar(128) default '' NULL,
  clicks int(9) default '0' NOT NULL,
  position tinyint(1) default '0' NOT NULL,
  porder mediumint(4) default '0' NOT NULL,
  added int(11) default '0' NOT NULL,
  expire int(11) default '0' NOT NULL,
  last_update int(11) default '0' NOT NULL,
  notify tinyint(1) default '0' NOT NULL,
  type tinyint(1) default '0' NOT NULL,
  PRIMARY KEY (id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_adv_person'
#
CREATE TABLE phpbb_adv_person (
  user_id mediumint(9) default '0' NOT NULL,
  person_id mediumint(9) default '0' NOT NULL,
  person_ip char(8) default '',
  PRIMARY KEY (user_id, person_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_anti_robotic_reg'
#
CREATE TABLE phpbb_anti_robotic_reg (
  session_id char(32) default '' NOT NULL,
  reg_key char(4) NOT NULL default '',
  timestamp int(10) UNSIGNED NOT NULL default '0',
  PRIMARY KEY (session_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_attachments'
#
CREATE TABLE phpbb_attachments (
  attach_id mediumint(8) UNSIGNED default '0' NOT NULL, 
  post_id mediumint(8) UNSIGNED default '0' NOT NULL, 
  privmsgs_id mediumint(8) UNSIGNED default '0' NOT NULL,
  user_id_1 mediumint(8) NOT NULL default '0',
  user_id_2 mediumint(8) NOT NULL default '0',
  KEY attach_id_post_id (attach_id, post_id),
  KEY attach_id_privmsgs_id (attach_id, privmsgs_id),
  KEY user_id_1 (user_id_1),
  KEY user_id_2 (user_id_2)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci; 

#
# Table structure for table 'phpbb_attachments_config'
#
CREATE TABLE phpbb_attachments_config (
  config_name varchar(255) NOT NULL default '',
  config_value varchar(255) NOT NULL default '',
  PRIMARY KEY (config_name)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_attachments_desc'
#
CREATE TABLE phpbb_attachments_desc (
  attach_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  physical_filename varchar(255) NOT NULL default '',
  real_filename varchar(255) NOT NULL default '',
  download_count mediumint(8) UNSIGNED default '0' NOT NULL,
  comment varchar(255) default NULL,
  extension varchar(100) default NULL,
  mimetype varchar(100) default NULL,
  filesize int(20) NOT NULL default '0',
  filetime int(11) default '0' NOT NULL,
  thumbnail tinyint(1) default '0' NOT NULL,
  PRIMARY KEY (attach_id),
  KEY filetime (filetime),
  KEY physical_filename (physical_filename(10)),
  KEY filesize (filesize)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_attach_quota'
#
CREATE TABLE phpbb_attach_quota (
  user_id mediumint(8) UNSIGNED NOT NULL default '0',
  group_id mediumint(8) UNSIGNED NOT NULL default '0',
  quota_type smallint(2) NOT NULL default '0',
  quota_limit_id mediumint(8) UNSIGNED NOT NULL default '0',
  KEY quota_type (quota_type)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_auth_access'
#
CREATE TABLE phpbb_auth_access (
  group_id mediumint(8) default '0' NOT NULL,
  forum_id smallint(5) UNSIGNED default '0' NOT NULL,
  auth_view tinyint(1) default '0' NOT NULL,
  auth_read tinyint(1) default '0' NOT NULL,
  auth_post tinyint(1) default '0' NOT NULL,
  auth_reply tinyint(1) default '0' NOT NULL,
  auth_edit tinyint(1) default '0' NOT NULL,
  auth_delete tinyint(1) default '0' NOT NULL,
  auth_sticky tinyint(1) default '0' NOT NULL,
  auth_announce tinyint(1) default '0' NOT NULL,
  auth_globalannounce tinyint(1) default '0' NOT NULL,
  auth_vote tinyint(1) default '0' NOT NULL,
  auth_pollcreate tinyint(1) default '0' NOT NULL,
  auth_attachments tinyint(1) default '0' NOT NULL,
  auth_mod tinyint(1) default '0' NOT NULL, 
  auth_download tinyint(1) default '0' NOT NULL,
  KEY group_id (group_id),
  KEY forum_id (forum_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_banlist'
#
CREATE TABLE phpbb_banlist (
  ban_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  ban_userid mediumint(8) NOT NULL default '0',
  ban_ip char(8) NOT NULL default '',
  ban_email varchar(255) default NULL,
  ban_time int(11) default NULL,
  ban_expire_time int(11) default NULL,
  ban_by_userid mediumint(8) default NULL,
  ban_priv_reason text,
  ban_pub_reason_mode tinyint(1) default NULL,
  ban_pub_reason text,
  ban_host varchar(255) default '',
  PRIMARY KEY (ban_id), 
  KEY ban_ip_user_id (ban_ip, ban_userid)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_categories'
#
CREATE TABLE phpbb_categories (
  cat_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  cat_title varchar(254) default NULL,
  cat_order mediumint(8) UNSIGNED NOT NULL default '0',
  cat_main_type char(1) default NULL,
  cat_main mediumint(8) UNSIGNED default '0' NOT NULL,
  cat_desc text NOT NULL,
  PRIMARY KEY (cat_id), 
  KEY cat_order (cat_order)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_config'
#
CREATE TABLE phpbb_config ( 
   config_name varchar(255) NOT NULL default '',
   config_value text NOT NULL,
   PRIMARY KEY (config_name)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_disallow'
#
CREATE TABLE phpbb_disallow (
  disallow_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  disallow_username varchar(25) default '' NOT NULL,
  PRIMARY KEY (disallow_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_extensions'
#
CREATE TABLE phpbb_extensions (
  ext_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  group_id mediumint(8) UNSIGNED default '0' NOT NULL,
  extension varchar(100) NOT NULL default '',
  comment varchar(100) default '',
  PRIMARY KEY ext_id (ext_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_extension_groups'
#
CREATE TABLE phpbb_extension_groups (
  group_id mediumint(8) NOT NULL auto_increment,
  group_name char(20) NOT NULL default '',
  cat_id tinyint(2) default '0' NOT NULL, 
  allow_group tinyint(1) default '0' NOT NULL,
  download_mode tinyint(1) UNSIGNED default '1' NOT NULL,
  upload_icon varchar(100) default '',
  max_filesize int(20) default '0' NOT NULL,
  forum_permissions varchar(255) default '' NOT NULL,
  PRIMARY KEY group_id (group_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_forbidden_extensions'
#
CREATE TABLE phpbb_forbidden_extensions (
  ext_id mediumint(8) UNSIGNED NOT NULL auto_increment, 
  extension varchar(100) NOT NULL default '', 
  PRIMARY KEY (ext_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_forum_prune'
#
CREATE TABLE phpbb_forum_prune (
  prune_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  forum_id smallint(5) UNSIGNED NOT NULL default '0',
  prune_days smallint(5) UNSIGNED NOT NULL default '0',
  prune_freq smallint(5) UNSIGNED NOT NULL default '0',
  PRIMARY KEY(prune_id),
  KEY forum_id (forum_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_forums'
#
CREATE TABLE phpbb_forums (
  forum_id smallint(5) UNSIGNED NOT NULL default '0',
  cat_id mediumint(8) UNSIGNED NOT NULL default '0',
  forum_name varchar(254) default '',
  forum_desc text,
  forum_status tinyint(1) default '0' NOT NULL, 
  forum_order mediumint(8) UNSIGNED default '1' NOT NULL,
  forum_posts mediumint(8) UNSIGNED default '0' NOT NULL,
  forum_topics mediumint(8) UNSIGNED default '0' NOT NULL,
  forum_last_post_id mediumint(8) UNSIGNED default '0' NOT NULL,
  prune_next int(11) default NULL,
  prune_enable tinyint(1) default '0' NOT NULL,
  auth_view tinyint(2) default '0' NOT NULL,
  auth_read tinyint(2) default '0' NOT NULL,
  auth_post tinyint(2) default '0' NOT NULL,
  auth_reply tinyint(2) default '0' NOT NULL,
  auth_edit tinyint(2) default '0' NOT NULL,
  auth_delete tinyint(2) default '0' NOT NULL,
  auth_sticky tinyint(2) default '0' NOT NULL,
  auth_announce tinyint(2) default '0' NOT NULL,
  auth_globalannounce tinyint(2) default '3' NOT NULL,
  auth_vote tinyint(2) default '0' NOT NULL,
  auth_pollcreate tinyint(2) default '0' NOT NULL,
  auth_attachments tinyint(2) default '0' NOT NULL,
  auth_download tinyint(2) default '0' NOT NULL,
  password varchar(20) NOT NULL default '',
  forum_sort varchar(12) NOT NULL,
  forum_color varchar(6) NOT NULL default  '',
  forum_link varchar(255) default NULL,
  forum_link_internal tinyint(1) NOT NULL default '0',
  forum_link_hit_count tinyint(1) NOT NULL default '0',
  forum_link_hit bigint(20) UNSIGNED NOT NULL default '0',
  main_type char(1) default NULL,
  forum_moderate tinyint(1) default '0' NOT NULL,
  no_count tinyint(1) default '0' NOT NULL,
  forum_trash smallint(1) default '0' NOT NULL,
  forum_separate smallint(1) default '2' NOT NULL,
  forum_show_ga smallint(1) default '1' NOT NULL,
  forum_tree_grade tinyint(1) default '3' NOT NULL,
  forum_tree_req tinyint(1) default '0' NOT NULL,
  forum_no_split tinyint(1) default '0' NOT NULL,
  forum_no_helped tinyint(1) default '0' NOT NULL,
  topic_tags varchar(255) default '' NULL,
  locked_bottom tinyint(1) default '0' NULL,
  PRIMARY KEY (forum_id),
  KEY forums_order (forum_order),
  KEY cat_id (cat_id), 
  KEY forum_last_post_id (forum_last_post_id),
  KEY no_count (no_count)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_groups'
#
CREATE TABLE phpbb_groups (
  group_id mediumint(8) NOT NULL auto_increment,
  group_type tinyint(4) default '1' NOT NULL, 
  group_name varchar(120) NOT NULL default '',
  group_description varchar(255) NOT NULL default '',
  group_moderator mediumint(8) default '0' NOT NULL, 
  group_single_user tinyint(1) default '1' NOT NULL, 
  group_order mediumint(8) default '0' NOT NULL,
  group_count int(4) UNSIGNED default '99999999',
  group_count_enable smallint(2) UNSIGNED default '0',
  group_mail_enable smallint(1) default '0' NULL,
  group_no_unsub smallint(1) default '0' NULL,
  group_color varchar(6) default NULL,
  group_prefix varchar(8) default NULL,
  group_style varchar(255) default NULL,
  PRIMARY KEY (group_id), 
  KEY group_single_user (group_single_user),
  KEY group_type (group_type)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_ignore'
#
CREATE TABLE phpbb_ignores (
  user_id mediumint(8) NOT NULL default '0',
  user_ignore mediumint(8) NOT NULL default '0',
  PRIMARY KEY (user_id, user_ignore)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_jr_admin_users'
#
CREATE TABLE phpbb_jr_admin_users (
  user_id mediumint(9) NOT NULL default '0',
  user_jr_admin varchar(254) default '' NOT NULL,
  PRIMARY KEY (user_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_logs'
#
CREATE TABLE phpbb_logs (
  id_log mediumint(10) NOT NULL auto_increment,
  mode varchar(50) NULL default '', 
  topic_id mediumint(10) NULL default '0',
  user_id mediumint(8) NULL default '0',
  username varchar(25) NULL default '',
  user_ip char(8) default '0' NOT NULL,
  time int(11) default '0',
  PRIMARY KEY (id_log)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_mass_email'
#
CREATE TABLE phpbb_mass_email (
  mass_email_user_id mediumint(8) default '0' NOT NULL,
  mass_email_text longtext NULL, 
  mass_email_subject text NULL,
  mass_email_bcc longtext NULL,
  mass_email_html tinyint(1) default '0' NOT NULL,
  mass_email_to varchar(128) default '' NULL,
  PRIMARY KEY (mass_email_user_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_posts'
#
CREATE TABLE phpbb_posts (
  post_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  topic_id mediumint(8) UNSIGNED default '0' NOT NULL,
  forum_id smallint(5) UNSIGNED default '0' NOT NULL,
  poster_id mediumint(8) default '0' NOT NULL,
  post_time int(11) default '0' NOT NULL,
  post_start_time int(11) default '0' NOT NULL,
  poster_ip char(8) NOT NULL default '', 
  post_username varchar(25) default '' NOT NULL, 
  enable_bbcode tinyint(1) default '1' NOT NULL,
  enable_html tinyint(1) DEFAULT '0' NOT NULL,
  enable_smilies tinyint(1) DEFAULT '1' NOT NULL,
  enable_sig tinyint(1) DEFAULT '1' NOT NULL, 
  post_edit_time int(11) default '0' NULL,
  post_edit_count smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
  post_attachment tinyint(1) DEFAULT '0' NOT NULL,
  user_agent varchar(255) DEFAULT '' NOT NULL,
  post_icon tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  post_expire int(11) DEFAULT '0' NOT NULL,
  reporter_id mediumint(8) DEFAULT '0' NOT NULL,
  post_marked enum('n','y') default NULL,
  post_approve tinyint(1) DEFAULT '1' NOT NULL,
  poster_delete tinyint(1) DEFAULT '0',
  post_edit_by mediumint(8) DEFAULT '0' NOT NULL,
  post_parent mediumint(8) DEFAULT '0' NOT NULL,
  post_order mediumint(8) DEFAULT '0' NOT NULL,
  PRIMARY KEY (post_id),
  KEY forum_id (forum_id),
  KEY topic_id (topic_id),
  KEY poster_id (poster_id), 
  KEY post_time (post_time),
  KEY reporter_id (reporter_id),
  KEY post_parent (post_parent),
  KEY post_approve (post_approve)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_posts_text'
#
CREATE TABLE phpbb_posts_text (
  post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  bbcode_uid char(10) DEFAULT '' NOT NULL,
  post_subject char(60) DEFAULT '' NOT NULL,
  post_text text,
  PRIMARY KEY (post_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_posts_text_history'
#
CREATE TABLE phpbb_posts_text_history (
  th_id mediumint(9) NOT NULL auto_increment,
  th_post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  th_post_text text,
  th_user_id mediumint(8) DEFAULT '0' NOT NULL,
  th_time int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (th_id),
  KEY th_post_id (th_post_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

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
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_privmsgs'
#
CREATE TABLE phpbb_privmsgs (
  privmsgs_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  privmsgs_type tinyint(4) DEFAULT '0' NOT NULL,
  privmsgs_subject varchar(255) DEFAULT '0' NOT NULL,
  privmsgs_from_userid mediumint(8) DEFAULT '0' NOT NULL,
  privmsgs_to_userid mediumint(8) DEFAULT '0' NOT NULL,
  privmsgs_date int(11) DEFAULT '0' NOT NULL,
  privmsgs_ip char(8) NOT NULL default '',
  privmsgs_enable_bbcode tinyint(1) DEFAULT '1' NOT NULL,
  privmsgs_enable_html tinyint(1) DEFAULT '0' NOT NULL,
  privmsgs_enable_smilies tinyint(1) DEFAULT '1' NOT NULL, 
  privmsgs_attach_sig tinyint(1) DEFAULT '1' NOT NULL, 
  privmsgs_attachment tinyint(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (privmsgs_id),
  KEY privmsgs_from_userid (privmsgs_from_userid),
  KEY privmsgs_to_userid (privmsgs_to_userid),
  KEY privmsgs_type (privmsgs_type)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_privmsgs_text'
#
CREATE TABLE phpbb_privmsgs_text (
  privmsgs_text_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  privmsgs_bbcode_uid char(10) DEFAULT '0' NOT NULL, 
  privmsgs_text text,
  PRIMARY KEY (privmsgs_text_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_quota_limits'
#
CREATE TABLE phpbb_quota_limits (
  quota_limit_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  quota_desc varchar(20) NOT NULL DEFAULT '',
  quota_limit bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (quota_limit_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_ranks'
#
CREATE TABLE phpbb_ranks (
  rank_id smallint(5) UNSIGNED NOT NULL auto_increment,
  rank_title varchar(50) NOT NULL default '',
  rank_min mediumint(8) DEFAULT '0' NOT NULL,
  rank_special tinyint(1) DEFAULT '0',
  rank_image varchar(255) default '',
  rank_group mediumint(8) DEFAULT '0' NOT NULL,
  PRIMARY KEY (rank_id) 
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_read_history'
#
CREATE TABLE phpbb_read_history (
  user_id mediumint(8) NOT NULL DEFAULT '0',
  post_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  topic_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  forum_id smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
  KEY user_id (user_id),
  KEY post_id (post_id),
  KEY topic_id (topic_id),
  KEY forum_id (forum_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table `phpbb_search_results`
#
CREATE TABLE phpbb_search_results (
  search_id int(11) UNSIGNED NOT NULL auto_increment,
  session_id char(32) NOT NULL DEFAULT '',
  search_array longtext NOT NULL,
  search_time int NOT NULL,
  PRIMARY KEY  (search_id),
  KEY session_id (session_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table `phpbb_search_wordlist`
#
CREATE TABLE phpbb_search_wordlist (
  word_text varchar(50) binary NOT NULL DEFAULT '',
  word_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  word_common tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (word_text), 
  KEY word_id (word_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table `phpbb_search_wordmatch`
#
CREATE TABLE phpbb_search_wordmatch (
  post_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  word_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  title_match tinyint(1) NOT NULL DEFAULT '0',
  KEY post_id (post_id),
  KEY word_id (word_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_sessions'
#
# Note that if you're running 3.23.x you may want to make
# this table a type HEAP. This type of table is stored
# within system memory and therefore for big busy boards
# is likely to be noticeably faster than continually
# writing to disk ... 
#
# I must admit I read about this type on vB's board.
# Hey, I never said you cannot get basic ideas from
# competing boards, just that I find it's best not to
# look at any code ... !
#
CREATE TABLE phpbb_sessions (
  session_id char(32) DEFAULT '' NOT NULL,
  session_user_id mediumint(8) DEFAULT '0' NOT NULL,
  session_start int(11) DEFAULT '0' NOT NULL,
  session_time int(11) DEFAULT '0' NOT NULL,
  session_ip char(8) DEFAULT '0' NOT NULL,
  session_page int(11) DEFAULT '0' NOT NULL,
  session_logged_in tinyint(1) DEFAULT '0' NOT NULL,
  session_admin tinyint(2) DEFAULT '0' NOT NULL,
  PRIMARY KEY (session_id),
  KEY session_user_id (session_user_id),
  KEY session_id_ip_user_id (session_id, session_ip, session_user_id),
  KEY session_time (session_time)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table `phpbb_sessions_keys`
#
CREATE TABLE phpbb_sessions_keys (
  key_id varchar(32) DEFAULT '0' NOT NULL,
  user_id mediumint(8) DEFAULT '0' NOT NULL,
  last_ip varchar(8) DEFAULT '0' NOT NULL,
  last_login int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (key_id, user_id),
  KEY last_login (last_login)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_shoutbox'
#
CREATE TABLE phpbb_shoutbox (
  id int(11) NOT NULL auto_increment,
  sb_user_id int(11) NOT NULL default '0',
  msg text NOT NULL,
  timestamp int(10) UNSIGNED NOT NULL default '0',
  PRIMARY KEY (id),
  KEY sb_user_id (sb_user_id),
  KEY timestamp (timestamp)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_shoutbox_config'
#
CREATE TABLE phpbb_shoutbox_config ( 
   config_name varchar(255) NOT NULL default '', 
   config_value varchar(255) NOT NULL default '', 
   PRIMARY KEY (config_name)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_smilies'
#
CREATE TABLE phpbb_smilies (
  smilies_id smallint(5) UNSIGNED NOT NULL auto_increment,
  code varchar(50) default '',
  smile_url varchar(100) default '',
  emoticon varchar(75) default '',
  smile_order mediumint(8) UNSIGNED DEFAULT '1' NOT NULL,
  PRIMARY KEY (smilies_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_stats_config'
#
CREATE TABLE phpbb_stats_config (
  config_name varchar(50) NOT NULL DEFAULT '',
  config_value varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (config_name)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_stats_modules'
#
CREATE TABLE phpbb_stats_modules (
  module_id tinyint(8) NOT NULL DEFAULT '0',
  name varchar(150) NOT NULL DEFAULT '',
  active tinyint(1) NOT NULL DEFAULT '0',
  installed tinyint(1) NOT NULL DEFAULT '0',
  display_order mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  update_time mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  auth_value tinyint(2) NOT NULL DEFAULT '0',
  module_info_cache blob,
  module_db_cache blob,
  module_result_cache blob,
  module_info_time int(10) UNSIGNED NOT NULL DEFAULT '0',
  module_cache_time int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (module_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_themes'
#
CREATE TABLE phpbb_themes (
  themes_id mediumint(8) UNSIGNED NOT NULL auto_increment, 
  template_name varchar(30) NOT NULL DEFAULT '', 
  style_name varchar(30) NOT NULL DEFAULT '',
  head_stylesheet varchar(100) DEFAULT NULL,
  body_background varchar(100) DEFAULT NULL,
  body_bgcolor varchar(6) DEFAULT NULL,
  body_text varchar(6) DEFAULT NULL,
  body_link varchar(6) DEFAULT NULL,
  body_vlink varchar(6) DEFAULT NULL,
  body_alink varchar(6) DEFAULT NULL,
  body_hlink varchar(6) DEFAULT NULL,
  tr_color1 varchar(6) DEFAULT NULL,
  tr_color2 varchar(6) DEFAULT NULL,
  tr_color3 varchar(6) DEFAULT NULL,
  tr_color_helped varchar(6) DEFAULT NULL,
  tr_class1 varchar(25) DEFAULT NULL,
  tr_class2 varchar(25) DEFAULT NULL,
  tr_class3 varchar(25) DEFAULT NULL,
  th_color1 varchar(6) DEFAULT NULL,
  th_color2 varchar(6) DEFAULT NULL,
  th_color3 varchar(6) DEFAULT NULL,
  th_class1 varchar(25) DEFAULT NULL,
  th_class2 varchar(25) DEFAULT NULL,
  th_class3 varchar(25) DEFAULT NULL,
  td_color1 varchar(6) DEFAULT NULL,
  td_color2 varchar(6) DEFAULT NULL,
  td_color3 varchar(6) DEFAULT NULL,
  td_class1 varchar(25) DEFAULT NULL,
  td_class2 varchar(25) DEFAULT NULL,
  td_class3 varchar(25) DEFAULT NULL,
  fontface1 varchar(50) DEFAULT NULL,
  fontface2 varchar(50) DEFAULT NULL,
  fontface3 varchar(50) DEFAULT NULL,
  fontsize1 tinyint(4) DEFAULT NULL,
  fontsize2 tinyint(4) DEFAULT NULL,
  fontsize3 tinyint(4) DEFAULT NULL,
  fontcolor1 varchar(6) DEFAULT NULL,
  fontcolor2 varchar(6) DEFAULT NULL,
  fontcolor3 varchar(6) DEFAULT NULL,
  fontcolor_admin varchar(6) DEFAULT NULL,
  fontcolor_jradmin varchar(6) DEFAULT NULL,
  fontcolor_mod varchar(6) DEFAULT NULL,
  factive_color varchar(6) DEFAULT NULL,
  faonmouse_color varchar(6) DEFAULT NULL,
  faonmouse2_color varchar(6) DEFAULT NULL,
  span_class1 varchar(25) DEFAULT NULL,
  span_class2 varchar(25) DEFAULT NULL,
  span_class3 varchar(25) DEFAULT NULL, 
  img_size_poll smallint(5) UNSIGNED, 
  img_size_privmsg smallint(5) UNSIGNED, 
  PRIMARY KEY  (themes_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_themes_name'
#
CREATE TABLE phpbb_themes_name (
  themes_id smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
  tr_color1_name char(50),
  tr_color2_name char(50),
  tr_color3_name char(50),
  tr_class1_name char(50),
  tr_class2_name char(50),
  tr_class3_name char(50),
  th_color1_name char(50),
  th_color2_name char(50),
  th_color3_name char(50),
  th_class1_name char(50),
  th_class2_name char(50),
  th_class3_name char(50),
  td_color1_name char(50),
  td_color2_name char(50),
  td_color3_name char(50),
  td_class1_name char(50),
  td_class2_name char(50),
  td_class3_name char(50),
  fontface1_name char(50),
  fontface2_name char(50),
  fontface3_name char(50),
  fontsize1_name char(50),
  fontsize2_name char(50),
  fontsize3_name char(50),
  fontcolor1_name char(50),
  fontcolor2_name char(50),
  fontcolor3_name char(50),
  span_class1_name char(50),
  span_class2_name char(50),
  span_class3_name char(50),
  PRIMARY KEY (themes_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_topics'
#
CREATE TABLE phpbb_topics (
  topic_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  forum_id smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
  topic_title char(60) NOT NULL default '',
  topic_poster mediumint(8) DEFAULT '0' NOT NULL,
  topic_time int(11) DEFAULT '0' NOT NULL,
  topic_views mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  topic_replies mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  topic_status tinyint(1) DEFAULT '0' NOT NULL,
  topic_vote tinyint(1) DEFAULT '0' NOT NULL,
  topic_type tinyint(1) DEFAULT '0' NOT NULL,
  topic_first_post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  topic_last_post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  topic_moved_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  topic_attachment tinyint(1) DEFAULT '0' NOT NULL,
  topic_icon tinyint(2) UNSIGNED DEFAULT '0' NOT NULL,
  topic_expire int(11) DEFAULT '0' NOT NULL,
  topic_color varchar(8) DEFAULT NULL,
  topic_title_e char(100) NOT NULL DEFAULT '',
  topic_action tinyint(1) DEFAULT '0',
  topic_action_user mediumint(8) NOT NULL DEFAULT '0',
  topic_action_date int(11) DEFAULT '0' NOT NULL,
  topic_tree_width smallint(2) DEFAULT '0' NOT NULL,
  topic_accept TINYINT( 1 ) NOT NULL DEFAULT '1',
  topic_votes_sum INT UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (topic_id),
  KEY forum_id (forum_id),
  KEY topic_moved_id (topic_moved_id),
  KEY topic_status (topic_status), 
  KEY topic_type (topic_type),
  KEY topic_poster (topic_poster),
  KEY topic_last_post_id (topic_last_post_id),
  KEY topic_first_post_id (topic_first_post_id),
  KEY topic_vote (topic_vote)

) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_topics_ignore'
#
CREATE TABLE phpbb_topics_ignore (
  topic_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  user_id mediumint(8) DEFAULT '0' NOT NULL,
  PRIMARY KEY (topic_id, user_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_topics_watch'
#
CREATE TABLE phpbb_topics_watch (
  topic_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  user_id mediumint(8) NOT NULL DEFAULT '0',
  notify_status tinyint(1) NOT NULL DEFAULT '0',
  KEY topic_id (topic_id),
  KEY user_id (user_id), 
  KEY notify_status (notify_status)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_topic_view'
#
CREATE TABLE phpbb_topic_view ( 
  topic_id mediumint(8) NOT NULL default '0', 
  user_id mediumint(8) NOT NULL default '0', 
  view_time int(11) NOT NULL default '0', 
  view_count int(11) NOT NULL default '0',
  PRIMARY KEY (topic_id, user_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_users'
#
CREATE TABLE phpbb_users (
  user_id mediumint(8) NOT NULL auto_increment,
  user_active tinyint(1) DEFAULT '1',
  username varchar(25) NOT NULL default '',
  user_password varchar(40) NOT NULL default '',
  user_session_time int(11) DEFAULT '0' NOT NULL, 
  user_session_page smallint(5) DEFAULT '0' NOT NULL, 
  user_lastvisit int(11) DEFAULT '0' NOT NULL, 
  user_regdate int(11) DEFAULT '0' NOT NULL, 
  user_level tinyint(1) DEFAULT '0',
  user_posts mediumint(6) UNSIGNED DEFAULT '0' NOT NULL,
  user_timezone decimal(5,2) DEFAULT '0' NOT NULL,
  user_style tinyint(2) default '1' NULL,
  user_lang varchar(12) default '' NOT NULL,
  user_new_privmsg smallint(5) UNSIGNED DEFAULT '0' NOT NULL, 
  user_unread_privmsg smallint(5) UNSIGNED DEFAULT '0' NOT NULL, 
  user_last_privmsg int(11) DEFAULT '0' NOT NULL, 
  user_emailtime int(11) default '0', 
  user_viewemail tinyint(1) DEFAULT '1', 
  user_viewaim tinyint(1) DEFAULT '1', 
  user_attachsig tinyint(1) DEFAULT '1', 
  user_allowhtml tinyint(1) DEFAULT '1', 
  user_allowbbcode tinyint(1) DEFAULT '1', 
  user_allowsmile tinyint(1) DEFAULT '1', 
  user_allowavatar tinyint(1) DEFAULT '1' NOT NULL, 
  user_allowsig tinyint(1) DEFAULT '1' NOT NULL,
  user_allow_pm tinyint(1) DEFAULT '1' NOT NULL, 
  user_allow_viewonline tinyint(1) DEFAULT '1' NOT NULL, 
  user_notify tinyint(1) DEFAULT '1' NOT NULL,
  user_notify_pm tinyint(1) DEFAULT '1' NOT NULL, 
  user_popup_pm tinyint(1) DEFAULT '0' NOT NULL,
  user_rank int(11) DEFAULT '0',
  user_avatar varchar(100) default '',
  user_avatar_type tinyint(1) DEFAULT '0' NOT NULL, 
  user_email varchar(255) default '',
  user_icq varchar(15) default '',
  user_website varchar(255) default '',
  user_from varchar(64) default '',
  user_sig text,
  user_sig_bbcode_uid char(10) default '',
  user_sig_image varchar(100) NOT NULL DEFAULT '',
  user_aim varchar(255) default '',
  user_yim varchar(255) default '',
  user_msnm varchar(255) default '',
  user_occ varchar(100) default '',
  user_interests varchar(255) default '',
  user_actkey varchar(32) default '',
  user_newpasswd varchar(40) default '',
  user_custom_rank varchar(100) default '',
  user_photo varchar(100) default '',
  user_photo_type tinyint(1) DEFAULT '0' NOT NULL,
  user_custom_color varchar(6) default '',
  user_badlogin smallint(2) DEFAULT '0' NOT NULL,
  user_blocktime int(11) DEFAULT '0' NOT NULL,
  user_block_by char(8) default '',
  disallow_forums varchar(254) default '',
  can_custom_ranks tinyint(1) DEFAULT '1' NOT NULL,
  can_custom_color tinyint(1) DEFAULT '1' NOT NULL,
  user_gender tinyint(1) NOT NULL DEFAULT '0',
  can_topic_color tinyint(1) DEFAULT '1' NOT NULL,
  user_notify_gg tinyint(1) DEFAULT '0' NOT NULL,
  allowpm tinyint(1) DEFAULT '1',
  no_report_popup tinyint(1) DEFAULT '0' NOT NULL,
  refresh_report_popup tinyint(1) DEFAULT '0' NOT NULL,
  no_report_mail tinyint(1) DEFAULT '0' NOT NULL,
  user_avatar_width smallint(3) default NULL,
  user_avatar_height smallint(3) default NULL,
  special_rank mediumint(8) UNSIGNED DEFAULT NULL,
  user_allow_helped tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  user_ip char(8) DEFAULT NULL,
  user_ip_login_check tinyint(1) DEFAULT '1' NOT NULL,
  user_spend_time int(8) DEFAULT '0' NOT NULL,
  user_visit int(7) DEFAULT '0' NOT NULL,
  user_session_start  int(11) NOT NULL DEFAULT '0',
  read_tracking_last_update int(11) NOT NULL DEFAULT '0',
  user_jr tinyint(1) DEFAULT '0',
  PRIMARY KEY (user_id), 
  KEY user_session_time (user_session_time),
  KEY user_level (user_level),
  KEY user_lastvisit (user_lastvisit),
  KEY user_active (user_active)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_user_group'
#
CREATE TABLE phpbb_user_group (
  group_id mediumint(8) DEFAULT '0' NOT NULL,
  user_id mediumint(8) DEFAULT '0' NOT NULL,
  user_pending tinyint(1) default NULL,
  KEY group_id (group_id),
  KEY user_id (user_id),
  KEY user_pending (user_pending)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_users_warnings'
#
CREATE TABLE phpbb_users_warnings (
  id mediumint(8) UNSIGNED NOT NULL auto_increment,
  userid mediumint(8) NOT NULL DEFAULT '0',
  modid mediumint(8) NOT NULL DEFAULT '0',
  date int(11) NOT NULL DEFAULT '0',
  value mediumint(8) NOT NULL DEFAULT '0',
  reason text,
  archive tinyint(1) DEFAULT '0' NOT NULL,
  warning_viewed smallint(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (id),
  KEY archive (archive),
  KEY warning_viewed (warning_viewed),
  KEY date (date),
  KEY userid (userid),
  KEY modid (modid)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_vote_desc'
#
CREATE TABLE phpbb_vote_desc (
  vote_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  topic_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  vote_text text NOT NULL,
  vote_start int(11) NOT NULL DEFAULT '0',
  vote_length int(11) NOT NULL DEFAULT '0',
  vote_max int(3) DEFAULT '1' NOT NULL,
  vote_voted int(7) DEFAULT '0' NOT NULL,
  vote_hide tinyint(1) DEFAULT '0' NOT NULL,
  vote_tothide tinyint(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY  (vote_id),
  KEY topic_id (topic_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_vote_results'
#
CREATE TABLE phpbb_vote_results (
  vote_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  vote_option_id tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  vote_option_text varchar(255) NOT NULL default '',
  vote_result int(11) NOT NULL DEFAULT '0',
  KEY vote_option_id (vote_option_id),
  KEY vote_id (vote_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_vote_voters'
#
CREATE TABLE phpbb_vote_voters (
  vote_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  vote_user_id mediumint(8) NOT NULL DEFAULT '0',
  vote_user_ip char(8) NOT NULL default '',
  vote_cast tinyint(4) UNSIGNED DEFAULT '0' NOT NULL,
  KEY vote_id (vote_id),
  KEY vote_user_id (vote_user_id),
  KEY vote_user_ip (vote_user_ip)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

#
# Table structure for table 'phpbb_words'
#
CREATE TABLE phpbb_words (
  word_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  word char(100) NOT NULL default '',
  replacement text NOT NULL,
  PRIMARY KEY (word_id)
) DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;
