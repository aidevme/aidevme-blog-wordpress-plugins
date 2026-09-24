# wp post

Reference: <https://developer.wordpress.org/cli/commands/post/>

## Description

Manages posts, content, and meta.

## Synopsis

```bash
wp post <command>
```

## Examples

```bash
# Create a new post.
$ wp post create --post_type=post --post_title='A sample post'
Success: Created post 123.

# Update an existing post.
$ wp post update 123 --post_status=draft
Success: Updated post 123.

# Delete an existing post.
$ wp post delete 123
Success: Trashed post 123.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp post create](https://developer.wordpress.org/cli/commands/post/create/) | Creates a new post. |
| [wp post delete](https://developer.wordpress.org/cli/commands/post/delete/) | Deletes an existing post. |
| [wp post edit](https://developer.wordpress.org/cli/commands/post/edit/) | Launches system editor to edit post content. |
| [wp post exists](https://developer.wordpress.org/cli/commands/post/exists/) | Verifies whether a post exists. |
| [wp post generate](https://developer.wordpress.org/cli/commands/post/generate/) | Generates some posts. |
| [wp post get](https://developer.wordpress.org/cli/commands/post/get/) | Gets details about a post. |
| [wp post list](https://developer.wordpress.org/cli/commands/post/list/) | Gets a list of posts. |
| [wp post meta](https://developer.wordpress.org/cli/commands/post/meta/) | Adds, updates, deletes, and lists post custom fields. |
| [wp post term](https://developer.wordpress.org/cli/commands/post/term/) | Adds, updates, removes, and lists post terms. |
| [wp post update](https://developer.wordpress.org/cli/commands/post/update/) | Updates one or more existing posts. |
| [wp post url-to-id](https://developer.wordpress.org/cli/commands/post/url-to-id/) | Gets the post ID for a given URL. |

### wp post create

Reference: <https://developer.wordpress.org/cli/commands/post/create/>

Creates a new post.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--post_author=<post_author>]`
  The ID of the user who added the post. Default is the current user ID.
- `[--post_date=<post_date>]`
  The date of the post. Default is the current time.
- `[--post_date_gmt=<post_date_gmt>]`
  The date of the post in the GMT timezone. Default is the value of $post_date.
- `[--post_content=<post_content>]`
  The post content. Default empty.
- `[--post_content_filtered=<post_content_filtered>]`
  The filtered post content. Default empty.
- `[--post_title=<post_title>]`
  The post title. Default empty.
- `[--post_excerpt=<post_excerpt>]`
  The post excerpt. Default empty.
- `[--post_status=<post_status>]`
  The post status. Default 'draft'.
- `[--post_type=<post_type>]`
  The post type. Default 'post'.
- `[--comment_status=<comment_status>]`
  Whether the post can accept comments. Accepts 'open' or 'closed'. Default is the value of 'default_comment_status' option.
- `[--ping_status=<ping_status>]`
  Whether the post can accept pings. Accepts 'open' or 'closed'. Default is the value of 'default_ping_status' option.
- `[--post_password=<post_password>]`
  The password to access the post. Default empty.
- `[--post_name=<post_name>]`
  The post name. Default is the sanitized post title when creating a new post.
- `[--from-post=<post_id>]`
  Post id of a post to be duplicated.
- `[--to_ping=<to_ping>]`
  Space or carriage return-separated list of URLs to ping. Default empty.
- `[--pinged=<pinged>]`
  Space or carriage return-separated list of URLs that have been pinged. Default empty.
- `[--post_modified=<post_modified>]`
  The date when the post was last modified. Default is the current time.
- `[--post_modified_gmt=<post_modified_gmt>]`
  The date when the post was last modified in the GMT timezone. Default is the current time.
- `[--post_parent=<post_parent>]`
  Set this for the post it belongs to, if any. Default 0.
- `[--menu_order=<menu_order>]`
  The order the post should be displayed in. Default 0.
- `[--post_mime_type=<post_mime_type>]`
  The mime type of the post. Default empty.
- `[--guid=<guid>]`
  Global Unique ID for referencing the post. Default empty.
- `[--post_category=<post_category>]`
  Array of category names, slugs, or IDs. Defaults to value of the 'default_category' option.
