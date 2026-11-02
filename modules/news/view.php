<?php
if (!defined('FLUX_ROOT')) exit;

require_once FLUX_LIB_DIR . '/Flux/Sanitizer.php';

$newsTable = Flux::config('FluxTables.CMSNewsTable');
$id = (int)$params->get('id');

if (!$id) {
	$this->redirect($this->url('news', 'index'));
}

$sql = "SELECT id, title, category, status, is_pinned, featured_image, body, link, author, published_at, created, modified FROM {$server->loginDatabase}.$newsTable WHERE id = ? LIMIT 1";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$post = $sth->fetch();

if (!$post) {
	$session->setMessageData("The requested announcement was not found.");
	$this->redirect($this->url('news', 'index'));
}

$isStaff = $auth->actionAllowed('news', 'manage');
if (!$isStaff && $post->status !== 'published') {
	$session->setMessageData("This announcement is not published.");
	$this->redirect($this->url('news', 'index'));
}

$title = $post->title;

// Fetch related/recent announcements
$recentSql = "SELECT id, title, category, published_at, created FROM {$server->loginDatabase}.$newsTable WHERE id != ? AND status = 'published' AND (published_at IS NULL OR published_at <= NOW()) ORDER BY id DESC LIMIT 5";
$recentSth = $server->connection->getStatement($recentSql);
$recentSth->execute(array($id));
$recentNews = $recentSth->fetchAll();
?>
