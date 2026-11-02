<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
require_once 'Flux/Sanitizer.php';

$title = Flux::message('CMSPageAddTitle') ?: 'Create New Page';
$pagesTable = Flux::config('FluxTables.CMSPagesTable');

// Fetch potential parent pages
$parentStmt = $server->connection->getStatement("SELECT id, title FROM {$server->loginDatabase}.$pagesTable WHERE parent_id = 0 ORDER BY title ASC");
$parentStmt->execute();
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
    $published_at    = $params->get('published_at') ? date('Y-m-d H:i:s', strtotime($params->get('published_at'))) : date('Y-m-d H:i:s');

    if ($page_title === '') {
        $errorMessage = 'Page title cannot be empty.';
    } elseif ($page_path === '') {
        $errorMessage = 'Page slug / URL path cannot be empty.';
    } else {
        // Check path uniqueness
        $checkStmt = $server->connection->getStatement("SELECT id FROM {$server->loginDatabase}.$pagesTable WHERE path = ?");
        $checkStmt->execute(array($page_path));
        if ($checkStmt->fetch()) {
            $errorMessage = 'A page with this URL path / slug already exists. Please choose a different path.';
        } else {
            $sql = "INSERT INTO {$server->loginDatabase}.$pagesTable 
                    (title, path, body, status, template, meta_description, meta_keywords, featured_image, sort_order, is_nav, parent_id, min_group_level, published_at, modified, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            $sth = $server->connection->getStatement($sql);
            $sth->execute(array(
                $page_title, $page_path, $page_body, $status, $template,
                $meta_desc, $meta_keywords, $featured_image, $sort_order,
                $is_nav, $parent_id, $min_group_level, $published_at
            ));

            $session->setMessageData('Page successfully created and published.');
            $this->redirect($this->url('pages', 'index'));
        }
    }
}
?>
