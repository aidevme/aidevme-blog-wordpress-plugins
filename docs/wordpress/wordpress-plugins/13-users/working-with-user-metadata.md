# Working with User Metadata

Reference: <https://developer.wordpress.org/plugins/users/working-with-user-metadata/>

## Introduction

WordPress' users table was designed to store only essential user information. As of WP 4.7, it contains: ID, user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, and display_name.

To accommodate additional data storage, the usermeta table was created. This table maintains a one-to-many relationship with the users table based on the user ID, allowing developers to store arbitrary amounts of user information.

## Manipulating User Metadata

There are two primary approaches for managing user metadata:

1. Form Field Method — Adding fields to the user profile screen in the WordPress admin
2. Programmatic Method — Using function calls to manage metadata directly

### Form Field Approach

This method suits scenarios where users have WordPress admin access and can view/edit their profiles.

Key hooks:

- **show_user_profile** — Fires when a user edits their own profile (requires edit capability)
- **edit_user_profile** — Fires when a user edits another user's profile (requires appropriate capability)

A common example implementation is a birthday field that:

- Displays an input field on user profile screens
- Validates date format using HTML5 pattern matching
- Saves data using the `update_user_meta()` function
- Includes permission checks via `current_user_can()`

### Programmatic Approach

This method works for custom user interfaces and scenarios where admin panel access is restricted.

Available functions:

- `add_user_meta()` — Creates new metadata entries
- `update_user_meta()` — Modifies existing metadata
- `delete_user_meta()` — Removes metadata entries
- `get_user_meta()` — Retrieves metadata (returns all metadata as an associative array when only user_id is provided)
