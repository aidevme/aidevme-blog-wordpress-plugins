# Term Splitting (WordPress 4.2)

Reference: <https://developer.wordpress.org/plugins/taxonomies/split-terms-wp-4-2/>

## Overview

This article addresses term splitting functionality introduced in WordPress 4.2, a historical change affecting how taxonomy terms are managed.

## Prior to WordPress 4.2

Before version 4.2, terms sharing identical slugs across different taxonomies used the same term ID. For example, a tag and category both named "news" would share a single identifier.

## WordPress 4.2 Changes

Starting with WordPress 4.2, updating a shared term triggers a split where the modified term receives a new ID, ensuring taxonomy-specific identification.

## Impact

In the vast majority of situations, this update was seamless and uneventful. However, plugins and themes storing term IDs in options, post metadata, or user metadata required adjustment.

## Handling Term Splits

WordPress 4.2 provides two mechanisms for developers.

### The split_shared_term Hook

When a shared term receives a new ID, the `split_shared_term` action fires, allowing developers to update stored references.

Example uses include:

- Updating options containing term ID arrays
- Refreshing post metadata with outdated term IDs

### The wp_get_split_term Function

This utility function retrieves new term IDs for terms that have split, useful for validation routines. It accepts an old term ID and taxonomy name, returning the new term ID if a split occurred.

A related function, `wp_get_split_terms()`, retrieves all split terms associated with an old ID across all taxonomies.
