# Privacy CI demo

A small Laravel application with a deliberately awkward schema, for trying
[Privacy CI](https://github.com/AsterlaneLabs/privacy-ci) without pointing it at
anything you care about.

```bash
composer install
touch database/database.sqlite
php artisan migrate --force
php artisan privacy:discover
```

## The forty second version

```bash
php artisan privacy:discover          # what personal data is here, and where
php artisan privacy:make-policy       # a file to edit rather than compose
php artisan privacy:check             # CHECK FAILED, exit 1
php artisan privacy:baseline          # forgive what predates adoption
php artisan privacy:check             # CHECK PASSED
```

Then add a migration with a `user_id` column and run `privacy:check` again. It
fails on exactly that column and nothing else. That is the product.

## Erasing someone, for real

```bash
php artisan privacy:make-handler      # writes app/Privacy/DeleteUser.php
php artisan privacy:forget 1 --force  # suspends, starts the clock
php artisan privacy:process-deletions # erases, then verifies
php artisan privacy:verify 1          # what was checked, and what was not
```

The demo sets `grace_days` to 0 so the erasure runs immediately. A real
application would leave the window in place.

## What the schema is for

Every table here exists to test one thing.

| Table | Why |
|---|---|
| `orders`, `comments` | linked by a real foreign key |
| `audit_entries` | **no** foreign key; only the Eloquent relationship reveals the link |
| `newsletter_signups` | personal data with nothing pointing at a user |
| `legacy_profiles` | declared as raw `CREATE TABLE` inside `DB::statement()` |
| `countries`, `order_statuses`, `refund_reasons` | **decoys**: `name`, `city`, `reason`, `description` that are not about people |
| `webhook_deliveries` | **decoys**: `email_template_id`, `email_sent`, `email_sent_at`, `payload` |
| `app/Services/ProfileCache.php` | writes a cache key and a file, which no migration describes |
| `config/theme.php` | mentions "snowflake" as an icon name, which is not a data warehouse |

The decoys matter more than the finds. Anyone can build a demo where a scanner
reports something. The useful question is whether it stays quiet about twenty
columns that merely look personal.

At the time of writing it finds 23 real locations and reports none of the decoys.

## Things the demo taught the tool

Building this turned up three checks that did not exist before:

- Anonymising a `NOT NULL` column cannot work, and the migration already says so.
- Retaining rows that hold a foreign key to a row being deleted makes the delete
  impossible. Keeping the row while dropping the link is anonymisation.
- A cache key written with `Cache::put()` should be cleared with
  `Cache::forget()`, not by reaching for Redis directly.

That is what a demo application is for.
