---
description: Weekly sync of the WP-CLI command reference mirror in docs/wordpress/api-reference/wp-cli-commands/ against developer.wordpress.org
on:
  schedule: weekly on monday
  workflow_dispatch:
    inputs:
      rows:
        description: "Optional Index numbers or Names to sync, comma-separated (e.g. '09, wp_core'). Empty = the 10 least recently synced rows."
        required: false
        type: string
permissions:
  contents: read
engine: claude
timeout-minutes: 45
network:
  allowed:
    - defaults
    - developer.wordpress.org
tools:
  playwright:
  edit:
  bash:
    - "date -u +%Y-%m-%dT%H:%M:%SZ"
    - "git diff --stat"
    - "git status --short"
safe-outputs:
  create-pull-request:
    title-prefix: "docs(wp-cli): "
    labels: [documentation, automated]
    draft: true
  noop:
---

# Sync WP-CLI command documentation

Keep the WP-CLI command reference mirror in `docs/wordpress/api-reference/wp-cli-commands/` in sync with its live source on developer.wordpress.org, and open a pull request with any changes.

## Rules

`.claude/agents/wordpress-docs-research-agent.md` is the source of truth for how this mirror is synced. Read it first and follow its **"WP-CLI commands mirror"** section and its **Rules** section exactly (file skeleton, subcommands under their own `##` headings, Index table columns, `Last Synced On` and `Notes` conventions, failure handling). Ignore its Plugin Handbook parts and its instructions about slash commands and `mcp__playwright__*` tool names; use the Playwright browser tool available in this workflow instead.

## Scope

The table to work from is `docs/wordpress/api-reference/wp-cli-commands/index.md`.

- If the workflow was started manually with a `rows` input (`${{ github.event.inputs.rows }}`), sync only those rows, matched by their `Index` or `Name` column.
- Otherwise sync the **10 rows with the oldest `Last Synced On`**, treating blank values as oldest, in Index order. Over the weekly runs this rotates through all 46 commands.

## Steps

For each row in scope:

1. Open the row's **Reference Url** with Playwright. Follow redirects and use the final resolved URL.
2. Extract the full page content from what the browser actually rendered: description, synopsis, options, examples, subcommands, and the content of each linked subcommand page (fetch these from within the browser session). Never write content from memory.
3. Rewrite the file in the row's **Document** column only if the extracted content differs from what is there.
4. Update the row in the Index table: **Last Synced On** set to the output of `date -u +%Y-%m-%dT%H:%M:%SZ` (run it, do not guess) and **Notes** set to `Synced`, or `Synced — {short reason}` / `Sync failed — {reason}` as the rules describe.

## Output

- If any file or Index row changed, create a **draft pull request** containing only files under `docs/wordpress/api-reference/wp-cli-commands/`. Title: `sync WP-CLI docs ({n} commands)`. Body: a table of the commands checked, whether each one's content changed or was already current, and any failures with the reason.
- If nothing changed and no row failed, call `noop` with a one-line explanation. A run that only bumps timestamps still counts as changed, since the Index rows are updated.

## Constraints

- Only touch files inside `docs/wordpress/api-reference/wp-cli-commands/`.
- Never add, rename, renumber or delete folders, files or Index rows. If a command has disappeared from the live site, report it in the PR body instead.
- Leave a file untouched when its page is a 404 or stub, and record the failure in **Notes**.
- Do not merge, push to `main`, or modify workflows, agents or commands.
