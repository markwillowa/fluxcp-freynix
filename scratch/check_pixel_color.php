<?php
foreach (['hero_lord_knight_trans.png', 'hero_high_priest_trans.png'] as $fn) {
    $img = imagecreatefrompng("scratch/$fn");
    $rgba0 = imagecolorat($img, 0, 0);
    $r = ($rgba0 >> 16) & 0xFF;
    $g = ($rgba0 >> 8) & 0xFF;
    $b = $rgba0 & 0xFF;
    printf("%s (0,0) RGB: #%02X%02X%02X\n", $fn, $r, $g, $b);
}

