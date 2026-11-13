<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();

$titleVal = $params->get('page_title') ?? '';
$pathVal = $params->get('page_path') ?? '';
$bodyVal = $params->get('page_body') ?? '';
$statusVal = $params->get('status') ?: 'published';
$featuredImgVal = $params->get('featured_image') ?? '';
$sortVal = (int)($params->get('sort_order') ?? 0);
$isNavVal = $params->get('is_nav') ? 1 : 0;
$minGroupVal = (int)($params->get('min_group_level') ?? 0);
?>

<h2>Create New Page</h2>
<p>Create a custom information page, server guide, or community rules codex.</p>

<p style="margin-bottom: 15px;">
	<a href="<?php echo $this->url('pages', 'index') ?>">&laquo; Back to Pages List</a>
</p>

<?php if (!empty($errorMessage)): ?>
	<p class="message" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
		<?php echo htmlspecialchars($errorMessage) ?>
	</p>
<?php endif ?>

<form action="<?php echo $this->url('pages', 'add') ?>" method="post" class="generic-form">
	<table class="generic-form-table" width="100%">
		<tr>
			<th><label for="page_title">Page Title *</label></th>
			<td><input type="text" name="page_title" id="page_title" value="<?php echo htmlspecialchars($titleVal) ?>" style="width: 440px;" placeholder="e.g. Server Rules &amp; Guidelines" required /></td>
		</tr>
		<tr>
			<th><label for="page_path">URL Slug / Path *</label></th>
			<td>
				<input type="text" name="page_path" id="page_path" value="<?php echo htmlspecialchars($pathVal) ?>" style="width: 320px; font-family: monospace;" placeholder="e.g. rules" required /><br />
				<small>Will be accessible at: <code>/?module=pages&amp;action=content&amp;path=<strong>slug</strong></code></small>
			</td>
		</tr>
		<tr>
			<th><label for="status">Publication Status</label></th>
			<td>
				<select name="status" id="status">
					<option value="published" <?php if ($statusVal === 'published') echo 'selected' ?>>Published (Live)</option>
					<option value="draft" <?php if ($statusVal === 'draft') echo 'selected' ?>>Draft (Hidden)</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="page_body">Page Content (HTML Supported) *</label></th>
			<td>
				<textarea name="page_body" id="page_body" rows="18" style="width: 580px; font-family: monospace;" placeholder="Write your page HTML content here..." required><?php echo htmlspecialchars($bodyVal) ?></textarea>
			</td>
		</tr>
		<tr>
			<th><label for="featured_image">Featured Banner Image URL</label></th>
			<td><input type="text" name="featured_image" id="featured_image" value="<?php echo htmlspecialchars($featuredImgVal) ?>" style="width: 440px;" placeholder="https://..." /></td>
		</tr>
		<tr>
			<th><label for="sort_order">Sort Order</label></th>
			<td><input type="number" name="sort_order" id="sort_order" value="<?php echo $sortVal ?>" style="width: 70px;" /></td>
		</tr>
		<tr>
			<th><label for="min_group_level">Minimum Account Level</label></th>
			<td><input type="number" name="min_group_level" id="min_group_level" value="<?php echo $minGroupVal ?>" style="width: 70px;" /> <small>(0 = Public)</small></td>
		</tr>
		<tr>
			<th>Navigation Options</th>
			<td>
				<label>
					<input type="checkbox" name="is_nav" value="1" <?php if ($isNavVal) echo 'checked' ?> />
					Include link in automatic navigation
				</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="submit" value="Create Page" class="button" /> |
				<a href="<?php echo $this->url('pages', 'index') ?>">Cancel</a>
			</td>
		</tr>
	</table>
</form>
