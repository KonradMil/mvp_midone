<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewLocalVisionCommentParameters;
use App\Parameters\NewLocalVisionParameters;
use App\Parameters\NewProjectCommunicationParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class ProjectCommunicationHandler extends RequestHandler
{

    /**
     * @return NewProjectCommunicationParameters
     */
    public function getParameters(): NewProjectCommunicationParameters
    {
        $parameters = new NewProjectCommunicationParameters();
        $parameters->authorId = Auth::user()->id;
        $parameters->projectId = (int)$this->request->route()->parameter('project_id');
        $parameters->communicationPlanId = $this->request->get('communication_plan_id');
        $parameters->personalOccupation = $this->request->get('personal_occupation');
        $parameters->personalData = $this->request->get('personal_data');
        $parameters->phoneNumber = $this->request->get('phone_number');
        $parameters->email = $this->request->get('email');
        $parameters->project_decision = $this->request->get('project_decision');

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
