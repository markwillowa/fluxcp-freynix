<?php
$pages = [
    'Home' => 'http://localhost/',
    'News' => 'http://localhost/?module=news',
    'MVP Ranking' => 'http://localhost/?module=ranking&action=mvp',
    'WoE' => 'http://localhost/?module=woe',
    'Server Status' => 'http://localhost/?module=server&action=status',
    'Downloads' => 'http://localhost/?module=main&action=downloads'
];

foreach ($pages as $name => $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $hasFatal = (stripos($html, 'Fatal error') !== false);
    $hasCritical = (stripos($html, 'Critical Error') !== false);
    $hasWarning = (stripos($html, 'Warning:') !== false);
    
    echo "$name ($url): HTTP $code, Length: " . strlen($html);
    if ($hasFatal || $hasCritical) {
        echo " [ERROR DETECTED]\n";
    } else {
        echo " [OK]\n";
    }
}

