<?php

namespace App\Http\Controllers;

use App\Mail\RoboHakatonMail;
use App\Mail\RoboHakatonReportMail;
use App\Models\Challenge;
use App\Models\Company;
use App\Models\FreeSave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        $user = User::where('email', '=', $userParameters['email'])->first();

        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        if($user) {

            $user->phone_number = $userParameters['phone_number'];
            $user->type = 'robochallenge';
            $user->updated_at = $now->format('Y-m-d H:i:s');
            $user->password = $userParameters['password'];
            $user->phone_number = $userParameters['phone_number'];
            $user->save();

        } else {

            $user = User::create($userParameters);
            $companyParameters['author_id'] = $user->id;
            /** @var Company $company */
            $company = Company::create($companyParameters);
            $company->users()->attach($user);

        }

        Mail::to($userParameters['email'])->send(new RoboHakatonMail());
        $users = User::where('type', '=', 'robochallenge')->get();
        Mail::to('malgorzata.samborska@dbr77.com')->send(new RoboHakatonReportMail($user, $users));

        $response['success'] = "Twoje zgłoszenie zostało wysłane pomyślnie.";

        return response()->json($response);

    }

    //FUNCTIONS BELOW TO BE BURNED TO THE GROUND LATER

    public function goToRoboChallengeSave(Request $request)
    {
        $check = Auth::user()->ownFreeSaves()->where('robochallenge_task', '=', $request->task_id)->first();

        if($check == NULL) {
            $fs = new FreeSave();
            $fs->robochallenge_task = $request->task_id;

            if ($request->task_id == 1) {
                $ch = Challenge::find(128);
            } else if($request->task_id == 2) {
                $ch = Challenge::find(130);
            } else if($request->task_id == 3) {
                $ch = Challenge::find(131);
            }

            $fs->save_json = $ch->save_json;
            $fs->name = 'Robochallenge Zadanie '. $request->task_id;
            $fs->save();

            $fs->users()->attach(Auth::user()->id, ['is_owner' => 1]);
        }

        return \response()->json($fs->id);
    }
}
