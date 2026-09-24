# wp option

Reference: <https://developer.wordpress.org/cli/commands/option/>

## Description

Retrieves and sets site options, including plugin and WordPress settings.

## Synopsis

```bash
wp option <command>
```

See the [Plugin Settings API](https://developer.wordpress.org/plugins/settings/settings-api/) and the [Theme Options](https://developer.wordpress.org/themes/customize-api/) for more information on adding customized options.

## Examples

```bash
# Get site URL.
$ wp option get siteurl
http://example.com

# Add option.
$ wp option add my_option foobar
Success: Added 'my_option' option.

# Update option.
$ wp option update my_option '{"foo": "bar"}' --format=json
Success: Updated 'my_option' option.

# Delete option.
$ wp option delete my_option
Success: Deleted 'my_option' option.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp option add](https://developer.wordpress.org/cli/commands/option/add/) | Adds a new option value. |
| [wp option delete](https://developer.wordpress.org/cli/commands/option/delete/) | Deletes an option. |
| [wp option get](https://developer.wordpress.org/cli/commands/option/get/) | Gets the value for an option. |
| [wp option get-autoload](https://developer.wordpress.org/cli/commands/option/get-autoload/) | Gets the 'autoload' value for an option. |
| [wp option list](https://developer.wordpress.org/cli/commands/option/list/) | Lists options and their values. |
| [wp option patch](https://developer.wordpress.org/cli/commands/option/patch/) | Updates a nested value in an option. |
| [wp option pluck](https://developer.wordpress.org/cli/commands/option/pluck/) | Gets a nested value from an option. |
| [wp option set](https://developer.wordpress.org/cli/commands/option/set/) | Updates an option value. |
| [wp option set-autoload](https://developer.wordpress.org/cli/commands/option/set-autoload/) | Sets the 'autoload' value for an option. |
| [wp option update](https://developer.wordpress.org/cli/commands/option/update/) | Updates an option value. |

### wp option add

Reference: <https://developer.wordpress.org/cli/commands/option/add/>

Adds a new option value.

Errors if the option already exists.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  The name of the option to add.
- `[<value>]`
  The value of the option to add. If omitted, the value is read from STDIN.
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json
- `[--autoload=<autoload>]`
  Should this option be automatically loaded.
  - options:
  - 'on'
  - 'off'
  - 'yes'
  - 'no'

#### Examples

```bash
# Create an option by reading a JSON file.
$ wp option add my_option --format=json < config.json
Success: Added 'my_option' option.
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

### wp option delete

Reference: <https://developer.wordpress.org/cli/commands/option/delete/>

Deletes an option.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>…`
  Key for the option.

#### Examples

```bash
# Delete an option.
$ wp option delete my_option
Success: Deleted 'my_option' option.

# Delete multiple options.
$ wp option delete option_one option_two option_three
Success: Deleted 'option_one' option.
Success: Deleted 'option_two' option.
Warning: Could not delete 'option_three' option. Does it exist?
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

### wp option get

Reference: <https://developer.wordpress.org/cli/commands/option/get/>

Gets the value for an option.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the option.
- `[--format=<format>]`
  Get value in a particular format.
  - default: var_export
  - options:
  - var_export
  - json
  - yaml

#### Examples

```bash
# Get option.
$ wp option get home
http://example.com

# Get blog description.
$ wp option get blogdescription
A random blog description

# Get blog name
$ wp option get blogname
A random blog name

# Get admin email.
$ wp option get admin_email
someone@example.com

# Get option in JSON format.
$ wp option get active_plugins --format=json
{"0":"dynamically-dynamic-sidebar\/dynamically-dynamic-sidebar.php","1":"monster-widget\/monster-widget.php","2":"show-current-template\/show-current-template.php","3":"theme-check\/theme-check.php","5":"wordpress-importer\/wordpress-importer.php"}
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

### wp option get-autoload

Reference: <https://developer.wordpress.org/cli/commands/option/get-autoload/>

Gets the 'autoload' value for an option.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  The name of the option to get 'autoload' of.

#### Examples

```bash
# Get the 'autoload' value for an option.
$ wp option get-autoload blogname
yes
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

### wp option list

Reference: <https://developer.wordpress.org/cli/commands/option/list/>

Lists options and their values.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--search=<pattern>]`
  Use wildcards ( * and ? ) to match option name.
- `[--exclude=<pattern>]`
  Pattern to exclude. Use wildcards ( * and ? ) to match option name.
- `[--autoload=<value>]`
  Match only autoload options when value is on, and only not-autoload option when off.
- `[--transients]`
  List only transients. Use `--no-transients` to ignore all transients.
- `[--unserialize]`
  Unserialize option values in output.
- `[--field=<field>]`
  Prints the value of a single field.
- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--format=<format>]`
  The serialization format for the value. total_bytes displays the total size of matching options in bytes.
  - default: table
  - options:
  - table
  - json
  - csv
  - count
  - yaml
  - total_bytes
- `[--orderby=<fields>]`
  Set orderby which field.
  - default: option_id
  - options:
  - option_id
  - option_name
  - option_value
- `[--order=<order>]`
  Set ascending or descending order.
  - default: asc
  - options:
  - asc
  - desc

#### Available Fields

This field will be displayed by default for each matching option:

- option_name
- option_value

These fields are optionally available:

- autoload
- size_bytes

#### Examples

