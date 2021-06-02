<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\UnityModel;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function getModel(Request  $request)
    {
        $model = UnityModel::find($request->id);
        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $model
        ]);
    }

    public function isempty(&$var) {
        return !empty($var) || $var === '0';
    }

    public function getModels(Request  $request)
    {
//        dd($request->search);
        $se = $request->search;
        if(!empty($se)) {
//            if(is_array($se)){
                if ($this->isempty($se['category']) && $this->isempty($se['subcategory'])) {
                    $models = UnityModel::where('category', '=', $se['category'])->where('subcategory', '=', $se['subcategory'])->get();
                } elseif ($this->isempty($se['category'])) {
                    $models = UnityModel::where('category', '=', $se['category'])->get();
                } elseif($this->isempty($se['subcategory'])) {
                    $models = UnityModel::where('subcategory', '=', $se['subcategory'])->get();
                } else {
                    $models = UnityModel::take(10)->get();
                }
//            } else {
//                $models = UnityModel::where('name', 'LIKE', '%'. $request->search . '%')->take(10)->get();
//            }
        } else {
            $models = UnityModel::take(10)->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Pobrano poprawnie.',
            'payload' => $models
        ]);
    }

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
    public function editModel(Request $request,UnityModel $model)
    {
        $model->fill($request->input('data'));
        $model->save();

        return response()->json([
           'success' => true,
           'message' => 'Edytowano poprawnie.',
           'payload' => $model
        ]);
    }
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
