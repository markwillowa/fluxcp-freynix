<?php
if (!defined('FLUX_ROOT')) exit;

$title = null;
$newslimit = (int)Flux::config('CMSNewsLimit') ?: 4;
$newstype = (int)Flux::config('CMSNewsType');

if ($newstype == '1') {
	$newsTable = Flux::config('FluxTables.CMSNewsTable'); 
	$sql = "SELECT id, title, category, status, is_pinned, featured_image, body, link, author, published_at, created, modified 
			FROM {$server->loginDatabase}.$newsTable 
			WHERE status = 'published' AND (published_at IS NULL OR published_at <= NOW())
			ORDER BY is_pinned DESC, published_at DESC, id DESC 
			LIMIT $newslimit";
	$sth = $server->connection->getStatement($sql);
	$sth->execute();
	$news = $sth->fetchAll();
} elseif ($newstype == '2') {
	$content = @file_get_contents(Flux::config('CMSNewsRSS'));
	$news = array();
	if ($content) {
		$xml = new SimpleXmlElement($content);
		$count = 0;
		foreach ($xml->channel->item as $item) {
			if ($count >= $newslimit) break;
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
			$count++;
		}
	}
}
?>
