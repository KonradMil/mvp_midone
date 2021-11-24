<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Handlers\Admin\ShowroomHandler;
use App\Http\Requests\Handlers\Admin\ShowroomSlideHandler;
use App\Http\ResponseBuilder;
use App\Models\SAAS\Studio;
use App\Models\Showrooms\Showroom;
use App\Models\Showrooms\ShowroomSlide;
use App\Models\Showrooms\ShowroomVisitor;
use App\Parameters\Admin\ShowroomSlideParameters;
use App\Repository\Eloquent\Admin\ShowroomRepository;
use App\Services\Admin\ShowroomService;
use App\Services\Admin\ShowroomSlideService;
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

    public function saveShowroom(Request $request, ShowroomRepository $repository, ShowroomService $showroomService, ShowroomSlideService $showroomSlideService)
    {
        $showroomHandler = new ShowroomHandler($request);
        $showroomSlideHandler = new ShowroomSlideHandler($request);

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
//        if (!$parametersSlide->isValid()) {
        $slides = $request->get('slides');
        foreach ($slides as $slide) {
            $parametersSlide = new ShowroomSlideParameters();

            $parametersSlide->name = $slide['title'] ?? '';
            $parametersSlide->menu_name = '';
            $parametersSlide->menu_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slide['title'])));
            $parametersSlide->content = $slide['content'] ?? $slide['text'];
            $parametersSlide->type = $slide['type'] ?? 0;

            $slide = new ShowroomSlide();
            $saveSlide = $showroomSlideService->saveSlide($parametersSlide, $slide, $saveShowroom->id);
        }

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('showroom', [$saveShowroom, $saveSlide]);


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

    public function loginVisitor(Request $request, $organization)
    {
        $check = ShowroomVisitor::where('email', '=', $request->email)->first();

        if($check != null) {
            session(['showroom_logged' => 'true']);
        } else {
            $check = new ShowroomVisitor();
            $check->email = $request->email;
            $check->save();
        }

        $this->responseBuilder->setSuccessMessage('Zalogowano poprawnie.');

        return $this->responseBuilder->getResponse();
    }

    public function showroom(Request $request, $organization)
    {

    }

    public function getShowroomData(Request $request, $organization)
    {
        $showroom = Showroom::where('organization_slug', '=', $organization)->with('challenge')->first();

        $this->responseBuilder->setData('showroom',  $showroom);

        return $this->responseBuilder->getResponse();

    }

    public function logInShowroomUser(Request $request, $organization)
    {
        $check = ShowroomVisitor::where('email', '=', $request->email)->first();

        if($check != null) {
            session(['showroom_logged' => 'true']);
        } else {
            $check = new ShowroomVisitor();
            $check->email = $request->email;
            $check->save();
        }

        $this->responseBuilder->setSuccessMessage('Zalogowano poprawnie.');

        return $this->responseBuilder->getResponse();
    }
}
