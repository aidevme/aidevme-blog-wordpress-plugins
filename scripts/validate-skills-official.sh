#!/usr/bin/env bash
#
# Validate skills with the official skills-ref library from the Agent Skills project
# (https://github.com/agentskills/agentskills/tree/main/skills-ref).
#
# Usage:
#   scripts/validate-skills-official.sh [skills-dir]
#
#   skills-dir  Directory holding one folder per skill. Default: .claude/skills
#
# Environment:
#   SKILLS_REF_REF  Git ref (tag or commit) of agentskills to install. Default: main.
#                   Pin it to a commit for reproducible runs.
#   SKILLS_REF_DIR  Where to keep the checkout. Default: ~/.cache/agentskills
#
# Needs git and either uv or python3 (with venv and pip). On Windows run it
# from Git Bash or WSL.

set -u

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SKILLS_DIR="${1:-$REPO_ROOT/.claude/skills}"
SKILLS_REF_REF="${SKILLS_REF_REF:-main}"
CHECKOUT_DIR="${SKILLS_REF_DIR:-$HOME/.cache/agentskills}"
LIB_DIR="$CHECKOUT_DIR/skills-ref"

if [[ ! -d "$SKILLS_DIR" ]]; then
    echo "Skills directory not found: $SKILLS_DIR" >&2
    exit 2
fi

echo "Validating skills with the official skills-ref library"
echo "  skills:  $SKILLS_DIR"
echo "  library: $LIB_DIR (ref: $SKILLS_REF_REF)"
echo

# The virtualenv layout differs between platforms.
venv_bin() {
    if [[ -d "$LIB_DIR/.venv/bin" ]]; then echo "$LIB_DIR/.venv/bin"
    elif [[ -d "$LIB_DIR/.venv/Scripts" ]]; then echo "$LIB_DIR/.venv/Scripts"
    fi
}

if [[ -z "$(venv_bin)" ]]; then
    echo "Installing skills-ref..."
    if [[ ! -d "$CHECKOUT_DIR/.git" ]]; then
        mkdir -p "$CHECKOUT_DIR" || exit 2
        git clone https://github.com/agentskills/agentskills.git "$CHECKOUT_DIR" || exit 2
    fi
    git -C "$CHECKOUT_DIR" fetch --quiet origin "$SKILLS_REF_REF" 2>/dev/null
    git -C "$CHECKOUT_DIR" checkout --quiet "$SKILLS_REF_REF" 2>/dev/null \
        || git -C "$CHECKOUT_DIR" checkout --quiet FETCH_HEAD || exit 2

    if command -v uv >/dev/null 2>&1; then
        (cd "$LIB_DIR" && uv sync) || exit 2
    else
        (cd "$LIB_DIR" && python3 -m venv .venv) || exit 2
        BIN="$(venv_bin)"
        "$BIN/python" -m pip install --quiet -e "$LIB_DIR" || exit 2
    fi
    echo
fi

BIN="$(venv_bin)"
if [[ -z "$BIN" || ! -x "$BIN/skills-ref" && ! -x "$BIN/skills-ref.exe" ]]; then
    echo "skills-ref was not installed correctly in $LIB_DIR/.venv" >&2
    exit 2
fi

PASSED=0
FAILED=0
FAILED_SKILLS=()

shopt -s nullglob
for skill_dir in "$SKILLS_DIR"/*/; do
    skill_dir="${skill_dir%/}"
    skill_name="$(basename "$skill_dir")"
    printf '  %-40s' "$skill_name"

    output="$("$BIN/skills-ref" validate "$skill_dir" 2>&1)"
    status=$?
    if [[ $status -eq 0 ]]; then
        echo "✓"
        PASSED=$((PASSED + 1))
    else
        echo "✗"
        FAILED=$((FAILED + 1))
        FAILED_SKILLS+=("$skill_name")
        printf '%s\n' "$output" | sed 's/^/      /'
    fi
done

echo
echo "Passed: $PASSED   Failed: $FAILED"

if [[ $((PASSED + FAILED)) -eq 0 ]]; then
    echo "No skill folders found." >&2
    exit 2
fi
if [[ $FAILED -gt 0 ]]; then
    echo "Failed skills:"
    for s in "${FAILED_SKILLS[@]}"; do echo "  - $s"; done
    exit 1
fi
echo "All skills are valid."
exit 0
