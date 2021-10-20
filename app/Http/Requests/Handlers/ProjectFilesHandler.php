<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewProjectFilesParameters;

/**
 *
 */
class ProjectFilesHandler extends RequestHandler
{

    /**
     * @return NewProjectFilesParameters
     */
    public function getParameters(): NewProjectFilesParameters
    {
        $parameters = new NewProjectFilesParameters();
        $parameters->projectFiles = $this->request->get('projectFiles');

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
