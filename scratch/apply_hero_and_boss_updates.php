<?php
$content = file_get_contents('themes/freynix/main/index.php');

// Define the new Hero section
$newHeroSection = <<<'HERO_EOD'
<!-- ========================================================================
     HOMEPAGE HERO SECTION
     ======================================================================== -->
<?php if (($hp['hp_show_hero'] ?? '1') == '1'): ?>
<section class="hero-section" style="background-image: url('<?php echo htmlspecialchars($heroBgImg) ?>');">
	<div class="hero-overlay"></div>
	<div class="hero-vignette"></div>

	<div class="freynix-container">
		<!-- Top Slogan from Official Freynix Artwork -->
		<div class="hero-quote-slogan">"Freedom to Play. Freedom to Conquer."</div>

		<!-- Main Hero Stage with Flanking Transcendent Jobs (Lord Knight & High Priest) -->
		<div class="hero-stage-flex">
			<!-- Left Flank: Lord Knight (Berserker / Frontline Bruiser) -->
			<div class="hero-flank-character flank-left">
				<div class="hero-char-img-wrap">
					<img src="<?php echo $this->themePath('img/hero_lord_knight_faded.png') ?>" alt="Lord Knight" class="hero-char-img" />
					<div class="hero-char-badge">
						<span class="badge-role">Frontline Berserker</span>
						<span class="badge-class">LORD KNIGHT</span>
					</div>
				</div>
			</div>

			<!-- Center Content: Logo, Rates, Join Now CTA -->
			<div class="hero-stage-center">
				<div class="hero-brand-wrap">
					<img src="<?php echo $this->themePath('img/logo.png') ?>" alt="FREYNIX RAGNAROK ONLINE" class="hero-brand-logo" />
				</div>

				<!-- Rates & Level Box -->
				<div class="hero-rates-box">
					<div class="rates-level-tag">LEVEL <?php echo htmlspecialchars($baseLevelText) ?>/<?php echo htmlspecialchars($jobLevelText) ?></div>
					<div class="rates-exp-tag">
						<span>EXP RATE <strong><?php echo htmlspecialchars($ratesText) ?></strong></span>
						<span class="rate-divider">|</span>
						<span>JOB RATE <strong><?php echo htmlspecialchars($ratesText) ?></strong></span>
					</div>
				</div>

				<!-- Call-to-Action Buttons -->
				<div class="hero-btn-group">
					<?php if (!$session->isLoggedIn()): ?>
						<a href="<?php echo htmlspecialchars($heroBtn1Url) ?>" class="hero-cta-btn-gold">
							<span>JOIN NOW!</span>
						</a>
						<a href="<?php echo htmlspecialchars($heroBtn2Url) ?>" class="freynix-btn btn-primary btn-lg">
							<span>⚡ <?php echo htmlspecialchars($heroBtn2Text) ?></span>
						</a>
					<?php else: ?>
						<a href="<?php echo $this->url('account', 'view') ?>" class="hero-cta-btn-gold">
							<span>🛡️ MY ACCOUNT</span>
						</a>
						<a href="<?php echo htmlspecialchars($heroBtn2Url) ?>" class="freynix-btn btn-primary btn-lg">
							<span>⚡ <?php echo htmlspecialchars($heroBtn2Text) ?></span>
						</a>
					<?php endif ?>
				</div>

				<!-- Secondary Links -->
				<div class="hero-secondary-links">
					<a href="<?php echo $this->url('main', 'downloads') ?>" class="hero-secondary-link">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM17 13l-5 5-5-5h3V9h4v4h3z"/></svg>
						Download Client
					</a>
					<span style="color: var(--text-dim);">&bull;</span>
					<a href="<?php echo htmlspecialchars($discordUrl) ?>" target="_blank" rel="noopener" class="hero-secondary-link">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.893.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
						Join Community
					</a>
					<span style="color: var(--text-dim);">&bull;</span>
					<a href="<?php echo $this->url('woe') ?>" class="hero-secondary-link">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l-5.5 9h11z M12 5.86L14.08 9h-4.16z M12 13l-4 8h8z"/></svg>
						WoE Timetable
					</a>
				</div>
			</div>

			<!-- Right Flank: High Priest (Saintly Guardian / Holy Support) -->
			<div class="hero-flank-character flank-right">
				<div class="hero-char-img-wrap">
					<img src="<?php echo $this->themePath('img/hero_high_priest_faded.png') ?>" alt="High Priest" class="hero-char-img" />
					<div class="hero-char-badge">
						<span class="badge-role">Divine Guardian</span>
						<span class="badge-class">HIGH PRIEST</span>
					</div>
				</div>
			</div>
		</div>

		<!-- 4 Core Server Feature Cards (Basic Cards, MVP Cards, PvP & WoE, Quests & Events) -->
		<div class="hero-promo-cards-grid">
			<div class="hero-promo-card">
				<div class="promo-card-thumb" style="background-image: url('<?php echo $this->themePath('img/feat_basic_cards.jpg') ?>');"></div>
				<div class="promo-card-content">
					<h4>BASIC CARDS PURCHASABLE</h4>
					<p>Get the cards you need and build your character faster!</p>
				</div>
			</div>

			<div class="hero-promo-card">
				<div class="promo-card-thumb" style="background-image: url('<?php echo $this->themePath('img/feat_mvp_cards.jpg') ?>');"></div>
				<div class="promo-card-content">
					<h4>MVP/BOSS CARDS</h4>
					<p>Selected MVP cards purchasable, others are <strong>HUNTED (1% Drop Rate)</strong> or obtainable through Quests.</p>
				</div>
			</div>

			<div class="hero-promo-card">
				<div class="promo-card-thumb" style="background-image: url('<?php echo $this->themePath('img/feat_pvp_woe.jpg') ?>');"></div>
				<div class="promo-card-content">
					<h4>PvP &amp; WoE</h4>
					<p>Competitive PvP and War of Emperium! Build your guild, conquer castles, and prove your strength!</p>
				</div>
			</div>

			<div class="hero-promo-card">
				<div class="promo-card-thumb" style="background-image: url('<?php echo $this->themePath('img/feat_quests_events.jpg') ?>');"></div>
				<div class="promo-card-content">
					<h4>QUESTS &amp; EVENTS</h4>
					<p>Enjoy quests, events, and a balanced economy with freedom of choice.</p>
				</div>
			</div>
		</div>

		<!-- 5 Golden Value Badges from Freynix Official Promo Artwork -->
		<div class="hero-golden-badges-row">
			<div class="golden-badge-item">
				<span class="golden-badge-icon">⚡</span>
				<span class="golden-badge-text">FAST PROGRESSION</span>
			</div>
			<div class="golden-badge-item">
				<span class="golden-badge-icon">👥</span>
				<span class="golden-badge-text">ACTIVE COMMUNITY</span>
			</div>
			<div class="golden-badge-item">
				<span class="golden-badge-icon">⚖️</span>
				<span class="golden-badge-text">FAIR &amp; FUN GAMEPLAY</span>
			</div>
			<div class="golden-badge-item">
				<span class="golden-badge-icon">👑</span>
				<span class="golden-badge-text">CUSTOM FEATURES</span>
			</div>
			<div class="golden-badge-item">
				<span class="golden-badge-icon">⚔️</span>
				<span class="golden-badge-text">EPIC BATTLES</span>
			</div>
		</div>
	</div>
