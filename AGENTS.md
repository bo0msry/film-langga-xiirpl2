# Repository Guide

## Project
- Laravel 13 application requiring PHP 8.3 or newer.
- Composer manages PHP dependencies; Vite manages the frontend build.
- Film and movie functionality is organized across `app/Http/Controllers`, `app/Models`, `app/Repositories`, `app/Interfaces`, and `routes/`.
- Blade views and frontend assets live under `resources/`.
- Database migrations, seeders, and factories live under `database/`.

## Working Conventions
- Follow the existing Laravel patterns and keep changes scoped to the affected feature.
- Preserve existing route names and API contracts unless a change explicitly requires otherwise.
- Add or update PHPUnit tests in `tests/` when changing behavior. Check neighboring tests before choosing a test style.
- Do not commit `.env` contents or expose credentials, application keys, or database secrets.
- Avoid unrelated changes to generated files or installed dependencies under `vendor/` and `node_modules/`.

## Validation
- Run PHP tests with `php artisan test`.
- Check PHP formatting with `vendor/bin/pint --test` (or format touched files with `vendor/bin/pint`).
- Verify frontend production assets with `npm run build` when frontend files change.
- Start the frontend dev server with `npm run dev` when needed.
