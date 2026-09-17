# Controller Classes

Reference: <https://developer.wordpress.org/plugins/rest-api/controller-classes/>

## Overview

Controller classes provide a structured approach for handling REST API endpoints in WordPress. They encapsulate functionality and establish consistent patterns for API interactions.

A primary advantage involves addressing PHP's scoping limitations. PHP 5.2 does not have namespacing built into it, which means that every function you declare will be in the global scope. This creates potential naming conflicts when multiple plugins register similarly named functions. Wrapping endpoint logic within classes avoids these collisions.

## Core Functionality

Controllers follow a straightforward pattern: they accept input via `WP_REST_Request` objects and produce output as `WP_REST_Response` objects. A typical controller includes:

- **Constructor** - Establishes namespace and resource identifiers
- **Route Registration** - Defines endpoints and associates callbacks
- **Permission Checks** - Validates user access rights
- **Data Processing** - Retrieves and formats information
- **Schema Definition** - Specifies expected data structure using JSON Schema

A typical example is a posts controller implementing GET endpoints for both collections and individual items, complete with permission validation and response preparation.

## Design Best Practices

Avoid excessive inheritance hierarchies. Rather than extending a posts controller to handle custom post types, create separate controllers or modify the existing class to accommodate multiple post types.

For consistency, consider building controllers as abstract classes or implementing interfaces that multiple endpoint controllers can utilize. WordPress's REST API team proposes the `WP_REST_Controller` class as a standardized foundation for custom endpoint development.
