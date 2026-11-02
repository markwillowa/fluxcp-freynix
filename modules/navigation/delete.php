<?php
if (!defined('FLUX_ROOT')) exit;

$navTable = Flux::config('FluxTables.NavigationTable') ?: 'cp_navigation';
$id = (int)$params->get('id');

$sql = "SELECT title FROM {$server->loginDatabase}.$navTable WHERE id = ?";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$item = $sth->fetch();

if ($item) {
	// Re-assign or orphan children
	$updSth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$navTable SET parent_id = 0 WHERE parent_id = ?");
	$updSth->execute(array($id));

	// Delete item
	$delSth = $server->connection->getStatement("DELETE FROM {$server->loginDatabase}.$navTable WHERE id = ?");
	$delSth->execute(array($id));

	$session->setMessageData("Navigation item '{$item->title}' has been deleted.");
} else {
	$session->setMessageData("Navigation item was not found.");
}

$this->redirect($this->url('navigation', 'index'));
?>

