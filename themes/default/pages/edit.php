<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();

$idVal = !empty($page->id) ? (int)$page->id : (int)$params->get('id');
$titleVal = isset($page_title) ? $page_title : (!empty($page->title) ? $page->title : '');
$pathVal = isset($page_path) ? $page_path : (!empty($page->path) ? $page->path : '');
$bodyVal = isset($page_body) ? $page_body : (!empty($page->body) ? $page->body : '');
$statusVal = isset($status) ? $status : (!empty($page->status) ? $page->status : 'published');
$templateVal = isset($template) ? $template : (!empty($page->template) ? $page->template : 'default');
$featuredImgVal = isset($featured_image) ? $featured_image : (!empty($page->featured_image) ? $page->featured_image : '');
$sortVal = isset($sort_order) ? (int)$sort_order : (!empty($page->sort_order) ? (int)$page->sort_order : 0);
$isNavVal = isset($is_nav) ? (int)$is_nav : (!empty($page->is_nav) ? 1 : 0);
$parentVal = isset($parent_id) ? (int)$parent_id : (!empty($page->parent_id) ? (int)$page->parent_id : 0);
$minGroupVal = isset($min_group_level) ? (int)$min_group_level : (!empty($page->min_group_level) ? (int)$page->min_group_level : 0);
?>

<h2>Edit Page: <?php echo htmlspecialchars($titleVal ?: ('#' . $idVal)) ?></h2>

<p style="margin-bottom: 15px;">
	<?php if (!empty($pathVal)): ?>
		<a href="<?php echo $this->url('pages', 'content', array('path' => $pathVal)) ?>" target="_blank">View Live Page &raquo;</a> |
	<?php endif ?>
	<a href="<?php echo $this->url('pages', 'index') ?>">&laquo; Back to Pages List</a>
</p>

<?php if (!empty($errorMessage)): ?>
	<p class="message" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
		<?php echo htmlspecialchars($errorMessage) ?>
	</p>
<?php endif ?>

<?php if ($page): ?>
<form action="<?php echo $this->url('pages', 'edit', array('id' => $idVal)) ?>" method="post" class="generic-form">
	<input type="hidden" name="id" value="<?php echo $idVal ?>" />
	<input type="hidden" name="page_id" value="<?php echo $idVal ?>" />
	<table class="generic-form-table" width="100%">
		<tr>
			<th><label for="page_title">Page Title *</label></th>
			<td><input type="text" name="page_title" id="page_title" value="<?php echo htmlspecialchars($titleVal) ?>" style="width: 440px;" required /></td>
		</tr>
		<tr>
			<th><label for="page_path">URL Slug / Path *</label></th>
			<td>
				<input type="text" name="page_path" id="page_path" value="<?php echo htmlspecialchars($pathVal) ?>" style="width: 320px; font-family: monospace;" required /><br />
				<small>Accessible at: <code>/?module=pages&amp;action=content&amp;path=<strong>slug</strong></code></small>
			</td>
		</tr>
		<tr>
			<th><label for="status">Publication Status</label></th>
			<td>
				<select name="status" id="status">
					<option value="published" <?php if ($statusVal === 'published') echo 'selected' ?>>Published (Visible)</option>
					<option value="draft" <?php if ($statusVal === 'draft') echo 'selected' ?>>Draft (Hidden)</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="page_body">Page Content (HTML Supported) *</label></th>
			<td>
				<textarea name="page_body" id="page_body" rows="18" style="width: 580px; font-family: monospace;" required><?php echo htmlspecialchars($bodyVal) ?></textarea>
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
				<input type="submit" value="Save Page Changes" class="button" /> |
				<a href="<?php echo $this->url('pages', 'index') ?>">Cancel</a>
			</td>
		</tr>
	</table>
</form>
<?php else: ?>
	<p>The requested page was not found. <a href="<?php echo $this->url('pages', 'index') ?>">Return to Pages List</a>.</p>
<?php endif ?>
