<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\FreeSavesController;
use App\Http\Controllers\RobochallengeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'playground', 'middleware' => 'auth:sanctum'], function () {
    Route::get('freesaves/get/all', [FreeSavesController::class, 'getSaves']);
    Route::get('freesave/get/{id}', [FreeSavesController::class, 'getSave']);
    Route::post('freesaves/save', [FreeSavesController::class, 'saveData']);
    Route::post('freesaves/delete', [FreeSavesController::class, 'deleteSave']);
    Route::post('freesaves/add', [FreeSavesController::class, 'saveEmpty']);
});
