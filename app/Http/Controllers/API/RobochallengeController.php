<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class RobochallengeController extends Controller
{
    public function register(Request $request)
    {
        $userParameters = [
            'name' => $request->get('firstName'),
            'lastname' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
        ];

        $companyParameters = [
            'name' => $request->get('companyName')
        ];

        $consents = [
            'competition_rules_consent' => $request->get('competitionRulesConsent'),
            'privacy_policy_consent' => $request->get('privacyPolicyConsent'),
            'data_processing_consent' => $request->get('dataProcessingConsent')
        ];

        $response = [

        ];


    }
}
