<?php if (!defined('FLUX_ROOT')) exit; ?>

<h2>Global Website Settings</h2>
<p>Configure website metadata, SEO tags, social media channels, maintenance advisory notices, and legal footers.</p>

<?php if (!empty($errorMessage)): ?>
	<p class="message" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
		<?php echo htmlspecialchars($errorMessage) ?>
	</p>
<?php endif ?>

<form action="<?php echo $this->url('settings', 'index') ?>" method="post">
	<h3>1. Maintenance Advisory Banner</h3>
	<table class="generic-form-table">
		<tr>
			<th>Maintenance Mode</th>
			<td>
				<label>
					<input type="checkbox" name="maintenance_mode" value="1" <?php if (($settings['maintenance_mode'] ?? '0') == '1') echo 'checked' ?> />
					<strong>Enable Site-Wide Maintenance Alert Banner</strong>
				</label><br />
				<small>Displays a prominent notice banner across all page headers.</small>
			</td>
		</tr>
		<tr>
			<th><label for="maintenance_notice">Notice Message</label></th>
			<td>
				<input type="text" name="maintenance_notice" id="maintenance_notice" value="<?php echo htmlspecialchars($settings['maintenance_notice'] ?? 'Scheduled maintenance in progress. Servers will return shortly.') ?>" style="width: 460px;" />
			</td>
		</tr>
	</table>

	<h3 style="margin-top: 25px;">2. General Site Branding</h3>
	<table class="generic-form-table">
		<tr>
			<th><label for="site_title">Website Title</label></th>
			<td><input type="text" name="site_title" id="site_title" value="<?php echo htmlspecialchars($settings['site_title'] ?? Flux::config('SiteTitle')) ?>" style="width: 320px;" /></td>
		</tr>
		<tr>
			<th><label for="site_slogan">Tagline / Slogan</label></th>
			<td><input type="text" name="site_slogan" id="site_slogan" value="<?php echo htmlspecialchars($settings['site_slogan'] ?? '') ?>" style="width: 320px;" /></td>
		</tr>
		<tr>
			<th><label for="site_logo_url">Custom Logo URL</label></th>
			<td><input type="text" name="site_logo_url" id="site_logo_url" value="<?php echo htmlspecialchars($settings['site_logo_url'] ?? '') ?>" style="width: 460px;" placeholder="https://..." /></td>
		</tr>
		<tr>
			<th><label for="support_email">Official Support Email</label></th>
			<td><input type="email" name="support_email" id="support_email" value="<?php echo htmlspecialchars($settings['support_email'] ?? $settings['contact_email'] ?? '') ?>" style="width: 320px;" /></td>
		</tr>
	</table>

	<h3 style="margin-top: 25px;">3. SEO &amp; Meta Information</h3>
	<table class="generic-form-table">
		<tr>
			<th><label for="site_description">Meta Description</label></th>
			<td><textarea name="site_description" id="site_description" rows="3" style="width: 460px;"><?php echo htmlspecialchars($settings['site_description'] ?? '') ?></textarea></td>
		</tr>
		<tr>
			<th><label for="site_keywords">Meta Keywords</label></th>
			<td><input type="text" name="site_keywords" id="site_keywords" value="<?php echo htmlspecialchars($settings['site_keywords'] ?? '') ?>" style="width: 460px;" placeholder="ragnarok, online, private server, mmorpg" /></td>
		</tr>
	</table>

	<h3 style="margin-top: 25px;">4. Social Media Communities</h3>
	<table class="generic-form-table">
		<tr>
			<th><label for="discord_url">Discord URL</label></th>
			<td><input type="text" name="discord_url" id="discord_url" value="<?php echo htmlspecialchars($settings['discord_url'] ?? 'https://discord.gg/') ?>" style="width: 360px;" /></td>
		</tr>
		<tr>
			<th><label for="facebook_url">Facebook URL</label></th>
			<td><input type="text" name="facebook_url" id="facebook_url" value="<?php echo htmlspecialchars($settings['facebook_url'] ?? '') ?>" style="width: 360px;" /></td>
		</tr>
		<tr>
			<th><label for="youtube_url">YouTube Channel</label></th>
			<td><input type="text" name="youtube_url" id="youtube_url" value="<?php echo htmlspecialchars($settings['youtube_url'] ?? '') ?>" style="width: 360px;" /></td>
		</tr>
	</table>

	<h3 style="margin-top: 25px;">5. Footer Legal Notice</h3>
	<table class="generic-form-table">
		<tr>
			<th><label for="footer_text">Footer Disclaimer</label></th>
			<td><textarea name="footer_text" id="footer_text" rows="3" style="width: 460px;"><?php echo htmlspecialchars($settings['footer_text'] ?? $settings['site_footer_disclaimer'] ?? '') ?></textarea></td>
		</tr>
	</table>

	<p style="margin-top: 20px;">
		<input type="submit" value="Save Global Settings" class="button" />
	</p>
</form>

