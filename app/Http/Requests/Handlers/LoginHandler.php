<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\LoginParameters;
use App\Parameters\ParametersInterface;

class LoginHandler extends RequestHandler
{

    public function getParameters(): ParametersInterface
    {

        $parameters = new LoginParameters();
        $parameters->email = $this->request->get('email');
        $parameters->password = $this->request->get('password');
        $parameters->recaptchaToken = $this->request->get('recaptchaToken');

        return $parameters;

    }

    public function authorize(): bool
    {
        return true;
    }
}
