# Routes & Endpoints

Reference: <https://developer.wordpress.org/plugins/rest-api/routes-endpoints/>

## Overview

The WordPress REST API operates at `/wp-json/` by default when pretty permalinks are enabled. The REST API index provides information about available routes, supported HTTP methods, and registered endpoints.

To register routes, use the `register_rest_route()` function on the `rest_api_init` action hook. This function handles all mapping between routes and endpoints.

## Routes

Routes are represented by URIs appended to `https://yourdomain.com/wp-json/`. The root index route (`/`) returns all available API information.

Routes should be unique to avoid conflicts. Two plugins attempting to register the same route will create conflicts.

### Namespaces

Namespaces group routes and prevent collisions. The structure follows: `/vendor/version`

Key guidelines:

- Core WordPress endpoints use `/wp/v2`
- Do not use the `/wp` namespace unless creating endpoints intended for WordPress core
- Custom plugins should use unique vendor names (e.g., `hello-world`)
- Version numbers allow backward compatibility (e.g., `v1`, `v2`)

### Resource Paths

Resource paths indicate what resource an endpoint manages. Within a namespace, each resource path should be unique. For example, an eCommerce plugin might use:

- `/my-shop/v1/orders`
- `/my-shop/v1/products`

### Path Variables

Path variables enable dynamic routes using regular expressions. Example syntax: `/products/(?P<id>[\d]+)`

This pattern matches numeric IDs only. When path variables don't match expectations, error handling becomes essential - return `WP_Error` objects for invalid requests.

## Endpoints

Endpoints are destinations that routes map to. Multiple endpoints can exist at one route, distinguished by HTTP methods.

Example: `/wp-json/my-shop/v1/products/` can support both GET (retrieve) and POST (create) endpoints.

### HTTP Methods

Standard HTTP methods include:

- **GET** - Retrieve existing data
- **POST** - Create new resources
- **PUT** - Update resources
- **DELETE** - Remove resources
- **OPTIONS** - Provide resource context

Unsupported clients can use the `_method` parameter or `X-HTTP-Method-Override` header as a workaround.

### Callbacks

#### Endpoint Callback

The main callback processes resource interactions. Follow these principles:

- **Idempotence** - GET, HEAD, TRACE, OPTIONS, PUT, and DELETE requests should produce no side effects
- **POST requests** - Not idempotent; create new resources with each identical request
- **Consistency** - Read, update, and delete operations should only perform their intended function

#### Permissions Callback

Permissions callbacks control access to private data. Example implementation:

```php
function prefix_check_permissions() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        return new WP_Error(
            'rest_forbidden',
            'Access denied',
            array( 'status' => 401 )
        );
    }
    return true;
}
```

### Arguments

Endpoint arguments allow request customization. Register arguments with descriptions, types, and validation rules:

```php
'args' => array(
    'filter' => array(
        'description' => 'Filter parameter',
        'type' => 'string',
        'enum' => array( 'red', 'green', 'blue' )
    )
)
```

Query parameters appear in the URL string; body parameters exist in the HTTP request body.

#### Validation

The `validate_callback` fires before sanitization to verify input validity:

```php
function validate_filter( $value, $request, $param ) {
    if ( ! is_string( $value ) ) {
        return new WP_Error( 'invalid', 'Must be string' );
    }
}
```

#### Sanitization

The `sanitize_callback` transforms or cleans input before processing. Use WordPress functions like `sanitize_text_field()` to prevent malicious content:

```php
'sanitize_callback' => 'sanitize_text_field'
```

Validation executes first (checking format), then sanitization (cleaning content).

## Summary

Routes are URIs; endpoints are callback collections mapped to routes. Each endpoint supports HTTP methods, main callbacks, permissions callbacks, and arguments. The `register_rest_route()` function connects endpoints to routes, forming the core interaction layer for the WordPress REST API.
