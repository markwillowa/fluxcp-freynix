<?php
if (!defined('FLUX_ROOT')) exit;

$downloadsTable = Flux::config('FluxTables.DownloadsTable') ?: 'cp_downloads';
$id = (int)$params->get('id');

$sql = "SELECT title FROM {$server->loginDatabase}.$downloadsTable WHERE id = ?";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$package = $sth->fetch();

if ($package) {
	$delSth = $server->connection->getStatement("DELETE FROM {$server->loginDatabase}.$downloadsTable WHERE id = ?");
	$delSth->execute(array($id));
	$session->setMessageData("Download package '{$package->title}' has been deleted.");
} else {
	$session->setMessageData("Download package was not found.");
}

$this->redirect($this->url('downloads', 'manage'));
?>

