<?php
$servers = require 'config/servers.php';
echo "Loaded servers count: " . count($servers) . "\n";
echo "ServerName: " . $servers[0]['ServerName'] . "\n";
echo "Hostname: " . $servers[0]['DbConfig']['Hostname'] . "\n";
echo "Username: " . $servers[0]['DbConfig']['Username'] . "\n";
echo "Database: " . $servers[0]['DbConfig']['Database'] . "\n";
