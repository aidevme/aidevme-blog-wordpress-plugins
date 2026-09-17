# Introduction to Plugin Development

Reference: <https://developer.wordpress.org/plugins/intro/>

## Overview

Welcome to the Plugin Developer Handbook. Whether you're writing your first plugin or your fiftieth, this resource is meant to help you write the best plugin possible.

The Plugin Developer Handbook covers a variety of topics — everything from what should be in the plugin header, to security best practices, to tools you can use to build your plugin. It's also a work in progress — if you find something missing or incomplete, notify the documentation team so it can be improved.

## Why We Make Plugins

If there's one cardinal rule in WordPress development, it's this: don't touch WordPress core. This means you don't edit core WordPress files to add functionality to your site, because WordPress overwrites core files with each update. Any functionality you want to add or modify should be done using plugins.

WordPress plugins can be as simple or as complicated as you need them to be, depending on what you want to do. The simplest plugin is a single PHP file. The Hello Dolly plugin is an example of such a plugin — the plugin PHP file just needs a plugin header, a couple of PHP functions, and some hooks to attach your functions to.

Plugins allow you to greatly extend the functionality of WordPress without touching WordPress core itself.

## What is a Plugin?

See: [what-is-a-plugin.md](what-is-a-plugin.md)
