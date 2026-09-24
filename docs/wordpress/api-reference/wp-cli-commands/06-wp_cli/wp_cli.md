# wp cli

Reference: <https://developer.wordpress.org/cli/commands/cli/>

## Description

Reviews current WP-CLI info, checks for updates, or views defined aliases.

## Synopsis

```bash
wp cli <command>
```

Unless overridden, these commands run on the `before_wp_load` hook, just before the WP load process begins.

## Examples

```bash
# Display the version currently installed.
$ wp cli version
WP-CLI 0.24.1

# Check for updates to WP-CLI.
$ wp cli check-update
Success: WP-CLI is at the latest version.

# Update WP-CLI to the latest stable release.
$ wp cli update
You have version 0.24.0. Would you like to update to 0.24.1? [y/n] y
Downloading from https://github.com/wp-cli/wp-cli/releases/download/v0.24.1/wp-cli-0.24.1.phar...
New version works. Proceeding to replace.
Success: Updated WP-CLI to 0.24.1.

# Clear the internal WP-CLI cache.
$ wp cli cache clear
Success: Cache cleared.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp cli alias](https://developer.wordpress.org/cli/commands/cli/alias/) | Retrieves, sets and updates aliases for WordPress Installations. |
| [wp cli cache](https://developer.wordpress.org/cli/commands/cli/cache/) | Manages the internal WP-CLI cache,. |
| [wp cli check-update](https://developer.wordpress.org/cli/commands/cli/check-update/) | Checks to see if there is a newer version of WP-CLI available. |
| [wp cli cmd-dump](https://developer.wordpress.org/cli/commands/cli/cmd-dump/) | Dumps the list of installed commands, as JSON. |
| [wp cli completions](https://developer.wordpress.org/cli/commands/cli/completions/) | Generates tab completion strings. |
| [wp cli has-command](https://developer.wordpress.org/cli/commands/cli/has-command/) | Detects if a command exists |
| [wp cli info](https://developer.wordpress.org/cli/commands/cli/info/) | Prints various details about the WP-CLI environment. |
| [wp cli param-dump](https://developer.wordpress.org/cli/commands/cli/param-dump/) | Dumps the list of global parameters, as JSON or in var_export format. |
| [wp cli update](https://developer.wordpress.org/cli/commands/cli/update/) | Updates WP-CLI to the latest release. |
| [wp cli version](https://developer.wordpress.org/cli/commands/cli/version/) | Prints WP-CLI version. |

### wp cli alias <command>

Reference: <https://developer.wordpress.org/cli/commands/cli/alias/>

Retrieves, sets and updates aliases for WordPress Installations.

Unless overridden, these commands run on the `before_wp_load` hook, just before the WP load process begins. Aliases are shorthand references to WordPress installs. For instance, `@dev` could refer to a development install and `@prod` could refer to a production install. This command gives you and option to add, update and delete, the registered aliases you have available.

#### Examples

```bash
# List alias information.
$ wp cli alias list
list
---
@all: Run command against every registered alias.
@local:
  user: wpcli
  path: /Users/wpcli/sites/testsite

# Get alias information.
$ wp cli alias get @dev
ssh: dev@somedeve.env:12345/home/dev/

# Add alias.
$ wp cli alias add @prod --set-ssh=login@host --set-path=/path/to/wordpress/install/ --set-user=wpcli
Success: Added '@prod' alias.

# Update alias.
$ wp cli alias update @prod --set-user=newuser --set-path=/new/path/to/wordpress/install/
Success: Updated 'prod' alias.

