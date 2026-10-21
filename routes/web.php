<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FavoriteController as AdminFavoriteController;
use App\Http\Controllers\Admin\ReadingLogController as AdminReadingLogController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/landing', [LandingController::class, 'index'])->name('landing');

Route::prefix('katalog')->name('katalog.')->group(function () {
    Route::get('/', [KatalogController::class, 'index'])->name('index');
    Route::get('/{book}', [KatalogController::class, 'show'])->name('show');
    Route::get('/{book}/baca', [KatalogController::class, 'baca'])->name('baca');
    Route::get('/{book}/api', [KatalogController::class, 'apiDetail'])->name('api');
});

// Shortcut route for reading
Route::get('/baca/{book}', [KatalogController::class, 'baca'])->name('baca.show');

/*
|--------------------------------------------------------------------------
| Admin Authentication & Entry Routes
|--------------------------------------------------------------------------
| Visiting /admin directly displays the login page if unauthenticated,
| or redirects to the admin dashboard if already logged in.
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Direct entry at /admin
    Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('entry');
    Route::post('/', [AdminAuthController::class, 'login'])->name('entry.submit');

    // Traditional /admin/login routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::get('/quick-login', [AdminAuthController::class, 'quickDemoLogin'])->name('quick_login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Protected Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // 2. Manajemen Buku (CRUD)
    Route::resource('books', AdminBookController::class);

    // 3. Manajemen User (CRUD)
    Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle_status');
    Route::resource('users', AdminUserController::class);

    // 4. Kategori Buku (CRUD)
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'show', 'edit']);

    // 5. Riwayat Baca
    Route::get('/reading-history', [AdminReadingLogController::class, 'index'])->name('reading_logs.index');
    Route::delete('/reading-history/{readingLog}', [AdminReadingLogController::class, 'destroy'])->name('reading_logs.destroy');
    Route::post('/reading-history/clear-old', [AdminReadingLogController::class, 'clearOld'])->name('reading_logs.clear_old');

    // 6. Favorit / Bookmark
    Route::get('/favorites', [AdminFavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('/favorites/{favorite}', [AdminFavoriteController::class, 'destroy'])->name('favorites.destroy');

    // 7. Laporan & Statistik
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-csv', [AdminReportController::class, 'exportCsv'])->name('reports.export_csv');
    Route::get('/reports/print', [AdminReportController::class, 'printView'])->name('reports.print');

    // 8. Pengaturan
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/profile', [AdminSettingController::class, 'updateProfile'])->name('settings.update_profile');
});
