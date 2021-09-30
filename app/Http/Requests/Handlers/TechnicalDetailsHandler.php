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
        $parameters->challengeId = (int)$this->request->route()->parameter('challenge_id');
        $parameters->detailWeight = $this->request->get('detail_weight');
        $parameters->pickQuality = $this->request->get('pick_quality');
        $parameters->detailMaterial = $this->request->get('detail_material');
        $parameters->detailSize = $this->request->get('detail_size');
        $parameters->detailPick = $this->request->get('detail_pick');
        $parameters->detailPosition = $this->request->get('detail_position');
        $parameters->detailRange = $this->request->get('detail_range');
        $parameters->detailDestination = $this->request->get('detail_destination');
        $parameters->numberOfLines = $this->request->get('number_of_lines');
        $parameters->workShifts = $this->request->get('work_shifts');

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
