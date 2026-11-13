<?php if (!defined('FLUX_ROOT')) exit; ?>

<h2>Homepage CMS &amp; Theme Management</h2>
<p>Configure your server branding, active theme layout, homepage visibility toggles, hero banner, server rates, and feature cards.</p>

<?php if (!empty($errorMessage)): ?>
	<p class="message" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
		<?php echo htmlspecialchars($errorMessage) ?>
	</p>
<?php endif ?>

<form action="<?php echo $this->url('homepage', 'index') ?>" method="post">

	<!-- 1. Branding & Active Theme -->
	<h3>1. Server Branding &amp; Active Theme Selection</h3>
	<table class="generic-form-table">
		<tr>
			<th><label for="server_name">Server Name *</label></th>
			<td>
				<input type="text" name="server_name" id="server_name" value="<?php echo htmlspecialchars($settings['server_name'] ?? $settings['site_title'] ?? Flux::config('SiteTitle')) ?>" style="width: 320px;" required />
				<small>Primary server name displayed in browser title bar, navbars, and copyright notices.</small>
			</td>
		</tr>
		<tr>
			<th><label for="site_slogan">Header Slogan / Motto</label></th>
			<td>
				<input type="text" name="site_slogan" id="site_slogan" value="<?php echo htmlspecialchars($settings['site_slogan'] ?? 'Forge Your Legend. Claim Your Kingdom.') ?>" style="width: 320px;" />
				<small>Tagline displayed beneath the logo or in banner titles.</small>
			</td>
		</tr>
		<tr>
			<th><label for="site_logo_url">Custom Logo URL</label></th>
			<td>
				<input type="text" name="site_logo_url" id="site_logo_url" value="<?php echo htmlspecialchars($settings['site_logo_url'] ?? '') ?>" style="width: 320px;" placeholder="Leave empty for theme default logo" />
				<small>Direct image URL to replace the default logo image.</small>
			</td>
		</tr>
		<tr>
			<th><label for="site_footer_disclaimer">Footer Legal Disclaimer</label></th>
			<td>
				<input type="text" name="site_footer_disclaimer" id="site_footer_disclaimer" value="<?php echo htmlspecialchars($settings['site_footer_disclaimer'] ?? $settings['site_disclaimer'] ?? '') ?>" style="width: 480px;" placeholder="Gravity Co., Ltd. community disclaimer" />
				<small>Copyright and trademark notice displayed at the footer of all pages.</small>
			</td>
		</tr>
		<tr>
			<th>Active Community Theme *</th>
			<td>
				<?php $curTheme = Flux::config('ThemeName.0') ?: ($settings['active_theme'] ?? 'default'); ?>
				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 10px; margin: 8px 0;">
					<label style="border: 1px solid #00D9F5; padding: 10px; background: <?php echo ($curTheme === 'nexus') ? '#e9ecef' : '#fff' ?>; display: block; cursor: pointer;">
						<input type="radio" name="active_theme" value="nexus" <?php if ($curTheme === 'nexus') echo 'checked="checked"' ?> />
						<strong style="color: #007799;">Arcane Nexus V5</strong><br />
						<small>Futuristic Cyber-Magic Bento</small>
					</label>
					<label style="border: 1px solid #ccc; padding: 10px; background: <?php echo ($curTheme === 'default') ? '#e9ecef' : '#fff' ?>; display: block; cursor: pointer;">
						<input type="radio" name="active_theme" value="default" <?php if ($curTheme === 'default') echo 'checked="checked"' ?> />
						<strong>Default FluxCP</strong><br />
						<small>Classic Minimalist Table Layout</small>
					</label>
					<label style="border: 1px solid #ccc; padding: 10px; background: <?php echo ($curTheme === 'dominion') ? '#e9ecef' : '#fff' ?>; display: block; cursor: pointer;">
						<input type="radio" name="active_theme" value="dominion" <?php if ($curTheme === 'dominion') echo 'checked="checked"' ?> />
						<strong>Eternal Dominion V4</strong><br />
						<small>Royal Medieval &bull; Crimson &amp; Gold</small>
					</label>
					<label style="border: 1px solid #ccc; padding: 10px; background: <?php echo ($curTheme === 'celestial') ? '#e9ecef' : '#fff' ?>; display: block; cursor: pointer;">
						<input type="radio" name="active_theme" value="celestial" <?php if ($curTheme === 'celestial') echo 'checked="checked"' ?> />
						<strong>Celestial Chronicle V3</strong><br />
						<small>Light Anime-Fantasy &bull; Ivory &amp; Azure</small>
					</label>
					<label style="border: 1px solid #ccc; padding: 10px; background: <?php echo ($curTheme === 'freynix') ? '#e9ecef' : '#fff' ?>; display: block; cursor: pointer;">
						<input type="radio" name="active_theme" value="freynix" <?php if ($curTheme === 'freynix') echo 'checked="checked"' ?> />
						<strong>Eclipse Realm V2 (Freynix)</strong><br />
						<small>Dark Arcane Fantasy &bull; Midnight &amp; Gold</small>
					</label>
				</div>
				<small>Changing this switches the global frontend theme immediately upon saving.</small>
			</td>
		</tr>
	</table>

	<!-- 2. Section Visibility Toggles -->
	<h3 style="margin-top: 25px;">2. Homepage Section Visibility</h3>
	<table class="generic-form-table">
		<tr>
			<th>Display Sections</th>
			<td>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="hp_show_hero" value="1" <?php if (($settings['hp_show_hero'] ?? $settings['hp_hero_enabled'] ?? '1') == '1') echo 'checked' ?> />
					<strong>Cinematic Hero Banner Section</strong>
				</label>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="hp_show_status" value="1" <?php if (($settings['hp_show_status'] ?? $settings['hp_status_enabled'] ?? '1') == '1') echo 'checked' ?> />
					<strong>Server Rates &amp; Specifications Strip</strong>
				</label>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="hp_show_news" value="1" <?php if (($settings['hp_show_news'] ?? $settings['hp_news_enabled'] ?? '1') == '1') echo 'checked' ?> />
					<strong>Chronicles &amp; Latest News Feed</strong>
				</label>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="hp_show_features" value="1" <?php if (($settings['hp_show_features'] ?? $settings['hp_features_enabled'] ?? '1') == '1') echo 'checked' ?> />
					<strong>6 Feature Highlight Cards</strong>
				</label>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="hp_show_rankings" value="1" <?php if (($settings['hp_show_rankings'] ?? $settings['hp_rankings_enabled'] ?? '1') == '1') echo 'checked' ?> />
					<strong>Top Champions &amp; Rankings Preview</strong>
				</label>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="hp_show_woe" value="1" <?php if (($settings['hp_show_woe'] ?? '1') == '1') echo 'checked' ?> />
					<strong>War of Emperium Castle Warfare Strip</strong>
				</label>
				<label style="display: block; margin: 4px 0;">
					<input type="checkbox" name="hp_show_discord" value="1" <?php if (($settings['hp_show_discord'] ?? $settings['hp_community_enabled'] ?? '1') == '1') echo 'checked' ?> />
					<strong>Community &amp; Discord Call-to-Action</strong>
				</label>
			</td>
		</tr>
	</table>

	<!-- 3. Hero Banner Settings -->
	<h3 style="margin-top: 25px;">3. Hero Banner Configuration</h3>
	<table class="generic-form-table">
		<tr>
			<th><label for="hp_hero_title">Hero Main Heading</label></th>
			<td><input type="text" name="hp_hero_title" id="hp_hero_title" value="<?php echo htmlspecialchars($settings['hp_hero_title'] ?? $settings['hp_hero_heading'] ?? 'FORGE YOUR LEGEND. CLAIM YOUR KINGDOM.') ?>" style="width: 360px;" /></td>
		</tr>
		<tr>
			<th><label for="hp_hero_subtitle">Hero Badge / Subtitle</label></th>
			<td><input type="text" name="hp_hero_subtitle" id="hp_hero_subtitle" value="<?php echo htmlspecialchars($settings['hp_hero_subtitle'] ?? 'PREMIER RAGNAROK ONLINE REALM') ?>" style="width: 360px;" /></td>
		</tr>
		<tr>
			<th><label for="hp_hero_desc">Hero Story Description</label></th>
			<td>
				<textarea name="hp_hero_desc" id="hp_hero_desc" rows="3" style="width: 480px;"><?php echo htmlspecialchars($settings['hp_hero_desc'] ?? $settings['hp_hero_description'] ?? 'Enter a world of legendary battles, powerful guilds, and unforgettable adventures.') ?></textarea>
			</td>
		</tr>
		<tr>
			<th><label for="hp_hero_bg_image">Hero Background Image URL</label></th>
			<td><input type="text" name="hp_hero_bg_image" id="hp_hero_bg_image" value="<?php echo htmlspecialchars($settings['hp_hero_bg_image'] ?? '') ?>" style="width: 480px;" placeholder="Leave empty for theme default hero banner" /></td>
		</tr>
		<tr>
			<th>Hero Primary Button</th>
			<td>
				Text: <input type="text" name="hp_hero_btn1_text" value="<?php echo htmlspecialchars($settings['hp_hero_btn1_text'] ?? 'Begin Your Journey') ?>" style="width: 160px;" />
				URL: <input type="text" name="hp_hero_btn1_url" value="<?php echo htmlspecialchars($settings['hp_hero_btn1_url'] ?? $settings['hp_hero_btn1_link'] ?? '?module=account&action=create') ?>" style="width: 260px;" />
			</td>
		</tr>
		<tr>
			<th>Hero Secondary Button</th>
			<td>
				Text: <input type="text" name="hp_hero_btn2_text" value="<?php echo htmlspecialchars($settings['hp_hero_btn2_text'] ?? 'Explore The Realm') ?>" style="width: 160px;" />
				URL: <input type="text" name="hp_hero_btn2_url" value="<?php echo htmlspecialchars($settings['hp_hero_btn2_url'] ?? $settings['hp_hero_btn2_link'] ?? '?module=server&action=info') ?>" style="width: 260px;" />
			</td>
		</tr>
	</table>

	<!-- 4. Server Stats Strip -->
	<h3 style="margin-top: 25px;">4. Server Rates &amp; Specs Strip</h3>
	<table class="generic-form-table">
		<tr>
			<th><label for="hp_status_rates_text">EXP / Drop Rates</label></th>
			<td><input type="text" name="hp_status_rates_text" id="hp_status_rates_text" value="<?php echo htmlspecialchars($settings['hp_status_rates_text'] ?? $settings['server_rates'] ?? '25x / 25x / 10x') ?>" style="width: 240px;" /></td>
		</tr>
		<tr>
			<th>Max Level Cap</th>
			<td>
				Base: <input type="text" name="hp_status_base_level" value="<?php echo htmlspecialchars($settings['hp_status_base_level'] ?? '99') ?>" style="width: 60px;" />
				Job: <input type="text" name="hp_status_job_level" value="<?php echo htmlspecialchars($settings['hp_status_job_level'] ?? '70') ?>" style="width: 60px;" />
			</td>
		</tr>
		<tr>
			<th><label for="hp_status_mode_text">Server Mode / Architecture</label></th>
			<td><input type="text" name="hp_status_mode_text" id="hp_status_mode_text" value="<?php echo htmlspecialchars($settings['hp_status_mode_text'] ?? $settings['server_mode'] ?? 'Pre-Renewal Transcendent') ?>" style="width: 240px;" /></td>
		</tr>
	</table>

	<!-- 5. 6 Feature Cards -->
	<h3 style="margin-top: 25px;">5. 6 Homepage Feature Highlight Cards</h3>
	<table class="generic-form-table">
		<?php
			$defaultFeats = array(
				1 => array('Competitive Guild Sieges', 'Experience balanced War of Emperium action with custom castle treasures.'),
				2 => array('Fair & Robust Economy', 'Pure anti-pay-to-win design. All equipment and cards are earned through gameplay.'),
				3 => array('Glory & Prestige Rankings', 'Real-time character, guild, and battleground leaderboards.'),
				4 => array('Chivalric Custom Quests', 'Explore immersive lore-rich quest lines, headgear crafting, and kingdom events.'),
				5 => array('Optimized Modern Engine', 'Smooth high-FPS client with customized quality-of-life commands.'),
				6 => array('Unyielding Anti-Cheat Shield', 'Dedicated protection ensuring fair competition across all battlefields.')
			);
			for ($i = 1; $i <= 6; $i++):
				$fTitle = $settings["hp_feature_{$i}_title"] ?? $defaultFeats[$i][0];
				$fDesc  = $settings["hp_feature_{$i}_desc"] ?? $defaultFeats[$i][1];
		?>
		<tr>
			<th>Card #<?php echo $i ?></th>
			<td>
				Title: <input type="text" name="hp_feature_<?php echo $i ?>_title" value="<?php echo htmlspecialchars($fTitle) ?>" style="width: 260px;" /><br />
				Description: <input type="text" name="hp_feature_<?php echo $i ?>_desc" value="<?php echo htmlspecialchars($fDesc) ?>" style="width: 480px; margin-top: 4px;" />
			</td>
		</tr>
		<?php endfor ?>
	</table>

	<!-- 6. Community & Discord -->
	<h3 style="margin-top: 25px;">6. Community Gateways &amp; Discord CTA</h3>
	<table class="generic-form-table">
		<tr>
			<th><label for="hp_discord_title">Discord Banner Title</label></th>
			<td><input type="text" name="hp_discord_title" id="hp_discord_title" value="<?php echo htmlspecialchars($settings['hp_discord_title'] ?? 'YOUR LEGEND BEGINS HERE.') ?>" style="width: 320px;" /></td>
		</tr>
		<tr>
			<th><label for="hp_discord_desc">Discord Banner Description</label></th>
			<td><input type="text" name="hp_discord_desc" id="hp_discord_desc" value="<?php echo htmlspecialchars($settings['hp_discord_desc'] ?? 'Ascend the throne, claim your territory, and lead your brethren into history.') ?>" style="width: 480px;" /></td>
		</tr>
		<tr>
			<th><label for="discord_url">Official Discord URL</label></th>
			<td><input type="text" name="discord_url" id="discord_url" value="<?php echo htmlspecialchars($settings['discord_url'] ?? 'https://discord.gg/') ?>" style="width: 320px;" /></td>
		</tr>
		<tr>
			<th><label for="facebook_url">Official Facebook URL</label></th>
			<td><input type="text" name="facebook_url" id="facebook_url" value="<?php echo htmlspecialchars($settings['facebook_url'] ?? '') ?>" style="width: 320px;" /></td>
		</tr>
	</table>

	<p style="margin-top: 20px;">
		<input type="submit" value="Save Homepage Configuration" class="button" />
	</p>
</form>

