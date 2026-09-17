# Summary

Reference: <https://developer.wordpress.org/plugins/javascript/summary/>

## Overview

This page presents complete code examples for implementing AJAX functionality in WordPress plugins, consolidated from the earlier discussion sections.

## PHP Implementation

The PHP code belongs in your plugin file and handles server-side operations:

- Enqueues JavaScript files and dependencies using the `admin_enqueue_scripts` hook
- Establishes a security nonce for safe AJAX communication
- Uses `wp_localize_script()` to pass the admin AJAX URL and nonce to the frontend
- Implements an AJAX handler that validates the nonce, processes user data, and returns results
- Calls `wp_die()` to properly terminate the AJAX request

## jQuery/JavaScript Implementation

The client-side JavaScript file (`js/myjquery.js`) contains:

- A document-ready wrapper for initialization
- An event listener monitoring changes to preference elements
- A POST request sending the nonce, action identifier, and user selection
- A callback function that removes outdated information and inserts the server response

After processing, the plugin stores user preferences and displays the resulting post count alongside the selected title.

## Additional Resources

- How To Use AJAX In WordPress (Smashing Magazine)
- AJAX for WordPress (Glenn Messersmith)
