# Common Issues

Reference: <https://developer.wordpress.org/plugins/wordpress-org/common-issues/>

## Overview

This page serves as guidance for plugin developers on WordPress.org standards, addressing common issues encountered during plugin reviews.

## Security

Addresses input handling practices, including sanitization, validation, and escaping techniques. Data that is input must be sanitized as soon as possible, using context-appropriate WordPress functions for protection. The guidance is to "Sanitize early, escape late, always validate," and to avoid direct file access vulnerabilities.

## Compatibility

Focuses on naming conventions, PHP best practices, and proper WordPress API usage. Developers should use unique prefixes for functions and classes to prevent conflicts among thousands of plugins.

## Compliance

Requires proper documentation, GPL licensing compatibility, and adherence to WordPress.org's distribution policies. Developers must disclose third-party service dependencies transparently.

## Key Guidance

Plugins must not use outdated libraries, deprecated PHP short tags, or custom update checkers, since WordPress.org provides these services natively.
