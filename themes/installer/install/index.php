<?php
if (!defined('FLUX_ROOT')) exit;
$cms = $cmsSettings ?? array();

// Load current configuration from config/servers.php
$serversCfg = @include FLUX_CONFIG_DIR . '/servers.php';
$curServer = is_array($serversCfg) && !empty($serversCfg[0]) ? $serversCfg[0] : array();
$curHost = $curServer['DbConfig']['Hostname'] ?? '127.0.0.1';
$curPort = $curServer['DbConfig']['Port'] ?? 3306;
$curUser = $curServer['DbConfig']['Username'] ?? 'root';
$curPass = $curServer['DbConfig']['Password'] ?? '';
$curDb   = $curServer['DbConfig']['Database'] ?? 'freynix';
$curServerName = $curServer['ServerName'] ?? 'Freynix Ragnarok Online';
?>

<?php if (!$session->installerAuth): ?>
	<?php $success = TRUE; ?>
	
	<div class="installer-card card-gold">
		<div class="card-header-styled">
			<h2 class="card-title-styled">STEP 1: SYSTEM ENVIRONMENT VERIFICATION</h2>
		</div>
		<p style="color: var(--color-muted); margin-bottom: 24px;">
			Before proceeding with the installation of your Ragnarok Online FluxCP realm, please verify that your hosting environment meets the prerequisites below.
		</p>

		<!-- Base Requirements -->
		<h4 style="font-family: 'Rajdhani', sans-serif; font-size: 1.1rem; color: var(--color-gold); text-transform: uppercase; margin-bottom: 12px;">
			Core Software Engines
		</h4>
		<table class="installer-table">
			<thead>
				<tr>
					<th width="30%">Software Component</th>
					<th width="30%">Detected Version</th>
					<th width="20%">Required</th>
					<th width="20%">Recommended</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>PHP Engine</strong></td>
					<td>
						<?php if (version_compare(PHP_VERSION, $minimumVersionCheck['php']['required']) >= 0): ?>
							<span class="badge-success">&#10003; PHP <?php echo PHP_VERSION ?></span>
						<?php else: $success = FALSE; ?>
							<span class="badge-danger">&#10007; PHP <?php echo PHP_VERSION ?> (Incompatible)</span>
						<?php endif ?>
					</td>
					<td style="color: var(--color-muted);"><?php echo $minimumVersionCheck['php']['required'] ?>+</td>
					<td style="color: var(--color-gold);"><?php echo $minimumVersionCheck['php']['recommended'] ?>+</td>
				</tr>
				<tr>
					<td><strong>MySQL / MariaDB Server</strong></td>
					<td>
						<?php if (version_compare($res->mysql_version, $minimumVersionCheck['mysql']['required']) >= 0): ?>
							<span class="badge-success">&#10003; MySQL <?php echo htmlspecialchars($res->mysql_version) ?></span>
						<?php else: $success = FALSE; ?>
							<span class="badge-danger">&#10007; MySQL <?php echo htmlspecialchars($res->mysql_version) ?> (Incompatible)</span>
						<?php endif ?>
					</td>
					<td style="color: var(--color-muted);"><?php echo $minimumVersionCheck['mysql']['required'] ?>+</td>
					<td style="color: var(--color-gold);"><?php echo $minimumVersionCheck['mysql']['recommended'] ?>+</td>
				</tr>
			</tbody>
		</table>

		<!-- PHP Extensions -->
		<h4 style="font-family: 'Rajdhani', sans-serif; font-size: 1.1rem; color: var(--color-gold); text-transform: uppercase; margin: 28px 0 12px 0;">
			Required PHP Extensions
		</h4>
		<table class="installer-table">
			<thead>
				<tr>
					<th width="50%">Extension</th>
					<th width="50%">Current Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($requiredExtensions as $ext): ?>
				<tr>
					<td><code><?php echo htmlspecialchars($ext) ?></code></td>
					<td>
						<?php if (extension_loaded($ext)): ?>
							<span class="badge-success">&#10003; Installed &amp; Loaded</span>
						<?php else: $success = FALSE; ?>
							<span class="badge-danger">&#10007; Missing Extension</span>
						<?php endif ?>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		<!-- File System Permissions -->
		<h4 style="font-family: 'Rajdhani', sans-serif; font-size: 1.1rem; color: var(--color-gold); text-transform: uppercase; margin: 28px 0 12px 0;">
			Writable Directory Permissions
		</h4>
		<table class="installer-table">
			<thead>
				<tr>
					<th width="60%">Directory Path</th>
					<th width="40%">Permission Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($permissionsChecks as $pathCheck => $pathDesc): ?>
					<?php $realP = realpath($pathCheck) ?: $pathCheck; ?>
					<tr>
						<td><small style="font-family: monospace; color: var(--color-muted);"><?php echo htmlspecialchars($realP) ?></small></td>
						<td>
							<?php if (is_writable($realP)): ?>
								<span class="badge-success">&#10003; Writable (<?php echo htmlspecialchars($pathDesc) ?>)</span>
							<?php else: $success = FALSE; ?>
								<span class="badge-danger">&#10007; Read-Only (Need chmod 0777)</span>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		<?php if ($success): ?>
			<!-- Password Form -->
			<div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-subtle);">
				<h3 style="font-family: 'Cinzel', serif; font-size: 1.15rem; color: #fff; margin-bottom: 8px;">
					AUTHENTICATE INSTALLER
				</h3>
				<p style="color: var(--color-muted); font-size: 0.9rem; margin-bottom: 18px;">
					Please enter your <strong>Installer Password</strong> (configured in <code>config/application.php</code>) to unlock the setup manager.
				</p>

				<form action="<?php echo $this->url ?>" method="post" style="max-width: 480px;">
					<div style="display: flex; gap: 12px; align-items: flex-end;">
						<div style="flex: 1;">
							<label for="installer_password">Installer Password</label>
							<input type="password" id="installer_password" name="installer_password" placeholder="Enter InstallerPassword..." required autofocus />
						</div>
						<button type="submit" class="btn-gold" style="white-space: nowrap;">
							<span>Unlock Installer &rarr;</span>
						</button>
					</div>
				</form>
			</div>
		<?php else: ?>
			<div class="alert-banner danger" style="margin-top: 24px;">
				<strong>Setup Blocked:</strong> Your server environment does not meet the minimum requirements. Please correct the highlighted errors above and refresh this page.
			</div>
		<?php endif ?>
	</div>

