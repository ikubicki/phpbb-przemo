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
UPDATE `phpbb_config` SET `config_value` = '1.12.13' WHERE `config_name` = 'version';