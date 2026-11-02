<?php
if (!defined('FLUX_ROOT')) exit;

if ($auth->actionAllowed('downloads', 'manage')) {
	$this->redirect($this->url('downloads', 'manage'));
} else {
	$this->redirect($this->url('main', 'downloads'));
}
?>

