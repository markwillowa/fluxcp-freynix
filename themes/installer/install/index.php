<?php
if (!defined('FLUX_ROOT')) exit;
$cms = $cmsSettings ?? array();
?>

<!-- Step 1: System Requirements & Database Verification -->
<?php if ($currentStep === 1): ?>

	<!-- Notifications & Flash Messages -->
	<?php if ($message = $session->getMessage()): ?>
		<div class="inst-alert success">
			<span style="font-weight: 700; font-size: 1.1rem;">&#10003;</span>
			<div><?php echo htmlspecialchars($message) ?></div>
		</div>
	<?php endif ?>

	<?php if (!empty($errorMessage)): ?>
		<div class="inst-alert danger">
			<span style="font-weight: 700; font-size: 1.1rem;">&#9888;</span>
			<div><?php echo htmlspecialchars($errorMessage) ?></div>
		</div>
	<?php endif ?>

	<?php if (!empty($pathMismatch)): ?>
		<div class="inst-alert warning">
			<span style="font-size: 1.2rem;">&#9888;</span>
			<div>
				<strong>Web Path Change Detected!</strong><br />
				FluxCP is currently running under <code><?php echo htmlspecialchars($detectedBaseURI ?: '/') ?></code>, but <code>config/application.php</code> has <code><?php echo htmlspecialchars($configuredBaseURI ?: '/') ?></code>.<br />
				Please synchronize your Web Path below to ensure all theme assets and routes resolve with zero broken layout.
			</div>
		</div>
	<?php endif ?>

	<!-- Main Requirements Card -->
	<div class="inst-card card-primary">
		<div class="inst-card-header">
			<h2 class="inst-card-title">
				<span class="badge-num">1</span>
				<span>System Environment &amp; Extensions Check</span>
			</h2>
			<div>
				<?php if ($phpOk && $extsOk && $dirsOk): ?>
					<span class="badge-pass">&#10003; System Ready</span>
				<?php else: ?>
					<span class="badge-fail">&#10007; Action Required</span>
				<?php endif ?>
			</div>
		</div>
		<p style="color: var(--inst-text-muted); margin-bottom: 20px;">
			FluxCP requires PHP <?php echo $phpRequired ?>+ with specific extensions and writable directories for sessions, logging, and assets.
		</p>

		<!-- 1. PHP & Core Software -->
		<table class="inst-table">
			<thead>
				<tr>
					<th width="35%">Component</th>
					<th width="25%">Detected Version</th>
					<th width="20%">Requirement</th>
					<th width="20%">Status</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>PHP Engine</strong></td>
					<td><code>PHP <?php echo $phpVersion ?></code></td>
					<td><?php echo $phpRequired ?>+ (Rec: <?php echo $phpRecommended ?>+)</td>
					<td>
						<?php if ($phpOk): ?>
							<span class="badge-pass">&#10003; Compatible</span>
						<?php else: ?>
							<span class="badge-fail">&#10007; Upgrade Required</span>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<td><strong>MySQL / MariaDB Server</strong></td>
					<td><code><?php echo htmlspecialchars($mysqlVersion) ?></code></td>
					<td>5.0+</td>
					<td>
						<?php if ($dbConnected): ?>
							<span class="badge-pass">&#10003; Connected (<?php echo htmlspecialchars($mysqlUser) ?>)</span>
						<?php else: ?>
							<span class="badge-fail">&#10007; Not Connected</span>
						<?php endif ?>
					</td>
				</tr>
			</tbody>
		</table>

		<!-- 2. Required PHP Extensions -->
		<h3 style="font-size: 1rem; color: #fff; margin: 24px 0 10px 0; display: flex; align-items: center; gap: 8px;">
			<span>Required PHP Extensions</span>
			<?php if ($extsOk): ?>
				<span class="badge-pass" style="font-size: 0.72rem;">All 9 Installed</span>
			<?php else: ?>
				<span class="badge-fail" style="font-size: 0.72rem;">Missing Extensions</span>
			<?php endif ?>
		</h3>
		<table class="inst-table">
			<thead>
				<tr>
					<th width="25%">Extension</th>
					<th width="55%">Purpose</th>
					<th width="20%">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($extsResults as $extKey => $extInfo): ?>
					<tr>
						<td><code style="font-weight: 700;"><?php echo htmlspecialchars($extKey) ?></code></td>
						<td style="color: var(--inst-text-muted); font-size: 0.85rem;"><?php echo htmlspecialchars($extInfo['desc']) ?></td>
						<td>
							<?php if ($extInfo['loaded']): ?>
								<span class="badge-pass">&#10003; Loaded</span>
							<?php else: ?>
								<span class="badge-fail">&#10007; Missing</span>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		<!-- 3. Directory Permissions -->
		<h3 style="font-size: 1rem; color: #fff; margin: 24px 0 10px 0; display: flex; align-items: center; gap: 8px;">
			<span>Filesystem Storage Permissions</span>
			<?php if ($dirsOk): ?>
				<span class="badge-pass" style="font-size: 0.72rem;">All Writable</span>
			<?php else: ?>
				<span class="badge-fail" style="font-size: 0.72rem;">Permissions Required</span>
			<?php endif ?>
		</h3>
		<table class="inst-table">
			<thead>
				<tr>
					<th width="35%">Directory Path</th>
					<th width="45%">Function</th>
					<th width="20%">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($dirsResults as $dirKey => $dirInfo): ?>
					<tr>
						<td><code><?php echo htmlspecialchars($dirKey) ?></code></td>
						<td style="color: var(--inst-text-muted); font-size: 0.85rem;"><?php echo htmlspecialchars($dirInfo['desc']) ?></td>
						<td>
							<?php if ($dirInfo['writable']): ?>
								<span class="badge-pass">&#10003; Writable</span>
							<?php else: ?>
								<span class="badge-fail">&#10007; Not Writable</span>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

	<!-- Database & rAthena Login Table Verification Card -->
	<div class="inst-card">
		<div class="inst-card-header">
			<h2 class="inst-card-title">
				<span class="badge-num">2</span>
				<span>MySQL Database &amp; rAthena Login Table Check</span>
			</h2>
			<div>
				<?php if ($dbConnected && $loginTableExists && !$cpTablesMissing): ?>
					<span class="badge-pass">&#10003; Database &amp; Tables Ready</span>
				<?php elseif ($dbConnected && $loginTableExists): ?>
					<span class="badge-fail">&#10007; CP Tables Need Installation</span>
				<?php elseif ($dbConnected): ?>
					<span class="badge-fail">&#10007; Login Table Missing</span>
				<?php else: ?>
					<span class="badge-fail">&#10007; Connection Required</span>
				<?php endif ?>
			</div>
		</div>

		<p style="color: var(--inst-text-muted); margin-bottom: 20px;">
			Configure your database credentials below. FluxCP connects to your MySQL server, checks your specified database for the rAthena <code>login</code> table, and prepares the CMS tables.
		</p>

		<!-- Directly Visible Database Configuration Form -->
		<form action="<?php echo $this->urlWithQs ?>" method="post" style="background: var(--inst-card-alt); border: 1px solid var(--inst-border); border-radius: var(--radius-md); padding: 20px; margin-bottom: 24px;">
			<input type="hidden" name="save_mysql_config" value="1" />
			<div style="font-weight: 600; color: #fff; font-size: 0.95rem; margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
				<span style="display: flex; align-items: center; gap: 8px;">
					<span>&#9881; Database Connection Settings</span>
					<code style="font-size: 0.78rem; font-weight: normal; color: var(--inst-primary);">config/servers.php</code>
				</span>
				<span style="font-size: 0.8rem; color: var(--inst-text-muted);">
					Active DB: <strong style="color: #fff;"><?php echo htmlspecialchars($curDb) ?></strong>
				</span>
			</div>

			<div class="inst-grid-3">
				<div class="inst-form-group">
					<label class="inst-label">MySQL Host *</label>
					<input type="text" name="mysql_host" value="<?php echo htmlspecialchars($curHost) ?>" required class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">MySQL Port</label>
					<input type="number" name="mysql_port" value="<?php echo (int)$curPort ?>" class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Database Name *</label>
					<input type="text" name="mysql_db" value="<?php echo htmlspecialchars($curDb) ?>" required class="inst-input" />
				</div>
			</div>

			<div class="inst-grid-3">
				<div class="inst-form-group">
					<label class="inst-label">MySQL User *</label>
					<input type="text" name="mysql_user" value="<?php echo htmlspecialchars($curUser) ?>" required class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">MySQL Password</label>
					<input type="password" name="mysql_pass" value="<?php echo htmlspecialchars($curPass) ?>" placeholder="Enter password..." class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Server Group Name</label>
					<input type="text" name="server_name" value="<?php echo htmlspecialchars($curServerName) ?>" class="inst-input" />
				</div>
			</div>

			<div style="display: flex; justify-content: flex-end; margin-top: 10px;">
				<button type="submit" class="inst-btn inst-btn-primary" style="font-size: 0.88rem; padding: 10px 24px;">
					&#128269; Test &amp; Save Database Connection
				</button>
			</div>
		</form>

		<!-- Live Verification Results Table -->
		<h3 style="font-size: 0.95rem; color: #fff; margin: 0 0 12px 0; display: flex; align-items: center; gap: 8px;">
			<span>Database &amp; Schema Verification Results</span>
		</h3>
		<table class="inst-table">
			<thead>
				<tr>
					<th width="28%">Target</th>
					<th width="47%">Details</th>
					<th width="25%">Verification</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>Database Connection</strong></td>
					<td>Host: <code><?php echo htmlspecialchars($curHost) ?>:<?php echo (int)$curPort ?></code> &bull; DB: <code><?php echo htmlspecialchars($curDb) ?></code></td>
					<td>
						<?php if ($dbConnected): ?>
							<span class="badge-pass">&#10003; Connected (<?php echo htmlspecialchars($mysqlUser) ?>)</span>
						<?php else: ?>
							<span class="badge-fail">&#10007; Connection Failed</span>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<td><strong>rAthena <code>login</code> Table</strong></td>
					<td>
						<?php if ($loginTableExists): ?>
							<span style="color: #A7F3D0;">Found active rAthena login table in <code><?php echo htmlspecialchars($curDb) ?></code> with <strong><?php echo $loginRowCount ?></strong> registered account(s).</span>
						<?php elseif ($dbConnected): ?>
							<span style="color: #FECACA;">rAthena <code>login</code> table does not exist in database <code><?php echo htmlspecialchars($curDb) ?></code>. Please import your rAthena SQL tables.</span>
						<?php else: ?>
							<span style="color: var(--inst-text-muted);">Awaiting database connection.</span>
						<?php endif ?>
					</td>
					<td>
						<?php if ($loginTableExists): ?>
							<span class="badge-pass">&#10003; Table Exists</span>
						<?php elseif ($dbConnected): ?>
							<span class="badge-fail">&#10007; Missing</span>
						<?php else: ?>
							<span style="color: var(--inst-text-muted); font-size: 0.82rem;">&mdash;</span>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<td><strong>FluxCP Core &amp; CMS Tables</strong></td>
					<td>Tables: <code>cp_credits</code>, <code>cp_cmsnews</code>, <code>cp_downloads</code>, <code>cp_navigation</code>, <code>cp_commands</code>, <code>cp_cmspages</code>, etc.</td>
					<td>
						<?php if (!$cpTablesMissing): ?>
							<span class="badge-pass">&#10003; Ready</span>
						<?php elseif ($dbConnected && $loginTableExists): ?>
							<form action="<?php echo $this->urlWithQs ?>" method="post" style="display: inline;">
								<input type="hidden" name="install_all_tables" value="1" />
								<button type="submit" class="inst-btn inst-btn-primary" style="padding: 5px 14px; font-size: 0.8rem; box-shadow: 0 2px 8px rgba(56, 189, 248, 0.35);">
									&#9889; Install Tables
								</button>
							</form>
						<?php else: ?>
							<span class="badge-fail">&#10007; Missing</span>
						<?php endif ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<!-- Step 1 Gate: Proceed to Step 2 Form -->
	<div class="inst-card" style="border-color: <?php echo $allRequirementsMet ? 'rgba(16, 185, 129, 0.4)' : 'rgba(239, 68, 68, 0.4)' ?>;">
		<div class="inst-card-header">
			<h2 class="inst-card-title">
				<span class="badge-num" style="background: <?php echo $allRequirementsMet ? 'var(--inst-success)' : 'var(--inst-danger)' ?>; color: #fff;">3</span>
				<span>Requirements Verification Status</span>
			</h2>
			<div>
				<?php if ($allRequirementsMet): ?>
					<span class="badge-pass" style="font-size: 0.9rem;">&#10003; All Requirements Satisfied</span>
				<?php else: ?>
					<span class="badge-fail" style="font-size: 0.9rem;">&#10007; Requirements Incomplete</span>
				<?php endif ?>
			</div>
		</div>

		<?php if (!$allRequirementsMet): ?>
			<div class="inst-alert danger" style="margin-bottom: 20px;">
				<span style="font-size: 1.4rem;">&#9888;</span>
				<div>
					<strong>Cannot Proceed to Step 2:</strong><br />
					Please complete all required checks before proceeding:
					<ul style="margin: 8px 0 0 18px; padding: 0; font-size: 0.88rem; line-height: 1.6;">
						<?php if (!$phpOk || !$extsOk || !$dirsOk): ?>
							<li>PHP version, required extensions, or directory permissions need attention in Section 1.</li>
						<?php endif ?>
						<?php if (!$dbConnected): ?>
							<li>Database is not connected. Configure credentials in Section 2 above.</li>
						<?php elseif (!$loginTableExists): ?>
							<li>rAthena <code>login</code> table does not exist in database <code><?php echo htmlspecialchars($curDb) ?></code>.</li>
						<?php elseif ($cpTablesMissing): ?>
							<li>FluxCP Core &amp; CMS tables are missing. Click <strong>Install Tables</strong> in Section 2 above.</li>
						<?php endif ?>
					</ul>
				</div>
			</div>
			<div style="display: flex; justify-content: flex-end;">
				<button type="button" class="inst-btn inst-btn-primary" disabled>
					Proceed to Step 2: Server Details &rarr;
				</button>
			</div>
		<?php else: ?>
			<div class="inst-alert success" style="margin-bottom: 20px;">
				<span style="font-size: 1.4rem;">&#10003;</span>
				<div>
					<strong>All Requirements Satisfied!</strong><br />
					Your hosting environment meets all requirements, the MySQL connection is established, and the rAthena <code>login</code> table is ready.
				</div>
			</div>

			<?php if (!$session->installerAuth): ?>
				<!-- Authenticate with InstallerPassword to proceed -->
				<form action="<?php echo $this->urlWithQs ?>" method="post" style="background: var(--inst-card-alt); border: 1px solid var(--inst-border); border-radius: var(--radius-md); padding: 20px;">
					<h4 style="font-size: 0.95rem; color: #fff; margin-bottom: 8px;">
						Authenticate Installer Password
					</h4>
					<p style="color: var(--inst-text-muted); font-size: 0.88rem; margin-bottom: 16px;">
						Enter the <strong>Installer Password</strong> configured in <code>config/application.php</code> to unlock Step 2.
					</p>
					<div style="display: flex; gap: 12px; align-items: flex-end; max-width: 500px;">
						<div style="flex: 1;">
							<label class="inst-label">Installer Password</label>
							<input type="password" name="installer_password" placeholder="Enter InstallerPassword..." required class="inst-input" autofocus />
						</div>
						<button type="submit" class="inst-btn inst-btn-primary" style="white-space: nowrap;">
							Unlock &amp; Proceed &rarr;
						</button>
					</div>
				</form>
			<?php else: ?>
				<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
					<span style="color: var(--inst-success); font-weight: 600;">
						&#10003; Installer unlocked! You are authorized to configure server details.
					</span>
					<a href="<?php echo $this->url('install', 'index', array('step' => 2)) ?>" class="inst-btn inst-btn-primary" style="font-size: 1rem; padding: 12px 28px;">
						Proceed to Step 2: Server Details &amp; Theme Setup &rarr;
					</a>
				</div>
			<?php endif ?>
		<?php endif ?>
	</div>

