<?php
// Database migration for Freynix FluxCP CMS Expansion
header('Content-Type: text/plain');

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix;charset=utf8mb4', 'admin', 'Maki0913$', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "Connected to MySQL freynix database successfully.\n";

    // Helper to check if column exists
    $columnExists = function($table, $column) use ($pdo) {
        $stmt = $pdo->prepare("SHOW COLUMNS FROM `$table` LIKE ?");
        $stmt->execute([$column]);
        return (bool)$stmt->fetch();
    };

    // 1. Alter cp_cmspages
    echo "Checking cp_cmspages columns...\n";
    if (!$columnExists('cp_cmspages', 'status')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'published' AFTER `title`");
        echo " + Added status to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'meta_description')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `meta_description` VARCHAR(255) NULL AFTER `body`");
        echo " + Added meta_description to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'meta_keywords')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `meta_keywords` VARCHAR(255) NULL AFTER `meta_description`");
        echo " + Added meta_keywords to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'template')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `template` VARCHAR(50) NOT NULL DEFAULT 'default' AFTER `meta_keywords`");
        echo " + Added template to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'featured_image')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `featured_image` VARCHAR(255) NULL AFTER `template`");
        echo " + Added featured_image to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'sort_order')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `sort_order` INT(11) NOT NULL DEFAULT 0 AFTER `featured_image`");
        echo " + Added sort_order to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'is_nav')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `is_nav` TINYINT(1) NOT NULL DEFAULT 0 AFTER `sort_order`");
        echo " + Added is_nav to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'parent_id')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `parent_id` INT(11) NOT NULL DEFAULT 0 AFTER `is_nav`");
        echo " + Added parent_id to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'min_group_level')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `min_group_level` INT(11) NOT NULL DEFAULT 0 AFTER `parent_id`");
        echo " + Added min_group_level to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'published_at')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `published_at` DATETIME NULL AFTER `min_group_level`");
        echo " + Added published_at to cp_cmspages\n";
    }
    if (!$columnExists('cp_cmspages', 'created_at')) {
        $pdo->exec("ALTER TABLE `cp_cmspages` ADD COLUMN `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `published_at`");
        echo " + Added created_at to cp_cmspages\n";
    }

    // 2. Alter cp_cmsnews
    echo "Checking cp_cmsnews columns...\n";
    if (!$columnExists('cp_cmsnews', 'category')) {
        $pdo->exec("ALTER TABLE `cp_cmsnews` ADD COLUMN `category` VARCHAR(50) NOT NULL DEFAULT 'Update' AFTER `title`");
        echo " + Added category to cp_cmsnews\n";
    }
    if (!$columnExists('cp_cmsnews', 'status')) {
        $pdo->exec("ALTER TABLE `cp_cmsnews` ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'published' AFTER `category`");
        echo " + Added status to cp_cmsnews\n";
    }
    if (!$columnExists('cp_cmsnews', 'is_pinned')) {
        $pdo->exec("ALTER TABLE `cp_cmsnews` ADD COLUMN `is_pinned` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`");
        echo " + Added is_pinned to cp_cmsnews\n";
    }
    if (!$columnExists('cp_cmsnews', 'featured_image')) {
        $pdo->exec("ALTER TABLE `cp_cmsnews` ADD COLUMN `featured_image` VARCHAR(255) NULL AFTER `is_pinned`");
        echo " + Added featured_image to cp_cmsnews\n";
    }
    if (!$columnExists('cp_cmsnews', 'published_at')) {
        $pdo->exec("ALTER TABLE `cp_cmsnews` ADD COLUMN `published_at` DATETIME NULL AFTER `featured_image`");
        echo " + Added published_at to cp_cmsnews\n";
    }

    // 3. Create cp_downloads
    echo "Creating cp_downloads table if not exists...\n";
    $pdo->exec("CREATE TABLE IF NOT EXISTS `cp_downloads` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(100) NOT NULL,
        `category` VARCHAR(50) NOT NULL DEFAULT 'Full Client',
        `description` TEXT NULL,
        `version` VARCHAR(50) NULL,
        `file_size` VARCHAR(50) NULL,
        `url_mirror1` VARCHAR(255) NOT NULL,
        `url_mirror2` VARCHAR(255) NULL,
        `url_mirror3` VARCHAR(255) NULL,
        `display_order` INT(11) NOT NULL DEFAULT 0,
        `status` VARCHAR(20) NOT NULL DEFAULT 'published',
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo " + cp_downloads table ready\n";

    // Seed cp_downloads if empty
    $count = $pdo->query("SELECT COUNT(*) FROM `cp_downloads`")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO `cp_downloads` (`title`, `category`, `description`, `version`, `file_size`, `url_mirror1`, `url_mirror2`, `url_mirror3`, `display_order`, `status`) VALUES
        ('Freynix Full Game Client', 'Full Client', 'Complete standalone game client pre-patched with all sound, BGM, sprite, and data files. Recommended for all new players.', 'v2.0.0', '2.8 GB', 'https://mega.nz/', 'https://drive.google.com/', 'https://www.mediafire.com/', 1, 'published'),
        ('Freynix Lite Client Package', 'Lite Client', 'Contains only the Freynix GRF, client executable, and custom sprites. Extract directly into a clean, updated Ragnarok Online directory.', 'v2.0.0', '250 MB', 'https://drive.google.com/', 'https://mega.nz/', NULL, 2, 'published'),
        ('Freynix Manual Cumulative Patch', 'Manual Patch', 'Manual update archive for players experiencing automatic patching issues.', 'Patch 2.0.1', '45 MB', 'https://drive.google.com/', NULL, NULL, 3, 'published');");
        echo " + Seeded initial downloads into cp_downloads\n";
    }

    // 4. Create cp_navigation
    echo "Creating cp_navigation table if not exists...\n";
    $pdo->exec("CREATE TABLE IF NOT EXISTS `cp_navigation` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `location` VARCHAR(20) NOT NULL DEFAULT 'main',
        `title` VARCHAR(100) NOT NULL,
        `url_type` VARCHAR(20) NOT NULL DEFAULT 'internal',
        `url_val` VARCHAR(255) NOT NULL,
        `parent_id` INT(11) NOT NULL DEFAULT 0,
        `sort_order` INT(11) NOT NULL DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `min_group_level` INT(11) NOT NULL DEFAULT 0,
        `target_blank` TINYINT(1) NOT NULL DEFAULT 0,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo " + cp_navigation table ready\n";

    // Seed cp_navigation if empty
    $navCount = $pdo->query("SELECT COUNT(*) FROM `cp_navigation`")->fetchColumn();
    if ($navCount == 0) {
        $pdo->exec("INSERT INTO `cp_navigation` (`location`, `title`, `url_type`, `url_val`, `parent_id`, `sort_order`, `is_active`) VALUES
        ('main', 'Home', 'internal', 'main/index', 0, 1, 1),
        ('main', 'Downloads', 'internal', 'main/downloads', 0, 2, 1),
        ('main', 'Rankings', 'internal', 'ranking/character', 0, 3, 1),
        ('main', 'War of Emperium', 'internal', 'woe/index', 0, 4, 1),
        ('main', 'Information', 'internal', 'server/info', 0, 5, 1),
        ('main', 'Donations', 'internal', 'donate/index', 0, 6, 1),
        ('main', 'Community', 'external', 'https://discord.gg/', 0, 7, 1);");

        // Submenus
        $rankParent = $pdo->query("SELECT id FROM cp_navigation WHERE title = 'Rankings' LIMIT 1")->fetchColumn();
        if ($rankParent) {
            $pdo->exec("INSERT INTO `cp_navigation` (`location`, `title`, `url_type`, `url_val`, `parent_id`, `sort_order`, `is_active`) VALUES
            ('main', 'Character Ranking', 'internal', 'ranking/character', $rankParent, 1, 1),
            ('main', 'Guild Ranking', 'internal', 'ranking/guild', $rankParent, 2, 1),
            ('main', 'MVP Ranking', 'internal', 'ranking/mvp', $rankParent, 3, 1),
            ('main', 'Zeny Ranking', 'internal', 'ranking/zeny', $rankParent, 4, 1);");
        }

        $woeParent = $pdo->query("SELECT id FROM cp_navigation WHERE title = 'War of Emperium' LIMIT 1")->fetchColumn();
        if ($woeParent) {
            $pdo->exec("INSERT INTO `cp_navigation` (`location`, `title`, `url_type`, `url_val`, `parent_id`, `sort_order`, `is_active`) VALUES
            ('main', 'WoE Timetable', 'internal', 'woe/index', $woeParent, 1, 1),
            ('main', 'Castle Ownership', 'internal', 'castle/index', $woeParent, 2, 1);");
        }

        $infoParent = $pdo->query("SELECT id FROM cp_navigation WHERE title = 'Information' LIMIT 1")->fetchColumn();
        if ($infoParent) {
            $pdo->exec("INSERT INTO `cp_navigation` (`location`, `title`, `url_type`, `url_val`, `parent_id`, `sort_order`, `is_active`) VALUES
            ('main', 'Server Info', 'internal', 'server/info', $infoParent, 1, 1),
            ('main', 'Server Status', 'internal', 'server/status', $infoParent, 2, 1),
            ('main', 'Item Database', 'internal', 'item/index', $infoParent, 3, 1),
            ('main', 'Monster Database', 'internal', 'monster/index', $infoParent, 4, 1),
            ('main', 'Who\\'s Online', 'internal', 'character/online', $infoParent, 5, 1);");
        }

        $donateParent = $pdo->query("SELECT id FROM cp_navigation WHERE title = 'Donations' LIMIT 1")->fetchColumn();
        if ($donateParent) {
            $pdo->exec("INSERT INTO `cp_navigation` (`location`, `title`, `url_type`, `url_val`, `parent_id`, `sort_order`, `is_active`) VALUES
            ('main', 'Make a Donation', 'internal', 'donate/index', $donateParent, 1, 1),
            ('main', 'Donation Shop', 'internal', 'purchase/index', $donateParent, 2, 1);");
        }

        // Footer links
        $pdo->exec("INSERT INTO `cp_navigation` (`location`, `title`, `url_type`, `url_val`, `parent_id`, `sort_order`, `is_active`) VALUES
        ('footer', 'Home Portal', 'internal', 'main/index', 0, 1, 1),
        ('footer', 'Create Account', 'internal', 'account/create', 0, 2, 1),
        ('footer', 'Download Client', 'internal', 'main/downloads', 0, 3, 1),
        ('footer', 'Character Leaderboard', 'internal', 'ranking/character', 0, 4, 1),
        ('footer', 'War of Emperium', 'internal', 'woe/index', 0, 5, 1),
        ('footer', 'Terms of Service', 'internal', 'service/tos', 0, 6, 1),
        ('footer', 'Support Desk', 'internal', 'servicedesk/index', 0, 7, 1);");

        echo " + Seeded initial navigation items\n";
    }

    // 5. Modify cp_cmssettings to allow TEXT
    echo "Updating cp_cmssettings schema...\n";
    $pdo->exec("ALTER TABLE `cp_cmssettings` MODIFY `value` TEXT NOT NULL;");

    // Seed default global site settings
    $defaultSettings = [
        'site_title'         => 'Freynix Ragnarok Online',
        'site_slogan'        => 'FORGE YOUR FREEDOM.',
        'site_description'   => 'Experience classic Ragnarok Online on Freynix! High-rate 1000x progression, 99/70 pre-renewal, competitive PvP, and epic War of Emperium battles.',
        'site_keywords'      => 'Ragnarok Online, Freynix RO, Pre-Renewal, High Rate, PvP, WoE, MVP hunting',
        'discord_url'        => 'https://discord.gg/',
        'facebook_url'       => 'https://facebook.com/',
        'youtube_url'        => '',
        'contact_email'      => 'support@freynix-ro.com',
        'maintenance_mode'   => '0',
        'maintenance_notice' => 'Server maintenance is currently scheduled. Game servers remain fully operational.',
        'footer_disclaimer'  => 'FREYNIX is an independent, community-driven game server operating for entertainment and educational purposes. Ragnarok Online and all associated assets are property of Gravity Co., Ltd. and Lee Myung-jin.',
        
        // Homepage Section Controls
        'hp_hero_enabled'        => '1',
        'hp_hero_heading'        => 'FREYNIX RAGNAROK ONLINE',
        'hp_hero_subtitle'       => 'FORGE YOUR FREEDOM.',
        'hp_hero_description'    => 'Experience the nostalgia of classic Ragnarok Online with high-rate progression, competitive PvP, intense War of Emperium battles, and legendary MVP hunting.',
        'hp_hero_btn1_text'      => 'CREATE ACCOUNT',
        'hp_hero_btn1_link'      => 'account/create',
        'hp_hero_btn2_text'      => 'PLAY NOW',
        'hp_hero_btn2_link'      => 'account/login',
        'hp_status_enabled'      => '1',
        'hp_features_enabled'    => '1',
        'hp_news_enabled'        => '1',
        'hp_news_limit'          => '3',
        'hp_rankings_enabled'    => '1',
        'hp_rankings_limit'      => '5',
        'hp_community_enabled'   => '1',
        'hp_community_heading'   => 'READY TO FORGE YOUR FREEDOM?',
        'hp_community_text'      => 'Download the full game client, grab your starter pack in Prontera, and enter the next generation of pre-renewal Ragnarok Online.'
    ];

    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM `cp_cmssettings` WHERE `name` = ?");
    $insertStmt = $pdo->prepare("INSERT INTO `cp_cmssettings` (`name`, `value`) VALUES (?, ?)");
    foreach ($defaultSettings as $name => $value) {
        $checkStmt->execute([$name]);
        if ($checkStmt->fetchColumn() == 0) {
            $insertStmt->execute([$name, $value]);
            echo " + Seeded setting: $name\n";
        }
    }

    // 6. Service Desk categories
    echo "Checking cp_servicedeskcat...\n";
    $catCount = $pdo->query("SELECT COUNT(*) FROM `cp_servicedeskcat`")->fetchColumn();
    if ($catCount == 0) {
        $pdo->exec("INSERT INTO `cp_servicedeskcat` (`cat_id`, `name`, `display`) VALUES
        (1, 'Account Assistance', 1),
        (2, 'Bug Report & Glitches', 1),
        (3, 'Donations & Credits', 1),
        (4, 'Gameplay & Quest Issues', 1),
        (5, 'Player Grievance & Reports', 1);");
        echo " + Seeded default ticket categories into cp_servicedeskcat\n";
    }

    // Ensure cp_cmsnews link column allows empty string or has default
    $pdo->exec("ALTER TABLE `cp_cmsnews` MODIFY `link` VARCHAR(255) NOT NULL DEFAULT '';");

    // 7. Seed initial news if empty
    $newsCount = $pdo->query("SELECT COUNT(*) FROM `cp_cmsnews`")->fetchColumn();
    if ($newsCount == 0) {
        $pdo->exec("INSERT INTO `cp_cmsnews` (`title`, `category`, `status`, `is_pinned`, `author`, `link`, `body`, `created`, `modified`) VALUES
        ('Grand Opening: Welcome to Freynix RO!', 'Update', 'published', 1, 'Freynix Team', '', '<p>Welcome adventurers to <strong>FREYNIX RAGNAROK ONLINE</strong>! We are thrilled to welcome you to our high-rate pre-renewal world featuring 1000x EXP, 99/70 max level, 1% selected MVP card drops, and weekly War of Emperium castle sieges. Forge your freedom today!</p>', NOW(), NOW()),
        ('War of Emperium Timetable & Castle Rewards', 'WoE', 'published', 0, 'Server Staff', '', '<p>Prepare your guilds for castle supremacy! Castles across Rune-Midgarts are primed for battle. Visit the WoE Portal to review the active timetable and daily Kafra castle treasure rewards.</p>', NOW(), NOW()),
        ('Novice to Champion: PvP Arenas Now Open', 'Event', 'published', 0, 'Event Team', '', '<p>Test your character builds in our 24/7 battlegrounds and automated PvP arenas. Earn PvP honor tokens and claim rare cosmetic rewards in Prontera.</p>', NOW(), NOW());");
        echo " + Seeded initial news announcements into cp_cmsnews\n";
    }

    echo "\n=== MIGRATION COMPLETED SUCCESSFULLY ===\n";

} catch (Exception $e) {
    echo "Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
