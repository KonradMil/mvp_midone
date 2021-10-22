<?php

namespace App\Services;

use App\Models\File;
use App\Models\ProjectConcept;
use App\Parameters\NewProjectConceptParameters;
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

    public function __construct(ProjectConceptRepository $projectConceptRepository)
    {
        $this->projectConceptRepository = $projectConceptRepository;
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
}
