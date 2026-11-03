<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Manage Game Downloads';
$downloadsTable = Flux::config('FluxTables.DownloadsTable') ?: 'cp_downloads';

$downloads = array();
try {
	$sql = "SELECT * FROM {$server->loginDatabase}.$downloadsTable ORDER BY display_order ASC, id ASC";
	$sth = $server->connection->getStatement($sql);
	$sth->execute();
	$downloads = $sth->fetchAll();
} catch (Exception $e) {}
?>

