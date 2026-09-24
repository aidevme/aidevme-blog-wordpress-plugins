# wp block

Reference: <https://developer.wordpress.org/cli/commands/block/>

## Description

Manages WordPress block editor blocks and related entities.

## Synopsis

```bash
wp block <command>
```

## Examples

```bash
# List all registered block types
$ wp block type list

# Get a specific block pattern
$ wp block pattern get my-theme/hero

# List block styles for a specific block
$ wp block style list --block=core/button

# Export a block template
$ wp block template export twentytwentyfour//single --stdout

# Create a synced pattern
$ wp block synced-pattern create --title="My Pattern" --content='&lt;!-- wp:paragraph --&gt;&lt;p&gt;Hello&lt;/p&gt;&lt;!-- /wp:paragraph --&gt;'
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp block binding](https://developer.wordpress.org/cli/commands/block/binding/) | Retrieves details on registered block binding sources. |
| [wp block pattern](https://developer.wordpress.org/cli/commands/block/pattern/) | Retrieves details on registered block patterns. |
| [wp block pattern-category](https://developer.wordpress.org/cli/commands/block/pattern-category/) | Retrieves details on registered block pattern categories. |
| [wp block style](https://developer.wordpress.org/cli/commands/block/style/) | Retrieves details on registered block styles. |
| [wp block synced-pattern](https://developer.wordpress.org/cli/commands/block/synced-pattern/) | Manages synced patterns (reusable blocks). |
| [wp block template](https://developer.wordpress.org/cli/commands/block/template/) | Retrieves details on block templates and template parts. |
| [wp block type](https://developer.wordpress.org/cli/commands/block/type/) | Retrieves details on registered block types. |

### wp block binding <command>

Reference: <https://developer.wordpress.org/cli/commands/block/binding/>

Retrieves details on registered block binding sources.

Get information on block binding sources from the [WP_Block_Bindings_Registry](https://developer.wordpress.org/reference/classes/wp_block_bindings_registry/). Block bindings allow dynamic data to be connected to block attributes.

#### Examples

```bash
# List all registered binding sources
$ wp block binding list

