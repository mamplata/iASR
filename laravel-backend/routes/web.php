<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\NFCCardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ADMIN ROUTES
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ANNNOUNCEMENTS
Route::get('/announcements', [AnnouncementController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('announcements');
Route::get('/announcements/create', [AnnouncementController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('announcements.create');
Route::post('/announcements/store', [AnnouncementController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('announcements.store');
Route::get('announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])
    ->name('announcements.edit');
Route::put('announcements/{announcement}', [AnnouncementController::class, 'update'])
    ->name('announcements.update');
Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])
    ->middleware(['auth', 'verified'])->name('announcements.destroy');

Route::get('/audit-logs', [AuditLogController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('audit-logs');
Route::get('/device', function () {
    return Inertia::render('Device/Index');
})->middleware(['auth', 'verified'])->name('device');
Route::get('/entry-logs', function () {
    return Inertia::render('Entry_Logs/Index');
})->middleware(['auth', 'verified'])->name('entry-logs');

// ADMIN ACCOUNTS
Route::get('/admin-accounts', [RegisteredUserController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('admin-accounts');
Route::put('/admin-accounts/{user}/toggle', [RegisteredUserController::class, 'toggle'])
    ->middleware(['auth', 'verified'])->name('admin-accounts.toggle');

//NFC Card
Route::get('/nfc-cards', function () {
    return Inertia::render('NFC_Card/Index');
})->middleware(['auth', 'verified'])->name('nfc-cards');
Route::post('/nfc-cards/store', [NFCCardController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('nfc-cards.store');

Route::get('/unauthorized-logs', function () {
    return Inertia::render('Unauthorized_Logs/Index');
})->middleware(['auth', 'verified'])->name('unauthorized-logs');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
