#!/bin/bash
# Re-record the README gif. Needs: asciinema, agg.
set -e
cd "$(dirname "$0")/.."
rm -f privacy-baseline.json .demo/parked.php
git checkout -- database/migrations 2>/dev/null || true
php artisan migrate:fresh --force >/dev/null
asciinema rec --overwrite --cols 106 --rows 32 -c ".demo/script.sh" .demo/privacy-ci.cast >/dev/null
git checkout -- database/migrations 2>/dev/null || true
rm -f .demo/parked.php
agg --theme monokai --font-size 16 --cols 106 --rows 32 .demo/privacy-ci.cast docs/privacy-ci.gif
echo "wrote docs/privacy-ci.gif"
