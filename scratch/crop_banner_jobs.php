<?php
$src = imagecreatefromjpeg('themes/freynix/img/freynix-promo-banner.jpg');
$w = imagesx($src);
$h = imagesy($src);

// 1. Lord Knight crop (0, 0, 480, 520)
$lk_w = 460;
$lk_h = 520;
$lk = imagecreatetruecolor($lk_w, $lk_h);
imagealphablending($lk, false);
imagesavealpha($lk, true);
$trans = imagecolorallocatealpha($lk, 0, 0, 0, 127);
imagefill($lk, 0, 0, $trans);

imagecopyresampled($lk, $src, 0, 0, 0, 0, $lk_w, $lk_h, $lk_w, $lk_h);

// 2. High Priest crop (564, 0, 460, 520)
$hp_w = 460;
$hp_h = 520;
$hp = imagecreatetruecolor($hp_w, $hp_h);
imagealphablending($hp, false);
imagesavealpha($hp, true);
$trans2 = imagecolorallocatealpha($hp, 0, 0, 0, 127);
imagefill($hp, 0, 0, $trans2);

imagecopyresampled($hp, $src, 0, 0, 564, 0, $hp_w, $hp_h, $hp_w, $hp_h);

// Save crops
imagepng($lk, 'themes/freynix/img/hero_lord_knight_banner.png');
imagepng($hp, 'themes/freynix/img/hero_high_priest_banner.png');

echo "Saved lord knight and high priest crops successfully!\n";

