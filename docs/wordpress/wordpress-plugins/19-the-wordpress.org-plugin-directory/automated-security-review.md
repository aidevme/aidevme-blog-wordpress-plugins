# Automated Security Review

Reference: <https://developer.wordpress.org/plugins/wordpress-org/automated-security-review/>

Every new release of a plugin hosted on WordPress.org goes through an automated security review before it is distributed through the WordPress.org update API. Releases with a high risk score are blocked from distribution until the issues are resolved.

Plugin authors whose release was blocked are notified by email. This page explains what that email means and what to do next.

## How Releases Are Reviewed

Since June 2026, every plugin release goes through a [cooldown period](https://wordpress.org/news/2026/06/pts/) before it is distributed through the WordPress.org update API, which powers update notifications and one-click updates in the WordPress dashboard.

During the cooldown, the changes in each release are analyzed by several AI models together with Jetpack Scan. The results are cross-checked and combined into findings, each with a risk score. The higher the score, the higher the potential risk. Cross-checking multiple tools keeps accuracy high and false positives low, but not zero.

What happens next depends on the release's highest risk score:

- **Below the blocking threshold:** The release continues through the normal cooldown process and is distributed as usual. No email is sent, and no action is needed from plugin authors.
- **At or above the blocking threshold:** The release is blocked from distribution as soon as the review finishes, and all committers of the plugin receive an email with the findings.

A high risk score does not mean malicious intent. An accidentally introduced vulnerability can score just as high as intentional malware. The score measures risk, not intent.

## Email Notifications

When a release is blocked, all committers of the plugin receive an email notification. It includes the highest risk score the review reported and a list of findings, each with its own risk score, a short summary, and the affected file and line, linked to the plugin's code to point directly at the relevant spot.

Emails are currently only sent when a release is blocked. Authors who haven't received an email don't need to take any action.

## What "Blocked" Means

A blocked release is withheld from the WordPress.org update API:

- Sites running the plugin are not offered the blocked version as an update. They keep receiving the previously distributed version.
- Only that specific version is blocked. The plugin remains published in the directory, it is not closed, its page stays up, and previously released versions are unaffected.
- The block stays in place beyond the end of the cooldown period until it is resolved in a subsequent release.

## Resolving a Blocked Release

A blocked release will not be distributed through the update API until the issues are resolved. The fastest way to get a release unblocked:

1. Review the reported findings in the email. They describe exactly what triggered the block.
2. Fix the issues and release a new version as usual. The block only applies to the flagged version, so the new release is unaffected by it and goes through the regular cooldown and security review. When it scores below the blocking threshold, it is distributed normally.

## Incorrect Findings

Automated reviews can produce false positives. If a finding looks incorrect, plugin authors should reply directly to the notification email explaining why the finding doesn't apply.

The team handles a high volume of reviews, so publishing a fixed release is almost always faster than waiting for the manual review of an appeal. Even so, reports of false positives can be helpful feedback and directly improve the accuracy of the review for everyone.

## Frequently Asked Questions

### Does a blocked release affect sites already running my plugin?

No. Sites keep receiving the previously distributed version through the update API. The blocked version is simply never offered to them.

### Was my plugin closed?

No. A release block is not a closure. Your plugin's directory page stays up and previously released versions remain available. Closures are a separate process and are communicated separately.

### Does this mean I'm suspected of distributing malware?

No. The review scores risk, not intent. Vulnerabilities introduced by accident are flagged the same way as intentionally malicious code, because the risk to sites is the same.

### Can a blocked version be unblocked without releasing a new version?

Only if the findings turn out to be incorrect after an appeal to the Plugins Team. Because of the review volume the team handles, releasing a fixed version is almost always faster.

### Will the new version be reviewed again?

Yes. Every release goes through the same automated review during its cooldown, including releases that fix a blocked one.
