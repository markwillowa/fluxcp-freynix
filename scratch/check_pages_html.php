<?php
$ch = curl_init('http://localhost/?module=pages');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$html = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "HTTP Code: " . $info['http_code'] . "\n";
echo "Effective URL: " . $info['url'] . "\n";
echo "HTML Length: " . strlen($html) . "\n";
echo "HTML Preview (first 1000 chars):\n";
echo substr($html, 0, 1000) . "\n...\n";
?>

