# Site Settings

Reference: <https://developer.wordpress.org/rest-api/reference/settings/>

## Schema

The schema defines all the fields that exist within a Site Setting record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `title`: Site title.
  - JSON data type: string
  - Context:
- `description`: Site tagline.
  - JSON data type: string
  - Context:
- `url`: Site URL.
  - JSON data type: string, Format: uri
  - Context:
- `email`: This address is used for admin purposes, like new user notification.
  - JSON data type: string, Format: email
  - Context:
- `timezone`: A city in the same timezone as you.
  - JSON data type: string
  - Context:
- `date_format`: A date format for all date strings.
  - JSON data type: string
  - Context:
- `time_format`: A time format for all time strings.
  - JSON data type: string
  - Context:
- `start_of_week`: A day number of the week that the week should start on.
  - JSON data type: integer
  - Context:
- `language`: WordPress locale code.
  - JSON data type: string
  - Context:
- `use_smilies`: Convert emoticons like :-) and :-P to graphics on display.
  - JSON data type: boolean
  - Context:
- `default_category`: Default post category.
  - JSON data type: integer
  - Context:
- `default_post_format`: Default post format.
  - JSON data type: string
  - Context:
- `posts_per_page`: Blog pages show at most.
  - JSON data type: integer
  - Context:
- `show_on_front`: What to show on the front page
  - JSON data type: string
  - Context:
- `page_on_front`: The ID of the page that should be displayed on the front page
  - JSON data type: integer
  - Context:
- `page_for_posts`: The ID of the page that should display the latest posts
  - JSON data type: integer
  - Context:
- `default_ping_status`: Allow link notifications from other blogs (pingbacks and trackbacks) on new articles.
  - JSON data type: string
  - Context:
  - One of: `open`, `closed`
- `default_comment_status`: Allow people to submit comments on new posts.
  - JSON data type: string
  - Context:
  - One of: `open`, `closed`
- `site_logo`: Site logo.
  - JSON data type: integer
  - Context:
- `site_icon`: Site icon.
  - JSON data type: integer
  - Context:

## Retrieve a Site Setting

### Definition & Example Request

```http
GET /wp/v2/settings
```

Query this endpoint to retrieve a specific Site Setting record.

```bash
curl https://example.com/wp-json/wp/v2/settings
```

There are no arguments for this endpoint.

## Update a Site Setting

### Arguments

- `title`: Site title.
- `description`: Site tagline.
- `url`: Site URL.
- `email`: This address is used for admin purposes, like new user notification.
- `timezone`: A city in the same timezone as you.
- `date_format`: A date format for all date strings.
- `time_format`: A time format for all time strings.
- `start_of_week`: A day number of the week that the week should start on.
- `language`: WordPress locale code.
- `use_smilies`: Convert emoticons like :-) and :-P to graphics on display.
- `default_category`: Default post category.
- `default_post_format`: Default post format.
- `posts_per_page`: Blog pages show at most.
- `show_on_front`: What to show on the front page
- `page_on_front`: The ID of the page that should be displayed on the front page
- `page_for_posts`: The ID of the page that should display the latest posts
- `default_ping_status`: Allow link notifications from other blogs (pingbacks and trackbacks) on new articles. One of: `open`, `closed`
- `default_comment_status`: Allow people to submit comments on new posts. One of: `open`, `closed`
- `site_logo`: Site logo.
- `site_icon`: Site icon.

### Definition

```http
POST /wp/v2/settings
```

### Example Request
