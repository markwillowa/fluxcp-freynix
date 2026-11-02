<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$rows = $pdo->query('SELECT name, value FROM cp_cmssettings ORDER BY name ASC')->fetchAll(PDO::FETCH_KEY_PAIR);
echo "Total Settings: " . count($rows) . "\n";
print_r(array_slice($rows, 0, 15, true));

