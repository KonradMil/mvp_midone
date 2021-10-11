<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\FinancialHandler;
use App\Http\Requests\Handlers\LocalVisionHandler;
use App\Http\Requests\Handlers\TechnicalDetailsHandler;
use App\Http\Requests\Handlers\VisitDateHandler;
use App\Http\ResponseBuilder;
use App\Repository\Eloquent\ChallengeRepository;
use App\Repository\Eloquent\LocalVisionRepository;
use App\Repository\Eloquent\OfferRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\SolutionRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\VisitDateRepository;
use App\Services\ChallengeService;
use App\Services\ProjectService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{

    public function __construct()
    {

    }

    /**
     * @param ChallengeRepository $challengeRepository
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @return JsonResponse
     */
    public function getProjectCard(ChallengeRepository $challengeRepository, ProjectRepository $projectRepository, int $id): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();
        $challenge = $challengeRepository->getFullChallengeById($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->getProjectByChallengeId($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $responseBuilder->setData('challenge', $challenge);
        $responseBuilder->setData('project', $project);

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectService $projectService
     * @param LocalVisionRepository $localVisionRepository
     * @return JsonResponse
     */
    public function saveLocalVision(Request $request, ProjectRepository $projectRepository, ProjectService $projectService, LocalVisionRepository $localVisionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $localVisionHandler = new LocalVisionHandler($request);

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $localVisionHandler->getParameters();

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

    /**
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function getLocalVision(int $id, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $reports = $localVisionRepository->getAllLocalVisionsByProjectId($id);

        $check = $projectService->checkLocalVision($id);

        $responseBuilder->setData('reports', $reports);
        $responseBuilder->setData('check', $check);

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @return JsonResponse
     */
    public function deleteReport(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->find($request->input('id'));

        if (!$localVision) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $projectService->deleteReport($localVision);

            $responseBuilder->setSuccessMessage(__('messages.delete_correct'));

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ChallengeRepository $challengeRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function saveFinancialDetails(Request $request, ChallengeRepository $challengeRepository, int $id, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $financialHandler = new FinancialHandler($request);

        $parameters = $financialHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {

            $newFinancial = $projectService->addFinancialDetails($parameters);

            $responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $responseBuilder->setData('new_technical', $newFinancial);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }


        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ChallengeRepository $challengeRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function saveTechnicalDetails(Request $request, int $id, ChallengeRepository $challengeRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $technicalDetailsHandler = new TechnicalDetailsHandler($request);

        $parameters = $technicalDetailsHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {

            $newTechnicalDetails = $projectService->addTechnicalDetails($parameters);

            $responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $responseBuilder->setData('new_technical', $newTechnicalDetails);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param OfferRepository $offerRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function acceptOffer(Request $request, ProjectRepository $projectRepository, OfferRepository $offerRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerRepository->find($request->input('new_offer_id'));

        if (!$offer) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $projectService->acceptOffer($project, $offer);

            $responseBuilder->setSuccessMessage(__('messages.accepted'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param OfferRepository $offerRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function rejectOffer(Request $request, ProjectRepository $projectRepository, OfferRepository $offerRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerRepository->find($request->input('new_offer_id'));

        if (!$offer) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $feedback = $request->input('feedback');

        try {
            $projectService->rejectOffer($project, $offer, $feedback);

            $responseBuilder->setSuccessMessage(__('messages.rejected'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function acceptTechnicalDetails(ProjectRepository $projectRepository, int $id, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $projectService->acceptTechnicalDetails($project);

            $responseBuilder->setSuccessMessage(__('messages.accepted'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function rejectTechnicalDetails(ProjectRepository $projectRepository, int $id, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $projectService->rejectTechnicalDetails($project);

            $responseBuilder->setSuccessMessage(__('messages.rejected'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function acceptFinancialDetails(ProjectRepository $projectRepository, int $id, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $projectService->acceptFinancialDetails($project);

            $responseBuilder->setSuccessMessage(__('messages.accepted'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function rejectFinancialDetails(ProjectRepository $projectRepository, int $id, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $projectService->rejectFinancialDetails($project);

            $responseBuilder->setSuccessMessage(__('messages.rejected'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function endLocalVision(Request $request, ProjectRepository $projectRepository,ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $projectService->endLocalVision($project);

            $responseBuilder->setData('visit_date', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function acceptReport(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->find($request->input('id'));

        if (!$localVision) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $acceptLocalVision = $projectService->acceptReport($localVision);

            $responseBuilder->setSuccessMessage(__('messages.accepted'));
            $responseBuilder->setData('visit_date', $acceptLocalVision);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function rejectReport(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->find($request->input('id'));

        if (!$localVision) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $rejectLocalVision = $projectService->rejectReport($localVision);

            $responseBuilder->setSuccessMessage(__('messages.rejected'));
            $responseBuilder->setData('visit_date', $rejectLocalVision);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function saveCommentLocalVision(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->find($request->input('id'));

        if (!$localVision) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVisionHandler = new LocalVisionHandler($request);

        $parameters = $localVisionHandler->getCommentParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {
            $addCommentLocalVision = $projectService->addCommentLocalVision($parameters, $localVision);

            $responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $responseBuilder->setData('local_vision', $addCommentLocalVision);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();

    }

    /**
     * @param int $id
     * @param ChallengeService $challengeService
     * @param ChallengeRepository $challengeRepository
     * @return JsonResponse
     */
    public function getTechnicalDetails(int $id, ChallengeService $challengeService, ChallengeRepository $challengeRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();
        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $details = $challengeService->getTechnicalDetailsByChallengeId($id);

        if (!$details) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $responseBuilder->setData('old_technical', $details[0]);
            $responseBuilder->setData('new_technical', $details[1]);

        } catch(QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
       ;

        return $responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param ChallengeService $challengeService
     * @param ChallengeRepository $challengeRepository
     * @return JsonResponse
     */
    public function getFinancialDetails(int $id, ChallengeService $challengeService, ChallengeRepository $challengeRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $details = $challengeService->getFinancialDetailsByChallengeId($id);

        if (!$details) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $responseBuilder->setData('old_financial', $details[0]);
            $responseBuilder->setData('new_financial', $details[1]);

        } catch(QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }


        return $responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param SolutionRepository $solutionRepository
     * @param ChallengeRepository $challengeRepository
     * @param ProjectRepository $projectRepository
     * @return JsonResponse
     */
    public function getProjectSolution(int $id, SolutionRepository $solutionRepository, ChallengeRepository $challengeRepository, ProjectRepository $projectRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->getProjectByChallengeId($challenge->id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $solution = $solutionRepository->getSolutionWithFiles($challenge->solution_project_id);

        if (!$solution) {
            $responseBuilder->setErrorMessage(__('messages.solution.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $responseBuilder->setData('solution', $solution);

        return $responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param UserRepository $userRepository
     * @param ChallengeRepository $challengeRepository
     * @param SolutionRepository $solutionRepository
     * @return JsonResponse
     */
    public function getInvestorAndIntegrator(int $id, UserRepository $userRepository, ChallengeRepository $challengeRepository, SolutionRepository $solutionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $investor = $userRepository->getUserWithCompanies($challenge->author_id);

        if (!$investor) {
            $responseBuilder->setErrorMessage(__('messages.user.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $solution = $solutionRepository->find($challenge->solution_project_id);

        if (!$solution) {
            $responseBuilder->setErrorMessage(__('messages.solution.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $integrator = $userRepository->getUserWithCompanies($solution->author_id);

        if (!$integrator) {
            $responseBuilder->setErrorMessage(__('messages.user.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $responseBuilder->setData('investor', $investor);
        $responseBuilder->setData('integrator', $integrator);

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function saveMembersVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDateHandler = new VisitDateHandler($request);

        $parameters = $visitDateHandler->getMembersParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {

            $addMembersVisitDate = $projectService->addMembersVisitDate($parameters, $visitDate);

            $responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $responseBuilder->setData('visit_date', $addMembersVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();

    }

    /**
     * @param Request $request
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function saveVisitDate(Request $request, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $visitDateHandler = new VisitDateHandler($request);

        $parameters = $visitDateHandler->getParameters();

        if (!$parameters->isValid()) {
            $responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        try {

            $newVisitDate = $projectService->addVisitDate($parameters);

            $responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $responseBuilder->setData('visit_date', $newVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @return JsonResponse
     */
    public function getVisitDate(int $id, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $deadlines = $visitDateRepository->getAllVisitDateByProjectId($id);

        $responseBuilder->setData('deadlines', $deadlines);

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function acceptVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $acceptVisitDate = $projectService->acceptVisitDate($visitDate);

            $responseBuilder->setSuccessMessage(__('messages.project.accepted'));
            $responseBuilder->setData('visit_date', $acceptVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function rejectVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $rejectVisitDate = $projectService->rejectVisitDate($visitDate);

            $responseBuilder->setSuccessMessage(__('messages.rejected'));
            $responseBuilder->setData('visit_date', $rejectVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function cancelVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.canceled'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $cancelVisitDate = $projectService->cancelVisitDate($visitDate);

            $responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $responseBuilder->setData('visit_date', $cancelVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function deleteVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository, ProjectService $projectService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $projectService->deleteVisitDate($visitDate);

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
     * @param ChallengeRepository $challengeRepository
     * @param ProjectRepository $projectRepository
     * @param OfferRepository $offerRepository
     * @return JsonResponse
     */
    public function getOffersProject(Request $request, int $id, ChallengeRepository $challengeRepository, ProjectRepository $projectRepository, OfferRepository $offerRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $old_offer = $offerRepository->getSelectedOfferByChallenge($challenge);

        if (!$old_offer) {
            $responseBuilder->setErrorMessage(__('messages.offer.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        try {

            $new_offer = null;
            if ($project->selected_offer_id > 0) {
                $new_offer = $offerRepository->getSelectedOfferByProject($project);
            }

            $responseBuilder->setData('old_offer', $old_offer);
            $responseBuilder->setData('new_offer', $new_offer);
        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ChallengeRepository $challengeRepository
     * @param ProjectRepository $projectRepository
     * @param OfferRepository $offerRepository
     * @return JsonResponse
     */
    public function getOffersProjectIntegrator(Request $request, int $id, ChallengeRepository $challengeRepository, ProjectRepository $projectRepository, OfferRepository $offerRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $offers = $offerRepository->getProjectOffers($project,$challenge->selected_offer_id);
            $old_offer = $offerRepository->getSelectedOfferByChallenge($challenge);

            $responseBuilder->setData('offers', $offers);
            $responseBuilder->setData('old_offer', $old_offer);
        } catch (QueryException $e) {
            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $responseBuilder->getResponse();
    }

}
