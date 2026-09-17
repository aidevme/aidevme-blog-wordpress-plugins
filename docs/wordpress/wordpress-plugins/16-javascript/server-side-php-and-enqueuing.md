# Server Side PHP and Enqueuing

Reference: <https://developer.wordpress.org/plugins/javascript/enqueuing/>

## Overview

The server-side implementation of AJAX in WordPress requires two essential components: enqueuing jQuery scripts with localized data, and creating handlers to process AJAX requests.

## Enqueue Script

The `wp_enqueue_script()` function registers scripts for proper inclusion in page headers. It accepts parameters for handle, source URL, dependencies, version, and loading arguments. Scripts must be enqueued through appropriate action hooks: `admin_enqueue_scripts` for admin pages, `wp_enqueue_scripts` for frontend, or `login_enqueue_scripts` for login pages.

All AJAX requests route through `wp-admin/admin-ajax.php`, never directly to plugin pages.

## Nonce Security

Creating a nonce using `wp_create_nonce()` protects against unauthorized requests. The function parameter can be any string, ideally descriptive of its purpose.

## Localization

The `wp_localize_script()` function creates global JavaScript objects containing PHP-generated data, such as the nonce and admin-ajax URL. This enables secure communication between PHP and jQuery scripts.

## AJAX Action Handlers

AJAX handlers use WordPress action hooks. Logged-in users trigger `wp_ajax_[action]` hooks, while unauthenticated users trigger `wp_ajax_nopriv_[action]` hooks. Handlers must verify nonces using `check_ajax_referer()` before processing data.

## Response Formats

- **JSON** - Use `wp_send_json()` or specialized success/error variants
- **XML** - Implement the `WP_Ajax_Response` class
- **Custom** - Plain text or HTML output

All handlers must call `wp_die()` upon completion.
