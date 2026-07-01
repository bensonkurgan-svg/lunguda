# Installing locally

This guide gets the archive running on your own computer for development or content entry before you deploy.

## 1. Requirements

- **PHP 8.2 or newer** with these extensions: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd` (for images), and your database driver (`pdo_mysql` or `pdo_pgsql`).
- **Composer 2**
- **Node.js 20+** and npm
- A database: **MySQL 8**, **MariaDB 10.6+**, or **PostgreSQL 14+**. (SQLite also works for quick local testing.)

Check what you have:

```bash
php -v
composer --version
node -v
```

## 2. Get the code and install dependencies

```bash
cd lunguda
composer install
npm install
```

## 3. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and set your database. For local MySQL:

```dotenv
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
FORCE_HTTPS=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lunguda
DB_USERNAME=root
DB_PASSWORD=your_password

# In local dev you usually want these off so cookies work over http:
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=false
```

> **Quick test with SQLite instead?** Set `DB_CONNECTION=sqlite`, then `touch database/database.sqlite` and skip the MySQL settings.

Set the first admin account before seeding:

```dotenv
ADMIN_EMAIL=you@example.com
ADMIN_PASSWORD=a-strong-password
```

## 4. Create the database tables and seed sample data

```bash
php artisan migrate --seed
```

This builds all tables and creates a superadmin plus a handful of example records (clans, words in each dialect, a ruler, an oral tradition, etc.) so the site isn't empty.

## 5. Link storage and build assets

```bash
php artisan storage:link
npm run build
```

`storage:link` makes uploaded audio and images publicly viewable. Use `npm run dev` instead of `npm run build` while developing — it rebuilds CSS/JS as you edit.

## 6. Run it

```bash
php artisan serve
```

Open **http://localhost:8000**. Sign in at **/login** with the admin credentials you set, and you'll land on the admin dashboard at **/admin**.

## Common issues

| Symptom | Fix |
|---------|-----|
| `419 Page Expired` on login | Your session cookie isn't being set. In local http, set `SESSION_SECURE_COOKIE=false`. |
| Uploaded images/audio don't show | You skipped `php artisan storage:link`, or your `APP_URL` doesn't match the address you're visiting. |
| CSS looks unstyled | Run `npm run build` (or `npm run dev`) and hard-refresh. |
| `Class "..." not found` after adding files | `composer dump-autoload`. |
| Map on the Sites page is blank | The map only loads when scrolled into view and needs internet access to fetch Leaflet + OpenStreetMap tiles. |

## Running tests

```bash
php artisan test
```
