# Hooking WP-Cron Into the System Task Scheduler

Reference: <https://developer.wordpress.org/plugins/cron/hooking-wp-cron-into-the-system-task-scheduler/>

## Overview

WordPress's cron system doesn't operate continuously, potentially causing missed scheduled tasks. The solution involves configuring your operating system's native task scheduler to trigger WordPress cron at regular intervals.

## Implementation Steps

The process requires two actions:

- Configure the system task scheduler to make periodic web requests to `wp-cron.php`
- Disable WordPress's built-in cron to prevent unnecessary server overhead

To disable automatic WP-Cron execution, add this line to `wp-config.php`:

```php
define( 'DISABLE_WP_CRON', true );
```

## Windows Setup

Windows Task Scheduler can execute this PowerShell command:

```powershell
powershell "Invoke-WebRequest http://YOUR_SITE_URL/wp-cron.php"
```

Access Task Scheduler through Administrative Tools in the control panel.

## MacOS and Linux Setup

Both systems use cron, accessible via `crontab -e` in the terminal. Cron syntax requires five time parameters (minute, hour, day of month, month, day of week) followed by the command.

Use asterisks (*) for wildcard time values. Example for every 15 minutes:

```bash
*/15 * * * * command
```

Running WordPress cron daily at midnight using `wget`:

```bash
0 0 * * * wget --delete-after http://YOUR_SITE_URL/wp-cron.php
```

The `--delete-after` flag prevents saving the HTTP response output.
