# Understanding WP-Cron Scheduling

Reference: <https://developer.wordpress.org/plugins/cron/understanding-wp-cron-scheduling/>

## Overview

WP-Cron operates differently from traditional system cron jobs. Rather than scheduling tasks at specific clock times, it uses intervals to simulate a system cron.

The mechanism works by accepting two parameters: an initial execution time and a recurring interval measured in seconds. For instance, a task scheduled to start at 2:00 PM with a 300-second interval would execute at 2:00 PM, then repeat at 2:05 PM, 2:10 PM, and so forth.

## Default Intervals

WordPress includes built-in scheduling options:

- hourly
- twicedaily
- daily
- weekly (available since WP 5.4)

## Creating Custom Intervals

Users can extend the available schedules by implementing a filter function. Here's an example that adds a five-second interval:

```php
add_filter( 'cron_schedules', 'example_add_cron_interval' );
function example_add_cron_interval( $schedules ) { 
    $schedules['five_seconds'] = array(
        'interval' => 5,
        'display'  => esc_html__( 'Every Five Seconds' ), );
    return $schedules;
}
```

All interval values must be expressed in seconds.
