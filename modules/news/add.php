<?php
if (!defined('FLUX_ROOT')) exit;

require_once FLUX_LIB_DIR . '/Flux/Sanitizer.php';

$title = 'Create Announcement';
$newsTable = Flux::config('FluxTables.CMSNewsTable');

$news_title = trim($params->get('news_title'));
$news_category = trim($params->get('news_category'));
if ($news_category === '__custom__' && $params->get('news_category_custom')) {
	$news_category = trim($params->get('news_category_custom'));
}
if (empty($news_category)) {
	$news_category = 'Server Update';
}
$news_status = in_array($params->get('news_status'), array('published', 'draft')) ? $params->get('news_status') : 'published';
$news_is_pinned = $params->get('news_is_pinned') ? 1 : 0;
$news_featured_image = trim($params->get('news_featured_image'));
$news_published_at = trim($params->get('news_published_at')) ?: date('Y-m-d H:i:s');
$news_author = trim($params->get('news_author')) ?: ($session->account ? $session->account->userid : 'Administrator');
$news_link = trim($params->get('news_link'));
$news_body = trim($params->get('news_body'));

$errorMessage = null;

if (count($_POST)) {
	if ($news_title === '') {
		$errorMessage = 'Please enter an announcement title.';
	} elseif ($news_body === '') {
		$errorMessage = 'Please enter the announcement body content.';
	} else {
		if ($news_link !== '' && !preg_match('!^https?://!i', $news_link)) {
			$news_link = 'https://' . $news_link;
		}

		$cleanBody = Flux_Sanitizer::sanitizeHtml($news_body);

		$sql = "INSERT INTO {$server->loginDatabase}.$newsTable 
				(title, category, status, is_pinned, featured_image, published_at, author, link, body, created, modified)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array(
			$news_title,
			$news_category,
			$news_status,
			$news_is_pinned,
			$news_featured_image ?: null,
			$news_published_at,
			$news_author,
			$news_link,
			$cleanBody
		));

		$session->setMessageData("Announcement '{$news_title}' successfully published!");
		$this->redirect($this->url('news', 'manage'));
	}
}

// Fetch existing categories for auto-suggestions
$catSql = "SELECT DISTINCT category FROM {$server->loginDatabase}.$newsTable WHERE category IS NOT NULL AND category != '' ORDER BY category ASC";
$catSth = $server->connection->getStatement($catSql);
$catSth->execute();
$existingCategories = $catSth->fetchAll(PDO::FETCH_COLUMN);
?>
