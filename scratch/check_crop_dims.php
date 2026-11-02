<?php
$files = [
    'hero_lord_knight_banner.png',
    'hero_high_priest_banner.png'
];
foreach ($files as $f) {
    $info = getimagesize("themes/freynix/img/$f");
    echo "$f: {$info[0]}x{$info[1]}\n";
}

