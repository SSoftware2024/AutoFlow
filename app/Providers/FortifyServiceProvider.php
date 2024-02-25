<?php

namespace App\Providers;


use App\Facade\AuthManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Facade\MessagesFactory;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\Admin\UpdateAdminPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Fortify\Admin\UpdateAdminProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        if (request()->isAdmin()) {
            config(['fortify.guard' => 'admin']);
            config(['fortify.prefix' => 'admin']);
            config(['fortify.passwords' => 'admins']);
            //jetstream
            config(['jetstream.guard' => 'admin']);
            config(['jetstream.path' => 'admin']);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->isAdmin()) {
            Fortify::updateUserProfileInformationUsing(UpdateAdminProfileInformation::class);
            Fortify::updateUserPasswordsUsing(UpdateAdminPassword::class);
        } else {
            // Fortify::createUsersUsing(CreateNewUser::class);
            Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
            Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
            // Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        }

        Fortify::authenticateUsing(function (Request $request) {
            return AuthManager::login($request);
        });



        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey)->response(function(){
                MessagesFactory::alertSwal()->warning('Limite de tentativas excedido, aguarde para tentar novamente!')->generate();
                return back();
            });
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
