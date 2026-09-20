# Automated Security Review

Reference: <https://developer.wordpress.org/plugins/wordpress-org/automated-security-review/>

## Overview

Every new release of a plugin hosted on WordPress.org goes through an automated security review before it is distributed through the WordPress.org update API. This explains how WordPress.org screens plugin releases for security risks before distribution.

## What Happens When Issues Are Found

Releases that score above a risk threshold get blocked from distribution, and plugin authors receive email notifications detailing the specific concerns.

Being blocked does not mean:

- Your plugin is closed or removed
- You're suspected of malicious intent
- Existing installations are affected (they continue receiving the previous version)

## Resolution Path

Authors can address flagged issues by releasing a corrected version, which undergoes the same review process independently.

## False Positives

Automated systems can produce incorrect findings. Authors can appeal through email, though releasing a fix typically resolves matters faster.

This is a risk-assessment tool measuring potential harm, not author intent, and it operates separately from formal plugin closure procedures.
