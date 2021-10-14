<?php

use App\Http\Controllers\ModelController;
use Illuminate\Support\Facades\Route;

Route::post('model/edit/{model}', [ModelController::class, 'editModel']);
Route::post('model/get', [ModelController::class, 'getModel']);
Route::post('model/delete', [ModelController::class, 'deleteModel']);

Route::group(['prefix' => 'models', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [ModelController::class, 'getModels']);
    Route::post('get/unity', [ModelController::class, 'getModelsUnity']);
    Route::post('add', [ModelController::class, 'addModel']);
});
