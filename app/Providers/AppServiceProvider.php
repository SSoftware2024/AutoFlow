<?php

namespace App\Providers;

use App\Facade\RequestMacro;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Request::macro('guardName', function () {
            $guards = config('auth.guards');
            unset($guards['sanctum']);
            foreach ($guards as $guardName => $guardConfig) {
                $user = Auth::guard($guardName)->user();
                if (!empty($user)) {
                    return $guardName;
                }
            }
        });
        Request::macro('isAdmin', function () {
            return str_starts_with(request()->path(), 'admin');
        });
        Request::macro('isOperatorCashier', function () {
            return str_starts_with(request()->path(), 'operatorCashier');
        });
        Request::macro('isClient', function () {
            return str_starts_with(request()->path(), 'client');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
