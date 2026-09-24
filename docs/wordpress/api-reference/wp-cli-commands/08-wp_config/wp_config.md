# wp config

Reference: <https://developer.wordpress.org/cli/commands/config/>

## Description

Generates and reads the wp-config.php file.

## Synopsis

```bash
wp config <command>
```

## Examples

```bash
# Create standard wp-config.php file.
$ wp config create --dbname=testing --dbuser=wp --dbpass=securepswd --locale=ro_RO
Success: Generated 'wp-config.php' file.

# List constants and variables defined in wp-config.php file.
$ wp config list
+------------------+------------------------------------------------------------------+----------+
| key              | value                                                            | type     |
+------------------+------------------------------------------------------------------+----------+
| table_prefix     | wp_                                                              | variable |
| DB_NAME          | wp_cli_test                                                      | constant |
| DB_USER          | root                                                             | constant |
| DB_PASSWORD      | root                                                             | constant |
| AUTH_KEY         | r6+@shP1yO&amp;$)1gdu.hl[/j;7Zrvmt~o;#WxSsa0mlQOi24j2cR,7i+QM/#7S:o^ | constant |
| SECURE_AUTH_KEY  | iO-z!_m--YH$Tx2tf/&amp;V,YW*13Z_HiRLqi)d?$o-tMdY+82pK$`T.NYW~iTLW;xp | constant |
+------------------+------------------------------------------------------------------+----------+

# Get wp-config.php file path.
$ wp config path
/home/person/htdocs/project/wp-config.php

# Get the table_prefix as defined in wp-config.php file.
$ wp config get table_prefix
wp_

# Set the WP_DEBUG constant to true.
$ wp config set WP_DEBUG true --raw
Success: Updated the constant 'WP_DEBUG' in the 'wp-config.php' file with the raw value 'true'.

# Delete the COOKIE_DOMAIN constant from the wp-config.php file.
$ wp config delete COOKIE_DOMAIN
Success: Deleted the constant 'COOKIE_DOMAIN' from the 'wp-config.php' file.

# Launch system editor to edit wp-config.php file.
$ wp config edit

# Check whether the DB_PASSWORD constant exists in the wp-config.php file.
$ wp config has DB_PASSWORD
$ echo $?
0

# Assert if MULTISITE is true.
$ wp config is-true MULTISITE
$ echo $?
0

