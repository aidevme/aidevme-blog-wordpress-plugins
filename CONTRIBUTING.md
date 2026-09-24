# Contributing

Thanks for helping improve the Aidevme Blog WordPress plugins. This guide covers how to report problems, propose changes and get a pull request merged.

## Ways to contribute

- **Report a bug** or **request a feature** using the [issue templates](https://github.com/aidevme/aidevme-blog-wordpress-plugins/issues/new/choose). Blank issues are disabled, so pick the template that fits.
- **Improve documentation** — plugin READMEs, specifications, and the docs under `docs/`.
- **Fix a bug or build a feature** in one of the plugins under `src/`.

For anything larger than a small fix, open an issue first so the approach can be agreed before you invest time.

## Repository layout

| Path | Contents |
| --- | --- |
| `src/` | One directory per plugin, plus the two plugin templates. |
| `docs/wordpress/wordpress-plugins/` | Mirror of the WordPress Plugin Handbook. |
| `docs/wordpress/api-reference/` | Mirrors of the WP-CLI command reference and other API references. |
| `docs/claude/agents/` | Documentation of the project's Claude Code agents. |
| `docs/styles/` | Documentation style guides. |
| `.claude/` | Claude Code agents and slash commands. |
| `.github/` | Issue templates, CI workflows and agentic workflows. |

Most plugins are plain PHP with no compile step. `credentials-manager-plugin` also has React/TypeScript admin screens. There is no repo-wide build, lint or test tooling.

## Getting started

1. Fork the repository and clone your fork.
2. Create a branch from `dev`, not `main`:
   ```
   git checkout dev
   git pull
   git checkout -b feat/short-description
   ```
3. Make your change (see below), then push and open a pull request against `dev`.

### Working on `credentials-manager-plugin`

Read [`src/credentials-manager-plugin/SPECIFICATION.md`](src/credentials-manager-plugin/SPECIFICATION.md) before changing its architecture. After editing anything under its `src/` directory, rebuild:

```
cd src/credentials-manager-plugin
npm install
npm run build
npm run check-types
```

The compiled files in `build/` are what WordPress loads, so commit them with the source change. Plugin requirements: WordPress 6.6 or later.

## Code standards

- Follow the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/) for PHP, and match the style of the code around your change.
- Security is not optional:
  - check the `manage_options` capability on every admin screen and action;
  - use a nonce on every save or delete (`wp_nonce_field()` / `check_admin_referer()`, or a localized nonce for the React screens);
  - use `$wpdb->insert()`, `update()` and `delete()` rather than raw `query()`, and go through the shared data-layer class where the plugin has one;
  - sanitize input and escape output at render time (`esc_html()`, `esc_url()`, `esc_attr()`).
- Keep changes focused: one concern per pull request.

## Document every code change

Every code change to a plugin needs a new entry in that plugin's `CHANGE_LOG.md`, including bug fixes, refactors and internal-only changes. Create the file if the plugin has none. If the change alters how the plugin works, update its `SPECIFICATION.md` to describe the plugin as it now is; the history belongs in `CHANGE_LOG.md`, not the spec.

## Commit messages

Use [Conventional Commits](https://www.conventionalcommits.org/): `<type>(<scope>): <subject>`.

- Types: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`, `perf`, `ci`.
- Subject in the imperative, lower case, no trailing period.
- Examples: `feat(ms-exams): add list view`, `fix(connections): handle invalid URLs`, `docs(agents): update source links`.

The full convention is in [`.github/instructions/commit-messages.instructions.md`](.github/instructions/commit-messages.instructions.md).

## Pull requests

1. Target the `dev` branch.
2. Use a Conventional Commits title. If you leave the description empty, the repository's PR workflow drafts a title and description for you; review and correct it.
3. Describe what changed and why, how you tested it, and any database or migration impact.
4. Make sure the plugin still activates and the affected screens work; there is no automated test suite, so say what you checked by hand.
5. Be ready to respond to review comments. Maintainers merge once the change is approved.

## Documentation mirrors

Files under `docs/wordpress/wordpress-plugins/` and `docs/wordpress/api-reference/wp-cli-commands/` are **copies of pages on developer.wordpress.org**, refreshed by tooling, not written by hand. Do not edit them manually; edits are overwritten on the next sync. To refresh them:

- Locally, with Claude Code: `/sync-wordpress-plugin-docs` or `/sync-wordpress-wp-cli-command-docs`, optionally with an Index number or name to limit the scope.
- In GitHub, the scheduled agentic workflows `sync-wordpress-plugins-docs` and `sync-wp-cli-docs` open draft pull requests automatically. Review their diffs like any other change.

Conventions for these mirrors are in [`docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md`](docs/styles/WORDPRESS-PLUGIN-DOCS-STYLE.md). Documentation outside the mirrors (READMEs, specifications, agent docs) is normal hand-written content and welcome as a contribution.

## Agentic workflows

The `.github/workflows/*.md` files are [GitHub Agentic Workflows](https://github.com/github/gh-aw). The `.lock.yml` next to each one is generated. If you edit a `.md` workflow, recompile it and commit both files together:

```
gh extension install github/gh-aw
gh aw compile
```

Never edit a `.lock.yml` by hand.

## Licence

By contributing you agree that your contributions are licensed under the [MIT License](LICENSE).
