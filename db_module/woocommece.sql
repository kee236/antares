-- Create add_on
INSERT INTO `add_ons` (`id`, `add_on_name`, `unique_name`, `version`, `installed_at`, `update_at`, `purchase_code`, `module_folder_name`, `project_id`) VALUES (37, 'WooCommerce Integration', 'woocommerce_integration', '2.0', NULL, NULL, '', 'woocommerce_integration', 50);

-- Create module
INSERT INTO `modules` (`id`, `module_name`, `add_ons_id`, `extra_text`, `limit_enabled`, `bulk_limit_enabled`, `deleted`) VALUES (293, 'WooCommerce Integration', 37, '', '1', '0', '0');

-- Create table for WooCommerce config
CREATE TABLE IF NOT EXISTS `woocommerce_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `home_url` text NOT NULL,
  `consumer_key` text NOT NULL,
  `consumer_secret` text NOT NULL,
  `currency` varchar(10) NOT NULL,
  `currency_icon` varchar(20) NOT NULL,
  `currency_position` varchar(20) NOT NULL,
  `decimal_point` varchar(10) NOT NULL,
  `thousand_comma` enum('0','1') NOT NULL,
  `attributes` longtext NOT NULL,
  `categories` longtext NOT NULL,
  `last_updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create table for WooCommerce products
CREATE TABLE IF NOT EXISTS `woocommerce_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `woocommerce_config_id` int(11) NOT NULL,
  `wc_product_id` int(11) NOT NULL,
  `slug` text NOT NULL,
  `permalink` text NOT NULL,
  `product_name` text NOT NULL,
  `product_description` longtext NOT NULL,
  `purchase_note` text NOT NULL,
  `original_price` varchar(20) NOT NULL,
  `sell_price` varchar(20) NOT NULL,
  `price_html` text NOT NULL,
  `taxable` enum('0','1') NOT NULL,
  `stock_item` int(11) NOT NULL,
  `thumbnail` text NOT NULL,
  `featured_images` text NOT NULL,
  `sales_count` int(11) NOT NULL,
  `category` text NOT NULL,
  `attribute` text NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` enum('0','1') NOT NULL,
  `on_sale` enum('0','1') NOT NULL,
  `visit_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wc_product_id` (`wc_product_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
