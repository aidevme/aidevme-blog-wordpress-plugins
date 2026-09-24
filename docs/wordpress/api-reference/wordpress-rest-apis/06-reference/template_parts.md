# Template_Parts

Reference: <https://developer.wordpress.org/rest-api/reference/wp_template_parts/>

## Schema

The schema defines all the fields that exist within a template_part record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

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
- `area`: Where the template part is intended for use (header, footer, etc.)
  - JSON data type: string
  - Context: `embed`, `view`, `edit`

## Retrieve a Template_Part

### Definition & Example Request

```http
GET /wp/v2/template-parts
```

Query this endpoint to retrieve a specific template_part record.

```bash
curl https://example.com/wp-json/wp/v2/template-parts
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `wp_id`: Limit to the specified post id.
- `area`: Limit to the specified template part area.
- `post_type`: Post type to get the templates for.

## Create a Template_Part

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
- `area`: Where the template part is intended for use (header, footer, etc.)

### Definition

```http
POST /wp/v2/template-parts
```

## Retrieve a Template_Part

### Definition & Example Request

```http
GET /wp/v2/template-parts/<id>?)[\/\w%-]+)
```

Query this endpoint to retrieve a specific template_part record.

```bash
curl https://example.com/wp-json/wp/v2/template-parts/<id>?)[\/\w%-]+)
```

### Arguments

- `id`: The id of a template
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Update a Template_Part

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
- `area`: Where the template part is intended for use (header, footer, etc.)

### Definition

```http
POST /wp/v2/template-parts/<id>?)[\/\w%-]+)
```

### Example Request

## Delete a Template_Part

### Arguments

- `id`: The id of a template
- `force`: Whether to bypass Trash and force deletion.

### Definition

```http
DELETE /wp/v2/template-parts/<id>?)[\/\w%-]+)
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/template-parts/<id>?)[\/\w%-]+)
```
