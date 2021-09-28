<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewTechnicalDetailsParameters;

/**
 *
 */
class TechnicalDetailsHandler extends RequestHandler
{

    /**
     * @return NewTechnicalDetailsParameters
     */
    public function getParameters(): NewTechnicalDetailsParameters
    {
        $parameters = new NewTechnicalDetailsParameters();
        $parameters->challenge_id = (int)$this->request->route()->parameter('challenge_id');
        $parameters->detail_weight = $this->request->get('detail_weight');
        $parameters->pick_quality = $this->request->get('pick_quality');
        $parameters->detail_material = $this->request->get('detail_material');
        $parameters->detail_size = $this->request->get('detail_size');
        $parameters->detail_pick = $this->request->get('detail_pick');
        $parameters->detail_position = $this->request->get('detail_position');
        $parameters->detail_range = $this->request->get('detail_range');
        $parameters->detail_destination = $this->request->get('detail_destination');
        $parameters->number_of_lines = $this->request->get('number_of_lines');
        $parameters->work_shifts = $this->request->get('work_shifts');

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
