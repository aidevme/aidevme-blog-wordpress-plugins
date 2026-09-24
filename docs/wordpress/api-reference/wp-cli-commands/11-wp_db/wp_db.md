# wp db

Reference: <https://developer.wordpress.org/cli/commands/db/>

## Description

Performs basic database operations using credentials stored in wp-config.php.

## Synopsis

```bash
wp db <command>
```

Unless overridden, these commands run on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope.

## Examples

```bash
# Create a new database.
$ wp db create
Success: Database created.

# Drop an existing database.
$ wp db drop --yes
Success: Database dropped.

# Reset the current database.
$ wp db reset --yes
Success: Database reset.

# Execute a SQL query stored in a file.
$ wp db query < debug.sql
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp db check](https://developer.wordpress.org/cli/commands/db/check/) | Checks the current status of the database. |
| [wp db clean](https://developer.wordpress.org/cli/commands/db/clean/) | Removes all tables with `$table_prefix` from the database. |
| [wp db cli](https://developer.wordpress.org/cli/commands/db/cli/) | Opens a MySQL console using credentials from wp-config.php |
| [wp db columns](https://developer.wordpress.org/cli/commands/db/columns/) | Displays information about a given table. |
| [wp db connect](https://developer.wordpress.org/cli/commands/db/connect/) | Opens a MySQL console using credentials from wp-config.php |
| [wp db create](https://developer.wordpress.org/cli/commands/db/create/) | Creates a new database. |
| [wp db drop](https://developer.wordpress.org/cli/commands/db/drop/) | Deletes the existing database. |
| [wp db dump](https://developer.wordpress.org/cli/commands/db/dump/) | Exports the database to a file or to STDOUT. |
| [wp db export](https://developer.wordpress.org/cli/commands/db/export/) | Exports the database to a file or to STDOUT. |
| [wp db import](https://developer.wordpress.org/cli/commands/db/import/) | Imports a database from a file or from STDIN. |
| [wp db optimize](https://developer.wordpress.org/cli/commands/db/optimize/) | Optimizes the database. |
| [wp db prefix](https://developer.wordpress.org/cli/commands/db/prefix/) | Displays the database table prefix. |
| [wp db query](https://developer.wordpress.org/cli/commands/db/query/) | Executes a SQL query against the database. |
| [wp db repair](https://developer.wordpress.org/cli/commands/db/repair/) | Repairs the database. |
| [wp db reset](https://developer.wordpress.org/cli/commands/db/reset/) | Removes all tables from the database. |
| [wp db search](https://developer.wordpress.org/cli/commands/db/search/) | Finds a string in the database. |
| [wp db size](https://developer.wordpress.org/cli/commands/db/size/) | Displays the database name and size. |
| [wp db tables](https://developer.wordpress.org/cli/commands/db/tables/) | Lists the database tables. |

### wp db check

Reference: <https://developer.wordpress.org/cli/commands/db/check/>

Checks the current status of the database.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. Runs `mysqlcheck` utility with `--check` using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php. [See docs](http://dev.mysql.com/doc/refman/5.7/en/check-table.html) for more details on the `CHECK TABLE` statement. This command does not check whether WordPress is installed; to do that run `wp core is-installed`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--dbuser=<value>]`
  Username to pass to mysqlcheck. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysqlcheck. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysqlcheck. [Refer to mysqlcheck docs](https://dev.mysql.com/doc/en/mysqlcheck.html).
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
$ wp db check
Success: Database checked.
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

### wp db clean

Reference: <https://developer.wordpress.org/cli/commands/db/clean/>

Removes all tables with `$table_prefix` from the database.

Runs `DROP_TABLE` for each table that has a `$table_prefix` as specified in wp-config.php.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--dbuser=<value>]`
  Username to pass to mysql. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysql. Defaults to DB_PASSWORD.
- `[--yes]`
  Answer yes to the confirmation message.
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
# Delete all tables that match the current site prefix.
$ wp db clean --yes
Success: Tables dropped.
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

### wp db cli

Reference: <https://developer.wordpress.org/cli/commands/db/cli/>

Opens a MySQL console using credentials from wp-config.php

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. **Alias:** `connect`

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--database=<database>]`
  Use a specific database. Defaults to DB_NAME.
- `[--default-character-set=<character-set>]`
  Use a specific character set. Defaults to DB_CHARSET when defined.
