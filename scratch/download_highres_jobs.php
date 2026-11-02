<?php
$jobs = [
    'hero_lord_knight' => 'Lord_Knight.png',
    'hero_high_priest' => 'High_Priest.png',
    'hero_paladin'     => 'Paladin.png',
    'hero_assassin_cross' => 'Assassin_Cross.png',
    'hero_high_wizard' => 'High_Wizard.png',
    'hero_sniper'      => 'Sniper.png'
];

foreach ($jobs as $key => $filename) {
    $wikiPageUrl = "https://irowiki.org/wiki/File:" . $filename;
    $ch = curl_init($wikiPageUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);

    if (preg_match('#/w/images/[a-f0-9]/[a-f0-9]{2}/[^"\']+\.png#i', $html, $m)) {
        $imgUrl = "https://irowiki.org" . $m[0];
        echo "Fetching $key from $imgUrl ...\n";
        $ch2 = curl_init($imgUrl);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch2);
        $code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        curl_close($ch2);
        
        if ($code == 200 && strlen($data) > 10000) {
            file_put_contents("themes/freynix/img/{$key}.png", $data);
            echo "Successfully saved themes/freynix/img/{$key}.png (" . strlen($data) . " bytes)\n";
        } else {
            echo "Failed $key: code $code, len " . strlen($data) . "\n";
        }
    } else {
        echo "Could not find image url for $filename in wiki page\n";
    }
}

