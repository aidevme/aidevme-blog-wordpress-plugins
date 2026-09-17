# Working with Custom Post Types

Reference: <https://developer.wordpress.org/plugins/post-types/working-with-custom-post-types/>

## Overview

This guide covers three primary approaches for managing custom post types in WordPress development.

## Custom Post Type Templates

WordPress allows developers to create specialized template files for custom post types using the naming convention `single-{post_type}.php` and `archive-{post_type}.php`, where the placeholder represents your custom post type identifier.

For example, a product post type would use `single-wporg_product.php` for individual items and `archive-wporg_product.php` for listing pages.

Alternatively, template files can incorporate the `is_post_type_archive()` function to detect archive pages and `post_type_archive_title()` to display appropriate headings.

## Querying by Post Type

Custom post types can be retrieved using the `WP_Query` class by specifying the `post_type` parameter in the arguments array. This approach allows developers to filter and display posts of a specific type with customizable pagination and display options.

## Altering the Main Query

Custom post types don't automatically appear in default archives or homepage displays. The `pre_get_posts` action hook enables developers to modify the main query, allowing custom post type content to be mixed with standard posts on archive pages or homepage feeds.

This technique proves valuable when you want custom content integrated with existing post types throughout your site.
