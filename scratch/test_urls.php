<?php
$urls = [
    'lk_fandom' => 'https://static.wikia.nocookie.net/ragnarok8812/images/8/87/Lord_Knight.png',
    'hp_fandom' => 'https://static.wikia.nocookie.net/ragnarok8812/images/c/c2/High_Priest.png',
    'lk_ro_fandom' => 'https://static.wikia.nocookie.net/ro/images/e/e5/Lord_Knight.png',
    'hp_ro_fandom' => 'https://static.wikia.nocookie.net/ro/images/6/62/High_Priest.png',
    'lk_wikimedia' => 'https://upload.wikimedia.org/wikipedia/en/thumb/5/52/Lord_Knight.png/250px-Lord_Knight.png',
    'irowiki_lk' => 'https://irowiki.org/wiki/File:Lord_Knight.png',
    'ratemyserver' => 'https://ratemyserver.net/images/char/m_lord_knight.gif'
];

foreach ($urls as $k => $u) {
    $ch = curl_init($u);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $d = curl_exec($ch);
    $c = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$k: HTTP $c, " . strlen($d) . " bytes\n";
    if ($c === 200 && strlen($d) > 3000) {
        $ext = (strpos($u, '.gif') !== false) ? 'gif' : 'png';
        file_put_contents("scratch/{$k}.{$ext}", $d);
    }
}

