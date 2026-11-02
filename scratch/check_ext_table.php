<?php
$h = file_get_contents(__DIR__ . '/install_step1.html');
if (preg_match_all('/<tr>\s*<td><code>(.*?)<\/code><\/td>\s*<td>\s*<span class="badge-(.*?)">(.*?)<\/span>/is', $h, $m, PREG_SET_ORDER)) {
    foreach ($m as $row) {
        echo $row[1] . " => " . $row[2] . " (" . strip_tags($row[3]) . ")\n";
    }
}

