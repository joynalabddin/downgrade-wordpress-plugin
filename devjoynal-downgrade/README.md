# DevJoynal Downgrade – WordPress Core Version Manager

**DevJoynal Downgrade** is a lightweight WordPress plugin for administrators who need to pin WordPress Core to a specific release and then run the normal WordPress update flow. It can be used for a controlled WordPress downgrade, WordPress rollback, reinstall, or upgrade when a theme, plugin, staging environment, or hosting stack requires a particular core version.

> **Important:** A WordPress core version change can affect files, the database, themes, plugins, and security. Create and verify a complete backup before changing versions. Use this plugin only on a staging site first whenever possible.

## Project information

| Field | Value |
|---|---|
| Plugin name | DevJoynal Downgrade |
| Current release | 2.0.4 |
| Author | Joynal Abdin |
| Website | [devjoynal.com](https://devjoynal.com) |
| Tested environment | WordPress 7.1, PHP 8.4 claim supplied by the project owner; live staging UI verified on WordPress 7.1 |
| License | GPL-2.0-or-later |

## What the plugin does

After activation, open **Settings → DevJoynal Downgrade**, enter an exact WordPress release such as `7.0.6`, and save. The plugin changes the update information presented to WordPress so that the selected release is offered through the normal Core Update screen. WordPress downloads the release ZIP from the official WordPress distribution endpoint unless an administrator deliberately enables the custom download URL option.

### Professional features in 2.0.4

| Feature | What it does | Operational benefit |
|---|---|---|
| Exact version pinning | Accepts structured versions such as `7.0.6` and rejects malformed input. | Reduces configuration mistakes. |
| Official release URL builder | Generates a locale-aware WordPress download URL. | Keeps the default path predictable. |
| Custom URL opt-in | Allows a trusted administrator to use a language-specific or controlled ZIP source. | Supports controlled environments while making the risk explicit. |
| Diagnostics panel | Shows effective URL, reachability result, HTTP status, plugin version, locale, and current WordPress version. | Makes pre-update review easier. |
| Reset control | Clears the version pin and custom URL after a nonce and capability check. | Provides a documented return to the standard update channel. |
| Safer update filter | Avoids mutating missing or malformed update objects and preserves the original update response when no target is configured. | Improves resilience on modern WordPress installations. |
| Author panel | Displays the supplied Joynal Abdin portrait and links to `devjoynal.com`. | Provides clear project ownership inside the admin screen. |
| Responsive admin UI | Uses scoped styles and adapts the settings layout for smaller screens. | Makes the workflow more comfortable on laptops and tablets. |
| View details override | Supplies project-owned plugin-information metadata for the `downgrade` slug. | Prevents the details modal from showing unrelated old directory branding. |
| Safe diagnostics requests | Uses safe remote requests, a bounded range probe, GET fallback for servers that reject HEAD, basic HTML-response rejection, and transient caching. | Improves reachability accuracy while reducing SSRF exposure and repeated network overhead. |
| Strict checkbox sanitization | Accepts only explicit enabled values and persists the disabled state. | Prevents a stale custom URL from remaining active. |
| Custom package checksum | Accepts an optional 64-character SHA-256 digest and rejects a mismatched custom package before unpacking. | Reduces custom-source tampering and supply-chain risk. |
| Locale-aware update selection | Selects the matching locale entry and clears partial, bundled, rollback, and no-content package alternatives. | Makes the configured target more deterministic. |

The WordPress Plugins screen may build the **View details** modal from a public directory slug rather than the local Plugin URI. DevJoynal Downgrade 2.0.4 intercepts its own `devjoynal-downgrade` slug and supplies project-owned information, so the modal uses Joynal Abdin, devjoynal.com, DevJoynal Downgrade 2.0.4, and the project’s own description instead of unrelated third-party directory content.

Leaving the target version empty or using **Reset all DevJoynal Downgrade settings** disables the pin. Deactivating the plugin also removes its update filters. The plugin does not replace a backup, staging workflow, security update policy, or compatibility testing process.

## Installation

1. Download the latest `devjoynal-downgrade-*.zip` package from the GitHub Releases page.
2. In WordPress, go to **Plugins → Add New Plugin → Upload Plugin**.
3. Select the ZIP, choose **Install Now**, and activate **DevJoynal Downgrade**.
4. Open **Settings → DevJoynal Downgrade** and confirm that the current WordPress version is displayed.

For a manual installation, extract the ZIP and upload the `devjoynal-downgrade` directory to `/wp-content/plugins/`, then activate it from **Plugins → Installed Plugins**.

## How to downgrade or pin WordPress Core safely

First create a tested backup of both the WordPress files and database. Record the current version, PHP version, active theme, active plugins, and hosting recovery procedure. On a staging copy, open **Settings → DevJoynal Downgrade**, enter the exact target release, and save. Then follow the **Update Core** link shown by WordPress, review the target release, and start the update only after confirming the backup and compatibility plan.

After the change, test the front end, login, editor, forms, media uploads, scheduled jobs, REST API, ecommerce flows, email delivery, and any critical integrations. Check the WordPress Site Health screen and server error logs. When the target is no longer needed, return to **Settings → DevJoynal Downgrade**, empty the target version field, save, and review the standard update channel.

## Custom download URL

The optional custom URL field is intended for an administrator who must use a language-specific package or a controlled mirror. The URL must point to a WordPress ZIP. For production use, enter the package’s 64-character SHA-256 digest in the checksum field; the plugin will reject a mismatched package before WordPress Core unpacks it. Use only a trusted source and test on staging first.

## Additional professional features worth considering

The current safe scope focuses on controlled version management. Future releases could add a dry-run preview that never starts an update, exportable diagnostic reports, an admin-only audit log of setting changes, configurable backup-provider checks, multisite-aware status reporting, and automated compatibility checks against the active PHP version. These features should be implemented only with clear permissions, privacy boundaries, and tests; adding more buttons without reliable workflows would not make the plugin more professional.

## Security and performance audit

The source contains no third-party runtime dependencies, no executable downloads, no arbitrary code execution, and no direct unescaped user-controlled output in the admin view. State-changing reset requests use a capability check and nonce. Settings use the WordPress Settings API sanitization callbacks. Diagnostics use safe HEAD/GET requests with a bounded range probe, five-second timeout, no automatic redirects, basic HTML-response rejection, and a five-minute transient cache keyed by the URL. The optional custom ZIP URL can be protected with a SHA-256 digest and should point only to a trusted WordPress archive.

## Compatibility and testing

The plugin main file passes `php -l` syntax validation in this repository, and the new settings/reset/diagnostics code is written with WordPress capability and nonce checks. The supplied staging site reported **WordPress 7.1** and the plugin was installed and activated successfully; the live settings page loaded and displayed the current WordPress version. PHP 8.4 compatibility is recorded from the project owner’s requirement and should be rechecked on the target host with its actual extensions, filesystem permissions, and update method before production use.

This project is not a promise that every WordPress installation or every PHP 8.4 configuration will behave identically. Test on staging and keep a recovery path.

## SEO and discoverability for this GitHub project

This README uses a descriptive project title, a focused opening summary, task-based headings, exact feature terminology, compatibility information, internal links, and safety guidance. Those practices help users and search engines understand the repository, but **no README, GitHub repository, or agent can guarantee a number-one Google position**. Ranking depends on relevance, originality, technical accessibility, authority, user satisfaction, competition, and many signals outside this repository.

For sustainable discoverability, publish a useful landing page on `devjoynal.com`, link to this repository from that page, keep the repository description and topics accurate, create versioned GitHub Releases, document real compatibility results, avoid keyword stuffing, and earn relevant references from genuine WordPress communities. Add a canonical URL, descriptive page title, unique meta description, readable headings, image alt text, fast hosting, HTTPS, and an XML sitemap on the website. Do not claim compatibility or security properties that have not been tested.

## Bengali quick guide

**DevJoynal Downgrade প্লাগিন ব্যবহার:** প্রথমে সম্পূর্ণ ফাইল ও ডাটাবেস ব্যাকআপ নিন। এরপর **Plugins → Add New Plugin → Upload Plugin** থেকে ZIP আপলোড করে সক্রিয় করুন। **Settings → DevJoynal Downgrade** এ গিয়ে কাঙ্ক্ষিত WordPress সংস্করণ লিখে সেভ করুন। তারপর WordPress-এর **Update Core** পেজে গিয়ে দেখানো সংস্করণটি যাচাই করে আপডেট/রোলব্যাক চালান। কাজ শেষ হলে সাইটের হোমপেজ, লগইন, পোস্ট এডিটর, ফর্ম, মিডিয়া, REST API এবং গুরুত্বপূর্ণ প্লাগিন পরীক্ষা করুন। নির্দিষ্ট সংস্করণ আর প্রয়োজন না হলে সংস্করণ ঘরটি খালি করে সেভ করুন।

**নিরাপত্তা:** লাইভ সাইটে সরাসরি পরীক্ষা না করে staging ব্যবহার করুন। পুরোনো WordPress সংস্করণে নিরাপত্তা ঝুঁকি থাকতে পারে। কাস্টম ZIP URL কেবল বিশ্বস্ত উৎসে ব্যবহার করুন।

## References

[1]: https://developer.wordpress.org/advanced-administration/upgrade/upgrading/ "WordPress Advanced Administration Handbook: Upgrading WordPress"
[2]: https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/ "WordPress Plugin Handbook: How your readme.txt works"
[3]: https://developers.google.com/search/docs/fundamentals/seo-starter-guide "Google Search Central: SEO Starter Guide"
[4]: https://developers.google.com/search/docs/essentials "Google Search Essentials"
