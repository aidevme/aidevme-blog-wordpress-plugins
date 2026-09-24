# /sync-wordpress-wp-cli-command-docs

Refreshes the local WP-CLI command reference mirror in `docs/wordpress/api-reference/wp-cli-commands/` from its live source on developer.wordpress.org.

Source definition: [`.claude/commands/sync-wordpress-wp-cli-command-docs.md`](../../../.claude/commands/sync-wordpress-wp-cli-command-docs.md)

## At a glance

| | |
| --- | --- |
| **Purpose** | Sync the WP-CLI command reference mirror against the live handbook |
| **Argument hint** | `[optional: Index number(s) or Name(s) to limit the sync, e.g. "09" or "wp_core"]` |
| **Runs** | The [`researcher`](../agents/researcher.md) agent, mode `wordpress-wp-cli-command-docs` |
| **Reads** | `docs/wordpress/api-reference/wp-cli-commands/index.md` and the live pages in its **Reference Url** column |
| **Writes** | Files named in the Index table's **Document** column, and the **Last Synced On** and **Notes** cells of the rows it processes |
| **Execution** | Foreground; the agent's summary is relayed to the user |

## Usage

```text
/sync-wordpress-wp-cli-command-docs
/sync-wordpress-wp-cli-command-docs 09
/sync-wordpress-wp-cli-command-docs wp_core
```

- **No argument:** every row (46 commands) is synced.
- **With an argument:** only the rows matching that `Index` number (`01` to `46`) or `Name` (for example `wp_core`).

## What it does

1. Passes the scope (`$ARGUMENTS`) to the `researcher` agent with the mode `wordpress-wp-cli-command-docs`, and tells it to work only from the WP-CLI `index.md`.
2. The agent opens each command's **Reference Url** (`https://developer.wordpress.org/cli/commands/<command>/`) in a headless browser and extracts the whole page: description, synopsis, options, examples and subcommands.
3. It fetches each linked subcommand page and writes it under its own `##` heading in the command's single md file (for example `01-wp_ability/wp_ability.md`). Shell usage is kept in `bash` code blocks.
4. It updates **Last Synced On** (real UTC time) and **Notes**, then reports rows checked, files changed versus already current, and any failures.

Folders and numbering are fixed by the Index table. A command that has disappeared from the live site is reported, not removed.

## Related

- [researcher](../agents/researcher.md) - the agent and its modes
- GitHub workflow `sync-wp-cli-docs` - the scheduled equivalent, which opens a draft pull request
