<?php
foreach (['hero_lord_knight_clean.png', 'hero_high_priest_clean.png'] as $fn) {
    $img = imagecreatefrompng("themes/freynix/img/$fn");
    $w = imagesx($img);
    $h = imagesy($img);
    $a0 = (imagecolorat($img, 0, 0) >> 24) & 0x7F;
    $aTR = (imagecolorat($img, $w-1, 0) >> 24) & 0x7F;
    $aCenter = (imagecolorat($img, (int)($w/2), (int)($h/2)) >> 24) & 0x7F;
    echo "$fn: corner alpha: $a0 (127=transparent), top-right: $aTR, center alpha: $aCenter (0=opaque)\n";
}

