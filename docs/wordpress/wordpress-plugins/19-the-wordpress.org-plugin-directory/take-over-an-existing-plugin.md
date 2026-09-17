# Take Over an Existing Plugin

Reference: <https://developer.wordpress.org/plugins/wordpress-org/take-over-an-existing-plugin/>

## Overview

The WordPress plugin directory allows developers to adopt abandoned plugins rather than letting them become outdated. When taking over a plugin, you assume responsibility for its maintenance, security, and compliance with WordPress guidelines.

## The Adoption Process

### Step 1: Check the Plugin Status

Before proceeding, thoroughly review the plugin's current state:

- **Active plugins** — ensure you can maintain the codebase long-term
- **Closed for inactivity** — contact `plugins@wordpress.org` directly with your proposed version
- **Closed for security issues** — you must resolve all identified vulnerabilities
- **Experience requirement** — you should have maintained similar plugins with comparable user bases

Larger plugins (100,000+ users) face stricter scrutiny due to their significant user impact.

### Step 2: Contact the Original Developer

You must make genuine efforts to reach the original developer through:

- Direct email
- Plugin support page comments
- GitHub issues

If the developer doesn't respond within 30 days, proceed to the next step. If they agree to transfer, they can grant access directly through their developer account.

### Step 3: Update the Code

Your revision must include:

- Documentation of new ownership in the readme file, crediting previous contributors
- Updated copyright information (additive — retain original credits and add yours)
- Removal of previous owner connections (links, server calls, support channels)

The plugin must maintain its original purpose and functionality while meeting current WordPress standards. Major upgrades require a clear upgrade path for existing users.

### Step 4: Submit for Review

Email `plugins@wordpress.org` with your updated code (as a zip file or via public repository link) and explain your outreach attempts. The team will conduct a thorough security and guidelines review, treating your submission as a new plugin application.

### Step 5: Original Developer Notification

The WordPress team contacts the original developer with your information and request. They allow 30 days for a response.

### Step 6: Wait for Decision

- **Developer approves** — the team facilitates transfer to your account
- **Developer denies** — you're encouraged to create a fork instead
- **No response after 30 days** — the team decides based on your history and the plugin's circumstances

### Step 7: Update via SVN

The plugin is temporarily closed, then reopened under your account after you update the code repository.

## Frequently Asked Questions

**Will old reviews and support posts disappear?**

No. All historical reviews and support threads transfer with the plugin.

**Must I retain the original developer as a contributor?**

You can remove their commit access but must preserve their copyright credits in the code. Keeping them listed as a contributor is recommended.

**What if the original developer has died?**

While you skip the permission step, the WordPress team reaches out to the developer's colleagues or organization to determine if they wish to continue maintaining the plugin. The team also respects any wishes regarding permanent closure.

**Why might my request be denied?**

Common reasons include:

- Insufficient experience for the plugin's complexity
- High-risk plugin designation
- Corporate trademark ownership
- Legal restrictions on transfer
- Your history of guideline violations
- Original developer's refusal
- Concerns about your community standing

If a plugin is unavailable, the team typically recommends submitting your work as a fork instead.
