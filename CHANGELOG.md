# Changelog

All notable changes to **DevJoynal Downgrade** are documented here.

This project follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and uses [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Planned

- Add automated WordPress integration tests for settings persistence, update-object selection, reset authorization, package verification, and multisite behavior.
- Add an optional dry-run preview that shows the target release and effective package URL without initiating an update.
- Add exportable diagnostics for support and staging review without exposing secrets or site content.
- Evaluate multisite-specific behavior and network-level administrative controls.

## [2.0.4] — 2026-08-27

### Security

- Added optional SHA-256 verification for custom WordPress ZIP packages before WordPress Core unpacks them.
- Kept custom package downloads opt-in and documented the requirement to use a trusted source and staging validation.
- Removed the inert `pre_site_option_update_core` hook so the plugin only alters the intended Core update transient.

### Fixed

- Fixed custom URL checkbox persistence by submitting an explicit disabled value when the checkbox is unchecked.
- Made Core update selection locale-aware instead of assuming the first update object is always the correct entry.
- Cleared partial, bundled, rollback, and no-content package alternatives so the configured full package is used deterministically.
- Improved package diagnostics with a safe GET fallback for servers that reject HEAD, a bounded range probe, redirect blocking, and basic HTML-response rejection.
- Aligned public compatibility metadata at WordPress 5.8 minimum, WordPress 7.1 tested target, and PHP 7.4 minimum.
- Removed the obsolete legacy `downgrade/` implementation so the renamed `devjoynal-downgrade/` directory is the only authoritative plugin entry point.

### Documentation

- Updated the GitHub README, WordPress readme, security report, and upgrade notice for the v2.0.4 behavior.
- Added a portable SHA-256 manifest for the release ZIP.

## [2.0.3] — 2026-08-27

### Changed

- Renamed the plugin to **DevJoynal Downgrade** with the distinctive `devjoynal-downgrade` slug.
- Preserved the project-owned View Details metadata for Joynal Abdin and devjoynal.com.
- Added the branded author panel and supplied author portrait.

### Security and performance

- Hardened diagnostics with WordPress safe remote requests, no automatic redirects, and short transient caching.
- Tightened boolean setting sanitization.

## [2.0.2] — 2026-08-27

### Security and reliability

- Hardened diagnostics and prepared the plugin for WordPress.org submission.
- Added safer remote request handling and improved administrative safeguards.

## [2.0.1] — 2026-08-27

### Added

- Added exact version validation, safe custom URL validation, diagnostics, HTTP status checks, and a nonce-protected reset control.
- Added responsive admin styling and the Joynal Abdin author panel.

### Fixed

- Fixed the WordPress View Details modal so the project uses Joynal Abdin and devjoynal.com metadata instead of unrelated directory branding.

## [2.0.0] — 2026-08-27

### Added

- Introduced the professional admin interface for controlled WordPress Core version management.
- Added the initial branded release and documented staging-first workflow.

## [1.2.6] — 2026-08-27

### Changed

- Prepared the original Downgrade codebase for WordPress 7.1 and PHP 8.4-targeted testing.

[Unreleased]: https://github.com/joynalabddin/downgrade-wordpress-plugin/compare/v2.0.4...HEAD
[2.0.4]: https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/tag/v2.0.4
[2.0.3]: https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/tag/v2.0.3
[2.0.2]: https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/tag/v2.0.2
[2.0.1]: https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/tag/v2.0.1
[2.0.0]: https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/tag/v2.0.0
[1.2.6]: https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/tag/v1.2.6
