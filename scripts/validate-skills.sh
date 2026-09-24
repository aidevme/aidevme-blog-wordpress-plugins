#!/usr/bin/env bash
#
# Audit skills against the Agent Skills specification (https://agentskills.io/specification).
#
# Usage:
#   scripts/validate-skills.sh [--strict] [skills-dir]
#
#   skills-dir  Directory holding one folder per skill. Default: .claude/skills
#   --strict    Treat warnings as failures (exit 1)
#
# Errors (exit 1): missing SKILL.md or frontmatter, missing/invalid `name`,
# name that differs from the folder name, missing or over-long `description`.
# Warnings: SKILL.md over 500 lines, top-level frontmatter keys the open spec
# does not define (Claude Code accepts some of them; the spec does not).

set -u

STRICT=0
SKILLS_DIR=""
for arg in "$@"; do
    case "$arg" in
        --strict) STRICT=1 ;;
        -h|--help) sed -n '2,14p' "$0" | sed 's/^# \{0,1\}//'; exit 0 ;;
        *) SKILLS_DIR="$arg" ;;
    esac
done

# Resolve the default relative to the repo root (this script lives in scripts/).
if [[ -z "$SKILLS_DIR" ]]; then
    SKILLS_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)/.claude/skills"
fi

if [[ ! -d "$SKILLS_DIR" ]]; then
    echo "Skills directory not found: $SKILLS_DIR" >&2
    exit 2
fi

if [[ -t 1 ]]; then
    RED=$'\033[0;31m'; GREEN=$'\033[0;32m'; YELLOW=$'\033[1;33m'; NC=$'\033[0m'
else
    RED=""; GREEN=""; YELLOW=""; NC=""
fi

ALLOWED_KEYS="name description license allowed-tools metadata compatibility"

ERRORS=0
WARNINGS=0
PASSED=0
CHECKED=0

# Print the frontmatter (text between the first two --- lines), CRLF stripped.
frontmatter_of() {
    tr -d '\r' < "$1" | awk '
        NR == 1 { if ($0 != "---") exit; started = 1; next }
        started && $0 == "---" { exit }
        started { print }
    '
}

# Print the value of a top-level scalar key. Handles plain, "double" and
# '"'"'single'"'"' quoted values, and folded/literal block scalars (> or |).
value_of() {
    local key="$1"
    awk -v key="$key" '
        function trim(s) { sub(/^[ \t]+/, "", s); sub(/[ \t]+$/, "", s); return s }
        $0 ~ "^" key ":" {
            v = $0; sub("^" key ":[ \t]*", "", v); v = trim(v)
            if (v ~ /^[>|][+-]?$/) { block = 1; next }
            if (v ~ /^".*"$/ || v ~ /^\x27.*\x27$/) v = substr(v, 2, length(v) - 2)
            print v; found = 1; exit
        }
        block && /^[ \t]+/ { out = out (out == "" ? "" : " ") trim($0); next }
        block { print out; found = 1; exit }
        END { if (block && !found) print out }
    '
}

shopt -s nullglob
for skill_dir in "$SKILLS_DIR"/*/; do
    skill_dir="${skill_dir%/}"
    skill_name="$(basename "$skill_dir")"
    skill_file="$skill_dir/SKILL.md"
    errors=()
    warnings=()
    CHECKED=$((CHECKED + 1))

    if [[ ! -f "$skill_file" ]]; then
        errors+=("Missing SKILL.md")
    else
        fm="$(frontmatter_of "$skill_file")"
        if [[ -z "$fm" ]]; then
            errors+=("Missing YAML frontmatter (--- block at the top of SKILL.md)")
        else
            # ---- name ----
            name="$(printf '%s\n' "$fm" | value_of name)"
            if [[ -z "$name" ]]; then
                errors+=("Missing 'name' in frontmatter")
            else
                if [[ "$name" != "$skill_name" ]]; then
                    errors+=("Name mismatch: folder is '$skill_name' but frontmatter says '$name'")
                fi
                if ! [[ "$name" =~ ^[a-z0-9]([a-z0-9-]*[a-z0-9])?$ ]] || [[ "$name" == *--* ]]; then
                    errors+=("Invalid name '$name' (lowercase letters, digits and single hyphens; no leading or trailing hyphen)")
                fi
                if [[ ${#name} -gt 64 ]]; then
                    errors+=("Name is ${#name} characters (maximum 64)")
                fi
            fi

            # ---- description ----
            description="$(printf '%s\n' "$fm" | value_of description)"
            if [[ -z "$description" ]]; then
                errors+=("Missing 'description' in frontmatter")
            elif [[ ${#description} -gt 1024 ]]; then
                errors+=("Description is ${#description} characters (maximum 1024)")
            fi

            # ---- unknown top-level keys ----
            while IFS= read -r key; do
                [[ -z "$key" ]] && continue
                case " $ALLOWED_KEYS " in
                    *" $key "*) ;;
                    *) warnings+=("Frontmatter key '$key' is not defined by the Agent Skills spec") ;;
                esac
            done < <(printf '%s\n' "$fm" | sed -n 's/^\([A-Za-z][A-Za-z0-9_-]*\):.*/\1/p')
        fi

        lines=$(wc -l < "$skill_file")
        if [[ $lines -gt 500 ]]; then
            warnings+=("SKILL.md is $lines lines (keep it under 500; move detail into references/)")
        fi
    fi

    if [[ ${#errors[@]} -gt 0 ]]; then
        echo "${RED}✗ $skill_name${NC}"
        for e in "${errors[@]}"; do echo "    ${RED}error:${NC} $e"; done
        for w in "${warnings[@]}"; do echo "    ${YELLOW}warning:${NC} $w"; done
        ERRORS=$((ERRORS + 1))
    elif [[ ${#warnings[@]} -gt 0 ]]; then
        echo "${YELLOW}! $skill_name${NC}"
        for w in "${warnings[@]}"; do echo "    ${YELLOW}warning:${NC} $w"; done
        WARNINGS=$((WARNINGS + 1))
    else
        echo "${GREEN}✓ $skill_name${NC}"
        PASSED=$((PASSED + 1))
    fi
done

echo
echo "Checked $CHECKED skill(s) in $SKILLS_DIR: $PASSED passed, $WARNINGS with warnings, $ERRORS with errors."

if [[ $CHECKED -eq 0 ]]; then
    echo "No skill folders found." >&2
    exit 2
fi
if [[ $ERRORS -gt 0 ]]; then
    exit 1
fi
if [[ $STRICT -eq 1 && $WARNINGS -gt 0 ]]; then
    exit 1
fi
exit 0
