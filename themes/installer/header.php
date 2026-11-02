<?php if (!defined('FLUX_ROOT')) exit; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/x-icon" href="./favicon.ico" />
	<title>FluxCP &bull; Realm Setup &amp; Installation Wizard</title>

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">

	<style type="text/css">
		:root {
			--color-midnight: #0B1020;
			--color-arcane:   #242044;
			--color-violet:   #9D80E8;
			--color-gold:     #D6AD66;
			--color-card:     #171C31;
			--color-text:     #F4F0FF;
			--color-muted:    #A6ACC5;
			--border-subtle:  rgba(166, 172, 197, 0.14);
			--border-card:    rgba(157, 128, 232, 0.22);
			--border-gold:    rgba(214, 173, 102, 0.40);
			--radius-md:      12px;
			--radius-sm:      6px;
			--shadow-card:    0 12px 36px rgba(0, 0, 0, 0.55);
		}

		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		body {
			background-color: var(--color-midnight);
			background-image: 
				radial-gradient(ellipse 80% 50% at 50% -20%, rgba(157, 128, 232, 0.18), transparent 70%),
				radial-gradient(circle at 10% 20%, rgba(36, 32, 68, 0.6), transparent 40%),
				linear-gradient(180deg, #070A14 0%, #0B1020 100%);
			background-attachment: fixed;
			color: var(--color-text);
			font-family: 'Outfit', sans-serif;
			font-size: 15px;
			line-height: 1.6;
			min-height: 100vh;
			display: flex;
			flex-direction: column;
		}

		.installer-header-bar {
			background: rgba(11, 16, 32, 0.95);
			border-bottom: 1px solid var(--border-card);
			padding: 18px 0;
			backdrop-filter: blur(12px);
			position: sticky;
			top: 0;
			z-index: 100;
		}

		.installer-container {
			max-width: 1100px;
			margin: 0 auto;
			padding: 0 24px;
			width: 100%;
		}

		.installer-brand {
			display: flex;
			align-items: center;
			justify-content: space-between;
			flex-wrap: wrap;
			gap: 16px;
		}

		.installer-logo-wrap {
			display: flex;
			align-items: center;
			gap: 14px;
			text-decoration: none;
		}

		.installer-logo-img {
			width: 44px;
			height: 44px;
			border-radius: 8px;
			border: 1px solid var(--border-gold);
			box-shadow: 0 0 16px rgba(214, 173, 102, 0.25);
		}

		.installer-title-text {
			font-family: 'Cinzel', serif;
			font-size: 1.35rem;
			font-weight: 800;
			letter-spacing: 0.08em;
			color: #fff;
			text-transform: uppercase;
		}

		.installer-subtitle-text {
			display: block;
			font-family: 'Rajdhani', sans-serif;
			font-size: 0.78rem;
			font-weight: 700;
			color: var(--color-gold);
			letter-spacing: 0.15em;
			text-transform: uppercase;
		}

		.installer-steps-bar {
			display: flex;
			gap: 8px;
			flex-wrap: wrap;
		}

		.step-pill {
			padding: 6px 14px;
			border-radius: var(--radius-sm);
			font-size: 0.8rem;
			font-weight: 700;
			font-family: 'Rajdhani', sans-serif;
			letter-spacing: 0.06em;
			text-transform: uppercase;
			border: 1px solid var(--border-subtle);
			background: rgba(36, 32, 68, 0.4);
			color: var(--color-muted);
		}

		.step-pill.active {
			background: var(--color-arcane);
			border-color: var(--color-gold);
			color: var(--color-gold);
			box-shadow: 0 0 12px rgba(214, 173, 102, 0.2);
		}

		.step-pill.done {
			border-color: var(--color-violet);
			color: var(--color-violet);
		}

		.installer-main {
			flex: 1;
			padding: 40px 0 60px 0;
		}

		.installer-card {
			background: var(--color-card);
			border: 1px solid var(--border-card);
			border-radius: var(--radius-md);
			padding: 32px;
			box-shadow: var(--shadow-card);
			margin-bottom: 28px;
		}

		.installer-card.card-gold {
			border-color: var(--border-gold);
			box-shadow: 0 12px 36px rgba(0, 0, 0, 0.6), 0 0 20px rgba(214, 173, 102, 0.1);
		}

		.card-header-styled {
			display: flex;
			align-items: center;
			justify-content: space-between;
			border-left: 3px solid var(--color-gold);
			padding-left: 14px;
			margin-bottom: 22px;
		}

		.card-title-styled {
			font-family: 'Cinzel', serif;
			font-size: 1.25rem;
			font-weight: 700;
			letter-spacing: 0.04em;
			color: #fff;
			text-transform: uppercase;
		}

		/* Form Inputs & Controls */
		input[type="text"],
		input[type="password"],
		input[type="email"],
		input[type="url"],
		input[type="number"],
		textarea,
		select {
			width: 100%;
			background: #0E1324;
			border: 1px solid var(--border-card);
			border-radius: var(--radius-sm);
			color: var(--color-text);
			font-family: 'Outfit', sans-serif;
			font-size: 0.95rem;
			padding: 10px 14px;
			outline: none;
			transition: all 0.2s ease;
		}

		input:focus,
		textarea:focus,
		select:focus {
			border-color: var(--color-gold);
			background: #12182E;
			box-shadow: 0 0 10px rgba(214, 173, 102, 0.25);
		}

		label {
			display: block;
			font-family: 'Rajdhani', sans-serif;
			font-size: 0.85rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.06em;
			color: var(--color-gold);
			margin-bottom: 6px;
		}

		.form-grid-2 {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
		}

		.form-grid-3 {
			display: grid;
			grid-template-columns: 1fr 1fr 1fr;
			gap: 20px;
		}

		@media (max-width: 768px) {
			.form-grid-2,
			.form-grid-3 {
				grid-template-columns: 1fr;
			}
		}

		/* Action Buttons */
		.btn-gold {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			background: linear-gradient(135deg, #e4c17e 0%, #D6AD66 50%, #b88d44 100%);
			color: #0B1020;
			border: 1px solid #ffd480;
			border-radius: var(--radius-sm);
			padding: 12px 24px;
			font-family: 'Rajdhani', sans-serif;
			font-size: 0.98rem;
			font-weight: 800;
			letter-spacing: 0.08em;
			text-transform: uppercase;
			cursor: pointer;
			text-decoration: none;
			transition: all 0.25s ease;
			box-shadow: 0 4px 15px rgba(214, 173, 102, 0.35);
		}

		.btn-gold:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(214, 173, 102, 0.5);
			color: #000;
		}

		.btn-secondary {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			background: rgba(36, 32, 68, 0.6);
			color: var(--color-text);
			border: 1px solid var(--border-card);
			border-radius: var(--radius-sm);
			padding: 10px 20px;
			font-family: 'Rajdhani', sans-serif;
			font-size: 0.92rem;
			font-weight: 700;
			letter-spacing: 0.06em;
			text-transform: uppercase;
			cursor: pointer;
			text-decoration: none;
			transition: all 0.2s ease;
		}

		.btn-secondary:hover {
			background: var(--color-arcane);
			border-color: var(--color-violet);
			color: #fff;
		}

		/* Tables */
		.installer-table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 20px;
			border-radius: var(--radius-sm);
			overflow: hidden;
		}

		.installer-table th {
			background: #12172A;
			color: var(--color-gold);
			font-family: 'Rajdhani', sans-serif;
			font-size: 0.85rem;
			font-weight: 700;
			letter-spacing: 0.06em;
			text-transform: uppercase;
			padding: 12px 16px;
			border-bottom: 1px solid var(--border-subtle);
			text-align: left;
		}

		.installer-table td {
			padding: 12px 16px;
			background: rgba(23, 28, 49, 0.5);
			border-bottom: 1px solid var(--border-subtle);
			font-size: 0.92rem;
		}

		.installer-table tr:hover td {
			background: rgba(36, 32, 68, 0.4);
		}

		/* Badges & Alerts */
		.badge-success {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			padding: 4px 10px;
			border-radius: 20px;
			background: rgba(46, 204, 113, 0.18);
			color: #2ecc71;
			border: 1px solid rgba(46, 204, 113, 0.4);
			font-size: 0.8rem;
			font-weight: 700;
		}

		.badge-danger {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			padding: 4px 10px;
			border-radius: 20px;
			background: rgba(231, 76, 60, 0.18);
			color: #e74c3c;
			border: 1px solid rgba(231, 76, 60, 0.4);
			font-size: 0.8rem;
			font-weight: 700;
		}

		.alert-banner {
			padding: 14px 18px;
			border-radius: var(--radius-sm);
			margin-bottom: 24px;
			display: flex;
			align-items: center;
			gap: 12px;
		}

		.alert-banner.success {
			background: rgba(46, 204, 113, 0.12);
			border: 1px solid rgba(46, 204, 113, 0.35);
			color: #2ecc71;
		}

		.alert-banner.danger {
			background: rgba(231, 76, 60, 0.12);
			border: 1px solid rgba(231, 76, 60, 0.35);
			color: #e74c3c;
		}
	</style>
