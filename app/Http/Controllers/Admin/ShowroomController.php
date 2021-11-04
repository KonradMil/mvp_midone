<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Handlers\Admin\ShowroomHandler;
use App\Http\ResponseBuilder;
use App\Models\Showrooms\Showroom;
use App\Repository\Eloquent\Admin\ShowroomRepository;
use App\Services\Admin\ShowroomService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowroomController extends Controller
{


    protected ResponseBuilder $responseBuilder;

    public function __construct()
    {
        $this->responseBuilder = new ResponseBuilder();
    }


    public function index(ShowroomRepository $repository)
    {
        $showrooms = $repository->all();

        if (!empty($showrooms)) {
            $this->responseBuilder->setErrorMessage(__('messages.showroom.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        } else {
            $this->responseBuilder->setData('showrooms', $showrooms);
        }

        return $this->responseBuilder->getResponse();
    }

    public function saveShowroom(Request $request, ShowroomRepository $repository, ShowroomService $showroomService)
    {
        $showroomHandler = new ShowroomHandler($request);

        $parameters = $showroomHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {
            if($request->showroom_id != null) {
                $check = $repository->find($request->showroom_id);
                if($check == null) {
                    $check = new Showroom();
                }
            } else {
                $check = new Showroom();
            }

            $saveShowroom = $showroomService->saveShowroom($parameters, $check);

            $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $this->responseBuilder->setData('showroom', $saveShowroom);


        } catch (QueryException $e) {

            $this->responseBuilder->setErrorMessage(__('messages.error'));
            return $this->responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $this->responseBuilder->getResponse();
    }

    public function deleteShowroom()
    {

    }

    public function saveSlide()
    {

    }

    public function removeSlide()
    {

    }
}
