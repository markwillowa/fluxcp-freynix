<?php
if (!defined('FLUX_ROOT')) exit;

require_once 'Flux/Installer/SchemaPermissionError.php';

// Helper: Ensure custom CMS tables and default records exist
if (!function_exists('installCustomCmsTables')) {
	function installCustomCmsTables($server, $theme = 'celestial') {
		if (!$server || !$server->connection) return;
		$db = $server->loginDatabase;

		// 1. Create cp_navigation
		$navSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_navigation` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `parent_id` int(11) NOT NULL DEFAULT 0,
		  `name` varchar(64) NOT NULL,
		  `title` varchar(64) DEFAULT NULL,
		  `url_val` varchar(255) NOT NULL,
		  `url_type` enum('internal','external') NOT NULL DEFAULT 'internal',
		  `location` enum('main','footer','sidebar') NOT NULL DEFAULT 'main',
		  `sort_order` int(11) NOT NULL DEFAULT 0,
		  `is_active` tinyint(1) NOT NULL DEFAULT 1,
		  `target_blank` tinyint(1) NOT NULL DEFAULT 0,
		  `min_group_level` int(11) NOT NULL DEFAULT 0,
		  PRIMARY KEY (`id`),
		  KEY `location_active` (`location`,`is_active`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($navSql)->execute(); } catch (Exception $e) {}

		// Seed cp_navigation if empty
		try {
			$chkNav = $server->connection->getStatement("SELECT COUNT(*) FROM {$db}.cp_navigation");
			$chkNav->execute();
			if ($chkNav->fetchColumn() == 0) {
				$seedNav = "INSERT INTO {$db}.cp_navigation (`name`, `url_val`, `url_type`, `location`, `sort_order`, `is_active`) VALUES
					('Home', 'main/index', 'internal', 'main', 1, 1),
					('Downloads', 'main/downloads', 'internal', 'main', 2, 1),
					('Rankings', 'ranking/character', 'internal', 'main', 3, 1),
					('WoE', 'woe/index', 'internal', 'main', 4, 1),
					('Information', 'server/info', 'internal', 'main', 5, 1),
					('Donations', 'donate/index', 'internal', 'main', 6, 1),
					('Rules', 'pages/content/rules', 'internal', 'footer', 1, 1),
					('Terms of Service', 'service/tos', 'internal', 'footer', 2, 1),
					('Item Shop', 'purchase/index', 'internal', 'footer', 3, 1)";
				$server->connection->getStatement($seedNav)->execute();
			}
		} catch (Exception $e) {}

		// 2. Create or extend cp_cmsnews
		$newsSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_cmsnews` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) NOT NULL,
		  `body` text NOT NULL,
		  `link` varchar(100) DEFAULT '',
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

		// 3. Create cp_cmssettings
		$settingsSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_cmssettings` (
		  `name` varchar(100) NOT NULL,
		  `value` mediumtext,
		  PRIMARY KEY (`name`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($settingsSql)->execute(); } catch (Exception $e) {}

		// Always ensure value is MEDIUMTEXT to prevent 1406 data truncation error
		try {
			$server->connection->getStatement("ALTER TABLE {$db}.`cp_cmssettings` MODIFY COLUMN `value` MEDIUMTEXT")->execute();
		} catch (Exception $e) {}

		// 4. Create cp_cmspages
		$pagesSql = "CREATE TABLE IF NOT EXISTS {$db}.`cp_cmspages` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) NOT NULL,
		  `body` mediumtext NOT NULL,
		  `path` varchar(100) NOT NULL,
		  `author` varchar(100) NOT NULL,
		  `created` datetime NOT NULL,
		  `modified` datetime NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `path` (`path`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		try { $server->connection->getStatement($pagesSql)->execute(); } catch (Exception $e) {}

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
		$requiredTables = array('cp_credits', 'cp_cmsnews', 'cp_cmssettings', 'cp_navigation');
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
		$installer = Flux_Installer::getInstance();
		$installer->updateAll();
		installCustomCmsTables($server);
		$session->setMessageData("FluxCP Core and CMS tables have been installed and verified successfully!");
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
