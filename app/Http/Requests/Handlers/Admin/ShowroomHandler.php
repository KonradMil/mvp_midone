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
        $showroom = $this->request->get('showroom');
        $parameters->name = $showroom['name'];
        $parameters->description = $showroom['description'];
        $parameters->custom_css = $showroom['custom_css'];
        $parameters->custom_functions = json_encode($showroom['custom_functions']);
        $parameters->organization = $showroom['organization'];
        $parameters->dominant_color = $showroom['dominantColor'] ?? '';
        $parameters->organization_logo = $showroom['organization_logo'] ?? '';
        $parameters->challenge_id = $showroom['challenge_id'];

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
