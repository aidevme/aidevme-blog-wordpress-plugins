# Shortcodes

Reference: <https://developer.wordpress.org/plugins/shortcodes/>

## Overview

WordPress prohibits running PHP within content for security reasons. To enable dynamic content interactions, shortcodes were introduced in version 2.5. These macros allow operations such as creating a gallery from images attached to the post or rendering a video.

## Why Shortcodes?

Shortcodes maintain clean, semantic content while giving users programmatic control over presentation. Key benefits include:

- No markup clutters post content, enabling flexible styling adjustments
- Parameters allow instance-by-instance customization

## Built-in WordPress Shortcodes

WordPress includes six default shortcodes:

- `[caption]` — wraps captions around content
- `[gallery]` — displays image galleries
- `[audio]` — embeds and plays audio files
- `[video]` — embeds and plays video files
- `[playlist]` — shows audio or video collections
- `[embed]` — wraps embedded items

## Best Practices

Developers should follow plugin development standards plus these guidelines:

- Always return values to avoid side effects and bugs
- Prefix shortcode names to prevent collisions
- Sanitize inputs and escape outputs
- Document all shortcode attributes clearly