# Get details about the post-meta binding
$ wp block binding get core/post-meta --format=json
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp block binding get](https://developer.wordpress.org/cli/commands/block/binding/get/) | Gets details about a registered block binding source. |
| [wp block binding list](https://developer.wordpress.org/cli/commands/block/binding/list/) | Lists registered block binding sources. |

#### wp block binding get

Reference: <https://developer.wordpress.org/cli/commands/block/binding/get/>

Gets details about a registered block binding source.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Binding source name (e.g., 'core/post-meta').
- `[--field=<field>]`
  Instead of returning the whole source, returns the value of a single field.
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

##### Examples

```bash
# Get details about the post-meta binding
$ wp block binding get core/post-meta

# Get as JSON
$ wp block binding get core/post-meta --format=json
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

#### wp block binding list

Reference: <https://developer.wordpress.org/cli/commands/block/binding/list/>

Lists registered block binding sources.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--field=<field>]`
  Prints the value of a single field for each source.
- `[--fields=<fields>]`
  Limit the output to specific source fields.
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

These fields will be displayed by default for each source:

- name
- label

These fields are optionally available:

- uses_context

##### Examples

```bash
# List all binding sources
$ wp block binding list

# Get source names only
$ wp block binding list --field=name

# Export sources to JSON
$ wp block binding list --format=json
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

### wp block pattern <command>

Reference: <https://developer.wordpress.org/cli/commands/block/pattern/>

Retrieves details on registered block patterns.

Get information on WordPress' built-in and custom block patterns from the [WP_Block_Patterns_Registry](https://developer.wordpress.org/reference/classes/wp_block_patterns_registry/).

#### Examples

```bash
# List all registered block patterns
$ wp block pattern list

# Get details about a specific pattern
$ wp block pattern get core/query-standard-posts --format=json

# List patterns in a specific category
$ wp block pattern list --category=featured
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp block pattern get](https://developer.wordpress.org/cli/commands/block/pattern/get/) | Gets details about a registered block pattern. |
| [wp block pattern list](https://developer.wordpress.org/cli/commands/block/pattern/list/) | Lists registered block patterns. |

#### wp block pattern get

Reference: <https://developer.wordpress.org/cli/commands/block/pattern/get/>

Gets details about a registered block pattern.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Pattern name including namespace (e.g., 'core/query-standard-posts').
- `[--field=<field>]`
  Instead of returning the whole pattern, returns the value of a single field.
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

##### Examples

```bash
# Get a pattern's content
$ wp block pattern get core/query-standard-posts --field=content

# Get full pattern details as JSON
$ wp block pattern get my-theme/hero --format=json
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

#### wp block pattern list

Reference: <https://developer.wordpress.org/cli/commands/block/pattern/list/>

Lists registered block patterns.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--category=<category>]`
  Filter by pattern category.
- `[--search=<search>]`
  Search patterns by title or keywords.
- `[--inserter]`
  Only show patterns visible in the inserter.
- `[--field=<field>]`
  Prints the value of a single field for each pattern.
- `[--fields=<fields>]`
  Limit the output to specific pattern fields.
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

These fields will be displayed by default for each pattern:

- name
- title
- description
- categories

These fields are optionally available:

- content
- keywords
- blockTypes
- postTypes
- templateTypes
- inserter
- viewportWidth

##### Examples

```bash
# List all registered patterns
$ wp block pattern list

# List patterns in the 'buttons' category
$ wp block pattern list --category=buttons

# Search for hero patterns
$ wp block pattern list --search=hero

# Export all patterns to JSON
$ wp block pattern list --format=json > patterns.json
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

### wp block pattern-category <command>

Reference: <https://developer.wordpress.org/cli/commands/block/pattern-category/>

Retrieves details on registered block pattern categories.

Get information on block pattern categories from the [WP_Block_Pattern_Categories_Registry](https://developer.wordpress.org/reference/classes/wp_block_pattern_categories_registry/).

#### Examples

```bash
# List all registered pattern categories
$ wp block pattern-category list

# Get details about a specific category
$ wp block pattern-category get featured --format=json
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp block pattern-category get](https://developer.wordpress.org/cli/commands/block/pattern-category/get/) | Gets details about a registered block pattern category. |
| [wp block pattern-category list](https://developer.wordpress.org/cli/commands/block/pattern-category/list/) | Lists registered block pattern categories. |

#### wp block pattern-category get

Reference: <https://developer.wordpress.org/cli/commands/block/pattern-category/get/>

Gets details about a registered block pattern category.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Category name (e.g., 'buttons', 'columns').
- `[--field=<field>]`
  Instead of returning the whole category, returns the value of a single field.
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

##### Examples

```bash
# Get details about the 'buttons' category
$ wp block pattern-category get buttons

# Get as JSON
$ wp block pattern-category get featured --format=json
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

#### wp block pattern-category list

Reference: <https://developer.wordpress.org/cli/commands/block/pattern-category/list/>

Lists registered block pattern categories.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--field=<field>]`
  Prints the value of a single field for each category.
- `[--fields=<fields>]`
  Limit the output to specific category fields.
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

These fields will be displayed by default for each category:

- name
- label
- description

##### Examples

```bash
# List all pattern categories
$ wp block pattern-category list

# Get category names only
$ wp block pattern-category list --field=name

# Export categories to JSON
$ wp block pattern-category list --format=json
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

### wp block style <command>

Reference: <https://developer.wordpress.org/cli/commands/block/style/>

Retrieves details on registered block styles.

Get information on block style variations from the [WP_Block_Styles_Registry](https://developer.wordpress.org/reference/classes/wp_block_styles_registry/).

#### Examples

```bash
# List all registered block styles
$ wp block style list

# List styles for a specific block
$ wp block style list --block=core/button

# Get details about a specific style
$ wp block style get core/button outline
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp block style get](https://developer.wordpress.org/cli/commands/block/style/get/) | Gets details about a registered block style. |
| [wp block style list](https://developer.wordpress.org/cli/commands/block/style/list/) | Lists registered block styles. |

#### wp block style get

Reference: <https://developer.wordpress.org/cli/commands/block/style/get/>

Gets details about a registered block style.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<block>`
  Block type name (e.g., 'core/button').
- `<style>`
  Style name (e.g., 'outline').
- `[--field=<field>]`
  Instead of returning the whole style, returns the value of a single field.
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

##### Examples

```bash
# Get the outline style for buttons
$ wp block style get core/button outline

# Get as JSON
$ wp block style get core/button outline --format=json
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

#### wp block style list

Reference: <https://developer.wordpress.org/cli/commands/block/style/list/>

Lists registered block styles.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--block=<block>]`
  Filter by block type name (e.g., 'core/button').
- `[--field=<field>]`
  Prints the value of a single field for each style.
- `[--fields=<fields>]`
  Limit the output to specific style fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - count
  - yaml

##### Available Fields

These fields will be displayed by default for each style:

- block_name
- name
- label
- is_default

These fields are optionally available:

- style_handle
- inline_style

##### Examples

```bash
# List all block styles
$ wp block style list

# List styles for the button block
$ wp block style list --block=core/button

# List all styles as JSON
$ wp block style list --format=json
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

### wp block synced-pattern <command>

Reference: <https://developer.wordpress.org/cli/commands/block/synced-pattern/>

Manages synced patterns (reusable blocks).

Synced patterns are stored as the 'wp_block' post type and can be either synced (changes reflect everywhere) or not synced (regular patterns).

#### Examples

```bash
# List all synced patterns
$ wp block synced-pattern list

# Create a synced pattern
$ wp block synced-pattern create --title="My Pattern" --content='&lt;!-- wp:paragraph --&gt;&lt;p&gt;Hello&lt;/p&gt;&lt;!-- /wp:paragraph --&gt;'

# Delete a synced pattern
$ wp block synced-pattern delete 123
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp block synced-pattern create](https://developer.wordpress.org/cli/commands/block/synced-pattern/create/) | Creates a synced pattern. |
| [wp block synced-pattern delete](https://developer.wordpress.org/cli/commands/block/synced-pattern/delete/) | Deletes one or more synced patterns. |
| [wp block synced-pattern get](https://developer.wordpress.org/cli/commands/block/synced-pattern/get/) | Gets details about a synced pattern. |
| [wp block synced-pattern list](https://developer.wordpress.org/cli/commands/block/synced-pattern/list/) | Lists synced patterns. |
| [wp block synced-pattern update](https://developer.wordpress.org/cli/commands/block/synced-pattern/update/) | Updates a synced pattern. |

#### wp block synced-pattern create

Reference: <https://developer.wordpress.org/cli/commands/block/synced-pattern/create/>

Creates a synced pattern.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--title=<title>]`
  The pattern title.
- `[--slug=<slug>]`
  The pattern slug. Default: sanitized title.
- `[--content=<content>]`
  The block content.
- `[--sync-status=<status>]`
  Sync status.
  - default: synced
  - options:
  - synced
  - unsynced
- `[--status=<status>]`
  Post status.
  - default: publish
- `[<file>]`
  Read content from file. Pass '-' for STDIN.
- `[--porcelain]`
  Output only the new pattern ID.

##### Examples

```bash
# Create a synced pattern from content
$ wp block synced-pattern create --title="My Hero" --content='&lt;!-- wp:paragraph --&gt;&lt;p&gt;Hello&lt;/p&gt;&lt;!-- /wp:paragraph --&gt;'

# Create from file
$ wp block synced-pattern create --title="Header" header.html

# Create an unsynced pattern
$ wp block synced-pattern create --title="Footer" --sync-status=unsynced footer.html

# Create from STDIN
$ cat content.html | wp block synced-pattern create --title="From STDIN" -
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

#### wp block synced-pattern delete

Reference: <https://developer.wordpress.org/cli/commands/block/synced-pattern/delete/>

Deletes one or more synced patterns.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>…`
  One or more synced pattern IDs.
- `[--force]`
  Skip trash and permanently delete.

##### Examples

```bash
# Delete a synced pattern (to trash)
$ wp block synced-pattern delete 123

# Permanently delete
$ wp block synced-pattern delete 123 --force

# Delete multiple
$ wp block synced-pattern delete 123 456 789
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

#### wp block synced-pattern get

Reference: <https://developer.wordpress.org/cli/commands/block/synced-pattern/get/>

Gets details about a synced pattern.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The synced pattern ID.
- `[--field=<field>]`
  Instead of returning the whole pattern, returns the value of a single field.
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

##### Examples

```bash
# Get a synced pattern
$ wp block synced-pattern get 123

# Get pattern content only
$ wp block synced-pattern get 123 --field=post_content
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

#### wp block synced-pattern list

Reference: <https://developer.wordpress.org/cli/commands/block/synced-pattern/list/>

Lists synced patterns.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--sync-status=<status>]`
  Filter by sync status.
  - default: all
  - options:
  - synced
  - unsynced
  - all
- `[--search=<search>]`
  Search by title.
- `[--field=<field>]`
  Prints the value of a single field for each pattern.
- `[--fields=<fields>]`
  Limit the output to specific fields.
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

These fields will be displayed by default for each pattern:

- ID
- post_title
- post_name
- sync_status
- post_date

These fields are optionally available:

- post_content
- post_status
- post_author

##### Examples

```bash
# List all synced patterns
$ wp block synced-pattern list --sync-status=synced

# Search for patterns by title
$ wp block synced-pattern list --search=hero

# Export all synced patterns to JSON
$ wp block synced-pattern list --format=json > synced-patterns.json
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

#### wp block synced-pattern update

Reference: <https://developer.wordpress.org/cli/commands/block/synced-pattern/update/>

Updates a synced pattern.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The synced pattern ID.
- `[--title=<title>]`
  The pattern title.
- `[--content=<content>]`
  The block content.
- `[--sync-status=<status>]`
  Sync status.
  - options:
  - synced
  - unsynced
- `[<file>]`
  Read content from file. Pass '-' for STDIN.

##### Examples

```bash
# Update pattern title
$ wp block synced-pattern update 123 --title="Updated Hero"

# Update content from file
$ wp block synced-pattern update 123 updated-content.html

# Change sync status
$ wp block synced-pattern update 123 --sync-status=unsynced
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

### wp block template <command>

Reference: <https://developer.wordpress.org/cli/commands/block/template/>

Retrieves details on block templates and template parts.

Get information on block templates used in Full Site Editing (FSE) themes.

#### Examples

```bash
# List all templates
$ wp block template list

# List template parts for the header area
$ wp block template list --type=wp_template_part --area=header

# Get a specific template
$ wp block template get twentytwentyfour//single
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp block template export](https://developer.wordpress.org/cli/commands/block/template/export/) | Exports a block template to a file. |
| [wp block template get](https://developer.wordpress.org/cli/commands/block/template/get/) | Gets details about a block template. |
| [wp block template list](https://developer.wordpress.org/cli/commands/block/template/list/) | Lists block templates or template parts. |

#### wp block template export

Reference: <https://developer.wordpress.org/cli/commands/block/template/export/>

Exports a block template to a file.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  Template ID to export.
- `[--type=<type>]`
  Template type.
  - default: wp_template
  - options:
  - wp_template
  - wp_template_part
- `[--file=<file>]`
  File path to export to. Parent directories will be created if needed.
- `[--dir=<directory>]`
  Directory to export to. Defaults to current directory. Creates directory if needed.
- `[--stdout]`
  Output to stdout instead of file.

##### Examples

```bash
# Export template to file
$ wp block template export twentytwentyfour//single

# Export to stdout
$ wp block template export twentytwentyfour//single --stdout

# Export to specific directory
$ wp block template export twentytwentyfour//single --dir=./templates/

# Export to specific file path
$ wp block template export twentytwentyfour//single --file=exports/templates/single.html
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

#### wp block template get

Reference: <https://developer.wordpress.org/cli/commands/block/template/get/>

Gets details about a block template.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  Template ID in format 'theme//slug' (e.g., 'twentytwentyfour//single').
- `[--type=<type>]`
  Template type.
  - default: wp_template
  - options:
  - wp_template
  - wp_template_part
- `[--field=<field>]`
  Instead of returning the whole template, returns the value of a single field.
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

##### Examples

```bash
# Get the single post template
$ wp block template get twentytwentyfour//single

# Get template content only
$ wp block template get twentytwentyfour//single --field=content

# Get as JSON
$ wp block template get twentytwentyfour//single --format=json
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

#### wp block template list

Reference: <https://developer.wordpress.org/cli/commands/block/template/list/>

Lists block templates or template parts.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--type=<type>]`
  Template type.
  - default: wp_template
  - options:
  - wp_template
  - wp_template_part
- `[--slug=<slug>]`
  Filter by template slug(s). Accepts a single slug or comma-separated list.
- `[--area=<area>]`
  For template parts, filter by area (header, footer, sidebar, uncategorized).
- `[--post-type=<post-type>]`
  Filter templates by post type they apply to.
- `[--source=<source>]`
  Filter by source (theme, plugin, custom).
- `[--field=<field>]`
  Prints the value of a single field for each template.
- `[--fields=<fields>]`
  Limit the output to specific template fields.
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

These fields will be displayed by default for each template:

- id
- slug
- title
- source
- type

These fields are optionally available:

- theme
- description
- status
- origin
- is_custom
- has_theme_file
- author
- area (template parts only)
- content

##### Examples

```bash
# List all templates
$ wp block template list

# List template parts for the header area
$ wp block template list --type=wp_template_part --area=header

# List templates from the theme
$ wp block template list --source=theme

# List specific templates by slug
$ wp block template list --slug=single,archive

# List templates for a specific post type
$ wp block template list --post-type=page

# Export templates as JSON
$ wp block template list --format=json
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

### wp block type <command>

Reference: <https://developer.wordpress.org/cli/commands/block/type/>

Retrieves details on registered block types.

Get information on WordPress' built-in and custom block types from the [WP_Block_Type_Registry](https://developer.wordpress.org/reference/classes/wp_block_type_registry/).

#### Examples

```bash
# List all registered block types
$ wp block type list

# Get details about a specific block type
$ wp block type get core/paragraph --format=json

# List all core blocks
$ wp block type list --namespace=core
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp block type exists](https://developer.wordpress.org/cli/commands/block/type/exists/) | Checks whether a block type is registered. |
| [wp block type get](https://developer.wordpress.org/cli/commands/block/type/get/) | Gets details about a registered block type. |
| [wp block type list](https://developer.wordpress.org/cli/commands/block/type/list/) | Lists registered block types. |

#### wp block type exists

Reference: <https://developer.wordpress.org/cli/commands/block/type/exists/>

Checks whether a block type is registered.

Exits with return code 0 if the block type exists, 1 if it does not.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  The block type name, including namespace.

##### Examples

```bash
# Check if a block type exists.
$ wp block type exists core/paragraph
Success: Block type 'core/paragraph' is registered.

# Check for a non-existent block type.
$ wp block type exists core/nonexistent
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

#### wp block type get

Reference: <https://developer.wordpress.org/cli/commands/block/type/get/>

Gets details about a registered block type.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Block type name (e.g., 'core/paragraph').
- `[--field=<field>]`
  Instead of returning the whole block type, returns the value of a single field.
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

##### Examples

```bash
# Get details about the paragraph block
$ wp block type get core/paragraph

# Get the supports field as JSON
$ wp block type get core/paragraph --field=supports --format=json

# Get specific fields
$ wp block type get core/image --fields=name,title,supports --format=json
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

#### wp block type list

Reference: <https://developer.wordpress.org/cli/commands/block/type/list/>

Lists registered block types.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--namespace=<namespace>]`
  Filter by block namespace (e.g., 'core', 'my-plugin').
- `[--dynamic]`
  Only show dynamic blocks (blocks with render_callback).
- `[--static]`
  Only show static blocks (blocks without render_callback).
- `[--field=<field>]`
  Prints the value of a single field for each block type.
- `[--fields=<fields>]`
  Limit the output to specific block type fields.
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

These fields will be displayed by default for each block type:

- name
- title
- description
- category
- is_dynamic

These fields are optionally available:

- icon
- keywords
- parent
- ancestor
- supports
- attributes
- provides_context
- uses_context
- block_hooks
- editor_script_handles
- script_handles
- view_script_handles
- editor_style_handles
- style_handles
- view_style_handles
- api_version

##### Examples

```bash
# List all registered block types
$ wp block type list

# List all core blocks
$ wp block type list --namespace=core --fields=name,title,category

# List only dynamic blocks
$ wp block type list --dynamic --format=json

# Get count of registered block types
$ wp block type list --format=count
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
