<?php

namespace App\Parameters;

use App\Models\User;
use App\Parameters\Parameters;
use Illuminate\Validation\Rule;

/**
 *
 */
class NewUserParameters extends Parameters
{

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string
     */
    public string $hashedPassword;

    /**
     * @var string
     */
    public string $confirmationToken;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:' . User::class . ',email',
            ],
            'type' => [
                'required',
                Rule::in([
                    User::USER_TYPE_ADMIN,
                    User::USER_TYPE_INVESTOR,
                    User::USER_TYPE_INTEGRATOR,
                ])
            ],
            'password' => 'required|min:6'
        ];

        $this->validationMessages = [
            'email.unique' => 'Podany adres e-mail jest już zajęty.',
            'type.in' => 'Wybrany typ konta jest nieprawidłowy.'
        ];

        $this->validationSubject = (array)$this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }
}
