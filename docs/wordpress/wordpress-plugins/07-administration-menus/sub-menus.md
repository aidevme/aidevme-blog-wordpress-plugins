# Sub-Menus

Reference: <https://developer.wordpress.org/plugins/administration-menus/sub-menus/>

## Overview

This page explains how to create, manage, and handle sub-menus in the WordPress administration panel.

## Adding Sub-Menus

The primary function for creating sub-menus is `add_submenu_page()`, which accepts parameters including the parent slug, page title, menu title, required user capability, menu slug, and an optional callback function.

### Implementation Example

A common example adds a "WPOrg Options" submenu to the Tools menu. This involves:

1. Creating an output function that handles security checks and renders options using the Settings API.
2. Registering the submenu via the `admin_menu` action hook.

The output function typically wraps its content in a `<div class="wrap">` and implements proper security fields with `settings_fields()`.

## Predefined Sub-Menu Helper Functions

WordPress offers convenience functions for common areas, eliminating the need to manually look up the parent slug:

- Dashboard, Posts, Media, Pages, Comments, Themes, Plugins, Users, Tools, Settings, and Links menus each have dedicated helper functions.
- Custom post types use the format `edit.php?post_type=custom_type`.

## Removal and Form Handling

Removing sub-menus follows the same process as removing top-level menus. Form submission handling leverages the `$hookname` value returned by `add_submenu_page()`, combined with the `load-` hook prefix, while still requiring proper CSRF verification and data sanitization.
