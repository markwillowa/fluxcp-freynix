<?php
$cookieFile = __DIR__ . '/cookie.txt';

$pages = [
    'Home' => 'https://localhost/',
    'Homepage CMS' => 'https://localhost/?module=homepage',
    'News' => 'https://localhost/?module=news',
    'MVP Ranking' => 'https://localhost/?module=ranking&action=mvp',
    'WoE' => 'https://localhost/?module=woe',
    'Server Status' => 'https://localhost/?module=server&action=status',
    'Downloads' => 'https://localhost/?module=main&action=downloads'
];

foreach ($pages as $name => $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $hasFatal = (stripos($html, 'Fatal error') !== false);
    $hasCritical = (stripos($html, 'Critical Error') !== false);
    echo "$name ($url): HTTP $code, Length: " . strlen($html);
    if ($hasFatal || $hasCritical) {
        echo " [ERROR]\n";
    } else {
        echo " [OK]\n";
    }
}

