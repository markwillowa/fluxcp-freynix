<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$stmt = $pdo->query('SELECT account_id, userid, user_pass, group_id FROM login LIMIT 10');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

