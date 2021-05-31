<?php

namespace App\Http\Controllers;

use App\Models\WorkshopObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{

    public function getObjects(Request $request)
    {
        $own = $request->input('own');

        if(!empty($own)) {
            $objects = WorkshopObject::where('author_id', '=', Auth::user()->id)->with('users')->get();
        } else {
            $objects = WorkshopObject::where('public', '=', 1)->with('users')->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $objects
        ]);
    }

    public function likeObject(Request $request)
    {

    }
}
