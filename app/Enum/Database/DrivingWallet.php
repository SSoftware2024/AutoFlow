<?php

namespace App\Enum\Database;

use App\Enum\Interface\ArrayOptions;
use ReflectionClass;

enum DrivingWallet: string implements ArrayOptions
{
    case ACC = 'ACC';
    case A = 'A';
    case B = 'B';
    case C = 'C';
    case D = 'D';
    case E = 'E';

    public static function getArrayObject(): array
    {
        return (new ReflectionClass(DrivingWallet::class))->getConstants();
    }
    public static function getArrayObjectSelect(): array
    {
        $object = self::getArrayObject();
        $array = [];
        foreach ($object as $key => $value) {
            $array[] = [
                'name' => $key,
                'code' => $value
            ];
        }
        return $array;
    }
}
