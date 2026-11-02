<?php
$pdo = new PDO('mysql:host=127.0.0.1', 'admin', 'Maki0913$');
$dbs = $pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
echo "Databases:\n";
print_r($dbs);
foreach ($dbs as $db) {
    $t = $pdo->query("SHOW TABLES FROM `$db` LIKE 'cp_%'")->fetchAll(PDO::FETCH_COLUMN);
    if (!empty($t)) {
        echo "Found CP tables in $db: " . count($t) . "\n";
    }
}

