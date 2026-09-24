# /sync-wordpress-plugin-docs

Refreshes the local WordPress Plugin Handbook mirror in `docs/wordpress/wordpress-plugins/` from its live source on developer.wordpress.org.

Source definition: [`.claude/commands/sync-wordpress-plugin-docs.md`](../../../.claude/commands/sync-wordpress-plugin-docs.md)

## At a glance

| | |
| --- | --- |
| **Purpose** | Sync the Plugin Handbook mirror against the live handbook |
| **Argument hint** | `[optional: section number(s) or name(s) to limit the sync, e.g. "19" or "Hooks"]` |
| **Runs** | The [`researcher`](../agents/researcher.md) agent, mode `wordpress-plugin-docs` |
| **Reads** | `docs/wordpress/wordpress-plugins/index.md` and the live pages in its **Reference Url** column |
| **Writes** | Files named in the Index table's **Document** column, and the **Last Synced On** and **Notes** cells of the rows it processes |
| **Execution** | Foreground; the agent's summary is relayed to the user |

## Usage

```text
/sync-wordpress-plugin-docs
/sync-wordpress-plugin-docs 19
/sync-wordpress-plugin-docs Hooks
```

- **No argument:** every row in the Index table is synced, unsynced rows first and then oldest `Last Synced On`.
- **With an argument:** only the rows matching that `Index` number or `Name` are synced.

## What it does

1. Passes the scope (`$ARGUMENTS`) to the `researcher` agent along with the mode `wordpress-plugin-docs`.
2. The agent opens each row's **Reference Url** in a headless browser, extracts the rendered content, and rewrites the row's **Document** file in the mirror's skeleton (`# Heading`, `Reference: <url>`, `##` sections, fenced code).
3. It updates **Last Synced On** (real UTC time) and **Notes** for the row, then reports rows checked, files changed versus already current, and any failures.

Numbering and folder layout (`0N-slug/` per section) are fixed by the Index table; the agent never adds, renames or renumbers anything.

## Related

- [researcher](../agents/researcher.md) - the agent and its modes
- [`docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md`](../../styles/WORDPRESS-PLUGIN-DOCS-STYLE.md) - conventions for this mirror
- GitHub workflow `sync-wordpress-plugins-docs` - the scheduled equivalent, which opens a draft pull request
