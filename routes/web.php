<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestementController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Redirect authenticated users to dashboard or 2FA if enabled
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->two_factor_secret && ! session('two_factor_verified')) {
            return redirect()->route('two-factor.challenge');
        }
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return view('auth/login');
})->name('home');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
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

        //Investmets
        Route::get('/investments', [InvestementController::class, 'index'])->name('admin.investments');
        Route::post('/investments', [InvestementController::class, 'upload'])->name('admin.investments.upload');
        Route::get('investments/template/download', function () {
            $path = storage_path('app/public/' . 'templates/investment-templates.xlsx');
            if (file_exists($path)) {
                return response()->download($path, 'investment-templates', [
                    'Content-Type' => Storage::mimeType($path),
                ]);
            }
            abort(404, 'File not found');
        })->name('admin.investments.template.download');
        Route::post('admin/investments/confirm-overwrite', [InvestementController::class, 'confirmOverwrite'])->name('admin.investments.confirm-overwrite');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/two-factor-challenge', [TwoFactorController::class, 'show'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
    Route::post('/user/two-factor-authentication', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::put('/user/two-factor-authentication', [TwoFactorController::class, 'confirm'])->name('2fa.confirm');
    Route::put('/user/disable', [TwoFactorController::class, 'disable2FA'])->name('2fa.disable');
    Route::post('/user/upload', [DashboardController::class, 'upload'])->name('user.upload');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/files/download/{file}', [AdminController::class, 'downloadFile'])->name('file.download');
});

// User routes
Route::middleware(['auth','2fa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/files/{file}/toggle-read', [DashboardController::class, 'toggleRead'])->name('file.toggle-read');
});

require __DIR__.'/auth.php';
