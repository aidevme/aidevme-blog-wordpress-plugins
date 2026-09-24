# Claude Agent Definitions Style Guide

This guide governs every file under `.claude/agents/` — the project-level Claude Code subagent definitions (`architect`, `developer`, `tester`, `documenter`, `researcher` as of this writing). It does not govern `docs/claude/agents/`, which documents these agents for human readers; see "Keeping this in sync" below for how the two relate.

## File and naming conventions

- One file per agent: `.claude/agents/<agent-name>.md`.
- The filename (minus `.md`) must exactly match the frontmatter `name:` field.
- Names are kebab-case and describe a role or function, not a personality: a repo-wide lifecycle role gets a short noun (`architect`, `developer`, `tester`, `documenter`, `researcher`); a narrowly scoped, single-purpose agent gets a descriptive `<subject>-<function>-agent` name.

## Frontmatter

```markdown
---
name: <slug>
description: <trigger-oriented description>
tools: <comma-separated tool allowlist>
model: sonnet
---
```

- **`name`** — exact match to the filename, no path, no `.md`.
- **`description`** — the field Claude's automatic delegation reads to decide whether to route a request to this agent, so it carries the most weight in this file. Structure it as:
  1. What the agent produces or owns, stated in the first clause (e.g. "Designs and maintains a WordPress plugin's `SPECIFICATION.md`...").
  2. Anything it explicitly does *not* do, when confusion with a neighboring agent is likely (e.g. "Does not write PHP implementation code."; "Distinct from `researcher`, whose wordpress-* modes only sync..."; "Not for writing the spec itself (use `architect`)").
  3. A closing `Use when asked to "phrase one", "phrase two", or "phrase three"` clause quoting literal trigger phrases a user might type.
  - Keep it to 2–4 dense sentences. This field is evaluated in full on every delegation decision — no filler, no marketing language.
- **`tools`** — an explicit, comma-space-separated allowlist, never a wildcard. Order:
  1. `Read` always first.
  2. `Write, Edit` — placed right after `Read` if the agent's core job is producing/modifying files (`architect`, `developer`, `researcher`), or moved to the end of the local-tool group if the agent is read-mostly and writing is a secondary, occasional capability (compare `tester`'s `Read, Grep, Glob, Bash, Write, Edit` — writing there is only for the rare explicit ask to scaffold tests).
  3. `Grep, Glob, Bash` as a fixed middle cluster.
  4. MCP tools last, grouped by server (e.g. all `mcp__plugin_microsoft-docs_microsoft-learn__*` tools together, all `mcp__playwright__*` tools together).
- **`model`** — `sonnet` for every agent currently defined in this repo. Don't switch an agent to a different model without a stated reason in the same change.

## Body structure

Follow this section order; omit a section only if it genuinely doesn't apply, don't reorder the ones you keep.

1. **Opening paragraph** (no heading, two sentences):
   - Sentence 1: `You are the <role> for WordPress plugins in this repo (`src/<plugin-slug>/`).` — states scope using the generic `src/<plugin-slug>/` placeholder, not a hardcoded plugin name.
   - Sentence 2: the agent's default operating mode or output in one line (e.g. "Your output is a `SPECIFICATION.md`, not code."; "Your default mode is read-mostly verification and reporting, not fixing.").
2. **Domain-specific section(s)** — the agent's actual how-to content, e.g. `## Reference documentation — consult before implementing` (developer's topic-to-handbook-folder table), `## Scope` (documenter's owned-artifact list), `## Default process` (tester's numbered steps), `## What to do when invoked` (researcher's numbered steps).
3. **`## Conventions to follow`** — a bulleted list of repo-specific patterns to match (naming prefixes, the shared data-layer class, table-versioning pattern, security conventions). Cite a concrete file or section as the reference example rather than restating rules that already live in `CLAUDE.md` or `SPECIFICATION.md`.
4. **Microsoft documentation section** (`architect`, `developer`, `tester`, `documenter` only) — reuse this repo's existing shared paragraph near-verbatim: use the `microsoft-docs` MCP tools (`microsoft_docs_search`, `microsoft_docs_fetch`, and `microsoft_code_sample_search` where the agent has it) only when a plugin genuinely integrates with a Microsoft product or service (Azure, Microsoft Graph, Entra ID/Azure AD, .NET, Windows) — never for ordinary WordPress questions, which the handbook mirror already covers. Keep the wording consistent across agents; if you improve it in one file, port the same wording to the others rather than letting them drift into near-duplicates that say slightly different things.
5. **Pre-action checklist** — what to read or verify before acting (`## What to check before proposing`, `## Before writing`) or how to verify after acting (`## Verification`). State plainly what was actually checked by reading code versus what would require a live WordPress install — don't imply verification that didn't happen.
6. **`## Boundaries`** — always the final section. A bulleted list of what this agent must *not* do, each one handed off to the agent that should do it instead, named in backticks (e.g. "Don't write or edit PHP implementation files — that's the `developer` agent's job."). This is what keeps the five agents' responsibilities non-overlapping; every boundary line should name the file/artifact being protected and the agent that owns it.

## Cross-agent conventions

These conventions currently hold across every agent in `.claude/agents/` — keep new or edited agents consistent with them rather than reinventing an equivalent rule locally:

- **The WordPress Plugin Handbook mirror (`docs/wordpress/wordpress-plugins/`) is the authoritative source** for WordPress APIs and conventions. Agents that touch plugin code or specs (`architect`, `developer`, `tester`) read it instead of relying on memory, which can be stale or subtly wrong.
- **`CHANGE_LOG.md` gets an entry for every code change** a plugin undergoes — bug fixes and refactors included, not just features. This is `developer`'s responsibility, stated explicitly in that agent's Conventions section.
- **No git actions.** No agent is instructed to `commit`, `push`, or open a PR; `researcher` says so explicitly, and the others simply never mention git.
- **Plugin-agnostic language.** Write instructions in terms of `src/<plugin-slug>/` and generic patterns; use `credentials-manager-plugin` only as the one fully worked example to point at (it's this repo's only plugin with a mature `SPECIFICATION.md`/`CHANGE_LOG.md` pair), not as an assumption that every plugin looks like it.
- **Cross-reference other agents by their exact `name:` value**, in backticks, whenever describing a handoff — this is what lets a reader (human or Claude) find the right agent definition file from the reference alone.
- **Flag conflicts, don't silently resolve them.** When a request or a code-vs-spec mismatch is ambiguous, the established pattern is to flag it back to the responsible agent (`developer` flags spec conflicts; `tester` flags questionable acceptance criteria back to `architect`; `documenter` says outright when something is actively wrong) rather than guessing which side is right.

## Formatting mechanics

- Straight quotes and apostrophes (`'`, `"`), not curly/smart quotes.
- Bullet lists use `-`, not `*`.
- Inline code (backticks) for every file path, function/class name, hook name, capability string, and agent `name:` reference.
- Fence any multi-line example with its language (` ```markdown `, ` ```yaml `, ` ```php `); a bare ` ``` ` is fine for a plain listing.
- No emoji, no "Generated by" footers, no author/date bylines.

## Keeping this in sync

`CLAUDE.md` requires that `docs/claude/agents/<agent-name>.md` (and `docs/claude/agents/AGENTS.md`'s overview table/diagram) be updated whenever an agent definition under `.claude/agents/` changes — treat an edit to an agent file as incomplete until its matching doc page reflects it. If you introduce a new convention here that isn't yet reflected in the five current agent files, update them to match in the same change rather than leaving this guide ahead of reality.
