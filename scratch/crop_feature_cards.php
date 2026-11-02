<?php
$src = imagecreatefromjpeg('themes/freynix/img/freynix-promo-banner.jpg');

$crops = [
    'feat_basic_cards.jpg' => [30, 520, 235, 245],
    'feat_mvp_cards.jpg'   => [270, 520, 235, 245],
    'feat_pvp_woe.jpg'     => [515, 520, 235, 245],
    'feat_quests_events.jpg'=> [755, 520, 235, 245]
];

foreach ($crops as $filename => $coords) {
    list($x, $y, $w, $h) = $coords;
    $dst = imagecreatetruecolor($w, $h);
    imagecopyresampled($dst, $src, 0, 0, $x, $y, $w, $h, $w, $h);
    imagejpeg($dst, "themes/freynix/img/$filename", 95);
    imagedestroy($dst);
    echo "Saved themes/freynix/img/$filename\n";
}

