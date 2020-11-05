ALTER TABLE `phpbb_topics` ADD `topic_votes_sum` INT UNSIGNED NOT NULL DEFAULT '0';
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
) ENGINE=InnoDB;
CREATE TABLE `phpbb_users_auth` (
  `user_id` mediumint unsigned NOT NULL,
  `type` set('legacy','classic','facebook','google') NOT NULL DEFAULT 'legacy',
  `index` varchar(64) NOT NULL DEFAULT '',
  `hash` varchar(64) DEFAULT '',
  `salt` varchar(32) DEFAULT '',
  `active` tinyint unsigned NOT NULL DEFAULT '1',
  UNIQUE KEY `type` (`type`,`index`)
) ENGINE=InnoDB;
INSERT INTO phpbb_users_auth (`user_id`, `type`, `index`, `hash`)
(SELECT user_id, 'legacy', username, user_password FROM phpbb_users WHERE user_id > 0)