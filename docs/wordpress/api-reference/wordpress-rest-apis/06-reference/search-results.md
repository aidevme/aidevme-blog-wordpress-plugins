# Search Results

Reference: <https://developer.wordpress.org/rest-api/reference/search-results/>

## Schema

The schema defines all the fields that exist within a search result record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: Unique identifier for the object.
  - JSON data type: integer or string
  - Read only
  - Context: `view`, `embed`
- `title`: The title for the object.
  - JSON data type: string
  - Read only
  - Context: `view`, `embed`
- `url`: URL to the object.
  - JSON data type: string, Format: uri
  - Read only
  - Context: `view`, `embed`
- `type`: Object type.
  - JSON data type: string
  - Read only
  - Context: `view`, `embed`
  - One of: `post`, `term`, `post-format`
- `subtype`: Object subtype.
  - JSON data type: string
  - Read only
  - Context: `view`, `embed`
  - One of: `post`, `page`, `category`, `post_tag`

## List Search Results

Query this endpoint to retrieve a collection of search results. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/search
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/search
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`
- `page`: Current page of the collection.
  - Default: `1`
- `per_page`: Maximum number of items to be returned in result set.
  - Default: `10`
- `search`: Limit results to those matching a string.
- `type`: Limit results to items of an object type.
  - Default: `post`
  - One of: `post`, `term`, `post-format`
- `subtype`: Limit results to items of one or more object subtypes.
  - Default: `any`
- `exclude`: Ensure result set excludes specific IDs.
- `include`: Limit result set to specific IDs.
