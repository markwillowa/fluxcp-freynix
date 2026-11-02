<?php
if (!defined('FLUX_ROOT')) exit;  

$newsTable = Flux::config('FluxTables.CMSNewsTable');
$id = (int)$params->get('id');

$sql = "SELECT title FROM {$server->loginDatabase}.$newsTable WHERE id = ?";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$post = $sth->fetch();

$redirect = $auth->actionAllowed('news', 'manage') ? $this->url('news', 'manage') : $this->url('news', 'index');

if ($post) {
    $delSth = $server->connection->getStatement("DELETE FROM {$server->loginDatabase}.$newsTable WHERE id = ?");
    $delSth->execute(array($id));
	$session->setMessageData(sprintf("Announcement '%s' has been deleted.", $post->title));
} else {
	$session->setMessageData("Announcement was not found.");
}

$this->redirect($redirect);
?>
