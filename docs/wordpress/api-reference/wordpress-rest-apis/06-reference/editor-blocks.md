# Editor Blocks

Reference: <https://developer.wordpress.org/rest-api/reference/blocks/>

## Schema

The schema defines all the fields that exist within a Editor Block record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `date`: The date the post was published, in the site's timezone.
  - JSON data type: string or null, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`, `embed`
- `date_gmt`: The date the post was published, as GMT.
  - JSON data type: string or null, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`
- `guid`: The globally unique identifier for the post.
  - JSON data type: object
  - Read only
  - Context: `view`, `edit`
- `id`: Unique identifier for the post.
  - JSON data type: integer
  - Read only
  - Context: `view`, `edit`, `embed`
- `link`: URL to the post.
  - JSON data type: string, Format: uri
  - Read only
  - Context: `view`, `edit`, `embed`
- `modified`: The date the post was last modified, in the site's timezone.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Read only
  - Context: `view`, `edit`
- `modified_gmt`: The date the post was last modified, as GMT.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Read only
  - Context: `view`, `edit`
- `slug`: An alphanumeric identifier for the post unique to its type.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `status`: A named status for the post.
  - JSON data type: string
  - Context: `view`, `edit`
  - One of: `publish`, `future`, `draft`, `pending`, `private`
- `type`: Type of post.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `password`: A password to protect access to the content and excerpt.
  - JSON data type: string
  - Context: `edit`
- `title`: The title for the post.
  - JSON data type: object
  - Context: `view`, `edit`, `embed`
- `content`: The content for the post.
  - JSON data type: object
  - Context: `view`, `edit`
- `meta`: Meta fields.
  - JSON data type: object
  - Context: `view`, `edit`
- `template`: The theme file to use to display the post.
  - JSON data type: string
  - Context: `view`, `edit`

## List Editor Blocks

Query this endpoint to retrieve a collection of Editor Blocks. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/blocks
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/blocks
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `page`: Current page of the collection.
  - Default: `1`
- `per_page`: Maximum number of items to be returned in result set.
  - Default: `10`
- `search`: Limit results to those matching a string.
- `after`: Limit response to posts published after a given ISO8601 compliant date.
- `modified_after`: Limit response to posts modified after a given ISO8601 compliant date.
- `before`: Limit response to posts published before a given ISO8601 compliant date.
- `modified_before`: Limit response to posts modified before a given ISO8601 compliant date.
- `exclude`: Ensure result set excludes specific IDs.
- `include`: Limit result set to specific IDs.
- `offset`: Offset the result set by a specific number of items.
- `order`: Order sort attribute ascending or descending.
  - Default: `desc`
  - One of: `asc`, `desc`
- `orderby`: Sort collection by post attribute.
  - Default: `date`
  - One of: `author`, `date`, `id`, `include`, `modified`, `parent`, `relevance`, `slug`, `include_slugs`, `title`
- `search_columns`: Array of column names to be searched.
- `slug`: Limit result set to posts with one or more specific slugs.
- `status`: Limit result set to posts assigned one or more statuses.
  - Default: `publish`

## Create a Editor Block

### Arguments

- `date`: The date the post was published, in the site's timezone.
- `date_gmt`: The date the post was published, as GMT.
- `slug`: An alphanumeric identifier for the post unique to its type.
- `status`: A named status for the post. One of: `publish`, `future`, `draft`, `pending`, `private`
- `password`: A password to protect access to the content and excerpt.
- `title`: The title for the post.
- `content`: The content for the post.
- `meta`: Meta fields.
- `template`: The theme file to use to display the post.

### Definition

```http
POST /wp/v2/blocks
```

## Retrieve a Editor Block

### Definition & Example Request

```http
GET /wp/v2/blocks/<id>
```

Query this endpoint to retrieve a specific Editor Block record.

```bash
curl https://example.com/wp-json/wp/v2/blocks/<id>
```

### Arguments

- `id`: Unique identifier for the post.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `password`: The password for the post if it is password protected.

## Update a Editor Block

### Arguments

- `id`: Unique identifier for the post.
- `date`: The date the post was published, in the site's timezone.
- `date_gmt`: The date the post was published, as GMT.
- `slug`: An alphanumeric identifier for the post unique to its type.
- `status`: A named status for the post. One of: `publish`, `future`, `draft`, `pending`, `private`
- `password`: A password to protect access to the content and excerpt.
- `title`: The title for the post.
- `content`: The content for the post.
- `meta`: Meta fields.
- `template`: The theme file to use to display the post.

### Definition

```http
POST /wp/v2/blocks/<id>
```

### Example Request

## Delete a Editor Block

### Arguments

- `id`: Unique identifier for the post.
- `force`: Whether to bypass Trash and force deletion.

### Definition

```http
DELETE /wp/v2/blocks/<id>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/blocks/<id>
```
