# Types

Reference: <https://developer.wordpress.org/rest-api/reference/post-types/>

## Schema

The schema defines all the fields that exist within a type record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `capabilities`: All capabilities used by the post type.
  - JSON data type: object
  - Read only
  - Context: `edit`
- `description`: A human-readable description of the post type.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`
- `hierarchical`: Whether or not the post type should have children.
  - JSON data type: boolean
  - Read only
  - Context: `view`, `edit`
- `viewable`: Whether or not the post type can be viewed.
  - JSON data type: boolean
  - Read only
  - Context: `edit`
- `labels`: Human-readable labels for the post type for various contexts.
  - JSON data type: object
  - Read only
  - Context: `edit`
- `name`: The title for the post type.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `slug`: An alphanumeric identifier for the post type.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `supports`: All features, supported by the post type.
  - JSON data type: object
  - Read only
  - Context: `edit`
- `has_archive`: If the value is a string, the value will be used as the archive slug. If the value is false the post type has no archive.
  - JSON data type: string or boolean
  - Read only
  - Context: `view`, `edit`
- `taxonomies`: Taxonomies associated with post type.
  - JSON data type: array
  - Read only
  - Context: `view`, `edit`
- `rest_base`: REST base route for the post type.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `rest_namespace`: REST route's namespace for the post type.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `visibility`: The visibility settings for the post type.
  - JSON data type: object
  - Read only
  - Context: `edit`
- `icon`: The icon for the post type.
  - JSON data type: string or null
  - Read only
  - Context: `view`, `edit`, `embed`

## Retrieve a Type

### Definition & Example Request

```http
GET /wp/v2/types
```

Query this endpoint to retrieve a specific type record.

```bash
curl https://example.com/wp-json/wp/v2/types
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Retrieve a Type

### Definition & Example Request

```http
GET /wp/v2/types/<type>
```

Query this endpoint to retrieve a specific type record.

```bash
curl https://example.com/wp-json/wp/v2/types/<type>
```

### Arguments

- `type`: An alphanumeric identifier for the post type.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
