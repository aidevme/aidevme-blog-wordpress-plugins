# wp embed

Reference: <https://developer.wordpress.org/cli/commands/embed-2/>

## Description

Inspects oEmbed providers, clears embed cache, and more.

## Synopsis

```bash
wp embed <command>
```

## Examples

```bash
# Get embed HTML for a given URL.
$ wp embed fetch https://www.youtube.com/watch?v=dQw4w9WgXcQ
&lt;iframe width="525" height="295" src="https://www.youtube.com/embed/dQw4w9WgXcQ?feature=oembed" ...

# Find cache post ID for a given URL.
$ wp embed cache find https://www.youtube.com/watch?v=dQw4w9WgXcQ --width=500
123

# List format,endpoint fields of available providers.
$ wp embed provider list
+------------------------------+-----------------------------------------+
| format                       | endpoint                                |
+------------------------------+-----------------------------------------+
| #https?://youtu\.be/.*#i     | https://www.youtube.com/oembed          |
| #https?://flic\.kr/.*#i      | https://www.flickr.com/services/oembed/ |
| #https?://wordpress\.tv/.*#i | https://wordpress.tv/oembed/            |

# List id,regex,priority fields of available handlers.
$ wp embed handler list --fields=priority,id
+----------+-------------------+
| priority | id                |
+----------+-------------------+
| 10       | youtube_embed_url |
| 9999     | audio             |
| 9999     | video             |
+----------+-------------------+
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp embed cache](https://developer.wordpress.org/cli/commands/embed-2/cache/) | Finds, triggers, and deletes oEmbed caches. |
| [wp embed fetch](https://developer.wordpress.org/cli/commands/embed-2/fetch/) | Attempts to convert a URL into embed HTML. |
| [wp embed handler](https://developer.wordpress.org/cli/commands/embed-2/handler/) | Retrieves embed handlers. |
| [wp embed provider](https://developer.wordpress.org/cli/commands/embed-2/provider/) | Retrieves oEmbed providers. |

### wp embed cache <command>

Reference: <https://developer.wordpress.org/cli/commands/embed-2/cache/>

Finds, triggers, and deletes oEmbed caches.

#### Examples

```bash
# Find cache post ID for a given URL.
$ wp embed cache find https://www.youtube.com/watch?v=dQw4w9WgXcQ --width=500
123

# Clear cache for a post.
$ wp embed cache clear 123
Success: Cleared oEmbed cache.

