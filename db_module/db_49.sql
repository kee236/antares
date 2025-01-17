-- Create add_on
INSERT INTO `add_ons` (`id`, `add_on_name`, `unique_name`, `version`, `installed_at`, `update_at`, `purchase_code`, `module_folder_name`, `project_id`) VALUES (28, 'User Input & Custom Fields', 'custom_field_manager', '2.0.1', NULL, NULL, '', 'custom_field_manager', 49);

-- Create module
INSERT INTO `modules` (`id`, `module_name`, `add_ons_id`, `extra_text`, `limit_enabled`, `bulk_limit_enabled`, `deleted`) VALUES (292, 'User Input Flow Campaign', 28, 'month', '1', '0', '0');

-- Create table for flow campaigns
CREATE TABLE IF NOT EXISTS `user_input_flow_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `flow_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_table_id` int(11) NOT NULL,
  `postback_id` varchar(255) NOT NULL,
  `media_type` enum('fb','ig') NOT NULL DEFAULT 'fb',
  `visual_flow_type` enum('flow','general') NOT NULL DEFAULT 'general',
  `unique_id` varchar(25) NOT NULL,
  `visual_flow_campaign_id` int(11) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create table for flow questions
CREATE TABLE IF NOT EXISTS `user_input_flow_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `flow_campaign_id` int(11) NOT NULL,
  `serial_no` int(11) NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('keyboard input','quick replies') NOT NULL DEFAULT 'keyboard input',
  `reply_type` varchar(50) NOT NULL,
  `quick_reply_email` varchar(50) NOT NULL,
  `quick_reply_phone` varchar(10) NOT NULL,
  `multiple_choice_options` text NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `label_ids` varchar(255) NOT NULL,
  `messenger_sequence_id` int(11) NOT NULL,
  `email_phone_sequence_id` int(11) NOT NULL,
  `system_field` varchar(100) NOT NULL,
  `skip_button_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_id` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`flow_campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create table for flow question answers
CREATE TABLE IF NOT EXISTS `user_input_flow_questions_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscriber_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `page_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `flow_campaign_id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `user_answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_message_id` varchar(200) NOT NULL,
  `answer_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscriber_id` (`subscriber_id`,`page_id`,`flow_campaign_id`,`question_id`) USING BTREE,
  KEY `subscriber_id_x` (`subscriber_id`),
  KEY `flow_campaign_id` (`flow_campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert email template
INSERT INTO `email_template_management` (`id`, `title`, `template_type`, `subject`, `message`, `icon`, `tooltip`, `info`) VALUES (NULL, 'New Input Flow Submission Alert', 'input_flow_submission', '#FLOW_NAME# | #SUBSCRIBER_NAME# Has Submitted Input Flow', '#SUBSCRIBER_NAME# has just submitted your Input Flow #FLOW_NAME# with below data. <br/><br/>\r\n#FLOW_DATA#\r\n<br/><br/>\r\nThank you,<br/>\r\n<a href=\"#APP_URL#\">#APP_NAME#</a> Team', 'fab fa-stack-overflow', '#FLOW_NAME#,#SUBSCRIBER_NAME#,#FLOW_DATA#,#APP_URL#,#APP_NAME#', 'Subscriber information received');
