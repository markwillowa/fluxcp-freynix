<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();

$pagesTable = Flux::config('FluxTables.CMSPagesTable');
$id = (int)$params->get('id');

$sql = "SELECT * FROM {$server->loginDatabase}.$pagesTable WHERE id = ?";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$page = $sth->fetch();

if ($page) {
    $newTitle = $page->title . ' (Copy)';
    $newPath  = $page->path . '-copy-' . time();
    $sqlInsert = "INSERT INTO {$server->loginDatabase}.$pagesTable 
                  (title, path, body, status, template, meta_description, meta_keywords, featured_image, sort_order, is_nav, parent_id, min_group_level, published_at, modified, created_at)
                  VALUES (?, ?, ?, 'draft', ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), NOW())";
    $insertStmt = $server->connection->getStatement($sqlInsert);
    $insertStmt->execute(array(
        $newTitle, $newPath, $page->body, $page->template,
        $page->meta_description, $page->meta_keywords, $page->featured_image,
        $page->sort_order, $page->is_nav, $page->parent_id, $page->min_group_level
    ));

    $session->setMessageData("Page '{$page->title}' was duplicated as draft.");
} else {
    $session->setMessageData('Page not found to duplicate.');
}

$this->redirect($this->url('pages', 'index'));
?>

