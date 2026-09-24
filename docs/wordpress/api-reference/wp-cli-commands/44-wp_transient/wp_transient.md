# wp transient

Reference: <https://developer.wordpress.org/cli/commands/transient/>

## Description

Adds, gets, and deletes entries in the WordPress Transient Cache.

## Synopsis

```bash
wp transient <command>
```

By default, the transient cache uses the WordPress database to persist values between requests. On a single site installation, values are stored in the `wp_options` table. On a multisite installation, values are stored in the `wp_options` or the `wp_sitemeta` table, depending on use of the `--network` flag. When a persistent object cache drop-in is installed (e.g. Redis or Memcached), the transient cache skips the database and simply wraps the WP Object Cache.

## Examples

```bash
# Set transient.
$ wp transient set sample_key "test data" 3600
Success: Transient added.

# Get transient.
$ wp transient get sample_key
test data

# Delete transient.
$ wp transient delete sample_key
Success: Transient deleted.

# Delete expired transients.
$ wp transient delete --expired
Success: 12 expired transients deleted from the database.

# Delete all transients.
$ wp transient delete --all
Success: 14 transients deleted from the database.

# Delete all site transients.
$ wp transient delete --all --network
Success: 2 transients deleted from the database.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp transient delete](https://developer.wordpress.org/cli/commands/transient/delete/) | Deletes a transient value. |
| [wp transient get](https://developer.wordpress.org/cli/commands/transient/get/) | Gets a transient value. |
| [wp transient list](https://developer.wordpress.org/cli/commands/transient/list/) | Lists transients and their values. |
| [wp transient patch](https://developer.wordpress.org/cli/commands/transient/patch/) | Update a nested value from a transient. |
| [wp transient pluck](https://developer.wordpress.org/cli/commands/transient/pluck/) | Get a nested value from a transient. |
| [wp transient set](https://developer.wordpress.org/cli/commands/transient/set/) | Sets a transient value. |
| [wp transient type](https://developer.wordpress.org/cli/commands/transient/type/) | Determines the type of transients implementation. |

### wp transient delete

Reference: <https://developer.wordpress.org/cli/commands/transient/delete/>

Deletes a transient value.

For a more complete explanation of the transient cache, including the network|site cache, please see docs for `wp transient`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<key>]`
  Key for the transient.
- `[--network]`
  Delete the value of a network|site transient. On single site, this is is a specially-named cache key. On multisite, this is a global cache (instead of local to the site).
- `[--all]`
  Delete all transients.
- `[--expired]`
  Delete all expired transients.

#### Examples

```bash
# Delete transient.
$ wp transient delete sample_key
Success: Transient deleted.

# Delete expired transients.
$ wp transient delete --expired
Success: 12 expired transients deleted from the database.

# Delete expired site transients.
$ wp transient delete --expired --network
Success: 1 expired transient deleted from the database.

# Delete all transients.
$ wp transient delete --all
Success: 14 transients deleted from the database.

# Delete all site transients.
$ wp transient delete --all --network
Success: 2 transients deleted from the database.

# Delete all transients in a multisite.
$ wp transient delete --all --network && wp site list --field=url | xargs -n1 -I % wp --url=% transient delete --all
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

### wp transient get

Reference: <https://developer.wordpress.org/cli/commands/transient/get/>

Gets a transient value.

For a more complete explanation of the transient cache, including the network|site cache, please see docs for `wp transient`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the transient.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml
- `[--network]`
  Get the value of a network|site transient. On single site, this is is a specially-named cache key. On multisite, this is a global cache (instead of local to the site).

#### Examples

```bash
$ wp transient get sample_key
test data

$ wp transient get random_key
Warning: Transient with key "random_key" is not set.
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

### wp transient list

Reference: <https://developer.wordpress.org/cli/commands/transient/list/>

Lists transients and their values.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--search=<pattern>]`
  Use wildcards ( * and ? ) to match transient name.
- `[--exclude=<pattern>]`
  Pattern to exclude. Use wildcards ( * and ? ) to match transient name.
- `[--network]`
  Get the values of network|site transients. On single site, this is a specially-named cache key. On multisite, this is a global cache (instead of local to the site).
- `[--unserialize]`
  Unserialize transient values in output.
- `[--human-readable]`
  Human-readable output for expirations.
- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--format=<format>]`
  The serialization format for the value.
  - default: table
  - options:
  - table
  - json
  - csv
  - count
  - yaml

#### Available Fields

This field will be displayed by default for each matching option:

- name
- value
- expiration

#### Examples

```bash
# List all transients
$ wp transient list
 +------+-------+---------------+
 | name | value | expiration    |
 +------+-------+---------------+
 | foo  | bar   | 39 mins       |
 | foo2 | bar2  | no expiration |
 | foo3 | bar2  | expired       |
 | foo4 | bar4  | 4 hours       |
 +------+-------+---------------+
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

### wp transient patch

Reference: <https://developer.wordpress.org/cli/commands/transient/patch/>

Update a nested value from a transient.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<action>`
  Patch action to perform.
  - options:
  - insert
  - update
  - delete
- `<key>`
  Key for the transient.
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
- `[--expiration=<expiration>]`
  Time until expiration, in seconds.
  - default: 0
- `[--network]`
  Get the value of a network|site transient. On single site, this is a specially-named cache key. On multisite, this is a global cache (instead of local to the site).

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

### wp transient pluck

Reference: <https://developer.wordpress.org/cli/commands/transient/pluck/>

Get a nested value from a transient.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the transient.
- `<key-path>…`
  The name(s) of the keys within the value to locate the value to pluck.
- `[--format=<format>]`
  The output format of the value.
  - default: plaintext
  - options:
  - plaintext
  - json
  - yaml
- `[--network]`
  Get the value of a network|site transient. On single site, this is a specially-named cache key. On multisite, this is a global cache (instead of local to the site).

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

### wp transient set

Reference: <https://developer.wordpress.org/cli/commands/transient/set/>

Sets a transient value.

`<expiration>` is the time until expiration, in seconds. For a more complete explanation of the transient cache, including the network|site cache, please see docs for `wp transient`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<key>`
  Key for the transient.
- `<value>`
  Value to be set for the transient.
- `[<expiration>]`
  Time until expiration, in seconds.
- `[--network]`
  Set the value of a network|site transient. On single site, this is is a specially-named cache key. On multisite, this is a global cache (instead of local to the site).

#### Examples

```bash
$ wp transient set sample_key "test data" 3600
Success: Transient added.
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

### wp transient type

Reference: <https://developer.wordpress.org/cli/commands/transient/type/>

Determines the type of transients implementation.

Indicates whether the transients API is using an object cache or the database. For a more complete explanation of the transient cache, including the network|site cache, please see docs for `wp transient`.

#### Examples

```bash
$ wp transient type
Transients are saved to the database.
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
