<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\ProjectCommunicationHandler;
use App\Http\ResponseBuilder;
use App\Models\ProjectCommunication;
use App\Models\User;
use App\Repository\Eloquent\ProjectCommunicationRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\UserRepository;
use App\Services\ProjectCommunicationService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectCommunicationsController extends Controller
{
    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectCommunicationService $projectCommunicationService
     * @param ProjectCommunicationRepository $projectCommunicationRepository
     * @return JsonResponse
     */
    public function saveCommunicationPlan(Request $request, ProjectRepository $projectRepository, ProjectCommunicationService $projectCommunicationService, ProjectCommunicationRepository $projectCommunicationRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $projectCommunicationHandler = new ProjectCommunicationHandler($request);

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $projectCommunicationHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if($parameters->communicationPlanId > 0){

            $projectCommunication = $projectCommunicationRepository->find($parameters->communicationPlanId);

            if(!$projectCommunication){
                $responseBuilder->setErrorMessage(__('messages.project.not_found'));
                return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
            }

            try {
                $updateProjectCommunication = $projectCommunicationService->updateProjectCommunication($parameters, $projectCommunication);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $updateProjectCommunication);

            } catch (QueryException $e) {

                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $newCommunicationPlan = $projectCommunicationService->addCommunicationPlan($parameters);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('local_vision', $newCommunicationPlan);

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
     * @param ProjectCommunicationRepository $projectCommunicationRepository
     * @param ProjectCommunicationService $projectCommunicationService
     * @return JsonResponse
     */
    public function deleteCommunicationPlan(Request $request, ProjectRepository $projectRepository, ProjectCommunicationRepository $projectCommunicationRepository, ProjectCommunicationService $projectCommunicationService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectCommunication = $projectCommunicationRepository->find($request->input('id'));

        if (!$projectCommunication) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $projectCommunicationService->deleteProjectCommunication($projectCommunication);

            $responseBuilder->setSuccessMessage(__('messages.delete_correct'));

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @param ProjectCommunicationRepository $projectCommunicationRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function getIntegratorCommunications(Request $request, int $id, ProjectRepository $projectRepository, ProjectCommunicationRepository $projectCommunicationRepository, UserRepository $userRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $user = $userRepository->find($request->get('integrator_id'));

        if (!$user) {
            $responseBuilder->setErrorMessage(__('messages.user.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $communications = $projectCommunicationRepository->getAllIntegratorCommunicationsByProjectId($id, $user->id);

        $responseBuilder->setData('communications', $communications);

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @param ProjectCommunicationRepository $projectCommunicationRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function getInvestorCommunications(Request $request, int $id, ProjectRepository $projectRepository, ProjectCommunicationRepository $projectCommunicationRepository, UserRepository $userRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $user = $userRepository->find($request->get('investor_id'));

        if (!$user) {
            $responseBuilder->setErrorMessage(__('messages.user.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $communications = $projectCommunicationRepository->getAllInvestorCommunicationsByProjectId($id, $user->id);

        $responseBuilder->setData('communications', $communications);

        return $responseBuilder->getResponse();
    }
}