<?php else: ?>
	<!-- ========================================================================
	     AUTHENTICATED INSTALLER STATE
	     ======================================================================== -->

	<!-- Top Navigation Actions -->
	<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
		<div>
			<h2 style="font-family: 'Cinzel', serif; font-size: 1.6rem; color: #fff;">
				REALM CONFIGURATION WIZARD
			</h2>
			<p style="color: var(--color-muted); font-size: 0.92rem;">
				Configure your MySQL database connection (<code>config/servers.php</code>), verify schemas, and customize server branding before launching the website.
			</p>
		</div>
		<div style="display: flex; gap: 10px;">
			<a href="<?php echo $this->url('main', 'index') ?>" target="_blank" class="btn-secondary">
				<span>&#128065; Preview Main Page</span>
			</a>
			<a href="<?php echo $this->url($params->get('module'), null, array('logout' => 1)) ?>" onclick="return confirm('Exit and lock installer?')" class="btn-secondary" style="border-color: rgba(231, 76, 60, 0.4); color: #ff6b81;">
				<span>Lock / Logout</span>
			</a>
		</div>
	</div>

	<!-- Section 0: MySQL Database Connection & config/servers.php -->
	<div class="installer-card" style="border-color: var(--border-violet); margin-bottom: 28px;">
		<div class="card-header-styled" style="border-color: var(--color-violet);">
			<h3 class="card-title-styled" style="color: var(--color-violet);">&#128187; MYSQL DATABASE CREDENTIALS (CONFIG/SERVERS.PHP)</h3>
		</div>
		<p style="color: var(--color-muted); font-size: 0.9rem; margin-bottom: 20px;">
			Configure the MySQL database login parameters used by FluxCP. Updating these fields tests the MySQL connection and automatically writes the configuration into <code>config/servers.php</code>.
		</p>

		<form action="<?php echo $this->urlWithQs ?>" method="post">
			<input type="hidden" name="save_mysql_config" value="1" />

			<div class="form-grid-3" style="margin-bottom: 18px;">
				<div>
					<label for="mysql_host">MySQL Hostname * (e.g. 127.0.0.1 or localhost)</label>
					<input type="text" name="mysql_host" id="mysql_host" value="<?php echo htmlspecialchars($curHost) ?>" required />
				</div>
				<div>
					<label for="mysql_port">MySQL Port (Default: 3306)</label>
					<input type="number" name="mysql_port" id="mysql_port" value="<?php echo (int)$curPort ?>" />
				</div>
				<div>
					<label for="mysql_db">MySQL Database Name * (e.g. freynix or ragnarok)</label>
					<input type="text" name="mysql_db" id="mysql_db" value="<?php echo htmlspecialchars($curDb) ?>" required />
				</div>
			</div>

			<div class="form-grid-3" style="margin-bottom: 20px;">
				<div>
					<label for="mysql_user">MySQL Username * (e.g. admin or root)</label>
					<input type="text" name="mysql_user" id="mysql_user" value="<?php echo htmlspecialchars($curUser) ?>" required />
				</div>
				<div>
					<label for="mysql_pass">MySQL Password</label>
					<input type="password" name="mysql_pass" id="mysql_pass" value="<?php echo htmlspecialchars($curPass) ?>" placeholder="Enter MySQL password..." />
				</div>
				<div>
					<label for="mysql_server_name">Server Group Name in config/servers.php</label>
					<input type="text" name="mysql_server_name" id="mysql_server_name" value="<?php echo htmlspecialchars($curServerName) ?>" required />
				</div>
			</div>

			<div style="display: flex; justify-content: flex-end;">
				<button type="submit" class="btn-secondary" style="border-color: var(--border-gold); color: var(--color-gold); font-weight: 700;">
					<span>&#128190; Test &amp; Update MySQL Connection in config/servers.php &rarr;</span>
				</button>
			</div>
		</form>
	</div>

	<!-- Section 1: Database Schemas -->
	<?php if (!empty($updateNeeded)): ?>
	<div class="installer-card" style="border-color: rgba(243, 156, 18, 0.4); margin-bottom: 28px;">
		<div class="card-header-styled" style="border-color: #f39c12;">
			<h3 class="card-title-styled" style="color: #f39c12;">DATABASE SCHEMA UPDATES REQUIRED</h3>
		</div>
		<p style="color: var(--color-muted); font-size: 0.92rem; margin-bottom: 20px;">
			New database schemas or table migrations have been detected. Click below to install or update the database tables.
		</p>

		<div style="margin-bottom: 20px;">
			<a href="<?php echo $this->url($params->get('module'), null, array('update_all' => 1)) ?>" class="btn-gold" onclick="return confirm('Execute database schema migrations now?')">
				<span>&#9881; Install / Update All Database Schemas</span>
			</a>
		</div>

		<table class="installer-table">
			<thead>
				<tr>
					<th>Schema Name</th>
					<th>Latest Version</th>
					<th>Version Installed</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($installer->servers as $mainServerName => $mainServer): ?>
					<?php foreach ($mainServer->schemas as $schema): ?>
					<tr>
						<td>
							<strong style="color: #fff;"><?php echo htmlspecialchars($schema->schemaInfo['name']) ?></strong>
						</td>
						<td style="color: var(--color-gold); font-family: monospace;"><?php echo htmlspecialchars($schema->latestVersion) ?></td>
						<td>
							<?php if ($schema->versionInstalled == $schema->latestVersion): ?>
								<span class="badge-success">&#10003; Installed</span>
							<?php else: ?>
								<span class="badge-danger">Pending Update</span>
							<?php endif ?>
						</td>
					</tr>
					<?php endforeach ?>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<?php else: ?>
	<div class="alert-banner success" style="margin-bottom: 28px;">
		<span>&#10003;</span>
		<span><strong>Database Ready:</strong> All FluxCP core database schemas and custom CMS tables are verified and up to date!</span>
	</div>
	<?php endif ?>

	<!-- ========================================================================
	     Section 2: Comprehensive Server & Website Information Configuration
	     ======================================================================== -->
	<form action="<?php echo $this->urlWithQs ?>" method="post">
		<input type="hidden" name="save_server_config" value="1" />

		<!-- 1. Server Identity & Branding -->
		<div class="installer-card card-gold">
			<div class="card-header-styled">
				<h3 class="card-title-styled">&#127984; SERVER BRAND &amp; IDENTITY</h3>
			</div>
			<p style="color: var(--color-muted); font-size: 0.9rem; margin-bottom: 20px;">
				Set your custom server name, slogan, description, and branding. These values appear dynamically across all navigation menus, hero banners, page titles, and footers.
			</p>

			<div class="form-grid-2" style="margin-bottom: 20px;">
				<div>
					<label for="server_name">Server Name * (e.g. "Freynix RO", "Aegis Ragnarok Online")</label>
					<input type="text" name="server_name" id="server_name" value="<?php echo htmlspecialchars($cms['server_name'] ?? $cms['site_title'] ?? $curServerName) ?>" required />
				</div>
				<div>
					<label for="site_slogan">Brand Slogan / Tagline * (e.g. "YOUR REALM. YOUR FREEDOM.")</label>
					<input type="text" name="site_slogan" id="site_slogan" value="<?php echo htmlspecialchars($cms['site_slogan'] ?? 'YOUR REALM. YOUR FREEDOM.') ?>" required />
				</div>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="site_logo_url">Custom Logo Image URL (Optional - leave empty for theme default)</label>
				<input type="text" name="site_logo_url" id="site_logo_url" value="<?php echo htmlspecialchars($cms['site_logo_url'] ?? '') ?>" placeholder="e.g. https://your-domain.com/img/my-custom-logo.png" />
			</div>

			<div class="form-grid-2">
				<div>
					<label for="site_description">Server Meta Description (Search Engine Snippet)</label>
					<textarea name="site_description" id="site_description" rows="3"><?php echo htmlspecialchars($cms['site_description'] ?? 'An elite pre-renewal Ragnarok Online private server featuring high-rate progression, legendary MVP hunting, guild castle sieges, and pure competitive freedom.') ?></textarea>
				</div>
				<div>
					<label for="site_keywords">SEO Search Keywords (Comma separated)</label>
					<textarea name="site_keywords" id="site_keywords" rows="3"><?php echo htmlspecialchars($cms['site_keywords'] ?? 'ragnarok online, private server, pre-renewal, rathena, high rate, woe, pvp, ro server') ?></textarea>
				</div>
			</div>
		</div>

		<!-- 2. Gameplay Specs & Experience Rates -->
		<div class="installer-card">
			<div class="card-header-styled">
				<h3 class="card-title-styled">&#9876; GAMEPLAY MECHANICS &amp; RATES</h3>
			</div>
			<p style="color: var(--color-muted); font-size: 0.9rem; margin-bottom: 20px;">
				Configure the floating statistics cards, server info encyclopedia, and rates widgets displayed across your website.
			</p>

			<div class="form-grid-3" style="margin-bottom: 20px;">
				<div>
					<label for="hp_status_rates_text">EXP Rates Display (e.g. "1000x / 1000x")</label>
					<input type="text" name="hp_status_rates_text" id="hp_status_rates_text" value="<?php echo htmlspecialchars($cms['hp_status_rates_text'] ?? '1000x / 1000x') ?>" />
					<input type="hidden" name="rates_text" value="<?php echo htmlspecialchars($cms['hp_status_rates_text'] ?? '1000x / 1000x') ?>" />
				</div>
				<div>
					<label for="drop_rates">Drop Rates Display (e.g. "50x Normal / 1% MVP")</label>
					<input type="text" name="drop_rates" id="drop_rates" value="<?php echo htmlspecialchars($cms['drop_rates'] ?? '50x Normal / 1% MVP') ?>" />
				</div>
				<div>
					<label for="hp_status_mode_text">Server Mode / Architecture</label>
					<input type="text" name="hp_status_mode_text" id="hp_status_mode_text" value="<?php echo htmlspecialchars($cms['hp_status_mode_text'] ?? $cms['server_mode'] ?? 'Pre-Renewal') ?>" />
					<input type="hidden" name="server_mode" value="<?php echo htmlspecialchars($cms['hp_status_mode_text'] ?? $cms['server_mode'] ?? 'Pre-Renewal') ?>" />
				</div>
			</div>

			<div class="form-grid-3">
				<div>
					<label for="hp_status_base_level">Max Base Level (e.g. "99")</label>
					<input type="number" name="hp_status_base_level" id="hp_status_base_level" value="<?php echo (int)($cms['hp_status_base_level'] ?? 99) ?>" />
					<input type="hidden" name="max_base_level" value="<?php echo (int)($cms['hp_status_base_level'] ?? 99) ?>" />
				</div>
				<div>
					<label for="hp_status_job_level">Max Job Level (e.g. "70")</label>
					<input type="number" name="hp_status_job_level" id="hp_status_job_level" value="<?php echo (int)($cms['hp_status_job_level'] ?? 70) ?>" />
					<input type="hidden" name="max_job_level" value="<?php echo (int)($cms['hp_status_job_level'] ?? 70) ?>" />
				</div>
				<div>
					<label for="main_city">Main City Hub</label>
					<input type="text" name="main_city" id="main_city" value="<?php echo htmlspecialchars($cms['main_city'] ?? 'Prontera Capital') ?>" />
				</div>
			</div>

			<div style="margin-top: 20px;">
				<label for="woe_schedule">War of Emperium Schedule</label>
				<input type="text" name="woe_schedule" id="woe_schedule" value="<?php echo htmlspecialchars($cms['woe_schedule'] ?? 'Wed & Sat 20:00 - 22:00 ST') ?>" />
			</div>
		</div>

		<!-- 3. Cinematic Hero Section Banner -->
		<div class="installer-card">
			<div class="card-header-styled">
				<h3 class="card-title-styled">&#127756; HOMEPAGE HERO SECTION</h3>
			</div>
			<p style="color: var(--color-muted); font-size: 0.9rem; margin-bottom: 20px;">
				Customize the main headline, introduction, and call-to-action buttons on the homepage hero area.
			</p>

			<div class="form-grid-2" style="margin-bottom: 20px;">
				<div>
					<label for="hero_headline">Hero Headline Title</label>
					<input type="text" name="hero_headline" id="hero_headline" value="<?php echo htmlspecialchars($cms['hero_headline'] ?? $cms['hp_hero_title'] ?? 'Your Realm. Your Freedom.') ?>" />
				</div>
				<div>
					<label for="hero_subtitle">Hero Subtitle Badge</label>
					<input type="text" name="hero_subtitle" id="hero_subtitle" value="<?php echo htmlspecialchars($cms['hero_subtitle'] ?? $cms['hp_hero_subtitle'] ?? 'HIGH-RATE &bull; PRE-RENEWAL &bull; COMPETITIVE PVP &bull; GUILD CASTLES') ?>" />
				</div>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="hero_description">Hero Introduction Text</label>
				<textarea name="hero_description" id="hero_description" rows="3"><?php echo htmlspecialchars($cms['hero_description'] ?? $cms['hp_hero_desc'] ?? 'Experience classic Ragnarok Online reinvented. Master instant trans jobs, hunt legendary MVPs, siege guild castles, and carve your own legend in an unforgiving, player-driven economy.') ?></textarea>
			</div>

			<div class="form-grid-2">
				<div>
					<label for="hero_cta_primary_text">Primary CTA Button (Text &amp; Link)</label>
					<div style="display: flex; gap: 8px;">
						<input type="text" name="hero_cta_primary_text" id="hero_cta_primary_text" value="<?php echo htmlspecialchars($cms['hero_cta_primary_text'] ?? $cms['hp_hero_btn1_text'] ?? 'Play Now') ?>" placeholder="Button Text" style="flex: 1;" />
						<input type="text" name="hero_cta_primary_link" id="hero_cta_primary_link" value="<?php echo htmlspecialchars($cms['hero_cta_primary_link'] ?? $cms['hp_hero_btn1_url'] ?? '/?module=account&action=create') ?>" placeholder="Link / URL" style="flex: 1.5;" />
					</div>
				</div>
				<div>
					<label for="hero_cta_secondary_text">Secondary CTA Button (Text &amp; Link)</label>
					<div style="display: flex; gap: 8px;">
						<input type="text" name="hero_cta_secondary_text" id="hero_cta_secondary_text" value="<?php echo htmlspecialchars($cms['hero_cta_secondary_text'] ?? $cms['hp_hero_btn2_text'] ?? 'Explore Realm') ?>" placeholder="Button Text" style="flex: 1;" />
						<input type="text" name="hero_cta_secondary_link" id="hero_cta_secondary_link" value="<?php echo htmlspecialchars($cms['hero_cta_secondary_link'] ?? $cms['hp_hero_btn2_url'] ?? '/?module=server&action=info') ?>" placeholder="Link / URL" style="flex: 1.5;" />
					</div>
				</div>
			</div>
		</div>

		<!-- 4. Game Client Downloads -->
		<div class="installer-card">
			<div class="card-header-styled">
				<h3 class="card-title-styled">&#128190; CLIENT DOWNLOAD PACKAGES</h3>
			</div>
			<p style="color: var(--color-muted); font-size: 0.9rem; margin-bottom: 20px;">
				Set the download mirror links for both Full and Lite installers shown on the homepage and downloads section.
			</p>

			<div class="form-grid-2" style="margin-bottom: 20px;">
				<div>
					<label for="download_full_name">Full Game Client Name</label>
					<input type="text" name="download_full_name" id="download_full_name" value="<?php echo htmlspecialchars($cms['download_full_name'] ?? 'Full Client Package (v2.0)') ?>" />
				</div>
				<div>
					<label for="download_full_url">Full Client Download Mirror Link</label>
					<input type="url" name="download_full_url" id="download_full_url" value="<?php echo htmlspecialchars($cms['download_full_url'] ?? 'https://drive.google.com/') ?>" />
				</div>
			</div>

			<div class="form-grid-2">
				<div>
					<label for="download_lite_name">Lite / Small Client Patch Name</label>
					<input type="text" name="download_lite_name" id="download_lite_name" value="<?php echo htmlspecialchars($cms['download_lite_name'] ?? 'Lite Patch Installer') ?>" />
				</div>
				<div>
					<label for="download_lite_url">Lite Client Download Mirror Link</label>
					<input type="url" name="download_lite_url" id="download_lite_url" value="<?php echo htmlspecialchars($cms['download_lite_url'] ?? 'https://mega.nz/') ?>" />
				</div>
			</div>
		</div>

		<!-- 5. Community & Social Links -->
		<div class="installer-card">
			<div class="card-header-styled">
				<h3 class="card-title-styled">&#128172; COMMUNITY &amp; SUPPORT CHANNELS</h3>
			</div>
			<p style="color: var(--color-muted); font-size: 0.9rem; margin-bottom: 20px;">
				Connect your official Discord server, social media channels, and support contact email.
			</p>

			<div class="form-grid-2" style="margin-bottom: 20px;">
				<div>
					<label for="discord_url">Discord Server Invite URL *</label>
					<input type="url" name="discord_url" id="discord_url" value="<?php echo htmlspecialchars($cms['discord_url'] ?? $cms['hp_discord_url'] ?? 'https://discord.gg/') ?>" required />
					<input type="hidden" name="hp_discord_url" value="<?php echo htmlspecialchars($cms['discord_url'] ?? $cms['hp_discord_url'] ?? 'https://discord.gg/') ?>" />
				</div>
				<div>
					<label for="contact_email">Support / Contact Email Address</label>
					<input type="email" name="contact_email" id="contact_email" value="<?php echo htmlspecialchars($cms['contact_email'] ?? $cms['support_email'] ?? 'support@example.com') ?>" />
					<input type="hidden" name="support_email" value="<?php echo htmlspecialchars($cms['contact_email'] ?? $cms['support_email'] ?? 'support@example.com') ?>" />
				</div>
			</div>

			<div class="form-grid-2">
				<div>
					<label for="facebook_url">Facebook Page URL (Optional)</label>
					<input type="url" name="facebook_url" id="facebook_url" value="<?php echo htmlspecialchars($cms['facebook_url'] ?? $cms['hp_facebook_url'] ?? '') ?>" placeholder="https://facebook.com/your-server" />
					<input type="hidden" name="hp_facebook_url" value="<?php echo htmlspecialchars($cms['facebook_url'] ?? $cms['hp_facebook_url'] ?? '') ?>" />
				</div>
				<div>
					<label for="youtube_url">YouTube Channel URL (Optional)</label>
					<input type="url" name="youtube_url" id="youtube_url" value="<?php echo htmlspecialchars($cms['youtube_url'] ?? '') ?>" placeholder="https://youtube.com/@your-server" />
				</div>
			</div>
		</div>

		<!-- 6. Footer Disclaimer & Copyright -->
		<div class="installer-card">
			<div class="card-header-styled">
				<h3 class="card-title-styled">&#128220; FOOTER &amp; LEGAL DISCLAIMER</h3>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="footer_text">Custom Footer Disclaimer / Copyright Notice</label>
				<textarea name="footer_text" id="footer_text" rows="3"><?php echo htmlspecialchars($cms['footer_text'] ?? $cms['footer_disclaimer'] ?? 'This is an independent Ragnarok Online server. Ragnarok Online and all associated character designs, music, artwork, and trademarks are property of Gravity Co., Ltd. and Lee Myoungjin.') ?></textarea>
				<input type="hidden" name="footer_disclaimer" value="<?php echo htmlspecialchars($cms['footer_text'] ?? $cms['footer_disclaimer'] ?? '') ?>" />
			</div>
		</div>

		<!-- Final Submit Launch Banner -->
		<div style="background: rgba(36, 32, 68, 0.7); border: 2px solid var(--border-gold); border-radius: var(--radius-md); padding: 28px; text-align: center; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6); margin-top: 30px;">
			<h3 style="font-family: 'Cinzel', serif; font-size: 1.4rem; color: #fff; margin-bottom: 8px;">
				READY TO LAUNCH YOUR REALM?
			</h3>
			<p style="color: var(--color-muted); font-size: 0.95rem; max-width: 600px; margin: 0 auto 20px auto;">
				Clicking the button below will save all server settings to your database, initialize default navigation and announcement records, and launch the website with your customized information.
			</p>

			<div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
				<button type="submit" class="btn-gold" style="font-size: 1.1rem; padding: 14px 36px;">
					<span>&#9889; Save Configuration &amp; Launch Website &rarr;</span>
				</button>
			</div>
		</div>
	</form>
<?php endif ?>
