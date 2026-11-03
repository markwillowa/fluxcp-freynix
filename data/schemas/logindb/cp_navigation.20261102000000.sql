CREATE TABLE IF NOT EXISTS `cp_navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(64) DEFAULT NULL,
  `url_val` varchar(255) NOT NULL DEFAULT '',
  `url_type` enum('internal','external') NOT NULL DEFAULT 'internal',
  `location` enum('main','footer','sidebar') NOT NULL DEFAULT 'main',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `target_blank` tinyint(1) NOT NULL DEFAULT 0,
  `min_group_level` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `location_active` (`location`,`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

