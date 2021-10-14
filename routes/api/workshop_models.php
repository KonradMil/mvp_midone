<?php

use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'workshop/models', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get/all', [WorkshopController::class, 'getWorkshopModels']);
    Route::post('get', [WorkshopController::class, 'getWorkshopModel']);
    Route::post('save', [WorkshopController::class, 'saveWorkshopModel']);
    Route::post('delete', [WorkshopController::class, 'delete']);
    Route::post('publish', [WorkshopController::class, 'publish']);
    Route::post('like', [WorkshopController::class, 'likeObject']);
    Route::post('copy', [WorkshopController::class, 'copy']);
});
