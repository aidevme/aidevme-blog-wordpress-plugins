# wp profile

Reference: <https://developer.wordpress.org/cli/commands/profile/>

## Description

Quickly identify what's slow with WordPress.

## Synopsis

```bash
wp profile <command>
```

## Examples

```bash
# See an overview for each stage of the load process.
$ wp profile stage --fields=stage,time,cache_ratio
+------------+---------+-------------+
| stage      | time    | cache_ratio |
+------------+---------+-------------+
| bootstrap  | 0.7994s | 93.21%      |
| main_query | 0.0123s | 94.29%      |
| template   | 0.792s  | 91.23%      |
+------------+---------+-------------+
| total (3)  | 1.6037s | 92.91%      |
+------------+---------+-------------+

# Dive into hook performance for a given stage.
$ wp profile stage bootstrap --fields=hook,time,cache_ratio --spotlight
+--------------------------+---------+-------------+
| hook                     | time    | cache_ratio |
+--------------------------+---------+-------------+
| muplugins_loaded:before  | 0.1767s | 33.33%      |
| plugins_loaded:before    | 0.103s  | 78.13%      |
| plugins_loaded           | 0.0194s | 19.32%      |
| setup_theme              | 0.0018s | 75%         |
| after_setup_theme:before | 0.0116s | 95.45%      |
| after_setup_theme        | 0.0049s | 96%         |
| init                     | 0.1428s | 76.74%      |
| wp_loaded:after          | 0.0236s |             |
+--------------------------+---------+-------------+
| total (8)                | 0.4837s | 67.71%      |
+--------------------------+---------+-------------+
```

## Installing

Use the `wp profile` command by installing the command's package:

```bash
wp package install wp-cli/profile-command
```

Once the package is successfully installed, the `wp profile` command will appear in the list of available commands.

## Subcommands

