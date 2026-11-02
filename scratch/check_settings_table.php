<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$cols = $pdo->query('DESCRIBE cp_cmssettings')->fetchAll(PDO::FETCH_ASSOC);
print_r($cols);

