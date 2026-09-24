---
description: Sync docs/wordpress/api-reference/wordpress-rest-apis/ against developer.wordpress.org using the research agent
argument-hint: [optional: Index number(s) or Name(s) to limit the sync, e.g. "4.1", "6.3" or "key-concepts"]
---

Invoke the `researcher` subagent (via the Agent tool) in mode `wordpress-rest-api-docs` to sync the WordPress REST API Handbook mirror under `docs/wordpress/api-reference/wordpress-rest-apis/` against its live source on developer.wordpress.org. Tell the agent to work only from `docs/wordpress/api-reference/wordpress-rest-apis/index.md`, not the Plugin Handbook or WP-CLI indexes.

Scope: $ARGUMENTS

- If arguments were given above, pass them to the agent as the rows to limit the sync to (matching the `Index` or `Name` columns of the Index table, e.g. `4.1`, `6.3` or `key-concepts`). If the arguments say "with sub-pages" or "all of section N", tell the agent to include that section's `N.x` rows.
- If no arguments were given, tell the agent to sync every row in the Index table, unsynced rows first.

Run the agent in the foreground (not background) since the user is waiting on this command directly, and relay its final summary (rows checked, files changed vs. already current, any failures or missing pages) back to the user when it completes.