# Triggers cache for a post.
$ wp embed cache trigger 456
Success: Caching triggered!
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp embed cache clear](https://developer.wordpress.org/cli/commands/embed-2/cache/clear/) | Deletes all oEmbed caches for a given post. |
| [wp embed cache find](https://developer.wordpress.org/cli/commands/embed-2/cache/find/) | Finds an oEmbed cache post ID for a given URL. |
| [wp embed cache trigger](https://developer.wordpress.org/cli/commands/embed-2/cache/trigger/) | Triggers the caching of all oEmbed results for a given post. |

#### wp embed cache clear

Reference: <https://developer.wordpress.org/cli/commands/embed-2/cache/clear/>

Deletes all oEmbed caches for a given post.

oEmbed caches for a post are stored in the post's metadata.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<post_id>`
  ID of the post to clear the cache for.

##### Examples

```bash
# Clear cache for a post
$ wp embed cache clear 123
Success: Cleared oEmbed cache.
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

#### wp embed cache find

Reference: <https://developer.wordpress.org/cli/commands/embed-2/cache/find/>

Finds an oEmbed cache post ID for a given URL.

Starting with WordPress 4.9, embeds that aren't associated with a specific post will be cached in a new oembed_cache post type. There can be more than one such entry for a url depending on attributes and context. Not to be confused with oEmbed caches for a given post which are stored in the post's metadata.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<url>`
  URL to retrieve oEmbed data for.
- `[--width=<width>]`
  Width of the embed in pixels. Part of cache key so must match. Defaults to `content_width` if set else 500px, so is theme and context dependent.
- `[--height=<height>]`
  Height of the embed in pixels. Part of cache key so must match. Defaults to 1.5 * default width (`content_width` or 500px), to a maximum of 1000px.
- `[--discover]`
  Whether to search with the discover attribute set or not. Part of cache key so must match. If not given, will search with attribute: unset, '1', '0', returning first.

##### Examples

```bash
# Find cache post ID for a given URL.
$ wp embed cache find https://www.youtube.com/watch?v=dQw4w9WgXcQ --width=500
123
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

#### wp embed cache trigger

Reference: <https://developer.wordpress.org/cli/commands/embed-2/cache/trigger/>

Triggers the caching of all oEmbed results for a given post.

oEmbed caches for a post are stored in the post's metadata.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<post_id>`
  ID of the post to do the caching for.

##### Examples

```bash
# Triggers cache for a post
$ wp embed cache trigger 456
Success: Caching triggered!
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

### wp embed fetch

Reference: <https://developer.wordpress.org/cli/commands/embed-2/fetch/>

Attempts to convert a URL into embed HTML.

In non-raw mode, starts by checking the URL against the regex of the registered embed handlers. If none of the regex matches and it's enabled, then the URL will be given to the [WP_oEmbed](https://developer.wordpress.org/reference/classes/wp_oembed/) class. In raw mode, checks the providers directly and returns the data.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<url>`
  URL to retrieve oEmbed data for.
- `[--width=<width>]`
  Width of the embed in pixels.
- `[--height=<height>]`
  Height of the embed in pixels.
- `[--post-id=<id>]`
  Cache oEmbed response for a given post.
- `[--discover]`
  Enable oEmbed discovery. Defaults to true.
- `[--skip-cache]`
  Ignore already cached oEmbed responses. Has no effect if using the 'raw' option, which doesn't use the cache.
- `[--skip-sanitization]`
  Remove the filter that WordPress from 4.4 onwards uses to sanitize oEmbed responses. Has no effect if using the 'raw' option, which by-passes sanitization.
- `[--do-shortcode]`
  If the URL is handled by a registered embed handler and returns a shortcode, do shortcode and return result. Has no effect if using the 'raw' option, which by-passes handlers.
- `[--limit-response-size=<size>]`
  Limit the size of the resulting HTML when using discovery. Default 150 KB (the standard WordPress limit). Not compatible with 'no-discover'.
- `[--raw]`
  Return the raw oEmbed response instead of the resulting HTML. Ignores the cache and does not sanitize responses or use registered embed handlers.
- `[--raw-format=<json|xml>]`
  Render raw oEmbed data in a particular format. Defaults to json. Can only be specified in conjunction with the 'raw' option.
  - options:
  - json
  - xml

#### Examples

```bash
# Get embed HTML for a given URL.
$ wp embed fetch https://www.youtube.com/watch?v=dQw4w9WgXcQ
&lt;iframe width="525" height="295" src="https://www.youtube.com/embed/dQw4w9WgXcQ?feature=oembed" ...

# Get raw oEmbed data for a given URL.
$ wp embed fetch https://www.youtube.com/watch?v=dQw4w9WgXcQ --raw
{"author_url":"https:\/\/www.youtube.com\/user\/RickAstleyVEVO","width":525,"version":"1.0", ...
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

### wp embed handler <command>

Reference: <https://developer.wordpress.org/cli/commands/embed-2/handler/>

Retrieves embed handlers.

#### Examples

```bash
# List id,regex,priority fields of available handlers.
$ wp embed handler list --fields=priority,id
+----------+-------------------+
| priority | id                |
+----------+-------------------+
| 10       | youtube_embed_url |
| 9999     | audio             |
| 9999     | video             |
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp embed handler list](https://developer.wordpress.org/cli/commands/embed-2/handler/list/) | Lists all available embed handlers. |

#### wp embed handler list

Reference: <https://developer.wordpress.org/cli/commands/embed-2/handler/list/>

Lists all available embed handlers.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--field=<field>]`
  Display the value of a single field
- `[--fields=<fields>]`
  Limit the output to specific fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json

##### Available Fields

These fields will be displayed by default for each handler:

- id
- regex

These fields are optionally available:

- callback
- priority

##### Examples

```bash
# List id,regex,priority fields of available handlers.
$ wp embed handler list --fields=priority,id
+----------+-------------------+
| priority | id                |
+----------+-------------------+
| 10       | youtube_embed_url |
| 9999     | audio             |
| 9999     | video             |
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

### wp embed provider <command>

Reference: <https://developer.wordpress.org/cli/commands/embed-2/provider/>

Retrieves oEmbed providers.

#### Examples

```bash
# List format,endpoint fields of available providers.
$ wp embed provider list
+------------------------------+-----------------------------------------+
| format                       | endpoint                                |
+------------------------------+-----------------------------------------+
| #https?://youtu\.be/.*#i     | https://www.youtube.com/oembed          |
| #https?://flic\.kr/.*#i      | https://www.flickr.com/services/oembed/ |
| #https?://wordpress\.tv/.*#i | https://wordpress.tv/oembed/            |

# Get the matching provider for the URL.
$ wp embed provider match https://www.youtube.com/watch?v=dQw4w9WgXcQ
https://www.youtube.com/oembed
```

#### Subcommands

| Name | Description |
| --- | --- |
| [wp embed provider list](https://developer.wordpress.org/cli/commands/embed-2/provider/list/) | Lists all available oEmbed providers. |
| [wp embed provider match](https://developer.wordpress.org/cli/commands/embed-2/provider/match/) | Gets the matching provider for a given URL. |

#### wp embed provider list

Reference: <https://developer.wordpress.org/cli/commands/embed-2/provider/list/>

Lists all available oEmbed providers.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--field=<field>]`
  Display the value of a single field
- `[--fields=<fields>]`
  Limit the output to specific fields.
- `[--format=<format>]`
  Render output in a particular format.
  - default: table
  - options:
  - table
  - csv
  - json
- `[--force-regex]`
  Turn the asterisk-type provider URLs into regexes.

##### Available Fields

These fields will be displayed by default for each provider:

- format
- endpoint

This field is optionally available:

- regex

##### Examples

```bash
# List format,endpoint fields of available providers.
$ wp embed provider list --fields=format,endpoint
+------------------------------+-----------------------------------------+
| format                       | endpoint                                |
+------------------------------+-----------------------------------------+
| #https?://youtu\.be/.*#i     | https://www.youtube.com/oembed          |
| #https?://flic\.kr/.*#i      | https://www.flickr.com/services/oembed/ |
| #https?://wordpress\.tv/.*#i | https://wordpress.tv/oembed/            |
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

#### wp embed provider match

Reference: <https://developer.wordpress.org/cli/commands/embed-2/provider/match/>

Gets the matching provider for a given URL.

##### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<url>`
  URL to retrieve provider for.
- `[--discover]`
  Whether to use oEmbed discovery or not. Defaults to true.
- `[--limit-response-size=<size>]`
  Limit the size of the resulting HTML when using discovery. Default 150 KB (the standard WordPress limit). Not compatible with 'no-discover'.
- `[--link-type=<json|xml>]`
  Whether to accept only a certain link type when using discovery. Defaults to any (json or xml), preferring json. Not compatible with 'no-discover'.
  - options:
  - json
  - xml

##### Examples

```bash
# Get the matching provider for the URL.
$ wp embed provider match https://www.youtube.com/watch?v=dQw4w9WgXcQ
https://www.youtube.com/oembed
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
