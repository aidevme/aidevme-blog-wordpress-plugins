# Special User Roles and Capabilities

Reference: <https://developer.wordpress.org/plugins/wordpress-org/special-user-roles-capabilities/>

## Overview

Every person contributing code or support for a plugin requires their own individual account. While these accounts need not reveal personal identity, each must be used by a single person for security purposes.

Four user roles exist, manageable through the Advanced View section of a plugin page.

## Owner

The plugin submitter automatically becomes the owner upon approval and receives committer status. Ownership transfer requires accessing the Danger Zone section and selecting a new owner from the dropdown menu.

Plugin owners must maintain commit access. Before transferring ownership, ensure another user has commit permissions. If you cannot transfer ownership, contact the plugins team for assistance.

## Committer

Committers can push code via SVN and make official requests concerning a plugin to the Plugin Directory Team. They appear as "Plugin Author" in forums and may mark support posts as resolved.

Only existing committers can add or remove commit access.

## Support Rep

Support representatives possess no direct plugin management abilities and cannot request directory status changes. However, they receive "Plugin Support" forum labeling and appear on the plugin page.

Adding and removing this status can only be done by an existing committer.

## Contributor

Contributors lack plugin management access and cannot request status changes. They're publicly listed in the plugin's "Contributors & Developers" section.

Users must be listed in the `readme.txt` Contributors section to gain this role.
