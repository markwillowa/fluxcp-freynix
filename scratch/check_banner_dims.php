<?php
$img = 'themes/freynix/img/freynix-promo-banner.jpg';
$info = getimagesize($img);
echo "Image dimensions: {$info[0]} x {$info[1]} ({$info['mime']})\n";

