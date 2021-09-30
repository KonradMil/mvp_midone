<?php

namespace App\Repository\Eloquent;

use App\Models\Challenge;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class OfferRepository extends BaseRepository
{
    /**
     * @param Offer $offer
     */
    public function __construct(Offer $offer)
    {
        parent::__construct($offer);
    }

    /**
     * @param Challenge $challenge
     * @return Model
     */
    public function getSelectedOfferByChallenge(Challenge $challenge): Model
    {
        $old_offer = Offer::where('id', '=', $challenge->selected_offer_id)->with('solution')->first();

        return $old_offer;
    }

    /**
     * @param Project $project
     * @return Offer|null
     */
    public function getSelectedOfferByProject(Project $project)
    {
        $offer = Offer::where('id', '=', $project->selected_offer_id)->with('solution')->first();

        return $offer;
    }

    /**
     * @param Project $project
     * @param int $offerId
     * @return Collection
     */
    public function getProjectOffers(Project $project, int $offerId): Collection
    {
        $offers = Offer::where('project_id', '=', $project->id)->where('id', '!=', $offerId)->orderBy('is_offer_project', 'ASC')->orderBy('created_at', 'DESC')->with('solution')->get();

        return $offers;
    }
}
