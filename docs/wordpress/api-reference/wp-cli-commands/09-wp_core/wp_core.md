# wp core

Reference: <https://developer.wordpress.org/cli/commands/core/>

## Description

Downloads, installs, updates, and manages a WordPress installation.

## Synopsis

```bash
wp core <command>
```

## Examples

```bash
# Download WordPress core
$ wp core download --locale=nl_NL
Downloading WordPress 4.5.2 (nl_NL)...
md5 hash verified: c5366d05b521831dd0b29dfc386e56a5
Success: WordPress downloaded.

# Install WordPress
$ wp core install --url=example.com --title=Example --admin_user=supervisor --admin_password=strongpassword --admin_email=info@example.com
Success: WordPress installed successfully.

# Display the WordPress version
$ wp core version
4.5.2
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp core check-update](https://developer.wordpress.org/cli/commands/core/check-update/) | Checks for WordPress updates via Version Check API. |
| [wp core download](https://developer.wordpress.org/cli/commands/core/download/) | Downloads core WordPress files. |
| [wp core install](https://developer.wordpress.org/cli/commands/core/install/) | Runs the standard WordPress installation process. |
| [wp core install-network](https://developer.wordpress.org/cli/commands/core/install-network/) | Transforms an existing single-site installation into a multisite installation. |
| [wp core is-installed](https://developer.wordpress.org/cli/commands/core/is-installed/) | Checks if WordPress is installed. |
| [wp core multisite-convert](https://developer.wordpress.org/cli/commands/core/multisite-convert/) | Transforms an existing single-site installation into a multisite installation. |
| [wp core multisite-install](https://developer.wordpress.org/cli/commands/core/multisite-install/) | Installs WordPress multisite from scratch. |
| [wp core update](https://developer.wordpress.org/cli/commands/core/update/) | Updates WordPress to a newer version. |
| [wp core update-db](https://developer.wordpress.org/cli/commands/core/update-db/) | Runs the WordPress database update procedure. |
| [wp core upgrade](https://developer.wordpress.org/cli/commands/core/upgrade/) | Updates WordPress to a newer version. |
| [wp core verify-checksums](https://developer.wordpress.org/cli/commands/core/verify-checksums/) | Verifies WordPress files against WordPress.org's checksums. |
| [wp core version](https://developer.wordpress.org/cli/commands/core/version/) | Displays the WordPress version. |

### wp core check-update

Reference: <https://developer.wordpress.org/cli/commands/core/check-update/>

Checks for WordPress updates via Version Check API.

Lists the most recent versions when there are updates available, or success message when up to date.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--minor]`
  Compare only the first two parts of the version number.
- `[--major]`
  Compare only the first part of the version number.
- `[--force-check]`
  Bypass the transient cache and force a fresh update check.
- `[--field=<field>]`
  Prints the value of a single field for each update.
- `[--fields=<fields>]`
  Limit the output to specific object fields. Defaults to version,update_type,package_url.
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
$ wp core check-update
+---------+-------------+-------------------------------------------------------------+
| version | update_type | package_url                                                 |
+---------+-------------+-------------------------------------------------------------+
| 4.5.2   | major       | https://downloads.wordpress.org/release/wordpress-4.5.2.zip |
+---------+-------------+-------------------------------------------------------------+
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

### wp core download

Reference: <https://developer.wordpress.org/cli/commands/core/download/>

Downloads core WordPress files.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Downloads and extracts WordPress core files to the specified path. Uses current directory when no path is specified. Downloaded build is verified to have the correct md5 and then cached to the local filesystem. Subsequent uses of command will use the local cache if it still exists.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<download-url>]`
  Download directly from a provided URL instead of fetching the URL from the wordpress.org servers.
- `[--path=<path>]`
  Specify the path in which to install WordPress. Defaults to current directory.
- `[--locale=<locale>]`
  Select which language you want to download.
- `[--version=<version>]`
  Select which version you want to download. Accepts a version number, 'latest' or 'nightly'.
- `[--skip-content]`
  Download WP without the default themes and plugins.
- `[--force]`
  Overwrites existing files, if present.
- `[--insecure]`
  Retry download without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.
- `[--extract]`
  Whether to extract the downloaded file. Defaults to true.

#### Examples

```bash
$ wp core download --locale=nl_NL
Downloading WordPress 4.5.2 (nl_NL)...
md5 hash verified: c5366d05b521831dd0b29dfc386e56a5
Success: WordPress downloaded.
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

