# DevJoynal Downgrade

[![Latest release](https://img.shields.io/github/v/release/joynalabddin/downgrade-wordpress-plugin?display_name=tag&sort=semver)](https://github.com/joynalabddin/downgrade-wordpress-plugin/releases)
[![License](https://img.shields.io/badge/license-GPLv2%20or%20later-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![WordPress](https://img.shields.io/badge/WordPress-5.8%2B-21759b.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777bb4.svg)](https://www.php.net/)

**DevJoynal Downgrade** is a focused WordPress plugin for administrators who need to pin WordPress Core to an exact release and then review that release through the normal WordPress Core Update screen. It supports controlled rollback, compatibility testing, reinstall workflows, staging recovery, and planned Core upgrades.

> **Important:** WordPress Core changes can affect files, the database, themes, plugins, extensions, and server requirements. Always create and verify a complete files-and-database backup, test on staging first, and maintain a recovery plan before changing versions.

## Project information

| Field | Value |
|---|---|
| Plugin name | DevJoynal Downgrade |
| Current release | 2.0.4 |
| WordPress compatibility | WordPress 5.8 and later; tested target WordPress 7.1 |
| PHP compatibility | PHP 7.4 and later; PHP 8.4 is a target environment requiring host-level verification |
| Author | [Joynal Abdin](https://devjoynal.com) |
| Project website | [devjoynal.com](https://devjoynal.com) |
| License | [GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html) |
| Plugin directory slug | `devjoynal-downgrade` |

## Why use this plugin?

WordPress Core version changes should be deliberate, reversible, and reviewed before execution. DevJoynal Downgrade adds an administrator-facing version pin without replacing the native Core update workflow. The plugin changes the Core update information that WordPress presents, then lets the administrator review the effective release and package URL on the standard Update Core screen.

The plugin does **not** create backups, guarantee compatibility with every host, bypass WordPress permissions, or silently perform a Core update. It is a controlled configuration tool for administrators who already have a backup and recovery process.

## Features

| Feature | Description | Benefit |
|---|---|---|
| Exact version pinning | Accepts structured releases such as `7.0.6` and rejects malformed values. | Reduces configuration mistakes. |
| Official release URL builder | Builds the locale-aware WordPress distribution URL for the selected release. | Keeps the default source predictable. |
| Custom package URL | Allows a trusted administrator to use a controlled HTTP(S) ZIP source when necessary. | Supports controlled mirrors and special staging workflows. |
| Optional SHA-256 verification | Verifies a configured custom package digest before WordPress Core unpacks the package. | Detects unexpected or tampered package content. |
| Locale-aware update selection | Selects the matching Core update entry and clears alternate package types. | Makes the selected full package more deterministic. |
| Package diagnostics | Uses safe HTTP checks, a bounded range probe, GET fallback, redirect blocking, basic HTML-response rejection, HTTP status reporting, and short transient caching. | Makes pre-update review more useful without repeated network work. |
| Reset control | Clears the version pin, custom URL, and checksum after a nonce and capability check. | Provides a documented return to the normal update channel. |
| Native Settings API | Stores settings through WordPress’s settings system with validation callbacks and capability checks. | Uses familiar WordPress administration behavior. |
| Responsive admin interface | Provides a scoped, responsive settings screen with a backup warning and author panel. | Keeps the workflow clear on common administrator screens. |
| Project-owned details metadata | Supplies DevJoynal branding for the plugin-information response for the project slug. | Prevents unrelated legacy branding in the local details view. |

## Requirements

The current release declares **WordPress 5.8 or later** and **PHP 7.4 or later**. The project has been tested against a WordPress 7.1 staging environment, while PHP 8.4 remains a target environment that must be rechecked on the actual host with its installed extensions, filesystem permissions, web server, and update method.

The plugin requires an administrator with the WordPress `update_core` capability. On multisite, verify the network’s administrative policy and test the workflow on a staging network before using it operationally.

## Installation

### Install from a release ZIP

1. Download the latest `devjoynal-downgrade-*.zip` file from the [GitHub Releases page](https://github.com/joynalabddin/downgrade-wordpress-plugin/releases).
2. In WordPress, open **Plugins → Add New Plugin → Upload Plugin**.
3. Select the ZIP, choose **Install Now**, and activate **DevJoynal Downgrade**.
4. Open **Settings → DevJoynal Downgrade** and confirm that the settings screen loads correctly.

### Install manually

Extract the release ZIP and upload the `devjoynal-downgrade` directory to `/wp-content/plugins/`. Then activate the plugin from **Plugins → Installed Plugins**.

### Verify the release package

The release includes a SHA-256 manifest. Download both the ZIP and its `.sha256` file into the same directory and run:

```bash
sha256sum -c devjoynal-downgrade-2.0.4.sha256
```

A successful result should report `devjoynal-downgrade-2.0.4.zip: OK`.

## How to pin or downgrade WordPress Core safely

First create and verify a complete backup of both the WordPress files and database. Record the current WordPress version, PHP version, active theme, active plugins, hosting recovery method, and any database migration concerns.

On a staging copy, open **Settings → DevJoynal Downgrade**, enter the exact target release, and save. Review the diagnostics result and then follow the **Open Update Core** link. Confirm that WordPress is offering the intended target package before starting the update.

After the change, test the public site, login, administrator screens, editor, forms, media uploads, scheduled jobs, REST API, ecommerce flows, email delivery, and critical integrations. Review Site Health and server error logs. When the pin is no longer needed, empty the target version field and save, use **Reset all Downgrade settings**, or deactivate the plugin to return to the standard update path.

## Custom package URL and checksum

The custom package URL is optional and disabled by default. Enable it only when a trusted, controlled source is required. The URL must use HTTP or HTTPS and should point to a genuine WordPress Core ZIP.

For production use, provide the package’s **64-character SHA-256 checksum**. When a checksum is configured, the plugin verifies the downloaded custom package before handing it back to the WordPress upgrader. A mismatch stops the package from being unpacked. A checksum proves that the downloaded file matches the expected digest; it does not prove that the digest itself came from a trustworthy source. Obtain it from a trusted release channel and test on staging.

## Security and privacy

The plugin is designed for administrator-controlled use and does not contain tracking, advertising, telemetry, or third-party runtime dependencies. It does not collect or transmit site content, user profiles, or usage analytics. Diagnostics make outbound requests only when the administrator opens the plugin settings screen, and only to the effective package URL configured or generated for the selected release.

Security measures include capability checks, Settings API validation, nonce-protected reset handling, escaped administrative output, safe HTTP requests, redirect blocking, bounded diagnostics, short transient caching, and optional package checksum verification. The plugin should still be reviewed and tested within the site’s own backup, access-control, and incident-response process.

## WordPress.org submission files

This GitHub repository contains both public project documentation and the WordPress.org-facing plugin metadata:

| File or directory | Purpose |
|---|---|
| `devjoynal-downgrade/devjoynal-downgrade.php` | Main plugin file and WordPress plugin header. |
| `devjoynal-downgrade/readme.txt` | WordPress.org directory-facing readme metadata and sections. |
| `devjoynal-downgrade/assets/` | Plugin author image and package assets. |
| `devjoynal-downgrade/languages/` | Translation template and compiled translation files. |
| `devjoynal-downgrade/screenshot-*.png` | Screenshots referenced by the WordPress.org readme. |
| `CHANGELOG.md` | Complete GitHub release history. |
| `REFACTORING_ROADMAP.md` | Planned security, performance, testing, and maintainability improvements. |
| `SECURITY_FIX_REPORT.md` | v2.0.4 audit-remediation summary. |

`README.md` is optimized for GitHub visitors and maintainers. WordPress.org parses `readme.txt` and the main plugin PHP header for directory metadata; therefore, changes intended for the official directory must be reflected in those files as well.

## Development and validation

The repository keeps the plugin package self-contained and free of runtime dependencies. Before a release, run at minimum:

```bash
php -l devjoynal-downgrade/devjoynal-downgrade.php
git diff --check
sha256sum -c devjoynal-downgrade-2.0.4.sha256
```

The project’s current audit results and future improvements are documented in [SECURITY_FIX_REPORT.md](SECURITY_FIX_REPORT.md) and [REFACTORING_ROADMAP.md](REFACTORING_ROADMAP.md). Planned CI improvements include WordPress PHPUnit integration tests, PHP 7.4–8.4 syntax checks, WordPress Coding Standards, PHPStan, Markdown validation, and readme validation.

## Contributing

Bug reports and improvement proposals are welcome through [GitHub Issues](https://github.com/joynalabddin/downgrade-wordpress-plugin/issues). When reporting a problem, include the plugin version, WordPress version, PHP version, active update method, relevant error message, and safe reproduction steps. Do not include passwords, private URLs, database dumps, or personally identifiable information.

Before opening a pull request, keep changes focused, follow WordPress coding conventions, update the relevant documentation, and run the syntax, diff, package, and regression checks. Core update behavior should be tested on staging and never assumed from a syntax check alone.

## Support and responsible use

DevJoynal Downgrade is a controlled version-management utility, not a backup system or a substitute for WordPress security updates. If an older Core release is required for compatibility, document the reason, restrict access to the administration area, monitor the site, and schedule a return to a supported release.

For professional maintenance and WordPress security services, visit [devjoynal.com](https://devjoynal.com).

## License

DevJoynal Downgrade is distributed under the [GNU General Public License, version 2 or later](https://www.gnu.org/licenses/gpl-2.0.html).

## References

[1]: https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/ "WordPress Plugin Handbook — Plugin Readmes"
[2]: https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/ "WordPress Plugin Handbook — Detailed Plugin Guidelines"
[3]: https://developer.wordpress.org/apis/security/ "WordPress Developer Resources — Common APIs: Security"
[4]: https://developer.wordpress.org/plugins/http-api/ "WordPress Plugin Handbook — HTTP API"
