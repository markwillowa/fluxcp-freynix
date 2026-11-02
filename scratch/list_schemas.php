<?php
$files = glob('C:/xampp/htdocs/fluxcp-freynix/data/schemas/*/*.sql');
$tables = array();
foreach ($files as $file) {
    $content = file_get_contents($file);
    if (preg_match_all('/CREATE TABLE (?:IF NOT EXISTS )?`?([a-zA-Z0-9_]+)`?/i', $content, $m)) {
        foreach ($m[1] as $tbl) {
            $type = strpos($file, 'charmapdb') !== false ? 'charmapdb' : 'logindb';
            $tables[$tbl][] = basename($file) . " ($type)";
        }
    }
}

ksort($tables);
echo "All tables defined in data/schemas/:\n";
foreach ($tables as $tbl => $srcs) {
    echo "- $tbl: " . implode(', ', array_unique($srcs)) . "\n";
}

