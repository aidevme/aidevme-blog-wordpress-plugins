# wp package

Reference: <https://developer.wordpress.org/cli/commands/package/>

## Description

Lists, installs, and removes WP-CLI packages.

## Synopsis

```bash
wp package <command>
```

Unless overridden, these commands run on the `before_wp_load` hook, just before the WP load process begins. WP-CLI packages are community-maintained projects built on WP-CLI. They can contain WP-CLI commands, but they can also just extend WP-CLI in some way. Learn how to create your own command from the [Commands Cookbook](https://make.wordpress.org/cli/handbook/guides/commands-cookbook/)

## Examples

```bash
# List installed packages.
$ wp package list
+-----------------------+------------------+----------+-----------+----------------+
| name                  | authors          | version  | update    | update_version |
+-----------------------+------------------+----------+-----------+----------------+
| wp-cli/server-command | Daniel Bachhuber | dev-main | available | 2.x-dev        |
+-----------------------+------------------+----------+-----------+----------------+

# Install the latest development version of the package.
$ wp package install wp-cli/server-command
Installing package wp-cli/server-command (dev-main)
Updating /home/person/.wp-cli/packages/composer.json to require the package...
Using Composer to install the package...
---
Loading composer repositories with package information
Updating dependencies
Resolving dependencies through SAT
Dependency resolution completed in 0.005 seconds
Analyzed 732 packages to resolve dependencies
Analyzed 1034 rules to resolve dependencies
 - Installing package
Writing lock file
Generating autoload files
---
Success: Package installed.

# Uninstall package.
$ wp package uninstall wp-cli/server-command
Removing require statement for package 'wp-cli/server-command' from /home/person/.wp-cli/packages/composer.json
Removing repository details from /home/person/.wp-cli/packages/composer.json
Removing package directories and regenerating autoloader...
Success: Uninstalled package.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp package browse](https://developer.wordpress.org/cli/commands/package/browse/) | Browses WP-CLI packages available for installation. |
| [wp package install](https://developer.wordpress.org/cli/commands/package/install/) | Installs a WP-CLI package. |
| [wp package list](https://developer.wordpress.org/cli/commands/package/list/) | Lists installed WP-CLI packages. |
| [wp package path](https://developer.wordpress.org/cli/commands/package/path/) | Gets the path to an installed WP-CLI package, or the package directory. |
| [wp package uninstall](https://developer.wordpress.org/cli/commands/package/uninstall/) | Uninstalls a WP-CLI package. |
| [wp package update](https://developer.wordpress.org/cli/commands/package/update/) | Updates all installed WP-CLI packages to their latest version. |

### wp package browse

Reference: <https://developer.wordpress.org/cli/commands/package/browse/>

Browses WP-CLI packages available for installation.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Lists packages available for installation from the [Package Index](http://wp-cli.org/package-index/). Although the package index will remain in place for backward compatibility reasons, it has been deprecated and will not be updated further. Please refer to https://github.com/wp-cli/ideas/issues/51 to read about its potential replacement.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--fields=<fields>]`
  Limit the output to specific fields. Defaults to all fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - ids
  - json
  - yaml

#### Available Fields

These fields will be displayed by default for each package:

- name
- description
- authors
- version

There are no optionally available fields.

#### Examples

```bash
$ wp package browse --format=yaml
---
10up/mu-migration:
  name: 10up/mu-migration
  description: A set of WP-CLI commands to support the migration of single WordPress instances to multisite
  authors: Nícholas André
  version: dev-main, dev-develop
aaemnnosttv/wp-cli-dotenv-command:
  name: aaemnnosttv/wp-cli-dotenv-command
  description: Dotenv commands for WP-CLI
  authors: Evan Mattson
  version: v0.1, v0.1-beta.1, v0.2, dev-main, dev-dev, dev-develop, dev-tests/behat
aaemnnosttv/wp-cli-http-command:
  name: aaemnnosttv/wp-cli-http-command
  description: WP-CLI command for using the WordPress HTTP API
  authors: Evan Mattson
  version: dev-main
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

### wp package install

Reference: <https://developer.wordpress.org/cli/commands/package/install/>

Installs a WP-CLI package.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Packages are required to be a valid Composer package, and can be specified as:

- Package name from WP-CLI's package index.
- Git URL accessible by the current shell user.
- Path to a directory on the local machine.
- Local or remote .zip file.

Packages are installed to `~/.wp-cli/packages/` by default. Use the `WP_CLI_PACKAGES_DIR` environment variable to provide a custom path. When installing a local directory, WP-CLI simply registers a reference to the directory. If you move or delete the directory, WP-CLI's reference breaks. When installing a .zip file, WP-CLI extracts the package to `~/.wp-cli/packages/local/<package-name>`. If Github token authorization is required, a GitHub Personal Access Token (https://github.com/settings/tokens) can be used. The following command will add a GitHub Personal Access Token to Composer's global configuration: composer config -g github-oauth.github.com <GITHUB_TOKEN> Once this has been added, the value used for <GITHUB_TOKEN> will be used for future authorization requests.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name|git|path|zip>`
  Name, git URL, directory path, or .zip file for the package to install. Names can optionally include a version constraint (e.g. wp-cli/server-command:@stable).
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Install a package hosted at a git URL.
$ wp package install runcommand/hook

# Install the latest stable version.
$ wp package install wp-cli/server-command:@stable

# Install a package hosted at a GitLab.com URL.
$ wp package install https://gitlab.com/foo/wp-cli-bar-command.git

# Install a package in a .zip file.
$ wp package install google-sitemap-generator-cli.zip
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

### wp package list

Reference: <https://developer.wordpress.org/cli/commands/package/list/>

Lists installed WP-CLI packages.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--fields=<fields>]`
  Limit the output to specific fields. Defaults to all fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - ids
  - json
  - yaml

#### Available Fields

These fields will be displayed by default for each package:

- name
- authors
- version
- update
- update_version

These fields are optionally available:

- description

#### Examples

```bash
# List installed packages.
$ wp package list
+-----------------------+------------------+----------+-----------+----------------+
| name                  | authors          | version  | update    | update_version |
+-----------------------+------------------+----------+-----------+----------------+
| wp-cli/server-command | Daniel Bachhuber | dev-main | available | 2.x-dev        |
+-----------------------+------------------+----------+-----------+----------------+
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

