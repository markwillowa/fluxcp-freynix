<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$rows = $pdo->query('SELECT id, path, title, status FROM cp_cmspages')->fetchAll(PDO::FETCH_ASSOC);
echo "=== CMS PAGES IN DB ===\n";
print_r($rows);

// Test curl request to one of the pages
if (!empty($rows)) {
    $first = $rows[0]['path'];
    $url = "http://localhost/?module=pages&action=content&path=" . urlencode($first);
    echo "\nTesting URL: $url\n";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "HTTP Status: $code\n";
    echo "HTML Length: " . strlen($html) . "\n";
    if (stripos($html, 'freynix-card') !== false) {
        echo "Card rendered successfully.\n";
    }
}

