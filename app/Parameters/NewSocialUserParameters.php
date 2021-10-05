<?php

namespace App\Parameters;

use App\Models\User;
use Illuminate\Validation\Rule;

/**
 *
 */
class NewSocialUserParameters extends Parameters
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
     * @var string|null
     */
    public ?string $firstName = null;

    /**
     * @var string|null
     */
    public ?string $lastName = null;

    /**
     * @var bool
     */
    public bool $pricingConsent;

    /**
     * @var bool
     */
    public bool $serviceRulesConsent;

    /**
     * @var bool
     */
    public bool $privacyPolicyConsent;

    /**
     * @var string|null
     */
    public ?string $provider;

    /**
     * @var string|null
     */
    public ?string $googleId = null;

    /**
     * @var string|null
     */
    public ?string $facebookId = null;

    /**
     * @var string|null
     */
    public ?string $avatar = null;

    /**
     * @var string
     */
    public string $emailVerifiedAt;

    /**
     *
     */
    public function __construct()
    {
        $this->validationRules = [
            'pricingConsent' => 'required|integer|in:1',
            'serviceRulesConsent' => 'required|integer|in:1',
            'privacyPolicyConsent' => 'required|integer|in:1',
            'googleId' => 'required_if:provider,google',
            'facebookId' => 'required_if:provider,facebook',
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
        ];

        $this->validationMessages = [
            'type.in' => __('messages.validation.registration.wrong_account_type'),
        ];
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return parent::validate((array)$this);
    }


}
