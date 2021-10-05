<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewVisitDateMembersParameters;
use App\Parameters\NewVisitDateParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class VisitDateHandler extends RequestHandler
{

    /**
     * @return NewVisitDateParameters
     */
    public function getParameters(): NewVisitDateParameters
    {
        $parameters = new NewVisitDateParameters();
        $parameters->authorId = Auth::user()->id;
        $parameters->projectId = (int)$this->request->route()->parameter('project_id');
        $parameters->date = $this->request->get('date');
        $parameters->time = $this->request->get('time');

        return $parameters;
    }

    /**
     * @return NewVisitDateMembersParameters
     */
    public function getMembersParameters(): NewVisitDateMembersParameters
    {
        $parameters = new NewVisitDateMembersParameters();
        $parameters->members = $this->request->get('members');

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
