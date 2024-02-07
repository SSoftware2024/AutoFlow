<?php
namespace App\Facade;


use Illuminate\Support\Facades\Facade;
use App\Helpers\Factory\MessagesFactory as HelperMessagesFactory;

final class MessagesFactory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HelperMessagesFactory::class;
    }
}
