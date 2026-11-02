<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$sql = file_get_contents(__DIR__ . '/../data/schemas/logindb/cp_cmsnews.20131120145701.sql');
echo "SQL:\n$sql\n";
try {
    $pdo->exec($sql);
    echo "Executed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
$t = $pdo->query("SHOW TABLES LIKE 'cp_%'")->fetchAll(PDO::FETCH_COLUMN);
print_r($t);

