# wp term

Reference: <https://developer.wordpress.org/cli/commands/term/>

## Description

Manages taxonomy terms and term meta, with create, delete, and list commands.

## Synopsis

```bash
wp term <command>
```

See reference for [taxonomies and their terms](https://wordpress.org/documentation/article/taxonomies).

## Examples

```bash
# Create a new term.
$ wp term create category Apple --description="A type of fruit"
Success: Created category 199.

# Get details about a term.
$ wp term get category 199 --format=json --fields=term_id,name,slug,count
{"term_id":199,"name":"Apple","slug":"apple","count":1}

# Update an existing term.
$ wp term update category 15 --name=Apple
Success: Term updated.

# Get the term's URL.
$ wp term list post_tag --include=123 --field=url
http://example.com/tag/tips-and-tricks

# Delete post category
$ wp term delete category 15
Success: Deleted category 15.

# Recount posts assigned to each categories and tags
$ wp term recount category post_tag
Success: Updated category term count
Success: Updated post_tag term count
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp term create](https://developer.wordpress.org/cli/commands/term/create/) | Creates a new term. |
| [wp term delete](https://developer.wordpress.org/cli/commands/term/delete/) | Deletes an existing term. |
| [wp term generate](https://developer.wordpress.org/cli/commands/term/generate/) | Generates some terms. |
| [wp term get](https://developer.wordpress.org/cli/commands/term/get/) | Gets details about a term. |
| [wp term list](https://developer.wordpress.org/cli/commands/term/list/) | Lists terms in a taxonomy. |
| [wp term meta](https://developer.wordpress.org/cli/commands/term/meta/) | Adds, updates, deletes, and lists term custom fields. |
| [wp term migrate](https://developer.wordpress.org/cli/commands/term/migrate/) | Migrate a term of a taxonomy to another taxonomy. |
| [wp term recount](https://developer.wordpress.org/cli/commands/term/recount/) | Recalculates number of posts assigned to each term. |
| [wp term update](https://developer.wordpress.org/cli/commands/term/update/) | Updates an existing term. |

### wp term create

Reference: <https://developer.wordpress.org/cli/commands/term/create/>

Creates a new term.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<taxonomy>`
  Taxonomy for the new term.
- `<term>`
  A name for the new term.
- `[--slug=<slug>]`
  A unique slug for the new term. Defaults to sanitized version of name.
- `[--description=<description>]`
  A description for the new term.
- `[--parent=<term-id>]`
  A parent for the new term.
- `[--porcelain]`
  Output just the new term id.

#### Examples

```bash
# Create a new category "Apple" with a description.
$ wp term create category Apple --description="A type of fruit"
Success: Created category 199.
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

### wp term delete

Reference: <https://developer.wordpress.org/cli/commands/term/delete/>

Deletes an existing term.

Errors if the term doesn't exist, or there was a problem in deleting it.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<taxonomy>`
  Taxonomy of the term to delete.
- `<term>…`
  One or more IDs or slugs of terms to delete.
- `[--by=<field>]`
  Explicitly handle the term value as a slug or id.
  - default: id
  - options:
  - slug
  - id

#### Examples

```bash
# Delete post category by id
$ wp term delete category 15
Deleted category 15.
Success: Deleted 1 of 1 terms.

# Delete post category by slug
$ wp term delete category apple --by=slug
Deleted category 15.
Success: Deleted 1 of 1 terms.

# Delete all post tags
$ wp term list post_tag --field=term_id | xargs wp term delete post_tag
Deleted post_tag 159.
Deleted post_tag 160.
Deleted post_tag 161.
Success: Deleted 3 of 3 terms.
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

### wp term generate

Reference: <https://developer.wordpress.org/cli/commands/term/generate/>

Generates some terms.

Creates a specified number of new terms with dummy data.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<taxonomy>`
  The taxonomy for the generated terms.
- `[--count=<number>]`
  How many terms to generate?
  - default: 100
- `[--max_depth=<number>]`
  Generate child terms down to a certain depth.
  - default: 1
- `[--format=<format>]`
  Render output in a particular format.
  - default: progress
  - options:
  - progress
  - ids

#### Examples

```bash
# Generate post categories.
$ wp term generate category --count=10
Generating terms  100% [=========] 0:02 / 0:02

# Add meta to every generated term.
$ wp term generate category --format=ids --count=3 | xargs -d ' ' -I % wp term meta add % foo bar
Success: Added custom field.
Success: Added custom field.
Success: Added custom field.
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

### wp term get

Reference: <https://developer.wordpress.org/cli/commands/term/get/>

Gets details about a term.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<taxonomy>`
  Taxonomy of the term to get
- `<term>`
  ID or slug of the term to get
- `[--by=<field>]`
  Explicitly handle the term value as a slug or id.
  - default: id
  - options:
  - slug
  - id
- `[--field=<field>]`
  Instead of returning the whole term, returns the value of a single field.
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

#### Examples

```bash
# Get details about a category with id 199.
$ wp term get category 199 --format=json
{"term_id":199,"name":"Apple","slug":"apple","term_group":0,"term_taxonomy_id":199,"taxonomy":"category","description":"A type of fruit","parent":0,"count":0,"filter":"raw"}

# Get details about a category with slug apple.
$ wp term get category apple --by=slug --format=json
{"term_id":199,"name":"Apple","slug":"apple","term_group":0,"term_taxonomy_id":199,"taxonomy":"category","description":"A type of fruit","parent":0,"count":0,"filter":"raw"}
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

### wp term list

Reference: <https://developer.wordpress.org/cli/commands/term/list/>

Lists terms in a taxonomy.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<taxonomy>…`
  List terms of one or more taxonomies
- `[--<field>=<value>]`
  Filter by one or more fields (see [get_terms()](https://developer.wordpress.org/reference/functions/get_terms/)  $args parameter for a list of fields).
- `[--field=<field>]`
  Prints the value of a single field for each term.
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

These fields will be displayed by default for each term:

- term_id
- term_taxonomy_id
- name
- slug
- description
- parent
- count

These fields are optionally available:

- url

#### Examples

```bash
# List post categories
$ wp term list category --format=csv
term_id,term_taxonomy_id,name,slug,description,parent,count
2,2,aciform,aciform,,0,1
3,3,antiquarianism,antiquarianism,,0,1
4,4,arrangement,arrangement,,0,1
5,5,asmodeus,asmodeus,,0,1

# List post tags
$ wp term list post_tag --fields=name,slug
+-----------+-------------+
| name      | slug        |
+-----------+-------------+
| 8BIT      | 8bit        |
| alignment | alignment-2 |
| Articles  | articles    |
| aside     | aside       |
+-----------+-------------+
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

### wp term meta <command>

Reference: <https://developer.wordpress.org/cli/commands/term/meta/>

Adds, updates, deletes, and lists term custom fields.

#### Examples

```bash
# Set term meta
$ wp term meta set 123 bio "Mary is a WordPress developer."
Success: Updated custom field 'bio'.

# Get term meta
$ wp term meta get 123 bio
Mary is a WordPress developer.

# Update term meta
$ wp term meta update 123 bio "Mary is an awesome WordPress developer."
Success: Updated custom field 'bio'.

# Delete term meta
$ wp term meta delete 123 bio
Success: Deleted custom field.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp term meta add](https://developer.wordpress.org/cli/commands/term/meta/add/) | Add a meta field. |
| [wp term meta delete](https://developer.wordpress.org/cli/commands/term/meta/delete/) | Delete a meta field. |
| [wp term meta get](https://developer.wordpress.org/cli/commands/term/meta/get/) | Get meta field value. |
| [wp term meta list](https://developer.wordpress.org/cli/commands/term/meta/list/) | List all metadata associated with an object. |
| [wp term meta patch](https://developer.wordpress.org/cli/commands/term/meta/patch/) | Update a nested value for a meta field. |
| [wp term meta pluck](https://developer.wordpress.org/cli/commands/term/meta/pluck/) | Get a nested value from a meta field. |
| [wp term meta set](https://developer.wordpress.org/cli/commands/term/meta/set/) | Update a meta field. |
| [wp term meta update](https://developer.wordpress.org/cli/commands/term/meta/update/) | Update a meta field. |

#### wp term meta add

Reference: <https://developer.wordpress.org/cli/commands/term/meta/add/>

Add a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to create.
- `[<value>]`
  The value of the meta field. If omitted, the value is read from STDIN.
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

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

#### wp term meta delete

Reference: <https://developer.wordpress.org/cli/commands/term/meta/delete/>

Delete a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `[<key>]`
  The name of the meta field to delete.
- `[<value>]`
  The value to delete. If omitted, all rows with key will deleted.
- `[--all]`
  Delete all meta for the object.

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

#### wp term meta get

Reference: <https://developer.wordpress.org/cli/commands/term/meta/get/>

Get meta field value.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to get.
- `[--single]`
  Whether to return a single value.
- `[--format=<format>]`
  Get value in a particular format.
  - default: var_export
  - options:
  - var_export
  - json
  - yaml

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

#### wp term meta list

Reference: <https://developer.wordpress.org/cli/commands/term/meta/list/>

List all metadata associated with an object.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  ID for the object.
- `[--keys=<keys>]`
  Limit output to metadata of specific keys.
- `[--fields=<fields>]`
  Limit the output to specific row fields. Defaults to id,meta_key,meta_value.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml
  - count
- `[--orderby=<fields>]`
  Set orderby which field.
  - default: id
  - options:
  - id
  - meta_key
  - meta_value
- `[--order=<order>]`
  Set ascending or descending order.
  - default: asc
  - options:
  - asc
  - desc
- `[--unserialize]`
  Unserialize meta_value output.

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

#### wp term meta patch

Reference: <https://developer.wordpress.org/cli/commands/term/meta/patch/>

Update a nested value for a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<action>`
  Patch action to perform.
  - options:
  - insert
  - update
  - delete
- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to update.
- `<key-path>…`
  The name(s) of the keys within the value to locate the value to patch.
- `[<value>]`
  The new value. If omitted, the value is read from STDIN.
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

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

#### wp term meta pluck

Reference: <https://developer.wordpress.org/cli/commands/term/meta/pluck/>

Get a nested value from a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to get.
- `<key-path>…`
  The name(s) of the keys within the value to locate the value to pluck.
- `[--format=<format>]`
  The output format of the value.
  -–
  - default: plaintext
  - options:
  - plaintext
  - json
  - yaml

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

#### wp term meta set

Reference: <https://developer.wordpress.org/cli/commands/term/meta/set/>

Update a meta field.

This is an alias for `wp term meta update`.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to update.
- `[<value>]`
  The new value. If omitted, the value is read from STDIN.
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

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

#### wp term meta update

Reference: <https://developer.wordpress.org/cli/commands/term/meta/update/>

Update a meta field.

**Alias:** `set`

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to update.
- `[<value>]`
  The new value. If omitted, the value is read from STDIN.
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

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

### wp term migrate

Reference: <https://developer.wordpress.org/cli/commands/term/migrate/>

Migrate a term of a taxonomy to another taxonomy.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<term>`
  Slug or ID of the term to migrate.
- `[--by=<field>]`
  Explicitly handle the term value as a slug or id.
  - default: id
  - options:
  - slug
  - id
- `[--from=<taxonomy>]`
  Taxonomy slug of the term to migrate.
- `[--to=<taxonomy>]`
  Taxonomy slug to migrate to.

#### Examples

```bash
# Migrate a category's term (video) to tag taxonomy.
$ wp term migrate 9190 --from=category --to=post_tag
Term 'video' assigned to post 1155.
Term 'video' migrated.
Old instance of term 'video' removed from its original taxonomy.
Success: Migrated the term 'video' from taxonomy 'category' to taxonomy 'post_tag' for 1 post.
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

### wp term recount

Reference: <https://developer.wordpress.org/cli/commands/term/recount/>

Recalculates number of posts assigned to each term.

In instances where manual updates are made to the terms assigned to posts in the database, the number of posts associated with a term can become out-of-sync with the actual number of posts. This command runs [wp_update_term_count()](https://developer.wordpress.org/reference/functions/wp_update_term_count/) on the taxonomy's terms to bring the count back to the correct value.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<taxonomy>…`
  One or more taxonomies to recalculate.

#### Examples

```bash
# Recount posts assigned to each categories and tags
$ wp term recount category post_tag
Success: Updated category term count.
Success: Updated post_tag term count.

# Recount all listed taxonomies
$ wp taxonomy list --field=name | xargs wp term recount
Success: Updated category term count.
Success: Updated post_tag term count.
Success: Updated nav_menu term count.
Success: Updated link_category term count.
Success: Updated post_format term count.
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

### wp term update

Reference: <https://developer.wordpress.org/cli/commands/term/update/>

Updates an existing term.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<taxonomy>`
  Taxonomy of the term to update.
- `<term>`
  ID or slug for the term to update.
- `[--by=<field>]`
  Explicitly handle the term value as a slug or id.
  - default: id
  - options:
  - slug
  - id
- `[--name=<name>]`
  A new name for the term.
- `[--slug=<slug>]`
  A new slug for the term.
- `[--description=<description>]`
  A new description for the term.
- `[--parent=<term-id>]`
  A new parent for the term.

#### Examples

```bash
# Change category with id 15 to use the name "Apple"
$ wp term update category 15 --name=Apple
Success: Term updated.

# Change category with slug apple to use the name "Apple"
$ wp term update category apple --by=slug --name=Apple
Success: Term updated.
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
