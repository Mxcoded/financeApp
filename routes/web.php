<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

// Public Route: Home Page
Route::get('/', function () {
    return view('welcome');
});

// Protected Route: Dashboard (Requires Authentication and Email Verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grouped Routes for Authenticated Users
Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');       // Show edit profile form
        Route::patch('/', [ProfileController::class, 'update'])->name('update'); // Update profile details
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy'); // Delete profile
    });

    // File Management Routes
    Route::prefix('files')->name('files.')->group(function () {
        Route::get('/', [FileController::class, 'index'])->name('index');       // List files
        Route::get('/create', [FileController::class, 'create'])->name('create'); // Show upload form
        Route::post('/', [FileController::class, 'store'])->name('store');       // Upload file
        Route::get('/{id}/download', [FileController::class, 'download'])->name('download'); // Download file
        Route::delete('/{id}', [FileController::class, 'destroy'])->name('destroy');         // Delete file
        Route::post('/mass-delete', [FileController::class, 'massDelete'])->name('massDelete'); // Mass delete files
    });
});

// Authentication Routes (e.g., Login, Register, Password Reset)
require __DIR__ . '/auth.php';
