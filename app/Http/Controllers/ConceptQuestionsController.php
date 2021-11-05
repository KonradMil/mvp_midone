<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\ConceptAnswerHandler;
use App\Http\Requests\Handlers\ConceptQuestionHandler;
use App\Http\ResponseBuilder;
use App\Repository\Eloquent\ConceptQuestionRepository;
use App\Repository\Eloquent\ProjectCommunicationRepository;
use App\Repository\Eloquent\ProjectConceptRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\UserRepository;
use App\Services\ProjectCommunicationService;
use App\Services\ProjectConceptService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ConceptQuestionsController extends Controller
{
    /**
     * @param Request $request
     * @param ProjectConceptRepository $projectConceptRepository
     * @param ProjectConceptService $projectConceptService
     * @param ConceptQuestionRepository $conceptQuestionRepository
     * @return JsonResponse
     */
    public function addConceptAnswer(Request $request, ProjectConceptRepository $projectConceptRepository, ProjectConceptService $projectConceptService, ConceptQuestionRepository $conceptQuestionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $conceptAnswerHandler = new ConceptAnswerHandler($request);

        $projectConcept = $projectConceptRepository->find($request->get('concept_id'));

        if (!$projectConcept) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $conceptQuestion = $conceptQuestionRepository->find($request->get('concept_question_id'));

        if (!$conceptQuestion) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $conceptAnswerHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {
            $projectConcept = $projectConceptService->addAnswer($parameters);

            $responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $responseBuilder->setData('project_concept', $projectConcept);

        } catch (QueryException $e) {
            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectConceptRepository $projectConceptRepository
     * @param ProjectConceptService $projectConceptService
     * @return JsonResponse
     */
    public function addConceptQuestion(Request $request, ProjectConceptRepository $projectConceptRepository, ProjectConceptService $projectConceptService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $projectCommunicationHandler = new ConceptQuestionHandler($request);

        $projectConcept = $projectConceptRepository->find($request->get('concept_id'));

        if (!$projectConcept) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $projectCommunicationHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {
                $projectConcept = $projectConceptService->addQuestion($parameters);

                $responseBuilder->setSuccessMessage(__('messages.save_correct'));
                $responseBuilder->setData('project_concept', $projectConcept);

            } catch (QueryException $e) {
                $responseBuilder->setErrorMessage(__('messages.error'));
                return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
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
     * @param ProjectConceptRepository $projectConceptRepository
     * @param ConceptQuestionRepository $conceptQuestionRepository
     * @return JsonResponse
     */
    public function getConceptQuestions(Request $request, int $id, ProjectRepository $projectRepository, ProjectConceptRepository $projectConceptRepository, ConceptQuestionRepository $conceptQuestionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectConcept = $projectConceptRepository->find($request->get('concept_id'));

        if (!$projectConcept) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $conceptQuestions = $conceptQuestionRepository->getAllQuestionsByConceptId($projectConcept->id);

        $responseBuilder->setData('conceptQuestions', $conceptQuestions);

        return $responseBuilder->getResponse();
    }
}
