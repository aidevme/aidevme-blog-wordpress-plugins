# Page Revisions

Reference: <https://developer.wordpress.org/rest-api/reference/page-revisions/>

## Schema

The schema defines all the fields that exist within a page revision record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `author`: The ID for the author of the revision.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `date`: The date the revision was published, in the site's timezone.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`, `embed`
- `date_gmt`: The date the revision was published, as GMT.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`
- `guid`: The globally unique identifier for the post.
  - JSON data type: object
  - Read only
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
- `title`: The title for the post.
  - JSON data type: object
  - Context: `view`, `edit`, `embed`
- `content`: The content for the post.
  - JSON data type: object
  - Context: `view`, `edit`
- `excerpt`: The excerpt for the post.
  - JSON data type: object
  - Context: `view`, `edit`, `embed`

## List Page Revisions

Query this endpoint to retrieve a collection of page revisions. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/pages/<parent>/revisions
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/pages/<parent>/revisions
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

## Retrieve a Page Revision

### Definition & Example Request

```http
GET /wp/v2/pages/<parent>/revisions/<id>
```

Query this endpoint to retrieve a specific page revision record.

```bash
curl https://example.com/wp-json/wp/v2/pages/<parent>/revisions/<id>
```

### Arguments

- `parent`: The ID for the parent of the revision.
- `id`: Unique identifier for the revision.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Delete a Page Revision

### Arguments

- `parent`: The ID for the parent of the revision.
- `id`: Unique identifier for the revision.
- `force`: Required to be true, as revisions do not support trashing.

### Definition

```http
DELETE /wp/v2/pages/<parent>/revisions/<id>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/pages/<parent>/revisions/<id>
```

## Retrieve a Page Revision

### Definition & Example Request

```http
GET /wp/v2/pages/<id>/autosaves
```

Query this endpoint to retrieve a specific page revision record.

```bash
curl https://example.com/wp-json/wp/v2/pages/<id>/autosaves
```

### Arguments

- `parent`: The ID for the parent of the autosave.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Create a Page Revision

### Arguments

- `parent`: The ID for the parent of the post.
- `date`: The date the post was published, in the site's timezone.
- `date_gmt`: The date the post was published, as GMT.
- `slug`: An alphanumeric identifier for the post unique to its type.
- `status`: A named status for the post. One of: `publish`, `future`, `draft`, `pending`, `private`
- `password`: A password to protect access to the content and excerpt.
- `title`: The title for the post.
- `content`: The content for the post.
- `author`: The ID for the author of the post.
- `excerpt`: The excerpt for the post.
- `featured_media`: The ID of the featured media for the post.
- `comment_status`: Whether or not comments are open on the post. One of: `open`, `closed`
- `ping_status`: Whether or not the post can be pinged. One of: `open`, `closed`
- `menu_order`: The order of the post in relation to other posts.
- `meta`: Meta fields.
- `template`: The theme file to use to display the post.

### Definition

```http
POST /wp/v2/pages/<id>/autosaves
```

## Retrieve a Page Revision

### Definition & Example Request

```http
GET /wp/v2/pages/<parent>/autosaves/<id>
```

Query this endpoint to retrieve a specific page revision record.

```bash
curl https://example.com/wp-json/wp/v2/pages/<parent>/autosaves/<id>
```

### Arguments

- `parent`: The ID for the parent of the autosave.
- `id`: The ID for the autosave.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
