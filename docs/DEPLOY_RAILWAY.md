# Deploying to Railway

Railway will build the included `Dockerfile` (Node compiles the assets, PHP serves the app behind nginx) and run your database migrations automatically on each deploy.

You do **not** need a domain yet — Railway gives you a free `*.up.railway.app` URL. Add your own domain later (last section).

---

## 1. Push the project to GitHub

Railway deploys from a Git repository.

```bash
git init
git add .
git commit -m "Lunguda Heritage Archive"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/lunguda.git
git push -u origin main
```

## 2. Create the Railway project

1. Go to **railway.app**, sign in, and click **New Project → Deploy from GitHub repo**.
2. Pick your `lunguda` repository. Railway detects the `Dockerfile` and starts building.
3. The first build will deploy but **fail health checks until you add a database and the `APP_KEY`** — that's expected. Continue below.

## 3. Add a database

In your project, click **New → Database**, then choose **MySQL** (matches the default config) or **PostgreSQL**.

Railway automatically injects connection variables. In your **web service → Variables**, reference them so Laravel picks them up. Click **New Variable → Add Reference** for each, or paste these (the `${{...}}` syntax pulls from the database service):

**For MySQL:**
```dotenv
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

**For PostgreSQL:**
```dotenv
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}
```

## 4. Set the application variables

Generate a key locally and copy the output:

```bash
php artisan key:generate --show
# prints something like: base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXX=
```

Then add these variables to the web service:

```dotenv
APP_NAME=Lunguda Heritage Archive
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:PASTE_WHAT_YOU_COPIED
APP_URL=https://YOUR-SERVICE.up.railway.app
FORCE_HTTPS=true

APP_TIMEZONE=Africa/Lagos

SESSION_DRIVER=database
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true

CACHE_STORE=database
QUEUE_CONNECTION=database

FILESYSTEM_DISK=public

# First admin account (the seeder reads these)
ADMIN_EMAIL=you@example.com
ADMIN_PASSWORD=a-long-random-password
```

> Set `APP_URL` to your real Railway URL once it's assigned (Settings → Networking → Generate Domain), then redeploy so generated links and asset URLs are correct.

The Docker image runs `migrate --force`, `storage:link` and config/route/view caching automatically on boot (via the `AUTORUN_*` variables in the `Dockerfile`). To also seed the first admin + sample content on the very first deploy, run a one-off command from the Railway shell:

```bash
php artisan db:seed --force
```

(Open the service → the **⋮** menu → **Shell**, or use the Railway CLI: `railway run php artisan db:seed --force`.)

## 5. Make uploaded audio & images survive deploys — IMPORTANT

Railway containers have an **ephemeral filesystem**: anything written at runtime (uploaded recordings and photos live in `storage/app/public`) is **wiped on the next deploy** unless you persist it. Choose **one** option.

### Option A — Railway Volume (simplest)

1. In the web service, go to **Settings → Volumes → New Volume**.
2. Set the **mount path** to:
   ```
   /var/www/html/storage/app/public
   ```
3. Redeploy. Uploads now persist across deploys and restarts.

> The volume holds your media. Keep the `storage:link` (it's automatic) so the files are served at `/storage/...`.

### Option B — Object storage (Cloudflare R2 or AWS S3)

More durable and lets you serve media from a CDN. R2 has a generous free tier and no egress fees.

1. Create an R2 bucket (Cloudflare) or S3 bucket (AWS) and an access key/secret.
2. Set these variables and switch the disk:
   ```dotenv
   FILESYSTEM_DISK=s3
   AWS_ACCESS_KEY_ID=your_key
   AWS_SECRET_ACCESS_KEY=your_secret
   AWS_DEFAULT_REGION=auto
   AWS_BUCKET=lunguda-media
   AWS_ENDPOINT=https://<accountid>.r2.cloudflarestorage.com
   AWS_USE_PATH_STYLE_ENDPOINT=true
   AWS_URL=https://your-public-r2-domain
   ```
3. Redeploy. New uploads go to the bucket; `AWS_URL` should point at the bucket's public URL so files display.

## 6. Confirm it's live

- Visit your `*.up.railway.app` URL — the homepage should load with the seeded sample content.
- Sign in at `/login` with `ADMIN_EMAIL` / `ADMIN_PASSWORD`.
- Add a word with an audio file in **Admin → Words**, then check it appears (and plays) in the public dictionary.
- The health check path is `/up` (already configured in `railway.json`).

## 7. Connect your domain (after you buy one)

1. Buy a domain from any registrar (Namecheap, Cloudflare, Google Domains, etc.).
2. In Railway: web service → **Settings → Networking → Custom Domain**, enter e.g. `lunguda.org`.
3. Railway shows a **CNAME** target. At your registrar's DNS, add:
   - `CNAME  www  →  <the value Railway gives you>`
   - For the root/apex (`lunguda.org`), use your registrar's ALIAS/ANAME/flattened-CNAME feature, or Cloudflare (which supports CNAME flattening at the root).
4. Wait for DNS to propagate (minutes to a few hours). Railway issues an HTTPS certificate automatically.
5. Update `APP_URL=https://lunguda.org` and redeploy.

## Updating the site later

Push to your `main` branch and Railway rebuilds and redeploys automatically. Migrations run on each deploy, so new tables/columns are applied without manual steps.

## Troubleshooting

| Symptom | Fix |
|---------|-----|
| Health check fails / 500 on boot | Usually a missing `APP_KEY` or database variables. Check the deploy logs. |
| Uploads disappear after a deploy | You skipped step 5 — add a Volume or S3/R2. |
| `Mixed content` / assets blocked | Ensure `FORCE_HTTPS=true` and `APP_URL` uses `https://`. |
| Login returns 419 | Confirm `APP_KEY` is set and `SESSION_SECURE_COOKIE=true` on HTTPS. |
| Build fails on the `serversideup/php` tag | Pin a different tag (e.g. `serversideup/php:8.3-fpm-nginx-alpine`) in the `Dockerfile`, or delete the `Dockerfile` to use the Nixpacks builder (`nixpacks.toml`). |
