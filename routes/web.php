<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return redirect()->route('files.index');
});

// Authentication routes
require __DIR__ . '/auth.php';

// File upload/download routes
Route::middleware('auth')->group(function () {
    Route::resource('files', FileController::class)->only(['index', 'create', 'store']);
    Route::get('files/{id}/download', [FileController::class, 'download'])->name('files.download');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
