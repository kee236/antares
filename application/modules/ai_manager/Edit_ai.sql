CREATE TABLE IF NOT EXISTS `ai_model_config` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,              -- ระบุผู้ใช้งาน (หรือ admin) ที่ตั้งค่าการใช้งาน AI
  `model_type` ENUM('openai', 'gemini', 'deepseek') NOT NULL, 
  `model_name` VARCHAR(100) NOT NULL,      -- ชื่อของโมเดล เช่น ChatGPT, Gemini 1, DeepSeek AI
  `api_key` VARCHAR(500) NOT NULL,         -- API key สำหรับโมเดลนั้นๆ
  `custom_instructions` TEXT,              -- ข้อความตั้งค่าหรือคำแนะนำ (prompt) พิเศษสำหรับการใช้งาน
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `ai_conversations` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `started_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ended_at` DATETIME DEFAULT NULL,
  `status` ENUM('open','closed') NOT NULL DEFAULT 'open',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ai_messages` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `conversation_id` BIGINT(20) NOT NULL, -- foreign key ไปยัง ai_conversations
  `sender` ENUM('user','ai') NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `conversation_id` (`conversation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ai_prompts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,               -- ชื่อ prompt เช่น "แนะนำสินค้า", "ตอบคำถามทั่วไป"
  `description` TEXT,                         -- คำอธิบายสั้น ๆ ของ prompt
  `content` TEXT NOT NULL,                    -- เนื้อหาของ prompt ที่จะส่งให้กับ AI
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tiktok_config`
ADD COLUMN `api_key` VARCHAR(500) NOT NULL AFTER `app_secret`,
ADD COLUMN `access_token` VARCHAR(500) DEFAULT NULL AFTER `api_key`,
ADD COLUMN `status` ENUM('active','inactive') NOT NULL DEFAULT 'active';

ALTER TABLE `facebook_ex_autoreply`
ADD COLUMN `ai_conversation_id` BIGINT(20) DEFAULT NULL AFTER `auto_comment_reply_count`;