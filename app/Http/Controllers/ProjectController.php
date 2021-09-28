<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\FinancialHandler;
use App\Http\Requests\Handlers\LocalVisionHandler;
use App\Http\Requests\Handlers\TechnicalDetailsHandler;
use App\Http\Requests\Handlers\VisitDateHandler;
use App\Http\ResponseBuilder;
use App\Models\Challenge;
use App\Models\LocalVision;
use App\Models\Project;
use App\Models\Solution;
use App\Models\TechnicalDetails;
use App\Models\User;
use App\Models\VisitDate;
use App\Repository\Eloquent\ChallengeRepository;
use App\Repository\Eloquent\LocalVisionRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\VisitDateRepository;
use App\Services\ChallengeService;
use App\Services\ProjectService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * @var ChallengeService
     */
    private ChallengeService $challengeService;

    /**
     * @var ProjectService
     */
    private ProjectService $projectService;

    /**
     * @var ProjectRepository
     */
    private ProjectRepository $projectRepository;

    /**
     * @var ChallengeRepository
     */
    private ChallengeRepository $challengeRepository;

    /**
     * @param ProjectService $projectService
     * @param ChallengeService $challengeService
     * @param ChallengeRepository $challengeRepository
     */
    public function __construct(ProjectService $projectService, ChallengeService $challengeService, ChallengeRepository $challengeRepository)
    {
        $this->projectService = $projectService;
        $this->challengeService = $challengeService;
        $this->challengeRepository = $challengeRepository;
    }

    /**
     * @param ChallengeService $challengeService
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @return JsonResponse
     */
    public function getProjectCard(ChallengeService $challengeService, ProjectRepository $projectRepository, int $id): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();
        $challenge = $challengeService->getChallengeById($id);

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
     * @return JsonResponse
     */
    public function saveLocalVision(Request $request, ProjectRepository $projectRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $localVisionHandler = new LocalVisionHandler($request);

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $localVisionHandler->getParameters();

        try {
            $newLocalVision = $this->projectService->addLocalVision($parameters);

            $responseBuilder->setSuccessMessage(__('messages.project.save_correct'));
            $responseBuilder->setData('local_vision', $newLocalVision);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @return JsonResponse
     */
    public function getLocalVision(int $id, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $reports = $localVisionRepository->getAllLocalVisionByProjectId($id);

        $check = $this->projectService->checkLocalVision($id);

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
    public function deleteReport(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->getLocalVisionById($request->input('id'));

        if (!$localVision) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var LocalVision $deleteLocalVision */
            $this->projectService->deleteReport($localVision);

            $responseBuilder->setSuccessMessage(__('messages.project.delete_correct'));

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ChallengeService $challengeService
     * @param int $id
     * @return JsonResponse
     */
    public function saveFinancialDetails(Request $request, ChallengeService $challengeService, int $id): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeService->getChallengeById($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $financialHandler = new FinancialHandler($request);

        $parameters = $financialHandler->getParameters();

        try {

            $newFinancial = $this->projectService->addFinancialDetails($parameters);

            $responseBuilder->setSuccessMessage(__('messages.project.save_correct'));
            $responseBuilder->setData('new_technical', $newFinancial);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }


        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ChallengeRepository $challengeRepository
     * @return JsonResponse
     */
    public function saveTechnicalDetails(Request $request, int $id, ChallengeRepository $challengeRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->getChallengeById($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $technicalDetailsHandler = new TechnicalDetailsHandler($request);

        $parameters = $technicalDetailsHandler->getParameters();

        try {

            $newTechnicalDetails = $this->projectService->addTechnicalDetails($parameters);

            $responseBuilder->setSuccessMessage(__('messages.project.save_correct'));
            $responseBuilder->setData('new_technical', $newTechnicalDetails);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @return JsonResponse
     */
    public function acceptOffer(Request $request, ProjectRepository $projectRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $projectRepository->getNewOfferProject($request->input('new_offer_id'));

        if (!$offer) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var TechnicalDetails $acceptTechnicalDetails */
            $this->projectService->acceptOffer($project, $offer);

            $responseBuilder->setSuccessMessage(__('messages.project.accepted'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @return JsonResponse
     */
    public function rejectOffer(Request $request, ProjectRepository $projectRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $projectRepository->getNewOfferProject($request->input('new_offer_id'));

        if (!$offer) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $feedback = $request->input('feedback');

        try {

            /** @var TechnicalDetails $acceptTechnicalDetails */
            $this->projectService->rejectOffer($project, $offer, $feedback);

            $responseBuilder->setSuccessMessage(__('messages.project.rejected'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @return JsonResponse
     */
    public function acceptTechnicalDetails(Request $request, ProjectRepository $projectRepository, int $id): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var TechnicalDetails $acceptTechnicalDetails */
            $this->projectService->acceptTechnicalDetails($project);

            $responseBuilder->setSuccessMessage(__('messages.project.accepted'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @return JsonResponse
     */
    public function rejectTechnicalDetails(Request $request, ProjectRepository $projectRepository, int $id): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var TechnicalDetails $acceptTechnicalDetails */
            $this->projectService->rejectTechnicalDetails($project);

            $responseBuilder->setSuccessMessage(__('messages.project.rejected'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @return JsonResponse
     */
    public function acceptFinancialDetails(ProjectRepository $projectRepository, int $id): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $this->projectService->acceptFinancialDetails($project);

            $responseBuilder->setSuccessMessage(__('messages.project.accepted'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @return JsonResponse
     */
    public function rejectFinancialDetails(Request $request, ProjectRepository $projectRepository, int $id): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $this->projectService->rejectFinancialDetails($project);

            $responseBuilder->setSuccessMessage(__('messages.project.rejected'));
            $responseBuilder->setData('project', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @return JsonResponse
     */
    public function endLocalVision(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var LocalVision $acceptLocalVision */
            $this->projectService->endLocalVision($project);

            $responseBuilder->setData('visit_date', $project);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @return JsonResponse
     */
    public function acceptReport(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->getLocalVisionById($request->input('id'));

        if (!$localVision) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var LocalVision $acceptLocalVision */
            $acceptLocalVision = $this->projectService->acceptReport($localVision);

            $responseBuilder->setSuccessMessage(__('messages.project.accepted'));
            $responseBuilder->setData('visit_date', $acceptLocalVision);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @return JsonResponse
     */
    public function rejectReport(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->getLocalVisionById($request->input('id'));

        if (!$localVision) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var LocalVision $rejectLocalVision */
            $rejectLocalVision = $this->projectService->rejectReport($localVision);

            $responseBuilder->setSuccessMessage(__('messages.project.rejected'));
            $responseBuilder->setData('visit_date', $rejectLocalVision);

        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @return JsonResponse
     */
    public function saveCommentVisitDate(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository,): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->getLocalVisionById($request->input('id'));

        if (!$localVision) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVisionHandler = new LocalVisionHandler($request);

        $parameters = $localVisionHandler->getCommentParameters();

        try {
            /** @var LocalVision $addCommentLocalVision */
            $addCommentLocalVision = $this->projectService->addCommentLocalVision($parameters, $localVision);

            $responseBuilder->setSuccessMessage(__('messages.project.save_correct'));
            $responseBuilder->setData('local_vision', $addCommentLocalVision);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();

    }

    /**
     * @param int $id
     * @param ChallengeService $challengeService
     * @return JsonResponse
     */
    public function getTechnicalDetails(int $id, ChallengeService $challengeService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();
        $challenge = $challengeService->getChallengeById($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $details = $challengeService->getTechnicalDetailsByChallengeId($id);

        if (!$details) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $responseBuilder->setData('old_technical', $details[0]);
        $responseBuilder->setData('new_technical', $details[1]);

        return $responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param ChallengeService $challengeService
     * @return JsonResponse
     */
    public function getFinancialDetails(int $id, ChallengeService $challengeService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();
        $challenge = $challengeService->getChallengeById($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $details = $challengeService->getFinancialDetailsByChallengeId($id);

        if (!$details) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $responseBuilder->setData('old_financial', $details[0]);
        $responseBuilder->setData('new_financial', $details[1]);

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProjectSolution(Request $request): JsonResponse
    {
        $solution = Solution::find($request->input('id'));

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'payload' => $solution,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getInvestorAndIntegrator(Request $request): JsonResponse
    {
        $challenge = Challenge::find($request->input('id'));
        $investor = User::with('companies')->find($challenge->author_id);
        $solution = Solution::find($challenge->solution_project_id);
        $integrator = User::with('companies')->find($solution->author_id);

        return response()->json([
            'success' => true,
            'message' => 'Zapisano poprawnie',
            'investor' => $investor,
            'integrator' => $integrator,
        ]);
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @return JsonResponse
     */
    public function saveMembersVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository,): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->getVisitDateById($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDateHandler = new VisitDateHandler($request);

        $parameters = $visitDateHandler->getMembersParameters();

        try {

            /** @var VisitDate $addMembersVisitDate */
            $addMembersVisitDate = $this->projectService->addMembersVisitDate($parameters, $visitDate);

            $responseBuilder->setSuccessMessage(__('messages.project.save_correct'));
            $responseBuilder->setData('visit_date', $addMembersVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveVisitDate(Request $request): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $visitDateHandler = new VisitDateHandler($request);

        $parameters = $visitDateHandler->getParameters();

        try {

            $newVisitDate = $this->projectService->addVisitDate($parameters);

            $responseBuilder->setSuccessMessage(__('messages.project.save_correct'));
            $responseBuilder->setData('visit_date', $newVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
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

        $project = $projectRepository->getProjectById($id);

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
     * @return JsonResponse
     */
    public function acceptVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->getVisitDateById($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var VisitDate $acceptVisitDate */
            $acceptVisitDate = $this->projectService->acceptVisitDate($visitDate);

            $responseBuilder->setSuccessMessage(__('messages.project.accepted'));
            $responseBuilder->setData('visit_date', $acceptVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @return JsonResponse
     */
    public function rejectVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->getVisitDateById($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var VisitDate $rejectVisitDate */
            $rejectVisitDate = $this->projectService->rejectVisitDate($visitDate);

            $responseBuilder->setSuccessMessage(__('messages.project.rejected'));
            $responseBuilder->setData('visit_date', $rejectVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @return JsonResponse
     */
    public function cancelVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->getVisitDateById($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.canceled'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var VisitDate $cancelVisitDate */
            $cancelVisitDate = $this->projectService->cancelVisitDate($visitDate);

            $responseBuilder->setSuccessMessage(__('messages.project.save_correct'));
            $responseBuilder->setData('visit_date', $cancelVisitDate);


        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @return JsonResponse
     */
    public function deleteVisitDate(Request $request, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->getVisitDateById($request->input('id'));

        if (!$visitDate) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            /** @var VisitDate $deleteVisitDate */
            $this->projectService->deleteVisitDate($visitDate);

            $responseBuilder->setSuccessMessage(__('messages.project.delete_correct'));
        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ChallengeRepository $challengeRepository
     * @param ProjectRepository $projectRepository
     * @return JsonResponse
     */
    public function getOffersProject(Request $request, int $id, ChallengeRepository $challengeRepository, ProjectRepository $projectRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->getChallengeById($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $old_offer = $challengeRepository->getSelectedOfferByChallenge($challenge);

            $new_offer = null;
            if ($project->selected_offer_id > 0) {
                $new_offer = $projectRepository->getSelectedOfferByProject($project);
            }

            $responseBuilder->setData('old_offer', $old_offer);
            $responseBuilder->setData('new_offer', $new_offer);
        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ChallengeRepository $challengeRepository
     * @param ProjectRepository $projectRepository
     * @return JsonResponse
     */
    public function getOffersProjectIntegrator(Request $request, int $id, ChallengeRepository $challengeRepository, ProjectRepository $projectRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $challenge = $challengeRepository->getChallengeById($id);

        if (!$challenge) {
            $responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->getProjectById($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $offers = $projectRepository->getProjectOffers($project);
            $old_offer = $challengeRepository->getSelectedOfferByChallenge($challenge);

            $responseBuilder->setData('offers', $offers);
            $responseBuilder->setData('old_offer', $old_offer);
        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage('Unexpected error occured!');
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $responseBuilder->getResponse();
    }
}
