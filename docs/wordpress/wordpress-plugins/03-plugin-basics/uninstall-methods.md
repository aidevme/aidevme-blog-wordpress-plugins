# Uninstall Methods

Reference: <https://developer.wordpress.org/plugins/plugin-basics/uninstall-methods/>

## Overview

WordPress plugins may require cleanup procedures during uninstallation. Deactivation (when a plugin is turned off) is distinct from uninstallation (when it's deleted from the site).

## Key Difference: Deactivation vs. Uninstallation

Deactivation hooks should handle temporary operations like cache clearing, while uninstall procedures should remove persistent data:

- **Deactivation tasks**: Flush cache/temp files and reset permalinks
- **Uninstallation tasks**: Remove database options and drop custom tables

## Two Implementation Approaches

**Method 1 — `register_uninstall_hook()`**: Uses WordPress's built-in function to designate a callback function that executes during plugin deletion.

**Method 2 — `uninstall.php`**: Creates a dedicated file in the plugin's root directory. This approach requires checking for the `WP_UNINSTALL_PLUGIN` constant before executing cleanup operations, protecting against unauthorized direct access.

## Important Consideration

When working with WordPress Multisite installations, developers should be cautious about resource usage when deleting options across multiple sites, as this can consume significant server resources.
