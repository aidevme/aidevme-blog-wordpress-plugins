# Block Types

Reference: <https://developer.wordpress.org/rest-api/reference/block-types/>

## Schema

The schema defines all the fields that exist within a block type record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `api_version`: Version of block API.
  - JSON data type: integer
  - Read only
  - Context: `embed`, `view`, `edit`
- `title`: Title of block type.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `name`: Unique name identifying the block type.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `description`: Description of block type.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `icon`: Icon of block type.
  - JSON data type: string or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `attributes`: Block attributes.
  - JSON data type: object or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `provides_context`: Context provided by blocks of this type.
  - JSON data type: object
  - Read only
  - Context: `embed`, `view`, `edit`
- `uses_context`: Context values inherited by blocks of this type.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `selectors`: Custom CSS selectors.
  - JSON data type: object
  - Read only
  - Context: `embed`, `view`, `edit`
- `supports`: Block supports.
  - JSON data type: object
  - Read only
  - Context: `embed`, `view`, `edit`
- `category`: Block category.
  - JSON data type: string or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `is_dynamic`: Is the block dynamically rendered.
  - JSON data type: boolean
  - Read only
  - Context: `embed`, `view`, `edit`
- `editor_script_handles`: Editor script handles.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `script_handles`: Public facing and editor script handles.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `view_script_handles`: Public facing script handles.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `editor_style_handles`: Editor style handles.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `style_handles`: Public facing and editor style handles.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `styles`: Block style variations.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `variations`: Block variations.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `textdomain`: Public text domain.
  - JSON data type: string or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `parent`: Parent blocks.
  - JSON data type: array or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `ancestor`: Ancestor blocks.
  - JSON data type: array or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `keywords`: Block keywords.
  - JSON data type: array
  - Read only
  - Context: `embed`, `view`, `edit`
- `example`: Block example.
  - JSON data type: object or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `editor_script`: Editor script handle. DEPRECATED: Use `editor_script_handles` instead.
  - JSON data type: string or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `script`: Public facing and editor script handle. DEPRECATED: Use `script_handles` instead.
  - JSON data type: string or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `view_script`: Public facing script handle. DEPRECATED: Use `view_script_handles` instead.
  - JSON data type: string or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `editor_style`: Editor style handle. DEPRECATED: Use `editor_style_handles` instead.
  - JSON data type: string or null
  - Read only
  - Context: `embed`, `view`, `edit`
- `style`: Public facing and editor style handle. DEPRECATED: Use `style_handles` instead.
  - JSON data type: string or null
  - Read only
  - Context: `embed`, `view`, `edit`

## Retrieve a Block Type

### Definition & Example Request

```http
GET /wp/v2/block-types
```

Query this endpoint to retrieve a specific block type record.

```bash
curl https://example.com/wp-json/wp/v2/block-types
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `namespace`: Block namespace.

## Retrieve a Block Type

### Definition & Example Request

```http
GET /wp/v2/block-types/<namespace>
```

Query this endpoint to retrieve a specific block type record.

```bash
curl https://example.com/wp-json/wp/v2/block-types/<namespace>
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `namespace`: Block namespace.

## Retrieve a Block Type

### Definition & Example Request

```http
GET /wp/v2/block-types/<namespace>/<name>
```

Query this endpoint to retrieve a specific block type record.

```bash
curl https://example.com/wp-json/wp/v2/block-types/<namespace>/<name>
```

### Arguments

- `name`: Block name.
- `namespace`: Block namespace.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
