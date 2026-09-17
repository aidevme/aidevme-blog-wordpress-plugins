# Adding the Personal Data Eraser to Your Plugin

Reference: <https://developer.wordpress.org/plugins/privacy/adding-the-personal-data-eraser-to-your-plugin/>

## Overview

WordPress 4.9.6 introduced privacy tools to help with GDPR compliance. The Personal Data Removal tool allows administrators to erase or anonymize user information without deleting user accounts.

## Key Concepts

The "key" for all the erasers is the user's email address, because it works for both registered users and unregistered users such as commenters.

The system requires admin verification before erasing data. Administrators must enter a username or email and confirm via a confirmation link.

Eraser callbacks receive a page parameter, starting at 1, to prevent timeouts by limiting the amount of data processed per request.

## 1. Create an Eraser Function

The callback function should:

- Accept an email address and a page number.
- Limit the amount of data processed per call (for example, 500 items).
- Return an array with four keys:
  - `items_removed` (boolean)
  - `items_retained` (boolean)
  - `messages` (array of explanations)
  - `done` (boolean indicating completion)

Example structure:

```php
function wporg_remove_location_meta_from_comments_for_email( $email_address, $page = 1 ) {
    $number = 500;
    $page = (int) $page;
    // Query and process data
    // Return array with status information
}
```

## 2. Register the Eraser

Use the `wp_privacy_personal_data_erasers` filter to register your callback:

```php
function wporg_register_privacy_erasers( $erasers ) {
    $erasers['my-plugin-slug'] = array(
        'eraser_friendly_name' => __( 'Comment Location Plugin', 'text-domain' ),
        'callback'             => 'wporg_remove_location_meta_from_comments_for_email',
    );
    return $erasers;
}

add_filter( 'wp_privacy_personal_data_erasers', 'wporg_register_privacy_erasers' );
```

## How It Works

When an admin initiates data removal, an AJAX loop processes registered erasers sequentially. If an eraser indicates that its work is incomplete, the system calls it again with an incremented page number until all data has been processed.
