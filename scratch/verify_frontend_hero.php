<?php
$ch = curl_init('https://localhost/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$html = curl_exec($ch);
curl_close($ch);

echo "Homepage status: Length " . strlen($html) . "\n";
echo "Clean Lord Knight Transparent Image: " . (strpos($html, 'hero_lord_knight_clean.png') !== false ? 'YES' : 'NO') . "\n";
echo "Clean High Priest Transparent Image: " . (strpos($html, 'hero_high_priest_clean.png') !== false ? 'YES' : 'NO') . "\n";
echo "Matching Gold Hero Button: " . (strpos($html, 'btn-hero-gold') !== false ? 'YES' : 'NO') . "\n";
echo "Matching Cyan Hero Button: " . (strpos($html, 'btn-hero-cyan') !== false ? 'YES' : 'NO') . "\n";
echo "Old Faded Hero Images Removed: " . (strpos($html, 'hero_lord_knight_faded.png') === false ? 'YES' : 'NO') . "\n";
echo "Discord Link Present: " . (strpos($html, 'https://discord.gg/freynix') !== false ? 'YES' : 'NO') . "\n";
echo "Facebook Link Present: " . (strpos($html, 'https://facebook.com/FreynixRO') !== false ? 'YES' : 'NO') . "\n";

