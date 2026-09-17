# Plugin Readmes

Reference: <https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/>

## Overview

To make your entry in the plugin browser most useful, each plugin should have a readme file named `readme.txt` that adheres to the WordPress plugin readme file standard. This file controls the output on the front-facing part of the directory. Writing a description in the readme determines exactly what will be displayed on `wordpress.org/plugins/Your-Plugin`.

You can use a plugin readme generator and put the completed result through the official readme validator to check it.

Since WordPress 5.8, plugin readme files are not parsed for requirements. This means that the headers `Requires PHP` and `Requires at least` are parsed from the plugin's main PHP file instead.

## Section Details

All plugins contain a main PHP file, and almost all plugins have a `readme.txt` file as well. The `readme.txt` file is intended to be written using a subset of markdown.

### Readme Header Information

The plugin readme header consists of this information:

```
=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: https://example.com/
Tags: tag1, tag2
Requires at least: 4.7
Tested up to: 5.4
Stable tag: 4.3
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Here is a short description of the plugin.  This should be no more than 150 characters.  No markup here.
```

- **Contributors** — a case sensitive, comma separated list of all WordPress.org usernames who have contributed to the code. It is generally considered respectful to include the names of people who worked on forked projects, though some developers will ask to be removed from the list. Only use the WordPress.org username — anything else will show up without a profile link and gravatar.
- **Donate link** — (optional) makes a "Donate to this plugin" link in the sidebar. If there is no link, nothing shows up.
- **Tags** — 1 to 5 comma separated terms that describe the plugin. Plugins must refrain from using competitors' plugin names as tags, and should not use tags unique to that plugin, as these will not be shown.
- **Tested up to** — the version of WordPress the plugin has been tested against. This field ignores minor versions, so a plugin only needs to define the major version it is tested against; the directory automatically adds the minor version. Use numbers only, so "4.9" and not "WP 4.9".
- **Requires PHP** — (optional) the required minimum version of PHP needed for use with this plugin. Numbers only, so "7.0" and not "PHP 7.0".
- **Stable Tag** — the stable version of the plugin itself (not the version of WordPress). Use only numbers and periods; SemVer formatting is recommended.
- **License** — the GPLv2 (or later) compatible license used for the plugin.
- **License URI** — (optional) a link to the license; recommended if the plugin uses a more rare license.

At the end of the header section is a place for a short description of the plugin, no more than 150 characters and without markup. That line shows up right under the plugin name; if it's longer than 150 characters it gets cut off.

### Installation

If your plugin has no custom install settings, it's okay to omit this section. If your plugin has custom configuration notes post install, this is a great place to put that information.

### Custom Sections

Custom sections are permitted and supported, but should be used in moderation. People get used to seeing how every other plugin looks, and when yours is different, they may miss important information.

## Technical Details

### How The Readme Is Parsed

WordPress.org's Plugin Directory works based on the information found in the **Stable Tag** field in the readme. When WordPress.org parses the `readme.txt`, the first thing it does is look at the `readme.txt` in the `/trunk` directory, where it reads the "Stable Tag" line.

When the Stable Tag is properly set, WordPress.org looks in `/tags/` for the referenced version. So a Stable Tag of "1.2.3" makes it look for `/tags/1.2.3/`.

The readme.txt in the tag folder must also be properly updated to have the correct "Stable Tag" — failing to do so may cause your plugin to not be updatable.

If the Stable Tag is 1.2.3 and `/tags/1.2.3/` exists, then nothing in trunk will be read any further for parsing by any part of the system. Everything comes from the `readme.txt` in the file pointed to by the Stable Tag.

The WordPress.org Plugin Directory reads the main plugin PHP file to get things like the Name of the plugin, the Plugin URI, and most importantly, the version number. The download button on the plugin page reads "Download Version 1.2.3" or similar — that version number comes from the plugin's main PHP file, not the readme.

The Stable Tag points to a subdirectory in the `/tags` directory, but the version of the plugin is set by the version listed in the plugin's PHP file itself, not the folder name.

Using a stable tag set to `trunk` (rather than a version) still works in the Plugin Directory, but it is neither supported nor recommended as a method of indicating new versions, and has been known to cause issues with automatic updates. WordPress.org actively discourages "Stable Tag: trunk" and prohibits its use for new plugins.

### Videos

You can embed videos from YouTube, Vimeo, and anywhere else WordPress supports by default. Paste the video URL onto its own line in your readme. It's recommended you not have the video as the final line in a FAQ section, as sometimes formatting gets weird.

### Markdown

Readmes use a customized version of Markdown. Most Markdown calls work as expected. Markdown allows for easy linking:

```
[WordPress](http://wordpress.org)
```

Videos can be put into your readme.txt too — a YouTube or Vimeo link on a line by itself will be auto-embedded. It's also possible to embed videos hosted on VideoPress using the wpvideo shortcode.

### Field Details

For those who want to know exactly what gets parsed into what:

- **Authors** — Author field from the plugin header and Contributors field from the readme file.
- **Version** — Version field from the plugin header.
- **Tags** (as in categories) — Tags field from the readme file.
- **Plugin Name** — the Plugin Name from the readme file, falling back on the Plugin Name specified in the plugin header.
- **Author and Plugin Homepages** — the Author URI and Plugin URI fields of the plugin header. The Plugin URI should be unique to each plugin; do not use the same URI for your free and pro plugin.
- **Last updated time** — time of last check in to the appropriate directory after a version number change.
- **Creation time** — time of first check in.

### File Size

While readmes are simple text files, having a file larger than 10k may result in errors. Your readme should be brief and to the point. The description should not be a sales pitch as much as a description of the plugin, what it does, and how to use it. Your install directions should be direct, and your FAQ should actually address issues.

As for your changelog, it's recommended to keep the current release in the readme and split the rest out into its own file — `changelog.txt`, for example. By storing older changelog data there, you keep your readme small.

Similarly, if you need in-depth documentation with inline images and so on, direct people to your own website.

## See Also

- Plugin Headers (found in the main file of the plugin)
