<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Edit Navigation Link';
$navTable = Flux::config('FluxTables.NavigationTable') ?: 'cp_navigation';
$id = (int)$params->get('id');

$sql = "SELECT * FROM {$server->loginDatabase}.$navTable WHERE id = ? LIMIT 1";
$sth = $server->connection->getStatement($sql);
$sth->execute(array($id));
$item = $sth->fetch();

if (!$item) {
	$session->setMessageData("Navigation item #{$id} was not found.");
	$this->redirect($this->url('navigation', 'index'));
}

$item_location = $item->location;
$item_title = $item->title;
$item_url_type = $item->url_type;
$item_url_val = $item->url_val;
$item_parent_id = (int)$item->parent_id;
$item_sort_order = (int)$item->sort_order;
$item_is_active = (int)$item->is_active;
$item_target_blank = (int)$item->target_blank;
$item_min_group = (int)$item->min_group_level;

$errorMessage = null;

if (count($_POST)) {
	$item_location = in_array($params->get('location'), array('main', 'footer')) ? $params->get('location') : 'main';
	$item_title = trim($params->get('title'));
	$item_url_type = in_array($params->get('url_type'), array('internal', 'external')) ? $params->get('url_type') : 'internal';
	$item_url_val = trim($params->get('url_val'));
	$item_parent_id = (int)$params->get('parent_id');
	$item_sort_order = (int)$params->get('sort_order');
	$item_is_active = $params->get('is_active') !== null ? (int)$params->get('is_active') : 1;
	$item_target_blank = $params->get('target_blank') ? 1 : 0;
	$item_min_group = (int)$params->get('min_group_level');

	if ($item_title === '') {
		$errorMessage = 'Please enter a title for this navigation link.';
	} elseif ($item_url_val === '') {
		$errorMessage = 'Please enter the URL or module/action destination.';
	} else {
		if ($item_url_type === 'external' && !preg_match('!^https?://!i', $item_url_val)) {
			$item_url_val = 'https://' . $item_url_val;
		}

		$updateSql = "UPDATE {$server->loginDatabase}.$navTable SET
						name = ?,
						title = ?,
						location = ?,
						url_type = ?,
						url_val = ?,
						parent_id = ?,
						sort_order = ?,
						is_active = ?,
						min_group_level = ?,
						target_blank = ?,
						updated_at = NOW()
					  WHERE id = ?";
		$updateSth = $server->connection->getStatement($updateSql);
		$updateSth->execute(array(
			$item_title,
			$item_title,
			$item_location,
			$item_url_type,
			$item_url_val,
			$item_parent_id,
			$item_sort_order,
			$item_is_active,
			$item_min_group,
			$item_target_blank,
			$id
		));

		$session->setMessageData("Navigation link '{$item_title}' updated successfully.");
		$this->redirect($this->url('navigation', 'index'));
	}
}

// Fetch potential parent items (excluding self)
$parentSql = "SELECT id, title FROM {$server->loginDatabase}.$navTable WHERE location = 'main' AND parent_id = 0 AND id != ? ORDER BY sort_order ASC, title ASC";
$parentSth = $server->connection->getStatement($parentSql);
$parentSth->execute(array($id));
$availableParents = $parentSth->fetchAll();
?>

