# Block Specific Plugin Guidelines

Reference: <https://developer.wordpress.org/plugins/wordpress-org/block-specific-plugin-guidelines/>

## Overview

This page provides guidance for developers submitting plugins to the Block Directory. The goal of the Block Directory is to provide a safe place for WordPress users to find and install new blocks.

## Core Requirements for Block Plugins

- Single, independent blocks (typically one top-level block per plugin)
- Descriptive naming that reflects the block's purpose
- Inclusion of a valid `block.json` file with required attributes
- Independent functionality without mandatory external dependencies
- Seamless operation requiring no login, payment, or additional setup
- Minimal server-side PHP code
- No advertisements or promotional messaging

## Notable Restrictions

Block plugins cannot include UI outside the editor (no admin menus or options panels), cannot bundle multiple unrelated blocks, and must function immediately upon installation without intrusive upselling.

Block plugins are intended to work seamlessly and instantly when installed from the editor, establishing user-centric expectations for the directory's offerings.