### wp package path

Reference: <https://developer.wordpress.org/cli/commands/package/path/>

Gets the path to an installed WP-CLI package, or the package directory.

This command runs on the `before_wp_load` hook, just before the WP load process begins. If you want to contribute to a package, this is a great way to jump to it.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<name>]`
  Name of the package to get the directory for.

#### Examples

```bash
# Get package path.
$ wp package path
/home/person/.wp-cli/packages/

# Get path to an installed package.
$ wp package path wp-cli/server-command
/home/person/.wp-cli/packages/vendor/wp-cli/server-command

# Change directory to package path.
$ cd $(wp package path) && pwd
/home/vagrant/.wp-cli/packages
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

### wp package uninstall

Reference: <https://developer.wordpress.org/cli/commands/package/uninstall/>

Uninstalls a WP-CLI package.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<name>`
  Name of the package to uninstall.
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Uninstall package.
$ wp package uninstall wp-cli/server-command
Removing require statement for package 'wp-cli/server-command' from /home/person/.wp-cli/packages/composer.json
Removing repository details from /home/person/.wp-cli/packages/composer.json
Removing package directories and regenerating autoloader...
Success: Uninstalled package.
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

### wp package update

Reference: <https://developer.wordpress.org/cli/commands/package/update/>

Updates all installed WP-CLI packages to their latest version.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Examples

```bash
$ wp package update
Using Composer to update packages...
---
Loading composer repositories with package information
Updating dependencies
Resolving dependencies through SAT
Dependency resolution completed in 0.074 seconds
Analyzed 1062 packages to resolve dependencies
Analyzed 22383 rules to resolve dependencies
Writing lock file
Generating autoload files
---
Success: Packages updated.
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
