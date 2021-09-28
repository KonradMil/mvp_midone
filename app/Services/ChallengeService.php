<?php

namespace App\Services;


use App\Models\Challenge;
use App\Models\Financial;
use App\Models\Offer;
use App\Models\TechnicalDetails;
use App\Repository\Eloquent\ChallengeRepository;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class ChallengeService
{
    private ChallengeRepository $challengeRepository;

    public function __construct(ChallengeRepository $challengeRepository)
    {
        $this->challengeRepository = $challengeRepository;
    }

    public function getChallengeById(int $id): ?Challenge
    {
        /** @var Challenge|null $challenge */
        $challenge = $this->challengeRepository->getFullChallengeById($id);

        if (!$challenge) {
            return $challenge;
        }

        $challenge->selected = $challenge->solutions()->where('selected', '=', 1)->get();

        if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Like', 1)) {
            $challenge->liked = true;
        } else {
            $challenge->liked = false;
        }

        if (Auth::user()->viaLoveReacter()->hasReactedTo($challenge, 'Follow', 1)) {
            $challenge->followed = true;
        } else {
            $challenge->followed = false;
        }

        foreach ($challenge->solutions as $sol) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($sol, 'Like', 1)) {
                $sol->liked = true;
            } else {
                $sol->liked = false;
            }

            if (Auth::user()->viaLoveReacter()->hasReactedTo($sol, 'Follow', 1)) {
                $sol->followed = true;
            } else {
                $sol->followed = false;
            }
            $sol->comments_count = $sol->comments()->count();
            $sol->likes = $sol->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
        }

        $challenge->comments_count = $challenge->comments()->count();
        $challenge->likes = $challenge->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();

        return $challenge;
    }

    public function getTechnicalDetailsByChallengeId(int $challengeId): array
    {
        $array = [];

        $technicalDetails = TechnicalDetails::where('challenge_id', '=', $challengeId)->get();

        if (sizeof($technicalDetails) > 1) {

            $technicalDetails = TechnicalDetails::where('challenge_id', '=', $challengeId)
                ->orderBy('created_at', 'DESC')->get();
            $array[0] = $technicalDetails[1];
            $array[1] = $technicalDetails[0];
        } else {
            $array[0] = $technicalDetails[0];
            $array[1] = $technicalDetails[0];
        }

        return $array;
    }

    public function getFinancialDetailsByChallengeId(int $challengeId): array
    {
        $array = [];

        $financialDetails = Financial::where('challenge_id', '=', $challengeId)->get();

        if (sizeof($financialDetails) > 1) {

            $financialDetails = Financial::where('challenge_id', '=', $challengeId)
                ->orderBy('created_at', 'DESC')->get();
            $array[0] = $financialDetails[1];
            $array[1] = $financialDetails[0];
        } else {
            $array[0] = $financialDetails[0];
            $array[1] = $financialDetails[0];
        }

        return $array;
    }

    public function getSelectedOfferByChallenge(Challenge $challenge)
    {
        return Offer::find($challenge->selected_offer_id)->with('solution');
    }
}
