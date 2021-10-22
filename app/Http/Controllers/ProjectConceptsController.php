<?php

namespace App\Http\Controllers;

use App\Http\Requests\Handlers\ProjectConceptHandler;
use App\Http\ResponseBuilder;
use App\Repository\Eloquent\FileRepository;
use App\Repository\Eloquent\ProjectConceptRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\UserRepository;
use App\Services\ProjectConceptService;
use App\Services\ProjectService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectConceptsController extends Controller
{
    /**
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectConceptService $projectConceptService
     * @param ProjectConceptRepository $projectConceptRepository
     * @return JsonResponse
     */
    public function saveConcept(Request $request, ProjectRepository $projectRepository, ProjectConceptService $projectConceptService, ProjectConceptRepository $projectConceptRepository): JsonResponse
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
     * @param ProjectRepository $projectRepository
     * @param ProjectConceptRepository $projectConceptRepository
     * @param ProjectConceptService $projectConceptService
     * @return JsonResponse
     */
    public function deleteConcept(Request $request, ProjectRepository $projectRepository, ProjectConceptRepository $projectConceptRepository, ProjectConceptService $projectConceptService): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($request->input('project_id'));

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $projectConcept = $projectConceptRepository->find($request->input('id'));

        if (!$projectConcept) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {

            $projectConceptService->deleteProjectConcept($projectConcept);

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
     * @param ProjectConceptRepository $projectConceptRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function getProjectConcepts(Request $request, int $id, ProjectRepository $projectRepository, ProjectConceptRepository $projectConceptRepository, UserRepository $userRepository): JsonResponse
    {
        $responseBuilder = new ResponseBuilder();

        $project = $projectRepository->find($id);

        if (!$project) {
            $responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $concepts = $projectConceptRepository->getAllProjectConceptsByProject($id);

        $responseBuilder->setData('concepts', $concepts);

        return $responseBuilder->getResponse();
    }

    /**
     * @param int $id
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param ProjectConceptRepository $projectConceptRepository
     * @param FileRepository $fileRepository
     * @param ProjectConceptService $projectConceptService
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile(int $id,Request $request, ProjectRepository $projectRepository, ProjectConceptRepository $projectConceptRepository, FileRepository $fileRepository, ProjectConceptService $projectConceptService): JsonResponse
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

        $file = $fileRepository->find($request->get('file_id'));

        if (!$file) {
            $responseBuilder->setErrorMessage(__('messages.file.not_found'));
            return $responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        try {
            $projectConceptService->detachFile($projectConcept, $file);
            $responseBuilder->setSuccessMessage(__('messages.delete_correct'));
        } catch (QueryException $e) {

            $responseBuilder->setErrorMessage(__('messages.error'));
            return $responseBuilder->getResponse(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return $responseBuilder->getResponse();
    }
}
