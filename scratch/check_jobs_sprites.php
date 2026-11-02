<?php
foreach (glob('themes/freynix/img/jobs/*.png') as $f) {
    $info = getimagesize($f);
    echo basename($f) . ": {$info[0]}x{$info[1]}\n";
}

