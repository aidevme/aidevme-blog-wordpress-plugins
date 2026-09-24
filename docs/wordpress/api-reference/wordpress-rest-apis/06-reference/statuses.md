# Statuses

Reference: <https://developer.wordpress.org/rest-api/reference/post-statuses/>

## Schema

The schema defines all the fields that exist within a status record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `name`: The title for the status.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `private`: Whether posts with this status should be private.
  - JSON data type: boolean
  - Read only
  - Context: `edit`
- `protected`: Whether posts with this status should be protected.
  - JSON data type: boolean
  - Read only
  - Context: `edit`
- `public`: Whether posts of this status should be shown in the front end of the site.
  - JSON data type: boolean
  - Read only
  - Context: `view`, `edit`
- `queryable`: Whether posts with this status should be publicly-queryable.
  - JSON data type: boolean
  - Read only
  - Context: `view`, `edit`
- `show_in_list`: Whether to include posts in the edit listing for their post type.
  - JSON data type: boolean
  - Read only
  - Context: `edit`
- `slug`: An alphanumeric identifier for the status.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `date_floating`: Whether posts of this status may have floating published dates.
  - JSON data type: boolean
  - Read only
  - Context: `view`, `edit`

## Retrieve a Status

### Definition & Example Request

```http
GET /wp/v2/statuses
```

Query this endpoint to retrieve a specific status record.

```bash
curl https://example.com/wp-json/wp/v2/statuses
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Retrieve a Status

### Definition & Example Request

```http
GET /wp/v2/statuses/<status>
```

Query this endpoint to retrieve a specific status record.

```bash
curl https://example.com/wp-json/wp/v2/statuses/<status>
```

### Arguments

- `status`: An alphanumeric identifier for the status.
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