- `[--dbuser=<value>]`
  Username to pass to mysql. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysql. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysql. [Refer to mysql docs](https://dev.mysql.com/doc/en/mysql-command-options.html).
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
# Open MySQL console
$ wp db cli
mysql&gt;
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

### wp db columns

Reference: <https://developer.wordpress.org/cli/commands/db/columns/>

Displays information about a given table.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<table>`
  Name of the database table.
- `[--format]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml

#### Examples

```bash
$ wp db columns wp_posts
+-----------------------+---------------------+------+-----+---------------------+----------------+
|         Field         |        Type         | Null | Key |       Default       |     Extra      |
+-----------------------+---------------------+------+-----+---------------------+----------------+
| ID                    | bigint(20) unsigned | NO   | PRI |                     | auto_increment |
| post_author           | bigint(20) unsigned | NO   | MUL | 0                   |                |
| post_date             | datetime            | NO   |     | 0000-00-00 00:00:00 |                |
| post_date_gmt         | datetime            | NO   |     | 0000-00-00 00:00:00 |                |
| post_content          | longtext            | NO   |     |                     |                |
| post_title            | text                | NO   |     |                     |                |
| post_excerpt          | text                | NO   |     |                     |                |
| post_status           | varchar(20)         | NO   |     | publish             |                |
| comment_status        | varchar(20)         | NO   |     | open                |                |
| ping_status           | varchar(20)         | NO   |     | open                |                |
| post_password         | varchar(255)        | NO   |     |                     |                |
| post_name             | varchar(200)        | NO   | MUL |                     |                |
| to_ping               | text                | NO   |     |                     |                |
| pinged                | text                | NO   |     |                     |                |
| post_modified         | datetime            | NO   |     | 0000-00-00 00:00:00 |                |
| post_modified_gmt     | datetime            | NO   |     | 0000-00-00 00:00:00 |                |
| post_content_filtered | longtext            | NO   |     |                     |                |
| post_parent           | bigint(20) unsigned | NO   | MUL | 0                   |                |
| guid                  | varchar(255)        | NO   |     |                     |                |
| menu_order            | int(11)             | NO   |     | 0                   |                |
| post_type             | varchar(20)         | NO   | MUL | post                |                |
| post_mime_type        | varchar(100)        | NO   |     |                     |                |
| comment_count         | bigint(20)          | NO   |     | 0                   |                |
+-----------------------+---------------------+------+-----+---------------------+----------------+
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

### wp db connect

Reference: <https://developer.wordpress.org/cli/commands/db/connect/>

Opens a MySQL console using credentials from wp-config.php

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. This is an alias for `wp db cli`.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--database=<database>]`
  Use a specific database. Defaults to DB_NAME.
- `[--default-character-set=<character-set>]`
  Use a specific character set. Defaults to DB_CHARSET when defined.
- `[--dbuser=<value>]`
  Username to pass to mysql. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysql. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysql. [Refer to mysql docs](https://dev.mysql.com/doc/en/mysql-command-options.html).
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
# Open MySQL console
$ wp db cli
mysql&gt;
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

### wp db create

Reference: <https://developer.wordpress.org/cli/commands/db/create/>

Creates a new database.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. Runs `CREATE_DATABASE` SQL statement using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--dbuser=<value>]`
  Username to pass to mysql. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysql. Defaults to DB_PASSWORD.
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
$ wp db create
Success: Database created.
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

### wp db drop

Reference: <https://developer.wordpress.org/cli/commands/db/drop/>

Deletes the existing database.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. Runs `DROP_DATABASE` SQL statement using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--dbuser=<value>]`
  Username to pass to mysql. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysql. Defaults to DB_PASSWORD.
- `[--yes]`
  Answer yes to the confirmation message.
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
$ wp db drop --yes
Success: Database dropped.
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

### wp db dump

Reference: <https://developer.wordpress.org/cli/commands/db/dump/>

Exports the database to a file or to STDOUT.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. This is an alias for `wp db export`. Runs `mysqldump` utility using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php. Accepts any valid `mysqldump` flags.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<file>]`
  The name of the SQL file to export. If '-', then outputs to STDOUT. If omitted, it will be '{dbname}-{Y-m-d}-{random-hash}.sql'.
- `[--dbuser=<value>]`
  Username to pass to mysqldump. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysqldump. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysqldump. [Refer to mysqldump docs](https://dev.mysql.com/doc/en/mysqldump.html#mysqldump-option-summary).
- `[--tables=<tables>]`
  The comma separated list of specific tables to export. Excluding this parameter will export all tables in the database.
- `[--exclude_tables=<tables>]`
  The comma separated list of specific tables that should be skipped from exporting. Excluding this parameter will export all tables in the database.
- `[--include-tablespaces]`
  Skips adding the default –no-tablespaces option to mysqldump.
- `[--porcelain]`
  Output filename for the exported database.
- `[--add-drop-table]`
  Include a `DROP TABLE IF EXISTS` statement before each `CREATE TABLE` statement.
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
# Export database with drop query included
$ wp db export --add-drop-table
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export certain tables
$ wp db export --tables=wp_options,wp_users
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export all tables matching a wildcard
$ wp db export --tables=$(wp db tables 'wp_user*' --format=csv)
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export all tables matching prefix
$ wp db export --tables=$(wp db tables --all-tables-with-prefix --format=csv)
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export certain posts without create table statements
$ wp db export --no-create-info=true --tables=wp_posts --where="ID in (100,101,102)"
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export relating meta for certain posts without create table statements
$ wp db export --no-create-info=true --tables=wp_postmeta --where="post_id in (100,101,102)"
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Skip certain tables from the exported database
$ wp db export --exclude_tables=wp_options,wp_users
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Skip all tables matching a wildcard from the exported database
$ wp db export --exclude_tables=$(wp db tables 'wp_user*' --format=csv)
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Skip all tables matching prefix from the exported database
$ wp db export --exclude_tables=$(wp db tables --all-tables-with-prefix --format=csv)
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export database to STDOUT.
$ wp db export -
-- MySQL dump 10.13  Distrib 5.7.19, for osx10.12 (x86_64)
--
-- Host: localhost    Database: wpdev
-- ------------------------------------------------------
-- Server version    5.7.19
...
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

### wp db export

Reference: <https://developer.wordpress.org/cli/commands/db/export/>

Exports the database to a file or to STDOUT.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. **Alias:** `dump` Runs `mysqldump` utility using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php. Accepts any valid `mysqldump` flags.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<file>]`
  The name of the SQL file to export. If '-', then outputs to STDOUT. If omitted, it will be '{dbname}-{Y-m-d}-{random-hash}.sql'.
