<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
require_once 'Flux/Sanitizer.php';

$title = Flux::message('CMSPageEditTitle') ?: 'Edit Page';
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

$id = (int)$params->get('id');
if (!$id && isset($_POST['id'])) {
	$id = (int)$_POST['id'];
}
if (!$id && isset($_GET['id'])) {
	$id = (int)$_GET['id'];
}
if (!$id && isset($_POST['page_id'])) {
	$id = (int)$_POST['page_id'];
}
if (!$id && $params->get('page_id')) {
	$id = (int)$params->get('page_id');
}

$sql = "SELECT * FROM {$server->loginDatabase}.$pagesTable WHERE id = ?";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$page = $sth->fetch();

if (!$page) {
	$session->setMessageData('The requested page could not be found.');
	$this->redirect($this->url('pages', 'index'));
}

// Fetch potential parent pages (excluding self)
$parentPages = array();
try {
	$parentStmt = $server->connection->getStatement("SELECT id, title FROM {$server->loginDatabase}.$pagesTable WHERE id != ? AND parent_id = 0 ORDER BY title ASC");
	$parentStmt->execute(array($id));
	$parentPages = $parentStmt->fetchAll();
} catch (Exception $e) {
	try {
		$parentStmt = $server->connection->getStatement("SELECT id, title FROM {$server->loginDatabase}.$pagesTable WHERE id != ? ORDER BY title ASC");
		$parentStmt->execute(array($id));
		$parentPages = $parentStmt->fetchAll();
	} catch (Exception $e2) {}
}

if (count($_POST)) {
	$page_title      = trim($params->get('page_title') ?: ($_POST['page_title'] ?? ''));
	$page_path       = Flux_Sanitizer::sanitizeSlug($params->get('page_path') ?: ($_POST['page_path'] ?? ''));
	$rawBody         = $params->get('page_body') ?: ($_POST['page_body'] ?? '');
	$page_body       = Flux_Sanitizer::sanitizeHtml($rawBody);
	$status          = $params->get('status') ?: ($_POST['status'] ?? 'published');
	$template        = $params->get('template') ?: ($_POST['template'] ?? 'default');
	$meta_desc       = trim($params->get('meta_description') ?: ($_POST['meta_description'] ?? ''));
	$meta_keywords   = trim($params->get('meta_keywords') ?: ($_POST['meta_keywords'] ?? ''));
	$featured_image  = trim($params->get('featured_image') ?: ($_POST['featured_image'] ?? ''));
	$sort_order      = (int)($params->get('sort_order') ?: ($_POST['sort_order'] ?? 0));
	$is_nav          = ($params->get('is_nav') || isset($_POST['is_nav'])) ? 1 : 0;
	$parent_id       = (int)($params->get('parent_id') ?: ($_POST['parent_id'] ?? 0));
	$min_group_level = (int)($params->get('min_group_level') ?: ($_POST['min_group_level'] ?? 0));
	
	$rawPub = $params->get('published_at') ?: ($_POST['published_at'] ?? '');
	if (!empty($rawPub) && strtotime($rawPub)) {
		$published_at = date('Y-m-d H:i:s', strtotime($rawPub));
	} elseif (!empty($page->published_at)) {
		$published_at = $page->published_at;
	} else {
		$published_at = date('Y-m-d H:i:s');
	}

	if ($page_title === '') {
		$errorMessage = 'Page title cannot be empty.';
	} elseif ($page_path === '') {
		$errorMessage = 'Page slug / URL path cannot be empty.';
	} else {
		// Check path uniqueness
		$checkStmt = $server->connection->getStatement("SELECT id FROM {$server->loginDatabase}.$pagesTable WHERE path = ? AND id != ?");
		$checkStmt->execute(array($page_path, $id));
		if ($checkStmt->fetch()) {
			$errorMessage = 'Another page with this URL path / slug already exists. Please choose a different path.';
		} else {
			try {
				$sql = "UPDATE {$server->loginDatabase}.$pagesTable SET 
						title = ?, path = ?, body = ?, status = ?, template = ?, 
						meta_description = ?, meta_keywords = ?, featured_image = ?, 
						sort_order = ?, is_nav = ?, parent_id = ?, min_group_level = ?, 
						published_at = ?, modified = NOW() 
						WHERE id = ?";
				$sth = $server->connection->getStatement($sql);
				$sth->execute(array(
					$page_title, $page_path, $page_body, $status, $template,
					$meta_desc, $meta_keywords, $featured_image,
					$sort_order, $is_nav, $parent_id, $min_group_level,
					$published_at, $id
				));
			} catch (Exception $e) {
				// Fallback to essential columns if database has basic schema
				$sql = "UPDATE {$server->loginDatabase}.$pagesTable SET 
						title = ?, path = ?, body = ?, status = ?, modified = NOW() 
						WHERE id = ?";
				$sth = $server->connection->getStatement($sql);
				$sth->execute(array($page_title, $page_path, $page_body, $status, $id));
			}

			$session->setMessageData('Page successfully updated.');
			$this->redirect($this->url('pages', 'index'));
		}
	}
}
?>