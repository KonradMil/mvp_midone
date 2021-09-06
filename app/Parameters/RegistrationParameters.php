<?php

namespace App\Parameters;

use Illuminate\Support\Facades\Validator;

class RegistrationParameters extends NewUserParameters
{

    public string $gRecaptchaResponse = "";

    public function __construct()
    {
        parent::__construct();

        $this->validationRules['gRecaptchaResponse'] = 'required|recaptcha:registration';
        $this->validationMessages['gRecaptchaResponse.required'] = 'Udowodnij, że nie jesteś robotem';
        $this->validationMessages['gRecaptchaResponse.recaptcha'] = 'Captcha error! Skontaktuj się z administratorem.';

    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $validator = Validator::make((array)$this, $this->validationRules, $this->validationMessages);
        $this->messageBag = $validator->errors();
        return !$validator->fails();
    }

}
