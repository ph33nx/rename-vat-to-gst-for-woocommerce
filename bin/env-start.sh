#!/usr/bin/env bash
# `wp-env run` can answer "Environment not initialized" right after `start` on a CI runner, so wait until it responds.
set -euo pipefail
for attempt in 1 2 3; do
	if npx wp-env start --update && npx wp-env run tests-cli wp cli info; then
		exit 0
	fi
	echo "wp-env not ready (attempt $attempt of 3)"
	sleep 15
done
exit 1
