<?php
if (!defined('FLUX_ROOT')) exit;

$adminLevel = (int)Flux::config('AdminMenuGroupLevel') ?: 99;
if (!$session->isLoggedIn() || (int)$session->account->group_level < $adminLevel) {
	$this->loginRequired();
}

$title = 'Re-Install & Database Reset Wizard';

if (count($_POST) && $params->get('reinstall')) {
	$loginDbFiles   = glob(FLUX_DATA_DIR.'/logs/schemas/logindb/*/*.txt') ?: array();
	$charMapDbFiles = array_merge(
		glob(FLUX_DATA_DIR.'/logs/schemas/charmapdb/*/*.txt') ?: array(),
		glob(FLUX_DATA_DIR.'/logs/schemas/charmapdb/*/*/*.txt') ?: array()
	);
	
	foreach (array($loginDbFiles, $charMapDbFiles) as $dbFiles) {
		if ($dbFiles) {
			foreach ($dbFiles as $file) {
				@unlink($file);
			}
		}
	}

	// Remove schema tracking directories if empty
	$loginDirs = glob(FLUX_DATA_DIR.'/logs/schemas/logindb/*') ?: array();
	$charDirs  = glob(FLUX_DATA_DIR.'/logs/schemas/charmapdb/*') ?: array();
	foreach (array_merge($loginDirs, $charDirs) as $d) {
		if (is_dir($d)) {
			@rmdir($d);
		}
	}

	// Clear temporary caches
	@unlink(FLUX_DATA_DIR . '/tmp/ServerStatus.cache');

	// If administrator requested CMS settings reset
	if ($params->get('reset_cms_defaults')) {
		try {
			$server->connection->getStatement("DELETE FROM {$server->loginDatabase}.cp_cmssettings WHERE name LIKE 'hp_%' OR name LIKE 'hero_%'")->execute();
		} catch (Exception $e) {}
	}

	// Automatically authenticate the administrator into the installer
	$session->setInstallerAuthData(true);
	$session->setMessageData('Database schema tracking records have been reset! You can now re-run database table migrations or edit your MySQL connection and server settings.');
	$this->redirect($this->url('install', 'index'));
}
?>