</section>
<?php endif ?>

HERO_EOD;

// Define the new World Boss section (Single 2-column spotlight stage with 30s random rotation)
$newBossSection = <<<'BOSS_EOD'
<!-- ========================================================================
     LEGENDARY MVP WORLD BOSS CODEX (SINGLE 2-COLUMN VIEW, 30s RANDOM SWITCH)
     ======================================================================== -->
<section class="monsters-codex-section">
	<div class="freynix-container">
		<div class="section-header-centered">
			<span class="section-tag">👑 1% SELECTED MVP CARD DROP RATE</span>
			<h2 class="section-title">LEGENDARY WORLD BOSSES</h2>
			<p class="section-sub">Conquer ancient MVPs across Rune-Midgarts. Hunt authentic world bosses for legendary cards and godlike equipment.</p>
		</div>

		<!-- Single Spotlight 2-Column Stage (Left: Big Boss Sprite on Summon Pedestal, Right: Boss Information) -->
		<div class="boss-spotlight-stage" id="bossSpotlightStage">
			<!-- LEFT COLUMN: GIANT BOSS VISUAL & PEDESTAL -->
			<div class="boss-stage-visual" id="bossStageVisual">
				<div class="boss-stage-runes-ring"></div>
				<div class="boss-giant-sprite-box">
					<img id="bossSpriteImg" src="<?php echo $this->themePath('img/monsters/baphomet.gif') ?>" alt="World Boss" class="boss-giant-sprite-img" />
				</div>
				<div class="boss-pedestal-platform"></div>

				<!-- Quick Switch Indicator Dots -->
				<div class="boss-quick-dots" id="bossQuickDots">
					<button type="button" class="boss-dot-btn active" data-index="0" title="Baphomet"></button>
					<button type="button" class="boss-dot-btn" data-index="1" title="Valkyrie Randgris"></button>
					<button type="button" class="boss-dot-btn" data-index="2" title="Golden Thief Bug"></button>
					<button type="button" class="boss-dot-btn" data-index="3" title="Moonlight Flower"></button>
					<button type="button" class="boss-dot-btn" data-index="4" title="Ifrit"></button>
					<button type="button" class="boss-dot-btn" data-index="5" title="Angeling & Deviling"></button>
				</div>
			</div>

			<!-- RIGHT COLUMN: BOSS INTEL & DROPS -->
			<div class="boss-stage-intel" id="bossStageIntel">
				<div class="boss-intel-header">
					<span class="boss-level-type-pill" id="bossLevelPill">Lv. 81 • Demon • Shadow 3 • Large</span>
					<span class="boss-bounty-badge">⭐ ACTIVE REALM BOUNTY</span>
				</div>

				<div>
					<h3 class="boss-intel-name" id="bossName">BAPHOMET</h3>
					<div class="boss-intel-title" id="bossTitle">"The Ancient Horned Devil of Rune-Midgarts"</div>
				</div>

				<!-- Location & Respawn -->
				<div class="boss-location-bar">
					<span>📍 <strong id="bossLocation">Labyrinth Forest (prt_maze03)</strong></span>
					<span style="color: var(--border-subtle);">&bull;</span>
					<span>Respawn: <span id="bossRespawn" style="color: var(--gold-antique); font-weight: 700;">120 Minutes</span></span>
				</div>

				<!-- Prized 1% MVP Drops -->
				<div class="boss-drops-card">
					<div class="boss-drops-heading">👑 PRIZED MVP DROPS (1% CARD CHANCE)</div>
					<div class="boss-drops-list" id="bossDropsList">
						<div class="boss-drop-item">⭐ <strong>1% Baphomet Card</strong> <span class="drop-desc">— Regular attacks deal 3x3 splash damage around target</span></div>
						<div class="boss-drop-item">⚔️ <strong>Crescent Scythe [1]</strong> <span class="drop-desc">— ATK 180, Critical +30, Piercing spear</span></div>
						<div class="boss-drop-item">👑 <strong>Magni's Cap</strong> <span class="drop-desc">— Part of the legendary Odin's battle set</span></div>
					</div>
				</div>

				<!-- Combat Intel & Strategy -->
				<div class="boss-combat-intel-row">
					<div class="combat-stat-box">
						<span class="combat-stat-label">Combat Parameters</span>
						<span class="combat-stat-text" id="bossCombatStats">HP: 668,000 • DEF: 45+82 • MDEF: 52+95</span>
					</div>
					<div class="combat-stat-box">
						<span class="combat-stat-label">Tactical Hunter Intel</span>
						<span class="combat-stat-text" id="bossCombatIntel">Holy element weapon (Aspersio) &amp; high flee evasion recommended.</span>
					</div>
				</div>

				<!-- 30-Second Countdown Tracker -->
				<div class="boss-rotation-tracker">
					<div class="boss-rotation-info">
						<span>🎯 REALM BOUNTY ROTATION</span>
						<span>SWITCHING IN <strong id="bossTimerCount">30</strong>s</span>
					</div>
					<div class="boss-progress-bar-bg">
						<div class="boss-progress-bar-fill" id="bossProgressFill"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
