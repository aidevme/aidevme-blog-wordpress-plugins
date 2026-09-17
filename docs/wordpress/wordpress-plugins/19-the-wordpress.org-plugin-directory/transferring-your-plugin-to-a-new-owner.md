# Transferring Your Plugin to a New Owner

Reference: <https://developer.wordpress.org/plugins/wordpress-org/transferring-your-plugin-to-a-new-owner/>

## Overview

A WordPress plugin can have multiple committers and support representatives, but only one official owner at any given time. This ownership structure parallels how a single author is designated for a WordPress post.

## For Plugins Under 10,000 Users

The transfer process requires two sequential actions:

**Step 1: Add the new owner as a committer**

- Access the advanced settings at `https://wordpress.org/plugins/YOURPLUGIN/advanced`
- Input their username as a committer
- Update `readme.txt` to include their user ID in the author field

**Step 2: Complete the transfer**

Navigate to the Advanced tab's "Danger Zone" section. You'll find a dropdown menu labeled "Transfer Your Plugin" where you can select the new owner and confirm the action.

If there are no other committers, the plugin will not be available to be transferred, so you must add one first.

## For Larger Plugins (10,000+ Users or Featured/Beta Status)

High-traffic and officially recognized plugins require manual processing to prevent misuse. Contact `plugins@wordpress.org` from the current owner's registered email address with:

1. A concise explanation for the transfer
2. The new owner's user ID
3. Any applicable status changes regarding featured or beta designation

Requests are typically approved promptly, though denial or delays may occur if the plugin is deemed critical to WordPress.org infrastructure or if authenticity concerns arise.
