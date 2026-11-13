<?php
$logos = array(
    'nexus'     => 'themes/nexus/img/nexus-logo.png',
    'dominion'  => 'themes/dominion/img/dominion-logo.png',
    'celestial' => 'themes/celestial/img/celestial-logo.png',
    'freynix'   => 'themes/freynix/img/logo.png',
    'default'   => 'themes/default/img/logo.gif'
);

foreach ($logos as $theme => $path) {
    $fullPath = 'c:/xampp/htdocs/fluxcp-freynix/' . $path;
    if (!file_exists($fullPath)) {
        echo "$theme ($path): FILE NOT FOUND\n";
        continue;
    }
    $info = @getimagesize($fullPath);
    $mime = $info ? $info['mime'] : 'unknown';
    echo "$theme: mime={$mime}, width={$info[0]}, height={$info[1]}";
    
    $im = null;
    if ($mime === 'image/png') {
        $im = @imagecreatefrompng($fullPath);
    } elseif ($mime === 'image/jpeg') {
        $im = @imagecreatefromjpeg($fullPath);
    } elseif ($mime === 'image/gif') {
        $im = @imagecreatefromgif($fullPath);
    }

    if ($im) {
        $c = imagecolorat($im, 0, 0);
        $rgba = imagecolorsforindex($im, $c);
        echo " | corner RGB=({$rgba['red']},{$rgba['green']},{$rgba['blue']}) alpha={$rgba['alpha']}\n";
    } else {
        echo " | FAILED TO LOAD GD\n";
    }
}

