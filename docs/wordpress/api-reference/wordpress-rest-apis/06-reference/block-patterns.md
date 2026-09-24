# Block Patterns

Reference: <https://developer.wordpress.org/rest-api/reference/block-patterns/>

## Schema

The schema defines all the fields that exist within a block pattern record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `name`: The pattern name.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `title`: The pattern title, in human readable format.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `content`: The pattern content.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `description`: The pattern detailed description.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `viewport_width`: The pattern viewport width for inserter preview.
  - JSON data type: number
  - Read only
  - Context: `view`, `edit`, `embed`
- `inserter`: Determines whether the pattern is visible in inserter.
  - JSON data type: boolean
  - Read only
  - Context: `view`, `edit`, `embed`
- `categories`: The pattern category slugs.
  - JSON data type: array
  - Read only
  - Context: `view`, `edit`, `embed`
- `keywords`: The pattern keywords.
  - JSON data type: array
  - Read only
  - Context: `view`, `edit`, `embed`
- `block_types`: Block types that the pattern is intended to be used with.
  - JSON data type: array
  - Read only
  - Context: `view`, `edit`, `embed`
- `post_types`: An array of post types that the pattern is restricted to be used with.
  - JSON data type: array
  - Read only
  - Context: `view`, `edit`, `embed`
- `template_types`: An array of template types where the pattern fits.
  - JSON data type: array
  - Read only
  - Context: `view`, `edit`, `embed`
- `source`: Where the pattern comes from e.g. core
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
  - One of: `core`, `plugin`, `theme`, `pattern-directory/core`, `pattern-directory/theme`, `pattern-directory/featured`

## Retrieve a Block Pattern

### Definition & Example Request

```http
GET /wp/v2/block-patterns/patterns
```

Query this endpoint to retrieve a specific block pattern record.

```bash
curl https://example.com/wp-json/wp/v2/block-patterns/patterns
```

There are no arguments for this endpoint.
