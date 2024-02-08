<?php
namespace App\Enum;
enum ToastType: string
{
    case INFO = 'info';
    case SUCCESS = 'success';
    case WARNING = 'warn';
    case ERROR = 'error';
}
