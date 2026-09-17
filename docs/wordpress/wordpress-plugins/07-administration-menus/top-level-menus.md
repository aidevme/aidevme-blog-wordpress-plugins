# Top-Level Menus

Reference: <https://developer.wordpress.org/plugins/administration-menus/top-level-menus/>

## Overview

This page explains how to create, manage, and handle form submissions for top-level WordPress administration menus through plugin development.

## Adding Top-Level Menus

The `add_menu_page()` function creates new top-level menus in the WordPress administration area. Its parameters include the page title, menu title, required user capability, menu slug, callback function, icon URL, and position.

### Implementation Steps

1. Create a callback function that outputs the menu page HTML, wrapped in a `<div class="wrap">` container.
2. Register the menu during the `admin_menu` action hook using `add_menu_page()`.

Example:

```php
add_action( 'admin_menu', 'wporg_options_page' );
function wporg_options_page() {
    add_menu_page(
        'WPOrg',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html',
        plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
        20
    );
}
```

An alternative approach involves passing a PHP file path as the menu slug with a null function parameter, for legacy code patterns.

## Removing Top-Level Menus

Use `remove_menu_page()` to remove a registered menu. This requires timing the removal after the menu has been registered, typically using a higher priority number (like 99) on the `admin_menu` hook.

Menu removal does not prevent direct access to the page — never rely on it for capability restrictions.

## Form Submission Handling

Two key requirements exist for processing form submissions:

1. Set the form action to the menu page URL using `menu_page_url()`.
2. Use the `load-$hookname` action hook for processing, since the page's callback function executes after HTML output has already begun.

The `add_menu_page()` function returns a hook name. WordPress triggers `load-$hookname` before displaying the page content, which allows for header operations like redirects.

Required validation checks:

- Verify the request method is POST.
- Perform CSRF verification using nonces.
- Validate and sanitize all input data.
