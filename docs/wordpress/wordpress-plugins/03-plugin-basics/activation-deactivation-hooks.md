# Activation / Deactivation Hooks

Reference: <https://developer.wordpress.org/plugins/plugin-basics/activation-deactivation-hooks/>

## Overview

Activation and deactivation hooks enable plugins to execute specific routines when activated or deactivated. During activation, plugins can establish rewrite rules, create database tables, or initialize default settings. Upon deactivation, they can clean up temporary data like cache files.

## Key Distinction

The deactivation hook differs from the uninstall hook. While deactivation handles temporary cleanup, the uninstall hook is designed to delete all data permanently, such as plugin options and custom tables.

## Setup Functions

**Activation Hook:**

```php
register_activation_hook( __FILE__, 'pluginprefix_function_to_run' );
```

**Deactivation Hook:**

```php
register_deactivation_hook( __FILE__, 'pluginprefix_function_to_run' );
```

The first parameter must reference your main plugin file containing the plugin header. These functions typically execute from the main plugin file, though if placed elsewhere, update the path accordingly.

## Practical Example

A common activation use case involves flushing WordPress permalinks after registering a custom post type to prevent 404 errors. The activation function registers the post type and clears rewrite rules, while the deactivation function unregisters the post type and refreshes rules to remove database entries.
