<?php
$cookieFile = __DIR__ . '/cookie.txt';

$testDiscord = 'https://discord.gg/freynix-ragnarok-official';
$testFacebook = 'https://facebook.com/FreynixROOfficial';

$postData = [
    'discord_url' => $testDiscord,
    'facebook_url' => $testFacebook,
    'hp_show_hero' => '1',
    'hp_show_status' => '1',
    'hp_show_features' => '1',
    'hp_show_news' => '1',
    'hp_show_rankings' => '1',
    'hp_show_woe' => '1',
    'hp_show_discord' => '1'
];

$ch = curl_init('https://localhost/?module=homepage');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Post Save Status: HTTP $code\n";

// Check database directly
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$stmt = $pdo->query("SELECT name, value FROM cp_cmssettings WHERE name IN ('discord_url', 'facebook_url', 'hp_discord_url', 'hp_facebook_url')");
$saved = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
print_r($saved);

// Now check if homepage (https://localhost/) reflects the new discord and facebook urls
$ch2 = curl_init('https://localhost/');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
$homeHtml = curl_exec($ch2);
curl_close($ch2);

$foundDiscord = (strpos($homeHtml, $testDiscord) !== false);
$foundFacebook = (strpos($homeHtml, $testFacebook) !== false);

echo "Homepage reflects new Discord URL: " . ($foundDiscord ? 'YES' : 'NO') . "\n";
echo "Homepage reflects new Facebook URL: " . ($foundFacebook ? 'YES' : 'NO') . "\n";

