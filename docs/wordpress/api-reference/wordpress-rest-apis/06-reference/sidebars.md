# Sidebars

Reference: <https://developer.wordpress.org/rest-api/reference/sidebars/>

## Schema

The schema defines all the fields that exist within a sidebar record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: ID of sidebar.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `name`: Unique name identifying the sidebar.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `description`: Description of sidebar.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `class`: Extra CSS class to assign to the sidebar in the Widgets interface.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `before_widget`: HTML content to prepend to each widget's HTML output when assigned to this sidebar. Default is an opening list item element.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `after_widget`: HTML content to append to each widget's HTML output when assigned to this sidebar. Default is a closing list item element.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `before_title`: HTML content to prepend to the sidebar title when displayed. Default is an opening h2 element.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `after_title`: HTML content to append to the sidebar title when displayed. Default is a closing h2 element.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
- `status`: Status of sidebar.
  - JSON data type: string
  - Read only
  - Context: `embed`, `view`, `edit`
  - One of: `active`, `inactive`
- `widgets`: Nested widgets.
  - JSON data type: array
  - Context: `embed`, `view`, `edit`

## Retrieve a Sidebar

### Definition & Example Request

```http
GET /wp/v2/sidebars
```

Query this endpoint to retrieve a specific sidebar record.

```bash
curl https://example.com/wp-json/wp/v2/sidebars
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Retrieve a Sidebar

### Definition & Example Request

```http
GET /wp/v2/sidebars/<id>
```

Query this endpoint to retrieve a specific sidebar record.

```bash
curl https://example.com/wp-json/wp/v2/sidebars/<id>
```

### Arguments

- `id`: The id of a registered sidebar
- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Update a Sidebar

### Arguments

- `widgets`: Nested widgets.

### Definition

```http
POST /wp/v2/sidebars/<id>
```

### Example Request
