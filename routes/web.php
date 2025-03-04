<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

// Redirect authenticated users to dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
});

// Show login page for unauthenticated users only
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth/login');
    })->name('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/upload', [AdminController::class, 'upload'])->name('admin.upload');
        Route::delete('/files/{id}', [AdminController::class, 'destroy'])->name('file.destroy');
    });

    Route::post('/user/upload', [DashboardController::class, 'upload'])->name('user.upload');

});

require __DIR__.'/auth.php';
