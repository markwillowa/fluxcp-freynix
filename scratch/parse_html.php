<?php
$html = file_get_contents('scratch/irowiki_lk.png');
preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m);
echo "IMG tags:\n";
foreach (array_slice($m[1], 0, 15) as $u) echo $u . "\n";

preg_match_all('/href=["\']([^"\']+\.(?:png|jpg|jpeg|gif))["\']/i', $html, $m2);
echo "HREF links:\n";
foreach (array_slice($m2[1], 0, 15) as $u) echo $u . "\n";

