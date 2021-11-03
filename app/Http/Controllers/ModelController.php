<?php

namespace App\Http\Controllers;

use App\Models\UnityModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */

class ModelController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getModel(Request $request): JsonResponse
    {
        $model = UnityModel::find($request->id);
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $model
        ]);
    }

    /**
     * @param $var
     * @return bool
     */
    public function isempty(&$var) {
        return !empty($var) || $var === '0';
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getModelsUnity (Request $request)
    {
        if(isset($request->search)) {
            if(is_array($request->search)){
                if(!empty($request->search['brand'])) {
                    $models = UnityModel::where('category', '=', $request->search['category'])->where('subcategory', '=', $request->search['subcategory'])->where('brand', '=', $request->search['brand'])->get();
                } else {
                    $models = UnityModel::where('category', '=', $request->search['category'])->where('subcategory', '=', $request->search['subcategory'])->get();
                }

            } else {
                $models = UnityModel::where('name', 'LIKE', '%'. $request->search . '%')->take(80)->get();
            }
        } else {
            $models = UnityModel::get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $models
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getModels(Request $request)
    {

        $se = $request->search;
        if(!empty($se)) {
                if ($this->isempty($se['category']) && $this->isempty($se['subcategory'])) {
                    $models = UnityModel::where('category', '=', $se['category'])->where('subcategory', '=', $se['subcategory'])->get();
                } elseif ($this->isempty($se['category'])) {
                    $models = UnityModel::where('category', '=', $se['category'])->get();
                } elseif($this->isempty($se['subcategory'])) {
                    $models = UnityModel::where('subcategory', '=', $se['subcategory'])->get();
                } else {
                    $models = UnityModel::take(10)->get();
                }
        } else {
            $models = UnityModel::take(10)->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $models
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addModel(Request $request)
    {
        $model = new UnityModel();
        $model->fill($request->input('data'));
//        dd($model);
        $model->save();

        return response()->json([
            'success' => true,
            'message' => 'Dodano poprawnie.',
            'payload' => $model
        ]);
    }

    /**
     * @param Request $request
     * @param UnityModel $model
     * @return JsonResponse
     */
    public function editModel(Request $request, UnityModel $model)
    {
        $model->fill($request->input('data'));
        $model->save();

        return response()->json([
           'success' => true,
           'message' => 'Edytowano poprawnie.',
           'payload' => $model
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteModel(Request $request)
    {
        $m = UnityModel::find($request->id);
        $m->delete();
        return response()->json([
           'success' => true,
           'message' => 'Usunięto poprawnie',
        ]);
    }
}