(function() {
	var worldBosses = [
		{
			id: 'baphomet',
			name: 'BAPHOMET',
			title: 'The Ancient Horned Devil of Rune-Midgarts',
			level: 'Lv. 81 • Demon • Shadow 3 • Large',
			sprite: '<?php echo $this->themePath('img/monsters/baphomet.gif') ?>',
			spriteScale: '1.4',
			location: 'Labyrinth Forest (prt_maze03)',
			respawn: '120 Minutes',
			stats: 'HP: 668,000 • DEF: 45+82 • MDEF: 52+95',
			tactics: 'Holy element weapon (Aspersio) & high flee evasion recommended. Beware Hell\'s Judgment.',
			drops: [
				{ icon: '⭐', name: '1% Baphomet Card', desc: 'Regular attacks deal 3x3 splash damage around target' },
				{ icon: '⚔️', name: 'Crescent Scythe [1]', desc: 'ATK 180, Critical +30, Piercing spear' },
				{ icon: '👑', name: 'Magni\'s Cap', desc: 'DEF +5, STR +2, Odin\'s set piece' }
			]
		},
		{
			id: 'valkyrie',
			name: 'VALKYRIE RANDGRIS',
			title: 'The Fallen Archangel of Odin\'s Sanctum',
			level: 'Lv. 99 • Angel • Holy 4 • Large',
			sprite: '<?php echo $this->themePath('img/monsters/valkyrie.gif') ?>',
			spriteScale: '1.2',
			location: 'Odin\'s Temple (odin_tem03)',
			respawn: '480 Minutes',
			stats: 'HP: 3,550,000 • DEF: 60+110 • MDEF: 70+120',
			tactics: 'Dispel removes your buffs! Shadow/Undead element converters and high burst DPS required.',
			drops: [
				{ icon: '⭐', name: '1% Valkyrie Randgris Card', desc: 'Permanent Endure, auto-casts Dispel on attack' },
				{ icon: '🛡️', name: 'Valkyrja\'s Shield [1]', desc: '20% elemental damage reduction from Water, Fire, Dark, Undead' },
				{ icon: '⚔️', name: 'Gungnir [2]', desc: 'Wind-element spear with +25 Perfect Hit' }
			]
		},
		{
			id: 'gtb',
			name: 'GOLDEN THIEF BUG',
			title: 'The Sovereign of the Subterranean Sewers',
			level: 'Lv. 75 • Insect • Fire 2 • Medium',
			sprite: '<?php echo $this->themePath('img/monsters/gtb.gif') ?>',
			spriteScale: '2.5',
			location: 'Prontera Culverts Lv. 4 (prt_sewb4)',
			respawn: '60 Minutes',
			stats: 'HP: 430,000 • DEF: 40+60 • MDEF: 35+50',
			tactics: 'Water physical damage destroys him quickly. Keep distance during Agi Up frenzy.',
			drops: [
				{ icon: '⭐', name: '1% Golden Thief Bug Card', desc: 'Grants 100% complete immunity to all hostile magic spells' },
				{ icon: '🛡️', name: 'Golden Bell [1]', desc: 'MDEF +3, stylish gilded oriental helmet' },
				{ icon: '💎', name: 'Gold Nugget & Oridecon', desc: 'Pure crafting and refining wealth' }
			]
		},
		{
			id: 'moonlight',
			name: 'MOONLIGHT FLOWER',
			title: 'The Enchanting Nine-Tailed Fox Maiden',
			level: 'Lv. 67 • Demon • Fire 1 • Medium',
			sprite: '<?php echo $this->themePath('img/monsters/moonlight.gif') ?>',
			spriteScale: '1.6',
			location: 'Payon Caves Lv. 5 (pay_dun04)',
			respawn: '60 Minutes',
			stats: 'HP: 380,000 • DEF: 32+45 • MDEF: 48+60',
			tactics: 'Fast agility and Spiral Pierce. Use Water-element multi-hits and snare with traps.',
			drops: [
				{ icon: '⭐', name: '1% Moonlight Flower Card', desc: 'Permanent Infinite Movement Speed increase' },
				{ icon: '🪄', name: 'Moonlight Dagger [0]', desc: 'Restores SP with every physical attack' },
				{ icon: '🎀', name: 'Fox Tail [0]', desc: 'Classic aesthetic headgear collectible' }
			]
		},
		{
			id: 'ifrit',
			name: 'IFRIT',
			title: 'The Primordial God of Volcanic Ruin',
			level: 'Lv. 99 • Formless • Fire 4 • Large',
			sprite: '<?php echo $this->themePath('img/monsters/ifrit.gif') ?>',
			spriteScale: '1.25',
			location: 'Thor Volcano Lv. 3 (thor_v03)',
			respawn: '660 Minutes',
			stats: 'HP: 7,700,000 • DEF: 65+120 • MDEF: 80+140',
			tactics: 'Meteor Storm Lv 10 & Earthquake. Ghostring armor, Water weapons, and High Priest Gospel essential.',
			drops: [
				{ icon: '⭐', name: '1% Ifrit Card', desc: 'Massive scaling ATK, Critical, and HIT per job level' },
				{ icon: '💍', name: 'Ring of Resonance', desc: 'Auto-casts devastating combat spells on melee attacks' },
				{ icon: '💍', name: 'Ring of Flame Lord', desc: 'Auto-casts offensive Fire abilities on strike' }
			]
		},
		{
			id: 'angeling',
			name: 'ANGELING & DEVILING',
			title: 'The Celestial Guardians of Poring Island',
			level: 'Mini-Bosses • Angel / Demon • Holy & Shadow • Small',
			sprite: '<?php echo $this->themePath('img/monsters/angeling.gif') ?>',
			spriteScale: '1.9',
			location: 'Poring Island (pay_fild04)',
			respawn: '60 Minutes',
			stats: 'HP: 220,000 • DEF: 20+30 • MDEF: 40+50',
			tactics: 'They cast Teleport when pressured! Lock them down with lexical status and burst down fast.',
			drops: [
				{ icon: '⭐', name: '1% Angeling Card', desc: 'Enchants equipped armor with Holy element defense' },
				{ icon: '⭐', name: '1% Deviling Card', desc: 'Reduces Neutral physical damage taken by 50%' },
				{ icon: '👑', name: 'Angel Wing & Evil Wing', desc: 'Iconic aesthetic feathered headgears' }
			]
		}
	];

	function initSingleWorldBossStage() {
		var spriteImg = document.getElementById('bossSpriteImg');
		var levelPill = document.getElementById('bossLevelPill');
		var nameEl = document.getElementById('bossName');
		var titleEl = document.getElementById('bossTitle');
		var locEl = document.getElementById('bossLocation');
		var respawnEl = document.getElementById('bossRespawn');
		var dropsList = document.getElementById('bossDropsList');
		var statsEl = document.getElementById('bossCombatStats');
		var tacticsEl = document.getElementById('bossCombatIntel');
		var timerCountEl = document.getElementById('bossTimerCount');
		var progressFill = document.getElementById('bossProgressFill');
		var dots = document.querySelectorAll('.boss-dot-btn');
		var stageVisual = document.getElementById('bossStageVisual');
		var stageIntel = document.getElementById('bossStageIntel');

		if (!spriteImg || !nameEl) return;

		var currentIndex = Math.floor(Math.random() * worldBosses.length);
		var totalSeconds = 30;
		var secondsLeft = totalSeconds;

		function renderBoss(index) {
			var b = worldBosses[index];
			if (!b) return;

			// Smooth transition fade out
			if (stageVisual) stageVisual.style.opacity = '0.35';
			if (stageIntel) stageIntel.style.opacity = '0.35';

			setTimeout(function() {
				spriteImg.src = b.sprite;
				spriteImg.alt = b.name;
				spriteImg.style.transform = 'scale(' + (b.spriteScale || '1.2') + ')';
				levelPill.textContent = b.level;
				nameEl.textContent = b.name;
				titleEl.textContent = '"' + b.title + '"';
				locEl.textContent = b.location;
				respawnEl.textContent = b.respawn;
				statsEl.textContent = b.stats;
				tacticsEl.textContent = b.tactics;

				// Drops
				var dropsHtml = '';
				for (var d = 0; d < b.drops.length; d++) {
					dropsHtml += '<div class="boss-drop-item">' +
						b.drops[d].icon + ' <strong>' + b.drops[d].name + '</strong> ' +
						'<span class="drop-desc">— ' + b.drops[d].desc + '</span>' +
						'</div>';
				}
				dropsList.innerHTML = dropsHtml;

				// Update active dot
				for (var i = 0; i < dots.length; i++) {
					if (parseInt(dots[i].getAttribute('data-index'), 10) === index) {
						dots[i].classList.add('active');
					} else {
						dots[i].classList.remove('active');
					}
				}

				// Smooth fade in
				if (stageVisual) stageVisual.style.opacity = '1';
				if (stageIntel) stageIntel.style.opacity = '1';
			}, 150);
		}

		// Initial display
		renderBoss(currentIndex);

		// Allow clicking dots to switch immediately
		for (var d = 0; d < dots.length; d++) {
			dots[d].addEventListener('click', function() {
				var targetIdx = parseInt(this.getAttribute('data-index'), 10);
				if (!isNaN(targetIdx) && targetIdx !== currentIndex) {
					currentIndex = targetIdx;
					renderBoss(currentIndex);
					secondsLeft = totalSeconds;
					if (timerCountEl) timerCountEl.textContent = totalSeconds;
					if (progressFill) progressFill.style.width = '100%';
				}
			});
		}

		// 30-Second random rotator
		setInterval(function() {
			secondsLeft--;
			if (timerCountEl) timerCountEl.textContent = secondsLeft;
			if (progressFill) {
				var pct = Math.max(0, (secondsLeft / totalSeconds) * 100);
				progressFill.style.width = pct + '%';
			}

			if (secondsLeft <= 0) {
				secondsLeft = totalSeconds;
				if (timerCountEl) timerCountEl.textContent = totalSeconds;
				if (progressFill) progressFill.style.width = '100%';

				// Pick random boss that is not current
				var nextIndex;
				do {
					nextIndex = Math.floor(Math.random() * worldBosses.length);
				} while (nextIndex === currentIndex && worldBosses.length > 1);
				currentIndex = nextIndex;
				renderBoss(currentIndex);
			}
		}, 1000);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initSingleWorldBossStage);
	} else {
		initSingleWorldBossStage();
	}
})();
</script>

