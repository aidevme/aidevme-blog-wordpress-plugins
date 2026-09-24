# wp widget

Reference: <https://developer.wordpress.org/cli/commands/widget/>

## Description

Manages widgets, including adding and moving them within sidebars.

## Synopsis

```bash
wp widget <command>
```

A [widget](https://developer.wordpress.org/themes/functionality/widgets/) adds content and features to a widget area (also called a [sidebar](https://developer.wordpress.org/themes/functionality/sidebars/)).

## Examples

```bash
# List widgets on a given sidebar
$ wp widget list sidebar-1
+----------+------------+----------+----------------------+
| name     | id         | position | options              |
+----------+------------+----------+----------------------+
| meta     | meta-6     | 1        | {"title":"Meta"}     |
| calendar | calendar-2 | 2        | {"title":"Calendar"} |
+----------+------------+----------+----------------------+

# Add a calendar widget to the second position on the sidebar
$ wp widget add calendar sidebar-1 2
Success: Added widget to sidebar.

# Update option(s) associated with a given widget
$ wp widget update calendar-1 --title="Calendar"
Success: Widget updated.

# Delete one or more widgets entirely
$ wp widget delete calendar-2 archive-1
Success: 2 widgets removed from sidebar.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp widget add](https://developer.wordpress.org/cli/commands/widget/add/) | Adds a widget to a sidebar. |
| [wp widget deactivate](https://developer.wordpress.org/cli/commands/widget/deactivate/) | Deactivates one or more widgets from an active sidebar. |
| [wp widget delete](https://developer.wordpress.org/cli/commands/widget/delete/) | Deletes one or more widgets from a sidebar. |
| [wp widget list](https://developer.wordpress.org/cli/commands/widget/list/) | Lists widgets associated with a sidebar. |
| [wp widget move](https://developer.wordpress.org/cli/commands/widget/move/) | Moves the position of a widget. |
| [wp widget reset](https://developer.wordpress.org/cli/commands/widget/reset/) | Resets sidebar. |
| [wp widget update](https://developer.wordpress.org/cli/commands/widget/update/) | Updates options for an existing widget. |

### wp widget add

Reference: <https://developer.wordpress.org/cli/commands/widget/add/>

Adds a widget to a sidebar.

Creates a new widget entry in the database, and associates it with the sidebar.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Widget name.
- `<sidebar-id>`
  ID for the corresponding sidebar.
- `[<position>]`
  Widget's current position within the sidebar. Defaults to last
- `[--<field>=<value>]`
  Widget option to add, with its new value

#### Examples

```bash
# Add a new calendar widget to sidebar-1 with title "Calendar"
$ wp widget add calendar sidebar-1 2 --title="Calendar"
Success: Added widget to sidebar.
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

### wp widget deactivate

Reference: <https://developer.wordpress.org/cli/commands/widget/deactivate/>

Deactivates one or more widgets from an active sidebar.

Moves widgets to Inactive Widgets.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<widget-id>…`
  Unique ID for the widget(s)

#### Examples

```bash
# Deactivate the recent-comments-2 widget.
$ wp widget deactivate recent-comments-2
Success: 1 widget deactivated.
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

### wp widget delete

Reference: <https://developer.wordpress.org/cli/commands/widget/delete/>

Deletes one or more widgets from a sidebar.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<widget-id>…`
  Unique ID for the widget(s)

#### Examples

```bash
# Delete the recent-comments-2 widget from its sidebar.
$ wp widget delete recent-comments-2
Success: Deleted 1 of 1 widgets.
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

### wp widget list

Reference: <https://developer.wordpress.org/cli/commands/widget/list/>

Lists widgets associated with a sidebar.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<sidebar-id>`
  ID for the corresponding sidebar.
- `[--fields=<fields>]`
  Limit the output to specific object fields.
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

#### Available Fields

These fields will be displayed by default for each widget:

- name
- id
- position
- options

There are no optionally available fields.

#### Examples

```bash
$ wp widget list sidebar-1 --fields=name,id --format=csv
name,id
meta,meta-5
search,search-3
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

### wp widget move

Reference: <https://developer.wordpress.org/cli/commands/widget/move/>

Moves the position of a widget.

Changes the order of a widget in its existing sidebar, or moves it to a new sidebar.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<widget-id>`
  Unique ID for the widget
- `[--position=<position>]`
  Assign the widget to a new position.
- `[--sidebar-id=<sidebar-id>]`
  Assign the widget to a new sidebar

#### Examples

```bash
# Change position of widget
$ wp widget move recent-comments-2 --position=2
Success: Widget moved.

# Move widget to Inactive Widgets
$ wp widget move recent-comments-2 --sidebar-id=wp_inactive_widgets
Success: Widget moved.
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

### wp widget reset

Reference: <https://developer.wordpress.org/cli/commands/widget/reset/>

Resets sidebar.

Removes all widgets from the sidebar and places them in Inactive Widgets.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<sidebar-id>…]`
  One or more sidebars to reset.
- `[--all]`
  If set, all sidebars will be reset.

#### Examples

```bash
# Reset a sidebar
$ wp widget reset sidebar-1
Success: Sidebar 'sidebar-1' reset.

# Reset multiple sidebars
$ wp widget reset sidebar-1 sidebar-2
Success: Sidebar 'sidebar-1' reset.
Success: Sidebar 'sidebar-2' reset.

# Reset all sidebars
$ wp widget reset --all
Success: Sidebar 'sidebar-1' reset.
Success: Sidebar 'sidebar-2' reset.
Success: Sidebar 'sidebar-3' reset.
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

### wp widget update

Reference: <https://developer.wordpress.org/cli/commands/widget/update/>

Updates options for an existing widget.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<widget-id>`
  Unique ID for the widget
- `[--<field>=<value>]`
  Field to update, with its new value

#### Examples

```bash
# Change calendar-1 widget title to "Our Calendar"
$ wp widget update calendar-1 --title="Our Calendar"
Success: Widget updated.
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
