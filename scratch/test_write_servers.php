<?php
$f = @fopen('config/servers.php', 'r+');
if ($f) {
    echo "Can open for r+ (read and write)!\n";
    fclose($f);
} else {
    echo "Cannot open for r+!\n";
}
