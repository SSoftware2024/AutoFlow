<?php

namespace App\Enum\Database;

use ReflectionClass;

enum LevelAccessAdmin: string
{
    case FIRST = 'first';
    case SECOND = 'second';

    public static function getArrayObject():array
    {
        return (new ReflectionClass(LevelAccessAdmin::class))->getConstants();
    }
}
