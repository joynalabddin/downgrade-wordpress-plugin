# Security, Performance, and Maintainability Refactoring Roadmap

**Project:** DevJoynal Downgrade  
**Current release:** 2.0.4  
**Author:** Joynal Abdin / DevJoynal

The v2.0.4 release already addresses the highest-priority audit findings. The following refactorings would further improve production quality without adding unnecessary complexity.

## Priority roadmap

| Priority | Refactoring | Why it matters | Recommended approach |
|---|---|---|---|
| P0 | Add automated regression tests | The plugin changes WordPress Core update objects, so regressions can affect the site’s update path. | Add PHPUnit tests with WordPress test bootstrap for version sanitization, URL sanitization, checkbox-off persistence, reset authorization, locale selection, and package-field clearing. |
| P0 | Make custom package verification fail closed when enabled | An enabled custom URL without a checksum is still trusted by design. | Add a setting such as “Require checksum for custom packages,” enabled by default for new installs. Preserve backward compatibility with an explicit migration notice for existing users. |
| P1 | Separate pure logic from WordPress hooks | The current single-file structure makes isolated testing and future maintenance harder. | Move version parsing, release URL generation, update-object transformation, and checksum policy into small namespaced classes or pure functions. Keep hook callbacks thin. |
| P1 | Improve Core update selection | Locale matching is improved, but target-version selection can be more explicit. | Match both locale and target version where available; otherwise clone the preferred compatible update object and document the fallback. Add tests for empty, malformed, multisite, and multi-entry transients. |
| P1 | Add archive-level validation | SHA-256 proves integrity against a known digest but does not prove that the archive is a genuine WordPress Core package. | After checksum verification, inspect the ZIP safely with `ZipArchive`: require the expected `wordpress/` root, reject path traversal, enforce a maximum entry count/size, and avoid extracting until validation passes. |
| P1 | Add capability and multisite policy tests | `update_core` is appropriate for Core updates, but multisite permissions and network administration need explicit coverage. | Test single-site administrators, multisite super administrators, and users who lack `update_core`. Document whether the setting is site-specific or network-wide. |
| P2 | Avoid repeated diagnostics during page rendering | A remote check during every settings-page render can add latency even with a transient cache miss. | Trigger diagnostics only after a settings save or behind an explicit “Check package” action. Keep a short cache and show the timestamp of the last check. |
| P2 | Use stable cache-key versioning | Future diagnostic schema changes can make old transient values ambiguous. | Prefix the transient key with a schema version, for example `wpdg_url_v2_`, and include locale and verification mode when they affect the result. |
| P2 | Add privacy-aware logging | Supportability improves when failures can be investigated, but package URLs may contain tokens. | Log only error codes, HTTP status, host, and a redacted URL when `WP_DEBUG_LOG` is enabled. Never log credentials, query strings, full response bodies, or package contents. |
| P2 | Make network calls more deterministic | Remote servers can return inconsistent headers or rate-limit requests. | Use a narrowly scoped user agent, explicit accepted response codes, bounded response sizes, and clear distinction between “reachable,” “not a ZIP,” “checksum mismatch,” and “request failed.” |
| P2 | Add static analysis and coding-standard CI | Syntax validation alone does not catch WordPress API misuse or maintainability problems. | Add GitHub Actions for PHP 7.4–8.4 syntax checks, WordPress Coding Standards via PHP_CodeSniffer, PHPStan at a conservative level, and Markdown/readme validation. |
| P3 | Improve admin accessibility and UX | The workflow is high risk and should be clear for keyboard and screen-reader users. | Use standard WordPress notices, visible field descriptions, `aria-describedby` where needed, a confirmation step before enabling custom packages, and clear disabled/active states. |
| P3 | Add controlled rollback safeguards | Downgrading Core can remove security fixes or create database incompatibility. | Add a dry-run summary and a prominent target-version risk notice. Do not attempt automatic backups unless a reliable backup API is available and tested. |
| P3 | Add localization checks | The plugin ships translation templates and German files. | Run text-domain checks, validate placeholders, and add a CI job that detects untranslated or mismatched strings. |

## Security-specific recommendations

WordPress guidance recommends validating and sanitizing input before use and escaping output in its final context [1]. The current release follows that baseline. The next security improvement should be archive validation: a checksum protects against tampering only when the expected digest is obtained from a trusted channel. It does not identify a malicious archive whose checksum was intentionally supplied by an attacker.

The custom URL feature should therefore communicate three distinct states: the URL is syntactically valid, the endpoint is reachable, and the downloaded package passed integrity and structure checks. These states should not be collapsed into a single “Reachable” label.

All remote requests should continue to use WordPress safe HTTP functions. WordPress documents that `wp_safe_remote_head()` validates the URL and redirect destinations to reduce SSRF exposure [2]. Any future download or archive-inspection code should retain the same safe-request boundary and use bounded timeouts and response sizes.

## Performance-specific recommendations

WordPress recommends the HTTP API for remote requests and transients for temporary cached values [3]. The current five-minute transient is reasonable for a low-frequency admin diagnostic, but the best next optimization is to avoid doing network work on every page view. Run the check after a relevant save or explicit user action, cache the result, and display when it was last refreshed.

The plugin has no front-end assets and uses a small scoped inline stylesheet only on its settings screen, so front-end performance risk is currently low. The main performance risk is administrative latency from remote diagnostics and duplicate downloads when users configure a checksum. The checksum implementation intentionally returns the verified temporary file to WordPress Core, preventing a second package download.

## Recommended implementation sequence

The safest next release sequence is: first add the PHPUnit and static-analysis foundation; then implement fail-closed checksum policy and ZIP structure validation; next refine update-object selection and multisite behavior; finally optimize diagnostic timing and improve admin accessibility. Each step should be released independently with a migration note and a staging verification record.

## References

[1]: https://developer.wordpress.org/apis/security/ "WordPress Developer Resources — Common APIs: Security"
[2]: https://developer.wordpress.org/reference/functions/wp_safe_remote_head/ "WordPress Developer Resources — wp_safe_remote_head"
[3]: https://developer.wordpress.org/plugins/http-api/ "WordPress Developer Resources — HTTP API"
