# Pattern Directory Items

Reference: <https://developer.wordpress.org/rest-api/reference/pattern-directory-items/>

## Schema

The schema defines all the fields that exist within a pattern directory item record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: The pattern ID.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `title`: The pattern title, in human readable format.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `content`: The pattern content.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `categories`: The pattern's category slugs.
  - JSON data type: array
  - Context: `view`, `edit`, `embed`
- `keywords`: The pattern's keywords.
  - JSON data type: array
  - Context: `view`, `edit`, `embed`
- `description`: A description of the pattern.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `viewport_width`: The preferred width of the viewport when previewing a pattern, in pixels.
  - JSON data type: integer
  - Context: `view`, `edit`, `embed`
- `block_types`: The block types which can use this pattern.
  - JSON data type: array
  - Context: `view`, `embed`

## List Pattern Directory Items

Query this endpoint to retrieve a collection of pattern directory items. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/pattern-directory/patterns
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/pattern-directory/patterns
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `page`: Current page of the collection.
  - Default: `1`
- `per_page`: Maximum number of items to be returned in result set.
  - Default: `100`
- `search`: Limit results to those matching a string.
- `category`: Limit results to those matching a category ID.
- `keyword`: Limit results to those matching a keyword ID.
- `slug`: Limit results to those matching a pattern (slug).
- `offset`: Offset the result set by a specific number of items.
- `order`: Order sort attribute ascending or descending.
  - Default: `desc`
  - One of: `asc`, `desc`
- `orderby`: Sort collection by post attribute.
  - Default: `date`
  - One of: `author`, `date`, `id`, `include`, `modified`, `parent`, `relevance`, `slug`, `include_slugs`, `title`, `favorite_count`
