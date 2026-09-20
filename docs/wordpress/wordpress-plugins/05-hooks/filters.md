# Filters

Reference: <https://developer.wordpress.org/plugins/hooks/filters/>

## Overview

Filters represent one of the two Hook types in WordPress development. They enable functions to modify data during WordPress Core, plugin, and theme execution. Unlike Actions, filters are meant to work in an isolated manner, and should never have side effects.

## Adding Filters

Implementation requires two steps:

1. Create a callback function to execute when the filter runs.
2. Register it using `add_filter()` with the hook name and callback function.

### Basic Implementation

The fundamental structure uses two required parameters:

- `string $hook_name`: the filter identifier
- `callable $callback`: your callback function reference

Simple example:

```php
function wporg_filter_title( $title ) {
	return 'The ' . $title . ' was filtered';
}
add_filter( 'the_title', 'wporg_filter_title' );
```

This transforms "Learning WordPress" into "The Learning WordPress was filtered."

### Additional Parameters

The `add_filter()` function accepts two optional parameters:

- `int $priority`: callback execution order
- `int $accepted_args`: number of arguments passed to callback

## Practical Example

Adding CSS classes conditionally:

```php
function wporg_css_body_class( $classes ) {
	if ( ! is_admin() ) {
		$classes[] = 'wporg-is-awesome';
	}
	return $classes;
}
add_filter( 'body_class', 'wporg_css_body_class' );
```
