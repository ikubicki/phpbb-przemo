ALTER TABLE `phpbb_users` CHANGE `user_avatar` `user_avatar` VARCHAR(255) NULL DEFAULT '';
ALTER TABLE `phpbb_topics` ADD `topic_gallery` TINYINT NOT NULL DEFAULT '0';
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('allow_topic_gallery', '1');
UPDATE `phpbb_config` SET `config_value` = '1.12.14' WHERE `config_name` = 'version';