<?php
$html = file_get_contents('themes/freynix/homepage/index.php');
preg_match_all('/name="([^"]+)"/i', $html, $m);
$names = array_unique($m[1]);
sort($names);
echo "All inputs in themes/freynix/homepage/index.php:\n";
print_r($names);

