# architect

Designs and maintains a WordPress plugin's `SPECIFICATION.md`. Its output is a design document, never code.

Source definition: [`.claude/agents/architect.md`](../../../.claude/agents/architect.md)

## At a glance

| | |
| --- | --- |
| **Role** | Plugin designer / specification author |
| **Model** | `sonnet` |
| **Writes** | `src/<plugin-slug>/SPECIFICATION.md` (only) |
| **Reads** | The plugin's existing spec, its `includes/` code, root `CLAUDE.md`, the handbook mirror under `docs/wordpress/wordpress-plugins/` |
| **Hands off to** | [`developer`](developer.md) (implements the spec) |
| **Tools** | `Read`, `Write`, `Edit`, `Grep`, `Glob`, `Bash`, plus the three Microsoft Learn tools (`microsoft_docs_search`, `microsoft_docs_fetch`, `microsoft_code_sample_search`) |
| **Skills** | `wordpress-plugin-security-checklist`, `wordpress-handbook-lookup`, `microsoft-docs-lookup`, see [Skills](../skills/SKILLS.md) |

## Purpose

Before any implementation begins, the architect decides what a plugin is: its data model, admin screens, hooks, shortcodes, file structure, permissions and acceptance criteria. Everything the [`developer`](developer.md) builds and the [`tester`](tester.md) verifies is measured against the spec this agent writes, so the architect is the one place where architectural decisions are made.

## When to use it

Trigger phrases from the agent's description: "design", "plan", "spec out", "architect", "propose a data model", "update the spec" - for a whole plugin or for a new feature inside an existing one.

Do not use it to write PHP/JS (use `developer`), to sync the spec with what was actually built (use [`documenter`](documenter.md)), or to verify code (use `tester`).

Example prompts:

- "Use the architect agent to spec out a new plugin that stores testimonials and renders them with a shortcode."
- "Have the architect add a `Status` field to `credentials` to the spec, including the migration approach."

## What it does

1. **Reads before proposing.** It reads the plugin's existing `SPECIFICATION.md` in full (if any) and its current `includes/` code, so a revision reconciles with what exists or explicitly supersedes it. It also checks root `CLAUDE.md` for noted mismatches between spec and code before treating the spec as authoritative.
2. **Writes the spec** using `src/credentials-manager-plugin/SPECIFICATION.md` as the structural template:
   - Overview, Goals, Non-Goals
   - Data Model (with `CREATE TABLE` SQL when custom tables are involved)
   - Table Creation & Versioning
   - Admin UI
   - Shared data-layer class
   - Front-end rendering (shortcode or block, if any)
   - Permissions
   - Suggested File Structure
   - Migration Notes (when superseding an earlier version)
   - Acceptance Criteria
3. **Bakes in security** rather than leaving it implicit: the capability required (`manage_options` or narrower, with the choice flagged explicitly), nonce protection on every state-changing action, and the sanitization/escaping function for each field.
4. **States non-goals explicitly**, because this repo's specs have been through several superseded designs and explicit non-goals prevent re-litigating dropped approaches.

## Conventions it enforces

- **Prefer custom tables + dedicated admin screens over a Custom Post Type** when the data isn't really "posts". The history behind this (a CPT design that ran into a Gutenberg REST-save vs. classic meta box conflict) is recorded in `credentials-manager-plugin`'s history.
- **One prefix per plugin.** Every plugin gets its own slug, text domain and function/class prefix (`credpl_` / `Credpl_` is the established example); a new plugin gets a short, collision-unlikely prefix used consistently.
- **Link to the handbook mirror** with relative links (for example `03-plugin-basics/activation-deactivation-hooks.md`, `04-plugin-security/*.md`, `21-creating-tables-with-plugins/`), the way the credentials spec's §5 and §8 do.
- **Don't invent style rules.** `docs/styles/SPECIFICATION-STYLE.md` is a placeholder (currently empty). The agent follows the credentials spec's demonstrated structure and does not attribute made-up rules to that file.
- **Microsoft integrations only:** if a plugin integrates with Azure, Microsoft Graph, Entra ID, .NET or Windows, that part of the spec is grounded in `microsoft_docs_search` / `microsoft_docs_fetch` rather than memory. Ordinary WordPress questions go to the handbook mirror instead.

## Boundaries

- Does not write or edit PHP implementation files - that is `developer`'s job, working from the spec.
- Does not write the handbook mirror under `docs/wordpress/wordpress-plugins/` - that is [`researcher`](researcher.md) (mode `wordpress-plugin-docs`)'s job.
- These limits are set by the agent's instructions; its `Write`/`Edit` tools are not path-restricted.

## Known issues in the agent definition (as of 2026-09-19)

- The agent file says to see `SPECIFICATION.md` §10 for why the CPT approach was abandoned. §10 is now only a pointer; that history lives in `src/credentials-manager-plugin/CHANGE_LOG.md`.
- The agent file still lists "Migration Notes" as the place for superseded-design history. Since the `CHANGE_LOG.md` convention was introduced (see [`developer`](developer.md)), those entries belong in the plugin's `CHANGE_LOG.md`, and the spec's §10 should just point there.
