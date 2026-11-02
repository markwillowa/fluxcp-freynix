<?php
$cookieFile = __DIR__ . '/cookie.txt';
if (file_exists($cookieFile)) unlink($cookieFile);

// 1. Login over HTTPS so secure cookie is sent
$ch = curl_init('https://localhost/?module=account&action=login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'server' => 'Freynix Ragnarok Online',
    'username' => 'malda009',
    'password' => 'Maki0913$'
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$res = curl_exec($ch);
curl_close($ch);

// 2. Fetch ?module=homepage over HTTPS
$ch2 = curl_init('https://localhost/?module=homepage');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch2, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch2, CURLOPT_COOKIEFILE, $cookieFile);
$html = curl_exec($ch2);
$code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
curl_close($ch2);

echo "Homepage CMS as malda009 (HTTPS): HTTP $code, Length: " . strlen($html) . "\n";
echo "Has discord_url: " . (strpos($html, 'name="discord_url"') !== false ? 'YES' : 'NO') . "\n";
echo "Has facebook_url: " . (strpos($html, 'name="facebook_url"') !== false ? 'YES' : 'NO') . "\n";

// 3. Test saving new discord and facebook urls via CMS POST
$postFields = [
    'discord_url' => 'https://discord.gg/freynix-official',
    'facebook_url' => 'https://facebook.com/freynix.ragnarok',
    'hp_show_hero' => '1',
    'hp_show_status' => '1',
    'hp_show_features' => '1',
    'hp_show_news' => '1',
    'hp_show_rankings' => '1',
    'hp_show_woe' => '1',
    'hp_show_discord' => '1'
];
$ch3 = curl_init('https://localhost/?module=homepage');
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch3, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch3, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch3, CURLOPT_POST, true);
curl_setopt($ch3, CURLOPT_POSTFIELDS, http_build_query($postFields));
curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
$htmlPost = curl_exec($ch3);
$codePost = curl_getinfo($ch3, CURLINFO_HTTP_CODE);
curl_close($ch3);

echo "Post Save Homepage: HTTP $codePost\n";

// Check DB values now
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$stmt = $pdo->query("SELECT name, value FROM cp_cmssettings WHERE name IN ('discord_url', 'facebook_url', 'hp_discord_url', 'hp_facebook_url')");
print_r($stmt->fetchAll(PDO::FETCH_KEY_PAIR));
