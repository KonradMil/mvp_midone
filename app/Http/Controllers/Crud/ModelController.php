<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\UnityModel;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function getModels(Request  $request)
    {
//        dd($request->search);
        if(isset($request->search)) {
            if(is_array($request->search)){
                if(!empty($request->search['brand'])) {
                    $models = UnityModel::where('category', '=', $request->search['category_id'])->where('subcategory', '=', $request->search['subcategory_id'])->where('brand', '=', $request->search['brand'])->get();
                } else {
                    $models = UnityModel::where('category', '=', $request->search['category_id'])->where('subcategory', '=', $request->search['subcategory_id'])->get();
                }

            } else {
                $models = UnityModel::where('name', 'LIKE', '%'. $request->search . '%')->get();
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
    public function editModel(Request $request,Request $id)
    {
        $model = UnityModel::find($id);
        $model->fill($request->input('data'));
        $model->save();

        return response()->json([
           'success' => true,
           'message' => 'Edytowano poprawnie.',
           'payload' => $model
        ]);
    }
}
