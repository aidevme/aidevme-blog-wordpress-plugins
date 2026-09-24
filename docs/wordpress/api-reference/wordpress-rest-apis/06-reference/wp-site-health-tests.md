# Wp Site Health Tests

Reference: <https://developer.wordpress.org/rest-api/reference/wp-site-health-tests/>

## Schema

The schema defines all the fields that exist within a wp site health test record. Any response from these endpoints can be expected to contain the fields below unless the `_filter` query parameter is used or the schema field only appears in a specific context.

- `test`: The name of the test being run.
  - JSON data type: string
  - Read only
  - Context:
- `label`: A label describing the test.
  - JSON data type: string
  - Read only
  - Context:
- `status`: The status of the test.
  - JSON data type: string
  - Read only
  - Context:
  - One of: `good`, `recommended`, `critical`
- `badge`: The category this test is grouped in.
  - JSON data type: object
  - Read only
  - Context:
- `description`: A more descriptive explanation of what the test looks for, and why it is important for the user.
  - JSON data type: string
  - Read only
  - Context:
- `actions`: HTML containing an action to direct the user to where they can resolve the issue.
  - JSON data type: string
  - Read only
  - Context:

## Retrieve a Wp Site Health Test

### Definition & Example Request

```http
GET /wp-site-health/v1/tests/background-updates
```

Query this endpoint to retrieve a specific wp site health test record.

```bash
curl https://example.com/wp-json/wp-site-health/v1/tests/background-updates
```

There are no arguments for this endpoint.

## Retrieve a Wp Site Health Test

### Definition & Example Request

```http
GET /wp-site-health/v1/tests/loopback-requests
```

Query this endpoint to retrieve a specific wp site health test record.

```bash
curl https://example.com/wp-json/wp-site-health/v1/tests/loopback-requests
```

There are no arguments for this endpoint.

## Retrieve a Wp Site Health Test

### Definition & Example Request

```http
GET /wp-site-health/v1/tests/https-status
```

Query this endpoint to retrieve a specific wp site health test record.

```bash
curl https://example.com/wp-json/wp-site-health/v1/tests/https-status
```

There are no arguments for this endpoint.

## Retrieve a Wp Site Health Test

### Definition & Example Request

```http
GET /wp-site-health/v1/tests/dotorg-communication
```

Query this endpoint to retrieve a specific wp site health test record.

```bash
curl https://example.com/wp-json/wp-site-health/v1/tests/dotorg-communication
```

There are no arguments for this endpoint.

## Retrieve a Wp Site Health Test

### Definition & Example Request

```http
GET /wp-site-health/v1/tests/authorization-header
```

Query this endpoint to retrieve a specific wp site health test record.

```bash
curl https://example.com/wp-json/wp-site-health/v1/tests/authorization-header
```

There are no arguments for this endpoint.
