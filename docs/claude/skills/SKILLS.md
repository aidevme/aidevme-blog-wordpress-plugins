# Claude Code skills

Documentation for the project-level Claude Code skills defined in [`.claude/skills/`](../../../.claude/skills/). This page is the overview and describes each skill.

These docs describe the skill definitions as they exist in the repo (snapshot: 2026-09-24). The `.claude/skills/*/SKILL.md` files are the source of truth - when one changes, update this page.

## What these skills are for

The plugin agents ([`architect`](../agents/architect.md), [`developer`](../agents/developer.md), [`tester`](../agents/tester.md), [`documenter`](../agents/documenter.md)) used to carry near-identical copies of the same rules: the security checklist in three of them, the Microsoft Learn paragraph in all four, and a long handbook topic table in one. Each is now a skill, so the wording lives in one place and the agents point at it.

A skill is a folder holding a `SKILL.md`. Claude Code loads it when a task matches its `description`, or when you type `/<skill-name>`. An agent can also list skills in its `skills` frontmatter field so they are available from the start of its run.

## Skills

| Skill | Purpose | Used by |
| --- | --- | --- |
| [`wordpress-plugin-security-checklist`](#wordpress-plugin-security-checklist) | The repo's security rules: capability checks, nonces, sanitizing, escaping, `$wpdb` writes | `architect`, `developer`, `tester` |
| [`wordpress-handbook-lookup`](#wordpress-handbook-lookup) | Maps a WordPress topic to the right page in the local docs mirrors | `architect`, `developer`, `tester` |
| [`microsoft-docs-lookup`](#microsoft-docs-lookup) | When and how to use the Microsoft Learn tools | `architect`, `developer`, `tester`, `documenter` |
| [`changelog-entry`](#changelog-entry) | Writing the `CHANGE_LOG.md` entry required for every code change | `developer` |

### wordpress-plugin-security-checklist

Source: [`.claude/skills/wordpress-plugin-security-checklist/SKILL.md`](../../../.claude/skills/wordpress-plugin-security-checklist/SKILL.md)

One seven-item checklist (capability check, nonce, sanitize in, escape out, `$wpdb->insert/update/delete`, single data-layer class, direct-access and destructive-action guards) applied in three roles:

- **Designing:** state each decision in the spec instead of leaving it implicit.
- **Implementing:** satisfy each item in every new handler and template, then say which were verified by reading and which need a running site.
- **Reviewing:** check each item across the whole plugin, report gaps with file and line, and do not fix them unless asked.

The authority behind it is the local handbook mirror, `docs/wordpress/wordpress-plugins/04-plugin-security/`.

### wordpress-handbook-lookup

Source: [`.claude/skills/wordpress-handbook-lookup/SKILL.md`](../../../.claude/skills/wordpress-handbook-lookup/SKILL.md)

The topic-to-folder table that used to sit inside `developer` (activation hooks, admin menus, shortcodes, settings, custom tables, HTTP API, cron, i18n, and so on), extended with the two newer mirrors: the REST API Handbook and the WP-CLI command reference. It also records rules for using the mirrors: they are generated and never hand-edited, an unsynced page is reported and refreshed with a sync command instead of being filled from memory, and PHP uses tabs while mirror code blocks use spaces.

### microsoft-docs-lookup

Source: [`.claude/skills/microsoft-docs-lookup/SKILL.md`](../../../.claude/skills/microsoft-docs-lookup/SKILL.md)

Describes the three Microsoft Learn MCP tools (`microsoft_docs_search`, `microsoft_docs_fetch`, `microsoft_code_sample_search`), how each role uses them, and the rules: only for plugins that integrate with a Microsoft product or service, search before fetch, cite the page URL, and say so when the documentation does not answer the question. Skills grant no tools, so the agents keep the MCP tools in their `tools` list (the `documenter` has search and fetch only).

### changelog-entry

Source: [`.claude/skills/changelog-entry/SKILL.md`](../../../.claude/skills/changelog-entry/SKILL.md)

The procedure for the `CHANGE_LOG.md` entry that every plugin code change requires, including bug fixes and refactors: find the file (create it if missing), take the next `vNN` number, write a bold headline with the spec section and named identifiers, describe upgrade impact for anything not purely additive, and keep `SPECIFICATION.md` pointing at the entry rather than duplicating it. The model to follow is `src/credentials-manager-plugin/CHANGE_LOG.md`.

## How they are used

- **By an agent.** The four plugin agents list their skills in frontmatter, and their instructions say when to apply each one.
- **Directly.** Type `/wordpress-plugin-security-checklist` (or any skill name) in a session, or describe the task and let Claude load the matching skill. For example, "review src/credentials-manager-plugin for security gaps" matches the security skill's description.

The `researcher` agent uses none of these skills; its mode procedures stay in its own definition because the scheduled GitHub workflows read them from that file.

## Evals

Each skill has an eval suite in its own folder, `.claude/skills/<skill>/evals/<case>/case.yaml`, for `claude plugin eval`. An eval sends a realistic prompt, phrased the way a person would type it and without naming the skill, and scores the result with graders. The suites check that a skill triggers when it should, stays quiet when it should not, and produces the right content.

| Skill | Cases | What they check |
| --- | --- | --- |
| `wordpress-plugin-security-checklist` | 4 | Finds all five gaps in an insecure handler; does not raise false alarms on a secure one; turns the checklist into spec statements; does not fire on an unrelated question |
| `wordpress-handbook-lookup` | 5 | Points to `08-shortcodes`, `21-creating-tables-with-plugins` and `wordpress-rest-apis/06-reference` for the right topics; asks for a sync instead of filling an empty page from memory; does not fire on unrelated questions |
| `microsoft-docs-lookup` | 3 | Grounds a Graph integration in Microsoft Learn; splits a hybrid question between WordPress HTTP API and Azure docs; does not fire on an ordinary WordPress question |
| `changelog-entry` | 4 | Writes a correctly numbered (v89) entry for a bug fix and for a schema change with upgrade impact; creates a missing `CHANGE_LOG.md` starting at v1; refuses to skip the entry for an internal refactor |

### Case format

Each case is one `case.yaml`: `schema_version: "1.1"`, a `name`, `tags`, an `execution` block (`prompt`, `max_turns`, `allowed_tools`), and a list of `graders`. The graders used here:

- `llm`: a judge model scores a PASS/FAIL rubric. The rubric says exactly what passes and what fails.
- `regex`: a pattern the reply must contain, for example the folder name or the version number.
- `tool_used` with `tool: Skill`: whether the skill was invoked. On the negative cases it has `min: 0` and `max: 0` and `arm: both`, so an unwanted invocation fails the case.

Runs start in an empty workspace and are limited to read-only tools, so each prompt carries its own scenario (the code, the last change log number) instead of pointing at repo files. That means the cases test the skill's guidance, not the contents of the repo.

### Two eval formats

Each skill carries the same scenarios in two formats, because Claude Code has two separate eval mechanisms:

| File | Used by | Format |
| --- | --- | --- |
| `evals/<case>/case.yaml` | `claude plugin eval` | One case per folder; graders (`llm`, `regex`, `tool_used`) score the result automatically |
| `evals/evals.json` | The skill-creator plugin, for iterating on a skill inside a Claude Code session | `{ "skill_name", "evals": [ { "id", "prompt", "expected_output", "assertions": [...], "files": [] } ] }`; assertions are plain-language statements that a reviewer or model checks |

The two are independent. `claude plugin eval` reads only the case folders and ignores `evals.json`. I confirmed that the `evals.json` files are valid JSON with the expected fields and that the CLI still finds the case folders next to them, but not that skill-creator accepts them, since that plugin is not installed here. When you change a scenario, change it in both files.

### Running them

Run from the repo root, one skill at a time:

```bash
claude plugin eval .claude/skills/changelog-entry
claude plugin eval .claude/skills/changelog-entry --case bugfix-entry --runs 1
claude plugin eval .claude/skills/wordpress-plugin-security-checklist --tag negative
```

Useful options: `--runs <n>` (default 3 per case), `--judge-model sonnet` for a stronger judge, `--json` for machine-readable output, `--max-cost-usd <n>` for a hard cost ceiling, and `--threshold 0.8` to exit non-zero below a score. Each run calls the model, so a full suite of three runs per case costs real usage; start with `--runs 1`. Results and an HTML report are written to `<skill>/evals/results/`, which is git-ignored.

Two things to remember when reading results:

- The `skill-fired` graders are a signal about the skill's `description`, not part of the score in a with/without-skill comparison, except on the negative cases. If a positive case passes its content graders but `skill-fired` fails, the skill was not chosen, so improve the description's trigger phrases.
- `claude plugin eval` is documented as an early-access feature and its options may change. The suites were validated only up to discovery (the CLI finds the cases); they have not been run against the model yet, so expect to tune rubrics after the first real run.

## Validating skills

Skill files are checked against the [Agent Skills specification](https://agentskills.io/specification) in three places:

| Where | What it does |
| --- | --- |
| [`.github/workflows/validate-skill.yml`](../../../.github/workflows/validate-skill.yml) | On pushes and PRs to `main` or `dev` that touch a `SKILL.md`, validates each changed skill folder with the `Flash-Brew-Digital/validate-skill` action (pinned to a commit). Deleted skills are skipped. It can also be run manually (Actions tab, or `gh workflow run validate-skill.yml -f skill=changelog-entry`); leave `skill` empty to validate every skill. |
| [`scripts/validate-skills.sh`](../../../scripts/validate-skills.sh) | Fast local check with no dependencies: name (format, matches the folder), description (present, at most 1024 characters, single-line, quoted or folded), `SKILL.md` under 500 lines, and a warning for frontmatter keys the open spec does not define. `--strict` makes warnings fail. |
| [`scripts/validate-skills-official.sh`](../../../scripts/validate-skills-official.sh) | Runs the official `skills-ref` library. Clones it into `~/.cache/agentskills` on first use (set `SKILLS_REF_REF` to a commit to pin it); needs `uv` or Python 3. |

Both scripts take an optional skills directory and default to `.claude/skills`:

```bash
scripts/validate-skills.sh
scripts/validate-skills.sh --strict
scripts/validate-skills-official.sh
```

Warnings are informational for this repo: Claude Code accepts frontmatter keys such as `skills` (on agents) and `argument-hint` (on commands) that the open spec does not list. A `.gitattributes` rule keeps `*.sh` files on LF endings so they run on Windows checkouts.

## Adding or changing a skill

1. Create or edit `.claude/skills/<name>/SKILL.md`. The frontmatter needs a `name` (matching the folder) and a `description` that says what it does and lists the phrases that should trigger it.
2. Keep one job per skill; put long reference material in separate files beside `SKILL.md`.
3. List the skill in the `skills` frontmatter of each agent that should use it, and add a one-line pointer in that agent's body.
4. If the skill mentions tools, make sure the agents that use it have those tools in their `tools` list.
5. Add or update its eval cases under `.claude/skills/<name>/evals/` (see Evals above): a case where it should fire, one where the content matters, and one where it must stay quiet.
6. Update this page and the `Skills` row on the affected agent pages under `docs/claude/agents/`.

## Scope of this documentation

Only the four skills defined in this repository. Built-in skills and skills supplied by installed plugins are not covered here.

## Related

- [Claude Code agents](../agents/AGENTS.md)
- [Claude Code commands](../commands/COMMANDS.md)
- [Developer guide](../DEVELOPER.md)
- [`docs/styles/CLAUDE-AGENTS-STYLE.md`](../../styles/CLAUDE-AGENTS-STYLE.md) - includes the `skills` frontmatter field
