<?php if (!defined('FLUX_ROOT')) exit; ?>

<h2>Download Game Client</h2>
<p>Choose your preferred download package below. For new players without existing Ragnarok Online files, we strongly recommend downloading the <strong>Full Game Client</strong>.</p>

<?php if (!empty($downloads) && is_array($downloads)): ?>
	<table class="horizontal-table" width="100%" style="margin-bottom: 25px;">
		<tr>
			<th>Package</th>
			<th>Category</th>
			<th>File Size</th>
			<th>Version</th>
			<th>Download Mirrors</th>
		</tr>
		<?php foreach ($downloads as $pkg): ?>
			<tr>
				<td>
					<strong><?php echo htmlspecialchars($pkg->title) ?></strong>
					<?php if (!empty($pkg->description)): ?>
						<br /><small><?php echo htmlspecialchars($pkg->description) ?></small>
					<?php endif ?>
				</td>
				<td><?php echo htmlspecialchars($pkg->category ?: 'Client') ?></td>
				<td><?php echo htmlspecialchars($pkg->file_size ?: '-') ?></td>
				<td><?php echo htmlspecialchars($pkg->version ?: 'Latest') ?></td>
				<td>
					<?php if (!empty($pkg->mirror1_url)): ?>
						<a href="<?php echo htmlspecialchars($pkg->mirror1_url) ?>" target="_blank" class="button">
							<?php echo htmlspecialchars($pkg->mirror1_name ?: 'Mirror 1') ?> &raquo;
						</a>
					<?php endif ?>
					<?php if (!empty($pkg->mirror2_url)): ?>
						&nbsp;<a href="<?php echo htmlspecialchars($pkg->mirror2_url) ?>" target="_blank" class="button">
							<?php echo htmlspecialchars($pkg->mirror2_name ?: 'Mirror 2') ?> &raquo;
						</a>
					<?php endif ?>
					<?php if (!empty($pkg->mirror3_url)): ?>
						&nbsp;<a href="<?php echo htmlspecialchars($pkg->mirror3_url) ?>" target="_blank" class="button">
							<?php echo htmlspecialchars($pkg->mirror3_name ?: 'Mirror 3') ?> &raquo;
						</a>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<!-- Default Fallback Client Table -->
	<table class="horizontal-table" width="100%" style="margin-bottom: 25px;">
		<tr>
			<th>Package</th>
			<th>Type</th>
			<th>Estimated Size</th>
			<th>Download Links</th>
		</tr>
		<tr>
			<td>
				<strong>Full Game Client (Installer)</strong><br />
				<small>Complete game client bundled with custom sprites, high-res audio, and automatic patcher.</small>
			</td>
			<td>Full Client</td>
			<td>~2.5 GB</td>
			<td>
				<a href="https://mega.nz/" target="_blank">MEGA Mirror &raquo;</a> |
				<a href="https://drive.google.com/" target="_blank">Google Drive &raquo;</a> |
				<a href="https://mediafire.com/" target="_blank">MediaFire &raquo;</a>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Lite Client / Patcher Only</strong><br />
				<small>Contains data.grf patches, custom BGM, and game exe. Requires existing kRO installation.</small>
			</td>
			<td>Lite Client</td>
			<td>~150 MB</td>
			<td>
				<a href="https://drive.google.com/" target="_blank">Google Drive &raquo;</a> |
				<a href="https://mediafire.com/" target="_blank">MediaFire &raquo;</a>
			</td>
		</tr>
	</table>
<?php endif ?>

<h3>System Requirements</h3>
<table class="vertical-table" width="100%">
	<tr>
		<th>Operating System</th>
		<td>Windows 7 / 8 / 10 / 11</td>
	</tr>
	<tr>
		<th>Processor</th>
		<td>Intel Core 2 Duo / AMD Athlon 64 or higher</td>
	</tr>
	<tr>
		<th>Memory</th>
		<td>2 GB RAM minimum (4 GB recommended)</td>
	</tr>
	<tr>
		<th>Graphics Card</th>
		<td>DirectX 9.0c compatible graphics card</td>
	</tr>
	<tr>
		<th>Hard Disk Space</th>
		<td>At least 5 GB available storage</td>
	</tr>
</table>

