<?php
$exts = array('pdo', 'pdo_mysql', 'curl', 'xml', 'xmlreader', 'mysqli');
foreach ($exts as $e) {
    echo $e . ': ' . (extension_loaded($e) ? 'LOADED' : 'NOT LOADED') . "\n";
}

