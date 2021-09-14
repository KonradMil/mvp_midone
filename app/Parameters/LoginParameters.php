<?php

namespace App\Parameters;

class LoginParameters extends Parameters
{

    public string $email;

    public string $password;

    public string $recaptchaToken;

    public function isValid(): bool
    {
        return parent::validate(array($this));
    }
}
