<?php
if (!defined('FLUX_ROOT')) exit;
$adminMenuItems = $this->getAdminMenuItems();
$menuItems = $this->getMenuItems();

$isStaff = false;
if ($session->isLoggedIn()) {
	$userGroup = (int)($session->account->group_level ?? $session->account->group_id ?? 0);
	$adminGroupLevel = (int)Flux::config('AdminMenuGroupLevel') ?: 20;
	if ($userGroup >= $adminGroupLevel || $userGroup >= 20 || $auth->actionAllowed('pages', 'index') || $auth->actionAllowed('homepage', 'index')) {
		$isStaff = true;
	}
}
?>

<?php if ($isStaff || (!empty($adminMenuItems) && !Flux::config('AdminMenuNewStyle'))): ?>
<table id="admin_sidebar">
	<tr>
		<td><img src="<?php echo $this->themePath('img/sidebar_admin_complete_top.gif') ?>" /></td>
	</tr>
	<tr>
		<th class="menuitem"><strong>Staff Controls</strong></th>
	</tr>
	<?php if ($isStaff): ?>
		<tr>
			<td class="menuitem">
				<a href="<?php echo $this->url('homepage', 'index') ?>" style="font-weight: bold; color: #856404;">
					<span>Homepage &amp; Theme CMS</span>
				</a>
			</td>
		</tr>
		<tr>
			<td class="menuitem">
				<a href="<?php echo $this->url('news', 'manage') ?>">
					<span>Manage Announcements</span>
				</a>
			</td>
		</tr>
		<tr>
			<td class="menuitem">
				<a href="<?php echo $this->url('pages', 'index') ?>">
					<span>Manage Pages</span>
				</a>
			</td>
		</tr>
		<tr>
			<td class="menuitem">
				<a href="<?php echo $this->url('navigation', 'index') ?>">
					<span>Manage Navigation</span>
				</a>
			</td>
		</tr>
		<tr>
			<td class="menuitem">
				<a href="<?php echo $this->url('downloads', 'manage') ?>">
					<span>Manage Downloads</span>
				</a>
			</td>
		</tr>
		<tr>
			<td class="menuitem">
				<a href="<?php echo $this->url('settings', 'index') ?>">
					<span>Global Site Settings</span>
				</a>
			</td>
		</tr>
	<?php endif ?>
	<?php if (!empty($adminMenuItems)): ?>
		<?php foreach ($adminMenuItems as $menuItem): ?>
		<tr>
			<td class="menuitem">
				<a href="<?php echo $this->url($menuItem['module'], $menuItem['action']) ?>"<?php
					if ($menuItem['module'] == 'account' && $menuItem['action'] == 'logout')
						echo ' onclick="return confirm(\'Are you sure you want to logout?\')"' ?>>
					<span><?php echo htmlspecialchars(Flux::message($menuItem['name'])) ?></span>
				</a>
			</td>
		</tr>
		<?php endforeach ?>
	<?php endif ?>
	<tr>
		<td><img src="<?php echo $this->themePath('img/sidebar_admin_complete_bottom.gif') ?>" /></td>
	</tr>
</table>
<?php endif ?>

<?php if (!empty($menuItems)): ?>
<table id="sidebar">
	<tr>
		<td><img src="<?php echo $this->themePath('img/sidebar_complete_top.gif') ?>" /></td>
	</tr>
	<?php foreach ($menuItems as $menuCategory => $menus): ?>
	<?php if (!empty($menus)): ?>
	<tr>
<th class="menuitem"><strong><?php echo htmlspecialchars(Flux::message($menuCategory)) ?></strong></th>
	</tr>
	<?php foreach ($menus as $menuItem):  ?>
	<tr>
		<td class="menuitem">
			<a href="<?php echo $menuItem['url'] ?>"<?php
				if ($menuItem['module'] == 'account' && $menuItem['action'] == 'logout')
					echo ' onclick="return confirm(\'Are you sure you want to logout?\')"' ?>>
				<span><?php echo htmlspecialchars(Flux::message($menuItem['name'])) ?></span>
			</a>
		</td>
	</tr>
	<?php endforeach ?>
	<?php endif ?>
	<?php endforeach ?>
	<tr>
		<td><img src="<?php echo $this->themePath('img/sidebar_complete_bottom.gif') ?>" /></td>
	</tr>
</table>
<?php endif ?>
