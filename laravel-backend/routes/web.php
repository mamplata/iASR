<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ADMIN ROUTES
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/announcement', function () {
    return Inertia::render('Announcement/Index');
})->middleware(['auth', 'verified'])->name('announcement');
Route::get('/audit-logs', function () {
    return Inertia::render('Audit_Logs/Index');
})->middleware(['auth', 'verified'])->name('audit-logs');
Route::get('/device', function () {
    return Inertia::render('Device/Index');
})->middleware(['auth', 'verified'])->name('device');
Route::get('/entry-logs', function () {
    return Inertia::render('Entry_Logs/Index');
})->middleware(['auth', 'verified'])->name('entry-logs');
Route::get('/rfid-card', function () {
    return Inertia::render('RFID_Card/Index');
})->middleware(['auth', 'verified'])->name('rfid-card');
Route::get('/unauthorized-logs', function () {
    return Inertia::render('Unauthorized_Logs/Index');
})->middleware(['auth', 'verified'])->name('unauthorized-logs');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
