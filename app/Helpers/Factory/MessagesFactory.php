<?php
namespace App\Helpers\Factory;

use App\Helpers\FinalClass\Messages\Toast;

final class MessagesFactory
{
    public function toast()
    {
        return new Toast();
    }
}
