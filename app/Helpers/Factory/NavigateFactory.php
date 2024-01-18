<?php

namespace App\Helpers\Factory;

use App\Helpers\FinalClass\Navigate\Breadcrumb;

/** Facade */
final class NavigateFactory
{
    public function breadcrumb():Breadcrumb
    {
        return new Breadcrumb();
    }
}
