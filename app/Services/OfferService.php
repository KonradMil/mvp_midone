<?php

namespace App\Services;

use App\Events\OfferAccepted;
use App\Events\OfferAdded;
use App\Events\OfferPublished;
use App\Events\OfferRejected;
use App\Models\Challenge;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Solution;
use App\Parameters\NewOfferParameters;
use App\Repository\Eloquent\OfferRepository;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class OfferService
{
    private OfferRepository $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @param NewOfferParameters $newOfferParameters
     * @param Project $project
     * @return Offer
     */
    public function addProjectOffer(NewOfferParameters $newOfferParameters, Project $project): Offer
    {
        $offerParams = [
            'installer_id' => $newOfferParameters->installerId,
            'challenge_id' => $newOfferParameters->challengeId,
            'solution_id' => $newOfferParameters->solutionId,
            'project_id' => $newOfferParameters->projectId,
            'price_of_delivery' => $newOfferParameters->priceOfDelivery,
            'weeks_to_start' => $newOfferParameters->weeksToStart,
            'time_to_start' => $newOfferParameters->timeToStart,
            'time_to_fix' => $newOfferParameters->timeToFix,
            'advance_upon_start' => $newOfferParameters->advanceUponStart,
            'advance_upon_delivery' => $newOfferParameters->advanceUponDelivery,
            'advance_upon_agreement' => $newOfferParameters->advanceUponAgreement,
            'years_of_guarantee' => $newOfferParameters->yearsOfGuarantee,
            'maintenance_frequency' => $newOfferParameters->maintenanceFrequency,
            'price_of_maintenance' => $newOfferParameters->priceOfMaintenance,
            'reaction_time' => $newOfferParameters->reactionTime,
            'intervention_price' => $newOfferParameters->interventionPrice,
            'work_hour_price' => $newOfferParameters->workHourPrice,
            'period_of_support' => $newOfferParameters->periodOfSupport,
            'offer_expires_in' => $newOfferParameters->offerExpiresIn,
            'solution_robots' => json_encode($newOfferParameters->solutionRobots),
        ];
        /** @var Offer $offer */

        $offer = $this->offerRepository->create($offerParams);

        $c = 0;
        $sum = 0;
        if (isset($newOfferParameters->solutionRobots)) {
            foreach ($newOfferParameters->solutionRobots as $robot) {
                $c++;
                $sum += $robot['guarantee_period'];
            }
        }
        if ($c > 0) {
            $offer->avg_guarantee = (float)($sum / $c);
        }

        $offer->save();
        $project->selected_offer_id = $offer->id;
        $project->save();

        return $offer;
    }

    /**
     * @param NewOfferParameters $newOfferParameters
     * @return Offer
     */
    public function addSolutionOffer(NewOfferParameters $newOfferParameters): Offer
    {
        $offerParams = [
            'installer_id' => $newOfferParameters->installerId,
            'challenge_id' => $newOfferParameters->challengeId,
            'solution_id' => $newOfferParameters->solutionId,
            'price_of_delivery' => $newOfferParameters->priceOfDelivery,
            'weeks_to_start' => $newOfferParameters->weeksToStart,
            'time_to_start' => $newOfferParameters->timeToStart,
            'time_to_fix' => $newOfferParameters->timeToFix,
            'advance_upon_start' => $newOfferParameters->advanceUponStart,
            'advance_upon_delivery' => $newOfferParameters->advanceUponDelivery,
            'advance_upon_agreement' => $newOfferParameters->advanceUponAgreement,
            'years_of_guarantee' => $newOfferParameters->yearsOfGuarantee,
            'maintenance_frequency' => $newOfferParameters->maintenanceFrequency,
            'price_of_maintenance' => $newOfferParameters->priceOfMaintenance,
            'reaction_time' => $newOfferParameters->reactionTime,
            'intervention_price' => $newOfferParameters->interventionPrice,
            'work_hour_price' => $newOfferParameters->workHourPrice,
            'period_of_support' => $newOfferParameters->periodOfSupport,
            'offer_expires_in' => $newOfferParameters->offerExpiresIn,
            'solution_robots' => $newOfferParameters->solutionRobots,
        ];
        /** @var Offer $offer */

        $offer = $this->offerRepository->create($offerParams);

        $c = 0;
        $sum = 0;
        if (isset($newOfferParameters->solutionRobots)) {
            foreach ($newOfferParameters->solutionRobots as $robot) {
                $c++;
                $sum += $robot['guarantee_period'];
            }
        }
        if ($c > 0) {
            $offer->avg_guarantee = (float)($sum / $c);
        }

        $offer->save();

        return $offer;
    }

    /**
     * @param NewOfferParameters $newOfferParameters
     * @param Offer $offer
     * @return Model
     */
    public function updateOffer(NewOfferParameters $newOfferParameters, Offer $offer): Model
    {
        $offer->price_of_delivery = $newOfferParameters->priceOfDelivery;
        $offer->weeks_to_start = $newOfferParameters->weeksToStart;
        $offer->time_to_start = $newOfferParameters->timeToStart;
        $offer->time_to_fix = $newOfferParameters->timeToFix;
        $offer->advance_upon_start = $newOfferParameters->advanceUponStart;
        $offer->advance_upon_delivery = $newOfferParameters->advanceUponDelivery;
        $offer->advance_upon_agreement = $newOfferParameters->advanceUponAgreement;
        $offer->years_of_guarantee = $newOfferParameters->yearsOfGuarantee;
        $offer->maintenance_frequency = $newOfferParameters->maintenanceFrequency;
        $offer->price_of_maintenance = $newOfferParameters->priceOfMaintenance;
        $offer->reaction_time = $newOfferParameters->reactionTime;
        $offer->intervention_price = $newOfferParameters->interventionPrice;
        $offer->work_hour_price = $newOfferParameters->workHourPrice;
        $offer->period_of_support = $newOfferParameters->periodOfSupport;
        $offer->offer_expires_in = $newOfferParameters->offerExpiresIn;

        $offer->save();

        return $offer;
    }

    /**
     * @param Offer $offer
     */
    public function deleteOffer(Offer $offer)
    {
        $offer->delete();
    }

    /**
     * @param Offer $offer
     */
    public function publishOffer(Offer $offer)
    {
        $solution = Solution::find($offer->solution_id);
        $offer->status = 1;
        $offer->save();
        event(new OfferPublished($offer, $offer->installer, 'Nowa oferta została opublikowana: ' . $solution->name, []));
    }

    /**
     * @param Offer $offer
     * @param Challenge $challenge
     * @param Solution $solution
     * @param String $comment
     */
    public function rejectOffer(Offer $offer,Challenge $challenge, Solution $solution, String $comment)
    {
        if ($challenge->selected_offer_id == $offer->id) {
            $challenge->selected_offer_id = 0;
        }
        $solution->selected_offer_id = 0;
        $challenge->save();
        $solution->save();
        $offer->comment = $comment;
        $offer->status = 2;
        $offer->save();

        event(new OfferRejected($offer, $offer->installer, 'Oferta została odrzucona: ' . $solution->name, []));

        return $offer;
    }

    /**
     * @param Offer $offer
     */
    public function acceptOffer(Offer $offer)
    {
        $challenge = Challenge::find($offer->challenge_id);
        $challenge->selected_offer_id = $offer->id;
        $challenge->stage = 3;

        $archiveSolutions = $challenge->solutions;
        foreach ($archiveSolutions as $archiveSolution) {
            $archiveSolution->archive = 1;
            $archiveSolution->save();
        }

        $solution = Solution::find($offer->solution_id);
        $solution->selected_offer_id = $offer->id;
        $challenge->solution_project_id = $solution->id;

        $offer->status = 3;
        $offer->is_offer_project = 1;

        $project = new Project();
        $project->challenge_id = $challenge->id;
        $project->name = $challenge->name;
        $project->en_name = $challenge->en_name;
        $project->type = $challenge->type;
        $project->description = $challenge->description;
        $project->en_description = $challenge->en_description;
        $project->stage = 0;
        $project->accept_technical_details = 0;
        $project->accept_financial_details = 0;
        $project->accept_offer = 0;
        $project->accept_local_vision = 0;
        $project->accept_visit_date = 0;
        $project->selected_offer_id = 0;
        $project->save();

        $offer->project_id = $project->id;
        $challenge->save();
        $solution->save();
        $offer->save();

        event(new OfferAccepted($offer, $offer->installer, 'Oferta zostało zaakceptowane: ' . $solution->name, []));
    }
}
