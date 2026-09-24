---
description: When a pull request is opened, generate a Conventional Commits title and a detailed description from its diff
on:
  pull_request:
    types: [opened, ready_for_review]
permissions:
  contents: read
  pull-requests: read
engine: copilot
timeout-minutes: 15
network:
  allowed:
    - defaults
tools:
  github:
    toolsets: [pull_requests, repos]
safe-outputs:
  update-pull-request:
    title: true
    body: true
    operation: replace
  noop:
---

# Pull request title and description

A pull request was just opened or marked ready for review: `#${{ github.event.pull_request.number }}`. Read its full diff, commits and changed files with the GitHub tools, then set a proper title and a detailed description.

## Skip when

Call `noop` instead of updating if the pull request:

- was opened by one of the docs sync workflows (`sync-wp-cli-docs`, `sync-wordpress-plugins-docs`; their titles start with `docs(wp-cli):` or `docs(wordpress-plugins):` and their bodies are generated), or
- already has a description longer than a couple of lines that a person wrote. Only overwrite empty, auto-generated (e.g. a single commit message) or placeholder descriptions.

## Title

Follow `.github/instructions/commit-messages.instructions.md`: Conventional Commits, `<type>(<scope>): <subject>`.

- Choose the type that fits the overall change (`feat`, `fix`, `docs`, `refactor`, `chore`, `ci`, ...).
- Use the plugin or area as the scope, e.g. `credentials-manager`, `ms-exams`, `docs`, `agents`.
- Imperative, lower case, no trailing period, at most 72 characters.

## Description

Write it in Markdown, based only on what is in the diff. Do not invent behaviour, test results or motivations that the changes don't show. Use these sections and omit any that don't apply:

1. **Summary** — 2–4 sentences on what changed and why, for someone who hasn't seen the code.
2. **Changes** — bullets grouped by area (for example plugin PHP, React/TSX screens, docs, `.claude` agents/commands, workflows). Link key files with relative paths and name the important classes, functions or components.
3. **Database / migration impact** — table changes, `CREDPL_DB_VERSION` bumps, live-data migrations, or "None".
4. **Security considerations** — capability checks, nonces, sanitization and escaping touched or added, or "No security-relevant changes".
5. **Documentation** — whether `CHANGE_LOG.md`, `SPECIFICATION.md`, `docs/` or agent docs were updated. Flag if a plugin code change has **no** `CHANGE_LOG.md` entry, since this repo requires one.
6. **How to test** — concrete manual steps inferred from the changes (there is no automated test suite). For the credentials-manager plugin mention `npm install && npm run build` when files under its `src/` changed.
7. **Notes for reviewers** — risks, follow-ups, or anything ambiguous.

Keep it accurate over long: a small change gets a short description.

## Constraints

- Only update the title and body of this pull request. Do not comment, label, push or change anything else.
- Never include secrets, tokens or personal data from the diff.
- Do not add attribution lines about being AI-generated.
