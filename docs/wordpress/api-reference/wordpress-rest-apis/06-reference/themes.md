# Themes

Reference: <https://developer.wordpress.org/rest-api/reference/themes/>

## Schema

The schema defines all the fields that exist within a theme record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `stylesheet`: The theme's stylesheet. This uniquely identifies the theme.
  - JSON data type: string
  - Read only
  - Context:
- `template`: The theme's template. If this is a child theme, this refers to the parent theme, otherwise this is the same as the theme's stylesheet.
  - JSON data type: string
  - Read only
  - Context:
- `author`: The theme author.
  - JSON data type: object
  - Read only
  - Context:
- `author_uri`: The website of the theme author.
  - JSON data type: object
  - Read only
  - Context:
- `description`: A description of the theme.
  - JSON data type: object
  - Read only
  - Context:
- `is_block_theme`: Whether the theme is a block-based theme.
  - JSON data type: boolean
  - Read only
  - Context:
- `name`: The name of the theme.
  - JSON data type: object
  - Read only
  - Context:
- `requires_php`: The minimum PHP version required for the theme to work.
  - JSON data type: string
  - Read only
  - Context:
- `requires_wp`: The minimum WordPress version required for the theme to work.
  - JSON data type: string
  - Read only
  - Context:
- `screenshot`: The theme's screenshot URL.
  - JSON data type: string, Format: uri
  - Read only
  - Context:
- `tags`: Tags indicating styles and features of the theme.
  - JSON data type: object
  - Read only
  - Context:
- `textdomain`: The theme's text domain.
  - JSON data type: string
  - Read only
  - Context:
- `theme_supports`: Features supported by this theme.
  - JSON data type: object
  - Read only
  - Context:
- `theme_uri`: The URI of the theme's webpage.
  - JSON data type: object
  - Read only
  - Context:
- `version`: The theme's current version.
  - JSON data type: string
  - Read only
  - Context:
- `status`: A named status for the theme.
  - JSON data type: string
  - Context:
  - One of: `inactive`, `active`

## Retrieve a Theme

### Definition & Example Request

```http
GET /wp/v2/themes
```

Query this endpoint to retrieve a specific theme record.

```bash
curl https://example.com/wp-json/wp/v2/themes
```

### Arguments

- `status`: Limit result set to themes assigned one or more statuses.

## Retrieve a Theme

### Definition & Example Request

```http
GET /wp/v2/themes/<stylesheet>?)
```

Query this endpoint to retrieve a specific theme record.

```bash
curl https://example.com/wp-json/wp/v2/themes/<stylesheet>?)
```

### Arguments

- `stylesheet`: The theme's stylesheet. This uniquely identifies the theme.
