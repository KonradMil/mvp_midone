<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\UnityModel;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function getModels(Request  $request)
    {
        if(isset($request->search)) {
            $models = UnityModel::where('name', 'LIKE', '%'. $request->search . '%')->get();
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
}
