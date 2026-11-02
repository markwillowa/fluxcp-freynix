<?php
$h = file_get_contents(__DIR__ . '/account_view_output.html');
if (preg_match('/<div class="account-info-grid">(.*?)<\/div>\s*<\/main>/s', $h, $m)) {
    echo $m[0];
} else {
    echo "Could not match regex\n";
}

