# wp ability

Reference: <https://developer.wordpress.org/cli/commands/ability/>

## Description

Lists, inspects, and executes abilities registered via the WordPress Abilities API.

The Abilities API, introduced in WordPress 6.9, provides a standardized way to register and discover distinct units of functionality within a WordPress site.

## Synopsis

```bash
wp ability <command>
```

## Examples

```bash
# List all registered abilities.
$ wp ability list
+---------------------------+----------------------+----------+------------------------------------------+
| name                      | label                | category | description                              |
+---------------------------+----------------------+----------+------------------------------------------+
| core/get-site-info        | Get Site Information | site     | Returns site information configured i... |
| core/get-user-info        | Get User Information | user     | Returns basic profile details for the... |
| core/get-environment-info | Get Environment Info | site     | Returns core details about the site's... |
+---------------------------+----------------------+----------+------------------------------------------+

# Get details of a specific ability.
$ wp ability get core/get-site-info --fields=name,label,category,readonly,show_in_rest
+---------------+----------------------+
| Field         | Value                |
+---------------+----------------------+
| name          | core/get-site-info   |
| label         | Get Site Information |
| category      | site                 |
| readonly      | 1                    |
| show_in_rest  | 1                    |
+---------------+----------------------+

# Execute an ability with JSON input (required for array values).
$ wp ability run core/get-site-info --input='{"fields":["name","version"]}' --user=admin
{
    "name": "Test Blog",
    "version": "6.9"
}

# Check if an ability exists.
$ wp ability exists core/get-site-info
$ echo $?
0

# Check if user can run an ability.
$ wp ability can-run core/get-site-info
$ echo $?
0

# Validate input before execution.
$ wp ability validate core/get-site-info --input='{"fields":["name","version"]}'
Success: Input is valid.
```

## Subcommands

- `wp ability can-run` - Checks if the current user can execute an ability.
- `wp ability category` - Lists and inspects ability categories registered via the WordPress Abilities API.
- `wp ability exists` - Checks whether an ability is registered.
- `wp ability get` - Gets details about a registered ability.
- `wp ability list` - Lists all registered abilities.
- `wp ability run` - Executes a registered ability.
- `wp ability validate` - Validates input against an ability's schema.

## wp ability can-run

Reference: <https://developer.wordpress.org/cli/commands/ability/can-run/>

Checks if the current user can execute an ability.

Validates permissions without actually executing the ability. Exits with return code 0 if permitted, 1 if not.

### Options

- `<name>` - The ability name (namespace/ability-name format).
- `[--input=<json>]` - JSON string containing input data for permission checking.
- `[--<field>=<value>]` - Individual input fields for permission checking.

### Examples

```bash
# Check if current user can run an ability (as admin).
$ wp ability can-run core/get-site-info --user=admin
$ echo $?
0

# Check permission when not permitted.
$ wp ability can-run core/get-site-info
$ echo $?
1

# Use in a script.
$ if wp ability can-run core/get-site-info --user=admin; then
>   wp ability run core/get-site-info --user=admin
> fi
```

### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.

## wp ability category

Reference: <https://developer.wordpress.org/cli/commands/ability/category/>

Lists and inspects ability categories registered via the WordPress Abilities API.

The Abilities API, introduced in WordPress 6.9, uses categories to organize related abilities for better discoverability.

### Synopsis

```bash
wp ability category <command>
```

### Examples

```bash
# List all registered ability categories.
$ wp ability category list
+------+-------+-----------------------------------------------------+
| slug | label | description                                         |
+------+-------+-----------------------------------------------------+
| site | Site  | Abilities that retrieve or modify site information. |
| user | User  | Abilities that retrieve or modify user information. |
+------+-------+-----------------------------------------------------+

# Get details of a specific category.
$ wp ability category get site
+-------------+-----------------------------------------------------+
| Field       | Value                                               |
+-------------+-----------------------------------------------------+
| slug        | site                                                |
| label       | Site                                                |
| description | Abilities that retrieve or modify site information. |
| meta        | {}                                                  |
+-------------+-----------------------------------------------------+

# Check if a category exists.
$ wp ability category exists site
$ echo $?
0
```

### Subcommands

- `wp ability category exists` - Checks whether an ability category is registered.
- `wp ability category get` - Gets details about a registered ability category.
- `wp ability category list` - Lists all registered ability categories.

### wp ability category exists

Reference: <https://developer.wordpress.org/cli/commands/ability/category/exists/>

Checks whether an ability category is registered.

Exits with return code 0 if the category exists, 1 if it does not.

#### Options

- `<slug>` - The category slug.

#### Examples

