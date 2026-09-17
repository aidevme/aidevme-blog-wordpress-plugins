# Best Practices

Reference: <https://developer.wordpress.org/plugins/plugin-basics/best-practices/>

## Overview

This guide addresses core organizational strategies to ensure WordPress plugins coexist effectively with WordPress core and other extensions.

## Preventing Naming Collisions

**The Problem:** Multiple plugins can accidentally use identical variable, function, or class names, causing conflicts.

### Procedural Coding Approach

**Prefix Everything:** All globally-accessible code requires a distinctive prefix to prevent conflicts. Use at least 4-5 character prefixes that are unique to your plugin, avoiding common English words.

Examples include `ecpt_save_post()`, `define( 'ECPT_LICENSE', true )`, or `class ECPT_Admin{}`.

**Critical restriction:** Do not use WordPress core prefixes like `wp_`, `__`, `WordPress`, or single underscores as standalone function/class names.

**Verify Existing Code:** PHP functions like `function_exists()`, `class_exists()`, `isset()`, and `defined()` can check whether entities already exist before creating them.

### Object-Oriented Programming Approach

Using classes simplifies namespace management. While you still need to verify class names aren't already taken, PHP handles most collision prevention automatically.

## File Organization

The root directory should contain only `plugin-name.php` and optionally `uninstall.php`. All other files belong in subfolders organized by function (languages, includes, admin, public, etc.).

## Plugin Architecture

**Conditional Loading:** Separate administrative code from public-facing code using `is_admin()` conditionals, though capability checks remain necessary.

**Security:** Disallow access if the `ABSPATH` global is not defined at the file's top level.

**Patterns:** Three primary organizational approaches exist — single file with functions, single file with classes, or main file with separate class files.

## Boilerplate Resources

Pre-built frameworks like WordPress Plugin Boilerplate, WordPress Plugin Bootstrap, and WP Skeleton Plugin provide consistent starting points for development.
