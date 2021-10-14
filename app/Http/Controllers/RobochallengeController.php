<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RobochallengeController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phoneNumber' => 'required|string|min:9',
            'competitionRulesConsent' => 'required|int|min:1',
            'privacyPolicyConsent' => 'required|int|min:1',
            'dataProcessingConsent' => 'required|int|min:1',
            'password' => 'required|min:6|required_with:passwordConfirmation|same:passwordConfirmation',
            'passwordConfirmation' => 'min:6'
        ], [
            'firstName.*' => 'Podaj swoje imię',
            'lastName.*' => 'Podaj swoje nazwisko',
            'email.*' => 'Podany adres e-mail jest nieprawidłowy',
            'phoneNumber.*' => 'Nieprawidłowy numer telefonu',
            'competitionRulesConsent.*' => 'Musisz zaakceptować regulamin konkursu.',
            'privacyPolicyConsent.*' => 'Musisz zaakceptować politykę prywatności.',
            'dataProcessingConsent.*' => 'Musisz wyrazić zgodę na przetwarzanie Twoich danych w ramach konkursu.',
            'password.required' => 'Podaj swoje hasło',
            'password.min' => 'Hasło musi zawierać przynajmniej 6 znaków',
            'password.same' => 'Oba hasła muszą być takie same',
        ]);

        $response = [
            'errors' => [],
            'success' => '',
        ];

        if ($validator->fails()) {

            foreach($validator->getMessageBag()->getMessages() as $msg) {

                foreach($msg as $m) {
                    $response['errors'][] = $m;
                }

            }

            return response()->json($response, Response::HTTP_BAD_REQUEST);

        }

        $userParameters = [
            'name' => $request->get('firstName'),
            'lastname' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone_number' => $request->get('phoneNumber'),
            'password' => Hash::make($request->get('password')),
            'type' => 'robochallenge'
        ];

        $companyParameters = [
            'company_name' => $request->get('companyName')
        ];

        $existingUser = User::where('email', '=', $userParameters['email'])->first();

        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        if($existingUser) {

            $existingUser->phone_number = $userParameters['phone_number'];
            $existingUser->type = 'robochallenge';
            $existingUser->updated_at = $now->format('Y-m-d H:i:s');
            $existingUser->password = $userParameters['password'];
            $existingUser->save();

        } else {

            $user = User::create($userParameters);
            $companyParameters['author_id'] = $user->id;
            /** @var Company $company */
            $company = Company::create($companyParameters);
            $company->users()->attach($user);

        }

        $response['success'] = "Twoje zgłoszenie zostało wysłane pomyślnie.";

        return response()->json($response);


    }
}