| Name | Description |
| --- | --- |
| [wp profile eval](https://developer.wordpress.org/cli/commands/profile/eval/) | Profile arbitrary code execution. |
| [wp profile eval-file](https://developer.wordpress.org/cli/commands/profile/eval-file/) | Profile execution of an arbitrary file. |
| [wp profile hook](https://developer.wordpress.org/cli/commands/profile/hook/) | Profile key metrics for WordPress hooks (actions and filters). |
| [wp profile stage](https://developer.wordpress.org/cli/commands/profile/stage/) | Profile each stage of the WordPress load process (bootstrap, main_query, template). |

### wp profile eval

Reference: <https://developer.wordpress.org/cli/commands/profile/eval/>

Profile arbitrary code execution.

Code execution happens after WordPress has loaded entirely, which means you can use any utilities defined in WordPress, active plugins, or the current theme.

#### Installing

Use the `wp profile eval` command by installing the command's package:

```bash
wp package install wp-cli/profile-command
```

Once the package is successfully installed, the `wp profile eval` command will appear in the list of available commands.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<php-code>`
  The code to execute, as a string.
- `[--hook[=<hook>]]`
  Focus on key metrics for all hooks, or callbacks on a specific hook.
- `[--fields=<fields>]`
  Display one or more fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - json
  - yaml
  - csv
- `[--order=<order>]`
  Ascending or Descending order.
  - default: ASC
  - options:
  - ASC
  - DESC
- `[--orderby=<fields>]`
  Set orderby which field.

#### Examples

```bash
# Profile a function that makes one HTTP request.
$ wp profile eval 'wp_remote_get( "https://www.apple.com/" );' --fields=time,cache_ratio,request_count
+---------+-------------+---------------+
| time    | cache_ratio | request_count |
+---------+-------------+---------------+
| 0.1009s | 100%        | 1             |
+---------+-------------+---------------+
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

### wp profile eval-file

Reference: <https://developer.wordpress.org/cli/commands/profile/eval-file/>

Profile execution of an arbitrary file.

File execution happens after WordPress has loaded entirely, which means you can use any utilities defined in WordPress, active plugins, or the current theme.

#### Installing

Use the `wp profile eval-file` command by installing the command's package:

```bash
wp package install wp-cli/profile-command
```

Once the package is successfully installed, the `wp profile eval-file` command will appear in the list of available commands.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<file>`
  The path to the PHP file to execute and profile.
- `[--hook[=<hook>]]`
  Focus on key metrics for all hooks, or callbacks on a specific hook.
- `[--fields=<fields>]`
  Display one or more fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - json
  - yaml
  - csv
- `[--order=<order>]`
  Ascending or Descending order.
  - default: ASC
  - options:
  - ASC
  - DESC
- `[--orderby=<fields>]`
  Set orderby which field.

#### Examples

```bash
# Profile from a file `request.php` containing `<?php wp_remote_get( "https://www.apple.com/" );`.
$ wp profile eval-file request.php --fields=time,cache_ratio,request_count
+---------+-------------+---------------+
| time    | cache_ratio | request_count |
+---------+-------------+---------------+
| 0.1009s | 100%        | 1             |
+---------+-------------+---------------+
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

### wp profile hook

Reference: <https://developer.wordpress.org/cli/commands/profile/hook/>

Profile key metrics for WordPress hooks (actions and filters).

This command runs on the `before_wp_load` hook, just before the WP load process begins. In order to profile callbacks on a specific hook, the action or filter will need to execute during the course of the request.

#### Installing

Use the `wp profile hook` command by installing the command's package:

```bash
wp package install wp-cli/profile-command
```

Once the package is successfully installed, the `wp profile hook` command will appear in the list of available commands.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<hook>]`
  Drill into key metrics of callbacks on a specific WordPress hook.
- `[--all]`
  Profile callbacks for all WordPress hooks.
- `[--spotlight]`
  Filter out logs with zero-ish values from the set.
- `[--url=<url>]`
  Execute a request against a specified URL. Defaults to the home URL.
- `[--fields=<fields>]`
  Display one or more fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - json
  - yaml
  - csv
- `[--order=<order>]`
  Ascending or Descending order.
  - default: ASC
  - options:
  - ASC
  - DESC
- `[--orderby=<fields>]`
  Set orderby which field.

#### Examples

```bash
# Profile a hook.
$ wp profile hook template_redirect --fields=callback,cache_hits,cache_misses
+--------------------------------+------------+--------------+
| callback                       | cache_hits | cache_misses |
+--------------------------------+------------+--------------+
| _wp_admin_bar_init()           | 0          | 0            |
| wp_old_slug_redirect()         | 0          | 0            |
| redirect_canonical()           | 5          | 0            |
| WP_Sitemaps-&gt;render_sitemaps() | 0          | 0            |
| rest_output_link_header()      | 3          | 0            |
| wp_shortlink_header()          | 0          | 0            |
| wp_redirect_admin_locations()  | 0          | 0            |
+--------------------------------+------------+--------------+
| total (7)                      | 8          | 0            |
+--------------------------------+------------+--------------+
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

### wp profile stage

Reference: <https://developer.wordpress.org/cli/commands/profile/stage/>

Profile each stage of the WordPress load process (bootstrap, main_query, template).

This command runs on the `before_wp_load` hook, just before the WP load process begins. When WordPress handles a request from a browser, it's essentially executing as one long PHP script. `wp profile stage` breaks the script into three stages:

- **bootstrap** is where WordPress is setting itself up, loading plugins and the main theme, and firing the `init` hook.
- **main_query** is how WordPress transforms the request (e.g. `/2016/10/21/moms-birthday/`) into the primary [WP_Query](https://developer.wordpress.org/reference/classes/wp_query/).
- **template** is where WordPress determines which theme template to render based on the main query, and renders it.

#### Installing

Use the `wp profile stage` command by installing the command's package:

```bash
wp package install wp-cli/profile-command
```

Once the package is successfully installed, the `wp profile stage` command will appear in the list of available commands.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<stage>]`
  Drill down into a specific stage.
- `[--all]`
  Expand upon all stages.
- `[--spotlight]`
  Filter out logs with zero-ish values from the set.
- `[--url=<url>]`
  Execute a request against a specified URL. Defaults to the home URL.
- `[--fields=<fields>]`
  Limit the output to specific fields. Default is all fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - json
  - yaml
  - csv
- `[--order=<order>]`
  Ascending or Descending order.
  - default: ASC
  - options:
  - ASC
  - DESC
- `[--orderby=<fields>]`
  Set orderby which field.

#### Examples

```bash
# See an overview for each stage of the load process.
$ wp profile stage --fields=stage,time,cache_ratio
+------------+---------+-------------+
| stage      | time    | cache_ratio |
+------------+---------+-------------+
| bootstrap  | 0.7994s | 93.21%      |
| main_query | 0.0123s | 94.29%      |
| template   | 0.792s  | 91.23%      |
+------------+---------+-------------+
| total (3)  | 1.6037s | 92.91%      |
+------------+---------+-------------+

# Dive into hook performance for a given stage.
$ wp profile stage bootstrap --fields=hook,time,cache_ratio --spotlight
+--------------------------+---------+-------------+
| hook                     | time    | cache_ratio |
+--------------------------+---------+-------------+
| muplugins_loaded:before  | 0.2335s | 40%         |
| muplugins_loaded         | 0.0007s | 50%         |
| plugins_loaded:before    | 0.2792s | 77.63%      |
| plugins_loaded           | 0.1502s | 100%        |
| after_setup_theme:before | 0.068s  | 100%        |
| init                     | 0.2643s | 96.88%      |
| wp_loaded:after          | 0.0377s |             |
+--------------------------+---------+-------------+
| total (7)                | 1.0335s | 77.42%      |
+--------------------------+---------+-------------+
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
