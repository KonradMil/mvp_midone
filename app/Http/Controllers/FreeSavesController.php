<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\FreeSavesHandler;
use App\Http\Requests\Handlers\LocalVisionHandler;
use App\Http\ResponseBuilder;
use App\Repository\Eloquent\FreeSavesRepository;
use App\Services\FreeSaveService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FreeSavesController extends Controller
{
    public function __construct()
    {

    }

    public function getSingleSave(Request $request, FreeSavesRepository $freeSavesRepository, int $id)
    {
        $responseBuilder = new ResponseBuilder();

        $freeSave = $freeSavesRepository->find($id);

        if (!$freeSave) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $responseBuilder->setData('freesave', $freeSave);

        return $responseBuilder->getResponse();
    }

    public function getManySaves(Request $request, FreeSavesRepository $freeSavesRepository)
    {

    }

    public function saveData(Request $request, FreeSavesRepository $freeSavesRepository, FreeSavesHandler $freeSavesHandler, FreeSaveService $freeSaveService)
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
                $updateFreeSave = $freeSaveService->updateFreeSave($parameters, $freeSave);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $freeSaveService);

            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $newFreeSave = $freeSaveService->addFreeSave($parameters);

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
