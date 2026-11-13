# FluxCP — Multi-Theme & CMS Platform (Community Edition)

[![PHP Version](https://img.shields.io/badge/PHP-7.4%20|%208.0%20|%208.1%20|%208.2%20|%208.3-blue.svg)](https://php.net)
[![rAthena](https://img.shields.io/badge/rAthena-Pre--Renewal%20|%20Renewal-orange.svg)](https://rathena.org)
[![Themes](https://img.shields.io/badge/Themes-5%20Unique%20Layouts-brightgreen.svg)]()
[![Arcane Nexus](https://img.shields.io/badge/V5-Arcane%20Nexus-00D9F5.svg)]()
[![Eternal Dominion](https://img.shields.io/badge/V4-Eternal%20Dominion-D4AD65.svg)]()
[![Celestial Chronicle](https://img.shields.io/badge/V3-Celestial%20Chronicle-83B9DA.svg)]()
[![Eclipse Realm](https://img.shields.io/badge/V2-Eclipse%20Realm-9D80E8.svg)]()
[![Classic](https://img.shields.io/badge/V1-Classic%20FluxCP-gray.svg)]()

A next-generation, high-performance Ragnarok Online web portal built on **Flux Control Panel (FluxCP)**. Features 5 distinct community themes, a bento-style cyber-magic layout (Arcane Nexus), dark medieval kingdom architecture (Eternal Dominion), light anime-fantasy aesthetics (Celestial Chronicle), dark gothic MMORPG portal (Eclipse Realm), a neutral two-step installation wizard, transparent vector logos, guaranteed fallbacks, dynamic CMS controls, and real-time rAthena telemetry.

---

## Table of Contents

- [Theme Gallery & Layout Styles](#theme-gallery--layout-styles)
- [Key Features & Architectural Enhancements](#key-features--architectural-enhancements)
  - [1. Transparent Logo System (Navigation & Footer)](#1-transparent-logo-system-navigation--footer)
  - [2. Intelligent Floating Navigation & Logged-In User Experience](#2-intelligent-floating-navigation--logged-in-user-experience)
  - [3. Live rAthena Telemetry & Server Command Center](#3-live-rathena-telemetry--server-command-center)
  - [4. Reusable UI Component Library & Bento Layouts](#4-reusable-ui-component-library--bento-layouts)
  - [5. White-Label Homepage CMS & 5-Theme Switcher](#5-white-label-homepage-cms--5-theme-switcher)
  - [6. Two-Step Setup Wizard with All Layout Presets](#6-two-step-setup-wizard-with-all-layout-presets)
  - [7. Complete CMS Integration (Pages, News, Downloads, Tickets)](#7-complete-cms-integration-pages-news-downloads-tickets)
- [Color Palettes & Design Tokens](#color-palettes--design-tokens)
- [Directory Structure](#directory-structure)
- [Installation & Quick Start](#installation--quick-start)
- [Administrator Guide](#administrator-guide)
- [Troubleshooting & FAQ](#troubleshooting--faq)
- [Compatibility & Requirements](#compatibility--requirements)

---

## Theme Gallery & Layout Styles

The platform includes **5 switchable themes**, each with distinct typography, layout structure, color schemes, and interactive elements:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 1. ARCANE NEXUS (V5)       │ Cyber-magic anime fantasy, floating capsule    │
│                            │ dock, bento grid, holographic telemetry.       │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 2. ETERNAL DOMINION (V4)   │ Dark medieval kingdom, royal gold & crimson,   │
│                            │ fortress citadel hero, rising ember particles. │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 3. CELESTIAL CHRONICLE (V3)│ Light anime-fantasy, skyward floating islands, │
│                            │ azure & gold filigree, ethereal atmosphere.    │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 4. ECLIPSE REALM (V2)      │ Dark gothic MMORPG, obsidian stone, mystic     │
│                            │ violet aura, compact portal sidebar.           │
├────────────────────────────┼────────────────────────────────────────────────┤
│ 5. CLASSIC FLUXCP (V1)     │ Retro table-based layout, lightweight, zero-js  │
│                            │ legacy administrator view.                     │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## Key Features & Architectural Enhancements

### 1. Transparent Logo System (Navigation & Footer)
- **True 32-Bit Alpha Channels:** Every theme includes an optimized 32-bit transparent PNG logo (`nexus-logo.png`, `dominion-logo.png`, `celestial-logo.png`, `logo.png`) with zero solid or black background boxes.
- **Dual Placement Parity:** All themes display the brand emblem in both the **Top Navigation Bar / Floating Dock** and the **Global Footer** (as well as mobile slide drawers).
- **Guaranteed CMS Fallback:** The CMS engine (`lib/Flux/CMS.php`) and theme templates guard against empty or whitespace database values (`trim((string)$customLogo)`). If an administrator leaves the custom logo URL blank, templates automatically and safely fall back to the built-in theme logo asset, completely preventing broken `<img src="" alt="...">` tags.
- **Ambient Glows:** Applied via CSS `filter: drop-shadow(...)` to create natural lighting integration matching each theme's primary accent color.

### 2. Intelligent Floating Navigation & Logged-In User Experience
- **Floating Glassmorphic Docks:** Modern capsule navbar suspended above hero art with smooth scroll backdrop blurs (`backdrop-filter: blur(14px)`).
- **Logged-In Account Hub:**
  - Displays user avatar initial, username, and active account ID.
  - Dropdown shortcuts for **Player Dashboard**, **Change Password**, **Change E-mail**, **Support Tickets**, and **Login History**.
  - **1-Click Logout Action:** Clean, red-accented exit link directly within user dropdowns.
- **Integrated Staff Panel Dropdown:**
  - Automatically revealed for users with administrative privileges (`group_level >= AdminMenuGroupLevel`).
  - Instant access to **Homepage CMS**, **Manage Announcements**, **Manage Codex Pages**, **Manage Navigation**, **Manage Downloads**, **Service Desk Tickets**, and **Flux Core Administration**.
- **Off-Canvas Mobile Drawer (`<= 1080px`):** Smooth slide-out touch drawer containing complete navigation hierarchies, server monitors, account actions, and mobile logo headers.

### 3. Live rAthena Telemetry & Server Command Center
- **Real-Time Data (Never Invented):**
  - Online player counts retrieved directly from `char.online > 0`.
  - Base and Job level caps retrieved from server configuration.
  - Base and Job EXP rates and drop rates retrieved from active Athena server settings.
  - Server Mode (Pre-Renewal / Renewal) and PvP availability.
  - War of Emperium castle ownership and schedule countdowns.
- **Live Status Beacons:** Animated pulsing status indicators displaying `ONLINE` or `MAINTENANCE` states.

### 4. Reusable UI Component Library & Bento Layouts
- **Bento-Style Modular Grids:** Asymmetric card layouts (Hero, Holo-Dispatches, Client Launcher, Apex Rankings, Operative Portal, Transmission Network).
- **Unified UI Component Set:**
  - Buttons (`btn-nexus-cyan`, `btn-nexus-glass`, `btn-dominion-crimson`, `btn-celestial-azure`).
  - Glassmorphic panels with subtle glowing borders.
  - Responsive, touch-scrollable data tables for rankings and item shops.
  - Flash message notification banners (Success, Danger, Notice).
  - Modal confirmation dialogs for critical actions.

### 5. White-Label Homepage CMS & 5-Theme Switcher
Accessible at `?module=homepage` for administrators:
- **5-Theme Switcher Cards:** Select between Arcane Nexus, Eternal Dominion, Celestial Chronicle, Eclipse Realm, or Classic FluxCP with instant live preview.
- **Server Identity:** Update server brand name, slogan, logo URL, and footer disclaimer in real time.
- **Section Visibility Toggles:** Toggle Hero, Live Stats Strip, News Grid, Rankings, Download Widget, or Discord callout.
- **Feature Cards Editor:** Customize 6 modular cards with custom headlines, icons, descriptions, and destination links.
- **Social Gateways:** Set Discord invite URLs and community links.

### 6. Two-Step Setup Wizard with All Layout Presets
Accessible at `?module=install`:
- **Step 1: System Requirements & Database Sync:**
  - Validates PHP 7.4 - 8.3+, required extensions (`curl`, `gd`, `pdo`, `pdo_mysql`, `mysqli`, `mbstring`, `xml`, `openssl`).
  - Tests database connection and detects rAthena `login` table.
  - Creates the `login` table schema with a single click if missing.
  - Executes migrations and records schema tracking logs without deleting them on submit.
  - Reversible and safe: does not wipe existing character or account data.
- **Step 2: Server & Theme Setup (`?module=install&step=2`):**
  - **All Available Layout Presets Listed:** Visually displays cards for Arcane Nexus, Eternal Dominion, Celestial Chronicle, Eclipse Realm, and Classic FluxCP.
  - Configure Server Identity, Rates, Level Caps, Download Mirrors, and Community Links before launch.
  - Submitting configuration binds settings and transitions seamlessly to the live website without redirect loops.

### 7. Complete CMS Integration (Pages, News, Downloads, Tickets)
- **Pages Module (`?module=pages`):** Custom CMS pages (Rules, FAQ, Guides, Donation info) rendered within the active theme layout.
- **News Module (`?module=news`):** Rich announcements with HTML support, category badges, author tags, and pagination.
- **Downloads Module (`?module=downloads`):** Multi-mirror distribution supporting Full Client, Lite Client, and patches.
- **Service Desk (`?module=servicedesk`):** Full player ticketing system with status tags, category controls, and staff responses.

---

## Color Palettes & Design Tokens

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
│   ├── homepage/                # Homepage CMS & 5-Theme Switcher
│   ├── install/                 # Two-Step setup & Re-Install wizard
│   ├── news/                    # Announcement manager & reader
│   ├── pages/                   # Codex document manager
│   ├── downloads/               # Client package manager
│   ├── servicedesk/             # ITIL support ticket system
│   └── ranking/                 # Character, Guild, and MVP ladders
└── themes/
    ├── nexus/                   # Arcane Nexus (Theme V5)
    │   ├── css/nexus.css        # Cyber-magic design system
    │   ├── img/nexus-logo.png   # Transparent 32-bit PNG logo
    │   ├── main/navbar.php      # Floating dock & user pill
    │   ├── footer.php           # Command center footer & mobile drawer
    │   └── README.md            # Theme documentation
    ├── dominion/                # Eternal Dominion (Theme V4)
    │   ├── css/dominion.css     # Medieval fantasy design system
    │   ├── img/dominion-logo.png# Transparent 32-bit PNG crest
    │   ├── main/navbar.php      # Two-tier royal navigation
    │   └── footer.php           # Citadel footer & brand links
    ├── celestial/               # Celestial Chronicle (Theme V3)
    │   ├── css/celestial.css    # Light fantasy design system
    │   ├── img/celestial-logo.png# Transparent 32-bit PNG logo
    │   └── footer.php           # Skyward footer
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
  - Select your preferred layout from the 5 visual cards (**Arcane Nexus**, **Eternal Dominion**, **Celestial Chronicle**, **Eclipse Realm**, or **Classic FluxCP**).
  - Enter your **Server Name**, **Slogan**, **EXP / Drop Rates**, **Level Caps**, and **Client Download Mirrors**.
  - Click **"Save Configuration & Launch Website"**.
  - The wizard finalizes setup and redirects directly to your live, fully-styled MMORPG portal.

---

## Administrator Guide

### Changing Themes Live
1. Log in with an administrator account (`group_level >= 20` or configured `AdminMenuGroupLevel`).
2. In the navigation bar, click the user pill and select **Staff Panel &rarr; Homepage & Theme CMS** (`?module=homepage`).
3. Under **Theme & Layout Selection**, select your preferred layout card:
   - **Arcane Nexus (V5)**
   - **Eternal Dominion (V4)**
   - **Celestial Chronicle (V3)**
   - **Eclipse Realm (V2)**
   - **Classic FluxCP (V1)**
4. Click **"Save Homepage Settings"**. The theme updates instantly across all pages and sessions.

### Updating Server Logos & Branding
1. In **Homepage CMS** (`?module=homepage`), locate **1. Server Brand & Identity**.
2. **Logo URL:** Enter the web path or URL to your custom logo (e.g. `/themes/nexus/img/nexus-logo.png`).
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
