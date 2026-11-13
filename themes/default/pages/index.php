<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();   
?>
<h2><?php echo htmlspecialchars(Flux::message('CMSPageHeader') ?: 'Custom Codex & Content Pages') ?></h2>
<p><?php echo htmlspecialchars(Flux::message('CMSPageText') ?: 'Manage custom HTML pages, guides, server rules, and information articles.') ?></p>

<p style="margin-bottom: 15px;">
	<a href="<?php echo $this->url('pages', 'add') ?>" class="button"><strong>+ Create New Page</strong></a>
</p>

<?php if (!empty($pages)): ?>
	<table class="horizontal-table" width="100%">  
		<tr>
			<th>Page Title &amp; Path</th>
			<th style="text-align: right;">Staff Controls</th>    
		</tr>
		<?php foreach ($pages as $prow): ?>
			<tr>
				<td>
					<strong><a href="<?php echo $this->url('pages', 'content', array('path' => $prow->path)) ?>" target="_blank"><?php echo htmlspecialchars($prow->title) ?></a></strong><br />
					<small style="color: #666; font-family: monospace;">/?module=pages&amp;action=content&amp;path=<?php echo htmlspecialchars($prow->path) ?></small>
				</td>
				<td align="right">
					<a href="<?php echo $this->url('pages', 'content', array('path' => $prow->path)) ?>" target="_blank">View</a> |
					<a href="<?php echo $this->url('pages', 'edit', array('id' => $prow->id)); ?>">Edit</a> |
					<a href="<?php echo $this->url('pages', 'delete', array('id' => $prow->id)); ?>" onclick="return confirm('<?php echo htmlspecialchars(Flux::message('CMSConfirmDelete') ?: 'Are you sure you want to delete this page?') ?>');" style="color: #c00;">Delete</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>
		No custom pages found.<br /><br />
		<a href="<?php echo $this->url('pages', 'add') ?>" class="button"><strong>+ Create New Page</strong></a>
	</p>
<?php endif ?>
