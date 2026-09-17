# Responses

Reference: <https://developer.wordpress.org/plugins/rest-api/responses/>

## Overview

API responses contain the requested data or error messages. The WordPress REST API manages responses through the `WP_REST_Response` class, one of the three infrastructural classes for the API.

## WP_REST_Response

This class extends WordPress's `WP_HTTP_Response`, providing access to headers, status codes, and data. Key methods include:

- `get_data()` - retrieves response data
- `get_status()` - accesses the HTTP status code
- `get_headers()` - retrieves response headers
- `get_matched_route()` - identifies which endpoint generated the response
- `get_matched_handler()` - returns endpoint options

## Error Handling

Returning `WP_Error` objects when requests fail is standard practice. The system automatically converts these objects into HTTP responses, with the error's status code becoming the response code. This enables using appropriate codes like 404 for missing content or 403 for forbidden access.

## Linking

Response linking creates relationships between resources using the HAL standard. For example, posts and comments can be linked bidirectionally - posts include "replies" links to their comments, while comments include "up" links to parent posts.

The API supports embedding via the `_embed` parameter, allowing linked resources to be included in a single HTTP request for improved performance.
