# Registering Custom Post Types

Reference: <https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/>

## Overview

WordPress includes five built-in post types: `post`, `page`, `attachment`, `revision`, and `menu`. When building plugins, developers often need to create domain-specific content types such as products, assignments, or movies.

Custom post types enable developers to register new content categories that receive dedicated administrative screens for creation and management. The `register_post_type()` function handles this registration.

Implement custom post types within plugins rather than themes to maintain content portability when themes are changed.

### Basic Implementation Example

```php
function wporg_custom_post_type() {
	register_post_type('wporg_product',
		array(
			'labels'      => array(
				'name'          => __('Products', 'textdomain'),
				'singular_name' => __('Product', 'textdomain'),
			),
			'public'      => true,
			'has_archive' => true,
		)
	);
}
add_action('init', 'wporg_custom_post_type');
```

Register custom post types using the `init` hook, which falls appropriately between `after_setup_theme` and `admin_init`.

## Naming Best Practices

Prefix all post type identifiers with a unique prefix representing your plugin or theme. Keep identifiers under 20 characters since the database column has this limitation. Avoid the `wp_` prefix reserved for WordPress core. Generic identifiers risk conflicts with other plugins — duplicate identifiers cannot coexist without disabling conflicting implementations.

## URLs

Custom post types receive unique URL structures. By default, a `wporg_product` post type generates URLs like `http://example.com/wporg_product/%product_name%`, with the final permalink appearing as `http://example.com/wporg_product/wporg-is-awesome`.

### A Custom Slug for a Custom Post Type

To modify the URL slug, add a `rewrite` parameter:

```php
function wporg_custom_post_type() {
	register_post_type('wporg_product',
		array(
			'labels'      => array(
				'name'          => __( 'Products', 'textdomain' ),
				'singular_name' => __( 'Product', 'textdomain' ),
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'products' ),
		)
	);
}
add_action('init', 'wporg_custom_post_type');
```

This produces URLs like `http://example.com/products/%product_name%`. Unlike post type identifiers, slug conflicts can be resolved by updating one post type's slug value.
