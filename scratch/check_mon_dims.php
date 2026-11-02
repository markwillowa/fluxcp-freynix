<?php
$monsters = ['baphomet.gif', 'valkyrie.gif', 'gtb.gif', 'moonlight.gif', 'ifrit.gif', 'angeling.gif', 'deviling.gif'];
foreach ($monsters as $m) {
    $p = "themes/freynix/img/monsters/$m";
    if (file_exists($p)) {
        $info = getimagesize($p);
        echo "$m: {$info[0]} x {$info[1]}\n";
    }
}

