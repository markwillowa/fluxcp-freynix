<?php
$cookieFile = __DIR__ . '/admin_cookie.txt';
if (file_exists($cookieFile)) @unlink($cookieFile);

// 1. Login as admin malda009 over https://localhost
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

// 2. Request https://localhost/?module=install&action=reinstall
$ch = curl_init('https://localhost/?module=install&action=reinstall');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $code\n";
echo "HTML Length: " . strlen($html) . "\n";
file_put_contents(__DIR__ . '/reinstall_fresh.html', $html);

if (strpos($html, 'RE-INSTALL &amp; DATABASE RESET') !== false) {
    echo "SUCCESS: Reinstall page rendered with Freynix Eclipse Realm theme!\n";
} else {
    echo "Title: ";
    if (preg_match('/<title>(.*?)<\/title>/is', $html, $m)) echo $m[1] . "\n";
}
