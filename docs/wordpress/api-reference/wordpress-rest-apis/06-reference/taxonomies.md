# Taxonomies

Reference: <https://developer.wordpress.org/rest-api/reference/taxonomies/>

## Schema

The schema defines all the fields that exist within a taxonomy record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `capabilities`: All capabilities used by the taxonomy.
  - JSON data type: object
  - Read only
  - Context: `edit`
- `description`: A human-readable description of the taxonomy.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`
- `hierarchical`: Whether or not the taxonomy should have children.
  - JSON data type: boolean
  - Read only
  - Context: `view`, `edit`
- `labels`: Human-readable labels for the taxonomy for various contexts.
  - JSON data type: object
  - Read only
  - Context: `edit`
- `name`: The title for the taxonomy.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `slug`: An alphanumeric identifier for the taxonomy.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `show_cloud`: Whether or not the term cloud should be displayed.
  - JSON data type: boolean
  - Read only
  - Context: `edit`
- `types`: Types associated with the taxonomy.
  - JSON data type: array
  - Read only
  - Context: `view`, `edit`
- `rest_base`: REST base route for the taxonomy.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `rest_namespace`: REST namespace route for the taxonomy.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `visibility`: The visibility settings for the taxonomy.
  - JSON data type: object
  - Read only
  - Context: `edit`

## Retrieve a Taxonomy

### Definition & Example Request

```http
GET /wp/v2/taxonomies
```

Query this endpoint to retrieve a specific taxonomy record.

```bash
curl https://example.com/wp-json/wp/v2/taxonomies
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `type`: Limit results to taxonomies associated with a specific post type.

## Retrieve a Taxonomy

### Definition & Example Request

```http
GET /wp/v2/taxonomies/<taxonomy>
```

Query this endpoint to retrieve a specific taxonomy record.

```bash
curl https://example.com/wp-json/wp/v2/taxonomies/<taxonomy>
```

### Arguments

- `taxonomy`: An alphanumeric identifier for the taxonomy.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
