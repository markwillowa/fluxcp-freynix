<?php
foreach (['hero_lord_knight_trans.png', 'hero_high_priest_trans.png'] as $fn) {
    $img = imagecreatefrompng("scratch/$fn");
    $w = imagesx($img);
    $h = imagesy($img);
    
    // Check top-left corner pixel alpha
    $rgba0 = imagecolorat($img, 0, 0);
    $a0 = ($rgba0 >> 24) & 0x7F;
    
    $rgbaTopRight = imagecolorat($img, $w - 1, 0);
    $aTopRight = ($rgbaTopRight >> 24) & 0x7F;
    
    echo "$fn ($w x $h): top-left alpha: $a0 (127=fully transparent), top-right alpha: $aTopRight\n";
}

