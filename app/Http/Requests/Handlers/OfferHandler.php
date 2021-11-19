<?php

namespace App\Http\Requests\Handlers;

use App\Parameters\NewOfferParameters;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class OfferHandler extends RequestHandler
{
    /**
     * @return NewOfferParameters
     */
    public function getParameters(): NewOfferParameters
    {
        $parameters = new NewOfferParameters();
        $parameters->installerId = Auth::user()->id;
        $parameters->offerId = $this->request->get('offer_id');
        $parameters->projectId = $this->request->get('project_id');
        $parameters->challengeId = $this->request->get('challenge_id');
        $parameters->solutionId = $this->request->get('solution_id');
        $parameters->priceOfDelivery = $this->request->get('price_of_delivery');
        $parameters->weeksToStart = $this->request->get('weeks_to_start');
        $parameters->timeToStart = $this->request->get('time_to_start');
        $parameters->timeToFix = $this->request->get('time_to_fix');
        $parameters->advanceUponStart = $this->request->get('advance_upon_start');
        $parameters->advanceUponDelivery = $this->request->get('advance_upon_delivery');
        $parameters->advanceUponAgreement = $this->request->get('advance_upon_agreement');
        $parameters->yearsOfGuarantee = $this->request->get('years_of_guarantee');
        $parameters->maintenanceFrequency = $this->request->get('maintenance_frequency');
        $parameters->priceOfMaintenance = $this->request->get('price_of_maintenance');
        $parameters->reactionTime = $this->request->get('reaction_time');
        $parameters->interventionPrice = $this->request->get('intervention_price');
        $parameters->workHourPrice = $this->request->get('work_hour_price');
        $parameters->periodOfSupport = $this->request->get('period_of_support');
        $parameters->offerExpiresIn = $this->request->get('offer_expires_in');
        $parameters->solutionRobots = $this->request->get('solution_robots');

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
