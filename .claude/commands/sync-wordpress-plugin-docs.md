---
description: Sync docs/wordpress/wordpress-plugins/ against developer.wordpress.org using the research agent
argument-hint: [optional: section number(s) or name(s) to limit the sync, e.g. "19" or "Hooks"]
---

Invoke the `wordpress-docs-research-agent` subagent (via the Agent tool) to sync the WordPress Plugin Handbook mirror under `docs/wordpress/wordpress-plugins/` against its live source on developer.wordpress.org.

Scope: $ARGUMENTS

- If arguments were given above, pass them to the agent as the rows/sections to limit the sync to (matching the Index table's `Index` or `Name` columns in `docs/wordpress/wordpress-plugins/index.md`).
- If no arguments were given, tell the agent to sync every row in the Index table.

Run the agent in the foreground (not background) since the user is waiting on this command directly, and relay its final summary (rows checked, files changed vs. already current, any failures) back to the user when it completes.
