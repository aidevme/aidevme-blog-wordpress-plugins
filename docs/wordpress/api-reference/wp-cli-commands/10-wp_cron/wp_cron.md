# wp cron

Reference: <https://developer.wordpress.org/cli/commands/cron/>

## Description

Tests, runs, and deletes WP-Cron events; manages WP-Cron schedules.

## Synopsis

```bash
wp cron <command>
```

## Examples

```bash
# Test WP Cron spawning system
$ wp cron test
Success: WP-Cron spawning is working as expected.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp cron event](https://developer.wordpress.org/cli/commands/cron/event/) | Schedules, runs, and deletes WP-Cron events. |
| [wp cron schedule](https://developer.wordpress.org/cli/commands/cron/schedule/) | Gets WP-Cron schedules. |
| [wp cron test](https://developer.wordpress.org/cli/commands/cron/test/) | Tests the WP Cron spawning system and reports back its status. |

### wp cron event <command>

Reference: <https://developer.wordpress.org/cli/commands/cron/event/>

Schedules, runs, and deletes WP-Cron events.

#### Examples

```bash
# Schedule a new cron event
$ wp cron event schedule cron_test
Success: Scheduled event with hook 'cron_test' for 2016-05-31 10:19:16 GMT.

# Run all cron events due right now
$ wp cron event run --due-now
Executed the cron event 'cron_test_1' in 0.01s.
Executed the cron event 'cron_test_2' in 0.006s.
Success: Executed a total of 2 cron events.

# Delete all scheduled cron events for the given hook
$ wp cron event delete cron_test
Success: Deleted a total of 2 cron events.

