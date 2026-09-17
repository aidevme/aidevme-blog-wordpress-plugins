# Using the WordPress.org MCP Server

Reference: <https://developer.wordpress.org/plugins/wordpress-org/using-the-mcp-server/>

## Overview

WordPress.org offers an MCP (Model Context Protocol) server enabling AI development tools to help developers prepare, validate, and submit plugins. This integration works with platforms like Claude, Cursor, and VS Code, providing direct access to plugin guidelines and submission tracking within your development environment.

## What is MCP?

Model Context Protocol is an open standard that lets AI assistants connect to external services. Rather than manual copying between tools and WordPress.org, MCP creates a seamless connection for reading guidelines, validating documentation, checking status, and submitting plugins.

## Prerequisites

- WordPress.org account
- Compatible MCP client (Claude Desktop, Claude Code, Cursor, or VS Code)
- Node.js version 18 or later

## Setup Options

**Quick Setup:** Run `npx -y @wporg/mcp` to automatically configure supported clients.

**Manual Setup:** Authorize via the WordPress.org login page, copy the JSON configuration provided, then paste it into your client's appropriate configuration file.

## Available Features

The server provides three capability types:

- **Tools** — validate readme files, retrieve plugin review status, and submit plugins
- **Resources** — access plugin guidelines, FAQs, header requirements, and reserved slug lists
- **Prompts** — guided workflows for preparation, Plugin Check execution, and addressing reviewer feedback

## Developer Responsibilities

You are responsible for all code in your plugin. The review process remains consistent regardless of development method. Developers must review all AI-generated changes, verify security, check licenses, and run Plugin Check locally before submission.

## Common Workflows

Developers can request assistance preparing submissions, checking review status, or addressing reviewer feedback through conversational prompts to their AI assistant.
