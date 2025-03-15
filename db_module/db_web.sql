-- ตารางผู้ใช้งาน (Users)
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','manager','staff') DEFAULT 'staff',
  `status` ENUM('active','inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ตารางสินค้า (Products)
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10, 2) NOT NULL,
  `cost_price` DECIMAL(10, 2),
  `stock` INT DEFAULT 0,
  `category_id` INT,
  `brand_id` INT,
  `status` ENUM('active','inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ตารางคำสั่งซื้อ (Orders)
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `total_amount` DECIMAL(10, 2) NOT NULL,
  `status` ENUM('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  `payment_method` VARCHAR(255),
  `shipping_method` VARCHAR(255),
  `address` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- รายการสินค้าในคำสั่งซื้อ (Order Items)
CREATE TABLE `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT,
  `product_id` INT,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL
);

-- ตาราง AI การตั้งค่า (AI Settings)
CREATE TABLE `ai_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ai_model` ENUM('Dialogflow','OpenAI','Gemini') DEFAULT 'OpenAI',
  `api_key` VARCHAR(255),
  `api_secret` VARCHAR(255),
  `endpoint_url` TEXT,
  `status` ENUM('active','inactive') DEFAULT 'active'
);

-- ตารางการตั้งค่าการชำระเงิน (Payment Settings)
CREATE TABLE `payment_gateways` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `type` ENUM('QRPromptpay','BankTransfer','Stripe','Omise'),
  `api_key` VARCHAR(255),
  `api_secret` VARCHAR(255),
  `qr_code_image` TEXT,
  `status` ENUM('active','inactive') DEFAULT 'active'
);

-- ตารางการขนส่ง (Shipping Methods)
CREATE TABLE `shipping_methods` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `api_connected` ENUM('Kerry','Flash','ThailandPost','Manual') DEFAULT 'Manual',
  `status` ENUM('active','inactive') DEFAULT 'active'
);

-- ตารางกล่องสินค้า (Package Box)
CREATE TABLE `package_boxes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `length` DECIMAL(10,2) NOT NULL,
  `width` DECIMAL(10,2) NOT NULL,
  `height` DECIMAL(10,2) NOT NULL,
  `max_weight` DECIMAL(10,2) NOT NULL
);



-- ผู้ใช้งานตัวอย่าง
INSERT INTO `users` (`name`, `email`, `password`, `role`) 
VALUES ('Admin', 'admin@example.com', '12345678', 'admin');

-- สินค้าตัวอย่าง
INSERT INTO `products` (`name`, `description`, `price`, `cost_price`, `stock`) 
VALUES ('สินค้า A', 'รายละเอียดสินค้า A', 500.00, 300.00, 100);

-- การตั้งค่า AI ตัวอย่าง
INSERT INTO `ai_settings` (`ai_model`, `api_key`, `api_secret`, `endpoint_url`) 
VALUES ('OpenAI', 'sk-xxxxxx', 'secret-xxxx', 'https://api.openai.com/v1/chat');

-- ช่องทางชำระเงินพร้อม QR Code Promptpay
INSERT INTO `payment_gateways` (`name`, `type`, `qr_code_image`) 
VALUES ('บัญชีพร้อมเพย์ กสิกรไทย', 'QRPromptpay', 'uploads/qr_code_kbank.png');

-- วิธีขนส่งตัวอย่าง
INSERT INTO `shipping_methods` (`name`, `price`, `api_connected`) 
VALUES ('Kerry Express', 50.00, 'Kerry');

-- กล่องสินค้า
INSERT INTO `package_boxes` (`name`, `length`, `width`, `height`, `max_weight`)
VALUES ('กล่องมาตรฐาน A', 30.00, 20.00, 15.00, 5.00);