### wp core install

Reference: <https://developer.wordpress.org/cli/commands/core/install/>

Runs the standard WordPress installation process.

Creates the WordPress tables in the database using the URL, title, and default admin user details provided. Performs the famous 5 minute install in seconds or less. Note: if you've installed WordPress in a subdirectory, then you'll need to `wp option update siteurl` after `wp core install`. For instance, if WordPress is installed in the `/wp` directory and your domain is example.com, then you'll need to run `wp option update siteurl http://example.com/wp` for your WordPress installation to function properly. Note: When using custom user tables (e.g. `CUSTOM_USER_TABLE`), the admin email and password are ignored if the user_login already exists. If the user_login doesn't exist, a new user will be created.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `--url=<url>`
  The address of the new site.
- `--title=<site-title>`
  The title of the new site.
- `--admin_user=<username>`
  The name of the admin user.
- `[--admin_password=<password>]`
  The password for the admin user. Defaults to randomly generated string.
- `--admin_email=<email>`
  The email address for the admin user.
- `[--locale=<locale>]`
  The locale/language for the installation (e.g. `de_DE`). Default is `en_US`.
- `[--skip-email]`
  Don't send an email notification to the new admin user.

#### Examples

```bash
# Install WordPress in 5 seconds
$ wp core install --url=example.com --title=Example --admin_user=supervisor --admin_password=strongpassword --admin_email=info@example.com
Success: WordPress installed successfully.

# Install WordPress without disclosing admin_password to bash history
$ wp core install --url=example.com --title=Example --admin_user=supervisor --admin_email=info@example.com --prompt=admin_password < admin_password.txt
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

### wp core install-network

Reference: <https://developer.wordpress.org/cli/commands/core/install-network/>

Transforms an existing single-site installation into a multisite installation.

This is an alias for `wp core multisite-convert`. Creates the multisite database tables, and adds the multisite constants to wp-config.php. For those using WordPress with Apache, remember to update the `.htaccess` file with the appropriate multisite rewrite rules. [Review the multisite documentation](https://wordpress.org/support/article/create-a-network/) for more details about how multisite works.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--title=<network-title>]`
  The title of the new network.
- `[--base=<url-path>]`
  Base path after the domain name that each site url will start with.
  - default: /
- `[--subdomains]`
  If passed, the network will use subdomains, instead of subdirectories. Doesn't work with 'localhost'.
- `[--skip-config]`
  Don't add multisite constants to wp-config.php.

#### Examples

```bash
$ wp core multisite-convert
Set up multisite database tables.
Added multisite constants to wp-config.php.
Success: Network installed. Don't forget to set up rewrite rules.
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

### wp core is-installed

Reference: <https://developer.wordpress.org/cli/commands/core/is-installed/>

Checks if WordPress is installed.

Determines whether WordPress is installed by checking if the standard database tables are installed. Doesn't produce output; uses exit codes to communicate whether WordPress is installed.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--network]`
  Check if this is a multisite installation.

#### Examples

```bash
# Bash script for checking if WordPress is not installed.

if ! wp core is-installed 2>/dev/null; then
    # WP is not installed. Let's try installing it.
    wp core install
fi

# Bash script for checking if WordPress is installed, with fallback.

if wp core is-installed 2>/dev/null; then
    # WP is installed. Let's do some things we should only do in a confirmed WP environment.
    wp core verify-checksums
else
    # Fallback if WP is not installed.
    echo 'Hey Friend, you are in the wrong spot. Move in to your WordPress directory and try again.'
fi
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

### wp core multisite-convert

Reference: <https://developer.wordpress.org/cli/commands/core/multisite-convert/>

Transforms an existing single-site installation into a multisite installation.

**Alias:** `install-network` Creates the multisite database tables, and adds the multisite constants to wp-config.php. For those using WordPress with Apache, remember to update the `.htaccess` file with the appropriate multisite rewrite rules. [Review the multisite documentation](https://wordpress.org/support/article/create-a-network/) for more details about how multisite works.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--title=<network-title>]`
  The title of the new network.
