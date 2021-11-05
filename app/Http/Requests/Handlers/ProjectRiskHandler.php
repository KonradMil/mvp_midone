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
        $parameters->projectId = $this->request->get('project_id');
        $parameters->riskId = $this->request->get('risk_id');
        $parameters->riskDescription = $this->request->get('risk_description');
        $parameters->riskArea = $this->request->get('risk_area');
        $parameters->eventProbability = $this->request->get('event_probability');
        $parameters->costImpact = $this->request->get('cost_impact');
        $parameters->scheduleImpact = $this->request->get('schedule_impact');
        $parameters->qualityImplementationImpact = $this->request->get('quality_implementation_impact');
        $parameters->riskLimitations = $this->request->get('risk_limitations');
        $parameters->commentIntegrator = $this->request->get('comment_integrator');
        $parameters->commentInvestor = $this->request->get('comment_investor');

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
