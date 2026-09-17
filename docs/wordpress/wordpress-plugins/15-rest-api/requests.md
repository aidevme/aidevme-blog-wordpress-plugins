# Requests

Reference: <https://developer.wordpress.org/plugins/rest-api/requests/>

## Overview

The REST API functions through a simple input-output model. Requests represent instructions sent to the API, typically via HTTP, which the server interprets to generate responses. Requests in the API utilize a lot of the different aspects present in HTTP requests like URIs, HTTP methods, headers, and parameters.

## WP_REST_Request Class

WordPress automatically instantiates this class when handling HTTP requests to API endpoints. The framework creates request objects that get passed to endpoint callbacks, enabling developers to access request properties and customize responses accordingly.

## Request Properties

**Method** - Follows HTTP conventions, GET for retrieval, POST for creation, PUT for updates, DELETE for removal. The request method acts as an indicator for the expected functionality of your endpoints.

**Route** - Matches the server's PATH_INFO variable and determines which endpoint receives the request.

**Headers** - Provide metadata about the request (caching policy, content type, origin) but don't directly interact with endpoints.

**Parameters** - Four types exist:

- URL parameters extracted from route patterns
- Query string parameters
- Body parameters for POST/PUT/DELETE requests
- File parameters using multipart/form-data

**Attributes** - Contains registration details for matched endpoints, including supported methods and registered arguments.

## Internal Requests

The `rest_do_request()` function enables internal API calls without HTTP overhead. This capability supports efficient batch endpoints that consolidate multiple requests into single HTTP calls, improving performance significantly.
