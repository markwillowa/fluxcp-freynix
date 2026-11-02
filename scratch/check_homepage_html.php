<?php
$cookieFile = __DIR__ . '/cookie.txt';

$ch2 = curl_init('https://localhost/?module=homepage');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch2, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch2, CURLOPT_COOKIEFILE, $cookieFile);
$html = curl_exec($ch2);
curl_close($ch2);

echo "Length: " . strlen($html) . "\n";
echo "Has discord_url: " . (strpos($html, 'name="discord_url"') !== false ? 'YES' : 'NO') . "\n";
echo "Has facebook_url: " . (strpos($html, 'name="facebook_url"') !== false ? 'YES' : 'NO') . "\n";
echo "Has Discord Invite URL: " . (strpos($html, 'Discord Community Invite URL') !== false ? 'YES' : 'NO') . "\n";
echo "Has Facebook Page URL: " . (strpos($html, 'Facebook Official Page URL') !== false ? 'YES' : 'NO') . "\n";

