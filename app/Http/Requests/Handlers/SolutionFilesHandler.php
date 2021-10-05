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
        $parameters->name = $this->request->get('name');
        $parameters->ext = $this->request->get('ext');
        $parameters->originalName = $this->request->get('original_name');
        $parameters->path = $this->request->get('path');
        $parameters->thumbnail = $this->request->get('thumbnail');
        $parameters->size = $this->request->get('size');
        $parameters->alt = $this->request->get('alt');

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
