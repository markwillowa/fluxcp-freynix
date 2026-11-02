<?php
$routes = [
    '/' => 'Homepage',
    '/?module=news' => 'News Index',
    '/?module=main&action=downloads' => 'Downloads',
    '/?module=pages' => 'Pages Manager (Admin)',
    '/?module=pages&action=content&path=rules' => 'Rules Page (Content)',
    '/?module=ranking&action=character' => 'Character Ranking',
    '/?module=ranking&action=guild' => 'Guild Ranking',
    '/?module=server&action=status' => 'Server Status',
    '/?module=server&action=info' => 'Server Info',
    '/?module=servicedesk' => 'Service Desk',
    '/?module=account&action=login' => 'Login Page',
    '/?module=account&action=create' => 'Register Page',
    '/?module=homepage' => 'CMS Homepage Control Panel'
];

$cookieFile = __DIR__ . '/cookie.txt';

echo "=== ROUTE HEALTH CHECK ===\n";
foreach ($routes as $path => $name) {
    $url = 'http://localhost' . $path;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $hasFatal = stripos($html, 'Fatal error') !== false;
    $hasWarning = stripos($html, 'Warning:') !== false;
    
    $status = ($code == 200 && !$hasFatal && !$hasWarning) ? "OK (200)" : "FAIL ($code)";
    if ($hasFatal) $status .= " [FATAL ERROR]";
    if ($hasWarning) $status .= " [WARNING]";
    
    printf("%-35s : %-15s [%d bytes]\n", $name, $status, strlen($html));
}

