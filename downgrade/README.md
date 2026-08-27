# Downgrade – WordPress Core Version Manager

**Downgrade** is a lightweight WordPress plugin for administrators who need to pin WordPress Core to a specific release and then run the normal WordPress update flow. It can be used for a controlled WordPress downgrade, WordPress rollback, reinstall, or upgrade when a theme, plugin, staging environment, or hosting stack requires a particular core version.

> **Important:** A WordPress core version change can affect files, the database, themes, plugins, and security. Create and verify a complete backup before changing versions. Use this plugin only on a staging site first whenever possible.

## Project information

| Field | Value |
|---|---|
| Plugin name | Downgrade |
| Current release | 1.2.6 |
| Author | Joynal Abdin |
| Website | [devjoynal.com](https://devjoynal.com) |
| Tested environment | WordPress 7.1, PHP 8.4 claim supplied by the project owner; live staging UI verified on WordPress 7.1 |
| License | GPL-2.0-or-later |

## What the plugin does

After activation, open **Settings → Downgrade**, enter an exact WordPress release such as `7.0.6`, and save. The plugin changes the update information presented to WordPress so that the selected release is offered through the normal Core Update screen. WordPress downloads the release ZIP from the official WordPress distribution endpoint unless an administrator deliberately enables the custom download URL option.

Leaving the target version empty disables the pin. Deactivating the plugin also removes its update filters. The plugin does not replace a backup, staging workflow, security update policy, or compatibility testing process.

## Installation

1. Download the latest `downgrade-*.zip` package from the GitHub Releases page.
2. In WordPress, go to **Plugins → Add New Plugin → Upload Plugin**.
3. Select the ZIP, choose **Install Now**, and activate **Downgrade**.
4. Open **Settings → Downgrade** and confirm that the current WordPress version is displayed.

For a manual installation, extract the ZIP and upload the `downgrade` directory to `/wp-content/plugins/`, then activate it from **Plugins → Installed Plugins**.

## How to downgrade or pin WordPress Core safely

First create a tested backup of both the WordPress files and database. Record the current version, PHP version, active theme, active plugins, and hosting recovery procedure. On a staging copy, open **Settings → Downgrade**, enter the exact target release, and save. Then follow the **Update Core** link shown by WordPress, review the target release, and start the update only after confirming the backup and compatibility plan.

After the change, test the front end, login, editor, forms, media uploads, scheduled jobs, REST API, ecommerce flows, email delivery, and any critical integrations. Check the WordPress Site Health screen and server error logs. When the target is no longer needed, return to **Settings → Downgrade**, empty the target version field, save, and review the standard update channel.

## Custom download URL

The optional custom URL field is intended for an administrator who must use a language-specific package or a controlled mirror. The URL must point to a WordPress ZIP, and the plugin does not verify that the remote archive contains a genuine WordPress release. Use this option only with a trusted source and verify the archive independently.

## Compatibility and testing

The plugin main file passes `php -l` syntax validation in this repository. The supplied staging site reported **WordPress 7.1** and the plugin was installed and activated successfully; the live settings page loaded and displayed the current WordPress version. PHP 8.4 compatibility is recorded from the project owner’s requirement and should be rechecked on the target host with its actual extensions, filesystem permissions, and update method before production use.

This project is not a promise that every WordPress installation or every PHP 8.4 configuration will behave identically. Test on staging and keep a recovery path.

## SEO and discoverability for this GitHub project

This README uses a descriptive project title, a focused opening summary, task-based headings, exact feature terminology, compatibility information, internal links, and safety guidance. Those practices help users and search engines understand the repository, but **no README, GitHub repository, or agent can guarantee a number-one Google position**. Ranking depends on relevance, originality, technical accessibility, authority, user satisfaction, competition, and many signals outside this repository.

For sustainable discoverability, publish a useful landing page on `devjoynal.com`, link to this repository from that page, keep the repository description and topics accurate, create versioned GitHub Releases, document real compatibility results, avoid keyword stuffing, and earn relevant references from genuine WordPress communities. Add a canonical URL, descriptive page title, unique meta description, readable headings, image alt text, fast hosting, HTTPS, and an XML sitemap on the website. Do not claim compatibility or security properties that have not been tested.

## Bengali quick guide

**Downgrade প্লাগিন ব্যবহার:** প্রথমে সম্পূর্ণ ফাইল ও ডাটাবেস ব্যাকআপ নিন। এরপর **Plugins → Add New Plugin → Upload Plugin** থেকে ZIP আপলোড করে সক্রিয় করুন। **Settings → Downgrade** এ গিয়ে কাঙ্ক্ষিত WordPress সংস্করণ লিখে সেভ করুন। তারপর WordPress-এর **Update Core** পেজে গিয়ে দেখানো সংস্করণটি যাচাই করে আপডেট/রোলব্যাক চালান। কাজ শেষ হলে সাইটের হোমপেজ, লগইন, পোস্ট এডিটর, ফর্ম, মিডিয়া, REST API এবং গুরুত্বপূর্ণ প্লাগিন পরীক্ষা করুন। নির্দিষ্ট সংস্করণ আর প্রয়োজন না হলে সংস্করণ ঘরটি খালি করে সেভ করুন।

**নিরাপত্তা:** লাইভ সাইটে সরাসরি পরীক্ষা না করে staging ব্যবহার করুন। পুরোনো WordPress সংস্করণে নিরাপত্তা ঝুঁকি থাকতে পারে। কাস্টম ZIP URL কেবল বিশ্বস্ত উৎসে ব্যবহার করুন।

## References

[1]: https://developer.wordpress.org/advanced-administration/upgrade/upgrading/ "WordPress Advanced Administration Handbook: Upgrading WordPress"
[2]: https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/ "WordPress Plugin Handbook: How your readme.txt works"
[3]: https://developers.google.com/search/docs/fundamentals/seo-starter-guide "Google Search Central: SEO Starter Guide"
[4]: https://developers.google.com/search/docs/essentials "Google Search Essentials"
