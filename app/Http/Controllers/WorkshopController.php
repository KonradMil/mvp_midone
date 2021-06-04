<?php

namespace App\Http\Controllers;

use App\Models\WorkshopObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

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
            dump($j);
            $object->save = json_encode($request->input('object')['data']);
            $object->name = $j['item_name'];
            $object->description = $j['item_descreption'];
            $object->type = $j['item_type'];
            $object->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $object
        ]);
    }

    public function processSS($ss)
    {
        $content = base64_decode($ss);
        $name = uniqid('ss_') . '.jpg';
        $path = public_path('screenshots/' . $name);
        \Illuminate\Support\Facades\File::put($path, $content);
        Image::make($path)->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($path);

        return ['absolute_path' => $path, 'relative' => ('screenshots/' . $name)];
    }

    public function likeObject(Request $request)
    {

    }
}
