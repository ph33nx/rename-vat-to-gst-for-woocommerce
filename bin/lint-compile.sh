#!/usr/bin/env bash
# Fails on any notice at compile time. The plugin compiles before PHPUnit installs its handler, so the suite cannot see one.
set -euo pipefail
cd "$(dirname "$0")/.."
out=$(find . -name '*.php' -not -path './vendor/*' -not -path './node_modules/*' -not -path './build/*' -print0 |
	xargs -0 -n1 php -d error_reporting=-1 -d display_errors=1 -d log_errors=0 -l 2>&1 | grep -v '^No syntax errors' | grep . || true)
if [ -n "$out" ]; then
	echo "$out"
	exit 1
fi
