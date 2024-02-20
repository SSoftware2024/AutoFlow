<?php
namespace App\Helpers\FinalClass\Messages;

use App\Enum\AlertSwalType;
use App\Helpers\Asbstract\Messages;

final class AlertSwal extends Messages
{
    private string $title = '';
    private string $question = '';
    private string $type = 'success';

    private function createQuestion(string $title, string $question, AlertSwalType $type){
        $this->type = $type->value;
        $this->title = $title;
        $this->question = $question;
    }

    public function deleteQuestion(string $title = 'Exclusão', string $question){
        $this->createQuestion($title, $question, AlertSwalType::DELETE_QUESTION);
        return $this;
    }
    public function generate() :void
    {
        session()->flash('alert_swal', [
            'type' => $this->type,
            'title' => $this->title,
            'data' => $this->question,
        ]);
    }
}
