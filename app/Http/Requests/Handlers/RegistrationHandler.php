<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewUserParameters;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class RegistrationHandler extends RequestHandler
{

    /**
     * @return NewUserParameters
     */
    public function handleRequest(): NewUserParameters
    {
        $parameters = new NewUserParameters();
        $parameters->email = $this->request->get('email');
        $parameters->type = $this->request->get('type');
        $parameters->password = $this->request->get('password');
        $parameters->hashedPassword = Hash::make($this->request->get('password'));

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
