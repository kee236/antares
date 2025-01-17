CREATE TABLE `webview_builder` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `page_id` INT NOT NULL,
  `form_name` VARCHAR(255) NOT NULL,
  `form_title` VARCHAR(255) NOT NULL,
  `canonical_id` VARCHAR(255) NOT NULL,
  `assign_label` VARCHAR(255) DEFAULT NULL,
  `reply_template` INT DEFAULT NULL,
  `form_data` LONGTEXT NOT NULL,
  `inserted_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  `deleted` ENUM('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `messenger_bot_user_custom_form_webview_data` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `subscriber_id` VARCHAR(255) NOT NULL,
  `web_view_form_canonical_id` VARCHAR(255) NOT NULL,
  `data` LONGTEXT NOT NULL,
  `inserted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `web_view_form_canonical_id` (`web_view_form_canonical_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
