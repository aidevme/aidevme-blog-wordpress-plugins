# Privacy Related Options, Hooks and Capabilities

Reference: <https://developer.wordpress.org/plugins/privacy/privacy-related-options-hooks-and-capabilities/>

## Overview

WordPress introduced privacy tools in version 4.9.6 to help developers incorporate data management features. There are three main categories of hooks and options: options, actions, and filters, which allow developers to include additional personal data in export and erasure requests.

## Options

The system uses `wp_page_for_privacy_policy` to store a site's privacy page ID.

## Actions

Six actions are available, including:

- `user_request_action_confirmed`, triggered when users confirm privacy requests.
- `wp_privacy_personal_data_erased`, which fires after erasure completion.
- `wp_privacy_personal_data_export_file_created`, which fires after export files are generated.

## Filters

Over 25 filters enable customization of privacy workflows, covering:

- Privacy policy URLs and content
- Email notifications (subject, headers, recipients, body text)
- User profile data extension
- Export file storage and expiration
- Data anonymization and erasure processes

## Capabilities

Three capabilities control access to privacy tools:

- `erase_others_personal_data`
- `export_others_personal_data`
- `manage_privacy_options`

Administrators receive these capabilities by default on non-multisite installations.