<!-- Step 2: Server Details, Branding & Theme Setup -->
<?php else: ?>

	<!-- Step 2 Form -->
	<form action="<?php echo $this->url('install', 'index', array('step' => 2)) ?>" method="post">
		<input type="hidden" name="save_server_config" value="1" />
		<input type="hidden" name="app_base_uri" value="<?php echo htmlspecialchars($detectedBaseURI ?: ($configuredBaseURI ?: '/')) ?>" />
		<input type="hidden" name="app_server_address" value="<?php echo htmlspecialchars($curServerAddress ?: 'localhost') ?>" />

		<!-- 1. Preferred Website Theme Selection -->
		<div class="inst-card card-primary">
			<div class="inst-card-header">
				<h2 class="inst-card-title">
					<span class="badge-num">1</span>
					<span>Select Website Theme</span>
				</h2>
			</div>
			<p style="color: var(--inst-text-muted); margin-bottom: 20px;">
				Choose your preferred community website design. Both themes share identical CMS features and can also be switched anytime via the Homepage CMS.
			</p>

			<div class="inst-grid-2">
				<!-- Theme 1: Celestial Chronicle -->
				<label style="display: flex; gap: 16px; background: rgba(56, 189, 248, 0.06); border: 2px solid rgba(56, 189, 248, 0.35); padding: 20px; border-radius: var(--radius-lg); cursor: pointer; transition: all 0.2s;">
					<input type="radio" name="chosen_theme" value="celestial" checked style="width: auto; margin-top: 4px;" />
					<div>
						<strong style="color: var(--inst-primary); font-size: 1.1rem; display: block;">
							Celestial Chronicle V3
						</strong>
						<span style="color: #BAE6FD; font-size: 0.8rem; font-weight: 600; display: block; margin-top: 2px;">
							Light Anime-Fantasy &bull; Sky Islands &bull; Ivory &amp; Gold
						</span>
						<p style="color: var(--inst-text-muted); font-size: 0.85rem; margin-top: 8px;">
							An airy, expansive sky aesthetic featuring floating castles, golden sunbeams, translucent navigation, and soft particle atmosphere.
						</p>
					</div>
				</label>

				<!-- Theme 2: Eclipse Realm -->
				<label style="display: flex; gap: 16px; background: rgba(99, 102, 241, 0.06); border: 2px solid rgba(99, 102, 241, 0.35); padding: 20px; border-radius: var(--radius-lg); cursor: pointer; transition: all 0.2s;">
					<input type="radio" name="chosen_theme" value="freynix" style="width: auto; margin-top: 4px;" />
					<div>
						<strong style="color: #A5B4FC; font-size: 1.1rem; display: block;">
							Eclipse Realm V2
						</strong>
						<span style="color: #C7D2FE; font-size: 0.8rem; font-weight: 600; display: block; margin-top: 2px;">
							Dark Gothic Fantasy &bull; Obsidian Citadel &bull; Violet Auroras
						</span>
						<p style="color: var(--inst-text-muted); font-size: 0.85rem; margin-top: 8px;">
							A dark, competitive MMORPG look with glowing runes, deep violet lighting, floating server stats, and high-contrast leaderboards.
						</p>
					</div>
				</label>
			</div>
		</div>

		<!-- 2. Server Brand & Identity -->
		<div class="inst-card">
			<div class="inst-card-header">
				<h2 class="inst-card-title">
					<span class="badge-num">2</span>
					<span>Server Brand &amp; Identity</span>
				</h2>
			</div>

			<div class="inst-grid-2">
				<div class="inst-form-group">
					<label class="inst-label">Server Brand Name *</label>
					<input type="text" name="server_name" value="<?php echo htmlspecialchars($cms['server_name'] ?? 'Freynix Ragnarok Online') ?>" required class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Header Slogan *</label>
					<input type="text" name="site_slogan" value="<?php echo htmlspecialchars($cms['site_slogan'] ?? 'FORGE YOUR FREEDOM.') ?>" required class="inst-input" />
				</div>
			</div>

			<div class="inst-form-group">
				<label class="inst-label">Meta Description</label>
				<textarea name="site_description" rows="2" class="inst-input"><?php echo htmlspecialchars($cms['site_description'] ?? 'Experience classic Ragnarok Online reimagined. High-rate progression, competitive PvP, legendary MVP hunting, and epic War of Emperium sieges.') ?></textarea>
			</div>

			<div class="inst-grid-2">
				<div class="inst-form-group">
					<label class="inst-label">SEO Meta Keywords</label>
					<input type="text" name="site_keywords" value="<?php echo htmlspecialchars($cms['site_keywords'] ?? 'Ragnarok Online, RO Private Server, High Rate, Pre-Renewal, PvP, WoE') ?>" class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Custom Logo Image URL</label>
					<input type="text" name="site_logo_url" value="<?php echo htmlspecialchars($cms['site_logo_url'] ?? '') ?>" placeholder="Leave blank to use theme default logo" class="inst-input" />
				</div>
			</div>
		</div>

		<!-- 3. Server Gameplay & Rates -->
		<div class="inst-card">
			<div class="inst-card-header">
				<h2 class="inst-card-title">
					<span class="badge-num">3</span>
					<span>Gameplay Rates &amp; Caps</span>
				</h2>
			</div>

			<div class="inst-grid-3">
				<div class="inst-form-group">
					<label class="inst-label">EXP Rates Text *</label>
					<input type="text" name="hp_status_rates_text" value="<?php echo htmlspecialchars($cms['hp_status_rates_text'] ?? '1000x / 1000x') ?>" required class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Max Base Level</label>
					<input type="number" name="hp_status_base_level" value="<?php echo (int)($cms['hp_status_base_level'] ?? 99) ?>" class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Max Job Level</label>
					<input type="number" name="hp_status_job_level" value="<?php echo (int)($cms['hp_status_job_level'] ?? 70) ?>" class="inst-input" />
				</div>
			</div>

			<div class="inst-grid-3">
				<div class="inst-form-group">
					<label class="inst-label">Server Mode</label>
					<select name="hp_status_mode_text" class="inst-input">
						<option value="Pre-Renewal" <?php if (($cms['hp_status_mode_text'] ?? '') !== 'Renewal') echo 'selected' ?>>Pre-Renewal</option>
						<option value="Renewal" <?php if (($cms['hp_status_mode_text'] ?? '') === 'Renewal') echo 'selected' ?>>Renewal</option>
					</select>
				</div>
				<div class="inst-form-group">
					<label class="inst-label">War of Emperium Schedule</label>
					<input type="text" name="woe_schedule" value="<?php echo htmlspecialchars($cms['woe_schedule'] ?? 'Wed & Sat 20:00 - 22:00') ?>" class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Main Capital City</label>
					<input type="text" name="main_city" value="<?php echo htmlspecialchars($cms['main_city'] ?? 'Prontera') ?>" class="inst-input" />
				</div>
			</div>
		</div>

		<!-- 4. Hero Section Presentation -->
		<div class="inst-card">
			<div class="inst-card-header">
				<h2 class="inst-card-title">
					<span class="badge-num">4</span>
					<span>Hero Banner Content</span>
				</h2>
			</div>

			<div class="inst-grid-2">
				<div class="inst-form-group">
					<label class="inst-label">Hero Headline</label>
					<input type="text" name="hero_headline" value="<?php echo htmlspecialchars($cms['hero_headline'] ?? 'YOUR REALM. YOUR FREEDOM.') ?>" class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Hero Subtitle</label>
					<input type="text" name="hero_subtitle" value="<?php echo htmlspecialchars($cms['hero_subtitle'] ?? 'Classic adventures, limitless possibilities.') ?>" class="inst-input" />
				</div>
			</div>

			<div class="inst-form-group">
				<label class="inst-label">Hero Description</label>
				<textarea name="hero_description" rows="2" class="inst-input"><?php echo htmlspecialchars($cms['hero_description'] ?? 'Ascend to new heights in a reimagined anime-fantasy Ragnarok Online realm. Unearth mythical artifacts, conquer skyward dungeons, and build your legend amongst the stars.') ?></textarea>
			</div>

			<div class="inst-grid-2">
				<div class="inst-form-group">
					<label class="inst-label">Primary Button Text &amp; URL</label>
					<div style="display: flex; gap: 8px;">
						<input type="text" name="hero_cta_primary_text" value="<?php echo htmlspecialchars($cms['hero_cta_primary_text'] ?? 'Start Adventure') ?>" class="inst-input" style="flex: 1;" />
						<input type="text" name="hero_cta_primary_link" value="<?php echo htmlspecialchars($cms['hero_cta_primary_link'] ?? '?module=account&action=create') ?>" class="inst-input" style="flex: 1.5;" />
					</div>
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Secondary Button Text &amp; URL</label>
					<div style="display: flex; gap: 8px;">
						<input type="text" name="hero_cta_secondary_text" value="<?php echo htmlspecialchars($cms['hero_cta_secondary_text'] ?? 'Server Guide') ?>" class="inst-input" style="flex: 1;" />
						<input type="text" name="hero_cta_secondary_link" value="<?php echo htmlspecialchars($cms['hero_cta_secondary_link'] ?? '?module=server&action=info') ?>" class="inst-input" style="flex: 1.5;" />
					</div>
				</div>
			</div>
		</div>

		<!-- 5. Client Downloads & Community -->
		<div class="inst-card">
			<div class="inst-card-header">
				<h2 class="inst-card-title">
					<span class="badge-num">5</span>
					<span>Client Downloads &amp; Community Links</span>
				</h2>
			</div>

			<div class="inst-grid-2">
				<div class="inst-form-group">
					<label class="inst-label">Full Client Download URL</label>
					<input type="url" name="download_full_url" value="<?php echo htmlspecialchars($cms['download_full_url'] ?? 'https://mega.nz/') ?>" class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Lite Client Download URL</label>
					<input type="url" name="download_lite_url" value="<?php echo htmlspecialchars($cms['download_lite_url'] ?? 'https://mega.nz/') ?>" class="inst-input" />
				</div>
			</div>

			<div class="inst-grid-3">
				<div class="inst-form-group">
					<label class="inst-label">Discord Invite URL</label>
					<input type="url" name="discord_url" value="<?php echo htmlspecialchars($cms['discord_url'] ?? 'https://discord.gg/') ?>" class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Facebook Page URL</label>
					<input type="url" name="facebook_url" value="<?php echo htmlspecialchars($cms['facebook_url'] ?? '') ?>" placeholder="Optional..." class="inst-input" />
				</div>
				<div class="inst-form-group">
					<label class="inst-label">Support / Contact E-mail</label>
					<input type="email" name="contact_email" value="<?php echo htmlspecialchars($cms['contact_email'] ?? 'support@server.com') ?>" class="inst-input" />
				</div>
			</div>
		</div>

		<!-- Step 2 Actions -->
		<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 32px;">
			<a href="<?php echo $this->url('install', 'index', array('step' => 1)) ?>" class="inst-btn inst-btn-secondary">
				&larr; Back to Step 1 Requirements
			</a>
			<button type="submit" class="inst-btn inst-btn-primary" style="font-size: 1.05rem; padding: 14px 34px;">
				Save Configuration &amp; Launch Website &rarr;
			</button>
		</div>
	</form>

<?php endif ?>
