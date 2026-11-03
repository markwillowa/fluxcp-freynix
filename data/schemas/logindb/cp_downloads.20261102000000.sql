CREATE TABLE IF NOT EXISTS `cp_downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'Full Client',
  `description` text,
  `version` varchar(50) DEFAULT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `url_mirror1` varchar(255) NOT NULL,
  `url_mirror2` varchar(255) DEFAULT NULL,
  `url_mirror3` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'published',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_status` (`category`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

