<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');

$schemaFiles = array_merge(
    glob(__DIR__ . '/../data/schemas/logindb/*.sql') ?: array(),
    glob(__DIR__ . '/../data/schemas/charmapdb/*.sql') ?: array()
);

echo "Total schema files: " . count($schemaFiles) . "\n";
foreach ($schemaFiles as $file) {
    $sql = file_get_contents($file);
    try {
        $pdo->exec($sql);
        echo "OK: " . basename($file) . "\n";
    } catch (Exception $e) {
        echo "ERR: " . basename($file) . ": " . $e->getMessage() . "\n";
    }
}

// Ensure default admin news and navigation exist
$checkNav = $pdo->query("SELECT COUNT(*) FROM cp_navigation")->fetchColumn();
if ($checkNav == 0) {
    $pdo->exec("INSERT INTO cp_navigation (`name`, `url_val`, `url_type`, `location`, `sort_order`, `is_active`) VALUES
        ('Home', 'main/index', 'internal', 'main', 1, 1),
        ('News', 'news/index', 'internal', 'main', 2, 1),
        ('Server Info', 'server/info', 'internal', 'main', 3, 1),
        ('Rankings', 'ranking/character', 'internal', 'main', 4, 1),
        ('Downloads', 'main/downloads', 'internal', 'main', 5, 1),
        ('Support Desk', 'servicedesk/index', 'internal', 'main', 6, 1),
        ('Rules', 'pages/content/rules', 'internal', 'footer', 1, 1),
        ('Terms of Service', 'service/tos', 'internal', 'footer', 2, 1),
        ('Item Shop', 'purchase/index', 'internal', 'footer', 3, 1)");
    echo "Navigation seeded.\n";
}

$checkNews = $pdo->query("SELECT COUNT(*) FROM cp_cmsnews")->fetchColumn();
if ($checkNews == 0) {
    $pdo->exec("INSERT INTO cp_cmsnews (`title`, `body`, `author`, `created`, `modified`, `category`, `is_pinned`, `status`) VALUES
        ('Welcome to Celestial Chronicle!', '<p>Welcome to our celestial anime-fantasy Ragnarok Online realm! Explore skyward dungeons, conquer castles, and write your legend.</p>', 'Administration', NOW(), NOW(), 'Announcement', 1, 'published')");
    echo "Welcome news seeded.\n";
}

$tables = $pdo->query("SHOW TABLES LIKE 'cp_%'")->fetchAll(PDO::FETCH_COLUMN);
echo "Total CP tables now: " . count($tables) . "\n";

