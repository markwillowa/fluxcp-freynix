<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Re-Install Database Schemas &amp; Reset Wizard</h2>
<p>You may reset your database schema tracking files and re-open the installation wizard from this interface.</p>
<p><strong>Note:</strong> Player accounts and characters in rAthena will <strong>NOT</strong> be deleted.</p>

<form action="<?php echo $this->urlWithQs ?>" method="post" class="generic-form">
	<input type="hidden" name="reinstall" value="1" />
	<table class="generic-form-table">
		<tr>
			<th><label>Reset Options:</label></th>
			<td>
				<label><input type="checkbox" name="reset_schemas" value="1" checked disabled /> Clear schema version logs (Re-runs SQL migrations)</label><br />
				<label><input type="checkbox" name="reset_cms_defaults" value="1" /> Reset homepage &amp; CMS settings to defaults</label>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;">
				<input type="submit" value="Reset &amp; Launch Installation Wizard &rarr;" onclick="return confirm('Are you sure you want to proceed with resetting schema tracking?')" />
			</td>
		</tr>
	</table>
</form>
