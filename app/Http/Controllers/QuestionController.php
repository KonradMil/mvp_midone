<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\ProjectConceptHandler;
use App\Http\ResponseBuilder;
use App\Models\Question;
use App\Repository\Eloquent\ProjectConceptRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Services\ProjectConceptService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class QuestionController extends Controller
{
    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectConceptService $projectConceptService
     * @param ProjectConceptRepository $projectConceptRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveConceptQuestion(Request $request, ProjectRepository $projectRepository, ProjectConceptService $projectConceptService, ProjectConceptRepository $projectConceptRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $projectConceptHandler = new ProjectConceptHandler($request);

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $projectConceptHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if($parameters->conceptId > 0){

            $projectConcept = $projectConceptRepository->find($parameters->conceptId);

            if(!$projectConcept){
                $responseBuilder->setErrorMessage(__('messages.project.not_found'));
                return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
            }

            try {
                $updateProjectConcept = $projectConceptService->updateProjectConcept($parameters, $projectConcept);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $updateProjectConcept);

            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $newConcept = $projectConceptService->addConcept($parameters);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $newConcept);

            } catch (QueryException $e) {
                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }


        return $responseBuilder->getResponse();
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $input = $request->input();
        $question = new Question();
        $question->question = $input['data']['question'];
        $question->challenge_id = $input['data']['challenge_id'];
        $question->author_id = Auth::user()->id;
        if (!empty($input['data']['isAnswer'])) {
            $question->answer = $input['data']['isAnswer'];
        }
        $question->save();

        return response()->json([
            'success' => true,
            'message' => 'Pytania zostało dodane poprawnie',
            'payload' => $question
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $questions = Question::where('challenge_id', '=', $request->input('id'))->where('answer', '=', null)->with('answers')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pytania zostały pobrane poprawnie',
            'payload' => $questions
        ]);

    }
}
