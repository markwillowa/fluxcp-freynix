<?php
set_include_path(__DIR__ . '/lib' . PATH_SEPARATOR . get_include_path());
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = '/?module=downloads&action=edit&id=1';
$_GET['module'] = 'downloads';
$_GET['action'] = 'edit';
$_GET['id'] = '1';

ob_start();
require 'index.php';
$html = ob_get_clean();

echo "HTML Length: " . strlen($html) . "\n";
if (strpos($html, 'Undefined variable $download') !== false) {
    echo "FAIL: Undefined variable \$download still present!\n";
} else {
    echo "PASS: No Undefined variable \$download!\n";
}

if (strpos($html, 'Full Game Client (Recommended)') !== false) {
    echo "PASS: Package title rendered correctly in edit form!\n";
} else {
    echo "FAIL: Package title not found in output!\n";
}

if (strpos($html, 'MODIFY PACKAGE ARCHIVE') !== false || strpos($html, 'EDIT DOWNLOAD') !== false) {
    echo "PASS: Luxury Elysian edit form template rendered!\n";
} else {
    echo "FAIL: Luxury edit form not found!\n";
}

if (strpos($html, 'nexus-') !== false) {
    echo "FAIL: Stray nexus-* class found in output!\n";
} else {
    echo "PASS: Zero stray nexus-* classes!\n";
}
