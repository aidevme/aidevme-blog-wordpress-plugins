# wp menu

Reference: <https://developer.wordpress.org/cli/commands/menu/>

## Description

Lists, creates, assigns, and deletes the active theme's navigation menus.

## Synopsis

```bash
wp menu <command>
```

See the [Navigation Menus](https://developer.wordpress.org/themes/functionality/navigation-menus/) reference in the Theme Handbook.

## Examples

```bash
# Create a new menu
$ wp menu create "My Menu"
Success: Created menu 200.

# List existing menus
$ wp menu list
+---------+----------+----------+-----------+-------+
| term_id | name     | slug     | locations | count |
+---------+----------+----------+-----------+-------+
| 200     | My Menu  | my-menu  |           | 0     |
| 177     | Top Menu | top-menu | primary   | 7     |
+---------+----------+----------+-----------+-------+

# Create a new menu link item
$ wp menu item add-custom my-menu Apple http://apple.com --porcelain
1922

# Assign the 'my-menu' menu to the 'primary' location
$ wp menu location assign my-menu primary
Success: Assigned location primary to menu my-menu.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp menu create](https://developer.wordpress.org/cli/commands/menu/create/) | Creates a new menu. |
| [wp menu delete](https://developer.wordpress.org/cli/commands/menu/delete/) | Deletes one or more menus. |
| [wp menu item](https://developer.wordpress.org/cli/commands/menu/item/) | List, add, and delete items associated with a menu. |
| [wp menu list](https://developer.wordpress.org/cli/commands/menu/list/) | Gets a list of menus. |
| [wp menu location](https://developer.wordpress.org/cli/commands/menu/location/) | Assigns, removes, and lists a menu's locations. |

### wp menu create

Reference: <https://developer.wordpress.org/cli/commands/menu/create/>

Creates a new menu.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<menu-name>`
  A descriptive name for the menu.
- `[--porcelain]`
  Output just the new menu id.

#### Examples

```bash
$ wp menu create "My Menu"
Success: Created menu 200.
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

### wp menu delete

Reference: <https://developer.wordpress.org/cli/commands/menu/delete/>

Deletes one or more menus.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<menu>…`
  The name, slug, or term ID for the menu(s).

#### Examples

```bash
$ wp menu delete "My Menu"
Deleted menu 'My Menu'.
Success: Deleted 1 of 1 menus.
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

### wp menu item <command>

Reference: <https://developer.wordpress.org/cli/commands/menu/item/>

List, add, and delete items associated with a menu.

#### Examples

```bash
# Add an existing post to an existing menu
$ wp menu item add-post sidebar-menu 33 --title="Custom Test Post"
Success: Menu item added.

# Create a new menu link item
$ wp menu item add-custom sidebar-menu Apple http://apple.com
Success: Menu item added.

# Delete menu item
$ wp menu item delete 45
Success: Deleted 1 of 1 menu items.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp menu item add-custom](https://developer.wordpress.org/cli/commands/menu/item/add-custom/) | Adds a custom menu item. |
| [wp menu item add-post](https://developer.wordpress.org/cli/commands/menu/item/add-post/) | Adds a post as a menu item. |
| [wp menu item add-term](https://developer.wordpress.org/cli/commands/menu/item/add-term/) | Adds a taxonomy term as a menu item. |
| [wp menu item delete](https://developer.wordpress.org/cli/commands/menu/item/delete/) | Deletes one or more items from a menu. |
| [wp menu item list](https://developer.wordpress.org/cli/commands/menu/item/list/) | Gets a list of items associated with a menu. |
| [wp menu item update](https://developer.wordpress.org/cli/commands/menu/item/update/) | Updates a menu item. |

#### wp menu item add-custom

Reference: <https://developer.wordpress.org/cli/commands/menu/item/add-custom/>

Adds a custom menu item.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<menu>`
  The name, slug, or term ID for the menu.
- `<title>`
  Title for the link.
- `<link>`
  Target URL for the link.
- `[--description=<description>]`
  Set a custom description for the menu item.
- `[--attr-title=<attr-title>]`
  Set a custom title attribute for the menu item.
- `[--target=<target>]`
  Set a custom link target for the menu item.
- `[--classes=<classes>]`
  Set a custom link classes for the menu item.
- `[--position=<position>]`
  Specify the position of this menu item.
- `[--parent-id=<parent-id>]`
  Make this menu item a child of another menu item.
- `[--porcelain]`
  Output just the new menu item id.

##### Examples

```bash
$ wp menu item add-custom sidebar-menu Apple http://apple.com
Success: Menu item added.
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

#### wp menu item add-post

Reference: <https://developer.wordpress.org/cli/commands/menu/item/add-post/>

Adds a post as a menu item.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<menu>`
  The name, slug, or term ID for the menu.
- `<post-id>`
  Post ID to add to the menu.
- `[--title=<title>]`
  Set a custom title for the menu item.
- `[--link=<link>]`
  Set a custom url for the menu item.
- `[--description=<description>]`
  Set a custom description for the menu item.
- `[--attr-title=<attr-title>]`
  Set a custom title attribute for the menu item.
- `[--target=<target>]`
  Set a custom link target for the menu item.
- `[--classes=<classes>]`
  Set a custom link classes for the menu item.
- `[--position=<position>]`
  Specify the position of this menu item.
- `[--parent-id=<parent-id>]`
  Make this menu item a child of another menu item.
- `[--porcelain]`
  Output just the new menu item id.

##### Examples

```bash
$ wp menu item add-post sidebar-menu 33 --title="Custom Test Post"
Success: Menu item added.
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

#### wp menu item add-term

Reference: <https://developer.wordpress.org/cli/commands/menu/item/add-term/>

Adds a taxonomy term as a menu item.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<menu>`
  The name, slug, or term ID for the menu.
- `<taxonomy>`
  Taxonomy of the term to be added.
- `<term-id>`
  Term ID of the term to be added.
- `[--title=<title>]`
  Set a custom title for the menu item.
- `[--link=<link>]`
  Set a custom url for the menu item.
- `[--description=<description>]`
  Set a custom description for the menu item.
- `[--attr-title=<attr-title>]`
  Set a custom title attribute for the menu item.
- `[--target=<target>]`
  Set a custom link target for the menu item.
- `[--classes=<classes>]`
  Set a custom link classes for the menu item.
- `[--position=<position>]`
  Specify the position of this menu item.
- `[--parent-id=<parent-id>]`
  Make this menu item a child of another menu item.
- `[--porcelain]`
  Output just the new menu item id.

##### Examples

```bash
$ wp menu item add-term sidebar-menu post_tag 24
Success: Menu item added.
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

#### wp menu item delete

Reference: <https://developer.wordpress.org/cli/commands/menu/item/delete/>

Deletes one or more items from a menu.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<db-id>…`
  Database ID for the menu item(s).

##### Examples

```bash
$ wp menu item delete 45
Success: Deleted 1 of 1 menu items.
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

#### wp menu item list

Reference: <https://developer.wordpress.org/cli/commands/menu/item/list/>

Gets a list of items associated with a menu.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<menu>`
  The name, slug, or term ID for the menu.
- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - count
  - ids
  - yaml

##### Available Fields

These fields will be displayed by default for each menu item:

- db_id
- type
- title
- link
- position

These fields are optionally available:

- menu_item_parent
- object_id
- object
- type
- type_label
- target
- attr_title
- description
- classes
- xfn

##### Examples

```bash
$ wp menu item list main-menu
+-------+-----------+-------------+---------------------------------+----------+
| db_id | type      | title       | link                            | position |
+-------+-----------+-------------+---------------------------------+----------+
| 5     | custom    | Home        | http://example.com              | 1        |
| 6     | post_type | Sample Page | http://example.com/sample-page/ | 2        |
+-------+-----------+-------------+---------------------------------+----------+
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

#### wp menu item update

Reference: <https://developer.wordpress.org/cli/commands/menu/item/update/>

Updates a menu item.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<db-id>`
  Database ID for the menu item.
- `[--title=<title>]`
  Set a custom title for the menu item.
- `[--link=<link>]`
  Set a custom url for the menu item.
- `[--description=<description>]`
  Set a custom description for the menu item.
- `[--attr-title=<attr-title>]`
  Set a custom title attribute for the menu item.
- `[--target=<target>]`
  Set a custom link target for the menu item.
- `[--classes=<classes>]`
  Set a custom link classes for the menu item.
- `[--position=<position>]`
  Specify the position of this menu item.
- `[--parent-id=<parent-id>]`
  Make this menu item a child of another menu item.

##### Examples

```bash
$ wp menu item update 45 --title=WordPress --link='http://wordpress.org' --target=_blank --position=2
Success: Menu item updated.
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

### wp menu list

Reference: <https://developer.wordpress.org/cli/commands/menu/list/>

Gets a list of menus.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - count
  - ids
  - yaml

#### Available Fields

These fields will be displayed by default for each menu:

- term_id
- name
- slug
- count

These fields are optionally available:

- term_group
- term_taxonomy_id
- taxonomy
- description
- parent
- locations

#### Examples

```bash
$ wp menu list
+---------+----------+----------+-----------+-------+
| term_id | name     | slug     | locations | count |
+---------+----------+----------+-----------+-------+
| 200     | My Menu  | my-menu  |           | 0     |
| 177     | Top Menu | top-menu | primary   | 7     |
+---------+----------+----------+-----------+-------+
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

### wp menu location <command>

Reference: <https://developer.wordpress.org/cli/commands/menu/location/>

Assigns, removes, and lists a menu's locations.

#### Examples

```bash
# List available menu locations
$ wp menu location list
+----------+-------------------+
| location | description       |
+----------+-------------------+
| primary  | Primary Menu      |
| social   | Social Links Menu |
+----------+-------------------+

# Assign the 'primary-menu' menu to the 'primary' location
$ wp menu location assign primary-menu primary
Success: Assigned location primary to menu primary-menu.

# Remove the 'primary-menu' menu from the 'primary' location
$ wp menu location remove primary-menu primary
Success: Removed location from menu.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp menu location assign](https://developer.wordpress.org/cli/commands/menu/location/assign/) | Assigns a location to a menu. |
| [wp menu location list](https://developer.wordpress.org/cli/commands/menu/location/list/) | Lists locations for the current theme. |
| [wp menu location remove](https://developer.wordpress.org/cli/commands/menu/location/remove/) | Removes a location from a menu. |

#### wp menu location assign

Reference: <https://developer.wordpress.org/cli/commands/menu/location/assign/>

Assigns a location to a menu.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<menu>`
  The name, slug, or term ID for the menu.
- `<location>`
  Location's slug.

##### Examples

```bash
$ wp menu location assign primary-menu primary
Success: Assigned location primary to menu primary-menu.
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

#### wp menu location list

Reference: <https://developer.wordpress.org/cli/commands/menu/location/list/>

Lists locations for the current theme.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - count
  - yaml
  - ids

##### Available Fields

These fields will be displayed by default for each location:

- name
- description

##### Examples

```bash
$ wp menu location list
+----------+-------------------+
| location | description       |
+----------+-------------------+
| primary  | Primary Menu      |
| social   | Social Links Menu |
+----------+-------------------+
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

#### wp menu location remove

Reference: <https://developer.wordpress.org/cli/commands/menu/location/remove/>

Removes a location from a menu.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<menu>`
  The name, slug, or term ID for the menu.
- `<location>`
  Location's slug.

##### Examples

```bash
$ wp menu location remove primary-menu primary
Success: Removed location from menu.
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
