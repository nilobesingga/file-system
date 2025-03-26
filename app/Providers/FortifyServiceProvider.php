<?php
namespace App\Providers;

use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\ServiceProvider;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRoutes();

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email'); // Your view
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Override login response
        $this->app->singleton(LoginResponseContract::class, function () {
            return new class implements LoginResponseContract {
                public function toResponse($request)
                {
                    $user = Auth::user();
                    if ($user && $user->two_factor_secret && !session('two_factor_verified')) {
                        return redirect()->route('two-factor.challenge');
                    }
                    if ($user->is_admin) {
                        return redirect()->route('admin.dashboard');
                    }
                    return redirect()->route('dashboard');
                }
            };
        });

        // Rate limiter for 2FA
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()->id ?? $request->ip());
        });
    }

    protected function configureRoutes()
    {
        Route::group([
            'as' => 'verification.',
        ], function () {
            Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware(['auth'])
                ->name('notice'); // Fortify’s notice becomes verification.notice

            Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed'])
                ->name('verify'); // Fortify’s verify becomes verification.verify
        });
    }
}
