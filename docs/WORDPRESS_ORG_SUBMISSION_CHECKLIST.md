# WordPress.org Submission Checklist

This checklist is tailored to **DevJoynal Downgrade** and should be reviewed immediately before submitting the plugin to the official WordPress.org Plugin Directory.

## Current package status

| Requirement | Current status | Evidence or action |
|---|---|---|
| Public source repository | Complete | [GitHub repository](https://github.com/joynalabddin/downgrade-wordpress-plugin) is public. |
| Open-source license | Complete | Root `LICENSE` contains canonical GPLv2 text; `COPYRIGHT` identifies Joynal Abdin. |
| GPL metadata | Complete | Main plugin file and `readme.txt` declare GPLv2-or-later. |
| Main plugin file | Complete | `devjoynal-downgrade/devjoynal-downgrade.php` contains the plugin header and version `2.0.4`. |
| WordPress.org readme | Complete | `devjoynal-downgrade/readme.txt` contains metadata, description, installation, FAQ, screenshots, changelog, and upgrade notice. |
| Screenshots | Complete | `screenshot-1.png`, `screenshot-2.png`, and `screenshot-3.png` are present and referenced. |
| Human-readable source | Complete | The deployed PHP source is readable and the repository is publicly maintained. |
| CI and package checks | Complete | `.github/workflows/ci.yml` validates syntax, metadata, package structure, and archive integrity. |
| WordPress.org account | Blocked | The current `wpexpertrafi` account was previously reported as disabled; contact WordPress.org account support before submitting. |
| Official submission | Not yet completed | Submit only after the account is active and the final package passes the readme validator. |

## Pre-submission technical checks

Run the following checks from the repository root:

```bash
php -l devjoynal-downgrade/devjoynal-downgrade.php
git diff --check
git status --short
```

Then verify that the plugin package contains the main PHP file, `readme.txt`, screenshots, translations, required assets, and license-compatible code or media. Do not include secrets, database exports, backup archives, development credentials, or unrelated build artifacts.

Validate the WordPress.org readme with the official [readme validator](https://wordpress.org/plugins/developers/readme-validator/). Fix every parser warning before submission. Keep the following values synchronized between the main plugin header and `readme.txt`:

| Field | Main plugin header | `readme.txt` |
|---|---|---|
| Plugin name | `DevJoynal Downgrade` | Display name in the first description line |
| Version | `2.0.4` | `Stable tag: 2.0.4` |
| Minimum WordPress | `5.8` | `Requires at least: 5.8` |
| Tested WordPress | `7.1` | `Tested up to: 7.1` |
| Minimum PHP | `7.4` | `Requires PHP: 7.4` |
| License | `GPL-2.0-or-later` | `GPLv2 or later` |

## Guideline review

Before submitting, confirm that every included PHP file, image, translation, library, and asset is original, GPL-compatible, or distributed under terms compatible with the WordPress.org requirements. The plugin must not contain hidden or obfuscated code, artificial feature restrictions, unauthorized tracking, unsolicited external links on the public site, or trialware behavior.

Confirm that external requests are documented and initiated only for a clear plugin function. DevJoynal Downgrade’s diagnostics are administrator-triggered and should remain documented in the readme. Keep the plugin’s built-in functionality available without license keys, paywalls, quotas, or mandatory registration.

## Submission process

1. Reactivate or recover the WordPress.org account and ensure its contact email is current.
2. Log in to the WordPress.org developer area.
3. Run `readme.txt` through the official validator.
4. Submit the complete plugin ZIP through [Add your plugin](https://wordpress.org/plugins/developers/add/).
5. Wait for the manual review. Do not create duplicate submissions while the review is pending.
6. Respond to the review email and address any requested changes in the source package.
7. After approval, use the assigned WordPress.org Subversion repository to upload the plugin and `readme.txt`.
8. Confirm that the directory-facing page, installation package, screenshots, author information, and stable tag display correctly.

The GitHub repository is the development and public source location; WordPress.org is the official distribution channel after approval. Keep the stable WordPress.org package synchronized with the maintained source and document each release.

## Versioning rule

Use a higher version for every new release. The repository currently declares `2.0.4`; therefore, the next production release should be `2.0.5` or another higher version after actual changes. A new `v1.0.0` tag created today would be lower than all existing versions and could confuse users, release tooling, and WordPress.org metadata. If a historical first-release marker is required, it should point to a matching historical commit and be clearly labeled as historical rather than current.

## References

[1]: https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/ "WordPress.org Detailed Plugin Guidelines"
[2]: https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/ "WordPress.org Plugin Readmes"
[3]: https://wordpress.org/plugins/developers/add/ "WordPress.org Add your Plugin"
[4]: https://wordpress.org/plugins/developers/readme-validator/ "WordPress.org Readme Validator"
[5]: https://wordpress.org/plugins/developers/ "WordPress.org Developer Information"
