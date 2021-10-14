<?php

namespace App\Http\Controllers;

use App\Models\WorkshopObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\File;


/**
 *
 */
class WorkshopController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getWorkshopModels(Request $request): JsonResponse
    {
        $own = $request->input('own');

        if (!empty($own)) {
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveWorkshopModel(Request $request): JsonResponse
    {
//        $id = $request->input('id');
        $j = $request->input('object')['data'];
        if (!empty($j['id'])) {
            $object = WorkshopObject::find($j['id']);
        } else {
            $object = new WorkshopObject();
            $object->author_id = Auth::user()->id;
        }


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

    /**
     * @param $ss
     * @return array
     */
    public function processSS($ss): array
    {
        $content = base64_decode($ss);
        $name = uniqid('ss_') . '.jpg';
        $path = public_path('screenshots/' . $name);
        $image_normal = Image::make($content)->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image_normal->save(public_path('images/'. $name));

        Storage::disk('s3')->putFileAs('screenshots/', new File(public_path('images/'. $name)), $name);

        return ['absolute_path' => $path, 'relative' => ('s3/screenshots/' . $name)];
    }

    /**
     * @param Request $request
     */
    public function likeObject(Request $request)
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $model = WorkshopObject::find($request->input('id'));
        $model->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usunięto poprawnie.',
            'payload' => ''
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function publish(Request $request): JsonResponse
    {
        $model = WorkshopObject::find($request->input('id'));
        $model->public = 1;
        $model->save();

        return response()->json([
            'success' => true,
            'message' => 'Opublikowano poprawnie.',
            'payload' => $model
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function copy(Request $request): JsonResponse
    {
        $model = WorkshopObject::find($request->input('id'));
        $modelNew = $model->replicate();
        $modelNew->author_id = Auth::user()->id;
        $modelNew->public = 0;
        $modelNew->save();

        return response()->json([
            'success' => true,
            'message' => 'Opublikowano poprawnie.',
            'payload' => $model
        ]);
    }
}
