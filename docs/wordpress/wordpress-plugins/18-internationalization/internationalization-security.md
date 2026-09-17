# Internationalization Security

Reference: <https://developer.wordpress.org/plugins/internationalization/security/>

## Overview

Security considerations in internationalization are often neglected but critical. The following four practices help secure internationalized content.

## Verify Translator Submissions

When a translator submits a localization to you, always check to make sure they didn't include spam or other malicious words in their translation. Tools like Google Translate can help compare original and translated content.

## Escape Internationalized Strings

Translators could potentially inject malicious code. The recommended approach is escaping output.

Vulnerable approach:

```php
_e( 'The REST API content endpoints were added in WordPress 4.7.', 'your-text-domain' );
```

Secure approach:

```php
esc_html_e( 'The REST API content endpoints were added in WordPress 4.7.', 'your-text-domain' );
```

Alternatively, implement translation verification systems, similar to the WordPress Polyglots editor roles.

## Replace URLs with Placeholders

Don't include URLs in internationalized strings, because a malicious translator could change them to point to a different URL. Use `printf()` or `sprintf()` with placeholders instead.

## Compile .mo Files Independently

You should discard a translator's supplied .mo file and compile your own, because you have no way of knowing whether or not it was compiled from the corresponding .po file. Use command-line compilation:

```bash
msgfmt -cv -o /path/to/output.mo /path/to/input.po
```
