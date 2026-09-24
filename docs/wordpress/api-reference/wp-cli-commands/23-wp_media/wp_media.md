# wp media

Reference: <https://developer.wordpress.org/cli/commands/media/>

## Description

Imports files as attachments, regenerates thumbnails, or lists registered image sizes.

## Synopsis

```bash
wp media <command>
```

## Examples

```bash
# Re-generate all thumbnails, without confirmation.
$ wp media regenerate --yes
Found 3 images to regenerate.
1/3 Regenerated thumbnails for "Sydney Harbor Bridge" (ID 760).
2/3 Regenerated thumbnails for "Boardwalk" (ID 757).
3/3 Regenerated thumbnails for "Sunburst Over River" (ID 756).
Success: Regenerated 3 of 3 images.

# Import a local image and set it to be the featured image for a post.
$ wp media import ~/Downloads/image.png --post_id=123 --title="A downloaded picture" --featured_image
Imported file '/home/person/Downloads/image.png' as attachment ID 1753 and attached to post 123 as featured image.
Success: Imported 1 of 1 images.

# List all registered image sizes
$ wp media image-size
+---------------------------+-------+--------+-------+
| name                      | width | height | crop  |
+---------------------------+-------+--------+-------+
| full                      |       |        | N/A   |
| twentyfourteen-full-width | 1038  | 576    | hard  |
| large                     | 1024  | 1024   | soft  |
| medium_large              | 768   | 0      | soft  |
| medium                    | 300   | 300    | soft  |
| thumbnail                 | 150   | 150    | hard  |
+---------------------------+-------+--------+-------+

# Fix orientation for specific images.
$ wp media fix-orientation 63
1/1 Fixing orientation for "Portrait_6" (ID 63).
Success: Fixed 1 of 1 images.
```

## Subcommands

