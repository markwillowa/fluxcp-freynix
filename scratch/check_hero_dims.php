<?php
$files = [
    'hero_lord_knight.gif',
    'hero_high_priest.gif',
    'hero_paladin.gif',
    'hero_assassin_cross.gif'
];
foreach ($files as $f) {
    $path = "themes/freynix/img/$f";
    if (file_exists($path)) {
        $info = getimagesize($path);
        echo "$f: {$info[0]}x{$info[1]} mime: {$info['mime']}\n";
    }
}

