=== Downgrade ===
Contributors: joynalabdin
Tags: wordpress downgrade, wordpress rollback, core version, wordpress update, version pinning
Requires at least: 3.0.1
Tested up to: 7.1
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Downgrade or update WordPress Core to an exact release through the normal WordPress update screen.

== Description ==

Downgrade helps administrators pin WordPress Core to a specified version for staging, compatibility testing, controlled rollback, reinstall, or upgrade workflows. The selected release is offered through WordPress Core Updates and normally comes from the official WordPress download endpoint.

This plugin is not a backup system. Always back up files and the database, test on staging, and maintain a recovery plan before changing WordPress Core.

The 2.0.0 admin screen includes exact version validation, locale-aware release URLs, optional trusted custom ZIP URLs, package diagnostics, HTTP status checks, a nonce-protected reset action, responsive styling, and an author panel with Joynal Abdin's supplied portrait.

== Installation ==

1. Upload the `downgrade` ZIP from Plugins > Add New Plugin > Upload Plugin.
2. Install and activate Downgrade.
3. Open Settings > Downgrade.
4. Enter an exact target version, such as `7.0.6`, and save.
5. Open the WordPress Core Update screen and review the offered release before proceeding.

To disable version pinning, empty the target version field and save, use Reset all Downgrade settings, or deactivate the plugin.

== Frequently Asked Questions ==

= Is a backup required? =
Yes. Create and verify backups of both files and the database before every core version change.

= Does the plugin download WordPress from wordpress.org? =
By default, the plugin builds the release URL for the selected version and locale using the official WordPress downloads endpoint.

= Can I use a custom ZIP URL? =
Yes, but only when necessary and only from a trusted source. The custom archive is not independently verified by the plugin.

= Does this guarantee PHP 8.4 compatibility on every host? =
No. The project owner supplied PHP 8.4 as a target environment. Verify the actual host, extensions, filesystem permissions, and update method on staging.

== Screenshots ==

1. Downgrade settings page on WordPress 7.1.
2. Downgrade activated in the Plugins screen.
3. WordPress target version configuration.

== Changelog ==

= 2.0.0 =
* Refactored the admin screen and update filter for modern WordPress and PHP coding practices.
* Added exact version validation, safe custom URL validation, diagnostics, HTTP status checks, and reset controls.
* Added responsive admin styling and the Joynal Abdin author portrait.
* Updated author and project website to Joynal Abdin and https://devjoynal.com.
* Verified installation and activation on the supplied WordPress 7.1 staging site.
* PHP syntax validated with PHP 8.4-targeted project requirements.

== Upgrade Notice ==

= 2.0.0 =
Use a complete backup and staging test before changing WordPress Core.
