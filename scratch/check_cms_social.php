<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$stmt = $pdo->query("SELECT name, value FROM cp_cmssettings WHERE name LIKE '%discord%' OR name LIKE '%facebook%'");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Current discord/facebook settings in cp_cmssettings:\n";
print_r($rows);
