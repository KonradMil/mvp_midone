<?php

namespace App\Http\Controllers;

use App\Events\OfferAccepted;
use App\Events\OfferAdded;
use App\Events\OfferPublished;
use App\Events\OfferRejected;
use App\Models\Challenges\Challenge;
use App\Models\FinancialAnalysis;
use App\Models\Offer;
use App\Models\Solutions\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function filterChallengeOffers(Request $request)
    {
        $option = $request->input('option');
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        $offers = NULL;

        if($option === 'Cena-max'){
            $offers = $challenge->offers()->orderBy('price_of_delivery', 'DESC')->with('solution')->get();
        }else if($option === 'Cena-min'){
            $offers = $challenge->offers()->orderBy('price_of_delivery', 'ASC')->with('solution')->get();
        }else if($option === 'Czas realizacji uruchomienia u klienta'){
            $offers = $challenge->offers()->orderBy('time_to_start', 'DESC')->with('solution')->get();
        }else if($option === 'NPV'){
            $offers = $challenge->offers()->join('solutions as so', 'so.id', '=', 'offers.solution_id')->join('financial_analyses as fa', 'fa.solution_id', '=', 'so.id')->with('solution', 'solution.financial_analyses')->orderBy('fa.npv', 'DESC')->get();
        }else if($option === 'OEE po robotyzacji'){
            $offers = $challenge->offers()->join('solutions as so', 'so.id', '=', 'offers.solution_id')->join('operational_analyses as oa', 'oa.solution_id', '=', 'so.id')->orderBy('oa.oee_after', 'DESC')->with('solution')->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Filter ok',
            'payload' => $offers
        ]);
    }
    public function check(Request $request)
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        $solutions = $challenge->solutions;
        $check = false;
        foreach($solutions as $solution) {
            $offers = $solution->offers;
            foreach($offers as $offer){
                if($offer->installer_id === Auth::user()->id && $offer->status == 0 && Auth::user()->type=='integrator'){
                    $check = true;
                } else if(Auth::user()->type == 'investor' && $offer->rejected != 1 && $offer->status == 1){
                    if($offer->selected == 0){
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

    public function delete(Request $request)
    {
        $id = $request->input('id');
        Offer::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Usunięto ofertę poprawnie.',
            'payload' => ''
        ]);
    }
    public function get(Request $request)
    {
        $id = $request->input('id');
        $offer = Offer::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Pobrano ofertę poprawnie.',
            'payload' => $offer
        ]);
    }

    public function getAllChallengeOffers(Challenge $challenge)
    {
        $offers = Offer::where('challenge_id', '=', $challenge->id)->with('solution')->get();
        $array = [];

        foreach($offers as $offer){
            $solution = Solution::find($offer->solution_id);
            if(($solution->selected == true) && ($offer->rejected != 1) && ($offer->status == 1)){
                $array[] = $offer;
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pobrano oferty poprawnie.',
            'payload' => $array
        ]);
    }

    public function getAll(Request $request)
    {
        $id = $request->input('id');
        $challenge = Challenge::find($id);
        $offers = Offer::where('installer_id', '=', Auth::user()->id)->where('challenge_id', '=', $challenge->id)->with('solution')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano oferty poprawnie.',
            'payload' => $offers
        ]);
    }

    public function save(Request $request)
    {
        if($request->edit_id != null){
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
            $offer->save();
            return response()->json([
                'success' => true,
                'message' => 'Edytowano oferte poprawnie.',
                'payload' => $offer
            ]);
        } else {
            $check = new Offer();
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

            event(new OfferAdded($check, $check->installer, 'Dodałeś nową ofertę do rozwiązania: ' . $solution ->name, []));

            return response()->json([
                'success' => true,
                'message' => 'Dodano oferte poprawnie.',
                'payload' => $check
            ]);
        }
    }

    public function addOffer(Request $request)
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

    public function publishOffer(Request $request){
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

    public function acceptOffer (Request $request) {
        $id = $request->input('id');
        $offer = Offer::find($id);
        $challenge = Challenge::find($offer->challenge_id);
        $challenge->selected_offer_id = $offer->id;
        $challenge->stage = 3;
        $archiveSolutions = $challenge->solutions;
        foreach($archiveSolutions as $archiveSolution){
            $archiveSolution->archive = 1;
            $archiveSolution->save();
        }
        $solution = Solution::find($offer->solution_id);
        $solution->selected_offer_id = $offer->id;

        $offer->selected = true;

        if($offer->rejected==true) {
            $offer->rejected = false;
        }
        $challenge->save();
        $solution->save();
        $offer->save();

        event(new OfferAccepted($offer, $offer->installer, 'Oferta zostało zaakceptowane: ' . $solution->name, []));

        return response()->json([
            'success' => true,
            'message' => 'Zatwierdzono ofertę.',
            'payload' => $offer, $solution, $challenge
        ]);
    }
    public function rejectOffer(Request $request)
    {
        $id = $request->input('id');
        $offer = Offer::find($id);
        $offer->rejected = true;
        $offer->selected = false;
        $challenge = Challenge::find($offer->challenge_id);
        if($challenge->selected_offer_id == $offer->id){
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