```bash
# Get the total size of all autoload options.
$ wp option list --autoload=on --format=total_bytes
33198

# Find biggest transients.
$ wp option list --search="*_transient_*" --fields=option_name,size_bytes | sort -n -k 2 | tail
option_name size_bytes
_site_transient_timeout_theme_roots 10
_site_transient_theme_roots 76
_site_transient_update_themes   181
_site_transient_update_core 808
_site_transient_update_plugins  6645

# List all options beginning with "i2f_".
$ wp option list --search="i2f_*"
+-------------+--------------+
| option_name | option_value |
+-------------+--------------+
| i2f_version | 0.1.0        |
+-------------+--------------+

# Delete all options beginning with "theme_mods_".
$ wp option list --search="theme_mods_*" --field=option_name | xargs -I % wp option delete %
Success: Deleted 'theme_mods_twentysixteen' option.
Success: Deleted 'theme_mods_twentyfifteen' option.
Success: Deleted 'theme_mods_twentyfourteen' option.
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

### wp option patch

Reference: <https://developer.wordpress.org/cli/commands/option/patch/>

Updates a nested value in an option.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<action>`
  Patch action to perform.
  - options:
  - insert
  - update
  - delete
- `<key>`
  The option name.
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

#### Examples

```bash
# Add 'bar' to the 'foo' key on an option with name 'option_name'
$ wp option patch insert option_name foo bar
Success: Updated 'option_name' option.

# Update the value of 'foo' key to 'new' on an option with name 'option_name'
$ wp option patch update option_name foo new
Success: Updated 'option_name' option.

# Set nested value of 'bar' key to value we have in the patch file on an option with name 'option_name'.
$ wp option patch update option_name foo bar < patch
Success: Updated 'option_name' option.

# Update the value for the key 'not-a-key' which is not exist on an option with name 'option_name'.
$ wp option patch update option_name foo not-a-key new-value
Error: No data exists for key "not-a-key"

# Update the value for the key 'foo' without passing value on an option with name 'option_name'.
$ wp option patch update option_name foo
Error: Please provide value to update.

# Delete the nested key 'bar' under 'foo' key on an option with name 'option_name'.
$ wp option patch delete option_name foo bar
Success: Updated 'option_name' option.
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

### wp option pluck

Reference: <https://developer.wordpress.org/cli/commands/option/pluck/>

Gets a nested value from an option.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  The option name.
- `<key-path>…`
  The name(s) of the keys within the value to locate the value to pluck.
- `[--format=<format>]`
  The output format of the value.
  - default: plaintext
  - options:
  - plaintext
  - json
  - yaml

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

### wp option set

Reference: <https://developer.wordpress.org/cli/commands/option/set/>

Updates an option value.

This is an alias for `wp option update`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  The name of the option to update.
- `[<value>]`
  The new value. If omitted, the value is read from STDIN.
- `[--autoload=<autoload>]`
  Requires WP 4.2. Should this option be automatically loaded.
  - options:
  - 'on'
  - 'off'
  - 'yes'
  - 'no'
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

#### Examples

```bash
# Update an option by reading from a file.
$ wp option update my_option < value.txt
Success: Updated 'my_option' option.

# Update one option on multiple sites using xargs.
$ wp site list --field=url | xargs -n1 -I {} sh -c 'wp --url={} option update my_option my_value'
Success: Updated 'my_option' option.
Success: Updated 'my_option' option.

# Update site blog name.
$ wp option update blogname "Random blog name"
Success: Updated 'blogname' option.

# Update site blog description.
$ wp option update blogdescription "Some random blog description"
Success: Updated 'blogdescription' option.

# Update admin email address.
$ wp option update admin_email someone@example.com
Success: Updated 'admin_email' option.

# Set the default role.
$ wp option update default_role author
Success: Updated 'default_role' option.

# Set the timezone string.
$ wp option update timezone_string "America/New_York"
Success: Updated 'timezone_string' option.
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

### wp option set-autoload

Reference: <https://developer.wordpress.org/cli/commands/option/set-autoload/>

Sets the 'autoload' value for an option.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  The name of the option to set 'autoload' for.
- `<autoload>`
  Should this option be automatically loaded.
  - options:
  - 'on'
  - 'off'
  - 'yes'
  - 'no'

#### Examples

```bash
# Set the 'autoload' value for an option.
$ wp option set-autoload abc_options no
Success: Updated autoload value for 'abc_options' option.
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

### wp option update

Reference: <https://developer.wordpress.org/cli/commands/option/update/>

Updates an option value.

**Alias:** `set`

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  The name of the option to update.
- `[<value>]`
  The new value. If omitted, the value is read from STDIN.
- `[--autoload=<autoload>]`
  Requires WP 4.2. Should this option be automatically loaded.
  - options:
  - 'on'
  - 'off'
  - 'yes'
  - 'no'
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

#### Examples

```bash
# Update an option by reading from a file.
$ wp option update my_option < value.txt
Success: Updated 'my_option' option.

# Update one option on multiple sites using xargs.
$ wp site list --field=url | xargs -n1 -I {} sh -c 'wp --url={} option update my_option my_value'
Success: Updated 'my_option' option.
Success: Updated 'my_option' option.

# Update site blog name.
$ wp option update blogname "Random blog name"
Success: Updated 'blogname' option.

# Update site blog description.
$ wp option update blogdescription "Some random blog description"
Success: Updated 'blogdescription' option.

# Update admin email address.
$ wp option update admin_email someone@example.com
Success: Updated 'admin_email' option.

# Set the default role.
$ wp option update default_role author
Success: Updated 'default_role' option.

# Set the timezone string.
$ wp option update timezone_string "America/New_York"
Success: Updated 'timezone_string' option.
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
