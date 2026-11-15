<?php
$servers = require 'config/servers.php';
$db = $servers[0]['DbConfig'];
$dsn = "mysql:host={$db['Hostname']};port={$db['Port']};dbname={$db['Database']};charset=utf8mb4";
$pdo = new PDO($dsn, $db['Username'], $db['Password']);

$stmt = $pdo->query("SELECT id, title, category, version, file_size, url_mirror1, status FROM cp_downloads");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total downloads in DB: " . count($rows) . "\n";
foreach ($rows as $r) {
    echo "  [#{$r['id']}] {$r['title']} | {$r['category']} | Mirror1: {$r['url_mirror1']} | Status: {$r['status']}\n";
}
