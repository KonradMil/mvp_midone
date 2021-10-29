<?php

namespace App\Repository\Eloquent;

use App\Models\Challenge;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class ChallengeRepository extends BaseRepository
{

    /**
     * @param Challenge $challenge
     */
    public function __construct(Challenge $challenge)
    {
        parent::__construct($challenge);
    }

    /**
     * @param int $id
     * @return Builder|array|Collection|Model
     */
    public function getFullChallengeById(int $id): Builder|array|Collection|Model
    {
        $challenge = Challenge::with(
            'solutions', 'author', 'technicalDetails',
            'financial_before', 'teams', 'files', 'teams.users',
            'teams.users.companies', 'solutions.comments', 'solutions.comments.commentator', 'solutions.teams',
            'solutions.teams.users', 'solutions.teams.users.companies', 'solutions.offers', 'solutions.files', 'project'
        )->find($id);

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

    /**
     * @param string $challengeName
     * @return Model
     */
    public function getChallengeByName(string $challengeName): Model
    {
        $challenge = Challenge::where('name', '=', $challengeName)->first();

        return $challenge;
    }

    /**
     * @param Collection $solutions
     * @return array
     */
    public function getChallengesNameBySolutions(Collection $solutions): array
    {
        $challengesName = [];
        foreach($solutions as $solution){
            $challenge = $solution->challenge;
            if (!(in_array($challenge->name, $challengesName))) {
                $challengesName[] = $challenge->name;
            }
        }

        return $challengesName;
    }
}