</head>
<body>
	<header class="installer-header-bar">
		<div class="installer-container">
			<div class="installer-brand">
				<div class="installer-logo-wrap">
					<img src="<?php echo $this->themePath('rathena-001.png') ?>" alt="FluxCP" class="installer-logo-img" />
					<div>
						<span class="installer-title-text">FLUXCP REALM WIZARD</span>
						<span class="installer-subtitle-text">Eclipse Realm V2 &bull; Setup &amp; Configuration</span>
					</div>
				</div>

				<div class="installer-steps-bar">
					<span class="step-pill <?php echo !$session->installerAuth ? 'active' : 'done' ?>">1. System Check</span>
					<span class="step-pill <?php echo !$session->installerAuth ? '' : (isset($updateNeeded) && $updateNeeded ? 'active' : 'done') ?>">2. Schemas</span>
					<span class="step-pill <?php echo $session->installerAuth ? 'active' : '' ?>">3. Realm &amp; Info Setup</span>
				</div>
			</div>
		</div>
	</header>

	<main class="installer-main">
		<div class="installer-container">
			<?php if ($message=$session->getMessage()): ?>
				<div class="alert-banner success">
					<span>&#10003;</span>
					<span><?php echo htmlspecialchars($message) ?></span>
				</div>
			<?php endif ?>

			<?php if (!empty($errorMessage)): ?>
				<div class="alert-banner danger">
					<span>&#9888;</span>
					<span><?php echo htmlspecialchars($errorMessage) ?></span>
				</div>
			<?php endif ?>
