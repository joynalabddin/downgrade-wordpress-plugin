# DevJoynal Downgrade Documentation and Wiki Guide

This guide defines a practical documentation structure for the **DevJoynal Downgrade** WordPress plugin. The goal is to help site administrators use the plugin safely, help contributors understand the code, and help new visitors discover the project without replacing useful documentation with keyword stuffing.

## Recommended documentation information architecture

| Page | Audience | Purpose | Recommended contents |
|---|---|---|---|
| Home / Overview | Everyone | Explain the product in one place. | What the plugin does, what it does not do, current release, compatibility, quick links, and safety warning. |
| Getting Started | Administrators | Help a new user install and configure the plugin. | Requirements, installation, first-run checklist, backup requirement, settings path, and first staging test. |
| Safe Core Rollback | Administrators and agencies | Explain the complete rollback process. | Backup verification, staging workflow, target version selection, native Update Core review, post-update testing, and recovery. |
| Settings Reference | Administrators | Describe every setting accurately. | Target version, custom URL toggle, checksum, diagnostics, reset behavior, capability, and expected validation errors. |
| Custom Package Verification | Technical administrators | Explain custom ZIP risks. | Trusted source requirements, SHA-256 calculation, checksum limitations, package validation roadmap, and failure handling. |
| Diagnostics and Troubleshooting | Support users | Resolve common failures. | DNS/TLS errors, HTTP status, redirects, HTML responses, filesystem permissions, stale transients, and conflicting update plugins. |
| Compatibility Matrix | Developers and agencies | Show tested environments honestly. | WordPress versions, PHP versions, database/server notes, test date, test type, and known limitations. |
| Security Policy | Security researchers | Provide responsible disclosure instructions. | Supported versions, private reporting, impact details, response process, and sensitive-data warning. |
| Developer Guide | Contributors | Explain extension and maintenance conventions. | Hooks, settings names, sanitization, escaping, HTTP API use, test commands, release process, and coding style. |
| Release Notes | Everyone | Explain each release. | Link to `CHANGELOG.md`, breaking or behavior changes, migration notes, checksums, and known limitations. |
| FAQ | Administrators | Answer high-intent questions. | Backup, silent updates, WordPress.org packages, custom URLs, checksum failures, multisite, PHP 8.4, and reset workflow. |

## Home page template

The wiki Home page should begin with one clear sentence:

> DevJoynal Downgrade helps WordPress administrators review a selected Core release through the native WordPress Update Core workflow.

Immediately after that sentence, show the current release, supported minimum versions, documentation links, security policy, and a prominent warning that the plugin is not a backup system. Avoid claims such as “guaranteed safe,” “works on every host,” or “the best WordPress downgrade plugin.”

## Getting Started template

The Getting Started page should follow this order:

1. Confirm that the site has a tested files-and-database backup.
2. Confirm the WordPress, PHP, database, filesystem, and hosting requirements.
3. Install and activate the release ZIP.
4. Open **Settings → DevJoynal Downgrade**.
5. Enter a precise target release and save.
6. Review the effective package URL and diagnostics.
7. Open the native **Update Core** screen and confirm the offered release.
8. Test the site after the change.
9. Remove the pin or deactivate the plugin when it is no longer required.

Every step should include a screenshot or a link to the relevant Settings Reference section when the page is expanded.

## Safe Core Rollback template

