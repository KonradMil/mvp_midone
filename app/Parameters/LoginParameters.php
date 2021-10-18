<?php

namespace App\Parameters;

use App\Models\User;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class LoginParameters extends Parameters
{

    public string $email;

    public string $password;

    public ?string $recaptchaToken;

    public function __construct(){

        $this->validationRules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        if(env('APP_ENV' !== 'local')) {
            $this->validationRules['recaptchaToken'] = ['required', new GoogleReCaptchaV3ValidationRule('login')];
        }

        $this->validationMessages['recaptchaToken.*'] = __('messages.recaptcha_error');

    }

    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
