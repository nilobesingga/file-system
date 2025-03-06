<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

// Redirect authenticated users to dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            if (Auth::check() && Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }
        return redirect()->route('dashboard');
    });
});

// Show login page for unauthenticated users only
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }
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
        Route::get('/upload', [AdminController::class, 'showUpload'])->name('admin.upload.show');

        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
        Route::post('/categories/assign', [AdminController::class, 'assignUserToCategory'])->name('categories.assign');
        Route::post('/categories/remove', [AdminController::class, 'removeUserFromCategory'])->name('categories.remove');
        Route::get('/categories', [AdminController::class, 'manageCategories'])->name('admin.categories');

        Route::get('/register', [AdminController::class, 'showRegisterForm'])->name('admin.register');
        Route::post('/register', [AdminController::class, 'register'])->name('admin.register.store');

        Route::get('/register/edit/{id?}', [RegisteredUserController::class, 'edit'])->name('admin.register.edit');
        Route::post('/register/update/{id}', [RegisteredUserController::class, 'update'])->name('admin.register.update');

        Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });
    Route::get('/files/download/{file}', [AdminController::class, 'downloadFile'])->name('file.download');
    Route::post('/user/upload', [DashboardController::class, 'upload'])->name('user.upload');

});

require __DIR__.'/auth.php';
