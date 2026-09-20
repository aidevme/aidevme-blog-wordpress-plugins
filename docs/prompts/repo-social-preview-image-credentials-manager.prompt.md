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

- **What the repo is:** WordPress plugins for the Aidevme Blog. The flagship
  plugin, *Credentials Manager*, manages credentials, certifications and exams
  and shows them as badges on the blog.
- **Palette** (taken from the plugin itself, since the repo has no logo or brand
  guide): Fluent UI brand blue `#0F6CBD` as the accent, on the WordPress admin
  dark slate `#1D2327`, with white text.
- **Visual metaphors:** a puzzle piece (plugin), an award ribbon / badge
  (credentials), and floating dashboard cards (the plugin's admin UI).
- **No real logos.** Image models garble them, and the WordPress and Microsoft
  marks are trademarks. Use generic shapes only.

## Prompt 1 — background art only (recommended)

Image models are unreliable at rendering text. Generate the artwork with the left
half left empty, then add the title yourself (Figma, Canva, or any editor) using
the text spec in the next section.

```text
Wide 2:1 banner illustration for a software developer's GitHub repository, flat
isometric vector style with soft gradients and subtle depth. Deep slate
background (#1D2327) with a faint blue radial glow and a fine dotted grid.
The RIGHT 45% of the image holds the artwork: a small stack of floating
rounded dashboard cards in white and light grey with thin blue outlines, each
card showing only a simple icon (no readable text), one card slightly raised
as if hovered; in front of the cards, a glowing electric-blue (#0F6CBD)
puzzle piece representing a plugin, and a gold-and-blue award ribbon badge
representing a certification. Crisp edges, clean modern SaaS look, generous
negative space. The LEFT 55% of the image is intentionally empty dark
background with only the faint glow and grid, reserved for a headline. No
text, no letters, no numbers, no logos, no watermark. Centered composition
safe for cropping, 2:1 aspect ratio, high resolution.
```

## Text to add over the empty left half

| Line | Text | Style |
| --- | --- | --- |
| Headline | **Aidevme Blog** | Bold sans-serif (Segoe UI / Inter), white, ~96 px |
| Headline 2 | **WordPress Plugins** | Same font, light blue `#4FA3E8`, ~96 px (the brand blue `#0F6CBD` itself is too dark to read as text on the slate background, so it's used for shapes only) |
| Subtitle | Credentials Manager · React + Fluent UI | Regular weight, light grey `#C8CDD2`, ~36 px |

Left-align the block, vertically centered, starting ~80 px from the left edge.

## Prompt 2 — with the headline rendered by the model

Only try this if your generator handles text well; check the spelling of every
word in the result. Keep the text this short on purpose.

```text
Wide 2:1 GitHub repository banner, flat isometric vector style. Deep slate
background (#1D2327) with a faint blue glow and a fine dotted grid. On the
left, a large left-aligned bold white sans-serif headline reading exactly
"Aidevme Blog" on the first line and "WordPress Plugins" on the second line,
the second line in bright blue. On the right, floating rounded white
dashboard cards with simple icons and no other text, a glowing electric-blue
(#0F6CBD) puzzle piece, and a gold-and-blue award ribbon badge. Clean modern
software look, generous negative space, high contrast, no other text, no
logos, no watermark, 2:1 aspect ratio.
```

## Negative prompt (for generators that support one)

```text
extra text, misspelled words, gibberish letters, real brand logos, WordPress
logo, Microsoft logo, watermark, signature, photo, people, faces, hands,
clutter, low contrast, blurry, off-center, cropped objects, more than one
puzzle piece
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
