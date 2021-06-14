<?php

namespace App\Http\Controllers;

use App\Models\Challenges\Challenge;
use App\Models\Offer;
use App\Models\Solutions\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
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
            if($solution->selected == true){
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
        $check = Offer::find($request->input('id'));

        if($check == NULL) {
            $check = new Offer();
        }

//        $check->fill($request->input());
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


//        $solution = Solution::find($request->input('solution_id'));
//        $check->challenge_id = $solution->challenge_id;

        $check->save();

        return response()->json([
            'success' => true,
            'message' => 'Dodano oferte poprawnie.',
            'payload' => $check
        ]);
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
    public function acceptOffer (Request $request) {
        $id = $request->input('id');
        $offer = Offer::find($id);
        $challenge = Challenge::find($offer->challenge_id);
//        $challenge->stage = 2;
//        $challenge->save();
        $offer->selected = true;
        if($offer->rejected==true)
        {
            $offer->rejected = false;
        }
        $offer->save();

//        event(new SolutionAccepted($solution, $challenge->author, 'Rozwiązanie zostało zaakceptowane: ' . $solution->name, []));

        return response()->json([
            'success' => true,
            'message' => 'Zatwierdzono ofertę.',
            'payload' => $offer
        ]);
    }
    public function rejectOffer(Request $request)
    {
        $id = $request->input('id');
        $offer = Offer::find($id);
        $offer->rejected = true;
        $offer->selected = false;
        $offer->save();

        return response()->json([
            'success' => true,
            'message' => 'Odrzucono ofertę.',
            'payload' => $offer
        ]);
    }
}
