---
description: Weekly sync of the WordPress Plugin Handbook mirror in docs/wordpress/wordpress-plugins/ against developer.wordpress.org
on:
  schedule: weekly on tuesday
  workflow_dispatch:
    inputs:
      rows:
        description: "Optional Index numbers or Names to sync, comma-separated (e.g. '3.1, Header Requirements'). Empty = the 15 least recently synced rows."
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
    title-prefix: "docs(wordpress-plugins): "
    labels: [documentation, automated]
    draft: true
  noop:
---

# Sync WordPress Plugin Handbook documentation

Keep the Plugin Handbook mirror in `docs/wordpress/wordpress-plugins/` in sync with its live source on developer.wordpress.org, and open a pull request with any changes.

## Rules

`.claude/agents/wordpress-docs-research-agent.md` is the source of truth for how this mirror is synced, and `docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md` defines the folder layout, Index format, document skeleton and content-fidelity rules. Read both first and follow the Plugin Handbook parts exactly (the "Source of truth (Plugin Handbook)", "What to do when invoked" and "Rules" sections). Ignore the "WP-CLI commands mirror" section, its instructions about slash commands, and `mcp__playwright__*` tool names; use the Playwright browser tool available in this workflow instead.

## Scope

The table to work from is `docs/wordpress/wordpress-plugins/index.md`.

- If the workflow was started manually with a `rows` input (`${{ github.event.inputs.rows }}`), sync only those rows, matched by their `Index` (e.g. `5`, `5.1`) or `Name` column.
- Otherwise sync the **15 rows with the oldest `Last Synced On`**, treating blank values as oldest, in Index order. The table has about 100 rows, so weekly runs rotate through all of them.

## Steps

For each row in scope:

1. Open the row's **Reference Url** with Playwright. Follow redirects and use the final resolved URL; if it differs from the table, update the **Reference Url** cell and say so in **Notes**.
2. Extract the page content from what the browser actually rendered (headings, paragraphs, lists, code samples). Never write content from memory.
3. Convert it to the mirror's document skeleton and rewrite the file in the row's **Document** column only if the extracted content differs from what is there.
4. Update the row in the Index table: **Last Synced On** set to the output of `date -u +%Y-%m-%dT%H:%M:%SZ` (run it, do not guess), and **Notes** set to `Synced`, `Synced — {short reason}` or `Sync failed — {reason}` as the rules describe.

## Output

- If any file or Index row changed, create a **draft pull request** containing only files under `docs/wordpress/wordpress-plugins/`. Title: `sync Plugin Handbook docs ({n} pages)`. Body: a table of the pages checked, whether each one's content changed or was already current, and any failures with the reason.
- If nothing changed and no row failed, call `noop` with a one-line explanation. A run that only bumps timestamps still counts as changed, since the Index rows are updated.

## Constraints

- Only touch files inside `docs/wordpress/wordpress-plugins/`.
- Never add, rename, renumber or delete folders, files or Index rows. If a page has disappeared from the live site, report it in the PR body instead.
- Leave a file untouched when its page is a 404 or stub, and record the failure in **Notes**.
- Do not merge, push to `main`, or modify workflows, agents, commands or the style guide.
