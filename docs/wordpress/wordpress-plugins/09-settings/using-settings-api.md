# Using Settings API

Reference: <https://developer.wordpress.org/plugins/settings/using-settings-api/>

## Adding Settings

To establish a new setting, use the `register_setting()` function, which generates an entry in the WordPress options table. Additional sections can be incorporated into existing pages via `add_settings_section()`, and new fields can be added to those sections using `add_settings_field()`. All of these functions should be attached to the `admin_init` action hook.

### Add a Setting

```php
register_setting(string $option_group, string $option_name, array $args = []);
```

### Add a Section

```php
add_settings_section(string $id, string $title, callable $callback, string $page, array $args = []);
```

Sections group related settings beneath shared headings. Rather than creating entirely new pages, you can add new sections to existing settings pages within your plugin, simplifying maintenance and reducing user confusion.

### Add a Field

```php
add_settings_field(
    string $id,
    string $title,
    callable $callback,
    string $page,
    string $section = 'default',
    array $args = []
);
```

### Example

A complete implementation demonstrates registering a setting, section, and field on the reading page with appropriate callbacks for rendering.

## Getting Settings

```php
get_option(string $option, mixed $default = false);
```

Use `get_option()` to retrieve settings, providing the option name and an optional default value.

### Example

```php
$setting = get_option('wporg_setting_name');
```
