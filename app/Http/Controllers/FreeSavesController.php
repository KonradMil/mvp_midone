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

    public ResponseBuilder $responseBuilder;

    public function __construct()
    {
        $this->responseBuilder = new ResponseBuilder();
    }

    /**
     * @param int $id
     * @param FreeSavesRepository $freeSavesRepository
     * @param FreeSavesService $freeSavesService
     * @return JsonResponse
     */
    public function deleteSave(int $id, FreeSavesRepository $freeSavesRepository, FreeSavesService $freeSavesService): JsonResponse
    {


        $freeSave = $freeSavesRepository->find($id);

        if (!$freeSave) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $freeSavesService->deleteFreeSave($freeSave);

            $this->responseBuilder->setSuccessMessage(__('messages.delete_correct'));

        } catch (QueryException $e) {

            $this->responseBuilder->setErrorMessage(__('messages.error'));
            return $this->responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $this->responseBuilder->getResponse();
    }


    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param FreeSavesRepository $freeSavesRepository
     * @return JsonResponse
     */
    public function getSaves(Request $request, UserRepository $userRepository, FreeSavesRepository $freeSavesRepository)
    {

        $user = $userRepository->find($request->user()->id);

        if (!$user) {
            $this->responseBuilder->setErrorMessage(__('messages.user.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $freeSaves = $freeSavesRepository->getFreeSavesByUser($user->id);

        $this->responseBuilder->setData('freeSaves', $freeSaves);

        return $this->responseBuilder->getResponse();
    }


    /**
     * @param Request $request
     * @param FreeSavesRepository $freeSavesRepository
     * @param FreeSavesService $freeSavesService
     * @return JsonResponse
     */
    public function saveData(Request $request, FreeSavesRepository $freeSavesRepository,FreeSavesService $freeSavesService)
    {

        $freeSavesHandler = new FreeSavesHandler($request);

        $parameters = $freeSavesHandler->getParameters();

        $id = $request->data['id'];

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if($id > 0){

            $freeSave = $freeSavesRepository->find($id);

            if(!$freeSave){
                $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
                return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
            }

            try {
                $updateFreeSave = $freeSavesService->updateFreeSave($parameters, $freeSave);

                $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
            } catch (QueryException $e) {

                $this->responseBuilder->setErrorMessage(__('messages.error'));
                return $this->responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $newFreeSave = $freeSavesService->addFreeSave($parameters);

                $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $this->responseBuilder->setData('local_vision', $newFreeSave);
            } catch (QueryException $e) {
                $this->responseBuilder->setErrorMessage(__('messages.error'));
                return $this->responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }


        return $this->responseBuilder->getResponse();
    }

    public function saveEmpty(Request $request, FreeSavesRepository $freeSavesRepository,FreeSavesService $freeSavesService)
    {
            try {
                $freeSave = $freeSavesService->createEmptySave();

                $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
            } catch (QueryException $e) {

                $this->responseBuilder->setErrorMessage(__('messages.error'));
                return $this->responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }


        return $this->responseBuilder->getResponse();
    }
}
