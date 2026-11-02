<?php
$sampleData = [
    // 1. Hero Banner
    'hp_hero_title'        => 'Your Realm. Your Freedom.',
    'hp_hero_subtitle'     => 'FREYNIX RAGNAROK ONLINE',
    'hp_hero_desc'         => 'Experience authentic Pre-Renewal Ragnarok Online reimagined. High-rate 1000x progression, 1% hunted MVP card drops, weekly War of Emperium sieges, and pure competitive freedom.',
    'hp_hero_btn1_text'    => 'Play Now',
    'hp_hero_btn1_url'     => 'account/create',
    'hp_hero_btn2_text'    => 'Explore Server',
    'hp_hero_btn2_url'     => 'server/info',
    'hp_hero_bg_image'     => '',
    'hp_show_hero'         => '1',

    // 2. Server Status & Rates
    'hp_show_status'       => '1',
    'hp_status_rates_text' => '1000x / 1000x',
    'hp_status_base_level' => '99',
    'hp_status_job_level'  => '70',
    'hp_status_mode_text'  => 'Pre-Renewal',

    // 3. 6 Core Distinctive Features
    'hp_show_features'     => '1',
    'hp_feature_1_title'   => 'INSTANT REBIRTH & 1000x RATES',
    'hp_feature_1_desc'    => 'Leap straight into the heat of combat with fast-paced 1000x EXP & Job progression, instant transcendence job changes, and automated stat resetters.',
    'hp_feature_2_title'   => 'COMPETITIVE 1% MVP CARD HUNTS',
    'hp_feature_2_desc'    => 'Every world boss drops authentic 1% MVP cards. No pay-to-win god items; legendary equipment is earned on the battlefield by dedicated guild parties.',
    'hp_feature_3_title'   => 'EPIC WAR OF EMPERIUM SIEGES',
    'hp_feature_3_desc'    => 'Engage in intense guild-versus-guild castle warfare twice every week. Compete for custom castle chest rewards, godly relics, and server-wide prestige.',
    'hp_feature_4_title'   => 'BALANCED PRE-RENEWAL PVP',
    'hp_feature_4_desc'    => 'Refined 99/70 combat mechanics where skill timing, elemental converters, and guild coordination determine victory. No broken third-job mechanics.',
    'hp_feature_5_title'   => 'BASIC CARDS & ACTIVE ECONOMY',
    'hp_feature_5_desc'    => 'Starter card merchants help you craft your PvP and leveling sets rapidly, keeping the economy focused on rare MVPs, costume quests, and refining.',
    'hp_feature_6_title'   => 'DEDICATED GM TEAM & PROTECTION',
    'hp_feature_6_desc'    => 'Powered by modern rAthena with enterprise Gepard Shield anti-cheat protection, 99.9% uptime, daily database backups, and 24/7 GM support.',

    // 4. Section Toggles
    'hp_show_news'         => '1',
    'hp_show_rankings'     => '1',
    'hp_show_woe'          => '1',

    // 5. WoE Headline & Description
    'hp_woe_headline'      => 'WAR OF EMPERIUM: CLASH FOR CASTLE SUPREMACY',
    'hp_woe_desc'          => 'Assemble your allies, raise your banners, and claim castle treasures. Weekly sieges feature competitive guild battles, custom castle chest rewards, and server-wide recognition.',

    // 6. Community & Social Callouts
    'hp_show_discord'      => '1',
    'hp_discord_title'     => 'JOIN THE FREYNIX ADVENTURERS ON DISCORD',
    'hp_discord_desc'      => 'Connect with fellow guild leaders, trade items, find party members, participate in community giveaways, and talk directly with Game Masters.',
    'hp_discord_btn_text'  => 'JOIN OUR DISCORD COMMUNITY',
    'discord_url'          => 'https://discord.gg/freynix',
    'hp_discord_url'       => 'https://discord.gg/freynix',
    'facebook_url'         => 'https://facebook.com/FreynixRO',
    'hp_facebook_url'      => 'https://facebook.com/FreynixRO',

    // Compatibility mirror aliases
    'hp_hero_enabled'      => '1',
    'hp_status_enabled'    => '1',
    'hp_features_enabled'  => '1',
    'hp_news_enabled'      => '1',
    'hp_rankings_enabled'  => '1',
    'hp_community_enabled' => '1',
    'hp_hero_heading'      => 'Your Realm. Your Freedom.',
    'hp_hero_description'  => 'Experience authentic Pre-Renewal Ragnarok Online reimagined. High-rate 1000x progression, 1% hunted MVP card drops, weekly War of Emperium sieges, and pure competitive freedom.',
    'hp_hero_btn1_link'    => 'account/create',
    'hp_hero_btn2_link'    => 'server/info',
    'hp_community_heading' => 'JOIN THE FREYNIX ADVENTURERS ON DISCORD',
    'hp_community_text'    => 'Connect with fellow guild leaders, trade items, find party members, participate in community giveaways, and talk directly with Game Masters.'
];

$pdo = new PDO('mysql:host=127.0.0.1;dbname=freynix', 'admin', 'Maki0913$');
$stmt = $pdo->prepare("INSERT INTO cp_cmssettings (name, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)");

$count = 0;
foreach ($sampleData as $key => $val) {
    $stmt->execute([$key, $val]);
    $count++;
}

echo "Successfully populated $count sample settings in cp_cmssettings!\n";

// Clear cached ServerStatus or CMS cache if any
@unlink('data/tmp/ServerStatus.cache');