- `[--tags_input=<tags_input>]`
  Array of tag names, slugs, or IDs. Default empty.
- `[--tax_input=<tax_input>]`
  Array of taxonomy terms keyed by their taxonomy name. Default empty.
- `[--meta_input=<meta_input>]`
  Array in JSON format of post meta values keyed by their post meta key. Default empty.
- `[<file>]`
  Read post content from <file>. If this value is present, the
  `--post_content` argument will be ignored.
  Passing `-` as the filename will cause post content to
  be read from STDIN.
- `[--<field>=<value>]`
  Associative args for the new post. See [wp_insert_post()](https://developer.wordpress.org/reference/functions/wp_insert_post/) .
- `[--edit]`
  Immediately open system's editor to write or edit post content.
  If content is read from a file, from STDIN, or from the `--post_content`
  argument, that text will be loaded into the editor.
- `[--porcelain]`
  Output just the new post id.

#### Examples

```bash
# Create post and schedule for future
$ wp post create --post_type=post --post_title='A future post' --post_status=future --post_date='2030-12-01 07:00:00'
Success: Created post 1921.

# Create post with content from given file
$ wp post create ./post-content.txt --post_category=201,345 --post_title='Post from file'
Success: Created post 1922.

# Create a post with multiple meta values.
$ wp post create --post_title='A post' --post_content='Just a small post.' --meta_input='{"key1":"value1","key2":"value2"}'
Success: Created post 1923.

# Create a duplicate post from existing posts.
$ wp post create --from-post=123 --post_title='Different Title'
Success: Created post 2350.
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

### wp post delete

Reference: <https://developer.wordpress.org/cli/commands/post/delete/>

Deletes an existing post.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>…`
  One or more IDs of posts to delete.
- `[--force]`
  Skip the trash bin.
- `[--defer-term-counting]`
  Recalculate term count in batch, for a performance boost.

#### Examples

```bash
# Delete post skipping trash
$ wp post delete 123 --force
Success: Deleted post 123.

# Delete multiple posts
$ wp post delete 123 456 789
Success: Trashed post 123.
Success: Trashed post 456.
Success: Trashed post 789.

# Delete all pages
$ wp post delete $(wp post list --post_type='page' --format=ids)
Success: Trashed post 1164.
Success: Trashed post 1186.

# Delete all posts in the trash
$ wp post delete $(wp post list --post_status=trash --format=ids)
Success: Deleted post 1268.
Success: Deleted post 1294.
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

### wp post edit

Reference: <https://developer.wordpress.org/cli/commands/post/edit/>

Launches system editor to edit post content.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the post to edit.

#### Examples

```bash
# Launch system editor to edit post
$ wp post edit 123
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

### wp post exists

Reference: <https://developer.wordpress.org/cli/commands/post/exists/>

Verifies whether a post exists.

Displays a success message if the post does exist.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the post to check.

#### Examples

```bash
# The post exists.
$ wp post exists 1337
Success: Post with ID 1337 exists.
$ echo $?
0

# The post does not exist.
$ wp post exists 10000
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

### wp post generate

Reference: <https://developer.wordpress.org/cli/commands/post/generate/>

Generates some posts.

Creates a specified number of new posts with dummy data.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--count=<number>]`
  How many posts to generate?
  - default: 100
- `[--post_type=<type>]`
  The type of the generated posts.
  - default: post
- `[--post_status=<status>]`
  The status of the generated posts.
  - default: publish
- `[--post_title=<post_title>]`
  The post title.
  - default:
- `[--post_author=<login>]`
  The author of the generated posts.
  - default:
- `[--post_date=<yyyy-mm-dd-hh-ii-ss>]`
  The date of the post. Default is the current time.
- `[--post_date_gmt=<yyyy-mm-dd-hh-ii-ss>]`
  The date of the post in the GMT timezone. Default is the value of –post_date.
- `[--post_content]`
  If set, the command reads the post_content from STDIN.
- `[--max_depth=<number>]`
  For hierarchical post types, generate child posts down to a certain depth.
  - default: 1
- `[--format=<format>]`
  Render output in a particular format.
  - default: progress
  - options:
  - progress
  - ids

#### Examples

```bash
# Generate posts.
$ wp post generate --count=10 --post_type=page --post_date=1999-01-04
Generating posts  100% [================================================] 0:01 / 0:04

# Generate posts with fetched content.
$ curl -N https://loripsum.net/api/5 | wp post generate --post_content --count=10
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100  2509  100  2509    0     0    616      0  0:00:04  0:00:04 --:--:--   616
Generating posts  100% [================================================] 0:01 / 0:04

# Add meta to every generated posts.
$ wp post generate --format=ids | xargs -d ' ' -I % wp post meta add % foo bar
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

### wp post get

Reference: <https://developer.wordpress.org/cli/commands/post/get/>

Gets details about a post.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the post to get.
- `[--field=<field>]`
  Instead of returning the whole post, returns the value of a single field.
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
# Save the post content to a file
$ wp post get 123 --field=content > file.txt
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

### wp post list

Reference: <https://developer.wordpress.org/cli/commands/post/list/>

Gets a list of posts.

Display posts based on all arguments supported by [WP_Query()](https://developer.wordpress.org/reference/classes/wp_query/). Only shows post types marked as post by default.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--<field>=<value>]`
  One or more args to pass to [WP_Query](https://developer.wordpress.org/reference/classes/wp_query/).
- `[--field=<field>]`
  Prints the value of a single field for each post.
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

These fields will be displayed by default for each post:

- ID
- post_title
- post_name
- post_date
- post_status

These fields are optionally available:

- post_author
- post_date_gmt
- post_content
- post_excerpt
- comment_status
- ping_status
- post_password
- to_ping
- pinged
- post_modified
- post_modified_gmt
- post_content_filtered
- post_parent
- guid
- menu_order
- post_type
- post_mime_type
- comment_count
- filter
- url

#### Examples

```bash
# List post
$ wp post list --field=ID
568
829
1329
1695

# List posts in JSON
$ wp post list --post_type=post --posts_per_page=5 --format=json
[{"ID":1,"post_title":"Hello world!","post_name":"hello-world","post_date":"2015-06-20 09:00:10","post_status":"publish"},{"ID":1178,"post_title":"Markup: HTML Tags and Formatting","post_name":"markup-html-tags-and-formatting","post_date":"2013-01-11 20:22:19","post_status":"draft"}]

# List all pages
$ wp post list --post_type=page --fields=post_title,post_status
+-------------+-------------+
| post_title  | post_status |
+-------------+-------------+
| Sample Page | publish     |
+-------------+-------------+

# List ids of all pages and posts
$ wp post list --post_type=page,post --format=ids
15 25 34 37 198

# List given posts
$ wp post list --post__in=1,3
+----+--------------+-------------+---------------------+-------------+
| ID | post_title   | post_name   | post_date           | post_status |
+----+--------------+-------------+---------------------+-------------+
| 3  | Lorem Ipsum  | lorem-ipsum | 2016-06-01 14:34:36 | publish     |
| 1  | Hello world! | hello-world | 2016-06-01 14:31:12 | publish     |
+----+--------------+-------------+---------------------+-------------+

# List given post by a specific author
$ wp post list --author=2
+----+-------------------+-------------------+---------------------+-------------+
| ID | post_title        | post_name         | post_date           | post_status |
+----+-------------------+-------------------+---------------------+-------------+
| 14 | New documentation | new-documentation | 2021-06-18 21:05:11 | publish     |
+----+-------------------+-------------------+---------------------+-------------+
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

### wp post meta <command>

Reference: <https://developer.wordpress.org/cli/commands/post/meta/>

Adds, updates, deletes, and lists post custom fields.

#### Examples

```bash
# Set post meta
$ wp post meta set 123 _wp_page_template about.php
Success: Updated custom field '_wp_page_template'.

# Get post meta
$ wp post meta get 123 _wp_page_template
about.php

# Update post meta
$ wp post meta update 123 _wp_page_template contact.php
Success: Updated custom field '_wp_page_template'.

# Delete post meta
$ wp post meta delete 123 _wp_page_template
Success: Deleted custom field.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp post meta add](https://developer.wordpress.org/cli/commands/post/meta/add/) | Add a meta field. |
| [wp post meta clean-duplicates](https://developer.wordpress.org/cli/commands/post/meta/clean-duplicates/) | Cleans up duplicate post meta values on a post. |
| [wp post meta delete](https://developer.wordpress.org/cli/commands/post/meta/delete/) | Delete a meta field. |
| [wp post meta get](https://developer.wordpress.org/cli/commands/post/meta/get/) | Get meta field value. |
| [wp post meta list](https://developer.wordpress.org/cli/commands/post/meta/list/) | List all metadata associated with an object. |
| [wp post meta patch](https://developer.wordpress.org/cli/commands/post/meta/patch/) | Update a nested value for a meta field. |
| [wp post meta pluck](https://developer.wordpress.org/cli/commands/post/meta/pluck/) | Get a nested value from a meta field. |
| [wp post meta set](https://developer.wordpress.org/cli/commands/post/meta/set/) | Update a meta field. |
| [wp post meta update](https://developer.wordpress.org/cli/commands/post/meta/update/) | Update a meta field. |

#### wp post meta add

Reference: <https://developer.wordpress.org/cli/commands/post/meta/add/>

Add a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to create.
- `[<value>]`
  The value of the meta field. If omitted, the value is read from STDIN.
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

#### wp post meta clean-duplicates

Reference: <https://developer.wordpress.org/cli/commands/post/meta/clean-duplicates/>

Cleans up duplicate post meta values on a post.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  ID of the post to clean.
- `<key>`
  Meta key to clean up.

##### Examples

```bash
# Delete duplicate post meta.
wp post meta clean-duplicates 1234 enclosure
Success: Cleaned up duplicate 'enclosure' meta values.
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

#### wp post meta delete

Reference: <https://developer.wordpress.org/cli/commands/post/meta/delete/>

Delete a meta field.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `[<key>]`
  The name of the meta field to delete.
- `[<value>]`
  The value to delete. If omitted, all rows with key will deleted.
- `[--all]`
  Delete all meta for the object.

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

#### wp post meta get

Reference: <https://developer.wordpress.org/cli/commands/post/meta/get/>

Get meta field value.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to get.
- `[--single]`
  Whether to return a single value.
- `[--format=<format>]`
  Get value in a particular format.
  - default: var_export
  - options:
  - var_export
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

#### wp post meta list

Reference: <https://developer.wordpress.org/cli/commands/post/meta/list/>

List all metadata associated with an object.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  ID for the object.
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
  - yaml
  - count
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

#### wp post meta patch

Reference: <https://developer.wordpress.org/cli/commands/post/meta/patch/>

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

#### wp post meta pluck

Reference: <https://developer.wordpress.org/cli/commands/post/meta/pluck/>

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

#### wp post meta set

Reference: <https://developer.wordpress.org/cli/commands/post/meta/set/>

Update a meta field.

This is an alias for `wp post meta update`.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to update.
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

#### wp post meta update

Reference: <https://developer.wordpress.org/cli/commands/post/meta/update/>

Update a meta field.

**Alias:** `set`

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>`
  The ID of the object.
- `<key>`
  The name of the meta field to update.
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

### wp post term <command>

Reference: <https://developer.wordpress.org/cli/commands/post/term/>

Adds, updates, removes, and lists post terms.

#### Examples

```bash
# Set category post term `test` to the post ID 123
$ wp post term set 123 test category
Success: Set term.

# Set category post terms `test` and `apple` to the post ID 123
$ wp post term set 123 test apple category
Success: Set terms.

# List category post terms for the post ID 123
$ wp post term list 123 category --fields=term_id,slug
+---------+-------+
| term_id | slug  |
+---------+-------+
| 2       | apple |
| 3       | test  |
+----------+------+

# Remove category post terms `test` and `apple` for the post ID 123
$ wp post term remove 123 category test apple
Success: Removed terms.
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp post term add](https://developer.wordpress.org/cli/commands/post/term/add/) | Add a term to an object. |
| [wp post term list](https://developer.wordpress.org/cli/commands/post/term/list/) | List all terms associated with an object. |
| [wp post term remove](https://developer.wordpress.org/cli/commands/post/term/remove/) | Remove a term from an object. |
| [wp post term set](https://developer.wordpress.org/cli/commands/post/term/set/) | Set object terms. |

#### wp post term add

Reference: <https://developer.wordpress.org/cli/commands/post/term/add/>

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

#### wp post term list

Reference: <https://developer.wordpress.org/cli/commands/post/term/list/>

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

#### wp post term remove

Reference: <https://developer.wordpress.org/cli/commands/post/term/remove/>

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

#### wp post term set

Reference: <https://developer.wordpress.org/cli/commands/post/term/set/>

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

### wp post update

Reference: <https://developer.wordpress.org/cli/commands/post/update/>

Updates one or more existing posts.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<id>…`
  One or more IDs of posts to update.
- `[--post_author=<post_author>]`
  The ID of the user who added the post. Default is the current user ID.
- `[--post_date=<post_date>]`
  The date of the post. Default is the current time.
- `[--post_date_gmt=<post_date_gmt>]`
  The date of the post in the GMT timezone. Default is the value of $post_date.
- `[--post_content=<post_content>]`
  The post content. Default empty.
- `[--post_content_filtered=<post_content_filtered>]`
  The filtered post content. Default empty.
- `[--post_title=<post_title>]`
  The post title. Default empty.
- `[--post_excerpt=<post_excerpt>]`
  The post excerpt. Default empty.
- `[--post_status=<post_status>]`
  The post status. Default 'draft'.
- `[--post_type=<post_type>]`
  The post type. Default 'post'.
- `[--comment_status=<comment_status>]`
  Whether the post can accept comments. Accepts 'open' or 'closed'. Default is the value of 'default_comment_status' option.
- `[--ping_status=<ping_status>]`
  Whether the post can accept pings. Accepts 'open' or 'closed'. Default is the value of 'default_ping_status' option.
- `[--post_password=<post_password>]`
  The password to access the post. Default empty.
- `[--post_name=<post_name>]`
  The post name. Default is the sanitized post title when creating a new post.
- `[--to_ping=<to_ping>]`
  Space or carriage return-separated list of URLs to ping. Default empty.
- `[--pinged=<pinged>]`
  Space or carriage return-separated list of URLs that have been pinged. Default empty.
- `[--post_modified=<post_modified>]`
  The date when the post was last modified. Default is the current time.
- `[--post_modified_gmt=<post_modified_gmt>]`
  The date when the post was last modified in the GMT timezone. Default is the current time.
- `[--post_parent=<post_parent>]`
  Set this for the post it belongs to, if any. Default 0.
- `[--menu_order=<menu_order>]`
  The order the post should be displayed in. Default 0.
- `[--post_mime_type=<post_mime_type>]`
  The mime type of the post. Default empty.
- `[--guid=<guid>]`
  Global Unique ID for referencing the post. Default empty.
- `[--post_category=<post_category>]`
  Array of category names, slugs, or IDs. Defaults to value of the 'default_category' option.
- `[--tags_input=<tags_input>]`
  Array of tag names, slugs, or IDs. Default empty.
- `[--tax_input=<tax_input>]`
  Array of taxonomy terms keyed by their taxonomy name. Default empty.
- `[--meta_input=<meta_input>]`
  Array in JSON format of post meta values keyed by their post meta key. Default empty.
- `[<file>]`
  Read post content from <file>. If this value is present, the
  `--post_content` argument will be ignored.
  Passing `-` as the filename will cause post content to
  be read from STDIN.
- `--<field>=<value>`
  One or more fields to update. See [wp_insert_post()](https://developer.wordpress.org/reference/functions/wp_insert_post/) .
- `[--defer-term-counting]`
  Recalculate term count in batch, for a performance boost.

#### Examples

```bash
$ wp post update 123 --post_name=something --post_status=draft
Success: Updated post 123.

# Update a post with multiple meta values.
$ wp post update 123 --meta_input='{"key1":"value1","key2":"value2"}'
Success: Updated post 123.

# Update multiple posts at once.
$ wp post update 123 456 --post_author=789
Success: Updated post 123.
Success: Updated post 456.

# Update all posts of a given post type at once.
$ wp post update $(wp post list --post_type=page --format=ids) --post_author=123
Success: Updated post 123.
Success: Updated post 456.
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

### wp post url-to-id

Reference: <https://developer.wordpress.org/cli/commands/post/url-to-id/>

Gets the post ID for a given URL.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<url>`
  The URL of the post to get.

#### Examples

```bash
# Get post ID by URL
$ wp post url-to-id https://example.com/?p=1
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
