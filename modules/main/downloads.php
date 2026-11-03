<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Download Game Client';
$downloadsTable = Flux::config('FluxTables.DownloadsTable') ?: 'cp_downloads';

$downloads = array();
try {
	$sql = "SELECT * FROM {$server->loginDatabase}.$downloadsTable WHERE status = 'published' ORDER BY display_order ASC, id ASC";
	$sth = $server->connection->getStatement($sql);
	$sth->execute();
	$downloads = $sth->fetchAll();
} catch (Exception $e) {}
?>
