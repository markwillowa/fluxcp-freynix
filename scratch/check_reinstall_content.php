<?php
$h = file_get_contents(__DIR__ . '/reinstall_output.html');
echo "HTML Length: " . strlen($h) . "\n";
if (preg_match('/<title>(.*?)<\/title>/is', $h, $m)) echo "Title: " . $m[1] . "\n";
if (preg_match('/<h[1-3]>(.*?)<\/h[1-3]>/is', $h, $m)) echo "Header: " . $m[1] . "\n";
if (stripos($h, 'login') !== false && stripos($h, 'username') !== false) {
    echo "Requires login!\n";
}

