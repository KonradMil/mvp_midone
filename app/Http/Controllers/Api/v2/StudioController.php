<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Repository\Eloquent\ChallengeRepository;
use App\Repository\Eloquent\SolutionRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudioController extends Controller
{

    private $unityKey = "0b24943cdcf275fc202fd53ec4aeb81f6fb01101";

    private function checkKey(Request $request){

        return $request->get('key') === $this->unityKey;
    }



    public function getChallengeSave(Request $request, ChallengeRepository $challengeRepository)
    {
        if(!$this->checkKey($request)) {
            $this->responseBuilder->setErrorMessage("Unauthorized!");
            return $this->responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);
        }

        $challengeId = $request->get('challenge_id');
        $challenge = $challengeRepository->find($challengeId);

        if(!$challenge) {

            $this->responseBuilder->setErrorMessage('Challenge not found!');
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);

        }

        $this->responseBuilder->setData('save', $challenge->save_json);

        return $this->responseBuilder->getResponse();
    }

    public function getSolutionSave(Request $request, SolutionRepository $solutionRepository)
    {
        if(!$this->checkKey($request)) {
            $this->responseBuilder->setErrorMessage("Unauthorized!");
            return $this->responseBuilder->getResponse(Response::HTTP_UNAUTHORIZED);
        }

        $solutionId = $request->get('solution_id');
        $solution = $solutionRepository->find($solutionId);

        if(!$solution) {
            $this->responseBuilder->setErrorMessage('Solution not found!');
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setData('save', json_decode($solution->save_json));

        return $this->responseBuilder->getResponse();
    }

}
