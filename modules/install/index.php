<?php
if (!defined('FLUX_ROOT')) exit;

require_once 'Flux/Installer/SchemaPermissionError.php';

// Helper: Ensure all FluxCP Core, Charmap, and custom CMS tables exist with complete schemas
if (!function_exists('installCustomCmsTables')) {
	function installCustomCmsTables($server, $theme = 'celestial') {
		if (!$server || !$server->connection) return;
		$db = $server->loginDatabase;
		$charDb = !empty($server->charMapServers[0]->charMapDatabase) ? $server->charMapServers[0]->charMapDatabase : $db;

		// 1. cp_navigation
		$navSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_navigation` (
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
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($navSql)->execute(); } catch (Exception $e) {}

		// Ensure columns created_at, updated_at, title exist on cp_navigation
		try {
			$colsNav = array(
				'title' => "ALTER TABLE {$db}.`cp_navigation` ADD COLUMN `title` varchar(64) DEFAULT NULL AFTER `name`",
				'created_at' => "ALTER TABLE {$db}.`cp_navigation` ADD COLUMN `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'updated_at' => "ALTER TABLE {$db}.`cp_navigation` ADD COLUMN `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
			);
			foreach ($colsNav as $c => $alterSql) {
				$chk = $server->connection->getStatement("SHOW COLUMNS FROM {$db}.cp_navigation LIKE '$c'");
				$chk->execute();
				if (!$chk->fetch()) {
					$server->connection->getStatement($alterSql)->execute();
				}
			}
			// Sync name <-> title
			$server->connection->getStatement("UPDATE {$db}.`cp_navigation` SET `title` = `name` WHERE (`title` IS NULL OR `title` = '') AND `name` IS NOT NULL AND `name` != ''")->execute();
			$server->connection->getStatement("UPDATE {$db}.`cp_navigation` SET `name` = `title` WHERE (`name` IS NULL OR `name` = '') AND `title` IS NOT NULL AND `title` != ''")->execute();
		} catch (Exception $e) {}

		// Seed cp_navigation if empty
		try {
			$chkNav = $server->connection->getStatement("SELECT COUNT(*) FROM {$db}.cp_navigation");
			$chkNav->execute();
			if ($chkNav->fetchColumn() == 0) {
				$seedNav = "INSERT INTO {$db}.cp_navigation (`name`, `title`, `url_val`, `url_type`, `location`, `sort_order`, `is_active`) VALUES
					('Home', 'Home', 'main/index', 'internal', 'main', 1, 1),
					('Downloads', 'Downloads', 'main/downloads', 'internal', 'main', 2, 1),
					('Rankings', 'Rankings', 'ranking/character', 'internal', 'main', 3, 1),
					('WoE', 'War of Emperium', 'woe/index', 'internal', 'main', 4, 1),
					('Information', 'Information', 'server/info', 'internal', 'main', 5, 1),
					('Donations', 'Donations', 'donate/index', 'internal', 'main', 6, 1),
					('Rules', 'Rules', 'pages/content/rules', 'internal', 'footer', 1, 1),
					('Terms of Service', 'Terms of Service', 'service/tos', 'internal', 'footer', 2, 1),
					('Item Shop', 'Item Shop', 'purchase/index', 'internal', 'footer', 3, 1)";
				$server->connection->getStatement($seedNav)->execute();
			}
		} catch (Exception $e) {}

		// 2. cp_downloads
		$dlSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_downloads` (
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
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($dlSql)->execute(); } catch (Exception $e) {}

		// Seed cp_downloads if empty
		try {
			$chkDl = $server->connection->getStatement("SELECT COUNT(*) FROM {$db}.cp_downloads");
			$chkDl->execute();
			if ($chkDl->fetchColumn() == 0) {
				$seedDl = "INSERT INTO {$db}.cp_downloads (`title`, `category`, `description`, `version`, `file_size`, `url_mirror1`, `url_mirror2`, `url_mirror3`, `display_order`, `status`) VALUES
					('Full Game Client (Recommended)', 'Full Client', 'Complete standalone client pre-patched with all sprites, maps, and music.', 'v2.0', '2.8 GB', 'https://mega.nz/', 'https://drive.google.com/', NULL, 1, 'published'),
					('Lite Client Installer', 'Lite Client', 'Small archive containing GRF and data files. Requires clean RO directory.', 'v2.0', '350 MB', 'https://drive.google.com/', 'https://mediafire.com/', NULL, 2, 'published'),
					('Manual Patch Cumulative', 'Manual Patch', 'Manual patch for adventurers experiencing auto-patch problems.', 'v2.0.1', '45 MB', 'https://drive.google.com/', NULL, NULL, 3, 'published')";
				$server->connection->getStatement($seedDl)->execute();
			}
		} catch (Exception $e) {}

		// 3. cp_commands (in both $db and $charDb)
		try {
			$server->connection->getStatement("CREATE TABLE IF NOT EXISTS {$db}.`cp_commands` (`id` int(6) NOT NULL AUTO_INCREMENT, `command` varchar(128) NOT NULL DEFAULT '0', `issuer` varchar(32) NOT NULL DEFAULT '0', `account_id` int(12) NOT NULL DEFAULT '0', `done` int(1) NOT NULL DEFAULT '0', `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4")->execute();
			if ($charDb !== $db) {
				$server->connection->getStatement("CREATE TABLE IF NOT EXISTS {$charDb}.`cp_commands` (`id` int(6) NOT NULL AUTO_INCREMENT, `command` varchar(128) NOT NULL DEFAULT '0', `issuer` varchar(32) NOT NULL DEFAULT '0', `account_id` int(12) NOT NULL DEFAULT '0', `done` int(1) NOT NULL DEFAULT '0', `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4")->execute();
			}
		} catch (Exception $e) {}

		// 4. cp_cmsnews
		$newsSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_cmsnews` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) NOT NULL,
		  `body` text NOT NULL,
		  `link` varchar(255) NOT NULL DEFAULT '',
		  `author` varchar(100) NOT NULL,
		  `created` datetime DEFAULT CURRENT_TIMESTAMP,
		  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `category` varchar(50) DEFAULT 'General',
		  `status` enum('draft','published','archived') DEFAULT 'published',
		  `is_pinned` tinyint(1) DEFAULT 0,
		  `featured_image` varchar(255) DEFAULT NULL,
		  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($newsSql)->execute(); } catch (Exception $e) {}

		// Ensure all extended columns exist on cp_cmsnews
		$columnsToAdd = array(
			'category' => "ALTER TABLE {$db}.`cp_cmsnews` ADD COLUMN `category` varchar(50) DEFAULT 'General'",
			'status' => "ALTER TABLE {$db}.`cp_cmsnews` ADD COLUMN `status` enum('draft','published','archived') DEFAULT 'published'",
			'is_pinned' => "ALTER TABLE {$db}.`cp_cmsnews` ADD COLUMN `is_pinned` tinyint(1) DEFAULT 0",
			'featured_image' => "ALTER TABLE {$db}.`cp_cmsnews` ADD COLUMN `featured_image` varchar(255) DEFAULT NULL",
			'published_at' => "ALTER TABLE {$db}.`cp_cmsnews` ADD COLUMN `published_at` datetime DEFAULT CURRENT_TIMESTAMP"
		);
		foreach ($columnsToAdd as $col => $sql) {
			try {
				$cCheck = $server->connection->getStatement("SHOW COLUMNS FROM {$db}.cp_cmsnews LIKE '$col'");
				$cCheck->execute();
				if (!$cCheck->fetch()) {
					$server->connection->getStatement($sql)->execute();
				}
			} catch (Exception $e) {}
		}

		// Seed initial welcome news if empty
		try {
			$chkNews = $server->connection->getStatement("SELECT COUNT(*) FROM {$db}.cp_cmsnews");
			$chkNews->execute();
			if ($chkNews->fetchColumn() == 0) {
				$welcomeTitle = ($theme === 'celestial') ? 'Welcome to Celestial Chronicle!' : 'Welcome to Eclipse Realm!';
				$welcomeBody = ($theme === 'celestial') 
					? '<p>Welcome to our celestial anime-fantasy realm! Explore skyward dungeons, conquer castles, and write your chronicle.</p>' 
					: '<p>Welcome to the ultimate dark fantasy Ragnarok Online experience. Forge your freedom in high-stakes PvP, WoE, and MVP hunts.</p>';
				$seedNews = "INSERT INTO {$db}.cp_cmsnews (`title`, `body`, `link`, `author`, `created`, `modified`, `category`, `is_pinned`, `status`, `published_at`) VALUES (?, ?, '', 'Administration', NOW(), NOW(), 'Announcement', 1, 'published', NOW())";
				$server->connection->getStatement($seedNews)->execute(array($welcomeTitle, $welcomeBody));
			}
		} catch (Exception $e) {}

		// 5. cp_cmssettings
		$settingsSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_cmssettings` (
		  `name` varchar(100) NOT NULL,
		  `value` mediumtext,
		  PRIMARY KEY (`name`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($settingsSql)->execute(); } catch (Exception $e) {}
		try { $server->connection->getStatement("ALTER TABLE {$db}.`cp_cmssettings` MODIFY COLUMN `value` MEDIUMTEXT")->execute(); } catch (Exception $e) {}

		// 6. cp_cmspages
		$pagesSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_cmspages` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) NOT NULL,
		  `body` mediumtext NOT NULL,
		  `path` varchar(100) NOT NULL,
		  `status` varchar(20) NOT NULL DEFAULT 'published',
		  `meta_description` varchar(255) DEFAULT NULL,
		  `meta_keywords` varchar(255) DEFAULT NULL,
		  `template` varchar(50) NOT NULL DEFAULT 'default',
		  `featured_image` varchar(255) DEFAULT NULL,
		  `sort_order` int(11) NOT NULL DEFAULT 0,
		  `is_nav` tinyint(1) NOT NULL DEFAULT 0,
		  `parent_id` int(11) NOT NULL DEFAULT 0,
		  `min_group_level` int(11) NOT NULL DEFAULT 0,
		  `published_at` datetime DEFAULT NULL,
		  `author` varchar(100) NOT NULL DEFAULT 'Staff',
		  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `path` (`path`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($pagesSql)->execute(); } catch (Exception $e) {}

		// Ensure all extended columns exist on cp_cmspages if table already existed
		$pageCols = array(
			'status'           => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `status` varchar(20) NOT NULL DEFAULT 'published' AFTER `title`",
			'meta_description' => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `meta_description` varchar(255) DEFAULT NULL AFTER `body`",
			'meta_keywords'    => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `meta_keywords` varchar(255) DEFAULT NULL AFTER `meta_description`",
			'template'         => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `template` varchar(50) NOT NULL DEFAULT 'default' AFTER `meta_keywords`",
			'featured_image'   => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `featured_image` varchar(255) DEFAULT NULL AFTER `template`",
			'sort_order'       => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `sort_order` int(11) NOT NULL DEFAULT 0 AFTER `featured_image`",
			'is_nav'           => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `is_nav` tinyint(1) NOT NULL DEFAULT 0 AFTER `sort_order`",
			'parent_id'        => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `parent_id` int(11) NOT NULL DEFAULT 0 AFTER `is_nav`",
			'min_group_level'  => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `min_group_level` int(11) NOT NULL DEFAULT 0 AFTER `parent_id`",
			'published_at'     => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `published_at` datetime DEFAULT NULL AFTER `min_group_level`",
			'created_at'       => "ALTER TABLE {$db}.`cp_cmspages` ADD COLUMN `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `published_at`"
		);
		foreach ($pageCols as $pCol => $pSql) {
			try {
				$chk = $server->connection->getStatement("SHOW COLUMNS FROM {$db}.cp_cmspages LIKE '$pCol'");
				$chk->execute();
				if (!$chk->fetch()) {
					$server->connection->getStatement($pSql)->execute();
				}
			} catch (Exception $e) {}
		}

		// Seed default CMS pages if empty
		try {
			$chkPages = $server->connection->getStatement("SELECT COUNT(*) FROM {$db}.cp_cmspages");
			$chkPages->execute();
			if ($chkPages->fetchColumn() == 0) {
				$seedRules = "INSERT INTO {$db}.cp_cmspages (`title`, `body`, `path`, `author`, `created`, `modified`) VALUES
					('Server Rules', '<p>Respect all adventurers and staff members. Third-party automation, botting, and exploitation of game bugs are strictly prohibited.</p>', 'rules', 'Staff', NOW(), NOW()),
					('Frequently Asked Questions', '<p>Find answers to common questions regarding rates, client setup, and discord verification.</p>', 'faq', 'Staff', NOW(), NOW()),
					('Terms of Service', '<p>By participating in this community, you agree to our fair-play policies and community guidelines.</p>', 'terms', 'Staff', NOW(), NOW())";
				$server->connection->getStatement($seedRules)->execute();
			}
		} catch (Exception $e) {}

		// 7. cp_servicedesk, cp_servicedeska, cp_servicedeskcat, cp_servicedesksettings
		$sdSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_servicedesk` (
		  `ticket_id` int(6) NOT NULL AUTO_INCREMENT,
		  `account_id` int(7) NOT NULL,
		  `author` varchar(24) NOT NULL,
		  `subject` varchar(64) NOT NULL,
		  `category` int(3) NOT NULL,
		  `resolved` int(1) NOT NULL DEFAULT 0,
		  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `last_reply` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `ip` varchar(39) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`ticket_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($sdSql)->execute(); } catch (Exception $e) {}

		$sdaSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_servicedeska` (
		  `action_id` int(6) NOT NULL AUTO_INCREMENT,
		  `ticket_id` int(6) NOT NULL,
		  `author` varchar(24) NOT NULL,
		  `action` int(2) NOT NULL,
		  `body` text NOT NULL,
		  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `ip` varchar(39) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`action_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($sdaSql)->execute(); } catch (Exception $e) {}

		$sdcSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_servicedeskcat` (
		  `cat_id` int(3) NOT NULL AUTO_INCREMENT,
		  `name` varchar(32) NOT NULL,
		  `display` int(1) NOT NULL DEFAULT 1,
		  PRIMARY KEY (`cat_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($sdcSql)->execute(); } catch (Exception $e) {}

		$sdsSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_servicedesksettings` (
		  `account_id` int(7) NOT NULL,
		  `account_name` varchar(32) NOT NULL,
		  `notify` int(1) NOT NULL DEFAULT 1,
		  `reopen` int(1) NOT NULL DEFAULT 1,
		  PRIMARY KEY (`account_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($sdsSql)->execute(); } catch (Exception $e) {}

		// Seed service desk categories if empty
		try {
			$chkSdc = $server->connection->getStatement("SELECT COUNT(*) FROM {$db}.cp_servicedeskcat");
			$chkSdc->execute();
			if ($chkSdc->fetchColumn() == 0) {
				$seedCat = "INSERT INTO {$db}.cp_servicedeskcat (`cat_id`, `name`, `display`) VALUES
					(1, 'Account Assistance', 1),
					(2, 'Bug Report & Glitches', 1),
					(3, 'Donations & Credits', 1),
					(4, 'Gameplay & Quest Issues', 1),
					(5, 'Player Grievance & Reports', 1)";
				$server->connection->getStatement($seedCat)->execute();
			}
		} catch (Exception $e) {}

		// 8. Core login tables
		$coreLoginTables = array(
			'cp_credits' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_credits` (`account_id` int(11) unsigned NOT NULL, `balance` int(11) unsigned NOT NULL DEFAULT 0, `last_donation` datetime DEFAULT NULL, PRIMARY KEY (`account_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_banlog' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_banlog` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `account_id` int(11) unsigned NOT NULL, `ban_type` tinyint(3) unsigned NOT NULL, `ban_until` datetime NOT NULL, `ban_date` datetime NOT NULL, `ban_reason` text NOT NULL, `banned_by` int(11) unsigned NOT NULL, PRIMARY KEY (`id`), KEY `account_id` (`account_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_createlog' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_createlog` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `account_id` int(11) unsigned NOT NULL, `reg_date` datetime NOT NULL, `reg_ip` varchar(39) NOT NULL, PRIMARY KEY (`id`), KEY `account_id` (`account_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_emailchange' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_emailchange` (`id` int(11) NOT NULL AUTO_INCREMENT, `code` varchar(32) NOT NULL, `account_id` int(11) unsigned NOT NULL, `old_email` varchar(39) NOT NULL, `new_email` varchar(39) NOT NULL, `request_date` datetime NOT NULL, `request_ip` varchar(39) NOT NULL, `change_date` datetime DEFAULT NULL, `change_ip` varchar(39) DEFAULT NULL, PRIMARY KEY (`id`), UNIQUE KEY `code` (`code`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_ipbanlog' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_ipbanlog` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `ip_address` varchar(39) NOT NULL, `ban_date` datetime NOT NULL, `ban_reason` text NOT NULL, `banned_by` int(11) unsigned NOT NULL, PRIMARY KEY (`id`), KEY `ip_address` (`ip_address`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_loginlog' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_loginlog` (`id` int(11) NOT NULL AUTO_INCREMENT, `account_id` int(10) DEFAULT NULL, `user` varchar(23) NOT NULL, `pass` varchar(32) NOT NULL, `ip` varchar(39) NOT NULL, `login_date` datetime NOT NULL, `status` varchar(20) NOT NULL, PRIMARY KEY (`id`), KEY `account_id` (`account_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_loginprefs' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_loginprefs` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `account_id` int(11) unsigned NOT NULL, `name` varchar(32) NOT NULL, `value` text, PRIMARY KEY (`id`), UNIQUE KEY `account_pref` (`account_id`,`name`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_pwchange' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_pwchange` (`id` int(11) NOT NULL AUTO_INCREMENT, `account_id` int(10) NOT NULL, `change_date` datetime NOT NULL, `change_ip` varchar(39) NOT NULL, PRIMARY KEY (`id`), KEY `account_id` (`account_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_resetpass' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_resetpass` (`id` int(11) NOT NULL AUTO_INCREMENT, `code` varchar(32) NOT NULL, `account_id` int(11) unsigned NOT NULL, `request_date` datetime NOT NULL, `request_ip` varchar(39) NOT NULL, `reset_date` datetime DEFAULT NULL, `reset_ip` varchar(39) DEFAULT NULL, PRIMARY KEY (`id`), UNIQUE KEY `code` (`code`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_trusted' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_trusted` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `account_id` int(11) unsigned NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `account_id` (`account_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_txnlog' => "CREATE TABLE IF NOT EXISTS {$db}.`cp_txnlog` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `account_id` int(11) unsigned NOT NULL, `txn_type` varchar(20) NOT NULL, `txn_id` varchar(64) DEFAULT NULL, `payment_date` datetime NOT NULL, `payment_status` varchar(20) NOT NULL, `mc_gross` decimal(10,2) NOT NULL, `mc_fee` decimal(10,2) NOT NULL, `payer_email` varchar(128) NOT NULL, `credits` int(11) unsigned NOT NULL, `referrer_id` varchar(13) DEFAULT NULL, `address_status` varchar(11) DEFAULT NULL, PRIMARY KEY (`id`), KEY `account_id` (`account_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
		);
		foreach ($coreLoginTables as $tName => $tSql) {
			try { $server->connection->getStatement($tSql)->execute(); } catch (Exception $e) {}
		}

		// 9. Core charmap tables (in $charDb and $db)
		$coreCharmapTables = array(
			'cp_charprefs' => "CREATE TABLE IF NOT EXISTS `cp_charprefs` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `account_id` int(11) unsigned NOT NULL, `char_id` int(11) unsigned NOT NULL, `name` varchar(32) NOT NULL, `value` text, PRIMARY KEY (`id`), KEY `account_id` (`account_id`,`char_id`), KEY `char_id` (`char_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_itemdesc' => "CREATE TABLE IF NOT EXISTS `cp_itemdesc` (`itemid` int(10) unsigned NOT NULL AUTO_INCREMENT, `itemdesc` text NOT NULL, PRIMARY KEY (`itemid`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_itemshop' => "CREATE TABLE IF NOT EXISTS `cp_itemshop` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `nameid` int(11) unsigned NOT NULL, `quantity` smallint(5) unsigned NOT NULL DEFAULT 1, `cost` int(11) unsigned NOT NULL DEFAULT 0, `info` text, `category` varchar(50) DEFAULT 'General', `use_existing` tinyint(1) NOT NULL DEFAULT 0, `stack` tinyint(1) NOT NULL DEFAULT 1, PRIMARY KEY (`id`), KEY `nameid` (`nameid`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_onlinepeak' => "CREATE TABLE IF NOT EXISTS `cp_onlinepeak` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `users` int(10) unsigned NOT NULL, `record_date` datetime NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_redeemlog' => "CREATE TABLE IF NOT EXISTS `cp_redeemlog` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `nameid` int(11) unsigned NOT NULL, `account_id` int(11) unsigned NOT NULL, `char_id` int(11) unsigned NOT NULL, `redeem_date` datetime NOT NULL, `cost` int(11) unsigned NOT NULL, PRIMARY KEY (`id`), KEY `nameid` (`nameid`,`account_id`,`char_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			'cp_xferlog' => "CREATE TABLE IF NOT EXISTS `cp_xferlog` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `from_account_id` int(10) unsigned NOT NULL, `target_account_id` int(10) unsigned NOT NULL, `target_char_id` int(10) unsigned NOT NULL, `amount` int(10) unsigned NOT NULL, `transfer_date` datetime NOT NULL, PRIMARY KEY (`id`), KEY `from_account_id` (`from_account_id`,`target_account_id`,`target_char_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
		);
		foreach ($coreCharmapTables as $tName => $tSql) {
			try { $server->connection->getStatement("USE `{$charDb}`")->execute(); $server->connection->getStatement($tSql)->execute(); } catch (Exception $e) {}
			if ($charDb !== $db) {
				try { $server->connection->getStatement("USE `{$db}`")->execute(); $server->connection->getStatement($tSql)->execute(); } catch (Exception $e) {}
			}
		}
	}
}

// Force dedicated installer theme
Flux::config('DebugMode', false);
Flux::config('ThemeName', array('installer'));

$title = 'Installation & Setup Wizard';
$currentStep = (int)($params->get('step') ?: 1);

// Step 0: Logout / Lock installer action
if ($params->get('logout')) {
	$session->setInstallerAuthData(false);
	$this->redirect($this->url('install', 'index', array('step' => 1)));
}

// System Requirements Definition
$phpRequired = '7.3.0';
$phpRecommended = '8.0.0';
$phpVersion = PHP_VERSION;
$phpOk = version_compare($phpVersion, $phpRequired, '>=');

// Required Extensions Check
$requiredExtensions = array(
	'pdo'        => 'PHP Data Objects (Database connection layer)',
	'pdo_mysql'  => 'MySQL Driver for PDO',
	'mysqli'     => 'MySQL Improved Extension',
	'curl'       => 'Client URL Library (External APIs & updates)',
	'gd'         => 'GD Graphics Library (Emblems, sprites & captcha)',
	'mbstring'   => 'Multibyte String Functions (UTF-8 encoding)',
	'xml'        => 'XML Parser',
	'xmlreader'  => 'XMLReader Stream Parser',
	'openssl'    => 'OpenSSL Cryptography (Session security & tokens)'
);

$extsResults = array();
$extsOk = true;
foreach ($requiredExtensions as $extKey => $extDesc) {
	$isLoaded = extension_loaded($extKey);
	$extsResults[$extKey] = array(
		'desc' => $extDesc,
		'loaded' => $isLoaded
	);
	if (!$isLoaded) {
		$extsOk = false;
	}
}

// Filesystem Permissions Check
$permissionsChecks = array(
	FLUX_DATA_DIR.'/logs'     => 'Log and schema migration storage',
	FLUX_DATA_DIR.'/itemshop' => 'Item shop image uploads',
	FLUX_DATA_DIR.'/tmp'      => 'Temporary cache storage'
);

$dirsResults = array();
$dirsOk = true;
foreach ($permissionsChecks as $path => $desc) {
	$realP = realpath($path) ?: $path;
	if (!file_exists($realP)) {
		@mkdir($realP, 0777, true);
	}
	$isWritable = is_dir($realP) && is_writable($realP);
	// On Windows, test actual file creation if is_writable returns false
	if (!$isWritable && is_dir($realP)) {
		$testFile = rtrim($realP, '/\\') . '/.write_test';
		if (@file_put_contents($testFile, 'test') !== false) {
			@unlink($testFile);
			$isWritable = true;
		}
	}
	$dirsResults[$path] = array(
		'real' => $realP,
		'desc' => $desc,
		'writable' => $isWritable
	);
	if (!$isWritable) {
		$dirsOk = false;
	}
}

// Web Path Detection
$detectedBaseURI = (string)(Flux::config('DetectedBaseURI') !== null ? Flux::config('DetectedBaseURI') : ((php_sapi_name() !== 'cli' && isset($_SERVER['SCRIPT_NAME'])) ? (dirname($_SERVER['SCRIPT_NAME']) !== '/' && dirname($_SERVER['SCRIPT_NAME']) !== '\\' ? rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') : '') : ''));
$configuredBaseURI = (string)(Flux::config('OriginalConfiguredBaseURI') !== null ? Flux::config('OriginalConfiguredBaseURI') : (Flux::config('BaseURI') === '/' ? '' : rtrim((string)Flux::config('BaseURI'), '/')));
$pathMismatch = Flux::config('PathMismatch') !== null ? (bool)Flux::config('PathMismatch') : ($detectedBaseURI !== $configuredBaseURI);
$curServerAddress = (string)Flux::config('ServerAddress');

// Handle Save Web Path in Step 1
if ($params->get('save_app_path')) {
	$newUri = trim((string)$params->get('app_base_uri'));
	$cleanUri = ($newUri === '/' || $newUri === '') ? '' : '/' . trim($newUri, '/');
	$newHost = trim((string)$params->get('app_server_address')) ?: 'localhost';

	$appConfigFile = FLUX_CONFIG_DIR . '/application.php';
	if (file_exists($appConfigFile)) {
		$appContent = file_get_contents($appConfigFile);
		$appContent = preg_replace("/('BaseURI'\s*=>\s*).*?,/", "$1'{$cleanUri}',", $appContent);
		$appContent = preg_replace("/('ServerAddress'\s*=>\s*).*?,/", "$1'{$newHost}',", $appContent);
		file_put_contents($appConfigFile, $appContent);
		Flux::config('BaseURI', $cleanUri);
		Flux::config('ServerAddress', $newHost);
	}
	$session->setMessageData("Web Path successfully synchronized with config/application.php!");
	$this->redirect($this->url('install', 'index', array('step' => 1)));
}

// MySQL Database Connection Check
$serverNames = array_keys(Flux::$loginAthenaGroupRegistry);
$server = !empty($serverNames) ? Flux::$loginAthenaGroupRegistry[$serverNames[0]] : null;
$dbConnected = false;
$mysqlVersion = 'Unknown';
$mysqlUser = 'Unknown';

// Load servers.php config for MySQL form defaults
$serversConfigFile = FLUX_CONFIG_DIR . '/servers.php';
$serversCfg = @include $serversConfigFile;
$curServer = is_array($serversCfg) && !empty($serversCfg[0]) ? $serversCfg[0] : array();
$curHost = $curServer['DbConfig']['Hostname'] ?? '127.0.0.1';
$curPort = $curServer['DbConfig']['Port'] ?? 3306;
$curUser = $curServer['DbConfig']['Username'] ?? 'root';
$curPass = $curServer['DbConfig']['Password'] ?? '';
$curDb   = $curServer['DbConfig']['Database'] ?? 'freynix';
$curServerName = $curServer['ServerName'] ?? 'Freynix Ragnarok Online';

if ($server && $server->connection) {
	try {
		$sth = $server->connection->getStatement("SELECT VERSION() AS mysql_version, CURRENT_USER() AS mysql_user");
		$sth->execute();
		$row = $sth->fetch();
		if ($row) {
			$dbConnected = true;
			$mysqlVersion = $row->mysql_version;
			$mysqlUser = $row->mysql_user;
		}
	} catch (Exception $e) {
		$dbConnected = false;
	}
}

// Handle MySQL Connection Configuration Form
if ($params->get('save_mysql_config')) {
	$host = trim((string)$params->get('mysql_host'));
	$port = (int)$params->get('mysql_port') ?: 3306;
	$user = trim((string)$params->get('mysql_user'));
	$pass = (string)$params->get('mysql_pass');
	$db   = trim((string)$params->get('mysql_db'));
	$srvName = trim((string)$params->get('server_name')) ?: 'Freynix Ragnarok Online';

	try {
		$dsn = "mysql:host={$host};port={$port};charset=utf8mb4";
		$testPdo = new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$testPdo->exec("CREATE DATABASE IF NOT EXISTS `{$db}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

		// Check if rAthena login table exists in the target database
		$checkLog = $testPdo->query("SHOW TABLES FROM `{$db}` LIKE 'login'");
		$hasLogTable = ($checkLog && $checkLog->fetch());

		$servers = is_array($serversCfg) && !empty($serversCfg) ? $serversCfg : array(array());
		$servers[0]['ServerName'] = $srvName;
		
		if (!isset($servers[0]['DbConfig'])) $servers[0]['DbConfig'] = array();
		$servers[0]['DbConfig']['Hostname'] = $host;
		$servers[0]['DbConfig']['Port']     = $port;
		$servers[0]['DbConfig']['Username'] = $user;
		$servers[0]['DbConfig']['Password'] = $pass;
		$servers[0]['DbConfig']['Database'] = $db;
		$servers[0]['DbConfig']['Persistent'] = false;

		if (!isset($servers[0]['LogsDbConfig'])) $servers[0]['LogsDbConfig'] = array();
		$servers[0]['LogsDbConfig']['Hostname'] = $host;
		$servers[0]['LogsDbConfig']['Port']     = $port;
		$servers[0]['LogsDbConfig']['Username'] = $user;
		$servers[0]['LogsDbConfig']['Password'] = $pass;
		$servers[0]['LogsDbConfig']['Database'] = $db;
		$servers[0]['LogsDbConfig']['Persistent'] = false;

		if (!isset($servers[0]['WebDbConfig'])) $servers[0]['WebDbConfig'] = array();
		$servers[0]['WebDbConfig']['Hostname'] = $host;
		$servers[0]['WebDbConfig']['Port']     = $port;
		$servers[0]['WebDbConfig']['Username'] = $user;
		$servers[0]['WebDbConfig']['Password'] = $pass;
		$servers[0]['WebDbConfig']['Database'] = $db;
		$servers[0]['WebDbConfig']['Persistent'] = false;

		if (!isset($servers[0]['LoginServer'])) $servers[0]['LoginServer'] = array();
		$servers[0]['LoginServer']['Address'] = $host;
		if (!isset($servers[0]['LoginServer']['Port'])) $servers[0]['LoginServer']['Port'] = 6900;

		if (!isset($servers[0]['CharMapServers'][0])) {
			$servers[0]['CharMapServers'][0] = array();
		}
		$servers[0]['CharMapServers'][0]['ServerName'] = $srvName;
		$servers[0]['CharMapServers'][0]['CharMapDatabase'] = $db;

		if (!isset($servers[0]['CharMapServers'][0]['CharServer']['Address'])) {
			$servers[0]['CharMapServers'][0]['CharServer'] = array('Address' => $host, 'Port' => 6121);
		} else {
			$servers[0]['CharMapServers'][0]['CharServer']['Address'] = $host;
		}

		if (!isset($servers[0]['CharMapServers'][0]['MapServer']['Address'])) {
			$servers[0]['CharMapServers'][0]['MapServer'] = array('Address' => $host, 'Port' => 5121);
		} else {
			$servers[0]['CharMapServers'][0]['MapServer']['Address'] = $host;
		}

		$serversContent = "<?php\nreturn " . var_export($servers, true) . ";\n";
		file_put_contents($serversConfigFile, $serversContent);

		if ($hasLogTable) {
			$session->setMessageData("Database connection established and rAthena 'login' table verified in '{$db}'! Configuration saved.");
		} else {
			$session->setMessageData("Connected to MySQL database '{$db}', but rAthena 'login' table was not found! Please import your rAthena SQL tables.");
		}
		$this->redirect($this->url('install', 'index', array('step' => 1)));
	} catch (Exception $e) {
		$errorMessage = "MySQL Connection Failed: " . $e->getMessage() . ". Please verify host, username, and password.";
	}
}

// rAthena `login` Table Verification
$loginTableExists = false;
$loginRowCount = 0;
if ($dbConnected && $server) {
	try {
		$stLog = $server->connection->getStatement("SHOW TABLES FROM `{$server->loginDatabase}` LIKE 'login'");
		$stLog->execute();
		if ($stLog->fetch()) {
			$loginTableExists = true;
			$stCount = $server->connection->getStatement("SELECT COUNT(*) AS total FROM {$server->loginDatabase}.`login`");
			$stCount->execute();
			$loginRowCount = (int)$stCount->fetchColumn();
		}
	} catch (Exception $e) {
		$loginTableExists = false;
	}
}

// create_login_table handler removed — login table is an rAthena prerequisite

// Core FluxCP & CMS Tables Verification
$cpTablesMissing = false;
if ($dbConnected && $server) {
	try {
		$tblCheck = $server->connection->getStatement("SHOW TABLES FROM `{$server->loginDatabase}` LIKE 'cp_%'");
		$tblCheck->execute();
		$existingTables = $tblCheck->fetchAll(PDO::FETCH_COLUMN);
		$requiredTables = array(
			'cp_credits', 'cp_cmsnews', 'cp_cmssettings', 'cp_navigation',
			'cp_cmspages', 'cp_downloads', 'cp_commands', 'cp_servicedesk',
			'cp_createlog', 'cp_loginlog', 'cp_itemshop'
		);
		foreach ($requiredTables as $reqTbl) {
			if (!in_array($reqTbl, $existingTables)) {
				$cpTablesMissing = true;
				break;
			}
		}
	} catch (Exception $e) {
		$cpTablesMissing = true;
	}
} else {
	$cpTablesMissing = true;
}

// Overall Requirements Gate
$allRequirementsMet = ($phpOk && $extsOk && $dirsOk && $dbConnected && $loginTableExists && !$cpTablesMissing);

// Handle Installer Authentication (Password from config/application.php)
if ($params->get('installer_password')) {
	if ($params->get('installer_password') === Flux::config('InstallerPassword')) {
		$session->setInstallerAuthData(true);
		if ($server) {
			// Auto install all schemas & CMS tables
			try {
				$schemaLogDir = FLUX_DATA_DIR . '/logs/schemas';
				if (file_exists($schemaLogDir)) {
					$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($schemaLogDir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
					foreach ($rii as $file) {
						if ($file->isFile() && $file->getExtension() === 'txt') {
							@unlink($file->getPathname());
						}
					}
				}
				$installer = Flux_Installer::getInstance();
				$installer->updateAll();
				installCustomCmsTables($server);
			} catch (Exception $e) {}
		}
		$session->setMessageData("Installer unlocked successfully!");
		$this->redirect($this->url('install', 'index', array('step' => $allRequirementsMet ? 2 : 1)));
	} else {
		$errorMessage = "Invalid Installer Password. Please verify the 'InstallerPassword' set in config/application.php.";
	}
}

// Handle: Install All FluxCP Schemas & CMS Tables
if ($params->get('install_all_tables') && $dbConnected && $server && $loginTableExists) {
	try {
		// Clean any stale schema log text files so Flux_Installer executes every schema cleanly
		$schemaLogDir = FLUX_DATA_DIR . '/logs/schemas';
		if (file_exists($schemaLogDir)) {
			$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($schemaLogDir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($rii as $file) {
				if ($file->isFile() && $file->getExtension() === 'txt') {
					@unlink($file->getPathname());
				}
			}
		}

		$installer = Flux_Installer::getInstance();
		$installer->updateAll();
		installCustomCmsTables($server);
		$session->setMessageData("FluxCP Core, Charmap, and CMS tables have been installed and verified successfully!");
		$this->redirect($this->url('install', 'index', array('step' => 1)));
	} catch (Exception $e) {
		$errorMessage = "Failed installing tables: " . $e->getMessage();
	}
}

// Enforcement: Cannot enter Step 2 unless authenticated and all requirements met
if ($currentStep === 2) {
	if (!$session->installerAuth) {
		$this->redirect($this->url('install', 'index', array('step' => 1)));
	}
	if (!$allRequirementsMet) {
		$session->setMessageData("You must satisfy all system requirements and have a verified database before proceeding to Step 2.");
		$this->redirect($this->url('install', 'index', array('step' => 1)));
	}
}

// Handle Step 2: Save Server Details & Theme Setup
if ($currentStep === 2 && $params->get('save_server_config')) {
	$chosenTheme = trim((string)$params->get('chosen_theme'));
	if (!in_array($chosenTheme, array('celestial', 'freynix'))) {
		$chosenTheme = 'celestial';
	}

	// Update ThemeName in config/application.php
	$appConfigFile = FLUX_CONFIG_DIR . '/application.php';
	if (file_exists($appConfigFile)) {
		$otherTheme = ($chosenTheme === 'celestial') ? 'freynix' : 'celestial';
		$newThemeArray = "array('{$chosenTheme}', '{$otherTheme}', 'default', 'bootstrap')";
		$appContent = file_get_contents($appConfigFile);
		$appContent = preg_replace("/('ThemeName'\s*=>\s*)array\([^)]+\),/", "$1{$newThemeArray},", $appContent);

		if ($params->get('app_base_uri') !== null) {
			$newUri = trim((string)$params->get('app_base_uri'));
			$cleanUri = ($newUri === '/' || $newUri === '') ? '' : '/' . trim($newUri, '/');
			$appContent = preg_replace("/('BaseURI'\s*=>\s*).*?,/", "$1'{$cleanUri}',", $appContent);
			Flux::config('BaseURI', $cleanUri);
		}
		if ($params->get('app_server_address') !== null) {
			$newHost = trim((string)$params->get('app_server_address')) ?: 'localhost';
			$appContent = preg_replace("/('ServerAddress'\s*=>\s*).*?,/", "$1'{$newHost}',", $appContent);
			Flux::config('ServerAddress', $newHost);
		}
		file_put_contents($appConfigFile, $appContent);
		Flux::config('ThemeName', array($chosenTheme, $otherTheme, 'default', 'bootstrap'));
	}

	// Save CMS Settings to database
	$cfgFields = array(
		'site_title', 'server_name', 'site_slogan', 'site_description', 'site_keywords',
		'server_mode', 'rates_text', 'drop_rates', 'max_base_level', 'max_job_level',
		'hp_status_rates_text', 'hp_status_base_level', 'hp_status_job_level', 'hp_status_mode_text',
		'woe_schedule', 'main_city',
		'hero_headline', 'hero_description', 'hero_subtitle', 'hero_cta_primary_text', 'hero_cta_primary_link',
		'hero_cta_secondary_text', 'hero_cta_secondary_link',
		'download_full_name', 'download_full_url', 'download_full_size', 'download_full_date',
		'download_lite_name', 'download_lite_url', 'download_lite_size', 'download_lite_date',
		'discord_url', 'hp_discord_url', 'facebook_url', 'hp_facebook_url', 'youtube_url', 'contact_email', 'support_email',
		'footer_text', 'footer_disclaimer', 'site_logo_url'
	);

	if ($server) {
		// Ensure column is MEDIUMTEXT so long strings (descriptions, hero texts, etc.) never truncate
		try {
			$server->connection->getStatement("ALTER TABLE {$server->loginDatabase}.`cp_cmssettings` MODIFY COLUMN `value` MEDIUMTEXT")->execute();
		} catch (Exception $e) {}

		$insertSql = "INSERT INTO {$server->loginDatabase}.cp_cmssettings (`name`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)";
		$insertSth = $server->connection->getStatement($insertSql);

		foreach ($cfgFields as $field) {
			$val = $params->get($field);
			if ($val !== null) {
				$insertSth->execute(array($field, trim($val)));
			}
		}

		$configuredName = trim($params->get('server_name') ?: $params->get('site_title') ?: 'Freynix RO');
		$insertSth->execute(array('server_name', $configuredName));
		$insertSth->execute(array('site_title', $configuredName));
		$insertSth->execute(array('active_theme', $chosenTheme));

		// Ensure all custom CMS tables and seed data are ready
		installCustomCmsTables($server, $chosenTheme);
	}

	// Complete installation session and redirect to main page
	$session->setInstallerAuthData(false);
	$session->setThemeData($chosenTheme);
	$session->setMessageData("Congratulations! Server installation and configuration are complete. Welcome to {$configuredName}!");
	$this->redirect($this->url('main', 'index'));
}

// Fetch existing CMS settings to populate Step 2 form
$cmsSettings = array();
if ($server) {
	try {
		$sthSet = $server->connection->getStatement("SELECT `name`, `value` FROM {$server->loginDatabase}.cp_cmssettings");
		$sthSet->execute();
		while ($row = $sthSet->fetch()) {
			$cmsSettings[$row->name] = $row->value;
		}
	} catch (Exception $e) {}
}
