# Users

Reference: <https://developer.wordpress.org/plugins/users/>

## Overview

A WordPress user represents an access account with specific capabilities within a WordPress installation. Each account requires a username, password, and email address at minimum.

Once created, users can log into the WordPress Admin interface or access WordPress programmatically. The system stores all user data in the `users` table.

## Roles and Capabilities

WordPress organizes user permissions through roles, with each role containing a defined set of capabilities. Developers can establish custom roles with tailored capability sets. This system allows programmers to limit the set of actions an account can perform.

## The Principle of Least Privileges

WordPress follows a security practice of granting users only the essential permissions needed for their specific tasks. When developing plugins, you should apply this same principle by creating appropriate roles and verifying capabilities before executing sensitive operations.
