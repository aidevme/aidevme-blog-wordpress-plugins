# Custom Settings Page

Reference: <https://developer.wordpress.org/plugins/settings/custom-settings-page/>

## Overview

Building a custom settings page requires combining three core WordPress concepts: administration menus, the Settings API, and the Options API. It is recommended to review those foundational topics before implementation.

## Complete Example

A full implementation demonstrates how to:

- Create a top-level menu labeled "WPOrg"
- Register a custom option called `wporg_options`
- Implement CRUD operations using the Settings and Options APIs
- Display success and error messages

### Key Functions Demonstrated

**Initialization Function:** `wporg_settings_init()` registers the setting, section, and field using WordPress functions like `register_setting()`, `add_settings_section()`, and `add_settings_field()`.

**Section Callback:** `wporg_section_developers_callback()` outputs descriptive text for the settings section.

**Field Callback:** `wporg_field_pill_cb()` renders a dropdown selection with two options and retrieves stored values via `get_option()`.

**Menu Creation:** `wporg_options_page()` uses `add_menu_page()` to register the administrative interface.

**Page Display:** `wporg_options_page_html()` handles capability checking, displays status messages, renders the form using `settings_fields()` and `do_settings_sections()`, and outputs a save button.

The code emphasizes security through proper escaping and capability verification, following WordPress plugin development best practices.
