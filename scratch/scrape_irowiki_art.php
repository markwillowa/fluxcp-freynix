<?php
function get_irowiki_file_url($file) {
    $url = "https://irowiki.org/wiki/File:" . urlencode($file);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);
    
    // Look for <div class="fullMedia"><p><a href="(...)" class="internal"
    if (preg_match('/class="internal"[^>]*href="([^"]+)"/i', $html, $m)) {
        $imgUrl = $m[1];
        if (strpos($imgUrl, 'http') !== 0) {
            $imgUrl = 'https://irowiki.org' . $imgUrl;
        }
        return $imgUrl;
    }
    return false;
}

$files = [
    'hero_lord_knight.png' => 'Lord_Knight.png',
    'hero_high_priest.png' => 'High_Priest.png',
    'hero_paladin.png'     => 'Paladin.png',
    'hero_assassin_cross.png' => 'Assassin_Cross.png'
];

foreach ($files as $saveAs => $wikiFile) {
    echo "Finding $wikiFile...\n";
    $directUrl = get_irowiki_file_url($wikiFile);
    echo "Direct URL: $directUrl\n";
    if ($directUrl) {
        $ch = curl_init($directUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo "Downloaded $saveAs: HTTP $code (" . strlen($data) . " bytes)\n";
        if ($code == 200 && strlen($data) > 10000) {
            file_put_contents("themes/freynix/img/$saveAs", $data);
            echo "Successfully saved themes/freynix/img/$saveAs\n";
        }
    }
}

