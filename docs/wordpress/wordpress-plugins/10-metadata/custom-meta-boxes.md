# Custom Meta Boxes

Reference: <https://developer.wordpress.org/plugins/metadata/custom-meta-boxes/>

## Overview

Meta boxes are interface components within WordPress post editing screens that enable developers to extend functionality. They are handy, flexible, modular edit screen elements that can be used to collect information related to the post being edited.

## What Meta Boxes Are

Meta boxes appear alongside default WordPress elements like the Editor, Publish, and Categories boxes. Plugin developers can add custom boxes containing HTML form elements to gather post-related data.

## Why Use Meta Boxes

These components offer several advantages:

- Display on the same screen as post data, establishing clear relationships
- Can be hidden from or shown to specific user groups
- Allow users to arrange the edit screen according to their preferences

## Adding Meta Boxes

Implementation involves:

- Using the `add_meta_box()` function
- Hooking to the `add_meta_boxes` action
- Specifying target post types
- Creating a callback function with form elements

Example code for meta boxes intentionally lacks production-ready security measures including input sanitization, capability checks, nonces, and internationalization — these must be added for real-world use.

## Data Management

**Retrieving Values:** Use `get_post_meta()` to fetch saved metadata and pre-populate form fields.

**Saving Values:** Hook into the `save_post` action to capture and store submitted form data, typically in the postmeta table using `update_post_meta()`.

## Implementation Approaches

**Object-Oriented Programming:** Using abstract classes with static methods provides namespace organization and memory efficiency.

**AJAX Enhancement:** A complete workflow for AJAX-driven meta boxes involves:

1. Define JavaScript triggers (like change events)
2. Write client-side code for POST requests
3. Enqueue scripts with `wp_enqueue_script()` and `wp_localize_script()`
4. Implement server-side handlers using `wp_ajax_` hooks

## Technical Reminders

Example implementations intentionally omit critical security operations. Production deployments must address:

- Input validation and sanitization
- User capability verification
- Nonce implementation
- Proper internationalization