- `[--base=<url-path>]`
  Base path after the domain name that each site url will start with.
  - default: /
- `[--subdomains]`
  If passed, the network will use subdomains, instead of subdirectories. Doesn't work with 'localhost'.
- `[--skip-config]`
  Don't add multisite constants to wp-config.php.

#### Examples

```bash
$ wp core multisite-convert
Set up multisite database tables.
Added multisite constants to wp-config.php.
Success: Network installed. Don't forget to set up rewrite rules.
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

### wp core multisite-install

Reference: <https://developer.wordpress.org/cli/commands/core/multisite-install/>

Installs WordPress multisite from scratch.

Creates the WordPress tables in the database using the URL, title, and default admin user details provided. Then, creates the multisite tables in the database and adds multisite constants to the wp-config.php. For those using WordPress with Apache, remember to update the `.htaccess` file with the appropriate multisite rewrite rules.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--url=<url>]`
  The address of the new site.
- `[--base=<url-path>]`
  Base path after the domain name that each site url in the network will start with.
  - default: /
- `[--subdomains]`
  If passed, the network will use subdomains, instead of subdirectories. Doesn't work with 'localhost'.
- `--title=<site-title>`
  The title of the new site.
- `--admin_user=<username>`
  The name of the admin user.
  - default: admin
- `[--admin_password=<password>]`
  The password for the admin user. Defaults to randomly generated string.
- `--admin_email=<email>`
  The email address for the admin user.
- `[--skip-email]`
  Don't send an email notification to the new admin user.
- `[--skip-config]`
  Don't add multisite constants to wp-config.php.

#### Examples

```bash
$ wp core multisite-install --title="Welcome to the WordPress" \
> --admin_user="admin" --admin_password="password" \
> --admin_email="user@example.com"
Single site database tables already present.
Set up multisite database tables.
Added multisite constants to wp-config.php.
Success: Network installed. Don't forget to set up rewrite rules.
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

### wp core update

Reference: <https://developer.wordpress.org/cli/commands/core/update/>

Updates WordPress to a newer version.

**Alias:** `upgrade` Defaults to updating WordPress to the latest version. If you see "Error: Another update is currently in progress.", you may need to run `wp option delete core_updater.lock` after verifying another update isn't actually running.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<zip>]`
  Path to zip file to use, instead of downloading from wordpress.org.
- `[--minor]`
  Only perform updates for minor releases (e.g. update from WP 4.3 to 4.3.3 instead of 4.4.2).
- `[--version=<version>]`
  Update to a specific version, instead of to the latest version. Alternatively accepts 'nightly'.
- `[--force]`
  Update even when installed WP version is greater than the requested version.
- `[--locale=<locale>]`
  Select which language you want to download.
- `[--insecure]`
  Retry download without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Update WordPress
$ wp core update
Updating to version 4.5.2 (en_US)...
Downloading update from https://downloads.wordpress.org/release/wordpress-4.5.2-no-content.zip...
Unpacking the update...
Cleaning up files...
No files found that need cleaning up
Success: WordPress updated successfully.

# Update WordPress using zip file.
$ wp core update ../latest.zip
Starting update...
Unpacking the update...
Success: WordPress updated successfully.

# Update WordPress to 3.1 forcefully
$ wp core update --version=3.1 --force
Updating to version 3.1 (en_US)...
Downloading update from https://wordpress.org/wordpress-3.1.zip...
Unpacking the update...
Warning: Checksums not available for WordPress 3.1/en_US. Please cleanup files manually.
Success: WordPress updated successfully.
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

### wp core update-db

Reference: <https://developer.wordpress.org/cli/commands/core/update-db/>

Runs the WordPress database update procedure.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--network]`
  Update databases for all sites on a network
- `[--dry-run]`
  Compare database versions without performing the update.

#### Examples

```bash
# Update the WordPress database.
$ wp core update-db
Success: WordPress database upgraded successfully from db version 36686 to 35700.

# Update databases for all sites on a network.
$ wp core update-db --network
WordPress database upgraded successfully from db version 35700 to 29630 on example.com/
Success: WordPress database upgraded on 123/123 sites.
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

### wp core upgrade

Reference: <https://developer.wordpress.org/cli/commands/core/upgrade/>

