# wp rewrite

Reference: <https://developer.wordpress.org/cli/commands/rewrite/>

## Description

Lists or flushes the site's rewrite rules, updates the permalink structure.

## Synopsis

```bash
wp rewrite <command>
```

See the WordPress [Rewrite API](https://developer.wordpress.org/apis/rewrite) and [WP Rewrite](https://developer.wordpress.org/reference/classes/wp_rewrite) class reference.

## Examples

```bash
# Flush rewrite rules
$ wp rewrite flush
Success: Rewrite rules flushed.

# Update permalink structure
$ wp rewrite structure '/%year%/%monthnum%/%postname%'
Success: Rewrite structure set.

# List rewrite rules
$ wp rewrite list --format=csv
match,query,source
^wp-json/?$,index.php?rest_route=/,other
^wp-json/(.*)?,index.php?rest_route=/$matches[1],other
category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$,index.php?category_name=$matches[1]&amp;feed=$matches[2],category
category/(.+?)/(feed|rdf|rss|rss2|atom)/?$,index.php?category_name=$matches[1]&amp;feed=$matches[2],category
category/(.+?)/embed/?$,index.php?category_name=$matches[1]&amp;embed=true,category
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp rewrite flush](https://developer.wordpress.org/cli/commands/rewrite/flush/) | Flushes rewrite rules. |
| [wp rewrite list](https://developer.wordpress.org/cli/commands/rewrite/list/) | Gets a list of the current rewrite rules. |
| [wp rewrite structure](https://developer.wordpress.org/cli/commands/rewrite/structure/) | Updates the permalink structure. |

### wp rewrite flush

Reference: <https://developer.wordpress.org/cli/commands/rewrite/flush/>

Flushes rewrite rules.

Resets WordPress' rewrite rules based on registered post types, etc. To regenerate a .htaccess file with WP-CLI, you'll need to add the mod_rewrite module to your wp-cli.yml or config.yml. For example:

```bash
apache_modules:
  - mod_rewrite
```

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--hard]`
  Perform a hard flush – update `.htaccess` rules as well as rewrite rules in database. Works only on single site installs.

#### Examples

```bash
$ wp rewrite flush
Success: Rewrite rules flushed.
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

### wp rewrite list

Reference: <https://developer.wordpress.org/cli/commands/rewrite/list/>

Gets a list of the current rewrite rules.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--match=<url>]`
  Show rewrite rules matching a particular URL.
- `[--source=<source>]`
  Show rewrite rules from a particular source.
- `[--fields=<fields>]`
  Limit the output to specific fields. Defaults to match,query,source.
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
$ wp rewrite list --format=csv
match,query,source
^wp-json/?$,index.php?rest_route=/,other
^wp-json/(.*)?,index.php?rest_route=/$matches[1],other
category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$,index.php?category_name=$matches[1]&amp;feed=$matches[2],category
category/(.+?)/(feed|rdf|rss|rss2|atom)/?$,index.php?category_name=$matches[1]&amp;feed=$matches[2],category
category/(.+?)/embed/?$,index.php?category_name=$matches[1]&amp;embed=true,category
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

### wp rewrite structure

Reference: <https://developer.wordpress.org/cli/commands/rewrite/structure/>

Updates the permalink structure.

Sets the post permalink structure to the specified pattern. To regenerate a .htaccess file with WP-CLI, you'll need to add the mod_rewrite module to your [WP-CLI config](https://make.wordpress.org/cli/handbook/config/#config-files). For example:

```bash
apache_modules:
  - mod_rewrite
```

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<permastruct>`
  The new permalink structure to apply.
- `[--category-base=<base>]`
  Set the base for category permalinks, i.e. '/category/'.
- `[--tag-base=<base>]`
  Set the base for tag permalinks, i.e. '/tag/'.
- `[--hard]`
  Perform a hard flush – update `.htaccess` rules as well as rewrite rules in database.

#### Examples

```bash
$ wp rewrite structure '/%year%/%monthnum%/%postname%/'
Success: Rewrite structure set.
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
