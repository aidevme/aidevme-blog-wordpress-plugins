# TinyMCE Enhanced Shortcodes

Reference: <https://developer.wordpress.org/plugins/shortcodes/tinymce-enhanced-shortcodes/>

It's possible to parse shortcodes within the visual editor of TinyMCE and make them render actual content, rather than the shortcode itself.

Switching to the `Text` tab allows you to see the actual shortcode again.

Below are the built-in WordPress shortcodes that use this functionality.

## Audio Shortcode

The `[audio]` shortcode allows you to embed a single audio file.

## Caption Shortcode

The `[caption]` shortcode wraps the image in a div and puts a `<p class="wp-caption-text">` tag around the caption.

## Gallery Shortcode

The `[gallery]` shortcode allows you to embed several images at once in a div.

## Playlist Shortcode

The `[playlist]` shortcode allows you to attach more than one media file and render with an html5 playlist.

## Video Shortcode

The `[video]` shortcode is very similar to the `[audio]` shortcode; it simply renders a video instead of audio.
