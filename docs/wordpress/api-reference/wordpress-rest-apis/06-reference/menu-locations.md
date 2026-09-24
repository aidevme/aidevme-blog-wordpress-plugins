# Menu Locations

Reference: <https://developer.wordpress.org/rest-api/reference/menu-locations/>

## Schema

The schema defines all the fields that exist within a menu location record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `name`: The name of the menu location.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `description`: The description of the menu location.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `menu`: The ID of the assigned menu.
  - JSON data type: integer
  - Read only
  - Context: `embed`, `view`, `edit`

## Retrieve a Menu Location

### Definition & Example Request

```http
GET /wp/v2/menu-locations
```

Query this endpoint to retrieve a specific menu location record.

```bash
curl https://example.com/wp-json/wp/v2/menu-locations
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Retrieve a Menu Location

### Definition & Example Request

```http
GET /wp/v2/menu-locations/<location>
```

Query this endpoint to retrieve a specific menu location record.

```bash
curl https://example.com/wp-json/wp/v2/menu-locations/<location>
```

### Arguments

- `location`: An alphanumeric identifier for the menu location.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
