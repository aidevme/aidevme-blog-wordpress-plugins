# Options API

Reference: <https://developer.wordpress.org/plugins/settings/options-api/>

## Overview

The Options API, introduced in WordPress 1.0, enables developers to create, read, update, and delete WordPress options. When paired with the Settings API, it facilitates management of options established through settings pages.

## Storage Location

Options are maintained in the `{$wpdb->prefix}_options` database table, where the prefix originates from the `$table_prefix` variable configured in `wp-config.php`.

## Storage Methods

Options can be persisted in two formats:

### Single Value Storage

Individual option names map to singular values:

```php
add_option('wporg_custom_option', 'hello world!');
$option = get_option('wporg_custom_option');
```

### Array-Based Storage

Option names can reference arrays containing key/value pairs:

```php
$data_r = array('title' => 'hello world!', 1, false);
add_option('wporg_custom_option', $data_r);
$options_r = get_option('wporg_custom_option');
echo esc_html($options_r['title']);
```

When you store or retrieve an array of options, it happens in a single transaction, which is ideal. Storing related options as arrays minimizes database transactions compared to individual option retrieval.

## Core Functions

- Add — `add_option()` (single-site), `add_site_option()` (multi-site)
- Retrieve — `get_option()` (single-site), `get_site_option()` (multi-site)
- Update — `update_option()` (single-site), `update_site_option()` (multi-site)
- Remove — `delete_option()` (single-site), `delete_site_option()` (multi-site)
