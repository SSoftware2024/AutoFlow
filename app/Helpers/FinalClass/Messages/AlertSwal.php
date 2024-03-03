<?php

namespace App\Helpers\FinalClass\Messages;

use App\Enum\AlertSwalType;
use App\Helpers\Asbstract\Messages;

/**
 * Criação de question e alertas informativos, só pode criar uma question por vez e tem q preparar o front.
 * Quando question é criada os alertas não são exebidos
 */

final class AlertSwal extends Messages //facade
{

    private function createQuestion(string $title, string $text, AlertSwalType $type)
    {
        return [
            'type' => $type->value,
            'title' => $title,
            'text' => $text,
        ];
    }
    private function createAlert(string $title, string $text, AlertSwalType $type)
    {
        return [
            'type' => $type->value,
            'title' => $title,
            'text' => $text,
        ];
    }
    public function info(string $text, string $title = 'Informação!')
    {
       $this->queque[] = $this->createAlert($title, $text, AlertSwalType::INFO);
       return $this;
    }
    public function warning(string $text, string $title = 'Atenção!')
    {
       $this->queque[] = $this->createAlert($title, $text, AlertSwalType::WARNING);
       return $this;
    }
    public function success(string $text, string $title = 'Sucesso!')
    {
       $this->queque[] = $this->createAlert($title, $text, AlertSwalType::SUCCESS);
       return $this;
    }
    public function error(string $text, string $title = 'Erro!')
    {
       $this->queque[] = $this->createAlert($title, $text, AlertSwalType::ERROR);
       return $this;
    }

    /**
     * Por ser uma deleção sim e não são trocados no front-end
     *
     * @param string $question
     * @return void
     */
    public function deleteQuestion(string $question)
    {
        $this->queque['question'] = $this->createQuestion('Exclusão', $question, AlertSwalType::DELETE_QUESTION);
        return $this;
    }
    public function generate(): void
    {
        session()->flash('alert_swal', $this->queque);
    }
}
