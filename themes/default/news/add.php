<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();

$titleVal = $params->get('news_title') ?? '';
$bodyVal = $params->get('news_body') ?? '';
$categoryVal = $params->get('news_category') ?: 'Announcement';
$authorVal = $params->get('news_author') ?: $session->account->userid;
$statusVal = $params->get('news_status') ?: 'published';
$linkVal = $params->get('news_link') ?? '';
$featuredImgVal = $params->get('news_featured_image') ?? '';
$isPinnedVal = $params->get('news_is_pinned') ? 1 : 0;
?>

<h2>Create New Announcement</h2>
<p>Compose and publish a server bulletin, patch note, or event schedule.</p>

<p style="margin-bottom: 15px;">
	<a href="<?php echo $this->url('news', 'manage') ?>">&laquo; Back to News List</a>
</p>

<?php if (!empty($errorMessage)): ?>
	<p class="message" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
		<?php echo htmlspecialchars($errorMessage) ?>
	</p>
<?php endif ?>

<form action="<?php echo $this->url('news', 'add') ?>" method="post" class="generic-form">
	<table class="generic-form-table" width="100%">
		<tr>
			<th><label for="news_title">Announcement Title *</label></th>
			<td><input type="text" name="news_title" id="news_title" value="<?php echo htmlspecialchars($titleVal) ?>" style="width: 440px;" placeholder="e.g. Maintenance &amp; Episode Patch Notes" required /></td>
		</tr>
		<tr>
			<th><label for="news_category">Category</label></th>
			<td><input type="text" name="news_category" id="news_category" value="<?php echo htmlspecialchars($categoryVal) ?>" style="width: 240px;" /></td>
		</tr>
		<tr>
			<th><label for="news_author">Author</label></th>
			<td><input type="text" name="news_author" id="news_author" value="<?php echo htmlspecialchars($authorVal) ?>" style="width: 240px;" /></td>
		</tr>
		<tr>
			<th><label for="news_status">Publishing Status</label></th>
			<td>
				<select name="news_status" id="news_status">
					<option value="published" <?php if ($statusVal === 'published') echo 'selected' ?>>Published (Live)</option>
					<option value="draft" <?php if ($statusVal === 'draft') echo 'selected' ?>>Draft (Hidden)</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="news_body">Announcement Body *</label></th>
			<td><textarea name="news_body" id="news_body" rows="14" style="width: 540px;" required><?php echo htmlspecialchars($bodyVal) ?></textarea></td>
		</tr>
		<tr>
			<th><label for="news_featured_image">Featured Image URL</label></th>
			<td><input type="text" name="news_featured_image" id="news_featured_image" value="<?php echo htmlspecialchars($featuredImgVal) ?>" style="width: 440px;" placeholder="https://..." /></td>
		</tr>
		<tr>
			<th><label for="news_link">External Link</label></th>
			<td><input type="text" name="news_link" id="news_link" value="<?php echo htmlspecialchars($linkVal) ?>" style="width: 440px;" placeholder="https://..." /></td>
		</tr>
		<tr>
			<th>Pin Announcement</th>
			<td>
				<label>
					<input type="checkbox" name="news_is_pinned" value="1" <?php if ($isPinnedVal) echo 'checked' ?> />
					Pin to top of news list
				</label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="submit" value="Publish Announcement" class="button" /> |
				<a href="<?php echo $this->url('news', 'manage') ?>">Cancel</a>
			</td>
		</tr>
	</table>
</form>
