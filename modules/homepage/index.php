<?php
if (!defined('FLUX_ROOT')) exit;

require_once FLUX_LIB_DIR . '/Flux/CMS.php';
require_once FLUX_LIB_DIR . '/Flux/Sanitizer.php';

$title = 'Homepage CMS & Section Controls';

if (count($_POST)) {
	$fields = array(
		'server_name',
		'site_slogan',
		'site_logo_url',
		'site_footer_disclaimer',
		'hp_hero_title',
		'hp_hero_subtitle',
		'hp_hero_desc',
		'hp_hero_btn1_text',
		'hp_hero_btn1_url',
		'hp_hero_btn2_text',
		'hp_hero_btn2_url',
		'hp_hero_bg_image',
		'hp_show_hero',
		'hp_show_status',
		'hp_show_features',
		'hp_show_news',
		'hp_show_rankings',
		'hp_show_woe',
		'hp_show_discord',
		'hp_status_rates_text',
		'hp_status_base_level',
		'hp_status_job_level',
		'hp_status_mode_text',
		'hp_feature_1_title',
		'hp_feature_1_desc',
		'hp_feature_2_title',
		'hp_feature_2_desc',
		'hp_feature_3_title',
		'hp_feature_3_desc',
		'hp_feature_4_title',
		'hp_feature_4_desc',
		'hp_feature_5_title',
		'hp_feature_5_desc',
		'hp_feature_6_title',
		'hp_feature_6_desc',
		'hp_woe_headline',
		'hp_woe_desc',
		'hp_discord_title',
		'hp_discord_desc',
		'hp_discord_btn_text',
		'discord_url',
		'facebook_url'
	);

	foreach ($fields as $field) {
		$val = $params->get($field);
		if ($val === null) {
			if (strpos($field, 'hp_show_') === 0) {
				$val = '0';
			} else {
				continue;
			}
		}
		$valStr = trim((string)$val);
		Flux_CMS::set($field, $valStr, $server);

		// Mirror compatibility aliases
		if ($field === 'server_name') {
			Flux_CMS::set('site_title', $valStr, $server);
		}
		if ($field === 'site_footer_disclaimer') {
			Flux_CMS::set('site_disclaimer', $valStr, $server);
		}
		if ($field === 'hp_show_hero') Flux_CMS::set('hp_hero_enabled', $valStr, $server);
		if ($field === 'hp_show_status') Flux_CMS::set('hp_status_enabled', $valStr, $server);
		if ($field === 'hp_show_features') Flux_CMS::set('hp_features_enabled', $valStr, $server);
		if ($field === 'hp_show_news') Flux_CMS::set('hp_news_enabled', $valStr, $server);
		if ($field === 'hp_show_rankings') Flux_CMS::set('hp_rankings_enabled', $valStr, $server);
		if ($field === 'hp_show_discord') Flux_CMS::set('hp_community_enabled', $valStr, $server);
		if ($field === 'hp_hero_title') Flux_CMS::set('hp_hero_heading', $valStr, $server);
		if ($field === 'hp_hero_desc') Flux_CMS::set('hp_hero_description', $valStr, $server);
		if ($field === 'hp_hero_btn1_url') Flux_CMS::set('hp_hero_btn1_link', $valStr, $server);
		if ($field === 'hp_hero_btn2_url') Flux_CMS::set('hp_hero_btn2_link', $valStr, $server);
		if ($field === 'hp_discord_title') Flux_CMS::set('hp_community_heading', $valStr, $server);
		if ($field === 'hp_discord_desc') Flux_CMS::set('hp_community_text', $valStr, $server);
		if ($field === 'discord_url') Flux_CMS::set('hp_discord_url', $valStr, $server);
		if ($field === 'facebook_url') Flux_CMS::set('hp_facebook_url', $valStr, $server);
	}

	// Handle Active Theme Switcher
	$chosenTheme = trim((string)$params->get('active_theme'));
	if (!empty($chosenTheme) && in_array($chosenTheme, array('celestial', 'freynix'))) {
		Flux_CMS::set('active_theme', $chosenTheme, $server);
		$appConfigFile = FLUX_CONFIG_DIR . '/application.php';
		if (file_exists($appConfigFile)) {
			$otherTheme = ($chosenTheme === 'celestial') ? 'freynix' : 'celestial';
			$newThemeArray = "array('{$chosenTheme}', '{$otherTheme}', 'default', 'bootstrap')";
			$appContent = file_get_contents($appConfigFile);
			$appContent = preg_replace("/('ThemeName'\s*=>\s*)array\([^)]+\),/", "$1{$newThemeArray},", $appContent);
			file_put_contents($appConfigFile, $appContent);
			Flux::config('ThemeName', array($chosenTheme, $otherTheme, 'default', 'bootstrap'));
			$session->setThemeData($chosenTheme);
		}
	}

	$session->setMessageData("Homepage and theme configuration saved successfully!");
	$this->redirect($this->url('homepage', 'index'));
}

$settings = Flux_CMS::getSettings($server);
?>

