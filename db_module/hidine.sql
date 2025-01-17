-- Create add_on
INSERT INTO `add_ons` (`id`, `add_on_name`, `unique_name`, `version`, `installed_at`, `update_at`, `purchase_code`, `module_folder_name`, `project_id`) VALUES (26, 'Hidden Interest Explorer', 'hidden_interest_explorer', '1.7', NULL, NULL, '', 'hidden_interest_explorer', 1013);

-- Create module
INSERT INTO `modules` (`id`, `module_name`, `add_ons_id`, `extra_text`, `limit_enabled`, `bulk_limit_enabled`, `deleted`) VALUES (3003, 'Hidden Interest Explorer', 26, '', '0', '0', '0');

-- Add column to users table
ALTER TABLE `users` ADD `interest` int(1) NOT NULL default '0';
