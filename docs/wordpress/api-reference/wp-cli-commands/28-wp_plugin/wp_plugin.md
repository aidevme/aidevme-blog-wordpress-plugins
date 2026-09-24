# wp plugin

Reference: <https://developer.wordpress.org/cli/commands/plugin/>

## Description

Manages plugins, including installs, activations, and updates.

## Synopsis

```bash
wp plugin <command>
```

See the WordPress [Plugin Handbook](https://developer.wordpress.org/plugins/) developer resource for more information on plugins.

## Examples

```bash
# Activate plugin
$ wp plugin activate hello
Plugin 'hello' activated.
Success: Activated 1 of 1 plugins.

# Deactivate plugin
$ wp plugin deactivate hello
Plugin 'hello' deactivated.
Success: Deactivated 1 of 1 plugins.

# Delete plugin
$ wp plugin delete hello
Deleted 'hello' plugin.
Success: Deleted 1 of 1 plugins.

# Install the latest version from wordpress.org and activate
$ wp plugin install bbpress --activate
Installing bbPress (2.5.9)
Downloading install package from https://downloads.wordpress.org/plugin/bbpress.2.5.9.zip...
Using cached file '/home/vagrant/.wp-cli/cache/plugin/bbpress-2.5.9.zip'...
Unpacking the package...
Installing the plugin...
Plugin installed successfully.
Activating 'bbpress'...
Plugin 'bbpress' activated.
Success: Installed 1 of 1 plugins.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp plugin activate](https://developer.wordpress.org/cli/commands/plugin/activate/) | Activates one or more plugins. |
| [wp plugin auto-updates](https://developer.wordpress.org/cli/commands/plugin/auto-updates/) | Manages plugin auto-updates. |
| [wp plugin deactivate](https://developer.wordpress.org/cli/commands/plugin/deactivate/) | Deactivates one or more plugins. |
| [wp plugin delete](https://developer.wordpress.org/cli/commands/plugin/delete/) | Deletes plugin files without deactivating or uninstalling. |
| [wp plugin get](https://developer.wordpress.org/cli/commands/plugin/get/) | Gets details about an installed plugin. |
| [wp plugin install](https://developer.wordpress.org/cli/commands/plugin/install/) | Installs one or more plugins. |
| [wp plugin is-active](https://developer.wordpress.org/cli/commands/plugin/is-active/) | Checks if a given plugin is active. |
| [wp plugin is-installed](https://developer.wordpress.org/cli/commands/plugin/is-installed/) | Checks if a given plugin is installed. |
| [wp plugin list](https://developer.wordpress.org/cli/commands/plugin/list/) | Gets a list of plugins. |
| [wp plugin path](https://developer.wordpress.org/cli/commands/plugin/path/) | Gets the path to a plugin or to the plugin directory. |
| [wp plugin search](https://developer.wordpress.org/cli/commands/plugin/search/) | Searches the WordPress.org plugin directory. |
| [wp plugin status](https://developer.wordpress.org/cli/commands/plugin/status/) | Reveals the status of one or all plugins. |
| [wp plugin toggle](https://developer.wordpress.org/cli/commands/plugin/toggle/) | Toggles a plugin's activation state. |
| [wp plugin uninstall](https://developer.wordpress.org/cli/commands/plugin/uninstall/) | Uninstalls one or more plugins. |
| [wp plugin update](https://developer.wordpress.org/cli/commands/plugin/update/) | Updates one or more plugins. |
| [wp plugin upgrade](https://developer.wordpress.org/cli/commands/plugin/upgrade/) | Updates one or more plugins. |
| [wp plugin verify-checksums](https://developer.wordpress.org/cli/commands/plugin/verify-checksums/) | Verifies plugin files against WordPress.org's checksums. |

### wp plugin activate

Reference: <https://developer.wordpress.org/cli/commands/plugin/activate/>

Activates one or more plugins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to activate.
- `[--all]`
  If set, all plugins will be activated.
- `[--exclude=<name>]`
  Comma separated list of plugin slugs to be excluded from activation.
- `[--network]`
  If set, the plugin will be activated for the entire multisite network.

#### Examples

```bash
# Activate plugin
$ wp plugin activate hello
Plugin 'hello' activated.
Success: Activated 1 of 1 plugins.

# Activate plugin in entire multisite network
$ wp plugin activate hello --network
Plugin 'hello' network activated.
Success: Network activated 1 of 1 plugins.

# Activate plugins that were recently active.
$ wp plugin activate $(wp plugin list --recently-active --field=name)
Plugin 'bbpress' activated.
Plugin 'buddypress' activated.
Success: Activated 2 of 2 plugins.

# Activate plugins that were recently active on a multisite.
$ wp plugin activate $(wp plugin list --recently-active --field=name) --network
Plugin 'bbpress' network activated.
Plugin 'buddypress' network activated.
Success: Activated 2 of 2 plugins.
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

### wp plugin auto-updates <command>

Reference: <https://developer.wordpress.org/cli/commands/plugin/auto-updates/>

Manages plugin auto-updates.

#### Examples

```bash
# Enable the auto-updates for a plugin
$ wp plugin auto-updates enable hello
Plugin auto-updates for 'hello' enabled.
Success: Enabled 1 of 1 plugin auto-updates.

# Disable the auto-updates for a plugin
$ wp plugin auto-updates disable hello
Plugin auto-updates for 'hello' disabled.
Success: Disabled 1 of 1 plugin auto-updates.

# Get the status of plugin auto-updates
$ wp plugin auto-updates status hello
Auto-updates for plugin 'hello' are disabled.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp plugin auto-updates disable](https://developer.wordpress.org/cli/commands/plugin/auto-updates/disable/) | Disables the auto-updates for a plugin. |
| [wp plugin auto-updates enable](https://developer.wordpress.org/cli/commands/plugin/auto-updates/enable/) | Enables the auto-updates for a plugin. |
| [wp plugin auto-updates status](https://developer.wordpress.org/cli/commands/plugin/auto-updates/status/) | Shows the status of auto-updates for a plugin. |

#### wp plugin auto-updates disable

Reference: <https://developer.wordpress.org/cli/commands/plugin/auto-updates/disable/>

Disables the auto-updates for a plugin.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to disable auto-updates for.
- `[--all]`
  If set, auto-updates will be disabled for all plugins.
- `[--enabled-only]`
  If set, filters list of plugins to only include the ones that have auto-updates enabled.

##### Examples

```bash
# Disable the auto-updates for a plugin
$ wp plugin auto-updates disable hello
Plugin auto-updates for 'hello' disabled.
Success: Disabled 1 of 1 plugin auto-updates.
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

#### wp plugin auto-updates enable

Reference: <https://developer.wordpress.org/cli/commands/plugin/auto-updates/enable/>

Enables the auto-updates for a plugin.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to enable auto-updates for.
- `[--all]`
  If set, auto-updates will be enabled for all plugins.
- `[--disabled-only]`
  If set, filters list of plugins to only include the ones that have auto-updates disabled.

##### Examples

```bash
# Enable the auto-updates for a plugin
$ wp plugin auto-updates enable hello
Plugin auto-updates for 'hello' enabled.
Success: Enabled 1 of 1 plugin auto-updates.
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

#### wp plugin auto-updates status

Reference: <https://developer.wordpress.org/cli/commands/plugin/auto-updates/status/>

Shows the status of auto-updates for a plugin.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to show the status of the auto-updates of.
- `[--all]`
  If set, the status of auto-updates for all plugins will be shown.
- `[--enabled-only]`
  If set, filters list of plugins to only include the ones that have auto-updates enabled.
- `[--disabled-only]`
  If set, filters list of plugins to only include the ones that have auto-updates disabled.
- `[--field=<field>]`
  Only show the provided field.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml
  - count

##### Examples

```bash
# Get the status of plugin auto-updates
$ wp plugin auto-updates status hello
+-------+----------+
| name  | status   |
+-------+----------+
| hello | disabled |
+-------+----------+

# Get the list of plugins that have auto-updates enabled
$ wp plugin auto-updates status --all --enabled-only --field=name
akismet
duplicate-post
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

### wp plugin deactivate

Reference: <https://developer.wordpress.org/cli/commands/plugin/deactivate/>

Deactivates one or more plugins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to deactivate.
- `[--uninstall]`
  Uninstall the plugin after deactivation.
- `[--all]`
  If set, all plugins will be deactivated.
- `[--exclude=<name>]`
  Comma separated list of plugin slugs that should be excluded from deactivation.
- `[--network]`
  If set, the plugin will be deactivated for the entire multisite network.

#### Examples

```bash
# Deactivate plugin
$ wp plugin deactivate hello
Plugin 'hello' deactivated.
Success: Deactivated 1 of 1 plugins.

# Deactivate all plugins with exclusion
$ wp plugin deactivate --all --exclude=hello,wordpress-seo
Plugin 'contact-form-7' deactivated.
Plugin 'ninja-forms' deactivated.
Success: Deactivated 2 of 2 plugins.
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

### wp plugin delete

Reference: <https://developer.wordpress.org/cli/commands/plugin/delete/>

Deletes plugin files without deactivating or uninstalling.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to delete.
- `[--all]`
  If set, all plugins will be deleted.
- `[--exclude=<name>]`
  Comma separated list of plugin slugs to be excluded from deletion.

#### Examples

```bash
# Delete plugin
$ wp plugin delete hello
Deleted 'hello' plugin.
Success: Deleted 1 of 1 plugins.

# Delete inactive plugins
$ wp plugin delete $(wp plugin list --status=inactive --field=name)
Deleted 'tinymce-templates' plugin.
Success: Deleted 1 of 1 plugins.

# Delete all plugins excluding specified ones
$ wp plugin delete --all --exclude=hello-dolly,jetpack
Deleted 'akismet' plugin.
Deleted 'tinymce-templates' plugin.
Success: Deleted 2 of 2 plugins.
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

### wp plugin get

Reference: <https://developer.wordpress.org/cli/commands/plugin/get/>

Gets details about an installed plugin.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<plugin>`
  The plugin to get.
- `[--field=<field>]`
  Instead of returning the whole plugin, returns the value of a single field.
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

These fields will be displayed by default for the plugin:

- name
- title
- author
- version
- description
- status

These fields are optionally available:

- requires_wp
- requires_php
- requires_plugins

#### Examples

```bash
# Get plugin details.
$ wp plugin get bbpress --format=json
{"name":"bbpress","title":"bbPress","author":"The bbPress Contributors","version":"2.6.9","description":"bbPress is forum software with a twist from the creators of WordPress.","status":"active"}
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

### wp plugin install

Reference: <https://developer.wordpress.org/cli/commands/plugin/install/>

Installs one or more plugins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<plugin|zip|url>…`
  One or more plugins to install. Accepts a plugin slug, the path to a local zip file, or a URL to a remote zip file.
- `[--version=<version>]`
  If set, get that particular version from wordpress.org, instead of the stable version.
- `[--force]`
  If set, the command will overwrite any installed version of the plugin, without prompting for confirmation.
- `[--ignore-requirements]`
  If set, the command will install the plugin while ignoring any WordPress or PHP version requirements specified by the plugin authors.
- `[--activate]`
  If set, the plugin will be activated immediately after install.
- `[--activate-network]`
  If set, the plugin will be network activated immediately after install
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Install the latest version from wordpress.org and activate
$ wp plugin install bbpress --activate
Installing bbPress (2.5.9)
Downloading install package from https://downloads.wordpress.org/plugin/bbpress.2.5.9.zip...
Using cached file '/home/vagrant/.wp-cli/cache/plugin/bbpress-2.5.9.zip'...
Unpacking the package...
Installing the plugin...
Plugin installed successfully.
Activating 'bbpress'...
Plugin 'bbpress' activated.
Success: Installed 1 of 1 plugins.

# Install the development version from wordpress.org
$ wp plugin install bbpress --version=dev
Installing bbPress (Development Version)
Downloading install package from https://downloads.wordpress.org/plugin/bbpress.zip...
Unpacking the package...
Installing the plugin...
Plugin installed successfully.
Success: Installed 1 of 1 plugins.

# Install from a local zip file
$ wp plugin install ../my-plugin.zip
Unpacking the package...
Installing the plugin...
Plugin installed successfully.
Success: Installed 1 of 1 plugins.

# Install from a remote zip file
$ wp plugin install http://s3.amazonaws.com/bucketname/my-plugin.zip?AWSAccessKeyId=123&Expires=456&Signature=abcdef
Downloading install package from http://s3.amazonaws.com/bucketname/my-plugin.zip?AWSAccessKeyId=123&Expires=456&Signature=abcdef
Unpacking the package...
Installing the plugin...
Plugin installed successfully.
Success: Installed 1 of 1 plugins.

# Update from a remote zip file
$ wp plugin install https://github.com/envato/wp-envato-market/archive/master.zip --force
Downloading install package from https://github.com/envato/wp-envato-market/archive/master.zip
Unpacking the package...
Installing the plugin...
Renamed Github-based project from 'wp-envato-market-master' to 'wp-envato-market'.
Plugin updated successfully
Success: Installed 1 of 1 plugins.

# Forcefully re-install all installed plugins
$ wp plugin install $(wp plugin list --field=name) --force
Installing Akismet (3.1.11)
Downloading install package from https://downloads.wordpress.org/plugin/akismet.3.1.11.zip...
Unpacking the package...
Installing the plugin...
Removing the old version of the plugin...
Plugin updated successfully
Success: Installed 1 of 1 plugins.
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

### wp plugin is-active

Reference: <https://developer.wordpress.org/cli/commands/plugin/is-active/>

Checks if a given plugin is active.

Returns exit code 0 when active, 1 when not active.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<plugin>`
  The plugin to check.
- `[--network]`
  If set, check if plugin is network-activated.

#### Examples

```bash
# Check whether plugin is Active; exit status 0 if active, otherwise 1
$ wp plugin is-active hello
$ echo $?
1
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

### wp plugin is-installed

Reference: <https://developer.wordpress.org/cli/commands/plugin/is-installed/>

Checks if a given plugin is installed.

Returns exit code 0 when installed, 1 when uninstalled.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<plugin>`
  The plugin to check.

#### Examples

```bash
# Check whether plugin is installed; exit status 0 if installed, otherwise 1
$ wp plugin is-installed hello
$ echo $?
1
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

### wp plugin list

Reference: <https://developer.wordpress.org/cli/commands/plugin/list/>

Gets a list of plugins.

Displays a list of the plugins installed on the site with activation status, whether or not there's an update available, etc. Use `--status=dropin` to list installed dropins (e.g. `object-cache.php`).

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--<field>=<value>]`
  Filter results based on the value of a field.
- `[--field=<field>]`
  Prints the value of a single field for each plugin.
- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - count
  - json
  - yaml
- `[--status=<status>]`
  Filter the output by plugin status.
  - options:
  - active
  - active-network
  - dropin
  - inactive
  - must-use
- `[--skip-update-check]`
  If set, the plugin update check will be skipped.
- `[--recently-active]`
  If set, only recently active plugins will be shown and the status filter will be ignored.

#### Available Fields

These fields will be displayed by default for each plugin:

- name
- status
- update
- version
- update_version
- auto_update

These fields are optionally available:

- update_package
- update_id
- title
- description
- file
- author
- tested_up_to
- requires
- requires_php
- wporg_status
- wporg_last_updated

#### Examples

```bash
# List active plugins on the site.
$ wp plugin list --status=active --format=json
[{"name":"dynamic-hostname","status":"active","update":"none","version":"0.4.2","update_version":"","auto_update":"off"},{"name":"tinymce-templates","status":"active","update":"none","version":"4.8.1","update_version":"","auto_update":"off"},{"name":"wp-multibyte-patch","status":"active","update":"none","version":"2.9","update_version":"","auto_update":"off"},{"name":"wp-total-hacks","status":"active","update":"none","version":"4.7.2","update_version":"","auto_update":"off"}]

# List plugins on each site in a network.
$ wp site list --field=url | xargs -I % wp plugin list --url=%
+---------+----------------+-----------+---------+-----------------+------------+
| name    | status         | update    | version | update_version | auto_update |
+---------+----------------+-----------+---------+----------------+-------------+
| akismet | active-network | none      | 5.3.1   |                | on          |
| hello   | inactive       | available | 1.6     | 1.7.2          | off         |
+---------+----------------+-----------+---------+----------------+-------------+
+---------+----------------+-----------+---------+----------------+-------------+
| name    | status         | update    | version | update_version | auto_update |
+---------+----------------+-----------+---------+----------------+-------------+
| akismet | active-network | none      | 5.3.1   |                | on          |
| hello   | inactive       | available | 1.6     | 1.7.2          | off         |
+---------+----------------+-----------+---------+----------------+-------------+

# Check whether plugins are still active on WordPress.org
$ wp plugin list --fields=name,wporg_status,wporg_last_updated
+--------------------+--------------+--------------------+
| name               | wporg_status | wporg_last_updated |
+--------------------+--------------+--------------------+
| akismet            | active       | 2023-12-11         |
| user-switching     | active       | 2023-11-17         |
| wordpress-importer | active       | 2023-04-28         |
| local              |              |                    |
+--------------------+--------------+--------------------+

# List recently active plugins on the site.
$ wp plugin list --recently-active --field=name --format=json
["akismet","bbpress","buddypress"]
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

### wp plugin path

Reference: <https://developer.wordpress.org/cli/commands/plugin/path/>

Gets the path to a plugin or to the plugin directory.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>]`
  The plugin to get the path to. If not set, will return the path to the plugins directory.
- `[--dir]`
  If set, get the path to the closest parent directory, instead of the plugin file.

#### Examples

```bash
$ cd $(wp plugin path) && pwd
/var/www/wordpress/wp-content/plugins
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

### wp plugin search

Reference: <https://developer.wordpress.org/cli/commands/plugin/search/>

Searches the WordPress.org plugin directory.

Displays plugins in the WordPress.org plugin directory matching a given search query.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<search>`
  The string to search for.
- `[--page=<page>]`
  Optional page to display.
  - default: 1
- `[--per-page=<per-page>]`
  Optional number of results to display.
  - default: 10
- `[--field=<field>]`
  Prints the value of a single field for each plugin.
- `[--fields=<fields>]`
  Ask for specific fields from the API. Defaults to name,slug,author_profile,rating. Acceptable values:
  **name**: Plugin Name
  **slug**: Plugin Slug
  **version**: Current Version Number
  **author**: Plugin Author
  **author_profile**: Plugin Author Profile
  **contributors**: Plugin Contributors
  **requires**: Plugin Minimum Requirements
  **tested**: Plugin Tested Up To
  **compatibility**: Plugin Compatible With
  **rating**: Plugin Rating in Percent and Total Number
  **ratings**: Plugin Ratings for each star (1-5)
  **num_ratings**: Number of Plugin Ratings
  **homepage**: Plugin Author's Homepage
  **description**: Plugin's Description
  **short_description**: Plugin's Short Description
  **sections**: Plugin Readme Sections: description, installation, FAQ, screenshots, other notes, and changelog
  **downloaded**: Plugin Download Count
  **last_updated**: Plugin's Last Update
  **added**: Plugin's Date Added to wordpress.org Repository
  **tags**: Plugin's Tags
  **versions**: Plugin's Available Versions with D/L Link
  **donate_link**: Plugin's Donation Link
  **banners**: Plugin's Banner Image Link
  **icons**: Plugin's Icon Image Link
  **active_installs**: Plugin's Number of Active Installs
  **contributors**: Plugin's List of Contributors
  **url**: Plugin's URL on wordpress.org
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - count
  - json
  - yaml

#### Examples

```bash
$ wp plugin search dsgnwrks --per-page=20 --format=json
Success: Showing 3 of 3 plugins.
[{"name":"DsgnWrks Instagram Importer Debug","slug":"dsgnwrks-instagram-importer-debug","rating":0},{"name":"DsgnWrks Instagram Importer","slug":"dsgnwrks-instagram-importer","rating":84},{"name":"DsgnWrks Twitter Importer","slug":"dsgnwrks-twitter-importer","rating":80}]

$ wp plugin search dsgnwrks --fields=name,version,slug,rating,num_ratings
Success: Showing 3 of 3 plugins.
+-----------------------------------+---------+-----------------------------------+--------+-------------+
| name                              | version | slug                              | rating | num_ratings |
+-----------------------------------+---------+-----------------------------------+--------+-------------+
| DsgnWrks Instagram Importer Debug | 0.1.6   | dsgnwrks-instagram-importer-debug | 0      | 0           |
| DsgnWrks Instagram Importer       | 1.3.7   | dsgnwrks-instagram-importer       | 84     | 23          |
| DsgnWrks Twitter Importer         | 1.1.1   | dsgnwrks-twitter-importer         | 80     | 1           |
+-----------------------------------+---------+-----------------------------------+--------+-------------+
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

### wp plugin status

Reference: <https://developer.wordpress.org/cli/commands/plugin/status/>

Reveals the status of one or all plugins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>]`
  A particular plugin to show the status for.

#### Examples

```bash
# Displays status of all plugins
$ wp plugin status
5 installed plugins:
  I akismet                3.1.11
  I easy-digital-downloads 2.5.16
  A theme-check            20160523.1
  I wen-logo-slider        2.0.3
  M ns-pack                1.0.0
Legend: I = Inactive, A = Active, M = Must Use

# Displays status of a plugin
$ wp plugin status theme-check
Plugin theme-check details:
    Name: Theme Check
    Status: Active
    Version: 20160523.1
    Author: Otto42, pross
    Description: A simple and easy way to test your theme for all the latest WordPress standards and practices. A great theme development tool!
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

### wp plugin toggle

Reference: <https://developer.wordpress.org/cli/commands/plugin/toggle/>

Toggles a plugin's activation state.

If the plugin is active, then it will be deactivated. If the plugin is inactive, then it will be activated.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<plugin>…`
  One or more plugins to toggle.
- `[--network]`
  If set, the plugin will be toggled for the entire multisite network.

#### Examples

```bash
# Akismet is currently activated
$ wp plugin toggle akismet
Plugin 'akismet' deactivated.
Success: Toggled 1 of 1 plugins.

# Akismet is currently deactivated
$ wp plugin toggle akismet
Plugin 'akismet' activated.
Success: Toggled 1 of 1 plugins.
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

### wp plugin uninstall

Reference: <https://developer.wordpress.org/cli/commands/plugin/uninstall/>

Uninstalls one or more plugins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to uninstall.
- `[--deactivate]`
  Deactivate the plugin before uninstalling. Default behavior is to warn and skip if the plugin is active.
- `[--skip-delete]`
  If set, the plugin files will not be deleted. Only the uninstall procedure will be run.
- `[--all]`
  If set, all plugins will be uninstalled.
- `[--exclude=<name>]`
  Comma separated list of plugin slugs to be excluded from uninstall.

#### Examples

```bash
$ wp plugin uninstall hello
Uninstalled and deleted 'hello' plugin.
Success: Uninstalled 1 of 1 plugins.

# Uninstall all plugins excluding specified ones
$ wp plugin uninstall --all --exclude=hello-dolly,jetpack
Uninstalled and deleted 'akismet' plugin.
Uninstalled and deleted 'tinymce-templates' plugin.
Success: Uninstalled 2 of 2 plugins.
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

### wp plugin update

Reference: <https://developer.wordpress.org/cli/commands/plugin/update/>

Updates one or more plugins.

**Alias:** `upgrade`

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to update.
- `[--all]`
  If set, all plugins that have updates will be updated.
- `[--exclude=<name>]`
  Comma separated list of plugin names that should be excluded from updating.
- `[--minor]`
  Only perform updates for minor releases (e.g. from 1.3 to 1.4 instead of 2.0)
- `[--patch]`
  Only perform updates for patch releases (e.g. from 1.3 to 1.3.3 instead of 1.4)
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - summary
- `[--version=<version>]`
  If set, the plugin will be updated to the specified version.
- `[--dry-run]`
  Preview which plugins would be updated.
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
$ wp plugin update bbpress --version=dev
Installing bbPress (Development Version)
Downloading install package from https://downloads.wordpress.org/plugin/bbpress.zip...
Unpacking the package...
Installing the plugin...
Removing the old version of the plugin...
Plugin updated successfully.
Success: Updated 1 of 2 plugins.

$ wp plugin update --all
Enabling Maintenance mode...
Downloading update from https://downloads.wordpress.org/plugin/akismet.3.1.11.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the plugin...
Plugin updated successfully.
Downloading update from https://downloads.wordpress.org/plugin/nginx-champuru.3.2.0.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the plugin...
Plugin updated successfully.
Disabling Maintenance mode...
+------------------------+-------------+-------------+---------+
| name                   | old_version | new_version | status  |
+------------------------+-------------+-------------+---------+
| akismet                | 3.1.3       | 3.1.11      | Updated |
| nginx-cache-controller | 3.1.1       | 3.2.0       | Updated |
+------------------------+-------------+-------------+---------+
Success: Updated 2 of 2 plugins.

$ wp plugin update --all --exclude=akismet
Enabling Maintenance mode...
Downloading update from https://downloads.wordpress.org/plugin/nginx-champuru.3.2.0.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the plugin...
Plugin updated successfully.
Disabling Maintenance mode...
+------------------------+-------------+-------------+---------+
| name                   | old_version | new_version | status  |
+------------------------+-------------+-------------+---------+
| nginx-cache-controller | 3.1.1       | 3.2.0       | Updated |
+------------------------+-------------+-------------+---------+
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

### wp plugin upgrade

Reference: <https://developer.wordpress.org/cli/commands/plugin/upgrade/>

Updates one or more plugins.

This is an alias for `wp plugin update`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to update.
- `[--all]`
  If set, all plugins that have updates will be updated.
- `[--exclude=<name>]`
  Comma separated list of plugin names that should be excluded from updating.
- `[--minor]`
  Only perform updates for minor releases (e.g. from 1.3 to 1.4 instead of 2.0)
- `[--patch]`
  Only perform updates for patch releases (e.g. from 1.3 to 1.3.3 instead of 1.4)
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - summary
- `[--version=<version>]`
  If set, the plugin will be updated to the specified version.
- `[--dry-run]`
  Preview which plugins would be updated.
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
$ wp plugin update bbpress --version=dev
Installing bbPress (Development Version)
Downloading install package from https://downloads.wordpress.org/plugin/bbpress.zip...
Unpacking the package...
Installing the plugin...
Removing the old version of the plugin...
Plugin updated successfully.
Success: Updated 1 of 2 plugins.

$ wp plugin update --all
Enabling Maintenance mode...
Downloading update from https://downloads.wordpress.org/plugin/akismet.3.1.11.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the plugin...
Plugin updated successfully.
Downloading update from https://downloads.wordpress.org/plugin/nginx-champuru.3.2.0.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the plugin...
Plugin updated successfully.
Disabling Maintenance mode...
+------------------------+-------------+-------------+---------+
| name                   | old_version | new_version | status  |
+------------------------+-------------+-------------+---------+
| akismet                | 3.1.3       | 3.1.11      | Updated |
| nginx-cache-controller | 3.1.1       | 3.2.0       | Updated |
+------------------------+-------------+-------------+---------+
Success: Updated 2 of 2 plugins.

$ wp plugin update --all --exclude=akismet
Enabling Maintenance mode...
Downloading update from https://downloads.wordpress.org/plugin/nginx-champuru.3.2.0.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the plugin...
Plugin updated successfully.
Disabling Maintenance mode...
+------------------------+-------------+-------------+---------+
| name                   | old_version | new_version | status  |
+------------------------+-------------+-------------+---------+
| nginx-cache-controller | 3.1.1       | 3.2.0       | Updated |
+------------------------+-------------+-------------+---------+
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

### wp plugin verify-checksums

Reference: <https://developer.wordpress.org/cli/commands/plugin/verify-checksums/>

Verifies plugin files against WordPress.org's checksums.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to verify.
- `[--all]`
  If set, all plugins will be verified.
- `[--strict]`
  If set, even "soft changes" like readme.txt changes will trigger checksum errors.
- `[--version=<version>]`
  Verify checksums against a specific plugin version.
- `[--format=<format>]`
  Render output in a specific format.
  - default: table
  - options:
  - table
  - json
  - csv
  - yaml
  - count
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.
- `[--exclude=<name>]`
  Comma separated list of plugin names that should be excluded from verifying.

#### Examples

```bash
# Verify the checksums of all installed plugins
$ wp plugin verify-checksums --all
Success: Verified 8 of 8 plugins.

# Verify the checksums of a single plugin, Akismet in this case
$ wp plugin verify-checksums akismet
Success: Verified 1 of 1 plugins.
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
