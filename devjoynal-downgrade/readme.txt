=== DevJoynal Downgrade ===
Contributors: joynalabdin
Tags: wordpress downgrade, wordpress rollback, core version, wordpress update, version pinning
Requires at least: 5.8
Tested up to: 7.1
Stable tag: 2.0.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

DevJoynal Downgrade helps administrators downgrade or update WordPress Core to an exact release through the normal WordPress update screen.

== Description ==

DevJoynal Downgrade helps administrators pin WordPress Core to a specified version for staging, compatibility testing, controlled rollback, reinstall, or upgrade workflows. The selected release is offered through WordPress Core Updates and normally comes from the official WordPress download endpoint.

This plugin is not a backup system. Always back up files and the database, test on staging, and maintain a recovery plan before changing WordPress Core.

The 2.0.4 admin screen includes exact version validation, locale-aware release URLs, an optional trusted custom ZIP URL, optional SHA-256 package verification, resilient package diagnostics, HTTP status checks, a nonce-protected reset action, responsive styling, an author panel with Joynal Abdin's supplied portrait, and a project-owned View details response that prevents unrelated directory branding.

== Installation ==

1. Upload the `devjoynal-downgrade` ZIP from Plugins > Add New Plugin > Upload Plugin.
2. Install and activate DevJoynal Downgrade.
3. Open Settings > DevJoynal Downgrade.
4. Enter an exact target version, such as `7.0.6`, and save.
5. Open the WordPress Core Update screen and review the offered release before proceeding.

To disable version pinning, empty the target version field and save, use Reset all DevJoynal Downgrade settings, or deactivate the plugin.

== Frequently Asked Questions ==

= Is a backup required? =
Yes. Create and verify backups of both files and the database before every core version change.

= Does the plugin download WordPress from wordpress.org? =
By default, the plugin builds the release URL for the selected version and locale using the official WordPress downloads endpoint.

= Can I use a custom ZIP URL? =
Yes, but only when necessary and only from a trusted source. For production use, provide the package's 64-character SHA-256 checksum so the plugin can reject a tampered or unexpected archive before WordPress Core unpacks it.

= Does this guarantee PHP 8.4 compatibility on every host? =
No. The project owner supplied PHP 8.4 as a target environment. Verify the actual host, extensions, filesystem permissions, and update method on staging.

== Screenshots ==

1. Downgrade settings page on WordPress 7.1.
2. Downgrade activated in the Plugins screen.
3. WordPress target version configuration.

== Changelog ==

= 2.0.4 =
* Fixed custom URL checkbox persistence by explicitly saving the disabled state.
* Added optional SHA-256 verification for custom WordPress ZIP packages before Core unpacks them.
* Improved diagnostics with safe GET fallback, range probing, and basic HTML-response rejection.
* Made Core update selection locale-aware and cleared alternate package fields to avoid accidental partial or bundled downloads.
* Removed the inert network-option update hook and aligned release metadata.

= 2.0.3 =
* Renamed the plugin to DevJoynal Downgrade with the distinctive `devjoynal-downgrade` slug.
* Hardened diagnostics with WordPress safe remote requests, no automatic redirects, and a short transient cache to reduce repeated network calls.
* Tightened boolean setting sanitization.
* Retained the View details modal branding fix for Joynal Abdin and devjoynal.com.

= 2.0.1 =
* Fixed the WordPress View details modal so the downgrade slug uses Joynal Abdin and devjoynal.com project metadata.
* Refactored the admin screen and update filter for modern WordPress and PHP coding practices.
* Added exact version validation, safe custom URL validation, diagnostics, HTTP status checks, and reset controls.
* Added responsive admin styling and the Joynal Abdin author portrait.
* Updated author and project website to Joynal Abdin and https://devjoynal.com.
* Verified installation and activation on the supplied WordPress 7.1 staging site.
* PHP syntax validated with PHP 8.4-targeted project requirements.

== Upgrade Notice ==

= 2.0.4 =
Use a complete backup and staging test before changing WordPress Core. If a custom ZIP URL is enabled, provide and verify its SHA-256 checksum.
