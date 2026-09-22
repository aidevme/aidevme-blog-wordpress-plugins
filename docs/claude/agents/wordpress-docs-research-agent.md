# wordpress-docs-research-agent

Syncs the local WordPress Plugin Handbook mirror in `docs/wordpress/wordpress-plugins/` against its live source on `developer.wordpress.org`, using a real headless browser (Playwright MCP) instead of guessing content.

Source definition: [`.claude/agents/wordpress-docs-research-agent.md`](../../../.claude/agents/wordpress-docs-research-agent.md)

## At a glance

| | |
| --- | --- |
| **Role** | Handbook mirror sync / research |
| **Model** | `sonnet` |
| **Writes** | Files under `docs/wordpress/wordpress-plugins/` and the Index table in its `index.md` |
| **Reads** | `docs/wordpress/wordpress-plugins/index.md` and the live pages listed in its **Reference Url** column |
| **Invoked via** | The `/sync-wordpress-plugin-docs` slash command, or directly by name |
| **Tools** | `Read`, `Edit`, `Write`, `Grep`, `Glob`, `Bash`, plus `mcp__playwright__browser_navigate`, `browser_snapshot`, `browser_evaluate`, `browser_close`, `browser_wait_for` |

## Purpose

The other agents treat `docs/wordpress/wordpress-plugins/` as the authoritative WordPress reference. This agent is the only one allowed to author it, and it does so exclusively from what a browser actually rendered during the run - never from memory.

## When to use it

Trigger phrases from the agent's description: "sync the WordPress docs", "refresh the plugin handbook", "check for doc updates", "re-sync index.md", "update docs from source".

### The slash command

`/sync-wordpress-plugin-docs [scope]` ([`.claude/commands/sync-wordpress-plugin-docs.md`](../../../.claude/commands/sync-wordpress-plugin-docs.md)) launches this agent:

- With an argument (an `Index` number or `Name` from the Index table, for example `19` or `Hooks`), only those rows are synced.
- With no argument, every row is synced.
- The agent runs in the foreground, since the user is waiting on it, and its final summary is relayed back.

## Source of truth: the Index table

`docs/wordpress/wordpress-plugins/index.md` has an `## Index` table:

| Column | Meaning |
| --- | --- |
| **Index** | Hierarchical position (`5`, `5.1`), mirroring `##` / `###` heading depth |
| **Name** | The heading text |
| **Document** | Relative markdown link to the file holding this section's content |
| **Reference Url** | The `developer.wordpress.org` page the section is sourced from |
| **Last Synced On** | ISO 8601 UTC timestamp (`YYYY-MM-DDTHH:MM:SSZ`) of the last refresh |
| **Notes** | Free text, for flags like "real slug differs" or "content moved to Common APIs Handbook" |

## What it does when invoked

1. Reads `index.md` in full and parses the Index table.
2. Decides scope: only the named rows if the request names any; otherwise every row, oldest `Last Synced On` first (or all rows if none have been synced).
3. For each row in scope:
   1. Navigates to the **Reference Url** with `browser_navigate`.
   2. If the page redirects or shows a "this content has moved" notice, follows it and uses the final resolved URL as the real reference.
   3. Extracts the actual page content with `browser_snapshot`, or `browser_evaluate` (for example `document.querySelector('.entry-content')?.innerText`), covering headings, paragraphs, lists and code samples.
   4. Converts it to the mirror's format (below) and overwrites the file named in **Document**.
   5. Updates the row: **Last Synced On** set to the real current UTC time (obtained with `date -u +%Y-%m-%dT%H:%M:%SZ` via `Bash`, not approximated), and **Notes** set to `Synced` or `Synced - {short reason}` (for example when the resolved URL differed or content moved). If the resolved URL differs from the table's, that cell is updated too.
   6. Closes the page with `browser_close` before the next row so tabs don't pile up.
4. Reports a compact summary: rows checked, files whose content actually changed versus already current, and any failures (404, moved permanently, couldn't extract) with what is needed to resolve them.

## Output format of a mirror file

- `# {Heading}` as the first line
- A blank line, then `Reference: <{final resolved url}>`
- A blank line, then `## {Subheading}` sections as clean prose paragraphs and `-` bullet lists
- PHP/JS/JSON code kept in fenced code blocks
- Straight quotes (not curly), no scraped author/date byline, no added commentary

The full conventions (folder layout, Index format, document skeleton, content-fidelity rules) live in [`docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md`](../../styles/WORDPRESS-PLUGIN-DOCS-STYLE.md). Per root `CLAUDE.md`, that style guide and this agent's definition are meant to stay identical; change one, update the other.

## Rules

- **Never invent or paraphrase from memory.** Every file's content must come from what the browser rendered during this run.
- **Preserve numbering and layout:** `N`, `N.1`, `N.2`, ... and `0N-slug/` folders (one per `##` section, holding one `.md` per `###` sub-item plus the section's overview file).
- **Unchanged content:** still bump **Last Synced On** (it was verified), but only rewrite a file if the extracted content actually differs.
- **Timestamps:** always UTC, always the exact `YYYY-MM-DDTHH:MM:SSZ` format; never mix bare dates and timestamps in the table.
- **Failures:** on a 404 or a gone page, leave the file as-is, set **Notes** to describe it (for example `Sync failed - 404`), and never blank out existing content.
- **No git actions:** it doesn't push, commit or open PRs; that is for the user to decide.

## Playwright server requirement

The agent's tools are scoped to the `mcp__playwright__*` server defined in the repo's `.mcp.json`:

```json
{
  "mcpServers": {
    "playwright": {
      "command": "npx",
      "args": ["-y", "@playwright/mcp@latest", "--headless"]
    }
  }
}
```

The server is enabled through `.claude/settings.local.json` (`enabledMcpjsonServers: ["playwright"]`). It runs `--headless` and should not be swapped for a different Playwright MCP server (for example one shipped by another plugin), since headlessness isn't guaranteed there.

## Boundaries

- It is the only agent that writes under `docs/wordpress/wordpress-plugins/`; [`architect`](architect.md), [`developer`](developer.md) and [`documenter`](documenter.md) are all told never to touch that folder.
- It writes local files only and does not touch plugin code under `src/`.
