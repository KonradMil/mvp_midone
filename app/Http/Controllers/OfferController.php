<?php

namespace App\Http\Controllers;

use App\Events\OfferAdded;
use App\Http\Requests\Handlers\OfferHandler;
use App\Models\Challenge;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Solution;
use App\Repository\Eloquent\ChallengeRepository;
use App\Repository\Eloquent\OfferRepository;
use App\Repository\Eloquent\ProjectRepository;
use App\Repository\Eloquent\SolutionRepository;
use App\Services\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class OfferController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function theBestChallengeOffer(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        $offers = $challenge->offers()->where('status', '=', 1)->get();
        $sum_check = 0;
        $the_best = NULL;
        foreach ($offers as $offer) {
            $sum = 0;
            if ($offer->time_to_start === 0) {
                $sum += 3;
            } else if ($offer->time_to_start === 1) {
                $sum += 2;
            } else if ($offer->time_to_start === 2) {
                $sum += 2;
            } else if ($offer->time_to_start === 3) {
                $sum += 1;
            } else if ($offer->time_to_start === 4) {
                $sum += 1;
            }

            if ($offer->advance_upon_delivery === 0) {
                $sum += 2;
            } else if ($offer->advance_upon_delivery === 1) {
                $sum += 2;
            } else if ($offer->advance_upon_delivery === 2) {
                $sum += 2;
            } else if ($offer->advance_upon_delivery === 3) {
                $sum += 1;
            } else if ($offer->advance_upon_delivery === 4) {
                $sum += 1;
            }

            if ($offer->years_of_guarantee === 0) {
                $sum += 1;
            } else if ($offer->years_of_guarantee === 1) {
                $sum += 2;
            } else if ($offer->years_of_guarantee === 2) {
                $sum += 3;
            }

            if ($offer->time_to_fix === 0) {
                $sum += 3;
            } else if ($offer->time_to_fix === 1) {
                $sum += 2;
            } else if ($offer->time_to_fix === 2) {
                $sum += 1;
            } else if ($offer->time_to_fix === 3) {
                $sum += 1;
            }

            if ($offer->weeks_to_start === 0) {
                $sum += 3;
            } else if ($offer->weeks_to_start === 1) {
                $sum += 2;
            } else if ($offer->weeks_to_start === 2) {
                $sum += 2;
            } else if ($offer->weeks_to_start === 3) {
                $sum += 1;
            } else if ($offer->weeks_to_start === 4) {
                $sum += 1;
            }

            if ($offer->advance_upon_agreement === 0) {
                $sum += 2;
            } else if ($offer->advance_upon_agreement === 1) {
                $sum += 2;
            } else if ($offer->advance_upon_agreement === 2) {
                $sum += 2;
            } else if ($offer->advance_upon_agreement === 3) {
                $sum += 1;
            } else if ($offer->advance_upon_agreement === 4) {
                $sum += 1;
            }

            if ($offer->advance_upon_start === 0) {
                $sum += 2;
            } else if ($offer->advance_upon_start === 1) {
                $sum += 2;
            } else if ($offer->advance_upon_start === 2) {
                $sum += 2;
            } else if ($offer->advance_upon_start === 3) {
                $sum += 1;
            } else if ($offer->advance_upon_start === 4) {
                $sum += 1;
            }

            if ($offer->reaction_time === 0) {
                $sum += 3;
            } else if ($offer->reaction_time === 1) {
                $sum += 3;
            } else if ($offer->reaction_time === 2) {
                $sum += 2;
            } else if ($offer->reaction_time === 3) {
                $sum += 1;
            }
            if ($sum > $sum_check) {
                $the_best = $offer;
                $sum_check = $sum;
            }
            $o = Offer::find($offer->id);
            $o->points = $sum;
            $o->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Filter ok',
            'payload' => $the_best
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function filterChallengeOffers(Request $request): JsonResponse
    {
        $option = $request->input('option');
        $technology_option = $request->input('technologyType');
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        $offers = NULL;
        try {
            if ($option === 'Cene malejąco') {
                $offers = $challenge->offers()->where('status', '=', 1)->orderBy('price_of_delivery', 'DESC')->with('solution')->get();
            } else if ($option === 'Cena rosnąco') {
                $offers = $challenge->offers()->where('status', '=', 1)->orderBy('price_of_delivery', 'ASC')->with('solution')->get();
            } else if ($option === 'Czas realizacji uruchomienia u klienta') {
                $offers = $challenge->offers()->where('status', '=', 1)->orderBy('time_to_start', 'DESC')->with('solution')->get();
            } else if ($option === 'Okres gwarancji stanowiska od integratora') {
                $offers = $challenge->offers()->where('status', '=', 1)->orderBy('years_of_guarantee', 'DESC')->with('solution')->get();
            } else if ($option === 'NPV') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->join('financial_analyses as fa', 'fa.solution_id', '=', 'so.id')->orderBy('fa.npv', 'DESC')->select('offers.*')->with('solution', 'solution.financial_analyses')->get();
            } else if ($option === 'OEE po robotyzacji') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->join('operational_analyses as oa', 'oa.solution_id', '=', 'so.id')->orderBy('oa.oee_after', 'DESC')->select('offers.*')->with('solution', 'solution.financial_analyses')->get();
            } else if ($option === 'Okres gwarancji robota') {
                $offers = $challenge->offers()->where('status', '=', 1)->orderBy('avg_guarantee', 'DESC')->with('solution')->get();
            } else if ($option === 'Okres zwrotu inwestycji') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->join('financial_analyses as fa', 'fa.solution_id', '=', 'so.id')->orderBy('fa.simple_payback', 'DESC')->select('offers.*')->with('solution', 'solution.financial_analyses')->get();
            } else if ($option === 'Ranking') {
                $offers = $challenge->offers()->where('status', '=', 1)->orderBy('points', 'DESC')->with('solution')->get();
            } else if ($technology_option === 'FANUC') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->where('so.number_of_fanuc', '>', 0)->orderBy('so.number_of_fanuc', 'DESC')->select('offers.*')->with('solution')->get();
            } else if ($technology_option === 'Yaskawa') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->where('so.number_of_yaskawa', '>', 0)->orderBy('so.number_of_yaskawa', 'DESC')->select('offers.*')->with('solution')->get();
            } else if ($technology_option === 'ABB') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->where('so.number_of_abb', '>', 0)->orderBy('so.number_of_abb', 'DESC')->select('offers.*')->with('solution')->get();
            } else if ($technology_option === 'Universal Robots') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->where('so.number_of_universal', '>', 0)->orderBy('so.number_of_universal', 'DESC')->select('offers.*')->with('solution')->get();
            } else if ($technology_option === 'Mitshubishi') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->where('so.number_of_mitshubishi', '>', 0)->orderBy('so.number_of_mitshubishi', 'DESC')->select('offers.*')->with('solution')->get();
            } else if ($technology_option === 'TFM ROBOTICS') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->where('so.number_of_tfm', '>', 0)->orderBy('so.number_of_tfm', 'DESC')->select('offers.*')->with('solution')->get();
            } else if ($technology_option === 'KUKA') {
                $offers = $challenge->offers()->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->where('so.number_of_kuka', '>', 0)->orderBy('so.number_of_kuka', 'DESC')->select('offers.*')->with('solution')->get();
            } else if ($option === null && $technology_option === null) {
                $offers = $challenge->offers()->with('solution')->get();
            }
        } catch (\Exception $e) {
            if ($option !== NULL) {
                return response()->json([
                    'success' => true,
                    'message' => 'Filter ok',
                    'payload' => ''
                ]);
            }
        }

        if ($offers == null) {
            return response()->json([
                'success' => true,
                'message' => 'Filter ok',
                'payload' => '',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Filter ok',
                'payload' => $offers,
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        $solutions = $challenge->solutions;
        $check = false;
        foreach ($solutions as $solution) {
            $offers = $solution->offers;
            foreach ($offers as $offer) {
                if ($offer->installer_id === Auth::user()->id && $offer->status == 0 && Auth::user()->type == 'integrator') {
                    $check = true;
                } else if (Auth::user()->type == 'investor' && $offer->rejected != 1 && $offer->status == 1) {
                    if ($offer->selected == 0) {
                        $check = true;
                    }
                }

            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie',
            'payload' => $check,
        ]);
    }

    /**
     * @param int $challengeId
     * @param Request $request
     * @param ChallengeRepository $challengeRepository
     * @param OfferRepository $offerRepository
     * @param OfferService $offerService
     * @return JsonResponse
     */
    public function delete(int $challengeId, Request $request, ChallengeRepository $challengeRepository, OfferRepository $offerRepository, OfferService $offerService): JsonResponse
    {
        $challenge = $challengeRepository->find($challengeId);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerRepository->find($request->get('offer_id'));

        if (!$offer) {
            $this->responseBuilder->setErrorMessage(__('messages.offer.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offerService->deleteOffer($offer);
        $this->responseBuilder->setSuccessMessage(__('messages.delete_correct'));

        return $this->responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $offer = Offer::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano ofertę poprawnie.',
            'payload' => $offer
        ]);
    }

    /**
     * @param int $id
     * @param ChallengeRepository $challengeRepository
     * @param OfferRepository $offerRepository
     * @return JsonResponse
     */
    public function getAllChallengeOffers(int $id, ChallengeRepository $challengeRepository, OfferRepository $offerRepository): JsonResponse
    {
        $challenge = $challengeRepository->find($id);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $challengeOffers = $offerRepository->getOffersByChallenge($challenge);

        if (!$challengeOffers) {
            $this->responseBuilder->setErrorMessage(__('messages.offer.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setData('offers', $challengeOffers);

        return $this->responseBuilder->getResponse();
    }

    /**
     * @param int $challengeId
     * @param ChallengeRepository $challengeRepository
     * @param OfferRepository $offerRepository
     * @return JsonResponse
     */
    public function getAll(int $challengeId, ChallengeRepository $challengeRepository, OfferRepository $offerRepository): JsonResponse
    {
        $challenge = $challengeRepository->find($challengeId);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $userOffers = $offerRepository->getUserOffersByChallenge($challenge);

        if (!$userOffers) {
            $this->responseBuilder->setErrorMessage(__('messages.offer.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setData('offers', $userOffers);

        return $this->responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param OfferRepository $offerRepository
     * @param OfferService $offerService
     * @param SolutionRepository $solutionRepository
     * @param ProjectRepository $projectRepository
     * @param ChallengeRepository $challengeRepository
     * @return JsonResponse
     */
    public function saveProjectOffer(Request $request, OfferRepository $offerRepository, OfferService $offerService, SolutionRepository $solutionRepository, ProjectRepository $projectRepository, ChallengeRepository $challengeRepository): JsonResponse
    {
        $offerHandler = new OfferHandler($request);

        $parameters = $offerHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        $challenge = $challengeRepository->find($parameters->challengeId);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $project = $projectRepository->find($parameters->projectId);

        if (!$project) {
            $this->responseBuilder->setErrorMessage(__('messages.project.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerService->addProjectOffer($parameters, $project);

        $oldOffer = $offerRepository->getOldOfferForProject($challenge);

        event(new OfferAdded($offer, $offer->installer, 'Dodałeś nową ofertę do projektu: ' . $project->name, []));

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('new_offer', $offer);
        $this->responseBuilder->setData('old_offer', $oldOffer);


        return $this->responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @param OfferRepository $offerRepository
     * @param OfferService $offerService
     * @param SolutionRepository $solutionRepository
     * @param ProjectRepository $projectRepository
     * @param ChallengeRepository $challengeRepository
     * @return JsonResponse
     */
    public function saveSolutionOffer(Request $request, OfferRepository $offerRepository, OfferService $offerService, SolutionRepository $solutionRepository, ProjectRepository $projectRepository, ChallengeRepository $challengeRepository): JsonResponse
    {
        $offerHandler = new OfferHandler($request);

        $parameters = $offerHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        $challenge = $challengeRepository->find($parameters->challengeId);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        if ($parameters->offerId > 0) {

            $offer = $offerRepository->find($parameters->offerId);

            if (!$offer) {
                $this->responseBuilder->setErrorMessage(__('messages.offer.not_found'));
                return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
            }

            $offer = $offerService->updateOffer($parameters, $offer);

            $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $this->responseBuilder->setData('$offer', $offer);

        } else {

            $offer = $offerService->addSolutionOffer($parameters);

            $solution = $solutionRepository->find($offer->solution_id);

            event(new OfferAdded($offer, $offer->installer, 'Dodałeś nową ofertę do rozwiązania: ' . $solution->name, []));

            $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
            $this->responseBuilder->setData('offer', $offer);

        }

        return $this->responseBuilder->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addOffer(Request $request): JsonResponse
    {
        $offer = new Offer();
        $sol = Solution::find($request->solution_id);
        $ch = Challenge::find($sol->challenge_id);
        $offer->challenge_id = $ch->id;
        $offer->solution_id = $request->solution_id;
        $offer->installer_id = Auth::user()->id;
        $offer->save();


        return response()->json([
            'success' => true,
            'message' => 'Dodano oferte poprawnie.',
            'payload' => $offer
        ]);
    }

    /**
     * @param int $challengeId
     * @param Request $request
     * @param ChallengeRepository $challengeRepository
     * @param OfferRepository $offerRepository
     * @param OfferService $offerService
     * @return JsonResponse
     */
    public function publishOffer(int $challengeId, Request $request, ChallengeRepository $challengeRepository, OfferRepository $offerRepository, OfferService $offerService): JsonResponse
    {
        $challenge = $challengeRepository->find($challengeId);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerRepository->find($request->get('offer_id'));

        if (!$offer) {
            $this->responseBuilder->setErrorMessage(__('messages.offer.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offerService->publishOffer($offer);
        $this->responseBuilder->setSuccessMessage(__('messages.publish'));

        return $this->responseBuilder->getResponse();
    }

    /**
     * @param int $challengeId
     * @param Request $request
     * @param ChallengeRepository $challengeRepository
     * @param OfferRepository $offerRepository
     * @param OfferService $offerService
     * @return JsonResponse
     */
    public function acceptOffer(int $challengeId, Request $request, ChallengeRepository $challengeRepository, OfferRepository $offerRepository, OfferService $offerService): JsonResponse
    {
        $challenge = $challengeRepository->find($challengeId);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerRepository->find($request->get('offer_id'));

        if (!$offer) {
            $this->responseBuilder->setErrorMessage(__('messages.offer.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setSuccessMessage(__('messages.accepted'));
        $offerService->acceptOffer($offer);

        return $this->responseBuilder->getResponse();
    }

    /**
     * @param int $challengeId
     * @param Request $request
     * @param ChallengeRepository $challengeRepository
     * @param OfferRepository $offerRepository
     * @param OfferService $offerService
     * @return JsonResponse
     */
    public function rejectOffer(int $challengeId, Request $request, ChallengeRepository $challengeRepository, OfferRepository $offerRepository, OfferService $offerService, SolutionRepository $solutionRepository): JsonResponse
    {
        $challenge = $challengeRepository->find($challengeId);

        if (!$challenge) {
            $this->responseBuilder->setErrorMessage(__('messages.challenge.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $offer = $offerRepository->find($request->get('offer_id'));

        if (!$offer) {
            $this->responseBuilder->setErrorMessage(__('messages.offer.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $solution = $solutionRepository->find($offer->solution_id);

        if (!$solution) {
            $this->responseBuilder->setErrorMessage(__('messages.solution.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $comment = $request->get('comment');

        if (!$comment) {
            $this->responseBuilder->setErrorMessage(__('messages.not_found'));
            return $this->responseBuilder->getResponse(Response::HTTP_NOT_FOUND);
        }

        $this->responseBuilder->setSuccessMessage(__('messages.rejected'));
        $offerService->rejectOffer($offer, $challenge, $solution, $comment);
        $this->responseBuilder->setData('offer', $offer);


        return $this->responseBuilder->getResponse();
    }
}
