# wp post-type

Reference: <https://developer.wordpress.org/cli/commands/post-type/>

## Description

Retrieves details on the site's registered post types.

## Synopsis

```bash
wp post-type <command>
```

Get information on WordPress' built-in and the site's [custom post types](https://developer.wordpress.org/plugins/post-types/).

## Examples

```bash
# Get details about a post type
$ wp post-type get page --fields=name,label,hierarchical --format=json
{"name":"page","label":"Pages","hierarchical":true}

# List post types with 'post' capability type
$ wp post-type list --capability_type=post --fields=name,public
+---------------+--------+
| name          | public |
+---------------+--------+
| post          | 1      |
| attachment    | 1      |
| revision      |        |
| nav_menu_item |        |
+---------------+--------+
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp post-type get](https://developer.wordpress.org/cli/commands/post-type/get/) | Gets details about a registered post type. |
| [wp post-type list](https://developer.wordpress.org/cli/commands/post-type/list/) | Lists registered post types. |

### wp post-type get

Reference: <https://developer.wordpress.org/cli/commands/post-type/get/>

Gets details about a registered post type.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<post-type>`
  Post type slug
- `[--field=<field>]`
  Instead of returning the whole taxonomy, returns the value of a single field.
- `[--fields=<fields>]`
  Limit the output to specific fields. Defaults to all fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml

#### Available Fields

These fields will be displayed by default for the specified post type:

- name
- label
- description
- hierarchical
- public
- capability_type
- labels
- cap
- supports

These fields are optionally available:

- count

#### Examples

```bash
# Get details about the 'page' post type.
$ wp post-type get page --fields=name,label,hierarchical --format=json
{"name":"page","label":"Pages","hierarchical":true}
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

### wp post-type list

Reference: <https://developer.wordpress.org/cli/commands/post-type/list/>

Lists registered post types.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--<field>=<value>]`
  Filter by one or more fields (see [get_post_types()](https://developer.wordpress.org/reference/functions/get_post_types/)  first parameter for a list of available fields).
- `[--field=<field>]`
  Prints the value of a single field for each post type.
- `[--fields=<fields>]`
  Limit the output to specific post type fields.
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

These fields will be displayed by default for each post type:

- name
- label
- description
- hierarchical
- public
- capability_type

These fields are optionally available:

- count

#### Examples

```bash
# List registered post types
$ wp post-type list --format=csv
name,label,description,hierarchical,public,capability_type
post,Posts,,,1,post
page,Pages,,1,1,page
attachment,Media,,,1,post
revision,Revisions,,,,post
nav_menu_item,"Navigation Menu Items",,,,post

# List post types with 'post' capability type
$ wp post-type list --capability_type=post --fields=name,public
+---------------+--------+
| name          | public |
+---------------+--------+
| post          | 1      |
| attachment    | 1      |
| revision      |        |
| nav_menu_item |        |
+---------------+--------+
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
