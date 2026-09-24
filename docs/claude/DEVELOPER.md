# Developer guide: agents, commands and skills

How to work with Claude Code in this repository: which agent to use for which job, how to phrase requests, how to run the slash commands, how skills fit in, and how to add your own agents, commands and skills.

This guide is for people working in the repo. The reference pages it links to describe each piece in detail:

- [Agents overview](agents/AGENTS.md) and one page per agent
- [Commands overview](commands/COMMANDS.md) and one page per command
- [Skills overview](skills/SKILLS.md), with a section per skill
- [Root `CLAUDE.md`](../../CLAUDE.md), the standing instructions Claude Code reads in every session

## Contents

1. [The building blocks](#the-building-blocks)
2. [Choosing the right one](#choosing-the-right-one)
3. [Working with the agents](#working-with-the-agents)
4. [End-to-end examples](#end-to-end-examples)
5. [Working with the slash commands](#working-with-the-slash-commands)
6. [Skills](#skills)
7. [GitHub agentic workflows](#github-agentic-workflows)
8. [Writing good requests](#writing-good-requests)
9. [Adding a new agent, command or skill](#adding-a-new-agent-command-or-skill)
10. [Troubleshooting](#troubleshooting)
11. [Keeping the docs in sync](#keeping-the-docs-in-sync)

## The building blocks

Everything Claude Code-specific lives under `.claude/`:

| Building block | Where | What it is | How it starts |
| --- | --- | --- | --- |
| **Agent** (subagent) | `.claude/agents/<name>.md` | A specialist with its own instructions, tool list and model. It runs in a separate context and reports back. | Claude delegates when your request matches its `description`, or you name it |
| **Slash command** | `.claude/commands/<name>.md` | A saved prompt you run by typing `/<name> [arguments]`. | You type it |
| **Skill** | `.claude/skills/<name>/SKILL.md` | A packaged set of instructions (optionally with supporting files) that Claude loads when the task calls for it. | Claude loads it when its `description` matches, or you type `/<name>` |
| **Standing instructions** | `CLAUDE.md` | Repo-wide rules Claude reads at the start of every session. | Automatic |
| **MCP server** | `.mcp.json`, `.claude/settings*.json` | External tools, here a headless Playwright browser and Microsoft Learn. | Used by agents that list the tools |
| **GitHub agentic workflow** | `.github/workflows/*.md` | An agent that runs in GitHub Actions on a schedule or event. | Schedule, PR event, or manual dispatch |

What exists in this repo today:

| Kind | Items |
| --- | --- |
| Agents | `architect`, `developer`, `tester`, `documenter`, `researcher` |
| Commands | `/sync-wordpress-plugin-docs`, `/sync-wordpress-rest-api-docs`, `/sync-wordpress-wp-cli-command-docs` |
| Skills | `wordpress-plugin-security-checklist`, `wordpress-handbook-lookup`, `microsoft-docs-lookup`, `changelog-entry`; see [Skills](#skills) |
| Agentic workflows | `sync-wordpress-plugins-docs`, `sync-wp-cli-docs`, `pr-title-and-description` |
| MCP servers | `playwright` (headless, from `.mcp.json`), `microsoft-docs` (plugin enabled in `.claude/settings.json`) |

## Choosing the right one

| You want to... | Use | Why |
| --- | --- | --- |
| Design a plugin or a new feature before any code exists | `architect` | Writes `SPECIFICATION.md`; never writes PHP |
| Build or fix plugin code against an approved spec | `developer` | Implements to the spec and logs every change in `CHANGE_LOG.md` |
| Check that code meets the spec and security conventions | `tester` | Structured review against the acceptance criteria; read-mostly |
| Bring READMEs, docblocks and the spec in line with the code | `documenter` | Owns non-handbook documentation |
| Refresh a docs mirror from developer.wordpress.org | A `/sync-wordpress-*` command | Fixed recipe, optional scope, runs `researcher` for you |
| Research something open-ended | `researcher`, mode `general` | Finds and cites sources; writes nothing by default |
| Do the same fixed thing repeatedly with an argument | A slash command | One line to run, always the same recipe |
| Teach Claude a reusable procedure with reference files | A skill | Loaded only when relevant |
| Run something on a schedule or on every PR | An agentic workflow | Runs in GitHub, opens a PR for review |

Rules of thumb:

- **Agent** when the work needs its own context, its own tool limits, or a distinct role.
- **Command** when you know exactly what you want to run and want it to be one short line.
- **Skill** when the value is a procedure or reference material Claude should pull in on demand.
- **Just ask Claude** when none of that is needed. Not every task needs an agent.

## Working with the agents

The five agents are set up as a pipeline for plugin work, plus a research agent that feeds it. All run on the `sonnet` model and none is instructed to commit or push.

| Agent | Does | Does not | Writes |
| --- | --- | --- | --- |
| [`architect`](agents/architect.md) | Data model, admin screens, hooks, shortcodes, file structure, migration notes | Write PHP implementation code | `src/<plugin>/SPECIFICATION.md` |
| [`developer`](agents/developer.md) | Implements or fixes PHP/JS/TS against the spec; follows WordPress security conventions | Write the spec or non-code docs | Plugin code and `CHANGE_LOG.md` |
| [`tester`](agents/tester.md) | Reviews code against the spec's acceptance criteria and the security conventions | Change code (unless you ask it to scaffold PHPUnit tests) | Nothing by default; reports in the conversation |
| [`documenter`](agents/documenter.md) | READMEs, docblocks, spec accuracy, `CLAUDE.md` | Touch the docs mirrors under `docs/wordpress/` | READMEs, docblocks, `CLAUDE.md`, spec corrections |
| [`researcher`](agents/researcher.md) | Syncs the docs mirrors and does general research | Change plugin code or agent definitions | The mirror folders in its sync modes |

### How to call an agent

There are two ways, and both are normal:

1. **Describe the job.** Claude picks the agent whose `description` fits. "Spec out an export feature for credentials-manager-plugin" goes to `architect`.
2. **Name the agent.** "Use the tester agent to verify credentials-manager-plugin against its spec." This removes any guesswork.

An agent starts with no memory of your conversation. Always include the plugin slug (for example `credentials-manager-plugin`) and the concrete task, and point at files or spec sections where you can.

### Sample requests

**architect**

~~~text
Use the architect agent to spec an "export credentials to CSV" action for
credentials-manager-plugin. It should be a button on the Credentials list screen,
admin-only, and must not change the database schema.
~~~

~~~text
Ask the architect to update the credentials-manager-plugin spec: the Microsoft Exams
screen now has a Skills column. Only describe it; don't write code.
~~~

**developer**

~~~text
Use the developer agent to implement the CSV export described in §6.2 of
src/credentials-manager-plugin/SPECIFICATION.md. Add the CHANGE_LOG.md entry.
~~~

~~~text
Use the developer agent to fix this bug in credentials-manager-plugin: deleting a
credential that is used by a Credential Block leaves the block referencing a missing ID.
The delete handler is in includes/. Keep the fix minimal.
~~~

**tester**

~~~text
Use the tester agent to verify credentials-manager-plugin against the acceptance
criteria in its SPECIFICATION.md, focusing on the Microsoft Exams screen.
~~~

~~~text
Have the tester do a security pass on credentials-manager-plugin: capability checks,
nonces, sanitization and escaping on every admin action. Report findings only; don't fix.
~~~

**documenter**

~~~text
Use the documenter agent to update src/credentials-manager-plugin/README.md so it
matches what was built in the last three CHANGE_LOG.md entries.
~~~

~~~text
Ask the documenter to add PHP docblocks to the public methods of Credpl_Data and
correct any statements in SPECIFICATION.md that no longer match the code.
~~~

**researcher**

~~~text
Use the researcher agent in general mode: what does the WordPress REST API say about
registering a custom route with a permission_callback? Give links to the official pages.
~~~

### What the agents check for you

- `developer` adds a `CHANGE_LOG.md` entry for every code change, including bug fixes and refactors, and writes security-conscious code: `manage_options` checks, nonces, `$wpdb->insert/update/delete`, and escaped output.
- `architect` and `developer` read the local Plugin Handbook mirror (`docs/wordpress/wordpress-plugins/`) rather than working from memory of WordPress APIs.
- `tester` reports problems rather than fixing them, and flags a wrong acceptance criterion to `architect` instead of quietly changing it.
- `documenter` says so explicitly when an existing doc is actively wrong.

## End-to-end examples

### Example 1: a new feature

The usual order for a feature is design, build, verify, document. Each step is a separate request so the output of one can be reviewed before the next starts.

1. **Design**
   ~~~text
   Use the architect agent to add a "duplicate credential" action to
   credentials-manager-plugin. Update SPECIFICATION.md with the behavior,
   the nonce/capability requirements and acceptance criteria.
   ~~~
   Read the spec change. Adjust it now; changing a spec is cheaper than changing code.
2. **Build**
   ~~~text
   Use the developer agent to implement the "duplicate credential" action from
   the updated SPECIFICATION.md. Add a CHANGE_LOG.md entry.
   ~~~
   For the React screens run `npm install && npm run build` and `npm run check-types` in `src/credentials-manager-plugin/`, since the compiled `build/` files are what WordPress loads.
3. **Verify**
   ~~~text
   Use the tester agent to check the duplicate-credential action against its
   acceptance criteria and the repo's security conventions.
   ~~~
4. **Fix what the tester found**, by going back to `developer` with the findings. If the tester says a criterion is wrong, that goes to `architect`.
5. **Document**
   ~~~text
   Use the documenter agent to bring README.md and the docblocks in line with the
   duplicate-credential change.
   ~~~
6. Commit with a Conventional Commits message (see `.github/instructions/commit-messages.instructions.md`).

### Example 2: a bug fix

For a small bug, skip the architect:

~~~text
Use the developer agent to fix: the Credentials list shows "0 items" after a search
with no results, but the pagination still says "1 of 1". Add a CHANGE_LOG.md entry.
~~~

Then ask for a quick check:

~~~text
Use the tester agent to confirm the search fix didn't change capability or nonce handling.
~~~

### Example 3: keeping the WordPress docs current

Run a command with a small scope first, then widen it:

~~~text
/sync-wordpress-wp-cli-command-docs wp_core
~~~

Check the resulting file in `docs/wordpress/api-reference/wp-cli-commands/09-wp_core/`, and the row in `index.md` (**Last Synced On** and **Notes** are updated). If it looks right, run it without an argument, or leave it to the weekly workflow.

### Example 4: research, then decide

~~~text
Use the researcher agent in general mode: compare WP_List_Table with a React admin
screen for a plugin list page. Cover accessibility, maintenance cost and how
@wordpress/scripts fits. Cite official sources and flag anything you couldn't verify.
~~~

The answer arrives in the reply. If it should become a design decision, hand the conclusion to `architect`.

## Working with the slash commands

Each command syncs one docs mirror. All three launch the `researcher` agent in the matching mode, run in the foreground, and print a summary. See [Commands overview](commands/COMMANDS.md).

| Command | Mirror | Scope examples |
| --- | --- | --- |
| `/sync-wordpress-plugin-docs` | Plugin Handbook | `19`, `Hooks` |
| `/sync-wordpress-rest-api-docs` | REST API Handbook | `4.1`, `6.3`, `key-concepts`, `all of section 6` |
| `/sync-wordpress-wp-cli-command-docs` | WP-CLI commands | `09`, `wp_core` |

~~~text
/sync-wordpress-plugin-docs 3.1
/sync-wordpress-rest-api-docs 4.1
/sync-wordpress-rest-api-docs all of section 5
/sync-wordpress-wp-cli-command-docs wp_ability
~~~

Things to know:

- **No argument means every row.** The Plugin Handbook has about 100 rows, so a full run takes a while. Start small.
- The mirrors are generated. Never hand-edit files in them; the next sync overwrites the edits.
- A run rewrites files and updates the Index table. It does not commit. Review with `git diff` before you commit.
- A failed page (404 or stub) leaves its file untouched and shows `Sync failed - ...` in **Notes**.

### Using the researcher directly

You can also skip the command and name a mode:

~~~text
Use the researcher agent, mode wordpress-rest-api-docs, to sync rows 6.1 to 6.5.
~~~

If a request could mean more than one mode, the agent asks which you mean instead of guessing.

## Skills

A skill is a folder with a `SKILL.md` file that Claude Code loads when a task matches the skill's description, or when you type `/<skill-name>`. Compared with an agent, a skill does not get its own context or tool limits; it adds instructions (and optional reference files or scripts) to the conversation you are already having.

### Skills in this repo

Four skills hold the rules that the plugin agents used to repeat. Full descriptions are in [Skills](skills/SKILLS.md).

| Skill | Use it to | Loaded by |
| --- | --- | --- |
| `wordpress-plugin-security-checklist` | Design, write or review anything against capability, nonce, sanitize, escape and `$wpdb` rules | `architect`, `developer`, `tester` |
| `wordpress-handbook-lookup` | Find the right page in the local Plugin Handbook, REST API and WP-CLI mirrors | `architect`, `developer`, `tester` |
| `microsoft-docs-lookup` | Use the Microsoft Learn tools correctly for Azure, Graph, Entra ID, .NET or Windows integrations | `architect`, `developer`, `tester`, `documenter` |
| `changelog-entry` | Write the `CHANGE_LOG.md` entry a code change requires | `developer` |

The agents list them in their `skills` frontmatter, so you normally get them without asking. You can also use one directly, with or without an agent:

~~~text
/wordpress-plugin-security-checklist
Review src/credentials-manager-plugin/includes/ against it and list the gaps with file and line.
~~~

~~~text
Which page in the local mirrors covers registering a REST route with a permission_callback?
(Claude loads wordpress-handbook-lookup, then reads the page.)
~~~

~~~text
/changelog-entry
I just renamed the Status dropdown values in credentials-manager-plugin. Write the entry.
~~~

Change the wording of a shared rule in its skill, once; the agents pick it up. Skills do not grant tools, so an agent that uses `microsoft-docs-lookup` must still have the Microsoft Learn tools in its own `tools` list.

Other skills you may see in a session ship with Claude Code or come from installed plugins, for example `/code-review` (review a diff) and `/security-review`. Those are not part of this repo and are not documented here.

### When a skill is the right choice

| Situation | Use a |
| --- | --- |
| A procedure with supporting files (templates, checklists, scripts) Claude should read only when relevant | Skill |
| A role that needs a restricted tool list or a separate context window | Agent |
| A one-line prompt you always run the same way | Command |
| A rule that should apply to every session | `CLAUDE.md` |

### Sample skill: release checklist

This is a suggested example of a new skill, not something that exists in the repo.

~~~text
.claude/skills/plugin-release-checklist/
  SKILL.md
  checklist.md
~~~

`SKILL.md`:

~~~markdown
---
name: plugin-release-checklist
description: Walks through releasing a plugin from src/<plugin>/ - version bump, CHANGE_LOG.md entry, build, zip. Use when asked to "release", "cut a release", "prepare a release" or "bump the version" for a plugin.
---

# Plugin release checklist

1. Ask which plugin (a directory under `src/`) and the new version if not given.
2. Read `checklist.md` in this folder and work through it in order.
3. Confirm every item before moving on; report any that cannot be done.

Never commit, tag or push. Leave that to the user.
~~~

Then either ask "prepare a release of credentials-manager-plugin 1.3.0" and let Claude load it, or type `/plugin-release-checklist`.

### Writing a good skill

- The `description` decides when it loads. Say what it does and list the phrases that should trigger it.
- Keep `SKILL.md` short and put long reference material in separate files it points to.
- Keep one job per skill.
- Say what it must not do (commit, push, edit certain folders), as the agents here do.

## GitHub agentic workflows

Three workflows in `.github/workflows/` are written as markdown (`*.md`), compiled into GitHub Actions files (`*.lock.yml`) with the `gh aw` CLI extension, and run an AI agent with limited permissions. Details on the file format are in the [gh-aw documentation](https://github.com/github/gh-aw).

| Workflow | Trigger | Does | Engine and secret |
| --- | --- | --- | --- |
| `sync-wp-cli-docs` | Weekly (Monday), or manual | Refreshes the 10 least recently synced WP-CLI pages; opens a draft PR | Claude, `ANTHROPIC_API_KEY` |
| `sync-wordpress-plugins-docs` | Weekly (Tuesday), or manual | Refreshes the 15 least recently synced Plugin Handbook pages; opens a draft PR | Claude, `ANTHROPIC_API_KEY` |
| `pr-title-and-description` | When a PR is opened or marked ready | Writes a Conventional Commits title and a detailed description | Copilot, `COPILOT_GITHUB_TOKEN` |

Common tasks:

~~~text
gh aw compile                         # regenerate every .lock.yml after editing a .md
gh aw compile sync-wp-cli-docs        # just one
gh aw run sync-wp-cli-docs -F rows="wp_ability, wp_admin"   # manual run on chosen rows
gh run list --workflow=sync-wp-cli-docs.lock.yml            # see recent runs
~~~

Rules:

- Edit the `.md`, recompile, and commit both files together. Never edit a `.lock.yml` by hand.
- Workflows run from the default branch, so a new or changed workflow takes effect once it is merged to `main`.
- The two sync workflows read their rules from `.claude/agents/researcher.md`. Changing a mode there changes what they do.
- A workflow only opens a draft PR. A person reviews and merges it.

## Writing good requests

Agents start cold, so the request is everything they know.

| Do | Instead of |
| --- | --- |
| "Use the developer agent to add a Skills column to the Microsoft Exams list in credentials-manager-plugin, per section 6.2 of its SPECIFICATION.md." | "Add a column." |
| Name the plugin slug and the files or spec sections involved | Assuming it knows what you were just working on |
| State limits: "report only", "don't change the schema", "minimal fix" | Leaving scope open |
| Ask for one job per request, then review | Asking one agent to design, build, test and document at once |
| Say what a good result looks like: "list findings with file and line" | "Check it" |

For fixed jobs, prefer the slash command over a hand-written request; it already carries the right instructions.

## Adding a new agent, command or skill

Follow the existing files and the style guides in [`docs/styles/`](../styles/), then document the addition. Agent definitions follow [`CLAUDE-AGENTS-STYLE.md`](../styles/CLAUDE-AGENTS-STYLE.md).

### New agent

Create `.claude/agents/<name>.md`:

~~~markdown
---
name: <name>
description: <What it does and when to use it. List trigger phrases ("Use when asked to ..."). Say what it does NOT do if a neighboring agent could be confused with it.>
tools: Read, Grep, Glob
skills: <optional: skills from .claude/skills/ this agent should have>
model: sonnet
---

You are the <role> for this repo. <One paragraph on the job.>

## What to do when invoked

1. ...

## Rules

- ...
- Do not commit, push or open PRs.
~~~

Guidelines:

- Give it only the tools it needs. A read-only reviewer should not have `Write` or `Edit`.
- Make the `description` specific; Claude uses it to decide when to delegate.
- Keep boundaries explicit (what it must not touch).
- Then add `docs/claude/agents/<name>.md`, a row in `docs/claude/agents/AGENTS.md`, and update the "Agents" text in `CLAUDE.md` if the new agent changes how work is organised.

### New command

Create `.claude/commands/<name>.md`:

~~~markdown
---
description: One line shown in the command list
argument-hint: [optional: what the argument means, e.g. "wp_core"]
---

Invoke the `<agent>` subagent (via the Agent tool) to <do the thing>.

Scope: $ARGUMENTS

- If arguments were given above, <how to use them>.
- If none were given, <the default>.

Run the agent in the foreground and relay its final summary.
~~~

`$ARGUMENTS` is replaced with whatever you type after the command name. The file name is the command name. Then add `docs/claude/commands/<name>.md` and a row in `docs/claude/commands/COMMANDS.md`.

### New skill

Create `.claude/skills/<name>/SKILL.md` as in [Skills](#skills), with any supporting files beside it. Document it briefly here and in `CLAUDE.md` if it changes how people work in the repo.

### Checklist for any addition

- [ ] Definition file created in `.claude/`
- [ ] Reference page created under `docs/claude/` and its index updated
- [ ] Anything that named the old way (`CLAUDE.md`, other agents' "don't do X, that is agent Y's job" lines) updated
- [ ] Tried once on a small, harmless request
- [ ] If it edits files, its boundaries (which folders it may touch) are written down

## Troubleshooting

| Symptom | Likely cause | What to do |
| --- | --- | --- |
| Claude doesn't use the agent you expected | Your request doesn't match its `description` | Name the agent explicitly, or improve the description |
| A new agent or command doesn't appear | Definitions are read at session start | Restart the Claude Code session and check the file is in `.claude/agents/` or `.claude/commands/` |
| The agent asks "which mode?" | The request fits several `researcher` modes or none | Name the mode: `wordpress-plugin-docs`, `wordpress-rest-api-docs`, `wordpress-wp-cli-command-docs` or `general` |
| A sync marks rows `Sync failed - 404` | The live page moved or the URL in the Index is wrong | Check the **Reference Url**; the agent updates it when the live page redirects |
| Browser tools are missing in a sync | The project's `playwright` MCP server isn't enabled | Check `.mcp.json` and `enabledMcpjsonServers` in `.claude/settings.local.json`; don't substitute another Playwright server |
| React screens look stale after a code change | `build/` wasn't rebuilt | Run `npm run build` in `src/credentials-manager-plugin/` |
| A workflow fails with "Invalid API key" | `ANTHROPIC_API_KEY` is missing, revoked or not a console API key | Re-set the repo secret with a valid key |
| A workflow fails on `COPILOT_GITHUB_TOKEN` | The secret is unset | Create a fine-grained token with Copilot Requests permission and set the secret |
| A workflow doesn't show up in Actions | The file isn't on the default branch, or the `.lock.yml` is missing | Compile, commit both files, merge to `main` |

## Keeping the docs in sync

The `.claude/` files are the source of truth. When one changes, update its page:

| You changed | Update |
| --- | --- |
| `.claude/agents/<name>.md` | `docs/claude/agents/<name>.md` and `AGENTS.md` if the summary changes |
| `.claude/commands/<name>.md` | `docs/claude/commands/<name>.md` and `COMMANDS.md` |
| A mode of `researcher` | The matching section of `.claude/agents/researcher.md`; the sync workflows read it, and `docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md` for the Plugin Handbook mode |
| A `.github/workflows/*.md` | Recompile the `.lock.yml` and commit both |
| How the team works with agents | `CLAUDE.md` and this guide |

Ask the `documenter` agent to do the sync for you: "Use the documenter agent to update docs/claude/agents to match the current .claude/agents definitions."
