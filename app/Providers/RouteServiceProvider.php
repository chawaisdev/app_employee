<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard'; // default

    public function boot()
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    public static function redirectTo()
    {
        $user = Auth::user();

        if ($user) {
            // Agar admin hai (users table)
            if ($user->role === 'admin') {
                return '/admin/dashboard';
            }

            // Agar employee hai
            if ($user->role === 'employee') {
                return '/employee/dashboard';
            }
        }

        return self::HOME; // fallback
    }
}
