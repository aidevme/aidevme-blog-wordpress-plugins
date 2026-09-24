# Block Directory Items

Reference: <https://developer.wordpress.org/rest-api/reference/block-directory-items/>

## Schema

The schema defines all the fields that exist within a block directory item record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `name`: The block name, in namespace/block-name format.
  - JSON data type: string
  - Context: `view`
- `title`: The block title, in human readable format.
  - JSON data type: string
  - Context: `view`
- `description`: A short description of the block, in human readable format.
  - JSON data type: string
  - Context: `view`
- `id`: The block slug.
  - JSON data type: string
  - Context: `view`
- `rating`: The star rating of the block.
  - JSON data type: number
  - Context: `view`
- `rating_count`: The number of ratings.
  - JSON data type: integer
  - Context: `view`
- `active_installs`: The number sites that have activated this block.
  - JSON data type: integer
  - Context: `view`
- `author_block_rating`: The average rating of blocks published by the same author.
  - JSON data type: number
  - Context: `view`
- `author_block_count`: The number of blocks published by the same author.
  - JSON data type: integer
  - Context: `view`
- `author`: The WordPress.org username of the block author.
  - JSON data type: string
  - Context: `view`
- `icon`: The block icon.
  - JSON data type: string, Format: uri
  - Context: `view`
- `last_updated`: The date when the block was last updated.
  - JSON data type: string, Format: datetime ([details](https://core.trac.wordpress.org/ticket/41032))
  - Context: `view`
- `humanized_updated`: The date when the block was last updated, in fuzzy human readable format.
  - JSON data type: string
  - Context: `view`

## List Block Directory Items

Query this endpoint to retrieve a collection of block directory items. The response you receive can be controlled and filtered using the URL query parameters below.

### Definition

```http
GET /wp/v2/block-directory/search
```

### Example Request

```bash
curl https://example.com/wp-json/wp/v2/block-directory/search
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`
- `page`: Current page of the collection.
  - Default: `1`
- `per_page`: Maximum number of items to be returned in result set.
  - Default: `10`
- `term`: Limit result set to blocks matching the search term.
  - Required: 1
