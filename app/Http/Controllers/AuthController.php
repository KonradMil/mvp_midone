<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\RegistrationHandler;
use App\Http\ResponseBuilder;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mpociot\Teamwork\Facades\Teamwork;
use Symfony\Component\HttpFoundation\Response;

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

        $response = [
            'success' => false,
            'message' => "",
            'payload' => null
        ];

        $registrationHandler = new RegistrationHandler($request);

        if (!$registrationHandler->authorize()) {

            return response()->json("Unauthorized!", Response::HTTP_UNAUTHORIZED);

            //New way:

            $responseBuilder->setError("Unauthorized!", 'security');
            return $responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);


        }

        $parameters = $registrationHandler->handleRequest();

        if (!$parameters->validate()) {

            $response['message'] = $parameters->getMessagesString();
            return response()->json($response, Response::HTTP_BAD_REQUEST);

            //New way:

            $responseBuilder->setErrorsFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);

        }

        try {

            $newUser = $this->userService->addUser($parameters);

            $response['success'] = true;
            $response['message'] = __('messages.registration.account-created');
            $response['payload'] = $newUser;

            //new way:

            $responseBuilder->setMessage(__('messages.registration.account-created'));
            $responseBuilder->addData('user', $newUser);


        } catch (QueryException $e) {

            $response['message'] = 'Unexpected error occured!';
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);

            //New way:
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

        return response()->json($response);

        //New way:
        return $responseBuilder->getResponse();
    }

}
