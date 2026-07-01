<?php

use App\Livewire\Admin\CulturalItemManager;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Moderation;
use App\Livewire\Admin\RulerManager;
use App\Livewire\Admin\WordManager;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Public\About;
use App\Livewire\Public\Culture;
use App\Livewire\Public\Dictionary;
use App\Livewire\Public\FamilyTrees;
use App\Livewire\Public\Gallery;
use App\Livewire\Public\Home;
use App\Livewire\Public\Monuments;
use App\Livewire\Public\OralTraditions;
use App\Livewire\Public\Rulers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', Home::class)->name('home');
Route::get('/dictionary', Dictionary::class)->name('dictionary');
Route::get('/oral-traditions', OralTraditions::class)->name('oral-traditions');
Route::get('/rulers', Rulers::class)->name('rulers');
Route::get('/lineage', FamilyTrees::class)->name('family-trees');
Route::get('/culture', Culture::class)->name('culture');
Route::get('/sites', Monuments::class)->name('monuments');
Route::get('/gallery', Gallery::class)->name('gallery');
Route::get('/about', About::class)->name('about');

/*
|--------------------------------------------------------------------------
| Guest (auth) routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Admin routes (require an admin or superadmin account)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/words', WordManager::class)->name('words');
        Route::get('/rulers', RulerManager::class)->name('rulers');
        Route::get('/culture', CulturalItemManager::class)->name('culture');
        Route::get('/moderation', Moderation::class)->name('moderation');
    });
