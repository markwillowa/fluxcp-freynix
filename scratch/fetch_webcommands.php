<?php
$cookieFile = __DIR__ . '/cookie.txt';
$ch = curl_init('https://localhost/?module=webcommands');
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
file_put_contents(__DIR__ . '/webcommands_output.html', $html);
if (preg_match('/<main class="main-content-panel">(.*?)<\/main>/s', $html, $m)) {
    echo "=== MAIN PANEL CONTENT ===\n";
    echo $m[1] . "\n";
}