Updates WordPress to a newer version.

This is an alias for `wp core update`. Defaults to updating WordPress to the latest version. If you see "Error: Another update is currently in progress.", you may need to run `wp option delete core_updater.lock` after verifying another update isn't actually running.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<zip>]`
  Path to zip file to use, instead of downloading from wordpress.org.
- `[--minor]`
  Only perform updates for minor releases (e.g. update from WP 4.3 to 4.3.3 instead of 4.4.2).
- `[--version=<version>]`
  Update to a specific version, instead of to the latest version. Alternatively accepts 'nightly'.
- `[--force]`
  Update even when installed WP version is greater than the requested version.
- `[--locale=<locale>]`
  Select which language you want to download.
- `[--insecure]`
  Retry download without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.

#### Examples

```bash
# Update WordPress
$ wp core update
Updating to version 4.5.2 (en_US)...
Downloading update from https://downloads.wordpress.org/release/wordpress-4.5.2-no-content.zip...
Unpacking the update...
Cleaning up files...
No files found that need cleaning up
Success: WordPress updated successfully.

# Update WordPress using zip file.
$ wp core update ../latest.zip
Starting update...
Unpacking the update...
Success: WordPress updated successfully.

# Update WordPress to 3.1 forcefully
$ wp core update --version=3.1 --force
Updating to version 3.1 (en_US)...
Downloading update from https://wordpress.org/wordpress-3.1.zip...
Unpacking the update...
Warning: Checksums not available for WordPress 3.1/en_US. Please cleanup files manually.
Success: WordPress updated successfully.
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

### wp core verify-checksums

Reference: <https://developer.wordpress.org/cli/commands/core/verify-checksums/>

Verifies WordPress files against WordPress.org's checksums.

This command runs on the `before_wp_load` hook, just before the WP load process begins. Downloads md5 checksums for the current version from WordPress.org, and compares those checksums against the currently installed files. For security, avoids loading WordPress when verifying checksums. If you experience issues verifying from this command, ensure you are passing the relevant `--locale` and `--version` arguments according to the values from the `Dashboard->Updates` menu in the admin area of the site.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--include-root]`
  Verify all files and folders in the root directory, and warn if any non-WordPress items are found.
- `[--version=<version>]`
  Verify checksums against a specific version of WordPress.
- `[--locale=<locale>]`
  Verify checksums against a specific locale of WordPress.
- `[--insecure]`
  Retry downloads without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.
- `[--exclude=<files>]`
  Exclude specific files from the checksum verification. Provide a comma-separated list of file paths.
- `[--format=<format>]`
  Render output in a specific format. When provided, messages are displayed in the chosen format.
  - default: plain
  - options:
  - plain
  - table
  - json
  - csv
  - yaml
  - count

#### Examples

```bash
# Verify checksums
$ wp core verify-checksums
Success: WordPress installation verifies against checksums.

# Verify checksums for given WordPress version
$ wp core verify-checksums --version=4.0
Success: WordPress installation verifies against checksums.

# Verify checksums for given locale
$ wp core verify-checksums --locale=en_US
Success: WordPress installation verifies against checksums.

# Verify checksums for given locale
$ wp core verify-checksums --locale=ja
Warning: File doesn't verify against checksum: wp-includes/version.php
Warning: File doesn't verify against checksum: readme.html
Warning: File doesn't verify against checksum: wp-config-sample.php
Error: WordPress installation doesn't verify against checksums.

# Verify checksums and exclude files
$ wp core verify-checksums --exclude="readme.html"
Success: WordPress installation verifies against checksums.

# Verify checksums with formatted output
$ wp core verify-checksums --format=json
[{"file":"readme.html","message":"File doesn't verify against checksum"}]
Error: WordPress installation doesn't verify against checksums.
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

### wp core version

Reference: <https://developer.wordpress.org/cli/commands/core/version/>

Displays the WordPress version.

This command runs on the `before_wp_load` hook, just before the WP load process begins.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--extra]`
  Show extended version information.

#### Examples

```bash
# Display the WordPress version
$ wp core version
4.5.2

# Display WordPress version along with other information
$ wp core version --extra
WordPress version: 4.5.2
Database revision: 36686
TinyMCE version:   4.310 (4310-20160418)
Package language:  en_US
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
