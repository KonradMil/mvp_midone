<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Handlers\Admin\CategoryHandler;
use App\Http\Requests\Handlers\Admin\DiscussionHandler;
use App\Http\Requests\Handlers\Admin\SAASHandler;
use App\Models\Forum\Category;
use App\Models\Forum\Discussion;
use App\Models\Forum\Post;
use App\Models\SAAS\Studio;
use App\Models\SAAS\StudioUser;
use App\Models\User;
use App\Repository\Eloquent\Admin\CategoryRepository;
use App\Repository\Eloquent\Admin\DiscussionRepository;
use App\Repository\Eloquent\Admin\PostRepository;
use App\Repository\Eloquent\Admin\SAASRepository;
use App\Services\Admin\CategoryService;
use App\Services\Admin\DiscussionService;
use App\Services\Admin\SAASService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
{

    public function getD(SAASRepository $SAASRepository, SAASService $SAASService, Request $request)
    {
        $saasHandler = new SAASHandler($request);
        $parameters = $saasHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessage($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if ($request->saas_id != null) {
            $check = $SAASRepository->find($request->saas_id);
            if ($check == null) {
                $check = new Studio();
            }
        } else {
            $check = new Studio();
        }

        $saveSaas = $SAASService->saveService($parameters, $check);
        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('saas',  $saveSaas);

        return $this->responseBuilder->getResponse();
    }

    public function saasIndex(SAASRepository $SAASRepository)
    {
        $services = $SAASRepository->all();

        $this->responseBuilder->setData('saas', $services);

        return $this->responseBuilder->getResponse();
    }

    public function getServiceData(Request $request, $organization)
    {
        $data = Studio::where('organization_slug', '=', $organization)->first();

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('saas',  $data);

        return $this->responseBuilder->getResponse();
    }

    public function registerServiceUser(Request $request, $organization)
    {
        $serviceUser = StudioUser::where('email', '=', $request->email)->first();
        $studio = Studio::where('organization_slug', '=', $organization)->first();

        if($serviceUser == NULL) {
            $serviceUser = new StudioUser();
            $serviceUser->email = $request->email;
            $serviceUser->password = bcrypt($request->password);
            $serviceUser->studio_id = $studio->id;
            $serviceUser->save();

            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->email_verified_at = Carbon::now();
            $user->verified = 1;
            $user->type = 'saas';
            $user->save();
            Auth::login($user);
        }

        session(['service_logged' => 'true']);
        session(['service' => $studio->organization_slug]);

        $this->responseBuilder->setSuccessMessage(__('Zarejestrowano'));
        $this->responseBuilder->setData('service-user',  $serviceUser);

        return $this->responseBuilder->getResponse();
    }

    public function logInServiceUser(Request $request, $organization)
    {
        $serviceUser = StudioUser::where('email', '=', $request->email)->first();
        $studio = Studio::where('organization_slug', '=', $organization)->first();

        if($serviceUser != NULL) {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                session(['service_logged' => 'true']);
                session(['service' => $studio->organization_slug]);
                $this->responseBuilder->setSuccessMessage(__('Zalogowano'));
                $this->responseBuilder->setData('service-user',  $serviceUser);
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