| Name | Description |
| --- | --- |
| [wp media fix-orientation](https://developer.wordpress.org/cli/commands/media/fix-orientation/) | Fix image orientation for one or more attachments. |
| [wp media image-size](https://developer.wordpress.org/cli/commands/media/image-size/) | Lists image sizes registered with WordPress. |
| [wp media import](https://developer.wordpress.org/cli/commands/media/import/) | Creates attachments from local files or URLs. |
| [wp media regenerate](https://developer.wordpress.org/cli/commands/media/regenerate/) | Regenerates thumbnails for one or more attachments. |

### wp media fix-orientation

Reference: <https://developer.wordpress.org/cli/commands/media/fix-orientation/>

Fix image orientation for one or more attachments.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<attachment-id>…]`
  One or more IDs of the attachments to regenerate.
- `[--dry-run]`
  Check images needing orientation without performing the operation.

#### Examples

```bash
# Fix orientation for all images.
$ wp media fix-orientation
1/3 Fixing orientation for "Landscape_4" (ID 62).
2/3 Fixing orientation for "Landscape_3" (ID 61).
3/3 Fixing orientation for "Landscape_2" (ID 60).
Success: Fixed 3 of 3 images.

# Fix orientation dry run.
$ wp media fix-orientation 63 --dry-run
1/1 "Portrait_6" (ID 63) will be affected.
Success: 1 of 1 image will be affected.

# Fix orientation for specific images.
$ wp media fix-orientation 63
1/1 Fixing orientation for "Portrait_6" (ID 63).
Success: Fixed 1 of 1 images.
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

### wp media image-size

Reference: <https://developer.wordpress.org/cli/commands/media/image-size/>

Lists image sizes registered with WordPress.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[--fields=<fields>]`
  Limit the output to specific fields. Defaults to all fields.
- `[--format=<format>]`
  Render output in a specific format
  - default: table
  - options:
  - table
  - json
  - csv
  - yaml
  - count

#### Available Fields

These fields will be displayed by default for each image size: * name * width * height * crop * ratio

#### Examples

```bash
# List all registered image sizes
$ wp media image-size
+---------------------------+-------+--------+-------+-------+
| name                      | width | height | crop  | ratio |
+---------------------------+-------+--------+-------+-------+
| full                      |       |        | N/A   | N/A   |
| twentyfourteen-full-width | 1038  | 576    | hard  | 173:96|
| large                     | 1024  | 1024   | soft  | N/A   |
| medium_large              | 768   | 0      | soft  | N/A   |
| medium                    | 300   | 300    | soft  | N/A   |
| thumbnail                 | 150   | 150    | hard  | 1:1   |
+---------------------------+-------+--------+-------+-------+
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

### wp media import

Reference: <https://developer.wordpress.org/cli/commands/media/import/>

Creates attachments from local files or URLs.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `<file>…`
  Path to file or files to be imported. Supports the glob(3) capabilities of the current shell.
  If file is recognized as a URL (for example, with a scheme of http or ftp), the file will be
  downloaded to a temp file before being sideloaded.
- `[--post_id=<post_id>]`
  ID of the post to attach the imported files to.
- `[--post_name=<post_name>]`
  Name of the post to attach the imported files to.
- `[--file_name=<name>]`
  Attachment name (post_name field).
- `[--title=<title>]`
  Attachment title (post title field).
- `[--caption=<caption>]`
  Caption for attachment (post excerpt field).
- `[--alt=<alt_text>]`
  Alt text for image (saved as post meta).
- `[--desc=<description>]`
  "Description" field (post content) of attachment post.
- `[--skip-copy]`
  If set, media files (local only) are imported to the library but not moved on disk. File names will not be run through [wp_unique_filename()](https://developer.wordpress.org/reference/functions/wp_unique_filename/)  with this set.
- `[--preserve-filetime]`
  Use the file modified time as the post published & modified dates. Remote files will always use the current time.
- `[--featured_image]`
  If set, set the imported image as the Featured Image of the post it is attached to.
- `[--porcelain[=<field>]]`
  Output a single field for each imported image. Defaults to attachment ID when used as flag.
  - options:
  - url

#### Examples

```bash
# Import all jpgs in the current user's "Pictures" directory, not attached to any post.
$ wp media import ~/Pictures/**\/*.jpg
Imported file '/home/person/Pictures/landscape-photo.jpg' as attachment ID 1751.
Imported file '/home/person/Pictures/fashion-icon.jpg' as attachment ID 1752.
Success: Imported 2 of 2 items.

# Import a local image and set it to be the post thumbnail for a post.
$ wp media import ~/Downloads/image.png --post_id=123 --title="A downloaded picture" --featured_image
Imported file '/home/person/Downloads/image.png' as attachment ID 1753 and attached to post 123 as featured image.
Success: Imported 1 of 1 images.

# Import a local image, but set it as the featured image for all posts.
# 1. Import the image and get its attachment ID.
# 2. Assign the attachment ID as the featured image for all posts.
$ ATTACHMENT_ID="$(wp media import ~/Downloads/image.png --porcelain)"
$ wp post list --post_type=post --format=ids | xargs -d ' ' -I % wp post meta add % _thumbnail_id $ATTACHMENT_ID
Success: Added custom field.
Success: Added custom field.

# Import an image from the web.
$ wp media import https://s.w.org/style/images/wp-header-logo.png --title='The WordPress logo' --alt="Semantic personal publishing"
Imported file 'https://s.w.org/style/images/wp-header-logo.png' as attachment ID 1755.
Success: Imported 1 of 1 images.

# Get the URL for an attachment after import.
$ wp media import https://s.w.org/style/images/wp-header-logo.png --porcelain | xargs -I {} wp post list --post__in={} --field=url --post_type=attachment
http://wordpress-develop.dev/wp-header-logo/
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

### wp media regenerate

Reference: <https://developer.wordpress.org/cli/commands/media/regenerate/>

Regenerates thumbnails for one or more attachments.

#### Options

See the [argument syntax](https://make.wordpress.org/cli/handbook/references/argument-syntax/) reference for a detailed explanation of the syntax conventions used.

- `[<attachment-id>…]`
  One or more IDs of the attachments to regenerate.
- `[--image_size=<image_size>]`
  Name of the image size to regenerate. Only thumbnails of this image size will be regenerated, thumbnails of other image sizes will not.
- `[--skip-delete]`
  Skip deletion of the original thumbnails. If your thumbnails are linked from sources outside your control, it's likely best to leave them around. Defaults to false.
- `[--only-missing]`
  Only generate thumbnails for images missing image sizes.
- `[--delete-unknown]`
  Only delete thumbnails for old unregistered image sizes.
- `[--yes]`
  Answer yes to the confirmation message. Confirmation only shows when no IDs passed as arguments.

#### Examples

```bash
# Regenerate thumbnails for given attachment IDs.
$ wp media regenerate 123 124 125
Found 3 images to regenerate.
1/3 Regenerated thumbnails for "Vertical Image" (ID 123).
2/3 Regenerated thumbnails for "Horizontal Image" (ID 124).
3/3 Regenerated thumbnails for "Beautiful Picture" (ID 125).
Success: Regenerated 3 of 3 images.

# Regenerate all thumbnails, without confirmation.
$ wp media regenerate --yes
Found 3 images to regenerate.
1/3 Regenerated thumbnails for "Sydney Harbor Bridge" (ID 760).
2/3 Regenerated thumbnails for "Boardwalk" (ID 757).
3/3 Regenerated thumbnails for "Sunburst Over River" (ID 756).
Success: Regenerated 3 of 3 images.

# Re-generate all thumbnails that have IDs between 1000 and 2000.
$ seq 1000 2000 | xargs wp media regenerate
Found 4 images to regenerate.
1/4 Regenerated thumbnails for "Vertical Featured Image" (ID 1027).
2/4 Regenerated thumbnails for "Horizontal Featured Image" (ID 1022).
3/4 Regenerated thumbnails for "Unicorn Wallpaper" (ID 1045).
4/4 Regenerated thumbnails for "I Am Worth Loving Wallpaper" (ID 1023).
Success: Regenerated 4 of 4 images.

# Re-generate only the thumbnails of "large" image size for all images.
$ wp media regenerate --image_size=large
Do you really want to regenerate the "large" image size for all images? [y/n] y
Found 3 images to regenerate.
1/3 Regenerated "large" thumbnail for "Sydney Harbor Bridge" (ID 760).
2/3 No "large" thumbnail regeneration needed for "Boardwalk" (ID 757).
3/3 Regenerated "large" thumbnail for "Sunburst Over River" (ID 756).
Success: Regenerated 3 of 3 images.
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
