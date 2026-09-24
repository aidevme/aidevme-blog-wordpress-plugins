# Posts

Reference: <https://developer.wordpress.org/rest-api/reference/posts/>

## Schema

The schema defines all the fields that exist within a post record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

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
- `permalink_template`: Permalink template for the post.
  - JSON data type: string
  - Read only
  - Context: `edit`
- `generated_slug`: Slug automatically generated from the post title.
  - JSON data type: string
  - Read only
  - Context: `edit`
- `title`: The title for the post.
  - JSON data type: object
  - Context: `view`, `edit`, `embed`
- `content`: The content for the post.
  - JSON data type: object
  - Context: `view`, `edit`
- `author`: The ID for the author of the post.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `excerpt`: The excerpt for the post.
  - JSON data type: object
  - Context: `view`, `edit`, `embed`
- `featured_media`: The ID of the featured media for the post.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `comment_status`: Whether or not comments are open on the post.
  - JSON data type: string
  - Context: `view`, `edit`
  - One of: `open`, `closed`
- `ping_status`: Whether or not the post can be pinged.
  - JSON data type: string
  - Context: `view`, `edit`
  - One of: `open`, `closed`
- `format`: The format for the post.
  - JSON data type: string
  - Context: `view`, `edit`
  - One of: `standard`, `aside`, `chat`, `gallery`, `link`, `image`, `quote`, `status`, `video`, `audio`
- `meta`: Meta fields.
  - JSON data type: object
  - Context: `view`, `edit`
- `sticky`: Whether or not the post should be treated as sticky.
  - JSON data type: boolean
  - Context: `view`, `edit`
- `template`: The theme file to use to display the post.
  - JSON data type: string
  - Context: `view`, `edit`
- `categories`: The terms assigned to the post in the category taxonomy.
  - JSON data type: array
  - Context: `view`, `edit`
- `tags`: The terms assigned to the post in the post_tag taxonomy.
  - JSON data type: array
  - Context: `view`, `edit`

## List Posts

Query this endpoint to retrieve a collection of posts. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/posts
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/posts
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
- `author`: Limit result set to posts assigned to specific authors.
- `author_exclude`: Ensure result set excludes posts assigned to specific authors.
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
- `tax_relation`: Limit result set based on relationship between multiple taxonomies. One of: `AND`, `OR`
- `categories`: Limit result set to items with specific terms assigned in the categories taxonomy.
- `categories_exclude`: Limit result set to items except those with specific terms assigned in the categories taxonomy.
- `tags`: Limit result set to items with specific terms assigned in the tags taxonomy.
- `tags_exclude`: Limit result set to items except those with specific terms assigned in the tags taxonomy.
- `sticky`: Limit result set to items that are sticky.

## Create a Post

### Arguments

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
- `format`: The format for the post. One of: `standard`, `aside`, `chat`, `gallery`, `link`, `image`, `quote`, `status`, `video`, `audio`
- `meta`: Meta fields.
- `sticky`: Whether or not the post should be treated as sticky.
- `template`: The theme file to use to display the post.
- `categories`: The terms assigned to the post in the category taxonomy.
- `tags`: The terms assigned to the post in the post_tag taxonomy.

### Definition

```http
POST /wp/v2/posts
```

## Retrieve a Post

### Definition & Example Request

```http
GET /wp/v2/posts/<id>
```

Query this endpoint to retrieve a specific post record.

```bash
curl https://example.com/wp-json/wp/v2/posts/<id>
```

### Arguments

- `id`: Unique identifier for the post.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `password`: The password for the post if it is password protected.

## Update a Post

### Arguments

- `id`: Unique identifier for the post.
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
- `format`: The format for the post. One of: `standard`, `aside`, `chat`, `gallery`, `link`, `image`, `quote`, `status`, `video`, `audio`
- `meta`: Meta fields.
- `sticky`: Whether or not the post should be treated as sticky.
- `template`: The theme file to use to display the post.
- `categories`: The terms assigned to the post in the category taxonomy.
- `tags`: The terms assigned to the post in the post_tag taxonomy.

### Definition

```http
POST /wp/v2/posts/<id>
```

### Example Request

```bash
curl -X POST https://example.com/wp-json/wp/v2/posts/<id> -d '{"title":"My New Title"}'
```

## Delete a Post

### Arguments

- `id`: Unique identifier for the post.
- `force`: Whether to bypass Trash and force deletion.

### Definition

```http
DELETE /wp/v2/posts/<id>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/posts/<id>
```
