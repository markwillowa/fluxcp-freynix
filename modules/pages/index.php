<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
$title = Flux::message('CMSPageHeader') ?: 'Manage CMS Pages';
$pagesTable = Flux::config('FluxTables.CMSPagesTable');

$sql = "SELECT p.*, parent.title AS parent_title 
        FROM {$server->loginDatabase}.$pagesTable AS p 
        LEFT JOIN {$server->loginDatabase}.$pagesTable AS parent ON parent.id = p.parent_id 
        ORDER BY p.sort_order ASC, p.id DESC";
$sth = $server->connection->getStatement($sql);
$sth->execute();

$pages = $sth->fetchAll();
?>
