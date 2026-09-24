# wp block

Reference: <https://developer.wordpress.org/cli/commands/block/>

## Description

Manages WordPress block editor blocks and related entities.

## Synopsis

```bash
wp block <command>
```

## Subcommands

| Name | Description |
| --- | --- |
| wp block binding | Retrieves details on registered block binding sources. |
| wp block pattern | Retrieves details on registered block patterns. |
| wp block pattern-category | Retrieves details on registered block pattern categories. |
| wp block style | Retrieves details on registered block styles. |
| wp block synced-pattern | Manages synced patterns (reusable blocks). |
| wp block template | Retrieves details on block templates and template parts. |
| wp block type | Retrieves details on registered block types. |

## Examples

```bash
# List all registered block types
$ wp block type list

# Get a specific block pattern
$ wp block pattern get my-theme/hero

# List block styles for a specific block
$ wp block style list --block=core/button

# Export a block template
$ wp block template export twentytwentyfour//single --stdout

# Create a synced pattern
$ wp block synced-pattern create --title="My Pattern" --content='&lt;!-- wp:paragraph --&gt;&lt;p&gt;Hello&lt;/p&gt;&lt;!-- /wp:paragraph --&gt;'
```
