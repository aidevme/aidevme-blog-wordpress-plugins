# Including a Software License

Reference: <https://developer.wordpress.org/plugins/plugin-basics/including-a-software-license/>

## Overview

Most WordPress plugins use the GPL license, which aligns with WordPress's own licensing approach. However, developers have access to other compatible licensing options and should always clearly communicate their chosen license.

## License Declaration Methods

There are two primary approaches for indicating a plugin's license:

1. **Plugin Header Comment**: As mentioned in the Header Requirements section, you can specify licensing information within the plugin header.
2. **License Block Comment**: A widely recommended practice involves placing a dedicated license block near the top of your main plugin file.

## Sample License Block Format

A typical license block reads along these lines:

> "{Plugin Name} is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation..."

This block typically includes:

- Declaration of free software status
- Redistribution and modification rights
- Version specification (e.g., version 2 or later)
- Warranty disclaimer
- Reference to the full license text
- Information about obtaining a copy if not included
