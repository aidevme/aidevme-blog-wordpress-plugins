# Shortcodes with Parameters

Reference: <https://developer.wordpress.org/plugins/shortcodes/shortcodes-with-parameters/>

## Overview

This guide builds on previous shortcode knowledge to demonstrate how to implement parameters — called "attributes" — in WordPress shortcodes.

## Shortcode Structure with Attributes

Shortcodes can accept attributes within square brackets:

```
[wporg title="WordPress.org"]
Having fun with WordPress.org shortcodes.
[/wporg]
```

The handler function receives three parameters:

- `$atts` — an array containing the shortcode's attributes
- `$content` — a string with text between opening and closing tags
- `$tag` — a string identifying the shortcode name

## Parsing Attributes Best Practices

Since users may include varying numbers of attributes, developers should:

- Establish default parameters in the handler function
- Normalize attribute key cases using `array_change_key_case()`
- Use `shortcode_atts()` to merge defaults with user-provided values
- Secure the output before returning it

## Practical Implementation

The documentation provides a complete `[wporg]` shortcode example that:

- Accepts an optional title attribute (defaults to "WordPress.org")
- Displays content within a styled box wrapper
- Applies WordPress content filters for security
- Handles both self-closing and enclosing tag scenarios

The code demonstrates proper escaping with `esc_html()` and filter application to ensure safe output rendering.
