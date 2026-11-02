<?php
if (!defined('FLUX_ROOT')) exit;

class Flux_CMS {
	private static $settingsCache = null;

	public static function getSettings($server) {
		if (self::$settingsCache !== null) {
			return self::$settingsCache;
		}

		try {
			$sql = "SELECT name, value FROM {$server->loginDatabase}.cp_cmssettings";
			$sth = $server->connection->getStatement($sql);
			$sth->execute();
			$rows = $sth->fetchAll();
			$settings = array();
			foreach ($rows as $row) {
				$settings[$row->name] = $row->value;
			}
			self::$settingsCache = $settings;
			return $settings;
		} catch (Exception $e) {
			return array();
		}
	}

	public static function get($key, $default = null, $server = null) {
		if ($server !== null) {
			$settings = self::getSettings($server);
			return isset($settings[$key]) ? $settings[$key] : $default;
		}
		if (self::$settingsCache !== null) {
			return isset(self::$settingsCache[$key]) ? self::$settingsCache[$key] : $default;
		}
		return $default;
	}

	public static function set($key, $val, $server) {
		$sql = "INSERT INTO {$server->loginDatabase}.cp_cmssettings (name, value) 
				VALUES (?, ?) 
				ON DUPLICATE KEY UPDATE value = VALUES(value)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($key, (string)$val));
		if (self::$settingsCache !== null) {
			self::$settingsCache[$key] = (string)$val;
		}
	}
}
?>
