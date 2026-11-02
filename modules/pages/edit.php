<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
require_once 'Flux/Sanitizer.php';

$title = Flux::message('CMSPageEditTitle') ?: 'Edit Page';
$pagesTable = Flux::config('FluxTables.CMSPagesTable');
$id = (int)$params->get('id');

$sql = "SELECT * FROM {$server->loginDatabase}.$pagesTable WHERE id = ?";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$page = $sth->fetch();

if (!$page) {
    $session->setMessageData('The requested page could not be found.');
    $this->redirect($this->url('pages', 'index'));
}

// Fetch potential parent pages (excluding self)
$parentStmt = $server->connection->getStatement("SELECT id, title FROM {$server->loginDatabase}.$pagesTable WHERE id != ? AND parent_id = 0 ORDER BY title ASC");
$parentStmt->execute(array($id));
$parentPages = $parentStmt->fetchAll();

if (count($_POST)) {
    $page_title      = trim($params->get('page_title'));
    $page_path       = Flux_Sanitizer::sanitizeSlug($params->get('page_path'));
    $page_body       = Flux_Sanitizer::sanitizeHtml($params->get('page_body'));
    $status          = $params->get('status') ?: 'published';
    $template        = $params->get('template') ?: 'default';
    $meta_desc       = trim($params->get('meta_description') ?: '');
    $meta_keywords   = trim($params->get('meta_keywords') ?: '');
    $featured_image  = trim($params->get('featured_image') ?: '');
    $sort_order      = (int)$params->get('sort_order');
    $is_nav          = $params->get('is_nav') ? 1 : 0;
    $parent_id       = (int)$params->get('parent_id');
    $min_group_level = (int)$params->get('min_group_level');
    $published_at    = $params->get('published_at') ? date('Y-m-d H:i:s', strtotime($params->get('published_at'))) : $page->published_at;

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

            $session->setMessageData('Page successfully updated.');
            $this->redirect($this->url('pages', 'index'));
        }
    }
}
?>
