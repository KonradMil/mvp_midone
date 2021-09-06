<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\RegistrationHandler;
use App\Http\ResponseBuilder;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use App\Services\UserService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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
     */
    public function register(Request $request): JsonResponse
    {

        $responseBuilder = new ResponseBuilder();

        $registrationHandler = new RegistrationHandler($request);

        if (!$registrationHandler->authorize()) {

            $responseBuilder->setError("Unauthorized!", 'security');
            return $responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);


        }

        $parameters = $registrationHandler->handleRequest();

        if (!$parameters->isValid()) {

            $responseBuilder->setErrorsFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);

        }

        try {

            /** @var User $newUser */
            $newUser = $this->userService->addUser($parameters);

            $responseBuilder->setMessage(__('messages.registration.account-created'));
            $responseBuilder->addData('user', $newUser);


        } catch (QueryException $e) {

            $responseBuilder->setError('Unexpected error occured!');
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
    public function emailVerification(UserRepository $userRepository, int $id, string $hash)
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


        return redirect('/login');

    }

}
