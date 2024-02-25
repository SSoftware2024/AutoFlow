<?php
namespace App\Facade;


use Illuminate\Support\Facades\Facade;
use App\Helpers\FinalClass\AuthManager as HelperAuthManager;

final class AuthManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HelperAuthManager::class;
    }
}
