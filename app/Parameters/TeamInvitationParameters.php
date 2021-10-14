<?php

namespace App\Parameters;


class TeamInvitationParameters extends Parameters
{

    public string $email;

    public int $teamId;


    public function __construct()
    {
        $this->validationRules = [
            'email' => 'required|email',
            'teamId' => 'exists:teams,id'
        ];
    }

    public function isValid(): bool
    {
        return $this->validate((array)$this);
    }
}
