<?php

namespace App\Http\Controllers;

use App\Events\OfferAccepted;
use App\Events\OfferAdded;
use App\Events\OfferPublished;
use App\Events\OfferRejected;
use App\Models\Challenge;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Solution;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $offers = $challenge->offers;

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
        if ($option === 'Cene malejąco') {
            $offers = $challenge->offers()->where('rejected', '=', null)->where('status', '=', 1)->orderBy('price_of_delivery', 'DESC')->with('solution')->get();
        } else if ($option === 'Cena rosnąco') {
            $offers = $challenge->offers()->where('rejected', '=', null)->where('status', '=', 1)->orderBy('price_of_delivery', 'ASC')->with('solution')->get();
        } else if ($option === 'Czas realizacji uruchomienia u klienta') {
            $offers = $challenge->offers()->where('rejected', '=', null)->where('status', '=', 1)->orderBy('time_to_start', 'DESC')->with('solution')->get();
        } else if ($option === 'Okres gwarancji stanowiska od integratora') {
            $offers = $challenge->offers()->where('rejected', '=', null)->where('status', '=', 1)->orderBy('years_of_guarantee', 'DESC')->with('solution')->get();
        } else if ($option === 'NPV') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->join('financial_analyses as fa', 'fa.solution_id', '=', 'so.id')->orderBy('fa.npv', 'DESC')->select('offers.*')->with('solution', 'solution.financial_analyses')->get();
        } else if ($option === 'OEE po robotyzacji') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->join('operational_analyses as oa', 'oa.solution_id', '=', 'so.id')->orderBy('oa.oee_after', 'DESC')->select('offers.*')->with('solution', 'solution.financial_analyses')->get();
        } else if ($option === 'Okres gwarancji robota') {
            $offers = $challenge->offers()->where('rejected', '=', null)->where('status', '=', 1)->orderBy('avg_guarantee', 'DESC')->with('solution')->get();
        } else if ($option === 'Okres zwrotu inwestycji') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->join('financial_analyses as fa', 'fa.solution_id', '=', 'so.id')->orderBy('fa.simple_payback', 'DESC')->select('offers.*')->with('solution', 'solution.financial_analyses')->get();
        } else if ($option === 'Ranking') {
            $offers = $challenge->offers()->where('rejected', '=', null)->where('status', '=', 1)->orderBy('points', 'DESC')->with('solution')->get();
        } else if ($technology_option === 'FANUC') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->orderBy('so.number_of_fanuc', 'DESC')->select('offers.*')->with('solution')->get();
        } else if ($technology_option === 'Yaskawa') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->orderBy('so.number_of_yaskawa', 'DESC')->select('offers.*')->with('solution')->get();
        } else if ($technology_option === 'ABB') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->orderBy('so.number_of_abb', 'DESC')->select('offers.*')->with('solution')->get();
        } else if ($technology_option === 'Universal Robots') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->orderBy('so.number_of_universal', 'DESC')->select('offers.*')->with('solution')->get();
        } else if ($technology_option === 'Mitshubishi') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->orderBy('so.number_of_mitshubishi', 'DESC')->select('offers.*')->with('solution')->get();
        } else if ($technology_option === 'Universal Robots') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->orderBy('so.number_of_universal', 'DESC')->select('offers.*')->with('solution')->get();
        } else if ($technology_option === 'TFM ROBOTICS') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->orderBy('so.number_of_tfm', 'DESC')->select('offers.*')->with('solution')->get();
        } else if ($technology_option === 'KUKA') {
            $offers = $challenge->offers()->where('offers.rejected', '=', null)->where('offers.status', '=', 1)->join('solutions as so', 'so.id', '=', 'offers.solution_id')->orderBy('so.number_of_kuka', 'DESC')->select('offers.*')->with('solution')->get();
        }


        return response()->json([
            'success' => true,
            'message' => 'Filter ok',
            'payload' => $offers
        ]);
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
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $id = $request->input('id');
        Offer::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Usunięto ofertę poprawnie.',
            'payload' => ''
        ]);
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
     * @param Challenge $challenge
     * @return JsonResponse
     */
    public function getAllChallengeOffers(Challenge $challenge): JsonResponse
    {
        $offers = Offer::where('challenge_id', '=', $challenge->id)->with('solution')->get();
        $array = [];

        foreach ($offers as $offer) {
            $solution = Solution::find($offer->solution_id);
            if (($solution->selected == true) && ($offer->rejected != 1) && ($offer->status == 1)) {
                $array[] = $offer;
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano oferty poprawnie.',
            'payload' => $array
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAll(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
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
        $goodOffers = NULL;
        if ($challenge->stage === 3) {
            $goodOffers = Offer::where('id', '=', $challenge->selected_offer_id)->with('solution')->get();
        } else {
            $goodOffers = Offer::whereIn('id', $array)->with('solution')->get();
        }


        return response()->json([
            'success' => true,
            'message' => 'Pobrano oferty poprawnie.',
            'payload' => $goodOffers
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
        if ($request->edit_id != null) {
            $offer = Offer::find($request->edit_id);
            $offer->price_of_delivery = $request->price_of_delivery;
            $offer->weeks_to_start = $request->weeks_to_start;
            $offer->time_to_start = $request->time_to_start;
            $offer->time_to_fix = $request->time_to_fix;
            $offer->advance_upon_start = $request->advance_upon_start;
            $offer->advance_upon_delivery = $request->advance_upon_delivery;
            $offer->advance_upon_agreement = $request->advance_upon_agreement;
            $offer->years_of_guarantee = $request->years_of_guarantee;
            $offer->service_support_scope = $request->service_support_scope;
            $offer->maintenance_frequency = $request->maintenance_frequency;
            $offer->price_of_maintenance = $request->price_of_maintenance;
            $offer->reaction_time = $request->reaction_time;
            $offer->intervention_price = $request->intervention_price;
            $offer->work_hour_price = $request->work_hour_price;
            $offer->period_of_support = $request->period_of_support;
            $offer->offer_expires_in = $request->offer_expires_in;
            $challenge = Challenge::find($request->challenge_id);
            if ($request->is_changed != null) {
                $offer->is_changed = $request->is_changed;
                $challenge -> is_offer_changed = 1;
            }
            $offer->save();
            $challenge->save();
            return response()->json([
                'success' => true,
                'message' => 'Edytowano oferte poprawnie.',
                'payload' => $offer
            ]);
        } else {
            $check = new Offer();
            $c = 0;
            $sum = 0;
//            $sum_fanuc = 0;
//            $sum_yaskawa = 0;
//            $sum_abb = 0;
//            $sum_mitshubishi = 0;
//            $sum_kuka = 0;
//            $sum_tfm = 0;
//            $sum_universal = 0;
            if (isset($request->solution_robots)) {
                foreach ($request->solution_robots as $robot) {
                    $c++;
                    $sum += $robot['guarantee_period'];
//                    if($robot['brand'] === 'FANUC'){
//                        $sum_fanuc++;
//                    }else if($robot['brand'] === 'Yaskawa'){
//                        $sum_yaskawa++;
//                    }else if($robot['brand'] === 'ABB'){
//                        $sum_abb++;
//                    }else if($robot['brand'] === 'Mitshubishi'){
//                        $sum_mitshubishi++;
//                    }else if($robot['brand'] === 'KUKA'){
//                        $sum_kuka++;
//                    }else if($robot['brand'] === 'TFM ROBOTICS'){
//                        $sum_tfm++;
//                    }else if($robot['brand'] === 'Universal Robots'){
//                        $sum_universal++;
//                    }
                }
            }
            if ($c > 0) {
                $check->avg_guarantee = (float)($sum / $c);
            }
//            $check->count_fanuc = $sum_fanuc;
//            $check->count_yaskawa = $sum_yaskawa;
//            $check->count_abb  = $sum_abb;
//            $check->count_mitshubishi = $sum_mitshubishi;
//            $check->count_tfm  = $sum_tfm;
//            $check->count_universal  = $sum_universal;
            $check->robots = json_encode($request->solution_robots);
            $check->challenge_id = $request->challenge_id;
            $check->solution_id = $request->solution_id;
            $check->installer_id = Auth::user()->id;
            $check->price_of_delivery = $request->price_of_delivery;
            $check->weeks_to_start = $request->weeks_to_start;
            $check->time_to_start = $request->time_to_start;
            $check->time_to_fix = $request->time_to_fix;
            $check->advance_upon_start = $request->advance_upon_start;
            $check->advance_upon_delivery = $request->advance_upon_delivery;
            $check->advance_upon_agreement = $request->advance_upon_agreement;
            $check->years_of_guarantee = $request->years_of_guarantee;
            $check->service_support_scope = $request->service_support_scope;
            $check->maintenance_frequency = $request->maintenance_frequency;
            $check->price_of_maintenance = $request->price_of_maintenance;
            $check->reaction_time = $request->reaction_time;
            $check->intervention_price = $request->intervention_price;
            $check->work_hour_price = $request->work_hour_price;
            $check->period_of_support = $request->period_of_support;
            $check->offer_expires_in = $request->offer_expires_in;
            $check->save();
            $solution = Solution::find($check->solution_id);

//            if($solution->teams != NULL){
//                foreach($solution->teams as $team){
//                    foreach($team->users as $member){
//                        $member->offers()->attach($check);
//                    }
//                }
//            }


            event(new OfferAdded($check, $check->installer, 'Dodałeś nową ofertę do rozwiązania: ' . $solution->name, []));

            return response()->json([
                'success' => true,
                'message' => 'Dodano oferte poprawnie.',
                'payload' => $check
            ]);
        }
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
     * @param Request $request
     * @return JsonResponse
     */
    public function publishOffer(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $offer = Offer::find($id);
        $offer->status = 1;
        $offer->save();

        $solution = Solution::find($offer->solution_id);
        $challenge = Challenge::find($offer->challenge_id);

        event(new OfferPublished($offer, $offer->installer, 'Nowa oferta została opublikowana: ' . $solution->name, []));


        return response()->json([
            'success' => true,
            'message' => 'Opublikowano oferte poprawnie.',
            'payload' => $offer
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptOffer(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $offer = Offer::find($id);
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

        $offer->selected = true;
        $offer->status = 2;
        if ($offer->rejected == true) {
            $offer->rejected = false;
        }
        $project = new Project();
        $project->challenge_id = $challenge->id;
        $project->name = $challenge->name;
        $project->en_name = $challenge->en_name;
        $project->type = $challenge->type;
        $project->description = $challenge->description;
        $project->en_description = $challenge->en_description;
        $project->stage = 0;
        $project->save_json = json_encode($challenge->save_json);
//        $project->screenshot_path = $challenge->screenshot_path;

        $project->save();
        $challenge->save();
        $solution->save();
        $offer->save();

        event(new OfferAccepted($offer, $offer->installer, 'Oferta zostało zaakceptowane: ' . $solution->name, []));

        return response()->json([
            'success' => true,
            'message' => 'Zatwierdzono ofertę.',
            'payload' => $project
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function rejectOffer(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $offer = Offer::find($id);
        $offer->rejected = true;
        $offer->selected = false;
        $challenge = Challenge::find($offer->challenge_id);
        if ($challenge->selected_offer_id == $offer->id) {
            $challenge->selected_offer_id = 0;
        }
        $solution = Solution::find($offer->solution_id);
        $solution->selected_offer_id = 0;
        $challenge->save();
        $solution->save();
        $offer->save();

        event(new OfferRejected($offer, $offer->installer, 'Oferta została odrzucona: ' . $solution->name, []));


        return response()->json([
            'success' => true,
            'message' => 'Odrzucono ofertę.',
            'payload' => $offer
        ]);
    }
}
