<?php
$source = 'c:/xampp/htdocs/fluxcp-freynix/themes/dominion/img/dominion-logo.png';
$im = imagecreatefromjpeg($source);
$w = imagesx($im);
$h = imagesy($im);

echo "Loaded dominion image: {$w}x{$h}\n";

// Sample corners
$corners = array(
    imagecolorsforindex($im, imagecolorat($im, 0, 0)),
    imagecolorsforindex($im, imagecolorat($im, $w - 1, 0)),
    imagecolorsforindex($im, imagecolorat($im, 0, $h - 1)),
    imagecolorsforindex($im, imagecolorat($im, $w - 1, $h - 1))
);
print_r($corners);

