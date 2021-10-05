<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewSocialUserParameters;
use App\Parameters\ParametersInterface;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

/**
 *
 */
class SocialAuthHandler extends RequestHandler
{

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * @throws Exception
     */
    public function getParameters(): ParametersInterface
    {
        $parameters = new NewSocialUserParameters();
        $provider = $this->request->route()->parameter('provider');

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return $parameters;
        }

        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $parameters->emailVerifiedAt = $now->format('Y-m-d H:i:s');
        $parameters->email = $socialUser->getEmail();

        $parameters->type = session('accountType');
        $parameters->privacyPolicyConsent = session('privacyPolicyConsent');
        $parameters->serviceRulesConsent = session('serviceRulesConsent');
        $parameters->pricingConsent = session('pricingConsent');
        $parameters->provider = $provider;


        if ($provider === 'google') {

            $parameters->firstName = $socialUser->user["given_name"];
            $parameters->lastName = $socialUser->user["family_name"];
            $parameters->avatar = $socialUser->user["picture"];
            $parameters->googleId = $socialUser->getId();

        }

        if ($provider === 'facebook') {

            $arrName = explode(' ', $socialUser->name);

            $parameters->firstName = $arrName[0] ?? null;
            $parameters->lastName = $arrName[1] ?? null;
            $parameters->avatar = $socialUser->avatar;
            $parameters->facebookId = $socialUser->id;

        }

        session()->remove('privacyPolicyConsent');
        session()->remove('serviceRulesConsent');
        session()->remove('pricingConsent');
        session()->remove('accountType');

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
