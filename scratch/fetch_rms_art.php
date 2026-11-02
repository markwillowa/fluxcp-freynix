<?php
$chars = [
    'hero_lord_knight' => 'https://ratemyserver.net/images/char/m_lord_knight.gif',
    'hero_high_priest' => 'https://ratemyserver.net/images/char/f_high_priest.gif',
    'hero_high_priest_m' => 'https://ratemyserver.net/images/char/m_high_priest.gif',
    'hero_assassin_cross' => 'https://ratemyserver.net/images/char/m_assassin_cross.gif',
    'hero_paladin' => 'https://ratemyserver.net/images/char/m_paladin.gif',
    'hero_high_wizard' => 'https://ratemyserver.net/images/char/m_high_wizard.gif',
    'hero_sniper' => 'https://ratemyserver.net/images/char/f_sniper.gif'
];

foreach ($chars as $key => $u) {
    $ch = curl_init($u);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$key: HTTP $code (" . strlen($data) . " bytes)\n";
    if ($code == 200 && strlen($data) > 10000) {
        file_put_contents("themes/freynix/img/{$key}.gif", $data);
        echo "Saved themes/freynix/img/{$key}.gif\n";
    }
}

