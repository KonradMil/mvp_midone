<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\FreeSavesHandler;
use App\Http\ResponseBuilder;
use App\Repository\Eloquent\FreeSavesRepository;
use App\Repository\Eloquent\UserRepository;
use App\Services\FreeSavesService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FreeSavesController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @param int $id
     * @param FreeSavesRepository $freeSavesRepository
     * @param FreeSavesService $freeSavesService
     * @return JsonResponse
     */
    public function deleteSave(int $id, FreeSavesRepository $freeSavesRepository, FreeSavesService $freeSavesService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $freeSave = $freeSavesRepository->find($id);

        if (!$freeSave) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $freeSavesService->deleteFreeSave($freeSave);

            $responseBuilder->setSuccessMessage(__('messages.delete_correct'));

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }


        return $responseBuilder->getResponse();
    }

    public function getSave(Request $request, FreeSavesRepository $freeSavesRepository, int $id)
    {
        $responseBuilder = new ResponseBuilder();

        $freeSave = $freeSavesRepository->find($id);

        if (!$freeSave) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $responseBuilder->setData('freeSave', $freeSave);

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param FreeSavesRepository $freeSavesRepository
     * @return JsonResponse
     */
    public function getSaves(Request $request, UserRepository $userRepository, FreeSavesRepository $freeSavesRepository)
    {
        $responseBuilder = new ResponseBuilder();

        $user = $userRepository->find(Auth::user()->id);

        if (!$user) {
            $responseBuilder->setErrorMessage(__('messages.user.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $freeSaves = $freeSavesRepository->getFreeSavesByUser($user->id);

        $responseBuilder->setData('freeSaves', $freeSaves);

        return $responseBuilder->getResponse();
    }


    /**
     * @param Request $request
     * @param FreeSavesRepository $freeSavesRepository
     * @param FreeSavesHandler $freeSavesHandler
     * @param FreeSavesService $freeSavesService
     * @return JsonResponse
     */
    public function saveData(Request $request, FreeSavesRepository $freeSavesRepository, FreeSavesHandler $freeSavesHandler, FreeSavesService $freeSavesService)
    {
        $responseBuilder = new ResponseBuilder();

        $freeSavesHandler = new FreeSavesHandler($request);

        $parameters = $freeSavesHandler->getParameters();

        $id = $request->data['id'];

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if($id > 0){

            $freeSave = $freeSavesRepository->find($id);

            if(!$freeSave){
                $responseBuilder->setErrorMessage(__('messages.project.not_found'));
                return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
            }

            try {
                $updateFreeSave = $freeSavesService->updateFreeSave($parameters, $freeSave);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $newFreeSave = $freeSavesService->addFreeSave($parameters);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $newFreeSave);


            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

            }
        }


        return $responseBuilder->getResponse();
    }
}
