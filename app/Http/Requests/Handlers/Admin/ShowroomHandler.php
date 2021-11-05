<?php

namespace App\Http\Requests\Handlers\Admin;

use App\Http\Requests\Handlers\RequestHandler;
use App\Parameters\Admin\ShowroomParameters;

/**
 *
 */
class ShowroomHandler extends RequestHandler
{

    /**
     * @return ShowroomParameters
     */
    public function getParameters(): ShowroomParameters
    {
        $parameters = new ShowroomParameters();
        $parameters->name = $this->request->get('name');
        $parameters->custom_css = $this->request->get('custom_css');
        $parameters->challenge_id = $this->request->get('challenge_id');

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
