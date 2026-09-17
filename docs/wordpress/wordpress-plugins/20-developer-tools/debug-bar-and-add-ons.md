# Debug Bar and Add-Ons

Reference: <https://developer.wordpress.org/plugins/developer-tools/debug-bar-and-add-ons/>

## Overview

The Debug Bar is a plugin that adds a debug menu to the admin bar that shows query, cache, and other helpful debugging information.

## Main Tools

**Debug Bar** — The foundational plugin providing base debugging functionality. It tracks PHP warnings and notices when `WP_DEBUG` is enabled, and monitors MySQL queries when `SAVEQUERIES` is active.

**Debug Bar Console** — Enables developers to execute arbitrary PHP code for variable testing and experimentation.

**Debug Bar Shortcodes** — Displays registered shortcodes, their associated functions, usage locations, and parameters.

**Debug Bar Constants** — Provides three panels showing WP constants, WP class constants, and PHP constants available during requests.

**Debug Bar Post Types** — Shows detailed information about registered post types on your site.

**Debug Bar Cron** — Displays WordPress scheduled events, including event counts, next execution times, and available schedules.

**Debug Bar Actions and Filters Addon** — Shows hooks attached to the current request, displaying actions and filters with their associated functions and priorities.

**Debug Bar Transients** — Lists existing transients, both custom and core, with deletion options.

**Debug Bar List Script & Style Dependencies** — Displays loaded scripts and styles with their load order and dependencies.

**Debug Bar Remote Requests** — Profiles HTTP API requests, showing methods, URLs, timing, and request counts.
