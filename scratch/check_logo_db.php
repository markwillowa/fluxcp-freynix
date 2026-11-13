<?php
$conn = new PDO('mysql:host=localhost;dbname=freynix', 'admin', 'Maki0913$');
$st = $conn->query("SELECT name, value FROM cp_cmssettings WHERE name LIKE '%logo%'");
$rows = $st->fetchAll(PDO::FETCH_ASSOC);
print_r($rows);
