<?php
namespace App\Enum;
enum AlertSwalType: string
{
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
    case SUCCESS = 'success';
    case DELETE_QUESTION = 'delete_question';
}
