# How Your Plugin Assets Work

Reference: <https://developer.wordpress.org/plugins/wordpress-org/plugin-assets/>

## Overview

The `assets` folder in your WordPress plugin stores images for your plugin's display page, including headers, icons, and screenshots. All files should be placed in the top-level `assets` directory of your SVN repository — not within `trunk` or version-specific folders.

Images are served through a CDN and cached heavily. Updates may take several minutes to hours to appear, especially during high-traffic periods.

## Default Image Sizes

Image dimensions must match their filenames exactly. For example, "banner-772x250.png" should be precisely 772x250 pixels. Don't make your images larger or smaller than the existing names indicate, or they will look terrible.

## Plugin Headers

Headers are the banner images displayed at the top of your plugin's page.

Filename options:

- Standard: `banner-772x250.(jpg|png)`
- Retina (High-DPI): `banner-1544x500.(jpg|png)`
- Localized versions: add language codes like `-rtl`, `-es`, or `-es_ES`

For right-to-left language directories (Hebrew, Arabic), design banners flexibly or create separate RTL versions. Maximum file size is 4MB.

## Plugin Icons

Icons appear in search results and WordPress administration areas. You can use PNG, JPG, GIF, or SVG formats. If you provide SVG, also include a PNG fallback for older browsers and Facebook compatibility.

Filename options:

- Standard: `icon-128x128.(png|jpg|gif)`
- Retina: `icon-256x256.(png|jpg|gif)`
- Vector: `icon.svg`

Maximum file size: 1MB.

## Screenshots

Screenshots illustrate your plugin's features and dashboard interface. Include one screenshot for each numbered line in your `readme.txt` file — those lines become captions.

Filename options:

- `screenshot-1.(png|jpg)`
- `screenshot-2.(png|jpg)`
- Localized: `screenshot-1-de.(png|jpg)` (for German, etc.)

All filenames must be lowercase. Maximum file size: 10MB. Screenshots must be local files; external links won't display.

## Common Issues

If images download instead of displaying, you need to set proper MIME types via SVN:

```
svn propset svn:mime-type image/png *.png
svn propset svn:mime-type image/jpeg *.jpg
```

Alternatively, add these settings to `~/.subversion/config` for future uploads.
