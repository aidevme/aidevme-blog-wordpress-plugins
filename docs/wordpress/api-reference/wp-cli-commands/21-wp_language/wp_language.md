# wp language

Reference: <https://developer.wordpress.org/cli/commands/language/>

## Description

Installs, activates, and manages language packs.

## Synopsis

```bash
wp language <command>
```

## Examples

```bash
# Install the Dutch core language pack.
$ wp language core install nl_NL
Downloading translation from https://downloads.wordpress.org/translation/core/6.4.3/nl_NL.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the translation...
Translation updated successfully.
Language 'nl_NL' installed.
Success: Installed 1 of 1 languages.

# Activate the Dutch core language pack.
$ wp site switch-language nl_NL
Success: Language activated.

# Install the Dutch theme language pack for Twenty Ten.
$ wp language theme install twentyten nl_NL
Downloading translation from https://downloads.wordpress.org/translation/theme/twentyten/4.0/nl_NL.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the translation...
Translation updated successfully.
Language 'nl_NL' installed.
Success: Installed 1 of 1 languages.

# Install the Dutch plugin language pack for Hello Dolly.
$ wp language plugin install hello-dolly nl_NL
Downloading translation from https://downloads.wordpress.org/translation/plugin/hello-dolly/1.7.2/nl_NL.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the translation...
Translation updated successfully.
Language 'nl_NL' installed.
Success: Installed 1 of 1 languages.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp language core](https://developer.wordpress.org/cli/commands/language/core/) | Installs, activates, and manages core language packs. |
| [wp language plugin](https://developer.wordpress.org/cli/commands/language/plugin/) | Installs, activates, and manages plugin language packs. |
| [wp language theme](https://developer.wordpress.org/cli/commands/language/theme/) | Installs, activates, and manages theme language packs. |

### wp language core <command>

Reference: <https://developer.wordpress.org/cli/commands/language/core/>

Installs, activates, and manages core language packs.

#### Examples

```bash
# Install the Dutch core language pack.
$ wp language core install nl_NL
Downloading translation from https://downloads.wordpress.org/translation/core/6.4.3/nl_NL.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the translation...
Translation updated successfully.
Language 'nl_NL' installed.
Success: Installed 1 of 1 languages.

# Activate the Dutch core language pack.
$ wp site switch-language nl_NL
Success: Language activated.

# Uninstall the Dutch core language pack.
$ wp language core uninstall nl_NL
Success: Language uninstalled.

