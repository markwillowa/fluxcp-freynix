<?php
// Search for direct image URL from DeviantArt page
$searchUrls = [
    'https://www.deviantart.com/michaelxgamingph/art/Lord-Knight-Male-Female-01-Ragnarok-Online-994328574',
    'https://www.deviantart.com/michaelxgamingph/art/High-Priest-Male-Female-01-Ragnarok-Online-993707769'
];

foreach ($searchUrls as $u) {
    echo "Checking $u ...\n";
    $ch = curl_init($u);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "HTTP $code, Length: " . strlen($html) . "\n";
    if (preg_match_all('/https:\/\/[a-z0-9\-]+\.wixmp\.com\/f\/[^\s"\'<>]+/i', $html, $m)) {
        echo "Found " . count($m[0]) . " wixmp images!\n";
        foreach (array_slice(array_unique($m[0]), 0, 5) as $img) {
            echo "IMG: $img\n";
        }
    }
}

