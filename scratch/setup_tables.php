<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');

$pdo->exec("ALTER TABLE `cp_cmsnews` MODIFY `link` varchar(100) DEFAULT ''");
$pdo->exec("ALTER TABLE `cp_cmsnews` MODIFY `created` datetime DEFAULT CURRENT_TIMESTAMP");
$pdo->exec("ALTER TABLE `cp_cmsnews` MODIFY `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

$cntNews = $pdo->query("SELECT COUNT(*) FROM cp_cmsnews")->fetchColumn();
if ($cntNews == 0) {
    $pdo->exec("INSERT INTO `cp_cmsnews` (`title`, `body`, `link`, `author`, `created`, `modified`, `category`, `is_pinned`, `status`, `published_at`) VALUES
        ('Welcome to Celestial Chronicle!', '<p>Welcome to our celestial anime-fantasy realm! Explore skyward dungeons, conquer castles, and write your legend.</p>', '', 'Administration', NOW(), NOW(), 'Announcement', 1, 'published', NOW())");
    echo "Welcome news seeded.\n";
}

echo "Done.\n";
