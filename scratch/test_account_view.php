<?php
$cookieFile = __DIR__ . '/cookie.txt';

$ch = curl_init('https://localhost/?module=account&action=view');
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

file_put_contents(__DIR__ . '/account_view_output.html', $html);

if (stripos($html, 'Fatal error') !== false) echo "HAS FATAL ERROR!\n";
if (stripos($html, 'Warning:') !== false) echo "HAS WARNING!\n";

if (strpos($html, 'account-detail-table') !== false) {
    echo "account-detail-table found in output!\n";
} else {
    echo "account-detail-table NOT found in output!\n";
}

if (strpos($html, 'ACCOUNT CREDENTIALS') !== false && strpos($html, 'ACTIVITY & TIMESTAMPS') !== false) {
    echo "Both card sections found in output!\n";
}

