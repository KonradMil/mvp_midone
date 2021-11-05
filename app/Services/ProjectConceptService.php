<?php

namespace App\Services;

use App\Models\File;
use App\Models\ProjectConcept;
use App\Parameters\NewConceptAnswerParameters;
use App\Parameters\NewConceptQuestionParameters;
use App\Parameters\NewProjectConceptParameters;
use App\Repository\Eloquent\ConceptAnswerRepository;
use App\Repository\Eloquent\ConceptQuestionRepository;
use App\Repository\Eloquent\ProjectConceptRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 *
 */
class ProjectConceptService
{
    /**
     * @var ProjectConceptRepository
     */
    private ProjectConceptRepository $projectConceptRepository;

    /**
     * @var ConceptQuestionRepository
     */
    private ConceptQuestionRepository $conceptQuestionRepository;

    /**
     * @var ConceptAnswerRepository
     */
    private ConceptAnswerRepository $conceptAnswerRepository;


    public function __construct(ProjectConceptRepository $projectConceptRepository, ConceptQuestionRepository $conceptQuestionRepository, ConceptAnswerRepository $conceptAnswerRepository)
    {
        $this->projectConceptRepository = $projectConceptRepository;
        $this->conceptQuestionRepository = $conceptQuestionRepository;
        $this->conceptAnswerRepository = $conceptAnswerRepository;
    }

    /**
     * @param NewProjectConceptParameters $newProjectConceptParameters
     * @return Model
     */
    public function addConcept(NewProjectConceptParameters $newProjectConceptParameters): Model
    {
        $projectConceptParams = [
            'author_id' => Auth::user()->id,
            'project_id' => $newProjectConceptParameters->projectId,
            'title' => $newProjectConceptParameters->title,
            'description' => $newProjectConceptParameters->description,
        ];

        $projectConcept = $this->projectConceptRepository->create($projectConceptParams);

        $arrayFiles = $newProjectConceptParameters->files;
        $projectFiles = $projectConcept->files()->get();
        $arrayFilesId = [];

        if($projectFiles){
            foreach($projectFiles as $file) {
                $arrayFilesId[] = $file->id;
            }
        }

        foreach($arrayFiles as $arrayFile){
            $file = File::find($arrayFile['id']);

            if(!(in_array($arrayFile['id'], $arrayFilesId))){
                $projectConcept->files()->attach($file);
            }
            $projectConcept->files = $projectConcept->files()->get();
        }

        return $projectConcept;
    }

    /**
     * @param ProjectConcept $projectConcept
     */
    public function deleteProjectConcept(ProjectConcept $projectConcept)
    {
        $projectConcept->delete();
    }

    /**
     * @param NewProjectConceptParameters $newProjectConceptParameters
     * @param ProjectConcept $projectConcept
     * @return Model
     */
    public function updateProjectConcept(NewProjectConceptParameters $newProjectConceptParameters, ProjectConcept $projectConcept): Model
    {
        $projectConcept->title = $newProjectConceptParameters->title;
        $projectConcept->description = $newProjectConceptParameters->description;

        $arrayFiles = $newProjectConceptParameters->files;
        $projectFiles = $projectConcept->files()->get();
        $arrayFilesId = [];

        if($projectFiles){
            foreach($projectFiles as $file) {
                $arrayFilesId[] = $file->id;
            }
        }

        foreach($arrayFiles as $arrayFile){
            $file = File::find($arrayFile['id']);

            if(!(in_array($arrayFile['id'], $arrayFilesId))){
                $projectConcept->files()->attach($file);
            }
            $projectConcept->files = $projectConcept->files()->get();
        }
        $projectConcept->save();

        return $projectConcept;
    }

    /**
     *
     * @param ProjectConcept $projectConcept
     * @param File $file
     * @return mixed
     */
    public function detachFile(ProjectConcept $projectConcept, File $file)
    {
        $projectConcept->files()->detach($file);
    }

    /**
     * @param NewConceptQuestionParameters $newConceptQuestionParameters
     * @return Model
     */
    public function addQuestion(NewConceptQuestionParameters $newConceptQuestionParameters): Model
    {
        $conceptQuestionParams = [
            'author_id' => Auth::user()->id,
            'project_concept_id' => $newConceptQuestionParameters->conceptId,
            'question' => $newConceptQuestionParameters->question
        ];

        $conceptQuestion = $this->conceptQuestionRepository->create($conceptQuestionParams);

        return $conceptQuestion;
    }

    /**
     * @param NewConceptAnswerParameters $newConceptAnswerParameters
     * @return Model
     */
    public function addAnswer(NewConceptAnswerParameters $newConceptAnswerParameters): Model
    {
        $conceptAnswerParams = [
            'author_id' => Auth::user()->id,
            'concept_question_id' => $newConceptAnswerParameters->conceptQuestionId,
            'answer' => $newConceptAnswerParameters->answer
        ];

        $conceptAnswer = $this->conceptAnswerRepository->create($conceptAnswerParams);

        return $conceptAnswer;
//        $conceptQuestion->answer = $newConceptAnswerParameters->answer;

//        $conceptQuestion->save();

//        return $conceptQuestion;
    }

    /**
     * @param ProjectConcept $projectConcept
     * @return ProjectConcept
     */
    public function acceptProjectConcept(ProjectConcept $projectConcept): ProjectConcept
    {
        $projectConcept->accepted = 1;

        $projectConcept->save();

        return $projectConcept;
    }

    /**
     * @param ProjectConcept $projectConcept
     * @return ProjectConcept
     */
    public function rejectProjectConcept(ProjectConcept $projectConcept): ProjectConcept
    {
        $projectConcept->accepted = 2;

        $projectConcept->save();

        return $projectConcept;
    }
}
