<?php 
if (!defined('FLUX_ROOT')) exit;

$postItem = !empty($post) ? $post : (!empty($news) && is_object($news) && isset($news->title) ? $news : null);
$isStaffUser = $auth->actionAllowed('news', 'manage');
?>           

<?php if ($postItem): ?>
	<h2><?php echo htmlspecialchars($postItem->title) ?></h2>
	
	<p style="color: #666; font-size: 0.9em; margin-bottom: 12px;">
		Posted by <strong><?php echo htmlspecialchars($postItem->author ?: 'Staff') ?></strong>
		on <?php echo date(Flux::config('DateFormat'), strtotime($postItem->published_at ?: $postItem->created)) ?>
		<?php if (!empty($postItem->category)): ?>
			&bull; Category: <em><?php echo htmlspecialchars($postItem->category) ?></em>
		<?php endif ?>
	</p>

	<?php if ($isStaffUser): ?>
		<p style="padding: 6px 10px; background: #eef4f9; border: 1px solid #ccd9e8; margin-bottom: 15px;">
			<strong>Staff Controls:</strong>
			<a href="<?php echo $this->url('news', 'index') ?>">&laquo; Back to News List</a> |
			<a href="<?php echo $this->url('news', 'edit', array('id' => $postItem->id)) ?>">Edit Announcement</a> |
			<a href="<?php echo $this->url('news', 'delete', array('id' => $postItem->id)) ?>" onclick="return confirm('Permanently delete this announcement?');" style="color: #c00;">Delete</a>
		</p>
	<?php endif ?>

	<?php if (!empty($postItem->featured_image)): ?>
		<div style="margin: 15px 0; max-height: 360px; overflow: hidden; border: 1px solid #ddd;">
			<img src="<?php echo htmlspecialchars($postItem->featured_image) ?>" alt="" style="width: 100%; height: auto; display: block;" />
		</div>
	<?php endif ?>

	<div class="news-body" style="line-height: 1.6; margin: 15px 0;">
		<?php echo $postItem->body ?>
	</div>

	<?php if (!empty($postItem->link)): ?>
		<p style="margin-top: 15px;">
			<a href="<?php echo htmlspecialchars($postItem->link) ?>" target="_blank" class="button">
				External Resource &raquo;
			</a>
		</p>
	<?php endif ?>

	<p style="margin-top: 25px;">
		<a href="<?php echo $this->url('news', 'index') ?>">&laquo; Back to All Announcements</a>
	</p>

<?php elseif (!empty($news) && is_array($news)): ?>
	<h2><?php echo htmlspecialchars(Flux::message('CMSNewsHomeTitle')) ?></h2>
	<div class="newsDiv">
		<?php foreach ($news as $nrow): ?>
			<h4><a href="<?php echo $this->url('news', 'view', array('id' => $nrow->id)) ?>"><?php echo htmlspecialchars($nrow->title) ?></a></h4>
			<div class="newsCont">
				<span class="newsDate"><small>by <?php echo htmlspecialchars($nrow->author) ?> on <?php echo date(Flux::config('DateFormat'), strtotime($nrow->published_at ?: $nrow->created)) ?></small></span>
				<p><?php echo $nrow->body ?></p>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	<h2>Announcement Not Found</h2>
	<p>The requested announcement could not be found or has been removed.</p>
	<p><a href="<?php echo $this->url('news', 'index') ?>">&laquo; Back to News List</a></p>
<?php endif ?>
