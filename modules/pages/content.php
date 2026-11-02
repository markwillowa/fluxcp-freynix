<?php
if (!defined('FLUX_ROOT')) exit;

$pagesTable = Flux::config('FluxTables.CMSPagesTable');
$path = trim($params->get('path'));

$sql = "SELECT * FROM {$server->loginDatabase}.$pagesTable WHERE path = ? LIMIT 1";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($path));
$page = $sth->fetch();

if (!$page) {
    $this->redirect($this->url('main', 'index'));
}

$isAdmin = $session->isLoggedIn() && ($session->account->group_level >= Flux::config('AdminMenuGroupLevel') || $auth->actionAllowed('pages', 'edit'));

// Check publication status
if ($page->status !== 'published') {
    if (!$isAdmin) {
        $this->redirect($this->url('main', 'index'));
    } else {
        $previewNotice = "PREVIEW MODE: This page is currently set to '{$page->status}' and is only visible to staff.";
    }
}

// Check scheduled publication
if (!empty($page->published_at) && strtotime($page->published_at) > time()) {
    if (!$isAdmin) {
        $this->redirect($this->url('main', 'index'));
    } else {
        $previewNotice = "PREVIEW MODE: This page is scheduled to publish on " . date('Y-m-d H:i', strtotime($page->published_at)) . ".";
    }
}

// Check role / group permissions
if (!empty($page->min_group_level) && (int)$page->min_group_level > 0) {
    if (!$session->isLoggedIn() || (int)$session->account->group_level < (int)$page->min_group_level) {
        $session->setMessageData("This page is restricted to authorized group level {$page->min_group_level} members.");
        $this->loginRequired();
    }
}

$title            = $page->title;
$body             = $page->body;
$modified         = $page->modified;
$meta_description = !empty($page->meta_description) ? $page->meta_description : '';
$meta_keywords    = !empty($page->meta_keywords) ? $page->meta_keywords : '';
$page_template    = !empty($page->template) ? $page->template : 'default';
$featured_image   = !empty($page->featured_image) ? $page->featured_image : '';
?>
