-- Projekti database schema
-- Run against database: projekti
-- Ketu kemi perdor query-t per te krijuar bazen e te dhenave te projektit
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- contact_messages
-- ----------------------------
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `products_created_by` (`created_by`),
  KEY `products_updated_by` (`updated_by`),
  CONSTRAINT `products_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `news_created_by` (`created_by`),
  KEY `news_updated_by` (`updated_by`),
  CONSTRAINT `news_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `news_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- slider
-- ----------------------------
DROP TABLE IF EXISTS `slider`;
CREATE TABLE `slider` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(500) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- site_content (key-value for Home/About text blocks)
-- ----------------------------
DROP TABLE IF EXISTS `site_content`;
CREATE TABLE `site_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_key` varchar(100) NOT NULL,
  `content_value` text,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_key` (`content_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- team_members (About page)
-- ----------------------------
DROP TABLE IF EXISTS `team_members`;
CREATE TABLE `team_members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- jobs (Home page listings)
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- Seed: site content for Home and About (optional - run if you want default content)
INSERT IGNORE INTO site_content (content_key, content_value) VALUES
  ('about_intro', 'Ne jemi një platformë inovative që lidh punëkërkuesit me punëdhënësit, duke e bërë gjetjen e punës më të lehtë dhe më të shpejtë. Qëllimi ynë është të ofrojmë mundësi të barabarta për të gjithë dhe të mbështesim zhvillimin profesional të përdoruesve tanë.'),
  ('home_slogan_line1', 'PUNË QË TË PËRSHTATET,'),
  ('home_slogan_line2', 'MUNDËSI QË RRIT.'),
  ('home_quote', 'Gjej punën tënde të ëndrrave, shpejt dhe lehtë! Shfleto oferta, krijo profilin tënd profesional dhe apliko me një klikim!');

-- Seed: team members for About page (images in assets/images/)
INSERT IGNORE INTO team_members (name, image, sort_order) VALUES
  ('Stina Bytyqi', '19222.jpg', 0),
  ('Vlera Zogjani', '2431.jpg', 1),
  ('Elsa Canolli', '93435.jpg', 2),
  ('Vesa Kadriu', '1328.jpg', 3);

-- Seed: sample jobs for Home (optional)
INSERT IGNORE INTO jobs (title, company, location, sort_order) VALUES
  ('Frontend Development', 'BrandingX', 'Pejton, Prishtinë', 0),
  ('Full Stack Developer', 'Raiffeisen Tech Kosovo', 'Dardani, Prishtinë', 1),
  ('Open Source Interactive Developer', 'KEN CREATIVE', 'Veterrnik, Prishtinë', 2),
  ('Menaxher Marketingu', 'Creative Marketing Agency', 'Bregu i Diellit, Prishtinë', 3),
  ('Dizajner Grafik', 'Tactica', 'Tophane, Prishtinë', 4),
  ('Specialist IT', 'Growzillas', 'Arbëri, Prishtinë', 5);

-- Admin user: run once (password: admin123) - change in production
-- INSERT INTO users (name, email, password, role) VALUES ('Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
