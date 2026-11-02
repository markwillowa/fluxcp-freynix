<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Manage Website Navigation';
$navTable = Flux::config('FluxTables.NavigationTable') ?: 'cp_navigation';

// Handle quick toggle if requested
$toggleId = (int)$params->get('toggle');
if ($toggleId) {
	$toggleSql = "UPDATE {$server->loginDatabase}.$navTable SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?";
	$sth = $server->connection->getStatement($toggleSql);
	$sth->execute(array($toggleId));
	$session->setMessageData("Navigation item status updated.");
	$this->redirect($this->url('navigation', 'index'));
}

// Fetch all items ordered by location, parent_id, sort_order
$sql = "SELECT * FROM {$server->loginDatabase}.$navTable ORDER BY location ASC, parent_id ASC, sort_order ASC, id ASC";
$sth = $server->connection->getStatement($sql);
$sth->execute();
$allItems = $sth->fetchAll();

// Group into Main and Footer, with parents and children
$mainNav = array();
$navChildren = array();
$footerNav = array();
$parentsMap = array();

foreach ($allItems as $item) {
	if ($item->location === 'main') {
		if ($item->parent_id == 0) {
			$mainNav[$item->id] = $item;
			$parentsMap[$item->id] = $item->title;
		} else {
			if (!isset($navChildren[$item->parent_id])) {
				$navChildren[$item->parent_id] = array();
			}
			$navChildren[$item->parent_id][] = $item;
		}
	} else {
		$footerNav[] = $item;
	}
}
?>

