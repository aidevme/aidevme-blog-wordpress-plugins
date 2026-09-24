# Global_Styles

Reference: <https://developer.wordpress.org/rest-api/reference/wp_global_styles/>

## Schema

The schema defines all the fields that exist within a global_styles record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: ID of global styles config.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `styles`: Global styles.
  - JSON data type: object
  - Context: `view`, `edit`
- `settings`: Global settings.
  - JSON data type: object
  - Context: `view`, `edit`
- `title`: Title of the global styles variation.
  - JSON data type: object or string
  - Context: `embed`, `view`, `edit`

## Retrieve a Global_Styles

### Definition & Example Request

```http
GET /wp/v2/global-styles/<id>
```

Query this endpoint to retrieve a specific global_styles record.

```bash
curl https://example.com/wp-json/wp/v2/global-styles/<id>
```

### Arguments

- `id`: The id of a template

## Update a Global_Styles

### Arguments

- `styles`: Global styles.
- `settings`: Global settings.
- `title`: Title of the global styles variation.

### Definition

```http
POST /wp/v2/global-styles/<id>
```

### Example Request
