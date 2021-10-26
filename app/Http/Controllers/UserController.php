<?php

namespace App\Http\Controllers;

use App\Mail\ChangePassword;
use App\Mail\ForgotPassword;
use App\Models\Challenge;
use App\Models\Solution;
use Authy\AuthyApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Octane\Exceptions\DdException;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

/**
 *
 */
class UserController extends Controller
{
    /**
     * @param $model
     * @return array
     */
    public static function userPermissions($model): array
    {
        $publishChallenges = [];
        $editChallenges = [];
        $acceptChallengeSolutions = [];
        $acceptChallengeOffers = [];
        $publishSolution = [];
        $addSolutionOffer = [];
        $canEditSolution = [];
        $canDeleteSolution = [];
        $showSolutions = [];

        $challenges = Challenge::where('author_id', '=', $model->id)->get();
        if ($challenges != NULL) {
            foreach ($challenges as $challenge) {
                $publishChallenges[] = $challenge->id;
                $editChallenges[] = $challenge->id;
                $acceptChallengeOffers[] = $challenge->id;
                $acceptChallengeSolutions[] = $challenge->id;
            }
        }

        $solutions = Solution::where('author_id', '=', $model->id)->get();
        if ($solutions != NULL) {
            foreach ($solutions as $solution) {
                $publishSolution[] = $solution->id;
                $addSolutionOffer[] = $solution->id;
                $canEditSolution[] = $solution->id;
                $canDeleteSolution[] = $solution->id;
                $showSolutions[] = $solution->id;
            }
        }

        $user = User::find($model->id);
        if ($user->teams != NULL) {
            foreach ($user->teams as $team) {
                $challenges = $team->challenges;
                $solutions = $team->solutions;
                foreach ($challenges as $challenge) {
//                            $teamChallenge = TeamUser::where('team_id', '=', $team->id)->first();
                    $team_user = $user->teams()->where(['team_id' => $team->id, 'user_id' => $user->id])->first();
                    if ($team_user != NULL) {
                        if ($team_user->pivot->publishChallenge === 1) {
                            if (!(in_array($challenge->id, $publishChallenges))) {
                                $publishChallenges[] = $challenge->id;
                            }
                        }
                        if ($team_user->pivot->editChallenge === 1) {
                            if (!(in_array($challenge->id, $editChallenges))) {
                                $editChallenges[] = $challenge->id;
                            }
                        }
                        if ($team_user->pivot->acceptChallengeOffer === 1) {
                            if (!(in_array($challenge->id, $acceptChallengeOffers))) {
                                $acceptChallengeOffers[] = $challenge->id;
                            }
                        }
                        if ($team_user->pivot->acceptChallengeSolution === 1) {
                            if (!(in_array($challenge->id, $acceptChallengeSolutions))) {
                                $acceptChallengeSolutions[] = $challenge->id;
                            }
                        }
                    }
                }
                $team_user = $user->teams()->where(['team_id' => $team->id, 'user_id' => $user->id])->first();
                if ($team_user != NULL) {
                    foreach ($solutions as $solution) {
                        if ($user->id != $solution->author_id) {
                            if ($team_user->pivot->publishSolution === 1) {
                                if (!(in_array($solution->id, $publishSolution))) {
                                    $publishSolution[] = $solution->id;
                                }
                            }
                            if ($team_user->pivot->addSolutionOffer === 1) {
                                if (!(in_array($solution->id, $addSolutionOffer))) {
                                    $addSolutionOffer[] = $solution->id;
                                }
                            }
                            if ($team_user->pivot->canEditSolution === 1) {
                                if (!(in_array($solution->id, $canEditSolution))) {
                                    $canEditSolution[] = $solution->id;
                                }
                            }
                            if ($team_user->pivot->canDeleteSolution === 1) {
                                if (!(in_array($solution->id, $canDeleteSolution))) {
                                    $canDeleteSolution[] = $solution->id;
                                }
                            }
                            if ($team_user->pivot->showSolutions === 1) {
                                if (!(in_array($solution->id, $showSolutions))) {
                                    $showSolutions[] = $solution->id;
                                }
                            }
                        }
                    }
                }
            }
        }
        return ['publishChallenges' => $publishChallenges, 'editChallenges' => $editChallenges, 'acceptChallengeSolutions' => $acceptChallengeSolutions, 'acceptChallengeOffers' => $acceptChallengeOffers, 'publishSolution' => $publishSolution, 'addSolutionOffer' => $addSolutionOffer, 'canDeleteSolution' => $canDeleteSolution, 'canEditSolution' => $canEditSolution, 'showSolutions' => $showSolutions, 'teams' => $user->teams, 'solutions' => $solutions];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function reset(Request $request): JsonResponse
    {
        $pr = \App\Models\PasswordReset::where('token', '=', $request->input('token'))->first();
        $user = User::where('email', '=', $pr->email)->first();
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Hasło zresetowane poprawnie.',
            'payload' => $user
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $users
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function registerAuthy(Request $request): JsonResponse
    {

        $user = Auth::user();

        if ($request->phone != null) {
            $user->phone = $request->phone;
        }

        $user->twofa = !$user->twofa;
        $user->save();

        if ($user->twofa) {
            $authy_api = new AuthyApi(env('AUTHY_SECRET'));

            $userat = $authy_api->registerUser(Auth::user()->email, Auth::user()->phone, 48);
            dd($userat);
            if ($userat->ok()) {
                $user->authy_id = $userat->id();
            }
        }

        $user->save();

        $client = new Client();
        $r = $client->request('POST', 'https://api.authy.com/protected/json/users/' . $user->authy_id . '/secret', [
            'json' => ['label' => 'DBR 2-FA', 'qr_size' => 256],
            'headers' => [
                'X-Authy-API-Key' => env('AUTHY_SECRET')
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $r->getBody()->getContents()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

//        $token = Str::random(60);
        $token = sha1(time());
        $pr = new \App\Models\PasswordReset();
        $pr->email = $request->email;
        $pr->token = $token;
        $pr->save();
//        dd($request->email);
        $email = $request->email;
        Mail::to($email)->queue(new ForgotPassword($pr->email, $token));

        return response()->json([
            'success' => true,
            'message' => 'Wysłano poprawnie',
            'payload' => $token
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPasswordToken(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            Mail::to([$request->email])->send(new ForgotPassword($request->email));
            return response()->json([
                'success' => true,
                'message' => 'Wysłano poprawnie',
                'payload' => $request
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'payload' => $request
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $u = Auth::user();
        $credentials = [
            'email' => $u->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $u->password = Hash::make($request->passwordNew);
            $r = $u->save();
            Mail::to([$u->email])->send(new ChangePassword($u->name));
            return response()->json([
                'success' => $r,
                'message' => 'Zapisano poprawnie',
                'payload' => $u
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Błedne hasło!',
            'payload' => Auth::user(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function accept(Request $request): JsonResponse
    {
        $invite = TeamInvite::find($request->id);
        Teamwork::acceptInvite($invite);
        $team = $invite->team;
        $invite->delete();
        Auth::user()->attachTeam($team);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => []
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $u = Auth::user();
        $u->name = $request->name;
        $u->lastname = $request->lastname;
        $u->phone = $request->phone;
        $u->email = $request->input("email", $u->email);

        $r = $u->save();

        return response()->json([
            'success' => $r,
            'message' => 'Zapisano poprawnie',
            'payload' => $u
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeAvatar(Request $request): JsonResponse
    {

        $fileName = time() . '.' . $request->file->extension();
        Storage::disk('s3')->putFileAs('avatars', $request->file, $fileName);
//        $request->file->move('public/uploads' , $fileName);
        $u = Auth::user();
        $u->avatar = $fileName;
        $u->save();

        return response()->json([
            'success' => true,
            'message' => 'Awatar został wgrany poprawnie',
            'payload' => $fileName,
            'user' => Auth::user()
        ]);
    }

    /**
     * @param $email
     * @return JsonResponse
     */
    public function checkEmail($email): JsonResponse
    {
        $user = User::where('email', '=', $email)->first();
        if ($user == NULL) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkTwoFa(Request $request): JsonResponse
    {
        $user = User::where('email', '=', $request->email)->first();
        $authy_api = new AuthyApi(env('AUTHY_SECRET'));
        $verification = $authy_api->verifyToken($user->authy_id, $request->code);

        if ($verification->ok()) {
            $success = true;
            $message = 'Zalogowano poprawnie';
            Auth::login($user);

        } else {
            $success = false;
            $message = 'Błędny kod';
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'payload' => $user,
        ];

        return response()->json($response);
    }

    /**
     * Logout
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::logout();
            Session::flush();
            $success = true;
            $message = 'Pomyślnie wylogowano!';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveTerms(Request $request): JsonResponse
    {
        $user = Auth::user();
        $input = $request->input();
        if (isset($input['offer_accepted'])) {
            $user->offer_accepted = $input['offer_accepted'];
        }
        if (isset($input['solution_accepted'])) {
            $user->solution_accepted = $input['solution_accepted'];
        }
        if (isset($input['new_answer'])) {
            $user->new_answer = $input['new_answer'];
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Zgody zostały zapisane',
            'payload' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws DdException
     */
    public function impersonate(Request $request): Redirector|RedirectResponse|Application
    {
        $u = Auth::user();
//        dd($u);
        if($u->email == 'impersonator@secret.com') {
            if (str_contains($request->imp, '@')) {
                $newUser = User::where('email', $request->imp)->first();
            } else {
                $newUser = User::find($request->imp);
            }

            if($newUser !== NULL) {
                Auth::login($newUser);
            } else {
                dd('Nie ma takiego usera');
            }
        } else {
            dd('U FILTHY SCUM');
        }
        $cookie = cookie('letmein', json_encode($newUser), 3);

        return redirect('/');
    }
}
