<?php
namespace App\Facade;

use Illuminate\Support\Facades\Facade;
use App\Helpers\FinalClass\MoneyConvert as MoneyConvertHelper;


final class MoneyConvert extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MoneyConvertHelper::class;
    }
}
