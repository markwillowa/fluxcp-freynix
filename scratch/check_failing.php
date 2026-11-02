<?php
$h = file_get_contents(__DIR__ . '/install_step1.html');
if (preg_match_all('/badge-danger[^\>]*\>(.*?)\<\/span\>/is', $h, $m)) {
    echo "Failing checks:\n";
    print_r($m[1]);
} else {
    echo "No badge-danger found.\n";
}
if (preg_match('/<div class="alert-banner danger".*?<\/div>/is', $h, $m)) {
    echo "Alert banner:\n" . $m[0] . "\n";
}

