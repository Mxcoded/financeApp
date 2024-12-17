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
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');       // Show edit profile form
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update profile details
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile

    // File Management Routes
    Route::middleware('auth')->group(function () {
        Route::resource('files', FileController::class)->only(['index', 'create', 'store']); // Added 'create'
        Route::get('files/{id}/download', [FileController::class, 'download'])->name('files.download');
        Route::delete('files/{id}', [FileController::class, 'destroy'])->name('files.destroy'); // Added destroy route for file deletion
        Route::post('files/mass-delete', [FileController::class, 'massDelete'])->name('files.massDelete'); // Mass delete route
    });
});

// Authentication Routes (e.g., Login, Register, Password Reset)
require __DIR__ . '/auth.php';
