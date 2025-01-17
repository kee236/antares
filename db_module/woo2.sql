-- Create add_on
INSERT INTO `add_ons` (`id`, `add_on_name`, `unique_name`, `version`, `installed_at`, `update_at`, `purchase_code`, `module_folder_name`, `project_id`) VALUES (35, 'WooCommerce Abandoned Cart Recovery ', 'woocommerce_abandoned_cart', '1.0.3', NULL, NULL, '', 'woocommerce_abandoned_cart', 33);

-- Create module
INSERT INTO `modules` (`id`, `module_name`, `add_ons_id`, `extra_text`, `limit_enabled`, `bulk_limit_enabled`, `deleted`) VALUES (266, 'WooCommerce Abandoned Cart Recovery', 35, '', '1', '0', '0');

-- Create table for WooCommerce drip campaigns
CREATE TABLE IF NOT EXISTS `woocommerce_drip_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `woocommerce_config_id` int(11) NOT NULL,
  `engagement_table_id` int(11) NOT NULL,
  `sms_api_id` int(11) NOT NULL,
  `sms_content` longtext NOT NULL,
  `email_api_id` int(11) NOT NULL,
  `email_content` longtext NOT NULL,
  `email_subject` varchar(250) NOT NULL,
  `configure_email_table` varchar(100) NOT NULL,
  `verification_code` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create table for WooCommerce drip campaign webhook calls
CREATE TABLE IF NOT EXISTS `woocommerce_drip_campaign_webhook_call` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `woocommerce_drip_campaign_id` int(11) NOT NULL,
  `wc_session_unique_id` varchar(250) NOT NULL,
  `wc_first_name` varchar(250) NOT NULL,
  `wc_last_name` varchar(250) NOT NULL,
  `wc_email` varchar(250) NOT NULL,
  `wc_mobile` varchar(250) NOT NULL,
  `check_box_unique_id` varchar(250) NOT NULL,
  `cart_info` longtext NOT NULL,
  `initial_date` datetime NOT NULL,
  `last_updated_at` datetime NOT NULL,
  `cart_url` text NOT NULL,
  `checkout_url` text NOT NULL,
  `checkout_at` datetime NOT NULL,
  `checkout_amount` varchar(20) NOT NULL,
  `checkout_country` varchar(250) NOT NULL,
  `checkout_currency` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wc_session_unique_id` (`wc_session_unique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create table for WooCommerce drip campaign reports
CREATE TABLE IF NOT EXISTS `woocommerce_drip_campaign_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `woocommerce_drip_campaign_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wc_session_unique_id` varchar(250) NOT NULL,
  `wc_first_name` varchar(250) NOT NULL,
  `wc_last_name` varchar(250) NOT NULL,
  `wc_email` varchar(250) NOT NULL,
  `wc_mobile` varchar(250) NOT NULL,
  `subscribe_id` varchar(250) NOT NULL,
  `last_completed_hour` varchar(50) NOT NULL,
  `is_sent` enum('0','1') NOT NULL,
  `sent_at` datetime NOT NULL,
  `sent_response` longtext NOT NULL,
  `last_updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `woocommerce_drip_campaign_id` (`woocommerce_drip_campaign_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
