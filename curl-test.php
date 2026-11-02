<?php
header('Content-Type: text/plain');

echo "PHP Version: " . PHP_VERSION . "\n";
echo "PHP INI: " . php_ini_loaded_file() . "\n";
echo "Extension Directory: " . ini_get('extension_dir') . "\n";
echo "cURL Loaded: " . (extension_loaded('curl') ? 'YES' : 'NO') . "\n";
echo "curl_init Available: " . (function_exists('curl_init') ? 'YES' : 'NO') . "\n";

if (extension_loaded('curl')) {
    print_r(curl_version());
}
