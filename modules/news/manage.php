<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Manage Announcements';
$newsTable = Flux::config('FluxTables.CMSNewsTable');

// Handle filter/search if present
$statusFilter = trim($params->get('status'));
$categoryFilter = trim($params->get('category'));
$searchKeyword = trim($params->get('q'));

$where = array();
$bind = array();

if ($statusFilter !== '') {
	$where[] = "status = ?";
	$bind[] = $statusFilter;
}

if ($categoryFilter !== '') {
	$where[] = "category = ?";
	$bind[] = $categoryFilter;
}

if ($searchKeyword !== '') {
	$where[] = "(title LIKE ? OR body LIKE ?)";
	$bind[] = "%$searchKeyword%";
	$bind[] = "%$searchKeyword%";
}

$whereSql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT id, title, category, status, is_pinned, featured_image, author, published_at, created, modified FROM {$server->loginDatabase}.$newsTable $whereSql ORDER BY is_pinned DESC, id DESC";
$sth = $server->connection->getStatement($sql);
$sth->execute($bind);
$news = $sth->fetchAll();

// Get unique categories for filter
$catSql = "SELECT DISTINCT category FROM {$server->loginDatabase}.$newsTable WHERE category IS NOT NULL AND category != '' ORDER BY category ASC";
$catSth = $server->connection->getStatement($catSql);
$catSth->execute();
$categories = $catSth->fetchAll(PDO::FETCH_COLUMN);
?>
