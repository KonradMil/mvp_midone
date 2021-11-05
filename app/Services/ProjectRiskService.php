<?php

namespace App\Services;

use App\Models\Financial;
use App\Models\LocalVision;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectRisk;
use App\Models\TechnicalDetails;
use App\Models\VisitDate;
use App\Parameters\NewFinancialParameters;
use App\Parameters\NewLocalVisionCommentParameters;
use App\Parameters\NewLocalVisionParameters;
use App\Parameters\NewProjectRiskParameters;
use App\Parameters\NewTechnicalDetailsParameters;
use App\Parameters\NewVisitDateMembersParameters;
use App\Parameters\NewVisitDateParameters;
use App\Repository\Eloquent\ChallengeRepository;
use App\Repository\Eloquent\FinancialRepository;
use App\Repository\Eloquent\LocalVisionRepository;
use App\Repository\Eloquent\OfferRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\ProjectRiskRepository;
use App\Repository\Eloquent\TechnicalDetailsRepository;
use App\Repository\Eloquent\VisitDateRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 *
 */
class ProjectRiskService
{
    /**
     * @var ProjectRiskRepository
     */
    private ProjectRiskRepository $projectRiskRepository;

    public function __construct(ProjectRiskRepository $projectRiskRepository)
    {
        $this->projectRiskRepository = $projectRiskRepository;
    }

    /**
     * @param NewProjectRiskParameters $newProjectRiskParameters
     * @return Model
     */
    public function addRisk(NewProjectRiskParameters $newProjectRiskParameters): Model
    {

        $projectRiskParams = [
            'author_id' => Auth::user()->id,
            'project_id' => $newProjectRiskParameters->projectId,
            'risk_description' => $newProjectRiskParameters->riskDescription,
            'risk_area' => $newProjectRiskParameters->riskArea,
            'event_probability' => $newProjectRiskParameters->eventProbability,
            'cost_impact' => $newProjectRiskParameters->costImpact,
            'schedule_impact' => $newProjectRiskParameters->scheduleImpact,
            'quality_implementation_impact' => $newProjectRiskParameters->qualityImplementationImpact,
            'risk_limitations' => $newProjectRiskParameters->riskLimitations,
            'comment_integrator' => $newProjectRiskParameters->commentIntegrator,
            'comment_investor' => $newProjectRiskParameters->commentInvestor,
        ];

        $projectRisk = $this->projectRiskRepository->create($projectRiskParams);

        return $projectRisk;
    }

    /**
     * @param ProjectRisk $projectRisk
     */
    public function deleteProjectRisk(ProjectRisk $projectRisk)
    {
        $projectRisk->delete();
    }

    /**
     * @param NewProjectRiskParameters $newProjectRiskParameters
     * @param ProjectRisk $projectRisk
     * @return Model
     */
    public function updateProjectRisk(NewProjectRiskParameters $newProjectRiskParameters, ProjectRisk $projectRisk): Model
    {
        $projectRisk->risk_description = $newProjectRiskParameters->riskDescription;
        $projectRisk->risk_area = $newProjectRiskParameters->riskArea;
        $projectRisk->event_probability = $newProjectRiskParameters->eventProbability;
        $projectRisk->cost_impact = $newProjectRiskParameters->costImpact;
        $projectRisk->schedule_impact = $newProjectRiskParameters->scheduleImpact;
        $projectRisk->quality_implementation_impact = $newProjectRiskParameters->qualityImplementationImpact;
        $projectRisk->risk_limitations = $newProjectRiskParameters->riskLimitations;
        $projectRisk->comment_integrator = $newProjectRiskParameters->commentIntegrator;
        $projectRisk->comment_investor = $newProjectRiskParameters->commentInvestor;

        $projectRisk->save();

        return $projectRisk;
    }
}
