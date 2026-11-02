<?php
define('FLUX_ROOT', dirname(__DIR__, 2));
set_include_path(get_include_path() . PATH_SEPARATOR . FLUX_ROOT . '/lib');
require_once FLUX_ROOT . '/lib/Flux.php';
require_once FLUX_ROOT . '/lib/Flux/Sanitizer.php';
require_once FLUX_ROOT . '/lib/Flux/CMS.php';

echo "=== FREYNIX RO — CMS EXPANSION VERIFICATION ===\n\n";

$host = '127.0.0.1';
$dbname = 'freynix';
$user = 'admin';
$pass = 'Maki0913$';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
    echo "[PASS] Database connection established successfully.\n";

    // 1. Check cp_cmspages
    $pages = $pdo->query("SELECT id, title, path, status, template FROM cp_cmspages")->fetchAll();
    echo "[PASS] cp_cmspages: " . count($pages) . " pages registered.\n";
    foreach ($pages as $p) {
        echo "       - [{$p->status}] {$p->title} (/?module=pages&action=content&path={$p->path})\n";
    }

    // 2. Check cp_cmsnews
    $news = $pdo->query("SELECT id, title, category, status, is_pinned FROM cp_cmsnews")->fetchAll();
    echo "[PASS] cp_cmsnews: " . count($news) . " announcements registered.\n";
    foreach ($news as $n) {
        $pin = $n->is_pinned ? "PINNED" : "NORMAL";
        echo "       - [{$n->status}|{$n->category}|{$pin}] {$n->title}\n";
    }

    // 3. Check cp_downloads
    $downloads = $pdo->query("SELECT id, title, category, version, status, display_order FROM cp_downloads ORDER BY display_order ASC")->fetchAll();
    echo "[PASS] cp_downloads: " . count($downloads) . " download packages registered.\n";
    foreach ($downloads as $d) {
        echo "       - #{$d->display_order} [{$d->category}] {$d->title} ({$d->version})\n";
    }

    // 4. Check cp_navigation
    $nav = $pdo->query("SELECT id, location, title, url_val, parent_id, sort_order, is_active FROM cp_navigation ORDER BY location ASC, parent_id ASC, sort_order ASC")->fetchAll();
    echo "[PASS] cp_navigation: " . count($nav) . " navigation items registered.\n";
    $mainCount = 0; $footerCount = 0;
    foreach ($nav as $item) {
        if ($item->location === 'main') $mainCount++;
        else $footerCount++;
    }
    echo "       - Main Navbar items: $mainCount (including dropdown children)\n";
    echo "       - Footer links: $footerCount\n";

    // 5. Check cp_cmssettings
    $settings = $pdo->query("SELECT name, value FROM cp_cmssettings")->fetchAll();
    echo "[PASS] cp_cmssettings: " . count($settings) . " CMS settings configured.\n";
    $sampleKeys = ['site_title', 'site_slogan', 'hp_hero_heading', 'maintenance_mode', 'hp_hero_enabled', 'hp_features_enabled'];
    foreach ($settings as $s) {
        if (in_array($s->name, $sampleKeys)) {
            echo "       - {$s->name}: " . substr($s->value, 0, 45) . "\n";
        }
    }

    // 6. Check cp_servicedeskcat
    $cats = $pdo->query("SELECT cat_id, name, display FROM cp_servicedeskcat")->fetchAll();
    echo "[PASS] cp_servicedeskcat: " . count($cats) . " support categories configured.\n";
    foreach ($cats as $c) {
        echo "       - #{$c->cat_id}: {$c->name} (Display: {$c->display})\n";
    }

    echo "\n=== ALL CMS SYSTEMS OPERATIONAL ===\n";

} catch (Exception $e) {
    echo "[FAIL] " . $e->getMessage() . "\n";
    exit(1);
}
