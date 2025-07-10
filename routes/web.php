<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\VillageProfileController;
use App\Http\Controllers\ImageUploadController;
use App\Models\Article;
use App\Models\Letter;
use App\Models\Resident;
use App\Models\User;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rute untuk publik

// Grup rute untuk admin, dilindungi oleh middleware Jetstream
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Rute lain untuk dashboard, dll.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Rute untuk mengedit profil desa
// Admin Articles Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('articles', ArticleController::class); // CRUD untuk Articles
        // Untuk profil desa, mungkin hanya ada satu entri yang diedit
        Route::get('profile-desa', [VillageProfileController::class, 'edit'])->name('profile-desa.edit');
        Route::put('profile-desa', [VillageProfileController::class, 'update'])->name('profile-desa.update');
    });

    // Contoh route untuk menampilkan artikel (public)
    Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
    // Contoh route untuk menampilkan profil desa (public)
    Route::get('/profile-desa', [VillageProfileController::class, 'show'])->name('profile-desa.show');
    Route::post('/images/upload', [ImageUploadController::class, 'upload'])->name('api.images.upload');
    Route::post('/images/fetch', [ImageUploadController::class, 'fetch'])->name('api.images.fetch');

});