#!/bin/bash
# Drives the recording. Every command below runs for real against this app.
# Regenerate with .demo/record.sh
NEW=database/migrations/2024_06_01_000000_create_recommendation_events_table.php
PARKED=.demo/parked.php

say() { printf '\033[2m# %s\033[0m\n' "$1"; sleep 2; }
run() { printf '\033[1;32m$\033[0m %s\n' "$*"; sleep 0.6; "$@"; sleep 0.4; }

# The pull request has not happened yet.
[ -f "$NEW" ] && mv "$NEW" "$PARKED"

clear
say "Where does personal data live in this application?"
run php artisan privacy:discover --ansi
sleep 6

clear
say "The policy is written. Adopt the debt that predates it, once."
run php artisan privacy:baseline --force --ansi
sleep 2
run php artisan privacy:check --ansi
sleep 4

clear
say "Now a developer opens a pull request."
mv "$PARKED" "$NEW"
run sed -n '13,18p' "$NEW"
sleep 3
run php artisan privacy:check --ansi
sleep 2
say "Exit 1, on exactly the column the pull request added."
sleep 3
