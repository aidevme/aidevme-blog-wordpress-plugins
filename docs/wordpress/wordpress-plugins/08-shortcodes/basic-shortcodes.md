# Basic Shortcodes

Reference: <https://developer.wordpress.org/plugins/shortcodes/basic-shortcodes/>

## Overview

This article covers three fundamental operations for WordPress shortcodes:

- Add a Shortcode
- Remove a Shortcode
- Check if a Shortcode Exists

## Add a Shortcode

The Shortcode API enables developers to create custom shortcodes by registering a callback function to a shortcode tag using `add_shortcode()`. The function signature accepts a tag name and a callable function:

```php
add_shortcode(
    string $tag,
    callable $func
);
```

Example implementation creates a `[wporg]` shortcode that triggers the `wporg_shortcode` callback:

```php
add_shortcode('wporg', 'wporg_shortcode');
function wporg_shortcode( $atts = [], $content = null) {
    // do something to $content
    // always return
    return $content;
}
```

## Remove a Shortcode

Shortcodes can be unregistered using the `remove_shortcode()` function, which requires only the tag name as a parameter:

```php
remove_shortcode(
    string $tag
);
```

Ensure the shortcode has been registered before removal. Use a higher priority number with `add_action()` or hook into later-executing action hooks to guarantee proper timing.

## Check if a Shortcode Exists

Use the `shortcode_exists()` function to verify whether a particular shortcode has been registered in the system.
