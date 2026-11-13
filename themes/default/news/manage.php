<?php
if (!defined('FLUX_ROOT')) exit;    
$this->loginRequired();
?>
<h2><?php echo htmlspecialchars(Flux::message('CMSNewsHeader') ?: 'Announcement Manager') ?></h2>
<p>Create, update, or remove server announcements and news chronicles.</p>

<p style="margin-bottom: 15px;">
	<a href="<?php echo $this->url('news', 'add') ?>" class="button"><strong>+ Create New Announcement</strong></a> |
	<a href="<?php echo $this->url('news', 'index') ?>" target="_blank">View Public News Feed &raquo;</a>
</p>

<?php if (!empty($news)): ?>
	<table class="horizontal-table" width="100%">  
		<tr>
			<th>Title</th>    
			<th>Author</th>    
			<th>Date Published</th>
			<th style="text-align: right;">Staff Controls</th>    
		</tr>
		<?php foreach ($news as $nrow): ?>
			<tr>
				<td>
					<strong><?php echo htmlspecialchars($nrow->title) ?></strong>
					<?php if (!empty($nrow->is_pinned)): ?>
						<small style="color: #b8860b; font-weight: bold;">[PINNED]</small>
					<?php endif ?>
					<?php if (!empty($nrow->category)): ?>
						<br /><small style="color: #666;"><?php echo htmlspecialchars($nrow->category) ?></small>
					<?php endif ?>
				</td>
				<td><?php echo htmlspecialchars($nrow->author ?: 'Staff') ?></td>
				<td><?php echo date(Flux::config('DateFormat'), strtotime($nrow->published_at ?: $nrow->created)) ?></td>
				<td align="right">
					<a href="<?php echo $this->url('news', 'view', array('id' => $nrow->id)); ?>" target="_blank">View</a> |
					<a href="<?php echo $this->url('news', 'edit', array('id' => $nrow->id)); ?>">Edit</a> |
					<a href="<?php echo $this->url('news', 'delete', array('id' => $nrow->id)); ?>" onclick="return confirm('<?php echo htmlspecialchars(Flux::message('CMSConfirmDeleteLabel') ?: 'Are you sure you want to delete this announcement?') ?>');" style="color: #c00;">Delete</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>
		No announcements found.<br /><br />
		<a href="<?php echo $this->url('news', 'add') ?>" class="button"><strong>+ Create New Announcement</strong></a>
	</p>
<?php endif ?>
