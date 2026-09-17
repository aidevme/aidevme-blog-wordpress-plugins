# Managing Post Metadata

Reference: <https://developer.wordpress.org/plugins/metadata/managing-post-metadata/>

## Overview

This guide covers the essential operations for handling post metadata in WordPress plugin development, including creation, modification, removal, and special considerations for data integrity.

## Core Operations

### Adding Metadata

The `add_post_meta()` function enables metadata creation with four parameters: post ID, meta key, meta value, and a uniqueness flag.

Meta keys should follow a naming convention combining your plugin or theme identifier with a descriptive term, such as `wporg_featured_menu`. Values can be strings, integers, or arrays — arrays are automatically serialized during storage. The unique flag designates whether a post should have only one value for that key.

### Updating Metadata

Use `update_post_meta()` to modify existing metadata. If the key doesn't exist, the function creates it automatically. An optional `prev_value` parameter allows conditional updates targeting specific existing entries.

### Deleting Metadata

The `delete_post_meta()` function removes metadata by accepting a post ID, meta key, and optionally a specific meta value.

## Special Considerations

### Character Escaping

Post meta values undergo `stripslashes()` processing during storage, potentially corrupting formatted data like JSON with escaped characters. The solution involves applying `wp_slash()` before storage to compensate for this automatic stripping.

### Hidden Custom Fields

Keys prefixed with an underscore (`_`) remain hidden from the post edit screen and `the_meta()` output. Additionally, array-type meta values won't display on edit screens regardless of naming conventions.
