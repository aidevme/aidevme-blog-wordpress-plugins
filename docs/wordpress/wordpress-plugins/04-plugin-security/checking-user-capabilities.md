# Checking User Capabilities

Reference: <https://developer.wordpress.org/plugins/security/checking-user-capabilities/>

## Overview

Every user logged into WordPress is automatically assigned specific user capabilities depending on their user role. User roles (Administrator, Editor, Author, Contributor, Subscriber) represent group membership, while capabilities are specific permissions tied to those roles.

## Hierarchy System

Roles follow a hierarchical structure where higher roles inherit capabilities from lower ones. An Administrator, for instance, inherits all capabilities from Subscriber through Editor roles.

## Critical Security Principle

As you build a plugin, make sure to run your code only when the current user has the necessary capabilities.

## Practical Examples

**Unsecured Approach:** A "Delete Post" feature with no capability restrictions allows any site visitor to trash posts — a major security vulnerability.

**Secured Approach:** The improved version uses `current_user_can( 'edit_others_posts' )` to verify the user possesses appropriate permissions before displaying or processing the delete functionality. This restricts access to Editors and above.
