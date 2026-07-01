# Lunguda Heritage Archive

A community-owned platform for documenting and revitalising the **Lunguda (Nʋngʋra)** language and culture of Jessu, Balanga LGA, Gombe State, Nigeria.

Built with **Laravel 12 · Livewire 3 · Alpine.js · Tailwind CSS**, designed to deploy on **Railway**, and structured so the underlying record can be exported and deposited into permanent language archives.

---

## What it does

| Area | Description |
|------|-------------|
| **Dictionary** | Words, names and phrases — each with a spoken recording and a dialect tag (Cerin, Deele, Guyuk, Gwaanda, Kɔla). Live search and filtering. |
| **Oral traditions** | Folktales, proverbs, songs and histories with audio/video, Lunguda transcript and English translation. |
| **Rulers & history** | A timeline of the chieftaincy of Jessu — reigns, accomplishments and the vision each ruler carried. |
| **Lineage** | Clans and family trees traced through the **mother's line**, reflecting Lunguda matrilineal kinship. |
| **Culture & attire** | Cloth, regalia, craft, instruments and food, each with its significance and maker. |
| **Sites & monuments** | Sacred sites and landmarks mapped on an interactive (lazy-loaded) map. |
| **Gallery** | Community photographs. |
| **Contribute & moderate** | Speakers can submit entries; administrators review them before they go live. |

## Why these technology choices

- **Livewire 3 + `wire:navigate`** gives SPA-smooth page transitions with no separate JavaScript build to maintain — the whole app is one deployable Laravel codebase, which is far simpler to host and hand over to a community team.
- **Lazy loading** throughout: Livewire `#[Lazy]` components (the gallery), native `loading="lazy"` images, scroll-reveal via IntersectionObserver, and a map that only loads Leaflet when you scroll to it.
- **Security hardening** is built in (hashed passwords, role middleware, a Content-Security-Policy, login rate-limiting, validated file uploads). See [`docs/SECURITY.md`](docs/SECURITY.md).

## Documentation

- **[docs/INSTALL.md](docs/INSTALL.md)** — run it locally.
- **[docs/DEPLOY_RAILWAY.md](docs/DEPLOY_RAILWAY.md)** — deploy to Railway, attach a database, persist media, and connect your domain.
- **[docs/FUNDING.md](docs/FUNDING.md)** — grants, community elders, diaspora and NGOs, with how to approach each.
- **[docs/SECURITY.md](docs/SECURITY.md)** — the security measures and your responsibilities.
- **[docs/EXTENDING.md](docs/EXTENDING.md)** — how to add the remaining admin managers.

## Quick start

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build        # or: npm run dev
php artisan serve
```

The seeder creates a superadmin. **Set `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env` before seeding**, or change the password immediately after first login. Default (change it!): `admin@lunguda.org` / `change-me-now`.

## License

MIT for the application code. **Heritage content — words, recordings, stories, images — belongs to the Lunguda community**, not to whoever hosts the software.
