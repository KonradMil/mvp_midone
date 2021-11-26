<?php

namespace App\Http\Controllers;

use App\Models\Contests\Contest;
use App\Models\Contests\ContestUser;
use App\Models\User;
use App\Repository\Eloquent\Admin\ContestRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ContestController extends Controller
{
    public function index(ContestRepository $contestRepository)
    {
        $services = $contestRepository->all();

        $this->responseBuilder->setData('contest', $services);

        return $this->responseBuilder->getResponse();
    }

    public function getContestData(Request $request, $name_slug)
    {
        $data = Contest::where('name_slug', '=', $name_slug)->first();

        $this->responseBuilder->setData('contest',  $data);

        return $this->responseBuilder->getResponse();
    }

    public function registerUser(Request $request, $name_slug)
    {
        $serviceUser = ContestUser::where('email', '=', $request->email)->first();
        $contest = Contest::where('name_slug', '=', $name_slug)->first();
//        Log::info(json_encode([$name_slug, $contest]));
        if($serviceUser == NULL) {
            $serviceUser = new ContestUser();
            $serviceUser->email = $request->email;
            $serviceUser->password = bcrypt($request->password);
            $serviceUser->contest_id = $contest->id;
            $serviceUser->save();

            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->email_verified_at = Carbon::now();
            $user->verified = 1;
            $user->type = 'contest';
            $user->save();
            Auth::login($user);

            session(['contest_logged' => 'true']);
            session(['contest' => $contest->organization_slug]);

            $this->responseBuilder->setSuccessMessage(__('Zarejestrowano'));
            $this->responseBuilder->setData('contest-user',  $serviceUser);
        } else {
            $user = User::where('email', '=', $request->email)->first();
            if(Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                Auth::login($user);
                session(['contest_logged' => 'true']);
                session(['contest' => $contest->organization_slug]);

                $this->responseBuilder->setSuccessMessage(__('Zarejestrowano'));
                $this->responseBuilder->setData('contest-user',  $serviceUser);
            } else {
                session(['contest_logged' => 'true']);
                session(['contest' => $contest->organization_slug]);

                $this->responseBuilder->setErrorMessage(__('Błędne hasło'));
//                $this->responseBuilder->setData('contest-user',  $serviceUser);
            }
        }



        return $this->responseBuilder->getResponse();
    }

    public function logInUser(Request $request, $name_slug)
    {
        $studio = Contest::where('name_slug', '=', $name_slug)->first();
        $serviceUser = ContestUser::where('email', '=', $request->email . $studio->email_regexp)->first();


        if($serviceUser != NULL) {
            if(Auth::attempt(['email' => $request->email . $studio->email_regexp, 'password' => $request->password])) {
                session(['contest_logged' => 'true']);
                session(['contest' => $studio->organization_slug]);
                $this->responseBuilder->setSuccessMessage(__('Zalogowano'));
                $this->responseBuilder->setData('contest-user',  $serviceUser);
                return $this->responseBuilder->getResponse();
            } else {
                $this->responseBuilder->setErrorMessage('Błędne hasło');
                return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
            }
        } else {
            $this->responseBuilder->setErrorMessage('Błędny email');
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }
    }
}
