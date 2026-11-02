<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
echo "Tables in freynix:\n";
print_r($tables);

