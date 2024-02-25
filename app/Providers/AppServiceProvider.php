<?php

namespace App\Providers;

use Closure;
use App\Rules\BiggerThen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\InvokableValidationRule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (app()->environment('production')) {
            Model::shouldBeStrict();
        }

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
        $this->rules();
    }


    private function rules()
    {
        Validator::extend('bigger_then', function ($attribute, $value, $parameters, $validator) {
            $parameters[0] = $parameters[0] ?? 0;
            return $value > $parameters[0];
        }, 'O campo :attribute deve ter o valor maior que :ct_minimum.');

        Validator::replacer('bigger_then', function ($message, $attribute, $rule, $parameters) {
            $message = str_replace(':attribute', $attribute, $message);
            $message = str_replace(':ct_minimum', $parameters[0] ?? 0, $message);
            return $message;
        });
    }
}