# Delete alias.
$ wp cli alias delete @prod
Success: Deleted '@prod' alias.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp cli alias add](https://developer.wordpress.org/cli/commands/cli/alias/add/) | Creates an alias. |
| [wp cli alias delete](https://developer.wordpress.org/cli/commands/cli/alias/delete/) | Deletes an alias. |
| [wp cli alias get](https://developer.wordpress.org/cli/commands/cli/alias/get/) | Gets the value for an alias. |
| [wp cli alias is-group](https://developer.wordpress.org/cli/commands/cli/alias/is-group/) | Check whether an alias is a group. |
| [wp cli alias list](https://developer.wordpress.org/cli/commands/cli/alias/list/) | Lists available WP-CLI aliases. |
| [wp cli alias update](https://developer.wordpress.org/cli/commands/cli/alias/update/) | Updates an alias. |

#### wp cli alias add

Reference: <https://developer.wordpress.org/cli/commands/cli/alias/add/>

Creates an alias.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the alias.
- `[--set-user=<user>]`
  Set user for alias.
- `[--set-url=<url>]`
  Set url for alias.
- `[--set-path=<path>]`
  Set path for alias.
- `[--set-ssh=<ssh>]`
  Set ssh for alias.
- `[--set-http=<http>]`
  Set http for alias.
- `[--grouping=<grouping>]`
  For grouping multiple aliases.
- `[--config=<config>]`
  Config file to be considered for operations.
  - default: global
  - options:
  - global
  - project

##### Examples

```bash
# Add alias to global config.
$ wp cli alias add @prod  --set-ssh=login@host --set-path=/path/to/wordpress/install/ --set-user=wpcli
Success: Added '@prod' alias.

# Add alias to project config.
$ wp cli alias add @prod --set-ssh=login@host --set-path=/path/to/wordpress/install/ --set-user=wpcli --config=project
Success: Added '@prod' alias.

# Add group of aliases.
$ wp cli alias add @multiservers --grouping=servera,serverb
Success: Added '@multiservers' alias.
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

#### wp cli alias delete

Reference: <https://developer.wordpress.org/cli/commands/cli/alias/delete/>

Deletes an alias.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the alias.
- `[--config=<config>]`
  Config file to be considered for operations.
  - options:
  - global
  - project

##### Examples

```bash
# Delete alias.
$ wp cli alias delete @prod
Success: Deleted '@prod' alias.

# Delete project alias.
$ wp cli alias delete @prod --config=project
Success: Deleted '@prod' alias.
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

#### wp cli alias get

Reference: <https://developer.wordpress.org/cli/commands/cli/alias/get/>

Gets the value for an alias.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the alias.

##### Examples

```bash
# Get alias.
$ wp cli alias get @prod
ssh: dev@somedeve.env:12345/home/dev/
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

#### wp cli alias is-group

Reference: <https://developer.wordpress.org/cli/commands/cli/alias/is-group/>

Check whether an alias is a group.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the alias.

##### Examples

```bash
# Checks whether the alias is a group; exit status 0 if it is, otherwise 1.
$ wp cli alias is-group @prod
$ echo $?
1
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

#### wp cli alias list

Reference: <https://developer.wordpress.org/cli/commands/cli/alias/list/>

Lists available WP-CLI aliases.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--format=<format>]`
  Render output in a particular format.
  - default: yaml
  - options:
  - yaml
  - json
  - var_export

##### Examples

```bash
# List all available aliases.
$ wp cli alias list
---
@all: Run command against every registered alias.
@prod:
  ssh: runcommand@runcommand.io~/webapps/production
@dev:
  ssh: vagrant@192.168.50.10/srv/www/runcommand.dev
@both:
  - @prod
  - @dev
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

#### wp cli alias update

Reference: <https://developer.wordpress.org/cli/commands/cli/alias/update/>

Updates an alias.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the alias.
- `[--set-user=<user>]`
  Set user for alias.
- `[--set-url=<url>]`
  Set url for alias.
- `[--set-path=<path>]`
  Set path for alias.
- `[--set-ssh=<ssh>]`
  Set ssh for alias.
- `[--set-http=<http>]`
  Set http for alias.
- `[--grouping=<grouping>]`
  For grouping multiple aliases.
- `[--config=<config>]`
  Config file to be considered for operations.
  - options:
  - global
  - project

##### Examples

```bash
# Update alias.
$ wp cli alias update @prod --set-user=newuser --set-path=/new/path/to/wordpress/install/
Success: Updated 'prod' alias.

# Update project alias.
$ wp cli alias update @prod --set-user=newuser --set-path=/new/path/to/wordpress/install/ --config=project
Success: Updated 'prod' alias.
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

### wp cli cache <command>

Reference: <https://developer.wordpress.org/cli/commands/cli/cache/>

Manages the internal WP-CLI cache,.

Unless overridden, these commands run on the `before_wp_load` hook, just before the WP load process begins.

#### Examples

```bash
# Remove all cached files.
$ wp cli cache clear
Success: Cache cleared.

# Remove all cached files except for the newest version of each one.
$ wp cli cache prune
Success: Cache pruned.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp cli cache clear](https://developer.wordpress.org/cli/commands/cli/cache/clear/) | Clears the internal cache. |
| [wp cli cache prune](https://developer.wordpress.org/cli/commands/cli/cache/prune/) | Prunes the internal cache. |

#### wp cli cache clear

Reference: <https://developer.wordpress.org/cli/commands/cli/cache/clear/>

Clears the internal cache.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

##### Examples

```bash
$ wp cli cache clear
Success: Cache cleared.
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

#### wp cli cache prune

Reference: <https://developer.wordpress.org/cli/commands/cli/cache/prune/>

Prunes the internal cache.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Removes all cached files except for the newest version of each one.

##### Examples

```bash
$ wp cli cache prune
Success: Cache pruned.
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

### wp cli check-update

Reference: <https://developer.wordpress.org/cli/commands/cli/check-update/>

Checks to see if there is a newer version of WP-CLI available.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Queries the GitHub releases API. Returns available versions if there are updates available, or success message if using the latest release.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--patch]`
  Only list patch updates.
- `[--minor]`
  Only list minor updates.
- `[--major]`
  Only list major updates.
- `[--field=<field>]`
  Prints the value of a single field for each update.
- `[--fields=<fields>]`
  Limit the output to specific object fields. Defaults to version,update_type,package_url,status,requires_php.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - count
  - yaml

#### Examples

```bash
# Check for update.
$ wp cli check-update
Success: WP-CLI is at the latest version.

# Check for update and new version is available.
$ wp cli check-update
+---------+-------------+-------------------------------------------------------------------------------+
| version | update_type | package_url                                                                   |
+---------+-------------+-------------------------------------------------------------------------------+
| 0.24.1  | patch       | https://github.com/wp-cli/wp-cli/releases/download/v0.24.1/wp-cli-0.24.1.phar |
+---------+-------------+-------------------------------------------------------------------------------+
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

### wp cli cmd-dump

Reference: <https://developer.wordpress.org/cli/commands/cli/cmd-dump/>

Dumps the list of installed commands, as JSON.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Examples

```bash
# Dump the list of installed commands.
$ wp cli cmd-dump
{"name":"wp","description":"Manage WordPress through the command-line.","longdesc":"\n\n## GLOBAL PARAMETERS
```

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

### wp cli completions

Reference: <https://developer.wordpress.org/cli/commands/cli/completions/>

Generates tab completion strings.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `--line=<line>`
  The current command line to be executed.
- `--point=<point>`
  The index to the current cursor position relative to the beginning of the command.

#### Examples

```bash
# Generate tab completion strings.
$ wp cli completions --line='wp eva' --point=100
eval
eval-file
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

### wp cli has-command

Reference: <https://developer.wordpress.org/cli/commands/cli/has-command/>

Detects if a command exists

This commands checks if a command is registered with WP-CLI. If the command is found then it returns with exit status 0. If the command doesn't exist, then it will exit with status 1.

#### Options

- `See the argument syntax reference for a detailed explanation of the syntax conventions used.`
- `<command_name>…`
  The command

#### Examples

```bash
# The "site delete" command is registered.
$ wp cli has-command "site delete"
$ echo $?
0

# The "foo bar" command is not registered.
$ wp cli has-command "foo bar"
$ echo $?
1

# Install a WP-CLI package if not already installed
$ if ! $(wp cli has-command doctor); then wp package install wp-cli/doctor-command; fi
Installing package wp-cli/doctor-command (dev-main || dev-master || dev-trunk)
Updating /home/person/.wp-cli/packages/composer.json to require the package...
Using Composer to install the package...
---
Success: Package installed.
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

### wp cli info

Reference: <https://developer.wordpress.org/cli/commands/cli/info/>

Prints various details about the WP-CLI environment.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Helpful for diagnostic purposes, this command shares:

- OS information.
- Shell information.
- PHP binary used.
- PHP binary version.
- php.ini configuration file used (which is typically different than web).
- WP-CLI root dir: where WP-CLI is installed (if non-Phar install).
- WP-CLI global config: where the global config YAML file is located.
- WP-CLI project config: where the project config YAML file is located.
- WP-CLI version: currently installed version.

See [config docs](https://make.wordpress.org/cli/handbook/references/config/) for more details on global and project config YAML files.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--format=<format>]`
  Render output in a particular format.
  - default: list
  - options:
  - list
  - json

#### Examples

```bash
# Display various data about the CLI environment.
$ wp cli info
OS:  Linux 4.10.0-42-generic #46~16.04.1-Ubuntu SMP Mon Dec 4 15:57:59 UTC 2017 x86_64
Shell:   /usr/bin/zsh
PHP binary:  /usr/bin/php
PHP version: 7.1.12-1+ubuntu16.04.1+deb.sury.org+1
php.ini used:    /etc/php/7.1/cli/php.ini
WP-CLI root dir:    phar://wp-cli.phar
WP-CLI packages dir:    /home/person/.wp-cli/packages/
WP-CLI global config:
WP-CLI project config:
WP-CLI version: 1.5.0
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

### wp cli param-dump

Reference: <https://developer.wordpress.org/cli/commands/cli/param-dump/>

Dumps the list of global parameters, as JSON or in var_export format.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--with-values]`
  Display current values also.
- `[--format=<format>]`
  Render output in a particular format.
  - default: json
  - options:
  - var_export
  - json

#### Examples

```bash
# Dump the list of global parameters.
$ wp cli param-dump --format=var_export
array (
  'path' =>
  array (
    'runtime' => '=&lt;path&gt;',
    'file' => '&lt;path&gt;',
    'synopsis' => '',
    'default' => NULL,
    'multiple' => false,
    'desc' => 'Path to the WordPress files.',
  ),
  'url' =>
  array (
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

### wp cli update

Reference: <https://developer.wordpress.org/cli/commands/cli/update/>

Updates WP-CLI to the latest release.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Default behavior is to check the releases API for the newest stable version, and prompt if one is available. Use `--stable` to install or reinstall the latest stable version. Use `--nightly` to install the latest built version of the master branch. While not recommended for production, nightly contains the latest and greatest, and should be stable enough for development and staging environments. Only works for the Phar installation mechanism.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--patch]`
  Only perform patch updates.
- `[--minor]`
  Only perform minor updates.
- `[--major]`
  Only perform major updates.
- `[--stable]`
  Update to the latest stable release. Skips update check.
- `[--nightly]`
  Update to the latest built version of the master branch. Potentially unstable.
- `[--yes]`
  Do not prompt for confirmation.
- `[--insecure]`
  Retry without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Update CLI.
$ wp cli update
You are currently using WP-CLI version 0.24.0. Would you like to update to 0.24.1? [y/n] y
Downloading from https://github.com/wp-cli/wp-cli/releases/download/v0.24.1/wp-cli-0.24.1.phar...
New version works. Proceeding to replace.
Success: Updated WP-CLI to 0.24.1.
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

### wp cli version

Reference: <https://developer.wordpress.org/cli/commands/cli/version/>

Prints WP-CLI version.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Examples

```bash
# Display CLI version.
$ wp cli version
WP-CLI 0.24.1
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
