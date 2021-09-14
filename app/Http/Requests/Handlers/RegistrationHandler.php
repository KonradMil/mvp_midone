<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\RegistrationParameters;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class RegistrationHandler extends RequestHandler
{

    /**
     * @return RegistrationParameters
     */
    public function getParameters(): RegistrationParameters
    {
        $parameters = new RegistrationParameters();
        $parameters->email = $this->request->get('email');
        $parameters->type = $this->request->get('type');
        $parameters->password = $this->request->get('password');
        $parameters->hashedPassword = Hash::make($this->request->get('password'));
        $parameters->confirmationToken = md5(rand(1, 100) . microtime());
        $parameters->recaptchaToken = $this->request->get('recaptchaToken');

        return $parameters;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
