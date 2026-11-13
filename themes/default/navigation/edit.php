<?php if (!defined('FLUX_ROOT')) exit; ?>

<h2>Edit Navigation Link: <?php echo htmlspecialchars($item->title) ?></h2>
<p>Update link title, destination target, dropdown parent, or visibility rules.</p>

<?php if (!empty($errorMessage)): ?>
	<p class="message" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
		<?php echo htmlspecialchars($errorMessage) ?>
	</p>
<?php endif ?>

<form action="<?php echo $this->url('navigation', 'edit', array('id' => $item->id)) ?>" method="post">
	<table class="generic-form-table">
		<tr>
			<th><label for="title">Link Title *</label></th>
			<td><input type="text" name="title" id="title" value="<?php echo htmlspecialchars($item_title) ?>" style="width: 320px;" required /></td>
		</tr>
		<tr>
			<th><label for="url_type">Link Type *</label></th>
			<td>
				<select name="url_type" id="url_type">
					<option value="internal" <?php if ($item_url_type === 'internal') echo 'selected' ?>>Internal (FluxCP Module / Action)</option>
					<option value="external" <?php if ($item_url_type === 'external') echo 'selected' ?>>External URL (Full http/https link)</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="url_val">Destination URL *</label></th>
			<td>
				<input type="text" name="url_val" id="url_val" value="<?php echo htmlspecialchars($item_url_val) ?>" style="width: 420px; font-family: monospace;" required /><br />
				<small>For internal links, use: <code>module/action</code> or <code>?module=pages&amp;action=content&amp;path=slug</code></small>
			</td>
		</tr>
		<tr>
			<th><label for="location">Menu Location *</label></th>
			<td>
				<select name="location" id="location">
					<option value="main" <?php if ($item_location === 'main') echo 'selected' ?>>Main Header Navbar</option>
					<option value="footer" <?php if ($item_location === 'footer') echo 'selected' ?>>Footer Columns</option>
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
							<option value="<?php echo (int)$parent->id ?>" <?php if ((int)$item_parent_id === (int)$parent->id) echo 'selected' ?>>
								<?php echo htmlspecialchars($parent->title) ?> (<?php echo htmlspecialchars($parent->location) ?>)
							</option>
						<?php endforeach ?>
					<?php endif ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="sort_order">Display Sort Order</label></th>
			<td><input type="number" name="sort_order" id="sort_order" value="<?php echo (int)$item_sort_order ?>" style="width: 70px;" /></td>
		</tr>
		<tr>
			<th><label for="min_group_level">Minimum Account Level</label></th>
			<td><input type="number" name="min_group_level" id="min_group_level" value="<?php echo (int)$item_min_group ?>" style="width: 70px;" /> <small>(0 = Everyone / Public)</small></td>
		</tr>
		<tr>
			<th>Options</th>
			<td>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="is_active" value="1" <?php if (!empty($item_is_active)) echo 'checked' ?> />
					Active (Visible)
				</label>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="target_blank" value="1" <?php if (!empty($item_target_blank)) echo 'checked' ?> />
					Open link in a new tab (_blank)
				</label>
			</td>
		</tr>
	</table>

	<p style="margin-top: 20px;">
		<input type="submit" value="Save Changes" class="button" /> |
		<a href="<?php echo $this->url('navigation', 'index') ?>">Cancel</a>
	</p>
</form>

