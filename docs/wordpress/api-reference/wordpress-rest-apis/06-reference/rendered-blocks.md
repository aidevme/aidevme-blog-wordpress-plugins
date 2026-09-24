# Rendered Blocks

Reference: <https://developer.wordpress.org/rest-api/reference/rendered-blocks/>

## Schema

The schema defines all the fields that exist within a Rendered Block record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `rendered`: The rendered block.
  - JSON data type: string
  - Context: `edit`

## Create a Rendered Block

### Arguments

- `name`: Unique registered name for the block.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `edit`
- `attributes`: Attributes for the block.
- `post_id`: ID of the post context.

### Definition

```http
POST /wp/v2/block-renderer/<name>
```
