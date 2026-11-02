<?php
$files = [
    'hero_lord_knight_trans.png' => 'https://irowiki.org/w/images/2/2c/LK.PNG',
    'hero_high_priest_trans.png' => 'https://irowiki.org/w/images/9/9e/FS.PNG',
    'hero_lk_thumb.png' => 'https://irowiki.org/w/images/thumb/2/2c/LK.PNG/400px-LK.PNG',
    'hero_hp_thumb.png' => 'https://irowiki.org/w/images/thumb/9/9e/FS.PNG/400px-FS.PNG'
];

foreach ($files as $name => $u) {
    $ch = curl_init($u);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    $data = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$name: HTTP $code, " . strlen($data) . " bytes\n";
    if ($code == 200 && strlen($data) > 5000) {
        file_put_contents("scratch/$name", $data);
        $info = getimagesize("scratch/$name");
        echo "Valid image! {$info[0]}x{$info[1]} {$info['mime']}\n";
    }
}

