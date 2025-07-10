<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\VillageProfileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rute untuk publik
Route::get('/profil-desa', [VillageProfileController::class, 'show'])->name('profile.show');

Route::get('/artikel', [ArticleController::class, 'publicIndex'])->name('articles.public.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'publicShow'])->name('articles.public.show');

// Grup rute untuk admin, dilindungi oleh middleware Jetstream
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Rute lain untuk dashboard, dll.
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Rute untuk mengedit profil desa
    Route::get('/admin/profil-desa', [VillageProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profil-desa', [VillageProfileController::class, 'update'])->name('admin.profile.update');
    Route::resource('articles', ArticleController::class);
});