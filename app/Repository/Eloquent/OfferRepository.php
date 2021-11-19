<?php

namespace App\Repository\Eloquent;

use App\Models\Challenge;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Solution;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        $offers = Offer::where('project_id', '=', $project->id)->orderBy('is_offer_project', 'ASC')->orderBy('created_at', 'DESC')->with('solution')->get();

        return $offers;
    }

    /**
     * @param Challenge $challenge
     * @return Collection
     */
    public function getOffersByChallenge(Challenge $challenge): Collection
    {
        $offers = Offer::where('challenge_id', '=', $challenge->id)->where('status', '=' , 1)->with('solution')->get();
        $array = [];

        foreach($offers as $offer){
            $solution = Solution::find($offer->solution_id);
            if (($solution->selected == true) && ($offer->rejected != 1) && ($offer->status == 1)) {
                $array[] = $offer;
            }
        }

        return $offers;
    }

    /**
     * @param Challenge $challenge
     * @return Collection
     */
    public function getUserOffersByChallenge(Challenge $challenge): Collection
    {
        $user = User::find(Auth::user()->id);
        $array = [];
        foreach ($user->teams as $team) {
            foreach ($team->users as $member) {
                $offers = Offer::where('installer_id', '=', $member->id)->where('challenge_id', '=', $challenge->id)->with('solution')->get();
                foreach ($offers as $offer) {
                    if (!(in_array($offer->id, $array))) {
                        $array[] = $offer->id;
                    }
                }
            }
        }
        foreach($challenge->offers as $offer){
            if($offer->installer_id == $user->id){
                if(!(in_array($offer->id, $array))){
                    $array[] = $offer->id;
                }
            }
        }
        $goodOffers = NULL;
        if ($challenge->stage === 3) {
            $goodOffers = Offer::where('id', '=', $challenge->selected_offer_id)->with('solution')->get();
        } else {
            $goodOffers = Offer::whereIn('id', $array)->with('solution')->get();
        }

        return $goodOffers;
    }

    /**
     * @param Challenge $challenge
     * @return Model
     */
    public function getOldOfferForProject(Challenge $challenge): Model
    {
        $offer = Offer::where('id', '=', $challenge->selected_offer_id)->first();

        return $offer;
    }
}
