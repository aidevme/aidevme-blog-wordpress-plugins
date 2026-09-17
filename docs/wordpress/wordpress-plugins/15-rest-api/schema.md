# Schema

Reference: <https://developer.wordpress.org/plugins/rest-api/schema/>

## Overview

Schema is data that tells us how other data should be structured, enabling consistent data handling across applications.

## JSON Schema Foundation

JSON is a human-readable format, and the WordPress REST API implements JSON Schema specifically. A JSON parser will go through arbitrary data with no problem and won't complain about anything, because it is valid JSON - which is exactly why schema becomes necessary for validation.

## Resource Schema

Schemas can be defined for API resources through PHP. This involves registering routes with schema callbacks, preparing data (such as comment data) according to specifications, and enabling schema discovery through OPTIONS requests.

## Argument Schema

Request parameters can be validated using JSON Schema. Validation and sanitization callbacks can reference schema definitions, allowing developers to reuse these functions across multiple endpoints as applications scale.

## Main Benefits

Schema provides improved testing, discoverability, and overall better structure, making endpoints self-documenting for both humans and machines. Schema also enables client-side validation libraries, potentially preventing invalid requests before they reach the server.
