# Actions

Reference: <https://developer.wordpress.org/plugins/hooks/actions/>

## Overview

Actions are one of the two types of Hooks. They enable functions to execute at specific WordPress execution points. Unlike Filters, callback functions for an Action do not return anything back to the calling Action hook.

## Creating a Callback Function

Develop a standard function with proper prefixing, typically placed in `functions.php`. The function's parameters depend on the specific action being hooked; documentation should specify what data each action passes.

## Hooking Your Function

Use `add_action()` with two required parameters:

- `$hook_name`: the action identifier
- `$callback`: your function name

Basic example:

```php
function wporg_callback() {
    // do something
}
add_action( 'init', 'wporg_callback' );
```

## Priority Control

The third parameter controls execution order. The default priority is 10, with lower numbers executing earlier. WordPress runs callbacks by priority level, then by registration order within the same priority.

## Accepting Arguments

The fourth parameter specifies how many arguments your function receives. For instance, the `save_post` hook passes the post ID and the post object:

```php
add_action('save_post', 'wporg_custom', 10, 2);
function wporg_custom( $post_id, $post ) {
    // do something
}
```
