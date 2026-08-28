=== DevJoynal Downgrade ===
Contributors: joynalabdin
Tags: wordpress downgrade, wordpress rollback, core version, wordpress update, version pinning
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 2.0.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
DevJoynal Downgrade pins WordPress Core to an exact release for controlled rollback, compatibility testing, reinstall, and staging workflows.

== Description ==

DevJoynal Downgrade is a WordPress Core version management plugin for administrators who need to review a specific WordPress release through the native **Update Core** screen. It is useful for staging environments, plugin and theme compatibility testing, controlled rollback preparation, reinstall workflows, hosting migrations, and planned Core upgrades.

Enter an exact target version such as `7.0.4`, save the setting, review the effective package URL and diagnostics, and then open the normal WordPress Core Update screen. The plugin changes the Core update information presented to WordPress; it does not silently update WordPress or replace the native upgrader.

By default, the plugin builds a locale-aware package URL for the selected release using the official WordPress downloads endpoint. Administrators can optionally enable a trusted custom HTTP(S) ZIP URL and provide a 64-character SHA-256 checksum. When a checksum is configured, the package is verified before WordPress Core unpacks it.

### Important safety notice

A WordPress Core downgrade or rollback can affect files, the database, themes, plugins, extensions, scheduled jobs, and server requirements. Always create and verify a complete files-and-database backup, test on staging first, and maintain a documented recovery plan before changing WordPress Core.

This plugin is not a backup system, malware scanner, security update replacement, or universal compatibility guarantee. The site administrator remains responsible for package selection, backup verification, staging tests, access control, and recovery decisions.

### Features

* Exact WordPress version validation for structured releases such as `7.0.4`.
* Native WordPress Core Update workflow instead of a separate silent updater.
* Locale-aware official WordPress package URL generation.
* Optional trusted custom ZIP URL for controlled staging or mirror workflows.
* Optional SHA-256 verification for custom WordPress Core packages.
* Locale-aware update entry selection when WordPress returns multiple update entries.
* Cleanup of alternate package fields to make the selected full package more deterministic.
* Safe package diagnostics with status reporting, bounded probing, GET fallback, redirect blocking, HTML-response rejection, and short transient caching.
* Nonce-protected reset control for clearing the version pin, custom URL, and checksum.
* WordPress Settings API validation and capability checks.
* Responsive administrator settings screen with backup guidance.
* Project-owned DevJoynal metadata in the local View details response.

== Installation ==

1. Download the latest `devjoynal-downgrade` ZIP from the [GitHub release page](https://github.com/joynalabddin/downgrade-wordpress-plugin/releases).
2. In WordPress, go to **Plugins > Add New Plugin > Upload Plugin**.
3. Select the ZIP, click **Install Now**, and activate **DevJoynal Downgrade**.
4. Go to **Settings > DevJoynal Downgrade**.
5. Create and verify a complete files-and-database backup before changing the target version.
6. Enter the exact target WordPress release, save, review the diagnostics, and open the native WordPress Core Update screen.
7. Confirm that WordPress is offering the intended release before proceeding.

To disable version pinning, empty the target version field and save, use **Reset all DevJoynal Downgrade settings**, or deactivate the plugin.

### Manual installation

Extract the plugin ZIP and upload the `devjoynal-downgrade` directory to `/wp-content/plugins/`. Activate the plugin from **Plugins > Installed Plugins**. Keep the plugin directory name as `devjoynal-downgrade`.

== Frequently Asked Questions ==

= Is a backup required before using the plugin? =

Yes. Create and verify backups of both the WordPress files and database before every Core version change. Test the restore process on staging whenever possible.

= Does this plugin perform a silent WordPress downgrade? =

No. The plugin pins the update information presented to WordPress and sends the administrator to the native Core Update screen for review and execution. It does not silently run an update.

= Does the plugin download WordPress from WordPress.org? =

By default, it builds the package URL for the selected version and site locale using the official WordPress downloads endpoint. The administrator should review the effective URL and diagnostics before proceeding.

= Can I use a custom WordPress ZIP URL? =

Yes, but only when necessary and only from a trusted source. Enable the custom URL option explicitly, use HTTP or HTTPS, and provide the package's 64-character SHA-256 checksum for production or sensitive staging workflows.

= What happens if the checksum does not match? =

The package is rejected before it is handed to the WordPress upgrader. Recalculate the checksum from the exact ZIP being served and confirm that the expected digest came from a trusted source.

= Does a successful diagnostic prove that the package is safe? =

No. Diagnostics check reachability and basic response characteristics. They are not a complete archive-authenticity, malware, compatibility, or backup check.

= Which capability is required? =

The settings screen and Core update behavior require the WordPress `update_core` capability. Users without that capability should not be able to configure or run this workflow.

= Is PHP 8.4 supported on every host? =

No universal host guarantee is made. PHP 8.4 is a target environment for this project. Verify the actual host, extensions, filesystem permissions, web server, database, and update method on staging before production use.

= Does the plugin work on multisite? =

Test multisite behavior and network administration policy on staging before production use. The site administrator must confirm how Core updates are managed in the network.

= How do I return to the normal WordPress update channel? =

Empty the target version field and save, use the reset control, or deactivate the plugin. Then refresh the native WordPress Core Update screen and confirm the expected update channel.

= Where can I report a bug? =

Use the [GitHub Issues](https://github.com/joynalabddin/downgrade-wordpress-plugin/issues) page. Include the plugin version, WordPress version, PHP version, active update-management plugins, error message, and safe reproduction steps. Never post passwords, private URLs, database dumps, backups, or personal data.

== Screenshots ==

1. DevJoynal Downgrade settings page with the target WordPress version field.
2. WordPress Plugins screen showing DevJoynal Downgrade activated.
3. Package diagnostics and reset controls in the administrator settings screen.

== Changelog ==

= 2.0.4 =
* Fixed custom URL checkbox persistence by explicitly saving the disabled state.
* Added optional SHA-256 verification for custom WordPress ZIP packages before Core unpacks them.
* Improved package diagnostics with safe GET fallback, bounded range probing, redirect blocking, and basic HTML-response rejection.
* Made Core update selection locale-aware and cleared alternate package fields to reduce accidental partial or bundled downloads.
* Removed the inert network-option update hook and aligned compatibility metadata.

= 2.0.3 =
* Rebranded the plugin as DevJoynal Downgrade with the `devjoynal-downgrade` slug.
* Hardened diagnostics with WordPress safe remote requests, no automatic redirects, and short transient caching.
* Tightened boolean setting sanitization.
* Corrected local View details metadata to use Joynal Abdin and devjoynal.com.

= 2.0.1 =
* Added exact version validation, custom URL validation, diagnostics, HTTP status checks, reset controls, and responsive administrator styling.
* Added the Joynal Abdin author portrait and updated project metadata.
* Verified installation and activation against the project’s WordPress 7.1 staging target.

== Upgrade Notice ==

= 2.0.4 =
Use a complete, verified backup and staging test before changing WordPress Core. If a custom ZIP URL is enabled, provide and verify its SHA-256 checksum.

== External services ==

The plugin does not require registration with an external service and does not use analytics, advertising, telemetry, or remote tracking. When an administrator opens the settings screen, package diagnostics may make an HTTP request to the effective official or explicitly configured custom package URL. No site content, user profile, or usage data is sent as part of that diagnostic.

== Credits ==

Developed and maintained by [Joynal Abdin](https://devjoynal.com) at [DevJoynal](https://devjoynal.com).
