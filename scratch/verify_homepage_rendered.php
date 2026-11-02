<?php
$ch = curl_init('http://localhost/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $code\n";
echo "Length: " . strlen($html) . "\n";

// Check Hero Section elements
$hasSlogan = (strpos($html, 'Freedom to Play. Freedom to Conquer.') !== false);
$hasLK = (strpos($html, 'hero_lord_knight_faded.png') !== false);
$hasHP = (strpos($html, 'hero_high_priest_faded.png') !== false);
$hasJoinNow = (strpos($html, 'JOIN NOW!') !== false);
$hasCardsGrid = (strpos($html, 'hero-promo-cards-grid') !== false);
$hasBadgesRow = (strpos($html, 'hero-golden-badges-row') !== false);

// Check World Boss Stage elements
$hasBossStage = (strpos($html, 'boss-spotlight-stage') !== false);
$hasBossVisual = (strpos($html, 'boss-stage-visual') !== false);
$hasBossIntel = (strpos($html, 'boss-stage-intel') !== false);
$hasOldCards = (strpos($html, 'monsters-showcase-grid') !== false);

echo "Hero Slogan: " . ($hasSlogan ? 'YES' : 'NO') . "\n";
echo "Hero Lord Knight: " . ($hasLK ? 'YES' : 'NO') . "\n";
echo "Hero High Priest: " . ($hasHP ? 'YES' : 'NO') . "\n";
echo "Hero JOIN NOW: " . ($hasJoinNow ? 'YES' : 'NO') . "\n";
echo "Hero Promo Cards: " . ($hasCardsGrid ? 'YES' : 'NO') . "\n";
echo "Hero Golden Badges: " . ($hasBadgesRow ? 'YES' : 'NO') . "\n";
echo "World Boss 2-Column Stage: " . ($hasBossStage ? 'YES' : 'NO') . "\n";
echo "World Boss Visual (Left): " . ($hasBossVisual ? 'YES' : 'NO') . "\n";
echo "World Boss Intel (Right): " . ($hasBossIntel ? 'YES' : 'NO') . "\n";
echo "Old Monster Cards Removed: " . (!$hasOldCards ? 'YES (REMOVED)' : 'NO (STILL PRESENT)') . "\n";

