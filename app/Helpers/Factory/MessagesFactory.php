<?php
namespace App\Helpers\Factory;

use App\Helpers\FinalClass\Messages\Toast;
use App\Helpers\FinalClass\Messages\AlertSwal;

final class MessagesFactory
{
    public function toast()
    {
        return new Toast();
    }
    public function alertSwal()
    {
        return new AlertSwal();
    }
}
