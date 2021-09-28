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
        $parameters->challenge_id = (int)$this->request->route()->parameter('challenge_id');
        $parameters->days = $this->request->get('days');
        $parameters->shifts = $this->request->get('shifts');
        $parameters->shift_time = $this->request->get('shift_time');
        $parameters->weekend_shift = $this->request->get('weekend_shift');
        $parameters->breakfast= $this->request->get('breakfast');
        $parameters->stop_time = $this->request->get('stop_time');
        $parameters->operator_performance = $this->request->get('operator_performance');
        $parameters->defective = $this->request->get('defective');
        $parameters->number_of_operators = $this->request->get('number_of_operators');
        $parameters->operator_cost = $this->request->get('operator_cost');
        $parameters->absence = $this->request->get('absence');
        $parameters->cycle_time = $this->request->get('cycle_time');

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
