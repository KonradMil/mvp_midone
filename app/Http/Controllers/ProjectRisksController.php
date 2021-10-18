<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\ProjectRiskHandler;
use App\Http\ResponseBuilder;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\ProjectRiskRepository;
use App\Services\ProjectRiskService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectRisksController extends Controller
{
    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectRiskService $projectRiskService
     * @param ProjectRiskRepository $projectRiskRepository
     * @return JsonResponse
     */
    public function saveCommunicationPlan(Request $request, ProjectRepository $projectRepository, ProjectRiskService $projectRiskService, ProjectRiskRepository $projectRiskRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $projectRiskHandler = new ProjectRiskHandler($request);

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $projectRiskHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if($parameters->riskId > 0){

            $projectRisk = $projectRiskRepository->find($parameters->riskId);

            if(!$projectRisk){
                $responseBuilder->setErrorMessage(__('messages.project.not_found'));
                return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
            }

            try {
                $updateProjectRisk = $projectRiskService->updateProjectRisk($parameters, $projectRisk);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $updateProjectRisk);

            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $newRisk = $projectRiskService->addRisk($parameters);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $newRisk);


            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

            }
        }


        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectRiskRepository $projectRiskRepository
     * @param ProjectRiskService $projectRiskService
     * @return JsonResponse
     */
    public function deleteRisk(Request $request, ProjectRepository $projectRepository, ProjectRiskRepository $projectRiskRepository, ProjectRiskService $projectRiskService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectRisk = $projectRiskRepository->find($request->input('id'));

        if (!$projectRisk) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $projectRiskService->deleteProjectRisk($projectRisk);

            $responseBuilder->setSuccessMessage(__('messages.delete_correct'));

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @param ProjectRiskRepository $projectRiskRepository
     * @return JsonResponse
     */
    public function getVisitDate(int $id, ProjectRepository $projectRepository, ProjectRiskRepository $projectRiskRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $risks = $projectRiskRepository->getAllRisksByProjectId($id);

        $responseBuilder->setData('deadlines', $risks);

        return $responseBuilder->getResponse();
    }
}
