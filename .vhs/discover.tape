# Regenerate with: vhs .vhs/discover.tape
# Everything below runs for real against this application.

Output docs/privacy-ci.gif

Set Shell zsh
Set FontSize 15
Set Width 1180
Set Height 760
Set Padding 18
Set Theme "Catppuccin Mocha"
Set TypingSpeed 45ms
Set PlaybackSpeed 1.0

Hide
Type "cd ~/PhpstormProjects/AsterlaneLabs/privacy-ci-demo && clear" Enter
Sleep 2s
Show

Type "# Where does personal data live in this application?" Sleep 900ms Enter
Sleep 400ms
Type "php artisan privacy:discover" Enter
Sleep 9s

Type "clear" Enter
Sleep 300ms
Type "# Turn those findings into a policy you edit, not one you compose." Sleep 900ms Enter
Type "php artisan privacy:make-policy --force" Enter
Sleep 5s

Type "clear" Enter
Sleep 300ms
Type "# A policy is already in place here. Adopt the existing debt once." Sleep 900ms Enter
Type "php artisan privacy:baseline --force" Enter
Sleep 4s
Type "php artisan privacy:check" Enter
Sleep 6s

Type "clear" Enter
Sleep 300ms
Type "# Now a developer opens a pull request." Sleep 1s Enter
Type "cat database/migrations/2024_06_01_*_create_recommendation_events_table.php | sed -n '12,18p'" Enter
Sleep 4s
Type "php artisan privacy:check" Enter
Sleep 8s
Type "# Exit 1, on exactly that column." Sleep 2s Enter
Sleep 2s
