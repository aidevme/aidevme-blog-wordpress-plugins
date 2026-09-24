# wp role

Reference: <https://developer.wordpress.org/cli/commands/role/>

## Description

Manages user roles, including creating new roles and resetting to defaults.

## Synopsis

```bash
wp role <command>
```

See references for [Roles and Capabilities](https://wordpress.org/documentation/article/roles-and-capabilities) and [WP User class](https://developer.wordpress.org/reference/classes/wp_user).

## Examples

```bash
# List roles.
$ wp role list --fields=role --format=csv
role
administrator
editor
author
contributor
subscriber

# Check to see if a role exists.
$ wp role exists editor
Success: Role with ID 'editor' exists.

# Create a new role.
$ wp role create approver Approver
Success: Role with key 'approver' created.

# Delete an existing role.
$ wp role delete approver
Success: Role with key 'approver' deleted.

# Reset existing roles to their default capabilities.
$ wp role reset administrator author contributor
Success: Reset 3/3 roles.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp role create](https://developer.wordpress.org/cli/commands/role/create/) | Creates a new role. |
| [wp role delete](https://developer.wordpress.org/cli/commands/role/delete/) | Deletes an existing role. |
| [wp role exists](https://developer.wordpress.org/cli/commands/role/exists/) | Checks if a role exists. |
| [wp role list](https://developer.wordpress.org/cli/commands/role/list/) | Lists all roles. |
| [wp role reset](https://developer.wordpress.org/cli/commands/role/reset/) | Resets any default role to default capabilities. |

### wp role create

Reference: <https://developer.wordpress.org/cli/commands/role/create/>

Creates a new role.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<role-key>`
  The internal name of the role.
- `<role-name>`
  The publicly visible name of the role.
- `[--clone=<role>]`
  Clone capabilities from an existing role.

#### Examples

```bash
# Create role for Approver.
$ wp role create approver Approver
Success: Role with key 'approver' created.

# Create role for Product Administrator.
$ wp role create productadmin "Product Administrator"
Success: Role with key 'productadmin' created.
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

### wp role delete

Reference: <https://developer.wordpress.org/cli/commands/role/delete/>

Deletes an existing role.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<role-key>`
  The internal name of the role.

#### Examples

```bash
# Delete approver role.
$ wp role delete approver
Success: Role with key 'approver' deleted.

# Delete productadmin role.
$ wp role delete productadmin
Success: Role with key 'productadmin' deleted.
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

### wp role exists

Reference: <https://developer.wordpress.org/cli/commands/role/exists/>

Checks if a role exists.

Exits with return code 0 if the role exists, 1 if it does not.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<role-key>`
  The internal name of the role.

#### Examples

```bash
# Check if a role exists.
$ wp role exists editor
Success: Role with ID 'editor' exists.
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

### wp role list

Reference: <https://developer.wordpress.org/cli/commands/role/list/>

Lists all roles.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--field=<field>]`
  Prints the value of a single field.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - count
  - yaml

#### Available Fields

These fields will be displayed by default for each role:

- name
- role

There are no optional fields.

#### Examples

```bash
# List roles.
$ wp role list --fields=role --format=csv
role
administrator
editor
author
contributor
subscriber
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

### wp role reset

Reference: <https://developer.wordpress.org/cli/commands/role/reset/>

Resets any default role to default capabilities.

Uses WordPress' `populate_roles()` function to put one or more roles back into the state they were at in the a fresh WordPress install. Removes any capabilities that were added, and restores any capabilities that were removed. Custom roles are not affected.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<role-key>…]`
  The internal name of one or more roles to reset.
- `[--all]`
  If set, all default roles will be reset.

#### Examples

```bash
# Reset three roles.
$ wp role reset administrator author contributor
Restored 1 capability to and removed 0 capabilities from 'administrator' role.
No changes necessary for 'author' role.
No changes necessary for 'contributor' role.
Success: 1 of 3 roles reset.

# Reset a custom role.
$ wp role reset custom_role
Custom role 'custom_role' not affected.
Error: Must specify a default role to reset.

# Reset all default roles.
$ wp role reset --all
Success: All default roles reset.
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
