#!/usr/bin/env bash
# Builds build/rename-vat-to-gst-for-woocommerce.zip with the files the SVN deploy ships: both read .distignore.
set -euo pipefail
cd "$(dirname "$0")/.."
rm -rf build
mkdir -p build/rename-vat-to-gst-for-woocommerce
rsync -a --exclude-from=.distignore ./ build/rename-vat-to-gst-for-woocommerce/
(cd build && zip -qr rename-vat-to-gst-for-woocommerce.zip rename-vat-to-gst-for-woocommerce)
find build/rename-vat-to-gst-for-woocommerce -type f | sort
