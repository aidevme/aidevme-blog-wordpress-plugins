# wp user

Reference: <https://developer.wordpress.org/cli/commands/user/>

## Description

Manages users, along with their roles, capabilities, and meta.

## Synopsis

```bash
wp user <command>
```

See references for [Roles and Capabilities](https://wordpress.org/documentation/article/roles-and-capabilities) and [WP User class](https://developer.wordpress.org/reference/classes/wp_user).

## Examples

```bash
# List user IDs
$ wp user list --field=ID
1

# Create a new user.
$ wp user create bob bob@example.com --role=author
Success: Created user 3.
Password: k9**&amp;I4vNH(&amp;

# Update an existing user.
$ wp user update 123 --display_name=Mary --user_pass=marypass
Success: Updated user 123.

# Delete user 123 and reassign posts to user 567
$ wp user delete 123 --reassign=567
Success: Removed user 123 from http://example.com.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp user add-cap](https://developer.wordpress.org/cli/commands/user/add-cap/) | Adds a capability to a user. |
| [wp user add-role](https://developer.wordpress.org/cli/commands/user/add-role/) | Adds a role for a user. |
| [wp user application-password](https://developer.wordpress.org/cli/commands/user/application-password/) | Creates, updates, deletes, lists and retrieves application passwords. |
| [wp user check-password](https://developer.wordpress.org/cli/commands/user/check-password/) | Checks if a user's password is valid or not. |
| [wp user create](https://developer.wordpress.org/cli/commands/user/create/) | Creates a new user. |
| [wp user delete](https://developer.wordpress.org/cli/commands/user/delete/) | Deletes one or more users from the current site. |
| [wp user exists](https://developer.wordpress.org/cli/commands/user/exists/) | Verifies whether a user exists. |
| [wp user generate](https://developer.wordpress.org/cli/commands/user/generate/) | Generates some users. |
| [wp user get](https://developer.wordpress.org/cli/commands/user/get/) | Gets details about a user. |
| [wp user import-csv](https://developer.wordpress.org/cli/commands/user/import-csv/) | Imports users from a CSV file. |
| [wp user list](https://developer.wordpress.org/cli/commands/user/list/) | Lists users. |
| [wp user list-caps](https://developer.wordpress.org/cli/commands/user/list-caps/) | Lists all capabilities for a user. |
| [wp user meta](https://developer.wordpress.org/cli/commands/user/meta/) | Adds, updates, deletes, and lists user custom fields. |
| [wp user remove-cap](https://developer.wordpress.org/cli/commands/user/remove-cap/) | Removes a user's capability. |
| [wp user remove-role](https://developer.wordpress.org/cli/commands/user/remove-role/) | Removes a user's role. |
| [wp user reset-password](https://developer.wordpress.org/cli/commands/user/reset-password/) | Resets the password for one or more users. |
| [wp user session](https://developer.wordpress.org/cli/commands/user/session/) | Destroys and lists a user's sessions. |
| [wp user set-role](https://developer.wordpress.org/cli/commands/user/set-role/) | Sets the user role. |
| [wp user signup](https://developer.wordpress.org/cli/commands/user/signup/) | Manages signups on a multisite installation. |
| [wp user spam](https://developer.wordpress.org/cli/commands/user/spam/) | Marks one or more users as spam on multisite. |
| [wp user term](https://developer.wordpress.org/cli/commands/user/term/) | Adds, updates, removes, and lists user terms. |
| [wp user unspam](https://developer.wordpress.org/cli/commands/user/unspam/) | Removes one or more users from spam on multisite. |
| [wp user update](https://developer.wordpress.org/cli/commands/user/update/) | Updates an existing user. |

### wp user add-cap

Reference: <https://developer.wordpress.org/cli/commands/user/add-cap/>

Adds a capability to a user.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or user login.
- `<cap>`
  The capability to add.

#### Examples

```bash
# Add a capability for a user
$ wp user add-cap john create_premium_item
Success: Added 'create_premium_item' capability for john (16).

# Add a capability for a user
$ wp user add-cap 15 edit_product
Success: Added 'edit_product' capability for johndoe (15).
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

### wp user add-role

Reference: <https://developer.wordpress.org/cli/commands/user/add-role/>

Adds a role for a user.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or user login.
- `[<role>…]`
  Add the specified role(s) to the user.

#### Examples

```bash
$ wp user add-role 12 author
Success: Added 'author' role for johndoe (12).

$ wp user add-role 12 author editor
Success: Added 'author', 'editor' roles for johndoe (12).
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

### wp user application-password <command>

Reference: <https://developer.wordpress.org/cli/commands/user/application-password/>

Creates, updates, deletes, lists and retrieves application passwords.

#### Examples

```bash
# List user application passwords and only show app name and password hash
$ wp user application-password list 123 --fields=name,password
+--------+------------------------------------+
| name   | password                           |
+--------+------------------------------------+
| myapp  | $P$BVGeou1CUot114YohIemgpwxQCzb8O/ |
+--------+------------------------------------+

# Get a specific application password and only show app name and created timestamp
$ wp user application-password get 123 6633824d-c1d7-4f79-9dd5-4586f734d69e --fields=name,created
+--------+------------+
| name   | created    |
+--------+------------+
| myapp  | 1638395611 |
+--------+------------+

# Create user application password
$ wp user application-password create 123 myapp
Success: Created application password.
Password: ZG1bxdxdzjTwhsY8vK8l1C65

# Only print the password without any chrome
$ wp user application-password create 123 myapp --porcelain
ZG1bxdxdzjTwhsY8vK8l1C65

# Update an existing application password
$ wp user application-password update 123 6633824d-c1d7-4f79-9dd5-4586f734d69e --name=newappname
Success: Updated application password.

# Delete an existing application password
$ wp user application-password delete 123 6633824d-c1d7-4f79-9dd5-4586f734d69e
Success: Deleted 1 of 1 application password.

# Check if an application password for a given application exists
$ wp user application-password exists 123 myapp
$ echo $?
1

# Bash script for checking whether an application password exists and creating one if not
if ! wp user application-password exists 123 myapp; then
    PASSWORD=$(wp user application-password create 123 myapp --porcelain)
fi
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp user application-password create](https://developer.wordpress.org/cli/commands/user/application-password/create/) | Creates a new application password. |
| [wp user application-password delete](https://developer.wordpress.org/cli/commands/user/application-password/delete/) | Delete an existing application password. |
| [wp user application-password exists](https://developer.wordpress.org/cli/commands/user/application-password/exists/) | Checks whether an application password for a given application exists. |
| [wp user application-password get](https://developer.wordpress.org/cli/commands/user/application-password/get/) | Gets a specific application password. |
| [wp user application-password list](https://developer.wordpress.org/cli/commands/user/application-password/list/) | Lists all application passwords associated with a user. |
| [wp user application-password record-usage](https://developer.wordpress.org/cli/commands/user/application-password/record-usage/) | Record usage of an application password. |
| [wp user application-password update](https://developer.wordpress.org/cli/commands/user/application-password/update/) | Updates an existing application password. |

#### wp user application-password create

Reference: <https://developer.wordpress.org/cli/commands/user/application-password/create/>

Creates a new application password.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to create a new application password for.
- `<app-name>`
  Unique name of the application to create an application password for.
- `[--app-id=<app-id>]`
  Application ID to attribute to the application password.
- `[--porcelain]`
  Output just the new password.

##### Examples

```bash
# Create user application password
$ wp user application-password create 123 myapp
Success: Created application password.
Password: ZG1bxdxdzjTwhsY8vK8l1C65

# Only print the password without any chrome
$ wp user application-password create 123 myapp --porcelain
ZG1bxdxdzjTwhsY8vK8l1C65

# Create user application with a custom application ID for internal tracking
$ wp user application-password create 123 myapp --app-id=42 --porcelain
ZG1bxdxdzjTwhsY8vK8l1C65
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

#### wp user application-password delete

Reference: <https://developer.wordpress.org/cli/commands/user/application-password/delete/>

Delete an existing application password.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to delete the application password for.
- `[<uuid>…]`
  Comma-separated list of UUIDs of the application passwords to delete.
- `[--all]`
  Delete all of the user's application password.

##### Examples

```bash
# Delete an existing application password
$ wp user application-password delete 123 6633824d-c1d7-4f79-9dd5-4586f734d69e
Success: Deleted 1 of 1 application password.

# Delete all of the user's application passwords
$ wp user application-password delete 123 --all
Success: Deleted all application passwords.
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

#### wp user application-password exists

Reference: <https://developer.wordpress.org/cli/commands/user/application-password/exists/>

Checks whether an application password for a given application exists.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to check the existence of an application password for.
- `<app-name>`
  Name of the application to check the existence of an application password for.

##### Examples

```bash
# Check if an application password for a given application exists
$ wp user application-password exists 123 myapp
$ echo $?
1

# Bash script for checking whether an application password exists and creating one if not
if ! wp user application-password exists 123 myapp; then
    PASSWORD=$(wp user application-password create 123 myapp --porcelain)
fi
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

#### wp user application-password get

Reference: <https://developer.wordpress.org/cli/commands/user/application-password/get/>

Gets a specific application password.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to get the application password for.
- `<uuid>`
  The universally unique ID of the application password.
- `[--field=<field>]`
  Prints the value of a single field for the application password.
- `[--fields=<fields>]`
  Limit the output to specific fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml

##### Examples

```bash
# Get a specific application password and only show app name and created timestamp
$ wp user application-password get 123 6633824d-c1d7-4f79-9dd5-4586f734d69e --fields=name,created
+--------+------------+
| name   | created    |
+--------+------------+
| myapp  | 1638395611 |
+--------+------------+
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

#### wp user application-password list

Reference: <https://developer.wordpress.org/cli/commands/user/application-password/list/>

Lists all application passwords associated with a user.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to get application passwords for.
- `[--<field>=<value>]`
  Filter the list by a specific field.
- `[--field=<field>]`
  Prints the value of a single field for each application password.
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
  - yaml
  - ids
- `[--orderby=<fields>]`
  Set orderby which field.
  - default: created
  - options:
  - uuid
  - app_id
  - name
  - password
  - created
  - last_used
  - last_ip
- `[--order=<order>]`
  Set ascending or descending order.
  - default: desc
  - options:
  - asc
  - desc

##### Examples

```bash
# List user application passwords and only show app name and password hash
$ wp user application-password list 123 --fields=name,password
+--------+------------------------------------+
| name   | password                           |
+--------+------------------------------------+
| myapp  | $P$BVGeou1CUot114YohIemgpwxQCzb8O/ |
+--------+------------------------------------+
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

#### wp user application-password record-usage

Reference: <https://developer.wordpress.org/cli/commands/user/application-password/record-usage/>

Record usage of an application password.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to update the application password for.
- `<uuid>`
  The universally unique ID of the application password.

##### Examples

```bash
# Record usage of an application password
$ wp user application-password record-usage 123 6633824d-c1d7-4f79-9dd5-4586f734d69e
Success: Recorded application password usage.
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

#### wp user application-password update

Reference: <https://developer.wordpress.org/cli/commands/user/application-password/update/>

Updates an existing application password.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to update the application password for.
- `<uuid>`
  The universally unique ID of the application password.
- `[--<field>=<value>]`
  Update the <field> with a new <value>. Currently supported fields: name.

##### Examples

```bash
# Update an existing application password
$ wp user application-password update 123 6633824d-c1d7-4f79-9dd5-4586f734d69e --name=newappname
Success: Updated application password.
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

### wp user check-password

Reference: <https://developer.wordpress.org/cli/commands/user/check-password/>

Checks if a user's password is valid or not.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email or user ID of the user to check credentials for.
- `<user_pass>`
  A string that contains the plain text password for the user.
- `[--escape-chars]`
  Escape password with `wp_slash()` to mimic the same behavior as `wp-login.php`.

#### Examples

```bash
# Check whether given credentials are valid; exit status 0 if valid, otherwise 1
$ wp user check-password admin adminpass
$ echo $?
1

# Bash script for checking whether given credentials are valid or not
if ! $(wp user check-password admin adminpass); then
 notify-send "Invalid Credentials";
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

### wp user create

Reference: <https://developer.wordpress.org/cli/commands/user/create/>

Creates a new user.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user-login>`
  The login of the user to create.
- `<user-email>`
  The email address of the user to create.
- `[--role=<role>]`
  The role of the user to create. Default: default role. Possible values include 'administrator', 'editor', 'author', 'contributor', 'subscriber'.
- `[--user_pass=<password>]`
  The user password. Default: randomly generated.
- `[--user_registered=<yyyy-mm-dd-hh-ii-ss>]`
  The date the user registered. Default: current date.
- `[--display_name=<name>]`
  The display name.
- `[--user_nicename=<nice_name>]`
  A string that contains a URL-friendly name for the user. The default is the user's username.
- `[--user_url=<url>]`
  A string containing the user's URL for the user's web site.
- `[--nickname=<nickname>]`
  The user's nickname, defaults to the user's username.
- `[--first_name=<first_name>]`
  The user's first name.
- `[--last_name=<last_name>]`
  The user's last name.
- `[--description=<description>]`
  A string containing content about the user.
- `[--rich_editing=<rich_editing>]`
  A string for whether to enable the rich editor or not. False if not empty.
- `[--send-email]`
  Send an email to the user with their new account details.
- `[--porcelain]`
  Output just the new user id.

#### Examples

```bash
# Create user
$ wp user create bob bob@example.com --role=author
Success: Created user 3.
Password: k9**&amp;I4vNH(&amp;

# Create user without showing password upon success
$ wp user create ann ann@example.com --porcelain
4
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

### wp user delete

Reference: <https://developer.wordpress.org/cli/commands/user/delete/>

Deletes one or more users from the current site.

On multisite, `wp user delete` only removes the user from the current site. Include `--network` to also remove the user from the database, but make sure to reassign their posts prior to deleting the user.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>…`
  The user login, user email, or user ID of the user(s) to delete.
- `[--network]`
  On multisite, delete the user from the entire network.
- `[--reassign=<user-id>]`
  User ID to reassign the posts to.
- `[--yes]`
  Answer yes to any confirmation prompts.

#### Examples

```bash
# Delete user 123 and reassign posts to user 567
$ wp user delete 123 --reassign=567
Success: Removed user 123 from http://example.com.

# Delete all contributors and reassign their posts to user 2
$ wp user delete $(wp user list --role=contributor --field=ID) --reassign=2
Success: Removed user 813 from http://example.com.
Success: Removed user 578 from http://example.com.

# Delete all contributors in batches of 100 (avoid error: argument list too long: wp)
$ wp user delete $(wp user list --role=contributor --field=ID | head -n 100)
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

### wp user exists

Reference: <https://developer.wordpress.org/cli/commands/user/exists/>

Verifies whether a user exists.

Displays a success message if the user does exist.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the user to check.

#### Examples

```bash
# The user exists.
$ wp user exists 1337
Success: User with ID 1337 exists.
$ echo $?
0

# The user does not exist.
$ wp user exists 10000
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

### wp user generate

Reference: <https://developer.wordpress.org/cli/commands/user/generate/>

Generates some users.

Creates a specified number of new users with dummy data.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--count=<number>]`
  How many users to generate?
  - default: 100
- `[--role=<role>]`
  The role of the generated users. Default: default role from WP
- `[--format=<format>]`
  Render output in a particular format.
  - default: progress
  - options:
  - progress
  - ids

#### Examples

```bash
# Add meta to every generated users.
$ wp user generate --format=ids --count=3 | xargs -d ' ' -I % wp user meta add % foo bar
Success: Added custom field.
Success: Added custom field.
Success: Added custom field.
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

### wp user get

Reference: <https://developer.wordpress.org/cli/commands/user/get/>

Gets details about a user.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or user login.
- `[--field=<field>]`
  Instead of returning the whole user, returns the value of a single field.
- `[--fields=<fields>]`
  Get a specific subset of the user's fields.
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
# Get user
$ wp user get 12 --field=login
supervisor

# Get user and export to JSON file
$ wp user get bob --format=json > bob.json
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

### wp user import-csv

Reference: <https://developer.wordpress.org/cli/commands/user/import-csv/>

Imports users from a CSV file.

If the user already exists (matching the email address or login), then the user is updated unless the `--skip-update` flag is used.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<file>`
  The local or remote CSV file of users to import. If '-', then reads from STDIN.
- `[--send-email]`
  Send an email to new users with their account details.
- `[--skip-update]`
  Don't update users that already exist.

#### Examples

```bash
# Import users from local CSV file
$ wp user import-csv /path/to/users.csv
Success: bobjones created.
Success: newuser1 created.
Success: existinguser created.

# Import users from remote CSV file
$ wp user import-csv http://example.com/users.csv

Sample users.csv file:

user_login,user_email,display_name,role
bobjones,bobjones@example.com,Bob Jones,contributor
newuser1,newuser1@example.com,New User,author
existinguser,existinguser@example.com,Existing User,administrator
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

### wp user list

Reference: <https://developer.wordpress.org/cli/commands/user/list/>

Lists users.

Display WordPress users based on all arguments supported by [WP_User_Query()](https://developer.wordpress.org/reference/classes/wp_user_query/prepare_query/).

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--role=<role>]`
  Only display users with a certain role.
- `[--<field>=<value>]`
  Control output by one or more arguments of [WP_User_Query](https://developer.wordpress.org/reference/classes/wp_user_query/)().
- `[--network]`
  List all users in the network for multisite.
- `[--field=<field>]`
  Prints the value of a single field for each user.
- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - ids
  - json
  - count
  - yaml

#### Available Fields

These fields will be displayed by default for each user:

- ID
- user_login
- display_name
- user_email
- user_registered
- roles

These fields are optionally available:

- user_pass
- user_nicename
- user_url
- user_activation_key
- user_status
- spam
- deleted
- caps
- cap_key
- allcaps
- filter
- url

#### Examples

```bash
# List user IDs
$ wp user list --field=ID
1

# List users with administrator role
$ wp user list --role=administrator --format=csv
ID,user_login,display_name,user_email,user_registered,roles
1,supervisor,supervisor,supervisor@gmail.com,"2016-06-03 04:37:00",administrator

# List users with only given fields
$ wp user list --fields=display_name,user_email --format=json
[{"display_name":"supervisor","user_email":"supervisor@gmail.com"}]

# List users ordered by the 'last_activity' meta value.
$ wp user list --meta_key=last_activity --orderby=meta_value_num
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

### wp user list-caps

Reference: <https://developer.wordpress.org/cli/commands/user/list-caps/>

Lists all capabilities for a user.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or login.
- `[--format=<format>]`
  Render output in a particular format.
  - default: list
  - options:
  - list
  - table
  - csv
  - json
  - count
  - yaml
- `[--origin=<origin>]`
  Render output in a particular format.
  - default: all
  - options:
  - all
  - user
  - role
- `[--exclude-role-names]`
  Exclude capabilities that match role names from output.

#### Examples

```bash
$ wp user list-caps 21
edit_product
create_premium_item
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

### wp user meta <command>

Reference: <https://developer.wordpress.org/cli/commands/user/meta/>

Adds, updates, deletes, and lists user custom fields.

#### Examples

```bash
# Add user meta
$ wp user meta add 123 bio "Mary is an WordPress developer."
Success: Added custom field.

# List user meta
$ wp user meta list 123 --keys=nickname,description,wp_capabilities
+---------+-----------------+--------------------------------+
| user_id | meta_key        | meta_value                     |
+---------+-----------------+--------------------------------+
| 123     | nickname        | supervisor                     |
| 123     | description     | Mary is a WordPress developer. |
| 123     | wp_capabilities | {"administrator":true}         |
+---------+-----------------+--------------------------------+

# Update user meta
$ wp user meta update 123 bio "Mary is an awesome WordPress developer."
Success: Updated custom field 'bio'.

# Delete user meta
$ wp user meta delete 123 bio
Success: Deleted custom field.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp user meta add](https://developer.wordpress.org/cli/commands/user/meta/add/) | Adds a meta field. |
| [wp user meta delete](https://developer.wordpress.org/cli/commands/user/meta/delete/) | Deletes a meta field. |
| [wp user meta get](https://developer.wordpress.org/cli/commands/user/meta/get/) | Gets meta field value. |
| [wp user meta list](https://developer.wordpress.org/cli/commands/user/meta/list/) | Lists all metadata associated with a user. |
| [wp user meta patch](https://developer.wordpress.org/cli/commands/user/meta/patch/) | Update a nested value for a meta field. |
| [wp user meta pluck](https://developer.wordpress.org/cli/commands/user/meta/pluck/) | Get a nested value from a meta field. |
| [wp user meta set](https://developer.wordpress.org/cli/commands/user/meta/set/) | Updates a meta field. |
| [wp user meta update](https://developer.wordpress.org/cli/commands/user/meta/update/) | Updates a meta field. |

#### wp user meta add

Reference: <https://developer.wordpress.org/cli/commands/user/meta/add/>

Adds a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to add metadata for.
- `<key>`
  The metadata key.
- `<value>`
  The new metadata value.
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

##### Examples

```bash
# Add user meta
$ wp user meta add 123 bio "Mary is an WordPress developer."
Success: Added custom field.
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

#### wp user meta delete

Reference: <https://developer.wordpress.org/cli/commands/user/meta/delete/>

Deletes a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to delete metadata from.
- `<key>`
  The metadata key.
- `[<value>]`
  The value to delete. If omitted, all rows with key will deleted.

##### Examples

```bash
# Delete user meta
$ wp user meta delete 123 bio
Success: Deleted custom field.
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

#### wp user meta get

Reference: <https://developer.wordpress.org/cli/commands/user/meta/get/>

Gets meta field value.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to get metadata for.
- `<key>`
  The metadata key.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml

##### Examples

```bash
# Get user meta
$ wp user meta get 123 bio
Mary is an WordPress developer.

# Get the primary site of a user (for multisite)
$ wp user meta get 2 primary_blog
3
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

#### wp user meta list

Reference: <https://developer.wordpress.org/cli/commands/user/meta/list/>

Lists all metadata associated with a user.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to get metadata for.
- `[--keys=<keys>]`
  Limit output to metadata of specific keys.
- `[--fields=<fields>]`
  Limit the output to specific row fields. Defaults to id,meta_key,meta_value.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - count
  - yaml
- `[--orderby=<fields>]`
  Set orderby which field.
  - default: id
  - options:
  - id
  - meta_key
  - meta_value
- `[--order=<order>]`
  Set ascending or descending order.
  - default: asc
  - options:
  - asc
  - desc
- `[--unserialize]`
  Unserialize meta_value output.

##### Examples

```bash
# List user meta
$ wp user meta list 123 --keys=nickname,description,wp_capabilities
+---------+-----------------+--------------------------------+
| user_id | meta_key        | meta_value                     |
+---------+-----------------+--------------------------------+
| 123     | nickname        | supervisor                     |
| 123     | description     | Mary is a WordPress developer. |
| 123     | wp_capabilities | {"administrator":true}         |
+---------+-----------------+--------------------------------+
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

#### wp user meta patch

Reference: <https://developer.wordpress.org/cli/commands/user/meta/patch/>

Update a nested value for a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<action>`
  Patch action to perform.
  - options:
  - insert
  - update
  - delete
- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to update.
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

#### wp user meta pluck

Reference: <https://developer.wordpress.org/cli/commands/user/meta/pluck/>

Get a nested value from a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to get.
- `<key-path>…`
  The name(s) of the keys within the value to locate the value to pluck.
- `[--format=<format>]`
  The output format of the value.
  -–
  - default: plaintext
  - options:
  - plaintext
  - json
  - yaml

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

#### wp user meta set

Reference: <https://developer.wordpress.org/cli/commands/user/meta/set/>

Updates a meta field.

This is an alias for `wp user meta update`.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to update metadata for.
- `<key>`
  The metadata key.
- `<value>`
  The new metadata value.
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

##### Examples

```bash
# Update user meta
$ wp user meta update 123 bio "Mary is an awesome WordPress developer."
Success: Updated custom field 'bio'.
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

#### wp user meta update

Reference: <https://developer.wordpress.org/cli/commands/user/meta/update/>

Updates a meta field.

**Alias:** `set`

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  The user login, user email, or user ID of the user to update metadata for.
- `<key>`
  The metadata key.
- `<value>`
  The new metadata value.
- `[--format=<format>]`
  The serialization format for the value.
  - default: plaintext
  - options:
  - plaintext
  - json

##### Examples

```bash
# Update user meta
$ wp user meta update 123 bio "Mary is an awesome WordPress developer."
Success: Updated custom field 'bio'.
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

### wp user remove-cap

Reference: <https://developer.wordpress.org/cli/commands/user/remove-cap/>

Removes a user's capability.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or user login.
- `<cap>`
  The capability to be removed.
- `[--force]`
  Forcefully remove a capability.

#### Examples

```bash
$ wp user remove-cap 11 publish_newsletters
Success: Removed 'publish_newsletters' cap for supervisor (11).

$ wp user remove-cap 11 publish_posts
Error: The 'publish_posts' cap for supervisor (11) is inherited from a role.

$ wp user remove-cap 11 nonexistent_cap
Error: No such 'nonexistent_cap' cap for supervisor (11).

$ wp user remove-cap 11 publish_newsletters --force
Success: Removed 'publish_newsletters' cap for supervisor (11).
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

### wp user remove-role

Reference: <https://developer.wordpress.org/cli/commands/user/remove-role/>

Removes a user's role.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or user login.
- `[<role>…]`
  Remove the specified role(s) from the user.

#### Examples

```bash
$ wp user remove-role 12 author
Success: Removed 'author' role for johndoe (12).

$ wp user remove-role 12 author editor
Success: Removed 'author', 'editor' roles for johndoe (12).
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

### wp user reset-password

Reference: <https://developer.wordpress.org/cli/commands/user/reset-password/>

Resets the password for one or more users.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>…`
  one or more user logins or IDs.
- `[--skip-email]`
  Don't send an email notification to the affected user(s).
- `[--show-password]`
  Show the new password(s).
- `[--porcelain]`
  Output only the new password(s).

#### Examples

```bash
# Reset the password for two users and send them the change email.
$ wp user reset-password admin editor
Reset password for admin.
Reset password for editor.
Success: Passwords reset for 2 users.

# Reset and display the password.
$ wp user reset-password editor --show-password
Reset password for editor.
Password: N6hAau0fXZMN#rLCIirdEGOh
Success: Password reset for 1 user.

# Reset the password for one user, displaying only the new password, and not sending the change email.
$ wp user reset-password admin --skip-email --porcelain
yV6BP*!d70wg

# Reset password for all users.
$ wp user reset-password $(wp user list --format=ids)
Reset password for admin.
Reset password for editor.
Reset password for subscriber.
Success: Passwords reset for 3 users.

# Reset password for all users with a particular role.
$ wp user reset-password $(wp user list --format=ids --role=administrator)
Reset password for admin.
Success: Password reset for 1 user.
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

### wp user session <command>

Reference: <https://developer.wordpress.org/cli/commands/user/session/>

Destroys and lists a user's sessions.

#### Examples

```bash
# List a user's sessions.
$ wp user session list admin@example.com --format=csv
login_time,expiration_time,ip,ua
"2016-01-01 12:34:56","2016-02-01 12:34:56",127.0.0.1,"Mozilla/5.0..."

# Destroy the most recent session of the given user.
$ wp user session destroy admin
Success: Destroyed session. 3 sessions remaining.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp user session destroy](https://developer.wordpress.org/cli/commands/user/session/destroy/) | Destroy a session for the given user. |
| [wp user session list](https://developer.wordpress.org/cli/commands/user/session/list/) | List sessions for the given user. |

#### wp user session destroy

Reference: <https://developer.wordpress.org/cli/commands/user/session/destroy/>

Destroy a session for the given user.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or user login.
- `[<token>]`
  The token of the session to destroy. Defaults to the most recently created session.
- `[--all]`
  Destroy all of the user's sessions.

##### Examples

```bash
# Destroy the most recent session of the given user.
$ wp user session destroy admin
Success: Destroyed session. 3 sessions remaining.

# Destroy a specific session of the given user.
$ wp user session destroy admin e073ad8540a9c2...
Success: Destroyed session. 2 sessions remaining.

# Destroy all the sessions of the given user.
$ wp user session destroy admin --all
Success: Destroyed all sessions.

# Destroy all sessions for all users.
$ wp user list --field=ID | xargs -n 1 wp user session destroy --all
Success: Destroyed all sessions.
Success: Destroyed all sessions.
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

#### wp user session list

Reference: <https://developer.wordpress.org/cli/commands/user/session/list/>

List sessions for the given user.

Note: The `token` field does not return the actual token, but a hash of it. The real token is not persisted and can only be found in the corresponding cookies on the client side.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or user login.
- `[--fields=<fields>]`
  Limit the output to specific fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml
  - count
  - ids

##### Available Fields

These fields will be displayed by default for each session:

- token
- login_time
- expiration_time
- ip
- ua

These fields are optionally available:

- expiration
- login

##### Examples

```bash
# List a user's sessions.
$ wp user session list admin@example.com --format=csv
login_time,expiration_time,ip,ua
"2016-01-01 12:34:56","2016-02-01 12:34:56",127.0.0.1,"Mozilla/5.0..."
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

### wp user set-role

Reference: <https://developer.wordpress.org/cli/commands/user/set-role/>

Sets the user role.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>`
  User ID, user email, or user login.
- `[<role>]`
  Make the user have the specified role. If not passed, the default role is used.

#### Examples

```bash
$ wp user set-role 12 author
Success: Added johndoe (12) to http://example.com as author.
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

### wp user signup <command>

Reference: <https://developer.wordpress.org/cli/commands/user/signup/>

Manages signups on a multisite installation.

#### Examples

```bash
# List signups.
$ wp user signup list
+-----------+------------+---------------------+---------------------+--------+------------------+
| signup_id | user_login | user_email          | registered          | active | activation_key   |
+-----------+------------+---------------------+---------------------+--------+------------------+
| 1         | bobuser    | bobuser@example.com | 2024-03-13 05:46:53 | 1      | 7320b2f009266618 |
| 2         | johndoe    | johndoe@example.com | 2024-03-13 06:24:44 | 0      | 9068d859186cd0b5 |
+-----------+------------+---------------------+---------------------+--------+------------------+

# Activate signup.
$ wp user signup activate 2
Signup 2 activated. Password: bZFSGsfzb9xs
Success: Activated 1 of 1 signups.

# Delete signup.
$ wp user signup delete 3
Signup 3 deleted.
Success: Deleted 1 of 1 signups.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp user signup activate](https://developer.wordpress.org/cli/commands/user/signup/activate/) | Activates one or more signups. |
| [wp user signup delete](https://developer.wordpress.org/cli/commands/user/signup/delete/) | Deletes one or more signups. |
| [wp user signup get](https://developer.wordpress.org/cli/commands/user/signup/get/) | Gets details about a signup. |
| [wp user signup list](https://developer.wordpress.org/cli/commands/user/signup/list/) | Lists signups. |

#### wp user signup activate

Reference: <https://developer.wordpress.org/cli/commands/user/signup/activate/>

Activates one or more signups.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<signup>…`
  The signup ID, user login, user email, or activation key of the signup(s) to activate.

##### Examples

```bash
# Activate signup.
$ wp user signup activate 2
Signup 2 activated. Password: bZFSGsfzb9xs
Success: Activated 1 of 1 signups.
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

#### wp user signup delete

Reference: <https://developer.wordpress.org/cli/commands/user/signup/delete/>

Deletes one or more signups.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<signup>…]`
  The signup ID, user login, user email, or activation key of the signup(s) to delete.
- `[--all]`
  If set, all signups will be deleted.

##### Examples

```bash
# Delete signup.
$ wp user signup delete 3
Signup 3 deleted.
Success: Deleted 1 of 1 signups.
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

#### wp user signup get

Reference: <https://developer.wordpress.org/cli/commands/user/signup/get/>

Gets details about a signup.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<signup>`
  The signup ID, user login, user email, or activation key.
- `[--field=<field>]`
  Instead of returning the whole signup, returns the value of a single field.
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

##### Examples

```bash
# Get signup.
$ wp user signup get 1 --field=user_login
bobuser

# Get signup and export to JSON file.
$ wp user signup get bobuser --format=json > bobuser.json
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

#### wp user signup list

Reference: <https://developer.wordpress.org/cli/commands/user/signup/list/>

Lists signups.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--<field>=<value>]`
  Filter the list by a specific field.
- `[--field=<field>]`
  Prints the value of a single field for each signup.
- `[--fields=<fields>]`
  Limit the output to specific object fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - ids
  - json
  - count
  - yaml
- `[--per_page=<per_page>]`
  Limits the signups to the given number. Defaults to none.

##### Available Fields

These fields will be displayed by default for each signup:

- signup_id
- user_login
- user_email
- registered
- active
- activation_key

These fields are optionally available:

- domain
- path
- title
- activated
- meta

##### Examples

```bash
# List signup IDs.
$ wp user signup list --field=signup_id
1

# List all signups.
$ wp user signup list
+-----------+------------+---------------------+---------------------+--------+------------------+
| signup_id | user_login | user_email          | registered          | active | activation_key   |
+-----------+------------+---------------------+---------------------+--------+------------------+
| 1         | bobuser    | bobuser@example.com | 2024-03-13 05:46:53 | 1      | 7320b2f009266618 |
| 2         | johndoe    | johndoe@example.com | 2024-03-13 06:24:44 | 0      | 9068d859186cd0b5 |
+-----------+------------+---------------------+---------------------+--------+------------------+
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

### wp user spam

Reference: <https://developer.wordpress.org/cli/commands/user/spam/>

Marks one or more users as spam on multisite.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>…`
  The user login, user email, or user ID of the user(s) to mark as spam.

#### Examples

```bash
# Mark user as spam.
$ wp user spam 123
User 123 marked as spam.
Success: Spammed 1 of 1 users.
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

### wp user term <command>

Reference: <https://developer.wordpress.org/cli/commands/user/term/>

Adds, updates, removes, and lists user terms.

#### Examples

```bash
# Set user terms
$ wp user term set 123 test category
Success: Set terms.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp user term add](https://developer.wordpress.org/cli/commands/user/term/add/) | Add a term to an object. |
| [wp user term list](https://developer.wordpress.org/cli/commands/user/term/list/) | List all terms associated with an object. |
| [wp user term remove](https://developer.wordpress.org/cli/commands/user/term/remove/) | Remove a term from an object. |
| [wp user term set](https://developer.wordpress.org/cli/commands/user/term/set/) | Set object terms. |

#### wp user term add

Reference: <https://developer.wordpress.org/cli/commands/user/term/add/>

Add a term to an object.

Append the term to the existing set of terms on the object.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<taxonomy>`
  The name of the taxonomy type to be added.
- `<term>…`
  The slug of the term or terms to be added.
- `[--by=<field>]`
  Explicitly handle the term value as a slug or id.
  - default: slug
  - options:
  - slug
  - id

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

#### wp user term list

Reference: <https://developer.wordpress.org/cli/commands/user/term/list/>

List all terms associated with an object.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  ID for the object.
- `<taxonomy>…`
  One or more taxonomies to list.
- `[--field=<field>]`
  Prints the value of a single field for each term.
- `[--fields=<fields>]`
  Limit the output to specific row fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
  - yaml
  - count
  - ids

##### Available Fields

These fields will be displayed by default for each term:

- term_id
- name
- slug
- taxonomy

These fields are optionally available:

- term_taxonomy_id
- description
- term_group
- parent
- count

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

#### wp user term remove

Reference: <https://developer.wordpress.org/cli/commands/user/term/remove/>

Remove a term from an object.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<taxonomy>`
  The name of the term's taxonomy.
- `[<term>…]`
  The slug of the term or terms to be removed from the object.
- `[--by=<field>]`
  Explicitly handle the term value as a slug or id.
  - default: slug
  - options:
  - slug
  - id
- `[--all]`
  Remove all terms from the object.

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

#### wp user term set

Reference: <https://developer.wordpress.org/cli/commands/user/term/set/>

Set object terms.

Replaces existing terms on the object.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<taxonomy>`
  The name of the taxonomy type to be updated.
- `<term>…`
  The slug of the term or terms to be updated.
- `[--by=<field>]`
  Explicitly handle the term value as a slug or id.
  - default: slug
  - options:
  - slug
  - id

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

### wp user unspam

Reference: <https://developer.wordpress.org/cli/commands/user/unspam/>

Removes one or more users from spam on multisite.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>…`
  The user login, user email, or user ID of the user(s) to remove from spam.

#### Examples

```bash
# Remove user from spam.
$ wp user unspam 123
User 123 removed from spam.
Success: Unspamed 1 of 1 users.
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

### wp user update

Reference: <https://developer.wordpress.org/cli/commands/user/update/>

Updates an existing user.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<user>…`
  The user login, user email or user ID of the user(s) to update.
- `[--user_pass=<password>]`
  A string that contains the plain text password for the user.
- `[--user_nicename=<nice_name>]`
  A string that contains a URL-friendly name for the user. The default is the user's username.
- `[--user_url=<url>]`
  A string containing the user's URL for the user's web site.
- `[--user_email=<email>]`
  A string containing the user's email address.
- `[--display_name=<display_name>]`
  A string that will be shown on the site. Defaults to user's username.
- `[--nickname=<nickname>]`
  The user's nickname, defaults to the user's username.
- `[--first_name=<first_name>]`
  The user's first name.
- `[--last_name=<last_name>]`
  The user's last name.
- `[--description=<description>]`
  A string containing content about the user.
- `[--rich_editing=<rich_editing>]`
  A string for whether to enable the rich editor or not. False if not empty.
- `[--user_registered=<yyyy-mm-dd-hh-ii-ss>]`
  The date the user registered.
- `[--role=<role>]`
  A string used to set the user's role.
- `--<field>=<value>`
  One or more fields to update. For accepted fields, see [wp_update_user()](https://developer.wordpress.org/reference/functions/wp_update_user/) .
- `[--skip-email]`
  Don't send an email notification to the user.

#### Examples

```bash
# Update user
$ wp user update 123 --display_name=Mary --user_pass=marypass
Success: Updated user 123.
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
