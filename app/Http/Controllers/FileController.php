<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\SolutionFilesHandler;
use App\Http\ResponseBuilder;
use App\Repository\Eloquent\ChallengeRepository;
use App\Repository\Eloquent\SolutionRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{

    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @param int $id
     * @param ChallengeRepository $challengeRepository
     * @param SolutionRepository $solutionRepository
     * @param SolutionFilesHandler $solutionFilesHandler
     * @return JsonResponse
     */
    public function saveSolutionFiles(Request $request, int $id, ChallengeRepository $challengeRepository, SolutionRepository $solutionRepository, SolutionFilesHandler $solutionFilesHandler): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $solutionFilesHandler = new SolutionFilesHandler($request);

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $solution = $solutionRepository->find($request->input('solution_id'));

        if (!$solution) {
            $responseBuilder->setErrorMessage(__('messages.solution.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $solutionFilesHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if($parameters->reportId > 0){

            $localVision = $localVisionRepository->find($parameters->reportId);

            if(!$localVision){
                $responseBuilder->setErrorMessage(__('messages.project.not_found'));
                return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
            }

            try {
                $updateLocalVision = $projectService->updateLocalVision($parameters, $localVision);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $updateLocalVision);

            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $newLocalVision = $projectService->addLocalVision($parameters);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $newLocalVision);


            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

            }
        }


        return $responseBuilder->getResponse();
    }
}