# Get new salts for your wp-config.php file.
$ wp config shuffle-salts
Success: Shuffled the salt keys.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp config create](https://developer.wordpress.org/cli/commands/config/create/) | Generates a wp-config.php file. |
| [wp config delete](https://developer.wordpress.org/cli/commands/config/delete/) | Deletes a specific constant or variable from the wp-config.php file. |
| [wp config edit](https://developer.wordpress.org/cli/commands/config/edit/) | Launches system editor to edit the wp-config.php file. |
| [wp config get](https://developer.wordpress.org/cli/commands/config/get/) | Gets the value of a specific constant or variable defined in wp-config.php file. |
| [wp config has](https://developer.wordpress.org/cli/commands/config/has/) | Checks whether a specific constant or variable exists in the wp-config.php file. |
| [wp config is-true](https://developer.wordpress.org/cli/commands/config/is-true/) | Determines whether value of a specific defined constant or variable is truthy. |
| [wp config list](https://developer.wordpress.org/cli/commands/config/list/) | Lists variables, constants, and file includes defined in wp-config.php file. |
| [wp config path](https://developer.wordpress.org/cli/commands/config/path/) | Gets the path to wp-config.php file. |
| [wp config set](https://developer.wordpress.org/cli/commands/config/set/) | Sets the value of a specific constant or variable defined in wp-config.php file. |
| [wp config shuffle-salts](https://developer.wordpress.org/cli/commands/config/shuffle-salts/) | Refreshes the salts defined in the wp-config.php file. |

### wp config create

Reference: <https://developer.wordpress.org/cli/commands/config/create/>

Generates a wp-config.php file.

Creates a new wp-config.php with database constants, and verifies that the database constants are correct.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `--dbname=<dbname>`
  Set the database name.
- `--dbuser=<dbuser>`
  Set the database user.
- `[--dbpass=<dbpass>]`
  Set the database user password.
- `[--dbhost=<dbhost>]`
  Set the database host.
  - default: localhost
- `[--dbprefix=<dbprefix>]`
  Set the database table prefix.
  - default: wp_
- `[--dbcharset=<dbcharset>]`
  Set the database charset.
  - default: utf8
- `[--dbcollate=<dbcollate>]`
  Set the database collation.
  - default:
- `[--locale=<locale>]`
  Set the WPLANG constant. Defaults to $wp_local_package variable.
- `[--extra-php]`
  If set, the command copies additional PHP code into wp-config.php from STDIN.
- `[--skip-salts]`
  If set, keys and salts won't be generated, but should instead be passed via `--extra-php`.
- `[--skip-check]`
  If set, the database connection is not checked.
- `[--force]`
  Overwrites existing files, if present.
- `[--config-file=<path>]`
  Specify the file path to the config file to be created. Defaults to the root of the WordPress installation and the filename "wp-config.php".
- `[--insecure]`
  Retry API download without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.
- `[--ssl]`
  Use SSL when checking the database connection.

#### Examples

```bash
# Standard wp-config.php file
$ wp config create --dbname=testing --dbuser=wp --dbpass=securepswd --locale=ro_RO
Success: Generated 'wp-config.php' file.

# Enable WP_DEBUG and WP_DEBUG_LOG
$ wp config create --dbname=testing --dbuser=wp --dbpass=securepswd --extra-php <<PHP
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
PHP
Success: Generated 'wp-config.php' file.

# Avoid disclosing password to bash history by reading from password.txt
# Using --prompt=dbpass will prompt for the 'dbpass' argument
$ wp config create --dbname=testing --dbuser=wp --prompt=dbpass < password.txt
Success: Generated 'wp-config.php' file.
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

### wp config delete

Reference: <https://developer.wordpress.org/cli/commands/config/delete/>

Deletes a specific constant or variable from the wp-config.php file.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Name of the wp-config.php constant or variable.
- `[--type=<type>]`
  Type of the config value to delete. Defaults to 'all'.
  - default: all
  - options:
  - constant
  - variable
  - all
- `[--config-file=<path>]`
  Specify the file path to the config file to be modified. Defaults to the root of the WordPress installation and the filename "wp-config.php".

#### Examples

```bash
# Delete the COOKIE_DOMAIN constant from the wp-config.php file.
$ wp config delete COOKIE_DOMAIN
Success: Deleted the constant 'COOKIE_DOMAIN' from the 'wp-config.php' file.
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

### wp config edit

Reference: <https://developer.wordpress.org/cli/commands/config/edit/>

Launches system editor to edit the wp-config.php file.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--config-file=<path>]`
  Specify the file path to the config file to be edited. Defaults to the root of the WordPress installation and the filename "wp-config.php".

#### Examples

```bash
# Launch system editor to edit wp-config.php file
$ wp config edit

# Edit wp-config.php file in a specific editor
$ EDITOR=vim wp config edit
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

### wp config get

Reference: <https://developer.wordpress.org/cli/commands/config/get/>

Gets the value of a specific constant or variable defined in wp-config.php file.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Name of the wp-config.php constant or variable.
- `[--type=<type>]`
  Type of config value to retrieve. Defaults to 'all'.
  - default: all
  - options:
  - constant
  - variable
  - all
- `[--format=<format>]`
  Get value in a particular format. Dotenv is limited to non-object values.
  - default: var_export
  - options:
  - var_export
  - json
  - yaml
  - dotenv
- `[--config-file=<path>]`
  Specify the file path to the config file to be read. Defaults to the root of the WordPress installation and the filename "wp-config.php".

#### Examples

```bash
# Get the table_prefix as defined in wp-config.php file.
$ wp config get table_prefix
wp_
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

### wp config has

Reference: <https://developer.wordpress.org/cli/commands/config/has/>

Checks whether a specific constant or variable exists in the wp-config.php file.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Name of the wp-config.php constant or variable.
- `[--type=<type>]`
  Type of the config value to set. Defaults to 'all'.
  - default: all
  - options:
  - constant
  - variable
  - all
- `[--config-file=<path>]`
  Specify the file path to the config file to be checked. Defaults to the root of the WordPress installation and the filename "wp-config.php".

#### Examples

```bash
# Check whether the DB_PASSWORD constant exists in the wp-config.php file.
$ wp config has DB_PASSWORD
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

### wp config is-true

Reference: <https://developer.wordpress.org/cli/commands/config/is-true/>

Determines whether value of a specific defined constant or variable is truthy.

This command runs on the `before_wp_load` hook, just before the WP load process begins. This determination is made by evaluating the retrieved value via boolval().

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Name of the wp-config.php constant or variable.
- `[--type=<type>]`
  Type of config value to retrieve. Defaults to 'all'.
  - default: all
  - options:
  - constant
  - variable
  - all
- `[--config-file=<path>]`
  Specify the file path to the config file to be read. Defaults to the root of the WordPress installation and the filename "wp-config.php".

#### Examples

```bash
# Assert if MULTISITE is true
$ wp config is-true MULTISITE
$ echo $?
0
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

### wp config list

Reference: <https://developer.wordpress.org/cli/commands/config/list/>

Lists variables, constants, and file includes defined in wp-config.php file.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<filter>…]`
  Name or partial name to filter the list by.
- `[--fields=<fields>]`
  Limit the output to specific fields. Defaults to all fields.
- `[--format=<format>]`
  Render output in a particular format. Dotenv is limited to non-object values.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml
  - dotenv
- `[--strict]`
  Enforce strict matching when a filter is provided.
- `[--config-file=<path>]`
  Specify the file path to the config file to be read. Defaults to the root of the WordPress installation and the filename "wp-config.php".

#### Examples

```bash
# List constants and variables defined in wp-config.php file.
$ wp config list
+------------------+------------------------------------------------------------------+----------+
| key              | value                                                            | type     |
+------------------+------------------------------------------------------------------+----------+
| table_prefix     | wp_                                                              | variable |
| DB_NAME          | wp_cli_test                                                      | constant |
| DB_USER          | root                                                             | constant |
| DB_PASSWORD      | root                                                             | constant |
| AUTH_KEY         | r6+@shP1yO&amp;$)1gdu.hl[/j;7Zrvmt~o;#WxSsa0mlQOi24j2cR,7i+QM/#7S:o^ | constant |
| SECURE_AUTH_KEY  | iO-z!_m--YH$Tx2tf/&amp;V,YW*13Z_HiRLqi)d?$o-tMdY+82pK$`T.NYW~iTLW;xp | constant |
+------------------+------------------------------------------------------------------+----------+

# List only database user and password from wp-config.php file.
$ wp config list DB_USER DB_PASSWORD --strict
+------------------+-------+----------+
| key              | value | type     |
+------------------+-------+----------+
| DB_USER          | root  | constant |
| DB_PASSWORD      | root  | constant |
+------------------+-------+----------+

# List all salts from wp-config.php file.
$ wp config list _SALT
+------------------+------------------------------------------------------------------+----------+
| key              | value                                                            | type     |
+------------------+------------------------------------------------------------------+----------+
| AUTH_SALT        | n:]Xditk+_7>Qi=>BmtZHiH-6/Ecrvl(V5ceeGP:{>?;BT^=[B3-0>,~F5z$(+Q$ | constant |
| SECURE_AUTH_SALT | ?Z/p|XhDw3w}?c.z%|+BAr|(Iv*H%%U+Du&kKR y?cJOYyRVRBeB[2zF-`(&gt;+LCC | constant |
| LOGGED_IN_SALT   | +$@(1{b~Z~s}Cs&gt;8Y]6[m6~TnoCDpE&gt;O%e75u}&amp;6kUH!&gt;q:7uM4lxbB6[1pa_X,q | constant |
| NONCE_SALT       | _x+F li|QL?0OSQns1_JZ{|Ix3Jleox-71km/gifnyz8kmo=w-;@AE8W,(fP&lt;N}2 | constant |
+------------------+------------------------------------------------------------------+----------+
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

### wp config path

Reference: <https://developer.wordpress.org/cli/commands/config/path/>

Gets the path to wp-config.php file.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Examples

```bash
# Get wp-config.php file path
$ wp config path
/home/person/htdocs/project/wp-config.php
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

### wp config set

Reference: <https://developer.wordpress.org/cli/commands/config/set/>

Sets the value of a specific constant or variable defined in wp-config.php file.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Name of the wp-config.php constant or variable.
- `<value>`
  Value to set the wp-config.php constant or variable to.
- `[--add]`
  Add the value if it doesn't exist yet. This is the default behavior, override with –no-add.
- `[--raw]`
  Place the value into the wp-config.php file as is, instead of as a quoted string.
- `[--anchor=<anchor>]`
  Anchor string where additions of new values are anchored around. Defaults to "/* That's all, stop editing!". The special case "EOF" string uses the end of the file as the anchor.
- `[--placement=<placement>]`
  Where to place the new values in relation to the anchor string.
  - default: 'before'
  - options:
  - before
  - after
- `[--separator=<separator>]`
  Separator string to put between an added value and its anchor string. The following escape sequences will be recognized and properly interpreted: '\n' => newline, '\r' => carriage return, '\t' => tab. Defaults to a single EOL ("\n" on *nix and "\r\n" on Windows).
- `[--type=<type>]`
  Type of the config value to set. Defaults to 'all'.
  - default: all
  - options:
  - constant
  - variable
  - all
- `[--config-file=<path>]`
  Specify the file path to the config file to be modified. Defaults to the root of the WordPress installation and the filename "wp-config.php".

#### Examples

```bash
# Set the WP_DEBUG constant to true.
$ wp config set WP_DEBUG true --raw
Success: Updated the constant 'WP_DEBUG' in the 'wp-config.php' file with the raw value 'true'.
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

### wp config shuffle-salts

Reference: <https://developer.wordpress.org/cli/commands/config/shuffle-salts/>

Refreshes the salts defined in the wp-config.php file.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<keys>…]`
  One ore more keys to shuffle. If none are provided, this falls back to the default WordPress Core salt keys.
- `[--force]`
  If an unknown key is requested to be shuffled, add it instead of throwing a warning.
- `[--config-file=<path>]`
  Specify the file path to the config file to be modified. Defaults to the root of the WordPress installation and the filename "wp-config.php".
- `[--insecure]`
  Retry API download without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Get new salts for your wp-config.php file
$ wp config shuffle-salts
Success: Shuffled the salt keys.

# Add a cache key salt to the wp-config.php file
$ wp config shuffle-salts WP_CACHE_KEY_SALT --force
Success: Shuffled the salt keys.
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
