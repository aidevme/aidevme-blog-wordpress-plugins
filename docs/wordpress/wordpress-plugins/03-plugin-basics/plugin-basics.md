# Plugin Basics

Reference: <https://developer.wordpress.org/plugins/plugin-basics/>

## Getting Started

To create a plugin, navigate to your WordPress installation's `wp-content/plugins` directory, create a new folder for your plugin, and add a PHP file with a properly formatted plugin header comment. A WordPress plugin is a PHP file with a WordPress plugin header comment.

## Hooks: Actions and Filters

WordPress hooks enable developers to modify functionality without altering core files. There are two hook types: actions (add/change functionality) and filters (alter displayed content). Three essential hooks for plugins are the activation, deactivation, and uninstall hooks.

## WordPress APIs

Leverage built-in APIs rather than writing custom code. Key APIs include the Options API for database storage and the HTTP API for remote requests.

## Plugin Loading

WordPress scans the plugins folder for PHP files containing plugin header comments. Plugins can consist of a single file or reside in dedicated directories.

## Sharing Considerations

Before distributing plugins, developers should select an appropriate license — ideally one compatible with the GNU General Public License (GPLv2+).
