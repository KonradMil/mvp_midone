<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewProjectRiskParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class ProjectRiskHandler extends RequestHandler
{

    /**
     * @return NewProjectRiskParameters
     */
    public function getParameters(): NewProjectRiskParameters
    {
        $parameters = new NewProjectRiskParameters();
        $parameters->authorId = Auth::user()->id;
        $parameters->projectId = (int)$this->request->route()->parameter('project_id');
        $parameters->riskId = $this->request->get('riskId');
        $parameters->riskDescription = $this->request->get('riskDescription');
        $parameters->riskArea = $this->request->get('riskArea');
        $parameters->eventProbability = $this->request->get('eventProbability');
        $parameters->costImpact = $this->request->get('costImpact');
        $parameters->scheduleImpact = $this->request->get('scheduleImpact');
        $parameters->qualityImplementationImpact = $this->request->get('qualityImplementationImpact');
        $parameters->riskLimitations = $this->request->get('riskLimitations');
        $parameters->commentIntegrator = $this->request->get('commentIntegrator');
        $parameters->commentInvestor = $this->request->get('commentInvestor');

        return $parameters;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
