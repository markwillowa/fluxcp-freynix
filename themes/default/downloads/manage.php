<?php if (!defined('FLUX_ROOT')) exit; ?>

<h2>Download Packages Manager</h2>
<p>Manage game clients, autopatchers, manual data patches, and mirror links available to players.</p>

<p style="margin-bottom: 15px;">
	<a href="<?php echo $this->url('downloads', 'add') ?>" class="button"><strong>+ Add New Package</strong></a> |
	<a href="<?php echo $this->url('main', 'downloads') ?>" target="_blank">View Public Downloads Page &raquo;</a>
</p>

<?php if (!empty($downloads)): ?>
	<table class="horizontal-table" width="100%">
		<tr>
			<th>Title &amp; Category</th>
			<th>Version / Size</th>
			<th>Mirrors</th>
			<th>Status</th>
			<th>Order</th>
			<th style="text-align: right;">Actions</th>
		</tr>
		<?php foreach ($downloads as $pkg): ?>
			<tr>
				<td>
					<strong><?php echo htmlspecialchars($pkg->title) ?></strong><br />
					<small style="color: #666;"><?php echo htmlspecialchars($pkg->category) ?></small>
				</td>
				<td>
					<?php echo htmlspecialchars($pkg->version ?: 'v1.0') ?><br />
					<small><?php echo htmlspecialchars($pkg->file_size ?: '-') ?></small>
				</td>
				<td>
					<?php if (!empty($pkg->mirror1_url)): ?>
						<a href="<?php echo htmlspecialchars($pkg->mirror1_url) ?>" target="_blank"><?php echo htmlspecialchars($pkg->mirror1_name ?: 'Mirror 1') ?></a><br />
					<?php endif ?>
					<?php if (!empty($pkg->mirror2_url)): ?>
						<a href="<?php echo htmlspecialchars($pkg->mirror2_url) ?>" target="_blank"><?php echo htmlspecialchars($pkg->mirror2_name ?: 'Mirror 2') ?></a><br />
					<?php endif ?>
					<?php if (!empty($pkg->mirror3_url)): ?>
						<a href="<?php echo htmlspecialchars($pkg->mirror3_url) ?>" target="_blank"><?php echo htmlspecialchars($pkg->mirror3_name ?: 'Mirror 3') ?></a>
					<?php endif ?>
				</td>
				<td>
					<?php if ($pkg->is_active): ?>
						<span style="color: green; font-weight: bold;">Active</span>
					<?php else: ?>
						<span style="color: red;">Hidden</span>
					<?php endif ?>
				</td>
				<td align="center"><?php echo (int)$pkg->sort_order ?></td>
				<td align="right">
					<a href="<?php echo $this->url('downloads', 'edit', array('id' => $pkg->id)) ?>">Edit</a> |
					<a href="<?php echo $this->url('downloads', 'delete', array('id' => $pkg->id)) ?>" onclick="return confirm('Permanently remove this package?');">Delete</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>No download packages found. Click <strong><a href="<?php echo $this->url('downloads', 'add') ?>">Add New Package</a></strong> to add your first client download.</p>
<?php endif ?>

