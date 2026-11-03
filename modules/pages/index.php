<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
$title = Flux::message('CMSPageHeader') ?: 'Manage CMS Pages';
$pagesTable = Flux::config('FluxTables.CMSPagesTable') ?: 'cp_cmspages';

// Ensure all extended CMS pages columns exist
if ($server && $server->connection) {
	try {
		$colsCheck = array(
			'status'           => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `status` varchar(20) NOT NULL DEFAULT 'published' AFTER `title`",
			'meta_description' => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `meta_description` varchar(255) NULL AFTER `body`",
			'meta_keywords'    => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `meta_keywords` varchar(255) NULL AFTER `meta_description`",
			'template'         => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `template` varchar(50) NOT NULL DEFAULT 'default' AFTER `meta_keywords`",
			'featured_image'   => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `featured_image` varchar(255) NULL AFTER `template`",
			'sort_order'       => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `sort_order` int(11) NOT NULL DEFAULT 0 AFTER `featured_image`",
			'is_nav'           => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `is_nav` tinyint(1) NOT NULL DEFAULT 0 AFTER `sort_order`",
			'parent_id'        => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `parent_id` int(11) NOT NULL DEFAULT 0 AFTER `is_nav`",
			'min_group_level'  => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `min_group_level` int(11) NOT NULL DEFAULT 0 AFTER `parent_id`",
			'published_at'     => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `published_at` datetime NULL AFTER `min_group_level`",
			'created_at'       => "ALTER TABLE {$server->loginDatabase}.$pagesTable ADD COLUMN `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `published_at`"
		);
		foreach ($colsCheck as $col => $alterSql) {
			$chk = $server->connection->getStatement("SHOW COLUMNS FROM {$server->loginDatabase}.$pagesTable LIKE '$col'");
			$chk->execute();
			if (!$chk->fetch()) {
				$server->connection->getStatement($alterSql)->execute();
			}
		}
	} catch (Exception $e) {}
}

$pages = array();
try {
	$sql = "SELECT p.*, parent.title AS parent_title 
	        FROM {$server->loginDatabase}.$pagesTable AS p 
	        LEFT JOIN {$server->loginDatabase}.$pagesTable AS parent ON parent.id = p.parent_id 
	        ORDER BY p.sort_order ASC, p.id DESC";
	$sth = $server->connection->getStatement($sql);
	$sth->execute();
	$pages = $sth->fetchAll();
} catch (Exception $e) {
	try {
		$sql = "SELECT p.*, NULL AS parent_title FROM {$server->loginDatabase}.$pagesTable AS p ORDER BY p.id DESC";
		$sth = $server->connection->getStatement($sql);
		$sth->execute();
		$pages = $sth->fetchAll();
	} catch (Exception $e2) {}
}
?>
