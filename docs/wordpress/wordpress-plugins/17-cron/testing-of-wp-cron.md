# Testing of WP-Cron

Reference: <https://developer.wordpress.org/plugins/cron/simple-testing/>

## Overview

This guide covers methods for testing WordPress cron jobs through various tools and functions.

## WP-CLI

The command-line interface offers dedicated cron commands. Users can "list" scheduled jobs and "run {job name}" to execute specific tasks. Additional details are available in the official WP-CLI documentation.

## WP-Cron Management Plugins

Multiple plugins accessible through the WordPress.org Plugin Directory provide interfaces for viewing, editing, and managing scheduled cron events and available schedules.

## _get_cron_array()

This function returns an array of all currently scheduled cron events. It serves developers needing to examine the complete list of active jobs programmatically.

## wp_get_schedules()

This function returns an array of available event recurrence schedules. Developers use it to inspect the raw collection of available scheduling intervals.
