# How to Internationalize Your Plugin

Reference: <https://developer.wordpress.org/plugins/internationalization/how-to-internationalize-your-plugin/>

## Overview

This guide provides comprehensive guidance on making plugins translatable using gettext functions and internationalization (i18n) practices.

## Text Domains

A text domain serves as a unique identifier to ensure WordPress can distinguish between all loaded translations. Text domains must match the plugin slug, use lowercase with dashes (not underscores), and contain no spaces.

## Basic Translation Functions

The guide covers essential functions for different scenarios:

- `__()` returns translated strings
- `_e()` echoes translations directly
- `_x()` and `_ex()` handle context-specific translations
- `_n()` manages singular and plural forms

## Variable Handling

Rather than embedding variables directly in translatable strings, developers should use placeholders with printf functions. This approach allows translators to understand context while keeping strings consistent across source and runtime.

## Escaping Integrated Functions

The documentation recommends using specialized escape-and-translate functions like `esc_html__()` and `esc_attr__()` when strings appear in HTML attributes, combining security with localization.

## Best Practices Summary

Key recommendations include:

- Writing complete sentences rather than word fragments
- Avoiding leading/trailing whitespace in translatable phrases
- Using format strings instead of concatenation
- Adding text domains to every gettext call
- Loading text domains via `load_plugin_textdomain()`

The guide also addresses JavaScript internationalization, language packs, and automation tools for adding text domains throughout plugin files.
