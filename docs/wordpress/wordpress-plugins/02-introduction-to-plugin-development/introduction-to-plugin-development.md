# Introduction to Plugin Development

Reference: <https://developer.wordpress.org/plugins/intro/>

## Overview

The Plugin Developer Handbook is a resource for developers at all levels. It covers a variety of topics — everything from what should be in the plugin header, to security best practices, to tools you can use to build your plugin. The documentation is a perpetual work in progress, and contributions to improve it are welcome.

## Why We Make Plugins

The fundamental principle of WordPress development is: don't touch WordPress core. Core files are overwritten during updates, so all custom functionality should be implemented through plugins instead.

Plugins offer flexibility in complexity — from simple single-file solutions to elaborate multi-file systems. The "Hello Dolly" plugin exemplifies minimal plugin structure: it requires only a plugin header, basic PHP functions, and hooks to connect functionality.

By using plugins, developers can greatly extend the functionality of WordPress without touching WordPress core itself.

## What is a Plugin?

See: [what-is-a-plugin.md](what-is-a-plugin.md)
