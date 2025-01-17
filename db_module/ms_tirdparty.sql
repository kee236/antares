CREATE TABLE IF NOT EXISTS `messenger_bot_thirdparty_webhook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page_id` varchar(50) NOT NULL,
  `page_name` varchar(250) NOT NULL,
  `webhook_url` text NOT NULL,
  `variable_post` text NOT NULL,
  `added_date` datetime NOT NULL,
  `last_trigger_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `xuser_id_page_id` (`user_id`,`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `messenger_bot_thirdparty_webhook_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `http_code` varchar(10) NOT NULL,
  `webhook_id` int(11) NOT NULL,
  `curl_error` varchar(250) NOT NULL,
  `post_time` datetime NOT NULL,
  `post_data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `messenger_bot_thirdparty_webhook_trigger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webhook_id` int(11) NOT NULL,
  `trigger_option` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `xwebhook_trigger` (`webhook_id`,`trigger_option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `messenger_bot_user_custom_form_webview_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL COMMENT 'page_table_id',
  `subscriber_id` varchar(25) NOT NULL,
  `web_view_form_canonical_id` varchar(50) NOT NULL,
  `data` longtext NOT NULL,
  `inserted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_mbucfwd_web_view_form_canonical_id` (`web_view_form_canonical_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `webview_builder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `canonical_id` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  `assign_label` varchar(11) DEFAULT NULL,
  `reply_template` int(11) DEFAULT NULL,
  `form_name` varchar(200) NOT NULL COMMENT 'This is actually form name for identify in our system',
  `form_title` varchar(200) NOT NULL COMMENT 'The form title that will be shown on top of your form',
  `form_data` text,
  `deleted` enum('0','1') DEFAULT '0',
  `inserted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_key` (`user_id`),
  KEY `canonical_id` (`canonical_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `messenger_bot_user_custom_form_webview_data`
  ADD CONSTRAINT `FK_mbucfwd_web_view_form_canonical_id` FOREIGN KEY (`web_view_form_canonical_id`) REFERENCES `webview_builder` (`canonical_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messenger_bot_user_custom_form_webview_data_ibfk_1` FOREIGN KEY (`web_view_form_canonical_id`) REFERENCES `webview_builder` (`canonical_id`);

ALTER TABLE `webview_builder`
  ADD CONSTRAINT `user_id_key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `webview_builder` CHANGE `assign_label` `assign_label` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `messenger_bot_thirdparty_webhook` ADD INDEX `xuser_id_page_id` (`user_id`, `page_id`);

ALTER TABLE `messenger_bot_thirdparty_webhook_trigger` ADD INDEX `xwebhook_trigger` (`webhook_id`, `trigger_option`);

ALTER TABLE `webview_builder` CHANGE `form_data` `form_data` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
