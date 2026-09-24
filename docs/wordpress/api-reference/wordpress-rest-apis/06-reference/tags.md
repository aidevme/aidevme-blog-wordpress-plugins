# Tags

Reference: <https://developer.wordpress.org/rest-api/reference/tags/>

## Schema

The schema defines all the fields that exist within a tag record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: Unique identifier for the term.
  - JSON data type: integer
  - Read only
  - Context: `view`, `embed`, `edit`
- `count`: Number of published posts for the term.
  - JSON data type: integer
  - Read only
  - Context: `view`, `edit`
- `description`: HTML description of the term.
  - JSON data type: string
  - Context: `view`, `edit`
- `link`: URL of the term.
  - JSON data type: string, Format: uri
  - Read only
  - Context: `view`, `embed`, `edit`
- `name`: HTML title for the term.
  - JSON data type: string
  - Context: `view`, `embed`, `edit`
- `slug`: An alphanumeric identifier for the term unique to its type.
  - JSON data type: string
  - Context: `view`, `embed`, `edit`
- `taxonomy`: Type attribution for the term.
  - JSON data type: string
  - Read only
  - Context: `view`, `embed`, `edit`
  - One of: `post_tag`
- `meta`: Meta fields.
  - JSON data type: object
  - Context: `view`, `edit`

## List Tags

Query this endpoint to retrieve a collection of tags. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/tags
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/tags
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
- `orderby`: Sort collection by term attribute.
  - Default: `name`
  - One of: `id`, `include`, `name`, `slug`, `include_slugs`, `term_group`, `description`, `count`
- `hide_empty`: Whether to hide terms not assigned to any posts.
- `post`: Limit result set to terms assigned to a specific post.
- `slug`: Limit result set to terms with one or more specific slugs.

## Create a Tag

### Arguments

- `description`: HTML description of the term.
- `name`: HTML title for the term.
  - Required: 1
- `slug`: An alphanumeric identifier for the term unique to its type.
- `meta`: Meta fields.

### Definition

```http
POST /wp/v2/tags
```

## Retrieve a Tag

### Definition & Example Request

```http
GET /wp/v2/tags/<id>
```

Query this endpoint to retrieve a specific tag record.

```bash
curl https://example.com/wp-json/wp/v2/tags/<id>
```

### Arguments

- `id`: Unique identifier for the term.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Update a Tag

### Arguments

- `id`: Unique identifier for the term.
- `description`: HTML description of the term.
- `name`: HTML title for the term.
- `slug`: An alphanumeric identifier for the term unique to its type.
- `meta`: Meta fields.

### Definition

```http
POST /wp/v2/tags/<id>
```

### Example Request

## Delete a Tag

### Arguments

- `id`: Unique identifier for the term.
- `force`: Required to be true, as terms do not support trashing.

### Definition

```http
DELETE /wp/v2/tags/<id>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/tags/<id>
```
