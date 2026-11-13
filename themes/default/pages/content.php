<?php
if (!defined('FLUX_ROOT')) exit;

$pageIdVal = isset($pageId) ? (int)$pageId : (isset($page->id) ? (int)$page->id : 0);
$isStaffUser = false;
if ($session->isLoggedIn()) {
	$grp = (int)($session->account->group_level ?? $session->account->group_id ?? 0);
	$adminGrp = (int)Flux::config('AdminMenuGroupLevel') ?: 20;
	if ($grp >= $adminGrp || $grp >= 20 || $auth->actionAllowed('pages', 'edit')) {
		$isStaffUser = true;
	}
}
?>
<h2><?php echo $title ?></h2>

<?php if ($isStaffUser && $pageIdVal > 0): ?>
	<p style="margin-bottom: 15px; padding: 6px 10px; background: #eef4f9; border: 1px solid #ccd9e8;">
		<strong>Staff Controls:</strong>
		<a href="<?php echo $this->url('pages', 'index') ?>">&laquo; Back to Pages</a> |
		<a href="<?php echo $this->url('pages', 'edit', array('id' => $pageIdVal)) ?>">Edit This Page</a> |
		<a href="<?php echo $this->url('pages', 'delete', array('id' => $pageIdVal)) ?>" onclick="return confirm('Permanently delete this page?');" style="color: #c00;">Delete Page</a>
	</p>
<?php endif ?>

<div class="page-content-body" style="line-height: 1.6; margin: 15px 0;">
	<?php echo $body ?>
</div>

<?php if(Flux::config('CMSDisplayModifiedBy') && !empty($modified)):?>
<p><small><?php echo htmlspecialchars(Flux::message('CMSModifiedLabel')) ?> : <?php echo date(Flux::config('DateFormat'),strtotime($modified))?></small></p>
<?php endif ?>
