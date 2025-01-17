CREATE TABLE IF NOT EXISTS `tag_machine_enabled_post_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facebook_rx_fb_user_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page_info_table_id` int(11) NOT NULL,
  `page_id` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_profile` text NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `post_description` longtext NOT NULL,
  `post_created_at` datetime NOT NULL,
  `last_updated_at` datetime NOT NULL,
  `commenter_count` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `facebook_rx_fb_user_info_id` (`facebook_rx_fb_user_info_id`),
  KEY `user_id` (`user_id`),
  KEY `page_info_table_id` (`page_info_table_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `tag_machine_commenter_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_machine_enabled_post_list_id` int(11) NOT NULL,
  `facebook_rx_fb_user_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page_info_table_id` int(11) NOT NULL,
  `page_id` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `last_comment_id` varchar(255) NOT NULL,
  `last_comment_time` datetime NOT NULL,
  `commenter_fb_id` varchar(255) NOT NULL,
  `commenter_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_machine_enabled_post_list_id` (`tag_machine_enabled_post_list_id`),
  KEY `facebook_rx_fb_user_info_id` (`facebook_rx_fb_user_info_id`),
  KEY `user_id` (`user_id`),
  KEY `page_info_table_id` (`page_info_table_id`),
  KEY `post_id` (`post_id`),
  KEY `commenter_fb_id` (`commenter_fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `tag_machine_comment_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_machine_enabled_post_list_id` int(11) NOT NULL,
  `facebook_rx_fb_user_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page_info_table_id` int(11) NOT NULL,
  `page_id` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `comment_id` varchar(255) NOT NULL,
  `comment_text` longtext NOT NULL,
  `commenter_fb_id` varchar(255) NOT NULL,
  `commenter_name` varchar(255) NOT NULL,
  `comment_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_machine_enabled_post_list_id` (`tag_machine_enabled_post_list_id`),
  KEY `facebook_rx_fb_user_info_id` (`facebook_rx_fb_user_info_id`),
  KEY `user_id` (`user_id`),
  KEY `page_info_table_id` (`page_info_table_id`),
  KEY `post_id` (`post_id`),
  KEY `comment_id` (`comment_id`),
  KEY `commenter_fb_id` (`commenter_fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
