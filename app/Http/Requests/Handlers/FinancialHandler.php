<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewFinancialParameters;

/**
 *
 */
class FinancialHandler extends RequestHandler
{

    /**
     * @return NewFinancialParameters
     */
    public function getParameters(): NewFinancialParameters
    {
        $parameters = new NewFinancialParameters();
        $parameters->challengeId = (int)$this->request->route()->parameter('challenge_id');
        $parameters->days = $this->request->get('days');
        $parameters->shifts = $this->request->get('shifts');
        $parameters->shiftTime = $this->request->get('shift_time');
        $parameters->weekendShift = $this->request->get('weekend_shift');
        $parameters->breakfast= $this->request->get('breakfast');
        $parameters->stopTime = $this->request->get('stop_time');
        $parameters->operatorPerformance = $this->request->get('operator_performance');
        $parameters->defective = $this->request->get('defective');
        $parameters->numberOfOperators = $this->request->get('number_of_operators');
        $parameters->operatorCost = $this->request->get('operator_cost');
        $parameters->absence = $this->request->get('absence');
        $parameters->cycleTime = $this->request->get('cycle_time');

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
