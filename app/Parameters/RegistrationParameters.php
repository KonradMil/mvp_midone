<?php

namespace App\Parameters;

use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

/**
 *
 */
class RegistrationParameters extends NewUserParameters
{

    /**
     * @var string
     */
    public string $recaptchaToken = "";

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

//        $this->validationRules['recaptchaToken'] = [new GoogleReCaptchaV3ValidationRule('register')];
//        $this->validationMessages['recaptchaToken.*'] = __('messages.recaptcha_error');

    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }

}
