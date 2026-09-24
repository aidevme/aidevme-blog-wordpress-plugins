# wp scaffold

Reference: <https://developer.wordpress.org/cli/commands/scaffold/>

## Description

Generates code for post types, taxonomies, plugins, child themes, etc.

## Synopsis

```bash
wp scaffold <command>
```

## Examples

```bash
# Generate a new plugin with unit tests.
$ wp scaffold plugin sample-plugin
Success: Created plugin files.
Success: Created test files.

# Generate theme based on _s.
$ wp scaffold _s sample-theme --theme_name="Sample Theme" --author="John Doe"
Success: Created theme 'Sample Theme'.

# Generate code for post type registration in given theme.
$ wp scaffold post-type movie --label=Movie --theme=simple-life
Success: Created '/var/www/example.com/public_html/wp-content/themes/simple-life/post-types/movie.php'.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp scaffold block](https://developer.wordpress.org/cli/commands/scaffold/block/) | Generates PHP, JS and CSS code for registering a Gutenberg block for a plugin or theme. |
| [wp scaffold child-theme](https://developer.wordpress.org/cli/commands/scaffold/child-theme/) | Generates child theme based on an existing theme. |
| [wp scaffold cpt](https://developer.wordpress.org/cli/commands/scaffold/cpt/) | Generates PHP code for registering a custom post type. |
| [wp scaffold package](https://developer.wordpress.org/cli/commands/scaffold/package/) | Generate the files needed for a basic WP-CLI command. |
| [wp scaffold package-github](https://developer.wordpress.org/cli/commands/scaffold/package-github/) | Generate GitHub configuration files for your command. |
| [wp scaffold package-readme](https://developer.wordpress.org/cli/commands/scaffold/package-readme/) | Generate a README.md for your command. |
| [wp scaffold package-tests](https://developer.wordpress.org/cli/commands/scaffold/package-tests/) | Generate files for writing Behat tests for your command. |
| [wp scaffold plugin](https://developer.wordpress.org/cli/commands/scaffold/plugin/) | Generates starter code for a plugin. |
| [wp scaffold plugin-tests](https://developer.wordpress.org/cli/commands/scaffold/plugin-tests/) | Generates files needed for running PHPUnit tests in a plugin. |
| [wp scaffold post-type](https://developer.wordpress.org/cli/commands/scaffold/post-type/) | Generates PHP code for registering a custom post type. |
| [wp scaffold tax](https://developer.wordpress.org/cli/commands/scaffold/tax/) | Generates PHP code for registering a custom taxonomy. |
| [wp scaffold taxonomy](https://developer.wordpress.org/cli/commands/scaffold/taxonomy/) | Generates PHP code for registering a custom taxonomy. |
| [wp scaffold theme-tests](https://developer.wordpress.org/cli/commands/scaffold/theme-tests/) | Generates files needed for running PHPUnit tests in a theme. |
| [wp scaffold underscores](https://developer.wordpress.org/cli/commands/scaffold/underscores/) | Generates starter code for a theme based on _s. |
| [wp scaffold _s](https://developer.wordpress.org/cli/commands/scaffold/_s/) | Generates starter code for a theme based on _s. |

### wp scaffold block

Reference: <https://developer.wordpress.org/cli/commands/scaffold/block/>

Generates PHP, JS and CSS code for registering a Gutenberg block for a plugin or theme.

**Warning: `wp scaffold block` is deprecated.** The official script to generate a block is the [@wordpress/create-block](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/) package. See the [Create a Block tutorial](https://developer.wordpress.org/block-editor/getting-started/tutorial/) for a complete walk-through.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The internal name of the block.
- `[--title=<title>]`
  The display title for your block.
- `[--dashicon=<dashicon>]`
  The dashicon to make it easier to identify your block.
- `[--category=<category>]`
  The category name to help users browse and discover your block.
  - default: widgets
  - options:
  - common
  - embed
  - formatting
  - layout
  - widgets
- `[--theme]`
  Create files in the active theme directory. Specify a theme with `--theme=<theme>` to have the file placed in that theme.
- `[--plugin=<plugin>]`
  Create files in the given plugin's directory.
- `[--force]`
  Overwrite files that already exist.

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

### wp scaffold child-theme

Reference: <https://developer.wordpress.org/cli/commands/scaffold/child-theme/>

Generates child theme based on an existing theme.

Creates a child theme folder with `functions.php` and `style.css` files.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The slug for the new child theme.
- `--parent_theme=<slug>`
  What to put in the 'Template:' header in 'style.css'.
- `[--theme_name=<title>]`
  What to put in the 'Theme Name:' header in 'style.css'.
- `[--author=<full-name>]`
  What to put in the 'Author:' header in 'style.css'.
- `[--author_uri=<uri>]`
  What to put in the 'Author URI:' header in 'style.css'.
- `[--theme_uri=<uri>]`
  What to put in the 'Theme URI:' header in 'style.css'.
- `[--activate]`
  Activate the newly created child theme.
- `[--enable-network]`
  Enable the newly created child theme for the entire network.
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate a 'sample-theme' child theme based on TwentySixteen
$ wp scaffold child-theme sample-theme --parent_theme=twentysixteen
Success: Created '/var/www/example.com/public_html/wp-content/themes/sample-theme'.
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

### wp scaffold cpt

Reference: <https://developer.wordpress.org/cli/commands/scaffold/cpt/>

Generates PHP code for registering a custom post type.

This is an alias for `wp scaffold post-type`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The internal name of the post type.
- `[--label=<label>]`
  The text used to translate the update messages.
- `[--textdomain=<textdomain>]`
  The textdomain to use for the labels.
- `[--dashicon=<dashicon>]`
  The dashicon to use in the menu.
- `[--theme]`
  Create a file in the active theme directory, instead of sending to STDOUT. Specify a theme with `--theme=<theme>` to have the file placed in that theme.
- `[--plugin=<plugin>]`
  Create a file in the given plugin's directory, instead of sending to STDOUT.
- `[--raw]`
  Just generate the `register_post_type()` call and nothing else.
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate a 'movie' post type for the 'simple-life' theme
$ wp scaffold post-type movie --label=Movie --theme=simple-life
Success: Created '/var/www/example.com/public_html/wp-content/themes/simple-life/post-types/movie.php'.
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

### wp scaffold package

Reference: <https://developer.wordpress.org/cli/commands/scaffold/package/>

Generate the files needed for a basic WP-CLI command.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Default behavior is to create the following files: – command.php – composer.json (with package name, description, and license) – .gitignore, .editorconfig, and .distignore – README.md (via wp scaffold package-readme) – Test harness (via wp scaffold package-tests) Unless specified with `--dir=&lt;dir&gt;`, the command package is placed in the WP-CLI `packages/local/` directory.

#### Installing

Use the `wp scaffold package` command by installing the command's package:

```bash
wp package install wp-cli/scaffold-package-command
```

Once the package is successfully installed, the `wp scaffold package` command will appear in the list of available commands.

#### Options

- `<name>`
  Name for the new package. Expects <author>/<package> (e.g. 'wp-cli/scaffold-package').
- `[--description=<description>]`
  Human-readable description for the package.
- `[--homepage=<homepage>]`
  Homepage for the package. Defaults to 'https://github.com/<name>'
- `[--dir=<dir>]`
  Specify a destination directory for the command. Defaults to WP-CLI's `packages/local/` directory.
- `[--license=<license>]`
  License for the package.
  - default: MIT
- `[--require_wp_cli=<version>]`
  Required WP-CLI version for the package.
  - default: ^2.5
- `[--require_wp_cli_tests=<version>]`
  Required WP-CLI testing framework version for the package.
  - default: ^3.0.11
- `[--skip-tests]`
  Don't generate files for integration testing.
- `[--skip-readme]`
  Don't generate a README.md for the package.
- `[--skip-github]`
  Don't generate GitHub issue and pull request templates.
- `[--skip-install]`
  Don't install the package after scaffolding.
- `[--force]`
  Overwrite files that already exist.

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

### wp scaffold package-github

Reference: <https://developer.wordpress.org/cli/commands/scaffold/package-github/>

Generate GitHub configuration files for your command.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Creates a variety of files to better manage your project on GitHub. These files include:

- `.github/ISSUE_TEMPLATE` – Text displayed when a user opens a new issue.
- `.github/PULL_REQUEST_TEMPLATE` – Text displayed when a user submits a pull request.
- `.github/settings.yml` – Configuration file for the [Probot settings app](https://probot.github.io/apps/settings/).

#### Installing

Use the `wp scaffold package-github` command by installing the command's package:

```bash
wp package install wp-cli/scaffold-package-command
```

Once the package is successfully installed, the `wp scaffold package-github` command will appear in the list of available commands.

#### Options

- `<dir>`
  Directory path to an existing package to generate GitHub configuration for.
- `[--force]`
  Overwrite files that already exist.

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

### wp scaffold package-readme

Reference: <https://developer.wordpress.org/cli/commands/scaffold/package-readme/>

Generate a README.md for your command.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Creates a README.md with Using, Installing, and Contributing instructions based on the composer.json file for your WP-CLI package. Run this command at the beginning of your project, and then every time your usage docs change. These command-specific docs are generated based composer.json -> 'extra' -> 'commands'. For instance, this package's composer.json includes:

```bash
{
  "name": "wp-cli/scaffold-package-command",
   // [...]
   "extra": {
       "commands": [
           "scaffold package",
           "scaffold package-tests",
           "scaffold package-readme"
       ]
   }
}
```

You can also customize the rendering of README.md generally with composer.json -> 'extra' -> 'readme'. For example, runcommand/hook's composer.json includes:

```bash
{
    "extra": {
        "commands": [
            "hook"
        ],
        "readme": {
            "shields": [
                "[![Build Status](https://travis-ci.org/runcommand/reset-password.svg?branch=master)](https://travis-ci.org/runcommand/reset-password)"
            ],
            "sections": [
                "Using",
                "Installing",
                "Support"
            ],
            "support": {
                "body": "https://raw.githubusercontent.com/runcommand/runcommand-theme/master/bin/readme-partials/support-open-source.md"
            },
            "show_powered_by": false
        }
    }
}
```

In this example:

- "shields" supports arbitrary images as shields to display.
- "sections" permits defining arbitrary sections (instead of default Using, Installing and Contributing).
- "support" -> "body" uses a remote Markdown file as the section contents. This can also be a local file path, or a string.
- "show_powered_by" shows or hides the Powered By mention at the end of the readme.

For sections, "pre", "body" and "post" are supported. Example: `"support": {
  "pre": "highlight.md",
  "body": "https://raw.githubusercontent.com/runcommand/runcommand-theme/master/bin/readme-partials/support-open-source.md",
  "post": "This is additional text to show after main body content."
},` In this example:

- "pre" content is pulled from local highlight.md file.
- "body" content is pulled from remote URL.
- "post" is a string.

#### Installing

Use the `wp scaffold package-readme` command by installing the command's package:

```bash
wp package install wp-cli/scaffold-package-command
```

Once the package is successfully installed, the `wp scaffold package-readme` command will appear in the list of available commands.

#### Options

- `<dir>`
  Directory path to an existing package to generate a readme for.
- `[--force]`
  Overwrite the readme if it already exists.
- `[--branch=<branch>]`
  Name of default branch of the underlying repository. Defaults to master.

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

### wp scaffold package-tests

Reference: <https://developer.wordpress.org/cli/commands/scaffold/package-tests/>

Generate files for writing Behat tests for your command.

This command runs on the `before_wp_load` hook, just before the WP load process begins. WP-CLI makes use of a Behat-based testing framework, which you should use too. This command generates all of the files you need. Functional tests are an integral ingredient of high-quality, maintainable commands. Behat is a great choice as a testing framework because:

- It's easy to write new tests, which means they'll actually get written.
- The tests interface with your command in the same manner as your users interface with your command, and they describe how the command is expected to work in human-readable terms.

Behat tests live in the `features/` directory of your project. When you use this command, it will generate a default test that looks like this:

```bash
Feature: Test that WP-CLI loads.

  Scenario: WP-CLI loads for your tests
    Given a WP install

    When I run `wp eval 'echo "Hello world.";'`
    Then STDOUT should contain:
      """
      Hello world.
      """
