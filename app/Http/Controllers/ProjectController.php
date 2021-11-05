<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\FinancialHandler;
use App\Http\Requests\Handlers\LocalVisionHandler;
use App\Http\Requests\Handlers\ProjectFilesHandler;
use App\Http\Requests\Handlers\TechnicalDetailsHandler;
use App\Http\Requests\Handlers\VisitDateHandler;
use App\Repository\Eloquent\ChallengeRepository;
use App\Repository\Eloquent\FileRepository;
use App\Repository\Eloquent\LocalVisionRepository;
use App\Repository\Eloquent\OfferRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\SolutionRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\VisitDateRepository;
use App\Services\ChallengeService;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{

    /**
     * @param int $id
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param FileRepository $fileRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function deleteFile(int $id, Request $request, ProjectRepository $projectRepository, FileRepository $fileRepository, ProjectService $projectService): JsonResponse
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $file = $fileRepository->find($request->input('file_id'));

        if (!$file) {
            $this->responseBuilder->setErrorMessage(__('messages.file.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectService->detachFile($project, $file);
        $this->responseBuilder->setSuccessMessage(__('messages.delete_correct'));


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function saveFiles(Request $request, int $id, ProjectRepository $projectRepository, ProjectService $projectService): JsonResponse
    {
        $projectFilesHandler = new ProjectFilesHandler($request);

        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $projectFilesHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        $newProjectFiles = $projectService->addProjectFiles($parameters, $project);

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('project', $newProjectFiles->with('files'));


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param FileRepository $fileRepository
     * @return JsonResponse
     */
    public function getFiles(ProjectRepository $projectRepository, int $id, FileRepository $fileRepository): JsonResponse
    {

        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectFiles = $fileRepository->getFilesByProject($project);

        if (!$projectFiles) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setData('projectFiles', $projectFiles);

        return $this->responseBuilder->getResponse();
    }

    /**
     * @param ChallengeRepository $challengeRepository
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @return JsonResponse
     */
    public function getProjectCard(ChallengeRepository $challengeRepository, ProjectRepository $projectRepository, int $id): JsonResponse
    {

        $challenge = $challengeRepository->getFullChallengeById($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->getProjectByChallengeId($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setData('challenge', $challenge);
        $this->responseBuilder->setData('project', $project);

        return $this->responseBuilder->getResponse();
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

        $localVisionHandler = new LocalVisionHandler($request);

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $parameters = $localVisionHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if ($parameters->reportId > 0) {

            $localVision = $localVisionRepository->find($parameters->reportId);

            if (!$localVision) {
                $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
                return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
            }

            $updateLocalVision = $projectService->updateLocalVision($parameters, $localVision);

            $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $this->responseBuilder->setData('local_vision', $updateLocalVision);

        } else {
            $newLocalVision = $projectService->addLocalVision($parameters);

            $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $this->responseBuilder->setData('local_vision', $newLocalVision);

        }


        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $reports = $localVisionRepository->getAllLocalVisionsByProjectId($id);

        $check = $projectService->checkLocalVision($id);

        $this->responseBuilder->setData('reports', $reports);
        $this->responseBuilder->setData('check', $check);

        return $this->responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalVisionRepository $localVisionRepository
     * @return JsonResponse
     */
    public function deleteReport(Request $request, ProjectRepository $projectRepository, LocalVisionRepository $localVisionRepository, ProjectService $projectService): JsonResponse
    {


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->find($request->input('id'));

        if (!$localVision) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectService->deleteReport($localVision);

        $this->responseBuilder->setSuccessMessage(__('messages.delete_correct'));

        return $this->responseBuilder->getResponse();
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


        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $financialHandler = new FinancialHandler($request);

        $parameters = $financialHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }


        $newFinancial = $projectService->addFinancialDetails($parameters);

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('new_technical', $newFinancial);

        return $this->responseBuilder->getResponse();
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


        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $technicalDetailsHandler = new TechnicalDetailsHandler($request);

        $parameters = $technicalDetailsHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        $newTechnicalDetails = $projectService->addTechnicalDetails($parameters);

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));


        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerRepository->find($request->input('new_offer_id'));

        if (!$offer) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectService->acceptOffer($project, $offer);

        $this->responseBuilder->setSuccessMessage(__('messages.accepted'));
        $this->responseBuilder->setData('project', $project);

        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerRepository->find($request->input('new_offer_id'));

        if (!$offer) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $feedback = $request->input('feedback');

        $projectService->rejectOffer($project, $offer, $feedback);

        $this->responseBuilder->setSuccessMessage(__('messages.rejected'));
        $this->responseBuilder->setData('project', $project);


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function acceptTechnicalDetails(ProjectRepository $projectRepository, int $id, ProjectService $projectService): JsonResponse
    {


        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectService->acceptTechnicalDetails($project);

        $this->responseBuilder->setSuccessMessage(__('messages.accepted'));
        $this->responseBuilder->setData('project', $project);


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function rejectTechnicalDetails(ProjectRepository $projectRepository, int $id, ProjectService $projectService): JsonResponse
    {


        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectService->rejectTechnicalDetails($project);

        $this->responseBuilder->setSuccessMessage(__('messages.rejected'));
        $this->responseBuilder->setData('project', $project);


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function acceptFinancialDetails(ProjectRepository $projectRepository, int $id, ProjectService $projectService): JsonResponse
    {


        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $projectService->acceptFinancialDetails($project);

        $this->responseBuilder->setSuccessMessage(__('messages.accepted'));
        $this->responseBuilder->setData('project', $project);


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param int $id
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function rejectFinancialDetails(ProjectRepository $projectRepository, int $id, ProjectService $projectService): JsonResponse
    {


        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $projectService->rejectFinancialDetails($project);

        $this->responseBuilder->setSuccessMessage(__('messages.rejected'));
        $this->responseBuilder->setData('project', $project);


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function endLocalVision(Request $request, ProjectRepository $projectRepository, ProjectService $projectService): JsonResponse
    {


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $projectService->endLocalVision($project);

        $this->responseBuilder->setData('visit_date', $project);


        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->find($request->input('id'));

        if (!$localVision) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $acceptLocalVision = $projectService->acceptReport($localVision);

        $this->responseBuilder->setSuccessMessage(__('messages.accepted'));
        $this->responseBuilder->setData('visit_date', $acceptLocalVision);


        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->find($request->input('id'));

        if (!$localVision) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $rejectLocalVision = $projectService->rejectReport($localVision);

        $this->responseBuilder->setSuccessMessage(__('messages.rejected'));
        $this->responseBuilder->setData('visit_date', $rejectLocalVision);


        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVision = $localVisionRepository->find($request->input('id'));

        if (!$localVision) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $localVisionHandler = new LocalVisionHandler($request);

        $parameters = $localVisionHandler->getCommentParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }


        $addCommentLocalVision = $projectService->addCommentLocalVision($parameters, $localVision);

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('local_vision', $addCommentLocalVision);

        return $this->responseBuilder->getResponse();

    }

    /**
     * @param int $id
     * @param ChallengeService $challengeService
     * @param ChallengeRepository $challengeRepository
     * @return JsonResponse
     */
    public function getTechnicalDetails(int $id, ChallengeService $challengeService, ChallengeRepository $challengeRepository): JsonResponse
    {

        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $details = $challengeService->getTechnicalDetailsByChallengeId($id);

        if (!$details) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $this->responseBuilder->setData('old_technical', $details[0]);
        $this->responseBuilder->setData('new_technical', $details[1]);


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param ChallengeService $challengeService
     * @param ChallengeRepository $challengeRepository
     * @return JsonResponse
     */
    public function getFinancialDetails(int $id, ChallengeService $challengeService, ChallengeRepository $challengeRepository): JsonResponse
    {


        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $details = $challengeService->getFinancialDetailsByChallengeId($id);

        if (!$details) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $this->responseBuilder->setData('old_financial', $details[0]);
        $this->responseBuilder->setData('new_financial', $details[1]);


        return $this->responseBuilder->getResponse();
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


        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->getProjectByChallengeId($challenge->id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $solution = $solutionRepository->getSolutionWithFiles($challenge->solution_project_id);

        if (!$solution) {
            $this->responseBuilder->setErrorMessage(__('messages.solution.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setData('solution', $solution);

        return $this->responseBuilder->getResponse();
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


        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $investor = $userRepository->getUserWithCompanies($challenge->author_id);

        if (!$investor) {
            $this->responseBuilder->setErrorMessage(__('messages.user.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $solution = $solutionRepository->find($challenge->solution_project_id);

        if (!$solution) {
            $this->responseBuilder->setErrorMessage(__('messages.solution.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $integrator = $userRepository->getUserWithCompanies($solution->author_id);

        if (!$integrator) {
            $this->responseBuilder->setErrorMessage(__('messages.user.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setData('investor', $investor);
        $this->responseBuilder->setData('integrator', $integrator);

        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDateHandler = new VisitDateHandler($request);

        $parameters = $visitDateHandler->getMembersParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }


        $addMembersVisitDate = $projectService->addMembersVisitDate($parameters, $visitDate);

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('visit_date', $addMembersVisitDate);


        return $this->responseBuilder->getResponse();

    }

    /**
     * @param Request $request
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function saveVisitDate(Request $request, ProjectService $projectService): JsonResponse
    {


        $visitDateHandler = new VisitDateHandler($request);

        $parameters = $visitDateHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }


        $newVisitDate = $projectService->addVisitDate($parameters);

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('visit_date', $newVisitDate);


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @param VisitDateRepository $visitDateRepository
     * @return JsonResponse
     */
    public function getVisitDate(int $id, ProjectRepository $projectRepository, VisitDateRepository $visitDateRepository): JsonResponse
    {


        $project = $projectRepository->find($id);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $deadlines = $visitDateRepository->getAllVisitDateByProjectId($id);

        $this->responseBuilder->setData('deadlines', $deadlines);

        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $acceptVisitDate = $projectService->acceptVisitDate($visitDate);

        $this->responseBuilder->setSuccessMessage(__('messages.project.accepted'));
        $this->responseBuilder->setData('visit_date', $acceptVisitDate);


        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $rejectVisitDate = $projectService->rejectVisitDate($visitDate);

        $this->responseBuilder->setSuccessMessage(__('messages.rejected'));
        $this->responseBuilder->setData('visit_date', $rejectVisitDate);

        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $this->responseBuilder->setErrorMessage(__('messages.canceled'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $cancelVisitDate = $projectService->cancelVisitDate($visitDate);

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('visit_date', $cancelVisitDate);

        return $this->responseBuilder->getResponse();
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


        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $visitDate = $visitDateRepository->find($request->input('id'));

        if (!$visitDate) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $projectService->deleteVisitDate($visitDate);

        $this->responseBuilder->setSuccessMessage(__('messages.delete_correct'));

        return $this->responseBuilder->getResponse();
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


        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $old_offer = $offerRepository->getSelectedOfferByChallenge($challenge);

        if (!$old_offer) {
            $this->responseBuilder->setErrorMessage(__('messages.offer.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }


        $new_offer = null;
        if ($project->selected_offer_id > 0) {
            $new_offer = $offerRepository->getSelectedOfferByProject($project);
        }

        $this->responseBuilder->setData('old_offer', $old_offer);
        $this->responseBuilder->setData('new_offer', $new_offer);

        return $this->responseBuilder->getResponse();
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


        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offers = $offerRepository->getProjectOffers($project, $challenge->selected_offer_id);
        $old_offer = $offerRepository->getSelectedOfferByChallenge($challenge);

        $this->responseBuilder->setData('offers', $offers);
        $this->responseBuilder->setData('old_offer', $old_offer);


        return $this->responseBuilder->getResponse();
    }

}
