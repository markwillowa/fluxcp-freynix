<?php
$list = [
    'LordKnight' => 'https://static.wikia.nocookie.net/ragnarok_gamepedia_en/images/a/a4/Character_LordKnight.jpg',
    'HighPriest' => 'https://static.wikia.nocookie.net/ragnarok_gamepedia_en/images/3/36/RO_HighPriest%28SD%29.png',
    'HighPriest_jpg' => 'https://static.wikia.nocookie.net/ragnarok_gamepedia_en/images/e/e0/Character_HighPriest.jpg',
    'Paladin' => 'https://static.wikia.nocookie.net/ragnarok_gamepedia_en/images/d/d3/Character_Paladin.jpg',
    'AssassinCross' => 'https://static.wikia.nocookie.net/ragnarok_gamepedia_en/images/b/ba/Character_AssassinCross.jpg'
];

foreach ($list as $name => $u) {
    $ch = curl_init($u);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    $data = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$name: HTTP $code, " . strlen($data) . " bytes\n";
    if ($code == 200 && strlen($data) > 5000) {
        file_put_contents("scratch/{$name}.jpg", $data);
    }
}

