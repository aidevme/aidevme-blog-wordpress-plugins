# wp cap

Reference: <https://developer.wordpress.org/cli/commands/cap/>

## Description

Adds, removes, and lists capabilities of a user role.

## Synopsis

```bash
wp cap <command>
```

See references for [Roles and Capabilities](https://wordpress.org/documentation/article/roles-and-capabilities) and [WP User class](https://developer.wordpress.org/reference/classes/wp_user).

## Examples

```bash
# Add 'spectate' capability to 'author' role.
$ wp cap add 'author' 'spectate'
Success: Added 1 capability to 'author' role.

# Add all caps from 'editor' role to 'author' role.
$ wp cap list 'editor' | xargs wp cap add 'author'
Success: Added 24 capabilities to 'author' role.

# Remove all caps from 'editor' role that also appear in 'author' role.
$ wp cap list 'author' | xargs wp cap remove 'editor'
Success: Removed 34 capabilities from 'editor' role.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp cap add](https://developer.wordpress.org/cli/commands/cap/add/) | Adds capabilities to a given role. |
| [wp cap list](https://developer.wordpress.org/cli/commands/cap/list/) | Lists capabilities for a given role. |
| [wp cap remove](https://developer.wordpress.org/cli/commands/cap/remove/) | Removes capabilities from a given role. |

### wp cap add

Reference: <https://developer.wordpress.org/cli/commands/cap/add/>

Adds capabilities to a given role.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<role>`
  Key for the role.
- `<cap>…`
  One or more capabilities to add.
- `[--grant]`
  Adds the capability as an explicit boolean value, instead of implicitly defaulting to `true`.
  - default: true
  - options:
  - true
  - false

#### Examples

```bash
# Add 'spectate' capability to 'author' role.
$ wp cap add author spectate
Success: Added 1 capability to 'author' role.
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

### wp cap list

Reference: <https://developer.wordpress.org/cli/commands/cap/list/>

Lists capabilities for a given role.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<role>`
  Key for the role.
- `[--format=<format>]`
  Render output in a particular format.
  - default: list
  - options:
  - list
  - table
  - csv
  - json
  - count
  - yaml
- `[--show-grant]`
  Display all capabilities defined for a role including grant.
  - default: false

#### Examples

```bash
# Display alphabetical list of Contributor capabilities.
$ wp cap list 'contributor' | sort
delete_posts
edit_posts
level_0
level_1
read
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

### wp cap remove

Reference: <https://developer.wordpress.org/cli/commands/cap/remove/>

Removes capabilities from a given role.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<role>`
  Key for the role.
- `<cap>…`
  One or more capabilities to remove.

#### Examples

```bash
# Remove 'spectate' capability from 'author' role.
$ wp cap remove author spectate
Success: Removed 1 capability from 'author' role.
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
