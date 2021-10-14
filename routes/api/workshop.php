<?php

use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'workshop', 'middleware' => 'auth:sanctum'], function () {
    Route::post('objects/get', [WorkshopController::class, 'getObjects']);
    Route::post('object/like', [WorkshopController::class, 'likeObject']);
});
