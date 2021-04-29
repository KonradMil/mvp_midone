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
    public function getModels(Request  $request)
    {
//        dd($request->search);
        if(isset($request->search)) {
            if(is_array($request->search)){
                if(!empty($request->search['brand'])) {
                    $models = UnityModel::where('category', '=', $request->search['category_id'])->where('subcategory', '=', $request->search['subcategory_id'])->where('brand', '=', $request->search['brand'])->take(10)->get();
                } else {
                    $models = UnityModel::where('category', '=', $request->search['category_id'])->where('subcategory', '=', $request->search['subcategory_id'])->take(10)->get();
                }

            } else {
                $models = UnityModel::where('name', 'LIKE', '%'. $request->search . '%')->take(10)->get();
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
        UnityModel::destroy($request->id);
        return response()->json([
           'success' => true,
           'message' => 'Usunięto poprawnie',
        ]);
    }
}
