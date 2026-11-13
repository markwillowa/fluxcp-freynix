<?php if (!defined('FLUX_ROOT')) exit; ?>

<h2>Navigation Menu Manager</h2>
<p>Configure your top header navigation, dropdown submenus, and footer portal links.</p>

<p style="margin-bottom: 15px;">
	<a href="<?php echo $this->url('navigation', 'add') ?>" class="button"><strong>+ Add Navigation Link</strong></a>
</p>

<h3>Main Header Navigation</h3>
<?php if (!empty($mainNav)): ?>
	<table class="horizontal-table" width="100%" style="margin-bottom: 30px;">
		<tr>
			<th>Title &amp; Destination</th>
			<th>Type</th>
			<th>Submenu Items</th>
			<th>Order</th>
			<th>Status</th>
			<th style="text-align: right;">Actions</th>
		</tr>
		<?php foreach ($mainNav as $item): ?>
			<?php 
				$kids = isset($navChildren[$item->id]) ? $navChildren[$item->id] : array();
				$hasKids = !empty($kids);
			?>
			<tr>
				<td>
					<strong><?php echo htmlspecialchars($item->title) ?></strong>
					<?php if ($item->target_blank): ?>
						<small title="Opens in new tab">&nearr;</small>
					<?php endif ?>
					<br /><small style="color: #666; font-family: monospace;"><?php echo htmlspecialchars($item->url_val) ?></small>
				</td>
				<td><?php echo htmlspecialchars(ucfirst($item->url_type)) ?></td>
				<td>
					<?php if ($hasKids): ?>
						<span style="font-weight: bold;"><?php echo count($kids) ?> sub-items</span><br />
						<small style="color: #888;">
							<?php 
								$kidNames = array();
								foreach ($kids as $k) $kidNames[] = htmlspecialchars($k->title);
								echo implode(', ', $kidNames);
							?>
						</small>
					<?php else: ?>
						<span style="color: #999;">None</span>
					<?php endif ?>
				</td>
				<td align="center"><?php echo (int)$item->sort_order ?></td>
				<td>
					<?php if ($item->is_active): ?>
						<span style="color: green; font-weight: bold;">Active</span>
					<?php else: ?>
						<span style="color: red;">Hidden</span>
					<?php endif ?>
				</td>
				<td align="right">
					<a href="<?php echo $this->url('navigation', 'edit', array('id' => $item->id)) ?>">Edit</a> |
					<a href="<?php echo $this->url('navigation', 'delete', array('id' => $item->id)) ?>" onclick="return confirm('Delete this navigation link?');">Delete</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>No header navigation links found.</p>
<?php endif ?>

<h3>Footer Navigation Links</h3>
<?php if (!empty($footerNav)): ?>
	<table class="horizontal-table" width="100%">
		<tr>
			<th>Title &amp; Destination</th>
			<th>Type</th>
			<th>Order</th>
			<th>Status</th>
			<th style="text-align: right;">Actions</th>
		</tr>
		<?php foreach ($footerNav as $item): ?>
			<tr>
				<td>
					<strong><?php echo htmlspecialchars($item->title) ?></strong>
					<?php if ($item->target_blank): ?>
						<small title="Opens in new tab">&nearr;</small>
					<?php endif ?>
					<br /><small style="color: #666; font-family: monospace;"><?php echo htmlspecialchars($item->url_val) ?></small>
				</td>
				<td><?php echo htmlspecialchars(ucfirst($item->url_type)) ?></td>
				<td align="center"><?php echo (int)$item->sort_order ?></td>
				<td>
					<?php if ($item->is_active): ?>
						<span style="color: green; font-weight: bold;">Active</span>
					<?php else: ?>
						<span style="color: red;">Hidden</span>
					<?php endif ?>
				</td>
				<td align="right">
					<a href="<?php echo $this->url('navigation', 'edit', array('id' => $item->id)) ?>">Edit</a> |
					<a href="<?php echo $this->url('navigation', 'delete', array('id' => $item->id)) ?>" onclick="return confirm('Delete this navigation link?');">Delete</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>No footer links found.</p>
<?php endif ?>

