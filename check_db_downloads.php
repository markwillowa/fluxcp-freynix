<?php
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SCRIPT_NAME'] = '/index.php';

require 'index.php';

$table = Flux::config('FluxTables.DownloadsTable') ?: 'cp_downloads';
$sql = "SELECT id, title, category, version, file_size, url_mirror1, status FROM {$server->loginDatabase}.$table";
$sth = $server->connection->getStatement($sql);
$sth->execute();
$rows = $sth->fetchAll();

echo "Total packages in DB: " . count($rows) . "\n";
foreach ($rows as $r) {
    echo "  [#{$r->id}] {$r->title} ({$r->category}) - Status: {$r->status} - Mirror1: {$r->url_mirror1}\n";
}

