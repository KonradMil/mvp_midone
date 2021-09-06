<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Http\Requests\Handlers\RegistrationHandler;
use App\Http\ResponseBuilder;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mpociot\Teamwork\Facades\Teamwork;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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

        if (!$parameters->validate()) {

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

    public function emailVerification(EmailVerificationRequest $request)
    { dd("TESTS");
        $request->fulfill();
        return redirect('login')->with('message', "Zaloguj się...");
    }

}
