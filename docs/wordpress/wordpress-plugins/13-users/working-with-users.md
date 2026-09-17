# Working with Users

Reference: <https://developer.wordpress.org/plugins/users/working-with-users/>

## Overview

This guide covers three primary operations for managing WordPress users:

- Adding Users
- Updating Users
- Deleting Users

## Adding Users

Two functions enable user creation:

**wp_create_user()** — A simplified approach accepting only username, password, and email parameters. It uses `wp_slash()` to escape the values and leverages the `compact()` function internally.

**wp_insert_user()** — A more flexible method accepting an array or object with comprehensive user properties.

### Creating Users

The `wp_create_user()` function streamlines user creation. Here's the recommended workflow:

1. Verify the username isn't already registered
2. Confirm the email address is available
3. Generate a secure password
4. Create the user account

### Inserting Users

The `wp_insert_user()` function triggers filters for predefined properties. When creating new users, it executes the `user_register` action; when modifying existing accounts, it performs the `profile_update` action.

## Updating Users

The `wp_update_user()` function modifies existing user records via the `$userdata` array/object. For updating individual metadata fields, use `update_user_meta()` instead.

Updating a current user's password will clear all authentication cookies.

## Deleting Users

The `wp_delete_user()` function removes users and optionally reassigns their associated content to another user. Without a valid reassignment, all content belonging to the deleted user will be permanently removed. The function executes the `deleted_user` action upon completion.
