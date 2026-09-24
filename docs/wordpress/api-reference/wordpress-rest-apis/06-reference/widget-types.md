# Widget Types

Reference: <https://developer.wordpress.org/rest-api/reference/widget-types/>

## Schema

The schema defines all the fields that exist within a widget type record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: Unique slug identifying the widget type.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `name`: Human-readable name identifying the widget type.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `description`: Description of the widget.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `is_multi`: Whether the widget supports multiple instances
  - JSON data type: boolean
  - Read only
  - Context: `view`, `edit`, `embed`
- `classname`: Class name
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`

## Retrieve a Widget Type

### Definition & Example Request

```http
GET /wp/v2/widget-types
```

Query this endpoint to retrieve a specific widget type record.

```bash
curl https://example.com/wp-json/wp/v2/widget-types
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Retrieve a Widget Type

### Definition & Example Request

```http
GET /wp/v2/widget-types/<id>
```

Query this endpoint to retrieve a specific widget type record.

```bash
curl https://example.com/wp-json/wp/v2/widget-types/<id>
```

### Arguments

- `id`: The widget type id.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
