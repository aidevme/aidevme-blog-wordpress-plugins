# wp taxonomy

Reference: <https://developer.wordpress.org/cli/commands/taxonomy/>

## Description

Retrieves information about registered taxonomies.

## Synopsis

```bash
wp taxonomy <command>
```

See references for [built-in taxonomies](https://developer.wordpress.org/themes/basics/categories-tags-custom-taxonomies/) and [custom taxonomies](https://developer.wordpress.org/plugins/taxonomies/working-with-custom-taxonomies/).

## Examples

```bash
# List all taxonomies with 'post' object type.
$ wp taxonomy list --object_type=post --fields=name,public
+-------------+--------+
| name        | public |
+-------------+--------+
| category    | 1      |
| post_tag    | 1      |
| post_format | 1      |
+-------------+--------+

# Get capabilities of 'post_tag' taxonomy.
$ wp taxonomy get post_tag --field=cap
{"manage_terms":"manage_categories","edit_terms":"manage_categories","delete_terms":"manage_categories","assign_terms":"edit_posts"}
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp taxonomy get](https://developer.wordpress.org/cli/commands/taxonomy/get/) | Gets details about a registered taxonomy. |
| [wp taxonomy list](https://developer.wordpress.org/cli/commands/taxonomy/list/) | Lists registered taxonomies. |

### wp taxonomy get

Reference: <https://developer.wordpress.org/cli/commands/taxonomy/get/>

Gets details about a registered taxonomy.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<taxonomy>`
  Taxonomy slug.
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

These fields will be displayed by default for the specified taxonomy:

- name
- label
- description
- object_type
- show_tagcloud
- hierarchical
- public
- labels
- cap

These fields are optionally available:

- count

#### Examples

```bash
# Get details of `category` taxonomy.
$ wp taxonomy get category --fields=name,label,object_type
+-------------+------------+
| Field       | Value      |
+-------------+------------+
| name        | category   |
| label       | Categories |
| object_type | ["post"]   |
+-------------+------------+

# Get capabilities of 'post_tag' taxonomy.
$ wp taxonomy get post_tag --field=cap
{"manage_terms":"manage_categories","edit_terms":"manage_categories","delete_terms":"manage_categories","assign_terms":"edit_posts"}
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

### wp taxonomy list

Reference: <https://developer.wordpress.org/cli/commands/taxonomy/list/>

Lists registered taxonomies.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--<field>=<value>]`
  Filter by one or more fields (see [get_taxonomies()](https://developer.wordpress.org/reference/functions/get_taxonomies/)  first parameter for a list of available fields).
- `[--field=<field>]`
  Prints the value of a single field for each taxonomy.
- `[--fields=<fields>]`
  Limit the output to specific taxonomy fields.
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

These fields will be displayed by default for each term:

- name
- label
- description
- object_type
- show_tagcloud
- hierarchical
- public

These fields are optionally available:

- count

#### Examples

```bash
# List all taxonomies.
$ wp taxonomy list --format=csv
name,label,description,object_type,show_tagcloud,hierarchical,public
category,Categories,,post,1,1,1
post_tag,Tags,,post,1,,1
nav_menu,"Navigation Menus",,nav_menu_item,,,
link_category,"Link Categories",,link,1,,
post_format,Format,,post,,,1

# List all taxonomies with 'post' object type.
$ wp taxonomy list --object_type=post --fields=name,public
+-------------+--------+
| name        | public |
+-------------+--------+
| category    | 1      |
| post_tag    | 1      |
| post_format | 1      |
+-------------+--------+
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
