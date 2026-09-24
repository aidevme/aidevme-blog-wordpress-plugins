# Users

Reference: <https://developer.wordpress.org/rest-api/reference/users/>

## Schema

The schema defines all the fields that exist within a user record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: Unique identifier for the user.
  - JSON data type: integer
  - Read only
  - Context: `embed`, `view`, `edit`
- `username`: Login name for the user.
  - JSON data type: string
  - Context: `edit`
- `name`: Display name for the user.
  - JSON data type: string
  - Context: `embed`, `view`, `edit`
- `first_name`: First name for the user.
  - JSON data type: string
  - Context: `edit`
- `last_name`: Last name for the user.
  - JSON data type: string
  - Context: `edit`
- `email`: The email address for the user.
  - JSON data type: string, Format: email
  - Context: `edit`
- `url`: URL of the user.
  - JSON data type: string, Format: uri
  - Context: `embed`, `view`, `edit`
- `description`: Description of the user.
  - JSON data type: string
  - Context: `embed`, `view`, `edit`
- `link`: Author URL of the user.
  - JSON data type: string, Format: uri
  - Read only
  - Context: `embed`, `view`, `edit`
- `locale`: Locale for the user.
  - JSON data type: string
  - Context: `edit`
  - One of: , `en_US`
- `nickname`: The nickname for the user.
  - JSON data type: string
  - Context: `edit`
- `slug`: An alphanumeric identifier for the user.
  - JSON data type: string
  - Context: `embed`, `view`, `edit`
- `registered_date`: Registration date for the user.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Read only
  - Context: `edit`
- `roles`: Roles assigned to the user.
  - JSON data type: array
  - Context: `edit`
- `password`: Password for the user (never included).
  - JSON data type: string
  - Context:
- `capabilities`: All capabilities assigned to the user.
  - JSON data type: object
  - Read only
  - Context: `edit`
- `extra_capabilities`: Any extra capabilities assigned to the user.
  - JSON data type: object
  - Read only
  - Context: `edit`
- `avatar_urls`: Avatar URLs for the user.
  - JSON data type: object
  - Read only
  - Context: `embed`, `view`, `edit`
- `meta`: Meta fields.
  - JSON data type: object
  - Context: `view`, `edit`

## List Users

Query this endpoint to retrieve a collection of users. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/users
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/users
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `page`: Current page of the collection.
  - Default: `1`
- `per_page`: Maximum number of items to be returned in result set.
  - Default: `10`
- `search`: Limit results to those matching a string.
- `exclude`: Ensure result set excludes specific IDs.
- `include`: Limit result set to specific IDs.
- `offset`: Offset the result set by a specific number of items.
- `order`: Order sort attribute ascending or descending.
  - Default: `asc`
  - One of: `asc`, `desc`
- `orderby`: Sort collection by user attribute.
  - Default: `name`
  - One of: `id`, `include`, `name`, `registered_date`, `slug`, `include_slugs`, `email`, `url`
- `slug`: Limit result set to users with one or more specific slugs.
- `roles`: Limit result set to users matching at least one specific role provided. Accepts csv list or single role.
- `capabilities`: Limit result set to users matching at least one specific capability provided. Accepts csv list or single capability.
- `who`: Limit result set to users who are considered authors. One of: `authors`
- `has_published_posts`: Limit result set to users who have published posts.

## Create a User

### Arguments

- `username`: Login name for the user.
  - Required: 1
- `name`: Display name for the user.
- `first_name`: First name for the user.
- `last_name`: Last name for the user.
- `email`: The email address for the user.
  - Required: 1
- `url`: URL of the user.
- `description`: Description of the user.
- `locale`: Locale for the user. One of: , `en_US`
- `nickname`: The nickname for the user.
- `slug`: An alphanumeric identifier for the user.
- `roles`: Roles assigned to the user.
- `password`: Password for the user (never included).
  - Required: 1
- `meta`: Meta fields.

### Definition

```http
POST /wp/v2/users
```

## Retrieve a User

### Definition & Example Request

```http
GET /wp/v2/users/<id>
```

Query this endpoint to retrieve a specific user record.

```bash
curl https://example.com/wp-json/wp/v2/users/<id>
```

### Arguments

- `id`: Unique identifier for the user.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Update a User

### Arguments

- `id`: Unique identifier for the user.
- `username`: Login name for the user.
- `name`: Display name for the user.
- `first_name`: First name for the user.
- `last_name`: Last name for the user.
- `email`: The email address for the user.
- `url`: URL of the user.
- `description`: Description of the user.
- `locale`: Locale for the user. One of: , `en_US`
- `nickname`: The nickname for the user.
- `slug`: An alphanumeric identifier for the user.
- `roles`: Roles assigned to the user.
- `password`: Password for the user (never included).
- `meta`: Meta fields.

### Definition

```http
POST /wp/v2/users/<id>
```

### Example Request

## Delete a User

### Arguments

- `id`: Unique identifier for the user.
- `force`: Required to be true, as users do not support trashing.
- `reassign`: Reassign the deleted user's posts and links to this user ID.
  - Required: 1

### Definition

```http
DELETE /wp/v2/users/<id>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/users/<id>
```

## Retrieve a User

### Definition & Example Request

```http
GET /wp/v2/users/me
```

Query this endpoint to retrieve a specific user record.

```bash
curl https://example.com/wp-json/wp/v2/users/me
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Update a User

### Arguments

- `username`: Login name for the user.
- `name`: Display name for the user.
- `first_name`: First name for the user.
- `last_name`: Last name for the user.
- `email`: The email address for the user.
- `url`: URL of the user.
- `description`: Description of the user.
- `locale`: Locale for the user. One of: , `en_US`
- `nickname`: The nickname for the user.
- `slug`: An alphanumeric identifier for the user.
- `roles`: Roles assigned to the user.
- `password`: Password for the user (never included).
- `meta`: Meta fields.

### Definition

```http
POST /wp/v2/users/me
```

### Example Request

## Delete a User

### Arguments

- `force`: Required to be true, as users do not support trashing.
- `reassign`: Reassign the deleted user's posts and links to this user ID.
  - Required: 1

### Definition

```http
DELETE /wp/v2/users/me
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/users/me
```
