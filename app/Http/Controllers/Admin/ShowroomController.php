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

    public function index(ShowroomRepository $repository)
    {
        $showrooms = $repository->all();

        $this->responseBuilder->setData('showrooms', $showrooms);

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

        if ($request->showroom_id != null) {
            $check = $repository->find($request->showroom_id);
            if ($check == null) {
                $check = new Showroom();
            }
        } else {
            $check = new Showroom();
        }

        $saveShowroom = $showroomService->saveShowroom($parameters, $check);

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('showroom', $saveShowroom);


        return $this->responseBuilder->getResponse();
    }

    public function deleteShowroom(Request $request, ShowroomRepository $repository)
    {

    }

    public function saveSlide()
    {

    }

    public function removeSlide()
    {

    }
}
