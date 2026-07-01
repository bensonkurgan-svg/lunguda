# Extending the admin

The public site renders **every** content type (words, names, phrases, oral traditions, rulers, lineage, culture, monuments, gallery). The admin area ships with full CRUD for the core and newest types:

- **Words** — `app/Livewire/Admin/WordManager.php` (the reference implementation, includes audio upload)
- **Rulers** — `RulerManager.php` (portrait upload)
- **Culture & attire** — `CulturalItemManager.php` (image upload)
- **Moderation** — `Moderation.php` (approve/reject community submissions)
- **Dashboard** — `Dashboard.php`

The remaining managers — **Phrases, Names, Oral Traditions, Monuments, Clans, People, Gallery, Users** — follow the **identical pattern**. Until you build a screen for them, you can manage them with `php artisan tinker` or a DB tool; the models and migrations already exist.

## The pattern (copy WordManager)

1. **Create the component** in `app/Livewire/Admin/XManager.php`:
   - `use WithFileUploads, WithPagination;` (drop `WithFileUploads` if there's no upload).
   - Public properties for each form field.
   - A `rules()` method (validate uploads with `mimes`/`image` + `max`).
   - `create()`, `edit($id)`, `save()`, `delete($id)`, `cancel()`, `resetForm()`.
   - In `save()`, store files with `->store('folder', 'public')` and delete the old file on replace.
   - `#[Layout('components.layouts.admin')]` and `#[Title('X')]`.

2. **Create the view** in `resources/views/livewire/admin/x-manager.blade.php` — copy `word-manager.blade.php` and swap the fields.

3. **Register the route** in `routes/web.php` inside the `admin` group:
   ```php
   Route::get('/phrases', PhraseManager::class)->name('phrases');
   ```

4. **Add it to the sidebar** in `resources/views/components/layouts/admin.blade.php` (the `$items` array).

That's the whole loop. Because each model already has `$fillable`, a `status` field and (where relevant) `scopePublished()`, the new manager will behave consistently with the rest.

## Roles

To make a user an admin, set their `role` column to `admin` (or `superadmin`). A Users manager is a good next screen to build — restrict it to `superadmin` with `->middleware('role:superadmin')`.

## Exporting for a permanent archive

Funders (e.g. ELDP/ELAR) require deposit to a permanent archive. A simple export command that dumps words + audio paths + metadata to CSV/JSON is a high-value addition — add it as an Artisan command in `routes/console.php` or `app/Console/Commands`.
