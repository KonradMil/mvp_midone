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
    public
    function saveSolutionOffer(Request $request, OfferRepository $offerRepository, OfferService $offerService, SolutionRepository $solutionRepository, ProjectRepository $projectRepository, ChallengeRepository $challengeRepository): JsonResponse
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

//        $stage = $request->stage;
//
//        if($stage == 3){
//            $challenge = Challenge::find($request->challenge_id);
//            $project = Project::where('challenge_id', '=' , $challenge->id)->first();
//            $old_offer = Offer::find($challenge->selected_offer_id);
//
//            $new_offer = new Offer();
//            $new_offer->challenge_id = $challenge->id;
//            $new_offer->solution_id = $challenge->solution_project_id;
//            $c = 0;
//            $sum = 0;
//            if (isset($request->solution_robots)) {
//                foreach ($request->solution_robots as $robot) {
//                    $c++;
//                    $sum += $robot['guarantee_period'];
//                }
//            }
//            if ($c > 0) {
//                $new_offer->avg_guarantee = (float)($sum / $c);
//            }
//            $new_offer->installer_id = Auth::user()->id;
//            $new_offer->robots = json_encode($request->solution_robots);
//            $new_offer->price_of_delivery = $request->price_of_delivery;
//            $new_offer->weeks_to_start = $request->weeks_to_start;
//            $new_offer->time_to_start = $request->time_to_start;
//            $new_offer->time_to_fix = $request->time_to_fix;
//            $new_offer->advance_upon_start = $request->advance_upon_start;
//            $new_offer->advance_upon_delivery = $request->advance_upon_delivery;
//            $new_offer->advance_upon_agreement = $request->advance_upon_agreement;
//            $new_offer->years_of_guarantee = $request->years_of_guarantee;
//            $new_offer->service_support_scope = $request->service_support_scope;
//            $new_offer->maintenance_frequency = $request->maintenance_frequency;
//            $new_offer->price_of_maintenance = $request->price_of_maintenance;
//            $new_offer->reaction_time = $request->reaction_time;
//            $new_offer->intervention_price = $request->intervention_price;
//            $new_offer->work_hour_price = $request->work_hour_price;
//            $new_offer->period_of_support = $request->period_of_support;
//            $new_offer->offer_expires_in = $request->offer_expires_in;
//            $new_offer->project_id = $project->id;
//            $new_offer->save();
//            $project->selected_offer_id = $new_offer->id;
//            $project->save();
//
//            return response()->json([
//                'success' => true,
//                'message' => 'Dodano kontrofertę poprawnie.',
//                'payload' => $new_offer,
//                'project' => $old_offer,
//            ]);
//        } else if ($request->edit_id != null) {
//            $offer = Offer::find($request->edit_id);
//            $offer->price_of_delivery = $request->price_of_delivery;
//            $offer->weeks_to_start = $request->weeks_to_start;
//            $offer->time_to_start = $request->time_to_start;
//            $offer->time_to_fix = $request->time_to_fix;
//            $offer->advance_upon_start = $request->advance_upon_start;
//            $offer->advance_upon_delivery = $request->advance_upon_delivery;
//            $offer->advance_upon_agreement = $request->advance_upon_agreement;
//            $offer->years_of_guarantee = $request->years_of_guarantee;
//            $offer->service_support_scope = $request->service_support_scope;
//            $offer->maintenance_frequency = $request->maintenance_frequency;
//            $offer->price_of_maintenance = $request->price_of_maintenance;
//            $offer->reaction_time = $request->reaction_time;
//            $offer->intervention_price = $request->intervention_price;
//            $offer->work_hour_price = $request->work_hour_price;
//            $offer->period_of_support = $request->period_of_support;
//            $offer->offer_expires_in = $request->offer_expires_in;
//            $challenge = Challenge::find($request->challenge_id);
//
//            $offer->save();
//            $challenge->save();
//            return response()->json([
//                'success' => true,
//                'message' => 'Edytowano oferte poprawnie.',
//                'payload' => $offer
//            ]);
//        } else {
//            $check = new Offer();
//            $c = 0;
//            $sum = 0;
//            if (isset($request->solution_robots)) {
//                foreach ($request->solution_robots as $robot) {
//                    $c++;
//                    $sum += $robot['guarantee_period'];
//                }
//            }
//            if ($c > 0) {
//                $check->avg_guarantee = (float)($sum / $c);
//            }
//            $check->robots = json_encode($request->solution_robots);
//            $check->challenge_id = $request->challenge_id;
//            $check->solution_id = $request->solution_id;
//            $check->installer_id = Auth::user()->id;
//            $check->price_of_delivery = $request->price_of_delivery;
//            $check->weeks_to_start = $request->weeks_to_start;
//            $check->time_to_start = $request->time_to_start;
//            $check->time_to_fix = $request->time_to_fix;
//            $check->advance_upon_start = $request->advance_upon_start;
//            $check->advance_upon_delivery = $request->advance_upon_delivery;
//            $check->advance_upon_agreement = $request->advance_upon_agreement;
//            $check->years_of_guarantee = $request->years_of_guarantee;
//            $check->service_support_scope = $request->service_support_scope;
//            $check->maintenance_frequency = $request->maintenance_frequency;
//            $check->price_of_maintenance = $request->price_of_maintenance;
//            $check->reaction_time = $request->reaction_time;
//            $check->intervention_price = $request->intervention_price;
//            $check->work_hour_price = $request->work_hour_price;
//            $check->period_of_support = $request->period_of_support;
//            $check->offer_expires_in = $request->offer_expires_in;
//            $check->save();
//            $solution = Solution::find($check->solution_id);
//
//            event(new OfferAdded($check, $check->installer, 'Dodałeś nową ofertę do rozwiązania: ' . $solution->name, []));
//
//            return response()->json([
//                'success' => true,
//                'message' => 'Dodano oferte poprawnie.',
//                'payload' => $check
//            ]);
//        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public
    function addOffer(Request $request): JsonResponse
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
    public
    function publishOffer(int $challengeId, Request $request, ChallengeRepository $challengeRepository, OfferRepository $offerRepository, OfferService $offerService): JsonResponse
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
    public
    function acceptOffer(int $challengeId, Request $request, ChallengeRepository $challengeRepository, OfferRepository $offerRepository, OfferService $offerService): JsonResponse
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
    public
    function rejectOffer(int $challengeId, Request $request, ChallengeRepository $challengeRepository, OfferRepository $offerRepository, OfferService $offerService, SolutionRepository $solutionRepository): JsonResponse
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

        $offerService->rejectOffer($offer, $challenge, $solution, $comment);

        return $this->responseBuilder->getResponse();
    }
}
