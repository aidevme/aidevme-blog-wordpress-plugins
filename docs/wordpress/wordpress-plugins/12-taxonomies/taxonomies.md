# Taxonomies

Reference: <https://developer.wordpress.org/plugins/taxonomies/>

## Overview

A Taxonomy is a mechanism for classifying and organizing content. These organizational structures can feature hierarchical relationships (parent-child arrangements) or operate as flat classifications.

## Key Concepts

WordPress manages taxonomies within the `term_taxonomy` database table, enabling developers to establish Custom Taxonomies alongside built-in options. Taxonomies have Terms which serve as the topic by which you classify/group things, stored in the `terms` table.

## Example

Consider a taxonomy labeled "Art" containing multiple terms such as "Modern" and "18th Century" that categorize related content.

## Scope

This guide covers:

- Registering Custom Taxonomies
- Retrieving taxonomy data from the database
- Displaying taxonomies to site visitors

## Historical Note

WordPress versions 3.4 and earlier included a "Links" taxonomy, which was deprecated in version 3.5.
