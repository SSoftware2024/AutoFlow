<?php

namespace App\Helpers\FinalClass\Messages;

use App\Enum\ToastType;
use App\Helpers\Asbstract\Messages;
use App\Helpers\Interface\ToastType as InterfaceToastType;

final class Toast extends Messages implements InterfaceToastType
{
    private string $message = '';
    private string $title = '';
    private string $type = 'success';

    private function create(string $title, string $message, ToastType $type): self
    {
        $this->type = $type->value;
        $this->message = $message;
        $this->title = $title;
        $this->queque[] = [
            'type' => $this->type,
            'message' => $this->message,
            'title' => $this->title,
        ];
        return $this;
    }

    public function info(string $message, string $title = 'Informação'): self
    {
        return $this->create($title, $message, ToastType::INFO);
    }
    public function success(string $message, string $title = 'Sucesso'): self
    {
        return $this->create($title, $message, ToastType::SUCCESS);
    }
    public function warning(string $message, string $title = 'Atenção'): self
    {
        return $this->create($title, $message, ToastType::WARNING);
    }
    public function error(string $message, string $title = 'Erro'): self
    {
        return $this->create($title, $message, ToastType::ERROR);
    }
}
