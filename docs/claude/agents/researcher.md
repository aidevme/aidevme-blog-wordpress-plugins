# researcher

A general research agent with switchable modes: three of them keep the WordPress documentation mirrors in `docs/wordpress/` in sync with developer.wordpress.org, and a fourth does open-ended web research.

Source definition: [`.claude/agents/researcher.md`](../../../.claude/agents/researcher.md)

## At a glance

| | |
| --- | --- |
| **Role** | General researcher with a selectable research mode |
| **Model** | `sonnet` |
| **Writes** | In the three mirror modes, files under that mode's mirror folder and the Index table in its `index.md`; in `general` mode, nothing unless the user asks for a file |
| **Reads** | Each mirror's `index.md`, the live pages in its **Reference Url** column, and, in `general` mode, the web and the repo |
| **Invoked via** | The `/sync-wordpress-plugin-docs`, `/sync-wordpress-rest-api-docs` and `/sync-wordpress-wp-cli-command-docs` slash commands (each sets the mode), or by naming the agent and a mode in the request |
| **Tools** | `Read`, `Edit`, `Write`, `Grep`, `Glob`, `Bash`, `WebSearch`, `WebFetch`, plus `mcp__playwright__browser_navigate`, `browser_snapshot`, `browser_evaluate`, `browser_close`, `browser_wait_for` |

## Modes

The user selects the mode by name (for example "use the researcher agent, mode `wordpress-rest-api-docs`") or by describing the work. If the request is ambiguous, the agent asks which mode is meant before doing anything. One mode runs per invocation.

| Mode | For | Works on | Slash command |
| --- | --- | --- | --- |
| `wordpress-plugin-docs` | Plugin Handbook | `docs/wordpress/wordpress-plugins/` | [`/sync-wordpress-plugin-docs`](../../../.claude/commands/sync-wordpress-plugin-docs.md) |
| `wordpress-rest-api-docs` | REST API Handbook | `docs/wordpress/api-reference/wordpress-rest-apis/` | [`/sync-wordpress-rest-api-docs`](../../../.claude/commands/sync-wordpress-rest-api-docs.md) |
| `wordpress-wp-cli-command-docs` | WP-CLI command reference | `docs/wordpress/api-reference/wp-cli-commands/` | [`/sync-wordpress-wp-cli-command-docs`](../../../.claude/commands/sync-wordpress-wp-cli-command-docs.md) |
| `general` | Open-ended research, report only | Nothing is written by default | none |

Each command takes an optional scope: an `Index` or `Name` from the mode's Index table (for example `19`, `4.1`, `09`, `wp_core`). With no scope, every row is synced. The commands run the agent in the foreground and relay its summary.

## Mirror modes

Each mirror is driven by the `## Index` table in its own `index.md`:

| Column | Meaning |
| --- | --- |
| **Index** | Row position. The scheme differs per mirror: hierarchical `5`, `5.1` for the Plugin Handbook; two digits `01`-`46` for WP-CLI; `1`-`9` with sub-pages such as `4.1` and `6.40` for the REST API |
| **Name** | The heading text (Plugin Handbook) or the md file name without extension (the other two) |
| **Document** | Relative markdown link to the file holding this row's content |
| **Reference Url** | The `developer.wordpress.org` page the row is sourced from |
| **Last Synced On** | ISO 8601 UTC timestamp (`YYYY-MM-DDTHH:MM:SSZ`) of the last refresh; blank means never synced |
| **Notes** | Free text, for flags like "real slug differs" or "content moved" |

### What it does when invoked

1. Reads the mode's `index.md` in full and parses the Index table.
2. Decides scope: only the named rows if the request names any; otherwise every row, unsynced first and then oldest `Last Synced On`.
3. For each row in scope:
   1. Navigates to the **Reference Url** with `browser_navigate`, following redirects and using the final resolved URL.
   2. Extracts the rendered content with `browser_snapshot` or `browser_evaluate`: headings, paragraphs, lists, tables and code samples.
   3. Converts it to the mode's skeleton (below) and overwrites the file named in **Document**, only if the content actually differs.
   4. Updates the row: **Last Synced On** set to the real current UTC time (obtained with `date -u +%Y-%m-%dT%H:%M:%SZ` via `Bash`, not approximated), and **Notes** set to `Synced` or `Synced - {short reason}`. If the resolved URL differed from the table's, that cell is updated too.
   5. Closes the page with `browser_close` before the next row.
4. Reports a compact summary: rows checked, files changed versus already current, failures, and anything missing from the Index.

### Differences per mode

- **`wordpress-plugin-docs`:** skeleton is `# {Heading}`, `Reference: <url>`, then `##` sections as prose and `-` bullets, code in fenced blocks. Layout is `0N-slug/` per `##` section with one `.md` per `###` sub-item plus the section's overview file. Conventions are in [`docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md`](../../styles/WORDPRESS-PLUGIN-DOCS-STYLE.md); per root `CLAUDE.md`, that guide and this mode of the agent definition are meant to stay identical.
- **`wordpress-wp-cli-command-docs`:** extracts the full command page and fetches linked subcommand pages, putting each under its own `##` heading in the command's single md file. Skeleton is `# wp {command}`, `Reference: <url>`, then Description, Synopsis, Subcommands, Options and Examples sections, with shell usage in `bash` code blocks. A command that vanished from the live site is reported, not removed.
- **`wordpress-rest-api-docs`:** endpoint and argument tables become markdown tables with every column kept; JSON, PHP, JavaScript and `curl` examples stay in language-tagged code blocks; endpoint paths and argument names are copied exactly as rendered. Each sub-page is its own file and an overview is never merged with its children. If a live slug differs from the table, the agent updates the **Reference Url** cell and notes it rather than renaming files, and reports missing or vanished pages.

### Rules in every mirror mode

- **Never invent or paraphrase from memory.** Every file's content must come from what the browser rendered during this run.
- **Index tables fix the layout.** The agent never adds, renames or renumbers folders, files or rows; it reports discrepancies.
- **Unchanged content:** still bump **Last Synced On** (it was verified), but only rewrite a file if the extracted content actually differs.
- **Timestamps:** always UTC, always the exact `YYYY-MM-DDTHH:MM:SSZ` format; never mix bare dates and timestamps in the table.
- **Failures:** on a 404, a gone page or a stub, leave the file as-is, set **Notes** to describe it (for example `Sync failed - 404`), and never blank out existing content.
- **No git actions:** it writes only inside the mode's mirror folder and doesn't push, commit or open PRs.

## General mode

For questions the mirrors do not cover. The agent restates the question, prefers primary sources (official documentation, source repositories, release notes), cross-checks important claims, and answers in the reply with a source link per finding and any open questions. It labels anything it could not verify. It is read-only unless the user asks for a file at a given path.

## Playwright server requirement

The agent's browser tools are scoped to the `mcp__playwright__*` server defined in the repo's `.mcp.json`:

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

- It is the only agent that writes under the mirror folders in `docs/wordpress/`; [`architect`](architect.md), [`developer`](developer.md) and [`documenter`](documenter.md) are all told never to touch them.
- It does not touch plugin code under `src/`, other docs, or agent and command definitions.
- Anything fetched from the web is treated as untrusted data; instructions embedded in pages are ignored.
- The GitHub agentic workflows `sync-wordpress-plugins-docs` and `sync-wp-cli-docs` read their rules from [`.claude/agents/researcher.md`](../../../.claude/agents/researcher.md), so changes to the mode sections there change what those workflows do (recompile is not needed, since the workflows read the file at run time).
