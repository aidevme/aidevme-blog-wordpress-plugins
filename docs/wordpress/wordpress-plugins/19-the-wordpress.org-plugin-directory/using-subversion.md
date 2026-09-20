# Using Subversion

Reference: <https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/>

## Overview

Subversion (SVN) is a version control system for managing WordPress plugin files. Unlike Git, SVN functions primarily as a "release repository" rather than a development system. SVN and the Plugin Directory are a release repository — unlike Git, you shouldn't commit every small change.

All plugin files are stored centrally on WordPress.org servers, where only the plugin author can upload changes. This process automatically updates both the repository and the Plugin Directory display.

## Account Setup

Your SVN username matches your WordPress.org forum username (case-sensitive). You can configure a separate SVN password through your account settings at profiles.wordpress.org. Remember, capitalization matters — if your username is JaneDoe, then you must use the capital J and D.

## Directory Structure

Three default directories exist in every SVN repository:

- `/trunk/` — contains active development code
- `/tags/` — stores versioned releases (e.g., `/tags/1.0/`)
- `/assets/` — holds screenshots, headers, and plugin icons

The `/branches/` directory is no longer created by default.

### Key Guidelines

- Never place your main plugin file in trunk subfolders
- Never commit pre-release code to SVN
- Always use proper semantic versioning for tags
- Create tags by copying from trunk, not direct uploads

## Best Practices

Avoid using SVN for everyday development, since each push rebuilds all plugin zip files, potentially delaying updates by up to 6 hours. Instead, maintain trunk with your latest code and create tags only when releasing formal versions.

Tags should be created using `svn cp` to preserve history, followed by a single commit rather than pushing code directly to tag folders.

## Practical Workflow

**Initial Setup:** Check out the repository, add files to trunk, then commit with a message.

**Making Updates:** Update your local copy with `svn up`, edit files, verify changes with `svn diff`, then commit with `svn ci -m "message"`.

**Releasing Versions:** Copy trunk to a new tag using `svn cp trunk tags/VERSION_NUMBER`, update the `Stable Tag` field in `readme.txt`, then commit.

## Important Notes

Don't put anything in SVN that you're not willing and prepared to have deployed to everyone who uses your plugin. This includes vendor files, `.gitignore`, and zip archives — only upload individual source files.
