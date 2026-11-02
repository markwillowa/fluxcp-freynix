# FluxCP — Eclipse Realm V2 (Custom Theme & CMS Expansion)

[![PHP Version](https://img.shields.io/badge/PHP-7.4%20|%208.0%20|%208.1%20|%208.2-blue.svg)](https://php.net)
[![rAthena](https://img.shields.io/badge/rAthena-Pre--Renewal%20|%20Renewal-orange.svg)](https://rathena.org)
[![Theme](https://img.shields.io/badge/Theme-Eclipse%20Realm%20V2-purple.svg)]()
[![CMS](https://img.shields.io/badge/CMS-Flux_CMS%20Enhanced-gold.svg)]()

A modern, high-performance, dark fantasy custom theme and CMS engine for **Flux Control Panel (FluxCP)**, tailored for Ragnarok Online private servers. Designed with an MMORPG portal aesthetic, dynamic server branding, full administrator CMS controls, and an enhanced setup & re-installation system.

---

## Table of Contents

- [Overview & Aesthetics](#overview--aesthetics)
- [Key Features & Additions](#key-features--additions)
  - [1. Eclipse Realm V2 Design System](#1-eclipse-realm-v2-design-system)
  - [2. White-Label & Dynamic Branding](#2-white-label--dynamic-branding)
  - [3. Homepage CMS & Live Controls](#3-homepage-cms--live-controls)
  - [4. Sticky Header & Intelligent Navigation](#4-sticky-header--intelligent-navigation)
  - [5. Redesigned FluxCP Core Modules](#5-redesigned-fluxcp-core-modules)
  - [6. Enhanced Installation Wizard](#6-enhanced-installation-wizard)
  - [7. Admin Re-Install & Reset Tool](#7-admin-re-install--reset-tool)
- [Color Palette & Design Tokens](#color-palette--design-tokens)
- [Directory Structure](#directory-structure)
- [Installation & Setup](#installation--setup)
- [Administrator Guide](#administrator-guide)
- [Compatibility & Tech Stack](#compatibility--tech-stack)

---

## Overview & Aesthetics

The **Eclipse Realm V2** theme transforms FluxCP into a cinematic, high-end fantasy MMORPG portal. Outdated table-based layouts, crowded borders, and hardcoded texts have been completely replaced with a modular, responsive flexbox/grid layout and rich interactive controls.

### Design Principles
- **Atmospheric & Immersive:** Midnight Navy backgrounds layered with Arcane Purple gradients, gold accents, and subtle particle glows.
- **CMS-Driven & Upgradable:** No duplicate hardcoded content or static PHP copies. Content is driven by the database and editable through the administrative interface.
- **Fully White-Label:** Instantly adaptable to any server name, rate, mode, or logo without modifying underlying code.

---

## Key Features & Additions

### 1. Eclipse Realm V2 Design System
- **Custom Fonts:** Google Fonts pairing using **Cinzel** (fantasy headings/branding), **Outfit** (readable body text), and **Rajdhani** (technical specs & rates).
- **CSS Architecture:**
  - `themes/freynix/css/freynix.css`: Main design system tokens, components, cards, tables, badges, and layout grids.
  - `themes/freynix/css/responsive.css`: Mobile drawer breakpoints, tablet stacking, and adaptive layouts.
  - `themes/freynix/css/flux-compat.css`: Legacy FluxCP table normalization, form field modernizations, and alert styling.
- **Interactive JavaScript:** `themes/freynix/js/freynix.js` handles sticky header transitions, mobile navigation drawer, dropdown hover/click states, tabs switching, and atmospheric canvas particle effects.

### 2. White-Label & Dynamic Branding
All server branding across the entire theme is completely dynamic:
- **Navbar & Header:** Dynamic server name, subtitle/slogan, and custom logo URL.
- **Footer:** Dynamic copyright notice, brand emblem, and editable legal disclaimer.
- **Meta & SEO:** Page `<title>`, description, keywords, and author dynamically pulled from `cp_cmssettings`.
- **Game Modules:** Server Info, Account Registration, Login, Web Commands, and WoE pages automatically inherit the configured server identity.

### 3. Homepage CMS & Live Controls (`/?module=homepage`)
Administrators can customize every aspect of the homepage directly from the web interface without touching PHP files:
- **Server Branding & Identity:**
  - **Server Brand Name:** Updates navbar, footer, browser title, and templates across the site immediately.
  - **Brand Slogan:** Tagline shown below the header logo (e.g., `FORGE YOUR FREEDOM.`).
  - **Logo URL:** Path to custom server crest / logo PNG.
  - **Footer Disclaimer:** Custom legal and copyright text.
- **Section Visibility Toggles:** Show or hide Hero, Floating Stats, News, Features, WoE, Rankings, or Discord callouts.
- **Cinematic Hero Customizer:** Editable main headline, tagline, narrative description, CTA button texts, and target URLs.
- **Floating Stats:** Editable rates (e.g. `1000x / 1000x`), max base level (`99`), max job level (`70`), and server mode (`Pre-Renewal`).
- **Feature Highlights (6 Cards):** Editable titles and descriptions for the 6 core server highlights.
- **Community Callouts:** Editable Discord title, text, invite URL, and Facebook page link.

### 4. Sticky Header & Intelligent Navigation
- **Unified Flexbox Layout:** Clean separation between server branding (left), CMS content navigation (center), and user actions (right).
- **CMS Navigation Integration:** Pulls top-level links and sub-menus dynamically from `cp_navigation`.
- **Refined Active & Hover States:** Antique Gold glowing bottom indicator line for active pages and smooth purple-violet hover glow.
- **User Account Pill & Dropdown:**
  - Grouped into the right action bar for authenticated users.
  - Displays user avatar, username, and live Credit Balance.
  - Dropdown options: Player Dashboard, Change Password, Change E-mail, Support Tickets, Login History.
  - **Staff Controls Section:** Instant shortcuts to Homepage CMS, Manage News, Manage Pages, Manage Nav, Manage Downloads, and Re-Install & Reset.
  - Dedicated Logout button with confirmation modal.
- **Dropdown Hover Bridges:** Invisible pseudo-element bridges prevent dropdowns from closing prematurely when moving the cursor.
- **Off-Canvas Mobile Drawer (`<= 1080px`):** Smooth slide-out mobile menu with touch accordion sub-menus.

### 5. Redesigned FluxCP Core Modules
- **News Module (`/?module=news`):** Rich news articles, category badges, publication dates, and administrative management.
- **Pages CMS (`/?module=pages`):** Corrected content container overlap, full support for custom content pages with standard theme framing.
- **Downloads Section (`/?module=main&action=downloads`):** Attractive cards for Full Client, Lite Client, and mirrors with system requirements and installation steps.
- **Service Desk (`/?module=servicedesk`):** Modern ITIL support ticketing interface, ticket conversation threads, category filters, and staff replies.
- **Player Dashboard (`/?module=account&action=view`):** Matched and aligned **Account Credentials** and **Activity & Timestamps** grid, character summaries, and quick actions.
- **Rankings (`/?module=ranking`):** Character leaderboard, Guild ranking, MVP leaderboard, and Zeny leaderboards.
- **War of Emperium (`/?module=woe` & `/?module=castle`):** Timetable and castle ownership boards.
- **Web Commands (`/?module=webcommands`):** Dark fantasy form inputs, clean responsive tables, and syntax guide.

### 6. Enhanced Installation Wizard (`/?module=install`)
- **Theme-Integrated Installer:** Redesigned setup wizard matching the Eclipse Realm aesthetic (`themes/installer`).
- **MySQL Configuration & Connection Tester:**
  - Enter Hostname, Port, DB Name, User, and Password.
  - Auto-tests connection via PDO, creates the database if missing (`CREATE DATABASE IF NOT EXISTS`), backs up `config/servers.php.bak`, and writes valid server arrays.
  - Automatically preserves and generates required FluxCP blocks (`CharServer`, `MapServer`, `WoeDayTimes`, `WoeDisallow`).
- **Pre-Flight Environment Check:** Verifies PHP version, PDO extensions, directory write permissions (`data/`, `data/logs/`).
- **Schema Migration Execution:** Executes migrations without abruptly kicking the admin off the page, allowing review of server parameters.
- **Initial Server Setup:** Configures Server Name, Slogan, EXP/Drop rates, Max Levels, Hero banner, Download mirrors, and Community links before launching.

### 7. Admin Re-Install & Reset Tool (`/?module=install&action=reinstall`)
- Dedicated administrative tool located under Staff Controls.
- Allows developers and administrators to reset schema tracking logs (`data/logs/schemas/logindb/` and `charmapdb/`).
- Optional checkbox to reset CMS default settings and navigation links.
- Automatically grants installer session authorization and redirects to the setup wizard for clean re-deployments.

---

## Color Palette & Design Tokens

| Token Name | Hex Code | Purpose |
|:---|:---|:---|
| `--color-midnight` | `#0B1020` | Base background, deep midnight fantasy foundation |
| `--color-arcane` | `#242044` | Dark arcane purple, card backgrounds, hero overlays |
| `--color-card` | `#171C31` | Content cards, sidebars, and panels |
| `--color-violet` | `#9D80E8` | Mystic violet, accent borders, subtle particle glows |
| `--color-gold` | `#D6AD66` | Antique gold, primary buttons, badges, active accents |
| `--color-text` | `#F4F0FF` | Primary typography, maximum readability |
| `--color-muted` | `#A6ACC5` | Secondary text, meta details, navigation inactive |

---

## Directory Structure

```text
htdocs/
├── config/
│   ├── application.php       # FluxCP core settings, security, cookies
│   ├── servers.php           # Athena servers & MySQL connection configuration
│   └── servers.php.bak       # Automated installer backup
├── lib/
│   ├── Flux/
│   │   ├── CMS.php           # CMS settings repository & helper functions
│   │   └── Sanitizer.php     # Dynamic content escaping & HTML sanitization
│   └── Flux.php              # Core Flux framework initialization
├── modules/
│   ├── homepage/             # Homepage CMS backend controller
│   ├── install/              # Setup wizard & Re-install controller
│   ├── news/                 # News & Announcements management
│   ├── pages/                # Content pages controller
│   ├── ranking/              # Character, guild, and MVP rankings
│   └── servicedesk/          # Ticket support system
└── themes/
    ├── freynix/              # Eclipse Realm V2 Custom Theme
    │   ├── css/
    │   │   ├── freynix.css       # Core design system & component rules
    │   │   ├── responsive.css    # Responsive breakpoints & mobile drawer
    │   │   └── flux-compat.css   # Legacy module compatibility styles
    │   ├── js/
    │   │   └── freynix.js        # Navigation, dropdowns, particles, tabs
    │   ├── img/                  # Theme graphic assets, logos, and hero art
    │   ├── main/
    │   │   ├── navbar.php        # Sticky header & navigation template
    │   │   └── sidebar.php       # Widget sidebar & staff controls
    │   ├── homepage/             # Admin Homepage CMS template
    │   ├── install/              # Admin Re-Install confirmation template
    │   ├── header.php            # HTML <head>, dynamic SEO & scripts
    │   └── footer.php            # Dynamic footer, emblem, & disclaimer
    └── installer/            # Eclipse Realm Installation Wizard Theme
        ├── install/index.php # Multi-step visual setup wizard
        ├── header.php        # Installer header
        └── footer.php        # Installer footer
```

---

## Installation & Setup

1. **Web Server Setup:**
   - Place this codebase in your web root (e.g. `c:/xampp/htdocs` or `/var/www/html`).
   - Ensure Apache/Nginx has write permissions to `data/`, `config/`, and subdirectories.

2. **Launch the Setup Wizard:**
   - Navigate to `http://localhost/?module=install` (or `https://your-domain.com/?module=install`).
   - Enter your installer password (default: `secretpassword`, configured in `config/application.php`).

3. **Configure MySQL:**
   - Fill in your MySQL Host, Port, Username, Password, Database Name, and Server Group Name.
   - Click **"Test Connection & Save MySQL Configuration"**. The wizard automatically tests the connection, creates the database if it doesn't exist, and configures `config/servers.php`.

4. **Install Schemas:**
   - Click **"Install / Update All Schemas"** to run FluxCP database migrations.

5. **Customize Server Details:**
   - Enter your Server Name, Slogan, EXP/Drop Rates, Max Levels, Hero banner texts, and Community links.
   - Click **"Save Configuration & Launch Website"**.

---

## Administrator Guide

### Changing the Server Name & Branding
1. Log in with an administrator account.
2. Click your account pill in the top-right corner and select **Homepage CMS** (`/?module=homepage`).
3. Under **1. SERVER BRANDING & IDENTITY**, update the **Server Brand Name**, **Header Slogan**, or **Logo URL**.
4. Click **"Save Homepage Settings"**. The entire portal updates immediately across all pages.

### Managing Navigation Links
- Navigate to **Manage Nav** (`/?module=navigation`) from the user dropdown.
- Add, edit, or reorder top-level links and sub-menus. The navigation bar updates automatically.

### Re-installing or Resetting Schemas
- Go to the admin dropdown and select **Re-Install & Reset** (`/?module=install&action=reinstall`).
- Select whether to clear schema tracking logs or reset CMS defaults, confirm the action, and you will be returned to the setup wizard.

---

## Compatibility & Tech Stack

- **PHP:** 7.4, 8.0, 8.1, 8.2 compatible (safe syntax, strict types handled).
- **Database:** MySQL 5.7+, MySQL 8.0+, MariaDB 10.3+.
- **rAthena:** Pre-Renewal and Renewal rAthena server branches.
- **Browsers:** Chrome, Firefox, Edge, Safari (Desktop & Mobile).
