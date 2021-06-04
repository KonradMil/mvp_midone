<?php

namespace App\Http\Controllers;

use App\Models\WorkshopObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{

    public function getWorkshopModels(Request $request)
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

    public function saveWorkshopModel(Request $request)
    {
        $id = $request->input('id');
        if(isset($id)) {
            $object  = WorkshopObject::find($id);
        } else {
            $object = new WorkshopObject();
            $object->author_id = Auth::user()->id;
        }

        $j = $request->input('object')['data'];

        if (!empty($j['screenshot'])) {

            $path = $this->processSS($j['screenshot']);
            $object->screenshot_path = $path['relative'];
            unset($j['screenshot']);
            $object->save = json_encode($request->input('object')['data']);
            $object->name = $j['name'];
            $object->description = $j['description'];
            $object->type = $j['type'];
            $object->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $object
        ]);
    }

    public function likeObject(Request $request)
    {

    }
}
