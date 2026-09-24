---
name: changelog-entry
description: Writes the CHANGE_LOG.md entry required for every plugin code change in this repo. Use after changing any code under src/<plugin>/ - features, bug fixes, refactors and internal-only changes alike - or when asked to "add a changelog entry", "log this change" or "update CHANGE_LOG.md".
---

# Change log entry

Every code change to a plugin gets a new entry in that plugin's own `CHANGE_LOG.md` (in `src/<plugin>/`, beside `SPECIFICATION.md`). That includes bug fixes, refactors and internal-only changes, not just features. `SPECIFICATION.md` describes the plugin as it currently is; the history of how it got there lives only in `CHANGE_LOG.md`. Never grow a second history in the spec.

## Steps

1. **Find the file.** Open `src/<plugin>/CHANGE_LOG.md`. If the plugin has none, create it (see "New file" below).
2. **Find the next number.** Entries are numbered `vNN` in ascending order, one bullet each. Read the last entry and use the next number. Always check the file rather than trusting a remembered number. Move the "(this version)" marker to your entry if the file uses one.
3. **Write one entry per change**, appended as a top-level bullet at the end of the list:
   - Start with `- **vNN <what changed, in one bold sentence>**`, followed by the spec section it affects, for example `(§6.2.1)`.
   - Then say what changed and why.
   - Add sub-bullets when the change has several parts (database, PHP classes and files, build output, front end, admin UI), naming the exact identifiers involved.
   - State what stays the same when it is not obvious (for example, that `save()` needed no change because the submitted field names are identical).
4. **Describe upgrade impact whenever the change is not purely additive** to a running site: a schema change (and whether `dbDelta()` covers it or a `maybe_*` migration runs, with the database-version bump), a breaking rename (shortcodes, options, script handles), or behavior that differs after upgrading. Say what an existing site must do, if anything.
5. **Keep the spec in step.** If the change alters how the plugin works, update the matching `SPECIFICATION.md` sections to describe the plugin as it now is, with cross-references written as `(§10 vNN)` pointing at your entry. Do not duplicate the entry's content into the spec.

## Model to follow

`src/credentials-manager-plugin/CHANGE_LOG.md`, especially its later entries, which show the expected level of detail: a bold headline, the spec section, identifiers named exactly, sub-bullets by area, and an explicit "not changed" note where useful. (`docs/styles/CHANGE-LOG-STYLE.md` exists but is empty, so do not attribute rules to it.)

## New file

Create `src/<plugin>/CHANGE_LOG.md` with a heading `# <Plugin Name> - Change Log`, a short paragraph explaining that it holds the version-by-version history and that `SPECIFICATION.md` describes the plugin as it currently is, then your first entry as `- **v1 ...**`.

## Do not

- Skip the entry because the change is "small" or "internal".
- Rewrite or renumber earlier entries; add a new one that supersedes them if needed.
- Commit or push; leave that to the user.
