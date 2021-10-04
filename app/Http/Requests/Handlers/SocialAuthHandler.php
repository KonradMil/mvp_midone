<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewSocialUserParameters;
use App\Parameters\NewUserParameters;
use App\Parameters\ParametersInterface;
use App\Parameters\SocialAuthParameters;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthHandler extends RequestHandler
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * @throws \Exception
     */
    public function getParameters(): ParametersInterface
    {
        $parameters = new NewSocialUserParameters();
        $provider = $this->request->route()->parameter('provider');

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
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

        if($provider === 'google') {
            $parameters->googleId = $socialUser->getId();
        }

        if($provider === 'facebook') {
            $parameters->facebookId = $socialUser->getId();
        }

        /*session()->remove('privacyPolicyConsent');
        session()->remove('serviceRulesConsent');
        session()->remove('pricingConsent');
        session()->remove('accountType');*/

        return $parameters;
    }

    public function authorize(): bool
    {
        return true;
    }
}
