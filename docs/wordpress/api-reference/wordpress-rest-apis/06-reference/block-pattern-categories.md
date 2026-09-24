# Block Pattern Categories

Reference: <https://developer.wordpress.org/rest-api/reference/block-pattern-categories/>

## Schema

The schema defines all the fields that exist within a block pattern category record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `name`: The category name.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `label`: The category label, in human readable format.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `description`: The category description, in human readable format.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`

## Retrieve a Block Pattern Category

### Definition & Example Request

```http
GET /wp/v2/block-patterns/categories
```

Query this endpoint to retrieve a specific block pattern category record.

```bash
curl https://example.com/wp-json/wp/v2/block-patterns/categories
```

There are no arguments for this endpoint.
