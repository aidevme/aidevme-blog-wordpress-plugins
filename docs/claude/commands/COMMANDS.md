# Claude Code commands

Documentation for the project-level Claude Code slash commands defined in [`.claude/commands/`](../../../.claude/commands/). Each command has its own file here; this page is the overview.

These docs describe the command definitions as they exist in the repo (snapshot: 2026-09-24). The `.claude/commands/*.md` files are the source of truth - when one changes, update its page here.

## Commands

| Command | Purpose | Agent and mode | Syncs | Doc |
| --- | --- | --- | --- | --- |
| `/sync-wordpress-plugin-docs` | Refresh the WordPress Plugin Handbook mirror | [`researcher`](../agents/researcher.md), `wordpress-plugin-docs` | `docs/wordpress/wordpress-plugins/` | [sync-wordpress-plugin-docs.md](sync-wordpress-plugin-docs.md) |
| `/sync-wordpress-rest-api-docs` | Refresh the REST API Handbook mirror | [`researcher`](../agents/researcher.md), `wordpress-rest-api-docs` | `docs/wordpress/api-reference/wordpress-rest-apis/` | [sync-wordpress-rest-api-docs.md](sync-wordpress-rest-api-docs.md) |
| `/sync-wordpress-wp-cli-command-docs` | Refresh the WP-CLI command reference mirror | [`researcher`](../agents/researcher.md), `wordpress-wp-cli-command-docs` | `docs/wordpress/api-reference/wp-cli-commands/` | [sync-wordpress-wp-cli-command-docs.md](sync-wordpress-wp-cli-command-docs.md) |

All three do the same job for a different mirror: they launch the `researcher` agent in the matching mode, which visits each row's **Reference Url** with a headless browser and rewrites the local document from what was actually rendered.

## How they work

Every command follows the same pattern:

1. **Optional scope.** The text typed after the command name (`$ARGUMENTS`) limits the sync to specific rows of the mirror's Index table, matched by their `Index` or `Name` column. With no argument, every row is synced.
2. **Agent call.** The command tells Claude to invoke the `researcher` subagent through the Agent tool, name the mode, and point it at that mirror's `index.md` only.
3. **Foreground run.** The agent runs in the foreground because the user is waiting on the command, and its final summary is relayed back: rows checked, files changed versus already current, and any failures or missing pages.

Each run rewrites files under `docs/wordpress/` and updates **Last Synced On** and **Notes** in the mirror's Index table. Nothing is committed or pushed.

## Scope arguments at a glance

| Command | Index style | Examples |
| --- | --- | --- |
| `/sync-wordpress-plugin-docs` | Hierarchical, `5`, `5.1` | `19`, `Hooks` |
| `/sync-wordpress-rest-api-docs` | Hierarchical, `4.1`, `6.40`; "with sub-pages" or "all of section N" includes the `N.x` rows | `4.1`, `6.3`, `key-concepts` |
| `/sync-wordpress-wp-cli-command-docs` | Two digits, `01`-`46` | `09`, `wp_core` |

## How to invoke a command

Type it in Claude Code with an optional scope:

```text
/sync-wordpress-wp-cli-command-docs wp_core
/sync-wordpress-rest-api-docs 4.1
/sync-wordpress-plugin-docs
```

Run a single row first before a full sync. The REST API mirror has 55 rows, the Plugin Handbook about 100 and the WP-CLI mirror 46, so a full run is long.

## Automated equivalents

Two of these mirrors are also refreshed on a schedule by GitHub agentic workflows, which open draft pull requests instead of editing your working tree:

| Workflow | Mirror | Schedule |
| --- | --- | --- |
| `sync-wordpress-plugins-docs` | Plugin Handbook | Weekly, Tuesday, 15 least recently synced rows |
| `sync-wp-cli-docs` | WP-CLI commands | Weekly, Monday, 10 least recently synced rows |

There is no workflow for the REST API mirror yet. The workflows read their rules from [`.claude/agents/researcher.md`](../../../.claude/agents/researcher.md), the same file the commands rely on.

## Configuration these commands depend on

| File | What it provides |
| --- | --- |
| [`.claude/commands/*.md`](../../../.claude/commands/) | The command definitions: YAML frontmatter (`description`, `argument-hint`) followed by the instructions Claude runs |
| [`.claude/agents/researcher.md`](../../../.claude/agents/researcher.md) | The agent, its modes and the sync procedure ([agent documentation](../agents/researcher.md)) |
| `.mcp.json` | Defines the headless `playwright` MCP server the agent uses to read the live pages |
| `.claude/settings.local.json` | Enables the project's `playwright` MCP server (`enabledMcpjsonServers`) |

## Scope of this documentation

Only the three commands defined in this repository. Built-in commands (such as `/help` or `/init`) and commands supplied by installed plugins are not covered here.

## Related

- [Claude Code agents](../agents/AGENTS.md) - overview of the project's subagents
- [`docs/styles/`](../../styles/) - documentation style guides that the mirror modes follow
