<?php
if (!defined('FLUX_ROOT')) exit;
$currentStep = (int)($params->get('step') ?: 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/x-icon" href="./favicon.ico" />
	<title>Flux Control Panel &bull; Setup &amp; Installation Manager</title>

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

	<style type="text/css">
		:root {
			--inst-bg:         #0B0F19;
			--inst-surface:    #111827;
			--inst-card:       #1E293B;
			--inst-card-alt:   #162032;
			--inst-border:     rgba(148, 163, 184, 0.16);
			--inst-border-hl:  rgba(56, 189, 248, 0.40);
			--inst-text:       #F8FAFC;
			--inst-text-muted: #94A3B8;
			--inst-primary:    #38BDF8;
			--inst-primary-hl: #0284C7;
			--inst-indigo:     #6366F1;
			--inst-success:    #10B981;
			--inst-success-bg: rgba(16, 185, 129, 0.12);
			--inst-danger:     #EF4444;
			--inst-danger-bg:  rgba(239, 68, 68, 0.12);
			--inst-warning:    #F59E0B;
			--inst-warning-bg: rgba(245, 158, 11, 0.12);
			--radius-lg:       12px;
			--radius-md:       8px;
			--radius-sm:       4px;
			--font-sans:       'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
			--font-mono:       'JetBrains Mono', Consolas, Monaco, monospace;
		}

		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		body {
			background-color: var(--inst-bg);
			background-image: 
				radial-gradient(circle at 50% 0%, rgba(56, 189, 248, 0.10) 0%, transparent 60%),
				radial-gradient(circle at 85% 30%, rgba(99, 102, 241, 0.08) 0%, transparent 40%),
				linear-gradient(180deg, #070A12 0%, #0B0F19 100%);
			background-attachment: fixed;
			color: var(--inst-text);
			font-family: var(--font-sans);
			font-size: 14.5px;
			line-height: 1.6;
			min-height: 100vh;
			display: flex;
			flex-direction: column;
		}

		/* Header Bar */
		.inst-topbar {
			background: rgba(17, 24, 39, 0.90);
			border-bottom: 1px solid var(--inst-border);
			padding: 16px 0;
			backdrop-filter: blur(12px);
			position: sticky;
			top: 0;
			z-index: 100;
		}

		.inst-container {
			max-width: 1080px;
			margin: 0 auto;
			padding: 0 24px;
			width: 100%;
		}

		.inst-nav-row {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 16px;
			flex-wrap: wrap;
		}

		.inst-brand {
			display: flex;
			align-items: center;
			gap: 12px;
			text-decoration: none;
			color: #fff;
		}

		.inst-brand-badge {
			width: 38px;
			height: 38px;
			border-radius: var(--radius-md);
			background: linear-gradient(135deg, var(--inst-primary) 0%, var(--inst-indigo) 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.25rem;
			color: #fff;
			font-weight: 800;
			box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
		}

		.inst-brand-text h1 {
			font-size: 1.15rem;
			font-weight: 700;
			letter-spacing: -0.01em;
			color: #fff;
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.inst-brand-text span {
			font-size: 0.76rem;
			color: var(--inst-text-muted);
			display: block;
			text-transform: uppercase;
			letter-spacing: 0.05em;
		}

		/* Stepper */
		.inst-stepper {
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.inst-step-pill {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			padding: 6px 14px;
			border-radius: var(--radius-md);
			font-size: 0.82rem;
			font-weight: 600;
			background: rgba(30, 41, 59, 0.6);
			border: 1px solid var(--inst-border);
			color: var(--inst-text-muted);
		}

		.inst-step-pill.active {
			background: rgba(56, 189, 248, 0.15);
			border-color: var(--inst-primary);
			color: #fff;
		}

		.inst-step-pill.completed {
			background: var(--inst-success-bg);
			border-color: rgba(16, 185, 129, 0.4);
			color: var(--inst-success);
		}

		.inst-step-num {
			width: 20px;
			height: 20px;
			border-radius: 50%;
			background: rgba(255, 255, 255, 0.15);
			display: inline-flex;
			align-items: center;
			justify-content: center;
			font-size: 0.72rem;
			font-weight: 700;
		}

		.inst-step-pill.active .inst-step-num {
			background: var(--inst-primary);
			color: #000;
		}

		.inst-step-pill.completed .inst-step-num {
			background: var(--inst-success);
			color: #fff;
		}

		/* Main Body */
		.inst-main {
			flex: 1;
			padding: 36px 0 60px 0;
		}

		/* Cards */
		.inst-card {
			background: var(--inst-card);
			border: 1px solid var(--inst-border);
			border-radius: var(--radius-lg);
			padding: 28px;
			margin-bottom: 24px;
			box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
			position: relative;
		}

		.inst-card.card-primary {
			border-color: var(--inst-border-hl);
		}

		.inst-card-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 16px;
			padding-bottom: 14px;
			border-bottom: 1px solid var(--inst-border);
		}

		.inst-card-title {
			font-size: 1.15rem;
			font-weight: 700;
			color: #fff;
			display: flex;
			align-items: center;
			gap: 10px;
		}

		.inst-card-title span.badge-num {
			width: 26px;
			height: 26px;
			border-radius: 6px;
			background: var(--inst-primary);
			color: #0B0F19;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			font-size: 0.82rem;
			font-weight: 800;
		}

		/* Tables */
		.inst-table {
			width: 100%;
			border-collapse: collapse;
			margin: 16px 0;
			background: var(--inst-card-alt);
			border-radius: var(--radius-md);
			overflow: hidden;
			border: 1px solid var(--inst-border);
		}

		.inst-table th {
			background: rgba(17, 24, 39, 0.85);
			color: var(--inst-text-muted);
			font-size: 0.76rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.06em;
			padding: 12px 16px;
			text-align: left;
			border-bottom: 1px solid var(--inst-border);
		}

		.inst-table td {
			padding: 12px 16px;
			border-bottom: 1px solid rgba(148, 163, 184, 0.08);
			font-size: 0.9rem;
			color: #E2E8F0;
		}

		.inst-table tr:last-child td {
			border-bottom: none;
		}

		/* Badges */
		.badge-pass {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			padding: 4px 10px;
			border-radius: var(--radius-sm);
			background: var(--inst-success-bg);
			border: 1px solid rgba(16, 185, 129, 0.3);
			color: var(--inst-success);
			font-size: 0.8rem;
			font-weight: 600;
		}

		.badge-fail {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			padding: 4px 10px;
			border-radius: var(--radius-sm);
			background: var(--inst-danger-bg);
			border: 1px solid rgba(239, 68, 68, 0.35);
			color: var(--inst-danger);
			font-size: 0.8rem;
			font-weight: 600;
		}

		.badge-warn {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			padding: 4px 10px;
			border-radius: var(--radius-sm);
			background: var(--inst-warning-bg);
			border: 1px solid rgba(245, 158, 11, 0.35);
			color: var(--inst-warning);
			font-size: 0.8rem;
			font-weight: 600;
		}

		/* Alerts */
		.inst-alert {
			padding: 16px 20px;
			border-radius: var(--radius-md);
			margin-bottom: 22px;
			display: flex;
			align-items: flex-start;
			gap: 14px;
			font-size: 0.92rem;
			line-height: 1.5;
		}

		.inst-alert.danger {
			background: var(--inst-danger-bg);
			border: 1px solid rgba(239, 68, 68, 0.4);
			color: #FECACA;
		}

		.inst-alert.success {
			background: var(--inst-success-bg);
			border: 1px solid rgba(16, 185, 129, 0.4);
			color: #A7F3D0;
		}

		.inst-alert.warning {
			background: var(--inst-warning-bg);
			border: 1px solid rgba(245, 158, 11, 0.4);
			color: #FDE68A;
		}

		/* Forms & Inputs */
		.inst-form-group {
			margin-bottom: 18px;
		}

		.inst-label {
			display: block;
			font-size: 0.82rem;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 0.05em;
			color: var(--inst-text-muted);
			margin-bottom: 6px;
		}

		.inst-input, select.inst-input, textarea.inst-input {
			width: 100%;
			background: #0B0F19;
			border: 1px solid var(--inst-border);
			border-radius: var(--radius-md);
			padding: 10px 14px;
			color: #fff;
			font-family: var(--font-sans);
			font-size: 0.92rem;
			transition: border-color 0.2s, box-shadow 0.2s;
		}

		.inst-input:focus {
			outline: none;
			border-color: var(--inst-primary);
			box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
		}

		.inst-grid-2 {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			gap: 18px;
		}

		.inst-grid-3 {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 18px;
		}

		@media (max-width: 768px) {
			.inst-grid-2, .inst-grid-3 {
				grid-template-columns: 1fr;
			}
		}

		/* Buttons */
		.inst-btn {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			padding: 11px 22px;
			border-radius: var(--radius-md);
			font-size: 0.92rem;
			font-weight: 600;
			cursor: pointer;
			text-decoration: none;
			transition: all 0.2s ease;
			border: 1px solid transparent;
		}

		.inst-btn-primary {
			background: linear-gradient(135deg, var(--inst-primary) 0%, #0284C7 100%);
			color: #0B0F19;
			font-weight: 700;
			box-shadow: 0 4px 14px rgba(56, 189, 248, 0.25);
		}

		.inst-btn-primary:hover:not(:disabled) {
			background: linear-gradient(135deg, #7DD3FC 0%, #0369A1 100%);
			transform: translateY(-1px);
			box-shadow: 0 6px 18px rgba(56, 189, 248, 0.35);
		}

		.inst-btn-primary:disabled {
			opacity: 0.5;
			cursor: not-allowed;
			box-shadow: none;
			filter: grayscale(80%);
		}

		.inst-btn-secondary {
			background: var(--inst-card-alt);
			border-color: var(--inst-border);
			color: var(--inst-text);
		}

		.inst-btn-secondary:hover {
			border-color: var(--inst-text-muted);
			background: rgba(30, 41, 59, 0.9);
		}

		.inst-btn-success {
			background: linear-gradient(135deg, var(--inst-success) 0%, #059669 100%);
			color: #fff;
			font-weight: 700;
		}

		/* Code block */
		code {
			font-family: var(--font-mono);
			background: rgba(0, 0, 0, 0.4);
			padding: 2px 6px;
			border-radius: 4px;
			color: var(--inst-primary);
			font-size: 0.85em;
		}
	</style>
</head>
<body>
	<header class="inst-topbar">
		<div class="inst-container">
			<div class="inst-nav-row">
				<a href="<?php echo rtrim($this->basePath, '/') ?>/?module=install" class="inst-brand">
					<div class="inst-brand-badge">&Delta;</div>
					<div class="inst-brand-text">
						<h1>Flux Control Panel <span>Ragnarok Online Setup</span></h1>
					</div>
				</a>

				<div class="inst-stepper">
					<div class="inst-step-pill <?php echo $currentStep === 1 ? 'active' : ($currentStep > 1 ? 'completed' : '') ?>">
						<span class="inst-step-num"><?php echo $currentStep > 1 ? '&#10003;' : '1' ?></span>
						<span>System Requirements</span>
					</div>
					<span style="color: var(--inst-border);">&rarr;</span>
					<div class="inst-step-pill <?php echo $currentStep === 2 ? 'active' : '' ?>">
						<span class="inst-step-num">2</span>
						<span>Server &amp; Theme Setup</span>
					</div>
				</div>
			</div>
		</div>
	</header>

	<main class="inst-main">
		<div class="inst-container">
