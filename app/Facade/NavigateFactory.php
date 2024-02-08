<?php
namespace App\Facade;


use Illuminate\Support\Facades\Facade;
use App\Helpers\Factory\NavigateFactory as HelperNavigateFactory;

final class NavigateFactory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HelperNavigateFactory::class;
    }
}
