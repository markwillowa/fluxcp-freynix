<?php
if (!defined('FLUX_ROOT')) exit;

require_once FLUX_LIB_DIR . '/Flux/Sanitizer.php';

$title = 'Add Download Package';
$downloadsTable = Flux::config('FluxTables.DownloadsTable') ?: 'cp_downloads';

$pkg_title = trim($params->get('title'));
$pkg_category = trim($params->get('category')) ?: 'Full Client';
$pkg_version = trim($params->get('version'));
$pkg_file_size = trim($params->get('file_size'));
$pkg_desc = trim($params->get('description'));
$pkg_mirror1 = trim($params->get('url_mirror1'));
$pkg_mirror2 = trim($params->get('url_mirror2'));
$pkg_mirror3 = trim($params->get('url_mirror3'));
$pkg_order = (int)$params->get('display_order');
$pkg_status = in_array($params->get('status'), array('published', 'draft')) ? $params->get('status') : 'published';

$errorMessage = null;

if (count($_POST)) {
	if ($pkg_title === '') {
		$errorMessage = 'Please provide a title for the download package.';
	} elseif ($pkg_mirror1 === '') {
		$errorMessage = 'Primary Mirror 1 download URL is required.';
	} else {
		// Ensure URLs start with http:// or https://
		if (!preg_match('!^https?://!i', $pkg_mirror1)) $pkg_mirror1 = 'https://' . $pkg_mirror1;
		if ($pkg_mirror2 !== '' && !preg_match('!^https?://!i', $pkg_mirror2)) $pkg_mirror2 = 'https://' . $pkg_mirror2;
		if ($pkg_mirror3 !== '' && !preg_match('!^https?://!i', $pkg_mirror3)) $pkg_mirror3 = 'https://' . $pkg_mirror3;

		$cleanDesc = Flux_Sanitizer::sanitizeHtml($pkg_desc);

		$sql = "INSERT INTO {$server->loginDatabase}.$downloadsTable
				(title, category, description, version, file_size, url_mirror1, url_mirror2, url_mirror3, display_order, status, created_at, updated_at)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array(
			$pkg_title,
			$pkg_category,
			$cleanDesc,
			$pkg_version ?: null,
			$pkg_file_size ?: null,
			$pkg_mirror1,
			$pkg_mirror2 ?: null,
			$pkg_mirror3 ?: null,
			$pkg_order,
			$pkg_status
		));

		$session->setMessageData("Download package '{$pkg_title}' added successfully.");
		$this->redirect($this->url('downloads', 'manage'));
	}
}
?>

