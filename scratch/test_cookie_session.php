<?php
$cookieFile = __DIR__ . '/cookie.txt';

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

echo "Logged in check:\n";
echo "Has Logout: " . (strpos($res, 'Logout') !== false ? 'YES' : 'NO') . "\n";
echo "Has MALDA009: " . (strpos($res, 'MALDA009') !== false ? 'YES' : 'NO') . "\n";

// Now request ?module=homepage
$ch2 = curl_init('https://localhost/?module=homepage');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch2, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch2, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, false);
$res2 = curl_exec($ch2);
$code2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
$headers = curl_getinfo($ch2);
curl_close($ch2);

echo "module=homepage: HTTP $code2\n";