```bash
# Check if a category exists.
$ wp ability category exists site
$ echo $?
0

# Check for non-existent category.
$ wp ability category exists nonexistent
$ echo $?
1

# Use in a script.
$ if wp ability category exists site; then
>   echo "Category exists"
> fi
```

#### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.

### wp ability category get

Reference: <https://developer.wordpress.org/cli/commands/ability/category/get/>

Gets details about a registered ability category.

#### Options

- `<slug>` - The category slug.
- `[--field=<field>]` - Instead of returning the whole category, returns the value of a single field.
- `[--fields=<fields>]` - Limit the output to specific fields. Defaults to all fields.
- `[--format=<format>]` - Render output in a particular format. Default: table. Options: table, csv, json, yaml.

#### Available Fields

- `slug`
- `label`
- `description`
- `meta`

#### Examples

```bash
# Get details of a specific category.
$ wp ability category get site
+-------------+-----------------------------------------------------+
| Field       | Value                                               |
+-------------+-----------------------------------------------------+
| slug        | site                                                |
| label       | Site                                                |
| description | Abilities that retrieve or modify site information. |
| meta        | {}                                                  |
+-------------+-----------------------------------------------------+

# Get category as JSON.
$ wp ability category get site --format=json
{"slug":"site","label":"Site","description":"...","meta":"{}"}

# Get only the label.
$ wp ability category get site --field=label
Site
```

#### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.

### wp ability category list

Reference: <https://developer.wordpress.org/cli/commands/ability/category/list/>

Lists all registered ability categories.

#### Options

- `[--field=<field>]` - Prints the value of a single field for each category.
- `[--fields=<fields>]` - Limit the output to specific category fields.
- `[--format=<format>]` - Render output in a particular format. Default: table. Options: table, csv, json, yaml, count.

#### Available Fields

These fields will be displayed by default for each category:

- `slug`
- `label`
- `description`

#### Examples

```bash
# List all categories.
$ wp ability category list
+------+-------+-----------------------------------------------------+
| slug | label | description                                         |
+------+-------+-----------------------------------------------------+
| site | Site  | Abilities that retrieve or modify site information. |
| user | User  | Abilities that retrieve or modify user information. |
+------+-------+-----------------------------------------------------+

# List categories as JSON.
$ wp ability category list --format=json
[{"slug":"site","label":"Site","description":"..."},{"slug":"user",...}]

# List only category slugs.
$ wp ability category list --field=slug
site
user
```

#### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.

## wp ability exists

Reference: <https://developer.wordpress.org/cli/commands/ability/exists/>

Checks whether an ability is registered.

Exits with return code 0 if the ability exists, 1 if it does not.

### Options

- `<name>` - The ability name (namespace/ability-name format).

### Examples

```bash
# Check if an ability exists.
$ wp ability exists core/get-site-info
$ echo $?
0

# Check for non-existent ability.
$ wp ability exists nonexistent/ability
$ echo $?
1

# Use in a script.
$ if wp ability exists core/get-site-info; then
>   wp ability run core/get-site-info
> fi
```

### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.

## wp ability get

Reference: <https://developer.wordpress.org/cli/commands/ability/get/>

Gets details about a registered ability.

### Options

- `<name>` - The ability name (namespace/ability-name format).
- `[--field=<field>]` - Instead of returning the whole ability, returns the value of a single field.
- `[--fields=<fields>]` - Limit the output to specific fields. Defaults to all fields.
- `[--format=<format>]` - Render output in a particular format. Default: table. Options: table, csv, json, yaml.

### Available Fields

- `name`
- `label`
- `category`
- `description`
- `input_schema`
- `output_schema`
- `readonly`
- `destructive`
- `idempotent`
- `show_in_rest`

### Examples

```bash
# Get details of a specific ability.
$ wp ability get core/get-site-info
+---------------+----------------------+
| Field         | Value                |
+---------------+----------------------+
| name          | core/get-site-info   |
| label         | Get Site Information |
| category      | site                 |
| description   | Returns site info... |
| input_schema  | {"type":"object"}    |
| output_schema | {"type":"object"}    |
| readonly      | 1                    |
| destructive   | 0                    |
| idempotent    | 1                    |
| show_in_rest  | 1                    |
+---------------+----------------------+

# Get ability as JSON.
$ wp ability get core/get-site-info --format=json

# Get only the description.
$ wp ability get core/get-site-info --field=description
Returns site information configured in WordPress.
```

### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.

## wp ability list

Reference: <https://developer.wordpress.org/cli/commands/ability/list/>

Lists all registered abilities.

### Options

