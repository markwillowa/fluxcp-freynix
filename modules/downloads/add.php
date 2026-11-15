<?php
if (!defined('FLUX_ROOT')) exit;

require_once FLUX_LIB_DIR . '/Flux/Sanitizer.php';

$title = 'Add Download Package';
$downloadsTable = Flux::config('FluxTables.DownloadsTable') ?: 'cp_downloads';

$mirrorArray   = isset($_POST['mirror_url']) && is_array($_POST['mirror_url']) ? array_values($_POST['mirror_url']) : array();

$pkg_title     = trim((string)($params->get('title') ?: $params->get('pkg_title')));
$pkg_category  = trim((string)($params->get('category') ?: $params->get('pkg_category'))) ?: 'Full Client';
$pkg_version   = trim((string)($params->get('version') ?: $params->get('pkg_version')));
$pkg_file_size = trim((string)($params->get('file_size') ?: $params->get('pkg_filesize')));
$pkg_desc      = trim((string)($params->get('description') ?: $params->get('pkg_desc')));
$pkg_mirror1   = trim((string)($params->get('url_mirror1') ?: ($params->get('pkg_mirror1') ?: ($mirrorArray[0] ?? ''))));
$pkg_mirror2   = trim((string)($params->get('url_mirror2') ?: ($params->get('pkg_mirror2') ?: ($mirrorArray[1] ?? ''))));
$pkg_mirror3   = trim((string)($params->get('url_mirror3') ?: ($params->get('pkg_mirror3') ?: ($mirrorArray[2] ?? ''))));
$pkg_order     = (int)($params->get('display_order') ?? ($params->get('sort_order') ?? ($params->get('pkg_sort') ?? 0)));

$rawStatus     = $params->get('status') ?: $params->get('pkg_status');
if ($rawStatus && in_array($rawStatus, array('published', 'draft'))) {
	$pkg_status = $rawStatus;
} elseif ($params->get('pkg_active') !== null) {
	$pkg_status = $params->get('pkg_active') ? 'published' : 'draft';
} else {
	$pkg_status = 'published';
}

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

