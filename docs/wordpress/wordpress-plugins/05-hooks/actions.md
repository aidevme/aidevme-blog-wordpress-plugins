# Actions

Reference: <https://developer.wordpress.org/plugins/hooks/actions/>

## Overview

Actions are one of the two types of Hooks. They provide a way for running a function at a specific point in the execution of WordPress Core, plugins, and themes. Callback functions for an Action do not return anything back to the calling Action hook. They are the counterpart to Filters.

## Adding an Action

Adding an action is a two-step process.

**1. Create a callback function.** This function runs when the action it is hooked to fires. The callback function is just like a normal function: it should be prefixed, and it should be in `functions.php` or somewhere callable. Its parameters are defined by the action you're hooking to — review the hooks docs to see what parameters a given action passes to your function.

**2. Assign (hook) your callback function.** Use `add_action()` to hook your callback function to the action you've selected. At a minimum, `add_action()` requires two parameters: `$hook_name` (the name of the action you're hooking to) and `$callback` (the name of your callback function).

The example below runs `wporg_callback()` when the `init` hook is executed:

```php
function wporg_callback() {
    // do something
}
add_action( 'init', 'wporg_callback' );
```

## Additional Parameters

`add_action()` can also accept `$priority` (an integer for the callback's priority) and `$accepted_args` (an integer for the number of arguments passed to the callback function).

### Priority

Many callback functions can be hooked to a single action, and WordPress determines their run order in two ways.

First, by manually setting the priority via the third argument to `add_action()`:

- Priorities are positive integers, typically between 1 and 20.
- The default priority (when none is supplied) is 10.
- There is no theoretical upper limit, but the realistic upper limit is around 100.
- A function with priority 11 runs after one with priority 10; a function with priority 9 runs before one with priority 10.

Second, when two callbacks share the same priority on the same hook, they run in the order they were registered. For example:

```php
add_action('init', 'wporg_callback_run_me_late', 11);
add_action('init', 'wporg_callback_run_me_normal');
add_action('init', 'wporg_callback_run_me_early', 9);
add_action('init', 'wporg_callback_run_me_later', 11);
```

Here, `wporg_callback_run_me_early()` runs first (priority 9), then `wporg_callback_run_me_normal()` (default priority 10), then `wporg_callback_run_me_late()` (priority 11), and finally `wporg_callback_run_me_later()` — also priority 11, but registered after `wporg_callback_run_me_late()`.

### Number of Arguments

Sometimes a callback function needs extra data related to the action being hooked to. For example, when WordPress saves a post and runs the `save_post` hook, it passes two parameters — the post ID and the post object:

```php
do_action( 'save_post', $post->ID, $post );
```

To receive those parameters, tell `add_action()` to expect them via the fourth argument, and update your callback's signature to match:

```php
add_action('save_post', 'wporg_custom', 10, 2);
function wporg_custom( $post_id, $post ) {
    // do something
}
```

It's good practice to give your callback function's parameters the same names as the passed parameters, or as close as possible.
