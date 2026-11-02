<?php
$pages = [
    'https://irowiki.org/wiki/Lord_Knight',
    'https://irowiki.org/wiki/High_Priest'
];

foreach ($pages as $p) {
    echo "=== Fetching $p ===\n";
    $ch = curl_init($p);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    $html = curl_exec($ch);
    curl_close($ch);
    preg_match_all('/src="(\/w\/images\/[^"]+\.png)"/i', $html, $m);
    foreach (array_unique($m[1]) as $img) {
        echo "PNG: $img\n";
    }
}

