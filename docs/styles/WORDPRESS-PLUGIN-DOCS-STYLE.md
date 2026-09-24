# WordPress Plugin Docs Style Guide

This guide governs every file under `docs/wordpress/wordpress-plugins/`. It mirrors the official [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/) — every document here is a sourced copy of one handbook page (or sub-page), kept in sync via the `researcher` agent (mode `wordpress-plugin-docs`).

## Folder and file layout

- One folder per `##` (top-level) handbook section, directly under `docs/wordpress/wordpress-plugins/`.
- Folder names are numbered to match reading order: `NN-slug`, zero-padded to two digits (`01-plugin-handbook`, `12-taxonomies`, `19-the-wordpress.org-plugin-directory`). The number reflects position in `index.md`'s Index table, not the source site's own ordering.
- Slugs are lowercase, hyphen-separated, derived from the heading text (`Plugin Basics` → `plugin-basics`). Punctuation is dropped except an internal dot when it's part of a real name (`the-wordpress.org-plugin-directory`).
- Each folder contains:
  - One overview file named after the section itself (`03-plugin-basics/plugin-basics.md`) — this is always the `##` section's own content.
  - One file per `###` sub-heading, named by its own slug, sitting flat in the same folder (`03-plugin-basics/header-requirements.md`, not a further subfolder). Sub-pages are never nested more than one level deep, even if the source site nests them (e.g. `.../wordpress-org/plugin-security/reporting-plugin-security-issues/` still becomes a flat `19-the-wordpress.org-plugin-directory/reporting-plugin-security-issues.md`).
- When a sub-heading's content is short enough to live inline in the parent overview file instead of its own file, link to it with a one-line `See: [slug.md](slug.md)` pointer rather than duplicating content in two places.

## The Index table (`index.md`)

`index.md` starts with the guide's own `# Title`, a top-level `Reference:` line pointing at `https://developer.wordpress.org/plugins/`, then an `## Index` section containing one table:

```markdown
| Index | Name | Document | Reference Url | Last Synced On | Notes |
| --- | --- | --- | --- | --- | --- |
```

- **Index** — hierarchical position mirroring heading depth: `5` for a `##` section, `5.1`, `5.2`, ... for its `###` sub-headings, in source order.
- **Name** — the heading text exactly as it appears in the handbook (and in the `##`/`###` outline below the table).
- **Document** — a relative markdown link to the file holding this row's content, e.g. `[actions.md](05-hooks/actions.md)`.
- **Reference Url** — the exact developer.wordpress.org (or `developer.wordpress.org/apis/...` when content has moved to the Common APIs Handbook) page this row is sourced from, as an autolink: `<https://...>`.
- **Last Synced On** — an ISO 8601 UTC timestamp (`YYYY-MM-DDTHH:MM:SSZ`) of the last successful sync against the live source. Get the real time when syncing (e.g. `date -u +%Y-%m-%dT%H:%M:%SZ`) — never approximate or invent it.
- **Notes** — free text. Use `Synced` for a plain successful sync, or `Synced — {short reason}` to flag anything worth knowing: a slug that differs from the guessed/linked one, content that has moved to another handbook, a redirect that was followed, or a sync failure (`Sync failed — 404`).

Below the table, `index.md` repeats the same outline as plain `##`/`###` headings (no table), so the file also works as a readable table of contents.

## Document format

Every content file (overview or sub-page) follows this exact skeleton:

```markdown
# {Heading}

Reference: <{source url}>

## {Subheading}

{prose}

## {Another Subheading}

{prose, lists, code}
```

- First line is always `# {Heading}` — matching the **Name** column exactly.
- Second block is always a single `Reference: <{url}>` line (angle brackets, not a bare URL — the repo's markdown linter flags bare URLs under `MD034`).
- Body sections use `##` for the source's top-level headings and `###` for anything nested under them. Don't skip heading levels.
- When a page has moved to a different WordPress handbook (this has happened for several Plugin Security sub-pages, now in the Common APIs Handbook), say so plainly in a short `## Note` section and point the `Reference:` line at the real, current URL — don't silently keep a dead link.

## Content fidelity

- **Never paraphrase from memory or let a summarizing tool rewrite the source.** Content must come from what was actually read on the live page — quote its wording, structure, tables, and code examples faithfully rather than compressing them into bullet-point paraphrases. A generic web-fetch summarizer tends to drop worked examples and re-word sentences; prefer reading the rendered page (or its raw markdown, for GitHub-hosted sources) directly, e.g. via a browser tool, and copying its actual text.
- Keep every code example the source has, verbatim, including inline comments. Don't trim "for brevity."
- Preserve tables from the source as markdown tables (see `uninstall-methods.md` for an example) rather than flattening them into prose.
- Drop only the things that don't belong in a reference doc: author bylines, "published on"/"last modified" datestamps scraped from the page, and site navigation chrome ("Previous section: ... / Next section: ..."). The **Reference Url** in the table is the provenance; you don't need an inline citation of the author or date.
- Add no commentary, opinions, or editorializing of your own. If something is genuinely ambiguous or missing on the source page, say so plainly rather than guessing.

## Formatting mechanics

- Straight quotes and apostrophes (`'`, `"`), not curly/smart quotes — even when the source page renders curly ones.
- Em dashes (`—`) are fine and match the source site's own style.
- Fence every code block with its language: ```` ```php ````, ```` ```js ````, ```` ```json ````, ```` ```html ````, ```` ```bash ````, or plain ```` ``` ```` for a shell tree / plain text listing.
- Use **spaces, never hard tabs**, inside code blocks — convert any tab-indented source code before writing the file (the repo's linter flags `MD010/no-hard-tabs`). WordPress core style normally indents PHP with tabs; represent that indentation with spaces here instead.
- Bullet lists use `-`, not `*`.
- Bold (`**text**`) is fine for genuinely emphasized terms the source itself emphasizes (a required field name, a strong warning), not for random emphasis.
- No trailing author/date footers, no "Generated by" notices, no emoji.

## Keeping this in sync

This style guide, the folder layout, and the Index table conventions are what the Plugin Handbook mode of `.claude/agents/researcher.md` and `/sync-wordpress-plugin-docs` follow when refreshing these docs. If you change a convention here, update that agent mode to match — the two are meant to stay identical.
