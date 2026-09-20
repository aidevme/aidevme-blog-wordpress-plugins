# Scheduling WP Cron Events

Reference: <https://developer.wordpress.org/plugins/cron/scheduling-wp-cron-events/>

## Overview

The WP Cron system enables developers to schedule recurring tasks using WordPress hooks. This guide covers three essential operations: creating hooks, scheduling tasks, and unscheduling them.

## Adding the Hook

To execute scheduled tasks, you must establish a custom hook paired with a callback function. As the documentation notes, "This is a very important step. Forget it and your task will never run."

The basic syntax requires two parameters:

```php
add_action( 'bl_cron_hook', 'bl_cron_exec' );
```

The prefix convention (here, "bl_") prevents naming conflicts across plugins and is considered best practice.

## Scheduling the Task

A critical consideration: calling `wp_schedule_event()` repeatedly with identical parameters will create duplicate schedules. The solution involves checking whether the hook is already scheduled using `wp_next_scheduled()`.

This function returns either a timestamp for the next execution or false if unscheduled:

```php
wp_next_scheduled( 'bl_cron_hook' )
```

To schedule recurring tasks, `wp_schedule_event()` requires three parameters:

- `$timestamp` - UNIX timestamp for initial execution
- `$recurrence` - Interval name (in seconds)
- `$hook` - Custom hook name

Proper implementation combines both functions:

```php
if ( ! wp_next_scheduled( 'bl_cron_hook' ) ) {
    wp_schedule_event( time(), 'five_seconds', 'bl_cron_hook' );
}
```

## Unscheduling Tasks

Remove tasks using `wp_unschedule_event()`, which accepts:

- `$timestamp` - Next occurrence timestamp
- `$hook` - Custom hook name

This function removes the specified task and all future occurrences. Retrieve the timestamp via `wp_next_scheduled()`:

```php
$timestamp = wp_next_scheduled( 'bl_cron_hook' );
wp_unschedule_event( $timestamp, 'bl_cron_hook' );
```

Neglecting to unschedule tasks causes WordPress to continue execution attempts indefinitely, even after plugin deactivation. Register cleanup code in a deactivation hook:

```php
register_deactivation_hook( __FILE__, 'bl_deactivate' ); 

function bl_deactivate() {
    $timestamp = wp_next_scheduled( 'bl_cron_hook' );
    wp_unschedule_event( $timestamp, 'bl_cron_hook' );
}
```
