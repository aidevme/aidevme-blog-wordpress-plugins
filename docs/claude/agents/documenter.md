# documenter

Keeps the repo's non-handbook documentation honest and current: plugin READMEs, `SPECIFICATION.md` accuracy after implementation, PHP docblocks, root `CLAUDE.md` and root `README.md`. It documents what exists; it does not write documentation speculatively ahead of the code.

Source definition: [`.claude/agents/documenter.md`](../../../.claude/agents/documenter.md)

## At a glance

| | |
| --- | --- |
| **Role** | Documentation maintainer / drift catcher |
| **Model** | `sonnet` |
| **Writes** | `src/<plugin-slug>/README.md`, `SPECIFICATION.md` corrections, PHP docblocks, root `CLAUDE.md`, root `README.md` |
| **Reads** | The actual current code, plus existing docs, before describing any behavior |
| **Never touches** | `docs/wordpress/wordpress-plugins/` (owned by [`wordpress-docs-research-agent`](wordpress-docs-research-agent.md)) |
| **Tools** | `Read`, `Write`, `Edit`, `Grep`, `Glob`, `Bash`, plus `microsoft_docs_search` and `microsoft_docs_fetch` (no code-sample search) |

## Purpose

Documentation drifts from code. This agent's job is to notice where it has and fix it, or flag it for the [`developer`](developer.md) when the code, not the doc, is what's wrong.

## When to use it

Trigger phrases from the agent's description: "document this plugin", "update the README", "write docblocks", "sync the spec with what was built".

Example prompts:

- "Use the documenter agent to write the README for credentials-manager-plugin."
- "Have the documenter check whether CLAUDE.md still matches the plugin's current architecture."

## Scope

- **Plugin-level docs:** a `src/<plugin-slug>/README.md` if the plugin has or needs one, and keeping `SPECIFICATION.md` truthful once implementation has diverged from the original plan, by adding a history entry rather than silently rewriting history.
- **PHP docblocks:** WordPress-core style `/** ... */`. The tone follows what the repo already does - for example `includes/class-credpl-installer.php` explains *why* a hook exists and what it covers ("register_activation_hook() doesn't fire on plugin update"), not just what the method is named.
- **Root `CLAUDE.md`:** updated when architecture, conventions or repo structure described in it changes (a mid-migration state is resolved, a plugin is added under `src/`, tooling appears where there was none).
- **Root `README.md`:** updated when the repository-level status or structure it describes changes.

## Out of scope

- **`docs/wordpress/wordpress-plugins/`** - the handbook mirror. It is exclusively the research agent's responsibility (via `/sync-wordpress-plugin-docs`), sourced from live pages, never authored or edited by hand.
- **Explanatory comments for the obvious.** No comments saying *what* code does when a well-named identifier already does; only the non-obvious *why* (a constraint, workaround or invariant).

## Process

1. **Read the actual code first,** not just the existing spec or README. Catching drift between what is documented and what is real is the point of the agent (for example a spec section describing an approach the code has since moved past).
2. **Say so explicitly when documentation is actively wrong,** not just incomplete, rather than quietly patching around it.
3. **Fix the doc, or flag it for `developer`** to reconcile in code, depending on which side is wrong.

## Microsoft integrations

When documenting a part of a plugin that integrates with Azure, Microsoft Graph, Entra ID, .NET or Windows, terminology and behavior are verified via `microsoft_docs_search` / `microsoft_docs_fetch` instead of memory. Rare in this repo; not used for ordinary WordPress documentation.

## Known issues in the agent definition (as of 2026-09-19)

- The agent file describes tracking superseded designs by adding a "Migration Notes" entry in the spec's §10. Since the `CHANGE_LOG.md` convention was introduced (see [`developer`](developer.md)), the version history lives in each plugin's `CHANGE_LOG.md` and §10 only points at it, so history entries should go there.
- `CHANGE_LOG.md` is not listed in this agent's scope; the `developer` owns writing new entries.
