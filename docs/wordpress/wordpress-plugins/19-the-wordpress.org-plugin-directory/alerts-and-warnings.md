# Alerts and Warnings

Reference: <https://developer.wordpress.org/plugins/wordpress-org/alerts-and-warnings/>

When you visit plugin pages on WordPress.org, you may notice special alerts or warnings. These exist to help visitors understand the status of various plugins.

## Approved and Pending Data

Plugins that have been approved but no code has yet been uploaded will see this message:This *only* displays to the plugin owner and will go away once code has been pushed via SVN.

## Closed

As of November 2017, plugins that are closed display a notice:

This is viewable by all visitors and indicates a plugin was closed. Plugins closed after January 2018 will include a date:

After 60 days, the alert will be updated to explain *why* the plugin was closed:

Plugin committers will see the following additional note:

### Reasons why plugins are closed

- Author Request – the author has asked the plugin to be closed
- Guideline Violation – a violation of any of the guideline
- Licensing/Trademark Violation – non-GPL code in use, or trademarks are being misused
- Merged Into Core – the plugin is now a part of core (reserved for feature projects)
- Security Issue – a security concern has been found in this plugin

Additional details on why a plugin is closed are not provided to anyone outside the WordPress.org security team or the plugin authors, unless there is an extreme circumstance.

## Out of Date

Plugins that do not support the last 3 major releases of WordPress have the following notice:

Previously this message alerted users to plugins not updated within the last 2 years. In 2018 it was modified to rely on more pertinent data. Since WordPress updates major releases 2 to 3 times per year, and a maintained a plugin should be testing with the recent versions, this alert can be avoided by updating a plugin readme when new versions of WordPress is released.

Developers are emailed before every major release of WordPress and asked to update this value. They *do not* need to push a new version, just [update the readme](https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/) and edit the value of `Tested up to:` to the latest version of WordPress.
