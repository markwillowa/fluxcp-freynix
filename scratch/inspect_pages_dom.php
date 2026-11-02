<?php
$html = file_get_contents(__DIR__ . '/pages_output.html');
if (preg_match('/<main class="main-content-panel">(.*?)<\/main>/s', $html, $matches)) {
    echo "=== FOUND MAIN PANEL ===\n";
    echo substr($matches[1], 0, 1000) . "\n...\n";
} else {
    echo "main-content-panel NOT FOUND!\n";
}

// Check for table-responsive
if (strpos($html, 'table-responsive') !== false) {
    echo "\n>>> table-responsive is present in HTML.\n";
} else {
    echo "\n>>> table-responsive is MISSING in HTML.\n";
}

// Check for horizontal-table
if (strpos($html, 'horizontal-table') !== false) {
    echo ">>> horizontal-table is present in HTML.\n";
}

// Check CSS references
preg_match_all('/<link rel="stylesheet"[^>]+>/i', $html, $cssLinks);
echo "\n=== CSS LINKS ===\n";
foreach ($cssLinks[0] as $link) {
    echo $link . "\n";
}

