---
name: wordpress-plugin-security-checklist
description: The security checklist for WordPress plugins in this repo - capability checks, nonces, input sanitization, output escaping, and safe $wpdb writes. Use when designing a plugin's permissions in a spec, writing or changing admin screens/handlers/AJAX/REST code, or reviewing plugin code for security gaps. Triggers on "security", "nonce", "capability", "sanitize", "escape", "harden", "security review" for anything under src/<plugin>/.
---

# WordPress plugin security checklist

The single source for this repo's security rules. Apply it in whichever role you are in: designing (state each item in the spec), implementing (satisfy each item in code), or reviewing (check each item against the code and report gaps).

The authority behind the rules is the local Plugin Handbook mirror: `docs/wordpress/wordpress-plugins/04-plugin-security/`. Read the relevant page there rather than relying on memory. Several pages there note that their content "moved" to the Common APIs Handbook; that is expected and the local file is already correct.

## The checklist

1. **Capability check on every admin screen and every state-changing handler.**
   - Use `current_user_can()`; this repo's plugins use `manage_options` unless the spec names a narrower capability.
   - Check on screen render *and* on the handler that saves, deletes or syncs, not just one of them.
2. **Nonce on every form and every handler that consumes one.**
   - `wp_nonce_field()` on each form; `check_admin_referer()` (or `check_ajax_referer()` for AJAX) in its handler.
   - For React admin screens the equivalent is a nonce passed through localized script data and submitted with the request.
3. **Sanitize every input on the way in**, chosen per field type: `sanitize_text_field()`, `sanitize_textarea_field()`, `esc_url_raw()`, `absint()`, `sanitize_key()`, an allow-list for fixed value sets (for example a status dropdown). Never trust `$_POST`, `$_GET` or `$_REQUEST` values as they arrive.
4. **Escape every output at render time**, not earlier: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()` where limited HTML is intended. Escape late, in the template or render function.
5. **Writes go through `$wpdb->insert()`, `update()` and `delete()`.** Never raw `$wpdb->query()` with interpolated values. Where a query must be raw, use `$wpdb->prepare()`.
6. **All database access goes through the plugin's single shared data-layer class** (for credentials-manager-plugin, `Credpl_Data`), so escaping and query shape live in one place.
7. **Direct access and destructive actions:** PHP files guard against direct access (`defined( 'ABSPATH' ) || exit;`), and destructive operations are never triggered from a GET request without a nonce.

## When designing (architect)

State the security decisions in the spec instead of leaving them implicit:

- The capability each screen and action requires, and flag any choice narrower or broader than `manage_options`.
- That each state-changing action is nonce-protected.
- Which sanitization and escaping function applies to each field.

## When implementing (developer)

Apply items 1-7 to every new handler and template. After writing, re-read your diff against the list and say which items you verified by reading and which need a running site.

## When reviewing (tester)

Check each item across the whole plugin, not only what the spec mentions:

- Every admin screen and handler: capability check present?
- Every form: nonce field paired with a verification on its handler?
- Every output: escaped at render time? Every input: sanitized on the way in?
- Every write: through `$wpdb->insert()`/`update()`/`delete()`?

Report findings with file and line, grouped as "meets the checklist" and "gaps", including gaps the spec never mentions. Be explicit about what you confirmed by reading code versus what would need a live WordPress install to confirm. Do not fix the gaps unless asked; report them clearly enough for `developer` to act.
