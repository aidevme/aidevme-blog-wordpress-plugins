# Templates

Reference: <https://developer.wordpress.org/rest-api/reference/wp_templates/>

## Schema

The schema defines all the fields that exist within a template record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: ID of template.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `slug`: Unique slug identifying the template.
  - JSON data type: string
  - Context: `embed`, `view`, `edit`
- `theme`: Theme identifier for the template.
  - JSON data type: string
  - Context: `embed`, `view`, `edit`
- `type`: Type of template.
  - JSON data type: string
  - Context: `embed`, `view`, `edit`
- `source`: Source of template
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `origin`: Source of a customized template
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `content`: Content of template.
  - JSON data type: object or string
  - Context: `embed`, `view`, `edit`
- `title`: Title of template.
  - JSON data type: object or string
  - Context: `embed`, `view`, `edit`
- `description`: Description of template.
  - JSON data type: string
  - Context: `embed`, `view`, `edit`
- `status`: Status of template.
  - JSON data type: string
  - Context: `embed`, `view`, `edit`
  - One of: `publish`, `future`, `draft`, `pending`, `private`
- `wp_id`: Post ID.
  - JSON data type: integer
  - Read only
  - Context: `embed`, `view`, `edit`
- `has_theme_file`: Theme file exists.
  - JSON data type: bool
  - Read only
  - Context: `embed`, `view`, `edit`
- `author`: The ID for the author of the template.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `modified`: The date the template was last modified, in the site's timezone.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Read only
  - Context: `view`, `edit`
- `is_custom`: Whether a template is a custom template.
  - JSON data type: bool
  - Read only
  - Context: `embed`, `view`, `edit`

## Retrieve a Template

### Definition & Example Request

```http
GET /wp/v2/templates
```

Query this endpoint to retrieve a specific template record.

```bash
curl https://example.com/wp-json/wp/v2/templates
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `wp_id`: Limit to the specified post id.
- `area`: Limit to the specified template part area.
- `post_type`: Post type to get the templates for.

## Create a Template

### Arguments

- `slug`: Unique slug identifying the template.
  - Required: 1
- `theme`: Theme identifier for the template.
- `type`: Type of template.
- `content`: Content of template.
- `title`: Title of template.
- `description`: Description of template.
- `status`: Status of template.
  - Default: `publish`
  - One of: `publish`, `future`, `draft`, `pending`, `private`
- `author`: The ID for the author of the template.

### Definition

```http
POST /wp/v2/templates
```

## Retrieve a Template

### Definition & Example Request

```http
GET /wp/v2/templates/<id>?)[\/\w%-]+)
```

Query this endpoint to retrieve a specific template record.

```bash
curl https://example.com/wp-json/wp/v2/templates/<id>?)[\/\w%-]+)
```

### Arguments

- `id`: The id of a template
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Update a Template

### Arguments

- `id`: The id of a template
- `slug`: Unique slug identifying the template.
- `theme`: Theme identifier for the template.
- `type`: Type of template.
- `content`: Content of template.
- `title`: Title of template.
- `description`: Description of template.
- `status`: Status of template. One of: `publish`, `future`, `draft`, `pending`, `private`
- `author`: The ID for the author of the template.

### Definition

```http
POST /wp/v2/templates/<id>?)[\/\w%-]+)
```

### Example Request

## Delete a Template

### Arguments

- `id`: The id of a template
- `force`: Whether to bypass Trash and force deletion.

### Definition

```http
DELETE /wp/v2/templates/<id>?)[\/\w%-]+)
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/templates/<id>?)[\/\w%-]+)
```
