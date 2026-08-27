# DevJoynal Downgrade

## Controlled WordPress Core version management for staging, compatibility testing, and planned rollback

[![CI](https://github.com/joynalabddin/downgrade-wordpress-plugin/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/joynalabddin/downgrade-wordpress-plugin/actions/workflows/ci.yml)
[![Latest release](https://img.shields.io/github/v/release/joynalabddin/downgrade-wordpress-plugin?display_name=tag&sort=semver)](https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/latest)
[![WordPress tested up to](https://img.shields.io/badge/WordPress_tested_up_to-7.1-21759b.svg)](https://wordpress.org/download/releases/)
[![Requires WordPress](https://img.shields.io/badge/WordPress_required-5.8%2B-21759b.svg)](https://wordpress.org/)
[![Requires PHP](https://img.shields.io/badge/PHP_required-7.4%2B-777bb4.svg)](https://www.php.net/supported-versions.php)
[![License](https://img.shields.io/badge/license-GPLv2%20or%20later-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

**DevJoynal Downgrade** is an administrator-focused WordPress plugin for presenting a selected WordPress Core release through the native **Update Core** workflow. It is built for controlled version pinning, staging validation, plugin and theme compatibility testing, reinstall workflows, hosting migrations, and documented rollback preparation.

> **Safety first:** A WordPress Core version change can affect files, the database, themes, plugins, scheduled jobs, integrations, server requirements, and site availability. Create and verify a complete files-and-database backup, test on staging, and maintain a recovery plan before changing Core.

## At a glance

| Item | Details |
|---|---|
| Current release | [v2.0.4](https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/tag/v2.0.4) |
| Plugin slug | `devjoynal-downgrade` |
| WordPress requirement | 5.8 or later |
| Tested target | WordPress 7.1 staging environment |
| PHP requirement | 7.4 or later |
| PHP 8.4 | Project target; verify the actual host on staging |
| Required capability | `update_core` |
| License | [GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html) |
| Author | [Joynal Abdin](https://devjoynal.com) |
| Website | [devjoynal.com](https://devjoynal.com) |

## What the plugin does

WordPress normally presents Core releases selected by its update service. DevJoynal Downgrade adds a controlled administrator setting that changes the update information WordPress receives for a specific target release. The administrator can then review the effective package URL, inspect diagnostics, and continue through the familiar native **Update Core** page.

The plugin does **not** silently replace WordPress Core, bypass WordPress permissions, or guarantee that an older release is safe for a particular site. It is a version-management aid, not a backup system, malware scanner, security-update replacement, or universal compatibility guarantee.

## Key capabilities

| Capability | Why it matters |
|---|---|
| Exact version pinning | Accepts structured releases such as `7.0.6` and rejects malformed or ambiguous values. |
| Native Core workflow | Keeps review and execution inside the normal WordPress update screen rather than implementing a separate silent updater. |
| Locale-aware package selection | Builds the official package URL for the selected release and detected site locale. |
| Trusted custom ZIP URL | Supports controlled mirrors and staging sources when explicitly enabled by an authorized administrator. |
| Optional SHA-256 verification | Compares a configured 64-character digest before a custom package is handed to the Core upgrader. |
| Locale-aware update matching | Selects the best matching update entry when WordPress returns multiple entries. |
| Alternate package cleanup | Clears partial, rollback, bundled, and no-content alternatives after a target is selected. |
| Bounded diagnostics | Uses safe WordPress HTTP requests, redirect blocking, status reporting, and short transient caching. |
| Reset control | Clears the version pin, custom URL, and checksum after authorization. |
| WordPress Settings API | Uses WordPress settings registration, sanitization, nonces, capabilities, and contextual escaping. |
| Administrator UI | Provides a responsive settings screen with backup guidance, diagnostics, and project-owned metadata. |

## Installation

DevJoynal Downgrade changes the WordPress Core update information shown to an authorized administrator. Installation itself does not downgrade WordPress. Configure a target only after the plugin is active, the package source has been reviewed, and the recovery plan has been tested.

### Before you install

Confirm that the site meets the [declared requirements](#at-a-glance): WordPress 5.8 or later, PHP 7.4 or later, and an administrator with the `update_core` capability. For the project target environment, verify WordPress 7.1 and PHP 8.4 on the actual staging host rather than assuming that every hosting stack behaves identically.

Create a complete backup of both the WordPress files and database. Verify that the backup is restorable, record the current WordPress and PHP versions, and note the active theme, plugins, scheduled integrations, and hosting recovery procedure. For a production site, perform the first installation and version test on staging.

### Install from the release ZIP

1. Open the [v2.0.4 GitHub release](https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/tag/v2.0.4) and download `devjoynal-downgrade-2.0.4.zip`.
2. Optionally download `devjoynal-downgrade-2.0.4.sha256` and verify the archive using the command below.
3. In the WordPress dashboard, open **Plugins → Add New Plugin → Upload Plugin**.
4. Select the ZIP file, choose **Install Now**, and wait for WordPress to finish unpacking the plugin.
5. Select **Activate Plugin**. If WordPress reports an existing version, use the update path and confirm that the package comes from this project’s release page.
6. Open **Plugins → Installed Plugins**, confirm that **DevJoynal Downgrade** is active, and review the plugin version.
7. Open **Settings → DevJoynal Downgrade**. Confirm that the settings page loads, shows the current WordPress version, and displays no unexpected diagnostic error.
8. Do not enter a target release until the backup, staging test, package URL, and recovery plan have been reviewed.

### Manual installation through SFTP or hosting file manager

1. Download the release ZIP and verify its checksum when a manifest is available.
2. Extract the archive locally. The package must contain one top-level directory named `devjoynal-downgrade`.
3. Upload that directory to `/wp-content/plugins/` using SFTP or the host’s file manager. Do not upload only the PHP file and do not rename the directory.
4. In the dashboard, open **Plugins → Installed Plugins** and activate **DevJoynal Downgrade**.
5. Confirm that `devjoynal-downgrade/devjoynal-downgrade.php` exists and that the settings page is available under **Settings → DevJoynal Downgrade**.

### Verify the release archive

The v2.0.4 release includes a SHA-256 manifest. Place the ZIP and manifest in the same local directory and run:

```bash
sha256sum -c devjoynal-downgrade-2.0.4.sha256
```

A valid result is:

```text
devjoynal-downgrade-2.0.4.zip: OK
```

On Windows, calculate the SHA-256 value with PowerShell and compare it with the value in the manifest:

```powershell
Get-FileHash .\\devjoynal-downgrade-2.0.4.zip -Algorithm SHA256
```

### Post-install verification

After activation, check that the plugin settings page is accessible only to an authorized administrator, the target field is empty by default, the diagnostics area loads, and the native **Update Core** link opens the expected WordPress screen. On staging, configure a known target release and confirm the displayed package URL and locale before taking any update action.

If the settings page is missing, confirm activation status, PHP compatibility, filesystem permissions, and the WordPress error log. If WordPress reports a package or checksum problem, stop the update, confirm the exact ZIP and trusted digest, and restore from the verified backup if the site has already been changed.

### Remove or disable the plugin safely

To stop version pinning while keeping the plugin installed, empty the target version field and save, or use **Reset all settings**. Refresh the native **Update Core** screen and confirm that the normal update channel has returned. Deactivate the plugin only after the pin has been cleared or when following the site’s documented maintenance procedure. Delete the plugin from **Plugins → Installed Plugins** only after confirming that no target configuration is still required.

## Configuration

Open **Settings → DevJoynal Downgrade**, enter the exact target release, save the setting, and review the effective package URL and diagnostic status. Then use **Open Update Core** to review the release in the native WordPress workflow.

| Setting | Behavior |
|---|---|
| Target WordPress version | Pins the exact Core release shown to the native update workflow. Leave empty to disable the pin. |
| Effective package URL | Displays the official locale-aware URL or explicitly enabled custom URL. |
| Custom package URL | Accepts a trusted HTTP(S) WordPress ZIP source when the option is enabled. |
| Expected SHA-256 checksum | Rejects a custom package when its downloaded bytes do not match the configured digest. |
| Diagnostics status | Reports bounded reachability and basic response characteristics; it is not a full authenticity or compatibility test. |
| Reset all settings | Clears the target version, custom URL, and checksum after capability and nonce validation. |

## Recommended rollback workflow

Treat every Core change as a controlled maintenance event. Record the current WordPress and PHP versions, database and server details, active theme and plugins, scheduled integrations, and recovery procedure. Verify that the files-and-database backup can be restored before proceeding.

Test on a staging copy first. Configure the target release, review the locale and package URL, inspect diagnostics, open the native **Update Core** screen, and confirm that WordPress offers the intended release. After the change, test the public site, authentication, administrator screens, editor, forms, media uploads, REST API, cron, email, ecommerce, search, cache, payment integrations, and other business-critical paths. Review **Tools → Site Health** and server logs.

When the target is no longer required, empty the target field and save, use the reset control, or deactivate the plugin to return to the normal update channel. Maintain a documented return path to a supported WordPress release.

## Custom package security model

Custom package URLs are disabled by default and should be used only for a trusted, controlled source. A reachable URL can still serve the wrong file. For production or sensitive staging workflows, provide the package’s SHA-256 digest through a trusted release channel.

A matching digest proves that the downloaded bytes match the expected bytes. It does not prove that the expected digest came from a trusted source, and it does not replace archive-structure, malware, compatibility, or backup review. The diagnostics screen is intentionally limited and is not a complete archive-authenticity test.

## Security and privacy

The plugin is designed for administrator-controlled use. It contains no advertising, telemetry, analytics, user tracking, or third-party runtime dependency. It does not collect or transmit site content, user profiles, or usage analytics. When an administrator views the settings screen, diagnostics may request the effective official or explicitly configured custom package URL.

Security controls include capability checks, Settings API validation, nonce-protected reset handling, contextual escaping, safe HTTP requests, redirect blocking, bounded diagnostics, transient caching, strict version validation, and optional checksum verification. Never include passwords, private URLs, database dumps, backup archives, or personal data in a public issue.

## Troubleshooting

| Symptom | Checks |
|---|---|
| Target release is not shown | Confirm the version format, save again, refresh the native **Update Core** page, and check that the user has `update_core`. |
| Diagnostics report an HTTP error | Check DNS, TLS, firewall, hosting egress rules, package URL, and remote availability from the staging host. |
| Custom package is rejected | Recalculate the digest from the exact ZIP being served and confirm it contains exactly 64 hexadecimal characters. |
| Normal update remains visible | Confirm the target is saved and check whether another update-management plugin is replacing the same update data. |
| Site behaves incorrectly after rollback | Restore the verified backup or follow the host recovery plan; then review database, PHP, theme, plugin, cache, REST, and scheduled-job compatibility. |

## Repository map

| Path | Purpose |
|---|---|
| `devjoynal-downgrade/` | WordPress.org-ready plugin package. |
| `devjoynal-downgrade/devjoynal-downgrade.php` | Main plugin file, hooks, settings, diagnostics, and update behavior. |
| `devjoynal-downgrade/readme.txt` | WordPress.org-facing metadata, installation, FAQ, screenshots, and changelog. |
| `devjoynal-downgrade/assets/` | Plugin assets, including the author image. |
| `devjoynal-downgrade/languages/` | Translation template and compiled translations. |
| `.github/workflows/ci.yml` | PHP linting, metadata validation, Markdown checks, and package smoke tests. |
| `CHANGELOG.md` | Release history. |
| `REFACTORING_ROADMAP.md` | Planned security, performance, testing, and maintainability improvements. |
| `SECURITY_FIX_REPORT.md` | v2.0.4 audit-remediation summary. |
| `docs/WIKI_GUIDE_AND_BADGES.md` | Documentation architecture and README badge guide. |
| `LICENSE` | Complete GNU GPLv2 license text. |
| `COPYRIGHT` | Joynal Abdin copyright and project ownership notice. |

## Development and validation

Before opening a pull request or publishing a release, run the local checks relevant to your change:

```bash
php -l devjoynal-downgrade/devjoynal-downgrade.php
git diff --check
```

GitHub Actions additionally checks PHP syntax on PHP 7.4 and PHP 8.4, plugin metadata, documentation hygiene, package structure, required files, and release archive integrity. A clean syntax check does not prove that a live Core update is safe; staging validation remains required.

## WordPress.org documentation

This repository includes a WordPress.org-ready `readme.txt`, screenshots, GPL-compatible code and assets, plugin metadata, and an installable package structure. See the [WordPress.org submission checklist](docs/WORDPRESS_ORG_SUBMISSION_CHECKLIST.md) and the official [Plugin Handbook](https://developer.wordpress.org/plugins/wordpress-org/) before submitting.

## Contributing

Bug reports and focused improvement proposals are welcome through [GitHub Issues](https://github.com/joynalabddin/downgrade-wordpress-plugin/issues). Include the plugin version, WordPress version, PHP version, active update-management plugins, relevant error message, and safe reproduction steps. Keep pull requests focused, update documentation when behavior changes, follow WordPress coding conventions, and test Core behavior on staging.

## Project and support

DevJoynal Downgrade is maintained by [Joynal Abdin](https://devjoynal.com). For project documentation, source code, releases, and issue tracking, use this repository. For professional WordPress development and maintenance services, visit [devjoynal.com](https://devjoynal.com).

## License

DevJoynal Downgrade is distributed under the [GNU General Public License, version 2 or later](https://www.gnu.org/licenses/gpl-2.0.html). Copyright remains with Joynal Abdin; the license grants the permissions and imposes the conditions described in `LICENSE`.

## References

[1]: https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/ "WordPress Plugin Handbook — Plugin Readmes"
[2]: https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/ "WordPress Plugin Handbook — Detailed Plugin Guidelines"
[3]: https://developer.wordpress.org/apis/security/ "WordPress Developer Resources — Security"
[4]: https://developer.wordpress.org/plugins/http-api/ "WordPress Plugin Handbook — HTTP API"
[5]: https://developers.google.com/search/docs/fundamentals/creating-helpful-content "Google Search Central — Helpful Content"
