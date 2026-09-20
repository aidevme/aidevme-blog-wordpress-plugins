# Repo social preview image — image-generation prompt

Prompt for generating the GitHub **Social preview** image of this repository
(Settings → General → Social preview → Edit). It is also what shows when the
repo link is pasted into Slack, LinkedIn, X, Discord, etc.

## Specs

| | |
| --- | --- |
| Size | **1280 × 640 px** (2:1). GitHub's minimum is 640 × 320. |
| Format | PNG, JPG or GIF, **under 1 MB** (per GitHub's docs). Use a solid background, not transparency — it shows up differently on light and dark sites. |
| Safe area | GitHub's docs give no safe margin, so this is a conservative rule of thumb: keep everything important at least **60 px from every edge**, because GitHub and link unfurlers (Slack, LinkedIn, X) crop differently. The **Download template** link in the Social preview settings offers GitHub's own template. |
| Legibility | Link previews are often shown ~500 px wide. The headline must still read at that size. |

## Design brief (why the prompt looks the way it does)

- **What the repo is:** a collection of WordPress plugins built for the Aidevme
  Blog. The image represents the *whole collection*, not any single plugin, so
  it must stay accurate as plugins are added or removed — no plugin names,
  feature-specific icons, or screenshots.
- **Palette:** WordPress-admin-inspired — dark slate `#1D2327` background, a
  strong blue accent `#0F6CBD`, white text. The repo has no logo or brand guide
  yet, so swap these hex values if one is created.
- **Visual metaphors:** several interlocking puzzle pieces (many plugins working
  together), a code-bracket / plug motif (development), and floating admin
  dashboard cards (WordPress admin).
- **No real logos.** Image models garble them, and the WordPress mark is a
  trademark. Use generic shapes only.

## Prompt 1 — background art only (recommended)

Image models are unreliable at rendering text. Generate the artwork with the left
half left empty, then add the title yourself (Figma, Canva, or any editor) using
the text spec in the next section.

```text
Wide 2:1 banner illustration for a software developer's GitHub repository, flat
isometric vector style with soft gradients and subtle depth. Deep slate
background (#1D2327) with a faint blue radial glow and a fine dotted grid.
The RIGHT 45% of the image holds the artwork: three interlocking puzzle pieces
in different shades of blue (electric blue #0F6CBD, a lighter sky blue, and a
deep navy) fitted together to represent a collection of plugins working as
one, the central piece glowing softly; behind them, a few floating rounded
dashboard cards in white and light grey with thin blue outlines, each showing
only a simple abstract icon (no readable text); small accents of a code
bracket symbol and a power-plug icon drawn as simple line glyphs. Crisp edges,
clean modern software look, generous negative space. The LEFT 55% of the
image is intentionally empty dark background with only the faint glow and
grid, reserved for a headline. No text, no letters, no numbers, no logos, no
watermark. Centered composition safe for cropping, 2:1 aspect ratio, high
resolution.
```

## Text to add over the empty left half

| Line | Text | Style |
| --- | --- | --- |
| Headline | **Aidevme Blog** | Bold sans-serif (Segoe UI / Inter), white, ~96 px |
| Headline 2 | **WordPress Plugins** | Same font, light blue `#4FA3E8`, ~96 px (the brand blue `#0F6CBD` itself is too dark to read as text on the slate background, so it's used for shapes only) |
| Subtitle | Custom plugins built for the Aidevme Blog | Regular weight, light grey `#C8CDD2`, ~36 px |

Left-align the block, vertically centered, starting ~80 px from the left edge.

## Prompt 2 — with the headline rendered by the model

Only try this if your generator handles text well; check the spelling of every
word in the result. Keep the text this short on purpose.

```text
Wide 2:1 GitHub repository banner, flat isometric vector style. Deep slate
background (#1D2327) with a faint blue glow and a fine dotted grid. On the
left, a large left-aligned bold white sans-serif headline reading exactly
"Aidevme Blog" on the first line and "WordPress Plugins" on the second line,
the second line in bright blue. On the right, three interlocking puzzle
pieces in different shades of blue fitted together, the central one glowing,
with a few floating rounded white dashboard cards behind them showing simple
icons and no other text. Clean modern software look, generous negative space,
high contrast, no other text, no logos, no watermark, 2:1 aspect ratio.
```

## Negative prompt (for generators that support one)

```text
extra text, misspelled words, gibberish letters, real brand logos, WordPress
logo, watermark, signature, photo, people, faces, hands, clutter, low
contrast, blurry, off-center, cropped objects
```

## Generator tips

- **Aspect ratio:** Midjourney takes `--ar 2:1` directly. If your generator has
  no 2:1 option, generate at the widest ratio it offers (16:9 or 3:2), keep the
  artwork in the middle band, and crop to 2:1.
- **Resize:** export or resize to exactly **1280 × 640**.
- **Iterate on the right half only** — the composition is the artwork; the
  headline is the part you control precisely, so it's best added by hand.
- **Check it small:** view the result at ~500 px wide before uploading.

## Uploading

Repository → **Settings** → **General** → **Social preview** → **Edit** →
**Upload an image…**
