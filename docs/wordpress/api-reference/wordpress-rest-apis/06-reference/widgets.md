# Widgets

Reference: <https://developer.wordpress.org/rest-api/reference/widgets/>

## Schema

The schema defines all the fields that exist within a widget record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `id`: Unique identifier for the widget.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `id_base`: The type of the widget. Corresponds to ID in widget-types endpoint.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `sidebar`: The sidebar the widget belongs to.
  - JSON data type: string
  - Context: `view`, `edit`, `embed`
- `rendered`: HTML representation of the widget.
  - JSON data type: string
  - Read only
  - Context: `view`, `edit`, `embed`
- `rendered_form`: HTML representation of the widget admin form.
  - JSON data type: string
  - Read only
  - Context: `edit`
- `instance`: Instance settings of the widget, if supported.
  - JSON data type: object
  - Context: `edit`
- `form_data`: URL-encoded form data from the widget admin form. Used to update a widget that does not support instance. Write only.
  - JSON data type: string
  - Context:

## Retrieve a Widget

### Definition & Example Request

```http
GET /wp/v2/widgets
```

Query this endpoint to retrieve a specific widget record.

```bash
curl https://example.com/wp-json/wp/v2/widgets
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`
- `sidebar`: The sidebar to return widgets for.

## Create a Widget

### Arguments

- `id`: Unique identifier for the widget.
- `id_base`: The type of the widget. Corresponds to ID in widget-types endpoint.
- `sidebar`: The sidebar the widget belongs to.
  - Required: 1
  - Default: `wp_inactive_widgets`
- `instance`: Instance settings of the widget, if supported.
- `form_data`: URL-encoded form data from the widget admin form. Used to update a widget that does not support instance. Write only.

### Definition

```http
POST /wp/v2/widgets
```

## Retrieve a Widget

### Definition & Example Request

```http
GET /wp/v2/widgets/<id>
```

Query this endpoint to retrieve a specific widget record.

```bash
curl https://example.com/wp-json/wp/v2/widgets/<id>
```

### Arguments

- `context`: Scope under which the request is made; determines fields present in response.
  - Default: `view`
  - One of: `view`, `embed`, `edit`

## Update a Widget

### Arguments

- `id`: Unique identifier for the widget.
- `id_base`: The type of the widget. Corresponds to ID in widget-types endpoint.
- `sidebar`: The sidebar the widget belongs to.
- `instance`: Instance settings of the widget, if supported.
- `form_data`: URL-encoded form data from the widget admin form. Used to update a widget that does not support instance. Write only.

### Definition

```http
POST /wp/v2/widgets/<id>
```

### Example Request

## Delete a Widget

### Arguments

- `force`: Whether to force removal of the widget, or move it to the inactive sidebar.

### Definition

```http
DELETE /wp/v2/widgets/<id>
```

### Example Request

```bash
curl -X DELETE https://example.com/wp-json/wp/v2/widgets/<id>
```
