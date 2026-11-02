<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'News & Announcements';
$newslimit = (int)Flux::config('CMSNewsLimit') ?: 10;
$newstype = (int)Flux::config('CMSNewsType');

if ($newstype == 1) {
	$newsTable = Flux::config('FluxTables.CMSNewsTable');
	
	// Available categories for filtering
	$catSql = "SELECT DISTINCT category FROM {$server->loginDatabase}.$newsTable WHERE category IS NOT NULL AND category != '' ORDER BY category ASC";
	$catSth = $server->connection->getStatement($catSql);
	$catSth->execute();
	$categories = $catSth->fetchAll(PDO::FETCH_COLUMN);

	$selectedCategory = trim($params->get('category'));
	$isStaff = $auth->actionAllowed('news', 'manage');

	// Base conditions
	$where = array();
	$bind = array();

	if (!$isStaff) {
		$where[] = "status = 'published'";
		$where[] = "(published_at IS NULL OR published_at <= NOW())";
	}

	if (!empty($selectedCategory)) {
		$where[] = "category = ?";
		$bind[] = $selectedCategory;
	}

	$whereSql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

	// Count total for pagination
	$countSql = "SELECT COUNT(*) AS total FROM {$server->loginDatabase}.$newsTable $whereSql";
	$countSth = $server->connection->getStatement($countSql);
	$countSth->execute($bind);
	$total = (int)$countSth->fetchColumn();

	$paginator = $this->getPaginator($total);
	$paginator->setSortableColumns(array('is_pinned' => 'desc', 'published_at' => 'desc', 'id' => 'desc'));

	$sql = $paginator->getSQL("SELECT id, title, category, status, is_pinned, featured_image, body, link, author, published_at, created, modified FROM {$server->loginDatabase}.$newsTable $whereSql");
	$sth = $server->connection->getStatement($sql);
	$sth->execute($bind);
	$news = $sth->fetchAll();

} elseif ($newstype == 2) {
	$content = @file_get_contents(Flux::config('CMSNewsRSS'));
	$news = array();
	if ($content) {
		$xml = new SimpleXmlElement($content);
		foreach ($xml->channel->item as $item) {
			$news[] = (object)array(
				'id' => null,
				'title' => (string)$item->title,
				'category' => 'RSS',
				'status' => 'published',
				'is_pinned' => 0,
				'featured_image' => null,
				'body' => (string)$item->description,
				'link' => (string)$item->link,
				'author' => 'Staff',
				'published_at' => date('Y-m-d H:i:s', strtotime((string)$item->pubDate)),
				'created' => date('Y-m-d H:i:s', strtotime((string)$item->pubDate)),
				'modified' => null
			);
		}
	}
} else {
	exit('Check CMSNewsType configuration option.');
}
?>
