<?php

namespace App\Services;


use App\Models\Challenge;
use App\Models\File;
use App\Models\Financial;
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

    /**
     * @param integer $challengeId
     * @return array
     */
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

    /**
     * @param integer $challengeId
     * @return array
     */
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

    /**
     * @param Challenge $challenge
     * @return Challenge
     */
    public function unFollowChallenge(Challenge $challenge): Challenge
    {
        Auth::user()->viaLoveReacter()->unreactTo($challenge, 'Follow');

        return $challenge;
    }

    /**
     * @param Challenge $challenge
     * @param File $file
     * @return mixed
     */
    public function detachFile(Challenge $challenge, File $file)
    {
        $challenge->files()->detach($file);
    }
}
