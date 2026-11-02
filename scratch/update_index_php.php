<?php
$content = file_get_contents('index.php');

$search1 = <<<'PHP'
	// Installer library.
	$installer = Flux_Installer::getInstance();
	if ($hasUpdates=$installer->updateNeeded())
		Flux::config('ThemeName', array('installer'));
PHP;

$replace1 = <<<'PHP'
	// Installer library.
	$installer = Flux_Installer::getInstance();
	$isInstallModule = (isset($_GET['module']) && $_GET['module'] === 'install' && (!isset($_GET['action']) || $_GET['action'] !== 'reinstall'));
	if (($hasUpdates=$installer->updateNeeded()) || $isInstallModule) {
		Flux::config('ThemeName', array('installer'));
		$hasUpdates = true;
	}
PHP;

$search1_crlf = str_replace("\n", "\r\n", $search1);
$replace1_crlf = str_replace("\n", "\r\n", $replace1);

if (strpos($content, $search1) !== false) {
    $content = str_replace($search1, $replace1, $content);
    echo "Replaced with LF!\n";
} elseif (strpos($content, $search1_crlf) !== false) {
    $content = str_replace($search1_crlf, $replace1_crlf, $content);
    echo "Replaced with CRLF!\n";
} else {
    echo "search1 still not found!\n";
}

file_put_contents('index.php', $content);
