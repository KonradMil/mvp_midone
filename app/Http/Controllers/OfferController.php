<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Solutions\Solution;
use Illuminate\Http\Request;

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

    public function save(Request $request)
    {
        $check = Offer::find($request->input('id'));

        if($check == NULL) {
            $check = new Offer();
        }

        $check->fill($request->input());
        $solution = Solution::find($request->input('solution_id'));
        $check->challenge_id = $solution->challenge_id;
        $check->save();

        return response()->json([
            'success' => true,
            'message' => 'Pobrano ofertę poprawnie.',
            'payload' => $check
        ]);
    }
}
