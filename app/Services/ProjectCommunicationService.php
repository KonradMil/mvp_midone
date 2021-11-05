<?php

namespace App\Services;

use App\Models\Financial;
use App\Models\LocalVision;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectCommunication;
use App\Models\TechnicalDetails;
use App\Models\VisitDate;
use App\Parameters\NewFinancialParameters;
use App\Parameters\NewLocalVisionCommentParameters;
use App\Parameters\NewLocalVisionParameters;
use App\Parameters\NewProjectCommunicationParameters;
use App\Parameters\NewTechnicalDetailsParameters;
use App\Parameters\NewVisitDateMembersParameters;
use App\Repository\Eloquent\ProjectCommunicationRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 *
 */
class ProjectCommunicationService
{
    /**
     * @var ProjectCommunicationRepository
     */
    private ProjectCommunicationRepository $projectCommunicationRepository;

    public function __construct(ProjectCommunicationRepository $projectCommunicationRepository)
    {
        $this->projectCommunicationRepository = $projectCommunicationRepository;
    }

    /**
     * @param NewProjectCommunicationParameters $newProjectCommunicationParameters
     * @return Model
     */
    public function addCommunicationPlan(NewProjectCommunicationParameters $newProjectCommunicationParameters): Model
    {

        $projectCommunicationParams = [
            'author_id' => Auth::user()->id,
            'project_id' => $newProjectCommunicationParameters->projectId,
            'personal_occupation' => $newProjectCommunicationParameters->personalOccupation,
            'personal_data' => $newProjectCommunicationParameters->personalData,
            'phone_number' => $newProjectCommunicationParameters->phoneNumber,
            'email' => $newProjectCommunicationParameters->email,
            'project_decision' => $newProjectCommunicationParameters->projectDecision,
        ];

        $projectCommunication = $this->projectCommunicationRepository->create($projectCommunicationParams);

        return $projectCommunication;
    }

    /**
     * @param ProjectCommunication $projectCommunication
     */
    public function deleteProjectCommunication(ProjectCommunication $projectCommunication)
    {
        $projectCommunication->delete();
    }

    /**
     * @param NewProjectCommunicationParameters $newProjectCommunicationParameters
     * @param ProjectCommunication $projectCommunication
     * @return Model
     */
    public function updateProjectCommunication(NewProjectCommunicationParameters $newProjectCommunicationParameters, ProjectCommunication $projectCommunication): Model
    {
        $projectCommunication->personal_occupation = $newProjectCommunicationParameters->personalOccupation;
        $projectCommunication->personal_data = $newProjectCommunicationParameters->personalData;
        $projectCommunication->phone_number = $newProjectCommunicationParameters->phoneNumber;
        $projectCommunication->email = $newProjectCommunicationParameters->email;
        $projectCommunication->project_decision = $newProjectCommunicationParameters->projectDecision;

        $projectCommunication->save();

        return $projectCommunication;
    }

    /**
     * @param Project $project
     * @return Project
     */
    public function acceptProjectCommunication(Project $project): Project
    {
        if(Auth::user()->type === 'investor'){
            if($project->accept_communication == 1){
                $project->accept_communication = 3;
            } else {
                $project->accept_communication = 2;
            }
        } else if(Auth::user()->type === 'integrator'){
            if($project->accept_communication == 2){
                $project->accept_communication = 3;
            } else {
                $project->accept_communication = 1;
            }
        }

        $project->save();

        return $project;
    }
}
