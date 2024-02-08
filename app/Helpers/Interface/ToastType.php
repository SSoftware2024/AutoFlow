<?php

namespace App\Helpers\Interface;

interface ToastType
{
    public function info(string $message, string $title): self;
    public function success(string $message, string $title): self;
    public function warning(string $message, string $title): self;
    public function error(string $message, string $title): self;
}
