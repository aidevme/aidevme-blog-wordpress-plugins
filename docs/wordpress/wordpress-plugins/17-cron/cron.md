# Cron

Reference: <https://developer.wordpress.org/plugins/cron/>

## Overview

WP-Cron is how WordPress handles scheduling time-based tasks in WordPress.

## Key Characteristics

The system operates by examining scheduled tasks during each page load, executing any that are due. Unlike traditional UNIX cron jobs that run continuously, WP-Cron depends entirely on site traffic to trigger its checks.

## Primary Use Cases

WordPress leverages WP-Cron for several core functions, including update verification and automated post publishing.

## Advantages Over System Schedulers

- **Accessibility**: Many shared hosting environments lack system scheduler access
- **Simplicity**: Implementing scheduling through WordPress APIs proves more straightforward than external system configuration
- **Reliability**: Tasks queue automatically and execute at the subsequent page load, ensuring eventual completion even if timing windows are missed

## Important Limitation

Scheduling accuracy depends on site activity. Tasks may experience significant delays if insufficient page loads occur during the intended execution window.
