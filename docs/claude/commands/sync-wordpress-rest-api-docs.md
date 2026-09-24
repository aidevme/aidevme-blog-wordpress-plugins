# /sync-wordpress-rest-api-docs

Refreshes the local WordPress REST API Handbook mirror in `docs/wordpress/api-reference/wordpress-rest-apis/` from its live source on developer.wordpress.org.

Source definition: [`.claude/commands/sync-wordpress-rest-api-docs.md`](../../../.claude/commands/sync-wordpress-rest-api-docs.md)

## At a glance

| | |
| --- | --- |
| **Purpose** | Sync the REST API Handbook mirror against the live handbook |
| **Argument hint** | `[optional: Index number(s) or Name(s) to limit the sync, e.g. "4.1", "6.3" or "key-concepts"]` |
| **Runs** | The [`researcher`](../agents/researcher.md) agent, mode `wordpress-rest-api-docs` |
| **Reads** | `docs/wordpress/api-reference/wordpress-rest-apis/index.md` and the live pages in its **Reference Url** column |
| **Writes** | Files named in the Index table's **Document** column, and the **Last Synced On** and **Notes** cells of the rows it processes |
| **Execution** | Foreground; the agent's summary is relayed to the user |

## Usage

```text
/sync-wordpress-rest-api-docs
/sync-wordpress-rest-api-docs 4.1
/sync-wordpress-rest-api-docs key-concepts
/sync-wordpress-rest-api-docs all of section 6
```

- **No argument:** every row in the Index table is synced, unsynced rows first.
- **With an index or name:** only those rows are synced. A bare section number such as `6` selects just that row.
- **"with sub-pages" or "all of section N":** the section's `N.x` rows are included too. The Reference section (`6.1` to `6.40`) is the largest, so scope it deliberately.

## What it does

1. Passes the scope (`$ARGUMENTS`) to the `researcher` agent with the mode `wordpress-rest-api-docs`, and tells it to work only from the REST API `index.md`.
2. The agent opens each row's **Reference Url** in a headless browser and extracts the rendered page, including endpoint and argument tables and code examples.
3. It rewrites the row's **Document** file: tables kept as markdown tables with every column, JSON/PHP/JavaScript/`curl` examples in language-tagged code blocks, endpoint paths and argument names exactly as rendered.
4. It updates **Last Synced On** (real UTC time) and **Notes**, then reports rows checked, files changed versus already current, failures, and any live child pages missing from the Index.

If a page's live slug differs from the table, the agent updates the **Reference Url** cell and notes it in **Notes**; it does not rename files.

## Related

- [researcher](../agents/researcher.md) - the agent and its modes
- There is no scheduled GitHub workflow for this mirror yet.