- `[--dbuser=<value>]`
  Username to pass to mysqldump. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysqldump. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysqldump. [Refer to mysqldump docs](https://dev.mysql.com/doc/en/mysqldump.html#mysqldump-option-summary).
- `[--tables=<tables>]`
  The comma separated list of specific tables to export. Excluding this parameter will export all tables in the database.
- `[--exclude_tables=<tables>]`
  The comma separated list of specific tables that should be skipped from exporting. Excluding this parameter will export all tables in the database.
- `[--include-tablespaces]`
  Skips adding the default –no-tablespaces option to mysqldump.
- `[--porcelain]`
  Output filename for the exported database.
- `[--add-drop-table]`
  Include a `DROP TABLE IF EXISTS` statement before each `CREATE TABLE` statement.
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
# Export database with drop query included
$ wp db export --add-drop-table
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export certain tables
$ wp db export --tables=wp_options,wp_users
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export all tables matching a wildcard
$ wp db export --tables=$(wp db tables 'wp_user*' --format=csv)
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export all tables matching prefix
$ wp db export --tables=$(wp db tables --all-tables-with-prefix --format=csv)
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export certain posts without create table statements
$ wp db export --no-create-info=true --tables=wp_posts --where="ID in (100,101,102)"
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export relating meta for certain posts without create table statements
$ wp db export --no-create-info=true --tables=wp_postmeta --where="post_id in (100,101,102)"
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Skip certain tables from the exported database
$ wp db export --exclude_tables=wp_options,wp_users
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Skip all tables matching a wildcard from the exported database
$ wp db export --exclude_tables=$(wp db tables 'wp_user*' --format=csv)
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Skip all tables matching prefix from the exported database
$ wp db export --exclude_tables=$(wp db tables --all-tables-with-prefix --format=csv)
Success: Exported to 'wordpress_dbase-db72bb5.sql'.

# Export database to STDOUT.
$ wp db export -
-- MySQL dump 10.13  Distrib 5.7.19, for osx10.12 (x86_64)
--
-- Host: localhost    Database: wpdev
-- ------------------------------------------------------
-- Server version    5.7.19
...
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

### wp db import

Reference: <https://developer.wordpress.org/cli/commands/db/import/>

Imports a database from a file or from STDIN.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. Runs SQL queries using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php. This does not create database by itself and only performs whatever tasks are defined in the SQL.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<file>]`
  The name of the SQL file to import. If '-', then reads from STDIN. If omitted, it will look for '{dbname}.sql'.
- `[--dbuser=<value>]`
  Username to pass to mysql. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysql. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysql. [Refer to mysql binary docs](https://dev.mysql.com/doc/refman/8.0/en/mysql-command-options.html).
- `[--skip-optimization]`
  When using an SQL file, do not include speed optimization such as disabling auto-commit and key checks.
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
# Import MySQL from a file.
$ wp db import wordpress_dbase.sql
Success: Imported from 'wordpress_dbase.sql'.
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

### wp db optimize

Reference: <https://developer.wordpress.org/cli/commands/db/optimize/>

Optimizes the database.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. Runs `mysqlcheck` utility with `--optimize=true` using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php. [See docs](http://dev.mysql.com/doc/refman/5.7/en/optimize-table.html) for more details on the `OPTIMIZE TABLE` statement.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--dbuser=<value>]`
  Username to pass to mysqlcheck. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysqlcheck. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysqlcheck. [Refer to mysqlcheck docs](https://dev.mysql.com/doc/en/mysqlcheck.html).
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
$ wp db optimize
Success: Database optimized.
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

### wp db prefix

Reference: <https://developer.wordpress.org/cli/commands/db/prefix/>

Displays the database table prefix.

Display the database table prefix, as defined by the database handler's interpretation of the current site.

#### Examples

```bash
$ wp db prefix
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

### wp db query

Reference: <https://developer.wordpress.org/cli/commands/db/query/>

Executes a SQL query against the database.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. Executes an arbitrary SQL query using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php. Use the `--skip-column-names` MySQL argument to exclude the headers from a SELECT query. Pipe the output to remove the ASCII table entirely.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<sql>]`
  A SQL query. If not passed, will try to read from STDIN.
- `[--dbuser=<value>]`
  Username to pass to mysql. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysql. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysql. [Refer to mysql docs](https://dev.mysql.com/doc/en/mysql-command-options.html).
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
# Execute a query stored in a file
$ wp db query < debug.sql

# Query for a specific value in the database (pipe the result to remove the ASCII table borders)
$ wp db query 'SELECT option_value FROM wp_options WHERE option_name="home"' --skip-column-names
+---------------------+
| https://example.com |
+---------------------+

# Check all tables in the database
$ wp db query "CHECK TABLE $(wp db tables | paste -s -d, -);"
+---------------------------------------+-------+----------+----------+
| Table                                 | Op    | Msg_type | Msg_text |
+---------------------------------------+-------+----------+----------+
| wordpress_dbase.wp_users              | check | status   | OK       |
| wordpress_dbase.wp_usermeta           | check | status   | OK       |
| wordpress_dbase.wp_posts              | check | status   | OK       |
| wordpress_dbase.wp_comments           | check | status   | OK       |
| wordpress_dbase.wp_links              | check | status   | OK       |
| wordpress_dbase.wp_options            | check | status   | OK       |
| wordpress_dbase.wp_postmeta           | check | status   | OK       |
| wordpress_dbase.wp_terms              | check | status   | OK       |
| wordpress_dbase.wp_term_taxonomy      | check | status   | OK       |
| wordpress_dbase.wp_term_relationships | check | status   | OK       |
| wordpress_dbase.wp_termmeta           | check | status   | OK       |
| wordpress_dbase.wp_commentmeta        | check | status   | OK       |
+---------------------------------------+-------+----------+----------+

# Pass extra arguments through to MySQL
$ wp db query 'SELECT * FROM wp_options WHERE option_name="home"' --skip-column-names
+---+------+------------------------------+-----+
| 2 | home | http://wordpress-develop.dev | yes |
+---+------+------------------------------+-----+
```

#### Multisite Usage

Please note that the global `--url` parameter will have no effect on this command. In order to query for data in a site other than your primary site, you will need to manually modify the table names to use the prefix that includes the site's ID. For example, to get the `home` option for your second site, modify the example above like so:

```bash
$ wp db query 'SELECT option_value FROM wp_2_options WHERE option_name="home"' --skip-column-names
+----------------------+
| https://example2.com |
+----------------------+
```

To confirm the ID for the site you want to query, you can use the `wp site list` command:

```bash
# wp site list --fields=blog_id,url
+---------+-----------------------+
| blog_id | url                   |
+---------+-----------------------+
| 1       | https://example1.com/ |
| 2       | https://example2.com/ |
+---------+-----------------------+
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

### wp db repair

Reference: <https://developer.wordpress.org/cli/commands/db/repair/>

Repairs the database.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. Runs `mysqlcheck` utility with `--repair=true` using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php. [See docs](http://dev.mysql.com/doc/refman/5.7/en/repair-table.html) for more details on the `REPAIR TABLE` statement.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--dbuser=<value>]`
  Username to pass to mysqlcheck. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysqlcheck. Defaults to DB_PASSWORD.
- `[--<field>=<value>]`
  Extra arguments to pass to mysqlcheck. [Refer to mysqlcheck docs](https://dev.mysql.com/doc/en/mysqlcheck.html).
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
$ wp db repair
Success: Database repaired.
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

### wp db reset

Reference: <https://developer.wordpress.org/cli/commands/db/reset/>

Removes all tables from the database.

This command runs on the `after_wp_config_load` hook, after wp-config.php has been loaded into scope. Runs `DROP_DATABASE` and `CREATE_DATABASE` SQL statements using `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` database credentials specified in wp-config.php.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--dbuser=<value>]`
  Username to pass to mysql. Defaults to DB_USER.
- `[--dbpass=<value>]`
  Password to pass to mysql. Defaults to DB_PASSWORD.
- `[--yes]`
  Answer yes to the confirmation message.
- `[--defaults]`
  Loads the environment's MySQL option files. Default behavior is to skip loading them to avoid failures due to misconfiguration.

#### Examples

```bash
$ wp db reset --yes
Success: Database reset.
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

### wp db search

Reference: <https://developer.wordpress.org/cli/commands/db/search/>

Finds a string in the database.

Searches through all of the text columns in a selection of database tables for a given string, Outputs colorized references to the string. Defaults to searching through all tables registered to $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/). On multisite, this default is limited to the tables for the current site.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<search>`
  String to search for. The search is case-insensitive by default.
- `[<tables>…]`
  One or more tables to search through for the string.
- `[--network]`
  Search through all the tables registered to $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/) in a multisite install.
- `[--all-tables-with-prefix]`
  Search through all tables that match the registered table prefix, even if not registered on $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/). On one hand, sometimes plugins use tables without registering them to $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/). On another hand, this could return tables you don't expect. Overrides –network.
- `[--all-tables]`
  Search through ALL tables in the database, regardless of the prefix, and even if not registered on $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/). Overrides –network and –all-tables-with-prefix.
- `[--before_context=<num>]`
  Number of characters to display before the match.
  - default: 40
- `[--after_context=<num>]`
  Number of characters to display after the match.
  - default: 40
- `[--regex]`
  Runs the search as a regular expression (without delimiters). The search becomes case-sensitive (i.e. no PCRE flags are added). Delimiters must be escaped if they occur in the expression. Because the search is run on individual columns, you can use the `^` and `$` tokens to mark the start and end of a match, respectively.
- `[--regex-flags=<regex-flags>]`
  Pass PCRE modifiers to the regex search (e.g. 'i' for case-insensitivity).
- `[--regex-delimiter=<regex-delimiter>]`
  The delimiter to use for the regex. It must be escaped if it appears in the search string. The default value is the result of `chr(1)`.
- `[--table_column_once]`
  Output the 'table:column' line once before all matching row lines in the table column rather than before each matching row.
- `[--one_line]`
  Place the 'table:column' output on the same line as the row id and match ('table:column:id:match'). Overrides –table_column_once.
- `[--matches_only]`
  Only output the string matches (including context). No 'table:column's or row ids are outputted.
- `[--stats]`
  Output stats on the number of matches found, time taken, tables/columns/rows searched, tables skipped.
- `[--table_column_color=<color_code>]`
  Percent color code to use for the 'table:column' output. For a list of available percent color codes, see below. Default '%G' (bright green).
- `[--id_color=<color_code>]`
  Percent color code to use for the row id output. For a list of available percent color codes, see below. Default '%Y' (bright yellow).
- `[--match_color=<color_code>]`
  Percent color code to use for the match (unless both before and after context are 0, when no color code is used). For a list of available percent color codes, see below. Default '%3%k' (black on a mustard background).
- `[--fields=<fields>]`
  Get a specific subset of the fields.
- `[--format=<format>]`
  Render output in a particular format.
  - options:
  - table
  - csv
  - json
  - yaml
  - ids
  - count

The percent color codes available are:

| Code | Color |
| --- | --- |
| %y | Yellow (dark) (mustard) |
| %g | Green (dark) |
| %b | Blue (dark) |
| %r | Red (dark) |
| %m | Magenta (dark) |
| %c | Cyan (dark) |
| %w | White (dark) (light gray) |
| %k | Black |
| %Y | Yellow (bright) |
| %G | Green (bright) |
| %B | Blue (bright) |
| %R | Red (bright) |
| %M | Magenta (bright) |
| %C | Cyan (bright) |
| %W | White |
| %K | Black (bright) (dark gray) |
| %3 | Yellow background (dark) (mustard) |
| %2 | Green background (dark) |
| %4 | Blue background (dark) |
| %1 | Red background (dark) |
| %5 | Magenta background (dark) |
| %6 | Cyan background (dark) |
| %7 | White background (dark) (light gray) |
| %0 | Black background |
| %8 | Reverse |
| %U | Underline |
| %F | Blink (unlikely to work) |

They can be concatenated. For instance, the default match color of black on a mustard (dark yellow) background `%3%k` can be made black on a bright yellow background with `%Y%0%8`.

#### Available Fields

These fields will be displayed by default for each result:

- table
- column
- match
- primary_key_name
- primary_key_value

#### Examples

```bash
# Search through the database for the 'wordpress-develop' string
$ wp db search wordpress-develop
wp_options:option_value
1:http://wordpress-develop.dev
wp_options:option_value
1:https://example.com/foo
    ...

# Search through a multisite database on the subsite 'foo' for the 'example.com' string
$ wp db search example.com --url=example.com/foo
wp_2_comments:comment_author_url
1:https://example.com/
wp_2_options:option_value
    ...

# Search through the database for the 'https?://' regular expression, printing stats.
$ wp db search 'https?://' --regex --stats
wp_comments:comment_author_url
1:https://wordpress.org/
    ...
Success: Found 99146 matches in 10.752s (10.559s searching). Searched 12 tables, 53 columns, 1358907 rows. 1 table skipped: wp_term_relationships.

# SQL search database table 'wp_options' where 'option_name' match 'foo'
wp db query 'SELECT * FROM wp_options WHERE option_name like "%foo%"' --skip-column-names
+----+--------------+--------------------------------+-----+
| 98 | foo_options  | a:1:{s:12:"_multiwidget";i:1;} | yes |
| 99 | foo_settings | a:0:{}                         | yes |
+----+--------------+--------------------------------+-----+

# SQL search and delete records from database table 'wp_options' where 'option_name' match 'foo'
wp db query "DELETE from wp_options where option_id in ($(wp db query "SELECT GROUP_CONCAT(option_id SEPARATOR ',') from wp_options where option_name like '%foo%';" --silent --skip-column-names))"

# Search for a string and print the result as a table
$ wp db search https://localhost:8889 --format=table --fields=table,column,match
+------------+--------------+-----------------------------+
| table      | column       | match                       |
+------------+--------------+-----------------------------+
| wp_options | option_value | https://localhost:8889      |
| wp_options | option_value | https://localhost:8889      |
| wp_posts   | guid         | https://localhost:8889/?p=1 |
| wp_users   | user_url     | https://localhost:8889      |
+------------+--------------+-----------------------------+

# Search for a string and get only the IDs (only works for a single table)
$ wp db search https://localhost:8889 wp_options --format=ids
1 2
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

### wp db size

Reference: <https://developer.wordpress.org/cli/commands/db/size/>

Displays the database name and size.

Display the database name and size for `DB_NAME` specified in wp-config.php. The size defaults to a human-readable number. Available size formats include: * b (bytes) * kb (kilobytes) * mb (megabytes) * gb (gigabytes) * tb (terabytes) * B (ISO Byte setting, with no conversion) * KB (ISO Kilobyte setting, with 1 KB = 1,000 B) * KiB (ISO Kibibyte setting, with 1 KiB = 1,024 B) * MB (ISO Megabyte setting, with 1 MB = 1,000 KB) * MiB (ISO Mebibyte setting, with 1 MiB = 1,024 KiB) * GB (ISO Gigabyte setting, with 1 GB = 1,000 MB) * GiB (ISO Gibibyte setting, with 1 GiB = 1,024 MiB) * TB (ISO Terabyte setting, with 1 TB = 1,000 GB) * TiB (ISO Tebibyte setting, with 1 TiB = 1,024 GiB)

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--size_format=<format>]`
  Display the database size only, as a bare number.
  - options:
  - b
  - kb
  - mb
  - gb
  - tb
  - B
  - KB
  - KiB
  - MB
  - MiB
  - GB
  - GiB
  - TB
  - TiB
- `[--tables]`
  Display each table name and size instead of the database size.
- `[--human-readable]`
  Display database sizes in human readable formats.
- `[--format=<format>]`
  Render output in a particular format.
  - options:
  - table
  - csv
  - json
  - yaml
- `[--scope=<scope>]`
  Can be all, global, ms_global, blog, or old tables. Defaults to all.
- `[--network]`
  List all the tables in a multisite install.
- `[--decimals=<decimals>]`
  Number of digits after decimal point. Defaults to 0.
- `[--all-tables-with-prefix]`
  List all tables that match the table prefix even if not registered on $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/). Overrides –network.
- `[--all-tables]`
  List all tables in the database, regardless of the prefix, and even if not registered on $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/). Overrides –all-tables-with-prefix.
- `[--order=<order>]`
  Ascending or Descending order.
  - default: asc
  - options:
  - asc
  - desc
- `[--orderby=<orderby>]`
  Order by fields.
  - default: name
  - options:
  - name
  - size

#### Examples

```bash
$ wp db size
+-------------------+------+
| Name              | Size |
+-------------------+------+
| wordpress_default | 6 MB |
+-------------------+------+

$ wp db size --tables
+-----------------------+-------+
| Name                  | Size  |
+-----------------------+-------+
| wp_users              | 64 KB |
| wp_usermeta           | 48 KB |
| wp_posts              | 80 KB |
| wp_comments           | 96 KB |
| wp_links              | 32 KB |
| wp_options            | 32 KB |
| wp_postmeta           | 48 KB |
| wp_terms              | 48 KB |
| wp_term_taxonomy      | 48 KB |
| wp_term_relationships | 32 KB |
| wp_termmeta           | 48 KB |
| wp_commentmeta        | 48 KB |
+-----------------------+-------+

$ wp db size --size_format=b
5865472

$ wp db size --size_format=kb
5728

$ wp db size --size_format=mb
6
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

### wp db tables

Reference: <https://developer.wordpress.org/cli/commands/db/tables/>

Lists the database tables.

Defaults to all tables registered to the $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/) database handler.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<table>…]`
  List tables based on wildcard search, e.g. 'wp_*_options' or 'wp_post?'.
- `[--scope=<scope>]`
  Can be all, global, ms_global, blog, or old tables. Defaults to all.
- `[--network]`
  List all the tables in a multisite install.
- `[--all-tables-with-prefix]`
  List all tables that match the table prefix even if not registered on $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/). Overrides –network.
- `[--all-tables]`
  List all tables in the database, regardless of the prefix, and even if not registered on $[wpdb](https://developer.wordpress.org/reference/classes/wpdb/). Overrides –all-tables-with-prefix.
- `[--format=<format>]`
  Render output in a particular format.
  - default: list
  - options:
  - list
  - csv

#### Examples

```bash
# List tables for a single site, without shared tables like 'wp_users'
$ wp db tables --scope=blog --url=sub.example.com
wp_3_posts
wp_3_comments
wp_3_options
wp_3_postmeta
wp_3_terms
wp_3_term_taxonomy
wp_3_term_relationships
wp_3_termmeta
wp_3_commentmeta

# Export only tables for a single site
$ wp db export --tables=$(wp db tables --url=sub.example.com --format=csv)
Success: Exported to wordpress_dbase.sql
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