BOSS_EOD;

// 1. Replace Boss section first (from bottom to top so indices don't shift)
$bossStartStr = "<!-- ========================================================================\n     LEGENDARY MVP WORLD BOSS CODEX";
$bossEndStr = "<!-- ========================================================================\n     SERVER FEATURES (6 FEATURE CARDS)";

$posBossStart = strpos($content, $bossStartStr);
$posBossEnd = strpos($content, $bossEndStr);

if ($posBossStart === false || $posBossEnd === false) {
    die("Error: Could not find World Boss section positions!\n");
}

$content = substr($content, 0, $posBossStart) . $newBossSection . substr($content, $posBossEnd);
echo "World Boss section replaced successfully!\n";

// 2. Replace Hero section
$heroStartStr = "<!-- ========================================================================\n     HOMEPAGE HERO SECTION";
$heroEndStr = "<!-- ========================================================================\n     LIVE SERVER STATUS DASHBOARD";

$posHeroStart = strpos($content, $heroStartStr);
$posHeroEnd = strpos($content, $heroEndStr);

if ($posHeroStart === false || $posHeroEnd === false) {
    die("Error: Could not find Hero section positions!\n");
}

$content = substr($content, 0, $posHeroStart) . $newHeroSection . substr($content, $posHeroEnd);
echo "Hero section replaced successfully!\n";

file_put_contents('themes/freynix/main/index.php', $content);
echo "themes/freynix/main/index.php updated successfully!\n";