# List scheduled cron events in JSON
$ wp cron event list --fields=hook,next_run --format=json
[{"hook":"wp_version_check","next_run":"2016-05-31 10:15:13"},{"hook":"wp_update_plugins","next_run":"2016-05-31 10:15:13"},{"hook":"wp_update_themes","next_run":"2016-05-31 10:15:14"}]
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp cron event delete](https://developer.wordpress.org/cli/commands/cron/event/delete/) | Deletes all scheduled cron events for the given hook. |
| [wp cron event list](https://developer.wordpress.org/cli/commands/cron/event/list/) | Lists scheduled cron events. |
| [wp cron event run](https://developer.wordpress.org/cli/commands/cron/event/run/) | Runs the next scheduled cron event for the given hook. |
| [wp cron event schedule](https://developer.wordpress.org/cli/commands/cron/event/schedule/) | Schedules a new cron event. |
| [wp cron event unschedule](https://developer.wordpress.org/cli/commands/cron/event/unschedule/) | Unschedules all cron events for a given hook. |

#### wp cron event delete

Reference: <https://developer.wordpress.org/cli/commands/cron/event/delete/>

Deletes all scheduled cron events for the given hook.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<hook>…]`
  One or more hooks to delete.
- `[--due-now]`
  Delete all hooks due right now.
- `[--exclude=<hooks>]`
  Comma-separated list of hooks to exclude.
- `[--all]`
  Delete all hooks.

##### Examples

```bash
# Delete all scheduled cron events for the given hook
$ wp cron event delete cron_test
Success: Deleted a total of 2 cron events.
```

##### Global Parameters

These [global parameters](https://make.wordpress.org/cli/handbook/config/) have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

| **Argument** | **Description** |
| --- | --- |
| `--path=<path>` | Path to the WordPress files. |
| `--url=<url>` | Pretend request came from given URL. In multisite, this argument is how the target site is specified. |
| `--ssh=[<scheme>:][<user>@]<host\|container>[:<port>][<path>]` | Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant"). |
| `--http=<http>` | Perform operation against a remote WordPress installation over HTTP. |
| `--user=<id\|login\|email>` | Set the WordPress user. |
| `--skip-plugins[=<plugins>]` | Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded. |
| `--skip-themes[=<themes>]` | Skip loading all themes, or a comma-separated list of themes. |
| `--skip-packages` | Skip loading all installed packages. |
| `--require=<path>` | Load PHP file before running the command (may be used more than once). |
| `--exec=<php-code>` | Execute PHP code before running the command (may be used more than once). |
| `--context=<context>` | Load WordPress in a given context. |
| `--[no-]color` | Whether to colorize the output. |
| `--debug[=<group>]` | Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help. |
| `--prompt[=<assoc>]` | Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values. |
| `--quiet` | Suppress informational messages. |

#### wp cron event list

Reference: <https://developer.wordpress.org/cli/commands/cron/event/list/>

Lists scheduled cron events.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--<field>=<value>]`
  Filter by one or more fields.
- `[--field=<field>]`
  Prints the value of a single field for each event.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - ids
  - json
  - count
  - yaml

##### Available Fields

These fields will be displayed by default for each cron event: * hook * next_run_gmt * next_run_relative * recurrence These fields are optionally available: * time * sig * args * schedule * interval * next_run

##### Examples

```bash
# List scheduled cron events
$ wp cron event list
+-------------------+---------------------+---------------------+------------+
| hook              | next_run_gmt        | next_run_relative   | recurrence |
+-------------------+---------------------+---------------------+------------+
| wp_version_check  | 2016-05-31 22:15:13 | 11 hours 57 minutes | 12 hours   |
| wp_update_plugins | 2016-05-31 22:15:13 | 11 hours 57 minutes | 12 hours   |
| wp_update_themes  | 2016-05-31 22:15:14 | 11 hours 57 minutes | 12 hours   |
+-------------------+---------------------+---------------------+------------+

# List scheduled cron events in JSON
$ wp cron event list --fields=hook,next_run --format=json
[{"hook":"wp_version_check","next_run":"2016-05-31 10:15:13"},{"hook":"wp_update_plugins","next_run":"2016-05-31 10:15:13"},{"hook":"wp_update_themes","next_run":"2016-05-31 10:15:14"}]
```

##### Global Parameters

These [global parameters](https://make.wordpress.org/cli/handbook/config/) have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

| **Argument** | **Description** |
| --- | --- |
| `--path=<path>` | Path to the WordPress files. |
| `--url=<url>` | Pretend request came from given URL. In multisite, this argument is how the target site is specified. |
| `--ssh=[<scheme>:][<user>@]<host\|container>[:<port>][<path>]` | Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant"). |
| `--http=<http>` | Perform operation against a remote WordPress installation over HTTP. |
| `--user=<id\|login\|email>` | Set the WordPress user. |
| `--skip-plugins[=<plugins>]` | Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded. |
| `--skip-themes[=<themes>]` | Skip loading all themes, or a comma-separated list of themes. |
| `--skip-packages` | Skip loading all installed packages. |
| `--require=<path>` | Load PHP file before running the command (may be used more than once). |
| `--exec=<php-code>` | Execute PHP code before running the command (may be used more than once). |
| `--context=<context>` | Load WordPress in a given context. |
| `--[no-]color` | Whether to colorize the output. |
| `--debug[=<group>]` | Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help. |
| `--prompt[=<assoc>]` | Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values. |
| `--quiet` | Suppress informational messages. |

#### wp cron event run

Reference: <https://developer.wordpress.org/cli/commands/cron/event/run/>

Runs the next scheduled cron event for the given hook.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<hook>…]`
  One or more hooks to run.
- `[--due-now]`
  Run all hooks due right now.
- `[--exclude=<hooks>]`
  Comma-separated list of hooks to exclude.
- `[--all]`
  Run all hooks.

##### Examples

```bash
# Run all cron events due right now
$ wp cron event run --due-now
Executed the cron event 'cron_test_1' in 0.01s.
Executed the cron event 'cron_test_2' in 0.006s.
Success: Executed a total of 2 cron events.
```

##### Global Parameters

These [global parameters](https://make.wordpress.org/cli/handbook/config/) have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

| **Argument** | **Description** |
| --- | --- |
| `--path=<path>` | Path to the WordPress files. |
| `--url=<url>` | Pretend request came from given URL. In multisite, this argument is how the target site is specified. |
| `--ssh=[<scheme>:][<user>@]<host\|container>[:<port>][<path>]` | Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant"). |
| `--http=<http>` | Perform operation against a remote WordPress installation over HTTP. |
| `--user=<id\|login\|email>` | Set the WordPress user. |
| `--skip-plugins[=<plugins>]` | Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded. |
| `--skip-themes[=<themes>]` | Skip loading all themes, or a comma-separated list of themes. |
| `--skip-packages` | Skip loading all installed packages. |
| `--require=<path>` | Load PHP file before running the command (may be used more than once). |
| `--exec=<php-code>` | Execute PHP code before running the command (may be used more than once). |
| `--context=<context>` | Load WordPress in a given context. |
| `--[no-]color` | Whether to colorize the output. |
| `--debug[=<group>]` | Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help. |
| `--prompt[=<assoc>]` | Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values. |
| `--quiet` | Suppress informational messages. |

#### wp cron event schedule

Reference: <https://developer.wordpress.org/cli/commands/cron/event/schedule/>

Schedules a new cron event.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<hook>`
  The hook name.
- `[<next-run>]`
  A Unix timestamp or an English textual datetime description compatible with `strtotime()`. Defaults to now.
- `[<recurrence>]`
  How often the event should recur. See `wp cron schedule list` for available schedule names. Defaults to no recurrence.
- `[--<field>=<value>]`
  Arguments to pass to the hook for the event. <field> should be a numeric key, not a string.

##### Examples

```bash
# Schedule a new cron event
$ wp cron event schedule cron_test
Success: Scheduled event with hook 'cron_test' for 2016-05-31 10:19:16 GMT.

# Schedule new cron event with hourly recurrence
$ wp cron event schedule cron_test now hourly
Success: Scheduled event with hook 'cron_test' for 2016-05-31 10:20:32 GMT.

# Schedule new cron event and pass arguments
$ wp cron event schedule cron_test '+1 hour' --0=first-argument --1=second-argument
Success: Scheduled event with hook 'cron_test' for 2016-05-31 11:21:35 GMT.
```

##### Global Parameters

These [global parameters](https://make.wordpress.org/cli/handbook/config/) have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

| **Argument** | **Description** |
| --- | --- |
| `--path=<path>` | Path to the WordPress files. |
| `--url=<url>` | Pretend request came from given URL. In multisite, this argument is how the target site is specified. |
| `--ssh=[<scheme>:][<user>@]<host\|container>[:<port>][<path>]` | Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant"). |
| `--http=<http>` | Perform operation against a remote WordPress installation over HTTP. |
| `--user=<id\|login\|email>` | Set the WordPress user. |
| `--skip-plugins[=<plugins>]` | Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded. |
| `--skip-themes[=<themes>]` | Skip loading all themes, or a comma-separated list of themes. |
| `--skip-packages` | Skip loading all installed packages. |
| `--require=<path>` | Load PHP file before running the command (may be used more than once). |
| `--exec=<php-code>` | Execute PHP code before running the command (may be used more than once). |
| `--context=<context>` | Load WordPress in a given context. |
| `--[no-]color` | Whether to colorize the output. |
| `--debug[=<group>]` | Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help. |
| `--prompt[=<assoc>]` | Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values. |
| `--quiet` | Suppress informational messages. |

#### wp cron event unschedule

Reference: <https://developer.wordpress.org/cli/commands/cron/event/unschedule/>

Unschedules all cron events for a given hook.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<hook>`
  Name of the hook for which all events should be unscheduled.

##### Examples

```bash
# Unschedule a cron event on given hook.
$ wp cron event unschedule cron_test
Success: Unscheduled 2 events for hook 'cron_test'.
```

##### Global Parameters

These [global parameters](https://make.wordpress.org/cli/handbook/config/) have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

| **Argument** | **Description** |
| --- | --- |
| `--path=<path>` | Path to the WordPress files. |
| `--url=<url>` | Pretend request came from given URL. In multisite, this argument is how the target site is specified. |
| `--ssh=[<scheme>:][<user>@]<host\|container>[:<port>][<path>]` | Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant"). |
| `--http=<http>` | Perform operation against a remote WordPress installation over HTTP. |
| `--user=<id\|login\|email>` | Set the WordPress user. |
| `--skip-plugins[=<plugins>]` | Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded. |
| `--skip-themes[=<themes>]` | Skip loading all themes, or a comma-separated list of themes. |
| `--skip-packages` | Skip loading all installed packages. |
| `--require=<path>` | Load PHP file before running the command (may be used more than once). |
| `--exec=<php-code>` | Execute PHP code before running the command (may be used more than once). |
| `--context=<context>` | Load WordPress in a given context. |
| `--[no-]color` | Whether to colorize the output. |
| `--debug[=<group>]` | Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help. |
| `--prompt[=<assoc>]` | Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values. |
| `--quiet` | Suppress informational messages. |

### wp cron schedule <command>

Reference: <https://developer.wordpress.org/cli/commands/cron/schedule/>

Gets WP-Cron schedules.

#### Examples

```bash
# List available cron schedules
$ wp cron schedule list
+------------+-------------+----------+
| name       | display     | interval |
+------------+-------------+----------+
| hourly     | Once Hourly | 3600     |
| twicedaily | Twice Daily | 43200    |
| daily      | Once Daily  | 86400    |
+------------+-------------+----------+
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp cron schedule list](https://developer.wordpress.org/cli/commands/cron/schedule/list/) | List available cron schedules. |

#### wp cron schedule list

Reference: <https://developer.wordpress.org/cli/commands/cron/schedule/list/>

List available cron schedules.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--field=<field>]`
  Prints the value of a single field for each schedule.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - ids
  - json
  - yaml

##### Available Fields

These fields will be displayed by default for each cron schedule:

- name
- display
- interval

There are no additional fields.

##### Examples

```bash
# List available cron schedules
$ wp cron schedule list
+------------+-------------+----------+
| name       | display     | interval |
+------------+-------------+----------+
| hourly     | Once Hourly | 3600     |
| twicedaily | Twice Daily | 43200    |
| daily      | Once Daily  | 86400    |
+------------+-------------+----------+

# List id of available cron schedule
$ wp cron schedule list --fields=name --format=ids
hourly twicedaily daily
```

##### Global Parameters

These [global parameters](https://make.wordpress.org/cli/handbook/config/) have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

| **Argument** | **Description** |
| --- | --- |
| `--path=<path>` | Path to the WordPress files. |
| `--url=<url>` | Pretend request came from given URL. In multisite, this argument is how the target site is specified. |
| `--ssh=[<scheme>:][<user>@]<host\|container>[:<port>][<path>]` | Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant"). |
| `--http=<http>` | Perform operation against a remote WordPress installation over HTTP. |
| `--user=<id\|login\|email>` | Set the WordPress user. |
| `--skip-plugins[=<plugins>]` | Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded. |
| `--skip-themes[=<themes>]` | Skip loading all themes, or a comma-separated list of themes. |
| `--skip-packages` | Skip loading all installed packages. |
| `--require=<path>` | Load PHP file before running the command (may be used more than once). |
| `--exec=<php-code>` | Execute PHP code before running the command (may be used more than once). |
| `--context=<context>` | Load WordPress in a given context. |
| `--[no-]color` | Whether to colorize the output. |
| `--debug[=<group>]` | Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help. |
| `--prompt[=<assoc>]` | Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values. |
| `--quiet` | Suppress informational messages. |

### wp cron test

Reference: <https://developer.wordpress.org/cli/commands/cron/test/>

Tests the WP Cron spawning system and reports back its status.

This command tests the spawning system by performing the following steps:

- Checks to see if the `DISABLE_WP_CRON` constant is set; errors if true because WP-Cron is disabled.
- Checks to see if the `ALTERNATE_WP_CRON` constant is set; warns if true.
- Attempts to spawn WP-Cron over HTTP; warns if non 200 response code is returned.

#### Examples

```bash
# Cron test runs successfully.
$ wp cron test
Success: WP-Cron spawning is working as expected.
```

#### Global Parameters

These [global parameters](https://make.wordpress.org/cli/handbook/config/) have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

| **Argument** | **Description** |
| --- | --- |
| `--path=<path>` | Path to the WordPress files. |
| `--url=<url>` | Pretend request came from given URL. In multisite, this argument is how the target site is specified. |
| `--ssh=[<scheme>:][<user>@]<host\|container>[:<port>][<path>]` | Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant"). |
| `--http=<http>` | Perform operation against a remote WordPress installation over HTTP. |
| `--user=<id\|login\|email>` | Set the WordPress user. |
| `--skip-plugins[=<plugins>]` | Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded. |
| `--skip-themes[=<themes>]` | Skip loading all themes, or a comma-separated list of themes. |
| `--skip-packages` | Skip loading all installed packages. |
| `--require=<path>` | Load PHP file before running the command (may be used more than once). |
| `--exec=<php-code>` | Execute PHP code before running the command (may be used more than once). |
| `--context=<context>` | Load WordPress in a given context. |
| `--[no-]color` | Whether to colorize the output. |
| `--debug[=<group>]` | Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help. |
| `--prompt[=<assoc>]` | Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values. |
| `--quiet` | Suppress informational messages. |
