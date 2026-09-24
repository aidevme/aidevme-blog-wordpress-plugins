# wp theme

Reference: <https://developer.wordpress.org/cli/commands/theme/>

## Description

Manages themes, including installs, activations, and updates.

## Synopsis

```bash
wp theme <command>
```

See the WordPress [Theme Handbook](https://developer.wordpress.org/themes/) developer resource for more information on themes.

## Examples

```bash
# Install the latest version of a theme from wordpress.org and activate
$ wp theme install twentysixteen --activate
Installing Twenty Sixteen (1.2)
Downloading install package from https://downloads.wordpress.org/theme/twentysixteen.1.2.zip...
Unpacking the package...
Installing the theme...
Theme installed successfully.
Activating 'twentysixteen'...
Success: Switched to 'Twenty Sixteen' theme.
Success: Installed 1 of 1 themes.

# Get details of an installed theme
$ wp theme get twentysixteen --fields=name,title,version
+---------+----------------+
| Field   | Value          |
+---------+----------------+
| name    | Twenty Sixteen |
| title   | Twenty Sixteen |
| version | 1.2            |
+---------+----------------+

# Get status of theme
$ wp theme status twentysixteen
Theme twentysixteen details:
     Name: Twenty Sixteen
     Status: Active
     Version: 1.2
     Author: the WordPress team
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp theme activate](https://developer.wordpress.org/cli/commands/theme/activate/) | Activates a theme. |
| [wp theme auto-updates](https://developer.wordpress.org/cli/commands/theme/auto-updates/) | Manages theme auto-updates. |
| [wp theme delete](https://developer.wordpress.org/cli/commands/theme/delete/) | Deletes one or more themes. |
| [wp theme disable](https://developer.wordpress.org/cli/commands/theme/disable/) | Disables a theme on a WordPress multisite install. |
| [wp theme enable](https://developer.wordpress.org/cli/commands/theme/enable/) | Enables a theme on a WordPress multisite install. |
| [wp theme get](https://developer.wordpress.org/cli/commands/theme/get/) | Gets details about a theme. |
| [wp theme install](https://developer.wordpress.org/cli/commands/theme/install/) | Installs one or more themes. |
| [wp theme is-active](https://developer.wordpress.org/cli/commands/theme/is-active/) | Checks if a given theme is active. |
| [wp theme is-installed](https://developer.wordpress.org/cli/commands/theme/is-installed/) | Checks if a given theme is installed. |
| [wp theme list](https://developer.wordpress.org/cli/commands/theme/list/) | Gets a list of themes. |
| [wp theme mod](https://developer.wordpress.org/cli/commands/theme/mod/) | Sets, gets, and removes theme mods. |
| [wp theme path](https://developer.wordpress.org/cli/commands/theme/path/) | Gets the path to a theme or to the theme directory. |
| [wp theme search](https://developer.wordpress.org/cli/commands/theme/search/) | Searches the WordPress.org theme directory. |
| [wp theme status](https://developer.wordpress.org/cli/commands/theme/status/) | Reveals the status of one or all themes. |
| [wp theme uninstall](https://developer.wordpress.org/cli/commands/theme/uninstall/) | Deletes one or more themes. |
| [wp theme update](https://developer.wordpress.org/cli/commands/theme/update/) | Updates one or more themes. |
| [wp theme upgrade](https://developer.wordpress.org/cli/commands/theme/upgrade/) | Updates one or more themes. |

### wp theme activate

Reference: <https://developer.wordpress.org/cli/commands/theme/activate/>

Activates a theme.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<theme>`
  The theme to activate.

#### Examples

```bash
$ wp theme activate twentysixteen
Success: Switched to 'Twenty Sixteen' theme.
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

### wp theme auto-updates <command>

Reference: <https://developer.wordpress.org/cli/commands/theme/auto-updates/>

Manages theme auto-updates.

#### Examples

```bash
# Enable the auto-updates for a theme
$ wp theme auto-updates enable twentysixteen
Theme auto-updates for 'twentysixteen' enabled.
Success: Enabled 1 of 1 theme auto-updates.

# Disable the auto-updates for a theme
$ wp theme auto-updates disable twentysixteen
Theme auto-updates for 'twentysixteen' disabled.
Success: Disabled 1 of 1 theme auto-updates.

# Get the status of theme auto-updates
$ wp theme auto-updates status twentysixteen
Auto-updates for theme 'twentysixteen' are disabled.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp theme auto-updates disable](https://developer.wordpress.org/cli/commands/theme/auto-updates/disable/) | Disables the auto-updates for a theme. |
| [wp theme auto-updates enable](https://developer.wordpress.org/cli/commands/theme/auto-updates/enable/) | Enables the auto-updates for a theme. |
| [wp theme auto-updates status](https://developer.wordpress.org/cli/commands/theme/auto-updates/status/) | Shows the status of auto-updates for a theme. |

#### wp theme auto-updates disable

Reference: <https://developer.wordpress.org/cli/commands/theme/auto-updates/disable/>

Disables the auto-updates for a theme.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to disable auto-updates for.
- `[--all]`
  If set, auto-updates will be disabled for all themes.
- `[--enabled-only]`
  If set, filters list of themes to only include the ones that have auto-updates enabled.

##### Examples

```bash
# Disable the auto-updates for a theme
$ wp theme auto-updates disable twentysixteen
Theme auto-updates for 'twentysixteen' disabled.
Success: Disabled 1 of 1 theme auto-updates.
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

#### wp theme auto-updates enable

Reference: <https://developer.wordpress.org/cli/commands/theme/auto-updates/enable/>

Enables the auto-updates for a theme.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to enable auto-updates for.
- `[--all]`
  If set, auto-updates will be enabled for all themes.
- `[--disabled-only]`
  If set, filters list of themes to only include the ones that have auto-updates disabled.

##### Examples

```bash
# Enable the auto-updates for a theme
$ wp theme auto-updates enable twentysixteen
Theme auto-updates for 'twentysixteen' enabled.
Success: Enabled 1 of 1 theme auto-updates.
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

#### wp theme auto-updates status

Reference: <https://developer.wordpress.org/cli/commands/theme/auto-updates/status/>

Shows the status of auto-updates for a theme.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to show the status of the auto-updates of.
- `[--all]`
  If set, the status of auto-updates for all themes will be shown.
- `[--enabled-only]`
  If set, filters list of themes to only include the ones that have auto-updates enabled.
- `[--disabled-only]`
  If set, filters list of themes to only include the ones that have auto-updates disabled.
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
# Get the status of theme auto-updates
$ wp theme auto-updates status twentysixteen
+---------------+----------+
| name          | status   |
+---------------+----------+
| twentysixteen | disabled |
+---------------+----------+

# Get the list of themes that have auto-updates enabled
$ wp theme auto-updates status --all --enabled-only --field=name
twentysixteen
twentyseventeen
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

### wp theme delete

Reference: <https://developer.wordpress.org/cli/commands/theme/delete/>

Deletes one or more themes.

**Alias:** `uninstall` Removes the theme or themes from the filesystem.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to delete.
- `[--all]`
  If set, all themes will be deleted except active theme.
- `[--force]`
  To delete active theme use this.

#### Examples

```bash
$ wp theme delete twentytwelve
Deleted 'twentytwelve' theme.
Success: Deleted 1 of 1 themes.
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

### wp theme disable

Reference: <https://developer.wordpress.org/cli/commands/theme/disable/>

Disables a theme on a WordPress multisite install.

Removes ability for a theme to be activated from the dashboard of a site on a WordPress multisite install.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<theme>`
  The theme to disable.
- `[--network]`
  If set, the theme is disabled on the network level. Note that individual sites may still have this theme enabled if it was enabled for them independently.

#### Examples

```bash
# Disable theme
$ wp theme disable twentysixteen
Success: Disabled the 'Twenty Sixteen' theme.

# Disable theme in network level
$ wp theme disable twentysixteen --network
Success: Network disabled the 'Twenty Sixteen' theme.
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

### wp theme enable

Reference: <https://developer.wordpress.org/cli/commands/theme/enable/>

Enables a theme on a WordPress multisite install.

Permits theme to be activated from the dashboard of a site on a WordPress multisite install.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<theme>`
  The theme to enable.
- `[--network]`
  If set, the theme is enabled for the entire network
- `[--activate]`
  If set, the theme is activated for the current site. Note that the "network" flag has no influence on this.

#### Examples

```bash
# Enable theme
$ wp theme enable twentysixteen
Success: Enabled the 'Twenty Sixteen' theme.

# Network enable theme
$ wp theme enable twentysixteen --network
Success: Network enabled the 'Twenty Sixteen' theme.

# Network enable and activate theme for current site
$ wp theme enable twentysixteen --activate
Success: Enabled the 'Twenty Sixteen' theme.
Success: Switched to 'Twenty Sixteen' theme.
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

### wp theme get

Reference: <https://developer.wordpress.org/cli/commands/theme/get/>

Gets details about a theme.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<theme>`
  The theme to get.
- `[--field=<field>]`
  Instead of returning the whole theme, returns the value of a single field.
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
$ wp theme get twentysixteen --fields=name,title,version
+---------+----------------+
| Field   | Value          |
+---------+----------------+
| name    | Twenty Sixteen |
| title   | Twenty Sixteen |
| version | 1.2            |
+---------+----------------+
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

### wp theme install

Reference: <https://developer.wordpress.org/cli/commands/theme/install/>

Installs one or more themes.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<theme|zip|url>…`
  One or more themes to install. Accepts a theme slug, the path to a local zip file, or a URL to a remote zip file.
- `[--version=<version>]`
  If set, get that particular version from wordpress.org, instead of the stable version.
- `[--force]`
  If set, the command will overwrite any installed version of the theme, without prompting for confirmation.
- `[--ignore-requirements]`
  If set, the command will install the theme while ignoring any WordPress or PHP version requirements specified by the theme authors.
- `[--activate]`
  If set, the theme will be activated immediately after install.
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Install the latest version from wordpress.org and activate
$ wp theme install twentysixteen --activate
Installing Twenty Sixteen (1.2)
Downloading install package from https://downloads.wordpress.org/theme/twentysixteen.1.2.zip...
Unpacking the package...
Installing the theme...
Theme installed successfully.
Activating 'twentysixteen'...
Success: Switched to 'Twenty Sixteen' theme.
Success: Installed 1 of 1 themes.

# Install from a local zip file
$ wp theme install ../my-theme.zip

# Install from a remote zip file
$ wp theme install http://s3.amazonaws.com/bucketname/my-theme.zip?AWSAccessKeyId=123&Expires=456&Signature=abcdef
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

### wp theme is-active

Reference: <https://developer.wordpress.org/cli/commands/theme/is-active/>

Checks if a given theme is active.

Returns exit code 0 when active, 1 when not active.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<theme>`
  The plugin to check.

#### Examples

```bash
# Check whether theme is Active; exit status 0 if active, otherwise 1
$ wp theme is-active twentyfifteen
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

### wp theme is-installed

Reference: <https://developer.wordpress.org/cli/commands/theme/is-installed/>

Checks if a given theme is installed.

Returns exit code 0 when installed, 1 when uninstalled.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<theme>`
  The theme to check.

#### Examples

```bash
# Check whether theme is installed; exit status 0 if installed, otherwise 1
$ wp theme is-installed hello
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

### wp theme list

Reference: <https://developer.wordpress.org/cli/commands/theme/list/>

Gets a list of themes.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--<field>=<value>]`
  Filter results based on the value of a field.
- `[--field=<field>]`
  Prints the value of a single field for each theme.
- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - count
  - yaml
- `[--status=<status>]`
  Filter the output by theme status.
  - options:
  - active
  - parent
  - inactive
- `[--skip-update-check]`
  If set, the theme update check will be skipped.

#### Available Fields

These fields will be displayed by default for each theme:

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

#### Examples

```bash
# List inactive themes.
$ wp theme list --status=inactive --format=csv
name,status,update,version,update_version,auto_update
twentyfourteen,inactive,none,3.8,,off
twentysixteen,inactive,available,3.0,3.1,off
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

### wp theme mod <command>

Reference: <https://developer.wordpress.org/cli/commands/theme/mod/>

Sets, gets, and removes theme mods.

#### Examples

```bash
# Set the 'background_color' theme mod to '000000'.
$ wp theme mod set background_color 000000
Success: Theme mod background_color set to 000000.

# Get single theme mod in JSON format.
$ wp theme mod get background_color --format=json
[{"key":"background_color","value":"dd3333"}]

# Remove all theme mods.
$ wp theme mod remove --all
Success: Theme mods removed.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp theme mod get](https://developer.wordpress.org/cli/commands/theme/mod/get/) | Gets one or more theme mods. |
| [wp theme mod list](https://developer.wordpress.org/cli/commands/theme/mod/list/) | Gets a list of theme mods. |
| [wp theme mod remove](https://developer.wordpress.org/cli/commands/theme/mod/remove/) | Removes one or more theme mods. |
| [wp theme mod set](https://developer.wordpress.org/cli/commands/theme/mod/set/) | Sets the value of a theme mod. |

#### wp theme mod get

Reference: <https://developer.wordpress.org/cli/commands/theme/mod/get/>

Gets one or more theme mods.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<mod>…]`
  One or more mods to get.
- `[--field=<field>]`
  Returns the value of a single field.
- `[--all]`
  List all theme mods
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - json
  - csv
  - yaml

##### Examples

```bash
# Get all theme mods.
$ wp theme mod get --all
+------------------+---------+
| key              | value   |
+------------------+---------+
| background_color | dd3333  |
| link_color       | #dd9933 |
| main_text_color  | #8224e3 |
+------------------+---------+

# Get single theme mod in JSON format.
$ wp theme mod get background_color --format=json
[{"key":"background_color","value":"dd3333"}]

# Get value of a single theme mod.
$ wp theme mod get background_color --field=value
dd3333

# Get multiple theme mods.
$ wp theme mod get background_color header_textcolor
+------------------+--------+
| key              | value  |
+------------------+--------+
| background_color | dd3333 |
| header_textcolor |        |
+------------------+--------+
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

#### wp theme mod list

Reference: <https://developer.wordpress.org/cli/commands/theme/mod/list/>

Gets a list of theme mods.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--field=<field>]`
  Returns the value of a single field.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - json
  - csv
  - yaml

##### Examples

```bash
# Gets a list of theme mods.
$ wp theme mod list
+------------------+---------+
| key              | value   |
+------------------+---------+
| background_color | dd3333  |
| link_color       | #dd9933 |
| main_text_color  | #8224e3 |
+------------------+---------+
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

#### wp theme mod remove

Reference: <https://developer.wordpress.org/cli/commands/theme/mod/remove/>

Removes one or more theme mods.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<mod>…]`
  One or more mods to remove.
- `[--all]`
  Remove all theme mods.

##### Examples

```bash
# Remove all theme mods.
$ wp theme mod remove --all
Success: Theme mods removed.

# Remove single theme mod.
$ wp theme mod remove background_color
Success: 1 mod removed.

# Remove multiple theme mods.
$ wp theme mod remove background_color header_textcolor
Success: 2 mods removed.
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

#### wp theme mod set

Reference: <https://developer.wordpress.org/cli/commands/theme/mod/set/>

Sets the value of a theme mod.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<mod>`
  The name of the theme mod to set or update.
- `<value>`
  The new value.

##### Examples

```bash
# Set theme mod
$ wp theme mod set background_color 000000
Success: Theme mod background_color set to 000000.
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

### wp theme path

Reference: <https://developer.wordpress.org/cli/commands/theme/path/>

Gets the path to a theme or to the theme directory.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>]`
  The theme to get the path to. Path includes "style.css" file. If not set, will return the path to the themes directory.
- `[--dir]`
  If set, get the path to the closest parent directory, instead of the theme's "style.css" file.

#### Examples

```bash
# Get theme path
$ wp theme path
/var/www/example.com/public_html/wp-content/themes

# Change directory to theme path
$ cd $(wp theme path)
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

### wp theme search

Reference: <https://developer.wordpress.org/cli/commands/theme/search/>

Searches the WordPress.org theme directory.

Displays themes in the WordPress.org theme directory matching a given search query.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<search>`
  The string to search for.
- `[--page=<page>]`
  Optional page to display.
  - default: 1
- `[--per-page=<per-page>]`
  Optional number of results to display. Defaults to 10.
- `[--field=<field>]`
  Prints the value of a single field for each theme.
- `[--fields=<fields>]`
  Ask for specific fields from the API. Defaults to name,slug,author,rating. Acceptable values:
  **name**: Theme Name
  **slug**: Theme Slug
  **version**: Current Version Number
  **author**: Theme Author
  **preview_url**: Theme Preview URL
  **screenshot_url**: Theme Screenshot URL
  **rating**: Theme Rating
  **num_ratings**: Number of Theme Ratings
  **homepage**: Theme Author's Homepage
  **description**: Theme Description
  **url**: Theme's URL on wordpress.org
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
$ wp theme search photo --per-page=6
Success: Showing 6 of 203 themes.
+----------------------+----------------------+--------+
| name                 | slug                 | rating |
+----------------------+----------------------+--------+
| Photos               | photos               | 100    |
| Infinite Photography | infinite-photography | 100    |
| PhotoBook            | photobook            | 100    |
| BG Photo Frame       | bg-photo-frame       | 0      |
| fPhotography         | fphotography         | 0      |
| Photo Perfect        | photo-perfect        | 98     |
+----------------------+----------------------+--------+
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

### wp theme status

Reference: <https://developer.wordpress.org/cli/commands/theme/status/>

Reveals the status of one or all themes.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>]`
  A particular theme to show the status for.

#### Examples

```bash
$ wp theme status twentysixteen
Theme twentysixteen details:
     Name: Twenty Sixteen
     Status: Inactive
     Version: 1.2
     Author: the WordPress team
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

### wp theme uninstall

Reference: <https://developer.wordpress.org/cli/commands/theme/uninstall/>

Deletes one or more themes.

This is an alias for `wp theme delete`. Removes the theme or themes from the filesystem.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to delete.
- `[--all]`
  If set, all themes will be deleted except active theme.
- `[--force]`
  To delete active theme use this.

#### Examples

```bash
$ wp theme delete twentytwelve
Deleted 'twentytwelve' theme.
Success: Deleted 1 of 1 themes.
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

### wp theme update

Reference: <https://developer.wordpress.org/cli/commands/theme/update/>

Updates one or more themes.

**Alias:** `upgrade`

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to update.
- `[--all]`
  If set, all themes that have updates will be updated.
- `[--exclude=<theme-names>]`
  Comma separated list of theme names that should be excluded from updating.
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
  If set, the theme will be updated to the specified version.
- `[--dry-run]`
  Preview which themes would be updated.
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Update multiple themes
$ wp theme update twentyfifteen twentysixteen
Downloading update from https://downloads.wordpress.org/theme/twentyfifteen.1.5.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the theme...
Theme updated successfully.
Downloading update from https://downloads.wordpress.org/theme/twentysixteen.1.2.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the theme...
Theme updated successfully.
+---------------+-------------+-------------+---------+
| name          | old_version | new_version | status  |
+---------------+-------------+-------------+---------+
| twentyfifteen | 1.4         | 1.5         | Updated |
| twentysixteen | 1.1         | 1.2         | Updated |
+---------------+-------------+-------------+---------+
Success: Updated 2 of 2 themes.

# Exclude themes updates when bulk updating the themes
$ wp theme update --all --exclude=twentyfifteen
Downloading update from https://downloads.wordpress.org/theme/astra.1.0.5.1.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the theme...
Theme updated successfully.
Downloading update from https://downloads.wordpress.org/theme/twentyseventeen.1.2.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the theme...
Theme updated successfully.
+-----------------+----------+---------+----------------+
| name            | status   | version | update_version |
+-----------------+----------+---------+----------------+
| astra           | inactive | 1.0.1   | 1.0.5.1        |
| twentyseventeen | inactive | 1.1     | 1.2            |
+-----------------+----------+---------+----------------+
Success: Updated 2 of 2 themes.

# Update all themes
$ wp theme update --all
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

### wp theme upgrade

Reference: <https://developer.wordpress.org/cli/commands/theme/upgrade/>

Updates one or more themes.

This is an alias for `wp theme update`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to update.
- `[--all]`
  If set, all themes that have updates will be updated.
- `[--exclude=<theme-names>]`
  Comma separated list of theme names that should be excluded from updating.
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
  If set, the theme will be updated to the specified version.
- `[--dry-run]`
  Preview which themes would be updated.
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Update multiple themes
$ wp theme update twentyfifteen twentysixteen
Downloading update from https://downloads.wordpress.org/theme/twentyfifteen.1.5.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the theme...
Theme updated successfully.
Downloading update from https://downloads.wordpress.org/theme/twentysixteen.1.2.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the theme...
Theme updated successfully.
+---------------+-------------+-------------+---------+
| name          | old_version | new_version | status  |
+---------------+-------------+-------------+---------+
| twentyfifteen | 1.4         | 1.5         | Updated |
| twentysixteen | 1.1         | 1.2         | Updated |
+---------------+-------------+-------------+---------+
Success: Updated 2 of 2 themes.

# Exclude themes updates when bulk updating the themes
$ wp theme update --all --exclude=twentyfifteen
Downloading update from https://downloads.wordpress.org/theme/astra.1.0.5.1.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the theme...
Theme updated successfully.
Downloading update from https://downloads.wordpress.org/theme/twentyseventeen.1.2.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the theme...
Theme updated successfully.
+-----------------+----------+---------+----------------+
| name            | status   | version | update_version |
+-----------------+----------+---------+----------------+
| astra           | inactive | 1.0.1   | 1.0.5.1        |
| twentyseventeen | inactive | 1.1     | 1.2            |
+-----------------+----------+---------+----------------+
Success: Updated 2 of 2 themes.

# Update all themes
$ wp theme update --all
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
