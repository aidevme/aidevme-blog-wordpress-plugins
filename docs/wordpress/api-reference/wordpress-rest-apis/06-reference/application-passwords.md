# Application Passwords

Reference: <https://developer.wordpress.org/rest-api/reference/application-passwords/>

## Schema

The schema defines all the fields that exist within a application password record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `uuid`: The unique identifier for the application password.
  - JSON data type: string, Format: uuid
  - Read only
  - Context: `view`, `edit`, `embed`
- `app_id`: A UUID provided by the application to uniquely identify it. It is recommended to use an UUID v5 with the URL or DNS namespace.
  - JSON data type: string, Format: uuid
  - Context: `view`, `edit`, `embed`
- `name`: The name of the application password.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `password`: The generated password. Only available after adding an application.
  - JSON data type: string
  - Read only
  - Context: `edit`
- `created`: The GMT date the application password was created.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Read only
  - Context: `view`, `edit`
- `last_used`: The GMT date the application password was last used.
  - JSON data type: string or null, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Read only
  - Context: `view`, `edit`
- `last_ip`: The IP address the application password was last used by.
  - JSON data type: string or null, Format: ip
  - Read only
  - Context: `view`, `edit`

## Retrieve a Application Password

### Definition & Example Request

```http
GET /wp/v2/users/<user_id>)/application-passwords
```

Query this endpoint to retrieve a specific application password record.

```bash
curl https://example.com/wp-json/wp/v2/users/<user_id>)/application-passwords
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Create a Application Password

### Arguments

- `app_id`: A UUID provided by the application to uniquely identify it. It is recommended to use an UUID v5 with the URL or DNS namespace.
- `name`: The name of the application password.
  - Required: 1

### Definition

```http
POST /wp/v2/users/<user_id>)/application-passwords
```

## Delete a Application Password

There are no arguments for this endpoint.

### Definition

```http
DELETE /wp/v2/users/<user_id>)/application-passwords
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/users/<user_id>)/application-passwords
```

## Retrieve a Application Password

### Definition & Example Request

```http
GET /wp/v2/users/<user_id>)/application-passwords/introspect
```

Query this endpoint to retrieve a specific application password record.

```bash
curl https://example.com/wp-json/wp/v2/users/<user_id>)/application-passwords/introspect
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Retrieve a Application Password

### Definition & Example Request

```http
GET /wp/v2/users/<user_id>)/application-passwords/<uuid>
```

Query this endpoint to retrieve a specific application password record.

```bash
curl https://example.com/wp-json/wp/v2/users/<user_id>)/application-passwords/<uuid>
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Update a Application Password

### Arguments

- `app_id`: A UUID provided by the application to uniquely identify it. It is recommended to use an UUID v5 with the URL or DNS namespace.
- `name`: The name of the application password.

### Definition

```http
POST /wp/v2/users/<user_id>)/application-passwords/<uuid>
```

### Example Request

## Delete a Application Password

There are no arguments for this endpoint.

### Definition

```http
DELETE /wp/v2/users/<user_id>)/application-passwords/<uuid>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/users/<user_id>)/application-passwords/<uuid>
```
