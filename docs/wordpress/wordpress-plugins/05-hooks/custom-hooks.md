# Custom Hooks

Reference: <https://developer.wordpress.org/plugins/hooks/custom-hooks/>

## Overview

An often-overlooked best practice involves implementing custom hooks within plugins to enable other developers to extend and modify functionality. Custom hooks function identically to WordPress Core hooks.

## Creating a Hook

To establish a custom hook, use `do_action()` for Actions and `apply_filters()` for Filters. It's recommended to use `apply_filters()` on any text output to the browser, particularly on the frontend, as this makes it easier for other developers to customize the plugin's behavior according to user requirements.

## Adding Callbacks

To attach a callback function to a custom hook, use `add_action()` for Actions or `add_filter()` for Filters, just as you would with a WordPress Core hook.

## Avoiding Naming Conflicts

Naming conflicts occur when multiple developers use identical hook names for different purposes, creating difficult-to-diagnose bugs. The solution is to prefix hook names with a unique identifier. For instance, rather than using a generic name like `email_body`, a prefix such as `wporg_` should precede the hook name. Choose a prefix based on your company name, WordPress handle, or plugin name to ensure uniqueness across the ecosystem.

## Practical Examples

### Extensible Action: Settings Form

Plugins can use Actions to permit other plugins to contribute settings to administrative forms:

```php
do_action( 'wporg_after_settings_page_html' );
```

Other plugins can then hook into this action without returning any values.

### Extensible Filter: Custom Post Type

Filters allow modification of parameters before post type registration:

```php
function wporg_create_post_type() {
    $post_type_params = [/* ... */];
    register_post_type(
        'post_type_slug',
        apply_filters( 'wporg_post_type_params', $post_type_params )
    );
}
```

Callback functions hooked to a filter should receive, modify, and return the data without producing direct screen output.