Document rollback as a controlled change, not as a one-click promise. Explain what may change, which backups are required, how staging differs from production, what to test after the change, and how to restore the site. Link to the official [WordPress updating documentation](https://wordpress.org/documentation/article/updating-wordpress/) and the project’s own release notes.

## Settings Reference template

Use a table for settings so the behavior remains easy to audit:

| Setting | Input | Default | Validation | Effect |
|---|---|---|---|---|
| Target WordPress version | Version string such as `7.0.6` | Empty | Strict numeric release format | Pins the selected Core update information. |
| Enable custom package URL | Checkbox | Disabled | Explicit boolean normalization | Switches from the generated official URL to a configured URL. |
| Custom package URL | HTTP(S) URL | Empty | URL and scheme validation | Supplies a trusted custom package source. |
| Expected SHA-256 | 64 hexadecimal characters | Empty | Exact digest format | Rejects a downloaded custom package when the digest differs. |
| Reset all settings | Authorized action | N/A | Nonce and capability check | Clears the target, custom URL, and checksum. |

## Troubleshooting template

Each troubleshooting article should state the symptom, likely causes, safe checks, and recovery path. Do not instruct users to disable security controls or expose credentials. For update failures, point users to their backup and hosting recovery process before suggesting repeated attempts.

## Developer Guide template

The Developer Guide should explain the plugin’s architecture in four layers:

| Layer | Documentation focus |
|---|---|
| Settings | Registered options, sanitizers, defaults, capability, and reset behavior. |
| Update filtering | How the selected update response is identified and normalized. |
| Diagnostics | Safe HTTP requests, bounded probes, transient caching, status reporting, and limitations. |
| Release engineering | Syntax checks, regression checks, package structure, checksum generation, and GitHub Actions. |

Document the difference between code that is unit-testable without WordPress and callbacks that require a WordPress integration test environment.

## Documentation quality checklist

Before publishing a page, verify the author, review date, WordPress/PHP versions, links, screenshots, security implications, and recovery instructions. A page should answer a real user question, include original project context, link to authoritative WordPress documentation, and avoid repeating the same keyword unnaturally.

## README.md badge code

Place the following badges immediately below the README title. The workflow badge is dynamic; the compatibility and license badges are descriptive metadata and must be changed whenever the project’s declared support changes. Add a security-policy badge only after a valid `SECURITY.md` file has been published.

```markdown
[![CI](https://github.com/joynalabddin/downgrade-wordpress-plugin/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/joynalabddin/downgrade-wordpress-plugin/actions/workflows/ci.yml)
[![Latest release](https://img.shields.io/github/v/release/joynalabddin/downgrade-wordpress-plugin?display_name=tag&sort=semver)](https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/latest)
[![WordPress tested up to](https://img.shields.io/badge/WordPress_tested_up_to-7.1-21759b.svg)](https://wordpress.org/download/releases/)
[![Requires WordPress](https://img.shields.io/badge/WordPress_required-5.8%2B-21759b.svg)](https://wordpress.org/)
[![Requires PHP](https://img.shields.io/badge/PHP_required-7.4%2B-777bb4.svg)](https://www.php.net/supported-versions.php)
[![License](https://img.shields.io/badge/license-GPLv2%20or%20later-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
```

For a compact badge row, use:

```markdown
[![CI](https://github.com/joynalabddin/downgrade-wordpress-plugin/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/joynalabddin/downgrade-wordpress-plugin/actions/workflows/ci.yml)
[![Release](https://img.shields.io/github/v/release/joynalabddin/downgrade-wordpress-plugin?display_name=tag&sort=semver)](https://github.com/joynalabddin/downgrade-wordpress-plugin/releases/latest)
[![WordPress 5.8+](https://img.shields.io/badge/WordPress-5.8%2B-21759b.svg)](https://wordpress.org/)
[![PHP 7.4+](https://img.shields.io/badge/PHP-7.4%2B-777bb4.svg)](https://www.php.net/)
[![GPLv2+](https://img.shields.io/badge/license-GPLv2%2B-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
```

Do not add a “passing” or “100% secure” static badge. A CI badge should reflect the actual workflow, while compatibility badges should describe declared or tested support rather than imply universal compatibility.

## Optional GitHub CLI commands

The repository topics and homepage can be maintained with:

```bash
REPO="joynalabddin/downgrade-wordpress-plugin"

gh repo edit "$REPO" --homepage "https://devjoynal.com/"
gh repo edit "$REPO" \
  --add-topic wordpress-core \
  --add-topic wordpress-plugin \
  --add-topic wordpress-downgrade \
  --add-topic wordpress-rollback \
  --add-topic wordpress-security \
  --add-topic php \
  --add-topic wp-cli \
  --add-topic staging

gh api "repos/$REPO/topics" \
  -H 'Accept: application/vnd.github+json' \
  --jq '.names'
```

## References

[1]: https://wordpress.org/documentation/article/updating-wordpress/ "WordPress.org — Updating WordPress"
[2]: https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/ "WordPress Plugin Handbook — Plugin Readmes"
[3]: https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/ "WordPress Plugin Handbook — Detailed Plugin Guidelines"
[4]: https://docs.github.com/en/actions/using-workflows/workflow-syntax-for-github-actions "GitHub Docs — Workflow syntax for GitHub Actions"
[5]: https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/classifying-your-repository-with-topics "GitHub Docs — Classifying your repository with topics"
[6]: https://developers.google.com/search/docs/fundamentals/creating-helpful-content "Google Search Central — Creating Helpful, Reliable, People-First Content"
