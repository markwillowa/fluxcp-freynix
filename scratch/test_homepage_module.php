<?php
// Test fetching http://localhost/?module=homepage
$ch = curl_init('http://localhost/?module=homepage');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Homepage Module: HTTP $code, Length: " . strlen($html) . "\n";

$hasDiscordField = (strpos($html, 'name="discord_url"') !== false);
$hasFacebookField = (strpos($html, 'name="facebook_url"') !== false);

echo "Has discord_url field: " . ($hasDiscordField ? 'YES' : 'NO') . "\n";
echo "Has facebook_url field: " . ($hasFacebookField ? 'YES' : 'NO') . "\n";

