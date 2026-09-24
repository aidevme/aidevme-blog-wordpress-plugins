# Comments

Reference: <https://developer.wordpress.org/rest-api/reference/comments/>

## Schema

The schema defines all the fields that exist within a comment record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: Unique identifier for the comment.
  - JSON data type: integer
  - Read only
  - Context: `view`, `edit`, `embed`
- `author`: The ID of the user object, if author was a user.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `author_email`: Email address for the comment author.
  - JSON data type: string, Format: email
  - Context: `edit`
- `author_ip`: IP address for the comment author.
  - JSON data type: string, Format: ip
  - Context: `edit`
- `author_name`: Display name for the comment author.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `author_url`: URL for the comment author.
  - JSON data type: string, Format: uri
  - Context: `view`, `edit`, `embed`
- `author_user_agent`: User agent for the comment author.
  - JSON data type: string
  - Context: `edit`
- `content`: The content for the comment.
  - JSON data type: object
  - Context: `view`, `edit`, `embed`
- `date`: The date the comment was published, in the site's timezone.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`, `embed`
- `date_gmt`: The date the comment was published, as GMT.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`, `edit`
- `link`: URL to the comment.
  - JSON data type: string, Format: uri
  - Read only
  - Context: `view`, `edit`, `embed`
- `parent`: The ID for the parent of the comment.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `post`: The ID of the associated post object.
  - JSON data type: integer
  - Context: `view`, `edit`
- `status`: State of the comment.
  - JSON data type: string
  - Context: `view`, `edit`
- `type`: Type of the comment.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `author_avatar_urls`: Avatar URLs for the comment author.
  - JSON data type: object
  - Read only
  - Context: `view`, `edit`, `embed`
- `meta`: Meta fields.
  - JSON data type: object
  - Context: `view`, `edit`

## List Comments

Query this endpoint to retrieve a collection of comments. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/comments
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/comments
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
- `after`: Limit response to comments published after a given ISO8601 compliant date.
- `author`: Limit result set to comments assigned to specific user IDs. Requires authorization.
- `author_exclude`: Ensure result set excludes comments assigned to specific user IDs. Requires authorization.
- `author_email`: Limit result set to that from a specific author email. Requires authorization.
- `before`: Limit response to comments published before a given ISO8601 compliant date.
- `exclude`: Ensure result set excludes specific IDs.
- `include`: Limit result set to specific IDs.
- `offset`: Offset the result set by a specific number of items.
- `order`: Order sort attribute ascending or descending.
  - Default: `desc`
  - One of: `asc`, `desc`
- `orderby`: Sort collection by comment attribute.
  - Default: `date_gmt`
  - One of: `date`, `date_gmt`, `id`, `include`, `post`, `parent`, `type`
- `parent`: Limit result set to comments of specific parent IDs.
- `parent_exclude`: Ensure result set excludes specific parent IDs.
- `post`: Limit result set to comments assigned to specific post IDs.
- `status`: Limit result set to comments assigned a specific status. Requires authorization.
  - Default: `approve`
- `type`: Limit result set to comments assigned a specific type. Requires authorization.
  - Default: `comment`
- `password`: The password for the post if it is password protected.

## Create a Comment

### Arguments

- `author`: The ID of the user object, if author was a user.
- `author_email`: Email address for the comment author.
- `author_ip`: IP address for the comment author.
- `author_name`: Display name for the comment author.
- `author_url`: URL for the comment author.
- `author_user_agent`: User agent for the comment author.
- `content`: The content for the comment.
- `date`: The date the comment was published, in the site's timezone.
- `date_gmt`: The date the comment was published, as GMT.
- `parent`: The ID for the parent of the comment.
- `post`: The ID of the associated post object.
- `status`: State of the comment.
- `meta`: Meta fields.

### Definition

```http
POST /wp/v2/comments
```

## Retrieve a Comment

### Definition & Example Request

```http
GET /wp/v2/comments/<id>
```

Query this endpoint to retrieve a specific comment record.

```bash
curl https://example.com/wp-json/wp/v2/comments/<id>
```

### Arguments

- `id`: Unique identifier for the comment.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `password`: The password for the parent post of the comment (if the post is password protected).

## Update a Comment

### Arguments

- `id`: Unique identifier for the comment.
- `author`: The ID of the user object, if author was a user.
- `author_email`: Email address for the comment author.
- `author_ip`: IP address for the comment author.
- `author_name`: Display name for the comment author.
- `author_url`: URL for the comment author.
- `author_user_agent`: User agent for the comment author.
- `content`: The content for the comment.
- `date`: The date the comment was published, in the site's timezone.
- `date_gmt`: The date the comment was published, as GMT.
- `parent`: The ID for the parent of the comment.
- `post`: The ID of the associated post object.
- `status`: State of the comment.
- `meta`: Meta fields.

### Definition

```http
POST /wp/v2/comments/<id>
```

### Example Request

## Delete a Comment

### Arguments

- `id`: Unique identifier for the comment.
- `force`: Whether to bypass Trash and force deletion.
- `password`: The password for the parent post of the comment (if the post is password protected).

### Definition

```http
DELETE /wp/v2/comments/<id>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/comments/<id>
```
