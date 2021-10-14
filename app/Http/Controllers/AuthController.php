<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\LoginHandler;
use App\Http\Requests\Handlers\RegistrationHandler;
use App\Http\ResponseBuilder;
use App\Models\User;
use App\Parameters\LoginParameters;
use App\Repository\Eloquent\UserRepository;
use App\Services\UserService;
use Exception;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Mpociot\Teamwork\Facades\Teamwork;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Events\Registered;


/**
 *
 */
class AuthController extends Controller
{

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function register(Request $request): JsonResponse
    {

        $responseBuilder = new ResponseBuilder();

        $registrationHandler = new RegistrationHandler($request);

        if (!$registrationHandler->authorize()) {

            $responseBuilder->setErrorMessage("Unauthorized!");
            return $responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);

        }

        $parameters = $registrationHandler->getParameters();

        if (!$parameters->isValid()) {

            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);

        }

        try {

            /** @var User $newUser */
            $newUser = $this->userService->addUser($parameters);

            $responseBuilder->setInfoMessage(__('messages.registration.account_created'));
            $responseBuilder->setData('user', $newUser);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        if (!empty($request->token)) {

            $invite = Teamwork::getInviteFromAcceptToken($request->token);

            if ($invite) // valid token found
            {
                Teamwork::acceptInvite($invite);
            }

        }

        event(new Registered($newUser));

        return $responseBuilder->getResponse();
    }

    /**
     * @param UserRepository $userRepository
     * @param int $id
     * @param string $hash
     * @return Application|RedirectResponse|Redirector
     */
    public function emailVerification(UserRepository $userRepository, int $id, string $hash): Redirector|RedirectResponse|Application
    {

        /** @var MustVerifyEmail|User|null $user */
        $user = $userRepository->find($id);

        if (
            !$user ||
            !hash_equals(
                (string)$id,
                (string)$user->getKey()
            ) ||
            !hash_equals(
                $hash,
                sha1($user->getEmailForVerification())
            )
        ) {
            abort(404);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        return redirect('/login')->with('message', __('messages.registration.email_confirmed'));

    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function resendVerificationEmail(Request $request, UserRepository $userRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();
        $email = $request->get('email');

        /** @var User $user */
        $user = $userRepository->findByEmail($email);

        if (!$user || $user->hasVerifiedEmail()) {
            $responseBuilder->setErrorMessage(__('messages.registration.confirmation.wrong_email'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $user->sendEmailVerificationNotification();

        $responseBuilder->setSuccessMessage(__('messages.registration.confirmation.sent'));

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @return RedirectResponse|JsonResponse
     */
    public function login(Request $request, UserRepository $userRepository): RedirectResponse|JsonResponse
    {

        $responseBuilder = new ResponseBuilder();
        $loginHandler = new LoginHandler($request);

        if (!$loginHandler->authorize()) {

            $responseBuilder->setErrorMessage('Unauthorized!');
            return $responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);

        }

        /** @var LoginParameters $loginParameters */
        $loginParameters = $loginHandler->getParameters();

        if (!$loginParameters->isValid()) {

            $responseBuilder->setErrorMessagesFromMB($loginParameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);

        }

        $user = $userRepository->findByEmail($loginParameters->email);

        if (!$user || !Hash::check($loginParameters->password, $user->password)) {

            $responseBuilder->setErrorMessage(__('messages.login.wrong_credentials'));
            return $responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);

        }

        if (!$user->email_verified_at) {
            $responseBuilder->setWarningMessage(__('messages.login.account_inactive'));
            $responseBuilder->setData('accountInactive', true);
            return $responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);
        }

        if ($user->twofa == 1) {
            $responseBuilder->setData('twofa', true);
        } else {

            if (!Auth::attempt(['email' => $loginParameters->email, 'password' => $loginParameters->password])) {
                $responseBuilder->setErrorMessage(__('messages.login.wrong_credentials'));
                return $responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);
            }

            $responseBuilder->setData('twofa', false);

        }

        $responseBuilder->setData('user', $user);
        $responseBuilder->setData('company', $user->company()->getResults());
        return $responseBuilder->getResponse();
    }

}
