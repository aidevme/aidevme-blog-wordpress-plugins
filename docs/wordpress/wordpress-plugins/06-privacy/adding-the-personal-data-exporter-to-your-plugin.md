# Adding the Personal Data Exporter to Your Plugin

Reference: <https://developer.wordpress.org/plugins/privacy/adding-the-personal-data-exporter-to-your-plugin/>

## Overview

WordPress 4.9.6 introduced privacy compliance tools, including a Personal Data Export feature that allows administrators to compile and deliver user data in a ZIP file. Plugins can integrate with this system by hooking into the exporter mechanism to include their own collected personal data.

## Key Concepts

The system uses email addresses as the primary key for exports, supporting both registered users and unregistered individuals such as commenters.

Administrators must enter a username or email address and send a confirmation link before the data export is generated. This prevents unauthorized data access.

Administrators can download the resulting ZIP file directly or email it to the requestor. The assembled export contains an index HTML page with personal data organized into logical groups.

## How Exporters Work

The system implements an AJAX loop that iterates through registered exporter callbacks sequentially. Each callback receives:

- An email address
- A page parameter, starting at 1

Callbacks should limit the amount of data returned per request to prevent timeouts, and should return structured arrays containing group identifiers, item identifiers, and name-value data pairs.

## Implementation

A plugin registers an exporter by:

1. Creating an exporter function that accepts an email and a page parameter, queries the relevant data, and returns results with a completion status.
2. Registering the function via the `wp_privacy_personal_data_exporters` filter.

A common example is a hypothetical location-tracking comment plugin, which retrieves comment metadata and formats it for export.

## Server-Side Management

Exports are cached for three days before being automatically deleted. Plugins may register multiple exporters, though most plugins require only one.
