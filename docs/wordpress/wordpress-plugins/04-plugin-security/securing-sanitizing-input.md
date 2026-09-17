# Securing (sanitizing) Input

Reference: <https://developer.wordpress.org/apis/security/sanitizing/>

## Overview

Data requires verification regardless of its origin — users, external sources, or even internal databases. The process of securing input is called sanitization, which involves cleaning and filtering information before use.

Validation is preferred over sanitization because validation is more specific. However, when specificity isn't feasible, sanitization serves as the appropriate alternative.

## Practical Example

Consider a basic text input field for a title. Since such fields accept varied content, validation alone won't suffice. Instead, the `sanitize_text_field()` function processes the data by:

1. Checking for invalid UTF-8 encoding
2. Converting unencoded less-than symbols to entities
3. Removing all HTML tags
4. Eliminating line breaks, tabs, and excess whitespace
5. Stripping octets

## Available Sanitization Functions

WordPress provides specialized functions for different data types:

- `sanitize_email()`
- `sanitize_file_name()`
- `sanitize_hex_color()` and `sanitize_hex_color_no_hash()`
- `sanitize_html_class()`
- `sanitize_key()`
- `sanitize_text_field()` and `sanitize_textarea_field()`
- `sanitize_title()`, `sanitize_title_for_query()`, and `sanitize_title_with_dashes()`
- `sanitize_url()` and `sanitize_user()`
- `wp_kses()` and `wp_kses_post()`
