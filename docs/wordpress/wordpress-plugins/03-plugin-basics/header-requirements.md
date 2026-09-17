# Header Requirements

Reference: <https://developer.wordpress.org/plugins/plugin-basics/header-requirements/>

## Overview

WordPress plugins require a header comment in the main PHP file to identify the plugin and provide metadata. The minimum requirement is specifying a Plugin Name, though additional fields enhance functionality and user experience.

## Minimum Required Field

Every plugin must include at least:

```php
/*
 * Plugin Name: YOUR PLUGIN NAME
 */
```

## Available Header Fields

- **Plugin Name** (required): Displayed in the WordPress admin plugins list
- **Plugin URI**: Unique homepage URL for the plugin
- **Description**: Brief overview under 140 characters
- **Version**: Current release number
- **Requires at least**: Minimum WordPress version compatibility
- **Requires PHP**: Minimum PHP version needed
- **Author**: Creator name(s)
- **Author URI**: Creator's website or profile
- **License**: License type identifier (e.g., GPLv2)
- **License URI**: Link to full license text
- **Text Domain**: Gettext translation identifier
- **Domain Path**: Translation file location
- **Network**: Multi-site activation setting
- **Update URI**: Prevents accidental overwrites from similarly-named plugins
- **Requires Plugins**: Dependencies listed as comma-separated slugs

## Practical Example

A complete header demonstrates proper formatting with all fields:

```php
/*
 * Plugin Name: My Basics Plugin
 * Version: 1.10.3
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * License: GPL v2 or later
 */
```

## Version Numbering Note

WordPress relies on PHP's `version_compare()` function for version comparison, so 1.02 is actually greater than 1.1 according to that function's logic.
