# Securing (escaping) Output

Reference: <https://developer.wordpress.org/apis/security/escaping/>

## Overview

Escaping output is the process of securing output data by stripping out unwanted data, like malformed HTML or script tags.

## Key Escaping Functions

WordPress provides specialized functions for different contexts:

- `esc_html()` — removes HTML within enclosed elements
- `esc_attr()` — secures HTML attribute values
- `esc_url()` — protects URLs in href and src attributes
- `esc_js()` — handles inline JavaScript contexts
- `esc_textarea()` — encodes text for textarea elements
- `wp_kses()` — allows selective HTML while removing unsafe content
- `wp_kses_post()` — permits HTML standard in post content
- `esc_xml()` — protects XML blocks

## Best Practices

**Escape Late**: Apply security functions as close to output as possible rather than earlier in code processing. This approach improves code reviews, prevents unintended modifications, and enables automated scanning.

**Exception**: When functions generate scripts that would be stripped by filtering, escape during string creation and mark variables with suffixes like `_escaped` or `_safe`.

**With Localization**: Combined functions like `esc_html_e()` merge localization with escaping simultaneously.

## Practical Scenarios

Specific use cases include attributes, URLs, JavaScript contexts, JSON data, textareas, and XML elements, each with correct and incorrect examples.
