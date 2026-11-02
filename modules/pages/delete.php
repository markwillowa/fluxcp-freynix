<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();

$pagesTable = Flux::config('FluxTables.CMSPagesTable');
$id = (int)$params->get('id');

$sql = "SELECT title FROM {$server->loginDatabase}.$pagesTable WHERE id = ?";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$page = $sth->fetch();

if ($page) {
    $del = $server->connection->getStatement("DELETE FROM {$server->loginDatabase}.$pagesTable WHERE id = ?");
    $del->execute(array($id));
    $session->setMessageData("Page '{$page->title}' has been deleted.");
} else {
    $session->setMessageData('Page not found.');
}

$this->redirect($this->url('pages', 'index'));
?>
