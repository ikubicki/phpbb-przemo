<?php
$dbs_for = '1.12.6';
$dbs = array(
	array(
		'table' => 'advertisement'),
	array(
		'table' => 'adv_person'),
	array(
		'table' => 'admin_notes',
		'verbose' => false),
	array(
		'table' => 'anti_robotic_reg'),
	array(
		'table' => 'attach_quota'),
	array(
		'table' => 'attachments'),
	array(
		'table' => 'attachments_config'),
	array(
		'table' => 'attachments_desc'),
	array(
		'table' => 'auth_access'),
	array(
		'table' => 'banlist'),
	array(
		'table' => 'categories'),
	array(
		'table' => 'config'),
	array(
		'table' => 'config_saved',
		'verbose' => false),
	array(
		'table' => 'disallow'),
	array(
		'table' => 'extension_groups'),
	array(
		'table' => 'extensions'),
	array(
		'table' => 'forbidden_extensions'),
	array(
		'table' => 'forum_prune'),
	array(
		'table' => 'forums'),
	array(
		'table' => 'groups'),
	array(
		'table' => 'ignores'),
	array(
		'table' => 'jr_admin_users'),
	array(
		'table' => 'logs'),
	array(
		'table' => 'mass_email'),
	array(
		'table' => 'posts',
		'fields' => 24),
	array(
		'table' => 'posts_text'),
	array(
		'table' => 'posts_text_history'),
	array(
		'table' => 'privmsgs'),
	array(
		'table' => 'privmsgs_text'),
	array(
		'table' => 'profile_fields',
		'verbose' => false),
	array(
		'table' => 'quota_limits'),
	array(
		'table' => 'ranks'),
	array(
		'table' => 'read_history'),
	array(
		'table' => 'search_results',
		'create' => "CREATE TABLE `{PREFIX}search_results` (
  `search_id` int(11) unsigned NOT NULL default '0',
  `session_id` varchar(32) NOT NULL default '',
  `search_array` text NOT NULL,
  PRIMARY KEY  (`search_id`),
  KEY `session_id` (`session_id`)
) DEFAULT CHARSET latin2 COLLATE latin2_general_ci"),
	array(
		'table' => 'search_wordlist',
		'create' => "CREATE TABLE `{PREFIX}search_wordlist` (
  `word_text` varchar(50) binary NOT NULL default '',
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word_common` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`word_text`),
  KEY `word_id` (`word_id`)
) DEFAULT CHARSET latin2 COLLATE latin2_general_ci AUTO_INCREMENT=1"),
	array(
		'table' => 'search_wordmatch',
		'create' => "CREATE TABLE `{PREFIX}search_wordmatch` (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `word_id` mediumint(8) unsigned NOT NULL default '0',
  `title_match` tinyint(1) NOT NULL default '0',
  KEY `post_id` (`post_id`),
  KEY `word_id` (`word_id`)
) DEFAULT CHARSET latin2 COLLATE latin2_general_ci"),
	array(
		'table' => 'sessions'),
	array(
		'table' => 'sessions_keys'),
	array(
		'table' => 'shoutbox'),
	array(
		'table' => 'shoutbox_config'),
	array(
		'table' => 'smilies'),
	array(
		'table' => 'stats_config'),
	array(
		'table' => 'stats_modules'),
	array(
		'table' => 'themes'),
	array(
		'table' => 'themes_name'),
	array(
		'table' => 'topic_view'),
	array(
		'table' => 'topics'),
	array(
		'table' => 'topics_ignore'),
	array(
		'table' => 'topics_watch'),
	array(
		'table' => 'user_group'),
	array(
		'table' => 'users',
		'fields' => 77),
	array(
		'table' => 'users_warnings'),
	array(
		'table' => 'vote_desc',
		'fields' => 9),
	array(
		'table' => 'vote_results'),
	array(
		'table' => 'vote_voters'),
	array(
		'table' => 'words')
);
?>