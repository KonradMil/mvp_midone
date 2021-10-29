<?php

namespace App\Repository\Eloquent;

use App\Models\Challenge;
use App\Models\Solution;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;


/**
 *
 */
class SolutionRepository extends BaseRepository
{

    /**
     * @param Solution $solution
     */
    public function __construct(Solution $solution)
    {
        parent::__construct($solution);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getSolutionWithFiles(int $id)
    {
        return Solution::where('id','=', $id)->with('files')->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getAllSolutionsByUserId(int $id) : Collection
    {
        $solutions = Solution::where('author_id', '=', $id)->where('archive', '=', 0)->orderBy('created_at', 'DESC')->with('comments.commentator', 'challenge')->get();

        foreach ($solutions as $solution) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($solution)) {
                $solution->liked = true;
            } else {
                $solution->liked = false;
            }
            $solution->comments_count = $solution->comments()->count();
            $solution->likes = $solution->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
        }

        return $solutions;
    }

    /**
     * @param Challenge $challenge
     * @param int $userId
     * @return mixed
     */
    public function getAllUserSolutionsByChallengeName(Challenge $challenge, int $userId) : Collection
    {
        $solutions = $challenge->solutions()->where('solutions.archive', '=', 0)->where('solutions.author_id', '=', $userId)
            ->orderBy('created_at', 'DESC')->get();


        foreach ($solutions as $solution) {
            if (Auth::user()->viaLoveReacter()->hasReactedTo($solution)) {
                $solution->liked = true;
            } else {
                $solution->liked = false;
            }
            $solution->comments_count = $solution->comments()->count();
            $solution->likes = $solution->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
        }

        return $solutions;
    }
}
