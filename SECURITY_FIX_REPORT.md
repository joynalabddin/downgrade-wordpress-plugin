# DevJoynal Downgrade v2.0.4 — Security and Reliability Fix Report

**Repository:** https://github.com/joynalabddin/downgrade-wordpress-plugin  
**Release:** 2.0.4  
**Author:** Joynal Abdin / DevJoynal

## Remediated findings

| Audit finding | v2.0.4 remediation |
|---|---|
| Custom URL checkbox could remain enabled after being unchecked | Added a hidden `0` field so the Settings API persists the disabled state. |
| Inconsistent compatibility metadata | Aligned `readme.txt` with the PHP header at WordPress 5.8 minimum, WordPress 7.1 tested target, and PHP 7.4 minimum. |
| Weak package diagnostics | Added safe GET fallback for servers that reject HEAD, a one-byte range probe, redirect blocking, HTML-response rejection, and transient caching. |
| First update entry was always rewritten | Added locale-aware selection of the update object and cleared partial, bundled, rollback, and no-content package alternatives. |
| Custom package lacked integrity verification | Added an optional 64-character SHA-256 setting and `upgrader_pre_download` verification. A mismatched custom archive is rejected before Core unpacks it. |
| Inert network-option hook | Removed the unrelated `pre_site_option_update_core` registration. |
| Duplicate legacy implementation in source tree | Removed the obsolete `downgrade/` directory so `devjoynal-downgrade/` is the only authoritative plugin directory. |

## Verification

The v2.0.4 PHP source passes `php -l`, `git diff --check` passes, and 12 focused regression checks pass. The release ZIP is rooted at `devjoynal-downgrade/`, contains the renamed main file, and has SHA-256 digest:

`9cbcda4031a9060939382d27d1d3c9da984468480637fe010a2e8f5ecb54eb64`

The checksum verifies the locally built `devjoynal-downgrade-2.0.4.zip` artifact. The plugin still requires a complete backup and staging validation before any WordPress Core change.
