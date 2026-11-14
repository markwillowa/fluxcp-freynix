# FluxCP — Multi-Theme & CMS Platform (Community Edition)

[![PHP Version](https://img.shields.io/badge/PHP-7.4%20|%208.0%20|%208.1%20|%208.2%20|%208.3-blue.svg)](https://php.net)
[![rAthena](https://img.shields.io/badge/rAthena-Pre--Renewal%20|%20Renewal-orange.svg)](https://rathena.org)
[![Themes](https://img.shields.io/badge/Themes-9%20Unique%20Layouts-brightgreen.svg)]()
[![Elysian Midgard](https://img.shields.io/badge/V9-Elysian%20Midgard%20Cinematic-C59A3F.svg)]()
[![Aetherium](https://img.shields.io/badge/V8-Aetherium%20Studio-B88A3B.svg)]()
[![Midgardian Chronicle](https://img.shields.io/badge/V7-Midgardian%20Chronicle-D9A441.svg)]()
[![Classic Adventure](https://img.shields.io/badge/V6-Classic%20Adventure-D4A64A.svg)]()
[![Arcane Nexus](https://img.shields.io/badge/V5-Arcane%20Nexus-00D9F5.svg)]()
[![Eternal Dominion](https://img.shields.io/badge/V4-Eternal%20Dominion-D4AD65.svg)]()
[![Celestial Chronicle](https://img.shields.io/badge/V3-Celestial%20Chronicle-83B9DA.svg)]()
[![Eclipse Realm](https://img.shields.io/badge/V2-Eclipse%20Realm-9D80E8.svg)]()
[![Classic](https://img.shields.io/badge/V1-Classic%20FluxCP-gray.svg)]()

A next-generation, high-performance Ragnarok Online web portal built on **Flux Control Panel (FluxCP)**. Features 9 distinct community themes: a flagship cinematic MMORPG portal (Elysian Midgard V9), a studio-grade digital home and command platform (Aetherium V8), an illustrated Pre-Renewal kingdom chronicle (Midgardian Chronicle V7), a nostalgic Pre-Renewal town portal (Classic Adventure V6), a bento cyber-magic command center (Arcane Nexus V5), dark medieval kingdom architecture (Eternal Dominion V4), light anime-fantasy aesthetics (Celestial Chronicle V3), dark gothic MMORPG portal (Eclipse Realm V2), and classic table-based administration (V1), with dynamic CMS controls, intelligent multi-tier view template fallbacks, and real-time rAthena telemetry.

---

## Table of Contents

- [Theme Gallery & Layout Styles](#theme-gallery--layout-styles)
- [Key Features & Architectural Enhancements](#key-features--architectural-enhancements)
  - [1. Elysian Midgard V9 (Flagship Cinematic MMORPG Portal)](#1-elysian-midgard-v9-flagship-cinematic-mmorpg-portal)
  - [2. Aetherium V8 (Studio-Grade Premium MMORPG Platform)](#2-aetherium-v8-studio-grade-premium-mmorpg-platform)
  - [3. Midgardian Chronicle V7 (Illustrated Midgard Adventure)](#3-midgardian-chronicle-v7-illustrated-midgard-adventure)
  - [4. Classic Adventure V6 (Pre-Renewal Town Portal)](#4-classic-adventure-v6-pre-renewal-town-portal)
  - [3. Multi-Tier View Template Fallback Architecture](#3-multi-tier-view-template-fallback-architecture)
  - [4. Transparent Logo System (Navigation & Footer)](#4-transparent-logo-system-navigation--footer)
  - [5. Intelligent Floating Navigation & Logged-In User Experience](#5-intelligent-floating-navigation--logged-in-user-experience)
  - [6. Live rAthena Telemetry & Server Command Center](#6-live-rathena-telemetry--server-command-center)
  - [7. Reusable UI Component Library & Bento Layouts](#7-reusable-ui-component-library--bento-layouts)
  - [8. White-Label Homepage CMS & 7-Theme Switcher](#8-white-label-homepage-cms--7-theme-switcher)
  - [9. Two-Step Setup Wizard with All Layout Presets](#9-two-step-setup-wizard-with-all-layout-presets)
  - [10. Complete CMS Integration (Pages, News, Downloads, Tickets)](#10-complete-cms-integration-pages-news-downloads-tickets)
- [Color Palettes & Design Tokens](#color-palettes--design-tokens)
- [Directory Structure](#directory-structure)
- [Installation & Quick Start](#installation--quick-start)
- [Administrator Guide](#administrator-guide)
- [Troubleshooting & FAQ](#troubleshooting--faq)
- [Compatibility & Requirements](#compatibility--requirements)

---

## Theme Gallery & Layout Styles

The platform includes **9 switchable themes**, each with distinct typography, layout structure, color schemes, and interactive elements:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 1. ELYSIAN MIDGARD (V9)    │ Flagship cinematic MMORPG portal, 95vh hero,   │
│                            │ living party, world atlas, character cinema.   │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 2. AETHERIUM (V8)          │ Studio-grade editorial digital platform,        │
│                            │ overlook hero, character legacy, command center.│
├────────────────────────────┼────────────────────────────────────────────────┤
│ 3. MIDGARDIAN CHRONICLE(V7)│ Illustrated Pre-Renewal kingdom chronicle,     │
│                            │ "The Road to Midgard" party, town travel atlas.│
├────────────────────────────┼────────────────────────────────────────────────┤
│ 4. CLASSIC ADVENTURE (V6)  │ Nostalgic Pre-Renewal town portal, warm oak    │
│                            │ wood, parchment notice board, Prontera skies.  │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 5. ARCANE NEXUS (V5)       │ Cyber-magic anime fantasy, floating capsule    │
│                            │ dock, bento grid, holographic telemetry.       │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 6. ETERNAL DOMINION (V4)   │ Dark medieval kingdom, royal gold & crimson,   │
│                            │ fortress citadel hero, rising ember particles. │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 7. CELESTIAL CHRONICLE (V3)│ Light anime-fantasy, skyward floating islands, │
│                            │ azure & gold filigree, ethereal atmosphere.    │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 8. ECLIPSE REALM (V2)      │ Dark gothic MMORPG, obsidian stone, mystic     │
│                            │ violet aura, compact portal sidebar.           │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 9. CLASSIC FLUXCP (V1)     │ Retro table-based layout, lightweight, zero-js  │
│                            │ legacy administrator view.                     │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## Key Features & Architectural Enhancements

### 1. Elysian Midgard V9 (Flagship Cinematic MMORPG Portal)
- **Alternating Visual Rhythm**: Continuously shifts visual atmospheres across 12 distinct sections (Bright Fantasy Sunrise &rarr; Warm Light Editorial &rarr; Deep Blue Astral Cinema &rarr; Antique Parchment Atlas &rarr; Dark Volcanic Arena &rarr; Dark Castle Embers &rarr; White Podium Rankings &rarr; Magazine News &rarr; Royal Blue Publisher Footer).
- **Cinematic 95vh Hero Overlook**: Living Transcendent party (Lord Knight vanguard with sword and shield, High Wizard with raised staff, High Priest with holy aura, Sniper, Assassin Cross, Paladin, Champion, and hopping Poring mascot) with unsynchronized breathing animations, drifting sunlight motes, and floating clouds.
- **Floating Environmental HUD**: Runic parchments integrated into the world displaying `Next War of Emperium`, `MVP Defeat Alert`, and `Guild Rank #1`.
- **Character Cinema Showcase ("Choose Your Legacy")**: Rotating runic summoning circle, full-body artwork, pixel-art accents, and interactive job switcher across 8 Transcendent classes.
- **Interactive World Atlas (11 Locations)**: Prontera, Payon, Geffen, Morroc, Alberta, Izlude, Aldebaran, Comodo, Lutie, Glast Heim, and Clock Tower with glowing map pins, coordinates, and smooth lore card transitions.
- **Midgard Live Command Center**: Animated counter count-ups for active players, server uptime (99.98%), experience rates, and a live dispatch activity feed.
- **The Hunt Begins (MVP Showcase)**: Dark ruins arena with real-time hunt status badges, respawn countdowns, monster avatars, and rare drop cards.
- **The Dungeon Journey**: 5-stage horizontal progression road detailing leveling tiers, danger ratings, and dungeon bosses.
- **Castle War (War of Emperium)**: Dramatic castle siege atmosphere with flying embers, siege window schedules, and reigning guild spotlight.
- **Legends of Midgard (Podium Leaderboard)**: Olympic-style `#2`, `#1`, `#3` podium presentation for top heroes and guilds.
- **Personalized Player Dashboard**: Dynamic greeting (`WELCOME BACK, ADVENTURER`) displaying the logged-in player's character name, class, level, zeny, and PvP standing.
- **Staff Controls with Scroll Container**: Dedicated scrollable management list (`max-height: 200px; overflow-y: auto`) for Homepage CMS, Announcements, Codex, Navigation, and Downloads.
- **Custom Desktop Cursor & Gold Scrollbar**: Subtle golden tracking dot and expanding hover ring + gold-gradient scrollbar.
- **Zero Stray Mobile Elements**: Strict media query separation ensuring no mobile toggle buttons leak onto desktop viewports.
- **100% White-Label & Community-Ready**: Free of hardcoded server names; completely driven by `config/theme.php` and Flux CMS.

### 2. Aetherium V8 (Studio-Grade Premium MMORPG Platform)
- **Professional Game Studio Aesthetic:** Built with a sophisticated neutral foundation—cream (`#F7F7F5`), pure white (`#FFFFFF`), deep charcoal (`#151515`), and luxurious muted gold (`#B88A3B` / `#D6B56C`). Features generous editorial whitespace, refined borders, and subtle elevation shadows instead of dark gradients or generic box clutter.
- **Editorial Typography Pairing:** Classic serif headlines (`Cormorant Garamond` / `Cinzel`) paired with crisp, highly readable modern sans-serif body typography (`Inter` / `Manrope`).
- **Cinematic Overlook Panoramic Hero ("ENTER A WORLD WORTH RETURNING TO"):**
  - **Floating Editorial Typography:** Headlines and narrative copy float directly above the panoramic overlook with multi-layered diffused drop shadows—zero opaque card boxes or restrictive panels obscuring the fantasy vista.
  - **Live Realm Status Pill:** Integrated at the top of the hero copy displaying real-time server connectivity, online adventurer counts, Pre-Renewal mode badge, and level caps.
  - **Dominant Transcendent Overlook Vanguard:** A towering Transcendent Lord Knight positioned majestically on the stone overlook facing the open kingdom, animated with gentle idle breathing (`@keyframes aeLeaderBreathe`), transcendent golden level-up radiance, and atmospheric drifting dust particles.
  - **Studio Action Directives:** High-contrast primary CTA button (`BEGIN YOUR ODYSSEY`) alongside secondary discovery link (`EXPLORE THE REALM`).
- **Interactive Character Legacy Showcase ("CHOOSE YOUR LEGACY"):**
  - Horizontal studio class selector allowing instant inspection of classic Transcendent jobs: Lord Knight, High Wizard, High Priest, Sniper, Assassin Cross, Paladin, Champion, and Whitesmith.
  - Dynamic client-side lore cards updating archetype role, title, epithet, character quote, gameplay bio, and animated sprites in real time.
- **Server Command Center ("THE WORLD, LIVE"):** Real-time server telemetry counters (active adventurers, base/job exp rates, drop rates, WoE status) paired with a live player activity feed tracking recent logins and achievements.
- **Sequential Storytelling ("YOUR ADVENTURE. YOUR PATH"):** Curated milestone roadmaps from Novice origins (01) to Transcendent mastery (05).
- **Interactive World Atlas ("DISCOVER MIDGARD"):** Visual region cards for Prontera, Payon, Geffen, Morroc, Alberta, and Glast Heim with level recommendations and lore summaries.
- **War of Emperium Citadel ("THE WAR NEVER ENDS"):** Castle ownership status, siege schedule countdowns, and top guild honorifics.
- **Adventurer Support & Supply Depot:** Comprehensive client downloads with mirror links, system requirements matrix, and a 3-step setup guide.
- **Comprehensive Staff Controls:** Built into both desktop user pill dropdown and mobile slide drawer for administrators (`group_level >= 20`).

### 2. Midgardian Chronicle V7 (Illustrated Midgard Adventure)
- **Illustrated Storybook Midgard Aesthetic:** Warm parchment (`#F5E8C8`), ivory (`#FFF9E8`), warm sky blue (`#83C7ED`), soft meadow green (`#9BCB78`), medieval brown (`#704A2E`), and warm gold (`#D9A441`). Handcrafted borders and parchment cards.
- **"The Road to Midgard" Panoramic Hero Scene:**
  - **45% Atmospheric Text / 55% Living Character Party Grid:** Floating typography with clean drop shadows and subtle frosted backing that never obstructs the panoramic rolling hills, town silhouette, or castle spires.
  - **Dominant Frontline Vanguard:** Lord Knight stands front and center, scaled 35–40% taller than the rest of the adventuring party, equipped with a transcendent level 99 golden halo, gentle idle breathing (`@keyframes mcLeaderBreathe`), and soft cobblestone shadow.
  - **Full Transcendent Party Formation:** Accompanied by High Wizard (arcane float), High Priest (holy devotion float), Sniper (scout sway), Assassin Cross (shadow crouch), Paladin (grand cross guard), Champion (asura guard), and a hopping Poring mascot near wooden supply crates.
  - **Floating Sunlight Motes & Level-Up Radiance:** Ground golden radiance, rotating level-up runes ring, and drifting sunlight particles.
- **Horizontal Adventurer's Status Board:** Positioned directly below the hero banner, featuring real-time realm status, live active adventurers in Midgard, experience rates, and level cap indicators.
- **Kingdom Town Travel Atlas:** Interactive district travel cards for Prontera, Payon, Geffen, Morroc, Alberta, and Izlude.
- **The Latest Chronicles (Town Gazette):** Proclamations and merchant trade bulletins styled like royal notices with category badges.
- **Heroes of Midgard Bento:** Live rankings with gold, silver, and bronze medallions for top characters and famed guilds.
- **Modular Party Registry (`config/theme.php`):** Server owners can freely swap, scale, or configure character sprites without modifying template HTML.

### 3. Classic Adventure V6 (Pre-Renewal Town Portal)
- **Classic Nostalgic Visual Language:** Recreates the bright, cheerful, welcoming atmosphere of early Ragnarok Online (Prontera streets, training grounds, tavern notice boards, and classic item shops). Avoids dark, cyber, or esports aesthetics.
- **Top Adventurer Information Bar:** Live server status indicator with active player counts, experience rates (`1000x BASE EXP • 1000x JOB EXP • PRE-RENEWAL`), Discord/Facebook outposts, and quick authentication.
- **Warm Oak Wood & Parchment Navigation:** Polished wood grain navbar, transparent guild crest emblem (`adventure-logo.png`), dynamic navigation links from `cp_navigation`, and an account pill with credit balance.
- **Sunny Prontera Adventure Hero:** Vibrant sunny landscape with blue sky, fluffy white clouds, green rolling hills, cobblestone guideposts, and a distant white clocktower. Headline: *"YOUR CLASSIC ADVENTURE BEGINS HERE"*.
- **Living Transcendent Adventurer Party Showcase (Left Stage):** An open fantasy scene integrated directly on the left side of the sunny Prontera landscape without boxed UI panels or job-selector buttons, facing the right-side adventure quest scroll:
  - **Dominant Main Feature Hero:** A commanding Lord Knight standing tall in the center (35–40% taller than supporting characters) with a golden transcendent aura halo and gentle breathing idle animation (`@keyframes advMainHeroBreathe`).
  - **Organic Adventuring Party Formation:** Surrounded asymmetrically by classic Pre-Renewal Transcendent comrades: High Wizard (channeling magic, back-left), Sniper (scouting vanguard, back-right), Paladin (holy defender, mid-left), High Priest (healer with blessing emotion, mid-right), Assassin Cross (stealth assault, front-left), and Champion (martial fists ready, front-right).
  - **Atmospheric Environment & Particle Effects:** Ground golden radiance, rotating level-up aura ring, floating sunbeam dust particles, and a playful hopping Poring mascot in the foreground grass.
  - **Subtle Idle Animations:** Unsynchronized breathing, casting, and stance movements across the party with classic Ragnarok emotion bubbles (`★ 99`, `❤`, `!`).
- **Adventurer Notice Board:** Authentic bulletin board with wooden trim, cork background, and pinned parchment cards powered by the FluxCP News module (`?module=news`).
- **Town Bento Grid:** Reusable content outposts representing *The Adventurer's Guild*, *Kafra Item Shop*, *Training Grounds*, *Battle Arena*, *Adventurer Tavern*, and *Hall of Fame*.
- **Pre-Renewal Class Showcase:** Interactive showcase for Swordsman, Archer, Mage, Acolyte, Merchant, Thief, Monk, and Crusader with original classic sprites.
- **Supply Depot (Downloads):** Classic game client download center supporting Full Client, Lite Patcher, Manual Patches, and an interactive 3-minute setup guide.

### 4. Multi-Tier View Template Fallback Architecture
- **Automatic Template Resolution:** Built directly into `lib/Flux/Template.php`, FluxCP resolves views across a 5-tier inheritance hierarchy:
  1. `themes/<current_theme>/<module>/<action>.php`
  2. `themes/<parent_theme>/<module>/<action>.php`
  3. `addons/<addon>/themes/<theme>/<module>/<action>.php`
  4. Configured themes in `ThemeName` array
  5. Ultimate terminal fallback: `themes/default/<module>/<action>.php`
- **Zero Missing View Notices:** Resolves PHP notices such as `Notice: The requested view template (ranking/death) is not found in the current theme` by safely casting `Flux_Config` objects to arrays and guaranteeing fallback to `default` views whenever a custom theme chooses not to override a specific secondary module.
- **Native Custom Ranking Templates:** Dedicated, beautifully styled ranking templates for `character`, `guild`, `zeny`, `death`, `alchemist`, `blacksmith`, `homunculus`, and `mvp`.

### 5. Transparent Logo System (Navigation & Footer)
- **True 32-Bit Alpha Channels:** Every theme includes an optimized 32-bit transparent PNG logo (`aetherium-logo.png`, `adventure-logo.png`, `nexus-logo.png`, `dominion-logo.png`, `celestial-logo.png`, `logo.png`) with zero solid or black background boxes.
- **Dual Placement Parity:** All themes display the brand emblem in both the **Top Navigation Bar / Floating Dock** and the **Global Footer** (as well as mobile slide drawers).
- **Guaranteed CMS Fallback:** The CMS engine (`lib/Flux/CMS.php`) and theme templates guard against empty or whitespace database values (`trim((string)$customLogo)`). If an administrator leaves the custom logo URL blank, templates automatically and safely fall back to the built-in theme logo asset, completely preventing broken `<img src="" alt="...">` tags.
- **Ambient Glows:** Applied via CSS `filter: drop-shadow(...)` to create natural lighting integration matching each theme's primary accent color.

### 6. Intelligent Floating Navigation & Logged-In User Experience
- **Floating Glassmorphic & Wooden Docks:** Modern navigation suspended above hero art with smooth scroll backdrop blurs or warm polished oak textures.
- **Logged-In Account Hub:**
  - Displays user avatar initial, username, and active account ID.
  - Dropdown shortcuts for **Player Dashboard**, **Change Password**, **Change E-mail**, **Support Tickets**, and **Login History**.
  - **1-Click Logout Action:** Clean, red-accented exit link directly within user dropdowns.
- **Integrated Staff Panel Dropdown:**
  - Automatically revealed for users with administrative privileges (`group_level >= AdminMenuGroupLevel`).
  - Instant access to **Homepage CMS**, **Manage Announcements**, **Manage Codex Pages**, **Manage Navigation**, **Manage Downloads**, **Service Desk Tickets**, and **Flux Core Administration**.
- **Off-Canvas Mobile Drawer (`<= 1080px`):** Smooth slide-out touch drawer containing complete navigation hierarchies, server monitors, account actions, and mobile logo headers.

### 7. Live rAthena Telemetry & Server Command Center
- **Real-Time Data (Never Invented):**
  - Online player counts retrieved directly from `char.online > 0`.
  - Base and Job level caps retrieved from server configuration.
  - Base and Job EXP rates and drop rates retrieved from active Athena server settings.
  - Server Mode (Pre-Renewal / Renewal) and PvP availability.
  - War of Emperium castle ownership and schedule countdowns.
- **Live Status Beacons:** Animated pulsing status indicators displaying `ONLINE` or `MAINTENANCE` states.

### 8. Reusable UI Component Library & Bento Layouts
- **Bento-Style Modular Grids:** Asymmetric card layouts (Hero, Holo-Dispatches, Client Launcher, Apex Rankings, Operative Portal, Transmission Network).
- **Unified UI Component Set:**
  - Buttons (`btn-ae-gold`, `btn-adv-gold`, `btn-adv-green`, `btn-adv-wood`, `btn-nexus-cyan`, `btn-dominion-crimson`).
  - Glassmorphic panels with subtle glowing borders.
  - Responsive, touch-scrollable data tables for rankings and item shops.
  - Flash message notification banners (Success, Danger, Notice).
  - Modal confirmation dialogs for critical actions.

### 9. White-Label Homepage CMS & 8-Theme Switcher
Accessible at `?module=homepage` for administrators:
- **8-Theme Switcher Cards:** Select between **Aetherium (V8)**, **Midgardian Chronicle (V7)**, **Classic Adventure (V6)**, **Arcane Nexus (V5)**, **Eternal Dominion (V4)**, **Celestial Chronicle (V3)**, **Eclipse Realm (V2)**, or **Classic FluxCP (V1)** with instant live preview.
- **Server Identity:** Update server brand name, slogan, logo URL, and footer disclaimer in real time.
- **Section Visibility Toggles:** Toggle Hero, Live Stats Strip, News Grid, Rankings, Download Widget, or Discord callout.
- **Feature Cards Editor:** Customize 6 modular cards with custom headlines, icons, descriptions, and destination links.
- **Social Gateways:** Set Discord invite URLs and community links.

### 10. Two-Step Setup Wizard with All Layout Presets
Accessible at `?module=install`:
- **Step 1: System Requirements & DB Sync:**
  - Validates PHP 7.4 - 8.3+, required extensions (`curl`, `gd`, `pdo`, `pdo_mysql`, `mysqli`, `mbstring`, `xml`, `openssl`).
  - Tests database connection and detects rAthena `login` table.
  - Creates the `login` table schema with a single click if missing.
  - Executes migrations and records schema tracking logs without deleting them on submit.
  - Reversible and safe: does not wipe existing character or account data.
- **Step 2: Server & Theme Setup (`?module=install&step=2`):**
  - **All Available Layout Presets Listed:** Visually displays cards for Classic Adventure V6, Arcane Nexus V5, Eternal Dominion V4, Celestial Chronicle V3, Eclipse Realm V2, and Classic FluxCP V1.
  - Configure Server Identity, Rates, Level Caps, Download Mirrors, and Community Links before launch.
  - Submitting configuration binds settings and transitions seamlessly to the live website without redirect loops.

### 8. Complete CMS Integration (Pages, News, Downloads, Tickets)
- **Automatic Template Inheritance & Fallback Engine:** Solved missing view notices (`ranking/death`, `ranking/alchemist`, `ranking/blacksmith`, `ranking/zeny`, `ranking/mvp`, etc.). If a custom theme does not define a specific action template, `Flux_Template` safely evaluates configured themes and gracefully falls back to `themes/default/` without throwing missing view notices or broken layouts.
- **Pages Module (`?module=pages`):** Custom CMS pages (Rules, FAQ, Guides, Donation info) rendered within the active theme layout.
- **News Module (`?module=news`):** Rich announcements with HTML support, category badges, author tags, and pagination.
- **Downloads Module (`?module=downloads`):** Multi-mirror distribution supporting Full Client, Lite Client, and patches.
- **Service Desk (`?module=servicedesk`):** Full player ticketing system with status tags, category controls, and staff responses.

---

## Color Palettes & Design Tokens

### Aetherium (V8)
| Token | Hex / Value | Description |
|:---|:---|:---|
| Neutral Cream | `#F7F7F5` | Sophisticated studio canvas foundation |
| Pure White | `#FFFFFF` | Editorial card surfaces, modals & containers |
| Deep Charcoal | `#151515` | High-contrast editorial typography & borders |
| Muted Grey | `#737373` | Subtitles, meta telemetry & secondary text |
| Studio Gold | `#B88A3B` | Primary luxury accent, buttons, badges & active tabs |
| Soft Champagne | `#D6B56C` | Secondary gold accent, subtle hover glows |
| Deep Slate | `#263238` | Dark contrast elements & telemetry cards |

### Midgardian Chronicle (V7)
| Token | Hex / Value | Description |
|:---|:---|:---|
| Parchment | `#F5E8C8` | Handcrafted storybook panels & scrolls |
| Ivory Canvas | `#FFF9E8` | Primary warm content surfaces |
| Sky Blue | `#83C7ED` | Sunny horizon & atmospheric gradients |
| Soft Grass Green | `#9BCB78` | Meadow paths & registration buttons |
| Medieval Brown | `#704A2E` | Handcrafted frames & high-contrast titles |
| Warm Gold | `#D9A441` | Transcendent auras, medals & primary CTA |

### Classic Adventure (V6)
| Token | Hex / Value | Description |
|:---|:---|:---|
| Sky Blue | `#DDF2FF` | Sunny cloud-filled skies & radial glows |
| Soft Blue | `#A9D7F2` | Accent header gradients & telemetry pills |
| Classic Blue | `#4F86B8` | Primary links & portal action tags |
| Parchment | `#FFF8E7` | Bulletin boards, notices & document surfaces |
| Warm Cream | `#F5E7C5` | Table headers, badges & card borders |
| Wood Brown | `#8B6242` | Polished oak frames & navbar accents |
| Dark Brown | `#4B3528` | Primary high-contrast typography |
| Classic Gold | `#D4A64A` | Guild medals, rank badges & primary CTA |
| Grass Green | `#8DBB72` | Field grass & registration action buttons |
| Soft Red | `#C96B62` | Bulletin notice pins & offline indicators |

### Arcane Nexus (V5)
| Token | Hex / Value | Description |
|:---|:---|:---|
| Void Black | `#070B18` | Primary background canvas |
| Deep Navy | `#111C33` | Glass card surfaces & panels |
| Neon Cyan | `#00D9F5` | Primary cyber accent, illuminated buttons & glows |
| Arcane Violet | `#9461FF` | Secondary magic accent, badge highlights |
| Electric Blue | `#367BFF` | Gradient transitions & telemetry indicators |
| Frost White | `#F4F7FF` | High-contrast readable typography |
| Muted Text | `#9BAAC6` | Secondary labels & telemetry descriptors |
| Glass Border | `rgba(130, 180, 255, 0.18)` | Subtle translucent cyber borders |

### Eternal Dominion (V4)
| Token | Hex / Value | Description |
|:---|:---|:---|
| Obsidian Stone | `#0C0B0F` / `#17141B` | Deep medieval dark fantasy canvas |
| Royal Crimson | `#9E2633` | Primary action buttons & War Room badges |
| Antique Gold | `#D4AD65` | Crest accents, active borders, rank badges |
| Bone White | `#EDE6D6` | Primary fantasy typography |
| Muted Stone | `#8F8A94` | Secondary text & lore descriptions |

### Celestial Chronicle (V3)
| Token | Hex / Value | Description |
|:---|:---|:---|
| Ivory Sky | `#F8F5EC` | Light fantasy backdrop |
| Sky Blue | `#DCEFFA` | Floating panel surfaces |
| Azure Blue | `#83B9DA` | Primary sky accent & action buttons |
| Royal Gold | `#C9A45E` | Filigree borders & rank badges |
| Deep Navy | `#283B59` | High-contrast text & branding |

---

## Directory Structure

```text
htdocs/fluxcp-freynix/
├── config/
│   ├── application.php          # Core configuration & theme arrays
│   ├── servers.php              # Athena cluster & MySQL credentials
│   └── access.php               # Module permissions & group levels
├── lib/
│   ├── Flux/
│   │   ├── CMS.php              # Dynamic CMS repository with safe fallbacks
│   │   ├── SessionData.php      # Session management & user data
│   │   └── Template.php         # Theme rendering engine
│   └── Flux.php                 # Core framework bootstrap
├── modules/
│   ├── homepage/                # Homepage CMS & 8-Theme Switcher
│   ├── install/                 # Two-Step setup & Re-Install wizard
│   ├── news/                    # Announcement manager & reader
│   ├── pages/                   # Codex document manager
│   ├── downloads/               # Client package manager
│   ├── servicedesk/             # ITIL support ticket system
│   └── ranking/                 # Character, Guild, and MVP ladders
└── themes/
    ├── aetherium/               # Aetherium (Theme V8 - Studio Platform)
    │   ├── config/theme.php     # Character legacy & world atlas registry
    │   ├── css/aetherium.css    # Editorial studio design system
    │   ├── css/hero.css         # Panoramic overlook hero & floating copy
    │   ├── img/aetherium-logo.png# Transparent 32-bit studio logo
    │   ├── img/hero/aetherium-overlook.jpg # Panoramic overlook artwork
    │   ├── main/index.php       # Complete 10-section homepage
    │   ├── main/navbar.php      # Minimal studio header & user pill
    │   └── footer.php           # Studio footer & off-canvas drawer
    ├── chronicle/               # Midgardian Chronicle (Theme V7)
    │   ├── config/theme.php     # Character party & town atlas registry
    │   ├── css/chronicle.css    # Parchment & ivory kingdom design system
    │   ├── css/hero.css         # "The Road to Midgard" living party scene
    │   ├── img/chronicle-logo.png # Transparent 32-bit PNG title emblem
    │   ├── img/chronicle-seal.png # Transparent 32-bit PNG guild seal
    │   ├── img/hero/road-to-midgard.jpg # Panoramic adventure scene
    │   ├── main/navbar.php      # Kingdom topbar & seal header
    │   └── footer.php           # Kingdom footer & community links
    ├── adventure/               # Classic Adventure (Theme V6)
    │   ├── css/adventure.css    # Classic Pre-Renewal design system
    │   ├── img/adventure-logo.png# Transparent 32-bit PNG guild crest
    │   ├── img/adventure-hero-bg.jpg# Prontera sunny adventure scene
    │   ├── main/navbar.php      # Top adventurer bar & wood nav
    │   ├── footer.php           # Wood/parchment footer & mobile drawer
    │   └── README.md            # Theme documentation
    ├── nexus/                   # Arcane Nexus (Theme V5)
    │   ├── css/nexus.css        # Cyber-magic design system
    │   ├── img/nexus-logo.png   # Transparent 32-bit PNG logo
    │   ├── main/navbar.php      # Floating dock & user pill
    │   └── footer.php           # Command center footer & mobile drawer
    ├── dominion/                # Eternal Dominion (Theme V4)
    │   ├── css/dominion.css     # Medieval fantasy design system
    │   ├── img/dominion-logo.png# Transparent 32-bit PNG crest
    │   └── main/navbar.php      # Two-tier royal navigation
    ├── celestial/               # Celestial Chronicle (Theme V3)
    │   ├── css/celestial.css    # Light fantasy design system
    │   └── img/celestial-logo.png# Transparent 32-bit PNG logo
    ├── freynix/                 # Eclipse Realm (Theme V2)
    │   ├── css/freynix.css      # Dark MMORPG design system
    │   └── img/logo.png         # Transparent 32-bit PNG logo
    ├── default/                 # Classic FluxCP (Theme V1)
    │   └── img/logo.png         # Clean crest logo
    └── installer/               # Installation Wizard Theme
        └── install/index.php    # Two-step setup wizard layout
```

---

## Installation & Quick Start

### 1. Requirements Check
- Web server: **Apache 2.4+** or **Nginx 1.18+** with PHP 7.4 to 8.3+.
- PHP Extensions: `curl`, `gd`, `pdo`, `pdo_mysql`, `mysqli`, `mbstring`, `xml`, `openssl`.
- MySQL 5.7+ or MariaDB 10.3+.

### 2. Deployment
1. Clone or extract this repository into your web directory (e.g. `c:/xampp/htdocs/fluxcp-freynix` or `/var/www/html/fluxcp`).
2. Ensure write permissions on `data/`, `data/logs/`, `data/itemshop/`, and `data/tmp/`.
3. Open your browser and navigate to:
   ```
   http://localhost/fluxcp-freynix/
   ```
4. You will be greeted by the **Installation & Configuration Manager**.

### 3. Running the Setup Wizard
- **Step 1 (System Requirements & DB Sync):**
  - Verify all extension checks and write permissions pass.
  - Review database connection status. If the rAthena `login` table is missing, click **"Create Standard rAthena Login Table"**.
  - Review database schema migrations.
  - Click **"Continue to Server & Theme Setup &rarr;"**.
- **Step 2 (Server & Theme Setup):**
  - Select your preferred layout from the 7 visual cards (**Midgardian Chronicle**, **Classic Adventure**, **Arcane Nexus**, **Eternal Dominion**, **Celestial Chronicle**, **Eclipse Realm**, or **Classic FluxCP**).
  - Enter your **Server Name**, **Slogan**, **EXP / Drop Rates**, **Level Caps**, and **Client Download Mirrors**.
  - Click **"Save Configuration & Launch Website"**.
  - The wizard finalizes setup and redirects directly to your live, fully-styled MMORPG portal.

---

## Administrator Guide

### Changing Themes Live
1. Log in with an administrator account (`group_level >= 20` or configured `AdminMenuGroupLevel`).
2. In the navigation bar, click the user pill and select **Staff Panel &rarr; Homepage & Theme CMS** (`?module=homepage`).
3. Under **Theme & Layout Selection**, select your preferred layout card:
   - **Midgardian Chronicle (V7)**
   - **Classic Adventure (V6)**
   - **Arcane Nexus (V5)**
   - **Eternal Dominion (V4)**
   - **Celestial Chronicle (V3)**
   - **Eclipse Realm (V2)**
   - **Classic FluxCP (V1)**
4. Click **"Save Homepage Settings"**. The theme updates instantly across all pages and sessions.

### Updating Server Logos & Branding
1. In **Homepage CMS** (`?module=homepage`), locate **1. Server Brand & Identity**.
2. **Logo URL:** Enter the web path or URL to your custom logo (e.g. `/themes/adventure/img/adventure-logo.png`).
   > **Note:** If left empty, themes automatically fall back to their built-in high-resolution transparent logo.
3. Update your **Server Name**, **Header Slogan**, and **Footer Disclaimer**.
4. Click **"Save Homepage Settings"**.

### Managing Navigation Links
1. Open **Staff Panel &rarr; Manage Navigation** (`?module=navigation`).
2. Add, edit, or reorder top-level links and nested dropdowns for both the **Main Navigation Dock** and the **Footer Columns**.

### Re-installing or Resetting
1. Navigate to `?module=install&action=reinstall` (or via the staff dropdown).
2. Choose whether to reset schema tracking logs or restore default CMS settings, then confirm to re-enter the setup wizard.

---

## Troubleshooting & FAQ

#### Q: Why is my logo showing a broken image or alt text?
**A:** This occurred when `site_logo_url` in the database was saved as an empty string `""`. In this updated version, `Flux_CMS::get()` and all theme templates explicitly check `!empty(trim((string)$customLogo))`. If empty, all templates automatically fall back to their built-in 32-bit transparent theme logo. Ensure your custom logo URL is either a valid accessible path or left completely blank to use the default theme logo.

#### Q: The installer kept looping back to Step 1. Is this resolved?
**A:** Yes. The previous installer logic had an unlinking loop that deleted schema tracking `.txt` files upon submission, causing FluxCP to believe tables were still missing. That loop has been removed, and the wizard cleanly saves configuration and directs you straight to the live website.

#### Q: Can I use my own custom logo without modifying theme templates?
**A:** Yes. All logos are rendered with `background: transparent; object-fit: contain;` and drop shadows. Upload your PNG into `themes/<theme-name>/img/` or enter any valid relative or absolute URL in the Homepage CMS.

#### Q: How do I access staff controls?
**A:** Log into any account with `group_level >= 20` (or the level configured in `config/application.php` under `AdminMenuGroupLevel`). A dedicated **Staff Panel** dropdown will appear in the top utility bar and in the user profile pill.

---

## Compatibility & Requirements

- **PHP Compatibility:** PHP 7.4.x, PHP 8.0.x, PHP 8.1.x, PHP 8.2.x, PHP 8.3.x.
- **Database Support:** MySQL 5.7+, MySQL 8.0+, MariaDB 10.3+.
- **Emulators Supported:** rAthena (Pre-Renewal & Renewal), Hercules, eAthena.
- **FluxCP Core:** Tested against standard FluxCP 1.0+ and 2.0+ rAthena branches.
- **Browsers:** Modern desktop and mobile browsers (Chrome, Firefox, Safari, Edge, Opera).
