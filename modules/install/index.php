<?php
if (!defined('FLUX_ROOT')) exit;

require_once 'Flux/Installer/SchemaPermissionError.php';

// Force debug mode off here and use dedicated installer theme.
Flux::config('DebugMode', false);
Flux::config('ThemeName', array('installer'));

// Define minimum requirements.
$requiredExtensions = array(
	'pdo',
	'pdo_mysql',
	'curl',
	'xml',
	'xmlreader',
	'mysqli'
);

$minimumVersionCheck = [
	'php' => [
		'required' => '7.3.0',
		'recommended' => '8.4.0'
	],
	'mysql' => [
		'required' => '5.0.0',
		'recommended' => '8.0.44'
	]
];
$sth = $server->connection->getStatement("SELECT VERSION() AS mysql_version, CURRENT_USER() AS mysql_user");
$sth->execute();
$res = $sth->fetch();

$permissionsChecks = [
	FLUX_DATA_DIR.'/logs'		=> 'log storage',
	FLUX_DATA_DIR.'/itemshop'	=> 'item shop image',
	FLUX_DATA_DIR.'/tmp'		=> 'temporary'
];

$schemasInstalled = false;

if ($session->installerAuth) {
	if ($params->get('logout')) {
		$session->setInstallerAuthData(false);
	}
	else {
		$requiredMySqlVersion = '5.0';

		foreach (Flux::$loginAthenaGroupRegistry as $serverName => $loginAthenaGroup) {
			$sth = $loginAthenaGroup->connection->getStatement("SELECT VERSION() AS mysql_version, CURRENT_USER() AS mysql_user");
			$sth->execute();
			
			$res = $sth->fetch();
			if (!$res || version_compare($res->mysql_version, $requiredMySqlVersion, '<')) {
				$message  = "MySQL version $requiredMySqlVersion or greater is required for Flux.";
				$message .= $res ? " You are running version {$res->mysql_version}" : "You are running an unknown version";
				$message .= " on the server '$serverName'"; 
				throw new Flux_Error($message);
			}
		}

		// Handle MySQL Database Connection & config/servers.php Update
		if ($params->get('save_mysql_config')) {
			$mysqlHost = trim($params->get('mysql_host') ?: '127.0.0.1');
			$mysqlPort = (int)$params->get('mysql_port') ?: 3306;
			$mysqlUser = trim($params->get('mysql_user') ?: 'root');
			$mysqlPass = (string)$params->get('mysql_pass');
			$mysqlDb   = trim($params->get('mysql_db') ?: 'freynix');
			$mysqlServerName = trim($params->get('mysql_server_name') ?: 'Freynix Ragnarok Online');

			try {
				$dsn = "mysql:host={$mysqlHost}" . (!empty($mysqlPort) ? ";port={$mysqlPort}" : "");
				$testPdo = new PDO($dsn, $mysqlUser, $mysqlPass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				$testPdo->exec("CREATE DATABASE IF NOT EXISTS `{$mysqlDb}` CHARACTER SET utf8 COLLATE utf8_general_ci");

				// Generate clean, modern config/servers.php content preserving all required FluxCP sections
				$configFile = FLUX_CONFIG_DIR . '/servers.php';
				$servers = array();
				if (file_exists($configFile)) {
					@copy($configFile, $configFile . '.bak');
					$loaded = @include($configFile);
					if (is_array($loaded)) {
						$servers = $loaded;
					}
				}

				if (empty($servers) || !isset($servers[0])) {
					$servers = array(array());
				}

				$servers[0]['ServerName'] = $mysqlServerName;

				// DbConfig
				if (!isset($servers[0]['DbConfig']) || !is_array($servers[0]['DbConfig'])) $servers[0]['DbConfig'] = array();
				$servers[0]['DbConfig']['Convert'] = 'utf8';
				$servers[0]['DbConfig']['Hostname'] = $mysqlHost;
				if (!empty($mysqlPort) && (int)$mysqlPort !== 3306) {
					$servers[0]['DbConfig']['Port'] = (int)$mysqlPort;
				} else {
					unset($servers[0]['DbConfig']['Port']);
				}
				$servers[0]['DbConfig']['Username'] = $mysqlUser;
				$servers[0]['DbConfig']['Password'] = $mysqlPass;
				$servers[0]['DbConfig']['Database'] = $mysqlDb;
				$servers[0]['DbConfig']['Persistent'] = true;
				$servers[0]['DbConfig']['Timezone'] = null;

				// LogsDbConfig
				if (!isset($servers[0]['LogsDbConfig']) || !is_array($servers[0]['LogsDbConfig'])) $servers[0]['LogsDbConfig'] = array();
				$servers[0]['LogsDbConfig']['Convert'] = 'utf8';
				$servers[0]['LogsDbConfig']['Hostname'] = $mysqlHost;
				if (!empty($mysqlPort) && (int)$mysqlPort !== 3306) {
					$servers[0]['LogsDbConfig']['Port'] = (int)$mysqlPort;
				} else {
					unset($servers[0]['LogsDbConfig']['Port']);
				}
				$servers[0]['LogsDbConfig']['Username'] = $mysqlUser;
				$servers[0]['LogsDbConfig']['Password'] = $mysqlPass;
				$servers[0]['LogsDbConfig']['Database'] = $mysqlDb;
				$servers[0]['LogsDbConfig']['Persistent'] = true;
				$servers[0]['LogsDbConfig']['Timezone'] = null;

				// WebDbConfig
				if (!isset($servers[0]['WebDbConfig']) || !is_array($servers[0]['WebDbConfig'])) $servers[0]['WebDbConfig'] = array();
				$servers[0]['WebDbConfig']['Hostname'] = $mysqlHost;
				if (!empty($mysqlPort) && (int)$mysqlPort !== 3306) {
					$servers[0]['WebDbConfig']['Port'] = (int)$mysqlPort;
				} else {
					unset($servers[0]['WebDbConfig']['Port']);
				}
				$servers[0]['WebDbConfig']['Username'] = $mysqlUser;
				$servers[0]['WebDbConfig']['Password'] = $mysqlPass;
				$servers[0]['WebDbConfig']['Database'] = $mysqlDb;
				$servers[0]['WebDbConfig']['Persistent'] = true;

				// LoginServer
				if (!isset($servers[0]['LoginServer']) || !is_array($servers[0]['LoginServer'])) $servers[0]['LoginServer'] = array();
				$servers[0]['LoginServer']['Address'] = $mysqlHost;
				$servers[0]['LoginServer']['Port'] = !empty($servers[0]['LoginServer']['Port']) ? (int)$servers[0]['LoginServer']['Port'] : 6900;
				$servers[0]['LoginServer']['UseMD5'] = false;
				$servers[0]['LoginServer']['NoCase'] = true;
				$servers[0]['LoginServer']['GroupID'] = 0;

				// CharMapServers
				if (!isset($servers[0]['CharMapServers']) || !is_array($servers[0]['CharMapServers']) || empty($servers[0]['CharMapServers'])) {
					$servers[0]['CharMapServers'] = array(array());
				}
				$servers[0]['CharMapServers'][0]['ServerName'] = $mysqlServerName;
				if (!isset($servers[0]['CharMapServers'][0]['Renewal'])) $servers[0]['CharMapServers'][0]['Renewal'] = false;
				if (!isset($servers[0]['CharMapServers'][0]['MaxCharSlots'])) $servers[0]['CharMapServers'][0]['MaxCharSlots'] = 9;
				if (!isset($servers[0]['CharMapServers'][0]['DateTimezone'])) $servers[0]['CharMapServers'][0]['DateTimezone'] = null;

				if (!isset($servers[0]['CharMapServers'][0]['ExpRates'])) {
					$servers[0]['CharMapServers'][0]['ExpRates'] = array('Base' => 1000, 'Job' => 1000, 'Mvp' => 1000);
				}
				if (!isset($servers[0]['CharMapServers'][0]['DropRates'])) {
					$servers[0]['CharMapServers'][0]['DropRates'] = array('DropRateCap' => 9000, 'Common' => 100, 'CommonBoss' => 100, 'CommonMVP' => 100, 'CommonMin' => 1, 'CommonMax' => 10000, 'Heal' => 100, 'HealBoss' => 100, 'HealMVP' => 100, 'HealMin' => 1, 'HealMax' => 10000, 'Useable' => 100, 'UseableBoss' => 100, 'UseableMVP' => 100, 'UseableMin' => 1, 'UseableMax' => 10000, 'Equip' => 100, 'EquipBoss' => 100, 'EquipMVP' => 100, 'EquipMin' => 1, 'EquipMax' => 10000, 'Card' => 100, 'CardBoss' => 100, 'CardMVP' => 100, 'CardMin' => 1, 'CardMax' => 10000, 'MvpItem' => 100, 'MvpItemMin' => 1, 'MvpItemMax' => 10000, 'MvpItemMode' => 0);
				}

				// Required: CharServer
				if (!isset($servers[0]['CharMapServers'][0]['CharServer']) || !is_array($servers[0]['CharMapServers'][0]['CharServer'])) {
					$servers[0]['CharMapServers'][0]['CharServer'] = array();
				}
				$servers[0]['CharMapServers'][0]['CharServer']['Address'] = !empty($servers[0]['CharMapServers'][0]['CharServer']['Address']) ? $servers[0]['CharMapServers'][0]['CharServer']['Address'] : $mysqlHost;
				$servers[0]['CharMapServers'][0]['CharServer']['Port'] = !empty($servers[0]['CharMapServers'][0]['CharServer']['Port']) ? (int)$servers[0]['CharMapServers'][0]['CharServer']['Port'] : 6121;

				// Required: MapServer
				if (!isset($servers[0]['CharMapServers'][0]['MapServer']) || !is_array($servers[0]['CharMapServers'][0]['MapServer'])) {
					$servers[0]['CharMapServers'][0]['MapServer'] = array();
				}
				$servers[0]['CharMapServers'][0]['MapServer']['Address'] = !empty($servers[0]['CharMapServers'][0]['MapServer']['Address']) ? $servers[0]['CharMapServers'][0]['MapServer']['Address'] : $mysqlHost;
				$servers[0]['CharMapServers'][0]['MapServer']['Port'] = !empty($servers[0]['CharMapServers'][0]['MapServer']['Port']) ? (int)$servers[0]['CharMapServers'][0]['MapServer']['Port'] : 5121;

				if (!isset($servers[0]['CharMapServers'][0]['WoeDayTimes'])) {
					$servers[0]['CharMapServers'][0]['WoeDayTimes'] = array(
						array(3, '20:00', 3, '22:00'),
						array(6, '20:00', 6, '22:00')
					);
				}
				if (!isset($servers[0]['CharMapServers'][0]['WoeDisallow'])) {
					$servers[0]['CharMapServers'][0]['WoeDisallow'] = array(
						array('module' => 'character', 'action' => 'online'),
						array('module' => 'character', 'action' => 'mapstats')
					);
				}

				$serversConfigContent = "<?php\nreturn " . var_export($servers, true) . ";\n";
				file_put_contents($configFile, $serversConfigContent);
				$session->setMessageData("MySQL login verified successfully! Updated config/servers.php with your credentials.");
				$this->redirect($this->url('install', 'index'));
			} catch (Exception $e) {
				$errorMessage = "MySQL Connection Failed: " . $e->getMessage() . ". Please check that MySQL is running and your credentials are correct.";
			}
		}
		
		if ($params->get('update_all')) {
			try {
				$installer->updateAll();
				if (!$installer->updateNeeded()) {
					$session->setMessageData('Database schemas have been successfully installed and verified! Please review and customize your server configuration below.');
					$schemasInstalled = true;
				}
			}
			catch (Flux_Installer_SchemaPermissionError $e) {
				$permissionError = $e;
			}
		}
		elseif (($username=$params->get('username')) && $username instanceOf Flux_Config &&
				($password=$params->get('password')) && $password instanceOf Flux_Config &&
				($update=$params->get('update')) && $update instanceOf Flux_Config) {
				
			$server64     = key($update->toArray());
			$username     = $username->get($server64);
			$password     = $password->get($server64);
			$serverName   = base64_decode($server64);
			$server       = array_key_exists($serverName, $installer->servers) ? $installer->servers[$serverName] : false;
			$updateNeeded = false;
			
			if ($server) {
				foreach ($server->schemas as $schema) {
					if (!$schema->isLatest()) {
						$updateNeeded = true;
						break;
					}
				}
				
				if (!$updateNeeded) {
					foreach ($server->charMapServers as $charMapServer) {
						foreach ($charMapServer->schemas as $schema) {
							if (!$schema->isLatest()) {
								$updateNeeded = true;
								break;
							}
						}
					}
				}
			}
			
			if (!$updateNeeded || !$server) {
				$errorMessage = 'Invalid server or the server has no updates.';
			}
			elseif (!$username || !$password) {
				$errorMessage = "Username and password are required for individual server updates.";
			}
			else {
				$connection = $server->loginAthenaGroup->connection;
				$connection->reconnectAs($username, $password);
				try {
					$server->updateAll();
					$session->setMessageData("Updates for $serverName have been installed.");
					$schemasInstalled = true;
				}
				catch (Flux_Installer_SchemaPermissionError $e) {
					$permissionError = $e;
				}
			}
		}

		// Handle Saving Server & Website Configuration
		if ($params->get('save_server_config')) {
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

			$insertSql = "INSERT INTO {$server->loginDatabase}.cp_cmssettings (`name`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)";
			$insertSth = $server->connection->getStatement($insertSql);

			foreach ($cfgFields as $field) {
				$val = $params->get($field);
				if ($val !== null) {
					$insertSth->execute(array($field, trim($val)));
				}
			}

			// Synchronize server_name and site_title
			$configuredName = trim($params->get('server_name') ?: $params->get('site_title') ?: 'Freynix RO');
			$insertSth->execute(array('server_name', $configuredName));
			$insertSth->execute(array('site_title', $configuredName));

			// Initialize default navigation items if empty
			try {
				$navTable = Flux::config('FluxTables.NavigationTable') ?: 'cp_navigation';
				$checkNav = $server->connection->getStatement("SELECT COUNT(*) FROM {$server->loginDatabase}.$navTable");
				$checkNav->execute();
				if ($checkNav->fetchColumn() == 0) {
					$initNavSql = "INSERT INTO {$server->loginDatabase}.$navTable (`name`, `url_val`, `url_type`, `location`, `sort_order`, `is_active`) VALUES
						('Home', 'main/index', 'internal', 'main', 1, 1),
						('News', 'news/index', 'internal', 'main', 2, 1),
						('Server Info', 'server/info', 'internal', 'main', 3, 1),
						('Rankings', 'ranking/character', 'internal', 'main', 4, 1),
						('Downloads', 'main/downloads', 'internal', 'main', 5, 1),
						('Support Desk', 'servicedesk/index', 'internal', 'main', 6, 1),
						('Rules', 'pages/content/rules', 'internal', 'footer', 1, 1),
						('Terms of Service', 'service/tos', 'internal', 'footer', 2, 1),
						('Item Shop', 'purchase/index', 'internal', 'footer', 3, 1)";
					$server->connection->getStatement($initNavSql)->execute();
				}
			} catch (Exception $e) {}

			// Also create initial welcome news announcement if cp_cmsnews is empty
			try {
				$checkNews = $server->connection->getStatement("SELECT COUNT(*) FROM {$server->loginDatabase}.cp_cmsnews");
				$checkNews->execute();
				if ($checkNews->fetchColumn() == 0) {
					$initNewsSql = "INSERT INTO {$server->loginDatabase}.cp_cmsnews (`title`, `body`, `author`, `created`, `modified`, `category`, `is_pinned`, `status`) VALUES
						(?, ?, 'Administration', NOW(), NOW(), 'Announcement', 1, 'published')";
					$initNewsBody = "<p>Welcome to <strong>" . htmlspecialchars($configuredName) . "</strong>! Our official server website is now live. Register your game account, download our game client, and join our Discord community!</p>";
					$server->connection->getStatement($initNewsSql)->execute(array("Welcome to " . $configuredName . "!", $initNewsBody));
				}
			} catch (Exception $e) {}

			// Complete installation session and redirect to main page
			$session->setInstallerAuthData(false);
			$session->setMessageData("Welcome to {$configuredName}! Server setup and website configuration have been successfully applied.");
			$this->redirect($this->url('main', 'index'));
		}

		// Fetch existing settings to populate the form
		$cmsSettings = array();
		try {
			$sth = $server->connection->getStatement("SELECT `name`, `value` FROM {$server->loginDatabase}.cp_cmssettings");
			$sth->execute();
			$cmsSettings = $sth->fetchAll(PDO::FETCH_KEY_PAIR);
		} catch (Exception $e) {}

		$updateNeeded = $installer->updateNeeded();
	}
}

if (count($_POST) && !$session->installerAuth) {
	$inputPassword  = $params->get('installer_password');
	$actualPassword = Flux::config('InstallerPassword');
	
	if ($inputPassword == $actualPassword) {
		$session->setInstallerAuthData(true);
	}
	else {
		$errorMessage = 'Incorrect password.';
	}
}
?>