- `[--category=<slug>]` - Filter abilities by category slug.
- `[--namespace=<prefix>]` - Filter abilities by namespace prefix (e.g., 'core' for 'core/*' abilities).
- `[--show-in-rest=<bool>]` - Filter abilities by REST API exposure.
- `[--field=<field>]` - Prints the value of a single field for each ability.
- `[--fields=<fields>]` - Limit the output to specific ability fields.
- `[--format=<format>]` - Render output in a particular format. Default: table. Options: table, csv, json, yaml, count, ids.

### Available Fields

These fields will be displayed by default for each ability:

- `name`
- `label`
- `category`
- `description`

These fields are optionally available:

- `readonly`
- `destructive`
- `idempotent`
- `show_in_rest`

### Examples

```bash
# List all abilities.
$ wp ability list
+---------------------------+----------------------+----------+------------------------------------------+
| name                      | label                | category | description                              |
+---------------------------+----------------------+----------+------------------------------------------+
| core/get-site-info        | Get Site Information | site     | Returns site information configured i... |
| core/get-user-info        | Get User Information | user     | Returns basic profile details for the... |
+---------------------------+----------------------+----------+------------------------------------------+

# List abilities in a specific category.
$ wp ability list --category=site

# List abilities by namespace.
$ wp ability list --namespace=core

# List abilities exposed to REST API.
$ wp ability list --show-in-rest=true

# List abilities as JSON.
$ wp ability list --format=json

# List only ability names.
$ wp ability list --field=name
core/get-site-info
core/get-user-info
core/get-environment-info
```

### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.

## wp ability run

Reference: <https://developer.wordpress.org/cli/commands/ability/run/>

Executes a registered ability.

### Options

- `<name>` - The ability name (namespace/ability-name format).
- `[--input=<json>]` - JSON string containing input data for the ability. Use '-' to read from stdin.
- `[--<field>=<value>]` - Individual input fields. Alternative to --input for simple inputs.
- `[--format=<format>]` - Render output in a particular format. Default: json. Options: json, yaml, var_export.

### Examples

```bash
# Execute an ability.
$ wp ability run core/get-site-info --user=admin
{
    "name": "Test Blog",
    "description": "Just another WordPress site",
    "url": "http://example.com",
    ...
}

# Execute an ability with JSON input (required for array values).
$ wp ability run core/get-site-info --input='{"fields":["name","version"]}' --user=admin
{
    "name": "Test Blog",
    "version": "6.9"
}

# Execute an ability with simple string arguments.
$ wp ability run my-plugin/greet --name=World

# Execute and output as YAML.
$ wp ability run core/get-site-info --format=yaml --user=admin
name: Test Blog
description: Just another WordPress site
...

# Execute with input from stdin.
$ echo '{"fields":["name"]}' | wp ability run core/get-site-info --input=- --user=admin
```

### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.

## wp ability validate

Reference: <https://developer.wordpress.org/cli/commands/ability/validate/>

Validates input against an ability's schema.

Validates the input data without executing the ability. Useful for testing input before execution.

### Options

- `<name>` - The ability name (namespace/ability-name format).
- `[--input=<json>]` - JSON string containing input data to validate.
- `[--<field>=<value>]` - Individual input fields to validate.

### Examples

```bash
# Validate input for an ability (use JSON for array values).
$ wp ability validate core/get-site-info --input='{"fields":["name","version"]}'
Success: Input is valid.

# Validate simple string arguments.
$ wp ability validate my-plugin/greet --name=World
Success: Input is valid.

# Validation failure shows error message.
$ wp ability validate core/get-site-info --input='{"fields":"invalid"}'
Error: Ability "core/get-site-info" has invalid input. Reason: ...
```

### Global Parameters

These global parameters have the same behavior across all commands and affect how WP-CLI interacts with WordPress.

- `--path=<path>` - Path to the WordPress files.
- `--url=<url>` - Pretend request came from given URL. In multisite, this argument is how the target site is specified.
- `--ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]` - Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "docker-compose-run", "vagrant").
- `--http=<http>` - Perform operation against a remote WordPress installation over HTTP.
- `--user=<id|login|email>` - Set the WordPress user.
- `--skip-plugins[=<plugins>]` - Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
- `--skip-themes[=<themes>]` - Skip loading all themes, or a comma-separated list of themes.
- `--skip-packages` - Skip loading all installed packages.
- `--require=<path>` - Load PHP file before running the command (may be used more than once).
- `--exec=<php-code>` - Execute PHP code before running the command (may be used more than once).
- `--context=<context>` - Load WordPress in a given context.
- `--[no-]color` - Whether to colorize the output.
- `--debug[=<group>]` - Show all PHP errors and add verbosity to WP-CLI output. Built-in groups include: bootstrap, commandfactory, and help.
- `--prompt[=<assoc>]` - Prompt the user to enter values for all command arguments, or a subset specified as comma-separated values.
- `--quiet` - Suppress informational messages.