# List installed core language packs.
$ wp language core list --status=installed
+----------+--------------+-------------+-----------+-----------+---------------------+
| language | english_name | native_name | status    | update    | updated             |
+----------+--------------+-------------+-----------+-----------+---------------------+
| nl_NL    | Dutch        | Nederlands  | installed | available | 2024-01-31 10:24:06 |
+----------+--------------+-------------+-----------+-----------+---------------------+
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp language core activate](https://developer.wordpress.org/cli/commands/language/core/activate/) | Activates a given language. |
| [wp language core install](https://developer.wordpress.org/cli/commands/language/core/install/) | Installs a given language. |
| [wp language core is-installed](https://developer.wordpress.org/cli/commands/language/core/is-installed/) | Checks if a given language is installed. |
| [wp language core list](https://developer.wordpress.org/cli/commands/language/core/list/) | Lists all available languages. |
| [wp language core uninstall](https://developer.wordpress.org/cli/commands/language/core/uninstall/) | Uninstalls a given language. |
| [wp language core update](https://developer.wordpress.org/cli/commands/language/core/update/) | Updates installed languages for core. |

#### wp language core activate

Reference: <https://developer.wordpress.org/cli/commands/language/core/activate/>

Activates a given language.

**Warning: `wp language core activate` is deprecated. Use `wp site switch-language` instead.**

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<language>`
  Language code to activate.

##### Examples

```bash
# Activate the given language.
$ wp language core activate ja
Success: Language activated.
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

#### wp language core install

Reference: <https://developer.wordpress.org/cli/commands/language/core/install/>

Installs a given language.

Downloads the language pack from WordPress.org. Find your language code at: https://translate.wordpress.org/

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<language>…`
  Language code to install.
- `[--activate]`
  If set, the language will be activated immediately after install.

##### Examples

```bash
# Install the Brazilian Portuguese language.
$ wp language core install pt_BR
Downloading translation from https://downloads.wordpress.org/translation/core/6.5/pt_BR.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the translation...
Translation updated successfully.
Language 'pt_BR' installed.
Success: Installed 1 of 1 languages.
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

#### wp language core is-installed

Reference: <https://developer.wordpress.org/cli/commands/language/core/is-installed/>

Checks if a given language is installed.

Returns exit code 0 when installed, 1 when uninstalled.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<language>`
  The language code to check.

##### Examples

```bash
# Check whether the German language is installed; exit status 0 if installed, otherwise 1.
$ wp language core is-installed de_DE
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

#### wp language core list

Reference: <https://developer.wordpress.org/cli/commands/language/core/list/>

Lists all available languages.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--field=<field>]`
  Display the value of a single field
- `[--<field>=<value>]`
  Filter results by key=value pairs.
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

##### Available Fields

These fields will be displayed by default for each translation:

- language
- english_name
- native_name
- status
- update
- updated

##### Examples

```bash
# List language,english_name,status fields of available languages.
$ wp language core list --fields=language,english_name,status
+----------------+-------------------------+-------------+
| language       | english_name            | status      |
+----------------+-------------------------+-------------+
| ar             | Arabic                  | uninstalled |
| ary            | Moroccan Arabic         | uninstalled |
| az             | Azerbaijani             | uninstalled |
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

#### wp language core uninstall

Reference: <https://developer.wordpress.org/cli/commands/language/core/uninstall/>

Uninstalls a given language.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<language>…`
  Language code to uninstall.

##### Examples

```bash
# Uninstall the Japanese core language pack.
$ wp language core uninstall ja
Success: Language uninstalled.
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

#### wp language core update

Reference: <https://developer.wordpress.org/cli/commands/language/core/update/>

Updates installed languages for core.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--dry-run]`
  Preview which translations would be updated.

##### Examples

```bash
# Update installed core languages packs.
$ wp language core update
Updating 'Japanese' translation for WordPress 6.4.3...
Downloading translation from https://downloads.wordpress.org/translation/core/6.4.3/ja.zip...
Translation updated successfully.
Success: Updated 1/1 translation.
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

### wp language plugin <command>

Reference: <https://developer.wordpress.org/cli/commands/language/plugin/>

Installs, activates, and manages plugin language packs.

#### Examples

```bash
# Install the Dutch plugin language pack for Hello Dolly.
$ wp language plugin install hello-dolly nl_NL
Downloading translation from https://downloads.wordpress.org/translation/plugin/hello-dolly/1.7.2/nl_NL.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the translation...
Translation updated successfully.
Language 'nl_NL' installed.
Success: Installed 1 of 1 languages.

# Uninstall the Dutch plugin language pack for Hello Dolly.
$ wp language plugin uninstall hello-dolly nl_NL
Language 'nl_NL' for 'hello-dolly' uninstalled.
+-------------+--------+-------------+
| name        | locale | status      |
+-------------+--------+-------------+
| hello-dolly | nl_NL  | uninstalled |
+-------------+--------+-------------+
Success: Uninstalled 1 of 1 languages.

# List installed plugin language packs for Hello Dolly.
$ wp language plugin list hello-dolly --status=installed
+-------------+----------+--------------+-------------+-----------+--------+---------------------+
| plugin      | language | english_name | native_name | status    | update | updated             |
+-------------+----------+--------------+-------------+-----------+--------+---------------------+
| hello-dolly | nl_NL    | Dutch        | Nederlands  | installed | none   | 2023-11-13 12:34:15 |
+-------------+----------+--------------+-------------+-----------+--------+---------------------+
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp language plugin install](https://developer.wordpress.org/cli/commands/language/plugin/install/) | Installs a given language for a plugin. |
| [wp language plugin is-installed](https://developer.wordpress.org/cli/commands/language/plugin/is-installed/) | Checks if a given language is installed. |
| [wp language plugin list](https://developer.wordpress.org/cli/commands/language/plugin/list/) | Lists all available languages for one or more plugins. |
| [wp language plugin uninstall](https://developer.wordpress.org/cli/commands/language/plugin/uninstall/) | Uninstalls a given language for a plugin. |
| [wp language plugin update](https://developer.wordpress.org/cli/commands/language/plugin/update/) | Updates installed languages for one or more plugins. |

#### wp language plugin install

Reference: <https://developer.wordpress.org/cli/commands/language/plugin/install/>

Installs a given language for a plugin.

Downloads the language pack from WordPress.org.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>]`
  Plugin to install language for.
- `[--all]`
  If set, languages for all plugins will be installed.
- `<language>…`
  Language code to install.
- `[--format=<format>]`
  Render output in a particular format. Used when installing languages for all plugins.
  - default: table
  - options:
  - table
  - csv
  - json
  - summary

##### Examples

```bash
# Install the Japanese language for Akismet.
$ wp language plugin install akismet ja
Downloading translation from https://downloads.wordpress.org/translation/plugin/akismet/4.0.3/ja.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the translation...
Translation updated successfully.
Language 'ja' installed.
Success: Installed 1 of 1 languages.
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

#### wp language plugin is-installed

Reference: <https://developer.wordpress.org/cli/commands/language/plugin/is-installed/>

Checks if a given language is installed.

Returns exit code 0 when installed, 1 when uninstalled.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<plugin>`
  Plugin to check for.
- `<language>…`
  The language code to check.

##### Examples

```bash
# Check whether the German language is installed for Akismet; exit status 0 if installed, otherwise 1.
$ wp language plugin is-installed akismet de_DE
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

#### wp language plugin list

Reference: <https://developer.wordpress.org/cli/commands/language/plugin/list/>

Lists all available languages for one or more plugins.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to list languages for.
- `[--all]`
  If set, available languages for all plugins will be listed.
- `[--field=<field>]`
  Display the value of a single field.
- `[--<field>=<value>]`
  Filter results by key=value pairs.
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

##### Available Fields

These fields will be displayed by default for each translation:

- plugin
- language
- english_name
- native_name
- status
- update
- updated

##### Examples

```bash
# List available language packs for the plugin.
$ wp language plugin list hello-dolly --fields=language,english_name,status
+----------------+-------------------------+-------------+
| language       | english_name            | status      |
+----------------+-------------------------+-------------+
| ar             | Arabic                  | uninstalled |
| ary            | Moroccan Arabic         | uninstalled |
| az             | Azerbaijani             | uninstalled |
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

#### wp language plugin uninstall

Reference: <https://developer.wordpress.org/cli/commands/language/plugin/uninstall/>

Uninstalls a given language for a plugin.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>]`
  Plugin to uninstall language for.
- `[--all]`
  If set, languages for all plugins will be uninstalled.
- `<language>…`
  Language code to uninstall.
- `[--format=<format>]`
  Render output in a particular format. Used when installing languages for all plugins.
  - default: table
  - options:
  - table
  - csv
  - json
  - summary

##### Examples

```bash
# Uninstall the Japanese plugin language pack for Hello Dolly.
$ wp language plugin uninstall hello-dolly ja
Language 'ja' for 'hello-dolly' uninstalled.
+-------------+--------+-------------+
| name        | locale | status      |
+-------------+--------+-------------+
| hello-dolly | ja     | uninstalled |
+-------------+--------+-------------+
Success: Uninstalled 1 of 1 languages.
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

#### wp language plugin update

Reference: <https://developer.wordpress.org/cli/commands/language/plugin/update/>

Updates installed languages for one or more plugins.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>…]`
  One or more plugins to update languages for.
- `[--all]`
  If set, languages for all plugins will be updated.
- `[--dry-run]`
  Preview which translations would be updated.

##### Examples

```bash
# Update all installed language packs for all plugins.
$ wp language plugin update --all
Updating 'Japanese' translation for Akismet 3.1.11...
Downloading translation from https://downloads.wordpress.org/translation/plugin/akismet/3.1.11/ja.zip...
Translation updated successfully.
Success: Updated 1/1 translation.
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

### wp language theme <command>

Reference: <https://developer.wordpress.org/cli/commands/language/theme/>

Installs, activates, and manages theme language packs.

#### Examples

```bash
# Install the Dutch theme language pack for Twenty Ten.
$ wp language theme install twentyten nl_NL
Downloading translation from https://downloads.wordpress.org/translation/theme/twentyten/4.0/nl_NL.zip...
Unpacking the update...
Installing the latest version...
Removing the old version of the translation...
Translation updated successfully.
Language 'nl_NL' installed.
Success: Installed 1 of 1 languages.

# Uninstall the Dutch theme language pack for Twenty Ten.
$ wp language theme uninstall twentyten nl_NL
Language 'nl_NL' for 'twentyten' uninstalled.
+-----------+--------+-------------+
| name      | locale | status      |
+-----------+--------+-------------+
| twentyten | nl_NL  | uninstalled |
+-----------+--------+-------------+
Success: Uninstalled 1 of 1 languages.

# List installed theme language packs for Twenty Ten.
$ wp language theme list twentyten --status=installed
+-----------+----------+--------------+-------------+-----------+--------+---------------------+
| theme     | language | english_name | native_name | status    | update | updated             |
+-----------+----------+--------------+-------------+-----------+--------+---------------------+
| twentyten | nl_NL    | Dutch        | Nederlands  | installed | none   | 2023-12-29 21:21:39 |
+-----------+----------+--------------+-------------+-----------+--------+---------------------+
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp language theme install](https://developer.wordpress.org/cli/commands/language/theme/install/) | Installs a given language for a theme. |
| [wp language theme is-installed](https://developer.wordpress.org/cli/commands/language/theme/is-installed/) | Checks if a given language is installed. |
| [wp language theme list](https://developer.wordpress.org/cli/commands/language/theme/list/) | Lists all available languages for one or more themes. |
| [wp language theme uninstall](https://developer.wordpress.org/cli/commands/language/theme/uninstall/) | Uninstalls a given language for a theme. |
| [wp language theme update](https://developer.wordpress.org/cli/commands/language/theme/update/) | Updates installed languages for one or more themes. |

#### wp language theme install

Reference: <https://developer.wordpress.org/cli/commands/language/theme/install/>

Installs a given language for a theme.

Downloads the language pack from WordPress.org.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>]`
  Theme to install language for.
- `[--all]`
  If set, languages for all themes will be installed.
- `<language>…`
  Language code to install.
- `[--format=<format>]`
  Render output in a particular format. Used when installing languages for all themes.
  - default: table
  - options:
  - table
  - csv
  - json
  - summary

##### Examples

```bash
# Install the Japanese language for Twenty Seventeen.
$ wp language theme install twentyseventeen ja
Downloading translation from https://downloads.wordpress.org/translation/theme/twentyseventeen/1.3/ja.zip...
Unpacking the update...
Installing the latest version...
Translation updated successfully.
Language 'ja' installed.
Success: Installed 1 of 1 languages.
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

#### wp language theme is-installed

Reference: <https://developer.wordpress.org/cli/commands/language/theme/is-installed/>

Checks if a given language is installed.

Returns exit code 0 when installed, 1 when uninstalled.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<theme>`
  Theme to check for.
- `<language>…`
  The language code to check.

##### Examples

```bash
# Check whether the German language is installed for Twenty Seventeen; exit status 0 if installed, otherwise 1.
$ wp language theme is-installed twentyseventeen de_DE
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

#### wp language theme list

Reference: <https://developer.wordpress.org/cli/commands/language/theme/list/>

Lists all available languages for one or more themes.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to list languages for.
- `[--all]`
  If set, available languages for all themes will be listed.
- `[--field=<field>]`
  Display the value of a single field.
- `[--<field>=<value>]`
  Filter results by key=value pairs.
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

##### Available Fields

These fields will be displayed by default for each translation:

- theme
- language
- english_name
- native_name
- status
- update
- updated

##### Examples

```bash
# List available language packs for the theme.
$ wp language theme list twentyten --fields=language,english_name,status
+----------------+-------------------------+-------------+
| language       | english_name            | status      |
+----------------+-------------------------+-------------+
| ar             | Arabic                  | uninstalled |
| ary            | Moroccan Arabic         | uninstalled |
| az             | Azerbaijani             | uninstalled |
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

#### wp language theme uninstall

Reference: <https://developer.wordpress.org/cli/commands/language/theme/uninstall/>

Uninstalls a given language for a theme.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>]`
  Theme to uninstall language for.
- `[--all]`
  If set, languages for all themes will be uninstalled.
- `<language>…`
  Language code to uninstall.
- `[--format=<format>]`
  Render output in a particular format. Used when installing languages for all themes.
  - default: table
  - options:
  - table
  - csv
  - json
  - summary

##### Examples

```bash
# Uninstall the Japanese theme language pack for Twenty Ten.
$ wp language theme uninstall twentyten ja
Language 'ja' for 'twentyten' uninstalled.
+-----------+--------+-------------+
| name      | locale | status      |
+-----------+--------+-------------+
| twentyten | ja     | uninstalled |
+-----------+--------+-------------+
Success: Uninstalled 1 of 1 languages.
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

#### wp language theme update

Reference: <https://developer.wordpress.org/cli/commands/language/theme/update/>

Updates installed languages for one or more themes.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>…]`
  One or more themes to update languages for.
- `[--all]`
  If set, languages for all themes will be updated.
- `[--dry-run]`
  Preview which translations would be updated.

##### Examples

```bash
# Update all installed language packs for all themes.
$ wp language theme update --all
Updating 'Japanese' translation for Twenty Fifteen 1.5...
Downloading translation from https://downloads.wordpress.org/translation/theme/twentyfifteen/1.5/ja.zip...
Translation updated successfully.
Success: Updated 1/1 translation.
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
