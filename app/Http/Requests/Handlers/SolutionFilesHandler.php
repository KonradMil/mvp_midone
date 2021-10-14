<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewSolutionFilesParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class SolutionFilesHandler extends RequestHandler
{

    /**
     * @return NewSolutionFilesParameters
     */
    public function getParameters(): NewSolutionFilesParameters
    {
        $parameters = new NewSolutionFilesParameters();
        $parameters->solutionFiles = $this->request->get('solutionFiles');

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
