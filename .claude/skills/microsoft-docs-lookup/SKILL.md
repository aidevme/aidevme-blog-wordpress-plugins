---
name: microsoft-docs-lookup
description: How and when to use the Microsoft Learn MCP tools in this WordPress-first repo. Use ONLY when a plugin integrates with a Microsoft product or service (Azure, Microsoft Graph, Entra ID/Azure AD, .NET, Windows, Microsoft Learn catalog APIs) and you need real API behavior for a spec, implementation, review or doc. Not for ordinary WordPress or PHP questions.
---

# Microsoft documentation lookup

This repo is WordPress-first. For anything WordPress itself, the local Plugin Handbook mirror is authoritative (see the `wordpress-handbook-lookup` skill). Use Microsoft Learn only when a plugin talks to a Microsoft product or service, so the API's shape comes from official documentation and not from memory.

## Tools

These belong to the `microsoft-docs` plugin (enabled in `.claude/settings.json`). An agent can call them only if its `tools` list includes them.

- `mcp__plugin_microsoft-docs_microsoft-learn__microsoft_docs_search`: search Microsoft Learn and get up to ten concise excerpts with titles and URLs. Start here.
- `mcp__plugin_microsoft-docs_microsoft-learn__microsoft_docs_fetch`: fetch one page's full content as markdown, once search has pointed at it. Use it when an excerpt is incomplete.
- `mcp__plugin_microsoft-docs_microsoft-learn__microsoft_code_sample_search`: find official code samples. Pass `language: php` for anything you are about to write in this repo.

## How to use them, by role

- **Designing (architect):** ground the integration part of the spec (endpoints, auth flow, permissions and scopes, rate limits, response shape) in what the documentation says. Cite the page URL in the spec.
- **Implementing (developer):** look up the request/response shape and required parameters before writing the call. Prefer official samples, adapted to WordPress conventions (`wp_remote_get()`/`wp_remote_post()` for HTTP; see the HTTP API row in the `wordpress-handbook-lookup` skill).
- **Reviewing (tester):** verify the code's assumptions about the API against the documentation instead of taking the implementation's own comments at face value.
- **Documenting (documenter):** check terminology and described behavior against the documentation instead of describing the API from memory. The documenter has search and fetch, but not code-sample search.

## Rules

- Do not use these tools for ordinary WordPress/PHP questions.
- Search first, fetch second; do not fetch a page you have not located.
- Note the page URL for anything you rely on, so a reader can check it.
- If the documentation does not answer the question or contradicts the code, say so plainly rather than guessing.
