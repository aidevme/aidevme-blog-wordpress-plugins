---
description: Sync docs/wordpress/api-reference/wp-cli-commands/ against developer.wordpress.org using the research agent
argument-hint: [optional: Index number(s) or Name(s) to limit the sync, e.g. "09" or "wp_core"]
---

Invoke the `researcher` subagent (via the Agent tool) in mode `wordpress-wp-cli-command-docs` to sync the WP-CLI command reference mirror under `docs/wordpress/api-reference/wp-cli-commands/` against its live source on developer.wordpress.org. Tell the agent to work only from `docs/wordpress/api-reference/wp-cli-commands/index.md`, not the Plugin Handbook index.

Scope: $ARGUMENTS

- If arguments were given above, pass them to the agent as the rows to limit the sync to (matching the `Index` or `Name` columns of the Index table, e.g. `09` or `wp_core`).
- If no arguments were given, tell the agent to sync every row in the Index table.

Run the agent in the foreground (not background) since the user is waiting on this command directly, and relay its final summary (rows checked, files changed vs. already current, any failures) back to the user when it completes.
