# Previews and Blueprints

Reference: <https://developer.wordpress.org/plugins/wordpress-org/previews-and-blueprints/>

## Overview

This page explains how WordPress plugin developers can enable preview functionality through the WordPress Playground feature.

## Plugin Preview Button

A convenient feature that allows users to test plugins directly in their browser before downloading them.

## Requirements for Enabling Previews

Developers need two things: a valid `blueprint.json` file must be provided in a blueprints sub-directory of the plugin's assets folder, and approval from a committer to set it to "public."

## Blueprint Files

These JSON configuration files set up Playground instances. They control settings like PHP version, WordPress version, the landing page, and automated setup steps. Developers can specify actions such as logging in, installing plugins/themes, or running custom PHP code.

## Submission Process

If developers lack a blueprint file, WordPress provides an auto-generated option. They can test their plugin, download the generated blueprint, modify it as needed, and then commit it to Subversion at `/assets/blueprints/blueprint.json`.

Both basic and advanced blueprint examples are available, demonstrating various configuration options.
