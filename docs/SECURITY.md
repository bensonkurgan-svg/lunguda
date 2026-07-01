# Security

What the application does to protect accounts and content, and what you must do.

## Built into the app

- **Passwords are hashed** with bcrypt (cost 12) and never stored or logged in plain text. The original PHP app stored plain-text passwords; this rebuild fixes that.
- **Role-based access.** Three roles — `learner`, `admin`, `superadmin`. Admin pages are gated by `auth` + a `role:admin` middleware; a `superadmin` implicitly passes admin gates. New sign-ups are always `learner` and can never self-assign a higher role.
- **Login rate limiting.** Five failed attempts per email+IP triggers a lockout, with a generic error that never reveals whether an email exists.
- **CSRF protection** on all state-changing requests (Laravel default), plus session regeneration on login/logout.
- **Validated, constrained file uploads.** Audio is limited to common audio MIME types and 8 MB; images to image types and 4 MB. Files are stored with random, non-guessable names on the configured disk.
- **Mass-assignment protection.** Every model declares an explicit `$fillable` allow-list.
- **Security headers** on every response (see `app/Http/Middleware/SecurityHeaders.php`): a Content-Security-Policy, `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy`, `Permissions-Policy`, and HSTS when served over HTTPS.
- **HTTPS enforcement** in production via `FORCE_HTTPS=true`, with proxy trust configured for Railway so the scheme/IP are detected correctly.
- **Encrypted, secure session cookies** (`SESSION_ENCRYPT=true`, `SESSION_SECURE_COOKIE=true`, `HttpOnly`, `SameSite=lax`).
- **Consent tracking.** Recordings carry a `consent_given` flag and provenance fields so you don't publish a voice without permission.

## Your responsibilities

1. **Change the seeded admin password immediately**, or set `ADMIN_EMAIL` / `ADMIN_PASSWORD` before seeding. Never ship `change-me-now`.
2. **Keep `APP_KEY` secret** and back it up. Losing it makes encrypted sessions/data unreadable.
3. **Keep `APP_DEBUG=false` in production.** Debug mode leaks configuration and stack traces.
4. **Grant `admin`/`superadmin` sparingly**, only to trusted community members.
5. **Run updates:** `composer update` and `npm update` periodically for security patches.
6. **Back up the database and the media** (the Volume or your S3/R2 bucket) on a schedule.

## Reporting a problem

Email the maintainers privately rather than opening a public issue, so a fix can ship before disclosure.
