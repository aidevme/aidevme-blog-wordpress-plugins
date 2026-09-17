# REST API Overview

Reference: <https://developer.wordpress.org/plugins/rest-api/rest-api-overview/>

## Introduction

The WordPress REST API introduces significant capabilities to WordPress, utilizing JSON as its data format. JSON is an open standard data format that is becoming more widely used across the web and provides a lightweight, human-readable structure. This enables developers to work with WordPress using languages beyond PHP, opening new possibilities for WordPress applications.

## Why Use the WordPress REST API

Multiple use cases exist for this API. A prominent application involves building Single Page Applications on WordPress. Developers can create entirely new administrative or user-facing experiences without writing PHP. Any programming language that can make HTTP requests and interpret JSON could be used to write something on WordPress.

The API also serves as a strong replacement for the admin-ajax API in core. This allows developers to structure data flow more elegantly, simplifying AJAX calls and improving user experiences. The possibilities extend broadly: if you want a structured, extensible, and simple way to get data in and out of WordPress, you probably want to use the REST API.

## Key Concepts

Five foundational concepts are essential to understanding the REST API:

- **Routes/Endpoints** - A route is a URI mappable to HTTP methods. An endpoint represents a specific HTTP method mapped to a route. The `/wp-json/` route itself demonstrates this concept.
- **Requests** - The `WP_REST_Request` class stores and retrieves request information. These objects generate automatically for HTTP requests to registered routes.
- **Responses** - The `WP_REST_Response` class manages data returned by endpoints, handling both successful data and error returns.
- **Schema** - Schema structures different data types and provides security validation for incoming API requests.
- **Controller Classes** - These consolidate all API elements, managing route registration, request handling, schema implementation, and response generation.
