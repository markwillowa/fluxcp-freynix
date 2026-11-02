<?php
$content = file_get_contents('themes/freynix/main/index.php');

// 1. Locate Hero Section
$heroStartStr = "<!-- ========================================================================\n     HOMEPAGE HERO SECTION";
$heroEndStr = "<!-- ========================================================================\n     LIVE SERVER STATUS DASHBOARD";

$posHeroStart = strpos($content, $heroStartStr);
$posHeroEnd = strpos($content, $heroEndStr);

echo "Hero start pos: " . var_export($posHeroStart, true) . "\n";
echo "Hero end pos: " . var_export($posHeroEnd, true) . "\n";

// 2. Locate World Boss Section
$bossStartStr = "<!-- ========================================================================\n     LEGENDARY MVP WORLD BOSS CODEX";
$bossEndStr = "<!-- ========================================================================\n     SERVER FEATURES (6 FEATURE CARDS)";

$posBossStart = strpos($content, $bossStartStr);
$posBossEnd = strpos($content, $bossEndStr);

echo "Boss start pos: " . var_export($posBossStart, true) . "\n";
echo "Boss end pos: " . var_export($posBossEnd, true) . "\n";

