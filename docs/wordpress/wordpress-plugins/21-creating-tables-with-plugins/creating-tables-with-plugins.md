# Creating Tables with Plugins

Reference: <https://developer.wordpress.org/plugins/creating-tables-with-plugins/>

## Overview

WordPress plugin developers often need to store information in the database. There are two storage types:

- **Setup information**: user configuration choices stored via the WordPress options mechanism
- **Data**: expanding information like statistics, requiring separate MySQL/MariaDB tables

The guide recommends three steps for automatic table creation:

1. Write a PHP function that creates the table
2. Ensure WordPress calls it during plugin activation
3. Create an upgrade function for structural changes in new versions

## Key Implementation Steps

### Database Table Prefix

Developers must access the database prefix via `$wpdb->prefix` to construct proper table names, accommodating custom WordPress configurations.

### Table Creation Requirements

The `dbDelta()` function handles table creation with specific formatting requirements: each field on separate lines, two spaces before PRIMARY KEY definitions, uppercase SQL keywords, and lowercase field types.

### Initial Data Population

Use `$wpdb->insert()` to add default data. The method automatically escapes values, enhancing security compared to direct query execution.

### Version Tracking

Store a version option using `add_option()` to manage future database structure modifications.

### Activation Hooks

Register the installation function with `register_activation_hook()` to trigger setup when administrators enable the plugin.

## Upgrade Management

Since WordPress 3.1, activation hooks don't trigger during updates. Developers should check database versions on the `plugins_loaded` hook and manually call upgrade functions when needed.

## Recommended Alternatives

Before creating custom tables, consider using WordPress Post Meta for simpler data structures, as it's the preferred approach when practical.
