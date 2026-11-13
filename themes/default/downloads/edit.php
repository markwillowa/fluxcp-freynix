<?php if (!defined('FLUX_ROOT')) exit; ?>

<h2>Edit Download Package: <?php echo htmlspecialchars($download->title) ?></h2>
<p>Update download links, versioning, file size, or setup instructions.</p>

<?php if (!empty($errorMessage)): ?>
	<p class="message" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
		<?php echo htmlspecialchars($errorMessage) ?>
	</p>
<?php endif ?>

<form action="<?php echo $this->url('downloads', 'edit', array('id' => $download->id)) ?>" method="post">
	<table class="generic-form-table">
		<tr>
			<th><label for="pkg_title">Package Title *</label></th>
			<td><input type="text" name="pkg_title" id="pkg_title" value="<?php echo htmlspecialchars($download->title) ?>" style="width: 340px;" required /></td>
		</tr>
		<tr>
			<th><label for="pkg_category">Category *</label></th>
			<td>
				<select name="pkg_category" id="pkg_category">
					<option value="Full Client" <?php if ($download->category === 'Full Client') echo 'selected' ?>>Full Client</option>
					<option value="Lite Client" <?php if ($download->category === 'Lite Client') echo 'selected' ?>>Lite Client</option>
					<option value="Patcher" <?php if ($download->category === 'Patcher') echo 'selected' ?>>Patcher / Manual Patch</option>
					<option value="Utilities" <?php if ($download->category === 'Utilities') echo 'selected' ?>>Utilities &amp; Tools</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="pkg_version">Version Number</label></th>
			<td><input type="text" name="pkg_version" id="pkg_version" value="<?php echo htmlspecialchars($download->version ?? '') ?>" style="width: 140px;" /></td>
		</tr>
		<tr>
			<th><label for="pkg_filesize">File Size</label></th>
			<td><input type="text" name="pkg_filesize" id="pkg_filesize" value="<?php echo htmlspecialchars($download->file_size ?? '') ?>" placeholder="e.g. 2.4 GB" style="width: 140px;" /></td>
		</tr>
		<tr>
			<th><label for="pkg_mirror1">Mirror 1 URL *</label></th>
			<td>
				<input type="url" name="pkg_mirror1" id="pkg_mirror1" value="<?php echo htmlspecialchars($download->mirror1_url) ?>" style="width: 440px;" required /><br />
				Name: <input type="text" name="pkg_mirror1_name" value="<?php echo htmlspecialchars($download->mirror1_name ?: 'Google Drive') ?>" style="width: 160px; margin-top: 4px;" />
			</td>
		</tr>
		<tr>
			<th><label for="pkg_mirror2">Mirror 2 URL</label></th>
			<td>
				<input type="url" name="pkg_mirror2" id="pkg_mirror2" value="<?php echo htmlspecialchars($download->mirror2_url ?? '') ?>" style="width: 440px;" /><br />
				Name: <input type="text" name="pkg_mirror2_name" value="<?php echo htmlspecialchars($download->mirror2_name ?: 'MEGA') ?>" style="width: 160px; margin-top: 4px;" />
			</td>
		</tr>
		<tr>
			<th><label for="pkg_mirror3">Mirror 3 URL</label></th>
			<td>
				<input type="url" name="pkg_mirror3" id="pkg_mirror3" value="<?php echo htmlspecialchars($download->mirror3_url ?? '') ?>" style="width: 440px;" /><br />
				Name: <input type="text" name="pkg_mirror3_name" value="<?php echo htmlspecialchars($download->mirror3_name ?: 'MediaFire') ?>" style="width: 160px; margin-top: 4px;" />
			</td>
		</tr>
		<tr>
			<th><label for="pkg_desc">Description / Instructions</label></th>
			<td><textarea name="pkg_desc" id="pkg_desc" rows="4" style="width: 440px;"><?php echo htmlspecialchars($download->description ?? '') ?></textarea></td>
		</tr>
		<tr>
			<th><label for="pkg_sort">Sort Order</label></th>
			<td><input type="number" name="pkg_sort" id="pkg_sort" value="<?php echo (int)$download->sort_order ?>" style="width: 70px;" /></td>
		</tr>
		<tr>
			<th>Status</th>
			<td>
				<label>
					<input type="checkbox" name="pkg_active" value="1" <?php if (!empty($download->is_active)) echo 'checked' ?> />
					Active (Visible to Players)
				</label>
			</td>
		</tr>
	</table>

	<p style="margin-top: 20px;">
		<input type="submit" value="Save Changes" class="button" /> |
		<a href="<?php echo $this->url('downloads', 'manage') ?>">Cancel</a>
	</p>
</form>

