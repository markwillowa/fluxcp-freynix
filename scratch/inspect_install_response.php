<?php
$ch = curl_init('http://127.0.0.1/?module=install');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$html = curl_exec($ch);
$err = curl_error($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "HTTP Code: $code\n";
echo "Curl error: $err\n";
echo "HTML Length: " . strlen($html) . "\n";
file_put_contents(__DIR__ . '/install_step1.html', $html);
if (preg_match('/<title>(.*?)<\/title>/is', $html, $m)) echo "Title: " . $m[1] . "\n";
if (preg_match('/<h[1-3]>(.*?)<\/h[1-3]>/is', $html, $m)) echo "Header: " . $m[1] . "\n";
