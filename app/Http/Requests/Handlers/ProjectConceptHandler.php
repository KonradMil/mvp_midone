<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewProjectConceptParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class ProjectConceptHandler extends RequestHandler
{

    /**
     * @return NewProjectConceptParameters
     */
    public function getParameters(): NewProjectConceptParameters
    {
        $parameters = new NewProjectConceptParameters();
        $parameters->authorId = Auth::user()->id;
        $parameters->projectId = (int)$this->request->route()->parameter('project_id');
        $parameters->conceptId = $this->request->get('project_concept_id');
        $parameters->title = $this->request->get('title');
        $parameters->description = $this->request->get('description');
        $parameters->files = $this->request->get('files');

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
