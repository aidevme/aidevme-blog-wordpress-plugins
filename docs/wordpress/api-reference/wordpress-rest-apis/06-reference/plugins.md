# Plugins

Reference: <https://developer.wordpress.org/rest-api/reference/plugins/>

## Schema

The schema defines all the fields that exist within a plugin record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `plugin`: The plugin file.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `status`: The plugin activation status.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
  - One of: `inactive`, `active`
- `name`: The plugin name.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `plugin_uri`: The plugin's website address.
  - JSON data type: string, Format: uri
  - Read only
  - Context: `view`, `edit`
- `author`: The plugin author.
  - JSON data type: object
  - Read only
  - Context: `view`, `edit`
- `author_uri`: Plugin author's website address.
  - JSON data type: string, Format: uri
  - Read only
  - Context: `view`, `edit`
- `description`: The plugin description.
  - JSON data type: object
  - Read only
  - Context: `view`, `edit`
- `version`: The plugin version number.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`
- `network_only`: Whether the plugin can only be activated network-wide.
  - JSON data type: boolean
  - Read only
  - Context: `view`, `edit`, `embed`
- `requires_wp`: Minimum required version of WordPress.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `requires_php`: Minimum required version of PHP.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `textdomain`: The plugin's text domain.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`

## Retrieve a Plugin

### Definition & Example Request

```http
GET /wp/v2/plugins
```

Query this endpoint to retrieve a specific plugin record.

```bash
curl https://example.com/wp-json/wp/v2/plugins
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `search`: Limit results to those matching a string.
- `status`: Limits results to plugins with the given status.

## Create a Plugin

### Arguments

- `slug`: WordPress.org plugin directory slug.
  - Required: 1
- `status`: The plugin activation status.
  - Default: `inactive`
  - One of: `inactive`, `active`

### Definition

```http
POST /wp/v2/plugins
```

## Retrieve a Plugin

### Definition & Example Request

```http
GET /wp/v2/plugins/<plugin>?)
```

Query this endpoint to retrieve a specific plugin record.

```bash
curl https://example.com/wp-json/wp/v2/plugins/<plugin>?)
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `plugin`

## Update a Plugin

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `plugin`
- `status`: The plugin activation status. One of: `inactive`, `active`

### Definition

```http
POST /wp/v2/plugins/<plugin>?)
```

### Example Request

## Delete a Plugin

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `plugin`

### Definition

```http
DELETE /wp/v2/plugins/<plugin>?)
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/plugins/<plugin>?)
```
