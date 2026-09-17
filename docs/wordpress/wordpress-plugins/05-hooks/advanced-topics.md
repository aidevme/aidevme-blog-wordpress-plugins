# Advanced Topics

Reference: <https://developer.wordpress.org/plugins/hooks/advanced-topics/>

## Removing Actions and Filters

There are situations where you need to eliminate a callback function from a hook previously registered by another plugin, theme, or WordPress Core itself.

To do this, call `remove_action()` or `remove_filter()`, depending on whether the callback was originally added as an Action or a Filter.

The parameters passed to `remove_action()` / `remove_filter()` must be identical to the parameters passed to `add_action()` / `add_filter()`, or the removal will fail. Timing also matters significantly — perform the removal only after the original callback was registered.

### Example

Consider optimizing a theme's performance by eliminating an unneeded feature. Suppose a theme's `functions.php` contains:

```php
function wporg_setup_slider() {
	// ...
}
add_action( 'template_redirect', 'wporg_setup_slider', 9 );
```

This slider loads unnecessary resources. Use the `after_setup_theme` hook to remove it after registration:

```php
function wporg_disable_slider() {
	// Make sure all parameters match the add_action() call exactly.
	remove_action( 'template_redirect', 'wporg_setup_slider', 9 );
}
// Make sure we call remove_action() after add_action() has been called.
add_action( 'after_setup_theme', 'wporg_disable_slider' );
```

## Removing All Callbacks

Strip all callback functions from a hook using `remove_all_actions()` or `remove_all_filters()`.

## Determining the Current Hook

When a single callback runs on multiple hooks but needs different behavior per hook, use `current_action()` or `current_filter()`:

```php
function wporg_modify_content( $content ) {
	switch ( current_filter() ) {
		case 'the_content':
			// Do something.
			break;
		case 'the_excerpt':
			// Do something.
			break;
	}
	return $content;
}

add_filter( 'the_content', 'wporg_modify_content' );
add_filter( 'the_excerpt', 'wporg_modify_content' );
```

## Checking How Many Times a Hook Has Run

Hooks sometimes execute multiple times, yet you may want your callback to run only once. Use `did_action()`:

```php
function wporg_custom() {
   // If save_post has been run more than once, skip the rest of the code.
   if ( did_action( 'save_post' ) !== 1 ) {
      return;
   }
   // ...
}
add_action( 'save_post', 'wporg_custom' );
```

## Debugging with the "all" Hook

To trigger a callback on every hook, register it to the `all` hook. This is useful for debugging, to track event timing or identify page failures:

```php
function wporg_debug() {
	echo '<p>' . current_action() . '</p>';
}
add_action( 'all', 'wporg_debug' );
```
