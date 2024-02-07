<?php
namespace App\Helpers\FinalClass\Messages;

use App\Helpers\Asbstract\Messages;

final class Toast extends Messages
{
    public string $message = '';
    public string $title = '';
    public string $type ='success';

    private function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function create(string $title,string $message, string $type): self
    {
        $this->setType($type);
        $this->message = $message;
        $this->title = $title;
        $this->queque[] = [
            'type' => $this->type,
            'message' => $this->message,
            'title' => $this->title,
        ];
        return $this;
    }
}
