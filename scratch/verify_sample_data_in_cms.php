<?php
$cookieFile = __DIR__ . '/cookie.txt';

$ch = curl_init('https://localhost/?module=homepage');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Homepage CMS status: HTTP $code, length: " . strlen($html) . "\n";

$checks = [
    'Hero Title' => 'FREYNIX RAGNAROK ONLINE',
    'Hero Slogan' => 'FORGE YOUR FREEDOM',
    'Rates Text' => '1000x / 1000x',
    'Feature 1' => 'INSTANT REBIRTH & 1000x RATES',
    'Feature 2' => 'COMPETITIVE 1% MVP CARD HUNTS',
    'WoE Headline' => 'WAR OF EMPERIUM: CLASH FOR CASTLE SUPREMACY',
    'Discord Title' => 'JOIN THE FREYNIX ADVENTURERS ON DISCORD',
    'Discord URL' => 'https://discord.gg/freynix',
    'Facebook URL' => 'https://facebook.com/FreynixRO'
];

foreach ($checks as $label => $str) {
    $found = (strpos($html, htmlspecialchars($str)) !== false);
    echo "$label: " . ($found ? 'OK' : 'MISSING') . "\n";
}

