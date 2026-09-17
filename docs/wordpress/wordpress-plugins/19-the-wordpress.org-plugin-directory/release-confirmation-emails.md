# Release Confirmation Emails

Reference: <https://developer.wordpress.org/plugins/wordpress-org/release-confirmation-emails/>

## Overview

This page describes an opt-in security feature that requires plugin developers to confirm new releases through a dashboard after tagging versions in SVN. When enabled on a plugin, to release a new version you'll need to tag a new release in SVN as normal, and then confirm on the Release Management dashboard.

## Requirements

- Using tags for version releases (not trunk)
- Updating the `Stable Tag:` header in readme.txt
- Unable to modify tagged versions post-release
- Committers must receive emails individually (not through shared inboxes)

## Notable Feature

Release Confirmations are opt-in, but only require a singular committer to confirm the release. Teams needing multiple approvals can request this from the WordPress Plugins team.

All actions are secured through tokenized email links sent to plugin committers when new versions are detected.
