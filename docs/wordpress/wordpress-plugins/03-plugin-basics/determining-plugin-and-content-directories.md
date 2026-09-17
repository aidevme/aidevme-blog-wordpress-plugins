# Determining Plugin and Content Directories

Reference: <https://developer.wordpress.org/plugins/plugin-basics/determining-plugin-and-content-directories/>

## Overview

WordPress developers need reliable methods to reference files and folders throughout installations. The platform provides built-in functions rather than requiring hard-coded paths.

## Key Principle

Always use these functions in your plugins instead of hard-coding references to the wp-content directory or using the WordPress internal constants.

Users can relocate and rename the wp-content directory, so developers shouldn't assume standard directory structures. Additionally, symlinked directories won't work with hard-coded paths.

## Common Usage Example

For JavaScript or CSS files within plugins, use `plugins_url()`:

```php
plugins_url( 'myscript.js', __FILE__ );
```

This returns the complete URL path. Pair this with `wp_enqueue_script()` or `wp_enqueue_style()` to properly load assets.

## Available Functions by Category

**Plugins**: `plugins_url()`, `plugin_dir_url()`, `plugin_dir_path()`, `plugin_basename()`

**Themes**: `get_template_directory_uri()`, `get_stylesheet_directory_uri()`, `get_theme_root()`, and related functions

**Site Home**: `home_url()`, `get_home_path()`

**WordPress Core**: `admin_url()`, `site_url()`, `content_url()`, `includes_url()`, `wp_upload_dir()`

**Multisite**: `get_admin_url()`, `get_home_url()`, `get_site_url()`, `network_admin_url()`, and related functions

## Internal Constants

WordPress uses constants like `WP_CONTENT_DIR`, `WP_PLUGIN_DIR`, and `UPLOADS`, but these shouldn't be used directly by plugins or themes.
