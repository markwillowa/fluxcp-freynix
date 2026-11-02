<?php
$cookieFile = __DIR__ . '/cookie.txt';

// Login
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
curl_exec($ch);
curl_close($ch);

// Now request ?module=pages
$ch = curl_init('https://localhost/?module=pages');
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

// Save html to scratch/pages_output.html so we can inspect it
file_put_contents(__DIR__ . '/pages_output.html', $html);

// Search for table, card, layout
echo "Saved to scratch/pages_output.html\n";

// Check if any error or notices
if (stripos($html, 'Fatal error') !== false) echo "Has Fatal Error!\n";
if (stripos($html, 'Warning:') !== false) echo "Has Warning!\n";
?>

