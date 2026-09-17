# Localization

Reference: <https://developer.wordpress.org/plugins/internationalization/localization/>

## Overview

Localization describes translating an internationalized plugin. The term is abbreviated as `l10n` due to the 10 letters between "l" and "n."

## Localization File Types

POT (Portable Object Template) files contain the original English strings from your plugin.

PO (Portable Object) files are created when translators take the POT file and translate the `msgstr` sections into their language. Each language requires one PO file.

MO (Machine Object) files are binary, machine-readable versions compiled from PO files. These are what gettext functions actually use. The conversion uses the `msgfmt` command line tool.

## Generating POT Files

Three primary methods exist:

- **WP-CLI**: Use the `wp i18n make-pot` command after installing WP-CLI
- **Poedit**: An open-source tool available for major operating systems that can scan source code for translatable strings
- **Grunt Tasks**: Automated tools like grunt-wp-i18n and grunt-pot can generate POT files during development

It's recommended to include the POT file with your plugin so translators don't need to request it separately.

## Translation Methods

Translators can work with PO files through:

- Manual editing using text editors
- Poedit software with integrated scanning capabilities
- Online services like Transifex, WebTranslateIt, Poeditor, or GlotPress

## Creating MO Files

Convert PO files to MO files using:

- Command line with `msgfmt` (part of the Gettext package)
- Poedit, which includes integrated conversion
- Grunt tasks via grunt-po2mo

## Translation Best Practices

Effective translators should:

- Prioritize natural expression over literal translation
- Maintain consistent formality levels matching the original
- Avoid slang and culture-specific terminology
- Study how other software localizes in their language for consistency

## File Placement and Activation

Store localization files in `wp-content/languages/plugins/` following the naming format: `plugin-name-{locale}.mo`

Activate by defining `WPLANG` in `wp-config.php` or through WordPress General Settings.
