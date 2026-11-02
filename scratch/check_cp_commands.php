<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$cols = $pdo->query("DESCRIBE cp_commands")->fetchAll(PDO::FETCH_ASSOC);
echo "cp_commands Columns:\n";
print_r($cols);
$rows = $pdo->query("SELECT * FROM cp_commands LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
echo "Sample rows:\n";
print_r($rows);
