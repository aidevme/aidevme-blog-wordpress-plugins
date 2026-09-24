# Template_Part Revisions

Reference: <https://developer.wordpress.org/rest-api/reference/wp_template_part-revisions/>

## Schema

The schema defines all the fields that exist within a template_part revision record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `author`: The ID for the author of the revision.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `date`: The date the revision was published, in the site's timezone.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`, `embed`
- `date_gmt`: The date the revision was published, as GMT.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`
- `guid`: GUID for the revision, as it exists in the database.
  - JSON data type: string
  - Context: `view`, `edit`
- `id`: Unique identifier for the revision.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `modified`: The date the revision was last modified, in the site's timezone.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`
- `modified_gmt`: The date the revision was last modified, as GMT.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`
- `parent`: The ID for the parent of the revision.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `slug`: An alphanumeric identifier for the revision unique to its type.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `title`: Title of template.
  - JSON data type: object or string
  - Context: `embed`, `view`, `edit`
- `content`: Content of template.
  - JSON data type: object or string
  - Context: `embed`, `view`, `edit`

## List Template_Part Revisions

Query this endpoint to retrieve a collection of template_part revisions. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/template-parts/<parent>/revisions
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/template-parts/<parent>/revisions
```

### Arguments

- `parent`: The ID for the parent of the revision.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `page`: Current page of the collection.
  - Default: `1`
- `per_page`: Maximum number of items to be returned in result set.
- `search`: Limit results to those matching a string.
- `exclude`: Ensure result set excludes specific IDs.
- `include`: Limit result set to specific IDs.
- `offset`: Offset the result set by a specific number of items.
- `order`: Order sort attribute ascending or descending.
  - Default: `desc`
  - One of: `asc`, `desc`
- `orderby`: Sort collection by object attribute.
  - Default: `date`
  - One of: `date`, `id`, `include`, `relevance`, `slug`, `include_slugs`, `title`

## Retrieve a Template_Part Revision

### Definition & Example Request

```http
GET /wp/v2/template-parts/<parent>/revisions/<id>
```

Query this endpoint to retrieve a specific template_part revision record.

```bash
curl https://example.com/wp-json/wp/v2/template-parts/<parent>/revisions/<id>
```

### Arguments

- `parent`: The ID for the parent of the revision.
- `id`: Unique identifier for the revision.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Delete a Template_Part Revision

### Arguments

- `parent`: The ID for the parent of the revision.
- `id`: Unique identifier for the revision.
- `force`: Required to be true, as revisions do not support trashing.

### Definition

```http
DELETE /wp/v2/template-parts/<parent>/revisions/<id>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/template-parts/<parent>/revisions/<id>
```

## Retrieve a Template_Part Revision

### Definition & Example Request

```http
GET /wp/v2/template-parts/<id>/autosaves
```

Query this endpoint to retrieve a specific template_part revision record.

```bash
curl https://example.com/wp-json/wp/v2/template-parts/<id>/autosaves
```

### Arguments

- `parent`: The ID for the parent of the autosave.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Create a Template_Part Revision

### Arguments

- `parent`: The ID for the parent of the autosave.
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
POST /wp/v2/template-parts/<id>/autosaves
```

## Retrieve a Template_Part Revision

### Definition & Example Request

```http
GET /wp/v2/template-parts/<parent>/autosaves/<id>
```

Query this endpoint to retrieve a specific template_part revision record.

```bash
curl https://example.com/wp-json/wp/v2/template-parts/<parent>/autosaves/<id>
```

### Arguments

- `parent`: The ID for the parent of the autosave.
- `id`: The ID for the autosave.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
