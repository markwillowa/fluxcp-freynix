<?php
$f = 'scratch/ratemyserver.gif';
$info = @getimagesize($f);
if ($info) {
    echo "Dimensions: {$info[0]} x {$info[1]}, Mime: {$info['mime']}\n";
} else {
    echo "Not a valid image, first 200 chars:\n" . substr(file_get_contents($f), 0, 200) . "\n";
}

