<?php if (!defined('FLUX_ROOT')) exit; ?>

<h2>Add Navigation Link</h2>
<p>Create a new link for the top navbar, a dropdown submenu, or the footer.</p>

<?php if (!empty($errorMessage)): ?>
	<p class="message" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
		<?php echo htmlspecialchars($errorMessage) ?>
	</p>
<?php endif ?>

<form action="<?php echo $this->url('navigation', 'add') ?>" method="post">
	<table class="generic-form-table">
		<tr>
			<th><label for="title">Link Title *</label></th>
			<td><input type="text" name="title" id="title" value="<?php echo htmlspecialchars($params->get('title') ?? '') ?>" style="width: 320px;" required /></td>
		</tr>
		<tr>
			<th><label for="url_type">Link Type *</label></th>
			<td>
				<select name="url_type" id="url_type">
					<option value="internal" <?php if (($params->get('url_type') ?? 'internal') === 'internal') echo 'selected' ?>>Internal (FluxCP Module / Action)</option>
					<option value="external" <?php if ($params->get('url_type') === 'external') echo 'selected' ?>>External URL (Full http/https link)</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="url_val">Destination URL *</label></th>
			<td>
				<input type="text" name="url_val" id="url_val" value="<?php echo htmlspecialchars($params->get('url_val') ?? '') ?>" style="width: 420px; font-family: monospace;" placeholder="e.g. main/downloads, ranking/character, or https://discord.gg/..." required /><br />
				<small>For internal links, use: <code>module/action</code> or <code>?module=pages&amp;action=content&amp;path=rules</code></small>
			</td>
		</tr>
		<tr>
			<th><label for="location">Menu Location *</label></th>
			<td>
				<select name="location" id="location">
					<option value="main" <?php if (($params->get('location') ?? 'main') === 'main') echo 'selected' ?>>Main Header Navbar</option>
					<option value="footer" <?php if ($params->get('location') === 'footer') echo 'selected' ?>>Footer Columns</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="parent_id">Parent Menu Item</label></th>
			<td>
				<select name="parent_id" id="parent_id">
					<option value="0">-- None (Top Level Item) --</option>
					<?php if (!empty($parentOptions)): ?>
						<?php foreach ($parentOptions as $parent): ?>
							<option value="<?php echo (int)$parent->id ?>" <?php if ((int)$params->get('parent_id') === (int)$parent->id) echo 'selected' ?>>
								<?php echo htmlspecialchars($parent->title) ?> (<?php echo htmlspecialchars($parent->location) ?>)
							</option>
						<?php endforeach ?>
					<?php endif ?>
				</select><br />
				<small>Choose a parent item to nest this link inside its dropdown menu.</small>
			</td>
		</tr>
		<tr>
			<th><label for="sort_order">Display Sort Order</label></th>
			<td><input type="number" name="sort_order" id="sort_order" value="<?php echo htmlspecialchars($params->get('sort_order') ?? '0') ?>" style="width: 70px;" /></td>
		</tr>
		<tr>
			<th><label for="min_group_level">Minimum Account Level</label></th>
			<td><input type="number" name="min_group_level" id="min_group_level" value="<?php echo htmlspecialchars($params->get('min_group_level') ?? '0') ?>" style="width: 70px;" /> <small>(0 = Everyone / Public)</small></td>
		</tr>
		<tr>
			<th>Options</th>
			<td>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="is_active" value="1" <?php if ($params->get('is_active') !== '0') echo 'checked' ?> />
					Active (Visible)
				</label>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="target_blank" value="1" <?php if ($params->get('target_blank')) echo 'checked' ?> />
					Open link in a new tab (_blank)
				</label>
			</td>
		</tr>
	</table>

	<p style="margin-top: 20px;">
		<input type="submit" value="Add Navigation Item" class="button" /> |
		<a href="<?php echo $this->url('navigation', 'index') ?>">Cancel</a>
	</p>
</form>

