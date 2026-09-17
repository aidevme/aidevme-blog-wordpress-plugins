# HTTP API

Reference: <https://developer.wordpress.org/plugins/http-api/>

## Overview

This guide covers HTTP API fundamentals for plugin development — how to make HTTP requests and cache API responses.

## Core HTTP Methods

WordPress supports three primary HTTP verbs:

**GET** retrieves data from servers. Every time you view a website or pull data from an API you are seeing the result of a GET request.

**POST** transmits data for server processing, commonly used with forms and API submissions.

**HEAD** functions similarly to GET but returns only metadata about resources without downloading the content, helping conserve bandwidth.

## Response Code Structure

Status codes follow a classification system where the first digit indicates result type:

- **2xx codes**: Successful requests
- **3xx codes**: Redirects to alternate URLs
- **4xx codes**: Client-side errors (authentication, missing data)
- **5xx codes**: Server-side errors

Common codes include 200 (OK), 301 (permanent redirect), 404 (not found), and 500 (server error).

## WordPress HTTP Functions

The API provides helper functions for making requests:

- `wp_remote_get()` for retrieving data
- `wp_remote_post()` for sending data
- `wp_remote_head()` for checking resource metadata
- `wp_remote_request()` for custom HTTP methods

Response data can be extracted using retrieval functions like `wp_remote_retrieve_body()` and `wp_remote_retrieve_response_code()`.

## Caching Strategies

WordPress Transients offer a straightforward caching mechanism using three functions:

- `set_transient()` stores data with expiration
- `get_transient()` retrieves cached data
- `delete_transient()` removes cached objects

Most API responses should be cached to improve site performance and respect rate limits, though real-time data typically shouldn't be cached.
