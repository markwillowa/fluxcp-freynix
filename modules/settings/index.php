<?php
if (!defined('FLUX_ROOT')) exit;

require_once FLUX_LIB_DIR . '/Flux/CMS.php';
require_once FLUX_LIB_DIR . '/Flux/Sanitizer.php';

$title = 'Global Website Settings';

if (count($_POST)) {
	$fields = array(
		'site_title',
		'site_slogan',
		'site_description',
		'site_keywords',
		'discord_url',
		'facebook_url',
		'youtube_url',
		'support_email',
		'footer_text',
		'maintenance_mode',
		'maintenance_notice',
		'site_logo_url'
	);

	foreach ($fields as $field) {
		$val = $params->get($field);
		if ($field === 'maintenance_mode') {
			$val = ($val !== null && $val == '1') ? '1' : '0';
		}
		$valStr = trim((string)$val);
		Flux_CMS::set($field, $valStr, $server);

		// Mirror compatibility aliases
		if ($field === 'footer_text') Flux_CMS::set('footer_disclaimer', $valStr, $server);
		if ($field === 'support_email') Flux_CMS::set('contact_email', $valStr, $server);
	}

	$session->setMessageData("Global site settings updated successfully!");
	$this->redirect($this->url('settings', 'index'));
}

$settings = Flux_CMS::getSettings($server);
?>

