<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\WorkProgramController;
use App\Http\Controllers\Public\VisionMissionController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\WorkProgramController as AdminWorkProgramController;
use App\Http\Controllers\Admin\VisionMissionController as AdminVisionMissionController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\AnnouncementController;

// ─── Public Routes ───────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/program-kerja', [WorkProgramController::class, 'index'])->name('work-programs.index');
Route::get('/program-kerja/{slug}', [WorkProgramController::class, 'show'])->name('work-programs.show');

Route::get('/visi-misi', [VisionMissionController::class, 'index'])->name('vision-mission');

Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';

// Redirect route 'dashboard' to admin dashboard for Breeze compatibility
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');

// ─── Admin Routes ─────────────────────────────────────────────────────────────

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats-api', [DashboardController::class, 'apiData'])->name('stats-api');

        // Articles CRUD
        Route::resource('artikel', AdminArticleController::class)->parameters([
            'artikel' => 'article',
        ]);

        // Work Programs CRUD
        Route::resource('program-kerja', AdminWorkProgramController::class)->parameters([
            'program-kerja' => 'workProgram',
        ]);

        // Vision & Mission (singleton: only edit + update)
        Route::get('/visi-misi', [AdminVisionMissionController::class, 'edit'])->name('vision-mission.edit');
        Route::put('/visi-misi', [AdminVisionMissionController::class, 'update'])->name('vision-mission.update');

        // Contact Messages
        Route::get('/pesan', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::patch('/pesan/{id}/read', [ContactMessageController::class, 'markRead'])->name('messages.read');
        Route::delete('/pesan/{id}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        // Announcements CRUD
        Route::resource('pengumuman', AnnouncementController::class)->parameters([
            'pengumuman' => 'announcement',
        ]);

        // Site Settings
        Route::get('/pengaturan', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/pengaturan', [SiteSettingController::class, 'update'])->name('settings.update');
    });