```

Functional tests typically follow this pattern:

- **Given** some background,
- **When** a user performs a specific action,
- **Then** the end result should be X (and Y and Z).

View all defined Behat steps available for use with `behat -dl`:

```bash
Given /^an empty directory$/
Given /^an empty cache/
Given /^an? ([^\s]+) file:$/
Given /^"([^"]+)" replaced with "([^"]+)" in the ([^\s]+) file$/
```

The files generated by this command include:

- `.travis.yml` is the configuration file for Travis CI.
- `bin/install-package-tests.sh` will configure your environment to run the tests.
- `bin/test.sh` is a test runner that respects contextual Behat tags.
- `features/load-wp-cli.feature` is a basic test to confirm WP-CLI can load.
- `features/bootstrap`, `features/steps`, `features/extra` are Behat configuration files.

After running `bin/install-package-tests.sh`, you can run the tests with `./vendor/bin/behat`. If you find yourself using Behat on a number of projects and don't want to install a copy with each one, you can `composer global require behat/behat` to install Behat globally on your machine. Make sure `~/.composer/vendor/bin` has also been added to your `$PATH`. Once you've done so, you can run the tests for a project by calling `behat`. For Travis CI, specially-named files in the package directory can be used to modify the generated `.travis.yml`, where `&lt;tag&gt;` is one of 'cache', 'env', 'matrix', 'before_install', 'install', 'before_script', 'script': * `travis-&lt;tag&gt;.yml` – contents used for `&lt;tag&gt;:` (if present following ignored) * `travis-&lt;tag&gt;-append.yml` – contents appended to generated `&lt;tag&gt;:` You can also append to the generated `.travis.yml` with the file: * `travis-append.yml` – contents appended to generated `.travis.yml`

#### Environment

The `features/bootstrap/FeatureContext.php` file expects the WP_CLI_BIN_DIR environment variable. WP-CLI Behat framework uses Behat ~2.5, which is installed with Composer.

#### Installing

Use the `wp scaffold package-tests` command by installing the command's package:

```bash
wp package install wp-cli/scaffold-package-command
```

Once the package is successfully installed, the `wp scaffold package-tests` command will appear in the list of available commands.

#### Options

- `<dir>`
  Directory path to an existing package to generate tests for.
- `[--ci=<provider>]`
  Create a configuration file for a specific CI provider.
  - default: travis
  - options:
  - travis
  - circle
  - github
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate files for writing Behat tests.
$ wp scaffold package-tests /path/to/command/dir/
Success: Created package test files.
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

### wp scaffold plugin

Reference: <https://developer.wordpress.org/cli/commands/scaffold/plugin/>

Generates starter code for a plugin.

The following files are always generated:

- `plugin-slug.php` is the main PHP plugin file.
- `readme.txt` is the readme file for the plugin.
- `package.json` needed by NPM holds various metadata relevant to the project. Packages: `grunt`, `grunt-wp-i18n` and `grunt-wp-readme-to-markdown`. Scripts: `start`, `readme`, `i18n`.
- `Gruntfile.js` is the JS file containing Grunt tasks. Tasks: `i18n` containing `addtextdomain` and `makepot`, `readme` containing `wp_readme_to_markdown`.
- `.editorconfig` is the configuration file for Editor.
- `.gitignore` tells which files (or patterns) git should ignore.
- `.distignore` tells which files and folders should be ignored in distribution.

The following files are also included unless the `--skip-tests` is used:

- `phpunit.xml.dist` is the configuration file for PHPUnit.
- `.circleci/config.yml` is the configuration file for CircleCI. Use `--ci=<provider>` to select a different service.
- `bin/install-wp-tests.sh` configures the WordPress test suite and a test database.
- `tests/bootstrap.php` is the file that makes the current plugin active when running the test suite.
- `tests/test-sample.php` is a sample file containing test cases.
- `.phpcs.xml.dist` is a collection of PHP_CodeSniffer rules.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The internal name of the plugin.
- `[--dir=<dirname>]`
  Put the new plugin in some arbitrary directory path. Plugin directory will be path plus supplied slug.
- `[--plugin_name=<title>]`
  What to put in the 'Plugin Name:' header.
- `[--plugin_description=<description>]`
  What to put in the 'Description:' header.
- `[--plugin_author=<author>]`
  What to put in the 'Author:' header.
- `[--plugin_author_uri=<url>]`
  What to put in the 'Author URI:' header.
- `[--plugin_uri=<url>]`
  What to put in the 'Plugin URI:' header.
- `[--skip-tests]`
  Don't generate files for unit testing.
- `[--ci=<provider>]`
  Choose a configuration file for a continuous integration provider.
  - default: circle
  - options:
  - circle
  - gitlab
  - bitbucket
  - github
- `[--activate]`
  Activate the newly generated plugin.
- `[--activate-network]`
  Network activate the newly generated plugin.
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
$ wp scaffold plugin sample-plugin
Success: Created plugin files.
Success: Created test files.
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

### wp scaffold plugin-tests

Reference: <https://developer.wordpress.org/cli/commands/scaffold/plugin-tests/>

Generates files needed for running PHPUnit tests in a plugin.

The following files are generated by default:

- `phpunit.xml.dist` is the configuration file for PHPUnit.
- `.circleci/config.yml` is the configuration file for CircleCI. Use `--ci=<provider>` to select a different service.
- `bin/install-wp-tests.sh` configures the WordPress test suite and a test database.
- `tests/bootstrap.php` is the file that makes the current plugin active when running the test suite.
- `tests/test-sample.php` is a sample file containing the actual tests.
- `.phpcs.xml.dist` is a collection of PHP_CodeSniffer rules.

Learn more from the [plugin unit tests documentation](https://make.wordpress.org/cli/handbook/misc/plugin-unit-tests/).

#### Environment

The `tests/bootstrap.php` file looks for the WP_TESTS_DIR environment variable.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<plugin>]`
  The name of the plugin to generate test files for.
- `[--dir=<dirname>]`
  Generate test files for a non-standard plugin path. If no plugin slug is specified, the directory name is used.
- `[--ci=<provider>]`
  Choose a configuration file for a continuous integration provider.
  - default: circle
  - options:
  - circle
  - gitlab
  - bitbucket
  - github
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate unit test files for plugin 'sample-plugin'.
$ wp scaffold plugin-tests sample-plugin
Success: Created test files.
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

### wp scaffold post-type

Reference: <https://developer.wordpress.org/cli/commands/scaffold/post-type/>

Generates PHP code for registering a custom post type.

**Alias:** `cpt`

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The internal name of the post type.
- `[--label=<label>]`
  The text used to translate the update messages.
- `[--textdomain=<textdomain>]`
  The textdomain to use for the labels.
- `[--dashicon=<dashicon>]`
  The dashicon to use in the menu.
- `[--theme]`
  Create a file in the active theme directory, instead of sending to STDOUT. Specify a theme with `--theme=<theme>` to have the file placed in that theme.
- `[--plugin=<plugin>]`
  Create a file in the given plugin's directory, instead of sending to STDOUT.
- `[--raw]`
  Just generate the `register_post_type()` call and nothing else.
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate a 'movie' post type for the 'simple-life' theme
$ wp scaffold post-type movie --label=Movie --theme=simple-life
Success: Created '/var/www/example.com/public_html/wp-content/themes/simple-life/post-types/movie.php'.
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

### wp scaffold tax

Reference: <https://developer.wordpress.org/cli/commands/scaffold/tax/>

Generates PHP code for registering a custom taxonomy.

This is an alias for `wp scaffold taxonomy`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The internal name of the taxonomy.
- `[--post_types=<post-types>]`
  Post types to register for use with the taxonomy.
- `[--label=<label>]`
  The text used to translate the update messages.
- `[--textdomain=<textdomain>]`
  The textdomain to use for the labels.
- `[--theme]`
  Create a file in the active theme directory, instead of sending to STDOUT. Specify a theme with `--theme=<theme>` to have the file placed in that theme.
- `[--plugin=<plugin>]`
  Create a file in the given plugin's directory, instead of sending to STDOUT.
- `[--raw]`
  Just generate the `register_taxonomy()` call and nothing else.
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate PHP code for registering a custom taxonomy and save in a file
$ wp scaffold taxonomy venue --post_types=event,presentation > taxonomy.php
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

### wp scaffold taxonomy

Reference: <https://developer.wordpress.org/cli/commands/scaffold/taxonomy/>

Generates PHP code for registering a custom taxonomy.

**Alias:** `tax`

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The internal name of the taxonomy.
- `[--post_types=<post-types>]`
  Post types to register for use with the taxonomy.
- `[--label=<label>]`
  The text used to translate the update messages.
- `[--textdomain=<textdomain>]`
  The textdomain to use for the labels.
- `[--theme]`
  Create a file in the active theme directory, instead of sending to STDOUT. Specify a theme with `--theme=<theme>` to have the file placed in that theme.
- `[--plugin=<plugin>]`
  Create a file in the given plugin's directory, instead of sending to STDOUT.
- `[--raw]`
  Just generate the `register_taxonomy()` call and nothing else.
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate PHP code for registering a custom taxonomy and save in a file
$ wp scaffold taxonomy venue --post_types=event,presentation > taxonomy.php
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

### wp scaffold theme-tests

Reference: <https://developer.wordpress.org/cli/commands/scaffold/theme-tests/>

Generates files needed for running PHPUnit tests in a theme.

The following files are generated by default:

- `phpunit.xml.dist` is the configuration file for PHPUnit.
- `.circleci/config.yml` is the configuration file for CircleCI. Use `--ci=<provider>` to select a different service.
- `bin/install-wp-tests.sh` configures the WordPress test suite and a test database.
- `tests/bootstrap.php` is the file that makes the current theme active when running the test suite.
- `tests/test-sample.php` is a sample file containing the actual tests.
- `.phpcs.xml.dist` is a collection of PHP_CodeSniffer rules.

Learn more from the [plugin unit tests documentation](https://make.wordpress.org/cli/handbook/misc/plugin-unit-tests/).

#### Environment

The `tests/bootstrap.php` file looks for the WP_TESTS_DIR environment variable.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<theme>]`
  The name of the theme to generate test files for.
- `[--dir=<dirname>]`
  Generate test files for a non-standard theme path. If no theme slug is specified, the directory name is used.
- `[--ci=<provider>]`
  Choose a configuration file for a continuous integration provider.
  - default: circle
  - options:
  - circle
  - gitlab
  - bitbucket
  - github
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate unit test files for theme 'twentysixteenchild'.
$ wp scaffold theme-tests twentysixteenchild
Success: Created test files.
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

### wp scaffold underscores

Reference: <https://developer.wordpress.org/cli/commands/scaffold/underscores/>

Generates starter code for a theme based on _s.

**Alias:** `_s` See the [Underscores website](https://underscores.me/) for more details.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The slug for the new theme, used for prefixing functions.
- `[--activate]`
  Activate the newly downloaded theme.
- `[--enable-network]`
  Enable the newly downloaded theme for the entire network.
- `[--theme_name=<title>]`
  What to put in the 'Theme Name:' header in 'style.css'.
- `[--author=<full-name>]`
  What to put in the 'Author:' header in 'style.css'.
- `[--author_uri=<uri>]`
  What to put in the 'Author URI:' header in 'style.css'.
- `[--sassify]`
  Include stylesheets as SASS.
- `[--woocommerce]`
  Include WooCommerce boilerplate files.
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate a theme with name "Sample Theme" and author "John Doe"
$ wp scaffold _s sample-theme --theme_name="Sample Theme" --author="John Doe"
Success: Created theme 'Sample Theme'.
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

### wp scaffold _s

Reference: <https://developer.wordpress.org/cli/commands/scaffold/_s/>

Generates starter code for a theme based on _s.

This is an alias for `wp scaffold underscores`. See the [Underscores website](https://underscores.me/) for more details.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<slug>`
  The slug for the new theme, used for prefixing functions.
- `[--activate]`
  Activate the newly downloaded theme.
- `[--enable-network]`
  Enable the newly downloaded theme for the entire network.
- `[--theme_name=<title>]`
  What to put in the 'Theme Name:' header in 'style.css'.
- `[--author=<full-name>]`
  What to put in the 'Author:' header in 'style.css'.
- `[--author_uri=<uri>]`
  What to put in the 'Author URI:' header in 'style.css'.
- `[--sassify]`
  Include stylesheets as SASS.
- `[--woocommerce]`
  Include WooCommerce boilerplate files.
- `[--force]`
  Overwrite files that already exist.

#### Examples

```bash
# Generate a theme with name "Sample Theme" and author "John Doe"
$ wp scaffold _s sample-theme --theme_name="Sample Theme" --author="John Doe"
Success: Created theme 'Sample Theme'.
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
