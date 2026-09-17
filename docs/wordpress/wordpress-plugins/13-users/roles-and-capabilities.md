# Roles and Capabilities

Reference: <https://developer.wordpress.org/plugins/users/roles-and-capabilities/>

## Overview

WordPress implements two key user management features: roles and capabilities. These control user privileges by determining what users can see and do within their dashboard and across the site.

## Roles

A role represents a collection of permissions assigned to users. WordPress includes six default roles:

- Super Admin
- Administrator
- Editor
- Author
- Contributor
- Subscriber

### Adding Custom Roles

The `add_role()` function creates new roles with assigned capabilities. However, sequential calls will do nothing, including modifications to capability lists. To update capabilities, you must remove and recreate the role.

### Removing Roles

Use `remove_role()` to delete roles from the database. Avoid removing the Administrator and Super Admin roles, and update the default role setting if removing the Subscriber role.

## Capabilities

Capabilities define specific actions — such as editing or publishing posts — that roles can perform. Custom capabilities can be assigned to roles even if they don't affect the default WordPress dashboard.

### Managing Capabilities

Add capabilities using `get_role()` combined with the `add_cap()` method. Remove them similarly using `remove_cap()`.

## Checking Permissions

Three functions check user permissions:

- **get_role()**: Retrieves a role object with its capabilities
- **user_can()**: Tests if a specific user has a capability or role
- **current_user_can()**: Tests the logged-in user's permissions

## Multisite

On WordPress multisite installations, use `current_user_can_for_blog()` to check capabilities on specific sites.
